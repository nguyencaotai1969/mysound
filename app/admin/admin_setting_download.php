<?php if ( !defined("root" ) ) die; ?>
<div class="box-title">
  <div class="icon"><span class="mdi mdi-cloud-download"></span></div>
  <div class="title">Download Setting</div>
</div>
<div class="box">
<form method="post" class="be_cli_form" data-action="admin_save_setting_download" data-target=".watermark">
  
  <div class="setting">
  <div class="row">
  	<div class="col-6">
  	  <div class="name">Session lock</div>
  	  <div class="tip">If checked, download links will only work for the user that created them ( by comparing IP/user-agent/session_id ). Otherwise users can share download links and anyone can use them</div>
  	</div>
  	<div class="col-6"><?php echo $loader->html->doms->create_input( "check", "download_lock", $loader->admin->get_setting( "download_lock", 1 ) ) ?></div>
  </div>
  </div>
  
  <div class="setting">
  <div class="row">
  	<div class="col-6">
  	  <div class="name">Download limit for purchased tracks</div>
  	  <div class="tip">How many times can a user download a purchased track? Enter 0 for unlimited</div>
  	</div>
  	<div class="col-6"><?php echo $loader->html->doms->create_input( "digit", "download_limit", $loader->admin->get_setting( "download_limit", 0 ) ) ?></div>
  </div>
  </div>
  
  <div class="setting">
  <div class="row">
  	<div class="col-6">
  	  <div class="name">Life time</div>
  	  <div class="tip">Enter life time of download links in minute. Links will be un-usable when life time is over</div>
  	</div>
  	<div class="col-6"><?php echo $loader->html->doms->create_input( "digit", "download_range", $loader->admin->get_setting( "download_range", 30 ) ) ?></div>
  </div>
  </div>

  <div class="foot_buttons"><input type="submit" value="Save" class="btn btn-success btn-wide"></div>
  
</form>
</div>
