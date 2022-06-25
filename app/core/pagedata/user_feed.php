<?php

if ( !defined( "root" ) ) die;

$page = $loader->secure->get( "get", "p", "int", [ "min" => 2 ], 1 );
$req_user_id   = $loader->visitor->user()->ID;
$req_user_data = $loader->visitor->user()->get_data(["group_data","event_setting"]);
$followings    = $loader->visitor->user()->get_logs( "6" );
$owner = true;

$this->page_data = [
	"owner"           => $owner,
	"links"           => $loader->visitor->user()->get_sidebar_links(),
	"user_data"       => $req_user_data,
	"user_group_data" => $loader->visitor->user()->get_group_data( $req_user_data["GID"] ),
	"user_feed"       => $followings ? $loader->visitor->user()->get_acts( [
	    "user_id"   => $followings,
			"user_id_2" => false,
			"acts_ids"  => $req_user_data["event_allowed"]["feed"],
	    "page"      => $page
    ] ) : false,
];

if ( empty( $this->page_data["user_feed"] ) && $page > 1 ) $loader->html->set_http_header( "status", "HTTP/1.0 404 Not Found" );

$loader->ui->set_title();

?>
