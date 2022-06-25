<?php

if ( !defined( "root" ) ) die;

$page = $loader->secure->get( "get", "p", "int", [ "min" => 2 ], 1 );
$req_user_id   = !empty( $loader->ui->page_hook ) ? $loader->ui->page_hook : $loader->visitor->user()->ID;
$req_user_data = $loader->user->set( $req_user_id )->get_data( ["group_data"] );
$owner = empty( $loader->visitor->user()->ID ) ? false : $loader->visitor->user()->ID == $req_user_id;

$this->page_data = [
	"owner"           => $owner,
	"links"           => $loader->user->set( $req_user_id )->data()->get_sidebar_links(),
	"user_data"       => $req_user_data,
	"user_group_data" => $loader->user->set( $req_user_id )->get_group_data( $req_user_data["GID"] ),
	"user_likes"      => $loader->user->set( $req_user_id )->get_acts( [
	    "user_id"  => $req_user_id,
	    "acts_ids" => [ 1 ],
	    "page"     => $page
    ] )
];

if ( empty( $this->page_data["user_likes"] ) && $page > 1 ) $loader->html->set_http_header( "status", "HTTP/1.0 404 Not Found" );

$loader->ui->set_title( [ "user" => $req_user_data["name_raw"] ] );

?>
