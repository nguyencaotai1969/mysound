<?php

if ( !defined( "root" ) ) die;

// Validate new artist
$new_artist = $this->ps["new_artist"] == 0 ? false : $loader->artist->select(["ID"=>$this->ps["new_artist"]]);
if ( empty( $new_artist ) && $this->ps["new_artist"] != 0 ) $this->set_error( "invalid_new_artist", true );

// Validate old ( removed ) artists
foreach( explode( ",", $this->ps["artists"] ) as $_old_artist_id ){
	
	if ( !$loader->secure->validate( $_old_artist_id, "int" ) )
		$this->set_error( "invalid_old_artist", true );
	
	$old_artist = $loader->artist->select(["ID"=>$_old_artist_id ]);
	
	if ( empty( $old_artist ) )
		$this->set_error( "invalid_old_artist", true );
	
}

// Remove old artists one by one
foreach( explode( ",", $this->ps["artists"] ) as $_old_artist_id ){
	$loader->artist->remove( $_old_artist_id, $new_artist );
}

$this->set_response( "done" );

?>