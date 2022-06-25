<?php

if ( !defined( "root" ) ) die;
// Require config file
require_once( realpath( app_root . "/config.php" ) );

// Require loader class
require_once(realpath( app_core_root . "/class_loader.php" ) );

$loader = new loader();

// bypass all filters to display covers from protected folder during user upload
if( isset( $_GET["play_uploading"] ) &&
    isset( $_GET["cover"] ) &&
    !empty( $_GET["hash"] ) &&
    !empty( $_GET["ID"] ) ){
	$loader->_setup_play_uploading();
}

// Require DB class. other classes will be required when called upon
$loader->_require_core_files( "db" );
// Check user request
$loader->_check_user_request();

// Load admin setting
$loader->_load_admin_setting();

// Set language ( Check admin & user setting )
$loader->_set_language();
// Check page request
$loader->_handle_page_request();
// Set timeout
$loader->_set_timeout();

// Backend or Frontend request?
if ( empty( $_POST["action"] ) && empty( $_FILES["\$file"] ) ){

	// Execute user-interface ( UI )
	$loader->hit->__log_hit();
	$loader->ui->execute();

} else {

	// Execute backend ( BE )
	$loader->be->execute();

}

?>
