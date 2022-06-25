<?php if ( !defined( "root" ) ) die;
$demo = defined( "demo" ) ? demo && $loader->visitor->user()->ID != 1 : false;
?>
<div class="box-title">
  <div class="icon"><span class="mdi mdi-rocket"></span></div>
  <div class="title">API Setting</div>
</div>
<div class="box">
<form method="post" class="be_cli_form" data-action="admin_save_setting_api" data-target=".watermark">

  <div class="setting">
  <div class="row">
    <div class="col-6">
      <div class="name">Get visitor IP data</div>
      <div class="tip">Do you want detailed IP data about your visitors from ip-api.com?</div>
    </div>
    <div class="col-6"><?php echo $loader->html->doms->create_input( "check", "get_visitor_ip_data", $loader->admin->get_setting("get_visitor_ip_data",null) ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
    <div class="col-6">
      <div class="name">Proxy address</div>
      <div class="tip">If you want your API calls go through a proxy, set proxy_address:proxy_port here</div>
    </div>
    <div class="col-6"><?php echo $loader->html->doms->create_input( "text", "req_proxy", $loader->admin->get_setting( "req_proxy", null ), null, "proxy_address:proxy_port" ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
    <div class="col-6">
      <div class="name">Proxy auth</div>
      <div class="tip">Your proxy authorization as username:password</div>
    </div>
    <div class="col-6"><?php echo $loader->html->doms->create_input( "text", "req_proxy_a", $loader->admin->get_setting( "req_proxy_a", null ), null, "proxy_username:proxy_password" ) ?></div>
  </div>
  </div>

  <div class="head">
  <div class="row">
    <div class="col-12"><span class="mdi mdi-spotify"></span>Spotify</div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-6">
  	  <div class="name">Client ID</div>
  	  <div class="tip">Client ID is the unique identifier of your application. <a href="https://developer.spotify.com/documentation/general/guides/app-settings/">more info</a></div>
  	</div>
  	<div class="col-6"><?php echo $loader->html->doms->create_input( "text", "spotify_id", $demo ? "*******" : $loader->admin->get_setting( "spotify_id", null ), "ID" ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-6">
  	  <div class="name">Client Secret</div>
  	  <div class="tip">Client Secret is the key that you pass in secure calls to the Spotify Accounts and Web API services. <a href="https://developer.spotify.com/documentation/general/guides/app-settings/">more info</a></div>
  	</div>
  	<div class="col-6"><?php echo $loader->html->doms->create_input( "text", "spotify_key", $demo ? "*******" : $loader->admin->get_setting( "spotify_key", null ), "Key" ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-6">
  	  <div class="name">Search</div>
  	  <div class="tip">Should app include search results from Spotify on website search page? You have to also enable 'Audo-Discover' options for spotify search to work</div>
  	</div>
  	<div class="col-6"><?php echo $loader->html->doms->create_input( "check", "spotify_search", $loader->admin->get_setting( "spotify_search", 1 ) ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-6">
  	  <div class="name">Audo-discover on upload</div>
  	  <div class="tip">Should the app try to find Spotify-ID for each track and album uploaded by user? App will use ID3 tags to find track on Spotify</div>
  	</div>
  	<div class="col-6"><?php echo $loader->html->doms->create_input( "check", "spotify_upload", $loader->admin->get_setting( "spotify_upload", 1 ) ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-6">
  	  <div class="name">Editable IDs on upload</div>
  	  <div class="tip">During upload, can users enter or change Spotify-ID for a track or album?</div>
  	</div>
  	<div class="col-6"><?php echo $loader->html->doms->create_input( "check", "spotify_upload_e", $loader->admin->get_setting( "spotify_upload_e", 1 ) ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-6">
  	  <div class="name">Auto-discover artist image</div>
  	  <div class="tip">Should app search for new artists image on Spotify?</div>
  	</div>
  	<div class="col-6"><?php echo $loader->html->doms->create_input( "check", "spotify_d_a", $loader->admin->get_setting( "spotify_d_a", 1 ) ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-6">
  	  <div class="name">Auto-discover artist tracks</div>
  	  <div class="tip">Should app try to get artist's tracks, albums and related artists from Spotify?</div>
  	</div>
  	<div class="col-6"><?php echo $loader->html->doms->create_input( "check", "spotify_d_ar", $loader->admin->get_setting( "spotify_d_ar", 1 ) ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-6">
  	  <div class="name">Auto-discover album tracks</div>
  	  <div class="tip">Should app try to get album complete track list from Spotify?</div>
  	</div>
  	<div class="col-6"><?php echo $loader->html->doms->create_input( "check", "spotify_d_a_ts", $loader->admin->get_setting( "spotify_d_a_ts", 1 ) ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-6">
  	  <div class="name">Auto-discover local album tracks</div>
  	  <div class="tip">Should app try to get local albums ( the ones user uploaded not automaticly gathered from Spotify ) complete track list from Spotify?</div>
  	</div>
  	<div class="col-6"><?php echo $loader->html->doms->create_input( "check", "spotify_d_la_ts", $loader->admin->get_setting( "spotify_d_la_ts", 0 ) ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-6">
  	  <div class="name">Genre creation</div>
  	  <div class="tip">Should app create new genres presented in Spotify API results? If left unchecked, all tracks/albums that don't belong to an already-existing genre will be under "No-Genre" category</div>
  	</div>
  	<div class="col-6"><?php echo $loader->html->doms->create_input( "check", "spotify_g_c", $loader->admin->get_setting( "spotify_g_c", 0 ) ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-6">
  	  <div class="name">Widgets update interval</div>
  	  <div class="tip">How often should app update Spotify widgets created in page builder? Recommended value is 24 hours</div>
  	</div>
  	<div class="col-6"><?php echo $loader->html->doms->create_input( "digit", "spotify_w_u_i", $loader->admin->get_setting( "spotify_w_u_i", 24 ), "24" ) ?></div>
  </div>
  </div>

  <div class="head">
  <div class="row">
    <div class="col-12"><span class="mdi mdi-youtube"></span>Youtube</div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
    <div class="col-6">
      <div class="name">Audo-Discover video ID for songs</div>
      <div class="tip">App will try to find the Youtube video ID for songs which have no sources</div>
    </div>
    <div class="col-6"><?php echo $loader->html->doms->create_input( "check", "youtube_d_t", $loader->admin->get_setting( "youtube_d_t", 1 ) ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-6">
  	  <div class="name">Unofficial API</div>
  	  <div class="tip">You can check this box to use our unofficial Youtube API and bypass any quota limits. This is a free feature for supported users</div>
  	</div>
  	<div class="col-6"><?php echo $loader->html->doms->create_input( "check", "utube_api", $loader->admin->get_setting( "utube_api", 1 ) ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-6">
  	  <div class="name">API Keys</div>
  	  <div class="tip">Enter your Youtube API keys here. You can enter multiple keys to bypass daily quota. Each key should be in a new line</div>
  	</div>
  	<div class="col-6"><?php echo $loader->html->doms->create_input( "textarea", "yt_key", $loader->admin->get_setting( "yt_key", 24 ) ) ?></div>
  </div>
  </div>

  <div class="foot_buttons"><input type="submit" value="Save" class="btn btn-success btn-wide"></div>

</form>
</div>
