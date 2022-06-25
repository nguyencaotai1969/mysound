<?php

if ( !defined( "root" ) ) die;

class track {

	public function __construct( $loader ){

		$this->loader = $loader;
		$this->db = $loader->db;

	}

	public function verify_args( $args ){

		if ( empty( $args["title"] ) ) return "title";
		if ( empty( $args["genre"] ) ) return "genre";
		if ( empty( $args["artist_name"] ) ) return "artist_name";

		if ( empty( $args["album_title"] ) ) return "album_title";
		if ( empty( $args["album_artist_name"] ) ) return "album artist_name";
		if ( empty( $args["album_type"] ) ) return "album_type";
		if ( empty( $args["album_time"] ) ) return "album_time";
		if ( empty( $args["album_cover"] ) ) return "album_cover";
		if ( empty( $args["album_genre"] ) ) return "album_genre";

		$args['cover']        = !empty( $args['album_cover'] ) ? $this->loader->general->addr_to_path( $args['album_cover'] ) : null;
		$args['spotify_ID']   = !empty( $args['spotify_ID'] ) ? strtolower( $args['spotify_ID'] ) : null;
		$args['spotify_hits'] = !empty( $args['spotify_hits'] ) ? $args['spotify_hits'] : null;
		$args['genre_id']     = $this->loader->genre->return_valid( $args['genre'], "ID" );
		$args['time']         = !empty( $args['album_time'] ) ? $this->loader->general->strtotime( $args['album_time'] )[0] : null;
		$args['code']         = !empty( $args['code'] ) ? $args['code'] : $this->loader->general->make_code( $args['album_artist_name'] . $args['album_title'] . $args['title'] );

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
		$spotify_id = null;
		$album_id   = null;
		$artist_id  = null;
		$user_id    = null;
		$genre      = null;
		$hash       = null;
		$priced     = null;
		$local      = null;
		$reported   = false;

		$_sq        = null;

		// Where sister tables
		$ft_artist_id = null;
		$playlist_id  = null;

		// Get from sister tables
		$_eg = [];

		extract( $args );

		// ShortCodes
		if ( $order_by == "play_full_m" || $order_by == "play_skip_m" )
			$where[] = [ "play_m", "=", $this->loader->general->month_string ];

		if ( !empty( $genre ) )
			$where[] = [ "genre_id", "=", $genre ];

		if ( !empty( $album_id ) )
			$where[] = [ "album_id", "=", $album_id ];

		if ( !empty( $artist_id ) )
			$where[] = [ "artist_id", "=", $artist_id ];

		if ( !empty( $user_id ) )
			$where[] = [ "user_id", "=", $user_id ];

		if ( !empty( $playlist_id ) ? ctype_digit( $playlist_id ) || is_int( $playlist_id ) : false ){
			$_tracks_ids_raw = $this->db->_select(["table"=>"_user_playlists_relations","where"=>[["playlist_id","=",$playlist_id]],"limit"=>1000,"columns"=>"track_id","order_by"=>"sort","order"=>"ASC"]);
			if ( empty( $_tracks_ids_raw ) ) return false;
			foreach( $_tracks_ids_raw as $_track_id_raw )
			$_tracks_ids[] = $_track_id_raw["track_id"];
			$where[] = [ "ID", "IN", implode( ",", $_tracks_ids ), true ];
			$order_by = "FIELD(id,".implode(",",array_reverse($_tracks_ids)).")";
		}

		if ( !empty( $ft_artist_id ) )
			$where[] = [ "ID", "IN", "SELECT ID2 FROM _m_relations WHERE ID1 = '{$ft_artist_id}' AND type = 'featured'", true ];

		if ( $local === true || $local === 1 )
			$where[] = [ "local", "=", "1" ];

		if ( $reported )
	  	$where[] = [ "ID", "IN", "SELECT hook FROM _user_reports WHERE type = 1 AND dismissed IS NULL", true ];

		if ( $_sq )
	    	$where[] = [ "code", "LIKE%", $this->loader->general->make_code( $_sq ) ];

		if ( $local === false || $local === 0 )
			$where[] = [
				"oper" => "OR",
				"cond" => [
				    [ "local", "=", "0" ],
				    [ "local", null, null, true ]
			    ]
			];

		if ( $priced === true )
	    	$where[] = [ "price", ">", 0 ];

		if ( $priced === false )
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

			"table"    => "_m_tracks",
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
			$__i["album_title"] = $this->loader->secure->escape( $__i["album_title"] );
			$__i["artist_name"] = $this->loader->secure->escape( $__i["artist_name"] );
			$__i["album_artist_name"] = $this->loader->secure->escape( $__i["album_artist_name"] );

			$__i["artists_featured"] = json_decode( $__i["artists_featured"], 1 );
			$__i["cover_o"]          = $__i["cover"];
			$__i["cover_addr"]       = !empty( $__i["cover"] ) ? $this->loader->general->path_to_addr( $__i["cover"] ) : null;
			$__i["duration_hr"]      = !empty( $__i["duration"] ) ? $this->loader->general->hr_seconds( $__i["duration"] ) : null;
			$__i["price_hr"]         = !empty( $__i["price"] ) ? $this->loader->general->display_price( $__i["price"], true ) : "<i>".$this->loader->lorem->turn( "free", [ "uc" => 1 ] )."</i>";

			foreach( [ "liked","commented","reposted","playlisted","paid","download_able" ] as $__evn ){
				if ( in_array( $__evn, $_eg ) ){
					$__fn = "is_{$__evn}";
					$__i["is_{$__evn}"] = $this->$__fn( $__i );
				}
			}

			if ( in_array( "text_data", $_eg ) ){
				$__i["text_data"] = $this->select_data( $__i["ID"] );
			}

			if ( in_array( "genre", $_eg ) ){
				$__i["genre_data"] = $this->loader->genre->select(["ID"=>$__i["genre_id"]]);
				$__i["genre"] = $__i["genre_data"]["name"];
				$__i["genre_code"] = $__i["genre_data"]["code"];
			}

			if ( in_array( "artists_featured_names", $_eg ) ){
				$_oas = $this->loader->artist->select_others(["ids"=>$__i["artists_featured"]]);
				$__i["artists_featured"] = [];
				if ( !empty( $_oas ) ) {
					foreach( $_oas as $_oa ){
						$__i["artists_featured"][] = $_oa["name"];
					}
				}
			}

			if ( in_array( "artists_featured", $_eg ) ){
				$_oas = $this->loader->artist->select_others(["ids"=>$__i["artists_featured"]]);
				$__i["artists_featured"] = [];
				if ( !empty( $_oas ) ) {
					foreach( $_oas as $_oa ){
						$__i["artists_featured"][ $_oa["ID"] ] = $_oa;
					}
				}
			}

			if ( in_array( "artist", $_eg ) ){
				$__i["artist"] = $this->loader->artist->select(["ID"=>$__i["artist_id"]]);
			}

			$__results[ $__i["ID"] ] = $__i;

		}

		return $limit == 1 && $singular ? reset( $__results ) : $__results;

	}
	public function select_by_code( $code ){

		return $this->select(["code"=>$code]);

	}
	public function select_by_id( $id ){

		return $this->select(["spotify_id"=>$id]);

	}
	public function create( $args ){

		if ( empty( $args ) ) return false;
		$args = $this->verify_args( $args );

		$local = null;
		$has_source = null;
		$code = null;
		$title = null;
		$cover = null;
		$price = null;
		$comment = null;
		$lyrics = null;
		$explicit = null;
		$spotify_id = null;
		$spotify_hits = null;
        $youtube_id = null;
        $bandcamp_id = null;
        $itunes_url = null;
        $soundcloud_url = null;
        $sitelink = null;
		$time = null;
		$genre = null;
		$genre_id = null;
		$user_id = null;
		$artist_name = null;
		$artist_id = null;
		$artist_url = null;
		$artists_featured = null;
		$album_type = null;
		$album_order = null;
		$album_id = null;
		$album_title = null;
		$album_url = null;
		$album_artist_id = null;
		$album_artist_url = null;
		$album_artist_name = null;
		$duration = null;
		$download_link = null;
		$hash = null;
		extract( $args );

		$exists = $this->select_by_code( $args["code"] );
		if ( !empty( $exists ) )
			return array_merge( $exists, [ "from_db" => true ] );

		if ( !empty( $spotify_ID ) ){
			$exists_id = $this->select_by_id( $spotify_ID );
			if ( !empty( $exists_id ) )
				return array_merge( $exists_id, [ "from_db" => true ] );
		}

		$artists_featured_final = [];
		if ( !empty( $artists_featured ) ){
			$artists_featured = is_array( $artists_featured ) ? $artists_featured : explode( ";", $artists_featured );
			foreach( $artists_featured as $artist_featured ){
				if ( $this->loader->artist->verify_args([ "name" => $artist_featured ]) ){
					$artists_featured_final[] = $this->loader->artist->create([ "name" => $artist_featured ])["ID"];
				}
			}
		}
		$artists_featured_final_encoded = json_encode( $artists_featured_final );

		$hash = !empty( $hash ) ? $hash : md5( microtime(true) . $artist_id . $album_id . $title );
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

		$stmt = $this->db->prepare("INSERT INTO _m_tracks ( user_id, has_source, local, hash, code, title, cover, genre_id, artist_id, artist_name, artist_url, artists_featured, album_id, album_order, album_artist_id, album_title, album_url, album_artist_name, album_artist_url, spotify_id, spotify_hits, explicit, time_release, duration, price, youtube_id, bandcamp_id, soundcloud_url, itunes_url, sitelink, dl_link ) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? )");
		$stmt->bind_param( "sssssssssssssssssssssssssssssss", $user_id, $has_source, $local, $hash, $code, $title, $cover, $genre_id, $artist_id, $artist_name, $artist_url, $artists_featured_final_encoded, $album_id, $album_order, $album_artist_id, $album_title, $album_url, $album_artist_name, $album_artist_url, $spotify_ID, $spotify_hits, $explicit, $time, $duration, $price, $youtube_id, $bandcamp_id, $soundcloud_url, $itunes_url, $sitelink, $download_link );
		$stmt->execute();
		if ( !empty( $stmt->error ) ){
			trigger_error( $stmt->error, E_USER_ERROR );
			exit;
		}
		$ID = $stmt->insert_id;
		$stmt->close();

		if ( $comment || $lyrics ? is_string( $comment ) || is_string( $lyrics ) : false ){

			$comment = is_string( $comment ) ? $this->loader->general->json_encode( strip_tags( $comment, "<b>" ) ) : null;
			$lyrics  = is_string( $lyrics )  ? $this->loader->general->json_encode( strip_tags( $lyrics , "<b>" ) ) : null;

			$stmt = $this->db->prepare("INSERT INTO _m_tracks_data ( track_id, comment, lyrics ) VALUES ( ?, ?, ? )");
			$stmt->bind_param( "sss", $ID, $comment, $lyrics );
			$stmt->execute();
			$stmt->close();

		}

		$url = $this->loader->ui->murl(
			"track",
			"{$artist_name}-{$title}",
			$ID
		);

		$stmt = $this->db->prepare("UPDATE _m_tracks SET url = ? WHERE ID = ?");
		$stmt->bind_param( "ss", $url, $ID );
		$stmt->execute();
		$stmt->close();

		if ( !empty( $artists_featured_final ) ){
			foreach( $artists_featured_final as $artist_featured ){
				$this->loader->artist->make_rel( $artist_featured, $ID, "featured" );
			}
		}

		$this->loader->artist->trigger_update( $artist_id, $time );

		return [
			"ID" => $ID,
			"artist_id" => $artist_id,
			"spotify_ID" => $spotify_ID,
			"album_id" => $album_id,
			"from_db" => false,
			"url" => $url
		];

	}

	public function create_data( $track_id, $comment, $lyrics ){

		$already_exists = $this->db->query("SELECT 1 FROM _m_tracks_data WHERE track_id = '{$track_id}' ")->num_rows ?  true : false;

		$comment = str_replace( PHP_EOL, "<BR>", $comment );
		$lyrics  = str_replace( PHP_EOL, "<BR>", $lyrics );

		$stmt = $already_exists ?
		$this->db->prepare("UPDATE _m_tracks_data SET comment = ?, lyrics = ? WHERE track_id = ?") :
		$this->db->prepare("INSERT INTO _m_tracks_data ( comment, lyrics, track_id ) VALUES ( ?, ?, ? )");
		$stmt->bind_param( "sss", $comment, $lyrics, $track_id );
		$stmt->execute();
		$stmt->close();

	}
	public function select_data( $track_id ){

		$data = $this->db->query("SELECT * FROM _m_tracks_data WHERE track_id = '{$track_id}' ");

		if ( !$data->num_rows ) return [
			"comment" => null,
			"lyrics"  => null
		];

		$rdata = $data = $data->fetch_assoc();

		$data["comment"] = $data["lyrics"]  = null;

		if ( $rdata["comment"] ){
			$data["comment"] = str_replace( PHP_EOL, "<BR>", $this->loader->general->json_decode( $rdata["comment"] ) );
			$data["comment"] = $this->loader->secure->escape( $rdata["comment"] );
			if ( substr( $data["comment"], 0, strlen( "&quot;" ) ) == "&quot;" ) $data["comment"] = substr( $data["comment"], strlen("&quot;"), -strlen("&quot;") );
		}

		if ( $rdata["lyrics"] ){
			$data["lyrics"] = str_replace( PHP_EOL, "<BR>", $this->loader->general->json_decode( $rdata["lyrics"] ) );
			$data["lyrics"] = $this->loader->secure->escape( $rdata["lyrics"] );
			if ( substr( $data["lyrics"], 0, strlen( "&quot;" ) ) == "&quot;" ) $data["lyrics"] = substr( $data["lyrics"], strlen("&quot;"), -strlen("&quot;") );
		}

		return $data;

	}

	public function mark_source( $ID ){

		if ( !is_int( $ID ) && !ctype_digit( $ID ) ) return;
		$this->db->query("UPDATE _m_tracks SET has_source = 1 WHERE ID = '{$ID}' ");

	}
	public function mark_local( $ID ){

		if ( !is_int( $ID ) && !ctype_digit( $ID ) ) return;
		$this->db->query("UPDATE _m_tracks SET local = 1 WHERE ID = '{$ID}' ");

	}
	public function is_paid( $ID ){

		$track_data = is_array( $ID ) ? $ID : $this->select(["ID"=>$ID]);

		// Free music
		if ( empty( $track_data["price"] ) )
			return true;

		if ( !empty( $this->loader->visitor->UID ) ){

			// Paid user
		    if ( $this->loader->visitor->user()->paid )
			    return true;

			// Premium user
		    if ( $this->loader->visitor->user()->has_access( "group", "premium" ) )
			    return true;

			// Owner
			if ( $this->loader->visitor->user()->ID == $track_data["user_id"] )
				return true;

		    // Bought song
		    if ( $this->db->query("SELECT 1 FROM _user_purchases WHERE item_type = 'song' AND user_id = '{$this->loader->visitor->user()->ID}' AND item_id = '{$track_data["ID"]}' ")->num_rows ? true : false )
			    return true;

			// Bought album
		    if ( $this->db->query("SELECT 1 FROM _user_purchases WHERE item_type = 'album' AND user_id = '{$this->loader->visitor->user()->ID}' AND item_id = '{$track_data["album_id"]}' ")->num_rows ?true:false )
			    return true;

		}

		return false;

	}
	public function is_download_able( $ID ){

		$track_id = is_array( $ID ) ? $ID["ID"] : $ID;
		$track_data = is_array( $ID ) ? $ID : $this->select(["ID"=>$ID]);

		if ( !$this->is_paid( $track_data ) )
			return false;

		if ( !$track_data["local"] && !$track_data["dl_link"] )
			return false;

		if ( !$this->loader->visitor->user()->has_access( "group", "download" ) )
			return false;

		if ( $track_data["price"] ){

			if ( !$this->loader->visitor->user()->ID )
				return false;

			$download_limit = $this->loader->admin->get_setting( "download_limit", 1  );
			if ( $download_limit ){

				$track_downloads = $this->db->query("SELECT 1 FROM _user_downloads WHERE user_id = '{$this->loader->visitor->user()->ID}' AND track_id = '{$track_id}' AND uses > 0 ")->num_rows;
				if ( $track_downloads >= $download_limit ) return false;

			}

		}

		return true;

	}
	public function is_liked( $ID ){

		$ID = is_array( $ID ) ? $ID["ID"] : $ID;

		return !$this->loader->visitor->user()->ID ? false : ( $this->loader->visitor->user()->check_log( 1, $ID ) ? true : false );

	}
	public function is_reposted( $ID ){

		return !$this->loader->visitor->user()->ID ? false : ( $this->loader->visitor->user()->check_log( 2, $ID["ID"] ) ? true : false );

	}
	public function is_commented( $ID ){

		return !$this->loader->visitor->user()->ID ? false : ( $this->loader->visitor->user()->check_log( 5, $ID["ID"] ) ? true : false );

	}
	public function is_playlisted( $ID ){

		return !$this->loader->visitor->user()->ID ? false : ( $this->loader->visitor->user()->check_log( 4, $ID["ID"] ) ? true : false );

	}

	public function get_comments( $ID, $liked_by_visitor_check = false ){

    $_eg = $liked_by_visitor_check ? "liked_by_visitor" : "";
		return $this->loader->comment->select([
			"target_id" => $ID,
			"limit"     => 100,
			"order_by"  => "likes",
			"_eg"       => [$_eg],
			"no_childs" => true
		]);

	}
	public function create_download_link( $ID ){

		$track_source = $this->loader->source->select([
			"track_id"  => $ID,
			"type"      => "files",
			"prefer_hq" => $this->loader->visitor->user()->has_access( "group", "hq_audio" ),
			"limit"     => 1
		]);

		if ( empty( $track_source ) ) return false;

		$track_data = $this->select([
			"ID" => $ID
		]);

		if ( empty( $track_data ) ) return false;

		if ( $track_source["type"] == "file_r" )
		return $this->loader->general->path_to_addr( $track_source["data"] );

		$keys = [];
		for( $i=1; $i<=4; $i++ ){
			$keys[$i] = substr( md5( uniqid() . microtime() . rand( 0,66666666666 ) ), 0, 12 );
		}

		$track_name = $this->loader->general->make_code( "{$track_data["artist_name"]} - {$track_data["title"]}", "\p{L}0-9 \-$._\[\]\(\)", 50 );
		$sessid = session_id();
		$_s_m = $this->loader->admin->get_setting( "download_range", 30 );
		$file_size = filesize( $track_source["data"] );
		$user_agent = $this->loader->secure->get( "server", "HTTP_USER_AGENT", "string" );

		$stmt = $this->db->prepare("INSERT INTO _user_downloads ( track_id, track_name, source_id, source_file, source_file_size, user_sess_id, user_id, user_ip, user_agent, key1, key2, key3, key4, time_expire ) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ADDDATE( now(), INTERVAL {$_s_m} MINUTE ) ) ");
		$stmt->bind_param( "sssssssssssss", $ID, $track_name, $track_source["ID"], $track_source["data"], $file_size, $sessid, $this->loader->visitor->user()->ID, $this->loader->hit->ip_data["ip"], $user_agent, $keys[1], $keys[2], $keys[3], $keys[4] );
		$stmt->execute();
		$stmt->close();

		return str_replace( [ "php?", "&" ], [ "php?key", "&key" ], $this->loader->ui->rurl( null, "download.php", http_build_query( $keys ) ) );

	}

	public function remove( $ID ){

		$data = is_array( $ID ) ? $ID : $this->select(["ID"=>$ID]);

		// remove from db
		$this->db->query("DELETE FROM _m_tracks WHERE ID = '{$data["ID"]}' ");

		// remove comments
		$comments = $this->loader->comment->select([
			"target_id" => $ID,
			"limit" => 1000
		]);

		if ( !empty( $comments ) ){
			foreach( $comments as $comment ){
				$this->loader->comment->delete( $comment["ID"] );
			}
		}

		// remove sources
		$source = $this->loader->source->select( [ "track_id" => $data["ID"], "limit" => 10 ] );
		if ( !empty( $source ) ){
			foreach( $source as $__s ){
				$this->loader->source->remove( $__s );
			}
		}

		// remove cover
		if ( !empty( $data["cover_o"]) )
		$this->loader->general->remove_file( $data["cover_o"] );

		// remove text data
		$this->db->query("DELETE FROM _m_tracks_data WHERE track_id = '{$data["ID"]}' ");

		// remove featured-artists relation
		$this->db->query("DELETE FROM _m_relations WHERE type = 'featured' AND ID2 = '{$data["ID"]}' ");

		// remove from user tables
		$this->db->query("DELETE FROM _user_actions WHERE type IN ( 1,2,3,19 ) AND hook = '{$data["ID"]}' ");
		$this->db->query("DELETE FROM _user_playlists_relations WHERE track_id = '{$data["ID"]}' ");
		$this->db->query("DELETE FROM _user_purchases WHERE item_type = 'song' AND item_id = '{$data["ID"]}' ");

		$this->loader->album->recount_tracks( $data["album_id"] );

	}
	public function edit( $ID, $new_data ){

		$data = is_array( $ID ) ? $ID : $this->select(["ID"=>$ID,"_eg"=>["text_data","artists_featured"]]);
		extract( array_merge( $data, $new_data ) );
		$price = $price ? $price : 0;
		$genre_id = empty( $genre ) ? $genre_id : $this->loader->genre->select(["name"=>$genre])["ID"];
		$text_data["comment"] = isset( $new_data["text_comment"] ) ? $new_data["text_comment"] : $text_data["comment"];
		$text_data["lyrics"]  = isset( $new_data["text_lyrics"] )  ? $new_data["text_lyrics"]  : $text_data["lyrics"];
		$album_order = $album_order ? $album_order : null;

		// Changed track's albums code?
		if ( $data["album_artist_name"] != $album_artist_name || $data["album_title"] != $album_title ){
			$album_code = $this->loader->general->make_code( $album_artist_name . $album_title );
			$album_data = $this->loader->album->select([ "code" => $album_code ]);
			if ( empty( $album_data ) ) return "Album: {$album_artist_name} - {$album_title} doesnt exists";
			$album_id = $album_data["ID"];
			$album_url = $album_data["url"];
		}

		// Changed track code?
		if ( $data["title"] != $title ||
		$data["album_title"] != $album_title ||
		$data["album_artist_name"] != $album_artist_name ){

			// new code
			$code = $this->loader->general->make_code( $album_artist_name . $album_title . $title );

			$check = $this->select( ["code"=>$code] );
			if ( $check ){
				if ( $check["ID"] != $ID ) return "track_{$code}_exists";
			}

			// new url
			$url = $this->loader->ui->murl(
				"track",
				"{$artist_name}-{$title}",
				$ID
			);

		}

		// Changed track artist?
		if ( $data["artist_name"] != $artist_name ){
			$artist_data = $this->loader->artist->create(["name"=>$artist_name]);
			$artist_id   = $artist_data["ID"];
			$artist_url  = $artist_data["url"];
		}

		// Changed track's album artist?
		if ( $data["album_artist_name"] != $album_artist_name ){
			$album_artist_data = $this->loader->artist->create(["name"=>$album_artist_name]);
			$album_artist_id   = $album_artist_data["ID"];
			$album_artist_url  = $album_artist_data["url"];
			$artist_id   = $album_artist_id;
			$artist_url  = $album_artist_url;
			$artist_name = $album_artist_name;
		}

		// Reset featured artist
		$this->db->query("DELETE FROM _m_relations WHERE type = 'featured' AND ID2 = '{$ID}' ");

		// Go thro each featured artist and add them
		if ( !empty( $artists_featured ) ){

			if ( is_array( $artists_featured ) ){

				$_fts = $artists_featured;
				$artists_featured = [];
				foreach( $_fts as $_ftID => $_ftData ){
					$artists_featured[] = $_ftID;
					$this->loader->artist->make_rel( $_ftID, $ID, "featured" );
				}

			} else {

				$_fts = explode( ";", $artists_featured );
				$artists_featured = [];
				foreach( $_fts as $_ft ){

					$_ft = trim( $_ft );
					if ( empty( $_ft ) ) continue;
					if ( !is_string( $_ft ) ) continue;
					$_ft = $this->loader->artist->create($this->loader->artist->verify_args(array("name"=>$_ft)))["ID"];
					$artists_featured[] = intval( $_ft );
					$this->loader->artist->make_rel( $_ft, $ID, "featured" );

				}

			}

			$artists_featured = json_encode( $artists_featured );

		} else {
			$artists_featured = "";
		}

		// Update track table itself
		$stmt = $this->db->prepare("UPDATE _m_tracks SET code=?, title=?, cover=?, url=?, user_id=?, genre_id=?, artist_id=?, artist_name=?, artist_url=?, artists_featured=?, album_id=?, album_order=?, album_artist_id=?, album_title=?, album_url=?, album_artist_name=?, album_artist_url=?, spotify_id=?, price=?, time_release=?, youtube_id=?, bandcamp_id=?, sitelink=?, dl_link=?, soundcloud_url=?, itunes_url=? WHERE ID=? ");
		$stmt->bind_param( "sssssssssssssssssssssssssss", $code, $title, $cover, $url, $user_id, $genre_id, $artist_id, $artist_name, $artist_url, $artists_featured, $album_id, $album_order, $album_artist_id, $album_title, $album_url, $album_artist_name, $album_artist_url, $spotify_id, $price, $time_release, $youtube_id, $bandcamp_id, $sitelink, $dl_link, $soundcloud_url, $itunes_url, $ID );
		$stmt->execute();
		if ( !empty( $stmt->error ) ){
			trigger_error( $stmt->error, E_USER_ERROR );
			exit;
		}
		$stmt->close();

		// Update track sister table
		if ( !empty( $text_data["comment"] ) || !empty( $text_data["lyrics"] ) ){

			$comment = is_string( $text_data["comment"] ) ? $this->loader->general->json_encode( str_replace( [ "\r\n", "\n", PHP_EOL ], "<BR>", $text_data["comment"] ) ) : null;
			$lyrics  = is_string( $text_data["lyrics"] )  ? $this->loader->general->json_encode( str_replace( [ "\r\n", "\n", PHP_EOL ], "<BR>", $text_data["lyrics"] ) ) : null;
			$this->create_data( $ID, $comment, $lyrics );

		} else if ( !empty( $data["text_data"]["comment"] ) || !empty( $data["text_data"]["lyrics"] ) ){
			$this->create_data( $ID, null, null );
		}

		$this->loader->album->recount_tracks( $data["album_id"] );
		if ( $album_id != $data["album_id"] ) $this->loader->album->recount_tracks( $album_id );

		return true;

	}

}

?>
