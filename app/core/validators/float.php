<?php

if ( !defined( "root" ) ) die;

function validator_float( &$value, $args, $loader ){
	
	$min = 0;
	$max = null;
	extract( $args );
	
	// Check value type
	if ( !in_array( gettype( $value ), [ "string", "integer", "float", "double" ], true ) )
		return false;
	
	$validate = gettype( filter_var( 
		$value, 
		FILTER_VALIDATE_FLOAT
	) ) === "double";
	
	$value = filter_var( 
		$value, 
		FILTER_SANITIZE_NUMBER_FLOAT, 
		array(
			"flags" => FILTER_FLAG_ALLOW_FRACTION | FILTER_FLAG_ALLOW_THOUSAND
		) 
	);
		
	if ( $validate && $min !== null ? $min > $value : false ){
		$validate = false;
		echo 1;
	}
	
	if ( $validate && $max ? $value > $max : false ){
		$validate = false;
		echo 2;
	}
	
	return $validate;
	
}

?>