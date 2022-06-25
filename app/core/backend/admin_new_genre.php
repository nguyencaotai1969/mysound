<?php

if ( !defined( "root" ) ) die;

$loader->genre->create( $this->ps["name"] );

$this->set_response( "done" );

?>