<?php

if ( !defined( "root" ) ) die;

// validate hook
$ad = $loader->ads->select(["ID"=>$this->ps["ID"]]);
if ( empty( $ad ) ) $this->set_error( "invalid_hook", true );

// validate placements
if ( $ad["type"] != "audio_v" ){
	foreach( explode( ",", $this->ps["placements"] ) as $_pl ){
		if ( !in_array( $_pl, array_keys( $loader->ads->getPlacements() ) ) )
		$this->set_error( "invalid_placement", true );
		$valid_places[] = $_pl;
	}
	if ( empty( $this->ps["placements"] ) )
	$this->set_error( "invalid_placement", true );
}
else {
	$this->ps["placements"] = "";
}

$this->db->_update([
	"table" => "_setting_ads",
	"set"   => [
		[ "name", $this->ps["name"] ],
		[ "url", $this->ps["url"] ],
		[ "placements", $this->ps["placements"] ],
		[ "fund_total", $this->ps["fund_total"] ],
		[ "fund_spent", $this->ps["fund_spent"] ],
		[ "fund_remain", $this->ps["fund_remain"] ],
		[ "fund_limit", $this->ps["fund_limit"] ],
		[ "fund_spent_day", $this->ps["fund_spent_day"] ],
		[ "fund_spent_day_code", date("ymd") ],
		[ "active", $this->ps["active"] ],
	],
	"where" => [
		[ "ID", "=", $this->ps["ID"] ]
	]
]);

$this->db->query("DELETE FROM _setting_ads_placements WHERE ad_id = '{$this->ps["ID"]}' ");
if ( !empty( $valid_places) ){
	foreach( $valid_places as $valid_place ){
		$this->db->_insert(array(
			"table" => "_setting_ads_placements",
			"set"   => array(
				[ "ad_id", $this->ps["ID"] ],
				[ "placement_code", $valid_place ]
			)
		));
	}
}

$this->set_response( "done" );

?>
