<?php

if ( !defined( "root" ) ) die;

$song = $loader->track->select( [ "hash" => $this->ps["hash"] ] );
if ( empty( $song ) ) $this->set_error( "invalid_hash", true );

if( mb_strlen( $this->ps["comment"], "UTF-8" ) > 100 )
	$this->set_error( "long_comment" );

$m_song = $m_seek = null;
if ( !empty( $this->ps["m_hash"] ) ){

	$m_song = $loader->track->select( [ "hash" => $this->ps["m_hash"] ] );
	if ( empty( $m_song ) ) $this->set_error( "invalid_hash", true );
	$m_seek = !empty( $this->ps["m_seeker"] ) && $m_song["ID"] == $song["ID"] ? ( is_numeric( $this->ps["m_seeker"] ) && $this->ps["m_seeker"] < $m_song["duration"] ? $this->ps["m_seeker"] : 0 ) : 0;

}

if ( !empty( $this->ps["PID"] ) ){

	$parent_comment = $loader->comment->select(["ID"=>$this->ps["PID"],"no_childs"=>false]);
	if ( empty( $parent_comment ) ) $this->set_error( "invalid_PID", true );
	if ( count( explode( "@{$parent_comment["user"]["username"]}", $this->ps["comment"] ) ) == 1 ){
		$this->ps["comment"] = "@{$parent_comment["user"]["username"]} " . $this->ps["comment"];
	}
	if ( $parent_comment["depth"] >= 3 ) $this->set_error( "invalid_PID", true );

}

$add_commenet = $loader->comment->create([

	"user_id"     => $loader->visitor->user()->ID,
	"text"        => $this->ps["comment"],
	"target_type" => "track",
	"target_id"   => $song["ID"],
	"target_seek" => $m_seek,
	"PID"         => $this->ps["PID"]

]);

if ( $add_commenet )
	$this->set_response( "posted" );
	$this->set_error( "waiting_4_approve" );

?>
