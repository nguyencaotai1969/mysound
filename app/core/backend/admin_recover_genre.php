<?php

if ( !defined( "root" ) ) die;

$genre = $loader->genre->select(["ID"=>$this->ps["ID"],"deleted"=>true]);
if ( empty( $genre ) ) $this->set_error( "invalid_ID", true );
$loader->genre->recover( $genre );
$this->set_response( "done" );

?>