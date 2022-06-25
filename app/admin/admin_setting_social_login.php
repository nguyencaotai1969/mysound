<?php if ( !defined( "root" ) ) die;
$demo = defined( "demo" ) ? demo && $loader->visitor->user()->ID != 1 : false;
?>
<div class="box-title">
  <div class="icon"><span class="mdi mdi-account-group"></span></div>
  <div class="title">Social Login Setting</div>
</div>
<div class="box">
<form method="post" class="be_cli_form" data-action="admin_save_setting_social_login" data-target=".watermark">

  <div class=" head top">
  <div class="row">
    <div class="col-12"><span class="mdi mdi-facebook"></span>Facebook</div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-6">
      <div class="name">Enable login</div>
      <div class="tip">Enable logging to your website via Facebook</div>
  	</div>
  	<div class="col-6"><?php echo $loader->html->doms->create_input( "check", "sl_fb", $loader->admin->get_setting("sl_fb",null) ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-6">
  	  <div class="name">App ID</div>
  	</div>
  	<div class="col-6"><?php echo $loader->html->doms->create_input( "text", "sl_fb_k1", $demo ? "******" : $loader->admin->get_setting("sl_fb_k1",null) ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-6">
  	  <div class="name">App Secret</div>
  	</div>
  	<div class="col-6"><?php echo $loader->html->doms->create_input( "text", "sl_fb_k2", $demo ? "******" : $loader->admin->get_setting("sl_fb_k2",null) ) ?></div>
  </div>
  </div>

  <div class=" head">
  <div class="row">
    <div class="col-12"><span class="mdi mdi-twitter"></span>Twitter</div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-6">
  	  <div class="name">Enable login</div>
      <div class="tip">Enable logging to your website via Twitter</div>
  	</div>
  	<div class="col-6"><?php echo $loader->html->doms->create_input( "check", "sl_tw", $loader->admin->get_setting("sl_tw",null) ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-6">
  	  <div class="name">ID</div>
  	</div>
  	<div class="col-6"><?php echo $loader->html->doms->create_input( "text", "sl_tw_k1", $demo ? "******" : $loader->admin->get_setting("sl_tw_k1",null) ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-6">
  	  <div class="name">Secret</div>
  	</div>
  	<div class="col-6"><?php echo $loader->html->doms->create_input( "text", "sl_tw_k2", $demo ? "******" : $loader->admin->get_setting("sl_tw_k2",null) ) ?></div>
  </div>
  </div>

  <div class=" head">
  <div class="row">
    <div class="col-12"><span class="mdi mdi-google"></span>Google</div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-6">
  	  <div class="name">Enable login</div>
      <div class="tip">Enable logging to your website via Google</div>
  	</div>
  	<div class="col-6"><?php echo $loader->html->doms->create_input( "check", "sl_ggl", $loader->admin->get_setting("sl_ggl",null) ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-6">
  	  <div class="name">ID</div>
  	</div>
  	<div class="col-6"><?php echo $loader->html->doms->create_input( "text", "sl_ggl_k1", $demo ? "******" : $loader->admin->get_setting("sl_ggl_k1",null) ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-6">
  	  <div class="name">Secret</div>
  	</div>
  	<div class="col-6"><?php echo $loader->html->doms->create_input( "text", "sl_ggl_k2", $demo ? "******" : $loader->admin->get_setting("sl_ggl_k2",null) ) ?></div>
  </div>
  </div>

  <div class=" head">
  <div class="row">
    <div class="col-12"><span class="mdi mdi-instagram"></span>Instagram</div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-6">
  	  <div class="name">Enable login</div>
      <div class="tip">Enable logging to your website via Instagram</div>
  	</div>
  	<div class="col-6"><?php echo $loader->html->doms->create_input( "check", "sl_ig", $loader->admin->get_setting("sl_ig",null) ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-6">
  	  <div class="name">ID</div>
  	</div>
  	<div class="col-6"><?php echo $loader->html->doms->create_input( "text", "sl_ig_k1", $demo ? "******" : $loader->admin->get_setting("sl_ig_k1",null) ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-6">
  	  <div class="name">Secret</div>
  	</div>
  	<div class="col-6"><?php echo $loader->html->doms->create_input( "text", "sl_ig_k2", $demo ? "******" : $loader->admin->get_setting("sl_ig_k2",null) ) ?></div>
  </div>
  </div>

  <div class="foot_buttons"><input type="submit" value="Save" class="btn btn-success btn-wide"></div>

</form>
</div>
