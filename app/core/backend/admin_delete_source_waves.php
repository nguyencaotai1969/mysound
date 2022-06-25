<?php

if ( !defined( "root" ) ) die;

$source =  $loader->source->select(["ID"=>$this->ps["ID"]]);
if ( empty( $source ) ) $this->set_error( "invalid_source", true );

if ( $source["type"] == "file" ){
	$loader->db->query("UPDATE _m_sources SET wave_bg = null, wave_pr = null WHERE ID = '{$source["ID"]}' ");
}

$this->set_response( "done" );

?>