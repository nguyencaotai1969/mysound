<?php

if ( !defined( "root" ) ) die;

$loader->admin->save_setting( "download_lock", $this->ps["download_lock"] );
$loader->admin->save_setting( "download_limit", $this->ps["download_limit"] );
$loader->admin->save_setting( "download_range", $this->ps["download_range"] );

$this->set_response( "saved" );

?>