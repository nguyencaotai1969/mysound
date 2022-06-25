<?php

if ( !defined( "root" ) ) die;

$login = $loader->user->check_auth( $this->ps["email"], $this->ps["password"] );

if ( is_int( $login ) ){
	$loader->hit->create_session( $login );
	$this->set_response( "welcome" );
}

$this->set_error( $login );

?>