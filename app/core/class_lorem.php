<?php

if ( !defined( "root" ) ) die;

class lorem {

	protected $cache = [];
	protected $gonewrong = [];

	public function __construct( $loader ){

		$this->loader = $loader;
		$this->db = $loader->db;

	}
	public function turn ( $hook, $args=[] ){

		$val     = null;
		$lang    = $this->loader->ui->lang;
		$params  = [];
		$uc      = false;
		$inline  = false;
		$escape  = true;
		$eol_br  = false;
		extract( $args );

		$_c_ID = "{$hook}_" . ( $args ? $this->loader->general->make_code( json_encode( $args ) ) : "no_args" );
		if ( in_array( $_c_ID, array_keys( $this->cache ) ) ) return $this->cache[ $_c_ID ];

		$get_text = $this->db->prepare("SELECT text FROM _langs WHERE lang = ? AND hook = ?");
		$get_text->bind_param( "ss", $lang, $hook );
		$get_text->execute();
		$get_text->bind_result( $text );
		$get_text->fetch();
		$get_text->execute();

		if ( empty( $text ) ){
			$this->gonewrong[] = $hook;
		}

		$output = empty( $text ) ? ( $val ? $val : $hook ) : $text;

		if ( !empty( $params ) ? is_array( $params ) : false ){
			foreach( $params as $param_hook => $param_val ){
				$output = str_replace( "\${$param_hook}\$", $param_val, $output );
			}
		}

		$output = $uc ? ucfirst( $output ) : $output;

		if ( $eol_br )
		$output = str_replace( [ "\n", "\r\n", PHP_EOL ], "<BR>", $output );

		if ( $inline )
		$output = str_replace( [ "'", '"' ], [ "\'", '\"' ], $output );

		elseif ( $escape )
		$output = $this->loader->secure->escape( $output );


		$this->cache[ $_c_ID ] = $output;

		return $output;

	}
	public function eturn( $hook, $args=[] ){

		echo $this->turn( $hook, $args );

	}
	public function get_gonewrong(){
		return $this->gonewrong;
	}

}

?>
