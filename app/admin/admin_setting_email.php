<?php if ( !defined("root" ) ) die; ?>
<div class="box-title">
  <div class="icon"><span class="mdi mdi-email"></span></div>
  <div class="title">Email Setting</div>
</div>
<div class="box">
<form method="post" class="be_cli_form" data-action="admin_save_setting_email" data-target=".watermark">

  <div class="setting">
  <div class="row">
  	<div class="col-6">
  	  <div class="name">Send Method</div>
  	  <div class="tip">Select the method you want the app use to send email to your website users</div>
  	</div>
  	<div class="col-6"><?php echo $loader->html->doms->create_input( "select", "email_s_type", $loader->admin->get_setting( "email_s_type", "mail" ), [
	    "smtp" => "SMTP server",
	    "mail" => "mail()"
    ] ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-6">
  	  <div class="name">SMTP Host</div>
  	</div>
  	<div class="col-6"><?php echo $loader->html->doms->create_input( "text", "email_s_host", $loader->admin->get_setting( "email_s_host" ) ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-6">
  	  <div class="name">SMTP Port</div>
  	</div>
  	<div class="col-6"><?php echo $loader->html->doms->create_input( "text", "email_s_port", $loader->admin->get_setting( "email_s_port" ) ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-6">
  	  <div class="name">SMTP Username</div>

  	</div>
  	<div class="col-6"><?php echo $loader->html->doms->create_input( "text", "email_s_user", $loader->admin->get_setting( "email_s_user" ) ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-6">
  	  <div class="name">SMTP Password</div>
  	</div>
  	<div class="col-6"><?php echo $loader->html->doms->create_input( "text", "email_s_pass", $loader->admin->get_setting( "email_s_pass" ) ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-6">
  	  <div class="name">SMTP Encryption</div>
  	  <div class="tip"></div>
  	</div>
  	<div class="col-6"><?php echo $loader->html->doms->create_input( "select", "email_s_encrypt", $loader->admin->get_setting( "email_s_encrypt", "tls" ), [
	    "tls" => "TLS",
	    "ssl" => "SSL"
    ] ) ?></div>
  </div>
  </div>

  <div class="foot_buttons">
    <a class="btn btn-primary" onclick="be_cli({action:'admin_test_smtp',domTarget:'.watermark'})" >Test SMTP</a>
    <input type="submit" value="Save" class="btn btn-success btn-wide">
  </div>

</form>
</div>
