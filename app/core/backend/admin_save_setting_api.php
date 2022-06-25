<?php

if ( !defined( "root" ) ) die;

$loader->admin->save_setting( "get_visitor_ip_data", $this->ps["get_visitor_ip_data"] );
$loader->admin->save_setting( "spotify_search", $this->ps["spotify_search"] );
$loader->admin->save_setting( "spotify_upload", $this->ps["spotify_upload"] );
$loader->admin->save_setting( "spotify_upload_e", $this->ps["spotify_upload_e"] );
$loader->admin->save_setting( "spotify_d_a", $this->ps["spotify_d_a"] );
$loader->admin->save_setting( "spotify_d_ar", $this->ps["spotify_d_ar"] );
$loader->admin->save_setting( "spotify_d_a_ts", $this->ps["spotify_d_a_ts"] );
$loader->admin->save_setting( "spotify_d_la_ts", $this->ps["spotify_d_la_ts"] );
$loader->admin->save_setting( "spotify_g_c", $this->ps["spotify_g_c"] );
$loader->admin->save_setting( "utube_api", $this->ps["utube_api"] );
$loader->admin->save_setting( "youtube_d_t", $this->ps["youtube_d_t"] );

$loader->admin->save_setting( "spotify_id", $this->ps["spotify_id"] );
$loader->admin->save_setting( "spotify_key", $this->ps["spotify_key"] );
$loader->admin->save_setting( "spotify_w_u_i", $this->ps["spotify_w_u_i"] );
$loader->admin->save_setting( "yt_key", $this->ps["yt_key"] );
$loader->admin->save_setting( "req_proxy", $this->ps["req_proxy"] );
$loader->admin->save_setting( "req_proxy_a", $this->ps["req_proxy_a"] );

$this->set_response( "saved" );

?>