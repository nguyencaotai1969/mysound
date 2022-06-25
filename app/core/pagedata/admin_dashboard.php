<?php

if ( !defined( "root" ) ) die;

// browser
$browsers = [];
$get_browsers = $loader->db->query("SELECT agent_browser,COUNT(*) as c FROM ( SELECT MAX(agent_browser) as agent_browser FROM _hits WHERE time_add > SUBDATE( NOW(), INTERVAL 30 DAY ) AND agent_type != 'bot' GROUP BY ip ) as _x  GROUP BY agent_browser ORDER BY c DESC LIMIT 6");
if ( $get_browsers->num_rows ){
	while( $browser = $get_browsers->fetch_assoc() ){
		$browser["agent_browser"] = $browser["agent_browser"] ? $browser["agent_browser"] : "Unkown";
		$browsers[ "hooks" ][] = $browser["agent_browser"];
		$browsers[ "datas" ][ "counts" ][ $browser["agent_browser"] ] = $browser["c"];
	}
}

// countries
$cns = [];
$get_cns = $loader->db->query("SELECT ip_country,COUNT(*) as c FROM ( SELECT MAX(ip_country) as ip_country FROM _hits WHERE time_add > SUBDATE( NOW(), INTERVAL 30 DAY ) AND agent_type != 'bot' GROUP BY ip ) as _x  GROUP BY ip_country ORDER BY c DESC LIMIT 6");
if ( $get_cns->num_rows ){
	while( $cn = $get_cns->fetch_assoc() ){
		$cn["ip_country"] = $cn["ip_country"] ? $cn["ip_country"] : "unknown";
		$cns[ "hooks" ][] = $cn["ip_country"];
		$cns[ "datas" ][ "counts" ][ $cn["ip_country"] ] = $cn["c"];
	}
}

// hits
$hits = [ "hooks" => [], "datas" => [  ] ];
$get_hits = $loader->db->query("SELECT DATE_FORMAT(`time_add`, '%y %m %d') as ymd,COUNT(*) as c FROM `_hits` WHERE time_add > SUBDATE( now(), INTERVAL 1 WEEK ) GROUP BY ymd");
if ( $get_hits->num_rows ){
	while( $hit = $get_hits->fetch_assoc() ){
		$hits[ "hooks" ][] = $hit["ymd"];
		$hits[ "datas" ][ "hits" ][ $hit["ymd"] ] = $hit["c"];
	}
}

// signup&users
$users = [ "hooks" => [], "datas" => [ "users" => [], "tracks" => [] ] ];
for( $i=7; $i>=0; $i-- ){

	$user_count = $loader->db->query("SELECT 1 FROM _users WHERE DATE_FORMAT( `time_add`, '%y %m %d' ) = DATE_FORMAT( SUBDATE( now(), INTERVAL {$i} DAY ) , '%y %m %d')")->num_rows;
	$track_count = $loader->db->query("SELECT 1 FROM _m_tracks WHERE DATE_FORMAT( `time_add`, '%y %m %d' ) = DATE_FORMAT( SUBDATE( now(), INTERVAL {$i} DAY ) , '%y %m %d')")->num_rows;

	$hook = date( "y m d", strtotime("-{$i} day") );
	$users[ "hooks" ][] = $hook;
	$users[ "datas" ][ "users" ][ $hook ] = $user_count;
	$users[ "datas" ][ "tracks" ][ $hook ] = $track_count;


}

$loader->ui->set_page_data(array(

	"browsers"  => $browsers,
	"countries" => $cns,
	"hits"      => $hits,
	"users"     => $users,

	"count_users" => $loader->db->query("SELECT 1 FROM _users")->num_rows,
	"count_artists" => $loader->db->query("SELECT 1 FROM _m_artists")->num_rows,
	"count_albums" => $loader->db->query("SELECT 1 FROM _m_albums")->num_rows,
	"count_tracks" => $loader->db->query("SELECT 1 FROM _m_tracks")->num_rows,
	"count_sources" => $loader->db->query("SELECT 1 FROM _m_sources")->num_rows,
	"count_playlists" => $loader->db->query("SELECT 1 FROM _user_playlists")->num_rows,

));

$loader->html->set_title( "Dashboard" );

?>
