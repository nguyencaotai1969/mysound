<?php

set_time_limit(0);

require_once( __DIR__ . "/app/_ini.php" );
require_once( realpath( app_core_root . "/class_loader.php" ) );
require_once( app_core_root . "/class_stream.php" );

$loader = new loader();
$loader->_require_core_files( "secure" );

// Validate && sanitize request strings
if ( !( $hash = $loader->secure->get( "get", "hash", "md5" ) ) ) die('1');

// Validate sessions
if ( empty( $_SESSION["wave_hash"] ) ) die ('3');
if ( time() > $_SESSION["wave_expire"] ) die ('4');

// Compare sessions data to request data
if ( $hash !== $_SESSION["wave_hash"] ) die ('5');

session_write_close();

$streamer = new stream();
$streamer->handle_download( $_SESSION["wave_file"], "waveform_demo.mp3", true );

?>
