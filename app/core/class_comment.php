<?php

if ( !defined("root" ) ) die;

class comment {

	public function __construct( $loader ){

		$this->loader = $loader;
		$this->db = $loader->db;

	}
	public function select( $args ){

		$query    = null;
		$limit    = 1;
		$offset   = null;
		$order_by = "time_add";
		$order    = "DESC";
		$where    = [];
		$where_o  = "AND";
		$singular = true;

		// Where shortcodes
		$ID          = null;
		$target_type = "track";
		$target_id   = null;
		$user_id     = null;
		$approved    = 1;
		$_sq         = null;
		$no_childs   = 0;
		$get_childs  = 1;
		$child_limit = 10;
		$PID         = null;
		$get_mentions = 1;

		$_eg = [];

		extract( $args );
		$_args = [
			"limit" => $limit,
			"order_by" => $order_by,
			"order" => $order,
			"get_childs" => $get_childs,
			"no_childs" => $no_childs,
			"PID" => $PID,
			"child_limit" => $child_limit,
			"_eg" => $_eg,
		];

		$limit_string = $offset ? "{$offset}, {$limit}" : $limit;

		if ( $approved )
			$where[] = [ "approved", "=", "1" ];
		if ( $approved === false || $approved === 0 )
			$where[] = [ "approved", "=", "0" ];
		if ( !empty( $user_id ) )
			$where[] = [ "user_id", "=", $user_id ];
		if ( !empty( $ID ) )
			$where[] = [ "ID", "=", $ID ];
		if ( !empty( $PID ) )
			$where[] = [ "PID", "=", $PID ];
		if ( $no_childs && !$PID )
		  $where[] = [
				"oper" => "OR",
				"cond" => [
				  [ "PID", "=", "0" ],
			   	[ "PID", null, null, true ]
			  ]
			];
		if ( $_sq )
	    	$where[] = [ "text", "LIKE%", strtolower($_sq) ];
		if ( !empty( $target_id ) && !empty( $target_type ) ? ( ctype_digit( $target_id ) || is_int( $target_id ) ) && in_array( $target_type, [ "track" ] ) : false ){
			$where[] = [ "target_type", "=", $target_type ];
			$where[] = [ "target_id", "=", $target_id ];
		}

		$args = array(

			"table"    => "_user_comments",
			"where"    => array(
			    "oper" => $where_o,
			    "cond" => $where
		    ),
			"order_by" => $order_by,
			"order"    => $order,
			"limit"    => $limit,
			"offset"   => $offset,

		);

		$raw_results = $this->loader->db->_select( $args );
		if ( empty( $raw_results ) ) return false;

		$__results = [];
		foreach( $raw_results as $__i ){

			$__i["text"] = json_decode( $__i["text"], 1 );
			$__i["text"] = $this->loader->secure->escape( $__i["text"] );

      if ( $get_mentions ){
				preg_match_all('!@(.+)(?:\s|$)!U', $__i["text"], $matches );
				if ( !empty( $matches[0] ) ){
					foreach( $matches[0] as $__mentioned_username ){
						if ( preg_match( '/<user>(.*)<\/user>/', html_entity_decode( $__mentioned_username ), $__m ) ){
							if( ctype_digit( $__m[1] ) ){
								if ( ( $user = $this->loader->user->select(["ID"=>$__m[1]]) ) ){
									$__i["text"] = str_replace( $__mentioned_username, "<a href='{$user["url"]}'>@{$user["username"]}</a> ", $__i["text"] );
								}
							}
						}
					}
				}
			}

			$__i["user"] = $this->loader->user->set( $__i["user_id"] )->get_data();

			if ( in_array( "track", $_eg ) ) {
				$__i["track"] = $this->loader->track->select(["ID"=>$__i["target_id"],"_eg"=>["artist"]]);
			}

			if ( in_array( "liked_by_visitor", $_eg ) ){
				$__i["liked"] = false;
				if ( $this->loader->visitor->user()->ID )
				$__i["liked"] = $this->loader->user->check_log( 8, $__i["ID"] ) ? true : false;
			}

			if ( $get_childs ){
				$__i["childs"] = $this->select(array_merge($_args,[
					"PID" => $__i["ID"],
					"limit" => $child_limit,
				]));
			}

			$__results[ $__i["ID"] ] = $__i;

		}

		return $limit == 1 && $singular ? reset( $__results ) : $__results;

	}
	public function create( $args ){

		$target_type = null;
		$target_id   = null;
		$target_seek = null;
		$user_id     = $this->loader->visitor->user()->ID;
		$text        = null;
		$PID         = null;
		extract( $args );

		$approved = $this->loader->user->set( $user_id )->data(["group_data"])->has_access( "group", "comment" ) ? 1 : 0;

		$depth = 1;
		if ( $PID ){
			$has_parent = $PID;
			while( $has_parent !== false ){
				$parent_comment = $this->select(["ID"=>$has_parent,"no_childs"=>false]);
				$has_parent = $parent_comment["PID"] ? $parent_comment["PID"] : false;
				$depth++;
			}
		}

		$text = json_encode( $text );

		$stmt = $this->loader->db->prepare("INSERT INTO _user_comments ( user_id, target_type, target_id, target_seek, text, approved, PID, depth ) VALUES ( ?, ?, ?, ?, ?, ?, ?, ? ) ");
		$stmt->bind_param( "ssssssss", $user_id, $target_type, $target_id, $target_seek, $text, $approved, $PID, $depth );
		$stmt->execute();
		$cmID = $stmt->insert_id;
		$stmt->close();

		if ( $approved )
		$this->exe_approved( $cmID );

		// Notify admins
		$this->loader->admin->add_not([
			"type" => "66",
			"hook" => $this->loader->visitor->user()->ID,
			"AID"  => $cmID,
			"extraData" => [ "approved" => $approved ]
		]);

		return $approved;

	}
	public function delete( $ID ){

		$data = is_array ( $ID ) ? $ID : $this->select(["ID"=>$ID,"approved"=>null,"no_childs"=>false]);
		if ( empty( $data ) ) return "delete_comment_invalid_comment_ID";

    if ( !empty( $data["childs"] ) ){
			foreach( $data["childs"] as $__child ){
				$this->delete( $__child["ID"] );
			}
		}

		$this->db->query("DELETE FROM _user_comments WHERE ID = '{$data["ID"]}' ");
		$this->db->query("UPDATE _m_{$data["target_type"]}s SET comments = comments - 1 WHERE ID = '{$data["target_id"]}' ");
		$this->loader->user->remove_log([
			"type" => 5,
			"hook" => $data["target_id"],
			"AID"  => $data["ID"],
			"user_id" => $data["user_id"]
		]);

		$this->db->query("DELETE FROM _user_actions WHERE type = 5 AND AID = '{$data["ID"]}' ");
		$this->db->query("DELETE FROM _user_actions WHERE type = 8 AND hook = '{$data["ID"]}' ");
		$this->db->query("DELETE FROM _user_actions WHERE type = 4 AND AID = '{$data["ID"]}' ");
		$this->db->query("DELETE FROM _user_actions WHERE type = 7 AND AID = '{$data["ID"]}' ");
		$this->db->query("DELETE FROM _user_actions WHERE type = 9 AND hook = '{$data["ID"]}' ");

		return true;

	}
	public function approve( $ID ){

		$data = is_array ( $ID ) ? $ID : $this->select(["ID"=>$ID,"approved"=>null]);
		if ( empty( $data ) ) return "approve_comment_invalid_comment_ID";

		$this->db->query("UPDATE _user_comments SET approved = 1 WHERE ID = '{$data["ID"]}' ");
		$this->exe_approved( $data );

		return true;

	}
	public function exe_approved( $ID ){

		$data = is_array ( $ID ) ? $ID : $this->select(["ID"=>$ID,"approved"=>null,"get_mentions"=>false]);
		if ( empty( $data ) ) return "approve_comment_invalid_comment_ID";

		$this->db->query("UPDATE _m_{$data["target_type"]}s SET comments = comments + 1 WHERE ID = '{$data["target_id"]}' ");
		$this->db->query("UPDATE _users SET comments = comments + 1 WHERE ID = {$data["user_id"]}");

		// Act log
		$this->loader->user->add_log([
			"type" => 5,
			"hook" => $data["target_id"],
			"AID"  => $data["ID"],
			"user_id" => $data["user_id"],
		]);

		$already_mentioned = [];

		// Comment replied
		if ( $data["PID"] ){

			$parent_comment = $this->loader->comment->select([
				"ID" => $data["PID"]
			]);

			if ( $parent_comment["user_id"] != $data["user_id"] && !in_array( $parent_comment["user_id"], $already_mentioned, true ) ){
				$this->loader->user->add_log([
					"user_id"   => null,
					"user_id_2" => $parent_comment["user_id"],
					"type"      => 7,
					"hook"      => $data["PID"],
					"AID"       => $data["ID"]
				]);
				$already_mentioned[] = $parent_comment["user_id"];
				$this->db->query("UPDATE _users SET comments_replied = comments_replied + 1 WHERE ID = {$parent_comment["user_id"]}");
			}

		}

		// Media replied
		$track = $this->loader->track->select([
			"ID" => $data["target_id"]
		]);

		if ( $track["user_id"] && $track["user_id"] != $data["user_id"] && !in_array( $track["user_id"], $already_mentioned, true ) ){
			$this->loader->user->add_log([
				"user_id"   => null,
				"user_id_2" => $track["user_id"],
				"type"      => 4,
				"hook"      => $track["ID"],
				"AID"       => $data["ID"]
			]);
			$already_mentioned[] = $track["user_id"];
			$this->db->query("UPDATE _users SET media_comments = media_comments + 1 WHERE ID = {$track["user_id"]}");
		}

		// Mentions
		if ( preg_match_all('!@(.+)(?:\s|$)!U', $data["text"], $matches ) ){

			foreach( $matches[0] as $__mention ){
				$__mentioned_username = trim( substr( $__mention, 1 ) );
				// Validate mentioned username
				if ( !$this->loader->secure->validate( $__mentioned_username, "username" ) ) continue;
				// Check if this username actually exists
				if ( !( $__mentioned_user_data = $this->loader->user->select(["username"=>$__mentioned_username]) ) ) continue;
				// Already mentioned?
				if ( in_array( $__mentioned_user_data["ID"], $already_mentioned, true ) ) continue;
				if ( $__mentioned_user_data["ID"] != $data["user_id"] ){
					$this->loader->user->add_log([
						"user_id" => null,
						"user_id_2" => $__mentioned_user_data["ID"],
						"type" => 9,
						"hook" => $data["ID"],
						"AID"  => $data["user_id"]
					]);
				}
				$data["text"] = str_replace( "@{$__mentioned_username}", "@{$__mentioned_username}<user>{$__mentioned_user_data["ID"]}</user>", $data["text"] );
				$already_mentioned[] = $__mentioned_user_data["ID"];
			}

			if ( !empty( $already_mentioned ) ){
				$this->loader->db->_update([
					"table" => "_user_comments",
					"set" => [
						[ "text", json_encode( $data["text"] ) ]
					],
					"where" => [
						[ "ID", "=", $ID ]
					]
				]);
			}

		}

		return true;

	}

}

?>
