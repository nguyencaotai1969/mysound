<?php if ( !defined("root" ) ) die;
echo $loader->theme->set_name('__default')->__req( "parts/m_tables.php", false, [ 
	"type"    => "album",
	"items"   => $items,
	"options" => array(
		"thead" => false,
		"cols"  => [ "cover", "i", "title", "artist", "play_btn", "tracks" ],
	)
] ); 
?>