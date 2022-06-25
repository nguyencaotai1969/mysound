<?php

if ( !defined( "root" ) ) die;

function validator_string_spotify_id( &$value, $args, $loader ){
	
	return $loader->secure->validate(
		$value,
		"string",
		[
			"strict" => true,
			"strict_regex" => "[0-9a-zA-Z-_.]",
			"min_length" => 22,
			"max_length" => 22
		]
	);
	
}

?>