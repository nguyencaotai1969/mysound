<?php

if ( !defined( "root" ) ) die;

$loader->admin->save_setting( "ffmpeg", $this->ps["ffmpeg"] );
$loader->admin->save_setting( "ffmpeg_convert", $this->ps["ffmpeg_convert"] );
$loader->admin->save_setting( "ffmpeg_wave", $this->ps["ffmpeg_wave"] );
$loader->admin->save_setting( "ffmpeg_path", $this->ps["ffmpeg_path"] );
$loader->admin->save_setting( "youtube_dl", $this->ps["youtube_dl"] );
$loader->admin->save_setting( "youtube_dl_path", $this->ps["youtube_dl_path"] );

$this->set_response( "saved" );

?>
