<?php

if ( !defined( "root" ) ) die;

$playlist = $loader->playlist->select([
	"hash"    => $this->ps["playlist_hash"],
	"user_id" => $loader->user->ID,
	"collabed_in_id" => $loader->user->ID
]);

$track = $loader->track->select([
	"hash" => $this->ps["track_hash"]
]);

if ( empty( $playlist ) || empty( $track ) )
	$this->set_error( "invalid_hash", true );

$loader->playlist->lessen( $playlist["ID"], $track["ID"] );
$loader->db->query("UPDATE _m_tracks SET playlisteds = playlisteds - 1 WHERE ID = '{$track["ID"]}' ");

$this->set_response( "done" );

?>
