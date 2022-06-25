<?php

// Start the session
session_start();

// Define absolute locations
define( "root", dirname(__DIR__) );
define( "app_root", realpath( root . "/app" ) );
define( "app_core_root", realpath( root . "/app/core" ) );
define( "themes_root", realpath( root . "/themes" ) );

?>