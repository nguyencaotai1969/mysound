<?php

if ( !defined( "root" ) ) die;

$page_data = $loader->ui->set_page_data();

if ( $page_data["playlist"]["hash"] != $this->ps["hook"] )
$this->set_error( "invalid_hook", true );

if ( $page_data["playlist"]["owner"]["ID"] != $loader->visitor->user()->ID )
$this->set_error( "invalid_hook", true );
$playlist = $page_data["playlist"];

// Image file validation
if ( $sent_file = $loader->secure->get( "file", "cover" ) ){

	$verify_and_copy_image = $loader->general->save_image( $sent_file["tmp_name"], array(
		"input_ext"  => $sent_file["extension"],
		"output_ext" => $sent_file["extension"],
		"min_width"  => 200,
		"min_height" => 200,
		"dirname"  => "playlists"
	));

	if ( empty( $verify_and_copy_image ) )
	$this->set_error( "invalid_image", true );

	$new_image = $loader->image
	->set( $verify_and_copy_image )
	->resize([
		"max_width"  => 1500,
		"max_height" => 1500,
		"min_width"  => 200,
		"min_height" => 200,
		"remove_src" => true
	])
	->square([
		"remove_src" => true
	])
	->get([
		"input_ext"  => $sent_file["extension"],
		"output_ext" => $sent_file["extension"],
		"basename"   => $loader->general->image_dir,
		"dirname"    => "playlists",
		"remove_src" => true
	]);

	if ( !empty( $playlist["cover_o"] ) )
	$loader->general->remove_file( $playlist["cover_o"] );

	if ( $new_image );
	$args["cover"] = $new_image;

}

// Collabs
$collabs = [];
if ( !empty( $this->ps["collabs"] ) ){
	foreach( explode( ",", $this->ps["collabs"] ) as $collab ){

		if ( !$loader->secure->validate( $collab, "username" ) )
		$this->set_error( "bad_username", true );

		if ( !( $collab_id = $loader->user->username_exists( $collab ) ) )
		$this->set_error( $loader->lorem->turn( "username_no_exists", [ "params" => [ "username" => $collab ] ] ) );

		if ( $collab_id == $playlist["owner"]["ID"] )
		continue;

		$collabs[ $collab_id ] = $loader->user->select(["ID"=>$collab_id]);

	}
	if ( !empty( $collabs ) )
	$args["collabs"] = $collabs;
}

// Name change
$args["name"] = $this->ps["name"];
$loader->playlist->edit( $playlist["ID"], $args );

$this->set_response( "done" );

?>
