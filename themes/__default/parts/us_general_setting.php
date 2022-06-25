<?php if ( !defined("root" ) ) die; ?>
<form method="post" class="be_cli_form" data-action="user_setting_<?php echo $page_data["setting_part"]; ?>" data-target=".watermark" data-callback-param="general_setting" data-callback="check_user_setting_response" >
<div class="input_wrapper">
  <div class="input">
    <label><?php $loader->lorem->eturn( "username", ["uc"=>true] ) ?></label>
    <input name="username" type="text" class="form-control" value="<?php echo $page_data["user_data"]["username"]; ?>">
  </div>
</div>
<div class="input_wrapper">
  <div class="input">
    <label><?php $loader->lorem->eturn( "email", ["uc"=>true] ) ?></label>
    <input name="email" type="email" class="form-control" disabled value="<?php echo $page_data["user_data"]["email"]; ?>">
  </div>
</div>
<input type="submit" class="btn btn-primary btn-wide" value="<?php $loader->lorem->eturn( "save", ["uc"=>true] ) ?>">
</form>