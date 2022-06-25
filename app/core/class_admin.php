<?php

if ( !defined( "root" ) ) die;

class admin {

	protected $cache = [];

	public function __construct( $loader ){

		$this->loader = $loader;
		$this->db = $loader->db;

	}

	public function get_setting( $variableName, $defaultValue = null, $expectedValues = null, $json = null ){

		if ( $variableName == "web_addr" ) return web_addr;
		if ( $variableName == "purchase_code" ) return purchase_code;
		if ( $variableName == "client_code" ) return client_code;

		if ( !empty( $this->cache[ $variableName ] ) )
			return $this->cache[ $variableName ];

		$get_setting_value = $this->loader->db->_select([
			"table" => "_setting_admin",
		    "where" => [
			    [ "var", "=", $variableName ]
		    ]
		]);

		if ( empty( $get_setting_value ) )
			return $defaultValue;

		$setting_value = reset( $get_setting_value )["val"];

		if ( !empty( $expectedValues ) ? !in_array( $setting_value, $expectedValues ) : false )
			return $defaultValue;

		$value = $json ? json_decode( $setting_value, 1 ) : $setting_value;

		$this->cache[ $variableName ] = $value;
		return $value;

	}
	public function save_setting( $variableName, $value, $expectedValues = null ){

		if ( !empty( $expectedValues ) ){
			if ( is_array( $expectedValues ) ? !in_array( $value, $expectedValues ) : false )
				return false;
			else if ( is_string( $expectedValues ) ? preg_match( "{$expectedValues}", preg_quote( $value ) ) : false )
				return false;
		}

		if ( !is_null( $this->get_setting( $variableName, null ) ) ){
			$stmt = $this->db->prepare("UPDATE _setting_admin SET val = ? WHERE var = ?");
		}
		else {
			$stmt = $this->db->prepare("INSERT INTO _setting_admin ( val, var ) VALUES ( ?, ? )");
		}

		$stmt->bind_param( "ss", $value, $variableName );
		$stmt->execute();
		$stmt->close();

		return true;

	}

	public function add_not($args){

		if ( empty( $args ) ? true : !is_array( $args ) )
		return false;

		$type      = null;
		$hook      = null;
		$AID       = null;
		$extraData = null;
		extract( $args );

		if ( empty( $type ) || empty( $hook ) )
		return false;

		foreach( explode( ",", $this->get_setting("admin_ids",1) ) as $_receiver_id ){
			$this->loader->user->add_log([
				"type" => $type,
				"hook" => $hook,
				"AID"  => $AID,
				"extraData" => $extraData,
				"user_id" => null,
				"user_id_2" => $_receiver_id,
				"admin" => true
			]);
		}

	}

	public function load_themes(){

		$themes = [];
		$themes_contents = scandir( themes_root );
		foreach( $themes_contents as $theme_content ){
			if ( strlen( $theme_content ) <= 2 || $theme_content == "__default" ) continue;
			$theme_location = realpath( themes_root . "/{$theme_content}" );
			if ( !is_dir( $theme_location ) ) continue;
			if ( !is_readable( $theme_location ) ) continue;
			$theme_contents = scandir( $theme_location );
			if ( file_exists( "{$theme_location}/_ini.php" ) ){
				$themes[ $theme_content ] = $theme_content;
			}
		}
		return $themes;

	}

}

?>
