<?php

if ( !defined( "root" ) ) die;

class hit {

	public $agent_data = null;
	public $session_data = null;
	public $ip_data = null;
	public $ip_db_id = null;

	public function __construct( $loader ){

		$this->loader = $loader;
		$this->db = $loader->db;

	}

	public function get_agent_data( $agentString = null ){

		$agentString = $agentString ? $agentString : $this->loader->secure->get( "server", "HTTP_USER_AGENT", "string" );
		if ( !$agentString ) die('invalid_user_agent');
		require_once( realpath( app_core_root . "/third/Parser-PHP-master/vendor/autoload.php" ) );
		$agent_data = json_decode(strtolower(json_encode(new WhichBrowser\Parser( $agentString ))),1);
		$this->agent_data = $agent_data;
		return $agent_data;

	}
	public function get_ip_data( $IPAddr ){

		$get_data = $this->loader->general->curl([
			"url" => "http://ip-api.com/json/{$IPAddr}",
			"ctimeout" => 1,
			"timeout" => 5,
			"cache_range" => 24,
		])[1];

		if ( !empty( $get_data ) ){

			// Try to decode given JSON data
			// It's wise to use @ before json_decode since we are checking for errors in the next line but i'm not allowed to do that
			$data = json_decode( $get_data, 1 );
			if ( json_last_error() !== JSON_ERROR_NONE )
				return false;

			// sanitize API data
			foreach( $data as $i => $v ){
				$this->loader->secure->validate( $v, "string" );
				$data[ $i ] = $v;
			}

			$this->ip_data = [
				"ip"           => $IPAddr,
			    "country_name" => !empty( $data["country"] ) ? $data["country"] : null,
			    "region"       => !empty( $data["region"] ) ? $data["region"] : null,
			    "city"         => !empty( $data["city"] ) ? $data["city"] : null,
			    "isp"          => !empty( $data["isp"] ) ? $data["isp"] : null,
			    "org"          => !empty( $data["org"] ) ? $data["org"] : null,
			    "lat"          => !empty( $data["loc"] ) ? $data["loc"] : null,
			    "lon"          => !empty( $data["loc"] ) ? $data["loc"] : null,
			    "timezone"     => !empty( $data["timezone"] ) ? $data["timezone"] : null,
			    "country"      => !empty( $data["countryCode"] ) ? $data["countryCode"] : null,
		    ];

			return true;

		}

		return false;

	}
	public function record_session( $extra_id ){

		$this->db->_insert([
			"table" => "_user_sessions",
			"set" => [
			    [ "session_extra_id", $extra_id ],
			    [ "session_id", session_id() ],
			    [ "user_id", $this->loader->visitor->user()->ID ],
			    [ "ip", $this->ip_data["ip"] ],
			    [ "ip_country", !empty( $this->ip_data["country"] ) ? $this->ip_data["country"] : null ],
			    [ "platform_type", $this->agent_data["device"]["type"] ],
			    [ "platform_os", $this->agent_data["os"]["name"] ],
			    [ "platform_browser", $this->agent_data["browser"]["name"] ],
		    ]
		]);

	}
	public function get_session( $session_id=null, $extra_id=null, $user_id=null ){

		$session_id = $session_id ? $session_id : session_id();
		$extra_id   = $extra_id ? $extra_id : ( !empty( $_SESSION["extra_id"] ) ? $_SESSION["extra_id"] : null );
		$user_id    = $user_id ? $user_id : $this->loader->visitor->user()->ID;

		if ( empty( $extra_id ) or empty( $session_id ) or empty( $user_id ) ) return false;

		$get_data = $this->db->_select([
			"table"    => "_user_sessions",
			"where"    => [
			    "oper" => "AND",
			    "cond" => [
			        [ "session_extra_id", "=", $extra_id ],
			        [ "session_id", "=", $session_id ],
			        [ "user_id", "=", $user_id ],
			        [ "active", "=", "1" ]
			    ]
		    ],
			"order_by" => "time_add",
			"limit"    => 1,
		]);


		if ( empty( $get_data ) ) return false;
		$data = reset( $get_data );

		// compare ips
		if ( $this->loader->admin->get_setting( "session_i_lock", 1 ) ? $data["ip"] != $this->ip_data["ip"] : false ){
			$this->db->query("UPDATE _user_sessions SET active = 0 WHERE ID = '{$data["ID"]}' ");
			return false;
		}

		// compare platform
		if ( $this->loader->admin->get_setting( "session_p_lock", 1 ) ? $data["platform_os"] != $this->agent_data["os"]["name"] || $data["platform_browser"] != $this->agent_data["browser"]["name"] || $data["platform_type"] != $this->agent_data["device"]["type"] : false ){
			$this->db->query("UPDATE _user_sessions SET active = 0 WHERE ID = '{$data["ID"]}' ");
			return false;
		}

		// check expiration date
		if ( $this->loader->admin->get_setting( "session_lifetime", 168 ) ? time() - strtotime( $data["time_add"] ) > $this->loader->admin->get_setting( "session_lifetime", 168 )*60*60 : false ){
			$this->db->query("UPDATE _user_sessions SET active = 0 WHERE ID = '{$data["ID"]}' ");
			return false;
		}

		// check lifetime
		$session_lifetime = ini_get("session.gc_maxlifetime");
		if ( $session_lifetime ? time() - strtotime( $data["time_update"] ) > $session_lifetime : false ){
			$this->db->query("UPDATE _user_sessions SET active = 0 WHERE ID = '{$data["ID"]}' ");
			return false;
		}

		if ( $data["session_extra_id"] == $_SESSION["extra_id"] )
			$this->session_data = $data;

		return $data;

	}
	public function get_sessions( $user_id=null ){

		$user_id = $user_id ? $user_id : $this->loader->visitor->user()->ID;
		if ( empty( $user_id ) ) return false;
		$user_id = intval( $user_id );

		$get_sessions = $this->db->query("SELECT * FROM _user_sessions WHERE user_id = '{$user_id}' AND active = 1 ");
		if ( !$get_sessions->num_rows ) return false;

		$sessions = [];
		while( $session = $get_sessions->fetch_assoc() ){
			$validate_session = $this->get_session( $session["session_id"], $session["session_extra_id"], $session["user_id"] );
			if ( empty( $validate_session ) ) continue;
			$sessions[] = $validate_session;
		}

		return $sessions;

	}
	public function create_session( $user_id ){

		if ( !empty( $_SESSION["userID"] ) ) return;

		$extra_id = substr( hash( "md5", uniqid() . rand(1,99999999) . microtime(true ) ), rand( 0, 5 ), rand( 10, 20 ) );

	    session_regenerate_id( true );
	    $_SESSION["time_log"] = time();
	    $_SESSION["userID"]   = $user_id;
	    $_SESSION["extra_id"] = $extra_id;

		// record session
	    $this->record_session( $extra_id );

	    $sessions = $this->get_sessions();

		// Force expire on older session if user limit is reached
	    if ( $this->loader->admin->get_setting( "session_max", 2 ) ? count( $sessions ) > $this->loader->admin->get_setting( "session_max", 2 ) : false ){
		    foreach( $sessions as $session ){
			    if ( $session["session_extra_id"] !== $extra_id ){
					$this->loader->db->query("UPDATE _user_sessions SET active = 0 WHERE ID = '{$session["ID"]}' ");
			    }
		    }
	    }

	}

	public function __log_hit(){

		// Detect Referrer
		$referer = null;
		$referer_full = null;

		// Validate && sanitize referer string
		if ( $referer_full = $this->loader->secure->get( "server", "HTTP_REFERER", "url", [ "default_scheme" => false, "remove_fragment" => true ] ) ){
			$referer = str_replace( "www.", "", parse_url( $referer_full, PHP_URL_HOST ) );
		}

		// validated && sanitized User-IP
		$ip_data = $this->ip_data;

		// URL data
		$page_type   = $this->loader->ui->page_type;
		if ( $page_type == "translation_js" ) return;
		$page_hook   = $this->loader->ui->page_hook;
		$request_url = $this->loader->ui->page_uri;

		// User inputs
		$request_cookies = json_encode( $_COOKIE, JSON_UNESCAPED_UNICODE );
		$request_posts   = json_encode( $_POST, JSON_UNESCAPED_UNICODE );
		$request_params  = json_encode( $_GET, JSON_UNESCAPED_UNICODE );
		$request_sessid  = session_id();
		$user_id         = $this->loader->visitor->user()->data()->ID;

		// Parsed agent-data
		$agent_data      = $this->agent_data;
		$agent_os        = !empty( $agent_data["os"]["name"] )      ? strtolower( $agent_data["os"]["name"] )      : null;
		$agent_browser   = !empty( $agent_data["browser"]["name"] ) ? strtolower( $agent_data["browser"]["name"] ) : null;
		$agent_engine    = !empty( $agent_data["engine"]["name"] )  ? strtolower( $agent_data["engine"]["name"] )  : null;
		$agent_model     = !empty( $agent_data["device"]["model"] ) ? strtolower( $agent_data["device"]["model"] ) : null;
		$agent_type      = !empty( $agent_data["device"]["type"] )  ? strtolower( $agent_data["device"]["type"] )  : null;
		$agent_string    = $this->loader->secure->get( "server", "HTTP_USER_AGENT", "string" );

		if ( strlen( $ip_data["ip"] ) > 18 )
		$ip_data["ip"] = '0.0.0.0';

		$this->db->_insert([
			"table" => "_hits",
			"set" => [
			    [ "page_type", $page_type ],
			    [ "page_hook", $page_hook ],
			    [ "user_id", $user_id ],
			    [ "request_url", $request_url ],
			    [ "request_sessid", $request_sessid ],
			    [ "request_cookies", $request_cookies ],
			    [ "request_posts", $request_posts ],
			    [ "request_params", $request_params ],
			    [ "ip", $ip_data["ip"] ],
			    [ "ip_country", !empty( $ip_data["country"] ) ? $ip_data["country"] : null ],
			    [ "agent", $agent_string ],
			    [ "agent_model", $agent_model ],
			    [ "agent_type", $agent_type ],
			    [ "agent_os", $agent_os ],
			    [ "agent_browser", $agent_browser ],
			    [ "agent_engine", $agent_engine ],
			    [ "referer", $referer ],
			    [ "referer_full", $referer_full ]
		    ]
		]);

	}

}

?>
