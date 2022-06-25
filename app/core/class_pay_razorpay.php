<?php

if ( !defined("root" ) ) die;

class og_razorpay {

	public $mode = "sandbox";
	public $id = null;
	public $key = null;
	public $client = null;

	public function __construct( $pay ){

		$this->pay = $pay;
		$this->loader = $pay->loader;
		$this->db = $this->loader->db;

	}
	public function getClient(){

		if ( !$this->loader->admin->get_setting( "pg_rp" ) ) return false;
		if ( !( $this->id = $this->loader->admin->get_setting( "pg_rp_k1" ) ) ) return false;
		if ( !( $this->key = $this->loader->admin->get_setting( "pg_rp_k2" ) ) ) return false;
		if ( !( $this->mode = $this->loader->admin->get_setting( "pg_rp_sb" ) ) ) return false;
		if ( !empty( $this->client ) ) return $this->client;

		require_once( app_core_root . "/third/razorpay/autoload.php" );
		$this->client = new \Razorpay\Api\Api( $this->id, $this->key );
		return $this->client;

	}

	public function get_link( $charge_amount, $order_no ){

		$client = $this->getClient();
		if ( !$client ) return [ "sta" => false ] ;

		$charge_amount *= 100;

		$order = $client->order->create(array(
			'receipt'  => $order_no,
			'amount'   => $charge_amount,
			'currency' => strtoupper( $this->loader->admin->get_setting("currency_code") ),
		));

		if ( !$order ) return [ "sta" => false ] ;

		$this->loader->db->_update(array(
			"table" => "_user_transaction",
			"set" => array(
				[ "data_txn_id", $order["id"] ]
			),
			"where" => array(
				[ "order_no", "=", $order_no ]
			)
		));

		return [ "sta" => true, "data" => [ "local" => $order_no, "remote" => $order["id"] ] ];

	}
	public function get_txn_id( $receipt ){

		if (
			!( $payment_id = $this->loader->secure->get( "post", "razorpay_payment_id", "string", [ "strict" => true, "strict_regex" => "[0-9a-zA-Z\-_]" ] ) ) ||
			!( $order_id = $this->loader->secure->get( "post", "razorpay_order_id", "string", [ "strict" => true, "strict_regex" => "[0-9a-zA-Z\-_]" ] ) ) ||
			!( $signature = $this->loader->secure->get( "post", "razorpay_signature", "string", [ "strict" => true, "strict_regex" => "[0-9a-zA-Z\-_]" ] ) )
		) return false;

		return $order_id;

	}
	public function check_result( $receipt ){

		if (
			!( $payment_id = $this->loader->secure->get( "post", "razorpay_payment_id", "string", [ "strict" => true, "strict_regex" => "[0-9a-zA-Z\-_]" ] ) ) ||
			!( $order_id = $this->loader->secure->get( "post", "razorpay_order_id", "string", [ "strict" => true, "strict_regex" => "[0-9a-zA-Z\-_]" ] ) ) ||
			!( $signature = $this->loader->secure->get( "post", "razorpay_signature", "string", [ "strict" => true, "strict_regex" => "[0-9a-zA-Z\-_]" ] ) )
		) return false;

		$client = $this->getClient();
		if ( !$client ) return false;

		$attributes = array(
			'razorpay_signature'  => $signature,
			'razorpay_payment_id' => $payment_id,
			'razorpay_order_id'   => $order_id
		);

		$valid_signature = null;
		try {
			$client->utility->verifyPaymentSignature( $attributes );
			$valid_signature = true;
		} catch ( Exception $err ){
			var_dump( $err->getMessage() );
			$valid_signature = false;
		}

		if ( !$valid_signature )
		return false;

		$payment_data = $client->payment->fetch( $payment_id );

		if ( $payment_data["amount"] < $receipt["amount"] * 100 )
		return false;

		if ( $payment_data["currency"] != strtoupper( $this->loader->admin->get_setting("currency_code") ) )
		return false;

		return true;

	}

}

?>
