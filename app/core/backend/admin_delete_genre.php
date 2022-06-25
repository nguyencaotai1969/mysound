<?php

if ( !defined( "root" ) ) die;

if ( $this->ps["ID"] == 1 )
$this->set_error( "Can't delete no-genre", true );

$genre = $loader->genre->select(["ID"=>$this->ps["ID"],"deleted"=>true]);

if ( empty( $genre ) )
$this->set_error( "invalid_ID", true );

$loader->db->query("DELETE FROM _m_genres WHERE ID = '{$genre["ID"]}' AND deleted > 0 ");
$this->set_response( "done" );

?>
