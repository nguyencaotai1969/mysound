<?php if ( !defined( "root" ) ) die; ?>
<?php for( $i=1; $i<=$setting["rows"]; $i++ ) : ?><div class="a_row"><?php foreach( array_splice( $items, 0, $setting["i_p_r"] ) as $album ) : ?><div class="slider_item album size_<?php echo $setting["size"]; ?> a_dom dom_album_<?php echo !empty( $album["hash"] ) ? $album["hash"] : $album["ID"]; ?>">

  <div class="cover">

    <a <?php echo $album["link"] . $album["datas"] . $album["fclass"]; ?>><img alt='<?php echo $album["title"]; ?>' src='<?php echo $loader->general->path_to_addr($album["cover"]); ?>'></a>

    <?php if ( !empty( $album["hash"] ) ) : ?>
    <div class="buttons buttons_<?php echo $album["hash"]; ?>">
  	  <a class="pauseplay m_add" data-type="album" data-hook="<?php echo $album["hash"]; ?>"><span class="mdi mdi-play"></span></a>
  	</div>
  	<?php endif; ?>

  	<?php if ( isset( $album["is_paid"] ) ? !$album["is_paid"] : false ) : ?>
    <div class="price"><span><?php echo $album["price"]; ?><span class="c"><?php echo $loader->admin->get_setting("currency") ?></span> </span></div>
    <?php endif; ?>

  </div>

  <div class="data">

  	<div class="title wsnw"><a class="wsnwe <?php echo $album["iclass"]; ?>" <?php echo $album["link"] . $album["datas"]; ?>><?php echo $album["title"]; ?><span class="year"> - <?php echo $album["year"]; ?></span></a></div>
  	<div class="artist"><a class="wsnwe <?php echo !empty( $album["artist_iclass"] ) ? $album["artist_iclass"] : ""; ?>" <?php echo ( !empty( $album["artist_link"] ) ? $album["artist_link"] : "" ) . ( !empty( $album["artist_datas"] ) ? $album["artist_datas"] : "" ); ?>><?php echo $album["artist_name"]; ?></a></div>

  	<?php if ( isset( $album["is_paid"] ) ? !$album["is_paid"] : false ) : ?>
  	<div class="price"><a href="<?php $loader->ui->eurl( "album", $album["url"] ) ?>"><span><?php $loader->general->display_price( $album["price"], false, [ "currency_wrapper" => "<span class=\"c\">%CURRENCY%</span>" ] ); ?></span></a></div>
  	<?php endif; ?>

  </div>

</div><?php endforeach; ?></div><?php endfor; ?>
