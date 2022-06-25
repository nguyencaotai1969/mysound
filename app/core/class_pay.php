<?php

if ( !defined("root" ) ) die;

class pay {

	public $all_ogs = [ "paypal", "stripe", "kkiapay", "paystack", "flutterwave", "coinpayments", "razorpay" ];
	public $ogs = [];

	public function __construct( $loader ){

		$this->loader = $loader;
		$this->db = $loader->db;

	}
	protected function get_order_number(){
		return ( $this->db->query("SELECT 1 FROM _user_transaction")->num_rows + 1 ) . "_" . substr( hash( "md5", microtime() ), 0, 5 );
	}

	// OnlineGateways
	public function og( $og_name ){

		if ( !empty( $this->ogs[ $og_name ] ) ) return $this->ogs[ $og_name ];
		$og_file_path = app_core_root . "/class_pay_{$og_name}.php";
		if ( !file_exists( $og_file_path ) ) die("invalid_og_file_path. Contact admin");
		require_once( $og_file_path );
		$og_class_name = "og_{$og_name}";
		$client = new $og_class_name( $this );
		$this->ogs[ $og_name ] = $client;
		return $client;

	}
	public function og_get_link( $og_name, $amount, $order_no=null ){

		$getLink = $this->og( $og_name )->get_link( $amount, $order_no );

		if ( !empty( $getLink["txn"] ) ){
			$this->loader->db->query("UPDATE _user_transaction SET data_txn_id = '{$getLink["txn"]}' WHERE order_no = '{$order_no}' ");
		}

		return $getLink;

	}
	public function og_check_result( $og_name, $receipt ){

		// check by order_no
		if ( $receipt["paid"] == 1 )
		return true;

		// check by txn_id
		$txn_id = $this->og( $og_name )->get_txn_id( $receipt );
		if ( $txn_id ){
			if ( $this->db->_select( array(
				"table" => "_user_transaction",
				"where" => [
					[ "data_txn_id", "=", $txn_id ],
					[ "ID", "!=", $receipt["ID"] ]
				]
			) ) ) return false;
		}

		// check by api
		$paid = $this->og( $og_name )->check_result( $receipt );
		if ( !$paid ) return false;

		$set = [ [ "paid", "1" ] ];
		if ( $txn_id ) $set[] = [ "data_txn_id", $txn_id ];

		$this->loader->db->_update([
			"table" => "_user_transaction",
			"set"   => $set,
			"where" => [
				[ "order_no" , "=" , $receipt["order_no"] ]
			]
		]);

		if ( $this->loader->admin->get_setting( "og_approved", 1 ) )
		$this->execute_payment( $receipt );

		$this->loader->admin->add_not([
			"type" => "72",
			"hook" => $this->loader->visitor->user()->ID,
			"extraData" => [ "amount" => $receipt["amount"] ]
		]);

		return true;

	}


	// Payment functions
	public function select( $args ){

		$limit    = 1;
		$offset   = null;
		$order_by = "time_add";
		$order    = "DESC";
		$where    = [];
		$where_o  = "AND";
		$singular = true;
		$_eg      = [];

		// Where shortcodes
		$paid      = null;
		$completed = null;
		$rejected  = null;
		$funding   = null;
		$withdrawing = null;
		$ID        = null;
		$user_id   = null;
		$_sq       = null;
		extract( $args );

		if ( $ID )
			$where[] = [ "ID", "=", $ID ];

		if ( $user_id )
			$where[] = [ "user_id", "=", $user_id ];

		if ( $paid === true || $paid === 1 )
			$where[] = [ "paid", "=", "1" ];

		if ( $paid === false || $paid === 0 )
			$where[] = [
				"oper" => "OR",
				"cond" => [
				    [ "paid", "=", "0" ],
				    [ "paid", null, null, true ]
			    ]
			];

		if ( $completed === true || $completed === 1 )
			$where[] = [ "completed", "=", "1" ];

		if ( $completed === -1 )
			$where[] = [ "completed", "=", "-1" ];

		if ( $completed === false || $completed === 0 )
			$where[] = [
				"oper" => "OR",
				"cond" => [
				    [ "completed", "=", "0" ],
				    [ "completed", "=", "-1" ],
				    [ "completed", null, null, true ]
			    ]
			];

		if ( $funding === true || $funding === 1 )
			$where[] = [ "funding", "=", "1" ];

		if ( $funding === false || $funding === 0 )
			$where[] = [
				"oper" => "OR",
				"cond" => [
				    [ "funding", "=", "0" ],
				    [ "funding", null, null, true ]
			    ]
			];

		if ( $withdrawing === true || $withdrawing === 1 )
			$where[] = [ "withdrawing", "=", "1" ];

		if ( $withdrawing === false || $withdrawing === 0 )
			$where[] = [
				"oper" => "OR",
				"cond" => [
				    [ "withdrawing", "=", "0" ],
				    [ "withdrawing", null, null, true ]
			    ]
			];

		if ( $rejected === true || $funding === 1 )
			$where[] = [ "completed", "=", "-1" ];

		if ( $rejected === false || $rejected === 0 )
			$where[] = [ "completed", "!=", "-1" ];

		if ( $_sq )
			$where[] = [
				"oper" => "OR",
				"cond" => [
				    [ "order_no", "LIKE%", $_sq ],
				    [ "data_txn_id", "LIKE%", $_sq ]
			    ]
			];

		$args = array(

			"table"    => "_user_transaction",
			"where"    => array(
			    "oper" => $where_o,
			    "cond" => $where
		    ),
			"order_by" => $order_by,
			"order"    => $order,
			"limit"    => $limit,
			"offset"   => $offset,

		);

		$raw_results = $this->loader->db->_select( $args );
		if ( empty( $raw_results ) ) return false;

		$__results = [];
		foreach( $raw_results as $transaction ){

			$transaction["data"] = $transaction["data"] ? json_decode( $transaction["data"], 1 ) : null;
			$transaction["info"] = null;

			if ( in_array( "target", $_eg ) && $transaction["data"] ){

				if ( $transaction["data"]["item"] == "song" )
					$__song = $this->loader->track->select(["ID"=>$transaction["data"]["ID"]]);

				if ( $transaction["data"]["item"] == "album" )
					$__album = $this->loader->album->select(["ID"=>$transaction["data"]["ID"]]);

				if ( $transaction["data"]["item"] == "song" && $transaction["type"] == "out" )
					$transaction["info"] = $this->loader->lorem->turn( "bought_song", [ "escape" => false, "params" => [ "song" => "<a href='{$this->loader->ui->rurl( "track", $__song["url"] )}'>{$__song["artist_name"]} - {$__song["title"]}</a>" ], "uc" => true ] );

				if ( $transaction["data"]["item"] == "song" && $transaction["type"] == "in" )
					$transaction["info"] = $this->loader->lorem->turn( "sold_song", [ "escape" => false, "params" => [ "song" => "<a href='{$this->loader->ui->rurl( "track", $__song["url"] )}'>{$__song["title"]}</a>" ], "uc" => true ] );

				if ( $transaction["data"]["item"] == "album" && $transaction["type"] == "out" )
					$transaction["info"] = $this->loader->lorem->turn( "bought_album", [ "escape" => false, "params" => [ "album" => "<a href='{$this->loader->ui->rurl( "album", $__album["url"] )}'>{$__album["artist_name"]} - {$__album["title"]}</a>" ], "uc" => true ] );

				if ( $transaction["data"]["item"] == "album" && $transaction["type"] == "in" )
					$transaction["info"] = $this->loader->lorem->turn( "sold_album", [ "escape" => false, "params" => [ "album" => "<a href='{$this->loader->ui->rurl( "album", $__album["url"] )}'>{$__album["title"]}</a>" ], "uc" => true ] );

				if ( $transaction["data"]["item"] == "pro" && $transaction["type"] == "out" )
					$transaction["info"] = $this->loader->lorem->turn( "bought_pro", [ "uc" => true ] );

				if ( $transaction["data"]["item"] == "advertisement" && $transaction["type"] == "out" )
					$transaction["info"] = $this->loader->lorem->turn( "bought_ads", [ "uc" => true ] );

				if ( $transaction["data"]["item"] == "add_fund" && $transaction["type"] == "in" )
					$transaction["info"] = $this->loader->lorem->turn( "added_fund", [ "escape" => false, "params" => [ "order_id" => $transaction["data_txn_id"] ? "<br>ID: {$transaction["data_txn_id"]}" : null ] ] );

				if ( $transaction["data"]["item"] == "withdrawal" && $transaction["type"] == "out" )
					$transaction["info"] = $this->loader->lorem->turn( "withdrew", [] );

			}

			if ( in_array( "user", $_eg ) ){
				$transaction["user"] = $this->loader->user->select(["ID"=>$transaction["user_id"]]);
			}

			$transactions[] = $transaction;

		}

		return $limit == 1 && $singular ? reset( $transactions ) : $transactions;

	}
	public function execute_payment( $receipt ){

		$receipt_user = $this->loader->user->set( $receipt["user_id"] )->get_data();

		$this->loader->user->add_log([
			"type" => 18,
			"hook" => $receipt["ID"],
			"user_id_2" => $receipt["user_id"],
			"user_id" => null
		]);

		$this->db->_update([
			"table" => "_user_transaction",
			"set" => [
			    [ "completed", "1" ],
			    [ "paid", "1" ],
			    [ "time_completed", "now()", true ],
			    [ "user_fund", $receipt_user["fund"] ]
		    ],
			"where" => [[ "ID", "=", $receipt["ID"] ]]
		]);

		$this->add_funds( $receipt["user_id"], $receipt["amount"], "total" );

		return;

	}

	// User functions
	public function add_funds( $user_id, $amount, $o2=false ){

		if( empty( $user_id ) ) return false;

		$this->db->query("UPDATE _users SET fund = fund + {$amount} WHERE ID = '{$user_id}' ");
		if ( $o2 ) $this->db->query("UPDATE _users SET fund_{$o2} = fund_{$o2} + {$amount} WHERE ID = '{$user_id}' ");

		return true;

	}
	public function remove_funds( $user_id, $amount ){

		if( empty( $user_id ) ) return false;

		$this->db->query("UPDATE _users SET fund = fund - {$amount} WHERE ID = '{$user_id}' ");

		return true;

	}
	public function get_purchases( $user_id=null ){

		$user_id = $user_id ? $user_id : $this->loader->visitor->user()->ID;
		$purchases = [];
		$get_purchases = $this->db->query("SELECT * FROM _user_purchases WHERE user_id = '{$user_id}' ORDER BY time_add DESC LIMIT 0, 50");
		if ( !$get_purchases->num_rows ) return $purchases;
		while( $purchase = $get_purchases->fetch_assoc() ){
			$purchases[] = $purchase;
		}
		return $purchases;

	}
	public function get_purchased_songs( $user_id=null ){

		$user_id = $user_id ? $user_id : $this->loader->visitor->user()->ID;
		$purchases = $this->get_purchases( $user_id );
		if ( empty( $purchases ) ) return [];

		$songs = [];
		foreach( $purchases as $purchase ){
			if ( $purchase["item_type"] != "song" ) continue;
			$song = $this->loader->track->select(["ID"=>$purchase["item_id"]]);
			if ( $song ){
				$songs[] = $song;
			}
		}
		return $songs;

	}

	// Record functions
	public function record_payment( $amount, $payment_method = null, $image = null ){

		$rid = $this->record_transaction([
			"amount"  => $amount,
			"image"   => $image,
			"type"    => "in",
			"data"    => [ "item" => "add_fund", "method" => $payment_method ],
			"funding" => 1
		]);

		// Notify admins
		if ( $payment_method == "bank_transfer" ){
			$this->loader->admin->add_not([
				"type" => "72",
				"hook" => $this->loader->visitor->user()->ID,
				"extraData" => [ "amount" => $amount ]
			]);
		}

		return $rid;

	}
	public function record_add_data( $order_no, $var, $val ){

		$t = $this->loader->db->_select(array(
			"table" => "_user_transaction",
			"where" => array(
				[ "order_no", "=", $order_no ]
			),
			"limit" => 1
		));

		if ( !$t ) return false;

		$t = reset( $t );
		$t["data"] = json_decode( $t["data"], true );

		$t["data"][ $var ] = $val;

		$this->loader->db->_update(array(
			"table" => "_user_transaction",
			"where" => array(
				[ "order_no", "=", $order_no ]
			),
			"set" => array(
				[ "data", json_encode( $t["data"] ) ]
			)
		));

		return true;

	}
	public function record_purchase( $args ){

		$user_id   = $this->loader->visitor->user()->ID;
		$item_type = null;
		$item_id   = null;
		extract( $args );

		$this->db->_insert([
			"table" => "_user_purchases",
			"set"   => [
			    [ "item_type", $item_type ],
			    [ "user_id", $user_id ],
			    [ "item_id", $item_id ],
		    ]
		]);

		return true;

	}
	public function record_transaction( $args ){

		$order_no       = $this->get_order_number();
		$user_id        = $this->loader->visitor->user()->ID;
		$user_fund      = $this->loader->visitor->user()->data["fund"];
		$amount         = null;
		$type           = null;
		$data           = null;
		$image          = null;
		$completed      = 0;
		$funding        = 0;
		$withdrawing    = 0;
		$revenue        = null;
		extract( $args );
		$time_completed = $completed ? "now()" : "null";
		$data           = $data ? json_encode( $data ) : null;

		$this->db->_insert([
			"table" => "_user_transaction",
			"set"   => [
			    [ "order_no", $order_no ],
			    [ "image", $image ],
			    [ "user_id", $user_id ],
			    [ "user_fund", $user_fund ],
			    [ "type", $type ],
			    [ "amount", $amount ],
			    [ "data", $data ],
			    [ "completed", $completed ],
			    [ "time_completed", $time_completed, true ],
			    [ "funding", $funding ],
			    [ "withdrawing", $withdrawing ],
			    [ "revenue", $revenue ]
		    ]
		]);

		if ( !empty( $revenue ) ){

		}

		return $order_no;

	}

}

?>
