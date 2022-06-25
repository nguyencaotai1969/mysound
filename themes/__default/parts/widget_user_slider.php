<?php if ( !defined( "root" ) ) die;
for( $i=1; $i<=$setting["rows"]; $i++ ) : ?>
<div class="a_row">
  <?php foreach( array_splice( $items, 0, $setting["i_p_r"] ) as $item ) :  ?>
    <div class="slider_item user artist">
      <div class="image"><a href="<?php echo $item["url"]; ?>"><img alt="<?php echo $item["name"]; ?>" src="<?php echo $item["avatar"]; ?>"></a></div>
      <div class="data">
        <div class="name wsnw"><a class="wsnwe" href="<?php echo $item["url"]; ?>"><?php echo $item["username"]; ?></a></div>
      </div>
    </div>
  <?php endforeach; ?>
</div>
<?php endfor; ?>
