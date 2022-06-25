<?php

if ( !defined( "root" ) ) die;

if ( !$this->loader->user->ID && 
	 !$this->loader->admin->get_setting( "guest_muse", 1, [ 0,1 ] ) 
) $this->set_error("invalid_request_3");

$loader->playlist->shuffle_que();

$this->set_response( "done" );

?>