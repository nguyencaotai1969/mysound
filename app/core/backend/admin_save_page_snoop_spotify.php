<?php

if ( !defined( "root" ) ) die;

$search_spotify_for_playlists = $loader->spotify->search_playlists( $this->ps["query"] );
if ( empty( $search_spotify_for_playlists[1] ) || !$search_spotify_for_playlists[0] )
	$this->set_error( "No search result" );

$html = "";
foreach( $search_spotify_for_playlists[1] as $playlist ){
	
	$html .= "<div class='result playlist'>";
	  $html .= "<div class='title'>{$playlist["name"]}</div>";
	  $html .= "<div class='desc'>{$playlist["description"]}<br>@owner: {$playlist["owner"]["display_name"]}</div>";
	  $html .= "<div class='buttons'>";
	    $html .= "<div class='button btn btn-sm btn-primary aspss_handle' data-widget-id='{$this->ps["widID"]}' data-hook='{$playlist["id"]}'>Select</div>";
	  $html .= "</div>";
	$html .= "</div>";
	
}

$this->set_response( $html, false, false, true );

?>