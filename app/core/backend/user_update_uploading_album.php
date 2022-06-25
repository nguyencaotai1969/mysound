<?php

if ( !defined( "root" ) ) die;

if ( !$loader->genre->valid( $this->ps["genre"] ) ) $this->set_error( 'invalid_genre' );

$_date = $loader->general->strtotime( $this->ps["time"] );
if ( !$_date ) $this->set_error("invalid_time");
	
// get uploading data
$uploadings = $loader->ui->set_page_data();
if ( empty( $uploadings ) ? true : !in_array( $this->ps["code"], array_keys( $uploadings[ "albums" ] ) ) ) $this->set_error( "invalid_code", true );

$_nd["album_title"]       = $this->ps["title"];
$_nd["album_artist_name"] = $this->ps["artist_name"];
$_nd["album_genre"]       = $this->loader->genre->return_valid( $this->ps["genre"], "code" );
$_nd["album_time"]        = $_date;
$_nd["album_type"]        = $this->ps["type"];
$_nd["album_comment"]     = $this->ps["comment"] ? $this->ps["comment"] : null;
$_nd["spotify_album_ID"]  = $this->ps["spotifyID"] ? $this->ps["spotifyID"] : null;
$_nd["album_price"]       = $this->ps["price"] && $loader->visitor->user()->has_access( "group", "sell" )  ? ( in_array( $this->ps["price"], explode( ",", $loader->admin->get_setting( "sell_music_prices" ) ), true ) ? $this->ps["price"] : null ) : null;

if ( $_nd["album_type"] == "compilation" )
	$_nd["album_artist_name"] = "various artists";

foreach( $uploadings["albums"][ $this->ps["code"] ][ "tracks_full" ] as $__track ){
	
	$__track_raw = json_decode(stripslashes($loader->db->query("SELECT finalData FROM _user_uploads WHERE ID = '{$__track["ID"]}' ")->fetch_assoc()["finalData"]),1);
	
	foreach( $_nd as $__k => $__v ){
		$__track_raw[ $__k ] = $__v;
	}
	
	$__track_raw["genre"] = $_nd["album_genre"];
	
	if ( $_nd["album_type"] != "compilation" )
		$__track_raw["artist_name"] = $_nd["album_artist_name"];
	
	if ( $_nd["album_type"] == "single" && count( $uploadings["albums"][ $this->ps["code"] ][ "tracks_full" ] ) == 1 ){
		$__track_raw["title"]   = $_nd["album_title"];
		$__track_raw["comment"] = $_nd["album_comment"];
	}
		
	
	$__nde = $loader->general->json_encode( $__track_raw );
	
	$stmt = $this->db->prepare("UPDATE _user_uploads SET finalData = ? WHERE ID = ?");
	$stmt->bind_param( "ss", $__nde, $__track["ID"] );
	$stmt->execute();
	$stmt->close();
	
}

$this->set_response( "done" );

?>