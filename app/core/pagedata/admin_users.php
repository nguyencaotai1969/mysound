<?php

if ( !defined( "root" ) ) die;

$groups = $loader->user->group_get_all_simplfied();
$groups[ "notverified" ] = [ null, "Not Verified" ];
unset( $groups["guest"] );

$limit = $loader->secure->get( "get", "l", "int", [ "min" => 1, "max" => 1000 ], 20 );
$page  = $loader->secure->get( "get", "p", "int", [ "min" => 1, "max" => 1000 ], 1 );
$search_query = $loader->secure->get( "get", "_sq", "string" );
$group = $loader->secure->get( "get", "group", "in_array", [ "values" => array_keys( $groups ), "strict" => false ], "all" );

$_sa["group"] = $group;
$_sa["_sq"]   = $search_query;

$select_args = array(

    "page"      => $page,
	"limit"     => $limit,
	"offset"    => ($page-1)*$limit,
	"order_by"  => "ID",

	"_eg"      => [ "group_data" ],

	"_sq"      => $_sa["_sq"],
	"group_id" => $_sa["group"] == "all" ? null : $groups[ $_sa["group"] ][0],
	"verified" => $_sa["group"] == "notverified" ? false : null,

);

$select_more_args = array_merge( $select_args, array(
	"limit"  => 1,
	"offset" => $page*$limit
));

$this->set_page_data([

	"groups" => $groups,
	"group"  => $_sa["group"],
	"_sq"    => $_sa["_sq"],

	"items"  => $loader->user->select( $select_args ),
	"more"   => !empty( $loader->user->select( $select_more_args ) ),
	"limit"  => $limit,
	"reqs"   => array_merge( [ "p" => $page, "l" => $limit ], $_sa ),
	"reqs_F" => array_merge( [ "l" => $limit ], $_sa ),
	"page"   => $page,

]);

$loader->html->set_title( "Manage Users" );

?>
