<?php

if ( !defined( "root" ) ) die;

$user_fund = $loader->visitor->user()->data["fund"];

if ( $this->ps["type"] == "pro" ){

	// Get price, check funds
	$price = $loader->admin->get_setting( "upgrade_price" );
	if ( $price > $user_fund ) $this->set_error( "fund_shortage" );
	$revenue = $price;
	$_title = "`Paid` plan";

	// Record transaction
	$loader->pay->record_transaction([
		"amount"    => $price,
		"type"      => "out",
		"data"      => [ "item" => "pro" ],
		"revenue"   => $price,
		"completed" => 1
	]);

	$this->loader->user->add_log([
		"user_id" => null,
		"user_id_2" => $loader->visitor->user()->ID,
		"type" => "21",
		"hook" => 1
	]);

	// Remove funds, give user the item ( upgrade )
	$loader->pay->remove_funds( $loader->visitor->user()->ID, $price );
	$loader->db->query("UPDATE _users SET time_paid_expire = DATE_ADD( NOW(), INTERVAL 1 MONTH ) WHERE ID = '{$loader->visitor->user()->ID}' ");

}
else if ( $this->ps["type"] == "album" ){

	// Get price, check funds
	$album = $loader->album->select(["hash"=>$this->ps["hook"]]);
	if ( empty( $album ) ) $this->set_error( "wrong_hash", true );
	$paid = $loader->album->is_paid( $album );
	if ( $paid ) $this->set_error( "wrong_hash", true );
	if ( $album["price"] > $user_fund ) $this->set_error( "fund_shortage" );

	// Calculate selling artist share
	$ratio = $album["user_id"] == 1 ? 0 : $loader->user->set( $album["user_id"] )->data()->get_access()["access"]["sell_share"] / 100;
	$artist_share = round( $album["price"] * $ratio, 1 );
	$revenue = round( $album["price"] - $artist_share, 1 );
	$_title = $album["artist_name"] . " - " . $album["title"];

	// Record transcation
	$loader->pay->record_transaction([
		"amount"    => $album["price"],
		"type"      => "out",
		"data"      => [ "item" => "album", "ID" => $album["ID"] ],
		"completed" => 1,
		"revenue"   => $revenue,
	]);

	// Remove funds, give user the item ( album )
	$loader->pay->remove_funds( $loader->visitor->user()->ID, $album["price"] );
	$loader->pay->record_purchase([
		"item_type" => "album",
		"item_id"   => $album["ID"]
	]);

	// Album has a owner? Owner is not sites admin?<br>
	// Then give the owner his/her share
	if ( $album["user_id"] ? $album["user_id"] > 1 : false ){

		// Give artist his share, record the transaction
		$loader->pay->record_transaction([
			"user_id"   => $album["user_id"],
			"user_fund" => $loader->user->set( $album["user_id"] )->get_data()[ "fund" ],
			"amount"    => $artist_share,
			"type"      => "in",
			"data"      => [ "item" => "album", "ID" => $album["ID"] ],
			"completed" => 1,
		]);

		$loader->pay->add_funds( $album["user_id"], $artist_share, "revenue" );

	}

	$this->loader->user->add_log([
		"user_id" => $loader->visitor->user()->ID,
		"user_id_2" => $album["user_id"],
		"type" => "20",
		"hook" => $album["ID"]
	]);

	$loader->db->query("UPDATE _m_albums SET purchased = purchased + 1 WHERE ID = '{$album["ID"]}' ");

}
else if ( $this->ps["type"] == "track" ){

	// Get price, check funds
	$song = $loader->track->select(["hash"=>$this->ps["hook"]]);
	if ( empty( $song ) ) $this->set_error( "wrong_hash", true );
	$paid = $loader->track->is_paid( $song );
	if ( $paid ) $this->set_error( "wrong_hash", true );
	if ( $song["price"] > $user_fund ) $this->set_error( "fund_shortage" );

	// Calculate selling artist share
	$ratio = $song["user_id"] == 1 ? 0 : $loader->user->set( $song["user_id"] )->data()->get_access()["access"]["sell_share"] / 100;
	$artist_share = round( $song["price"] * $ratio, 1 );
	$revenue = round( $song["price"] - $artist_share, 1 );
	$_title = $song["artist_name"] . " - " . $song["title"];

	// Record transcation
	$loader->pay->record_transaction([
		"amount"    => $song["price"],
		"type"      => "out",
		"data"      => [ "item" => "song", "ID" => $song["ID"] ],
		"completed" => 1,
		"revenue"   => $revenue
	]);

	// Remove funds, give user the item ( song )
	$loader->pay->remove_funds( $loader->visitor->user()->ID, $song["price"] );
	$loader->pay->record_purchase([
		"item_type" => "song",
		"item_id"   => $song["ID"]
	]);


	if ( $song["user_id"] ? $song["user_id"] > 1 : false ){

		// Give artist his share, record the transaction
		$loader->pay->record_transaction([
			"user_id"   => $song["user_id"],
			"user_fund" => $loader->user->set( $song["user_id"] )->get_data()[ "fund" ],
			"amount"    => $artist_share,
			"type"      => "in",
			"data"      => [ "item" => "song", "ID" => $song["ID"] ],
			"completed" => 1,
		]);

		$loader->pay->add_funds( $song["user_id"], $artist_share, "revenue" );

	}

	$this->loader->user->add_log([
		"user_id" => $loader->visitor->user()->ID,
		"user_id_2" => $song["user_id"],
		"type" => "19",
		"hook" => $song["ID"]
	]);

	$loader->db->query("UPDATE _m_tracks SET purchased = purchased + 1 WHERE ID = '{$song["ID"]}' ");

}

if ( !empty( $revenue ) ){

	// Notify admins
	$this->loader->admin->add_not([
		"type" => "73",
		"hook" => $loader->visitor->user()->ID,
		"extraData" => [ "revenue" => $revenue, "" ]
	]);

}

$this->set_response( "done" );

?>
