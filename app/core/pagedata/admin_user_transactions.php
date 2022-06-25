<?php

if ( !defined( "root" ) ) die;

$limit = $loader->secure->get( "get", "l", "int", [ "min" => 1, "max" => 1000 ], 20 );
$page  = $loader->secure->get( "get", "p", "int", [ "min" => 1, "max" => 1000 ], 1 );
$completed = $loader->secure->get( "get", "completed", "in_array", [ "values" => [ "yes", "no" ] ], "all" );
$search_query = $loader->secure->get( "get", "_sq", "string" );

$_sa["_sq"]       = $search_query;
$_sa["completed"] = $completed;

$select_args = array(

  "page"      => $page,
	"limit"     => $limit,
	"offset"    => ($page-1)*$limit,
	"order_by"  => "ID",
	"singular"  => false,

	"completed" => $_sa["completed"] == "all" ? null : ( $_sa["completed"] == "yes" ),

	"_sq"       => $_sa["_sq"],
	"_eg"       => [ "target", "user" ]

);

$select_more_args = array_merge( $select_args, array(
	"limit"  => 1,
	"offset" => $page*$limit
));

$this->set_page_data([

	"completed" => $_sa["completed"],
	"_sq"       => $_sa["_sq"],

	"items"  => $loader->pay->select( $select_args ),
	"more"   => !empty( $loader->pay->select( $select_more_args ) ),
	"limit"  => $limit,
	"reqs"   => array_merge( [ "p" => $page, "l" => $limit ], $_sa ),
	"reqs_F" => array_merge( [ "l" => $limit ], $_sa ),
	"page"   => $page,

]);

$loader->html->set_title( "User Transactions" );

?>
