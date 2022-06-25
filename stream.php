<?php

set_time_limit(0);

require_once( __DIR__ . "/app/_ini.php" );
require_once( realpath( app_core_root . "/class_loader.php" ) );
require_once( app_core_root . "/class_stream.php" );

$loader = new loader();
$loader->_require_core_files( "secure" );

// Validate && sanitize request strings
if ( !( $play_hash = $loader->secure->get( "get", "play_hash", "md5" ) ) ) die ('1');
if ( !( $track_hash = $loader->secure->get( "get", "track_hash", "md5" ) ) ) die ('1');
if ( !( $track_key = $loader->secure->get( "get", "track_key", "md5" ) ) ) die ('1');
if ( !( $source_hash = $loader->secure->get( "get", "source_hash", "md5" ) ) ) die ('1');

// Validate sessions
if ( empty( $_SESSION["play_hash"] ) ) die ('9');
if ( empty( $_SESSION["play_hash_expire"] ) ) die ('10');
if ( empty( $_SESSION["play_track_key"] ) ) die ('11');
if ( empty( $_SESSION["play_track_hash"] ) ) die ('12');
if ( empty( $_SESSION["play_track_name"] ) ) die ('13');
if ( empty( $_SESSION["play_track_expire"] ) ) die('14');
if ( empty( $_SESSION["play_source_hash"] ) ) die ('15');
if ( empty( $_SESSION["play_source_file"] ) ) die ('16');
if ( empty( $_SESSION["play_que"] ) ) die('18');
if ( !isset( $_SESSION["play_track_paid"] ) ) die('18.1');
if ( time() > $_SESSION["play_track_expire"] ) die('19');
if ( time() > $_SESSION["play_hash_expire"] ) die ('20');

// Compare sessions data to request data
if ( $play_hash !== $_SESSION["play_hash"] ) die ('22');
if ( $track_key !== $_SESSION["play_track_key"] ) die ('23');
if ( $track_hash !== $_SESSION["play_track_hash"] ) die ('24');
if ( $source_hash !== $_SESSION["play_source_hash"] ) die ('25');

// Validate request headers
// if ( empty( $_SERVER["HTTP_RANGE"] ) ) die('26');
if ( empty( $_SERVER["HTTP_REFERER"] ) ) die('27');

session_write_close();

$streamer = new stream();
$streamer->handle_download( $_SESSION["play_source_file"], "{$_SESSION["play_track_name"]}.mp3", $_SESSION["play_track_paid"] );

?>
