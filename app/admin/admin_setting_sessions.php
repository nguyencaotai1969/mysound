<?php if ( !defined("root" ) ) die; ?>
<div class="box-title">
  <div class="icon"><span class="mdi mdi-lock"></span></div>
  <div class="title">Session Setting</div>
</div>
<div class="box">
<form method="post" class="be_cli_form" data-action="admin_save_setting_sessions" data-target=".watermark">

  <div class="setting">
  <div class="row">
  	<div class="col-6">
  	  <div class="name">IP lock</div>
  	  <div class="tip">Should users get logged out if their IP changes?</div>
  	</div>
  	<div class="col-6"><?php echo $loader->html->doms->create_input( "check", "session_i_lock", $loader->admin->get_setting( "session_i_lock", 1 ) ) ?></div>
  </div>
  </div>
  
  <div class="setting">
  <div class="row">
  	<div class="col-6">
  	  <div class="name">Platform lock</div>
  	  <div class="tip">Should users get logged out if their OS or browser changes?</div>
  	</div>
  	<div class="col-6"><?php echo $loader->html->doms->create_input( "check", "session_p_lock", $loader->admin->get_setting( "session_p_lock", 1 ) ) ?></div>
  </div>
  </div>
  
  <div class="setting">
  <div class="row">
  	<div class="col-6">
  	  <div class="name">Maximum sessions for user</div>
  	  <div class="tip">How many active sessions can a user have? Enter zero for unlimited</div>
  	</div>
  	<div class="col-6"><?php echo $loader->html->doms->create_input( "digit", "session_max", $loader->admin->get_setting( "session_max", 2 ) ) ?></div>
  </div>
  </div>
  
  <div class="setting">
  <div class="row">
  	<div class="col-6">
  	  <div class="name">Maximum session life</div>
  	  <div class="tip">By your php.ini configs, sessions will be collected as garbage after <?php echo round( ini_get("session.gc_maxlifetime") / 3600, 1 ); ?> hours of inactivity. You can set another limit here, the user will be logged out X hours after logging in. Enter zero for unlimited</div>
  	</div>
  	<div class="col-6"><?php echo $loader->html->doms->create_input( "digit", "session_lifetime", $loader->admin->get_setting( "session_lifetime", 168 ) ) ?></div>
  </div>
  </div>

  <div class="foot_buttons"><input type="submit" value="Save" class="btn btn-success btn-wide"></div>
  
</form>
</div>
