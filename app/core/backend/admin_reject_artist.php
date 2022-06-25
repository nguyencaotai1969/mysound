<?php

if ( !defined( "root" ) ) die;

$request_data = $loader->db->_select([
	"table" => "_user_artist_reqs",
	"where" => [ 
	    [ "ID", "=", $this->ps["ID"] ],
	    [
	        "oper" => "OR",
	        "cond" => [
	            [ "approved", "=", "1" ],
	            [ "approved", null, null, true ] 
            ]
        ]
    ]
]);

if ( empty( $request_data ) )
	$this->set_error( "invalid_id", true );

$request_data = reset( $request_data );

$loader->db->_update([
	"table" => "_user_artist_reqs",
	"where" => [["ID","=",$request_data["ID"]]],
	"set"   => [["approved","0"]]
]);

$this->set_response( "done" );

?>