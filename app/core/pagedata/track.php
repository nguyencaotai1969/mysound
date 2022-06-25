<?php

if ( !defined( "root" ) ) die;

$loader->db->query("UPDATE _m_tracks SET views = views + 1 WHERE ID = {$loader->ui->page_hook} ");

$track_data = $loader->track->select([
	"ID"  => $loader->ui->page_hook,
	"_eg" => [ "liked", "commented", "reposted", "playlisted", "paid", "download_able", "text_data" ]
]);

$track_data["cover"]         = $loader->general->path_to_addr( $track_data["cover"] );
$track_data["album"]         = $loader->album->select(["ID"=>$track_data["album_id"]]);
$track_data["artist"]        = $loader->artist->select(["ID"=>$track_data["artist_id"]]);
$track_data["source"]        = $loader->source->select([
	"track_id"  => $track_data["ID"],
	"prefer_hq" => $loader->visitor->user()->has_access( "group", "hq_audio" ),
]);
$track_data["other_artists"] = $loader->artist->select_others(["ids"=>$track_data["artists_featured"]]);
$track_data["genre"]         = $loader->genre->select( [ "ID" => $track_data["genre_id"] ] );
$track_data["user_comments"] = $loader->track->get_comments( $track_data["ID"], true );
$track_data["user_comments_time"] = null;
$track_data["text_data"]     = $loader->track->select_data( $track_data["ID"] );
$track_data["uploader"]      = $track_data["user_id"] ? $loader->user->set( $track_data["user_id"] )->get_data(["group_data"]) : null;
$track_data["likers"]        = $loader->user->get_users_by_log( 1, $track_data["ID"], 15 );
$track_data["reposters"]     = $loader->user->get_users_by_log( 2, $track_data["ID"], 15 );
$track_data["playlists"]     = $loader->playlist->select( [ "track_id" => $track_data["ID"], "singular" => false, "limit" => 15 ] );

$loader->bot->complete_artist_most_popular( $track_data["artist"] );

$track_data["related"]       = $loader->track->select( [
	"where"     => [
		[ "ID", "!=", $track_data["ID"] ],
		[
			"oper" => "OR",
			"cond" => [
				[ "artist_id", "=", $track_data["artist_id"] ],
				[ "ID", "IN", "SELECT ID2 FROM _m_relations WHERE ID1 = '{$track_data["artist_id"]}' AND type = 'featured'", true ],
			]
		],
	],
	"singular"  => false,
	"limit"     => 10,
	"order_by"  => "time_play"
] );

if ( !empty( $track_data["user_comments"] ) ){

	foreach( $track_data["user_comments"] as $comment ){
		$comment["pos"] = $comment["target_seek"] ? round( round( $comment["target_seek"] / 3 ) / ( $track_data["duration"] / 3 )  * 100 ) : 0;
		$track_data["user_comments_time"][ $comment["target_seek"] ] = $comment;
	}
	ksort( $track_data["user_comments_time"] );

}

$loader->ui->page_data = $track_data;

$loader->html
	->set_title( "{$track_data["artist"]["name"]} - {$track_data["title"]}" )
	->set_description( "{$track_data["artist"]["name"]} - {$track_data["title"]}" )
	->set_og( "image", $track_data["cover_addr"] )
	->set_twitter( "image", $track_data["cover_addr"] )

?>
