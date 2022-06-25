<?php

if ( !defined( "root" ) ) die;

$get_playlist = $loader->playlist->select(array(
	"hash"    => $this->ps["hash"],
	"user_id" => $loader->user->ID
));

if ( empty( $get_playlist["ID"] ) ){
	$this->set_error( "bad_hash", true );
}

$loader->db->query("UPDATE _users SET playlists = playlists - 1 WHERE ID = '{$loader->visitor->user()->ID}' ");
$loader->playlist->remove( $get_playlist["ID"] );

$this->set_response( "done" );

?>
