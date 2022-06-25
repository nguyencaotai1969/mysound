<?php

if ( !defined( "root" ) ) die;

$artist = $loader->artist->select(["code"=>$this->ps["code"]]);
if ( empty( $artist ) ) $this->set_error( "invalid_code", true );

$followed = $loader->visitor->user()->check_log( 10, $artist["ID"] );
$visitor_id = $loader->visitor->user()->ID;

if ( $followed ){
	$loader->visitor->user()->remove_log([
		"type" => 10,
		"hook" => $artist["ID"]
	]);
	$loader->db->query("UPDATE _m_artists SET followers  = followers - 1 WHERE ID = {$artist["ID"]} ");
	$loader->db->query("DELETE FROM _user_relations WHERE user_id = '{$visitor_id}' AND rel_type = '10' AND target_id = '{$artist["ID"]}' ");
}
else {
	$loader->visitor->user()->add_log([
		"type" => 10,
		"hook" => $artist["ID"]
	]);
	$loader->db->query("UPDATE _m_artists SET followers  = followers + 1 WHERE ID = {$artist["ID"]} ");
	$loader->db->query("INSERT INTO _user_relations ( user_id, rel_type, target_id ) VALUES ( '{$visitor_id}', '10', '{$artist["ID"]}' ) ");
}

$this->set_response( "done" );

?>
