<?php

if ( !defined( "root" ) ) die;

// receipt image validation
if ( $sent_file = $loader->secure->get( "file", "receipt" ) ){

	$verify_and_copy_image = $loader->general->save_image( $sent_file["tmp_name"], array(
		"input_ext"  => $sent_file["extension"],
		"output_ext" => $sent_file["extension"],
		"min_width"  => 200,
		"min_height" => 200,
		"dirname"  => "uploaded_receipts"
	));

	if ( empty( $verify_and_copy_image ) ){
		$this->set_error( "invalid_image", true );
	}

	$resize_image = $loader->image
	->set( $verify_and_copy_image )
	->resize([
		"max_width"  => 800,
		"max_height" => 800,
		"min_width"  => 200,
		"min_height" => 200,
		"remove_src" => true
	])
	->get([
		"input_ext"  => $sent_file["extension"],
		"output_ext" => "jpg",
		"basename" => $loader->general->image_dir,
		"dirname"  => "uploaded_receipts",
		"final"    => false
	]);

}

if ( empty( $resize_image ) )
	$this->set_error( "invalid_image", true );

$loader->pay->record_payment( $this->ps["amount"], "bank_transfer", $resize_image );

$this->set_response( "done" );

?>
