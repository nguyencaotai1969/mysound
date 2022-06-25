<?php

if ( !defined( "root" ) ) die;

$user   = $loader->user->select(["ID"=>$this->ps["user_id"]]);
$artist = $loader->artist->select(["ID"=>$this->ps["artist_id"]]);

if ( empty( $user ) || empty( $artist ) )
	$this->set_error("invalid_ids",true);

if ( $user["artist"] )
	$this->set_error("This user is already connected to artist:id:{$user["artist"]}");

if ( $artist["user_id"] )
	$this->set_error("This artist is already connected to user:id:{$artist["user_id"]}");

$loader->db->_update([
	"table" => "_users",
	"set"   => [
	    [ "artist", $artist["ID"] ],
	    [ "artist_code", $artist["code"] ]
    ],
	"where" => [[ "ID", "=", $user["ID"] ]]
]);

$loader->db->_update([
	"table" => "_m_artists",
	"set"   => [[ "user_id", $user["ID"] ]],
	"where" => [[ "ID", "=", $artist["ID"] ]]
]);

$this->set_response( "done" );

?>