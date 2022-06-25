<?php if ( !defined("root" ) ) die; ?>
<form method="post" class="be_cli_form" data-action="user_setting_<?php echo $page_data["setting_part"]; ?>" data-target=".watermark" data-callback-param="profile_setting" data-callback="check_user_setting_response" data-hasFile="true" >
<div class="input_wrapper">
  <div class="input">
    <label><?php $loader->lorem->eturn( "profile_picture", ["uc"=>true] ); ?></label>
    <input name="avatar" type="file" id="f1" class="form-control" >
    <div class="file_handler file_placeholder" data-target="#f1"><?php $loader->lorem->eturn( "click_to_select", ["uc"=>true] ); ?></div>
  </div>
</div>
<div class="input_wrapper">
  <div class="input">
    <label><?php $loader->lorem->eturn( "background_picture", ["uc"=>true] ); ?></label>
    <input name="bg_img" type="file" id="f2" class="form-control" >
    <div class="file_handler file_placeholder" data-target="#f2"><?php $loader->lorem->eturn( "click_to_select", ["uc"=>true] ); ?></div>
  </div>
</div>
<div class="input_wrapper">
  <div class="input">
    <label><?php $loader->lorem->eturn( "name", ["uc"=>true] ); ?></label>
    <input name="name" type="text" class="form-control" value="<?php echo strip_tags( $page_data["user_data"]["name"], "" ); ?>">
  </div>
</div>
<div class="input_wrapper">
  <div class="input">
    <label>Website</label>
    <input name="website" type="text" class="form-control" value="<?php echo $loader->secure->escape( $page_data["user_data"]["external_addresses"]["website"] ); ?>">
  </div>
</div>
<div class="input_wrapper">
  <div class="input">
    <label>Facebook ID</label>
    <input name="facebook" type="text" class="form-control" value="<?php echo $loader->secure->escape( $page_data["user_data"]["external_addresses"]["facebook"] ); ?>">
  </div>
</div>
<div class="input_wrapper">
  <div class="input">
    <label>Instagram ID</label>
    <input name="instagram" type="text" class="form-control" value="<?php echo $loader->secure->escape( $page_data["user_data"]["external_addresses"]["instagram"] ); ?>">
  </div>
</div>
<div class="input_wrapper">
  <div class="input">
    <label>Soundcloud ID</label>
    <input name="soundcloud" type="text" class="form-control" value="<?php echo $loader->secure->escape( $page_data["user_data"]["external_addresses"]["soundcloud"] ); ?>">
  </div>
</div>
<div class="btn-grps">
  <input type="submit" class="btn btn-primary btn-wide" value="<?php $loader->lorem->eturn( "save", ["uc"=>true] ); ?>">
  <a href="<?php $loader->ui->eurl( "user_setting", $page_data["user_data"]["username"], "n=change_password" ); ?>" class="btn btn-secondary btn-wide"><?php $loader->lorem->eturn("us_change_password"); ?></a>
  <a href="<?php $loader->ui->eurl( "user_setting", $page_data["user_data"]["username"], "n=general_setting" ); ?>" class="btn btn-secondary btn-wide"><?php $loader->lorem->eturn("us_change_username"); ?></a>
</div>
</form>
