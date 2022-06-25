<?php

if ( !defined("root" ) ) die;

class playlist {

	public function __construct( $loader ){

		$this->loader = $loader;
		$this->db = $loader->db;

	}

	public function select( $args ){

		$query    = null;
		$limit    = 1;
		$offset   = null;
		$order_by = "time_update";
		$order    = "DESC";
		$where    = [];
		$where_o  = "AND";
		$singular = true;

		$ID          = null;
		$hash        = null;
		$track_id    = null;
		$user_id     = null;
		$collabed_in_id = null;

		$_eg = [];
		extract( $args );

		if ( !empty( $ID ) )
		$where[] = [ "ID", "=", $ID ];
		elseif ( !empty( $hash ) )
		$where[] = [ "hash", "=", $hash ];

		if ( !empty( $user_id ) && !empty( $collabed_in_id ) )
		$where[] = [
			"oper" => "OR",
			"cond" => [
				[ "user_id", "=", $user_id ],
				[ "ID", "IN", "SELECT _user_relations.target_id FROM _user_relations WHERE _user_relations.rel_type = 24 AND _user_relations.user_id = {$user_id}", true ]
			]
		];
		elseif ( !empty( $user_id ) )
		$where[] = [ "user_id", "=", $user_id ];

		if ( !empty( $track_id ) ? ctype_digit( $track_id ) || is_int( $track_id ) : false )
		$where[] = [ "ID", "IN", "SELECT playlist_id FROM _user_playlists_relations WHERE track_id = '{$track_id}'", true ];

		$args = array(

			"table"    => "_user_playlists",
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

			$__i["name"]               = $this->loader->secure->escape( $__i["name"] );
			$__i["passed_time_add"]    = $this->loader->general->passed_time_hr( time() - strtotime( $__i["time_add"] ), 1 )["string"];
			$__i["passed_time_update"] = $this->loader->general->passed_time_hr( time() - strtotime( $__i["time_update"] ), 1 )["string"];
			$__i["cover_o"]            = $__i["cover"];
			$__i["cover"]              = $__i["cover"] ? $this->loader->general->path_to_addr( $__i["cover"] ) : $__i["cover"];

			if ( in_array( "liked", $_eg, true ) ) $__i["liked"] = $this->loader->user->check_log( 13, $__i["ID"] );
			if ( in_array( "followed", $_eg, true ) ) $__i["followed"] = $this->loader->user->check_log( 12, $__i["ID"] );
			if ( in_array( "owner", $_eg, true ) ) $__i["owner"] = $this->loader->user->set( $__i["user_id"] )->get_data();
			if ( in_array( "collabed", $_eg, true ) ) {
				$__i["collabed"] = false;
				if ( $__i["owner"]["ID"] == $this->loader->visitor->user()->ID )
				$__i["collabed"] = true;
				elseif ( $this->loader->visitor->user()->ID )
				$__i["collabed"] = $this->loader->user->is_sub( 24, $__i["ID"] );
			}
			if ( in_array( "tracks", $_eg, true ) ){
				$__eg_tracks_limit = !empty( $_eg["tracks_limit"] ) ? $_eg["tracks_limit"] : 20;
				$__eg_tracks_eg = !empty( $_eg["tracks_eg"] ) ? $_eg["tracks_eg"] : ["liked", "reposted", "paid", "download_able", "artists_featured"];
				$__i["tracks"] = $this->loader->track->select([
					"playlist_id" => $__i["ID"],
					"limit"       => $__eg_tracks_limit,
					"_eg"         => $__eg_tracks_eg
				]);
				if ( !empty( $__i["tracks"] ) && empty( $__i["cover"] ) )
				$__i["cover"] = reset( $__i["tracks"] )["cover_addr"];
			}
			if ( in_array( "collabs", $_eg, true ) ){
				$__i["collabs"] = $this->loader->user->select([
					"where" => [
						[ "ID", "IN", "SELECT user_id FROM _user_relations WHERE rel_type = 24 AND target_id = {$__i["ID"]}", true ]
					],
					"limit" => 100
				]);
				$__i["collabs_o"] = "";
				if ( !empty( $__i["collabs"] ) ){
					foreach( $__i["collabs"] as $_collab )
					$_collabs[] = $_collab["username"];
					$__i["collabs_o"] = implode(",",$_collabs);
				}
			}
			$__results[ $__i["hash"] ] = $__i;
		}

		return $limit == 1 && $singular ? reset( $__results ) : $__results;

	}
	public function create( $args ){

		$name = null;
		$user_id = null;
		$hash = md5( uniqid() );
		extract( $args );
		if ( empty( $name ) ) return "empty_name";
		$user_id = empty( $user_id ) ? $this->loader->visitor->user()->ID : $user_id;

		$stmt = $this->db->prepare("INSERT INTO _user_playlists ( user_id, hash, name ) VALUES ( ?, ?, ? )");
		$stmt->bind_param( "sss", $user_id, $hash, $name );
		$stmt->execute();
		$playlist_id = $stmt->insert_id;
		$stmt->close();

		if ( empty( $playlist_id ) ) return "database_creation_failed";

		$url = $this->loader->ui->murl(
			"playlist",
			$name,
			$playlist_id
		);

		$stmt = $this->db->prepare("UPDATE _user_playlists SET url = ? WHERE ID = ?");
		$stmt->bind_param( "ss", $url, $playlist_id );
		$stmt->execute();
		$stmt->close();

		return array(
			1,
			array(
			    "ID"  => $playlist_id,
			    "url" => $url
		    )
		);

	}
	public function extend( $playlist_id, $track_id ){

		// get sort
		$last_sort = $this->db->_select([
			"table" => "_user_playlists_relations",
			"where" => [
				[ "playlist_id", "=", $playlist_id ]
			],
			"order_by" => "sort",
			"order" => "DESC",
			"limit" => 1
		]);

		if ( empty( $last_sort ) )
		$last_sort = 1;
		else
		$last_sort = $last_sort[0]["sort"];

		// exists
		if ( $this->db->_select([
			"table" => "_user_playlists_relations",
			"where" => [
				[ "playlist_id", "=", $playlist_id ],
				[ "track_id", "=", $track_id ],
			]
		]) )
		return;

		// insert
		$this->db->_insert([
			"table" => "_user_playlists_relations",
			"set" => [
				[ "playlist_id", $playlist_id ],
				[ "track_id", $track_id ],
				[ "sort", $last_sort+1 ]
			]
		]);

		$this->count_tracks( $playlist_id );

	}
	public function lessen( $playlist_id, $track_id ){

		$stmt = $this->db->prepare("DELETE FROM _user_playlists_relations WHERE playlist_id = ? AND track_id = ? ");
		$stmt->bind_param( "ss", $playlist_id, $track_id );
		$stmt->execute();
		$stmt->close();

		$this->count_tracks( $playlist_id );

	}

	public function count_tracks( $playlist_id ){

		$track_count = $this->db->query("SELECT 1 FROM _user_playlists_relations WHERE playlist_id = '{$playlist_id}' ")->num_rows;
		$this->db->query("UPDATE _user_playlists SET track_count = '{$track_count}', time_update = now() WHERE ID = '{$playlist_id}' ");

	}

	public function reset_que( $hashs=null ){

		if ( empty( $_SESSION["play_que"] ) )
			return;

		if ( !empty( $hashs ) ){
			$__nq = [];
			foreach( json_decode( $_SESSION["play_que"], 1 ) as $__h ){
				if ( !in_array( $__h, $hashs ) ){
					$__nq[] = $__h;
				}
			}
			$_SESSION["play_que"] = json_encode( $__nq );
		}
		else {
			$_SESSION["play_que"] = json_encode( [] );
		}

	}
	public function get_que(){

		$repeat = !isset( $_SESSION["play_repeat"] ) ? true : $_SESSION["play_repeat"];
		if ( !$repeat && !empty( $_SESSION["play_radio_seeds"] ) ?
			  ( empty( $_SESSION["play_que"] ) ? true : empty( json_decode( $_SESSION["play_que"], 1 ) ) ) && $this->loader->admin->get_setting("station",1) && $this->loader->admin->get_setting("spotify_id",null) && $this->loader->admin->get_setting("spotify_key",null)
			: false ){
			$this->get_tracks_from_seeds();
		}

		return !empty( $_SESSION["play_que"] ) ?
			json_decode( $_SESSION["play_que"], 1 ) :
		    [];

	}
	public function extend_que( $tracks, $append = true, $source = null ){

		$que = $this->get_que();

		foreach( $tracks as $track ){

			// Hash
			$track_hash = is_array( $track ) ? $track["hash"] : $track;

			// Remove duplicated
			foreach( (array) $que as $_q_i => $_q_track ){
				if ( $_q_track[0] == $track_hash ) unset( $que[ $_q_i ] );
			}

			$tracks_hashes[] = $track_hash;

		}

		foreach( $append ? array_reverse( $tracks_hashes ) : $tracks_hashes as $track_hash ){

			// Prepend/Append track to que
			if ( $append ) array_push( $que, [ $track_hash, $source ] );
			else array_unshift( $que, [ $track_hash, $source ] );

		}

		// Save the que
		$_SESSION["play_que"] = json_encode( $que );

	}
	public function mark_pre_que(){

		$que = $this->get_que();
		$_SESSION["play_pre"] = !empty( $que ) ? reset( $que )[0] : null;

	}
	public function remove_from_que( $hash ){

		$que = $this->get_que();
		foreach( (array) $que as $_q_i => $_q_track ){
			if ( $_q_track[0] == $hash ) unset( $que[ $_q_i ] );
		}

		$this->remove_from_radio( $hash );

		// Save the que
		$_SESSION["play_que"] = json_encode( $que );

	}
	public function remove_from_radio( $hash ){

		$radio = $this->get_radio_que();
		$hash_id = $this->loader->track->select(["hash"=>$hash]);
		if ( empty( $hash_id["ID"] ) ) return false;
		foreach( (array) $radio as $_q_i => $_q_track ){
			if ( $_q_track == $hash_id["ID"] ) unset( $radio[ $_q_i ] );
		}

		// Save the que
		$_SESSION["play_radio_tracks"] = empty( $radio ) ? "" : implode( ",", $radio );

	}
	public function shuffle_que(){

		$que = $this->get_que();

		// Anything qued?
		if ( empty( $que ) ) return;

		$new_que = [ array_values( $que )[0] ];
		$que = array_slice( $que, 1 );
		while ( count( $que ) ){

			$que = array_values( $que );
			$rand_from_que = $que[ rand( 0, count( $que ) - 1 ) ];
			unset( $que[ array_search( $rand_from_que, $que ) ] );
			$new_que[] = $rand_from_que;

		}

		$_SESSION["play_que"] = json_encode( $new_que );

	}

	public function clear_radio(){

		$_SESSION["play_radio_seeds"]  = null;
        $_SESSION["play_radio_tracks"] = null;
        $_SESSION["play_radio_seeds_used"] = null;

	}
	public function get_radio_que( $data=null ){

		if ( empty( $_SESSION["play_radio_tracks"] ) ) return false;
		$radio_que = explode( ",", $_SESSION["play_radio_tracks"] );

		if ( !$data ) return $radio_que;

		foreach( array_slice( $radio_que, 0, 5000 ) as $_track_id ){
			$radio_tracks_data[] = $this->loader->track->select(["ID"=>$_track_id]);
		}

		return $radio_tracks_data;

	}
	public function set_radio_seeds( $type, $tracks, $source ){

		$this->reset_que();
		$_SESSION["play_repeat"] = false;

		$seeds = [];
		$track_ids = [];
		foreach( $tracks as $track ){

			$track_ids[] = $track["ID"];
			if ( !in_array( "artist_{$track["artist_id"]}", $seeds ) ) $seeds[] = "artist_{$track["artist_id"]}";
			if ( !empty( $track["artists_featured"] ) ){
				foreach( $track["artists_featured"] as $_ft_artist ){
					if ( !in_array( "artist_{$_ft_artist["ID"]}", $seeds ) )  $seeds[] = "artist_{$_ft_artist["ID"]}";
				}
			}

		}

		if ( empty( $seeds ) ) return false;
		shuffle( $track_ids );
		shuffle( $seeds );
		$seeds = array_slice( $seeds, 0, 10 );
		$track_ids = array_slice( $track_ids, 0, 15 );
		$_SESSION["play_radio_seeds"]  = implode( ",", $seeds );
		$_SESSION["play_radio_tracks"] = implode( ",", $track_ids );

		$this->set_tracks_for_seeds();
		$this->get_tracks_from_seeds();

	}
	public function set_used_radio_seed( $seed ){
		$_SESSION["play_radio_seeds_used"] = empty( $_SESSION["play_radio_seeds_used"] ) ? $seed : $_SESSION["play_radio_seeds_used"] . ",{$seed}";
	}
	public function get_tracks_from_seeds(){

		if ( !empty( $_SESSION["play_radio_tracks"] ) ? count( $this->get_radio_que() ) < 5 : true ){
			$this->set_tracks_for_seeds();
		}

		$tracks_ids = $this->get_radio_que();
		if ( empty( $tracks_ids ) ) return false;

		$track_id = array_shift( $tracks_ids );
		$track_data = $this->loader->track->select(["ID"=>$track_id,"singular"=>true,"limit"=>1]);
		if ( empty( $track_data ) ) return false;


		$_SESSION["play_que"] = json_encode( array( [ $track_data["hash"], "radio" ] ) );
		$_SESSION["play_radio_tracks"] = implode( ",", array_values( $tracks_ids ) );
		$_SESSION["play_radio_tracks_used"] = implode( ",", array_merge( [ $track_id ], ( empty( $_SESSION["play_radio_tracks_used"] ) ? [] : explode( ",", $_SESSION["play_radio_tracks_used"] ) ) ) );

		return true;

	}
	public function set_tracks_for_seeds( $rerun=false ){

		if ( empty( $_SESSION["play_radio_seeds"] ) )
			return false;

		$seeds             = explode( ",", $_SESSION["play_radio_seeds"] );
		$seeds_used        = !empty( $_SESSION["play_radio_seeds_used"] ) ? explode( ",", $_SESSION["play_radio_seeds_used"] ) : [];
		$seeds_unused      = array_diff( $seeds, $seeds_used );
		$seeds_tracks      = $this->get_radio_que();
		$seeds_tracks_used = empty( $_SESSION["play_radio_tracks_used"] ) ? [] : explode( ",", $_SESSION["play_radio_tracks_used"] );
		$seeds_tracks_new  = [];

		if ( empty( $seeds_unused ) ){
			$this->set_radio_related_seeds();
			if ( $rerun ) return false;
			return $this->set_tracks_for_seeds( true );
		}

		foreach( $seeds_unused as $seed_unused ){

			list( $seed_unused_type, $seed_unused_hook ) = explode( "_", $seed_unused );
			if ( $seed_unused_type == "artist" ){

			    $seed_data = $this->loader->artist->select(["ID"=>$seed_unused_hook]);

			    $this->loader->bot->complete_artist( $seed_data, 6 );

			    $artist_tracks = $this->loader->track->select(["artist_id"=>$seed_unused_hook,"singular"=>false,"limit"=>50,"order_by"=>" ","order"=>"RAND()"]);
			    $artist_fted_tracks = $this->loader->track->select(["ft_artist_id"=>$seed_unused_hook,"singular"=>false,"limit"=>50,"order_by"=>" ","order"=>"RAND()"]);
				$artist_unused_tracks = 0;

			    if ( empty( $artist_tracks ) ){
				    // cancel seed, rerun
				    $this->set_used_radio_seed( $seed_unused );
		     	    continue;
			    }

				$artist_tracks = empty( $artist_fted_tracks ) ? $artist_tracks : array_merge( $artist_tracks, $artist_fted_tracks );

				foreach( $artist_tracks as $_artist_track ){

					if ( $seeds_tracks ? false : in_array( $_artist_track["ID"], $seeds_tracks ) ) continue;
					if ( $seeds_tracks_used ? false : in_array( $_artist_track["ID"], $seeds_tracks_used ) ) continue;
					if ( $artist_unused_tracks >= 10 ) continue;

					$artist_unused_tracks++;
					$seeds_tracks_new[] = $_artist_track["ID"];

				}

		    }

			$seeds_used[] = $seed_unused;

		}

		shuffle( $seeds_tracks_new );
		$seeds_tracks = array_merge( $seeds_tracks, $seeds_tracks_new );
		$_SESSION["play_radio_tracks"] = implode( ",", $seeds_tracks );
		$_SESSION["play_radio_seeds_used"] = implode( ",", $seeds_used );
		return true;

	}
	public function set_radio_related_seeds(){

		if ( empty( $_SESSION["play_radio_seeds"] ) ) return false;
		$seeds = explode( ",", $_SESSION["play_radio_seeds"] );

		foreach( $seeds as $seed ){

			list( $seed_type, $seed_hook ) = explode( "_", $seed );
			$seed_data = $this->loader->artist->select(["ID"=>$seed_hook]);
			if ( $seed_type == "artist" ){
				$seed_related_from_spotify = $this->loader->spotify->get_artist_related_artists( $seed_data["spotify_id"] );
				if ( !empty( $seed_related_from_spotify[0] ) && !empty( $seed_related_from_spotify[1] ) ){
					shuffle( $seed_related_from_spotify[1] );
					foreach( array_slice( $seed_related_from_spotify[1], 0, 3 ) as $_new_seed ){
						$_new_seed_data = $this->loader->artist->select(["spotify_id"=>$_new_seed["ID"]]);
						if ( !empty( $_new_seed_data ) ? !in_array( "artist_{$_new_seed_data["ID"]}", $seeds ) : false ){
							$seeds[] = "artist_{$_new_seed_data["ID"]}";
						}
					}
				}
			}

		}

		$_SESSION["play_radio_seeds"] = implode( ",", $seeds );

	}

	public function is_download_able( $ID ){

		if ( !$this->loader->visitor->user()->has_access( "group", "download" ) )
			return false;

		return true;

	}
	public function remove( $ID ){

		$data = $this->select([ "ID" => $ID ]);
		if ( !empty( $data["cover_o"] ) )
		$this->loader->general->remove_file( $data["cover_o"] );

		$this->loader->db->query("DELETE FROM _user_playlists WHERE ID = '{$ID}' ");
		$this->loader->db->query("DELETE FROM _user_playlists_relations WHERE playlist_id = '{$ID}' ");
		$this->loader->db->query("DELETE FROM _user_relations WHERE rel_type = '12' AND target_id = '{$ID}' ");
		$this->loader->db->query("DELETE FROM _user_actions WHERE type = 12 AND hook = '{$ID}' ");
		$this->loader->db->query("DELETE FROM _user_actions WHERE type = 11 AND hook = '{$ID}' ");
		$this->loader->db->query("DELETE FROM _user_actions WHERE type = 13 AND hook = '{$ID}' ");
		$this->loader->db->query("DELETE FROM _user_actions WHERE type = 15 AND hook = '{$ID}' ");

	}
	public function edit( $ID, $new_data ){

		$data = $this->select([ "ID" => $ID, "_eg" => [ "collabs" ] ]);
		extract( array_merge( $data, $new_data ) );

		// name  changed
		if ( $name != $data["name"] ){

			// new url
			$url = $this->loader->ui->murl(
				"playlist",
				$name,
				$ID
			);

			$this->loader->db->_update([
				"table" => "_user_playlists",
				"set" => [
					[ "name", $name ],
					[ "url", $url ]
				],
				"where" => [
					[ "ID", "=", $ID ]
				]
			]);

		}

		// cover changed
		if ( $cover != $data["cover_o"] ){
			$this->loader->db->_update([
				"table" => "_user_playlists",
				"set" => [
					[ "cover", $cover ],
				],
				"where" => [
					[ "ID", "=", $ID ]
				]
			]);
		}

		// collabs
		if ( !empty( $collabs ) OR !empty( $data["collabs"] ) ){

			if ( !empty( $collabs ) ){
				foreach( $collabs as $_collab ){
					if ( $data["collabs"] ? !in_array( $_collab["ID"], array_keys( $data["collabs"] ) ) : true ){
						// new collab
						$this->loader->visitor->user()->add_log([
							"type" => 24,
							"hook" => $data["ID"],
							"user_id" => $_collab["ID"],
							"user_id_2" => $data["user_id"] ? $data["user_id"] : null,
						]);
						$this->loader->visitor->user()->add_log([
							"type" => 25,
							"hook" => $data["ID"],
							"user_id" => null,
							"user_id_2" => $_collab["ID"],
							"AID" => $data["user_id"]
						]);
						$this->loader->db->query("INSERT INTO _user_relations ( user_id, rel_type, target_id ) VALUES ( '{$_collab["ID"]}', '24', '{$data["ID"]}' ) ");
					}
				}
			}
			if ( !empty( $data["collabs"] ) ){
				foreach( $data["collabs"] as $_collab ){
					if ( !empty( $new_data["collabs"] ) ? !in_array( $_collab["ID"], array_keys( $new_data["collabs"] ) ) : true ){
						// removed collab
						$this->loader->visitor->user()->remove_log([
							"type" => 24,
							"hook" => $data["ID"],
							"user_id" => $_collab["ID"],
							"user_id_2" => $data["user_id"] ? $data["user_id"] : null,
						]);
						$this->loader->visitor->user()->remove_log([
							"type" => 25,
							"hook" => $data["ID"],
							"user_id" => null,
							"user_id_2" => $_collab["ID"],
							"AID" => $data["user_id"]
						]);
						$this->loader->db->query("DELETE FROM _user_relations WHERE user_id = '{$_collab["ID"]}' AND rel_type = '24' AND target_id = '{$data["ID"]}' ");
					}
				}
			}

		}

	}

}

?>
