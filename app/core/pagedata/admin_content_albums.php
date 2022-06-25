<?php

if ( !defined( "root" ) ) die;

$limit = $loader->secure->get( "get", "l", "int", [ "min" => 1, "max" => 1000 ], 20 );
$page  = $loader->secure->get( "get", "p", "int", [ "min" => 1, "max" => 1000 ], 1 );
$search_query = $loader->secure->get( "get", "_sq", "string" );
$price = $loader->secure->get( "get", "price", "in_array", [ "values" => [ "pre", "free", "all" ] ], "all" );
$type = $loader->secure->get( "get", "type", "in_array", [ "values" => $loader->album->types ] );

if ( $genre = $loader->secure->get( "get", "genre", "string" ) ){
	if ( !empty( $__genre = $loader->genre->select( [ "code" => $genre ] ) ) )
		$genre = $__genre["code"];
	else 
		$genre = null;
}

if ( $artist_id = $loader->secure->get( "get", "artist_id", "int" ) ){
	if ( empty( $loader->artist->select( [ "ID" => $artist_id ] ) ) )
		$artist_id = null;
}

if ( $user_id = $loader->secure->get( "get", "user_id", "int" ) ){
	if ( empty( $loader->user->select( [ "ID" => $user_id ] ) ) )
		$user_id = null;
}

$_sa["_sq"]       = $search_query;
$_sa["type"]      = $type;
$_sa["genre"]     = $genre;
$_sa["price"]     = $price;
$_sa["artist_id"] = $artist_id;
$_sa["user_id"]   = $user_id;

$select_args = array(
	
    "page"      => $page,
	"limit"     => $limit,
	"offset"    => ($page-1)*$limit,
	"order_by"  => "ID",

	"_eg"       => [ "text_data", "artists_featured_names" ],
	
	"_sq"       => $_sa["_sq"],
	"type"      => $_sa["type"]  == null  ? null : $_sa["type"],
	"genre"     => $_sa["genre"] == null  ? null : $_sa["genre"],
	"priced"    => $_sa["price"] == "all" ? null : ( $_sa["price"] == "pre" ),
	"artist_id" => $_sa["artist_id"],
	"user_id"   => $_sa["user_id"],
	
);

$select_more_args = array_merge( $select_args, array(
	"limit"  => 1,
	"offset" => $page*$limit
));

$this->set_page_data([
	
	"type"      => $_sa["type"],
	"user_id"   => $_sa["user_id"],
	"artist_id" => $_sa["artist_id"],
	"price"     => $_sa["price"],
	"genre"     => $_sa["genre"],
	"_sq"       => $_sa["_sq"],
	
	"genres"  => $loader->genre->get_all_simplfied(),
	
	"items"  => $loader->album->select( $select_args ),
	"more"   => !empty( $loader->album->select( $select_more_args ) ),
	"limit"  => $limit,
	"reqs"   => array_merge( [ "p" => $page, "l" => $limit ], $_sa ),
	"reqs_F" => array_merge( [ "l" => $limit ], $_sa ),
	"page"   => $page,
	
]);

$loader->html->set_title( "Manage Albums" );

?>