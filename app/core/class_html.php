<?php

if ( !defined("root" ) ) die;

class html {

	protected $http_headers = [
		'status' => 'HTTP/1.1 200 OK',
	];
	protected $heads = [
		'r1' => '<meta http-equiv="X-UA-Compatible" content="IE=edge">',
		'r2' => '<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">',
		'r3' => '<meta name="HandheldFriendly" content="True">',
		'r4' => '<meta name="MobileOptimized" content="360">',
		'r5' => '<meta name = "introduction" content = "no-reference">',
	];
	protected $inline_styles = "";
	public $styles = [];
	public $javas = [];
	public $footer_javas = [];
	protected $content = [];
	protected $body_class = [];

	public function __construct( $loader ){

		$this->loader = $loader;
		$this->db = $loader->db;

		require_once( realpath( app_core_root . "/class_html_doms.php" ) );

		$this->doms = new doms( $this->loader );

	}

	public function set_title( $title ){

		$sitename = $this->loader->admin->get_setting( 'sitename', 'Sitename' );
		$this->heads[ 'title' ] = "<title>{$title} | {$sitename}</title>";
		$this->set_twitter( 'title', $title );
		$this->set_og( 'title', $title );
		return $this;

	}
	public function set_description( $description ){

		$this->heads["aa_desc"] = "<meta name='description' content='{$description}' >";
		$this->set_twitter( 'description', $description );
		$this->set_og( 'description', $description );
		return $this;

	}
	public function set_keywords( $keywords ){

		$this->heads["keywords"] = "<meta name='keywords' content='{$keywords}' />";
		return $this;

	}
	public function set_og( $var, $val ){

		$this->heads["aa_og_{$var}"] = "<meta property=\"og:{$var}\" content=\"{$val}\" />";
		return $this;

	}
	public function set_fb( $var, $val ){

		$this->heads["aa_fb_{$var}"] = "<meta property=\"fb:{$var}\" content=\"{$val}\" />";
		return $this;

	}
	public function set_article( $var, $val ){

		$this->heads["aa_article_{$var}"] = "<meta property=\"article:{$var}\" content=\"{$val}\" />";
		return $this;

	}
	public function set_twitter( $var, $val ){

		$this->heads["aa_twitter_{$var}"] = "<meta name=\"twitter:{$var}\" content=\"{$val}\" />";
		return $this;

	}
	public function set_code( $var, $val ){

		$this->heads[ $var ] = $val;
		return $this;

	}

	public function set_http_header( $var, $val ){

		$this->http_headers[ $var ] = $val;
		return $this;

	}

	public function add_meta( $k, $val ){
		$this->heads[$k] = $val;
	}
	public function add_style( $styleID, $stylePath ){

		$stylePath = substr( $stylePath, 0, 4 ) == "http" || substr( $stylePath, 0, 3 ) == "://" ? $stylePath : $this->loader->theme->addr . $stylePath;
		$this->styles[ $styleID ] = "{$stylePath}";
		return $this;

	}
	public function add_java( $javaID, $javaPath, $footer = false ){

		$javaPath = substr( $javaPath, 0, 4 ) == "http" || substr( $javaPath, 0, 3 ) == "://" ? $javaPath : $this->loader->theme->addr . $javaPath;
		$footer ? $this->footer_javas[ $javaID ] = "{$javaPath}" : $this->javas[ $javaID ] = "{$javaPath}";
		return $this;

	}
	public function add_inline_style( $string ){
		$this->inline_styles .= $string;
	}
	public function add_body_class( $class ){

		$this->body_class = array_unique( array_merge( $this->body_class, is_array( $class ) ? $class : array( $class ) ) );

	}
	public function get_body_class( $check_for=null ){

		return $check_for ? in_array( $check_for, $this->body_class ) : $this->body_class;

	}

	public function add_content( $k, $data, $forceFresh = false ){

		$this->content[ $k ] = empty( $this->content[ $k ] ) ? $data : ( $forceFresh ? $data : $this->content[ $k ] . $data );
		return $this;

	}
	public function reset_content( $k ){

		$this->content[ $k ] = "";
		return $this;

	}

	protected function execute_assets( $assets, $asset_type ){

		if ( empty( $assets ) ) return;
		foreach( is_array( $assets ) ? $assets : [ $assets ] as $asset ){
			echo $asset_type == "css" ?
				  "<link href='{$asset}' rel='stylesheet' media='all' type='text/css'>\n" :
		          "<script src='{$asset}'></script>\n";
		}

	}
	public function execute(){

		if ( !empty( $this->http_headers ) ){
			foreach( $this->http_headers as $http_header ){
				header( $http_header );
			}
		}

		echo "<!DOCTYPE html>\n";
		echo "<html lang='{$this->loader->ui->lang}' dir='{$this->loader->ui->dir}' class='notranslate' translate='no' >\n ";
		echo "<head>\n";
		foreach( $this->heads as $__h ){
			echo $__h . PHP_EOL;
		}
		$this->execute_assets( $this->styles, "css" );
		$this->execute_assets( $this->javas, "js" );
		if ( !empty( $this->inline_styles ) ){
			echo $this->inline_styles;
		}
		echo "</head>\n";
		$bodyClass = empty( $this->body_class ) ? "" : " class=\"".(implode(" ",$this->body_class))."\"";
		echo "<body{$bodyClass}>\n";

		ksort( $this->content );
		foreach( $this->content as $__c ){
			echo $__c;
		}
		unset( $__c,$__h );

		echo PHP_EOL;
		$this->execute_assets( $this->footer_javas, "js" );
		echo "</body>\n";
		echo "</html>";

	}
	public function load_part( $partName, $args = [], $add_to_content = false ){

		$partPath = themes_root . "/__default/parts/{$partName}.php";
		if ( !file_exists( realpath( $partPath ) ) ){

			die("partName_{$partName} is missing from default theme. Try re-uploading script and DO NOT remove __default theme");
			exit();
			die;

		}

		$loader = $this->loader;
		if ( !empty( $args ) ) extract( $args );
		ob_start();
		require( realpath( $partPath ) );
		$ob_data = ob_get_contents();
		ob_end_clean();

		if ( $add_to_content ){
			$this->add_content( $add_to_content, $ob_data );
		}

		return $ob_data;

	}

}

?>
