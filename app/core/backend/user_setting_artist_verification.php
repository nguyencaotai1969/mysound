<?php

if ( !defined( "root" ) ) die;

if ( $sent_file = $loader->secure->get( "file", "file" ) ){

	$verify_and_copy_image = $loader->general->save_image( $sent_file["tmp_name"], array(
		"input_ext"  => $sent_file["extension"],
		"output_ext" => $sent_file["extension"],
		"min_width"  => 200,
		"min_height" => 200,
		"dirname"  => "uploaded_docs"
	));

	if ( empty( $verify_and_copy_image ) ){
		$this->set_error( "invalid_image", true );
	}

	$resize_image = $loader->image
	->set( $verify_and_copy_image )
	->resize([
		"max_width"  => 2000,
		"max_height" => 2000,
		"min_width"  => 200,
		"min_height" => 200,
		"remove_src" => true
	])
	->get([
		"input_ext"  => $sent_file["extension"],
		"output_ext" => "jpg",
		"basename"   => $loader->general->image_dir,
		"dirname"    => "uploaded_docs",
		"final"      => false
	]);

	$files = [ $resize_image ];

}

$loader->db->_insert([
	"table" => "_user_artist_reqs",
	"set" => [
	    [ "user_id", $loader->visitor->user()->ID ],
	    [ "real_name", $this->ps["real_name"] ],
	    [ "stage_name", $this->ps["stage_name"] ],
	    [ "data", $this->ps["data"] ],
	    [ "files", !empty( $files ) ? json_encode( $files ) : "[]" ],
    ]
]);

// Notify admins
$this->loader->admin->add_not([
	"type" => "70",
	"hook" => $loader->visitor->user()->ID,
	"extraData" => [ "stage_name" => $this->ps["stage_name"] ]
]);

$this->set_response( "done" );

?>
