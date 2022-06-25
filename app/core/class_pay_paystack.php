<?php

if ( !defined("root" ) ) die;
use Yabacon\Paystack;

class og_paystack {

	public $id = null;
	public $key = null;
	public $currency_code = null;
	public $client = null;

	public function __construct( $pay ){

		$this->pay = $pay;
		$this->loader = $pay->loader;
		$this->db = $this->loader->db;

	}
	public function getClient(){

		if ( !$this->loader->admin->get_setting( "pg_ps" ) ) return false;
		if ( !( $this->id = $this->loader->admin->get_setting( "pg_ps_k1" ) ) ) return false;
		if ( !( $this->key = $this->loader->admin->get_setting( "pg_ps_k2" ) ) ) return false;
		if ( !empty( $this->client ) ) return $this->client;

		require( app_core_root . "/third/yabacon-paystack-php-2.1.23/autoload.php" );
		$this->client = $paystack = new Paystack( $this->key );
		return $this->client;

	}
	public function get_link( $charge_amount, $order_no ){

		$client = $this->getClient();
		if ( !$client ) return false;

		$charge_amount *= 100;

		try {
      $tranx = $client->transaction->initialize([
        'amount'       => $charge_amount,
        'email'        => $this->loader->visitor->user()->data["email"],
				'currency'     => strtoupper( $this->loader->admin->get_setting("currency_code") ),
        'reference'    => str_replace( "_", "-", $order_no ),
				'callback_url' => web_addr . "user_pay_result?og=paystack&on={$order_no}"
      ]);
    }
		catch( \Yabacon\Paystack\Exception\ApiException $e ){
      return [
				"sta"  => false,
				"data" => $e->getMessage()
			];
    }

		return [
			"sta"  => true,
			"data" => $tranx->data->authorization_url
		];

	}
	public function get_txn_id( $receipt ){

		if (
			!( $this->loader->secure->get( "get", "trxref", "string", [ "strict" => true, "strict_regex" => "[0-9a-zA-Z\-_]" ] ) ) ||
			!( $this->loader->secure->get( "get", "reference", "string", [ "strict" => true, "strict_regex" => "[0-9a-zA-Z\-_]" ] ) )
		) return false;

		return $receipt["order_no"];

	}
	public function check_result( $receipt ){

		if (
			!( $this->loader->secure->get( "get", "trxref", "string", [ "strict" => true, "strict_regex" => "[0-9a-zA-Z\-_]" ] ) ) ||
			!( $this->loader->secure->get( "get", "reference", "string", [ "strict" => true, "strict_regex" => "[0-9a-zA-Z\-_]" ] ) )
		) return false;

		$client = $this->getClient();
		if ( !$client ) return false;

		try {
      $tranx = $client->transaction->verify([
        'reference' => str_replace( "_", "-", $receipt["order_no"] ),
      ]);
    }
		catch( \Yabacon\Paystack\Exception\ApiException $e ){
      return false;
    }
    if ( 'success' === $tranx->data->status ){
			if ( $tranx->data->amount == $receipt["amount"] * 100 )
			return true;
		}

		return false;

	}

}

?>
