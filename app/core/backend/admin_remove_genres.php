<?php

if ( !defined( "root" ) ) die;

// Validate new genre
$new_genre = $loader->genre->select(["ID"=>$this->ps["new_genre"]]);
if ( empty( $new_genre ) ) $this->set_error( "invalid_new_genre", true );

// Validate old ( removed ) genres
foreach( explode( ",", $this->ps["genres"] ) as $_old_genre_id ){
	
	if ( !$loader->secure->validate( $_old_genre_id, "int" ) ) 
		$this->set_error( "invalid_old_genre", true );
	
	$old_genre = $loader->genre->select(["ID"=>$_old_genre_id ]);
	
	if ( empty( $old_genre ) )
		$this->set_error( "invalid_old_genre", true );
	
}

// Remove old genres one by one
foreach( explode( ",", $this->ps["genres"] ) as $_old_genre_id ){
	$loader->genre->remove( $_old_genre_id, $new_genre["ID"] );
}

$this->set_response( "done" );

?>