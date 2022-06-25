<?php

if ( !defined( "root" ) ) die;

$loader->admin->save_setting( "sitename", $this->ps["sitename"] );
$loader->admin->save_setting( "web_addr", $this->ps["web_addr"] );
$loader->admin->save_setting( "theme_name", $this->ps["theme_name"] );
$loader->admin->save_setting( "lang", $this->ps["lang"] );
$loader->admin->save_setting( "up_timeout", $this->ps["up_timeout"] );
$loader->admin->save_setting( "signup_verified", $this->ps["signup_verified"] );
$loader->admin->save_setting( "redirect_single_album", $this->ps["redirect_single_album"] );
$loader->admin->save_setting( "prefer_localfile", $this->ps["prefer_localfile"] );
$loader->admin->save_setting( "video_display", $this->ps["video_display"] );
$loader->admin->save_setting( "station", $this->ps["station"] );
$loader->admin->save_setting( "default_gid", $this->ps["default_gid"] );
$loader->admin->save_setting( "heard_ratio", $this->ps["heard_ratio"] );
$loader->admin->save_setting( "twitter_username", $this->ps["twitter_username"] );

$this->set_response( "saved" );

?>
