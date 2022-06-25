<?php

if ( !defined( "root" ) ) die;

$limit = $loader->secure->get( "get", "l", "int", [ "min" => 1, "max" => 1000 ], 20 );
$page  = $loader->secure->get( "get", "p", "int", [ "min" => 1, "max" => 1000 ], 1 );
$search_query = $loader->secure->get( "get", "_sq", "string" );
$is_user = $loader->secure->get( "get", "is_user", "in_array", [ "values" => [ "yes", "no" ] ], "all" );

$_sa["_sq"]     = $search_query;
$_sa["is_user"] = $is_user;

$select_args = array(
	
	"page"      => $page,
	"limit"     => $limit,
	"offset"    => ($page-1)*$limit,
	"order_by"  => "ID",
	
	"_sq"       => $_sa["_sq"],
	"is_user"   => $_sa["is_user"] == "all" ? null : ( $_sa["is_user"] == "yes" ),

);

$select_more_args = array_merge( $select_args, array(
	"limit"  => 1,
	"offset" => $page*$limit
));

$this->set_page_data([

	"is_user" => $_sa["is_user"],
	"_sq"     => $_sa["_sq"],
	
	"items"  => $loader->artist->select( $select_args ),
	"more"   => !empty( $loader->artist->select( $select_more_args ) ),
	"limit"  => $limit,
	"reqs"   => array_merge( [ "p" => $page, "l" => $limit ], $_sa ),
	"reqs_F" => array_merge( [ "l" => $limit ], $_sa ),
	"page"   => $page,
	
	
]);

$loader->html->set_title( "Manage Artists" );

?>