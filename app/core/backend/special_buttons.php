<?php

if ( !defined( "root" ) ) die;

$type = $this->ps["type"];
if( $type == "track" ){
	$data = $loader->track->select([
		"hash" => $this->ps["hash"],
		"_eg" => [ "liked", "reposted", "playlisted", "paid", "download_able" ]
	]);
}
elseif ( $type == "playlist" ){
	$data = $loader->playlist->select([
		"hash" => $this->ps["hash"],
		"_eg" => [ "liked", "followed", "owner", "collabs" ]
	]);
}

$html = $loader->theme->set_name('__default')->__req( "parts/m_buttons.php", false, [ "no_ul" => true, "type" => $type, "item" => $data ] );

$this->set_response( $html, false, false, true );

?>
