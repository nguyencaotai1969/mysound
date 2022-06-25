<?php

if ( !defined( "root" ) ) die;

// code
$langs = $loader->admin->get_setting( "langs", null, null, true );
if ( !in_array( $this->ps["code"], array_keys( $langs ) ) ) die;

// ID
$en_data = $loader->db->query("SELECT * FROM _langs WHERE lang = 'en' AND ID = '{$this->ps["ID"]}' ");
if ( !$en_data->num_rows ) die;
$en_data = $en_data->fetch_assoc();

if ( count( explode( '$', $en_data["text"] ) ) > 1 )
	$this->set_response("Can't auto-translate <i>{$en_data["text"]}</i> because it has variable text in it");

// target data
$t_data = $loader->db->query("SELECT 1 FROM _langs WHERE lang = '{$this->ps["code"]}' AND hook = '{$en_data["hook"]}' ");
if ( $t_data->num_rows ) $type = "update";
else $type = "insert";

require_once( app_core_root . "/third/google_translate/autoload.php" );

use Stichoza\GoogleTranslate\GoogleTranslate;
$gt = new GoogleTranslate();
$gt->setSource('en');
$gt->setTarget( $this->ps["code"] );

$translate = $gt->translate( $en_data["text"] );

if ( $type == "insert" ){
	$loader->db->_insert([
	    "table" => "_langs",
	    "set"   => [
		    [ "lang", $this->ps["code"] ],
		    [ "hook", $en_data["hook"] ],
		    [ "text", $translate ]
	    ]
    ]);
}
else {
	$loader->db->_update([
	    "table" => "_langs",
	    "set"   => [
		    [ "text", $translate ]
	    ],
		"where" => [
			[ "lang", "=", $this->ps["code"] ],
			[ "hook", "=", $en_data["hook"] ]
		]
    ]);
}

$this->set_response( "Translated <i>{$en_data["text"]}</i> to <i>{$translate}</i>", false, false, true );

?>
