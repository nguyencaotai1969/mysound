<?php

if ( !defined( "root" ) ) die;

function validator_string_color_hex( &$value, $args, $loader ){

	// Check value type
	if ( !is_string( $value ) )
		return false;

	if ( !$loader->secure->validate( $value, "string" ) )
		return false;

	$validate = preg_match( "/#([a-f]|[A-F]|[0-9]){6}?\b/", $value ) || preg_match( "/([a-f]|[A-F]|[0-9]){6}?\b/", $value );

	return $value;
}

?>
