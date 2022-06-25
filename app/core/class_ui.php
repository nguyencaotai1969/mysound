<?php

if ( !defined( "root" ) ) die;

class ui {

	public $lang = "en";
	public $dir = "ltr";

	public $page_parent = null;
	public $page_type = null;
	public $page_hook = null;
	public $page_uri  = null;
	public $page_data = null;
	public $admin_menus = null;
	public $includes = [ "footer", "header", "sidebar" ];

	public $pre_pages = array(

    // Global pages
		"themes/__default/assets/js/textsjs" => [ "p" => "translation_js", "t" => "translation_js" ],
		"search"                 => [ "p" => "search", "t" => "search" ],
		"genres"                 => [ "p" => "genre", "t" => "genre" ],

    // Guest pages
		"user_login"             => [ "p" => "account", "t" => "user_login" ],
		"user_recover"           => [ "p" => "account", "t" => "user_recover" ],
		"user_signup"            => [ "p" => "account", "t" => "user_signup" ],

    // Upload pages
		"user_upload"            => [ "p" => "user_private",  "t" => "user_upload" ],
		"user_upload_edit"       => [ "p" => "user_private",  "t" => "user_upload_edit" ],

    // User Private Pages
		"user_feed"              => [ "p" => "user_private", "t" => "user_feed" ],
		"user_setting"           => [ "p" => "user_private", "t" => "user_setting" ],
		"user_purchased"         => [ "p" => "user_private", "t" => "user_purchased" ],
		"user_pay_result"        => [ "p" => "user_private", "t" => "user_pay_result" ],
		"user_logout"            => [ "p" => "user_private", "t" => "user_logout" ],

		// User upgrade page
		"user_upgrade"           => [ "p" => "user_private", "t" => "user_upgrade" ],

    // Admin pages
		"admin_dashboard"        => [ "p" => "admin", "t" => "admin_dashboard" ],
		"admin_menu_editor"      => [ "p" => "admin", "t" => "admin_menu_editor" ],
		"admin_page_editor"      => [ "p" => "admin", "t" => "admin_page_editor" ],
		"admin_theme_setting"    => [ "p" => "admin", "t" => "admin_theme_setting" ],
		"admin_language_editor"  => [ "p" => "admin", "t" => "admin_language_editor" ],
		"admin_setting_api"      => [ "p" => "admin", "t" => "admin_setting_api" ],
		"admin_setting_upload"   => [ "p" => "admin", "t" => "admin_setting_upload" ],
		"admin_setting_upload_aws" => [ "p" => "admin", "t" => "admin_setting_upload_aws" ],
		"admin_setting_general"  => [ "p" => "admin", "t" => "admin_setting_general" ],
		"admin_setting_sessions" => [ "p" => "admin", "t" => "admin_setting_sessions" ],
		"admin_setting_download" => [ "p" => "admin", "t" => "admin_setting_download" ],
		"admin_setting_pay"      => [ "p" => "admin", "t" => "admin_setting_pay" ],
		"admin_setting_email"    => [ "p" => "admin", "t" => "admin_setting_email" ],
		"admin_setting_programs" => [ "p" => "admin", "t" => "admin_setting_programs" ],
		"admin_setting_social_login" => [ "p" => "admin", "t" => "admin_setting_social_login" ],
		"admin_setting_notifications" => [ "p" => "admin", "t" => "admin_setting_notifications" ],
		"admin_users"            => [ "p" => "admin", "t" => "admin_users" ],
		"admin_user_groups"      => [ "p" => "admin", "t" => "admin_user_groups" ],
		"admin_user_comments"    => [ "p" => "admin", "t" => "admin_user_comments" ],
		"admin_user_payments"    => [ "p" => "admin", "t" => "admin_user_payments" ],
		"admin_user_transactions" => [ "p" => "admin", "t" => "admin_user_transactions" ],
		"admin_user_artist_reqs" => [ "p" => "admin", "t" => "admin_user_artist_reqs" ],
		"admin_user_withdraws"   => [ "p" => "admin", "t" => "admin_user_withdraws" ],
		"admin_user_reports"     => [ "p" => "admin", "t" => "admin_user_reports" ],
		"admin_user_ads"         => [ "p" => "admin", "t" => "admin_user_ads" ],
		"admin_content_genres"   => [ "p" => "admin", "t" => "admin_content_genres" ],
		"admin_content_tracks"   => [ "p" => "admin", "t" => "admin_content_tracks" ],
		"admin_content_albums"   => [ "p" => "admin", "t" => "admin_content_albums" ],
		"admin_content_sources"  => [ "p" => "admin", "t" => "admin_content_sources" ],
		"admin_content_artists"  => [ "p" => "admin", "t" => "admin_content_artists" ],
		"admin_tools_bot_runner" => [ "p" => "admin", "t" => "admin_tools_bot_runner" ],
		"admin_tools_auto_translate" => [ "p" => "admin", "t" => "admin_tools_auto_translate" ],
		"admin_tools_cleaner"    => [ "p" => "admin", "t" => "admin_tools_cleaner" ],

	);
	public $url_prefixes = array(

		"index" => "",

		"track" => "track/%url%",
		"track_embed" => "track/%url%/embed",
		"album" => "album/%url%",
		"artist" => "artist/%url%",
		"genre" => "genre/%url%",
		"playlist" => "playlist/%url%",
		"page" => "%url%",

		"user" => "user/%url%",
		"user_uploads" => "user/%url%/uploads",
		"user_followers" => "user/%url%/followers",
		"user_followings" => "user/%url%/followings",
		"user_heard" => "user/%url%/heard",
		"user_likes" => "user/%url%/likes",
		"user_reposts" => "user/%url%/reposts",
		"user_playlists" => "user/%url%/playlists",

		"user_feed" => "user_feed",
		"user_setting" => "user_setting",
		"user_purchased" => "user_purchased"

	);

	public function __construct( $loader ){

		$this->loader = $loader;
		$this->db = $loader->db;

	}

	public function set_page(){

		$request_uri_raw = $this->loader->secure->get( "server", "REQUEST_URI", "string" );
		$server_prefix = $this->loader->secure->get( "server", "CONTEXT_PREFIX", "string" );

    if ( $server_prefix ? substr( $request_uri_raw, 0, strlen( $server_prefix ) ) == $server_prefix : false )
			$request_uri_raw = substr( $request_uri_raw, strlen( $server_prefix ) );

		$request_uri = urldecode( $request_uri_raw );
		$request_url = parse_url( $request_uri, PHP_URL_PATH );
		parse_str( parse_url( $request_uri, PHP_URL_QUERY ), $request_que );
		$this->page_uri = $this->loader->ui->rurl( null, $request_url );

		$__user_req = null;
		if ( !empty( $request_que["q"] ) ){
			$__user_req = substr( $request_url, 1 );
		}
		elseif ( $get_q = $this->loader->secure->get( "get", "q", "string" ) ){
			$__user_req = $get_q;
		}
		elseif ( preg_match( "/index.php/", $request_url ) ){
			$__user_req = false;
		}

		$this->page_uri = $this->loader->ui->rurl( null, $__user_req );

    if( isset( $_GET["q"] ) ) unset( $_GET["q"] );

		// Set admin's chosen landing-page as default page
		$this->page_type   = "page";
		$this->page_parent = "dynamic";
		$this->page_hook   = $this->loader->admin->get_setting( 'landing_page', false );

		if ( is_null( $__user_req ) )
			return;

		if ( $__user_req === false ){
			$this->page_type = "404";
		    $this->loader->html->set_http_header( 'status', 'HTTP/1.1 404 Not Found' );
			return;
		}

		// sanitize and unset query
		$this->loader->secure->validate( $__user_req, "string" );

		// Did user ask for a pre-defined page? such as login/signup/etc
		if ( in_array( $__user_req, array_keys( $this->pre_pages ) ) ){
		  $this->page_type   = $this->pre_pages[ $__user_req ]["t"];
			$this->page_parent = $this->pre_pages[ $__user_req ]["p"];
			$this->page_hook   = null;
			if ( $this->page_parent == 'admin' ){
				$this->theme_name = "admin";
				$this->loader->theme->name = "admin";
			}
			return;
		}
		elseif ( in_array( $__user_req, [ "user_activities", "user_playlists", "user_likes", "user_heard", "user_uploads", "user_reposts", "user_followers", "user_followings" ], true ) ) {
			$this->page_type = "no_access";
			return;
		}

		// Did user ask for a dynamic type of page?
		foreach( $this->url_prefixes as $prefixType => $prefixURL ){

			if ( !preg_match( "/%url%/", $prefixURL ) ) continue;
			if ( $checkType = $this->curl( $prefixType, $__user_req ) ){
				$this->page_type   = $prefixType;
				$this->page_parent = "dynamic";
				$this->page_hook   = $checkType["ID"];
				return;
			}
		}

		$this->page_type = "404";
		$this->loader->html->set_http_header( 'status', 'HTTP/1.1 404 Not Found' );

	}
	public function check_page_access(){

		if ( !$this->loader->visitor->has_access( "ui", $this->page_type ) ){

			if ( $this->page_parent == 'admin' && !$this->loader->visitor->user()->has_access( "group", "admin" ) ){
	    		$this->page_type = "404";
			} else {
				$this->page_hook = null;
		    $this->page_type = "no_access";
			}

		}

	}
	public function set_page_data( $data = null ){

		if ( $data !== null ){
			$this->loader->ui->page_data = $data;
			return;
		}

		$page_data_path = app_core_root . "/pagedata/{$this->page_type}.php";
		if ( !file_exists( $page_data_path ) ) return;
		$page_data_path = realpath( $page_data_path );
		$loader = $this->loader;
		require_once( $page_data_path );
		return $this->page_data;

	}

	public function execute(){

		$this->set_page_data();

		$this->loader->theme->set_name()->load();

		// Load requested page pre-content from theme
		if ( $this->loader->theme->has_custom_page( "pre_{$this->page_type}" ) ) {
			$this->loader->html->add_content( "h_content", $this->loader->theme->set_name()->__req( "pre_{$this->page_type}" . '.php', true ) );
		}

		// Load requested page content from theme
		if ( $this->loader->theme->has_custom_page( $this->page_type ) ) {
			$this->loader->html->add_content( "h_content", $this->loader->theme->set_name()->__req( $this->page_type . '.php', true ) );
		}
		// If theme doesn't have a custom page for this content type, load from default theme
		else {
			$this->loader->html->add_content( "h_content", $this->loader->theme->set_name('__default')->__req( $this->page_type . '.php', false ) );
		}

		// Load requested page post-content from theme
		if ( $this->loader->theme->has_custom_page( "post_{$this->page_type}" ) ) {
			$this->loader->html->add_content( "h_content", $this->loader->theme->set_name()->__req( "post_{$this->page_type}" . '.php', true ) );
		}

		// Load header content from theme
		if ( $this->includes ? in_array( "header", $this->includes ) : false )
		$this->loader->html->add_content( "c_header" , $this->loader->theme->set_name()->__req( 'header.php', true ), true );

		// Load sidebar content from theme
		if ( $this->includes ? in_array( "sidebar", $this->includes ) : false )
		$this->loader->html->add_content( "f_sidebar" , $this->loader->theme->set_name()->__req( 'sidebar.php', true ), true );

		// Load footer content from theme
		if ( $this->includes ? in_array( "footer", $this->includes ) : false )
		$this->loader->html->add_content( "p_footer" , $this->loader->theme->set_name()->__req( 'footer.php', true ), true );

		// Display the output html
		if ( $this->page_parent == "admin" )
			$this->loader->html->add_body_class( "theme_admin" );

		$this->loader->html
			->set_og( 'site_name', $this->loader->admin->get_setting( "sitename" ) )
			->set_og( 'url', $this->page_uri )
			->set_twitter( 'card', 'summary_large_image' )
			->add_body_class( [ "pt_{$this->page_type}" ] );

		if ( !empty( $__tu = $this->loader->admin->get_setting( "twitter_username", null ) ) ){
			$this->loader->html
				->set_twitter( "site", "@" . $__tu )
				->set_twitter( "creator", "@" . $__tu );
		}

		$this->loader->html->execute();

	}
	public function set_title( $params = [] ){

		$page_type = substr( $this->loader->ui->page_type, 0, 15 );
		$page_title = $this->loader->lorem->turn( "pt_{$page_type}", [ "params" => $params ] );
		$this->loader->html->set_title( $page_title );
		return $page_title;

	}

	public function save_menu( $name, $jsonData ){

		$name_exists = $this->db->prepare("SELECT ID FROM _setting_menu WHERE name = ?");
		$name_exists->bind_param( "s", $name );
		$name_exists->execute();
		$name_exists->bind_result( $ID );
		$name_exists->fetch();
		$name_exists->close();

		if ( !empty( $ID ) ){
			$stmt = $this->db->prepare("UPDATE _setting_menu SET data = ? WHERE ID = ?");
			$stmt->bind_param( "ss", $jsonData, $ID );
		} else {
			$stmt = $this->db->prepare("INSERT INTO _setting_menu ( name, data ) VALUES ( ?, ? )");
			$stmt->bind_param( "ss", $name, $jsonData );
		}

		$stmt->execute();
		$stmt->close();

		return true;

	}
	public function load_menus( $detailed = true, $detailed_raw = false ){

		$get_menus = $this->db->query("SELECT * FROM _setting_menu ");
		if ( !$get_menus->num_rows ) return [];

		$menus = [];
		while( $menu = $get_menus->fetch_assoc() ){
			if ( $detailed ) $menus[ $menu["ID"] ] = $this->load_menu( json_decode( $menu["data"], 1 ), $detailed_raw );
			else $menus[ $menu["ID"] ] = $menu["name"];
		}

		return $menus;

	}
	public function load_menu( $ID, $raw = false ){

		if ( is_array( $ID ) ){
			$data = $ID;
		} else {

			$key = (  ctype_digit( $ID ) or is_int( $ID ) ) ? "ID" : "name";

			$get_menu = $this->db->_select([
				"table" => "_setting_menu",
				"where" => [
					"oper" => "AND",
					"cond" => [
						[ $key, "=", $ID ]
					]
				]
			]);
			if ( !$get_menu ) return [];
			$data = json_decode( $get_menu[0]["data"], 1 );

		}


		if ( empty( $data ) ? true : !is_array( $data ) ) return [];


		foreach( $data as &$__m ){

			if ( substr( $__m["title"], 0, 1 ) == "#" && !$raw ){
				$__m["title"] = $this->loader->lorem->turn( "m_" . substr( $__m["title"], 1 ) );
			}

			if ( !empty( $__m["items"] ) ){
				foreach( $__m["items"] as &$__s ){
					if ( substr( $__s["title"], 0, 1 ) == "#" && !$raw ){
						$__s["title"] = $this->loader->lorem->turn( "m_" . substr( $__s["title"], 1 ) );
					}
					if ( empty( $__s["icon"] ) ) $__s["icon"] = false;
				}
			}

			if ( empty( $__m["icon"] ) ) $__m["icon"] = false;

		}
		unset( $__m, $__s );

		return $data;

	}
	public function display_menu( $ID, $prepend = [], $append = [], $max=null ){

		$menuData = is_array( $ID ) ? $ID : $this->load_menu( $ID );
		if ( empty( $menuData ) ) return;

		echo $this->loader->html->load_part( "menu", [ "menuData" => array_merge( $prepend, array_slice( $menuData, 0, $max ), $append ), "max" => $max ] );

	}

	public function load_pages( $detailed = true ){

		$get_pages = $this->db->query("SELECT * FROM _setting_page");
		if ( !$get_pages->num_rows ) return [];
		$get_landing_page_id = $this->loader->admin->get_setting( "landing_page" );

		$pages = [];
		while( $page = $get_pages->fetch_assoc() ){
			if ( $detailed ) $page["widgets"] = $this->load_page( $page["ID"] );
			$page["landing"] = $get_landing_page_id == $page["ID"];
			$pages[$page["ID"]] = $page;
		}
		return $pages;

	}
	public function load_page( $ID ){

		if ( !ctype_digit( $ID ) && !is_int( $ID ) ) return [];
		$get_widgets = $this->db->query("SELECT * FROM _setting_page_widgets WHERE page_id = {$ID} ORDER BY widget_order ASC");
		if ( !$get_widgets->num_rows ) return [];

		$widgets = [];
		while( $widget = $get_widgets->fetch_assoc() ){
			$widgets[ $widget["ID"] ] = array(
				"ID"          => $widget["ID"],
				"title"       => $widget["widget_title"],
				"type"        => $widget["widget_type"],
				"sett"        => json_decode( $widget["widget_setting"], 1 ),
				"cache"       => $widget["widget_cache"] ? json_decode( $widget["widget_cache"], 1 ) : null,
				"time_update" => $widget["time_update"],
			);
		}
		return $widgets;

	}
	public function load_page_widget( $widget, $items = null, $return = false, $page = false ){

		$setting = $widget["sett"];

		// Selecting items arguments
		$select_args["order_by"] = empty( $setting["sort"] )      ? "time_add" : $setting["sort"];
		$select_args["order"]    = empty( $setting["sort2"] )     ? "DESC"     : $setting["sort2"];
		$select_args["limit"]    = empty( $setting["limit"] )     ? 20 : ( $setting["limit"] < 3 ? 10 : $setting["limit"] );
		$select_args["offset"]   = empty( $setting["limit2"] )    ? null       : $setting["limit2"];
		$select_args["local"]    = empty( $setting["source"] )    ? null       : ( $setting["source"] == "all" ? null : ( $setting["source"] == "youtube" ? 0 : 1 ) );
		$select_args["user_id"]  = empty( $setting["user_id"] )   ? null       : $setting["user_id"];
		$select_args["priced"]   = empty( $setting["price"] )    ? null       : ( $setting["price"] == "all" ? null : ( $setting["price"] == "priced" ? true : false ) );
		$select_args["is_user"]  = empty( $setting["artist_verified"] ) ? null : ( $setting["artist_verified"] == "all" ? null : ( $setting["artist_verified"] == "yes" ? true : false ) );
		$select_args["_eg"]      = [ "paid", "owner" ];

		// Selecting by genre filter
		if ( !empty( $setting["genre"] ) ){

			$__genres = [];
			foreach( is_array( $setting["genre"] ) ? $setting["genre"] : explode( ",", $setting["genre"] ) as $__genre ){
				if ( !$this->loader->genre->valid( $__genre ) ) continue;
				if ( $__genre == "all" ){
					$__genres = [];
					break;
				}
				$__genres[] = $this->loader->genre->return_valid( $__genre, "ID" );
			}

			$select_args["genres"] = $__genres ? $__genres : null;

		}
		// Selecting by album-type filter
		if ( ( $widget["type"] == "album_slider" || $widget["type"] == "album_table" || $widget["type"] == "album_list" ) && !empty( $setting["album_type"] ) ){

			$__valid_album_types = [];
			$__album_types = explode( ",", $setting["album_type"] );
			foreach( $__album_types as $__album_type ){
				if ( !in_array( $__album_type, $this->loader->album->types ) ) continue;
				if ( $__album_type == "all" ){
					$__valid_album_types = [];
					break;
				}
				$__valid_album_types[] = $__album_type;
			}

			if ( !empty( $__valid_album_types ) ){
				$select_args["types"] = $__valid_album_types;
			}

		}
		// on-Mobile changes
		if( $this->loader->hit->agent_data["device"]["type"] == "mobile" ){
			$setting["limit"] = $select_args["limit"] = round( $select_args["limit"] / 2 );
		}

		// Pagination
		$setting["page"] = 1;

		if ( $page && $setting["pagination"] ){

			$setting["page"]       = $page;
			$setting["limit"]      = 24;
			$setting["size"]       = "medium";
			$setting["class"]      = [ "noslide", "selected_widget" ];
			$setting["rows"]       = 1;
			$setting["width"]      = 12;
			$select_args["limit"]  = 24;
			$select_args["offset"] = ( $setting["page"]-1 ) * $select_args["limit"];
			$widget["type"]        = str_replace( [ "list" ], "slider", $widget["type"] );

		}

		// Styles
		$setting["width"]      = empty( $setting["width"] )     ? 12         : $setting["width"];
		$setting["table_cols"] = empty( $setting["table_cols"] ) ? null      : $setting["table_cols"];
		$setting["id"]         = empty( $setting["id"] )        ? null       : $setting["id"];
		$setting["class"]      = empty( $setting["class"] )     ? []         : $setting["class"];
		$setting["size"]       = empty( $setting["size"] )      ? "medium"   : $setting["size"];
		$setting["rows"]       = empty( $setting["rows"] )      ? 1          : $setting["rows"];
		$setting["columns"]    = empty( $setting["columns"] )   ? 1          : $setting["columns"];
		$setting["arrows"]     = !isset( $setting["arrows"] )   ? true       : $setting["arrows"];
		$setting["i_p_r"]      = ceil( $select_args["limit"] / $setting["rows"] );
		$setting["i_p_c"]      = ceil( $select_args["limit"] / $setting["columns"] );
		$setting["pagination"] = empty( $setting["pagination"] ) ? 0 : 1;
		$setting["linked"]     = empty( $setting["linked"] ) ? 0 : $this->loader->ui->rurl( null, strip_tags( $setting["linked"], " " ) );
		$setting["html"]       = !empty( $setting["html"] ) ? $setting["html"] : "";
		// ads
		$setting["pl_code"]        = !empty( $setting["pl_code"] ) ? $setting["pl_code"] : null;
		$setting["banner_size"]    = !empty( $setting["banner_size"] ) ? $setting["banner_size"] : null;
		$setting["banner_pl_name"] = !empty( $setting["banner_pl_name"] ) ? $setting["banner_pl_name"] : null;

		// Get items
		if( !$items ){

			if ( $widget["type"] == "album_slider" || $widget["type"] == "album_table" || $widget["type"] == "album_list" ){
				$items = $this->loader->album->select( $select_args );
				$items_more = $setting["pagination"] ? $this->loader->album->select( array_merge( $select_args, [ "offset" => ($setting["page"]*$select_args["limit"]), "limit" => 1 ] ) ) : false;
			}
			elseif ( $widget["type"] == "track_slider" || $widget["type"] == "track_table" || $widget["type"] == "track_list" ){
				$items = $this->loader->track->select( $select_args );
				$items_more = $setting["pagination"] ? $this->loader->track->select( array_merge( $select_args, [ "offset" => ($setting["page"]*$select_args["limit"]), "limit" => 1 ] ) ) : false;
				if ( !empty( $items ) ){
					foreach( $items as $item ){
						$widget["tracks_hashes"][] = $item["hash"];
					}
				}
			}
			elseif ( $widget["type"] == "spotify" ){

				$items = [];
				if ( !empty( $widget["cache"] ) ){
					$_cc = count( $widget["cache"] );
					foreach( array_slice( $widget["cache"], $select_args["offset"], $select_args["limit"] ) as $playlist_track ){
						$track = $this->loader->track->select(["ID"=>$playlist_track]);
						if ( $track ) $items[] = $track;
					}
				}
				$items_more = $setting["pagination"] && !empty( $_cc ) ? $_cc > $setting["page"] * $select_args["limit"] : false;
				if ( $page && $widget["type"] == "track_list" ) $widget["type"] = "track_table";

			}
			elseif ( $widget["type"] == "genre_slider" ){
				$items = true;
			}
			elseif ( $widget["type"] == "artist_slider" ){
				$items = $this->loader->artist->select( $select_args );
				$items_more = $setting["pagination"] ? $this->loader->artist->select( array_merge( $select_args, [ "offset" => ($setting["page"]*$select_args["limit"]), "limit" => 1 ] ) ) : false;
			}
			elseif ( $widget["type"] == "playlist_slider" ){
				$items = $this->loader->playlist->select( $select_args );
				$items_more = $setting["pagination"] ? $this->loader->playlist->select( array_merge( $select_args, [ "offset" => ($setting["page"]*$select_args["limit"]), "limit" => 1 ] ) ) : false;
			}
			elseif ( $widget["type"] == "user_slider" ){
				$items = $this->loader->user->select( $select_args );
				$items_more = $setting["pagination"] ? $this->loader->user->select( array_merge( $select_args, [ "offset" => ($setting["page"]*$select_args["limit"]), "limit" => 1 ] ) ) : false;
			}
			elseif ( $widget["type"] == "pl" ? $setting["pl_code"] : false ){
				$items = $this->loader->ads->shouldDisplay( $setting["pl_code"] );
			}

			$setting["has_more"] = !empty( $items_more ) ? $items_more : false;
			if ( !empty( $items_more ) ) $setting["class"][] = "has_more";

		}
		else {
			$items_more = !empty( $widget["has_more"] );
		}

		// Spotify shapeshift
		if ( $widget["type"] == "spotify" ){
			$widget["type"] = !empty ( $setting["type"] ) ? "track_{$setting["type"]}" : "track_slider";
		}

		// Classes
		$setting["class"][] = "widget";
		$setting["class"][] = "widget_{$widget["type"]}";

		if ( $widget["type"] == "album_slider" || $widget["type"] == "album_table" || $widget["type"] == "album_list"  ){
			$setting["class"][] = "type_album";
			$t_type = "album";
		}
		if ( $widget["type"] == "track_slider" || $widget["type"] == "track_table" || $widget["type"] == "track_list" || $widget["type"] == "spotify" ){
			$setting["class"][] = "type_track";
			$t_type = "track";
		}
		if ( $widget["type"] == "artist_slider" ){
			$t_type = "artist";
		}
		if ( $widget["type"] == "track_slider" || $widget["type"] == "album_slider" || $widget["type"] == "genre_slider" || $widget["type"] == "artist_slider" || $widget["type"] == "user_slider" || $widget["type"] == "playlist_slider" ){
			$setting["class"][] = "widget_slider";
			$setting["class"][] = "size_{$setting["size"]}";
			$setting["class"][] = "rows_{$setting["rows"]}";
		}
		if ( $widget["type"] == "track_list" || $widget["type"] == "album_list" ){
			$setting["class"][] = "widget_list";
			$setting["class"][] = "columns_{$setting["columns"]}";
		}
		if ( $widget["type"] == "album_table" || $widget["type"] == "track_table" ){
			$setting["class"][] = "widget_table";
		}
		if ( !$items && $setting["page"] > 1 ){
			ob_end_clean();
			header( "Location: " . $this->loader->ui->rurl( "index" ) );
			die;
		}
		if ( !$items && $widget["type"] != "html" ) return;
		if ( !empty( $t_type ) ){

			$setting["class"][] = "t_{$t_type}";

			foreach( $items as &$item ){

				if ( empty( $item ) ) continue;
				$item["link"] = empty( $item["spotify"] ) ? "href=\"{$this->loader->ui->rurl( $t_type, $item["url"] )}\"" : "";
				$item["iclass"] = empty( $item["spotify"] ) ? "" : "rti_handle";
				$item["fclass"] = empty( $item["spotify"] ) ? "" : " class=\"rti_handle\" ";
				$item["datas"] = empty( $item["spotify"] ) ? "" : " data-source-type=\"spotify\" data-target-type=\"{$t_type}\" data-target-hook=\"{$item["ID"]}\" ";

				if ( !empty( $item["artist_name"] ) ){
					$item["artist_link"] = empty( $item["spotify"] ) ? "href=\"{$this->loader->ui->rurl( "artist", $item["artist_url"] )}\"" : "";
					$item["artist_iclass"] = empty( $item["spotify"] ) ? "" : "rti_handle";
					$item["artist_fclass"] = empty( $item["spotify"] ) ? "" : " class=\"rti_handle\" ";
					$item["artist_datas"] = empty( $item["spotify"] ) ? "" : " data-source-type=\"spotify\" data-target-type=\"artist\" data-target-hook=\"{$item["artist_ID"]}\" ";
				}

				if ( !empty( $item["album_title"] ) ){
					$item["album_link"] = empty( $item["spotify"] ) ? "href=\"{$this->loader->ui->rurl( "album", $item["album_url"] )}\"" : "";
					$item["album_iclass"] = empty( $item["spotify"] ) ? "" : "rti_handle";
					$item["album_fclass"] = empty( $item["spotify"] ) ? "" : " class=\"rti_handle\" ";
					$item["album_datas"] = empty( $item["spotify"] ) ? "" : " data-source-type=\"spotify\" data-target-type=\"album\" data-target-hook=\"{$item["album_ID"]}\" ";
				}

	    	}

		}

		$html = "";
		$html .= "<div class=\"widget_wrapper col-12 col-lg-{$setting["width"]} widget-{$widget["type"]}-wrapper ".(empty($widget["title"])?"no-title":"has-title")."\">";
		$html .= "<div class=\"".( implode( " ", $setting["class"] ) )."\"".($setting["id"]?" id=\"{$setting["id"]}\"":"").">";

		    $html .= $this->loader->theme->set_name('__default')->__req( "parts/widget_title.php", true, [
				"widget"  => $widget,
				"setting" => $setting,
				"page"    => $page
			] );

		    if ( in_array( "widget_slider", $setting["class"] ) ){
				$html .= "<div class=\"slider_wrapper\"><div class=\"slider\">";
			}

		    $html .= trim( $this->loader->theme->set_name('__default')->__req( "parts/widget_{$widget["type"]}.php", true, [
			    "widget"  => $widget,
			    "setting" => $setting,
			    "items"   => $items,
				"page"    => $page
		    ] ) );

	    	if ( in_array( "widget_slider", $setting["class"] ) ){
				$html .= "</div>";
				if ( $setting["arrows"] )
					$html .= "<div class=\"arrows\"><div class=\"arrow next\"><span class=\"mdi mdi-chevron-right\"></span></div><div class=\"arrow prev\"><span class=\"mdi mdi-chevron-left\"></span></div></div>";
				$html .= "</div>";
			}

	    	$html .= $this->loader->theme->set_name('__default')->__req( "parts/widget_pagination.php", true, [
				"widget"  => $widget,
				"setting" => $setting,
				"page"    => $page
			] );

		$html .= "</div>";
		$html .= "</div>";

		if ( $return ) {
			return [
				"html"    => $html,
				"items"   => $items,
				"setting" => $setting,
				"select"  => $select_args
		    ];
		}

		echo $html;

	}
	public function verify_page_widget( $data ){

		if ( empty( $data["type"] ) ) return "no type";
		if ( !in_array( $data["type"], ["album_slider","album_table","album_list","track_slider","track_table","track_list","artist_slider","spotify","genre_slider","html","pl","user_slider","playlist_slider"], true ) ) return "bad type";
		if ( empty( $data["sett"] ) ? !is_array( $data["sett"] ) : false ) return "no setting data";

		// verify setting now
		$setting = $data["sett"];
		$type = $data["type"];
		$__type_exploded = explode( "_", $type );
		$target_type = $__type_exploded[0];
		$widget_type = !empty( $__type_exploded[1] ) ? $__type_exploded[1] : $__type_exploded[0];

		if ( empty( $setting["width"] ) ) return "no width";
		if ( empty( $setting["wid"] ) ) return "no wid";
		if ( !isset( $setting["title"] ) ) return "no title";
		if ( !isset( $setting["linked"] ) ) return "no linked-page";

		$setting["linked"] = empty( $setting["linked"] ) ? $setting["linked"] : strip_tags( htmlspecialchars_decode( $setting["linked"], ENT_QUOTES ), " " );

		if ( !$this->loader->secure->validate( $setting["width"], "in_array", [ "values" => [ 6, 12, "6", "12" ] ] ) ) return "bad width";
		if ( !$this->loader->secure->validate( $setting["wid"], "md5", [ "length" => 8 ] ) ) return "bad wid";
		if ( !$this->loader->secure->validate( $setting["title"], "string", [ "empty()" ] ) ) return "bad title";
		if ( !$this->loader->secure->validate( $setting["linked"], "string", [ "empty()" ] ) ) return "bad linked-page";

		if ( !in_array( $target_type, [ "genre", "html", "pl" ], true ) ){

			if ( empty( $setting["limit"] ) ) return "no limit";
			if ( !$this->loader->secure->validate( $setting["limit"], "int", [ "min" => 1, "max" => 100 ] ) ) return "bad limit";

		}

		if ( in_array( $target_type, [ "track", "album", "artist", "spotify" ], true ) ){

			if ( !isset( $setting["pagination"] ) ) return "no pagination";
			if ( !$this->loader->secure->validate( $setting["pagination"], "boolean" ) ) return "bad pagination";

		}

		if ( in_array( $target_type, [ "track", "album" ], true ) ){

			if ( empty( $setting["source"] ) ) return "no source";
			if ( empty( $setting["price"] ) ) return "no price";
			if ( !isset( $setting["genre"] ) ) return "no genre";
			if ( !isset( $setting["user_id"] ) ) return "no user_id";
			if ( !$this->loader->secure->validate( $setting["source"], "in_array", [ "values" => [ "all", "youtube", "local" ] ] ) ) return "bad source";
			if ( !$this->loader->secure->validate( $setting["price"], "in_array", [ "values" => [ "all", "free", "priced" ] ] ) ) return "bad price";
			if ( !$this->loader->secure->validate( $setting["genre"], "string" ) ) return "bad genre";
			if ( !$this->loader->secure->validate( $setting["user_id"], "int", [ "empty()", "min" => 0 ] ) ) return "bad user_id";

		}

		if ( $target_type == "track" ){

			if ( !isset( $setting["sort"] ) ) return "no sort";
			if ( !$this->loader->secure->validate( $setting["sort"], "in_array", [ "values" => [ 'title', 'spotify_hits', 'play_full', 'play_skip', 'play_full_m', 'play_skip_m', 'views', 'likes', 'reposts', 'comments', 'playlisteds', 'downloads', 'purchased', 'time_release', 'time_play', 'time_add' ] ] ) ) return "bad sort";

		}

		if ( $target_type == "album" ){

			if ( !isset( $setting["album_type"] ) ) return "no album_type";
			if ( !isset( $setting["sort"] ) ) return "no sort";
			if ( !$this->loader->secure->validate( $setting["album_type"], "string" ) ) return "bad album_type";
			if ( !$this->loader->secure->validate( $setting["sort"], "in_array", [ "values" => [ 'title', 'spotify_hits', 'play_full', 'play_skip', 'play_full_m', 'play_skip_m', 'views', 'time_release', 'time_play', 'time_add' ] ] ) ) return "bad sort";

		}

		if ( $target_type == "artist" ){

			if ( !isset( $setting["artist_verified"] ) ) return "no artist_verified";
			if ( !isset( $setting["sort"] ) ) return "no sort";
			if ( !$this->loader->secure->validate( $setting["artist_verified"], "in_array", [ "values" => [ "all", "yes", "no" ] ] ) ) return "bad artist_verified";
			if ( !$this->loader->secure->validate( $setting["sort"], "in_array", [ "values" => [ 'name', 'spotify_hits', 'play_full', 'play_skip', 'play_full_m', 'play_skip_m', 'views', 'time_play', 'time_add' ] ] ) ) return "bad sort";

		}

		if ( $target_type == "playlist" ){

			if ( !isset( $setting["sort"] ) ) return "no sort";
			if ( !$this->loader->secure->validate( $setting["sort"], "in_array", [ "values" => [ 'name','likes','followers','views','time_update','time_add' ] ] ) ) return "bad sort";

		}

		if ( $target_type == "user" ){

			if ( !isset( $setting["sort"] ) ) return "no sort";
			if ( !$this->loader->secure->validate( $setting["sort"], "in_array", [ "values" => [ 'followers','followings','likes','reposts','comments','comments_likes','comments_replied','media_comments','media_likes','media_uploads','playlists','playlists_likes','playlists_followers','time_add' ] ] ) ) return "bad sort";

		}

		if ( $target_type == "spotify" ){

			if ( !isset( $setting["id"] ) ) return "no id";
			if ( !isset( $setting["type"] ) ) return "no type";
			if ( !$this->loader->secure->validate( $setting["id"], "string_spotify_id" ) ) return "bad spotify_id";
			if ( !$this->loader->secure->validate( $setting["type"], "in_array", [ "values" => [ "slider", "list", "table" ] ] ) ) return "bad type";

		}

		if ( $widget_type == "slider" || $widget_type == "spotify" ){

			if ( empty( $setting["size"] ) ) return "no size";
			if ( empty( $setting["rows"] ) ) return "no rows";
			if ( !$this->loader->secure->validate( $setting["size"], "in_array", [ "values" => [ "small", "medium", "large" ] ] ) ) return "bad size";
			if ( !$this->loader->secure->validate( $setting["rows"], "in_array", [ "values" => [ "1", "2", "3", "4", "5", "6" ] ] ) ) return "bad rows";

		}

		if ( $widget_type == "list" || $widget_type == "spotify" ){

			if ( empty( $setting["columns"] ) ) return "no columns";
			if ( !$this->loader->secure->validate( $setting["columns"], "in_array", [ "values" => [ "1", "2", "3" ] ] ) ) return "bad columns";

		}

		if ( $target_type == "pl" ){

			if ( !isset( $setting["banner_size"] ) ) return "no_banner_size";
			if ( !$this->loader->secure->validate( $setting["banner_size"], "in_array", [ "values" => array_keys( $this->loader->ads->getBannerSizes() ) ] ) ) return "invalid_banner_size";
			if ( !$this->loader->secure->validate( $setting["banner_pl_name"], "string" ) ) return "bad pl_name";
			$setting["pl_code"] = $this->loader->general->make_code( substr( $setting["banner_pl_name"], -10 ) );

		}

		return $setting;

	}

	public function rurl( $pageType, $pageURL = null, $extraRequests = false ){

		if ( !$pageType && $pageURL ? substr( $pageURL, 0, strlen( "http://" ) ) === "http://" || substr( $pageURL, 0, strlen( "https://" ) ) === "https://" : false )
			return trim( str_replace( [ "///", "//", "http:/", "https:/" ], [ "/", "/", "http://", "https://" ], $pageURL . ( $extraRequests ? "?{$extraRequests}" : "" ) ) );

		$url = $this->loader->admin->get_setting( 'web_addr' );

		if ( !$pageType && !$pageURL )
			return $url;

		if ( $pageType && $pageURL ? !in_array( $pageType, array_keys( $this->url_prefixes ), true ) : false )
			die("invalid_url_params_2:{$pageType}:{$pageURL}");

		if ( $pageType && $pageURL )
			$url .= str_replace( "%url%", $pageURL, $this->url_prefixes[ $pageType ] );

		elseif ( $pageType ? in_array( $pageType, array_keys( $this->url_prefixes ), true ) : false )
			$url .= $this->url_prefixes[ $pageType ];

		elseif ( $pageType )
			$url .= $pageType;

		else
			$url .= $pageURL;

		if ( $extraRequests )
			$url .= "?" . $extraRequests;

		return trim( str_replace( [ "///", "//", "http:/", "https:/" ], [ "/", "/", "http://", "https://" ], $url ) );

	}
	public function eurl( $pageType, $pageURL = null, $extraRequests = false ){
		echo $this->rurl( $pageType, $pageURL, $extraRequests );
	}
	public function curl( $pageType, $pageURL, $pageURLTyped=false ){

		if ( !in_array( $pageType, array_keys( $this->url_prefixes ), true ) )
			die("invalid_url_params_3");
		$pageTypeFormat = $this->url_prefixes[ $pageType ];

		if ( $pageTypeFormat != "%url%" && substr( $pageTypeFormat, 0, 5 ) != "%url%" )
			$pageTypeFormat = "\b{$pageTypeFormat}";

		if ( $pageTypeFormat != "%url%" && substr( $pageTypeFormat, 0, -5 ) != "%url%" )
			$pageTypeFormat = "{$pageTypeFormat}$";

		if ( $pageURLTyped ){
			$pageTypeURL = $pageURL;
		}
		elseif ( $pageTypeFormat == "%url%" ){
			$pageTypeURL = $pageURL;
		}
		else {

			$pageTypeFormat = str_replace( [ "%url%", "/" ], [ "(.*?)", "\/" ], $pageTypeFormat );
			preg_match( "/{$pageTypeFormat}/", $pageURL, $m );
			if ( !empty( $m[1] ) )
				$pageTypeURL = $m[1];

		}

		if ( empty( $pageTypeURL ) )
			return false;

		if ( in_array( $pageType, [ "track", "album", "artist", "genre", "track_embed" ], true ) ){

			$pageType = $pageType == "track_embed" ? "track" : $pageType;
			$check = $this->loader->db->_select([
				"table" => "_m_{$pageType}s",
				"columns" => "ID",
				"single" => true,
				"where" => [
					[ "url", "=", $pageTypeURL ]
				]
			]);

			if ( $pageType == "artist" && strtolower( $pageTypeURL ) == "various_artists" )
				return false;

		}

		if ( substr( $pageType, 0, 5 ) === "user_" || $pageType === "user" ){

			$check = $this->loader->db->_select([
				"table" => "_users",
				"columns" => "ID",
				"single" => true,
				"where" => [
					[ "username", "=", $pageTypeURL ]
				]
			]);

		}

		if ( $pageType == "playlist" ){

			$check = $this->loader->db->_select([
				"table" => "_user_playlists",
				"columns" => "ID",
				"single" => true,
				"where" => [
					[ "url", "=", $pageTypeURL ]
				]
			]);

		}

		if ( $pageType == "page" ){

			$check = $this->loader->db->_select([
				"table" => "_setting_page",
				"columns" => "ID",
				"single" => true,
				"where" => [
					[ "url", "=", $pageTypeURL ],
					[ "ID", "!=", $this->loader->admin->get_setting("landing_page") ]
				]
			]);

		}

		if ( !empty( $check ) )
			return $check;

		return false;

	}
	public function murl( $pageType, $pageURL, $hook=null ){

		$pageURL = mb_strtolower( mb_substr( $pageURL, 0, 100, "UTF-8" ), "UTF-8" );
		$pageURL = str_replace( [ " ", "___" , "__" ], "_", $this->loader->general->make_code( $pageURL, "\p{L}0-9\-_ " ) );
		if ( empty( $pageURL ) ? true : strlen( $pageURL ) <= 2 ) $pageURL = uniqid();

		$original_pageURL = $pageURL;
		$url_exists = $this->curl( $pageType, $pageURL, true ) != false;
		$i=1;
		while( $url_exists ){
			$i++;
			$pageURL = $original_pageURL . "_" . $i;
			$url_exists = $this->curl( $pageType, $pageURL, true ) != false;
		}
		return $pageURL;

	}

}

?>
