<?php

if ( !defined( "root" ) ) die;

$request_data = $loader->db->_select([
	"table" => "_user_artist_reqs",
	"where" => [ 
	    [ "ID", "=", $this->ps["ID"] ],
	    [
	        "oper" => "OR",
	        "cond" => [
	            [ "approved", "=", "0" ],
	            [ "approved", null, null, true ] 
            ]
        ]
    ]
]);

if ( empty( $request_data ) )
	$this->set_error( "invalid_id", true );

$request_data = reset( $request_data );
$user_data = $loader->user->select(["ID"=>$request_data["user_id"]]);
$loader->artist->create(["name"=>$request_data["stage_name"]]);
$artist_data = $loader->artist->select(["name"=>$request_data["stage_name"]]);

if ( $user_data["artist"] )
	$this->set_error("This user is already connected to a artist");
	
if ( $artist_data["user_id"] )
	$this->set_error("This artist is already connected to an user");

$loader->db->_update([
	"table" => "_users",
	"set"   => [
	    [ "artist", $artist_data["ID"] ],
	    [ "artist_code", $artist_data["code"] ]
    ],
	"where" => [[ "ID", "=", $user_data["ID"] ]]
]);

$loader->db->_update([
	"table" => "_m_artists",
	"set"   => [[ "user_id", $user_data["ID"] ]],
	"where" => [[ "ID", "=", $artist_data["ID"] ]]
]);

$loader->db->_update([
	"table" => "_user_artist_reqs",
	"where" => [["ID","=",$request_data["ID"]]],
	"set"   => [["approved","1"]]
]);

$this->set_response( "done" );

?>