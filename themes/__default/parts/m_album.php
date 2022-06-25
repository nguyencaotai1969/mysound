<?php if ( !defined("root" ) ) die; ?>
<div class="album size_<?php echo $widget_setting["size"]; ?> a_dom dom_album_<?php echo $album["hash"]; ?>">
  <div class="cover">
    <img src='<?php echo $loader->general->path_to_addr($album["cover"]); ?>' alt='<?php echo $album["title"]; ?>'>
    <div class="buttons buttons_<?php echo $album["hash"]; ?>">
  	  <div class="pauseplay m_add" data-hook="<?php echo $album["hash"]; ?>" data-type="album"><span class="mdi mdi-play"></span></div>
  	</div>
  </div>
  <div class="data">
  	<div class="title wsnw"><a class="wsnwe" href="<?php $loader->ui->eurl( "album", $album["url"] ) ?>"><?php echo $album["title"]; ?><span class="year"> - <?php echo $album["year"]; ?></span></a></div>
  	<div class="artist"><a class="wsnwe" href="<?php $loader->ui->eurl( "artist", $album["artist_url"] ) ?>"><?php echo $album["artist_name"]; ?></a></div>
  	<?php if ( isset( $album["is_paid"] ) ? !$album["is_paid"] : false ) : ?>
  	<div class="price"><a href="<?php $loader->ui->eurl( "album", $album["url"] ) ?>"><span><?php $loader->general->display_price( $album["price"], false, [ "currency_wrapper" => "<span class=\"c\">%CURRENCY%</span>" ] ); ?></span></a></div>
  	<?php endif; ?>
  </div>
</div>
