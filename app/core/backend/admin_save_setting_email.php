<?php

if ( !defined( "root" ) ) die;

$loader->admin->save_setting( "email_s_type", $this->ps["email_s_type"] );
$loader->admin->save_setting( "email_s_host", $this->ps["email_s_host"] );
$loader->admin->save_setting( "email_s_port", $this->ps["email_s_port"] );
$loader->admin->save_setting( "email_s_user", $this->ps["email_s_user"] );
$loader->admin->save_setting( "email_s_pass", $this->ps["email_s_pass"] );
$loader->admin->save_setting( "email_s_encrypt", $this->ps["email_s_encrypt"] );

$this->set_response( "saved" );

?>