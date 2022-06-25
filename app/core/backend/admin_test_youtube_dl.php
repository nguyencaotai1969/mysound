<?php

if ( !defined( "root" ) ) die;

$test = $loader->utube->download( 'XqZsoesa55w', true );

if ( $test[0] )
$this->set_response( "youtube_dl is working" );

else
$this->set_error( "Failed: {$test[1]}" );

?>
