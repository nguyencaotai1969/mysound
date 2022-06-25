<?php

if ( !defined( "root" ) ) die;

$loader->admin->save_setting( "currency", $this->ps["currency"] );
$loader->admin->save_setting( "currency_code", $this->ps["currency_code"] );
$loader->admin->save_setting( "currency_format", $this->ps["currency_format"] );
$loader->admin->save_setting( "sell_music_prices", $this->ps["sell_music_prices"] );
$loader->admin->save_setting( "upgrade_price", $this->ps["upgrade_price"] );
$loader->admin->save_setting( "withdrawal_min", $this->ps["withdrawal_min"] );

$loader->admin->save_setting( "adsense", $this->ps["adsense"] );
$loader->admin->save_setting( "banner_v_cost", $this->ps["banner_v_cost"] );
$loader->admin->save_setting( "banner_c_cost", $this->ps["banner_c_cost"] );
$loader->admin->save_setting( "audio_v_cost", $this->ps["audio_v_cost"] );
$loader->admin->save_setting( "ad_audio_iv", $this->ps["ad_audio_iv"] );

$loader->admin->save_setting( "og_approved", $this->ps["og_approved"] );
$loader->admin->save_setting( "pg_op", $this->ps["pg_op"] );
$loader->admin->save_setting( "bank_data", $this->ps["bank_data"] );

$loader->admin->save_setting( "pg_pp", $this->ps["pg_pp"] );
$loader->admin->save_setting( "pg_pp_sb", $this->ps["pg_pp_sb"] );
$loader->admin->save_setting( "pg_pp_k1", $this->ps["pg_pp_k1"] );
$loader->admin->save_setting( "pg_pp_k2", $this->ps["pg_pp_k2"] );

$loader->admin->save_setting( "pg_cp", $this->ps["pg_cp"] );
$loader->admin->save_setting( "pg_cp_k1", $this->ps["pg_cp_k1"] );
$loader->admin->save_setting( "pg_cp_k2", $this->ps["pg_cp_k2"] );
$loader->admin->save_setting( "pg_cp_k3", $this->ps["pg_cp_k3"] );
$loader->admin->save_setting( "pg_cp_k4", $this->ps["pg_cp_k4"] );
$loader->admin->save_setting( "pg_cp_cr", $this->ps["pg_cp_cr"] );

$loader->admin->save_setting( "pg_st", $this->ps["pg_st"] );
$loader->admin->save_setting( "pg_st_k1", $this->ps["pg_st_k1"] );
$loader->admin->save_setting( "pg_st_k2", $this->ps["pg_st_k2"] );

$loader->admin->save_setting( "pg_ps", $this->ps["pg_ps"] );
$loader->admin->save_setting( "pg_ps_k1", $this->ps["pg_ps_k1"] );
$loader->admin->save_setting( "pg_ps_k2", $this->ps["pg_ps_k2"] );

$loader->admin->save_setting( "pg_kk", $this->ps["pg_kk"] );
$loader->admin->save_setting( "pg_kk_sb", $this->ps["pg_kk_sb"] );
$loader->admin->save_setting( "pg_kk_k1", $this->ps["pg_kk_k1"] );
$loader->admin->save_setting( "pg_kk_k2", $this->ps["pg_kk_k2"] );
$loader->admin->save_setting( "pg_kk_k3", $this->ps["pg_kk_k3"] );

$loader->admin->save_setting( "pg_fw", $this->ps["pg_fw"] );
$loader->admin->save_setting( "pg_fw_sb", $this->ps["pg_fw_sb"] );
$loader->admin->save_setting( "pg_fw_k1", $this->ps["pg_fw_k1"] );
$loader->admin->save_setting( "pg_fw_k2", $this->ps["pg_fw_k2"] );
$loader->admin->save_setting( "pg_fw_k3", $this->ps["pg_fw_k3"] );

$loader->admin->save_setting( "pg_rp", $this->ps["pg_rp"] );
$loader->admin->save_setting( "pg_rp_sb", $this->ps["pg_rp_sb"] );
$loader->admin->save_setting( "pg_rp_k1", $this->ps["pg_rp_k1"] );
$loader->admin->save_setting( "pg_rp_k2", $this->ps["pg_rp_k2"] );

$this->set_response( "saved" );

?>
