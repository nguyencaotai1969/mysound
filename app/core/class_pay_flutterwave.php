<?php

if ( !defined("root" ) ) die;

class og_flutterwave {

	public $mode = "sandbox";
	public $id = null;
	public $key = null;
	public $key2 = null;
	public $client = null;

	public function __construct( $pay ){

		$this->pay = $pay;
		$this->loader = $pay->loader;
		$this->db = $this->loader->db;

	}
	public function getClient(){

		if ( !$this->loader->admin->get_setting( "pg_fw" ) ) return false;
		if ( !( $this->id = $this->loader->admin->get_setting( "pg_fw_k1" ) ) ) return false;
		if ( !( $this->key = $this->loader->admin->get_setting( "pg_fw_k2" ) ) ) return false;
		if ( !( $this->key2 = $this->loader->admin->get_setting( "pg_fw_k3" ) ) ) return false;
		if ( !( $this->mode = $this->loader->admin->get_setting( "pg_fw_sb" ) ) ) return false;
		return true;

	}

	public function get_txn_id( $receipt ){

		if (
			!( $payment_id = $this->loader->secure->get( "get", "transaction_id", "string", [ "strict" => true, "strict_regex" => "[0-9a-zA-Z\-_]" ] ) ) ||
			!( $tx_ref = $this->loader->secure->get( "get", "tx_ref", "string", [ "strict" => true, "strict_regex" => "[0-9a-zA-Z\-_]" ] ) ) ||
			!( $status = $this->loader->secure->get( "get", "status", "string", [ "strict" => true, "strict_regex" => "[0-9a-zA-Z\-_]" ] ) )
		) return false;

		return $payment_id;

	}
	public function check_result( $receipt ){

		if (
			!( $payment_id = $this->loader->secure->get( "get", "transaction_id", "string", [ "strict" => true, "strict_regex" => "[0-9a-zA-Z\-_]" ] ) ) ||
			!( $tx_ref = $this->loader->secure->get( "get", "tx_ref", "string", [ "strict" => true, "strict_regex" => "[0-9a-zA-Z\-_]" ] ) ) ||
			!( $status = $this->loader->secure->get( "get", "status", "string", [ "strict" => true, "strict_regex" => "[0-9a-zA-Z\-_]" ] ) )
		) return false;

		$client = $this->getClient();
		if ( !$client ) return false;

		if ( $status != "successful" )
		return false;

		$verify = $this->__verify_transaction( $receipt, $payment_id );
		return $verify;

	}

	private function __verify_transaction( $receipt, $transaction_id ){

		$response = $this->loader->general->curl( array(
			"url" => "https://api.flutterwave.com/v3/transactions/{$transaction_id}/verify",
			"headers" => array(
				"Content-Type: application/json",
				"Authorization: Bearer {$this->key}"
			)
		) );

		if ( empty( $response[1] ) )
		return false;

		$data = $response[1];
		if ( !$this->loader->secure->validate( $data, "json" ) )
		return false;

		if ( $data["status"] != "success" )
		return false;

		if ( $data["data"]["currency"] != $this->loader->admin->get_setting( "currency_code" ) )
		return false;

		if (  $data["data"]["amount"] != $receipt["amount"] )
		return false;

		return true;

	}

}

?>
