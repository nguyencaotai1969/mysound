<?php

if ( !defined( "root" ) ) die;

if ( $this->ps["username"] != $loader->visitor->user()->data["username"] ){
	
	$add = $loader->visitor->user()->change_username( $this->ps["username"] );
	
	if ( $add !== true ){
		$this->set_error( $add );
	}
	
}

// TODO :: give user ability to change their email after verification on old && new email

$this->set_response( "done" );

?>