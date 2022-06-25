<?php

if ( !defined( "root" ) ) die;

// Validate old ( removed ) tracks
foreach( explode( ",", $this->ps["tracks"] ) as $_old_track_id ){

	if ( !$loader->secure->validate( $_old_track_id, "int" ) )
		$this->set_error( "invalid_old_track", true );

	$old_track = $loader->track->select(["ID"=>$_old_track_id ]);

	if ( empty( $old_track ) )
		$this->set_error( "invalid_old_track", true );

}

// Remove old genres one by one
foreach( explode( ",", $this->ps["tracks"] ) as $_old_track_id ){
	$loader->db->_update([
		"table" => "_user_reports",
		"set" => [
			[ "dismissed", 1 ]
		],
		"where" => [
			[ "type", "=", "1" ],
			[ "hook", "=", $_old_track_id ]
		]
	]);
}

$this->set_response( "done" );

?>
