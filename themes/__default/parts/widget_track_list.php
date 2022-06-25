<?php if ( !defined( "root" ) ) die;
$col_x = 12 / $setting["columns"];
$__col_class = "col-12";
if ( $setting["columns"] == 2 ) $__col_class = "col-md-6 col-12";
elseif ( $setting["columns"] == 3 ) $__col_class = "col-lg-4 col-md-6 col-12";
?>

   	<div class="listing">
    <div class="row">
    
	  <?php 
	  $i=0; foreach( $items as $track ) : $i++; 
	  if ( !empty( $track["hash"] ) ) :
	  $track["is_paid"]  = isset( $track["is_paid"] ) ? $track["is_paid"] : $loader->track->is_paid( $track["ID"] );
	  $track["is_liked"] = isset( $track["is_liked"] ) ? $track["is_liked"] : $loader->track->is_liked( $track["ID"] );
	  endif;
	  ?>
	  <div class="<?php echo $__col_class; ?>">
	  <div class="track track_dom track_dom_<?php echo !empty( $track["hash"] ) ? $track["hash"] : $track["code"]; ?>">
	    <div class="cover">
	      <a <?php echo $track["fclass"] . $track["link"] . $track["datas"]; ?>><img src='<?php echo $loader->general->path_to_addr($track["cover"]); ?>' alt='<?php echo $track["title"]; ?>'></a>
	    </div>
	    <div class="data">
	      <div class="title">
            <?php if ( empty( $track["hash"] ) ) : ?>
            <div class="buttons"><a <?php echo $track["fclass"] . $track["link"] . $track["datas"]; ?>><span class="mdi mdi-link"></span></a></div>
            <?php elseif ( !empty( $track["is_paid"] ) ) : ?>
            <div class="buttons buttons_<?php echo $track["hash"]; ?> m_add" data-hook="<?php echo $track["hash"]; ?>">
              <span class="pauseplay"><span class="mdi mdi-play"></span></span>
            </div>
            <?php else : ?>
            <div class="buttons"><a href='<?php echo $loader->ui->rurl( "track", $track["url"] ) ?>'><span class="mdi mdi-cart-outline"></span></a></div>
            <?php endif; ?>
	        <div class="wsnw"><a <?php echo $track["fclass"] . $track["link"] . $track["datas"]; ?> class="wsnwe" ><?php echo $track["title"]; ?></a></div>
	      </div>
	      <div class="album_title wsnw"><div class="wsnwe">
	        <a <?php echo $track["artist_link"] . $track["artist_datas"] . $track["artist_fclass"]; ?>><?php echo $track["artist_name"] ?></a>
	      </div></div>
	      <div class="duration"><?php echo $loader->general->hr_seconds( $track["duration"] ); ?></div>
	    </div>
	  </div>
	  </div>
	  <?php endforeach; ?>
	  
	</div>
	</div>