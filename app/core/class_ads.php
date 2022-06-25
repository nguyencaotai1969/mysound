<?php

if ( !defined( "root" ) ) die;

class ads {

	public $banner_sizes = [
		[ 970, 250 ],
		[ 970, 90 ],
		[ 728, 90 ],
		[ 468, 60 ],
		[ 336, 280 ],
		[ 300, 600 ],
		[ 300, 250 ],
		[ 250, 250 ],
		[ 234, 60 ],
		[ 200, 200 ],
		[ 160, 600 ],
		[ 120, 600 ],
		[ 120, 240 ]
	];

	public function __construct( $loader ){

		$this->loader = $loader;
		$this->db = $loader->db;

	}

	// active: -2 -> rejected
	// active: -1 -> removed
	// active: 0  -> waiting for admin
	// active: 1  -> active
	// active: 2  -> pause
	// active: 3  -> finished

	public function shouldDisplay( $placement ){

		if ( $this->loader->visitor->user()->has_access( "group", "hide_advertisement" ) )
		return false;

		if ( $this->loader->hit->agent_data["device"]["type"] == "bot" ? $this->loader->admin->get_setting( "ads_hide_bot", 1 ) : false )
		return false;

		if ( in_array( $this->loader->ui->page_type, [ "no_access", "404", "track_embed", "pay_check", "user_login", "user_signup", "user_logout", "user_recover", "user_upgrade", "user_upload", "user_upload_edit", "user_pay_result" ] ) )
		return false;

		$this->ad = $this->select([
			"placement" => $placement,
			"active" => 1,
			"order" => "",
			"order_by" => "rand()",
			"has_funds" => true,
			"has_daily_funds" => true
		]);

		if ( empty( $this->ad ) ) return false;

		$this->update_acts( $this->ad["ID"], "views" );

		if ( $this->ad["type"] == "banner_v" )
		$this->update_fund( $this->ad, $this->loader->admin->get_setting( "banner_v_cost", 0.1 ) );

		return true;

	}
	public function display( $placement ){

		echo $this->loader->theme->set_name('__default')->__req( "parts/m_ad.php", false, [
			"placement" => $placement,
			"ad" => $this->ad
		] );
		return;

	}
	public function getBannerSizes( $output_type="normal" ){

		$banner_sizes = $this->banner_sizes;
		if ( $output_type == "for_select" ){
			foreach( $banner_sizes as $_banner_size )
			$_op[] = [ "{$_banner_size[0]}_{$_banner_size[1]}", "{$_banner_size[0]}*{$_banner_size[1]}" ];
			return $_op;
		}

		foreach( $banner_sizes as $_banner_size )
		$_op[ "{$_banner_size[0]}_{$_banner_size[1]}" ] = $_banner_size;

		return $_op;

	}
	public function getPlacements( $output_type="normal" ){

		$places = $theme_places = $this->loader->theme->set_name($this->loader->admin->get_setting( 'theme_name' ))->loader->theme->get_advertisement_placements([ "lorem" => true ]);

		$page_builder_places = $this->db->_select([
			"table" => "_setting_page_widgets",
			"where" => [
				[ "widget_type", "=", "pl" ]
			],
			"limit" => 100
		]);

		if ( $page_builder_places ){
			foreach( $page_builder_places as $_pl ){
				$_pl_setting = json_decode( $_pl["widget_setting"], 1 );
				$places[ $_pl_setting["pl_code"] ] = array(
					"type" => "banner",
					"code" => $_pl_setting["pl_code"],
					"size" => [
						"w" => substr( $_pl_setting["banner_size"], 0, 3 ),
						"h" => substr( $_pl_setting["banner_size"], 4 )
					],
					"lorem" => $_pl_setting["banner_pl_name"]
				);
			}
		}

		if ( $output_type == "for_select" ){
			foreach( $places as $_pl )
			$_op[] = [ $_pl["code"], $_pl["lorem"] . " - {$_pl["size"]["w"]}*{$_pl["size"]["h"]}" ];
			return $_op;
		}

		return $places;

	}
	public function shouldPlay(){

		if ( $this->loader->visitor->user()->has_access( "group", "hide_advertisement" ) )
		return false;

		if ( in_array( $this->loader->ui->page_type, [ "no_access", "404", "track_embed", "pay_check", "user_login", "user_signup", "user_logout", "user_recover", "user_pay_result" ] ) )
		return false;

		$last_advertisement_time = !empty( $_SESSION["ad_time"] ) ? time() - $_SESSION["ad_time"] : false;
		$advertisement_interval  = $this->loader->admin->get_setting( "ad_audio_iv", 3 ) * 60;

		// recently played ad. dont bug the viewers!
		if ( $last_advertisement_time ? $last_advertisement_time < $advertisement_interval : false )
		return false;

		$this->ad = $this->select([
			"type" => "audio_v",
			"active" => 1,
			"order" => "",
			"order_by" => "rand()"
		]);

		if ( empty( $this->ad ) ) return false;

		$this->update_acts( $this->ad["ID"], "views" );
		$this->update_fund( $this->ad, $this->loader->admin->get_setting( "audio_v_cost", 0.5 ) );

		return true;

	}
	public function getPlay(){
		return $this->ad;
	}

	public function select( $args ){

		$hide_removed = true;
		$has_funds = null;
		$has_daily_funds = null;
		$active = null;
		$ID = null;
		$user_id = null;
		$placement = null;
		$order_no = null;
		$type = null;

		$singular = true;
		$offset = 0;
		$limit = 1;
		$order_by = "time_add";
		$order = "DESC";
		$day_code = date("ymd");

		$where = [];
		$_eg = [];

		extract( $args );

		if ( $ID )
		$where[] = [ "ID", "=", $ID ];

		if ( $user_id )
		$where[] = [ "user_id", "=", $user_id ];

		if ( $type )
		$where[] = [ "type", "=", $type ];

		if ( $active !== null )
		$where[] = [ "active", "=", $active ];

		if ( $hide_removed )
		$where[] = [ "active", "!=", "-1" ];

		if ( $placement )
		$where[] = [ "ID", "IN", "SELECT ad_id  FROM `_setting_ads_placements` WHERE `placement_code` = '{$placement}' ", true ];

		if ( $has_funds === true )
		$where[] = [
			"oper" => "OR",
			"cond" => [
				[ "fund_remain", ">", 0 ],
				[ "type", "=", "adsense" ]
			]
		];

		if ( $has_funds === false )
		$where[] = [ "fund_remain", "<=", 0 ];

		if ( $has_daily_funds === true )
		$where[] = [
			"oper" => "OR",
			"cond" => [
				[ "fund_spent_day_code", "!=", $day_code ],
				[ "fund_spent_day_code", null, null, true ],
				[ "fund_limit", null, null, true ],
				[ "fund_limit", "=", "0" ],
				[
					"oper" => "AND",
					"cond" => [
						[ "fund_spent_day_code", "=", $day_code ],
						[ "fund_limit", ">", "fund_spent_day", true ]
					]
				],
				[ "type", "=", "adsense" ],
			]
		];

		if ( $order_no )
		$where[] = [ "order_no", "=", $order_no ];

		$select = $this->db->_select([
			"table"  => "_setting_ads",
			"where"  => $where,
			"limit"  => $limit,
			"offset" => $offset,
			"order_by" => $order_by,
			"order"  => $order
		]);

		if ( empty( $select ) ) return false;
		$items = [];
		foreach( $select as $_i ){

			$_i["time_add_sml"] = substr( $_i["time_add"], 0, 10 );
			$_i["url_host"] = parse_url( $_i["url"], PHP_URL_HOST );
			$_i["type_hr"] = $this->loader->lorem->turn( $_i["type"] );

			// daily
			if ( $_i["fund_spent_day_code"] != date("ymd") )
			$_i["fund_spent_day"] = 0;

			// files
			$_i["files_o"] = $_i["files"];
			$_i["files"] = json_decode( $_i["files"], 1 );
			$_i["files_urls"] = [];
			$_i["files_urls_inline"] = "";
			if ( !empty( $_i["files"] ) ){
				foreach( $_i["files"] as $_i_f_k => $_i_f ){
					$_i["files_urls"][ $_i_f_k ] = $this->loader->general->path_to_addr( $_i_f );
					if ( $_i_f_k != "audio_duration" )
					$_i["files_urls_inline"] .= "<a href='{$_i["files_urls"][ $_i_f_k ]}'>File</a> ";
				}
			}

			// active sta
			if ( $_i["active"] == 0 ) { $_i["active_code"] = "pending"; $_i["active_color"] = "danger"; }
			elseif( $_i["active"] == 1 ) { $_i["active_code"] = "active"; $_i["active_color"] = "success"; }
			elseif ( $_i["active"] == 2 ) { $_i["active_code"] = "paused"; $_i["active_color"] = "warning"; }
			elseif ( $_i["active"] == 3 ) { $_i["active_code"] = "finished"; $_i["active_color"] = "secondary"; }
			elseif ( $_i["active"] == -2 ) { $_i["active_code"] = "rejected"; $_i["active_color"] = "danger"; }
			else { $_i["active_code"] = "removed"; $_i["active_color"] = "danger"; }
			$_i["active_hr"] = $this->loader->lorem->turn( $_i["active_code"], [ "uc" => true ] );

			// external get
			if ( in_array( "user", $_eg, true ) )
			$_i["user"] = $this->loader->user->select([ "ID" => $_i["user_id"] ]);

			$items[ $_i["ID"] ] = $_i;

		}

		return $singular && $limit == 1 ? reset( $items ) : $items;

	}
	public function create( $args ){

		$user_charge = null;
		$user_id = null;
		$type = null;
		$name = null;
		$files = null;
		$url = null;
		$placements = null;
		$fund_total = null;
		$fund_spent = null;
		$fund_remain = null;
		$fund_limit = null;
		$fund_spent_day = null;
		$fund_spent_day_code = null;
		$act_clicks = null;
		$act_views = null;
		$active = $this->loader->admin->get_setting("ads_approved",0);
		extract( $args );

		if ( !$user_id || !$type || !$name || !$files || !$url || !$fund_total || !$fund_remain ) return false;

		$files = is_array( $files ) ? json_encode( $files ) : $files;
		$placements = is_array( $placements ) ? implode( ",", $placements ) : $placements;

		if ( $type == "audio_v" )
		$placements = null;

		$set = [
			[ "user_id", $user_id ],
			[ "type", $type ],
			[ "name", $name ],
			[ "files", $files ],
			[ "url", $url ],
			[ "fund_total", $fund_total ],
			[ "fund_remain", $fund_remain ],
			[ "active", $active ],
			[ "placements", $placements ],
		];

		if ( $fund_spent )
		$set[] = [ "fund_spent", $fund_spent ];

		if ( $fund_limit )
		$set[] = [ "fund_limit", $fund_limit ];

		if ( $fund_spent_day )
		$set[] = [ "fund_spent_day", $fund_spent_day ];

		if ( $fund_spent_day_code )
		$set[] = [ "fund_spent_day_code", $fund_spent_day_code ];

		$create = $this->db->_insert([
			"table" => "_setting_ads",
			"set"   => $set
		]);

		if ( !$create ) return false;

		if ( !empty( $placements ) ){
			foreach( explode( ",", $placements ) as $_pl ){
				$this->db->_insert([
					"table" => "_setting_ads_placements",
					"set" => [
						[ "ad_id", $create ],
						[ "placement_code", $_pl ]
					]
				]);
			}
		}

		if ( $user_charge && $user_id ){

			// Remove funds
			$this->loader->pay->remove_funds( $user_id, $fund_total );

			// Record transaction
			$order_no = $this->loader->pay->record_transaction([
				"amount"    => $fund_total,
				"type"      => "out",
				"data"      => [ "item" => "advertisement" ],
				"revenue"   => $fund_total,
				"completed" => 1
			]);

			// Record transaction in ads table
			$this->db->_update([
				"table" => "_setting_ads",
				"set"   => [
					[ "order_no", $order_no ]
				],
				"where" => [
					[ "ID", "=", $create ]
				]
			]);

			// Notify admins
			$this->loader->admin->add_not([
				"type" => "69",
				"hook" => $user_id,
				"extraData" => [ "amount" => $fund_total ]
			]);

		}

		if ( $active == 1 ){
			$this->exe_approve( $create );
		}

	}

	public function exe_approve( $ad_id ){

		$ad_data = $this->select([ "ID" => $ad_id ]);
		if ( !$ad_data["user_id"] ) return;
		if ( $ad_data["active"] != 0 ) return;

		// Add log
		$this->loader->user->add_log([
			"user_id" => null,
			"user_id_2" => $ad_data["user_id"],
			"type" => "26",
			"hook" => $ad_id
		]);

		// Ad table
		$this->db->_update([
			"table" => "_setting_ads",
			"set"   => [
				[ "active", "1" ]
			],
			"where" => [
				[ "ID", "=", $ad_id ]
			]
		]);

	}
	public function exe_reject( $ad_id ){

		$ad_data = $this->select([ "ID" => $ad_id ]);
		if ( !$ad_data["user_id"] ) return;
		if ( $ad_data["active"] != 0 ) return;

		// remove log
		$this->loader->user->remove_log([
			"user_id" => null,
			"user_id_2" => $ad_data["user_id"],
			"type" => 26,
			"hook" => $ad_id
		]);

		// Transaction table
		$this->db->_update([
			"table" => "_user_transaction",
			"set"   => [
				[ "completed", -1 ],
				[ "paid", 0 ]
			],
			"where" => [
				[ "order_no", "=", $ad_data["order_no"] ]
			]
		]);

		// Ad table
		$this->db->_update([
			"table" => "_setting_ads",
			"set"   => [
				[ "active", "-2" ]
			],
			"where" => [
				[ "ID", "=", $ad_id ]
			]
		]);

		// User funds
		$this->loader->pay->add_funds( $ad_data["user_id"], $ad_data["fund_total"] );

	}
	public function exe_pause( $ad_id ){

		$ad_data = $this->select([ "ID" => $ad_id ]);
		if ( !$ad_data ) return;
		if ( $ad_data["active"] != 1 ) return;

		$this->db->_update([
			"table" => "_setting_ads",
			"set"   => [
				[ "active", "2" ]
			],
			"where" => [
				[ "ID", "=", $ad_id ]
			]
		]);

		return true;

	}
	public function exe_resume( $ad_id ){

		$ad_data = $this->select([ "ID" => $ad_id ]);
		if ( !$ad_data ) return;
		if ( $ad_data["active"] != 2 ) return;

		$this->db->_update([
			"table" => "_setting_ads",
			"set"   => [
				[ "active", "1" ]
			],
			"where" => [
				[ "ID", "=", $ad_id ]
			]
		]);

		return true;

	}
	public function exe_remove( $ad_id ){

		$ad_data = $this->select([ "ID" => $ad_id ]);
		if ( !$ad_data ) return;
		if ( $ad_data["active"] != 2 && $ad_data["active"] != -2 ) return;

		$this->db->_update([
			"table" => "_setting_ads",
			"set"   => [
				[ "active", "-1" ]
			],
			"where" => [
				[ "ID", "=", $ad_id ]
			]
		]);

		return true;

	}
	public function exe_finish( $ad_id ){

		$ad_data = $this->select([ "ID" => $ad_id ]);

		// Add log
		$this->loader->user->add_log([
			"user_id" => null,
			"user_id_2" => $ad_data["user_id"],
			"type" => "27",
			"hook" => $ad_id
		]);

		$this->db->_update([
			"table" => "_setting_ads",
			"set"   => [
				[ "active", "3" ],
			],
			"where" => [
				[ "ID", "=", $ad_id ]
			]
		]);

	}

	public function update_acts( $ad_id, $type, $change=1 ){

		if ( !in_array( $type, [ "views", "clicks" ], true ) ) return false;

		$a = $change > 0 ? "+" : "-";
		$b = abs( $change );
		$this->db->query("UPDATE _setting_ads SET act_{$type} = act_{$type} {$a} {$b} WHERE ID = '{$ad_id}' ");

	}
	public function update_fund( $ad_id, $amount ){

		$ad_data = is_array( $ad_id ) ? $ad_id : $this->select(["ID"=>$ad_id]);
		$new_fund = $ad_data["fund_remain"] - $amount;
		$new_fund = $new_fund < 0 ? 0 : $new_fund;
		$day_code = date("ymd");

		if ( $ad_data ? $ad_data["fund_spent_day_code"] != $day_code : false )
		$this->db->query("UPDATE _setting_ads SET fund_spent_day = 0, fund_spent_day_code = '{$day_code}' WHERE ID = '{$ad_data["ID"]}' ");
		$this->db->query("UPDATE _setting_ads SET fund_remain = '{$new_fund}', fund_spent = fund_spent + {$amount}, fund_spent_day = fund_spent_day + {$amount} WHERE ID = '{$ad_data["ID"]}' ");

		if ( $new_fund <= 0 )
		$this->exe_finish( $ad_data["ID"] );

		return true;

	}

}
?>
