<?php

if ( !defined( "root" ) ) die;

$loader->admin->save_setting( "aws_protect", $this->ps["aws_protect"] );

$loader->admin->save_setting( "aws", $this->ps["aws"] );
$loader->admin->save_setting( "aws_bucket", $this->ps["aws_bucket"] );
$loader->admin->save_setting( "aws_secret", $this->ps["aws_secret"] );
$loader->admin->save_setting( "aws_key", $this->ps["aws_key"] );
$loader->admin->save_setting( "aws_region", $this->ps["aws_region"] );
$loader->admin->save_setting( "aws_endpoint", $this->ps["aws_endpoint"] );

$loader->admin->save_setting( "ftp", $this->ps["ftp"] );
$loader->admin->save_setting( "ftp_username", $this->ps["ftp_username"] );
$loader->admin->save_setting( "ftp_password", $this->ps["ftp_password"] );
$loader->admin->save_setting( "ftp_address", $this->ps["ftp_address"] );
$loader->admin->save_setting( "ftp_port", $this->ps["ftp_port"] );
$loader->admin->save_setting( "ftp_path", $this->ps["ftp_path"] );
$loader->admin->save_setting( "ftp_ssl", $this->ps["ftp_ssl"] );
$loader->admin->save_setting( "ftp_web_address", $this->ps["ftp_web_address"] );

$this->set_response( "saved" );

?>
