<?php

if ( !defined( "root" ) ) die;

$page_data = $this->loader->ui->set_page_data();

if ( !in_array( $this->ps["ID"], array_keys( $page_data["_pages"] ) ) )
$this->set_error("invalid_ID",true);

if ( $page_data["_pages"][$this->ps["ID"]]["landing"] )
$this->set_error("Index page can't be deleted");

$this->db->query("DELETE FROM _setting_page WHERE ID = {$this->ps["ID"]}");
$this->db->query("DELETE FROM _setting_page_widgets WHERE page_id = {$this->ps["ID"]}");
$this->db->query("OPTIMIZE TABLE _setting_page");
$this->db->query("OPTIMIZE TABLE _setting_page_widgets");

$this->set_response( "removed" );

?>
