<?php

if ( !defined( "root" ) ) die;

$limit = $loader->secure->get( "get", "l", "int", [ "min" => 1, "max" => 1000 ], 20 );
$page  = $loader->secure->get( "get", "p", "int", [ "min" => 1, "max" => 1000 ], 1 );
$search_query = $loader->secure->get( "get", "_sq", "string" );
$status = $loader->secure->get( "get", "status", "in_array", [ "values" => [ 1, 2, "1", "2" ] ], 0 );

$_sa["_sq"]    = $search_query;
$_sa["status"] = $status;

$select_args = array(

	"page"      => $page,
	"limit"     => $limit,
	"offset"    => ($page-1)*$limit,
	"order_by"  => "ID",

	"_sq"      => $_sa["_sq"],
	"deleted"  => $_sa["status"] == 1 ? false : ( $_sa["status"] == 2 ? true : null ),
);

$select_more_args = array_merge( $select_args, array(
	"limit"  => 1,
	"offset" => $page*$limit
));

$this->set_page_data([

	"status" => $_sa["status"],
	"_sq"    => $_sa["_sq"],

	"genres" => $loader->genre->select( $select_args ),
	"more"   => !empty( $loader->genre->select( $select_more_args ) ),
	"limit"  => $limit,
	"reqs"   => array_merge( [ "p" => $page, "l" => $limit ], $_sa ),
	"reqs_F" => array_merge( [ "l" => $limit ], $_sa ),
	"page"   => $page,

]);

$loader->html->set_title( "Manage Genres" );

?>
