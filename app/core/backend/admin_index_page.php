<?php

if ( !defined( "root" ) ) die;

$page_data = $this->loader->ui->set_page_data();

if ( !in_array( $this->ps["ID"], array_keys( $page_data["_pages"] ) ) )
$this->set_error("invalid_ID",true);

if ( $page_data["_pages"][$this->ps["ID"]]["landing"] )
$this->set_error("invalid_ID",true);

$this->loader->admin->save_setting( "landing_page", $this->ps["ID"] );

$this->set_response( "done" );

?>
