<?php

if ( !defined( "root" ) ) die;

$loader->admin->save_setting( "session_i_lock", $this->ps["session_i_lock"] );
$loader->admin->save_setting( "session_p_lock", $this->ps["session_p_lock"] );
$loader->admin->save_setting( "session_max", $this->ps["session_max"] );
$loader->admin->save_setting( "session_lifetime", $this->ps["session_lifetime"] );

$this->set_response( "saved" );

?>