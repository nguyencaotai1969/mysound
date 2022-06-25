<?php

if ( !defined( "root" ) ) die;

$verification_code_by_get = $loader->secure->get( "get", "verification_code", "md5", [ "length" => 9 ] );
if ( $verification_code_by_get &&
	 !empty( $_SESSION["verify_code"] ) ?
	   $verification_code_by_get == $_SESSION["verify_code"]
	: false
){

	$_select = $loader->db->_select([
		"table" => "_users",
		"where" => [
		    [ "verify_code", "=", $verification_code_by_get ],
		    [
		        "oper" => "OR",
		        "cond" => [
	                [ "verified", "=", "0" ],
	                [ "verified", null, null, true ],
	            ]
	        ],
		    [
		        "oper" => "OR",
		        "cond" => [
		            [ "time_verify_try", null, null, true ],
		            [ "time_verify_try", ">", "SUBDATE( now(), INTERVAL 2 HOUR )", true ]
	            ]
	        ]
	    ],
		"limit" => 1
	]);

	if ( !empty( $_select[0] ) ){

		$loader->db->_update([
			"table" => "_users",
			"set"   => [
			    [ "verified", "1" ],
			    [ "time_verify", "now()", true ],
			    [ "verify_code", "null", true ]
		    ],
			"where" => [
		        [ "ID", "=", $_select[0]["ID"] ]
	    	]
		]);

		$loader->hit->create_session( $_select[0]["ID"] );
		$loader->user->verified( $_select[0]["ID"] );

		header("Location: " . $loader->ui->rurl( null, "/?welcome" ) );
		die;

	}

}

$loader->html->set_title( $loader->lorem->turn( 'signup_h1', [ "uc" => true ] ) );

?>
