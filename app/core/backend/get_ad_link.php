<?php

if ( !defined( "root" ) ) die;

$ad = $loader->ads->select([
	"order_no" => $this->ps["ad_id"],
	"active" => 1
]);

if ( empty( $ad ) )
$this->set_error( "invalid_id", true );

$loader->ads->update_acts( $ad["ID"], "clicks" );

if ( $ad["type"] == "banner_c" )
$loader->ads->update_fund( $ad, $loader->admin->get_setting( "banner_c_cost", 0.3 ) );

$this->set_response( $ad["url"] );

?>
