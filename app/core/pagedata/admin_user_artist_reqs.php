<?php

if ( !defined( "root" ) ) die;

$this->set_page_data([
	"items" => $loader->db->_select([
	    "table" => "_user_artist_reqs",
	    "limit" => 100,
	    "where" => [
	        [ "approved", null, null, true ]
        ]
    ])
]);

$loader->html->set_title( "Artist Verification Requests" );

?>