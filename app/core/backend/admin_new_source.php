<?php

if ( !defined( "root" ) ) die;

$track = $loader->track->select(["ID"=>$this->ps["track_id"]]);
if ( empty( $track ) ) $this->set_error( "invalid_track_ID" );
if ( $this->ps["type"] == "youtube" ? !empty( $this->ps["youtube"] ) : false ){

    $loader->source->create([
		"track_id" => $track["ID"],
		"duration" => $this->ps["duration"],
		"yt_id"    => $this->ps["youtube"]
	]);

	$loader->track->mark_source( $track["ID"] );

    $this->set_response( "done" );

}
elseif ( $this->ps["type"] == "local" && ( $sent_file = $loader->secure->get( "file", 'file', "file", [ "acceptable_extensions" => [ "mp3" ], "acceptable_types" => [ "audio/mpeg" ] ] ) ) ){

  $sent_file_temp_path = $loader->general->mkdir( $loader->general->uploading_dir ) . "/" . pathinfo( $sent_file["tmp_name"], PATHINFO_FILENAME ) . ".mp3";
  move_uploaded_file( $sent_file["tmp_name"], $sent_file_temp_path );
    $_source_data = $this->loader->id3->read_tags( $sent_file_temp_path );

    if ( empty( $_source_data["tags"]["bitrate"] ) || empty( $_source_data["tags"]["duration"] ) )
        $this->set_error( "invalid_audio_file", true );

    if ( $loader->admin->get_setting( "upload_write_id3", 1, [ 0, 1 ] ) ){

        $id3_tags = array(
            "title"        => [ $track["title"] ],
            "artist"       => [ $track["artist_name"] ],
            "album"        => [ $track["album_title"] ],
            "track_number" => [ $track["album_order"] ],
        );

        if ( $loader->general->is_local( $track["cover"] ) ){
            $id3_tags["attached_picture"] = [[
                 "picturetypeid" => 2,
                 "description"   => 'cover',
                 "mime"          => 'image/jpeg',
                 "data"          => file_get_contents( $track["cover"] )
            ]];
        }

        $loader->id3->write_tags( $sent_file_temp_path, $id3_tags );

    }

    $source_data = $loader->source->create(array(
        "track_id"      => $track["ID"],
        "album_id"      => $track["album_id"],
        "file"          => $sent_file_temp_path,
        "file_name"     => uniqid() . ".mp3",
        "file_bitrate"  => $_source_data["tags"]["bitrate"],
        "file_relocate" => $loader->general->protected_dir . "/audio/",
        "duration"      => $_source_data["tags"]["duration"]
    ));

    $loader->track->mark_source( $track["ID"] );
    $loader->track->mark_local( $track["ID"] );

    $this->set_response( "done" );

}

$this->set_error( "failed" );

?>
