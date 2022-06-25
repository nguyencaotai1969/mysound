<?php if ( !defined("root" ) ) die;
$col_x = 12 / $setting["columns"];
$__col_class = "col-12";
if ( $setting["columns"] == 2 ) $__col_class = "col-md-6 col-12";
elseif ( $setting["columns"] == 3 ) $__col_class = "col-lg-4 col-md-6 col-12";
?>

	<div class="listing">
    <div class="row">
    
	  <?php $i=0; foreach( $items as $album ) : $i++; ?>
	  <div class="<?php echo $__col_class; ?>">
	  <div class="track album a_dom dom_album_<?php echo $album["hash"]; ?>">
	    <div class="cover">
	      <a href="<?php $loader->ui->eurl( "album", $album["url"] ); ?>" ><img alt='<?php echo $album["title"]; ?>' src='<?php echo $loader->general->path_to_addr($album["cover"]); ?>'></a>
	    </div>
	    <div class="data">
	      <div class="title">
            <div class="buttons buttons_<?php echo $album["hash"]; ?> m_add" data-type="album" data-hook="<?php echo $album["hash"]; ?>">
              <span class="pauseplay"><span class="mdi mdi-play"></span></span>
            </div>
	        <div class="wsnw"><a href="<?php $loader->ui->eurl( "album", $album["url"] ); ?>" class="wsnwe" ><?php echo $album["title"]; ?></a></div>
	      </div>
	      <div class="album_title wsnw"><div class="wsnwe">
	        <a href='<?php echo $loader->ui->rurl( "artist", $album["artist_url"] ) ?>'><?php echo $album["artist_name"] ?></a>
	      </div></div>
	      <div class="duration"><?php echo $album["tracks_count"] . " tracks"; ?></div>
	    </div>
	  </div>
	  </div>
	  <?php endforeach; ?>
	  
	</div>
	</div>