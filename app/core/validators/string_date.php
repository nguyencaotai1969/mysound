<?php

if ( !defined( "root" ) ) die;

function validator_string_date( &$value, $args, $loader ){

	$time = false;
	extract( $args );

	// Check value type
	if ( !is_string( $value ) )
		return false;

	$parse_date = $loader->general->strtotime( $value );
	if ( !$parse_date ? true : !$parse_date[0] ) return false;

	if ( $time && $parse_date[1] < 5 )
		return false;

	$value = $parse_date[0];

	return true;

}

?>
