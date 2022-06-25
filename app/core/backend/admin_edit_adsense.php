<?php

if ( !defined( "root" ) ) die;

// validate hook
if ( $this->ps["ID"] ){
	$ad = $loader->ads->select(["ID"=>$this->ps["ID"]]);
	if ( empty( $ad ) ) $this->set_error( "invalid_hook", true );
}

// validate placements
foreach( explode( ",", $this->ps["placements"] ) as $_pl ){
	if ( !in_array( $_pl, array_keys( $loader->ads->getPlacements() ) ) )
	$this->set_error( "invalid_placement", true );
	$valid_places[] = $_pl;
}
if ( empty( $this->ps["placements"] ) )
$this->set_error( "invalid_placement", true );

$sets = [];

$sets[] = [ "user_id", $this->loader->visitor->user()->ID ];
$sets[] = [ "type", "adsense" ];
$sets[] = [ "name", $this->ps["name"] ];
$sets[] = [ "code", $this->ps["code"] ];
$sets[] = [ "placements", $this->ps["placements"] ];
$sets[] = [ "active", $this->ps["active"] ];

if ( !empty( $ad ) ){
	$adID = $ad["ID"];
	$this->loader->db->_update(array(
		"table" => "_setting_ads",
		"set" => $sets,
		"where" => array(
			[ "ID", "=", $ad["ID"] ]
		)
	) );
}
else {
	$adID = $this->loader->db->_insert(array(
		"table" => "_setting_ads",
		"set" => $sets
	));
}

$this->db->query("DELETE FROM _setting_ads_placements WHERE ad_id = '{$adID}' ");

if ( !empty( $valid_places) ){
	foreach( $valid_places as $valid_place ){

		$this->db->_insert(array(
			"table" => "_setting_ads_placements",
			"set"   => array(
				[ "ad_id", $adID ],
				[ "placement_code", $valid_place ]
			)
		));

	}
}

$this->set_response( "done" );

?>
