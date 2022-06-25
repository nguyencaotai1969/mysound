<?php

if ( !defined( "root" ) ) die;

$page_data = $loader->ui->set_page_data();

if ( $page_data["step"] != 2 || empty( $page_data["valid"]["ID"] ) ) die;

if ( $this->ps["password"] != $this->ps["password2"] )
	$this->set_error("pws_no_match");

$hash_password = $loader->user->hash_password( $this->ps["password"] );

$loader->db->_update([
	"table" => "_users",
	"set"   => [
	    [ "verify_code", "null", true ],
	    [ "password", $hash_password ],
    ],
	"where" => [
	    [ "ID", "=", $page_data["valid"]["ID"] ]
    ]
]);

$this->set_response( "done" );

?>