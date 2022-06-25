<?php

if ( !defined( "root" ) ) die;

$loader->admin->save_setting( "sl_fb", $this->ps["sl_fb"] );
$loader->admin->save_setting( "sl_fb_k1", $this->ps["sl_fb_k1"] );
$loader->admin->save_setting( "sl_fb_k2", $this->ps["sl_fb_k2"] );
$loader->admin->save_setting( "sl_ig", $this->ps["sl_ig"] );
$loader->admin->save_setting( "sl_ig_k1", $this->ps["sl_ig_k1"] );
$loader->admin->save_setting( "sl_ig_k2", $this->ps["sl_ig_k2"] );
$loader->admin->save_setting( "sl_ggl", $this->ps["sl_ggl"] );
$loader->admin->save_setting( "sl_ggl_k1", $this->ps["sl_ggl_k1"] );
$loader->admin->save_setting( "sl_ggl_k2", $this->ps["sl_ggl_k2"] );
$loader->admin->save_setting( "sl_tw", $this->ps["sl_tw"] );
$loader->admin->save_setting( "sl_tw_k1", $this->ps["sl_tw_k1"] );
$loader->admin->save_setting( "sl_tw_k2", $this->ps["sl_tw_k2"] );

$this->set_response( "saved" );

?>
