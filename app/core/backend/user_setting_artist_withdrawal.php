<?php

if ( !defined( "root" ) ) die;

$user = $loader->visitor->user()->data()->data;

if ( $this->ps["amount"] > $user["fund"] )
	$this->set_error("fund_shortage");

if ( $this->ps["amount"] < $loader->admin->get_setting( "withdrawal_min", 5 ) )
	$this->set_error("amount_is_too_low");


// Record transaction
$loader->pay->record_transaction([
	"amount"    => $this->ps["amount"],
	"type"      => "out",
	"data"      => [ "item" => "withdrawal", "email" => $this->ps["email"], "data" => $this->ps["data"] ],
	"completed" => 0,
	"withdrawing" => 1,
]);

// Remove funds
$loader->pay->remove_funds( $loader->visitor->user()->ID, $this->ps["amount"] );

// Notify admins
$this->loader->admin->add_not([
	"type" => "71",
	"hook" => $loader->visitor->user()->ID,
	"extraData" => [ "amount" => $this->ps["amount"] ]
]);

$this->set_response("done");

?>
