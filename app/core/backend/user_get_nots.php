<?php

if ( !defined( "root" ) ) die;
if ( $this->ps["hash"] != $_SESSION["play_hash"] ) $this->set_error( "refresh_website", true );

$allowed_nots = $loader->visitor->user()->data["event_allowed"]["not"];

if ( !$this->ps["full"] )
$this->set_response( $loader->db->query("SELECT 1 FROM _user_actions WHERE user_id_2 = '{$loader->visitor->user()->ID}' AND type IN (".implode(",",$allowed_nots).") AND time_add > '{$loader->visitor->user()->data["time_notified"]}' ")->num_rows );

$loader->db->query("UPDATE _users SET time_notified = now() WHERE ID = '{$loader->visitor->user()->ID}' ");

$nots = $loader->visitor->user()->get_acts( [
	"user_id"   => null,
	"user_id_2" => $loader->visitor->user()->ID,
	"acts_ids"  => $allowed_nots,
	"limit"     =>  $this->loader->hit->agent_data["device"]["type"] == "mobile" ? 4 : 8,
	"page"      => $this->ps["page"],
	"lorem_prefix" => "rec_type"
] );

if ( empty( $nots["acts"] ) )
$this->set_response( "<li class='empty'>{$this->loader->lorem->turn("no_nots_yet",["uc"=>true])}</li>", false, false, true );

$nots_html = "";
foreach( $nots["acts"] as $not ){
	$nots_html .= $loader->theme->set_name('__default')->__req( "parts/m_not.php", false, [
		"not" => $not,
		"user_time" => $loader->visitor->user()->data["time_notified"] ? strtotime( $loader->visitor->user()->data["time_notified"] ) : $loader->visitor->user()->data["time_notified"]
	] );
}

if ( $nots["has_more"] ){
	$nots_html .= "<li class='load_more' onClick='get_nots( true, ".($this->ps["page"]+1).", $(\".nots_ul\") )'>{$loader->lorem->turn("next",["uc"=>true])}</li>";
}

$this->set_response( $nots_html, false, false, true );

?>
