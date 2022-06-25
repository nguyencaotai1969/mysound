<?php

if ( !defined( "root" ) ) die;

$loader->db->query("UPDATE _user_sessions SET active = 0 WHERE session_id = '".(session_id())."' ");
session_destroy();

?>