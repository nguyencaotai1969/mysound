<?php if ( !defined("root" ) ) die;
echo $loader->theme->set_name('__default')->__req( "parts/m_tables.php", false, [
	"type"    => "track",
	"items"   => $items,
	"options" => array(
	    "thead" => false,
	    "cols"  => $setting["table_cols"] ? $setting["table_cols"] : [ "cover", "i", "title", "artist", "play_btn" => [ "width" => 50 ], "duration" ],
    ),
	"setting" => $setting
] );
?>
