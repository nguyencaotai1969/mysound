<?php

if ( !defined( "root" ) ) die;

$playlist = $loader->playlist->select(["hash"=>$this->ps["hook"]]);
if ( empty( $playlist ) ) $this->set_error( "invalid_hash", true );

// unfollowed
if ( $loader->visitor->user()->check_log( 12, $playlist["ID"] ) ){

	$loader->user->remove_log([
		"type" => 12,
		"hook" => $playlist["ID"]
	]);
	$loader->db->query("UPDATE _user_playlists SET followers = followers - 1 WHERE ID = '{$playlist["ID"]}' ");
	$loader->db->query("DELETE FROM _user_relations WHERE user_id = '{$loader->visitor->user()->ID}' AND rel_type = '12' AND target_id = '{$playlist["ID"]}' ");
	if ( $playlist["user_id"] ) $loader->db->query("UPDATE _users SET playlists_followers = playlists_followers - 1 WHERE ID = {$playlist["user_id"]}");

}
// followed
else {

	$loader->user->add_log([
		"type" => 12,
		"hook" => $playlist["ID"],
		"user_id_2" => $playlist["user_id"] ? $playlist["user_id"] : null
	]);
	$loader->db->query("UPDATE _user_playlists SET followers = followers + 1 WHERE ID = '{$playlist["ID"]}' ");
	$loader->db->query("INSERT INTO _user_relations ( user_id, rel_type, target_id ) VALUES ( '{$loader->visitor->user()->ID}', '12', '{$playlist["ID"]}' ) ");
	if ( $playlist["user_id"] ) $loader->db->query("UPDATE _users SET playlists_followers = playlists_followers + 1 WHERE ID = {$playlist["user_id"]}");

}

$this->set_response( "done" );

?>
