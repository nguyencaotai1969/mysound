<?php

if ( !defined( "root" ) ) die;

$loader->db->query( "UPDATE _user_sessions SET active = 0 WHERE user_id = '{$loader->visitor->user()->ID}' AND ID = '{$this->ps["ID"]}' AND active = 1 " );

$this->set_response( "done" );

?>