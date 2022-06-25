<?php

if ( !defined( "root" ) ) die;

if ( !$this->loader->user->ID &&
	 !$this->loader->admin->get_setting( "guest_muse", 1, [ 0,1 ] )
) $this->set_error("invalid_request_3");

if ( !$this->ps["start_radio"] && !empty( $_SESSION["play_radio_seeds"] ) ){
	$_SESSION["play_que"] = null;
}

$loader->playlist->mark_pre_que();
$type = $this->ps["type"];
$hash = $this->ps["hash"];

// Check hook
if ( $type == "artist" ){

	$hash = $loader->general->make_code( $this->ps["hash"] );
	$key = "code";

}
elseif ( $type == "widget" ){

	if ( !$loader->secure->validate( $hash, "int" ) )
		$this->set_error("invalid_request_3",true);

	$key = "ID";

}
else {

	if ( !$loader->secure->validate( $hash, "md5" ) )
		$this->set_error("invalid_request_3",true);

	$key = "hash";

}

if ( ( $type != "track" && $this->ps["que_to_top"] ) || $this->ps["start_radio"] ){
	$loader->playlist->reset_que();
	$loader->playlist->clear_radio();
}
if ( $type == "track" ){
	$loader->playlist->remove_from_radio( $hash );
}

// Get item
if ( $type == "widget" ){

	$get_widget = $loader->db->_select([
		"table" => "_setting_page_widgets",
		"where" => [
			[ "ID", "=", $hash ]
		]
	]);

	if ( empty( $get_widget ) ? true : empty( $get_widget[0]["ID"] ) or ( substr( $get_widget[0]["widget_type"], 0, 6 ) != "track_" && $get_widget[0]["widget_type"] != "spotify" ) )
		$this->set_error( "invalid_hook", true );

	$item = array(
		"ID"          => $get_widget[0]["ID"],
		"title"       => $get_widget[0]["widget_title"],
		"type"        => $get_widget[0]["widget_type"],
		"sett"        => json_decode( $get_widget[0]["widget_setting"], 1 ),
		"cache"       => $get_widget[0]["widget_cache"] ? json_decode( $get_widget[0]["widget_cache"], 1 ) : null,
		"time_update" => $get_widget[0]["time_update"],
	);

	$item["sett"]["limit"] = 40;

}
else {

	$item = $loader->$type->select([$key=>$hash,"_eg"=>["artists_featured"]]);
    if ( empty( $item ) ) $this->set_error( "invalid_hook", true );

}


// Get tracks
$tracks = [];
if ( $type == "track" ){

	$tracks[] = $item;

}
elseif ( $type == "album" ){

	$album_tracks = $loader->track->select(["album_id"=>$item["ID"],"singular"=>false,"limit"=>100,"order_by"=>"album_order","_eg"=>["artists_featured"]]);
	if ( empty( $album_tracks ) ) $this->set_error( "invalid_hook", true );

	// Reset que
	foreach( $album_tracks as $__t ){
		$album_tracks_hashes[] = is_array( $__t ) ? $__t["hash"] : $__t;
	}
	$this->loader->playlist->reset_que( !empty( $album_tracks_hashes ) ? $album_tracks_hashes : null );

	$tracks = $album_tracks;

}
elseif ( $type == "artist" ){

	$artist_tracks = $loader->track->select(["artist_id"=>$item["ID"],"singular"=>false,"limit"=>10,"order_by"=>" ","order"=>"spotify_hits DESC, play_full DESC","_eg"=>["artists_featured"]]);
	if ( empty( $artist_tracks ) ) $this->set_error( "invalid_hook", true );

	// Reset que
	foreach( $artist_tracks as $__t ){
		$artist_tracks_hashes[] = is_array( $__t ) ? $__t["hash"] : $__t;
	}
	$this->loader->playlist->reset_que( !empty( $artist_tracks_hashes ) ? $artist_tracks_hashes : null );

	$tracks = array_reverse( $artist_tracks );

}
elseif ( $type == "widget" ){

	$page_data = $loader->ui->set_page_data();
	$widget_page = !empty( $page_data["widget_page"] ) ? $page_data["widget_page"] : 1;
	$widget_tracks = $loader->ui->load_page_widget( $item, false, true, $widget_page );
	if ( empty( $widget_tracks ) ) $this->set_error( "invalid_hook", true );

	foreach( $widget_tracks["items"] as $__t ){
		$widget_tracks_hashes[] = $__t["hash"];
	}
	$this->loader->playlist->reset_que( !empty( $widget_tracks_hashes ) ? $widget_tracks_hashes : null );
	$tracks = array_reverse( $widget_tracks["items"] );

}
elseif ( $type == "playlist" ){

	// Get playlist tracks
	$playlist_tracks = $this->loader->track->select(["playlist_id"=>$item["ID"],"limit"=>200,"_eg"=>["artists_featured"]]);
	if ( empty( $playlist_tracks ) ) $this->set_error("invalid_hook");

	// Reset que
	foreach( $playlist_tracks as $__t ){
		$playlist_tracks_hashes[] = is_array( $__t ) ? $__t["hash"] : $__t;
	}
	$this->loader->playlist->reset_que( !empty( $playlist_tracks_hashes ) ? $playlist_tracks_hashes : null );

	$tracks = array_reverse( $playlist_tracks );

}

if ( empty( $tracks ) )
	$this->set_error("invalid_hook");

// Add tracks to que
if ( $this->ps["start_radio"] && $this->loader->admin->get_setting("station",1) )
	$this->loader->playlist->set_radio_seeds( $type, $tracks, "{$type}_{$item[$key]}" );
else
	$this->loader->playlist->extend_que( $tracks, !$this->ps["que_to_top"] ? true : false, "{$type}_{$item[$key]}" );


$this->set_response( "done" );

?>
