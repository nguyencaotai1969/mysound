<?php if ( !defined("root" ) ) die; ?>

<div class="row">
  <div class="col-lg-6 col-12">
    <h4 class="nots"><?php $loader->lorem->eturn("notification",["uc"=>true]); ?></h4>
    <?php foreach( $loader->user->getActions(["admin_setting"=>true,"user_setting"=>true]) as $_action ) :
      if ( !$_action["ua_not"] ) continue;
      ?>
      <div class="input_wrapper check">
        <div class="input ">
          <label><?php $loader->lorem->eturn( "not_{$_action["type_name"]}_{$_action["hook_type"]}", ["uc"=>true] ); ?></label>
          <div class="checkbox_wrapper">
            <input name="not_<?php echo $_action["type"] ?>" type="checkbox" class="form-control" <?php echo $_action["usa_not"] ? "checked='checked'" : ""; ?>>
            <span class="checkmark"></span>
          </div>
          <?php if ( $_action["ua_email"] ) : ?>
          <div class="checkbox_wrapper email_cw">
            <input name="email_<?php echo $_action["type"] ?>" type="checkbox" class="form-control" <?php echo $_action["usa_email"] ? "checked='checked'" : ""; ?>>
            <span class="checkmark"></span>
          </div>
          <?php endif; ?>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
  <div class="col-lg-6 col-12">
    <h4><?php $loader->lorem->eturn("feed",["uc"=>true]); ?></h4>
    <?php foreach( $loader->user->getActions(["admin_setting"=>true,"user_setting"=>true]) as $_action ) :
    if ( !$_action["ua_feed"] ) continue; ?>
      <div class="input_wrapper check">
        <div class="input ">
          <label><?php $loader->lorem->eturn( "feed_{$_action["type_name"]}_{$_action["hook_type"]}", ["uc"=>true] ); ?></label>
          <div class="checkbox_wrapper">
            <input name="feed_<?php echo $_action["type"] ?>" type="checkbox" class="form-control" <?php echo $_action["usa_feed"] ? "checked='checked'" : ""; ?>>
            <span class="checkmark"></span>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>
<br>
<input type="button" class="btn btn-primary btn-wide save_feed_handler" value="<?php $loader->lorem->eturn( "save", ["uc"=>true] ); ?>">
