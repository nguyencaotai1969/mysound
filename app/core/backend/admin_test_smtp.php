<?php

if ( !defined( "root" ) ) die;

set_time_limit( 10 );
ini_set( 'max_execution_time', 10 );

$test = $loader->email->test_smtp();
$tester_user = $this->loader->visitor->user()->data;

if ( $test === true )
$this->set_response( "Everything seem to be working. Check {$tester_user["email"]} for email" );

$this->set_error( $test );

?>
