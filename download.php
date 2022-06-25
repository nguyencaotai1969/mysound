<?php

set_time_limit(0);

require_once( __DIR__ . "/app/_ini.php" );
require_once( realpath( app_root . "/config.php" ) );
require_once( realpath( app_core_root . "/class_loader.php" ) );
require_once( app_core_root . "/class_stream.php" );

$loader = new loader();
$loader->_require_core_files( [ "db", "secure" ] );

// Validate && sanitize request strings
if ( !( $key1 = $loader->secure->get( "get", "key1", "md5", [ "length" => 12 ] ) ) ) die ('1');
if ( !( $key2 = $loader->secure->get( "get", "key2", "md5", [ "length" => 12 ] ) ) ) die ('1');
if ( !( $key3 = $loader->secure->get( "get", "key3", "md5", [ "length" => 12 ] ) ) ) die ('1');
if ( !( $key4 = $loader->secure->get( "get", "key4", "md5", [ "length" => 12 ] ) ) ) die ('1');

// Find requested download
$get_download = $loader->db->query("SELECT * FROM _user_downloads WHERE key1 = '{$key1}' AND time_expire > now() ");
if ( !$get_download->num_rows ) die('9');
$download = $get_download->fetch_assoc();

// Compare keys
if (
	$download["key2"] != $key2 ||
	$download["key3"] != $key3 ||
	$download["key4"] != $key4
) die('10');


// Check lock on request begin
$begin = 0;
if ( isset( $_SERVER['HTTP_RANGE'] ) ? preg_match('/bytes=\h*(\d+)-(\d*)[\D.*]?/i', $_SERVER['HTTP_RANGE'], $matches) : false ){
	$begin = intval( $matches[1] );
}

if ( $begin / $download["source_file_size"] < 0.15 ){

	// Admin setting
	$_lock  = $loader->admin->get_setting( "download_lock", 1, [0,1] );

	// Compare user sessID,agent,ip if lock is on
	if ( $_lock ){

		if (
			$loader->secure->validate( $_SERVER["REMOTE_ADDR"], "ip" ) &&
			$loader->secure->validate( $_SERVER["HTTP_USER_AGENT"], "string" ) ?
			  $download["user_sess_id"] != session_id() ||
			  $download["user_ip"] != $_SERVER['REMOTE_ADDR'] ||
			  $download["user_agent"] != $_SERVER['HTTP_USER_AGENT']
			: false
		) die('11');

	}

	$loader->db->query("UPDATE _user_downloads SET uses = uses + 1 WHERE ID = '{$download["ID"]}' ");

}

session_write_close();

$streamer = new stream();
$streamer->handle_download( $download["source_file"], "{$download["track_name"]}.mp3", true, 'application/octet-stream' );

?>
