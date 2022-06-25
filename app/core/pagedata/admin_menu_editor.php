<?php

if ( !defined( "root" ) ) die;

$requested_page = $loader->secure->get( "get", "name", "string", [ "strict" => true ], false );

$page_data["menus"] = $this->loader->ui->load_menus( false, false );
$page_data["name"]  = $requested_page;

if ( !empty( $page_data["name"] ) ){
	$page_data["items"] = $loader->ui->load_menu( $page_data["name"], true );
}

$page_data["items"] = !empty( $page_data["items"] ) ? $page_data["items"] : array(
	
	array(
	    "title" => "#item_title",
	    "page"  => "page_url",
		"icon"  => "music",
    )

);

$this->set_page_data( $page_data );

$loader->html->set_title( "Menu Builder" );

$loader->theme->set_name('__default')->loader->html->add_java( 'iconlist', 'assets/js/icon_list.js', true );

?>