<?php if ( !defined( "root" ) ) die;
for( $i=1; $i<=$setting["rows"]; $i++ ) : ?><div class="a_row"><?php foreach( array_splice( $items, 0, $setting["i_p_r"] ) as $track ) : ?><div class="slider_item album track size_<?php echo $loader->secure->escape( $setting["size"] ); ?> track_dom track_dom_<?php echo !empty( $track["hash"] ) ? $track["hash"] : $track["ID"]; ?>">

  <div class="cover">

    <a <?php echo $track["link"] . $track["datas"] . $track["fclass"]; ?>><img alt='<?php echo $track["title"]; ?>' src='<?php echo $loader->general->path_to_addr($track["cover"]); ?>'></a>

    <?php if ( !empty( $track["hash"] ) ) : ?>
    <div class="buttons buttons_<?php echo $track["hash"]; ?>">
      <a class="pauseplay m_add" data-hook="<?php echo $track["hash"]; ?>"><span class="mdi mdi-play"></span></a>
    </div>
    <?php endif; ?>

    <?php if ( isset( $track["is_paid"] ) ? !$track["is_paid"] : false ) : ?>
    <div class="price"><span><?php echo $track["price"]; ?><span class="c"><?php echo $loader->admin->get_setting("currency") ?></span> </span></div>
    <?php endif; ?>

  </div>

  <div class="data">

    <div class="title wsnw"><a class="wsnwe <?php echo $track["iclass"]; ?>" <?php echo $track["link"] . $track["datas"]; ?>><?php echo $track["title"]; ?></a></div>
    <div class="artist"><a class="wsnwe <?php echo $track["artist_iclass"]; ?>" <?php echo $track["artist_link"] . $track["artist_datas"]; ?>><?php echo $track["artist_name"]; ?></a></div>

    <?php if ( isset( $track["is_paid"] ) ? !$track["is_paid"] : false ) : ?>
    <div class="price"><a href="<?php $loader->ui->eurl( "track", $track["url"] ) ?>"><span><?php $loader->general->display_price( $track["price"], false, [ "currency_wrapper" => "<span class=\"c\">%CURRENCY%</span>" ] ); ?></span></a></div>
    <?php endif; ?>

  </div>

</div><?php endforeach; ?></div><?php endfor; ?>
