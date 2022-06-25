<?php

if ( !defined( "root" ) ) die;

if ( !$this->loader->user->ID &&
	 !$this->loader->admin->get_setting( "guest_muse", 1, [ 0,1 ] )
) $this->set_error("invalid_request_3");

$que = $loader->playlist->get_que( true );
$radio = $loader->playlist->get_radio_que( true );

if ( empty( $que ) ) $this->set_error( "no_qued_song" );

$que_data = "<div class='que_wrapper'>";
$que_data .= "<div class='que_buttons_wrapper'>";
$que_data .= "<div class='button clear_que_handle'>{$loader->lorem->turn("clear",["uc"=>true])}</div>";
$que_data .= "<div class='button shuffle_que_handle'>{$loader->lorem->turn("shuffle",["uc"=>true])}</div>";
$que_data .= "</div>";
$que_data .= "<div class='que_tracks_wrapper'>";

$tracks = [];
foreach( $que as $track_hash ){

	$track_data = $loader->track->select([
		"hash" => $track_hash[0]
	]);

	if ( empty( $track_data ) ) continue;

	$tracks[] = $track_data;

}

foreach( $tracks as $track_data ){

	$track_to_dom = $loader->theme->set_name('__default')->__req( "parts/que_track.php", true, [ "track" => $track_data ] );
	$que_data .= $track_to_dom;

}

if ( !empty( $radio ) ){
	$que_data .= "<div class='que_radio'>";
	$que_data .= "<div class='que_radio_title'>{$loader->lorem->turn("que_up_next")}</div>";
	foreach( $radio as $track_data ){
		$track_to_dom = $loader->theme->set_name('__default')->__req( "parts/que_track.php", true, [ "track" => $track_data, "radio" => true ] );
		$que_data .= $track_to_dom;
	}
	$que_data .= "</div>";
}


$que_data .= "</div>";
$que_data .= "</div>";

$this->set_response( $que_data, false, false, true );

?>
