<?php if ( !defined( "root" ) ) die;
for( $i=1; $i<=$setting["rows"]; $i++ ) : ?>
<div class="a_row">
  <?php foreach( array_splice( $items, 0, $setting["i_p_r"] ) as $item ) :  ?>
    <div class="slider_item playlist track">
      <div class="cover"><a href="<?php $loader->ui->eurl( "playlist", $item["url"] ); ?>"><img alt="<?php echo $item["name"]; ?>" src="<?php echo $item["cover"]; ?>"></a></div>
      <div class="data">
        <div class="title wsnw"><a class="wsnwe" href="<?php $loader->ui->eurl( "playlist", $item["url"] ); ?>"><?php echo $item["name"]; ?></a></div>
        <div class="artist"><a class="wsnwe" href="<?php echo $item["owner"]["url"]; ?>"><?php echo $item["owner"]["username"]; ?></a></div>
      </div>
    </div>
  <?php endforeach; ?>
</div>
<?php endfor; ?>
