<?php if ( !defined("root" ) ) die; ?>
<div class="box-title">
  <div class="icon"><span class="mdi mdi-apps"></span></div>
  <div class="title">CLI Programs Setting</div>
</div>
<div class="box">
<form method="post" class="be_cli_form" data-action="admin_save_setting_programs" data-target=".watermark">

  <div class="setting">
  <div class="row">
  	<div class="col-6">
  	  <div class="name">FFmpeg</div>
  	  <div class="tip">If this option is checked and FFmpeg is installed on your server, app will use FFmpeg to make waveforms ( and provide supports for all audio extensions and not just mp3 ( soon ) )</div>
  	</div>
  	<div class="col-6"><?php echo $loader->html->doms->create_input( "check", "ffmpeg", $loader->admin->get_setting( "ffmpeg", 1 ) ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-6">
  	  <div class="name">FFmpeg Path</div>
  	  <div class="tip">The path to FFmpeg program</div>
  	</div>
  	<div class="col-6"><?php echo $loader->html->doms->create_input( "text", "ffmpeg_path", $loader->admin->get_setting( "ffmpeg_path" ) ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-6">
  	  <div class="name">FFmpeg Convert</div>
  	  <div class="tip">Would you like to automatically convert high quality audios to low quality audios and store both of them? If yes, enter the low quality bitrate. For example if you enter 128 and user uploads a 320 bitrate mp3 file, FFmpeg will convert that to 128k bitrate audio and store both of them. In user-group setting you can choose which file you want to use. Enter zero if don't want to convert</div>
  	</div>
  	<div class="col-6"><?php echo $loader->html->doms->create_input( "text", "ffmpeg_convert", $loader->admin->get_setting( "ffmpeg_convert", 0 ) ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-6">
  	  <div class="name">FFmpeg Waveforms</div>
  	  <div class="tip">If FFmpeg is installed and enabled and this option is checked, app will use FFmpeg to create waveforms</div>
  	</div>
  	<div class="col-6"><?php echo $loader->html->doms->create_input( "check", "ffmpeg_wave", $loader->admin->get_setting( "ffmpeg_wave", 0 ) ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-6">
  	  <div class="name">youtube-dl</div>
  	  <div class="tip">If this option & FFmpeg is checked and youtube-dl is installed on your server, app will try to download video from Youtube and convert it into mp3 rather than showing youtube video to users. Notice that downloading and converting each video might take to 30 seconds depending on your server and setup. Also, downloading video from Youtube might be illegal in your or your server location and we highly suggest leaving this option unchecked</div>
  	</div>
  	<div class="col-6"><?php echo $loader->html->doms->create_input( "check", "youtube_dl", $loader->admin->get_setting( "youtube_dl", 0 ) ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-6">
  	  <div class="name">youtube-dl Path</div>
  	  <div class="tip">The path to youtube-dl program</div>
  	</div>
  	<div class="col-6"><?php echo $loader->html->doms->create_input( "text", "youtube_dl_path", $loader->admin->get_setting( "youtube_dl_path", null ) ) ?></div>
  </div>
  </div>

  <div class="foot_buttons">
    <a class="btn btn-primary" onclick="be_cli({action:'admin_test_youtube_dl',domTarget:'#result'})" >Test youtube_dl</a>
    <input type="submit" value="Save" class="btn btn-success btn-wide">
  </div>

  <div id="result"></div>

</form>
</div>
