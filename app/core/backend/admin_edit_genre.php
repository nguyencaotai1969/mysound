<?php

if ( !defined( "root" ) ) die;

// ID validation
$genre = $loader->genre->select(["ID"=>$this->ps["ID"]]);
if ( empty( $genre ) ) $this->set_error( "invalid_ID", true );

// Image file validation
if ( $sent_file = $loader->secure->get( "file", "file" ) ){

	$verify_and_copy_image = $loader->general->save_image( $sent_file["tmp_name"], array(
		"input_ext"  => $sent_file["extension"],
		"output_ext" => $sent_file["extension"],
		"min_width"  => 100,
		"min_height" => 100,
		"dirname"    => "genres"
	));

	if ( empty( $verify_and_copy_image ) ){
		$this->set_error( "invalid_image", true );
	}

	$new_image = $loader->image
	->set( $verify_and_copy_image )
	->resize([
		"max_width"  => 800,
		"max_height" => 800,
		"min_width"  => 100,
		"min_height" => 100,
		"remove_src" => true
	])
	->get([
		"input_ext"  => $sent_file["extension"],
		"output_ext" => $sent_file["extension"],
		"basename" => $loader->general->image_dir,
		"dirname"  => "genres",
		"remove_src" => true
	]);

	if ( !empty( $genre["image_o"] ) )
	$loader->general->remove_file( $genre["image_o"] );

}

// Edit args
$args = array(
	"name"  => $this->ps["name"]
);
if ( !empty( $new_image ) ) $args["image"] = $new_image;

// Edit
$edit = $loader->genre->edit( $genre["ID"], $args );

if ( $edit === true ) $this->set_response("done");
else $this->set_error("Failed: {$edit}");

?>
