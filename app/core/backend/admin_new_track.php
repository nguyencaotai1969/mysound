<?php

if ( !defined( "root" ) ) die;

// Image file validation
if ( $sent_file = $loader->secure->get( "file", "cover" ) ){

	$verify_and_copy_image = $loader->general->save_image( $sent_file["tmp_name"], array(
		"input_ext"  => $sent_file["extension"],
		"output_ext" => $sent_file["extension"],
		"min_width"  => 200,
		"min_height" => 200,
		"dirname"  => "covers"
	));

	if ( empty( $verify_and_copy_image ) ){
		$this->set_error( "invalid_image", true );
	}

	$new_image = $loader->image
	->set( $verify_and_copy_image )
	->resize([
		"max_width"  => 1500,
		"max_height" => 1500,
		"min_width"  => 200,
		"min_height" => 200,
		"remove_src" => true
	])
	->square()
	->get([
		"input_ext"  => $sent_file["extension"],
		"output_ext" => "jpg",
		"basename" => $loader->general->image_dir,
		"dirname"  => "covers",
		"remove_src" => true
	]);

}

if ( empty( $new_image ) )
	$this->set_error( "invalid_cover_image" );

// Album args
$album_args = array(

    "type"        => $this->ps["album_type"],
    "genre"       => $this->ps["album_genre"],
	"title"       => $this->ps["album_title"],
	"artist_name" => $this->ps["album_artist_name"],
	"time"        => $this->ps["time_release"],
    "cover"       => $new_image,
    "user_id"     => $this->ps["user_id"]

);

$verify_album = $loader->album->verify_args( $album_args );
if ( !is_array( $verify_album ) ) $this->set_error( $verify_album );
$album_data = $loader->album->create( $verify_album );


// Track args
$args = array(

	"album_type"        => $this->ps["album_type"],
    "album_genre"       => $this->ps["album_genre"],
	"album_title"       => $this->ps["album_title"],
	"album_order"       => $this->ps["album_order"] ? $this->ps["album_order"] : null,
	"album_artist_name" => $this->ps["album_artist_name"],
    "album_id"          => $album_data["ID"],
    "album_url"         => $album_data["url"],
    "album_artist_url"  => $album_data["artist_url"],
    "album_artist_id"   => $album_data["artist_id"],
	"album_time"        => $this->ps["time_release"],

	"title"             => $this->ps["title"],
	"user_id"           => $this->ps["user_id"] ? $this->ps["user_id"] : $this->loader->visitor->user()->ID,
	"genre"             => $this->ps["genre"],
	"artist_name"       => $this->ps["artist_name"],
	"artists_featured"  => $this->ps["artists_featured"],
	"spotify_ID"        => $this->ps["spotify_id"],
	"price"             => $this->ps["price"] ? $this->ps["price"] : 0,
	"time_release"      => $this->ps["time_release"],
	"duration"          => $this->ps["duration"],
	"comment"           => $this->ps["text_comment"],
	"lyrics"            => $this->ps["text_lyrics"],

);
if ( !empty( $new_image ) ) $args["cover"] = $new_image;
if ( !empty( $new_image ) ) $args["album_cover"] = $new_image;

$verify = $loader->track->verify_args( $args );
if ( !is_array( $verify ) ) $this->set_error( $verify );
$add = $loader->track->create( $verify );

// Is there a source?
if ( !empty( $this->ps["youtube_id"] ) ){

	$loader->source->create([
		"track_id" => $add["ID"],
		"duration" => $this->ps["duration"],
		"yt_id"    => $this->ps["youtube_id"]
	]);

	$loader->track->mark_source( $add["ID"] );

}

$this->set_response("done");

?>
