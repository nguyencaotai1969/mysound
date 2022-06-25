<?php

if ( !defined("root" ) ) die;

class og_kkiapay {

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

		if ( !$this->loader->admin->get_setting( "pg_kk" ) ) return false;
		if ( !( $this->id = $this->loader->admin->get_setting( "pg_kk_k1" ) ) ) return false;
		if ( !( $this->key = $this->loader->admin->get_setting( "pg_kk_k2" ) ) ) return false;
		if ( !( $this->key2 = $this->loader->admin->get_setting( "pg_kk_k3" ) ) ) return false;
		if ( !( $this->mode = $this->loader->admin->get_setting( "pg_kk_sb" ) ) ) return false;
		if ( !empty( $this->client ) ) return $this->client;

		require_once( app_core_root . "/third/kkiapay/autoload.php" );

		$this->client = new \Kkiapay\Kkiapay(
			$this->id,
			$this->key,
			$this->key2,
			$this->mode == "sandbox" ? true : false
		);

		return $this->client;

	}

	public function get_txn_id( $receipt ){

		if (
			!( $payment_id = $this->loader->secure->get( "get", "transaction_id", "string", [ "strict" => true, "strict_regex" => "[0-9a-zA-Z\-_]" ] ) )
		) return false;

		return $payment_id;

	}
	public function check_result( $receipt ){

		if (
			!( $payment_id = $this->loader->secure->get( "get", "transaction_id", "string", [ "strict" => true, "strict_regex" => "[0-9a-zA-Z\-_]" ] ) )
		) return false;

		$client = $this->getClient();
		if ( !$client ) return false;

		$verify = $client->verifyTransaction( $payment_id );
		if ( $verify->status != "SUCCESS" )
		return false;

		if ( $verify->amount != $receipt["amount"] )
		return false;

		return true;

	}

}

?>
