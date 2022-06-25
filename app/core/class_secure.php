<?php

if ( !defined( "root" ) ) die;

class secure {

	public function __construct( $loader ){

		$this->loader = $loader;
		if ( !empty( $loader->db ) )
		$this->db = $loader->db;

	}
	protected function call_function( $type ){

		if ( file_exists( root . "/app/core/validators/" . $type . ".php" ) )
			require_once( root . "/app/core/validators/" . $type . ".php" );

		if ( !function_exists( "validator_{$type}" ) )
			die("validator_{$type} is missing");

	}
	public function validate( &$value, $type, $args=[] ){

		$can_be_empty = !is_array( $value ) && in_array( 'empty()', $args, true );
		$original_value = $value;
		$value = in_array( 'array()', $args, true ) ? $value : [ $value ];
		$valid  = true;

		foreach( $value as &$_value ){

			$function_name = "validator_{$type}";
		    if ( !function_exists( "validator_{$type}" ) )
				$this->call_function( $type );

			$validate = $function_name( $_value, $args, $this->loader );
			if ( !$validate ) $valid = false;

		}

		if ( !in_array( 'array()', $args, true ) )
			$value = reset( $value );

		if ( $can_be_empty && empty( $original_value ) )
			$valid = true;

		return $valid;

	}
	public function get( $type, $name, $validator_type=null, $validator_args=[], $default_value=null ){

		// Get input
		$input = null;
		if ( $type == "post" ? isset( $_POST[ $name ] ) : false )
			$input = $_POST[ $name ];
		elseif( $type == "get" ? isset( $_GET[ $name ] ) : false )
			$input = $_GET[ $name ];
		elseif( $type == "file" ? isset( $_FILES[ $name ] ) : false ){
			$input = $_FILES[ $name ];
			$validator_type = "file";
		}
		elseif( $type == "cookie" ? isset( $_COOKIE[ $name ] ) : false )
			$input = $_COOKIE[ $name ];
		elseif ( $type == "server" ? isset( $_SERVER[ $name ] ) : false )
		  $input = $_SERVER[ $name ];

		// Check input existence
		if ( is_null( $input ) )
			return $default_value;

		// Need raw ( unvalidated && unsanitized ) input?
		if ( !$validator_type )
			return $input;

		// Validate && Sanitize input
		$validate = $this->validate( $input, $validator_type, $validator_args );
		if ( !$validate ) return $default_value;

		// Input is valid & it was passed as a refernce to `validate` function so it's also sanitized
		return $input;

	}
	public function escape( $string ){
		return htmlspecialchars( $string, ENT_QUOTES, 'UTF-8', false );
	}

}

?>
