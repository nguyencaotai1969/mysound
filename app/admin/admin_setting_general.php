<?php if ( !defined( "root" ) ) die; ?>
<div class="box-title">
  <div class="icon"><span class="mdi mdi-puzzle"></span></div>
  <div class="title">General Setting</div>
</div>
<div class="box">
<form method="post" class="be_cli_form" data-action="admin_save_setting_general" data-target=".watermark">

  <div class="setting">
  <div class="row">
  	<div class="col-6">
  	  <div class="name">Site name</div>
  	  <div class="tip">Your website name</div>
  	</div>
  	<div class="col-6"><?php echo $loader->html->doms->create_input( "text", "sitename", $loader->admin->get_setting("sitename",null) ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-6">
  	  <div class="name">Web Address</div>
  	  <div class="tip">Web address of your website. You can't change this address</div>
  	</div>
  	<div class="col-6"><?php echo $loader->html->doms->create_input( "text", "web_addr", $loader->admin->get_setting("web_addr",null) ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-6">
  	  <div class="name">Selected theme</div>
  	  <div class="tip">Select your theme. Themes are located in ~app_location/themes/</div>
  	</div>
  	<div class="col-6"><?php echo $loader->html->doms->create_input( "select", "theme_name", $loader->admin->get_setting("theme_name",null), $page_data["themes"] ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-6">
  	  <div class="name">Default language</div>
  	  <div class="tip">What is the default language for your website?</div>
  	</div>
  	<div class="col-6"><?php echo $loader->html->doms->create_input( "select", "lang", $loader->admin->get_setting("lang",null), $page_data["langs"] ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-6">
  	  <div class="name">Default user-group</div>
  	  <div class="tip">Which group should be assigned to new users?</div>
  	</div>
  	<div class="col-6"><?php echo $loader->html->doms->create_input( "select", "default_gid", $loader->admin->get_setting("default_gid",4), $page_data["groups"] ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-6">
  	  <div class="name">Prefer local-file</div>
  	  <div class="tip">If there is a track with multiple source types ( like local-file, youtube ) and this option is checked system will always choose localfile over other sources. If left unchecked, system will use other sources for play and only use local-file for download</div>
  	</div>
  	<div class="col-6"><?php echo $loader->html->doms->create_input( "check", "prefer_localfile", $loader->admin->get_setting("prefer_localfile",1) ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-6">
  	  <div class="name">Display Videos</div>
  	  <div class="tip">Left unchecked will force script to hide videos for video sources such as Youtube</div>
  	</div>
  	<div class="col-6"><?php echo $loader->html->doms->create_input( "check", "video_display", $loader->admin->get_setting("video_display",1) ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-6">
  	  <div class="name">Allow `Station`</div>
  	  <div class="tip">1 button, unlimited related tracks. If you have Spotify API enabled and you allow stations, there will be a `station` button which looks like an anthena next to good old play/pause button. Once clicked, DigiMuse will play that item ( track/album/artist/widget ) and set that item as station `seed`. Then it will find relative tracks for those seeds and add them to `Up Next`</div>
  	</div>
  	<div class="col-6"><?php echo $loader->html->doms->create_input( "check", "station", $loader->admin->get_setting("station",1) ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-6">
  	  <div class="name">Maximum execution time</div>
  	  <div class="tip">Maximum time for your server to execute a page/request in seconds. This option is ignored during uploads</div>
  	</div>
  	<div class="col-6"><?php echo $loader->html->doms->create_input( "digit", "up_timeout", $loader->admin->get_setting("up_timeout",null) ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-6">
  	  <div class="name">`Full Play` percentage</div>
  	  <div class="tip">If a user listens to at least a percentage of a song duration before that song is finished or skipped, that song `full play` count will increase by 1. Otherwise that song is considered `skipped` and not `full played`. Enter that percentage in this field </div>
  	</div>
  	<div class="col-6"><?php echo $loader->html->doms->create_input( "digit", "heard_ratio", $loader->admin->get_setting( "heard_ratio", 50 ) ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-6">
  	  <div class="name">Sign-up verification NOT required</div>
  	  <div class="tip">If left unchecked, your new users have to verify their email before being able to access your website as a user</div>
  	</div>
  	<div class="col-6"><?php echo $loader->html->doms->create_input( "check", "signup_verified", $loader->admin->get_setting("signup_verified",null) ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-6">
  	  <div class="name">Redirect single-albums to track</div>
  	  <div class="tip">Should system redirect users from single-album page to that album's only track?</div>
  	</div>
  	<div class="col-6"><?php echo $loader->html->doms->create_input( "check", "redirect_single_album", $loader->admin->get_setting( "redirect_single_album", 1 ) ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-6">
  	  <div class="name">Twitter username</div>
  	  <div class="tip">We need your Twitter username for html metadata. Makes Twitter sharing more relevant</div>
  	</div>
  	<div class="col-6"><?php echo $loader->html->doms->create_input( "text", "twitter_username", $loader->admin->get_setting( "twitter_username" ) ) ?></div>
  </div>
  </div>

  <div class="foot_buttons"><input type="submit" value="Save" class="btn btn-success btn-wide"></div>

</form>
</div>
