<?php if ( !defined("root" ) ) die; ?>

<div id="form_holder">

  <h1><?php $loader->lorem->eturn( 'login_h1', [ "uc" => true ] ); ?></h1>

  <?php if ( !empty( $page_data["sls"] ) ) : ?>
  <div class="sls">
    <?php foreach( $page_data["sls"] as $_sl_code => $_sl_name ) : ?>
    <a class="sl" href="<?php $loader->ui->eurl( "user_login", null, "sl={$_sl_name}" ); ?>"><span class="mdi mdi-<?php echo strtolower( $_sl_name ); ?>"></span></a>
    <?php endforeach; ?>
    <div class="sls_separator"><span><?php $loader->lorem->eturn("sls_separator"); ?></span></div>
  </div>
  <?php endif; ?>

  <div class="form_wrapper">
  <form method="post" class="be_cli_form" data-callback="check_login_result" data-action="user_login" data-target=".watermark" >

      <div id="response"></div>

      <div class="form-group">
        <div class="input-group">
          <span class="input-group-text" ><span class="mdi mdi-email"></span></span>
          <label><?php $loader->lorem->eturn( 'email', [ "uc" => true ] ); ?></label>
          <input type="email" name="email" autocomplete="off" autofill="off" class="form-control" placeholder="<?php $loader->lorem->eturn( 'email', [ "uc" => true ] ); ?>">
        </div>
      </div>

      <div class="form-group">
        <div class="input-group">
          <span class="input-group-text" ><span class="mdi mdi-lock"></span></span>
          <label><?php $loader->lorem->eturn( 'password', [ "uc" => true ] ); ?></label>
          <input type="password" name="password" autocomplete="off" autofill="off" class="form-control" placeholder="<?php $loader->lorem->eturn( 'password', [ "uc" => true ] ); ?>">
        </div>
      </div>

      <div class="form-group form-check">
        <label class="text"><a href="<?php echo $loader->ui->eurl( 'user_recover' ) ?>"><?php $loader->lorem->eturn( 'forget_pass_txt' ); ?></a></label>
      </div>

      <div class="btn_wrapper">
      	<input type="submit" value="<?php $loader->lorem->eturn( 'continue', [ "uc" => true ] ); ?>" class="btn btn-primary">
      	<a href="<?php echo $loader->ui->eurl( 'user_signup' ) ?>" class="btn btn-light"><?php $loader->lorem->eturn( 'signup', [ "uc" => true ] ); ?></a>
      </div>

  </form>
  </div>

</div>
