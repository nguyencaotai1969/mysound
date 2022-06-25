<?php

if ( !defined( "root" ) ) die;

$items = null;
$_limit = 40;
$_offset = 0;
$_page = 1;

if ( $loader->ui->page_parent == "dynamic" && !empty( $loader->ui->page_hook ) ){

	if ( ( $reqed_page = $loader->secure->get( "get", "p", "int", [ "min" => 1 ], 1 ) ) ){
		$_page   = $reqed_page;
		$_offset = ($_page-1)*$_limit;
	}

	$items = $loader->album->select(["genre"=>$loader->ui->page_hook,"offset"=>$_offset,"limit"=>$_limit,"order_by"=>"time_release"]);
	$has_more = !empty( $loader->album->select(["genre"=>$loader->ui->page_hook,"offset"=>$_offset+1+$_limit,"limit"=>1,"order_by"=>"time_release"]) );

}

if ( empty( $items ) && $_page > 1 ){
	$loader->html->set_http_header( "status", "HTTP/1.0 404 Not Found" );
}


$loader->ui->set_title();

$loader->ui->page_data = array(
	"items"       => $items,
	"has_more"    => !empty( $has_more ),
	"items_limit" => $_limit,
	"page"        => $_page
);

?>
