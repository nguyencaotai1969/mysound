<?php

if ( !defined( "root" ) ) die;

$song  = $loader->track->select(["hash"=>$this->ps["hash"]]);
if ( empty( $song ) ) $this->set_error( "invalid_hash", true );

// unlike
if ( ( $liked = $loader->visitor->user()->check_log( 1, $song["ID"] ) ) ){

	$loader->visitor->user()->remove_log([
		"type" => 1,
		"hook" => $song["ID"]
	]);
	$loader->db->query("UPDATE _m_tracks SET likes = likes - 1 WHERE ID = {$song["ID"]} ");
	$loader->db->query("UPDATE _users SET likes = likes - 1 WHERE ID = {$loader->visitor->user()->ID}");
	if ( $song["user_id"] ) $loader->db->query("UPDATE _users SET media_likes = media_likes - 1 WHERE ID = {$song["user_id"]}");

}
// like
else {

	$loader->visitor->user()->add_log([
		"type"      => 1,
		"hook"      => $song["ID"],
		"user_id_2" => $song["user_id"] ? $song["user_id"] : null
	]);
	$loader->db->query("UPDATE _m_tracks SET likes = likes + 1 WHERE ID = {$song["ID"]} ");
	$loader->db->query("UPDATE _users SET likes = likes + 1 WHERE ID = {$loader->visitor->user()->ID}");
	if ( $song["user_id"] ) $loader->db->query("UPDATE _users SET media_likes = media_likes + 1 WHERE ID = {$song["user_id"]}");

}

$this->set_response( $liked ? "unliked" : "liked" );

?>
