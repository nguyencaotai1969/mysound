<?php

if ( !defined( "root" ) ) die;

$get_page = $loader->db->query("SELECT * FROM _setting_page WHERE ID = '{$loader->ui->page_hook}' ");
if ( !$get_page->num_rows ) return;
$page = $get_page->fetch_assoc();

$get_page_widgets = $loader->ui->load_page( $loader->ui->page_hook );
if ( empty( $get_page_widgets ) ) return;
$widgets = $get_page_widgets;

$widget_ID = null;
$widget_page = null;
if ( ( $requested_widget_ID = $loader->secure->get( "get", "w", "int" ) ) ){
	if ( in_array( $requested_widget_ID, array_keys( $widgets ) ) ){
		$widget_ID = $requested_widget_ID;
		$widget_page = $loader->secure->get( "get", "p", "int", [ "min" => 1 ], 1 );
	}
}

$this->page_data = array(
	"data" => $page,
	"widgets" => $widgets,
	"widget_ID" => $widget_ID,
	"widget_page" => $widget_page
);

$loader->html->set_title( $loader->lorem->turn( "p_{$page["name"]}_title" ) )
	->set_description( $loader->lorem->turn( "p_{$page["name"]}_desc") );

?>
