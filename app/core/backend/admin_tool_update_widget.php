<?php

if ( !defined( "root" ) ) die;

$page_data = $loader->ui->set_page_data();

if ( empty( $page_data["widgets"]["outdated"] ) )
	$this->set_error( "invalid_ID", true );

if ( !in_array( $this->ps["ID"], array_keys( $page_data["widgets"]["outdated"] ) ) )
	$this->set_error( "invalid_ID", true );

$widget = $page_data["widgets"]["outdated"][$this->ps["ID"]];

$loader->bot->echo_off();
$loader->bot->reset_logs();
$update_report = $loader->bot->update_spotify_widget( $widget );
$logs = $loader->bot->get_logs();

$this->set_response( $update_report, false, false, true );

?>