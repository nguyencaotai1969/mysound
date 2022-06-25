<?php

if ( !defined( "root" ) ) die;

$page_data = $loader->ui->set_page_data();

// validate playlist
if ( $page_data["playlist"]["hash"] != $this->ps["playlist_hash"] )
$this->set_error( "invalid_hook", true );
if ( !$page_data["playlist"]["collabed"] )
$this->set_error( "invalid_hook", true );
$playlist = $page_data["playlist"];

// validate hashes
foreach( explode( ",", $this->ps["hashes"] ) as $_hash ){
	if ( !$loader->secure->validate( $_hash, "md5" ) )
	$this->set_error( "invalid_hook", true );
	$sent_hashes[] = $_hash;
}

// get actual hasahes
$db_hashes_raw = $loader->db->_select([
	"table" => "_user_playlists_relations",
	"where" => [
		[ "playlist_id", "=", $playlist["ID"] ]
	],
	"columns" => "track_id",
	"limit" => 1000
]);
if ( empty( $db_hashes_raw ) )
$this->set_error( "invalid_hook", true );
foreach( $db_hashes_raw as $_db_hash_data ){
	$track_data = $loader->track->select(["ID"=>$_db_hash_data["track_id"]]);
	if ( empty( $track_data ) ) continue;
	$db_hashes[] = $track_data["hash"];
	$hash_id[ $track_data["hash"] ] = $track_data["ID"];
}

// compare hashes
if ( count( $db_hashes ) != count( $sent_hashes ) || array_diff( $db_hashes, $sent_hashes ) )
$this->set_error( "invalid_hook", true );

// submit changes
$loader->db->query("UPDATE _user_playlists_relations SET sort = null WHERE playlist_id = '{$playlist["ID"]}' ");
$i=0;
foreach( $sent_hashes as $_hash ){
	$i++;
	$loader->db->query("UPDATE _user_playlists_relations SET sort = '{$i}' WHERE playlist_id = '{$playlist["ID"]}' and track_id = '{$hash_id[$_hash]}' ");
}

$this->set_response( "done" );

?>
