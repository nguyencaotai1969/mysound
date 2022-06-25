<?php

if ( !defined( "root" ) ) die;

function validator_boolean( &$value, $args, $loader ){

	// Check value type
	if ( !in_array( gettype( $value ), [ "string", "integer", "float", "double", "boolean" ], true ) )
		$value = 0;
	
	$value = filter_var( 
		$value,
		FILTER_VALIDATE_BOOLEAN
	) ? 1 : 0;
	
	return true;
	
}

?>