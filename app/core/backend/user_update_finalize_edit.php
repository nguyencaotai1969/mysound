<?php

if ( !defined( "root" ) ) die;

$uploadings = $loader->ui->set_page_data();
if ( !$loader->secure->get( "get", "ID", "md5", [ "length" => 20 ] ) or empty( $uploadings ) )
	$this->set_error("invalid_requestID",true);

$__all_valid = true;
$fails = [];
foreach( $uploadings["albums"] as $__an => $__ad ){
	$validate = $loader->album->verify_args( $__ad );
	if ( !is_array( $validate ) ){
		$__all_valid = false;
		$fails[] = $loader->lorem->turn( "album", ["uc"=>true] ) . ": {$__ad["title"]}. {$loader->lorem->turn( "error", ["uc"=>true] )}: {$loader->lorem->turn( $validate, ["uc"=>true] )}";
	}
} unset( $__an, $__ad );

foreach( $uploadings["tracks"] as $__tn => $__t ){
	$validate = $loader->track->verify_args( $__t );
	if ( !is_array( $validate ) ){
		$__all_valid = false;
		$fails[] = $loader->lorem->turn( "track", ["uc"=>true] ) . ": {$__t["title"]}. {$loader->lorem->turn( "error", ["uc"=>true] )}: {$loader->lorem->turn( $validate, ["uc"=>true] )}";
	}
} unset( $__an, $__ad );

if ( !$__all_valid ){
	$this->set_error( $fails[0] );
	die;
}

$done = [];
foreach( $uploadings["albums"] as $__an => $__ats ){

	if ( $loader->general->is_local( $__ats["cover"] ) ){
		$__ats["cover"] = $loader->general->save_image( $__ats["cover"], array(
			"input_ext"  => "jpg",
			"output_ext" => "jpg",
			"basename"   => $loader->general->image_dir,
			"remove_src" => true,
			"dirname"    => "uploaded_covers",
			"final"      => true
		));
	}

	$album_data = $loader->album->create( array_merge( $__ats , [
		"user_id" => $loader->visitor->user()->ID
	] ) );

	$errors = [];

	foreach( $__ats["tracks_full"] as $__t ){

		$__t["album_cover"] = $__ats["cover"];

		if ( !empty( $__t["ID"] ) ){
			$__tid = $__t["ID"];
			unset( $__t["ID"] );
		}

		$track_data = $loader->track->create( array_merge( $__t, [
			"album_url"        => $album_data["url"],
			"album_id"         => $album_data["ID"],
			"album_artist_id"  => $album_data["artist_id"],
			"album_artist_url" => $album_data["artist_url"],
			"local"            => 1,
			"has_source"       => 1,
			"user_id"          => $loader->visitor->user()->ID
		] ) );

		if ( $track_data["from_db"] ? ( $track_data["local"] ? true : false ) : false ){
			$errors[] = [ "upload_track_exist", "{$__t["artist_name"]} - {$__t["title"]}" ];
			continue;
		}

		if ( !$track_data["from_db"] ){

			$loader->visitor->user()->add_log([
				"type" => 3,
				"hook" => $track_data["ID"]
			]);

			$loader->db->query("UPDATE _users SET media_uploads = media_uploads + 1 WHERE ID = '{$loader->visitor->user()->ID}' ");

		}

		if ( $loader->admin->get_setting( "upload_write_id3", 1, [ 0, 1 ] ) ){

			$id3_tags = array(
				"title"        => [ $__t["title"] ],
				"artist"       => [ $__t["artist_name"] ],
				"album"        => [ $__t["album_title"] ],
				"track_number" => [ $__t["album_order"] ],
				"genre"        => [ $__t["genre"] ],
				"year"         => [ substr( $__t["album_time"][0], 0, 4 ) ],
			);

			if ( $loader->general->is_local( $__t["cover"] ) ){
				$id3_tags["attached_picture"] = [[
				    "picturetypeid" => 2,
	    	        "description"   => 'cover',
	    	        "mime"          => 'image/jpeg',
	    	        "data"          => file_get_contents( $__t["cover"] )
				]];
			}

			$loader->id3->write_tags( $__t["fileName"], $id3_tags );

		}

		$source_data = $loader->source->create(array(
			"track_id"      => $track_data["ID"],
			"album_id"      => $album_data["ID"],
			"file"          => $__t["fileName"],
			"file_bitrate"  => $__t["source_bitrate"],
			"file_relocate" => $loader->general->protected_dir . "/audio/",
			"file_wave_bg"  => !empty( $__t["waveData"]["bg"] ) ? $__t["waveData"]["bg"] : null,
			"file_wave_pr"  => !empty( $__t["waveData"]["pr"] ) ? $__t["waveData"]["pr"] : null,
			"duration"      => $__t["source_duration"]
		));

		if ( !$source_data ){
			$errors[] = [ "upload_file_failed", "{$__t["artist_name"]} - {$__t["title"]}" ];
			continue;
		}

		$loader->db->query("UPDATE _m_tracks SET user_id = {$loader->visitor->user()->ID} WHERE user_id IS NULL AND ID = '{$track_data["ID"]}' ");
		$loader->track->mark_local( $track_data["ID"] );
		$done[] = "{$__t["artist_name"]} - {$__t["title"]}";
		$loader->db->query("UPDATE _user_uploads SET time_removed = now() WHERE ID = '{$__tid}' ");

	}

	if ( count( $done ) > 0 ) $loader->album->mark_local( $album_data["ID"] );
	$loader->album->recount_tracks( $album_data["ID"] );

}

$output = "";
if ( !empty( $done ) ){
	$output = "<span class='track_count'>".$loader->lorem->turn("tracks_uploaded",["params"=>["tracks"=>count($done)]])."</span><br><span class='divider'></span>";

	// Notify admins
	$this->loader->admin->add_not([
		"type" => "74",
		"hook" => $loader->visitor->user()->ID,
		"extraData" => [ "track_count" => count( $done ) ]
	]);

}
if ( !empty( $errors ) ){

	$output .= "<span class='errors'>";
	foreach( $errors as $error ){
		$output .= "<span class='error'>{$error[0]} -> {$error[1]} </span><br><span class='divider'></span>";
	}
	$output .= "</span>";
	$this->set_error( $output, false, true );

} else {

	$this->set_response( $output, false, false, true );

}

?>
