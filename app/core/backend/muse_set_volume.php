<?php

if ( !defined( "root" ) ) die;

if ( !$this->loader->user->ID && 
	 !$this->loader->admin->get_setting( "guest_muse", 1, [ 0,1 ] ) 
) $this->set_error("invalid_request_3");

if ( $this->ps["volume"] >= 0 && $this->ps["volume"] <= 100 ){
	$_SESSION["play_volume"] = $this->ps["volume"];
}

$this->set_response( "done" );

?>