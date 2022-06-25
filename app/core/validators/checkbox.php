<?php

if ( !defined( "root" ) ) die;

function validator_checkbox( &$value, $args, $loader ){
	
	$value = $value ? 1 : 0;
	return true;
	
}

?>