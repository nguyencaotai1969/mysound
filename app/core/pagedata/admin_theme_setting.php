<?php

if ( !defined( "root" ) ) die;

$menus = $loader->ui->load_menus( false );
$this->set_page_data( $menus );
$loader->html->set_title( "Theme Setting" );

?>