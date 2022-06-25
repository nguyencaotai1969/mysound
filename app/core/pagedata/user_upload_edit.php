<?php

if ( !defined( "root" ) ) die;

// Validate && sanitize requested ID
if ( !( $upload_ID = $loader->secure->get( "get", "ID", "md5", [ "length" => 20 ] ) ) ){
	$loader->ui->page_hook = $loader->ui->page_type;
	$loader->ui->page_type = "no_access";
	return;
}

$uploadings = $loader->upload->get( [ "uploadID" => $upload_ID ] );
if ( empty( $uploadings["uploadings"] ) ){
	$loader->ui->page_hook = $loader->ui->page_type;
	$loader->ui->page_type = "no_access";
	return;
}

foreach( $uploadings["albums"] as &$_album ){

	foreach( $_album["tracks"] as $_album_track_rID ){
		$_album["tracks_full"][ $_album_track_rID ] = $uploadings["tracks"][ $_album_track_rID ];
	}

	usort( $_album["tracks_full"], function($a, $b) {
		return $a['album_order'] - $b['album_order'];
	});

}

$uploadings["genres"] = $loader->genre->get_all_simplfied();
$uploadings["ID"] = $upload_ID;

$uploadings["prices"][] = [ 0, $loader->lorem->turn( "free", ["uc"=>true] ) ];
foreach( explode( ",", $this->loader->admin->get_setting( "sell_music_prices" ) ) as $price )
	$uploadings["prices"][] = [ $price, "{$price}$" ];

$this->page_data = $uploadings;

$loader->ui->set_title();

?>
