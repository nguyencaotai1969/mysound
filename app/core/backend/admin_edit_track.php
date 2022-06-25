<?php

if ( !defined( "root" ) ) die;

// ID validation
$track = $loader->track->select(["ID"=>$this->ps["ID"]]);
if ( empty( $track ) ) $this->set_error( "invalid_ID", true );

// Image file validation
if ( $sent_cover = $loader->secure->get( "file", "cover" ) ){

	$verify_and_copy_image = $loader->general->save_image( $sent_cover["tmp_name"], array(
		"input_ext"  => $sent_cover["extension"],
		"output_ext" => $sent_cover["extension"],
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
		"input_ext"  => $sent_cover["extension"],
		"output_ext" => "jpg",
		"basename" => $loader->general->image_dir,
		"dirname"  => "covers",
		"remove_src" => true
	]);

	if ( !empty( $track["cover_o"] ) )
	$loader->general->remove_file( $track["cover_o"] );

}

// Edit args
$args = array(

	"title"             => $this->ps["title"],
	"user_id"           => $this->ps["user_id"],
	"genre"             => $this->ps["genre"],
	"artist_name"       => $this->ps["artist_name"],
	"artists_featured"  => $this->ps["artists_featured"],
	"album_title"       => $this->ps["album_title"],
	"album_order"       => $this->ps["album_order"],
	"album_artist_name" => $this->ps["album_artist_name"],
	"spotify_id"        => $this->ps["spotify_id"],
	"price"             => $this->ps["price"],
	"time_release"      => $this->ps["time_release"],
	"text_comment"      => $this->ps["text_comment"],
	"text_lyrics"       => $this->ps["text_lyrics"],
	"spotify_ID"        => $this->ps["spotify_id"],

);

if ( !empty( $new_image ) )
	$args["cover"] = $new_image;

// Edit
$edit = $loader->track->edit( $track["ID"], $args );

if ( $edit === true ) $this->set_response("done");
else $this->set_error("Failed: {$edit}");

?>
