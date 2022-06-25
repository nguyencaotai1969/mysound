<?php

if ( !defined( "root" ) ) die;

function validator_string( &$value, $args, $loader ){

	$min_length   = 1;
	$max_length   = null;
	$strict       = false;
	$only_utf8    = true;
	$strip_emoji  = false;
	$allow_eol    = false;
	$strict_regex = "[\p{L}0-9_.\-]";
	extract( $args );
	$validate = true;

	// Check value type
	if ( !in_array( gettype( $value ), [ "string", "integer", "float", "double" ], true ) )
		return false;

	// Prevent double encoding
	$value = htmlspecialchars_decode( strval( $value ), ENT_QUOTES );

	if ( $strict ){

		$validate = filter_var(
			$value,
			FILTER_VALIDATE_REGEXP,
			array(
				"options" => array(
					"regexp" => "/^{$strict_regex}{{$min_length},{$max_length}}$/u"
				)
			)
		) ? true : false;

	}

	if ( $min_length ? $min_length > mb_strlen( $value, "UTF-8" ) : false )
		$validate = false;

	if ( $max_length ? mb_strlen( $value, "UTF-8" ) > $max_length : false )
		$validate = false;

	$value = filter_var(
		$value,
		FILTER_SANITIZE_STRING,
		array(
			"flags" => FILTER_FLAG_STRIP_BACKTICK | FILTER_FLAG_ENCODE_AMP
		)
	);

	if ( $strip_emoji ){

		$value = preg_replace('%(?:
		\xF0[\x90-\xBF][\x80-\xBF]{2}
        | [\xF1-\xF3][\x80-\xBF]{3}
        | \xF4[\x80-\x8F][\x80-\xBF]{2}
		)%xs', '', $value);

		$regex_emoticons = '/[\x{1F600}-\x{1F64F}]/u';
		$value = preg_replace($regex_emoticons, '', $value);

        $regex_symbols = '/[\x{1F300}-\x{1F5FF}]/u';
        $value = preg_replace($regex_symbols, '', $value);

        $regex_transport = '/[\x{1F680}-\x{1F6FF}]/u';
        $value = preg_replace($regex_transport, '', $value);

        $regex_misc = '/[\x{2600}-\x{26FF}]/u';
        $value = preg_replace($regex_misc, '', $value);

        $regex_dingbats = '/[\x{2700}-\x{27BF}]/u';
        $value = preg_replace($regex_dingbats, '', $value);

		$regex_emoticons = '/[\x{1F600}-\x{1F64F}]/u';
        $value = preg_replace($regex_emoticons, '', $value);

        $regex_symbols = '/[\x{1F300}-\x{1F5FF}]/u';
        $value = preg_replace($regex_symbols, '', $value);

        $regex_transport = '/[\x{1F680}-\x{1F6FF}]/u';
        $value = preg_replace($regex_transport, '', $value);

	}

	if ( $only_utf8 ? !mb_check_encoding( $value, "UTF-8" ) : false )
		$value =  mb_convert_encoding($value, 'UTF-8', 'UTF-8');

	if ( !$allow_eol ){
		$value = preg_replace('/\s+/', ' ', trim( $value ) );
	}
	else {
		$value = str_replace( [ PHP_EOL . PHP_EOL . PHP_EOL, PHP_EOL . PHP_EOL ], [ PHP_EOL, PHP_EOL ], $value );
		$value = str_replace( [ "\r\n" . "\r\n" . "\r\n", "\r\n" . "\r\n" ], [ PHP_EOL, PHP_EOL ], $value );
		$value = str_replace( [ "\n" . "\n" . "\n", "\n" . "\n" ], [ PHP_EOL, PHP_EOL ], $value );
	}

	$value = trim( $value );

	return $validate;

}

?>
