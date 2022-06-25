<?php

if ( !defined( "root" ) ) die;

// Handle uploadings
$uploadings = $loader->ui->set_page_data();

if ( empty( $uploadings["albums"][ $this->ps["album_code"] ][ "tracks_full" ] ) )
	$this->set_error( "failed", true );

$__tracks = $uploadings["albums"][ $this->ps["album_code"] ][ "tracks_full" ];

// Handle Image
$sent_image = $loader->secure->get( "file", "file" );
if ( !$sent_image )
	$this->set_error( "failed" );

$verify_and_copy_image = $loader->general->save_image( $sent_image["tmp_name"], array(
	"input_ext"  => $sent_image["extension"],
	"min_width"  => $loader->admin->get_setting( "upload_min_cover", 400 ),
	"min_height" => $loader->admin->get_setting( "upload_min_cover", 400 )
));

if ( !empty( $verify_and_copy_image ) ){

	$resize_image = $loader->image
		->set( $verify_and_copy_image )
		->resize([
			"max_width"  => 2000,
			"max_height" => 2000,
			"min_width"  => $loader->admin->get_setting( "upload_min_cover", 400 ),
			"min_height" => $loader->admin->get_setting( "upload_min_cover", 400 ),
			"remove_src" => true
		])
		->square()
		->get([
			"basename" => $loader->general->uploading_dir,
			"dirname"  => "uploaded_covers",
			"final"    => false
		]);

}

if ( !empty( $resize_image ) ){

	foreach( $__tracks as $__track ){

		$__tfd = json_decode(stripslashes($loader->db->query("SELECT finalData FROM _user_uploads WHERE ID = '{$__track["ID"]}' ")->fetch_assoc()["finalData"]),1);
		$__tfd["cover"] = $__tfd["album_cover"] = $resize_image;
		$__tfde = $loader->general->json_encode( $__tfd );

		$stmt = $this->db->prepare("UPDATE _user_uploads SET finalData = ? WHERE ID = ?");
		$stmt->bind_param( "ss", $__tfde, $__track["ID"] );
		$stmt->execute();
		$stmt->close();

	}

	sleep( 0.3 );
	$this->set_response( "done" );

}

$this->set_error( "failed" );

?>
