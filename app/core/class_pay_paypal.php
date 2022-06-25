<?php

if ( !defined("root" ) ) die;

use PayPal\Api\Payer;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Details;
use PayPal\Api\Amount;
use PayPal\Api\Transaction;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;

class og_paypal {

	public $mode = "live";
	public $id = null;
	public $key = null;
	public $client = null;

	public function __construct( $pay ){

		$this->pay = $pay;
		$this->loader = $pay->loader;
		$this->db = $this->loader->db;

	}
	public function getClient(){

		if ( !$this->loader->admin->get_setting( "pg_pp" ) ) return false;
		if ( !( $this->id = $this->loader->admin->get_setting( "pg_pp_k1" ) ) ) return false;
		if ( !( $this->key = $this->loader->admin->get_setting( "pg_pp_k2" ) ) ) return false;
		if ( !( $this->mode = $this->loader->admin->get_setting( "pg_pp_sb" ) ) ) return false;
		if ( !empty( $this->client ) ) return $this->client;

		require_once( app_core_root . "/third/paypal-1.14/autoload.php" );

		$this->client = new \PayPal\Rest\ApiContext(
		  new \PayPal\Auth\OAuthTokenCredential( $this->id, $this->key )
		);

		$this->client->setConfig(
		    array(
		      'mode' => $this->mode
		    )
		);

		return $this->client;

	}

	public function get_link( $charge_amount, $order_no ){

		$client = $this->getClient();
		if ( !$client ) return false;
		$title = "Chargin wallet";
		$charge_amount = intval( $charge_amount );

    $payer = new Payer();
    $payer->setPaymentMethod('paypal');

    $item = new Item();
    $item->setName( $title )
		->setQuantity( 1 )
		->setPrice( $charge_amount )
		->setCurrency( strtoupper( $this->loader->admin->get_setting("currency_code") ) );

    $itemList = new ItemList();
    $itemList->setItems(array(
        $item
    ));

    $details = new Details();
    $details->setSubtotal( $charge_amount );

    $amount = new Amount();
    $amount->setCurrency( strtoupper( $this->loader->admin->get_setting("currency_code") ) )
		->setTotal( $charge_amount )
		->setDetails( $details );

    $transaction = new Transaction();
    $transaction->setAmount( $amount )
		->setItemList( $itemList )
		->setDescription( 'Wallet charge For ' . $this->loader->admin->get_setting( "sitename" ) )
		->setInvoiceNumber( $order_no );

    $redirectUrls = new RedirectUrls();
    $redirectUrls->setReturnUrl( web_addr . "user_pay_result?og=paypal&on={$order_no}" )
		->setCancelUrl( web_addr . "?og=paypal&on={$order_no}" );

    $payment = new Payment();
    $payment->setIntent('sale')
		->setPayer( $payer )
		->setRedirectUrls( $redirectUrls )
		->setTransactions(array(
        $transaction
    ));

    try {
        $payment->create( $client );
    }
    catch (Exception $e) {
			return array(
				"sta"  => false,
				"data" => $e->getData()
			);
    }

		return array(
			"sta"  => true,
			"data" => $payment->getApprovalLink()
		);

	}
	public function get_txn_id( $receipt ){

		if (
			!( $payment_id = $this->loader->secure->get( "get", "paymentId", "string", [ "strict" => true, "strict_regex" => "[0-9a-zA-Z\-_]" ] ) ) ||
			!( $payer_id = $this->loader->secure->get( "get", "PayerID", "string", [ "strict" => true, "strict_regex" => "[0-9a-zA-Z\-_]" ] ) ) ||
			!( $token = $this->loader->secure->get( "get", "token", "string", [ "strict" => true, "strict_regex" => "[0-9a-zA-Z\-_]" ] ) )
		) return false;

		return $payment_id;

	}
	public function check_result( $receipt ){

		if (
			!( $payment_id = $this->loader->secure->get( "get", "paymentId", "string", [ "strict" => true, "strict_regex" => "[0-9a-zA-Z\-_]" ] ) ) ||
			!( $payer_id = $this->loader->secure->get( "get", "PayerID", "string", [ "strict" => true, "strict_regex" => "[0-9a-zA-Z\-_]" ] ) ) ||
			!( $token = $this->loader->secure->get( "get", "token", "string", [ "strict" => true, "strict_regex" => "[0-9a-zA-Z\-_]" ] ) )
		) return false;

		$client = $this->getClient();
		if ( !$client ) return false;

		$payment = Payment::get( $payment_id, $client );
		$execute = new PaymentExecution();
		$execute->setPayerId( $payer_id );

		try{
		    $result = $payment->execute( $execute, $client );
				if ( $result->transactions[0]->invoice_number == $receipt["order_no"] )
				return true;
				return false;
		}
		catch (Exception $e) {
		   return false;
		}

	}

}

?>
