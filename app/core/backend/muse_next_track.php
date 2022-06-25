<?php

if ( !defined( "root" ) ) die;

if ( !$this->loader->user->ID && 
	 !$this->loader->admin->get_setting( "guest_muse", 1, [ 0,1 ] ) 
) $this->set_error("invalid_request_3");

$loader->playlist->mark_pre_que();

// Get que
$que = $loader->playlist->get_que();

// Anything qued?
if ( empty( $que ) ) $this->set_error( "no_qued_song", true );

$repeat = isset( $_SESSION["play_repeat"] ) ? $_SESSION["play_repeat"] : true;
$first_que = array_shift( $que );
if ( $repeat ) array_push( $que, $first_que );

// Save que list
$_SESSION["play_que"] = json_encode( $que );

$this->set_response( "done" );

?>