<?php

if ( !defined( "root" ) ) die;

$limit = $loader->secure->get( "get", "l", "int", [ "min" => 1, "max" => 1000 ], 20 );
$page  = $loader->secure->get( "get", "p", "int", [ "min" => 1, "max" => 1000 ], 1 );
$paid  = $loader->secure->get( "get", "paid", "in_array", [ "values" => [ "yes", "no" ] ] );

$_sa["paid"] = $paid;

$select_args = array(
	
	"page"      => $page,
	"limit"     => $limit,
	"offset"    => ($page-1)*$limit,
	"order_by"  => "ID",
	
	"paid"      => $_sa["paid"] == "yes" ? true : ( $_sa["paid"] == "no" ? false : null ),
	"withdrawing" => true,
	"_eg"         => [ "user" ],

);

$select_more_args = array_merge( $select_args, array(
	"limit"  => 1,
	"offset" => $page*$limit
));

$this->set_page_data([
	
	"paid"   => $_sa["paid"],
	
	"items"  => $loader->pay->select( $select_args ),
	"more"   => !empty( $loader->pay->select( $select_more_args ) ),
	"limit"  => $limit,
	"reqs"   => array_merge( [ "p" => $page, "l" => $limit ], $_sa ),
	"reqs_F" => array_merge( [ "l" => $limit ], $_sa ),
	"page"   => $page,
	
]);

$loader->html->set_title( "Artist Withdrawal Requests" );

?>