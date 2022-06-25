<?php

if ( !defined("root" ) ) die;

class og_stripe {

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

		if ( !$this->loader->admin->get_setting( "pg_st" ) ) return false;
		if ( !( $this->id = $this->loader->admin->get_setting( "pg_st_k1" ) ) ) return false;
		if ( !( $this->key = $this->loader->admin->get_setting( "pg_st_k2" ) ) ) return false;
		require( app_core_root . "/third/stripe-7.75/autoload.php" );
		return true;

	}
	public function get_link( $charge_amount, $order_no ){

		$client = $this->getClient();
		if ( !$client ) return false;
		\Stripe\Stripe::setApiKey( $this->key );

		$checkout_session = \Stripe\Checkout\Session::create([
			'payment_method_types' => ['card'],
			'line_items' => [[
				'price_data' => [
					'currency' => $this->loader->admin->get_setting("currency_code"),
					'unit_amount' => $charge_amount * 100,
					'product_data' => [
						'name' => 'Wallet charge',
					],
				],
				'quantity' => 1,
				]],
				'mode' => 'payment',
				'success_url' => web_addr . "user_pay_result?og=stripe&on={$order_no}",
				'cancel_url' => web_addr . "user_pay_result?og=stripe&on={$order_no}",
			]);

			if ( empty( $checkout_session->id ) )
			return [
				"sta" => false,
				"data" => "failed"
			];

			$txn = $checkout_session->payment_intent;
			$this->db->_update(array(
				"table" => "_user_transaction",
				"set" => [
					[ "data_txn_id", $txn ]
				],
				"where" => [
					[ "order_no", "=", $order_no ]
				]
			));

			return [
				"sta" => true,
				"data" => $checkout_session->id
			];

	}
	public function get_txn_id( $receipt ){

		return $receipt["data_txn_id"];

	}
	public function check_result( $receipt ){

		$client = $this->getClient();
		if ( !$client ) return false;
		\Stripe\Stripe::setApiKey( $this->key );

		$intent = \Stripe\PaymentIntent::retrieve( $receipt["data_txn_id"] );

		if( !$intent->charges->data["0"]->captured )
		return false;

		return true;

	}

}

?>
