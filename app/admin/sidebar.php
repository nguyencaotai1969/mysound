<?php if ( !defined("root" ) ) die; ?>
<div id="sidebar">
  <div class="logo"><a href="<?php $loader->ui->eurl( "index" ); ?>"><img src="<?php echo web_addr; ?>/themes/__default/assets/icons/l.png"></a></div>
  <div class="handler menu_handler"><span class="mdi mdi-menu"></span><span class="mdi mdi-close"></span></div>
  <ul>
    <?php foreach( $loader->ui->admin_menus as $parent_item ) : 
	$parent_item["has_child"] = empty( $parent_item["children"] ) ? "no-child" : "has-child"; 
	$parent_item["active"]    = empty( $parent_item["children"] ) ? $parent_item["url"] == $loader->ui->page_type : in_array( $loader->ui->page_type, $parent_item["urls"] );
	$parent_item["active"]    = $parent_item["active"] ? "active open" : "";
	?>
    <li data-url="<?php echo $parent_item["url"]; ?>" class="parent <?php echo $parent_item["has_child"] . " " . $parent_item["active"]; ?>">
      <div class="icon"><span class="mdi mdi-<?php echo $parent_item["icon"]; ?>"></span></div>
      <div class="con">
      	<div class="title"><?php echo $parent_item["title"]; ?></div>
      </div>
      <?php if ( !empty( $parent_item["children"] ) ) : ?>
      <ul class="children">
      	<?php foreach( $parent_item["children"] as $child_item ) : 
		$child_item["active"] = $loader->ui->page_type == $child_item["url"] ? "active" : "";  
		?>
      	<li data-url="<?php echo $child_item["url"]; ?>" class="child <?php echo $child_item["active"]; ?>">
      	  <div class="icon"><span class="mdi mdi-<?php echo $child_item["icon"]; ?>"></span></div>
      	  <div class="con">
      	  	<div class="title"><?php echo $child_item["title"]; ?></div>
      	  </div>
      	</li>
      	<?php endforeach; ?>
      </ul>
      <?php endif; ?>
    </li>
    <?php endforeach; ?>
    	
  </ul>
</div>
<div id="main">
