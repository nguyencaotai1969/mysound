<?php

if ( !defined( "root" ) ) die;

$limit = $loader->secure->get( "get", "l", "int", [ "min" => 1, "max" => 1000 ], 20 );
$page  = $loader->secure->get( "get", "p", "int", [ "min" => 1, "max" => 1000 ], 1 );
$search_query = $loader->secure->get( "get", "_sq", "string" );
$user_id = $loader->secure->get( "get", "user_id", "int", [ "min" => 1 ] );
$target_type = $loader->secure->get( "get", "target_type", "in_array", [ "values" => [ "track" ] ] );
$target_id = $loader->secure->get( "get", "target_id", "int", [ "min" => 1 ] );
$approved = $loader->secure->get( "get", "approved", "in_array", [ "values" => [ "yes", "no" ] ], "all" );

$select_args = array(
	"page"        => $page,
	"limit"       => $limit,
	"offset"      => ($page-1)*$limit,
	"approved"    => $approved == "yes" ? true : ( $approved == "no" ? false : null ),
	"target_id"   => $target_id,
	"target_type" => $target_type,
	"user_id"     => $user_id,
	"order_by"    => "ID",
	"_sq"         => $search_query,
	"_eg"         => [ "track" ]
);

$select_more_args = array_merge( $select_args, array(
	"limit"  => 1,
	"offset" => $page*$limit
));

$this->set_page_data([
	
	"_sq"         => $search_query,
	"user_id"     => $user_id,
	"target_type" => $target_type,
	"target_id"   => $target_id,
	"approved"    => $approved,
	"items"       => $loader->comment->select( $select_args ),
	"more"        => !empty( $loader->comment->select( $select_more_args ) ),

	"limit"  => $limit,
	"reqs"   => "target_id={$target_id}&target_type={$target_type}&user_id={$user_id}&approved={$approved}&sq={$search_query}&l={$limit}",
	"reqs_F" => "target_id={$target_id}&target_type={$target_type}&user_id={$user_id}&approved={$approved}&sq={$search_query}&l={$limit}&p={$page}",
	"page"   => $page,
	
]);

$loader->html->set_title( "Manage Comments" );

?>