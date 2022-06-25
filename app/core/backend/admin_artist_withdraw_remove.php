<?php

if ( !defined( "root" ) ) die;

$data = $loader->pay->select(["ID"=>$this->ps["ID"],"withdrawing"=>true]);
if ( !$data ) $this->set_error( "invalid_id", true );

$loader->pay->add_funds( $loader->visitor->user()->ID, $data["amount"] );

$loader->db->_delete([
	"table" => "_user_transaction",
	"where" => [["ID","=",$data["ID"]]]
]);

$this->set_response( "done" );

?>