<?php

// Define absolute locations
define( "root", dirname(dirname(dirname(__DIR__))) );
define( "app_root", realpath( root . "/app" ) );
define( "app_core_root", realpath( root . "/app/core" ) );
define( "app_bot_root", realpath( root . "/app/core/bot/" ) );
define( "themes_root", realpath( root . "/themes" ) );

// Require config file
require_once( realpath( app_root . "/config.php" ) );

// Require loader class
require_once( realpath( app_core_root . "/class_loader.php" ) );

// Setup app
$loader = new loader();
$loader->_require_core_files( "db" );
$bot = $loader->bot;
$bot->update_spotify_widgets();

?>