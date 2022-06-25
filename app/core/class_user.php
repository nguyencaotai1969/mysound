<?php

if ( !defined( "root" ) ) die;

class user {

	// Data
	public $ID       = null;
	public $data     = null;
	public $avatar   = null;
	public $name     = null;
	public $name_raw = null;
	public $username = null;
	public $email    = null;
	public $fund     = 0;
	public $user_actions = 	array(

		// liked_track
		1 => array(
			"hook_type" => "track",
			"type_name" => "like",
			"icon" => "heart",
			"detail" => "User liked your track",
			"detail2" => "User liked a track",
			"detail_doer" => "liker",
			"detail_receiver" => "track uploader"
		),

		// reposted_track
		2 => array(
			"hook_type" => "track",
			"type_name" => "repost",
			"icon" => "repeat",
			"detail" => "User reposted your track",
			"detail2" => "User reposted a track",
			"detail_doer" => "reposter",
			"detail_receiver" => "track uploader"
		),

		// uploaded_track
		3 => array(
			"hook_type" => "track",
			"type_name" => "upload",
			"icon" => "cloud-upload",
			"detail2" => "User uploaded a track",
			"detail_doer" => "uploader",
		),


		// commented_track
		5 => array(
			"hook_type"    => "track",
			"display_type" => "comment",
			"type_name"    => "comment",
			"extra_type"   => "comment",
			"icon" => "message-reply-text",
			"detail2" => "User commented a track",
			"detail_doer" => "commenter",
		),

		// followed_user
		6 => array(
			"hook_type" => "user",
			"type_name" => "follow",
			"icon" => "account-plus",
			"detail" => "User followed you",
			"detail2" => "User followed a user",
			"detail_doer" => "follower",
			"detail_receiver" => "followed user",
		),


		// liked_comment
		8 => array(
			"hook_type"  => "comment",
			"extra_type" => "user",
			"type_name"  => "like",
			"icon" => "thumb-up",
			"detail" => "User liked your comment",
			"detail2" => "User liked a comment",
			"detail_doer" => "liker",
			"detail_receiver" => "commenter",
		),

		// followed_artist
		10 => array(
			"hook_type" => "artist",
			"type_name" => "follow",
			"icon" => "heart",
			"detail2" => "User followed an artist",
			"detail_doer" => "follower",
		),

		// followed_playlist
		12 => array(
			"hook_type"  => "playlist",
			"type_name"  => "follow",
			"extra_type" => "user",
			"icon" => "account-plus",
			"detail" => "User subscribed to your playlist",
			"detail2" => "User subscribed to playlist",
			"detail_doer" => "subscriber",
			"detail_receiver" => "playlist creator",
		),

		// liked_playlist
		13 => array(
			"hook_type"  => "playlist",
			"type_name"  => "like",
			"extra_type" => "user",
			"icon" => "heart",
			"detail" => "User liked your playlis",
			"detail2" => "User liked a playlist",
			"detail_doer" => "liker",
			"detail_receiver" => "playlist creator",
		),

		// liked_album
		14 => array(
			"hook_type"  => "album",
			"type_name"  => "like",
			"extra_type" => "user",
			"icon" => "heart",
			"detail" => "User liked your album",
			"detail2" => "User liked an album",
			"detail_doer" => "liker",
			"detail_receiver" => "album uploader",
		),

		// updated_playlist
		15 => array(
			"hook_type" => "playlist",
			"type_name" => "update",
			"icon" => "fire",
			"detail2" => "User updated a playlist",
			"detail_doer" => "playlist creator",
		),

		// purchased a track
		19 => array(
			"hook_type" => "track",
			"type_name" => "purchased",
			"icon" => "credit-card",
			"detail" => "User purchased your track",
			"detail2" => "User purchased a track",
			"detail_doer" => "buyer",
			"detail_receiver" => "track uploader",
		),

		// purchased an album
		20 => array(
			"hook_type" => "album",
			"type_name" => "purchased",
			"icon" => "credit-card",
			"detail" => "User purchased your album",
			"detail2" => "User purchased an album",
			"detail_doer" => "buyer",
			"detail_receiver" => "album uploader",
		),

		// collabing in playlist
		24 => array(
			"hook_type" => "playlist",
			"type_name" => "collab",
			"icon" => "home",
			"detail" => "User is now collaborating in your playlist",
			"detail2" => "User collaborating in a playlist",
			"detail_doer" => "collaborator",
			"detail_receiver" => "playlist creator",
		),

		// collabed in playlist
		25 => array(
			"hook_type" => "playlist",
			"type_name" => "collabed",
			"icon" => "home",
			"detail" => "Got collabed in a playlist",
			"detail_receiver" => "collaborator",
		),

		// purchased ads
		26 => array(
			"hook_type" => "ads",
			"type_name" => "purchased",
			"icon" => "star",
			"detail" => "Advertisement is active now",
			"detail_receiver" => "advertiser",
		),

		// media_commented
		4 => array(
			"hook_type" => "track",
			"extra_type" => "comment",
			"display_type" => "comment",
			"type_name" => "commented",
			"icon" => "comment",
			"detail" => "Track got commented",
			"detail_receiver" => "track uploader",
		),

		// comment_commented
		7 => array(
			"hook_type" => "comment",
			"extra_type" => "comment",
			"type_name" => "commented",
			"icon" => "comment",
			"detail" => "Comment got replied",
			"detail_receiver" => "commenter",
		),

		// mentioned
		9 => array(
			"hook_type"  => "comment",
			"extra_type" => "user",
			"type_name"  => "mentioned",
			"icon" => "tag",
			"detail" => "Got mentioned in comment",
			"detail_receiver" => "mentioned user",
		),

		// playlist_updated
		11 => array(
			"hook_type" => "playlist",
			"type_name" => "updated",
			"icon" => "playlist-music",
			"icon" => "tag",
			"detail" => "Subscribed playlist got updated",
			"detail_receiver" => "subscriber",
		),

		// artist_updated
		16 => array(
			"hook_type" => "artist",
			"extra_type" => "comment",
			"type_name" => "updated",
			"icon" => "fire",
			"detail" => "Subscribed artist got updated",
			"detail_receiver" => "subscriber",
		),

		// payment ok
		18 => array(
			"hook_type" => "receipt",
			"type_name" => "purchased",
			"icon" => "coffee",
			"detail" => "Payment Successfull",
			"detail_receiver" => "buyer",
		),

		// purchased an album
		21 => array(
			"hook_type" => "vip",
			"type_name" => "purchased",
			"icon" => "credit-card",
			"detail" => "Purchased `Paid` plan Successfull",
			"detail_receiver" => "buyer",
		),

		// signed up
		17 => array(
			"hook_type" => "user",
			"type_name" => "welcome",
			"icon" => "party-popper",
			"detail" => "Welcome message",
			"detail_receiver" => "user",
		),

		66 => array(
			"admin" => true,
			"hook_type" => "comment",
			"type_name" => "new",
			"icon" => "alert-decagram",
			"detail" => "New comment"
		),

		67 => array(
			"admin" => true,
			"hook_type" => "user",
			"type_name" => "new",
			"icon" => "alert-decagram",
			"detail" => "New user"
		),

		68 => array(
			"admin" => true,
			"hook_type" => "report",
			"type_name" => "new",
			"icon" => "alert-decagram",
			"detail" => "New report"
		),

		69 => array(
			"admin" => true,
			"hook_type" => "advertisement",
			"type_name" => "new",
			"icon" => "alert-decagram",
			"detail" => "New advertisement"
		),

		70 => array(
			"admin" => true,
			"hook_type" => "artist_request",
			"type_name" => "new",
			"icon" => "alert-decagram",
			"detail" => "New artist request"
		),

		71 => array(
			"admin" => true,
			"hook_type" => "artist_withdrawal",
			"type_name" => "new",
			"icon" => "alert-decagram",
			"detail" => "New artist withdrawal"
		),

		72 => array(
			"admin" => true,
			"hook_type" => "payment",
			"type_name" => "new",
			"icon" => "alert-decagram",
			"detail" => "New payment"
		),

		73 => array(
			"admin" => true,
			"hook_type" => "purchase",
			"type_name" => "new",
			"icon" => "alert-decagram",
			"detail" => "New purchase"
		),

		74 => array(
			"admin" => true,
			"hook_type" => "upload",
			"type_name" => "new",
			"icon" => "alert-decagram",
			"detail" => "New upload"
		),

	);
	public $admin_actions = [ 66, 67, 68, 69, 70, 71, 72, 73, 74 ];

	// Groups
	public $guest      = null;
	public $admin      = null;
	public $artist     = null;
	public $paid       = null;
	public $group_ID   = null;
	public $group_data = null;

	// Access
	public $group_access = null;
	public $be_access    = null;
	public $ui_access    = null;

	public function __construct( $loader ){

		$this->loader = $loader;
		$this->db = $loader->db;
		$this->_reset_class();

	}
	public function getActions($args=[]){

		$admin = false;
		$admin_setting = false;
		$user_setting = false;
		$ua = [];
		extract( $args );

		if ( $admin_setting || $user_setting ){
			$ua["nots"]   = explode( ",", $this->loader->admin->get_setting( "ua_not" ) );
			$ua["emails"] = explode( ",", $this->loader->admin->get_setting( "ua_email" ) );
			$ua["feeds"]  = explode( ",", $this->loader->admin->get_setting( "ua_feed" ) );
			$ua["acts"]   = explode( ",", $this->loader->admin->get_setting( "ua_act" ) );
		}

		if ( $user_setting ){
			$user_data = $this->loader->visitor->user()->get_data();
			$usa["feeds"]  = $user_data["feed_setting"]  ? $user_data["feed_setting"]  : $ua["feeds"];
			$usa["nots"]   = $user_data["not_setting"]   ? $user_data["not_setting"]   : $ua["nots"];
			$usa["emails"] = $user_data["email_setting"] ? $user_data["email_setting"] : [];
		}

		$raw_actions = $this->user_actions;
		foreach( $raw_actions as $type => $action ){

			if ( !$admin && !empty( $action["admin"] ) ) continue;

			$actions[ $type ] = $action;
			$actions[ $type ][ "type" ] = $type;

			if ( !empty( $ua ) ){
				$actions[ $type ][ "ua_not" ] = in_array( $type, $ua["nots"] );
				$actions[ $type ][ "ua_act" ] = in_array( $type, $ua["acts"] );
				$actions[ $type ][ "ua_feed" ] = in_array( $type, $ua["feeds"] );
				$actions[ $type ][ "ua_email" ] = in_array( $type, $ua["emails"] );
			}

			if ( !empty( $usa ) ){
				$actions[ $type ][ "usa_feed" ]  = $actions[ $type ][ "ua_feed" ]  ? in_array( $type, $usa["feeds"] )  : false;
				$actions[ $type ][ "usa_not" ]   = $actions[ $type ][ "ua_not" ]   ? in_array( $type, $usa["nots"] )   : false;
				$actions[ $type ][ "usa_email" ] = $actions[ $type ][ "ua_email" ] ? in_array( $type, $usa["emails"] ) : false;
			}
		}

		return $actions;

	}

	// Set User
	public function _reset_class(){

		$this->ID         = null;
		$this->data       = null;
		$this->avatar     = "{$this->loader->theme->set_name('__default')->addr}assets/icons/avatar.png";
		$this->name       = null;
		$this->name_raw   = null;
		$this->username   = null;
		$this->email      = null;
		$this->admin      = null;
		$this->artist     = null;
		$this->paid       = null;
		$this->guest      = null;
		$this->fund       = 0;
		$this->group_ID   = null;
		$this->group_data = null;
		$this->group_access = [];
		$this->be_access    = [];
		$this->ui_access    = [];

	}
	public function set( $ID ){

		$this->_reset_class();
		$this->ID = $ID;

		return $this;

	}
	public function data( $external = [] ){

		$data = $this->get_data( $external );

		$this->data     = $data;
		$this->fund     = $this->data["fund"];
		$this->avatar   = $this->data["avatar"];
		$this->name     = $this->data["name"];
		$this->name_raw = !empty( $this->data["name_raw"] ) ? $this->data["name_raw"] : null;
		$this->username = $this->data["username"];
		$this->email    = $this->data["email"];
		$this->guest    = empty( $this->ID );
		$this->logged   = $this->ID && $this->loader->visitor->UID ? $this->ID == $this->loader->visitor->UID : false;

		if ( in_array( "group_data", $external ) ){
			$this->admin        = $this->data["group_access"]["admin"];
			$this->artist       = $this->data["artist"];
			$this->paid         = $this->data["paid"];
			$this->group_ID     = $this->data["group_data"]["ID"];
			$this->group_data   = $this->data["group_data"];
			$this->group_access = $this->data["group_access"];
			$this->be_access    = $this->data["be_access"];
			$this->ui_access    = $this->data["ui_access"];
		}

		return $this;

	}

	// Select User
	public function select( $args ){

		$limit    = 1;
		$offset   = null;
		$order_by = "time_add";
		$order    = "DESC";
		$where    = [];
		$where_o  = "AND";
		$singular = true;

		// Where shortcodes
		$ID          = null;
		$verified    = null;
		$group_id    = null;
		$_sq         = null;
		$username    = null;

		$_eg         = [];

		extract( $args );

		// Search Queries
		if ( $ID )
		$where[] = [ "ID", "=", $ID ];

		if ( $username )
		$where[] = [ "username", "=", $username ];

		if ( $_sq )
		$where[] = [ "username", "LIKE%", strtolower($_sq) ];

		if ( $group_id == 2 )
		$where[] = [ "artist", "=", "1" ];
		elseif ( $group_id == 3 )
		$where[] = [ "time_paid_expire", ">", "now()", true ];
		elseif ( $group_id )
		$where[] = [ "GID", "=", $group_id ];

		if ( $verified === true || $verified === 1 || $verified === "1" )
		$where[] = [ "verified", "=", "1" ];

		if ( $verified === false || $verified === 0 || $verified === "0" )
		$where[] = [
			"oper" => "OR",
			"cond" => [
				[ "verified", "=", "0" ],
				[ "verified", null, null, true ]
			],
		];

		$args = array(

			"table"    => "_users",
			"where"    => array(
			    "oper" => $where_o,
			    "cond" => $where
		    ),
			"order_by" => $order_by,
			"order"    => $order,
			"limit"    => $limit,
			"offset"   => $offset,
			"cache"    => $limit == 1 ? true : false

		);

		$raw_results = $this->loader->db->_select( $args );
		if ( empty( $raw_results ) ) return false;

		$__results = [];
		foreach( $raw_results as $__i ){
			$__results[ $__i["ID"] ] = $this->select_clean( $__i, $_eg );
		}

		return $limit == 1 && $singular ? reset( $__results ) : $__results;

	}
	protected function select_clean( $data, $external = [] ){

		$data["name"] = $data["name_raw"] = empty( $data["name"] ) ? ucfirst( $data["username"] ) : $data["name"];
		$data["name"] = $this->loader->secure->escape( $data["name"] );
		$data["paid"] = !empty( $data["time_paid_expire"] ) ? strtotime( $data["time_paid_expire"] ) > time() : false;
		$data["feed_setting"] = !empty( $data["feed_setting"] ) ? explode( ",", $data["feed_setting"] ) : null;
		$data["not_setting"] = !empty( $data["not_setting"] ) ? explode( ",", $data["not_setting"] ) : null;
		$data["email_setting"] = !empty( $data["email_setting"] ) ? explode( ",", $data["email_setting"] ) : null;

		$data["external_addresses"]               = !empty( $data["external_addresses"] ) ? json_decode( $data["external_addresses"], 1 ) : [];
		$data["external_addresses"]["website"]    = empty( $data["external_addresses"]["website"] ) ? null : $data["external_addresses"]["website"];
		$data["external_addresses"]["facebook"]   = empty( $data["external_addresses"]["facebook"] ) ? null : $data["external_addresses"]["facebook"];
		$data["external_addresses"]["soundcloud"] = empty( $data["external_addresses"]["soundcloud"] ) ? null : $data["external_addresses"]["soundcloud"];
		$data["external_addresses"]["instagram"]  = empty( $data["external_addresses"]["instagram"] ) ? null : $data["external_addresses"]["instagram"];
		$data["external_addresses"]["twitter"]    = empty( $data["external_addresses"]["twitter"] ) ? null : $data["external_addresses"]["twitter"];

		$data["url"]      = $this->loader->ui->rurl( "user", $data["username"] );
		$data["avatar_o"] = $data["avatar"];
		$data["bg_img_o"] = $data["bg_img"];
		$data["avatar"]   = $data["avatar"] ? $this->loader->general->path_to_addr( $data["avatar"] ) : "{$this->loader->theme->set_name('__default')->addr}assets/icons/avatar.png";
		$data["bg_img"]   = $this->loader->general->path_to_addr( $data["bg_img"] );


		// External Gets
		if ( in_array( "group_data", $external ) ){

			$__gacs = $this->get_access( $data );
			$data["group_access"] = $__gacs["access"];
			$data["be_access"]    = $__gacs["be_access"];
			$data["ui_access"]    = $__gacs["ui_access"];
			$data["group_data"]   = $this->get_group_data( $__gacs["ID"] );

			if ( !empty( $data["group_access"]["verified"] ) )
				$data["name"] = "{$data["name"]}<span class='verified mdi mdi-star-circle'></span>";

		}

		// Events setting
		if ( in_array( "event_setting", $external ) ){

			foreach( [ "feed", "email", "not" ] as $e_type ){

				$admin_allowed_e_s = explode( ",", $this->loader->admin->get_setting( "ua_{$e_type}" ) );
				$allowed_e_s = array_diff( $admin_allowed_e_s, $this->admin_actions );

				if ( ( $user_allowed_e_s = $data["{$e_type}_setting"] ) )
				$allowed_e_s = array_intersect( $allowed_e_s, $user_allowed_e_s );

				if ( in_array( $data["ID"], explode( ",", $this->loader->admin->get_setting( "admin_ids", 1 ) ) ) )
				$allowed_e_s = array_merge( $this->admin_actions, $allowed_e_s );

				$data["event_allowed"][$e_type] = $allowed_e_s;

			}

		}

		return $data;

	}
	public function get_data( $external_gets = [] ){

		if ( !empty( $this->cache[ "users" ][ $this->ID . ( $external_gets ? "_" . implode( "_", $external_gets ) : "" ) ] ) ){
			return $this->cache[ "users" ][ $this->ID . ( $external_gets ? "_" . implode( "_", $external_gets ) : ""  )];
		}

		if ( $this->ID ){

			$data = $this->select(array(
			    "ID"  => $this->ID,
			    "_eg" => $external_gets
		    ));

			$data["avatar"] = $data["avatar"] ? $data["avatar"] : $this->avatar;

		} else {

			$data = array(
				"name"     => "guest",
				"username" => null,
				"email"    => null,
				"avatar"   => "{$this->loader->theme->set_name('__default')->addr}assets/icons/avatar.png",
				"artist"   => 0,
				"paid"     => 0,
				"fund"     => 0
			);

			if ( in_array( "group_data", $external_gets ) ){
				$__gac = $this->get_access( false );
				$data["group_data"]   = $this->get_group_data( 5 );
				$data["group_access"] = $__gac["access"];
				$data["be_access"]    = $__gac["be_access"];
				$data["ui_access"]    = $__gac["ui_access"];
			}

		}

		$this->cache[ "users" ][ $this->ID . ( $external_gets ? "_" . implode( "_", $external_gets ) : "" ) ] = $data;

		return $data;

	}

	// User Group
	public function group_select( $args ){

		$query    = null;
		$limit    = 1;
		$offset   = null;
		$order_by = "ID";
		$order    = "ASC";
		$where    = [];
		$where_o  = "AND";
		$singular = true;

		// Where shortcodes
		$ID          = null;
		$name        = null;
		$_eg         = [];
		extract( $args );

		// String Operations
		$limit_string = $offset ? "{$offset}, {$limit}" : $limit;

		// Search Queries
		if ( $ID )
			$where[] = [ "ID", "=", $ID ];

		if ( $name )
			$where[] = [ "name", "=", $name ];

		$args = array(

			"table"    => "_user_groups",
			"where"    => array(
			    "oper" => $where_o,
			    "cond" => $where
		    ),
			"order_by" => $order_by,
			"order"    => $order,
			"limit"    => $limit,
			"offset"   => $offset,
			"cache"    => $limit == 1 ? true : false

		);

		$raw_results = $this->loader->db->_select( $args );
		if ( empty( $raw_results ) ) return false;

		$__results = [];
		foreach( $raw_results as $__i ){
			$__results[ $__i["ID"] ] = $this->group_select_clean( $__i, $_eg );
		}

		return $limit == 1 && $singular ? reset( $__results ) : $__results;

	}
	public function group_select_clean( $data, $external = [] ){

		$data["ui_access"] = $data["ui_access"] ? ( $data["ui_access"] == '["*"]' ? "*" : json_decode( $data["ui_access"], 1 ) ) : [];
		$data["be_access"] = $data["be_access"] ? ( $data["be_access"] == '["*"]' ? "*" : json_decode( $data["be_access"], 1 ) ) : [];
		return $data;

	}
	public function get_group_data( $ID, $external_gets = [] ){

		if ( !empty( $this->cache[ "groups" ][ $ID . ( $external_gets ? "_" . implode( "_", $external_gets ) : "" ) ] ) )
		return $this->cache[ "groups" ][ $ID . ( $external_gets ? "_" . implode( "_", $external_gets ) : "" ) ];

		$data = $this->group_select(array(
		    "ID"  => $ID,
		    "_eg" => $external_gets
		));

		$this->cache[ "groups" ][ $ID . ( $external_gets ? "_" . implode( "_", $external_gets ) : "" ) ] = $data;

		return $data;

	}
	public function group_delete( $ID ){

		$data = is_array( $ID ) ? $ID : $this->group_select(["ID"=>$ID]);
		if ( empty( $data ) ) return false;
		$ID = $data["ID"];
		if ( $ID <= 5 ) return false;

		$this->db->_delete([
			"table" => "_user_groups",
			"where" => [
			    "oper" => "AND",
			    "cond" => [
			        [ "ID", "=", $ID ]
		        ],
		    ],
		]);

		$this->db->_update([
			"table" => "_users",
			"set"   => [
			    [ "GID", 4 ]
		    ],
			"where" => [
			    "oper" => "AND",
			    "cond" => [
			        [ "GID", "=", $ID ]
		        ],
		    ],
		]);

		return true;

	}
	public function group_create( $args ){

		$name = null;
		extract( $args );

		if ( empty( $name ) )
			return false;

		if ( !empty( $this->group_select(["name"=>$name] ) ) )
			return false;

		$this->loader->db->_insert([
			"table" => "_user_groups",
			"set"   => [
			    [ "name", $name ]
		    ],
		]);

	}
	public function group_get_all_simplfied( $forceNew = false ){

		$all = $this->group_select(["limit"=>100,"singular"=>false]);
		$all_simple = [];
		foreach( $all as $group ){
			$all_simple[ $group["name"] ] = [ $group["ID"], $group["name"] ];
		}
		return $all_simple;

	}

	// Access
	public function get_access( $user = null ){

		$user = $user === null ? $this->data : $user;

		$group_access = [
			"muse"       => false,
			"premium"    => false,
			"download"   => false,
			"upload"     => false,
			"sell"       => false,
			"upgrade"    => false,
			"signup"     => false,
			"artist_req" => false,
			"report"     => false,
			"admin"      => false,
			"verified"   => false,
			"comment"    => false,
			"language"   => false,
			"sell_share" => false,
			"advertisement" => false,
			"notification" => false,
			"hide_advertisement" => false,
			"hq_audio"   => false,
		];

		$groups_ui_access = [
			"all" => array(
				// global
				"translation_js",
				"404",
				"no_access",
				// content
				"search",
				"album",
				"track",
				"track_embed",
				"page",
				"artist",
				"playlist",
				"genre",
				// user ( public pages )
				"user",
				"user_playlists",
				"user_heard",
				"user_likes",
				"user_uploads",
				"user_reposts",
				"user_followers",
				"user_followings"
			),
			"guest" => array(
				"user_login",
				"user_recover",
				"user_signup",
				"user_pay_result",
			),
			"user" => array(
				"user_feed",
				"user_logout",
				"user_setting",
				"user_purchased",
				"user_pay_result"
			),
			"upload" => array(
				"user_upload",
				"user_upload_edit"
			),
			"upgrade" => array(
				"user_upgrade"
			),
			"admin" => array(
				"admin_dashboard",
				"admin_menu_editor",
				"admin_theme_setting",
				"admin_page_editor",
				"admin_language_editor",
				"admin_setting_api",
				"admin_setting_upload",
				"admin_setting_upload_aws",
				"admin_setting_general",
				"admin_setting_sessions",
				"admin_setting_download",
				"admin_setting_pay",
				"admin_setting_email",
				"admin_setting_programs",
				"admin_setting_social_login",
				"admin_setting_notifications",
				"admin_users",
				"admin_user_groups",
				"admin_user_comments",
				"admin_user_payments",
				"admin_user_transactions",
				"admin_user_artist_reqs",
				"admin_user_withdraws",
				"admin_user_reports",
				"admin_user_ads",
				"admin_tools_bot_runner",
				"admin_tools_auto_translate",
				"admin_tools_cleaner",
				"admin_content_genres",
				"admin_content_tracks",
				"admin_content_albums",
				"admin_content_sources",
				"admin_content_artists"
			),
		];

		$groups_be_access = array(
			"all" => array(
				"spotify_create",
				"waveform_create",
				"special_buttons",
				"get_ad_link"
			),
			"guest" => array(
				"user_login",
				"user_recover",
				"user_recover2",
			),
			"user" => array(
				"user_act_like",
				"user_act_repost",
				"user_act_load_playlists",
				"user_act_create_playlist",
				"user_act_remove_playlist",
				"user_act_edit_playlist",
				"user_act_extend_playlist",
				"user_act_sort_playlist",
				"user_act_lessen_playlist",
				"user_act_follow",
				"user_act_post_comment",
				"user_act_delete_comment",
				"user_act_like_comment",
				"user_proceed_payment",
				"user_stripe",
				"user_bank_transfer",
				"user_bank_transfer_submit",
				"user_purchase",
				"user_setting_general_setting",
				"user_setting_profile_setting",
				"user_setting_change_password",
				"user_setting_end_session",
				"user_setting_feed_setting",
				"user_act_sub_artist",
				"user_act_like_album",
				"user_act_sub_playlist",
				"user_act_like_playlist"
			),
			"muse" => array(
				"muse_add",
				"muse_get_track",
				"muse_next_track",
				"muse_prev_track",
				"muse_get_que",
				"muse_set_volume",
				"muse_set_repeat",
				"muse_remove_from_que",
				"muse_clear_que",
				"muse_shuffle_que"
			),
			"upload" => array(
				"user_upload_music",
				"user_update_uploading_track",
				"user_update_uploading_album",
				"user_update_uploading_cover",
				"user_update_uploading_wave",
				"user_update_finalize_edit",
			),
			"download" => array(
				"download_music"
			),
			"signup" => array(
				"user_signup"
			),
			"admin" => array(
				"admin_save_menu",
				"admin_remove_menu",
				"admin_save_page",
				"admin_remove_page",
				"admin_index_page",
				"admin_save_theme_setting",
				"admin_new_language",
				"admin_remove_language",
				"admin_edit_language",
				"admin_save_page_snoop_spotify",
				"admin_users_edit_group",
				"admin_users_remove_group",
				"admin_users_new_group",
				"admin_user_verify",
				"admin_user_connect",
				"admin_user_disconnect",
				"admin_save_setting_general",
				"admin_save_setting_api",
				"admin_save_setting_upload",
				"admin_save_setting_upload_aws",
				"admin_save_setting_sessions",
				"admin_save_setting_pay",
				"admin_save_setting_download",
				"admin_save_setting_email",
				"admin_save_setting_programs",
				"admin_save_setting_social_login",
				"admin_save_setting_notifications",
				"admin_test_ftp",
				"admin_test_aws",
				"admin_test_smtp",
				"admin_remove_genres",
				"admin_delete_genre",
				"admin_recover_genre",
				"admin_new_genre",
				"admin_edit_genre",
				"admin_delete_albums",
				"admin_edit_album",
				"admin_delete_tracks",
				"admin_edit_track",
				"admin_new_track",
				"admin_delete_artists",
				"admin_edit_artist",
				"admin_delete_sources",
				"admin_delete_source_waves",
				"admin_delete_comments",
				"admin_approve_comments",
				"admin_edit_user",
				"admin_approve_payments",
				"admin_reject_payments",
				"admin_accept_artist",
				"admin_reject_artist",
				"admin_artist_withdraw_remove",
				"admin_artist_withdraw_done",
				"admin_tool_update_widget",
				"admin_tools_translate",
				"admin_tool_cleaner_job",
				"admin_delete_users",
				"admin_get_suggestions",
				"admin_new_source",
				"admin_dismiss_reports",
				"admin_manage_ads",
				"admin_edit_ad",
				"admin_edit_adsense",
				"admin_test_youtube_dl",
				"admin_test_ffmpeg"
			),
			"artist_req" => array(
				"user_setting_artist_verification"
			),
			"advertisement" => array(
				"user_ads_create",
				"user_ads_remove",
				"user_ads_recharge"
			),
			"artist" => array(
				"user_setting_artist_withdrawal"
			),
			"report" => array(
				"user_act_report_track"
			),
			"notification" => array(
				"user_get_nots",
			)
		);

		$paid   = false;
		$artist = false;
		$admin  = false;
		$ID     = 5;
		$name   = "guest";
		$groups = [];
		$be_access = [];
		$ui_access = [];

		if ( $user ){

			$paid   = $user["paid"];
			$artist = $user["artist"];
			$ID     = $user["GID"];
			$groups = [ $ID ];

			if ( $paid )   $groups[] = 3;
			if ( $artist ) $groups[] = 2;
			if ( $ID == 2 && $paid ) $ID = 3;

			$be_access = array_merge( $groups_be_access["all"], $groups_be_access["user"] );
			$ui_access = array_merge( $groups_ui_access["all"], $groups_ui_access["user"] );

			if ( $artist && !empty( $groups_be_access["artist"] ) ) $be_access = array_merge( $be_access, $groups_be_access["artist"] );
			if ( $artist && !empty( $groups_ui_access["artist"] ) ) $ui_access = array_merge( $ui_access, $groups_ui_access["artist"] );
			if ( $paid && !empty( $groups_be_access["paid"] ) ) $be_access = array_merge( $be_access, $groups_be_access["paid"] );
			if ( $paid && !empty( $groups_ui_access["paid"] ) ) $ui_access = array_merge( $ui_access, $groups_ui_access["paid"] );

		}
		else {

			$groups = [ $ID ];
			$be_access = array_merge( $groups_be_access["all"], $groups_be_access["guest"] );
			$ui_access = array_merge( $groups_ui_access["all"], $groups_ui_access["guest"] );

		}

		// get group data
		foreach( $groups as $group ){

			$group_data = $this->get_group_data( $group );
			foreach( $group_data as $_gp_k => $_gp_v ){

				$_gp_k = str_replace( "_access", "", $_gp_k );
				if ( !in_array( $_gp_k, array_keys( $group_access ) ) ) continue;
				if ( $_gp_k == "sell_share" ) $group_access[ $_gp_k ] = empty( $group_access[ $_gp_k ] ) ? $_gp_v : ( $_gp_v > $group_access[ $_gp_k ] ? $_gp_v : $group_access[ $_gp_k ] );
				else $group_access[ $_gp_k ] = $_gp_v ? $_gp_v : $group_access[ $_gp_k ];

			}

			if ( $group == $ID && $group_data["admin_access"] ){
				$groups_ui_access["admin"] = $group_data["ui_access"] == "*" ? $groups_ui_access["admin"] : $group_data["ui_access"];
				$groups_be_access["admin"] = $group_data["be_access"] == "*" ? $groups_be_access["admin"] : $group_data["be_access"];
			}

		}


		if ( $group_access["admin"] ) $admin = true;
		if ( $artist ) $group_access["artist_req"] = false;
		if ( $paid ) $group_access["upgrade"]      = false;
		if ( $user ) $group_access["signup"]       = false;
		if ( !$user ){
			$group_access["upload"]     = false;
			$group_access["upgrade"]    = false;
			$group_access["sell"]       = false;
			$group_access["artist_req"] = false;
			$group_access["verified"]   = false;
			$group_access["admin"]      = false;
			$group_access["comment"]    = false;
			$group_access["notification"] = false;
			$group_access["advertisement"] = false;
		}

		foreach( $group_access as $__k => $inc ){

			if ( !$inc ) continue;

			if ( !empty( $groups_be_access[ $__k ] ) )
				$be_access = array_merge( $be_access, $groups_be_access[ $__k ] );

			if ( !empty( $groups_ui_access[ $__k ] ) )
				$ui_access = array_merge( $ui_access, $groups_ui_access[ $__k ] );

		}

		return [ "ID" => $ID, "access" => $group_access, "be_access" => $be_access, "ui_access" => $ui_access ];

	}
	public function has_access( $type, $name ){

		if ( $type == "group" ){
			return !empty( $this->group_access[ $name ] );
		}

		$var_name = "{$type}_access";
		return in_array( $name, $this->$var_name );

	}

	public function get_sidebar_links(){

		$links = array();

		if ( $this->logged ){
			$links[] = [ "rss",                $this->loader->lorem->turn( "feed", ["uc"=>true] ),     "user_feed" ];
		}

		$links[] = [ "heart-pulse",            $this->loader->lorem->turn( "activities", ["uc"=>true] ), "user" ];

		if ( $this->logged ){
			$links[] = [ "cart",               $this->loader->lorem->turn( "purchased", ["uc"=>true] ),  "user_purchased" ];
		}

		$links[] = [ "headphones",             $this->loader->lorem->turn( "heard", ["uc"=>true] ),      "user_heard" ];
		$links[] = [ "cloud-upload",           $this->loader->lorem->turn( "uploads", ["uc"=>true] ),    "user_uploads" ];
		$links[] = [ "heart",                  $this->loader->lorem->turn( "likes", ["uc"=>true] ),      "user_likes" ];
		$links[] = [ "repeat",                 $this->loader->lorem->turn( "reposts", ["uc"=>true] ),    "user_reposts" ];
		$links[] = [ "playlist-music",         $this->loader->lorem->turn( "playlists", ["uc"=>true] ),  "user_playlists" ];
		$links[] = [ "account-check",          $this->loader->lorem->turn( "followers", ["uc"=>true] ),  "user_followers" ];
		$links[] = [ "account-check-outline",  $this->loader->lorem->turn( "followings", ["uc"=>true] ), "user_followings" ];
		if ( $this->logged ){
			$links[] = [ "cog",                $this->loader->lorem->turn( "setting", ["uc"=>true] ),    "user_setting" ];
		}

		return $links;

	}

	// Signing (in|up)
	public function create( $username, $email, $password, $verified = null ){

		// Email exists?
		if ( $this->email_exists( $email ) )
			return "email_exists";

		// Username exists?
		if ( $this->username_exists( $username ) )
			return "username_exists";

		// Get hash key and hashed password
		$password_hashed = $this->hash_password( $password );

		// Users need to verify email? Check admin setting
		$verified = $verified === null ? $this->loader->admin->get_setting( 'signup_verified', 1, [ 0, 1 ] ) : $verified;
		$gid = $this->loader->admin->get_setting( "default_gid", 4 );

		$stmt = $this->db->prepare("INSERT INTO _users ( GID, username, email, password, verified ) VALUES( ?, ?, ?, ?, ? )");
		$stmt->bind_param( "sssss", $gid, $username, $email, $password_hashed, $verified );
		$stmt->execute();
		$ID = $stmt->insert_id;
		$stmt->close();

		// Notify admins
		$this->loader->admin->add_not([
			"type" => "67",
			"hook" => $ID,
			"extraData" => [ "country" => !empty( $this->loader->hit->ip_data["country"] ) ? $this->loader->hit->ip_data["country"] : "unkown" ]
		]);

		if ( $verified ){
			$this->loader->hit->create_session( $ID );
			$this->verified( $ID );
			return true;
		}

		$this->set( $ID )->data()->verify_try();

		return "verify_now";

	}
	public function check_auth( $email, $password ){

		$presented_password = $password;

		$stmt = $this->db->prepare("SELECT ID,password,verified FROM _users WHERE email = ?");
		$stmt->bind_param( "s", $email );
		$stmt->execute();
		$stmt->bind_result( $ID, $password, $verified );
		$stmt->fetch();
		$stmt->close();

		if ( empty( $ID ) ) return "wrong_auth";
		if ( $this->verify_password( $presented_password, $password ) ){
			if ( $verified ) return $ID;
			$this->set( $ID )->data()->verify_try();
			return "unverified_user";
		}
		return "wrong_auth";

	}
	public function username_exists( $username ){

		$stmt = $this->db->prepare("SELECT ID FROM _users WHERE username = ?");
		$stmt->bind_param( "s", $username );
		$stmt->execute();
		$stmt->bind_result( $ID );
		$stmt->fetch();
		$stmt->close();

		return empty( $ID ) ? false : $ID;

	}
	public function email_exists( $email ){

		$stmt = $this->db->prepare("SELECT ID FROM _users WHERE email = ?");
		$stmt->bind_param( "s", $email );
		$stmt->execute();
		$stmt->bind_result( $ID );
		$stmt->fetch();
		$stmt->close();

		return empty( $ID ) ? false : $ID;

	}
	public function hash_password( $password ){
		return password_hash( $password, PASSWORD_BCRYPT );
	}
	public function verify_password( $password, $hash ){
		return password_verify( $password, $hash );
	}
	public function change_password( $new_password ){

		$new_password_data = $this->hash_password( $new_password );

		$this->loader->db->_update([
	        "table" => "_users",
	        "where" => [
	            "oper" => "AND",
	            "cond" => [
	                [ "ID", "=", $this->ID ]
                ],
            ],
	        "set" => [
	            [ "password", $new_password_data ],
            ]
        ]);

		return true;

	}
	public function change_username( $new_username ){

		if ( $this->loader->user->username_exists( $new_username ) ){
		    return "username_already";
	    }

	    $this->loader->db->_update([
		    "table" => "_users",
		    "where" => [
		        "oper" => "AND",
		        "cond" => [
		            [ "ID", "=", $this->ID ]
	            ],
	        ],
		    "set" => [
		        [ "username", $new_username ]
	        ]
	    ]);

		return true;

	}
	public function change_email( $new_email, $need_verification = true ){

		if ( $this->loader->user->email_exists( $new_email ) ){
		    return "email_already";
	    }

		if ( $need_verification ){
			return "need_verification";
		}

	    $this->loader->db->_update([
		    "table" => "_users",
		    "where" => [
		        "oper" => "AND",
		        "cond" => [
		            [ "ID", "=", $this->ID ]
	            ],
	        ],
		    "set" => [
		        [ "email", $new_email ]
	        ]
	    ]);

		return true;

	}
	public function verify_try( $type = "signup" ){

		if ( ( $type == "signup" ? $this->data["verified"] : false  ) or ( $type == "recover" ? !$this->data["verified"] : false  ) ) return;
		if ( $this->data["time_verify_try"] ? time() - strtotime( $this->data["time_verify_try"] ) < (2*60*60) : false ) return;

		// create the code
		$verify_code = substr( md5( uniqid() ), rand(0,5), 9 );

		// save the code ( in db )
		$this->loader->db->_update([
			"table" => "_users",
			"set"   => [
			    [ "verify_code", $verify_code ],
			    [ "time_verify_try", "now()", true ]
		    ],
			"where" => [
			    [ "ID", "=", $this->ID ]
		    ]
		]);

		// save the code ( in session )
		$_SESSION["verify_code"] = $verify_code;

		// send the verification link to client's email
		$this->notify([
			"subject" => $this->loader->lorem->turn( "mls_" . ( $type == "signup" ? "verify" : "recover" ), [ "params" => [ "link" => $this->loader->ui->rurl( null, "user_{$type}", "verification_code={$verify_code}" ) ]  ] ),
			"content" => $this->loader->lorem->turn( "ml_" . ( $type == "signup" ? "verify" : "recover" ), [ "params" => [ "link" => $this->loader->ui->rurl( null, "user_{$type}", "verification_code={$verify_code}" ) ]  ] ),
		]);

	}
	public function verified( $userID ){

		if ( defined( "autfollow_admin" ) ? autfollow_admin : false ){
			$this->add_log([
				"type" => 6,
				"hook" => 1,
				"user_id" => $userID,
				"user_id_2" => 1
			]);
			$this->db->query("UPDATE _users SET followers  = followers + 1 WHERE ID = 1 ");
			$this->db->query("UPDATE _users SET followings = followings + 1 WHERE ID = {$userID} ");
			$this->db->query("INSERT INTO _user_relations ( user_id, rel_type, target_id ) VALUES ( '{$userID}', '6', '1' ) ");
		}

		$this->add_log([
			"type" => 17,
			"hook" => $userID,
			"user_id" => null,
			"user_id_2" => $userID
		]);

	}

	// Logs
	public function get_logs( $type ){

		if ( !is_int( $type ) && !ctype_digit( $type ) ) return false;
		$get = $this->db->query("SELECT * FROM _user_actions WHERE user_id = '{$this->ID}' AND type = '{$type}' ORDER BY time_add DESC ");
		if ( !$get->num_rows ) return false;

		$hooks = [];
		while( $hook = $get->fetch_assoc() ){
			$hooks[] = $hook["hook"];
		}

		return $hooks;

	}
	public function add_log( $args ){

		if ( empty( $args ) ? true : !is_array( $args ) )
		return false;

		$type      = null;
		$hook      = null;
		$AID       = null;
		$user_id   = $this->ID;
		$user_id_2 = null;
		$extraData = null;
		$admin     = false;
		extract( $args );

		if ( $user_id == $user_id_2 ) $user_id_2 = null;

		if ( empty( $type ) || empty( $hook ) )
		return false;

		$set = [];
		$set[] = [ "type", $type ];
		$set[] = [ "hook", $hook ];

		if ( $user_id )
		$set[] = [ "user_id", $user_id ];
		if ( $user_id_2 )
		$set[] = [ "user_id_2", $user_id_2 ];
		if ( $AID )
		$set[] = [ "AID", $AID ];
		if ( $extraData )
		$set[] = [ "extraData", is_array( $extraData ) ? json_encode( $extraData ) : $extraData ];

		$logID = $this->db->_insert([
			"table" => "_user_actions",
			"set" => $set
		]);

		$typeData = $this->user_actions[ $type ];
		$logData = $this->get_acts([
			"ID" => $logID,
			"user_id" => null,
			"lorem_prefix" => "rec_type"
		]);

		if ( $user_id_2 ){

			$receiverData = $this->select(["ID"=>$user_id_2,"_eg"=>["event_setting"]]);

			if ( !empty( $typeData["admin"] ) )
			$allowed_emails = array_intersect( explode( ",", $this->loader->admin->get_setting( "ua_email" ) ), $this->admin_actions );
			else
			$allowed_emails = $receiverData["event_allowed"]["email"];

			if ( in_array( $type, $allowed_emails ) ){
				$this->notify(array(
					"type_id" => $type,
					"user_id" => $receiverData["ID"],
					"email"   => $receiverData["email"],
					"subject" => $this->loader->lorem->turn( "not_{$typeData["type_name"]}_{$typeData["hook_type"]}" ),
					"content" => $logData["text"]
				));
			}

		}

		$logText = $logData["text"];

		return $logID;

	}
	public function check_log( $type, $hook ){

		$stmt = $this->db->prepare("SELECT ID FROM _user_actions WHERE user_id = ? AND type = ? AND hook = ? ");
		$stmt->bind_param( "sss", $this->ID, $type, $hook );
		$stmt->execute();
		$stmt->bind_result( $logID );
		$stmt->fetch();
		$stmt->close();

		return empty( $logID ) ? false : $logID;

	}
	public function remove_log( $args ){

		if ( empty( $args ) ? true : !is_array( $args ) )
		return false;

		$type      = null;
		$hook      = null;
		$AID       = null;
		$user_id   = $this->ID;
		$user_id_2 = null;
		extract( $args );

		$where = [];
		if ( $type )
		$where[] = [ "type", "=", $type ];
		if ( $hook )
		$where[] = [ "hook", "=", $hook ];
		if ( $AID )
		$where[] = [ "AID", "=", $AID ];
		if ( $user_id )
		$where[] = [ "user_id", "=", $user_id ];
		if ( $user_id_2 )
		$where[] = [ "user_id_2", "=", $user_id_2 ];

		if ( empty( $where ) ) return false;

		$this->db->_delete([
			"table" => "_user_actions",
			"where" => $where
		]);

	}
	public function get_users_by_log( $type, $id, $limit ){

		$get_user_acts = $this->db->query("SELECT *  FROM `_user_actions` WHERE `hook` = {$id} AND `type` = {$type} ORDER BY ID DESC LIMIT {$limit}");
		if ( !$get_user_acts->num_rows ) return false;

		$users = [];
		while( $user_act = $get_user_acts->fetch_assoc() ){
			$users[] = $this->set( $user_act["user_id"] )->get_data();
		}
		return $users;

	}
	public function get_subs( $type, $hook ){
		$get = $this->loader->db->_select([
			"table" => "_user_relations",
			"where" => [
				[ "rel_type", "=", $type ],
				[ "target_id", "=", $hook ]
			],
			"columns" => "user_id",
			"limit" => 10000
		]);
		if ( !$get ) return false;
		foreach( $get as $_arr ){
			$ids[] = $_arr["user_id"];
		}
		return $ids;
	}
	public function is_sub( $type, $hook ){
		$user_id = $this->ID;
		return $this->loader->db->_select([
			"table" => "_user_relations",
			"where" => [
				[ "rel_type", "=", $type ],
				[ "target_id", "=", $hook ],
				[ "user_id", "=", $user_id ]
			]
		]) ? true : false;
	}

	// Data
	public function get_acts( $args ){

		$user_actions = $this->user_actions;
		$ID        = null;
		$user_id   = $this->ID;
		$user_id_2 = null;
		$acts_ids  = null;
		$limit     = 25;
		$page      = 1;
		$lorem_prefix = "act_type";
		$order     = "time_add";
		extract( $args );

		$where = [];
		if ( $ID )
		$where[] = [ "ID", "=", $ID ];
		if ( $user_id ? is_array( $user_id ) : false )
		$where[] = [ "user_id", "IN", implode( ", ", $user_id ), true ];
		if ( $user_id ? is_int( $user_id ) || ctype_digit( $user_id ) : false )
		$where[] = [ "user_id", "=", $user_id ];
		if ( $user_id_2 ? is_int( $user_id_2 ) || ctype_digit( $user_id_2 ) : false )
		$where[] = [ "user_id_2", "=", $user_id_2 ];
		if ( $acts_ids ? is_array( $acts_ids ) : false )
		$where[] = [ "type", "IN", implode( ",", $acts_ids ), true ];
		if ( $acts_ids ? is_int( $acts_ids ) || ctype_digit( $acts_ids ) : false )
		$where[] = [ "type", "=", $acts_ids ];

		$get = $this->loader->db->_select([
			"table"  => "_user_actions",
			"where"  => $where,
			"limit"  => $limit,
			"offset" => ($page-1)*$limit,
			"order_by" => "time_add"
		]);

		if ( !$get ) return false;

		$acts = [];
		foreach( $get as $action ){

			// get type data
      if ( empty( $user_actions[ $action["type"] ] ) ) continue;
			$action_type_data = $user_actions[ $action["type"] ];
			$action_type_data["display_type"] = empty( $action_type_data["display_type"] ) ? $action_type_data["hook_type"] : $action_type_data["display_type"];
			$action_type_data["extra_type"]   = empty( $action_type_data["extra_type"] ) ? false : $action_type_data["extra_type"];
			$action["extraData"] = $action["extraData"] ? json_decode( $action["extraData"], 1 ) : [];
			if ( !empty( $action["extraData"]["amount"] ) ) $action["extraData"]["amount"] = $this->loader->general->display_price( $action["extraData"]["amount"], true );
			$action["type_data"] = $action_type_data;

			// get user data
			$action["user"] = $action["user_id"] ? $this->set( $action["user_id"] )->get_data() : false;
			if ( !empty( $action_type_data["admin"] ) ){
				$action["user"] = $this->set( $action["hook"] )->get_data();
				$action_type_data["hook_type"] = null;
			}
			$action["icon"] = $action_type_data["icon"];
			$action["time"] = $this->loader->general->passed_time_hr( time() - strtotime( $action["time_add"] ), 1, ", " )["string"];

			// hook data
			$action["data"]["hook"] =	false;
			if ( $action_type_data["hook_type"] == "track" ){
				$action["data"]["hook"] = $action["data"]["track"] = $this->loader->track->select( [ "ID" => $action["hook"], "_eg" => [ "artist" ] ] );
				$action["data"]["hook"]["simplified"] = [
					"url"   => $this->loader->ui->rurl( "track", $action["data"]["hook"]["url"] ),
					"title" => "{$action["data"]["hook"]["artist_name"]} - {$action["data"]["hook"]["title"]}",
					"image" => $action["data"]["hook"]["artist"]["image"]
				];
				$action["text_params"] = [
					"track"  => "<a href='{$this->loader->ui->rurl( "track", $action["data"]["hook"]["url"] )}'>{$action["data"]["hook"]["title"]}</a>",
					"artist" => "<a href='{$this->loader->ui->rurl( "artist", $action["data"]["hook"]["artist"]["url"] )}'>{$action["data"]["hook"]["artist"]["name"]}</a>"
				];
			}
			elseif ( $action_type_data["hook_type"] == "album" ){
				$action["data"]["hook"] = $action["data"]["album"] = $this->loader->album->select( [ "ID" => $action["hook"], "_eg" => [ "artist" ] ] );
				$action["data"]["hook"]["simplified"] = [
					"url"   => $this->loader->ui->rurl( "album", $action["data"]["hook"]["url"] ),
					"title" => "{$action["data"]["hook"]["artist_name"]} - {$action["data"]["hook"]["title"]}",
					"image" => $action["data"]["hook"]["artist"]["image"]
				];
				$action["text_params"] = [
					"album"  => "<a href='{$this->loader->ui->rurl( "album", $action["data"]["hook"]["url"] )}'>{$action["data"]["hook"]["title"]}</a>",
					"artist" => "<a href='{$this->loader->ui->rurl( "artist", $action["data"]["hook"]["artist"]["url"] )}'>{$action["data"]["hook"]["artist"]["name"]}</a>"
				];
			}
			elseif ( $action_type_data["hook_type"] == "artist" ){
				$action["data"]["hook"] = $action["data"]["artist"] = $this->loader->artist->select( [ "ID" => $action["hook"] ] );
				$action["data"]["hook"]["simplified"] = [
					"url"   => $this->loader->ui->rurl( "artist", $action["data"]["hook"]["url"] ),
					"title" => $action["data"]["hook"]["name"],
					"image" => $action["data"]["hook"]["image"]
				];
				$action["text_params"] = [
					"artist" => "<a href='{$action["data"]["hook"]["simplified"]["url"]}'>{$action["data"]["hook"]["simplified"]["title"]}</a>",
				];
			}
			elseif ( $action_type_data["hook_type"] == "user" ){
				$action["data"]["hook"] = $action["data"]["user"] = $this->set( $action["hook"] )->get_data();
				$action["data"]["hook"]["simplified"] = [
					"url"   => $action["data"]["hook"]["url"],
					"title" => $action["data"]["hook"]["name"],
					"image" => $action["data"]["hook"]["avatar"]
				];
				$action["text_params"] = [
					"target" => "<a href='{$action["data"]["hook"]["url"]}'>{$action["data"]["hook"]["name"]}</a>",
				];
			}
			elseif ( $action_type_data["hook_type"] == "playlist" ){
				$pl_data = $this->loader->playlist->select( [ "ID" => $action["hook"], "_eg" => [ "owner" ] ] );
				if ( !empty( $pl_data ) ){
					$action["data"]["hook"] = $action["data"]["playlist"] = $pl_data;
					$action["data"]["hook"]["simplified"] = [
						"url"   => $this->loader->ui->rurl( "playlist", $action["data"]["hook"]["url"] ),
						"title" => $action["data"]["hook"]["name"],
						"image" => "soon"
					];
					$action["text_params"] = [
						"playlist" => "<a href='{$action["data"]["hook"]["simplified"]["url"]}'>{$action["data"]["hook"]["name"]}</a>",
						"target"   => "<a href='{$action["data"]["hook"]["owner"]["url"]}'>{$action["data"]["hook"]["owner"]["username"]}</a>",
					];
				}
			}
			elseif ( $action_type_data["hook_type"] == "comment" ){
				$action["data"]["hook"] = $action["data"]["comment"] = $this->loader->comment->select( [ "ID" => $action["hook"], "_eg" => ["track"], "no_childs" => false ] );
				$action["data"]["hook"]["simplified"] = [
					"url"   => $this->loader->ui->rurl( "track", $action["data"]["hook"]["track"]["url"], "#comment_{$action["data"]["hook"]["ID"]}" ),
					"title" => $action["data"]["hook"]["user"]["username"],
					"image" => $action["data"]["hook"]["user"]["avatar"]
				];
				$action["text_params"] = [
					"track"  => "<a href='{$this->loader->ui->rurl( "track", $action["data"]["hook"]["track"]["url"], "#comment_{$action["data"]["hook"]["ID"]}" )}'>{$action["data"]["hook"]["track"]["title"]}</a>",
					"target" => "<a href='{$action["data"]["hook"]["user"]["url"]}'>{$action["data"]["hook"]["user"]["name"]}</a>",
				];
			}
			elseif ( $action_type_data["hook_type"] == "receipt" ){
				$action["data"]["hook"] = $action["data"]["receipt"] = $this->loader->pay->select( [ "ID" => $action["hook"] ] );
				$action["data"]["hook"]["simplified"] = [
					"url"   => $this->loader->ui->rurl( "user_setting", null, "n=transaction_history" ),
					"title" => "credit",
					"icon" => "mdi mdi-coffee-maker"
				];
				$action["text_params"] = [
					"amount" => $action["data"]["receipt"]["amount"],
					"currency" => $this->loader->admin->get_setting( "currency", "$" )
				];
			}
			elseif ( $action_type_data["hook_type"] == "ads" ){
				$_ad_data = $this->loader->ads->select( [ "ID" => $action["hook"] ] );
				if ( $_ad_data ){
					$action["data"]["hook"] = $action["data"]["ads"] = $_ad_data;
					$action["data"]["hook"]["simplified"] = [
						"url"   => $this->loader->ui->rurl( "user_setting", null, "n=advertising" ),
						"title" => "ads",
						"icon" => "mdi mdi-star"
					];
					$action["text_params"] = [
						"amount" => $action["data"]["ads"]["fund_total"],
						"currency" => $this->loader->admin->get_setting( "currency", "$" )
					];
				}
			}

			// extra data
		  $action["data"]["extra"] = false;
			if ( $action_type_data["extra_type"] == "track" )
			$action["data"]["extra"] = $action["data"]["track"] = $this->loader->track->select( [ "ID" => $action["AID"], "_eg" => [ "artist" ] ] );
			elseif ( $action_type_data["extra_type"] == "album" )
			$action["data"]["extra"] = $action["data"]["album"] = $this->loader->album->select( [ "ID" => $action["AID"], "_eg" => [ "artist" ] ] );
			elseif ( $action_type_data["extra_type"] == "artist" )
			$action["data"]["extra"] = $action["data"]["artist"] = $this->loader->artist->select( [ "ID" => $action["AID"] ] );
			elseif ( $action_type_data["extra_type"] == "user" )
			$action["data"]["extra"] = $action["data"]["user"] = $this->set( $action["AID"] )->get_data();
			elseif ( $action_type_data["extra_type"] == "playlist" )
			$action["data"]["extra"] = $action["data"]["playlist"] = $this->loader->playlist->select( [ "ID" => $action["AID"], "_eg" => ["owner"] ] );
			elseif ( $action_type_data["extra_type"] == "comment" )
			$action["data"]["extra"] = $action["data"]["comment"] = $this->loader->comment->select( [ "ID" => $action["AID"], "_eg" => ["track"], "no_childs" => false ] );

			if ( $action["type"] == 4 || $action["type"] == 7 )
			$action["user"] = $action["data"]["comment"]["user"];
			elseif ( $action["type"] == 9 )
			$action["user"] = $action["data"]["user"];
			elseif ( $action["type"] == 16 )
			$action["user"] = [
				"avatar"   => $action["data"]["artist"]["image"],
				"name"     => $action["data"]["artist"]["name"],
				"username" => $action["data"]["artist"]["name"],
				"url"      => $this->loader->ui->rurl( "artist", $action["data"]["artist"]["url"] )
			];
			elseif ( $action["type"] == 11 || $action["type"] == 25 )
			$action["user"] = [
				"avatar"   => $action["data"]["playlist"]["cover"] ? $action["data"]["playlist"]["cover"] : $action["data"]["playlist"]["owner"]["avatar"],
				"name"     => $action["data"]["playlist"]["name"],
				"username" => $action["data"]["playlist"]["owner"]["username"],
				"url"      => $this->loader->ui->rurl( "playlist", $action["data"]["playlist"]["url"] )
			];
			elseif ( $action["type"] == 21 )
			$action["user"] = $this->loader->visitor->user()->get_data();
			elseif ( $action["type"] == 17 )
			$action["data"]["hook"]["simplified"] = [
				"icon" => "mdi mdi-party-popper"
			];

			// make data human-readable
			$action["text"] = $this->loader->lorem->turn( "{$lorem_prefix}_{$action["type"]}", [
				"params" => array_merge(
					[ "user" => !empty( $action["user"]["url"] ) ? "<a href='{$action["user"]["url"]}' class='ul'>".ucfirst($action["user"]["username"])."</a>" : "" ],
					$action["extraData"] ,
					!empty( $action["text_params"] ) ? $action["text_params"] : []
				),
				"escape" => false
			] );

			$acts[] = $action;

		}

		if ( empty( $acts ) ) return false;
		if ( $ID ) return reset( $acts );

		return array(
			"acts"     => $acts,
			"has_more" => !empty( $this->set($user_id)->get_acts( array_merge( $args, [ "page" => $page+1 ] ) ) ) ? "{$this->loader->ui->page_uri}?p=".($page+1) : false
		);

	}
	public function remove( $ID, $new_user_ID ){

		if ( $ID == 1 ) return;
		$data = is_array( $ID ) ? $ID : $this->select(["ID"=>$ID]);
		$new_user = $new_user_ID ? ( is_array( $new_user_ID ) ? $new_user_ID : $this->select(["ID"=>$ID]) ) : false;

		// remove from _m_users
		$this->db->query("DELETE FROM _users WHERE ID = '{$data["ID"]}' ");

		// move/remove albums
		$albums = $this->loader->album->select(["user_id"=>$data["ID"],"limit"=>1000,"singular"=>false]);
		if ( !empty( $albums ) ){
			foreach( $albums as $__a ){

				if ( $new_user ){

					$edit = $this->loader->album->edit( $__a["ID"], array(
						"user_id" => $new_user["ID"],
					) );

					if ( $edit !== true ) return $edit;

				} else {

					$this->loader->album->remove( $__a, 0 );

				}

			}
		}

		// move/remove tracks
		$tracks = $this->loader->track->select(["user_id"=>$data["ID"],"limit"=>1000,"singular"=>false]);
		if ( !empty( $tracks ) ){
			foreach( $tracks as $__t ){

				if ( $new_user ){

					$edit = $this->loader->track->edit( $__t["ID"], array(
						"user_id"    => $new_user["ID"],
					) );

					if ( $edit !== true ) return $edit;

				} else {

					$this->loader->track->remove( $__t );

				}

			}
		}

		// remove playlists
		$playlists = $this->loader->playlist->select(["user_id"=>$data["ID"],"limit"=>1000,"singular"=>false]);
		if ( !empty( $playlists ) ){
			foreach( $playlists as $playlist ){
				$this->loader->playlist->remove( $playlist["ID"] );
			}
		}

		// remove comments
		$comments = $this->loader->comment->select(["user_id"=>$data["ID"],"limit"=>5000,"no_childs"=>false,"get_childs"=>false]);
		if ( !empty( $comments ) ){
			foreach( $comments as $comment ){
				$this->loader->comment->delete( $comment["ID"] );
			}
		}

		// remove cover
		if ( !empty( $data["avatar_o"] ) )
		$this->loader->general->remove_file( $data["avatar_o"] );

		// remove bg_img_o
		if ( !empty( $data["bg_img_o"] ) )
		$this->loader->general->remove_file( $data["bg_img_o"] );

		$this->db->query("UPDATE _m_artists SET user_id = null WHERE user_id = '{$data["ID"]}' ");
		$this->db->query("DELETE FROM _user_actions WHERE user_id = {$data["ID"]}");
		$this->db->query("DELETE FROM _user_actions WHERE user_id_2 = {$data["ID"]}");
		$this->db->query("DELETE FROM _user_artist_reqs WHERE user_id = {$data["ID"]}");
		$this->db->query("DELETE FROM _user_downloads WHERE user_id = {$data["ID"]}");
		$this->db->query("DELETE FROM _user_sessions WHERE user_id = {$data["ID"]}");
		$this->db->query("DELETE FROM _user_uploads WHERE userID = {$data["ID"]}");
		$this->db->query("DELETE FROM _user_reports WHERE user_id = {$data["ID"]}");
		$this->db->query("DELETE FROM _user_relations WHERE user_id = {$data["ID"]}");

	}
	public function get_heard( $args ){

		$user_id  = $this->ID;
		$limit    = 25;
		$page     = 1;
		extract( $args );
		$page = $page ? $page : 1;

		$tracks = $this->db->_select([
			"table" => "_user_heard",
			"where" => [
				[ "user_id", "=", $user_id ]
			],
			"columns" => "track_id,MAX(time_add) as time_add",
			"group" => "GROUP BY track_id",
			"limit" => $limit,
			"offset" => ($page-1)*$limit,
			"order_by" => "time_add",
		]);

		$more = $this->db->_select([
			"table" => "_user_heard",
			"where" => [
				[ "user_id", "=", $user_id ]
			],
			"columns" => "track_id",
			"group" => "GROUP BY track_id",
			"limit" => "1",
			"offset" => ($page)*$limit
		]);

		return [
			"tracks" => $tracks,
			"has_more" => !empty( $more ) ? "{$this->loader->ui->page_uri}?p=".($page+1) : false
		];

	}

	// Rels
	public function rel_exists( $type, $target_ID ){

		return $this->loader->db->_select([
			"table" => "_user_relations",
			"where" => [
				[ "user_id", "=", $this->ID ],
				[ "rel_type", "=", $type ],
				[ "target_id", "=", $target_ID ]
			]
		]) ? true : false;

	}

	// Notification
	public function notify( $args ){

		$via     = "all";
		$content = null;
		$subject = null;
		$email   = $this->email;
		$user_id = $this->ID;
		$type_id = null;
		extract( $args );

		if ( !in_array( $via, [ "email", "all" ] ) )
			return false;

		if ( $via == "email" || $via == "all" ){

			$this->db->_insert([
				"table" => "_emails",
				"set" => [
					[ "user_id", $user_id ],
					[ "type_id", $type_id ],
					[ "to", $email ],
					[ "subject", $subject ],
				]
			]);

			$send = $this->loader->email->send( $email, $subject, $content );

		}

		return true;

	}

}

?>
