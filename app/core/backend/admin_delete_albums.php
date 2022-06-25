<?php

if ( !defined( "root" ) ) die;

// Validate new album
$new_album = $this->ps["new_album"] == 0 ? false : $loader->album->select(["ID"=>$this->ps["new_album"]]);
if ( empty( $new_album ) && $this->ps["new_album"] != 0 ) $this->set_error( "invalid_new_album", true );

// Validate old ( removed ) albums
foreach( explode( ",", $this->ps["albums"] ) as $_old_album_id ){
	
	if ( !$loader->secure->validate( $_old_album_id, "int" ) )
		$this->set_error( "invalid_old_album", true );
	
	$old_album = $loader->album->select(["ID"=>$_old_album_id ]);
	
	if ( empty( $old_album ) )
		$this->set_error( "invalid_old_album", true );
	
}

// Remove old albums one by one
foreach( explode( ",", $this->ps["albums"] ) as $_old_album_id ){
	$loader->album->remove( $_old_album_id, $new_album );
}

$this->set_response( "done" );

?>