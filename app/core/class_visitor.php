<?php

if ( !defined("root" ) ) die;

class visitor {

	// Session
	public $play_hash = false;
	public $UID = false;

	// Access
	public $access = array(
		"ui" => [],
		"be" => [],
	);


	public function __construct( $loader ){

		$this->loader = $loader;
		$this->db = $loader->db;
		$this->def_access = $this->access;

	}
	public function user(){

		return $this->loader->user->set(
			!empty( $_SESSION["userID"] ) ? $_SESSION["userID"] : null,
			[ "data" => true ] )
			->data( [ "group_data", "event_setting" ] ) ;

	}

	public function set_access(){

		$this->access["ui"] = $this->access["be"] = [];

		$visitor_user = $this->user();

		if ( $visitor_user->ui_access )
			$this->give_access( "ui", $visitor_user->ui_access );

		if ( $visitor_user->be_access )
			$this->give_access( "be", $visitor_user->be_access );

		if ( $visitor_user->guest ) return;

		$this->UID = $visitor_user->ID;

		// User global pages shotcut
		$this->loader->ui->pre_pages[ "user_activities" ]   = [ "p" => "user", "t" => "user_activities" ];
		$this->loader->ui->pre_pages[ "user_playlists" ]    = [ "p" => "user", "t" => "user_playlists" ];
		$this->loader->ui->pre_pages[ "user_likes" ]        = [ "p" => "user", "t" => "user_likes" ];
		$this->loader->ui->pre_pages[ "user_heard" ]        = [ "p" => "user", "t" => "user_heard" ];
		$this->loader->ui->pre_pages[ "user_uploads" ]      = [ "p" => "user", "t" => "user_uploads" ];
		$this->loader->ui->pre_pages[ "user_reposts" ]      = [ "p" => "user", "t" => "user_reposts" ];
		$this->loader->ui->pre_pages[ "user_followers" ]    = [ "p" => "user", "t" => "user_followers" ];
		$this->loader->ui->pre_pages[ "user_followings" ]   = [ "p" => "user", "t" => "user_followings" ];

	}
	public function set_play_access(){

		if ( !empty( $_SESSION["play_hash"] ) && !empty( $_SESSION["play_hash_expire"] ) ? $_SESSION["play_hash_expire"] > time() : false ){
			$this->play_hash = $_SESSION["play_hash"];
			return;
		}

		$_SESSION["play_hash"] = md5( uniqid() );
		$_SESSION["play_hash_expire"] = time() + ( 24*60*60 );
		$this->play_hash = $_SESSION["play_hash"];

	}
	public function give_access( $type, $hook ){

		$this->access[ $type ] = array_unique( array_merge( $this->access[ $type ], is_array( $hook ) ? $hook : array( $hook ) ) );
		return $this;

	}
	public function remove_access( $type, $hook ){

		if ( is_array( $hook ) ){
			foreach( $hook as $__h ){
				$this->remove_access( $type, $__h );
			}
			return $this;
		}

		if ( ( $key = array_search( $hook, $this->access[ $type ] ) ) !== false )
			unset( $this->access[ $type ][ $key ] );

		return $this;

	}
	public function has_access( $type, $name ){

		return in_array( $name, $this->access[ $type ] );

	}

}

?>
