<?php

if ( !defined( "root" ) ) die;

$song = $loader->track->select(["hash"=>$this->ps["hash"]]);
if ( empty( $song ) ) $this->set_error( "invalid_hash", true );

// has this user reported this track before?
$check = $loader->db->_select([
	"table" => "_user_reports",
	"where" => [
		[ "user_id", "=", $loader->visitor->user()->ID ],
		[ "type", "=", 1 ],
		[ "hook", "=", $song["ID"] ]
	]
]);

if ( $check )
	$this->set_error( "already_done" );

// submit report
$rid = $loader->db->_insert([
	"table" => "_user_reports",
	"set" => [
		[ "user_id", $loader->visitor->user()->ID ],
		[ "type", 1 ],
		[ "reason", $this->ps["reason"] ],
		[ "hook", $song["ID"] ]
	]
]);

// Notify admins
$this->loader->admin->add_not([
	"type" => "68",
	"hook" => $loader->visitor->user()->ID,
	"AID"  => $rid,
	"extraData" => [ "track_title" => $song["title"] ]
]);

$this->set_response( "done" );

?>
