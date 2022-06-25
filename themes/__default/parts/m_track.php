<?php if ( !defined("root" ) ) die; ?>
<div class="album track size_<?php echo $loader->secure->escape( $widget_setting["size"] ); ?> track_dom track_dom_<?php echo $track["hash"]; ?>">
  <div class="cover">
  	<img alt="<?php echo $track["title"]; ?>" src='<?php echo $loader->general->path_to_addr($track["cover"]); ?>'>
  	<div class="buttons buttons_<?php echo $track["hash"]; ?>">
  	  <div class="pauseplay m_add" data-hook="<?php echo $track["hash"]; ?>"><span class="mdi mdi-play"></span></div>
  	</div>
  	<?php if ( isset( $track["is_paid"] ) ? !$track["is_paid"] : false ) : ?>
  	<div class="price"><span><?php echo $track["price"]; ?><span class="c"><?php echo $loader->secure->escape( $loader->admin->get_setting("currency") ); ?></span> </span></div>
  	<?php endif; ?>
  </div>
  <div class="data">
  	<div class="title wsnw"><a class="wsnwe" href="<?php $loader->ui->eurl( "track", $track["url"] ) ?>"><?php echo $track["title"]; ?></a></div>
  	<div class="artist"><a class="wsnwe" href="<?php $loader->ui->eurl( "artist", $track["artist_url"] ) ?>"><?php echo $track["artist_name"]; ?></a></div>
  	<?php if ( isset( $track["is_paid"] ) ? !$track["is_paid"] : false ) : ?>
  	<div class="price"><a href="<?php $loader->ui->eurl( "track", $track["url"] ) ?>"><span><?php $loader->general->display_price( $track["price"], false, [ "currency_wrapper" => "<span class=\"c\">%CURRENCY%</span>" ] ); ?></span></a></div>
  	<?php endif; ?>
  </div>
</div>
