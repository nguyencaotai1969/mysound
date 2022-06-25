<?php

if ( !defined( "root" ) ) die;

function validator_int( &$value, $args, $loader ){
	
	$min = 1;
	$max = null;
	extract( $args );
	
	// Check value type
	if ( !in_array( gettype( $value ), [ "string", "integer", "float", "double" ], true ) )
		return false;
	
	$value = str_replace( ",", "", $value );
	$validate = is_numeric( $value );
	$value = intval( $value );
	
	if ( $validate && $min !== null ? $min > $value : false )
		$validate = false;
	
	if ( $validate && $max ? $max < $value : false )
		$validate = false;
	
	return $validate;
	
}

?>