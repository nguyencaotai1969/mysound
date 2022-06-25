<?php
if ( !defined( "root" ) ) die;

$loader->ui->includes = [];

if ( !$loader->visitor->user()->has_access( "group", "muse" ) )
die('no_access');

$track_data = $loader->track->select([
	"ID"  => $loader->ui->page_hook,
	"_eg" => [ "source" ]
]);

$source_data = $loader->source->select([
	"track_id" => $track_data["ID"],
	"prefer_localfile" => $loader->admin->get_setting( "prefer_localfile", 1 ),
	"prefer_hq" => false
]);

$_SESSION["play_source_hash"]  = $source_data["hash"];
$_SESSION["play_source_file"]  = $source_data["data"];
$_SESSION["play_track_key"]    = md5( uniqid() );
$_SESSION["play_track_name"]   = $track_data["code"];
$_SESSION["play_track_hash"]   = $track_data["hash"];
$_SESSION["play_track_expire"] = time() + (5*60*60);
$_SESSION["play_track_paid"]   = $track_data["price"] ? false : true;

$loader->playlist->extend_que([$track_data["hash"]]);

$this->set_page_data([
	"track"  => $track_data,
	"source" => $source_data
]);

?>
