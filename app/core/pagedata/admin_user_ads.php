<?php

if ( !defined( "root" ) ) die;

$limit = $loader->secure->get( "get", "l", "int", [ "min" => 1, "max" => 1000 ], 20 );
$page  = $loader->secure->get( "get", "p", "int", [ "min" => 1, "max" => 1000 ], 1 );
$active = $loader->secure->get( "get", "active", "int", [ "min" => -2, "max" => 2 ], null );

$select_args = array(

	"page"      => $page,
	"limit"     => $limit,
	"offset"    => ($page-1)*$limit,
	"order_by"  => "ID",
	"active"    => $active,
	"hide_removed" => $active !== null ? false : true,
	"_eg"       => [ "user" ],
  "reported"  => true

);

$select_more_args = array_merge( $select_args, array(
	"limit"  => 1,
	"offset" => $page*$limit
));

$this->set_page_data([

	"items"  => $loader->ads->select( $select_args ),
	"more"   => !empty( $loader->ads->select( $select_more_args ) ),
	"limit"  => $limit,
	"reqs"   => [ "p" => $page, "l" => $limit, "active" => $active ],
	"reqs_F" => [ "l" => $limit, "active" => $active ],
	"page"   => $page,
	"active" => $active !== null ? $active : "all",

]);

$loader->html->set_title( "User Advertisement" );

?>
