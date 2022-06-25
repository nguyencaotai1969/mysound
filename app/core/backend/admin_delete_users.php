<?php

if ( !defined( "root" ) ) die;

// Validate new user ( against DB )
$new_user = $this->ps["new_user"] == 0 ? false : $loader->user->select(["ID"=>$this->ps["new_user"]]);
if ( empty( $new_user ) && $this->ps["new_user"] != 0 ) $this->set_error( "invalid_new_user", true );

// Validate old ( removed ) users
foreach( explode( ",", $this->ps["users"] ) as $_old_user_id ){
	
	// Validate & sanitize given ID
	if ( !$loader->secure->validate( $_old_user_id, "int", [ "min" => 2 ] ) )
		$this->set_error( "invalid_old_user", true );
	
	// Check if ID exists in db
	$old_user = $loader->user->select(["ID"=>$_old_user_id ]);
	if ( empty( $old_user ) ) $this->set_error( "invalid_old_user", true );
}

// Remove old users one by one
foreach( explode( ",", $this->ps["users"] ) as $_old_user_id ){
	$loader->user->remove( $_old_user_id, $new_user );
}

$this->set_response( "done" );

?>