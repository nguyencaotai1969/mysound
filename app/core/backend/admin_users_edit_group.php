<?php

if ( !defined( "root" ) ) die;

$page_data = $this->loader->ui->set_page_data();

if ( empty( $page_data["group"] ) )
	$this->set_error("Select a group first",true);

$set[] = [ "muse_access"      , $this->ps["muse_access"] ? 1 : 0 ];
$set[] = [ "hq_audio_access"      , $this->ps["hq_audio_access"] ? 1 : 0 ];
$set[] = [ "hide_advertisement_access" , $this->ps["hide_advertisement_access"] ? 1 : 0 ];
$set[] = [ "premium_access"   , $this->ps["premium_access"] ? 1 : 0 ];
$set[] = [ "download_access"  , $this->ps["download_access"] ? 1 : 0 ];
$set[] = [ "language_access"  , $this->ps["language_access"]  ? 1 : 0 ];
$set[] = [ "signup_access"    , $this->ps["signup_access"]     && $page_data["group"]["name"] == "guest" ? 1 : 0 ];
$set[] = [ "upload_access"    , $this->ps["upload_access"]     && $page_data["group"]["name"] != "guest" ? 1 : 0 ];
$set[] = [ "sell_access"      , $this->ps["sell_access"]       && $page_data["group"]["name"] != "guest" ? 1 : 0 ];
$set[] = [ "sell_share"       , $this->ps["sell_share"]        && $page_data["group"]["name"] != "guest" ? $this->ps["sell_share"] : 0 ];
$set[] = [ "report_access"    , $this->ps["report_access"]     && $page_data["group"]["name"] != "guest" ? 1 : 0 ];
$set[] = [ "notification_access"  , $this->ps["notification_access"]  && $page_data["group"]["name"] != "guest" ? 1 : 0 ];
$set[] = [ "advertisement_access" , $this->ps["advertisement_access"] && $page_data["group"]["name"] != "guest" ? 1 : 0 ];
$set[] = [ "comment_access"   , $this->ps["comment_access"]    && $page_data["group"]["name"] != "guest" ? 1 : 0 ];
$set[] = [ "upgrade_access"   , $this->ps["upgrade_access"]    && $page_data["group"]["name"] != "guest" && $page_data["group"]["name"] != "paid" ? 1 : 0 ];
$set[] = [ "artist_req_access", $this->ps["artist_req_access"] && $page_data["group"]["name"] != "guest" && $page_data["group"]["name"] != "artist" ? 1 : 0 ];
$set[] = [ "admin_access"     , $this->ps["admin_access"]      && $page_data["group"]["name"] != "guest" ? 1 : 0 ];
$set[] = [ "verified"         , $this->ps["verified"]          && $page_data["group"]["name"] != "guest" ? 1 : 0 ];
$set[] = [ "ui_access"        , $this->ps["ui_access"] ? json_encode( explode( ",", $this->ps["ui_access"] ) ) : null ];
$set[] = [ "be_access"        , $this->ps["be_access"] ? json_encode( explode( ",", $this->ps["be_access"] ) ) : null ];

$where = [ [ "ID", "=", $page_data["group"]["ID"] ] ];

$loader->db->_update([
	"table" => "_user_groups",
	"where" => [
	    "oper" => "AND",
	    "cond" => $where
    ],
	"set"   => $set
]);

$this->set_response( "done" );

?>
