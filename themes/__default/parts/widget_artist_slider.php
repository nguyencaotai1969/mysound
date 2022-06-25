<?php if ( !defined( "root" ) ) die;
for( $i=1; $i<=$setting["rows"]; $i++ ) : ?>
<div class="a_row"><?php foreach( array_splice( $items, 0, $setting["i_p_r"] ) as $artist ) : $artist["image"] = empty( $artist["image"] ) ? $this->loader->admin->get_setting("web_addr") . "/themes/__default/assets/icons/artist.png" : $artist["image"]; ?><div class="slider_item artist">
      <div class="image"><a <?php echo $artist["link"] . $artist["datas"] . $artist["fclass"]; ?>><img alt="<?php echo $artist["name"]; ?>" src="<?php echo $artist["image"]; ?>"></a></div>
      <div class="data">
      	<div class="name wsnw"><a class="wsnwe <?php echo $artist["iclass"] ?>" <?php echo $artist["link"] . $artist["datas"]; ?>><?php echo $artist["name"]; ?></a></div>
      </div></div><?php endforeach; ?></div>
<?php endfor; ?>
