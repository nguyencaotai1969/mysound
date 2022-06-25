<?php
if ( !defined("root" ) ) die;
?>
<ul class="menu_wrapper"><?php foreach( $menuData as $menu ) : 
	if ( empty( $menu ) ) continue;
	$menu_url = $loader->ui->rurl( null, $menu["page"] );
	if ( $menu["title"] == "divide" ) : ?><li class="divide"></li>
    <?php ;else: ?>
    <li class="p<?php
		if ( $loader->ui->page_uri == $menu_url ) echo " active";
	    if ( !empty( $menu["items"] ) ) echo " has-child";
		else echo " single";
		echo !empty( $menu["class"] ) ? " {$menu["class"]}" : "";
	?>">
      <span class="mdi mdi-<?php echo $loader->secure->escape( $menu["icon"] ); ?>"></span><a class="inline" href="<?php if ( !empty( $menu_url ) ) echo $menu_url; ?>"><?php echo $loader->secure->escape( $menu["title"] ); ?></a>
      <?php if ( !empty( $menu["items"] ) ) : ?>
      <ul class="items">
      	<?php foreach( $menu["items"] as $item ) :
		$item_url = $loader->ui->rurl( null, $item["page"] );
		if ( $item["title"] == "divide" ) : ?>
     	<li class="divide"></li>
     	<?php else: ?>
      	<li class="c<?php echo !empty( $item["class"] ) ? " {$item["class"]}" : ""; ?>"><span class="mdi mdi-<?php echo $loader->secure->escape( $item["icon"] ); ?>"></span><a class="inline" href="<?php if ( !empty( $item_url ) ) echo $item_url; ?>"><?php echo $loader->secure->escape( $item["title"] ); ?></a></li>
      	<?php endif;
	    endforeach; ?>
      </ul>
      <?php endif; ?>
    </li><?php endif; endforeach; ?></ul>
