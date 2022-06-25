<?php

if ( !defined( "root" ) ) die;

class album {

	public $types = [ 'single', 'mixtape', 'compilation', 'studio' ];
	public function __construct( $loader ){

		$this->loader = $loader;
		$this->db = $loader->db;

	}

	public function verify_args( $args ){

		if ( empty( $args["title"] ) ) return "title";
		if ( empty( $args["cover"] ) ) return "cover";
		if ( empty( $args["type"] ) ) return "type";
		if ( empty( $args["time"] ) ) return "time";
		if ( empty( $args["artist_name"] ) ) return "artist_name";
		if ( empty( $args["genre"] ) ) return "genre";

		$args['cover']        = !empty( $args['cover'] ) ? $this->loader->general->addr_to_path( $args['cover'] ) : null;
		$args['spotify_ID']   = !empty( $args['spotify_ID'] ) ? $args['spotify_ID'] : null;
		$args['spotify_hits'] = !empty( $args['spotify_hits'] ) ? $args['spotify_hits'] : null;
		$args['genre_id']     = $this->loader->genre->return_valid( $args['genre'], "ID" );
		$args['time']         = !empty( $args['time'] ) ? $this->loader->general->strtotime( $args['time'] )[0] : null;
		$args['code']         = !empty( $args['code'] ) ? $args['code'] : $this->loader->general->make_code( $args['artist_name'] . $args['title'] );
		$args['comment']      = !empty( $args['comment'] ) ? $this->loader->general->json_encode( strip_tags( $args['comment'], "<b>" ) ) : null;

		if ( strtolower( $args["artist_name"] ) == "various artists" )
			$args["type"] = "compilation";

		if ( $args["type"] == "compilation" )
			$args["artist_name"] = "various artists";

		return $args;

	}
	public function select_by_code( $code ){

		return $this->select(["code"=>$code]);

	}
	public function select_by_id( $id ){

		return $this->select(["spotify_id"=>$id]);

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
		$spotify_id = null;
		$artist_id  = null;
		$user_id    = null;
		$genre      = null;
		$genres     = [];
		$hash       = null;
		$local      = null;
		$types      = [ "mixtape", "studio", "hack" ];
		$type       = null;
		$priced     = null;

		$_sq = null;

		// Get from sister tables
		$_eg = [];

		extract( $args );

		// ShortCodes
		if ( $order_by == "play_full_m" || $order_by == "play_skip_m" )
			$where[] = [ "play_m", "=", $this->loader->general->month_string ];

		if ( !empty( $genres ) )
			$where[] = [ "genre_id", "IN", implode( ", ", $genres ), true ];

		if ( !empty( $genre ) ? $genre == 1 : false )
			$where[] = [
				"oper" => "OR",
				"cond" => [
				    [ "genre_id", "=", $genre ],
				    [ "genre_id", null, null, true ]
				]
			];
		else if ( !empty( $genre ) )
			$where[] = [ "genre_id", "=", $genre ];

		if ( !empty( $artist_id ) )
			$where[] = [ "artist_id", "=", $artist_id ];

		if ( !empty( $user_id ) )
			$where[] = [ "user_id", "=", $user_id ];

		if ( !empty( $types ) ? is_array( $types ) && empty( array_diff( $types, $this->types ) ) : false )
		    $where[] = [ "type", "IN", "'" . implode( "' ,'", $types ) . "'", true ];

		if ( !empty( $type ) ? in_array( $type, $this->types ) : false )
			$where[] = [ "type", "=", $type ];

		if ( $_sq )
			$where[] = [ "code", "LIKE%", $this->loader->general->make_code( $_sq ) ];

		if ( $local === true || $local === 1 )
			$where[] = [ "local", "=", "1" ];

		if ( $local === false || $local === 0 )
			$where[] = [
				"oper" => "OR",
				"cond" => [
				    [ "local", "=", "0" ],
				    [ "local", null, null, true ]
			    ]
			];

		if ( $priced === true or $priced === 1 )
	    	$where[] = [ "price", ">", 0 ];

		if ( $priced === false or $priced === 0 )
			$where[] = [
				"oper" => "OR",
				"cond" => [
				    [ "price", "=", "0" ],
				    [ "price", null, null, true ]
			    ]
			];

		if ( !empty( $ID ) )             $where[] = [ "ID", "=", $ID ];
		elseif ( !empty( $code ) )       $where[] = [ "code", "=", $code ];
		elseif ( !empty( $hash ) )       $where[] = [ "hash", "=", $hash ];
		elseif ( !empty( $spotify_id ) ) $where[] = [ "spotify_id", "=",$spotify_id ];

		$args = array(

			"table"    => "_m_albums",
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

			$__i["title"] = $this->loader->secure->escape( $__i["title"] );
			$__i["artist_name"] = $this->loader->secure->escape( $__i["artist_name"] );

			$__i["year"]       = !empty( $__i["time_release"] ) ? substr( $__i["time_release"], 0, 4 ) : null;
			$__i["cover_o"]    = $__i["cover"];
			$__i["cover_addr"] = !empty( $__i["cover"] ) ? $this->loader->general->path_to_addr( $__i["cover"] ) : null;
			$__i["comment"]    = !empty( $__i["comment"] ) ?  $this->loader->secure->escape( str_replace( PHP_EOL, "<BR>", $this->loader->general->json_decode( $__i["comment"] ) ) ) : null;
			$__i["genre_id"]   = !$__i["genre_id"] ? 1 : $__i["genre_id"];
			$__i["genre"]      = $this->loader->genre->select(["ID"=>$__i["genre_id"]]);

			foreach( [ "download_able", "paid" ] as $__evn ){
				if ( in_array( $__evn, $_eg ) ){
					$__fn = "is_{$__evn}";
					$__i["is_{$__evn}"] = $this->$__fn( $__i );
				}
			}

      if ( in_array( "liked", $_eg, true ) ){
				$__i["liked"] = $this->loader->visitor->user()->check_log( 14, $__i["ID"] );
			}

			if ( in_array( "artist", $_eg ) ){
				$__i["artist"] = $this->loader->artist->select(["ID"=>$__i["artist_id"]]);
			}

			$__results[$__i["ID"]] = $__i;

		}

		return $limit == 1 && $singular ? reset( $__results ) : $__results;

	 }
	public function create( $args ){

		if ( empty( $args ) ) return false;
		$args = $this->verify_args( $args );
		if ( !$args ) return false;

		$exists = $this->select_by_code( $args["code"] );
		if ( !empty( $exists ) )
			return array_merge( $exists, [ "from_db" => true ] );

		if ( !empty( $spotify_ID ) ){
			$exists_id = $this->select_by_id( $spotify_ID );
			if ( !empty( $exists_id ) )
				return array_merge( $exists_id, [ "from_db" => true ] );
		}

		$code = null;
		$title = null;
		$cover = null;
		$type = null;
		$price = null;
		$time = null;
		$spotify_ID = null;
		$spotify_hits = null;
		$genre = null;
		$user_id = null;
		$artist_name = null;
		$tracks_count = null;
		$tracks_duration = null;
		$comment = null;
		$hash = null;
		extract( $args );

		$hash = !empty( $hash ) ? $hash : md5( microtime(true) . $artist_name . $title );
		$cover = !empty( $cover ) ? $this->loader->general->addr_to_path( $cover ) : $cover;
		$spotify_ID = !empty( $spotify_ID ) ? $spotify_ID : null;
		$spotify_hits = !empty( $spotify_hits ) ? $spotify_hits : null;
		$artist_data = $this->loader->artist->create( [ "name" => $artist_name ] );
		$artist_id = $artist_data["ID"];
		$artist_url = $artist_data["url"];

		if ( $cover ? count(explode(root,$cover))>1 && preg_match("/uploading/",$cover) : false ){
			$cover_dir = $this->loader->general->mkdir( $this->loader->general->image_dir . "/covers/" );
			copy( $cover, $cover_dir . "/" . pathinfo( $cover, PATHINFO_BASENAME ) );
			$cover = realpath( $cover_dir . "/" . pathinfo( $cover, PATHINFO_BASENAME ) );
		}

		$stmt = $this->db->prepare("INSERT INTO _m_albums ( type, code, hash, title, comment, artist_id, artist_name, artist_url, genre_id, spotify_id, spotify_hits, cover, tracks_count, tracks_duration, time_release, price, user_id ) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? )");
		$stmt->bind_param( "sssssssssssssssss", $type, $code, $hash, $title, $comment, $artist_id, $artist_name, $artist_url, $genre_id, $spotify_ID, $spotify_hits, $cover, $tracks_count, $tracks_duration, $time, $price, $user_id );
		$stmt->execute();
		$ID = $stmt->insert_id;
		$stmt->close();

		$url = $this->loader->ui->murl(
			"album",
			"{$artist_name}-{$title}",
			$ID
		);

		$stmt = $this->db->prepare("UPDATE _m_albums SET url = ? WHERE ID = ?");
		$stmt->bind_param( "ss", $url, $ID );
		$stmt->execute();
		$stmt->close();

		return [ "ID" => $ID, "artist_id" => $artist_id, "artist_url" => $artist_url, "spotify_id" => $spotify_ID, "url" => $url ];

	}

	public function mark_local( $ID ){

		if ( !is_int( $ID ) && !ctype_digit( $ID ) ) return;
		$this->db->query("UPDATE _m_albums SET local = 1 WHERE ID = '{$ID}' ");

	}
	public function recount_tracks( $ID ){

		if ( !is_int( $ID ) && !ctype_digit( $ID ) ) return;
		$get_tracks = $this->db->query("SELECT COUNT(*) as c,SUM(duration) as d FROM _m_tracks WHERE album_id = '{$ID}' ")->fetch_assoc();
		$this->db->query("UPDATE _m_albums SET tracks_count = '{$get_tracks["c"]}', tracks_duration = '{$get_tracks["d"]}' WHERE ID = '{$ID}' ");

	}

	public function is_paid( $ID ){

		$album_data = is_array( $ID ) ? $ID : $this->select(["ID"=>$ID]);

		// Free music
		if ( empty( $album_data["price"] ) )
			return true;

		if ( !empty( $this->loader->user ) ){

			// Paid user
		    if ( $this->loader->visitor->user()->paid )
			    return true;

			// Premium user
		    if ( $this->loader->visitor->user()->has_access( "group", "premium" ) )
			    return true;

			// Owner
			if ( $this->loader->visitor->user()->ID == $album_data["user_id"] )
				return true;

		    // Bought song
		    if ( $this->db->query("SELECT 1 FROM _user_purchases WHERE item_type = 'album' AND user_id = '{$this->loader->visitor->user()->ID}' AND item_id = '{$album_data["ID"]}' ")->num_rows ? true : false )
			    return true;

		}

		return false;

	}
	public function is_download_able( $ID ){

		$album_id = is_array( $ID ) ? $ID["ID"] : $ID;
		$album_data = is_array( $ID ) ? $ID : $this->select(["ID"=>$ID]);

		if ( !$this->is_paid( $album_data ) )
			return false;

		if ( !$album_data["local"] )
			return false;

		if ( !$this->loader->visitor->user()->has_access( "group", "download" ) )
			return false;

		if ( $album_data["price"] ){

			if ( !$this->loader->visitor->user()->ID )
				return false;

		}

		return true;

	}

	public function remove( $ID, $new_album_ID ){

		$data = is_array( $ID ) ? $ID : $this->select(["ID"=>$ID]);
		$new_album = $new_album_ID ? ( is_array( $new_album_ID ) ? $new_album_ID : $this->select(["ID"=>$ID]) ) : false;

		// remove from _m_albums
		$this->db->query("DELETE FROM _m_albums WHERE ID = '{$data["ID"]}' ");

		$tracks = $this->loader->track->select(["album_id"=>$data["ID"],"limit"=>100]);
		if ( !empty( $tracks ) ) {
			foreach( $tracks as $__t ){

				if ( $new_album ){

					$edit = $this->loader->track->edit( $__t["ID"], array(
						"album_id" => $new_album["ID"],
						"album_title" => $new_album["title"],
						"album_url" => $new_album["url"],
						"album_artist_id" => $new_album["artist_id"],
						"album_artist_name" => $new_album["artist_name"],
						"album_artist_url" => $new_album["artist_url"],
					) );

					if ( $edit !== true ) return $edit;

				} else {

					$this->loader->track->remove( $__t );

				}

			}
		}

		if ( $new_album ) $this->loader->album->recount_tracks( $new_album["ID"] );

		// remove cover
		if ( !empty( $data["cover_o"] ) )
		$this->loader->general->remove_file( $data["cover_o"] );

		// remove from user tables
		$this->db->query("DELETE FROM _user_purchases WHERE item_type = 'album' AND item_id = '{$data["ID"]}' ");
		$this->db->query("DELETE FROM _user_actions WHERE type IN ( 14,20 ) AND hook = '{$data["ID"]}' ");

	}
	public function edit( $ID, $new_data ){

		$data = is_array( $ID ) ? $ID : $this->select(["ID"=>$ID]);
		extract( array_merge( $data, $new_data ) );

		$price = $price ? $price : 0;
		$genre_id = !empty( $genre_id ) ? $genre_id : $this->loader->genre->select(["name"=>$genre])["ID"];
		$comment = !empty( $comment ) ? json_encode( str_replace( [ "\r\n", "\n", PHP_EOL ], "<br>", $comment ) ) : "";

		// Changed album code?
		if ( $data["title"] != $title ||
			$data["artist_name"] != $artist_name ){

			// new code
        	$code = $this->loader->general->make_code( $artist_name . $title );

			if ( !empty( $this->select(["code"=>$code] ) ) ){
				return "album_{$code}_exists";
			}

        	// new url
        	$url = $this->loader->ui->murl(
				"album",
				"{$artist_name}-{$title}",
				$ID
			);

		}

		// Changed album artist?
		if ( $data["artist_name"] != $artist_name ){
			$artist_data = $this->loader->artist->create(["name"=>$artist_name]);
			$artist_id = $artist_data["ID"];
			$artist_url = $artist_data["url"];
		}

		// Update track table itself
		$stmt = $this->db->prepare("UPDATE _m_albums SET code=?, url=?, title=?, type=?, cover=?, comment=?, user_id=?, genre_id=?, artist_name=?, artist_id=?, artist_url=?, spotify_id=?, price=?, time_release=? WHERE ID=?");
		$stmt->bind_param( "sssssssssssssss", $code, $url, $title, $type, $cover, $comment, $user_id, $genre_id, $artist_name, $artist_id, $artist_url, $spotify_id, $price, $time_release, $ID );
		$stmt->execute();
		if ( !empty( $stmt->error ) ){
			trigger_error( $stmt->error, E_USER_ERROR );
			exit;
		}
		$stmt->close();

		// Change tracks albums data
		$tracks = $this->loader->track->select(["album_id"=>$ID,"limit"=>200,"singular"=>false,"_eg"=>["text_data","artists_featured_names"]]);
		if ( !empty( $tracks ) ){
			foreach( $tracks as $__t ){
				$edit = $this->loader->track->edit( $__t["ID"], array(
					"genre_id"          => $genre_id,
				    "album_title"       => $title,
				    "album_url"         => $url,
				    "album_artist_name" => $artist_name,
				    "album_artist_id"   => $artist_id,
				    "album_artist_url"  => $artist_url,
					"cover"             => $cover,
			    ) );
				if ( $edit !== true ) return $edit;
			}
		}

		$this->loader->album->recount_tracks( $ID );

		return true;

	}

}

?>
