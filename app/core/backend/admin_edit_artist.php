<?php

if ( !defined( "root" ) ) die;

$artist = $loader->artist->select(["ID"=>$this->ps["ID"]]);
if ( empty( $artist ) ) $this->set_error( "invalid_ID", true );

// Image file validation
if ( $sent_file = $loader->secure->get( "file", "image" ) ){

	$verify_and_copy_image = $loader->general->save_image( $sent_file["tmp_name"], array(
		"input_ext"  => $sent_file["extension"],
		"output_ext" => $sent_file["extension"],
		"min_width"  => 200,
		"min_height" => 200,
		"dirname"  => "artists"
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
		"output_ext" => $sent_file["extension"],
		"basename" => $loader->general->image_dir,
		"dirname"  => "artists",
		"remove_src" => true
	]);

	if ( !empty( $artist["image_o"] ) )
	$loader->general->remove_file( $artist["image_o"] );

}

$args = array(
	"name"         => $this->ps["name"],
	"spotify_id"   => $this->ps["spotify_id"],
);

if ( !empty( $new_image ) ) $args["image"] = $new_image;

$edit = $loader->artist->edit( $artist, $args );

if ( $edit === true ) $this->set_response("done");
else $this->set_error("Failed: {$edit}");

?>
