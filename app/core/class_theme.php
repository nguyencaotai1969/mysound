<?php

if ( !defined("root" ) ) die;

class theme {

	public $name = null;
	public $path = null;
	public $addr = null;
	public $admin_setting = [];
	public $custom_pages = [];
	protected $cache = [];

	public function __construct( $loader ){

		$this->loader = $loader;
		$this->db = $loader->db;

	}

	public function set_name( $name = null ){

		$name = $name === null ? ( !empty( $this->loader->visitor->user()->admin ) && $this->loader->ui->page_parent == 'admin' ? 'admin' : $this->loader->admin->get_setting( 'theme_name' ) ) : $name;
		if ( empty( $name ) ){
			die( "themeName is empty. Try re-installing script or change theme_name in _setting_admin in mysql" );
		}

		$this->name = $name;
		$this->path = realpath( $this->name == "admin" ? app_root . "/admin/" : themes_root . "/{$this->name}/" );
		$this->addr = $this->name != "admin" ? $this->loader->admin->get_setting('web_addr') . "themes/{$this->loader->theme->name}/" :  $this->loader->admin->get_setting('web_addr') . "themes/__default/";

		return $this;

	}

	public function load(){
		$this->__req( '_ini.php', false );
	}

	public function load_setting(){
		$this->__req( '_setting.php', true );
	}

	public function __req( $partName, $skipDying = false, $extraData = false ){

		$themeName = $this->name;
		$themePath = $this->path . "/" . $partName;
		if ( !file_exists( realpath( $themePath ) ) ){

			if ( !$skipDying ){
				echo $themePath;
				echo PHP_EOL;
				die("{$themeName}_{$partName}_is_missing");
				exit();
			}

			return false;

		}

		if ( !empty( $extraData ) ? is_array( $extraData ) : false )
			extract( $extraData );

		$loader = $this->loader;
		$page_data = $this->loader->ui->page_data;
		ob_start();
		require( realpath( $themePath ) );
		$ob_data = ob_get_contents();
		ob_end_clean();
		return $ob_data;

	}

	public function setup_setting( $args ){

		extract( $args );
		$this->admin_setting[] = $args;

	}

	public function get_setting( $variableName, $defaultValue = null, $expectedValues = null ){

		if ( in_array( $variableName, array_keys( $this->cache ) ) ) return $this->cache[ $variableName ];

		$get_setting = $this->db->prepare("SELECT val FROM _setting_theme WHERE theme = ? AND var = ? ");
		$get_setting->bind_param( "ss", $this->name, $variableName );
		$get_setting->execute();
		$get_setting->bind_result( $val );
		$get_setting->fetch();
		$get_setting->close();

		$val = empty( $val ) ? $defaultValue : $val;
		$output = substr( $val, 0, 5 ) == "JSON_" ? $this->loader->general->json_decode( substr( $val, 5 ) ) : $val;

		$this->cache[ $variableName ] = $output;

		return $output;

	}

	public function save_setting( $variableName, $value ){

		$get_ID = $this->db->prepare("SELECT ID FROM _setting_theme WHERE theme = ? AND var = ?");
		$get_ID->bind_param( "ss", $this->name, $variableName );
		$get_ID->execute();
		$get_ID->bind_result( $ID );
		$get_ID->fetch();
		$get_ID->close();

		if ( empty( $ID ) ){
			$stmt = $this->db->prepare("INSERT INTO _setting_theme ( theme, var, val ) VALUES( ?, ?, ? ) ");
			$stmt->bind_param( "sss", $this->name, $variableName, $value );
			$stmt->execute();
			$ID = $stmt->insert_id;
			$stmt->close();
		} else {
			$stmt = $this->db->prepare("UPDATE _setting_theme SET val = ? WHERE theme = ? AND var = ?");
		    $stmt->bind_param( "sss", $value, $this->name, $variableName );
		    $stmt->execute();
		    $stmt->close();
		}

		return $ID;

	}

	public function add_custom_page( $page ){

		if ( is_array( $page ) ) $this->custom_pages = array_merge( $page, $this->custom_pages );
		else $this->custom_pages[] = $page;

	}

	public function has_custom_page( $page ){

		return in_array( $page, $this->custom_pages ) || in_array( "{$page}.php", $this->custom_pages );

	}

  public function add_advertisement_placements( $placement_data ){

    if ( empty( $placement_data ) ? true : !is_array( $placement_data ) || empty( $placement_data["code"] ) ) return false;
    $this->cache["placement"][ $placement_data["code"] ] = $placement_data;

  }

  public function get_advertisement_placements( $args=[] ){

    $lorem = false;
    $for_select = false;
    extract( $args );
    $this->load_setting();

    if ( empty( $this->cache["placement"] ) ) return false;
    $placements = $this->cache["placement"];

    foreach( $placements as &$placement ){
      $placement["lorem"] = $placement["code"];
      if ( !empty( $placement["name"] ) ) $placement["lorem"] = $placement["name"];
      else if ( $lorem ) $placement["lorem"] = $this->loader->lorem->turn("pl_{$placement["code"]}");
      if ( $for_select ) $placement = [ $placement["code"], $placement["lorem"] ];
    }

    return $for_select ? array_values ( $placements ) : $placements;

  }

}

?>
