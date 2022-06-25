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
		    [ "verified", "=", "1" ],
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
		$valid = $_select[0];
	} else {
		$valid = false;
	}

}

$loader->html->set_title( $loader->lorem->turn( 'recover_h1', [ "uc" => true ] ) );
$loader->ui->set_page_data([
	"step"  => isset( $valid ) ? 2 : 1,
	"valid" => !empty( $valid ) ? $valid : false
]);

?>
