<?php

if ( !defined( "root" ) ) die;

$loader->admin->save_setting( "chunk", $this->ps["chunk"] );
$loader->admin->save_setting( "chunk_size", $this->ps["chunk_size"] );
$loader->admin->save_setting( "max_par_ups", $this->ps["max_par_ups"] );
$loader->admin->save_setting( "max_size", $this->ps["max_size"] );
$loader->admin->save_setting( "upload_write_id3", $this->ps["upload_write_id3"] );
$loader->admin->save_setting( "upload_min_bitrate", $this->ps["upload_min_bitrate"] );
$loader->admin->save_setting( "upload_min_cover", $this->ps["upload_min_cover"] );

$this->set_response( "saved" );

?>
