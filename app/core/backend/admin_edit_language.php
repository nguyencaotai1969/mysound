<?php

if ( !defined( "root" ) ) die;

$loader->ui->set_page_data();
$pagedata = $loader->ui->page_data;

if ( empty( $pagedata["code"] ) || !$loader->secure->get( "get", "code", "string_lang_code" ) )
	$this->set_error( "invalid language code", true );

$hook_exist = $loader->db->query("SELECT 1 FROM _langs WHERE lang = '{$pagedata["r_code"]}' AND hook = '{$this->ps["hook"]}' ")->num_rows ? 1 : 0;

if ( $hook_exist ) $stmt = $this->db->prepare("UPDATE _langs SET text = ? WHERE lang = ? AND hook = ?");
else $stmt = $this->db->prepare("INSERT INTO _langs ( text, lang, hook ) VALUES ( ?, ?, ? )");

$stmt->bind_param( "sss", $this->ps["text"] ,$pagedata["r_code"], $this->ps["hook"] );
$stmt->execute();
if ( !empty( $stmt->error ) ) var_dump( $stmt->error );
$stmt->close();

$this->set_response( "Edited" );

?>