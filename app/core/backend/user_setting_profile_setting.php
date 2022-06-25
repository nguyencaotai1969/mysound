<?php

if ( !defined( "root" ) ) die;

$pagedata = $loader->ui->set_page_data();
if ( !$pagedata["owner"] ) $this->set_error( "invalid_data", true );
$user = $pagedata["user_data"];

if ( $sent_avatar = $loader->secure->get( "file", "avatar" ) ){

	$verify_and_copy_image = $loader->general->save_image( $sent_avatar["tmp_name"], array(
		"input_ext"  => $sent_avatar["extension"],
		"output_ext" => $sent_avatar["extension"],
		"min_width"  => 150,
		"min_height" => 150,
		"dirname"  => "uploaded_avatars"
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
	->square()
	->get([
		"input_ext"  => $sent_avatar["extension"],
		"output_ext" => $sent_avatar["extension"],
		"basename" => $loader->general->image_dir,
		"dirname"  => "uploaded_avatars"
	]);

	if ( !empty( $resize_image ) ){

		$stmt = $this->db->prepare("UPDATE _users SET avatar = ? WHERE ID = ?");
		$stmt->bind_param( "ss", $resize_image, $loader->visitor->user()->ID );
		$stmt->execute();
		$stmt->close();

		if ( !empty( $user["avatar_o"] ) ){
			$this->loader->general->remove_file( $user["avatar_o"] );
		}

	}

}
if ( $sent_bg_img = $loader->secure->get( "file", "bg_img" ) ){

	$verify_and_copy_image = $loader->general->save_image( $sent_bg_img["tmp_name"], array(
		"input_ext"  => $sent_bg_img["extension"],
		"output_ext" => $sent_bg_img["extension"],
		"min_width"  => 800,
		"min_height" => 400,
		"dirname"  => "uploaded_bg_img"
	));

	if ( empty( $verify_and_copy_image ) )
	$this->set_error( "invalid_image", true );

	$resize_image = $loader->image
	->set( $verify_and_copy_image )
	->resize([
		"max_width"  => 2000,
		"max_height" => 1400,
		"min_width"  => 800,
		"min_height" => 400,
		"remove_src" => true
	])
	->square()
	->get([
		"input_ext"  => $sent_bg_img["extension"],
		"output_ext" => $sent_bg_img["extension"],
		"basename"   => $loader->general->image_dir,
		"dirname"    => "uploaded_bg_img"
	]);

	if ( !empty( $resize_image ) ){

		$stmt = $this->db->prepare("UPDATE _users SET bg_img = ? WHERE ID = ?");
		$stmt->bind_param( "ss", $resize_image, $loader->visitor->user()->ID );
		$stmt->execute();
		$stmt->close();

		if ( !empty( $user["bg_img_o"] ) ){
			$this->loader->general->remove_file( $user["bg_img_o"] );
		}

	}

}

$external_addresses = json_encode( array(
	"website"    => $this->ps["website"],
	"facebook"   => $this->ps["facebook"],
	"instagram"  => $this->ps["instagram"],
	"soundcloud" => $this->ps["soundcloud"],
) );

$stmt = $this->db->prepare("UPDATE _users SET name = ?, external_addresses = ? WHERE ID = ?");
$stmt->bind_param( "sss", $this->ps["name"], $external_addresses, $loader->visitor->user()->ID );
$stmt->execute();
$stmt->close();

$this->set_response( "done" );

?>
