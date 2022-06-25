<?php

if ( !defined( "root" ) ) die;

$target_ID = $loader->user->username_exists( $this->ps["target"] );
if ( empty( $target_ID ) ) $this->set_error( "invalid_username", true );
if ( $target_ID == $loader->visitor->user()->ID ) $this->set_error( "invalid_username", true );

$followed = $loader->visitor->user()->check_log( 6, $target_ID );
$visitor_id = $loader->visitor->user()->ID;

// unfollow
if ( $followed ){

	$loader->user->remove_log([
		"type" => 6,
		"hook" => $target_ID
	]);
	$loader->db->query("UPDATE _users SET followers  = followers - 1 WHERE ID = {$target_ID} ");
	$loader->db->query("UPDATE _users SET followings = followings - 1 WHERE ID = {$visitor_id} ");
	$loader->db->query("DELETE FROM _user_relations WHERE user_id = '{$visitor_id}' AND rel_type = '6' AND target_id = '{$target_ID}' ");

}
// follow
else {

	$loader->visitor->user()->add_log([
		"type" => 6,
		"hook" => $target_ID,
		"user_id_2" => $target_ID
	]);
	$loader->db->query("UPDATE _users SET followers  = followers + 1 WHERE ID = {$target_ID} ");
	$loader->db->query("UPDATE _users SET followings = followings + 1 WHERE ID = {$visitor_id} ");
	$loader->db->query("INSERT INTO _user_relations ( user_id, rel_type, target_id ) VALUES ( '{$visitor_id}', '6', '{$target_ID}' ) ");

}

$this->set_response( "done" );

?>
