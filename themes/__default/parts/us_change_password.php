<?php if ( !defined("root" ) ) die; ?>
<form method="post" class="be_cli_form" data-action="user_setting_<?php echo $page_data["setting_part"]; ?>" data-target=".watermark" data-callback-param="change_password" data-callback="check_user_setting_response" >
<div class="input_wrapper">
  <div class="input">
    <label><?php $loader->lorem->eturn( "password", ["uc"=>true] ) ?></label>
    <input name="password" type="password" class="form-control" value="">
  </div>
</div>
<div class="input_wrapper">
  <div class="input">
    <label><?php $loader->lorem->eturn( "new_password", ["uc"=>true] ) ?></label>
    <input name="npassword" type="password" class="form-control" value="">
  </div>
</div>
<div class="input_wrapper">
  <div class="input">
    <label><?php $loader->lorem->eturn( "new_password", ["uc"=>true] ) ?></label>
    <input name="npassword2" type="password" class="form-control" value="">
  </div>
</div>
<input type="submit" class="btn btn-primary btn-wide" value="<?php $loader->lorem->eturn( "save", ["uc"=>true] ) ?>">
</form>