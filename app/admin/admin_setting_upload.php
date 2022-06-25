<?php if ( !defined( "root" ) ) die; ?>
<div class="box-title">
  <div class="icon"><span class="mdi mdi-cloud-upload"></span></div>
  <div class="title">Upload Setting</div>
</div>
<div class="box">
<form method="post" class="be_cli_form" data-action="admin_save_setting_upload" data-target=".watermark">

  <div class="setting">
  <div class="row">
    <div class="col-6">
      <div class="name">Maximum file size</div>
      <div class="tip">Maximum size for uploading files in megabyte</div>
    </div>
    <div class="col-6"><?php echo $loader->html->doms->create_input( "digit", "max_size", $loader->admin->get_setting( "max_size", 20 ) ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
    <div class="col-6">
      <div class="name">Minimum cover size</div>
      <div class="tip">Minimum width*height of uploaded covers in pixel</div>
    </div>
    <div class="col-6"><?php echo $loader->html->doms->create_input( "digit", "upload_min_cover", $loader->admin->get_setting( "upload_min_cover", 400 ) ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
    <div class="col-6">
      <div class="name">Minimum mp3 bitrate</div>
      <div class="tip">Minimum bitrate for uploaded tracks</div>
    </div>
    <div class="col-6"><?php echo $loader->html->doms->create_input( "digit", "upload_min_bitrate", $loader->admin->get_setting( "upload_min_bitrate", 64 ) ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
    <div class="col-6">
      <div class="name">Write mp3 ID3 tags</div>
      <div class="tip">Should system write new data to mp3 files?</div>
    </div>
    <div class="col-6"><?php echo $loader->html->doms->create_input( "check", "upload_write_id3", $loader->admin->get_setting( "upload_write_id3", 1 ) ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-6">
  	  <div class="name">Chunk upload</div>
  	  <div class="tip">Should selected files for uploading be chunked into smaller pieces and get uploaded one by one? We highly recommend using chunk upload. <a href='https://stackoverflow.com/questions/14909198/why-chunk-file-upload'>More info</a></div>
  	</div>
  	<div class="col-6"><?php echo $loader->html->doms->create_input( "check", "chunk", $loader->admin->get_setting( "chunk", 1 ) ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-6">
  	  <div class="name">Chunk size</div>
  	  <div class="tip">Maximum size for chunked pieces in megabyte. Maximum upload size on your server: <?php echo $page_data["max_upload_size"] ?></div>
  	</div>
  	<div class="col-6"><?php echo $loader->html->doms->create_input( "digit", "chunk_size", $loader->admin->get_setting( "chunk_size", 1 ) ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-6">
  	  <div class="name">Chunk parallel uploads</div>
  	  <div class="tip">How many files should be uploaded simultaneously?</div>
  	</div>
  	<div class="col-6"><?php echo $loader->html->doms->create_input( "digit", "max_par_ups", $loader->admin->get_setting( "max_par_ups", 1 ) ) ?></div>
  </div>
  </div>

  <div class="foot_buttons">
    <a class="btn btn-primary" href="<?php $loader->ui->eurl( "admin_setting_upload_aws" ); ?>">Third Party Hosting</a>
    <input type="submit" value="Save" class="btn btn-success btn-wide">
  </div>

</form>
</div>
