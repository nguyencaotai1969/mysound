<?php

if ( !defined( "root" ) ) die;

// Validate Payments IDs
foreach( explode( ",", $this->ps["payments"] ) as $_old_payment_id ){
	
	if ( !$loader->secure->validate( $_old_payment_id, "int" ) )
		$this->set_error( "invalid_old_payment", true );
	
	$old_payment = $loader->pay->select([ "ID"=>$_old_payment_id, "completed"=>false ]);
	$old_payments[] = $old_payment;
	
	if ( empty( $old_payment ) )
		$this->set_error( "invalid_old_payment", true );
	
}

// Execute payments 1by1
foreach( $old_payments as $old_payment ){
	$loader->pay->execute_payment( $old_payment );
}

$this->set_response( "done" );

?>