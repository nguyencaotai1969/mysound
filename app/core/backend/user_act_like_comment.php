<?php

if ( !defined( "root" ) ) die;

$get_comment = $loader->db->query("SELECT * FROM _user_comments WHERE target_type = 'track' AND ID = '{$this->ps["ID"]}' AND approved = 1 ");
if ( !$get_comment->num_rows || $loader->ui->page_type != "track" ) $this->set_error( "invalid_request", true );
$comment = $get_comment->fetch_assoc();

if ( $comment["user_id"] == $loader->visitor->user()->ID )
$this->set_error( "cant_like_own_cm" );

// unlike
if ( $loader->user->check_log( 8, $this->ps["ID"] ) ){

  $loader->user->remove_log([
    "type" => 8,
    "hook" => $this->ps["ID"]
  ]);
  $loader->db->_update([
    "table" => "_user_comments",
    "set" => [
      [ "likes", "likes - 1", true ]
    ],
    "where" => [
      [ "ID", "=", $this->ps["ID"] ]
    ]
  ]);
  $loader->db->query("UPDATE _users SET likes = likes - 1 WHERE ID = {$loader->visitor->user()->ID}");
	if ( $comment["user_id"] ) $loader->db->query("UPDATE _users SET comments_likes = comments_likes - 1 WHERE ID = {$comment["user_id"]}");

}
// like
else {

  $loader->user->add_log([
    "type" => 8,
    "hook" => $this->ps["ID"],
    "user_id_2" => $comment["user_id"]
  ]);
  $loader->db->_update([
    "table" => "_user_comments",
    "set" => [
      [ "likes", "likes + 1", true ]
    ],
    "where" => [
      [ "ID", "=", $this->ps["ID"] ]
    ]
  ]);
  $loader->db->query("UPDATE _users SET likes = likes + 1 WHERE ID = {$loader->visitor->user()->ID}");
	if ( $comment["user_id"] ) $loader->db->query("UPDATE _users SET comments_likes = comments_likes + 1 WHERE ID = {$comment["user_id"]}");

}

$this->set_response( "done" );

?>
