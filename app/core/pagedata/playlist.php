<?php

if ( !defined( "root" ) ) die;

$loader->db->query("UPDATE _user_playlists SET views = views + 1 WHERE ID = {$loader->ui->page_hook} ");

$playlist = $loader->playlist->select(["ID"=>$loader->ui->page_hook,"_eg"=>["tracks","tracks_limit"=>200,"liked","followed","owner","collabs","collabed"]]);
$playlist["is_download_able"] = $loader->playlist->is_download_able( $playlist );
$playlist_owner = $playlist["owner"];

if ( !empty( $playlist["tracks"] ) ){
	foreach( $playlist["tracks"] as $_track ){
		$playlist["tracks_hashes"][] = $_track["hash"];
	}
}

$loader->ui->set_title( [ "playlist" => $playlist["name"], "user" => $playlist_owner["name_raw"] ] );

$this->page_data = [
	"playlist_owner" => $playlist_owner,
	"playlist"       => $playlist
];

?>
