<?php

if ( !defined( "root" ) ) die;

// Validate presnted IDs
foreach( explode( ",", $this->ps["ids"] ) as $id ){

	if ( !$loader->secure->validate( $id, "md5" ) )
		$this->set_error( "invalid_ids", true );

	$track_data = $loader->track->select([ "hash" => $id ]);

	if ( !$track_data )
		$this->set_error( "invalid_ids", true );

	if ( $loader->track->is_download_able( $track_data ) )
		$download_able_tracks[] = $track_data;

}

if ( empty( $download_able_tracks ) )
	$this->set_error( "no_download_able_track" );

// get links
$links = [];
foreach( $download_able_tracks as $track ){

	$links[] = $loader->track->create_download_link( $track["ID"] );
	$loader->db->query("UPDATE _m_tracks SET downloads = downloads + 1 WHERE ID = '{$track["ID"]}' ");

}

$this->set_response( $links, false, false, true );

?>
