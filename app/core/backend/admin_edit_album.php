<?php

if ( !defined( "root" ) ) die;

$album = $loader->album->select(["ID"=>$this->ps["ID"]]);
if ( empty( $album ) ) $this->set_error( "invalid_ID", true );

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
	]);

	if ( !empty( $album["cover_o"] ) )
	$loader->general->remove_file( $album["cover_o"] );

}

$args = array(
	"title"        => $this->ps["title"],
	"artist_name"  => $this->ps["artist_name"],
	"type"         => $this->ps["type"],
	"time_release" => $this->ps["time_release"],
	"comment"      => $this->ps["comment"],
	"user_id"      => $this->ps["user_id"],
	"genre"        => $this->ps["genre"],
	"genre_id"     => $this->loader->genre->select([ "name" => $this->ps["genre"] ])["ID"],
	"spotify_id"   => $this->ps["spotify_id"],
	"price"        => $this->ps["price"]
);

if ( !empty( $new_image ) ) $args["cover"] = $new_image;
$edit = $loader->album->edit( $album, $args );
if ( $edit === true ) $this->set_response("done");
else $this->set_error("Failed: {$edit}");

?>
