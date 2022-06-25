<?php if ( !defined("root" ) ) die; ?>
  <ul class="som_scroll_h">
    <?php if ( $page_data["user_data"]["artist"] ) :
	$artist_data = $loader->artist->select(["ID"=>$page_data["user_data"]["artist"]]);
	?>
    <li>
      <a href="<?php $loader->ui->eurl( "artist", $artist_data["url"] ); ?>">
        <div class="icon"><span class="mdi mdi-album"></span></div>
        <div class="label"><?php $loader->lorem->eturn( "albums", ["uc"=>true] ); ?></div>
      </a>
    </li>
    <li>
      <a href="<?php $loader->ui->eurl( "artist", $artist_data["url"] ); ?>">
        <div class="icon"><span class="mdi mdi-music-box-multiple"></span></div>
        <div class="label"><?php $loader->lorem->eturn( "tracks", ["uc"=>true] ); ?></div>
      </a>
    </li>
    <?php endif; ?>
    <?php foreach( $page_data["links"] as $_link ): ?>
    <li class="<?php if( $loader->ui->rurl( $_link[2], $page_data["user_data"]["username"] ) == $loader->ui->page_uri ) echo "active"; ?>">
      <a href="<?php $loader->ui->eurl( $_link[2], $page_data["user_data"]["username"] ); ?>">
        <div class="icon"><span class="mdi mdi-<?php echo $_link[0] ?>"></span></div>
        <div class="label"><?php echo $_link[1]; ?></div>
      </a>
    </li>
    <?php endforeach; ?>
  </ul>
