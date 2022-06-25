<?php

if ( !defined( "root" ) ) die;

$this->loader->ui->set_page_data();
$menus = $this->loader->ui->page_data["menus"];

if ( !in_array( $this->ps["name"], $menus, true ) ) 
	$this->set_error("invalid_name",true);

$stmt = $this->db->prepare("DELETE FROM _setting_menu WHERE name = ?");
$stmt->bind_param( "s", $this->ps["name"] );
$stmt->execute();
$stmt->close();

$this->db->query("OPTIMIZE TABLE _setting_menu");

$this->set_response( "removed" );

?>