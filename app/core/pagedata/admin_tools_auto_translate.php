<?php

if ( !defined( "root" ) ) die;

$langs = $loader->admin->get_setting( "langs", null, null, true );
$reqed_lang = null;

$get_en_hooks = $loader->db->query("SELECT * FROM _langs WHERE lang = 'en' ");
while( $en_hook = $get_en_hooks->fetch_assoc() ){
	$hooks[ "en" ][ $en_hook["hook"] ] = $en_hook;
}

if ( ( $reqed_lang = $loader->secure->get( "get", "code", "in_array", [ "values" => array_keys( $langs ) ] ) ) ){
	$get_reqed_lang_hooks = $loader->db->query("SELECT * FROM _langs WHERE lang = '{$reqed_lang}' ");
    while( $reqed_lang_hook = $get_reqed_lang_hooks->fetch_assoc() ){
	    $hooks[ $reqed_lang ][ $reqed_lang_hook["hook"] ] = $reqed_lang_hook;
    }
}

$this->set_page_data([
	"langs" => $langs,
	"hooks" => $hooks,
	"reqed_lang" => $reqed_lang
]);

$loader->html->set_title( "Tools - Auto Translate" );

?>
