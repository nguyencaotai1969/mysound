<?php

if ( !defined( "root" ) ) die;

$playlist = $loader->playlist->select(["hash"=>$this->ps["hook"]]);
if ( empty( $playlist ) ) $this->set_error( "invalid_hash", true );

// unlike
if ( $loader->visitor->user()->check_log( 13, $playlist["ID"] ) ){

	$loader->user->remove_log([
		"type" => 13,
		"hook" => $playlist["ID"]
	]);
	$loader->db->query("UPDATE _user_playlists SET likes = likes - 1 WHERE ID = '{$playlist["ID"]}' ");
	$loader->db->query("UPDATE _users SET likes = likes - 1 WHERE ID = {$loader->visitor->user()->ID}");
	if ( $playlist["user_id"] ) $loader->db->query("UPDATE _users SET playlists_likes = playlists_likes - 1 WHERE ID = {$playlist["user_id"]}");

}
// like
else {

	$loader->user->add_log([
		"type" => 13,
		"hook" => $playlist["ID"],
		"user_id_2" => $playlist["user_id"] ? $playlist["user_id"] : null
	]);
	$loader->db->query("UPDATE _user_playlists SET likes = likes + 1 WHERE ID = '{$playlist["ID"]}' ");
	$loader->db->query("UPDATE _users SET likes = likes + 1 WHERE ID = {$loader->visitor->user()->ID}");
	if ( $playlist["user_id"] ) $loader->db->query("UPDATE _users SET playlists_likes = playlists_likes + 1 WHERE ID = {$playlist["user_id"]}");

}

$this->set_response( "done" );

?>
