<?php

if ( !defined( "root" ) ) die;

$loader->db->_update([
	"table" => "_users",
	"set" => [
	    [ "verified", "1" ],
	    [ "time_verify", "now()", true ]
    ],
	"where" => [
	    [ "ID", "=", $this->ps["ID"] ],
	    [ "verified", "=", "0" ]
    ],
]);

$this->set_response( "done" );

?>