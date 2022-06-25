<?php

if ( !defined( "root" ) ) die;

$data = $loader->pay->select(["ID"=>$this->ps["ID"],"withdrawing"=>true]);
if ( !$data ) $this->set_error( "invalid_id", true );
if ( $data["paid"] ) $this->set_error( "already_marked", true );

$loader->db->_update([
	"table" => "_user_transaction",
	"set"   => [
	    [ "paid", "1" ],
	    [ "completed", "1" ],
	    [ "time_completed", "now()", true ]
    ],
	"where" => [["ID","=",$data["ID"]]]
]);

$this->set_response( "done" );

?>