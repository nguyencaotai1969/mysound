<?php

if ( !defined( "root" ) ) die;

$req_user_id   = !empty( $loader->ui->page_hook ) ? $loader->ui->page_hook : $loader->visitor->user()->ID;
$req_user_data = $loader->user->set( $req_user_id )->get_data( ["group_data"] );
$owner = empty( $loader->visitor->user()->ID ) ? false : $loader->visitor->user()->ID == $req_user_id;

$this->page_data = [
	"owner"           => $owner,
	"links"           => $loader->user->set( $req_user_id )->data()->get_sidebar_links(),
	"user_data"       => $req_user_data,
	"user_group_data" => $loader->user->set( $req_user_id )->get_group_data( $req_user_data["GID"] ),
	"user_purchased"  => $loader->pay->get_purchased_songs()
];

$loader->ui->set_title();

?>