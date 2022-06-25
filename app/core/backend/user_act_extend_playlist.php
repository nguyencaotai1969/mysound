<?php

if ( !defined( "root" ) ) die;

$playlist = $loader->playlist->select([
	"hash"    => $this->ps["playlist_hash"],
	"user_id" => $loader->user->ID,
	"collabed_in_id" => $loader->user->ID,
]);

if ( !$playlist )
	$this->set_error( "invalid_ids", true );

foreach( array_reverse( explode( ",", $this->ps["track_hash"] ) ) as $hash ){

	if ( !$loader->secure->validate( $hash, "md5" ) )
		$this->set_error( "invalid_ids", true );

	$track_data = $loader->track->select([
		"hash" => $hash
	]);

	if ( !$track_data )
		$this->set_error( "invalid_ids", true );

	$loader->playlist->extend( $playlist["ID"], $track_data["ID"] );
	$loader->db->query("UPDATE _m_tracks SET playlisteds = playlisteds + 1 WHERE ID = '{$track_data["ID"]}' ");

}

// Notify subscribers if playlist was update
if ( $playlist["followers"] && $playlist["time_update"] ? time() - strtotime( $playlist["time_update"] ) > 60*60*2 : false ){

    $loader->user->add_log([
			"type" => 15,
			"hook" => $playlist["ID"]
		]);

		if ( ( $followers = $loader->user->get_subs( 12, $playlist["ID"] ) ) ){
			foreach( $followers as $follower_id ){
				$loader->user->add_log([
					"user_id"   => null,
					"user_id_2" => $follower_id,
					"type"      => 11,
					"hook"      => $playlist["ID"]
				]);
			}
		}

}

$this->set_response( "done" );

?>
