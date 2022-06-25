<?php

if ( !defined( "root" ) ) die;

$test = $loader->ftp->test();

if ( $test === true )
$this->set_response( "successful" );
$this->set_error( $test === false ? "failed" : $test );

?>
