<?php

if ( !defined( "root" ) ) die;

$loader->db->query("UPDATE _m_albums SET views = views + 1 WHERE ID = {$loader->ui->page_hook} ");
$album_data = $loader->album->select(["ID"=>$loader->ui->page_hook,"_eg"=>["liked"]]);

if (
	$loader->admin->get_setting( "spotify_d_a_ts", 1 ) &&
	empty( $album_data["spotify_completed"] ) &&
	empty( $album_data["time_spotify_check"] ) &&
	( !$album_data["local"] || $loader->admin->get_setting( "spotify_d_la_ts", 0 ) )
){
	$loader->bot->complete_album( $album_data );
	$loader->db->query("UPDATE _m_albums SET time_spotify_check = now() WHERE ID = '{$album_data["ID"]}' ");
	$album_data = $loader->album->select(["ID"=>$loader->ui->page_hook,"_eg"=>["liked"]]);
}

$album_data["cover"]         = $loader->general->path_to_addr( $album_data["cover"] );
$album_data["artist"]        = $loader->artist->select(["ID"=>$album_data["artist_id"]]);
$album_data["tracks"]        = $loader->track->select(["album_id"=>$album_data["ID"],"singular"=>false,"limit"=>100,"order_by" => "album_order","order" => "ASC", "_eg" => ["liked", "reposted", "paid", "download_able", "artists_featured" ] ] );
$album_data["genre"]         = $loader->genre->select( [ "ID" => $album_data["genre_id"] ] );
$album_data["is_paid"]          = $loader->album->is_paid( $album_data );
$album_data["is_download_able"] = $loader->album->is_download_able( $album_data );
$album_data["uploader"]      = $album_data["user_id"] ? $loader->user->set( $album_data["user_id"] )->get_data(["group_data"]) : null;

if ( !empty( $album_data["tracks"] ) ){

	$popularity_source = $loader->admin->get_setting( "popularity_source", "play_full", [ "play_full", "spotify_hits" ] );
	$most_popular = 0;
	foreach( $album_data["tracks"] as $_track ){
		if ( $_track[$popularity_source] > $most_popular && $_track[$popularity_source] ) $most_popular = $_track[$popularity_source];
		$album_data["tracks_hashes"][] = $_track["hash"];
	}
	foreach( $album_data["tracks"] as &$_track ){
		$_track["popularity"] = !$most_popular ? 0 : round( $_track[$popularity_source] / $most_popular * 100 );
		$_track["popularity"] = $_track["popularity"] < 5 ? 5 : $_track["popularity"];
	}
	unset( $_track );

}

if ( $album_data["type"] == "single" && $loader->admin->get_setting("redirect_single_album",1,[0,1]) && ( $album_data["tracks_count"] == 1 || empty( $album_data["tracks_count"] ) ) ){

	$track = reset( $album_data["tracks"] );
	$track_url = $loader->ui->rurl( "track", $track["url"] );
	header( "Location: {$track_url}", true, 301 );
	die;
	exit;

}

$loader->ui->page_data = $album_data;

$loader->html
	->set_title( "{$album_data["artist"]["name"]} - {$album_data["title"]}" )
	->set_description( "{$album_data["artist"]["name"]} - {$album_data["title"]}" )
	->set_og( "image", $album_data["cover_addr"] )
	->set_twitter( "image", $album_data["cover_addr"] )

?>
