<?php

if ( !defined( "root" ) ) die;

// Validate old ( removed ) sources
foreach( explode( ",", $this->ps["sources"] ) as $_old_source_id ){
	
	if ( !$loader->secure->validate( $_old_source_id, "int" ) ) 
		$this->set_error( "invalid_old_source", true );
	
	$old_source = $loader->source->select(["ID"=>$_old_source_id ]);
	
	if ( empty( $old_source ) )
		$this->set_error( "invalid_old_source", true );
	
}

// Remove old genres one by one
foreach( explode( ",", $this->ps["sources"] ) as $_old_source_id ){
	$loader->source->remove( $_old_source_id );
}

$this->set_response( "done" );

?>