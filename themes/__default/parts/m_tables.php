<?php if ( !defined("root" ) ) die;

$options["thead"] = !isset( $options["thead"] ) ? true : $options["thead"];
$options["class"] = !isset( $options["class"] ) ? []   : $options["class"];

$options["class"][] = $options["thead"] ? "has_head" : "has_no_head";

$tables_cols_standard = array(
	"track" => [ "sort", "i", "order", "cover", "duration", "title", "title_full_artist", "popularity", "like_btn", "play_btn", "artist", "album", "btns" ],
	"album" => [ "i", "cover", "duration", "title", "artist", "btns", "play_btn", "tracks" ],
);

$cols_standard = array(
	"title_full_artist" => array(
		"text" => "#"
	),
	"sort" => array(
		"width" => 40,
	),
	"order" => array(
	    "track" => "album_order",
	    "width" => 30,
	    "text"  => "#"
	),
	"i" => array(
	    "width" => 30,
	    "text"  => "#",
    ),
	"cover" => array(
	    "text"   => "",
	    "width"  => 40,
	    "class"  => "hom",

	    "track"  => "cover_addr",
	    "album"  => "cover_addr",
	    "artist" => "image",
    ),
	"duration" => array(
	    "track" => "duration",
	    "album" => "tracks_duration"
    ),
	"title" => array(
	    "track" => "title",
	    "album" => "title",
    ),
	"artist" => array(
	    "track" => "artist_name",
	    "album" => "artist_name"
    ),
	"album" => array(
	    "track" => "album_title",
	    "class" => "hom",
    ),
	"popularity" => array(
	    "track" => "popularity",
	    "class" => "hom",
	    "width" => 120
    ),
	"like_btn" => array(
	    "text"  => "",
	    "class" => "hom",
	    "width" => 28
    ),
	"play_btn" => array(
	    "text"  => "",
	    "width" => 28
    ),
	"duration" => array(
	    "width" => 40,
	    "track" => "duration",
	    "album" => "duration",
    ),
	"tracks" => array(
	    "width" => 60,
	    "album" => "tracks_count"
    ),

);

if ( empty( $type ) || empty( $items ) || empty( $options["cols"] ) ? true : !in_array( $type, array_keys( $tables_cols_standard ) ) )
	return;

$cols = [];

foreach( $options["cols"] as $_col_a => $_col_b ){

	if ( is_array( $_col_b ) && is_string( $_col_a ) ){
		$_col = $_col_a;
	} else {
		$_col = $_col_b;
	}

	if ( in_array( $_col, $tables_cols_standard[ $type ] ) && in_array( $_col, array_keys( $cols_standard ) ) ){
		$cols[] = $_col;
	}

	if ( is_array( $_col_b ) && is_string( $_col_a ) ){
		foreach( $_col_b as $__k => $__i ){
			$cols_standard[ $_col ][ $__k ] = $__i;
		}
	}

}

if ( empty( $cols ) ) return;

?>
<div class="table_wrapper" >
  <table class="<?php echo implode( " ", $options["class"] ); ?>">

    <?php if ( $options["thead"] ) : ?>
    <thead>
      <tr>
        <?php foreach( $cols as $col ) : ?>
        <td class="<?php echo "col-{$col}"; ?>"><?php $loader->lorem->eturn( strtolower( isset( $cols_standard[$col]["text"] ) ? $cols_standard[$col]["text"] : $col ), ["uc"=>true] ); ?></td>
        <?php endforeach; ?>
      </tr>
    </thead>
    <?php endif; ?>

    <tbody>

      <?php $i=0; foreach( $items as $item ) : $i++; ?>

      <tr class="<?php echo "{$type}_dom {$type}_dom_{$item["hash"]} a_dom dom_{$type}_{$item["hash"]}" ?>">

        <?php foreach( $cols as $col_key => $col ) :

		  $_options = $cols_standard[$col];
		  $classes = !empty( $_options["class"] ) ? explode( " ", $_options["class"] ) : [];
		  $attrs   = !empty( $_options["attr"] )  ? explode( " ", $_options["attr"] ) : [];
		  $output  = !empty( $_options[$type] ) ? ( !empty( $item[ $_options[$type] ] ) ? $item[ $_options[$type] ] : "-" ) : null;

		  if ( $col == "i" ) $output = !empty( $setting["page"] ) && !empty( $setting["limit"] ) ? ($setting["limit"]*($setting["page"]-1))+$i : $i;
		  if ( $col == "cover" ) $output = "<a href=\"".$loader->ui->rurl( $type, $item["url"] )."\"><img alt=\"cover\" class=\"a_cover\" src=\"{$output}\"></a>";
		  if ( $col == "duration" ) $output = $loader->general->hr_seconds( $output );
		  if ( $col == "tracks" ) $output = "{$output} tracks";
		  if ( $col == "popularity" ) $output = "<div class=\"pg_wrapper\"><div class=\"pg\" style=\"width:{$output}%\"></div></div>";
		  if ( $col == "title" ){

			  $output = !empty( $item["explicit"] ) ? $output . '<span class="explicit">E</span>' : $output;
			  $output = "<a href=\"".$loader->ui->rurl( $type, $item["url"] )."\">{$output}</a>";

		  }
		  if ( $col == "artist" ){

			  if ( !empty( $item["artist_url"] ) )
			  $output = "<a href=\"".$loader->ui->rurl( "artist", $item["artist_url"] )."\">{$output}</a>";

		  }
		  if ( $col == "title_full_artist" ){

			  $output = "<a class=\"_title\" href=\"".$loader->ui->rurl( $type, $item["url"] )."\">{$item["title"]}</a>";
			  $output .= "<div class=\"_artists\">";
			  $output .= "<a class=\"_artist\" href=\"".$loader->ui->rurl( "artist", $item["artist_url"] )."\">{$item["artist_name"]}</a>";
			  if ( !empty( $item["artists_featured"] ) ){
				  foreach( $item["artists_featured"] as $__ft ){
			    	  $output .= "<a class=\"_artist\" href=\"".$loader->ui->rurl( "artist", $__ft["url"] )."\">{$__ft["name"]}</a>";
				  }
			  }
			  $output .= "</div>";

		  }
		  if ( $col == "like_btn" ){

			  $item["is_paid"] = isset( $item["is_paid"] ) ? $item["is_paid"] : $loader->$type->is_paid( $item["ID"] );

			  if ( $item["is_paid"] ) {
				  $item["is_liked"] = isset( $item["is_liked"] ) ? $item["is_liked"] : $loader->$type->is_liked( $item["ID"] );
			      $output = "<div class=\"stat like_dom id_{$item["hash"]}".($item["is_liked"]?" liked":"")." m_like\" data-hook=\"{$item["hash"]}\"><span class=\"mdi mdi-heart-outline\"></span></div>";
			  }
			  else{
				   $output = "<a href=\"".$loader->ui->rurl( $type, $item["url"] )."\"><span class=\"mdi mdi-cart\"></span></a>";
			  }

		  }
		  if ( $col == "play_btn" ){

			  $item["is_paid"] = isset( $item["is_paid"] ) ? $item["is_paid"] : $loader->$type->is_paid( $item["ID"] );
			  if ( $item["is_paid"] ) {

			      $output = "<div class=\"buttons buttons_{$item["hash"]} m_add\" data-type=\"{$type}\" data-hook=\"{$item["hash"]}\"><div class=\"pauseplay\" ><span class=\"mdi mdi-play\"></span></div></div>";

			  }
			  else{
				   $output = "<a href=\"".$loader->ui->rurl( $type, $item["url"] )."\"><span class=\"mdi mdi-cart\"></span></a>";
			  }

		  }
			if ( $col == "sort" ) $output = "<span class='mdi mdi-sort'></span>";

		  if ( !empty( $_options["btn"] ) ){

			  $output = "<span class='val'>{$output}</span>";
			  $classes[] = "col-btn col-btn_{$_options["btn"]}";

			  if ( $_options["btn"] == "play" )
				  $output .= "<div class=\"buttons play buttons_{$item["hash"]} m_add\" data-hook=\"{$item["hash"]}\"><span class=\"pauseplay\"><span class=\"mdi mdi-play\"></span></span></div>";

			  if ( $_options["btn"] == "all" ){
				  $output .= "<div class=\"buttons button_more more_btn\">";
				    $output .= "<span class=\"mdi mdi-dots-horizontal more\"></span>";
				    $output .= "<div class=\"button_holder\">";
				      $output .= $loader->theme->set_name('__default')->__req( "parts/m_buttons.php", false, [ "type" => $type, "item" => $item ] );
				    $output .= "</div>";
				  $output .= "</div>";
			  }



		  }

		  if ( $output == "-" || !$output ) $classes[] = "no_val";
		  $classes[] = "col-no-" . ($col_key+1);
		  $classes[] = "col-{$col}";

		?>
        <td
          class="<?php echo implode( " ", $classes ); ?>"
		  <?php if ( !empty( $_options["width"] ) && $i == 1 ) echo " style=\"width: {$_options["width"]}px\" " ?>
          <?php echo !empty( $attrs ) ? implode( PHP_EOL, $attrs ) : ""; ?>
        ><?php echo $output ; ?></td>
        <?php endforeach; ?>

      </tr>

      <?php endforeach; ?>

    </tbody>

  </table>
</div>
