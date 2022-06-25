<?php

if ( !defined( "root" ) ) die;

class bot {

	public function __construct( $loader ){

		$this->loader = $loader;
		$this->db = $loader->db;

	}

	protected $logs = [];
	protected $log_echo = true;

	public function get_logs(){
		return $this->logs;
	}
	public function reset_logs(){
		$this->logs = [];
	}
	public function echo_off(){
		$this->log_echo = false;
	}
	protected function __log( $msg, $error = false, $seperator = false ){

		if ( $seperator ){
			for( $i=1; $i<=($seperator===true?1:$seperator); $i++ ){
				if ( $this->log_echo ) echo "========================\n";
			}
			$this->logs[] = "======";
		}
		$log = ( $error ? "ERROR:" : "" ) . "{$msg}";
		$this->logs[] = $log;
		if ( $this->log_echo ) echo $log . PHP_EOL;

	}

	public function update_spotify_widgets( $run = true ){

		$widgets = [ "updated" => [], "outdated" => [] ];
		$pages = $this->loader->ui->load_pages();
		if ( empty( $pages ) ) return $widgets;

		foreach( $pages as $page ){

			if ( empty( $page["widgets"] ) ) continue;
			foreach( $page["widgets"] as $widget ){

				if ( substr( $widget["type"], 0, 7 ) != "spotify" ) continue;
				if ( empty( $widget["sett"]["id"] ) ) continue;
				if ( $widget["time_update"] ? strtotime( $widget["time_update"] ) > time() - ( $this->loader->admin->get_setting("spotify_w_u_i",6)*60*60 ) : false ){
					$widgets[ "updated" ][ $widget["ID"] ] = $widget;
					continue;
				}
				// This widget is "spotify" type, unupdated and has a ID, let's update it!
				if ( $run ){
					$this->update_spotify_widget( $widget );
			    	$widgets[ "updated" ][ $widget["ID"] ] = $widget;
					sleep( rand( 5, 10 ) );
				}
				else {
					$widgets[ "outdated" ][ $widget["ID"] ] = $widget;
				}

			}
		}

		return $widgets;

	}
	public function update_spotify_widget( $data ){

		$__report = [
			"added"   => 0,
			"exists"  => 0,
			"ignored" => 0
		];

		$tracks = [];
		$this->loader->general->curl_debug = $this->log_echo;
		$this->loader->spotify->rest = 0.2;
		$this->__log( "Updating {$data["title"]} Spotify widget started", false, 3 );
		$this->__log( "Getting playlist:{$data["sett"]["id"]} data from Spotify API" );
		$get_playlist_data = $this->loader->spotify->get_playlist_data( $data["sett"]["id"] );

		if ( !$get_playlist_data[0] ){
			$this->__log( "Getting playlist:{$data["sett"]["id"]} FAILED", true );
			return;
		}

		$playlist_data = $get_playlist_data[1];
		$this->__log( "Bot found " . count( $playlist_data["tracks"] ) . " tracks in playlist" );

		foreach( $playlist_data["tracks"] as $playlist_track_simple ){

			$this->__log("Fetching {$playlist_track_simple["title"]} by {$playlist_track_simple["artist_name"]}",false,true);
			$this->__log("Searching for alternative version of track on Spotify");
			$playlist_track_full = $this->loader->spotify->search_track( $playlist_track_simple["title"], $playlist_track_simple["artist_name"] );
			if ( !$playlist_track_full[0] || empty( $playlist_track_full[1] ) ){
				$this->__log("Found no alternative. Skipping this song",true);
				$__report["ignored"]++;
				continue;
			}
			$playlist_track = $playlist_track_full[1];

			$playlist_track_genre = !empty( $data["sett"]["genre"] ) ? $data["sett"]["genre"] !== "all" && $this->loader->genre->return_valid( $data["sett"]["genre"] ) : "No-Genre";
			if ( empty( $playlist_track_genre ) ? true : $playlist_track_genre == "No-Genre" ){
				$this->__log("Searching for track's artist to find out the track's genre");
			    $playlist_track_artist = $this->loader->spotify->search_artist( $playlist_track["artist_name"] );
				$playlist_track_genre  = $this->loader->genre->return_from_array( !empty( $playlist_track_artist[1]["genres"] ) ? $playlist_track_artist[1]["genres"] : null );
			}

			$album_args = array(
				"title"       => $playlist_track["album_title"],
				"cover"       => $playlist_track["album_cover"],
				"time"        => $playlist_track["album_time"][0],
				"artist_name" => $playlist_track["album_artist_name"],
				"genre"       => $playlist_track_genre,
				"type"        => $playlist_track["album_type"],
				"spotify_ID"  => $playlist_track["album_ID"]
			);

			if ( !is_array( $album_verified_args = $this->loader->album->verify_args( $album_args ) ) ){
				$this->__log( "There is something wrong with this album's info or DigiMuse does not support it. Skipping it", true );
				$this->__log( "Album: {$album_verified_args}", true );
				$__report["ignored"]++;
				continue;
			}

			if ( !is_array( $album_db_data = $this->loader->album->create( $album_verified_args ) ) ){
				$this->__log( "DigiMuse failed to create this album on database, Skipping it", true );
				$__report["ignored"]++;
				continue;
			}

			if ( empty( $album_db_data["ID"] )  ){
				$this->__log( "DigiMuse failed to create this album on database ( 2 ), Skipping it", true );
				$__report["ignored"]++;
				continue;
			}

			$track_args = array(
				"title"             => $playlist_track["title"],
				"genre"             => $playlist_track_genre,
				"artist_name"       => $playlist_track["artist_name"],
				"cover"             => $playlist_track["cover"],
				"duration"          => $playlist_track["duration"],
				"spotify_id"        => $playlist_track["ID"],
				"spotify_cover"     => $playlist_track["cover"],
				"spotify_hits"      => $playlist_track["hits"],
				"artists_featured"  => !empty( $playlist_track["artists_featured"] ) ? $playlist_track["artists_featured"] : null,
				"album_order"       => $playlist_track["album_order"],
				"album_title"       => $playlist_track["album_title"],
				"album_artist_name" => $playlist_track["album_artist_name"],
				"album_type"        => $playlist_track["album_type"],
				"album_time"        => $playlist_track["album_time"][0],
				"album_cover"       => $playlist_track["album_cover"],
				"album_genre"       => $playlist_track_genre,
				"album_id"          => $album_db_data["ID"],
				"album_url"         => $album_db_data["url"],
				"album_artist_id"   => $album_db_data["artist_id"],
				"album_artist_url"  => $album_db_data["artist_url"],
				"local"             => 0
			);

			if ( !is_array( $track_verified_args = $this->loader->track->verify_args( $track_args ) ) ){
				$this->__log( "There is something wrong with this track's info or DigiMuse does not support it. Skipping it", true );
				$this->__log( "Track: {$track_verified_args}", true );
				$__report["ignored"]++;
				continue;
			}

			if ( !is_array( $track_db_data = $this->loader->track->create( $track_verified_args ) ) ){
				$this->__log( "DigiMuse failed to create this track on database, Skipping it", true );
				$__report["ignored"]++;
				continue;
			}

			$tracks[] = $track_db_data["ID"];

			if ( !empty( $track_db_data["from_db"] ) ){
				$this->__log( "This track already existed in our database. Skipping" );
				$__report["exists"]++;
				continue;
			}

			$__report["added"]++;

			// Check if this track has a YT source
			$playlist_track_source = $this->loader->source->select(["track_id"=>$track_db_data["ID"],"type"=>"youtube"]);
			$this->loader->album->recount_tracks( $track_db_data["album_id"] );

		}

		$cached_encoded = json_encode( $tracks );
		$this->db->query("UPDATE _setting_page_widgets SET widget_cache = '{$cached_encoded}', time_update = now() WHERE ID = {$data["ID"]} ");
		return $__report;

	}
	public function complete_album( $data, $scrapData = null ){

		// Album spotify ID
		$album_spotify_id = null;
		if ( !empty( $data["spotify_id"] ) ){

			$album_spotify_id = $data["spotify_id"];

		}
		else {

			$album_spotify_data = $this->loader->spotify->search_album( $data["title"], $data["artist_name"] );
			if ( $album_spotify_data[0] && !empty( $album_spotify_data[1]["ID"] ) ){
				$stmt = $this->db->prepare("UPDATE _m_albums SET spotify_id = ?, spotify_hits = ? WHERE ID = ? ");
				$stmt->bind_param( "sss", $album_spotify_data[1]["ID"], $album_spotify_data[1]["hits"], $data["ID"] );
				$stmt->execute();
				$stmt->close();
				$album_spotify_id = $album_spotify_data[1]["ID"];
			} else {
				return [ 0, "album_no_spotify_ID" ];
			}

		}

		// Album track list
		$album_spotify_data = $scrapData ? $scrapData : $this->loader->spotify->get_album_data( $album_spotify_id );
		if ( empty( $album_spotify_data[1]["tracks"] ) ){
			return [ 0, "album_no_tracks" ];
		}

		foreach( $album_spotify_data[1]["tracks"] as $__track ){

			$__track_db = $this->loader->track->select(["spotify_id"=>$__track["ID"]]);
			if ( !empty( $__track_db ) ) continue;
			$__track["album_type"] = $data["type"];
			$this->spotify_create( "track", $__track );

		}

		$this->db->query("UPDATE _m_albums SET spotify_completed = 1 WHERE ID = '{$data["ID"]}' ");
		$this->loader->album->recount_tracks( $data["ID"] );

	}
	public function complete_artist( $data, $complete = true ){

		$artist_spotify_id = $this->complete_artist_get_id( $data );
		if ( empty( $artist_spotify_id[0] ) ) return $artist_spotify_id;
		$data["spotify_id"] = $artist_spotify_id[1];

		$popular_tracks = $this->complete_artist_most_popular( $data );
		if ( empty( $popular_tracks[0] ) ) return $popular_tracks;

		// Albums
		$artist_spotify_data = $this->loader->spotify->get_artist_top_albums( $data["spotify_id"], [ "album" ], 50, $complete === true );
		if ( !$artist_spotify_data[0] || empty( $artist_spotify_data[1] ) ){
			return [ 0, "artist_no_popular_albums" ];
		}
		if ( !$complete ) shuffle( $artist_spotify_data[1] );
		foreach( $complete === true ? $artist_spotify_data[1] : array_slice( $artist_spotify_data[1], 0, $complete ) as $__album ){
			$__album_db = $this->loader->album->select(["spotify_id"=>$__album["ID"]]);
			$__album_db2 = $this->loader->album->select(["code"=>$this->loader->general->make_code("{$__album["artist_name"]}{$__album["title"]}")]);
			if ( !empty( $__album_db ) or !empty( $__album_db2 ) ) continue;
			$this->spotify_create( "album", $__album );
			$__album_db = $this->loader->album->select(["spotify_id"=>$__album["ID"]]);
			if ( !empty( $__album_db ) ){
				$this->complete_album( $__album_db );
			}
		}

		// Related artists
		$artist_spotify_related_data = $this->loader->spotify->get_artist_related_artists( $data["spotify_id"] );
		if ( empty( $artist_spotify_related_data[1] ) ){
			return [ 0, "artist_no_related" ];
		}
		foreach( $artist_spotify_related_data[1] as $__artist ){
			$__artist_db = $this->loader->artist->select(["spotify_id"=>$__artist["ID"]]);
			$__artist_db2 = $this->loader->artist->select(["code"=>$this->loader->general->make_code("{$__artist["name"]}")]);
			if ( !empty( $__artist_db ) or !empty( $__artist_db2 ) ) continue;
			$this->spotify_create( "artist", $__artist );
		}


	}
	public function complete_artist_get_id( $data ){

		// Artist spotify ID
		$artist_spotify_id = null;
		if ( !empty( $data["spotify_id"] ) ){

			$artist_spotify_id = $data["spotify_id"];

		} else {

			$artist_spotify_data = $this->loader->spotify->search_artist( $data["name"] );
			if ( $artist_spotify_data[0] && !empty( $artist_spotify_data[1]["ID"] ) ){
				$stmt = $this->db->prepare("UPDATE _m_artists SET spotify_id = ?, spotify_hits = ? WHERE ID = ? ");
				$stmt->bind_param( "sss", $artist_spotify_data[1]["ID"], $artist_spotify_data[1]["hits"], $data["ID"] );
				$stmt->execute();
				$stmt->close();
				$artist_spotify_id = $artist_spotify_data[1]["ID"];
			} else {
				return [ 0, "artist_no_spotify_ID" ];
			}

		}

		return [ 1, $artist_spotify_id ];

	}
	public function complete_artist_most_popular( $data ){

		$artist_spotify_id = $this->complete_artist_get_id( $data );
		if ( empty( $artist_spotify_id[0] ) ) return $artist_spotify_id;
		$data["spotify_id"] = $artist_spotify_id[1];

		// Popular tracks
		$artist_spotify_top_data = $this->loader->spotify->get_artist_top_tracks( $data["spotify_id"] );
		if ( empty( $artist_spotify_top_data[1] ) ? true : !is_array( $artist_spotify_top_data[1]) ){
			return [ 0, "artist_no_popular_tracks" ];
		}
		foreach( $artist_spotify_top_data[1] as $__track ){
			$__track_db = $this->loader->track->select(["spotify_id"=>$__track["ID"]]);
			$__track_db2 = $this->loader->track->select(["code"=>$this->loader->general->make_code("{$__track["album_artist_name"]}{$__track["album_title"]}{$__track["title"]}")]);
			if ( !empty( $__track_db ) or !empty( $__track_db2 ) ) continue;
			$this->spotify_create( "track", $__track );
		}

		return [ 1 ];

	}
	public function spotify_create( $type, $hook ){

		if ( $type == "track" ){

	        // get track data
	        $track_data = is_array( $hook ) ? [ 1, $hook ] : $this->loader->spotify->get_track_data( $hook );
	        if ( !$track_data[0] ) return false;

	        // figure out track's genre
	        $album_artist_data = $this->loader->spotify->get_artist_data( $track_data[1]["artist_ID"] );
	        if ( !$album_artist_data[0] ) return false;

	        $genre = $this->loader->genre->return_from_array( $album_artist_data[1]["genres"] );

	        $__album_args = array(
		        "title"        => $track_data[1]["album_title"],
		        "artist_name"  => $track_data[1]["album_artist_name"],
		        "cover"        => $track_data[1]["album_cover"],
		        "type"         => $track_data[1]["album_type"],
		        "time"         => $track_data[1]["album_time"][0],
		        "genre"        => $genre,
		        "spotify_ID"   => $track_data[1]["album_ID"],
		        "spotify_hits" => null
	        );

	        if ( !is_array( $this->loader->album->verify_args( $__album_args ) ) )
		        return false;

	        $album_data = $this->loader->album->create( $this->loader->album->verify_args( $__album_args ) );

	        $__track_args = array(
		        "genre"             => $genre,
		        "title"             => $track_data[1]["title"],
		        "artist_name"       => $track_data[1]["artist_name"],
		        "spotify_ID"        => $track_data[1]["ID"],
		        "spotify_hits"      => $track_data[1]["hits"],
		        "explicit"          => empty( $track_data[1]["explicit"] ) ? 0 : 1,
		        "time"              => $track_data[1]["album_time"][0],
		        "duration"          => $track_data[1]["duration"],
		        "artists_featured"  => $track_data[1]["artists_featured"],
		        "album_url"         => $album_data["url"],
		        "album_title"       => $track_data[1]["album_title"],
		        "album_artist_name" => $track_data[1]["album_artist_name"],
		        "album_artist_id"   => $album_data["artist_id"],
		        "album_artist_url"  => $album_data["artist_url"],
		        "album_time"        => $track_data[1]["album_time"][0],
		        "album_type"        => $track_data[1]["album_type"],
		        "album_genre"       => $genre,
		        "album_cover"       => $track_data[1]["album_cover"],
		        "album_id"          => $album_data["ID"],
		        "album_spotify_ID"  => $track_data[1]["album_ID"],
		        "album_order"       => $track_data[1]["album_order"]
	        );

	        $__track_verified = $this->loader->track->verify_args( $__track_args );
	        if ( !is_array( $__track_verified ) ) return false;

	        $track_data = $this->loader->track->create( $__track_verified );
	        $response = $this->loader->ui->rurl( "track", $track_data["url"] );

        }
        elseif ( $type == "album" ){

	        $album_data = is_array( $hook ) ? [ 1, $hook ] : $this->loader->spotify->get_album_data( $hook );
	        if ( !$album_data[0] ) return false;

	        // figure out album's genre
	        $album_artist_data = $this->loader->spotify->get_artist_data( $album_data[1]["artist_ID"] );
	        if ( !$album_artist_data[0] ) return false;
	        $genre = $this->loader->genre->return_from_array( $album_artist_data[1]["genres"] );

	        $__album_args = array(
		        "title"        => $album_data[1]["title"],
		        "artist_name"  => $album_data[1]["artist_name"],
		        "cover"        => $album_data[1]["cover"],
		        "type"         => $album_data[1]["type"],
		        "time"         => $album_data[1]["time"][0],
		        "genre"        => $genre,
		        "spotify_ID"   => $album_data[1]["ID"],
		        "spotify_hits" => $album_data[1]["hits"]
	        );

	        if ( !is_array( $this->loader->album->verify_args( $__album_args ) ) )
		        return false;

	        $album_data = $this->loader->album->create( $this->loader->album->verify_args( $__album_args ) );
	        $response = $this->loader->ui->rurl( "album", $album_data["url"] );

        }
        elseif ( $type == "artist" ){

	        $artist_data = is_array( $hook ) ? [ 1, $hook ] : $this->loader->spotify->get_artist_data( $hook );
	        if ( !$artist_data[0] ) return false;

	        $__artist_args = array(
		        "code"         => $this->loader->general->make_code( $artist_data[1]["name"] ),
		        "name"         => $artist_data[1]["name"],
		        "spotify_ID"   => $artist_data[1]["ID"],
		        "spotify_hits" => $artist_data[1]["popularity"],
		        "image"        => $artist_data[1]["image"]
	        );

	        if ( !is_array( $this->loader->artist->verify_args( $__artist_args ) ) )
		        return false;

	        $artist_data = $this->loader->artist->create( $this->loader->artist->verify_args( $__artist_args ) );
	        $response = $this->loader->ui->rurl( "artist", $artist_data["url"] );

        }

		return $response;

	}
	public function localize_video( $track_data, $youtube_id, $test = false ){

		$download = $this->loader->utube->download( $youtube_id, $test );
		if ( !$download[0] ) return $download;
		$youtube_mp3_path = $download[1];

		// Write tags into mp3
		if ( $this->loader->admin->get_setting( "upload_write_id3", 1, [ 0, 1 ] ) ){

			$id3_tags = array(
				"title"        => [ $track_data["title"] ],
				"artist"       => [ $track_data["artist_name"] ],
				"album"        => [ $track_data["album_title"] ],
				"track_number" => [ $track_data["album_order"] ],
				"year"         => [ substr( $track_data["time_release"], 0, 4 ) ],
			);

			if ( $this->loader->general->is_local( $track_data["cover"] ) ){
				$id3_tags["attached_picture"] = [[
				    "picturetypeid" => 2,
	    	        "description"   => 'cover',
	    	        "mime"          => 'image/jpeg',
	    	        "data"          => file_get_contents( $track_data["cover"] )
				]];
			}

			$this->loader->id3->write_tags( $youtube_mp3_path, $id3_tags );

		}

		// Read tags from mp3
		$youtube_mp3_tags = $this->loader->id3->read_tags( $youtube_mp3_path );

		$source_data = $this->loader->source->create(array(
			"track_id"      => $track_data["ID"],
			"album_id"      => $track_data["album_id"],
			"file"          => $youtube_mp3_path,
			"file_bitrate"  => $youtube_mp3_tags["tags"]["bitrate"],
			"file_relocate" => $this->loader->general->protected_dir . "/audio/",
			"file_wave_bg"  => null,
			"file_wave_pr"  => null,
			"duration"      => $youtube_mp3_tags["tags"]["duration"]
		));

		$this->loader->track->mark_local( $track_data["ID"] );
		$this->loader->album->mark_local( $track_data["album_id"] );
		$this->loader->album->recount_tracks( $track_data["album_id"] );

		return [ true ];

	}

}

?>
