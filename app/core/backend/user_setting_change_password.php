<?php

if ( !defined( "root" ) ) die;

if ( !$loader->user->verify_password( $this->ps["password"], $loader->visitor->user()->data["password"] ) ){
	$this->set_error("incorrect_password");
}

if ( $this->ps["npassword"] != $this->ps["npassword2"] ){
	$this->set_error("new_passwords_dont_match");
}

$loader->visitor->user()->change_password( $this->ps["npassword"] );

$this->set_response( "done" );

?>