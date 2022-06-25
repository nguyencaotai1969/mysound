<?php

if ( !defined( "root" ) ) die;

if ( $user_id = $loader->user->email_exists( $this->ps["email"] ) ){
	
	$user_data = $this->loader->user->set( $user_id )->data()->data;
	if ( $user_data["verified"] ){
		$this->loader->user->set( $user_id )->data()->verify_try( "recover" );
	}
	else {
		$this->loader->user->set( $user_id )->data()->verify_try();
	}
	
}

$this->set_response( "recovery_m_sent" );

?>