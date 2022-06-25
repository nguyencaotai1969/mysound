<?php

if ( !defined( "root" ) ) die;

class loader {

	public $db = false;
	public $debug = false;

	public function _require_core_files( $required_core_files = null ){

		$cores = [
			"db",
			"general",
			"html",
			"lorem",
			"hit",
			"admin",
			"user",
			"theme",
			"album",
			"artist",
			"genre",
			"track",
			"ui",
			"be",
			"id3",
			"spotify",
			"image",
			"source",
			"playlist",
			"youtube",
			"utube",
			"search",
			"pay",
			"ffmpeg",
			"comment",
			"visitor",
			"upload",
			"boac",
			"secure",
			"aws",
			"ftp",
			"ads",
			"email"
		];

		if ( $required_core_files ){
			if ( is_array( $required_core_files ) ) $cores = $required_core_files;
			else $cores = [ $required_core_files ];
		}

		foreach( $cores as $core_file_name ){

			if ( !in_array( $core_file_name, $cores, true ) ) continue;

			if ( !file_exists( realpath( app_core_root . "/class_{$core_file_name}.php" ) ) )
				die( "class_{$core_file_name}.php is missing in app/core/ directory!! Try re-downloading DigiMuse script from Codecanyon" );

			require_once( realpath( app_core_root . "/class_{$core_file_name}.php" ) );

			if ( !class_exists( $core_file_name ) )
				die( "class_{$core_file_name}.php is corrupted. Try re-downloading DigiMuse script from Codecanyon" );

			$this->$core_file_name = new $core_file_name( $this );

		}


	}
	public function __get( $requested_core ){

		$this->_require_core_files( $requested_core );
		return $this->$requested_core;

	}
	public function _load_admin_setting( $force_cc=false ){

		define( "domain", str_replace( "www.", "", parse_url( web_addr, PHP_URL_HOST ) ) );
		$domain_code = md5(crc32( domain . purchase_code ));
		// if ( $domain_code != sign_code ) die;

		if (
			( debug_for_admin ? $this->user->ID == 1 : false ) ||
			( debug_for_ip ? $this->hit->ip_data["ip"] == debug_for_ip : false ) ||
			debug
		){

			error_reporting( E_ALL );
			ini_set( "display_errors", 'on' );
			ini_set( "xdebug.var_display_max_children", '-1' );
			ini_set( "xdebug.var_display_max_data", '-1' );
			ini_set( "xdebug.var_display_max_depth", '-1' );

			$this->debug = $this->db->debug = true;

		}

		// if ( rand( 0, 1718 ) == 1717 || $force_cc ){
		// 	$check = $this->boac->get_cc( null, $this->admin->get_setting("version",100) );
		//     if ( empty( $check["sta"] ) && !empty( $check["data"] ) ){
		// 			unlink( root . "/app/config.php" );
		// 			die;
		// 		}
		// }

		if ( defined("no_bot") ? no_bot && $this->hit->agent_data["device"]["type"] == "bot" : false ){
			die;
		}

	}
	public function _check_user_request(){

		// Validate && Sanitize user-IP
		if ( !( $user_ip = $this->secure->get( "server", "REMOTE_ADDR", "ip" ) ) )
			die('invalid_user_ip');

		// Firewall
		if ( firewall ){

			// Is this IP blocked?
			$check = $this->db->query("SELECT 1 FROM _blocked_ips WHERE IP = '{$user_ip}' AND until > now() ");
			if ( $check->num_rows ) die;

			if ( firewall_anti_session_hijacking ){

				// Should this IP get blocked?
				$session_count = $this->db->query("SELECT MAX(request_sessid) FROM `_hits` WHERE `ip` = '{$user_ip}' AND time_add > subdate( now(), INTERVAL 24 HOUR ) GROUP BY request_sessid ")->num_rows;

				// Session Hijacking Protection
				if ( $session_count > firewall_anti_session_hijacking_max_sessions_per_ip_per_day ){
					$this->db->query("INSERT INTO _blocked_ips ( IP, until, reason ) VALUES ( '{$user_ip}', ADDDATE( now(), INTERVAL 7 DAY ), 'sessHiJack' ) ");
					die("blocked");
				}

				// TODO:: DDOS protection

			}

		}

		// Check session, detect user type and set access
		$this->visitor->set_access();
		$this->visitor->set_play_access();

		// Parse visitor's useragent to detect device/browser/etc
		// Thanks to https://github.com/WhichBrowser/Parser-PHP
		$this->hit->get_agent_data();

		// Check if user-IP has been cached in session
		if ( !empty( $_SESSION["ip_addr"] ) && !empty( $_SESSION["ip_country"] ) ? $_SESSION["ip_addr"] == $user_ip : false ){

			$this->hit->ip_data = array(
				"ip"      => $user_ip,
				"country" => $_SESSION["ip_country"]
			);

		}
		// Get visitor's ip data to detect country/city/etc
		else {

			if ( $this->admin->get_setting( 'get_visitor_ip_data', 1, [ 0, 1 ] ) ){
				$this->hit->get_ip_data( $user_ip );
				if ( !empty( $this->hit->ip_data ) ){
					$_SESSION["ip_addr"] = $user_ip;
					$_SESSION["ip_country"] = !empty( $this->hit->ip_data["country"] ) ? $this->hit->ip_data["country"] : null;
				}
			}
			else  {
				$this->hit->ip_data = array(
				    "ip"      => $user_ip,
				    "country" => null
			    );
			}

		}

		if ( !empty( session_id() ) && !empty( $_SESSION["extra_id"] ) ) {

			// Get user session data and decide if we are going to let this user in or not
	    	$check_session_data_ratio = session_check_ratio;

			if ( $check_session_data_ratio >= rand( 1, 100 ) ? : false ){

			    $session_data = $this->hit->get_session();
			    if ( !empty( $this->visitor->user()->ID ) && empty( $this->hit->session_data ) ){

				    session_destroy();
				    $this->visitor->set_access();
				    header("Location: ?LoggedOut");
				    die("Refresh");

			    }
			    else if ( $session_data ) {
				    $this->db->query("UPDATE _user_sessions SET time_update = now() WHERE ID = '{$session_data["ID"]}' ");
			    }

		    }

		};

	}
	public function _set_language(){

		// Admin's chosen language is the default language
		// And it will be the only language unless admin allows language to be changed
		$lang = $this->admin->get_setting( 'lang', 'en' );

		// Is there language change request?
		// Does admin allow language to be changed by this [type] of user?
		// If two above are true, Did user ask for a valid language?
		// If all are true, update session
		if ( ( $reqed_lang = $this->secure->get( "get", "lang", "string_lang_code" ) ) &&
			 $this->visitor->user()->has_access( "group", "language" ) )
		{
			if ( in_array( $reqed_lang, array_keys( $this->admin->get_setting( 'langs', [ 'en' => 'English' ], null, true ) ), true ) ){
				$_SESSION["lang"] = $reqed_lang;
			}
		}

		// Set language from session if admin allows it && language is -still- valid
		if ( !empty( $_SESSION["lang"] ) &&
			 $this->visitor->user()->has_access( "group", "language" ) ?
			   in_array( $_SESSION["lang"], array_keys( $this->admin->get_setting( 'langs', [ 'en' => 'English' ], null, true ) ) )
			 : false )
		{
			$lang = $_SESSION["lang"];
		}

		$this->ui->lang = $lang;
		$this->ui->dir  = $this->lorem->turn( "dir", [ "val" => "ltr" ] );
		$this->html->add_body_class( [ $this->ui->lang, $this->ui->dir, "active", "loading", "hard_loading" ] );

	}
	public function _set_timeout(){

		$this->timeout = $this->ui->page_type == "user_upload_edit" || $this->ui->page_parent == "admin" ? 150 : $this->admin->get_setting( "up_timeout", 10 );

		// Set timeout
		set_time_limit( $this->timeout );
		ini_set( 'max_execution_time', $this->timeout );

	}
	public function _handle_page_request(){

		$this->ui->set_page();
		$this->ui->check_page_access();
		$this->html->add_body_class( [ "page_{$this->ui->page_type}" ] );

	}
	public function _setup_play_uploading(){

		$this->_require_core_files( [ "db", "general", "user", "admin", "genre" ] );

		$reqed_hash = $this->secure->get( "get", "hash", "md5" );
		$reqed_ID = $this->secure->get( "get", "ID", "md5", [ "length" => 20 ] );

		if ( !$reqed_hash || !$reqed_ID ) return;

		$source = $this->upload->get( [ "userID" => $this->visitor->user()->ID, "rID" => $reqed_hash ] );
		if ( empty( $source["uploadings"][ $reqed_hash ] ) ) return;
		$source = $source["uploadings"][ $reqed_hash ];

		$cover = $this->general->addr_to_path( $source["data"]["cover"] );
		if ( pathinfo( $cover, PATHINFO_EXTENSION ) == "gif" ) header("Content-type: image/gif");
		elseif ( pathinfo( $cover, PATHINFO_EXTENSION ) == "png" ) header("Content-type: image/png");
		else header("Content-type: image/jpg");
		echo file_get_contents( $cover );

		die;

	}

}

?>
