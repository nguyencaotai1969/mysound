<?php

if ( !defined( "root" ) ) die;

$user   = $this->ps["user_id"] ? $loader->user->select(["ID"=>$this->ps["user_id"]]) : false;
$artist = $this->ps["artist_id"] ? $loader->artist->select(["ID"=>$this->ps["artist_id"]]) : false;

if ( empty( $user ) && empty( $artist ) )
	$this->set_error("invalid_id",true);

$target_user = $target_artist = null;

if ( $user ){
	$target_user   = $user["ID"];
	$target_artist = $user["artist"];
} else {
	$target_user   = $artist["user_id"];
	$target_artist = $artist["ID"];
}

if ( $target_user ){
	$loader->db->_update([
	    "table" => "_users",
	    "set"   => [
	        [ "artist", "null", true ],
	        [ "artist_code", "null", true ]
        ],
	    "where" => [[ "ID", "=", $target_user ]]
    ]);
}

if ( $target_artist ){
    $loader->db->_update([
	    "table" => "_m_artists",
	    "set"   => [[ "user_id", "null", true ]],
	    "where" => [[ "ID", "=", $target_artist ]]
    ]);
}

$this->set_response( "done" );

?>