<?php if ( !defined( "root" ) ) die; ?>
<div class="box-title">
  <div class="icon"><span class="mdi mdi-cloud-upload"></span></div>
  <div class="title">Third Party Hosting</div>
</div>
<div class="box">
<form method="post" class="be_cli_form" data-action="admin_save_setting_upload_aws" data-target=".watermark">

  <div class="setting">
  <div class="row">
    <div class="col-6">
      <div class="name">Protect premium songs</div>
      <div class="tip">Third party hosts are public. Uploading your premium content on them is not recommended. Script will skip uploading premium content to third party hosts if you check this box</div>
    </div>
    <div class="col-6"><?php echo $loader->html->doms->create_input( "check", "aws_protect", $loader->admin->get_setting( "aws_protect", 1 ) ) ?></div>
  </div>
  </div>

  <div class="head">
  <div class="row">
    <div class="col-12"><span class="mdi mdi-amazon"></span> Amazon S3 Setting</div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
    <div class="col-6">
      <div class="name">Use AWS</div>
      <div class="tip">Do you want uploaded images/songs to your website automaticlly transfer to your AWS bucket?</div>
    </div>
    <div class="col-6"><?php echo $loader->html->doms->create_input( "check", "aws", $loader->admin->get_setting( "aws", 0 ) ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-6">
  	  <div class="name">Amazon Bucket Name</div>
  	</div>
  	<div class="col-6"><?php echo $loader->html->doms->create_input( "text", "aws_bucket", $loader->admin->get_setting( "aws_bucket" ) ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
    <div class="col-6">
      <div class="name">Amazon Bucket Region</div>
      <div class="tip">Enter bucket region code here. Example: eu-central-1</div>
    </div>
    <div class="col-6"><?php echo $loader->html->doms->create_input( "text", "aws_region", $loader->admin->get_setting( "aws_region" ) ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-6">
  	  <div class="name">Amazon S3 Key</div>
  	</div>
  	<div class="col-6"><?php echo $loader->html->doms->create_input( "text", "aws_key", $loader->admin->get_setting( "aws_key" ) ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-6">
  	  <div class="name">Amazon S3 Secret</div>
  	</div>
  	<div class="col-6"><?php echo $loader->html->doms->create_input( "text", "aws_secret", $loader->admin->get_setting( "aws_secret" ) ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-6">
      <div class="name">Endpoint</div>
      <div class="tip">Enter endpoint address if you are using a S3 compatible storage service like Wasabi</div>
  	</div>
  	<div class="col-6"><?php echo $loader->html->doms->create_input( "text", "aws_endpoint", $loader->admin->get_setting( "aws_endpoint" ) ) ?></div>
  </div>
  </div>

  <div class=" head ">
  <div class="row">
    <div class="col-12"><span class="mdi mdi-server-network"></span> FTP Setting</div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
    <div class="col-6">
      <div class="name">Use FTP</div>
      <div class="tip">Do you want uploaded images/songs to your website automaticlly transfer to another server via FTP?</div>
    </div>
    <div class="col-6"><?php echo $loader->html->doms->create_input( "check", "ftp", $loader->admin->get_setting( "ftp", 0 ) ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-6">
      <div class="name">FTP Address</div>
      <div class="tip">Example: ftp.domain.com OR 95.217.206.55</div>
  	</div>
  	<div class="col-6"><?php echo $loader->html->doms->create_input( "text", "ftp_address", $loader->admin->get_setting( "ftp_address" ) ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
    <div class="col-6">
      <div class="name">FTP Path</div>
    </div>
    <div class="col-6"><?php echo $loader->html->doms->create_input( "text", "ftp_path", $loader->admin->get_setting( "ftp_path" ) ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
    <div class="col-6">
      <div class="name">FTP Port</div>
      <div class="tip">Default FTP port is 21</div>
    </div>
    <div class="col-6"><?php echo $loader->html->doms->create_input( "digit", "ftp_port", $loader->admin->get_setting( "ftp_port" ) ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
    <div class="col-6">
      <div class="name">FTP SSL</div>
      <div class="tip">Should script connect to FTP using SSL?</div>
    </div>
    <div class="col-6"><?php echo $loader->html->doms->create_input( "check", "ftp_ssl", $loader->admin->get_setting( "ftp_ssl" ) ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
    <div class="col-6">
      <div class="name">FTP Username</div>
    </div>
    <div class="col-6"><?php echo $loader->html->doms->create_input( "text", "ftp_username", $loader->admin->get_setting( "ftp_username" ) ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
    <div class="col-6">
      <div class="name">FTP Password</div>
    </div>
    <div class="col-6"><?php echo $loader->html->doms->create_input( "text", "ftp_password", $loader->admin->get_setting( "ftp_password" ) ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-6">
      <div class="name">FTP Web-Address</div>
      <div class="tip">Where is FTP pointing to? example: https://ftp-server.domain.com </div>
  	</div>
  	<div class="col-6"><?php echo $loader->html->doms->create_input( "text", "ftp_web_address", $loader->admin->get_setting( "ftp_web_address" ) ) ?></div>
  </div>
  </div>

  <div class="foot_buttons">
    <a class="btn btn-primary disabled" onclick="be_cli({action:'admin_test_ftp',domTarget:'.watermark'})" >Test FTP</a>
    <a class="btn btn-primary disabled" onclick="be_cli({action:'admin_test_aws',domTarget:'.watermark'})" >Test AWS</a>
    <input type="submit" value="Save" class="btn btn-success btn-wide" onClick="$('.foot_buttons a.disabled').removeClass('disabled');">
  </div>

</form>
</div>
