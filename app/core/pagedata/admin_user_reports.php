<?php

if ( !defined( "root" ) ) die;

$reports = $loader->db->_select([
	"table" => "_user_reports",
	"where" => [
		[ "dismissed", null, null, true ]
	],
	"limit" => 500
]);

if ( !empty( $reports ) ){
	foreach( $reports as &$_report ){
		$_report["track"] = $loader->track->select([
			"ID" => $_report["hook"]
		]);
		$_report["user"] = $loader->user->select([
			"ID" => $_report["user_id"]
		]);
	}
	unset( $_report );
}

$this->set_page_data([
	"items"  => $reports,
]);

$loader->html->set_title( "User Reports" );

?>
