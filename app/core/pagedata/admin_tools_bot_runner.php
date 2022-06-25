<?php

if ( !defined( "root" ) ) die;

$loader->html->set_title( "Tools - Manual Bot Runner" );

$loader->ui->set_page_data([
	"widgets" => $loader->bot->update_spotify_widgets( false )
]);

$loader->theme->set_name('__default')->loader->html->add_style( 'botfont', 'https://fonts.googleapis.com/css2?family=Ubuntu+Mono:ital,wght@0,400;0,700;1,400&display=swap', true );

?>