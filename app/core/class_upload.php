<?php

if ( !defined("root" ) ) die;

class upload {

	public function __construct( $loader ){

		$this->loader = $loader;
		$this->db = $loader->db;

	}

	// Uploading
	public function add( $args = [] ){

		$userID = $this->loader->visitor->user()->ID;
		$uploadID = null;
		$fileName = null;
		$tagData = null;
		$spotifyData = null;
		$youtubeData = null;
		$finalData = null;
		$waveData = null;
		$originalName = null;
		$rID = null;
		extract( $args );

		if ( empty( $uploadID ) || empty( $fileName ) || empty( $userID ) ){
			die("user::add_upload bad arguments passed");
		}

		$stmt = $this->db->prepare("INSERT INTO _user_uploads ( userID, uploadID, fileName, tagData, spotifyData, youtubeData, originalName, finalData, waveData, rID )
		VALUES( ?, ?, ?, ?, ?, ?, ?, ?, ?, ? )");
		$stmt->bind_param( "ssssssssss", $userID, $uploadID, $fileName, $tagData, $spotifyData, $youtubeData, $originalName, $finalData, $waveData, $rID );
		$stmt->execute();
		$stmt->close();

		return $this;

	}
	public function add_from_file( $file, $file_name, $upload_id ){

		$_default_data = $_final_data = array(
			"title"             => "Unkown Title ",
			"artist_name"       => "Unkown Artist",
			"genre"             => "no-Genre",
			"duration"          => null,
			"cover"             => null,
			"comment"           => null,
			"album_order"       => null,
			"album_title"       => "Unkown Album Title",
			"album_artist_name" => "Unkown Album Artist",
			"album_time"        => null,
			"album_cover"       => null,
			"album_type"        => "studio",
			"album_comment"     => null
		);

		foreach( $_default_data as $k => $v ) $_final_data["source_{$k}"] = null;
		foreach( $_default_data as $k => $v ) $_final_data["spotify_{$k}"] = null;

		$_final_data[ "rID" ]                      = md5( uniqid() );
		$_final_data[ "comment" ]                  = null;
		$_final_data[ "price" ]                    = 0;
		$_final_data[ "source_bitrate" ]           = null;
		$_final_data[ "spotify_hits" ]             = null;
		$_final_data[ "spotify_explicit" ]         = null;
		$_final_data[ "spotify_artists_featured" ] = null;

		// Read mp3 file tag data
		// This will help user in editing phase and also validates mp3 file
		$_source_data = $this->loader->id3->read_tags( $file );
		if ( empty( $_source_data ) ) return false;

		// If there is a cover attached to file, save it, resize it, make it square
		if ( !empty( $_source_data["comments"]["picture"][0]["data"] ) ){

			$cover = $this->loader->general->save_image(
				$_source_data["comments"]["picture"][0]["data"],
				[
					"min_width"  => 400,
					"min_height" => 400,
					"basename"   => $this->loader->general->uploading_dir,
					"dirname"    => "attached_covers_raw"
				]
			);

			if ( !empty( $cover ) ){

				$cover = $this->loader->image
				->set( $cover )
				->resize([
					"max_width"  => 2000,
					"max_height" => 2000,
					"min_width"  => 400,
					"min_height" => 400,
					"remove_src" => true
				])
				->square()
				->get([
					"basename" => $this->loader->general->uploading_dir,
					"dirname"  => "attached_covers_edited",
					"final"    => false,
				]);

			}

			$_source_data["tags"]["cover"] = $cover;

		}

		// Override default data by tags data
		if ( !empty( $_source_data["tags"] ) ){

			foreach( $_source_data["tags"] as $__k => $__v ){
				if ( !empty( $__v ) ) $_final_data[ $__k ] = $_final_data[ "source_{$__k}" ] = $__v;
			}
			$_final_data["duration"] = $_final_data["source_duration"] = ceil( $_final_data["duration"] );
			if ( empty( $_final_data["duration"] ) || empty( $_final_data["bitrate"] ) ? true : $_final_data["bitrate"] < $this->loader->admin->get_setting( "upload_min_bitrate" , 64 ) ) return false;
			unset( $__k, $__v );

		}

		// Try to find this track on Spotify from tag datas ( if admin allows it )
		if ( ( !empty( $_final_data["artist_name"] ) || !empty( $_final_data["album_artist_name"] ) ) && !empty( $_final_data["title"] ) && !empty( $_final_data["duration"] ) && !empty( $_final_data["album_title"] ) && $this->loader->admin->get_setting('spotify_upload',0,[0,1] ) ){

			$search_spotify = $this->loader->spotify->search_track( $_final_data["title"], !empty( $_final_data["album_artist_name"] ) ? $_final_data["album_artist_name"] : $_final_data["artist_name"] );
			if ( !empty( $search_spotify[0] ) && !empty( $search_spotify[1]["duration"] ) && !empty( $search_spotify[1]["album_title"] ) ){

				similar_text( $this->loader->general->purify_album_title( $_final_data["album_title"] ), $this->loader->general->purify_album_title( $search_spotify[1]["album_title"] ), $__s );
				if ( abs( $search_spotify[1]["duration"] - intval( $_source_data["playtime_seconds"] ) ) < 20 && $__s > 75 ){

					// Override default data by spotify data
					$_spotify_data = $search_spotify[1];
					foreach( $_spotify_data as $__k => $__v ){
						if ( !empty( $__v ) ) $_final_data[ $__k ] = $_final_data[ "spotify_{$__k}" ] = $__v;
					}

				}

			}

		}

		// Validate genre
		$_final_data["genre"] = $_final_data["album_genre"] = $this->loader->genre->return_valid( $_final_data["genre"], "code" );

		ksort( $_final_data );
	    $this->add(array(
		    "rID"          => $_final_data["rID"],
		    "uploadID"     => $upload_id,
		    "fileName"     => $file,
		    "originalName" => $file_name,
		    "tagData"      => !empty( $_source_data["tags"] ) ? $this->loader->general->json_encode( $_source_data["tags"] ) : null,
		    "spotifyData"  => !empty( $_spotify_data ) ? $this->loader->general->json_encode( $_spotify_data ) : null,
		    "finalData"    => $this->loader->general->json_encode( $_final_data ),
		    "waveData"     => !empty( $_wavedata ) ? $_wavedata : null
	    ));

		return true;

	}
	public function get( $args = [] ){

		$uploadID = null;
		$rID = null;
		$userID = $this->loader->visitor->user()->ID;
		extract( $args );
		$results = [
			"albums" => [],
			"tracks" => [],
			"uploadings" => []
		];

		$__ws = [ "time_add > SUBDATE( now(), INTERVAL 12 HOUR )", "time_removed IS NULL" ];
		if ( !empty( $userID ) )   $__ws[] = "userID = '{$userID}'";
		if ( !empty( $uploadID ) ) $__ws[] = "uploadID = '{$uploadID}'";
		if ( !empty( $rID ) )      $__ws[] = "rID = '{$rID}'";

		$__q = "SELECT * FROM _user_uploads WHERE ".implode( " AND ", $__ws )." ORDER BY time_add ASC";

		$get_uploadings = $this->db->query($__q);
		if ( !$get_uploadings->num_rows ) return $results;

		while ( $__d = $get_uploadings->fetch_assoc() ){

			$__d["waveData"] = !empty( $__d["waveData"] )  ? json_decode( stripslashes( $__d["waveData"] ), 1 )  : null;
			$__d["data"]     = !empty( $__d["finalData"] ) ? $this->loader->general->json_decode( $__d["finalData"] ) : null;

			$__d["data"]["code"] = $this->loader->general->make_code( $__d["data"]["album_artist_name"] . $__d["data"]["album_title"] . $__d["data"]["title"] );

			$__d["data"]["album_code"]          = $__dac = $this->loader->general->make_code( $__d["data"]["album_artist_name"] . $__d["data"]["album_title"] );
			$__d["data"]["album_time"]          = !empty( $__d["data"]["album_time"] ) ? ( is_array( $__d["data"]["album_time"] ) ? $__d["data"]["album_time"][0] : $__d["data"]["album_time"] ) : null;
			$__d["data"]["album_time"]          = $__d["data"]["album_time"] ? substr( $__d["data"]["album_time"], 0, 10 ) : null;
			$__d["data"]["album_spotify_ID"]    = !empty( $__d["data"]["spotify_album_ID"] ) ? $__d["data"]["spotify_album_ID"] : null;
			$__d["data"]["album_spotify_cover"] = !empty( $__d["data"]["spotify_album_cover"] ) ? $__d["data"]["spotify_album_cover"] : null;
			$__d["data"]["artists_featured"]    = !empty( $__d["data"]["artists_featured"] ) ? implode( ";", $__d["data"]["artists_featured"] ) : null;
			$__d["data"]["originalName"]        = $__d["originalName"];
			$__d["data"]["fileName"]            = $__d["fileName"];
			$__d["data"]["waveData"]            = $__d["waveData"];
			$__d["data"]["ID"]                  = $__d["ID"];

			// Add track to result array
			$results["tracks"][ $__d["rID"] ] = $__d["data"];
			$results["uploadings"][ $__d["rID"] ] = $__d;

			$results[ "albums" ][ $__dac ][ "tracks" ][] = $__d["rID"];

			// Add album to result array
			foreach( [ "code", "genre", "title", "artist_name", "cover", "time", "type", "comment", "rID", "spotify_ID", "spotify_cover", "price" ] as $_required_album_variable_name ){

				// Required variable not added from other tracks?
				if ( empty( $results[ "albums" ][ $__dac ][ $_required_album_variable_name ] ) )
					$results[ "albums" ][ $__dac ][ $_required_album_variable_name ] = null;

				// Uploading has a specific album variable?
				if ( !empty( $__d["data"]["album_{$_required_album_variable_name}"] ) )
					$results[ "albums" ][ $__dac ][ $_required_album_variable_name ] = $__d["data"]["album_{$_required_album_variable_name}"];

				// Still nothing? get track's variable and set it as album's
				if (
					empty( $results[ "albums" ][ $__dac ][ $_required_album_variable_name ] ) &&
					!empty( $__d["data"][ $_required_album_variable_name ] ) &&
					$_required_album_variable_name !== "spotify_ID" && $_required_album_variable_name != "price"
				)
					$results[ "albums" ][ $__dac ][ $_required_album_variable_name ] = $__d["data"][ $_required_album_variable_name ];

				foreach( $results[ "albums" ][ $__dac ][ "tracks" ] as $track_rID ){
					$results["tracks"][ $__d["rID"] ][ "album_{$_required_album_variable_name}" ] = $results[ "albums" ][ $__dac ][ $_required_album_variable_name ];
				}

			}

			$results[ "albums" ][ $__dac ][ "tracks_count" ]    = empty( $results[ "albums" ][ $__dac ][ "tracks_count" ]  ) ? 1 : $results[ "albums" ][ $__dac ][ "tracks_count" ] + 1;
			$results[ "albums" ][ $__dac ][ "tracks_duration" ] = empty( $results[ "albums" ][ $__dac ][ "tracks_duration" ] ) ? $__d["data"]["duration"] : $results[ "albums" ][ $__dac ][ "tracks_duration" ] + $__d["data"]["duration"];

		}

		return $results;

	}

}

?>
