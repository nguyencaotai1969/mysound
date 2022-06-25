<?php

if ( !defined( "root" ) ) die;

$playlists = $loader->playlist->select([
	"user_id" => $loader->visitor->user()->ID,
	"collabed_in_id" => $loader->visitor->user()->ID,
	"limit" => 100
]);

if ( empty( $playlists ) ){
	$html = $loader->lorem->turn( "no_playlist" );
}
else {

	$html = "<select class='form-control' name='playlist_hash'>";
	foreach( $playlists as $playlist )
		$html .= "<option value='{$playlist["hash"]}'>{$playlist["name"]}</option>";
	$html .= "</select>";

}

$this->set_response( $html, false, false, true );

?>
