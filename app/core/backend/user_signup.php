<?php

if ( !defined( "root" ) ) die;

if ( !$this->ps['terms_agreed'] )
	$this->set_error("terms_agreed_missing");
		
if ( $this->ps['password'] != $this->ps['password2'] )
	$this->set_error("pws_no_match");

$create = $loader->user->create( $this->ps["username"], $this->ps["email"], $this->ps["password"] );

if ( $create === true ){
	$this->set_response("done");
}

$this->set_error( $create );

?>