<?php

if ( !defined( "root" ) ) die;

$comment = $loader->db->query("SELECT * FROM _user_comments WHERE user_id = '{$loader->user->ID}' AND target_type = 'track' AND ID = '{$this->ps["ID"]}' AND approved = 1 ");
if ( !$comment->num_rows ) $this->set_error( "invalid_request", true );

$loader->comment->delete( $this->ps["ID"] );

$this->set_response( "done" );

?>