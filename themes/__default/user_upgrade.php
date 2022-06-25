<?php if ( !defined("root" ) ) die;
$color = $loader->secure->escape( $loader->theme->set_name()->get_setting( "color" ) );
$darker_color = $loader->general->color_adjust_brightness( $color, -66 );
?>

<div class="plans">
  <div class="plan normal">
  	<div class="title"><?php $loader->lorem->eturn( "normal_name", ["uc"=>true] ); ?></div>
  	<div class="price"><?php $loader->lorem->eturn( "free", ["uc"=>true] ); ?></div>
  	<div class="text">
 	  <?php echo str_replace( PHP_EOL, "<br>", $loader->lorem->turn( "normal_text" ) ); ?>
  	</div>
  </div>
  <div class="plan upgrade" style="background: linear-gradient(88deg, #<?php echo $color; ?>, <?php echo $darker_color; ?>)">
  	<div class="title"><?php $loader->lorem->eturn( "pro_name", ["uc"=>true] ); ?></div>
  	<div class="price"><?php $loader->general->display_price( $loader->admin->get_setting("upgrade_price") ); ?>/<?php $loader->lorem->eturn( "mo" ); ?></div>
  	<div class="text">
 	  <?php echo str_replace( PHP_EOL, "<br>", $loader->lorem->turn( "pro_text" ) ); ?>
  	</div>
  	<a class="purchase_handle"
	   data-title="<?php $loader->lorem->eturn( "purchase_premium", [ "uc" => true ] ); ?>"
	   data-fund="<?php echo $loader->user->data["fund"]; ?>"
	   data-item-title="<?php $loader->lorem->eturn( "purchase_premium_tip", [ "uc" => true ] ); ?>"
	   data-item-price="<?php echo $loader->admin->get_setting("upgrade_price"); ?>"
	   data-item-type="pro"><?php $loader->lorem->eturn( "upgrade", ["uc"=>true] ); ?></a>
  </div>
</div>
