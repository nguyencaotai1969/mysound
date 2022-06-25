<?php

if ( !defined( "root" ) ) die;

$limit = 1000;
$page  = 1;

if ( $track_id = $loader->secure->get( "get", "track_id", "int" ) ){
	if ( empty( $track_data = $loader->track->select( [ "ID" => $track_id ] ) ) )
		$track_id = null;
}

if ( empty( $track_id ) ) die;

$select_args = array(
	"limit"    => $limit,
	"track_id" => $track_id
);

$this->set_page_data([

	"more"    => false,
	"sources" => $loader->source->select( $select_args ),

	"limit"  => $limit,
	"reqs"   => "l={$limit}",
	"reqs_F" => "l={$limit}&p={$page}",
	"page"   => $page,

	"track_id" => $track_id

]);

$loader->html->set_title( "Managing `{$track_data["artist_name"]} - {$track_data["title"]}` Sources" );

?>
