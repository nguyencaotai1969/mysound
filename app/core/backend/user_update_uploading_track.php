<?php

if ( !defined( "root" ) ) die;

// validate genre ( against database )
if ( !$loader->genre->valid( $this->ps["genre"] ) )
	$this->set_error( 'invalid_genre' );

// get uploading data
$uploadings = $loader->ui->set_page_data();
if ( empty( $uploadings["uploadings"][ $this->ps["rID"] ] ) ) $this->set_error( "invalid_rID", true );
$uploading = $uploadings["uploadings"][ $this->ps["rID"] ];
$_nd = $uploading["data"];

if ( $loader->admin->get_setting( 'spotify_upload_e', 1, [ 0, 1 ] ) )
	$_nd["spotify_ID"]    = $this->ps["spotifyID"];

$_nd["title"]             = $this->ps["title"];
$_nd["genre"]             = $this->loader->genre->return_valid( $this->ps["genre"], "code" );
$_nd["artists_featured"]  = !empty( $this->ps["artists_featured"] ) ? explode( ";", $this->ps["artists_featured"] ) : null;
$_nd["artist_name"]       = $this->ps["artist_name"];
$_nd["comment"]           = $this->ps["comment"] ? str_replace( [ "\r\n", "\n", PHP_EOL ], "<BR>", $this->ps["comment"] ): null;
$_nd["lyrics"]            = $this->ps["lyrics"] ? $this->ps["lyrics"] : null;
$_nd["album_order"]       = $this->ps["album_order"] ? $this->ps["album_order"] : null;
$_nd["album_type"]        = $this->ps["album_type"];
$_nd["album_title"]       = $this->ps["album_title"];
$_nd["album_artist_name"] = $this->ps["album_artist_name"];
$_nd["price"]             = $this->ps["price"] && $loader->visitor->user()->has_access( "group", "sell" )  ? ( in_array( $this->ps["price"], explode( ",", $loader->admin->get_setting( "sell_music_prices" ) ) ) ? $this->ps["price"] : null ) : null;

if ( $_nd["album_type"] == "single" ){
	
	$_nd["album_title"]             = $_nd["title"];
	$_nd["album_artist_name"]       = $_nd["artist_name"];
	$_nd["album_order"]             = null;
	$_nd["spotify_album_artist_ID"] = !empty( $_nd["spotify_artist_ID"] ) ? $_nd["spotify_artist_ID"] : null;
	
}
else if ( $_nd["album_type"] == "compilation" ){
	
	$_nd["album_artist_name"]      = "various artists";
	$_nd["spotify_album_artist_ID"] = null;
	
}

$_nde = $loader->general->json_encode( $_nd );

$this->db->_update([
	"table" => "_user_uploads",
	"set" => [
		[ "finalData", $_nde ],
	],
	"where" => [
		[ "uploadID", "=", $uploading["uploadID"] ],
		[ "rID", "=", $uploading["rID"] ]
	]
]);

$this->set_response( "done" );

?>