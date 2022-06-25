<?php

if ( !defined( "root" ) ) die;

if ( !$this->loader->user->ID &&
	 !$this->loader->admin->get_setting( "guest_muse", 1, [ 0,1 ] )
) $this->set_error("invalid_request_3");

if ( $this->ps["pl"] )
$_SESSION["ad_time"] = time();

$que = $loader->playlist->get_que( true );

// Anything qued?
if ( empty( $que ) ) $this->set_error( "no_qued_song", true );

// Advertisement time?
if ( !$this->ps["pl"] && $loader->ads->shouldPlay() ){

	$ad_data = $loader->ads->getPlay();
	$this->set_response( array(
		"pl"     => true,
		"id"     => $ad_data["order_no"],
		"audio"  => $ad_data["files_urls"]["audio"],
		"audio_duration" => $ad_data["files"]["audio_duration"],
		"audio_duration_hr" =>$loader->general->hr_seconds( $ad_data["files"]["audio_duration"] ),
		"banner" => $ad_data["files_urls"]["banner"],
		"url"    => $ad_data["url"],
	), false, false, true );

}

// Get data for first qued track
$first_que  = reset( $que );
$track_data = $loader->track->select( [ "hash" => $first_que[0] ] );
$track_data["source"] = $source = $loader->source->select([
	"prefer_localfile" => $loader->admin->get_setting( "prefer_localfile", 1 ),
	"prefer_hq"        => $loader->visitor->user()->has_access( "group", "hq_audio" ),
	"track_id"         => $track_data["ID"],
]);
$track_data["artist"] = $loader->artist->select(["ID"=>$track_data["artist_id"]]);
$track_data["paid"]   = $loader->track->is_paid( $track_data );

// Get youtube-source for this track if it has no source and admin allows it
if ( empty( $track_data["source"] ) && $loader->admin->get_setting( "youtube_d_t", 1 ) ){

	$search_yt_for_track = $loader->youtube->find_track_full( $track_data["artist_name"], $track_data["title"] );
	if ( $search_yt_for_track[0] ? !empty( $search_yt_for_track[1]["ID"] ) : false ){

		$loader->source->create([
			"type"     => "youtube",
			"track_id" => $track_data["ID"],
			"yt_id"    => $search_yt_for_track[1]["ID"],
			"duration" => $search_yt_for_track[1]["duration"]
		]);

		$loader->track->mark_source( $track_data["ID"] );

	}

	$track_data["source"] = $loader->source->select(["track_id"=>$track_data["ID"]]);

}

// Download youtube-source for this track if source-type is youtube, youtube-dl and ffmpeg are installed and admin allows it
if (
	$loader->admin->get_setting( "prefer_localfile", 1 ) &&
  ( !empty( $track_data["source"] ) ? $track_data["source"]["type"] == "youtube" : false ) &&
  $loader->admin->get_setting( "youtube_dl", 0, [0,1] ) &&
  $loader->admin->get_setting( "ffmpeg", 0, [0,1] )
){

	$_uid = uniqid();
	$get_file = $loader->bot->localize_video( $track_data, $track_data["source"]["data"] );
	if ( $get_file[0] ){
		$track_data["source"] = $loader->source->select( [ "track_id" => $track_data["ID"] ] );
		$force_refresh = true;
	}
	elseif ( $loader->visitor->user()->ID == 1 ) {
		$this->set_error( "youtube_dl failed" . ( !empty( $get_file[1] ) ? ": {$get_file[1]}" : "" ) );
	}

	var_dump( $get_file );
	die( $_uid );

}

// Update pre track data
if ( !empty( $_SESSION["play_pre"] ) ){

	$previous_track = $loader->track->select( [ "hash" => $_SESSION["play_pre"] ] );
	if ( !empty( $previous_track ) ){

		$type = !$this->ps["second"] ? "skip" : ( $this->ps["second"] / $previous_track["duration"] * 100 >= $loader->admin->get_setting( "heard_ratio" ) ? "full" : "skip" );
		$ms   = $loader->general->month_string;

		$this->db->query("UPDATE _m_tracks SET play_m  = {$ms}, play_skip_m = 0, play_full_m = 0 WHERE ( play_m IS NULL OR play_m != {$ms} ) AND ID = {$previous_track["ID"]} ");
		$this->db->query("UPDATE _m_albums SET play_m  = {$ms}, play_skip_m = 0, play_full_m = 0 WHERE ( play_m IS NULL OR play_m != {$ms} ) AND ID = {$previous_track["album_id"]} ");
		$this->db->query("UPDATE _m_artists SET play_m = {$ms}, play_skip_m = 0, play_full_m = 0 WHERE ( play_m IS NULL OR play_m != {$ms} ) AND ID = {$previous_track["artist_id"]} ");

		$this->db->query("UPDATE _m_tracks SET play_{$type}  = play_{$type}+1, play_{$type}_m = play_{$type}_m+1, time_play = now() WHERE ID={$previous_track["ID"]} ");
	    $this->db->query("UPDATE _m_albums SET play_{$type}  = play_{$type}+1, play_{$type}_m = play_{$type}_m+1, time_play = now() WHERE ID={$previous_track["album_id"]} ");
	    $this->db->query("UPDATE _m_artists SET play_{$type} = play_{$type}+1, play_{$type}_m = play_{$type}_m+1, time_play = now() WHERE ID={$previous_track["artist_id"]} ");

		if ( $type == "full" && $loader->visitor->user()->ID ){

			$this->db->_insert([
				"table" => "_user_heard",
				"set" => [
					[ "user_id", $loader->visitor->user()->ID ],
					[ "track_id", $previous_track["ID"] ]
				]
			]);

		}

	}

}

// Set session data
$_SESSION["play_source_hash"]  = $track_data["source"]["hash"];
$_SESSION["play_source_file"]  = $track_data["source"]["data"];
$_SESSION["play_track_key"]    = md5( uniqid() );
$_SESSION["play_track_name"]   = $track_data["code"];
$_SESSION["play_track_hash"]   = $track_data["hash"];
$_SESSION["play_track_expire"] = time() + (5*60*60);
$_SESSION["play_track_paid"]   = $track_data["paid"];

// Return data for player
$track_data_simplified = array(

	"title"       => $track_data["title"],
	"cover"       => $track_data["cover_addr"],
	"url"         => $loader->ui->rurl( "track", $track_data["url"] ),
	"hash"        => $track_data["hash"],
	"key"         => $_SESSION["play_track_key"],
	"album_title" => $track_data["album_title"],
	"album_url"   => $loader->ui->rurl( "album", $track_data["album_url"] ),
	"artist_name" => $track_data["artist_name"],
	"artist_url"  => $loader->ui->rurl( "artist", $track_data["artist_url"] ),
  "artist_image" => $track_data["artist"]["image"],
	"source_hash" => $track_data["source"]["hash"],
	"source_type" => $track_data["source"]["type"],
	"source_data" => $track_data["source"]["type"] == "youtube" ? $track_data["source"]["data"] : null,
	"duration"    => $track_data["source"]["duration"],
	"duration_fr" => round( $track_data["source"]["duration"] * ( $track_data["paid"] ? 1 : 1 ) ),
	"duration_hr" => $loader->general->hr_seconds( $track_data["source"]["duration"] ),
	"liked"       => $loader->track->is_liked( $track_data["ID"] ),
	"paid"        => $track_data["paid"],
	"from"        => $first_que[1],
	"volume"      => isset( $_SESSION["play_volume"] ) ? $_SESSION["play_volume"] : 100,
	"repeat"      => !isset( $_SESSION["play_repeat"] ) ? true : $_SESSION["play_repeat"],
	"force_refresh" => !empty( $force_refresh ) ? 1 : 0

);

if ( !empty( $source["type"] ) ? $source["type"] == "file_r" : false ){
	$track_data_simplified["stream_url"] = $loader->general->path_to_addr( $source["data"] );
}

$this->set_response( $track_data_simplified, false, false, true );

?>
