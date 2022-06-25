<?php

if ( !defined( "root" ) ) die;

$test = $loader->aws->test();

if ( $test )
$this->set_response( "successful" );
$this->set_error( "failed" );

?>
