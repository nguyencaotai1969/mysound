<?php

if ( !defined( "root" ) ) die;

// Validate Payments IDs
foreach( explode( ",", $this->ps["payments"] ) as $_old_payment_id ){

	if ( !$loader->secure->validate( $_old_payment_id, "int" ) )
		$this->set_error( "invalid_old_payment", true );

	$old_payment = $loader->pay->select([ "ID"=>$_old_payment_id ]);
	$old_payments[] = $old_payment;

	if ( empty( $old_payment ) )
		$this->set_error( "invalid_old_payment", true );

}

// Execute payments 1by1
foreach( $old_payments as $old_payment ){

	if ( $old_payment["completed"] == -1 ) continue;
	if ( $old_payment["completed"] == 1 ){

		$loader->pay->remove_funds( $old_payment["user_id"], $old_payment["amount"] );
		$this->loader->user->remove_log([
			"type" => 18,
			"hook" => $old_payment["ID"],
			"user_id" => null,
		]);

	}

	$loader->db->_update([
	    "table" => "_user_transaction",
	    "set" => [[ "completed", "-1" ]],
	    "where" => [[ "ID", "=", $old_payment["ID"] ]]
	]);

}

$this->set_response( "done" );

?>
