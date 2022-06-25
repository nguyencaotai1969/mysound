<?php

if ( !defined( "root" ) ) die;

$response = $loader->bot->spotify_create( $this->ps["type"], $this->ps["hook"] );
if ( !$response ) $this->set_error( "failed" );
$this->set_response( $response, false, false, true );

?>