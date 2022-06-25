<?php

if ( !defined( "root" ) ) die;

class artist {

	public function __construct( $loader ){

		$this->loader = $loader;
		$this->db = $loader->db;

	}

	public function verify_args( $args ){

		if ( empty( $args["name"] ) ) return false;
		$args['spotify_ID']   = !empty( $args['spotify_ID'] )   ? $args['spotify_ID']   : null;
		$args['spotify_hits'] = !empty( $args['spotify_hits'] ) ? $args['spotify_hits'] : null;
		$args['code']         = !empty( $args['code'] ) ? $args['code'] : $this->loader->general->make_code( $args['name'] );
		return $args;

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
		$ID         = null;
		$code       = null;
		$name       = null;
		$hash       = null;
		$spotify_id = null;
		$_sq        = null;
		$is_user    = null;

		$_eg = [];

		extract( $args );
		$code = $code ? $code : ( $name ? $this->loader->general->make_code( $name ) : null );

		// ShortCodes
		if ( $order_by == "play_full_m" || $order_by == "play_skip_m" )
			$where[] = [ "play_m", "=", $this->loader->general->month_string ];

		if ( $_sq )
	    	$where[] = [ "code", "LIKE%", $this->loader->general->make_code( $_sq ) ];

		if ( $is_user === true )
	    	$where[] = [ "user_id", ">", 0 ];

		if ( $is_user === false )
			$where[] = [
				"oper" => "OR",
				"cond" => [
				    [ "user_id", "=", "0" ],
				    [ "user_id", null, null, true ]
			    ]
			];

		if ( !empty( $ID ) )             $where[] = [ "ID", "=", $ID ];
		elseif ( !empty( $code ) )       $where[] = [ "code", "=", $code ];
		elseif ( !empty( $hash ) )       $where[] = [ "hash", "=", $hash ];
		elseif ( !empty( $spotify_id ) ) $where[] = [ "spotify_id", "=",$spotify_id ];

		$args = array(

			"table"    => "_m_artists",
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

			$__i["name"] = $this->loader->secure->escape( $__i["name"] );
			$__i["image_o"] = $__i["image"];
			$__i["image"] = !empty( $__i["image"] ) ? $this->loader->general->path_to_addr( $__i["image"] ) : $this->loader->admin->get_setting("web_addr") . "/themes/__default/assets/icons/artist.png";

			if ( in_array( "followed", $_eg, true ) ){
				$__i["followed"] = $this->loader->user->rel_exists( 10, $__i["ID"] );
			}

			$__results[$__i["ID"]] = $__i;

		}

		return $limit == 1 ? reset( $__results ) : $__results;

	}
	public function create( $args ){

		if ( empty( $args ) ) return false;
		$args = $this->verify_args( $args );

		$name = null;
		$code = null;
		$spotify_ID = null;
		$spotify_hits = null;
		$image = null;
		extract( $args );

		$exists = $this->select( [ "code" => $code ] );
		if ( !empty( $exists ) ){
			return $exists;
		}

		// Search for artist in Spotify ( if allowed )
		if ( $this->loader->admin->get_setting( "spotify_d_a", 1, [ 0, 1 ] ) ){
			$spotify_data = $this->loader->spotify->search_artist( $name );
			if ( $spotify_data[0] ){
				$spotify_ID   = $spotify_data[1]["ID"];
				$spotify_hits = $spotify_data[1]["popularity"];
				if ( !empty( $spotify_data[1]["image"] ) ){
					$image = $spotify_data[1]["image"];
					if ( $this->loader->admin->get_setting( "spotify_upload_d", 1, [ 0, 1 ] ) ){
						$image = $this->loader->spotify->save_image( $image, [ "dirname" => "spotify_artists", "basename" => $this->loader->general->uploading_dir ] );
						$image = $this->loader->image->set( $image )->square(["remove_src"=>true])->get(["dirname"=>"artists"]);
					}
				}
			}
		}

		// Make DB data
		$stmt = $this->db->prepare("INSERT INTO _m_artists ( code, name, spotify_id, spotify_hits, image ) VALUES ( ?, ?, ?, ?, ? )");
		$stmt->bind_param( "sssss", $code, $name, $spotify_ID, $spotify_hits, $image );
		$stmt->execute();
		$ID = $stmt->insert_id;
		$stmt->close();

		// Make URL
		$url = $this->loader->ui->murl(
			"artist",
			$name,
			$ID
		);

		// Update DB data with made url
		$stmt = $this->db->prepare("UPDATE _m_artists SET url = ? WHERE ID = ?");
		$stmt->bind_param( "ss", $url, $ID );
		$stmt->execute();
		$stmt->close();

		return [ "ID" => $ID, "url" => $url ];

	}
	public function select_others( $args ){

		$track_id = null;
		$ids = null;
		extract( $args );

		$other_artists = [];
		if ( !empty( $ids ) ){
			foreach( $ids as $artist_featured ){
				$other_artists[] = $this->select(["ID"=>$artist_featured]);
			}
		}

		return $other_artists;

	}

	public function make_rel( $artist_id, $track_id, $type ){

		if ( empty( $artist_id ) || empty( $track_id ) || empty( $type ) ) return false;
		if ( ( !ctype_digit( $artist_id ) && !is_int( $artist_id ) ) || ( !ctype_digit( $track_id ) && !is_int( $track_id ) ) ) return false;
		if ( !is_string( $type ) ) return false;

		$stmt = $this->db->prepare("INSERT INTO _m_relations ( ID1, ID2, type ) VALUES ( ?, ?, ? )");
		$stmt->bind_param( "sss", $artist_id, $track_id, $type );
		$stmt->execute();
		$stmt->close();

	}
	public function trigger_update( $artist_id, $time ){

		$time = is_string( $time ) ? strtotime( $time ) : $time;
		$data = $this->select(["ID"=>$artist_id]);
		if ( empty( $data ) ) return false;

		// reently updated?
		if ( time() - $time < 6*60*60 || strtotime( $data["time_release"] ) > $time )
		return false;

		// check update
		$this->loader->db->_update([
			"table" => "_m_artists",
			"set"   => [
				[ "time_release", "now()", true ],
			],
			"where" => [
				[ "ID", "=", $artist_id ]
			]
		]);

		// notify subs
		$subs = $this->loader->user->get_subs( 10, $artist_id );
		if ( !empty( $subs ) ){
			foreach( $subs as $sub ){
				$this->loader->user->add_log([
					"user_id" => null,
					"user_id_2" => $sub,
					"type" => 16,
					"hook" => $artist_id
				]);
			}
		}

	}

	public function remove( $ID, $new_artist_ID ){

		$data = is_array( $ID ) ? $ID : $this->select(["ID"=>$ID]);
		$new_artist = $new_artist_ID ? ( is_array( $new_artist_ID ) ? $new_artist_ID : $this->select(["ID"=>$ID]) ) : false;

		// remove from _m_artists
		$this->db->query("DELETE FROM _m_artists WHERE ID = '{$data["ID"]}' ");

		// move/remove albums
		$albums = $this->loader->album->select(["artist_id"=>$data["ID"],"limit"=>100,"singular"=>false]);
		if ( !empty( $albums ) ){
			foreach( $albums as $__a ){

				if ( $new_artist ){

					$edit = $this->loader->album->edit( $__a["ID"], array(
						"artist_id"    => $new_artist["ID"],
						"artist_name"  => $new_artist["name"],
						"artist_url"   => $new_artist["url"],
					) );

					if ( $edit !== true ) return $edit;

				} else {

					$this->loader->album->remove( $__a, 0 );

				}

			}
		}

		// move/remove tracks
		$tracks = $this->loader->track->select(["artist_id"=>$data["ID"],"limit"=>100,"singular"=>false]);
		if ( !empty( $tracks ) ){
			foreach( $tracks as $__t ){

				if ( $new_artist ){

					$edit = $this->loader->track->edit( $__t["ID"], array(
						"artist_id"    => $new_artist["ID"],
						"artist_name"  => $new_artist["name"],
						"artist_url"   => $new_artist["url"],
					) );

					if ( $edit !== true ) return $edit;

				} else {

					$this->loader->track->remove( $__t );

				}

			}
		}

		// remove cover
		if ( !empty( $data["image_o"] ) )
		$this->loader->general->remove_file( $data["image_o"] );

		// remove featured-artists relation
		$this->db->query("DELETE FROM _m_relations WHERE type = 'featured' AND ID1 = '{$data["ID"]}' ");
		$this->db->query("DELETE FROM _user_actions WHERE type IN ( 10,16 ) AND hook = '{$data["ID"]}' ");

	}
	public function edit( $ID, $new_data ){

		$data = is_array( $ID ) ? $ID : $this->select(["ID"=>$ID]);
		extract( array_merge( $data, $new_data ) );

		$image = preg_match("/__default/",$image) ? null : $image;

		// Changed artist code?
		if ( $data["name"] != $name ){

			// new code
        	$code = $this->loader->general->make_code( $name );

			if ( !empty( $this->select(["code"=>$code] ) ) ){
				return "artist_{$code}_exists";
			}

        	// new url
        	$url = $this->loader->ui->murl(
				"artist",
				$name,
				$ID
			);

		}

		// Update artist table itself
		$stmt = $this->db->prepare("UPDATE _m_artists SET code=?, name=?, url=?, spotify_id=?, image=? WHERE ID=?");
		$stmt->bind_param( "ssssss", $code, $name, $url, $spotify_id, $image, $ID );
		$stmt->execute();
		$stmt->close();

		// Change albums data
		$albums = $this->loader->album->select(["artist_id"=>$ID,"limit"=>100,"singular"=>false]);
		if ( !empty( $albums ) ){
			foreach( $albums as $__a ){

				$edit = $this->loader->album->edit( $__a["ID"], array(
					"artist_id"    => $ID,
					"artist_name"  => $name,
					"artist_url"   => $url,
				) );
				if ( $edit !== true ) return $edit;

			}
		}

		// move/remove tracks
		$tracks = $this->loader->track->select(["artist_id"=>$ID,"limit"=>100,"singular"=>false,"_eg"=>["text_data","artists_featured_names"]]);
		if ( !empty( $tracks ) ){
			foreach( $tracks as $__t ){

				$edit = $this->loader->track->edit( $__t["ID"], array(
					"artist_id"    => $ID,
					"artist_name"  => $name,
					"artist_url"   => $url,
				) );
				if ( $edit !== true ) return $edit;

			}
		}

		return true;

	}

}

?>
