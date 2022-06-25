<?php

if ( !defined( "root" ) ) die;

function validator_string_code( &$value, $args, $loader ){
	
	$validate = $loader->secure->validate(
		$value,
		"string",
		[
			"strict" => true,
			"strict_regex" => "[\p{L}0-9]"
		]
	);
	
	$value = $loader->general->make_code( $value );
	
	return $validate;
	
}

?>