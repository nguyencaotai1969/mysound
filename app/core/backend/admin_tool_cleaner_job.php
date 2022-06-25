<?php

if ( !defined( "root" ) ) die;

$uploading_folders = $loader->ui->set_page_data()["uploading_folders"];
$queries = ["TRUNCATE `_curl_cache`","TRUNCATE `_debug`","TRUNCATE `_emails`","TRUNCATE `_user_downloads`","DELETE FROM _hits WHERE time_add < SUBDATE( now(), INTERVAL 1 YEAR )","DELETE FROM _user_sessions WHERE active = 0 OR time_update < SUBDATE( now(), INTERVAL 3 MONTH )","DELETE FROM _user_uploads WHERE time_add < SUBDATE( now(), INTERVAL 1 DAY )","OPTIMIZE TABLE `_blocked_ips`","OPTIMIZE TABLE `_curl_cache`","OPTIMIZE TABLE `_debug`","OPTIMIZE TABLE `_emails`","OPTIMIZE TABLE `_hits`","OPTIMIZE TABLE `_langs`","OPTIMIZE TABLE `_m_albums`","OPTIMIZE TABLE `_m_artists`","OPTIMIZE TABLE `_m_genres`","OPTIMIZE TABLE `_m_relations`","OPTIMIZE TABLE `_m_sources`","OPTIMIZE TABLE `_m_tracks`","OPTIMIZE TABLE `_m_tracks_data`","OPTIMIZE TABLE `_setting_admin`","OPTIMIZE TABLE `_setting_ads`","OPTIMIZE TABLE `_setting_ads_placements`","OPTIMIZE TABLE `_setting_menu`","OPTIMIZE TABLE `_setting_page`","OPTIMIZE TABLE `_setting_page_widgets`","OPTIMIZE TABLE `_setting_theme`","OPTIMIZE TABLE `_users`","OPTIMIZE TABLE `_user_actions`","OPTIMIZE TABLE `_user_artist_reqs`","OPTIMIZE TABLE `_user_comments`","OPTIMIZE TABLE `_user_downloads`","OPTIMIZE TABLE `_user_groups`","OPTIMIZE TABLE `_user_heard`","OPTIMIZE TABLE `_user_playlists`","OPTIMIZE TABLE `_user_playlists_relations`","OPTIMIZE TABLE `_user_purchases`","OPTIMIZE TABLE `_user_relations`","OPTIMIZE TABLE `_user_reports`","OPTIMIZE TABLE `_user_sessions`","OPTIMIZE TABLE `_user_transaction`","OPTIMIZE TABLE `_user_uploads`"];

if ( $this->ps["type"] == "query" ? in_array( $this->ps["job"], $queries, true ) : false ){
  $this->loader->db->query( $this->ps["job"] );
}

if ( $this->ps["type"] == "folder" ? in_array( $this->ps["job"], $uploading_folders ) : false ){

  $ents = $this->loader->general->scan_folder( $this->loader->general->upload_dir . "uploading/" . $this->ps["job"] );

  if ( $ents["files"] ){
    foreach( $ents["files"] as $_file ){
      unlink( $_file["path"] );
    }
  }

  if ( $ents["dirs"] ){
    foreach( array_reverse( $ents["dirs"] ) as $_dir ){
      rmdir( $_dir );
    }
  }

}

die;

?>
