<?php

if ( !defined( "root" ) ) die;

$album = $loader->album->select(["hash"=>$this->ps["hook"]]);
if ( empty( $album ) ) $this->set_error( "invalid_hash", true );

// unlike
if ( $loader->visitor->user()->check_log( 14, $album["ID"] ) ){

	$loader->visitor->user()->remove_log([
		"type" => 14,
		"hook" => $album["ID"]
	]);
	$loader->db->query("UPDATE _m_albums SET likes = likes - 1 WHERE ID = '{$album["ID"]}' ");
	$loader->db->query("UPDATE _users SET likes = likes - 1 WHERE ID = {$loader->visitor->user()->ID}");
	if ( $album["user_id"] ) $loader->db->query("UPDATE _users SET media_likes = media_likes - 1 WHERE ID = {$album["user_id"]}");

}
// like
else {

	$loader->visitor->user()->add_log([
		"type" => 14,
		"hook" => $album["ID"],
		"user_id_2" => $album["user_id"] ? $album["user_id"] : null
	]);
	$loader->db->query("UPDATE _m_albums SET likes = likes + 1 WHERE ID = '{$album["ID"]}' ");
	$loader->db->query("UPDATE _users SET likes = likes + 1 WHERE ID = {$loader->visitor->user()->ID}");
	if ( $album["user_id"] ) $loader->db->query("UPDATE _users SET media_likes = media_likes + 1 WHERE ID = {$album["user_id"]}");

}

$this->set_response( "done" );

?>
