<?php

if ( !defined( "root" ) ) die;

$req_user_id   = $loader->visitor->user()->ID;
$req_user_data = $loader->user->set( $req_user_id )->get_data( ["group_data"] );
$owner = true;

$setting_parts = array(
	"profile_setting",
	"general_setting",
	"feed_setting",
	"change_password",
	"manage_sessions",
	"transaction_history",
);

$setting_parts_display = array(
	"profile_setting",
	"feed_setting",
	"manage_sessions",
	"transaction_history",
	"advertising",
	"artist_verification",
	"artist_withdrawal"
);

if ( $loader->visitor->user()->has_access( "group", "artist_req" ) && !$req_user_data["artist"] )
	$setting_parts[] = "artist_verification";

if ( $req_user_data["artist"] )
	$setting_parts[] = "artist_withdrawal";

if ( $loader->visitor->user()->has_access( "group", "advertisement" ) )
	$setting_parts[] = "advertising";

$requested_setting_part = $loader->secure->get( "get", "n", "in_array", [ "values" => $setting_parts ], reset( $setting_parts) );
$requested_setting_part_name = $loader->lorem->turn( "us_" . ( $requested_setting_part == "transaction_history" ? "transactions" : ( $requested_setting_part == "artist_verification" ? "verification" : $requested_setting_part ) ) );

$this->page_data = [
	"owner"           => $owner,
	"links"           => $loader->user->set( $req_user_id )->data()->get_sidebar_links(),
	"user_data"       => $req_user_data,
	"user_group_data" => $loader->user->set( $req_user_id )->get_group_data( $req_user_data["GID"] ),
	"setting_parts"   => $setting_parts,
	"setting_parts_display" => $setting_parts_display,
	"setting_part"    => $requested_setting_part,
	"setting_part_name" => $requested_setting_part_name,
	"icons"           => array(
		"general_setting" => "cog",
		"profile_setting" => "account",
		"feed_setting" => "rss",
		"change_password" => "lock",
		"manage_sessions" => "lock-open",
		"transaction_history" => "cash-usd-outline",
		"artist_verification" => "account-music",
		"artist_withdrawal" => "account-music",
		"advertising" => "star"
	),
];

$loader->html->set_title( $requested_setting_part_name );

?>
