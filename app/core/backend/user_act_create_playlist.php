<?php

if ( !defined( "root" ) ) die;

$create_playlist = $loader->playlist->create(array(
	"name" => $this->ps["name"]
));

if ( is_array( $create_playlist ) ){
	$loader->db->query("UPDATE _users SET playlists = playlists + 1 WHERE ID = '{$loader->visitor->user()->ID}' ");
	$this->set_response( $create_playlist[1]["url"], false, false, true );
}
else {
	$this->set_error( $create_playlist );
}

?>
