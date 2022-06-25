<?php

if ( !defined( "root" ) ) die;

$search_page  = $loader->secure->get( "get", "p", "int", [ "max" => 10, "min" => 1 ], 1 );
$search_type  = $loader->secure->get( "get", "type", "in_array", [ "values" => [ "artists", "albums", "tracks" ] ], "all" );
$search_query = $loader->secure->get( "get", "qn", "string", [ "max_length" => 100, "strip_emoji" => true ], "" );

$search_result = $loader->search->exe( $search_query, $search_type, $search_page );

$loader->ui->set_page_data( array_merge(
	is_array( $search_result ) ? $search_result : [],
    [ "type"  => $search_type ],
	[ "query" => $search_query ],
	[ "page"  => $search_page ]
) );

if ( $search_query )
	$loader->html->set_title( "`{$search_query}`" );
else
	$loader->html->set_title( $loader->lorem->turn( "search") );

?>
