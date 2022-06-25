<?php

if ( !defined( "root" ) ) die;

$song  = $loader->track->select(["hash"=>$this->ps["hash"]]);
if ( empty( $song ) ) $this->set_error( "invalid_hash", true );

// unrepost
if ( ( $reposted = $loader->visitor->user()->check_log( 2, $song["ID"] ) ) ){

	$loader->visitor->user()->remove_log([
		"type" => 2,
		"hook" => $song["ID"]
	]);
	$loader->db->query("UPDATE _m_tracks SET reposts = reposts - 1 WHERE ID = {$song["ID"]} ");
	$loader->db->query("UPDATE _users SET reposts = reposts - 1 WHERE ID = '{$loader->visitor->user()->ID}' ");

}
// repost
else {

	$loader->visitor->user()->add_log([
		"type" => 2,
		"hook" => $song["ID"],
		"user_id_2" => $song["user_id"] ? $song["user_id"] : null
	]);
	$loader->db->query("UPDATE _m_tracks SET reposts = reposts + 1 WHERE ID = {$song["ID"]} ");
	$loader->db->query("UPDATE _users SET reposts = reposts + 1 WHERE ID = '{$loader->visitor->user()->ID}' ");

}

$this->set_response( $reposted ? "unreposted" : "reposted" );

?>
