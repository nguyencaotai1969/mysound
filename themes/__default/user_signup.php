<?php if ( !defined("root" ) ) die; ?>

<div id="form_holder">

  <h1><?php $loader->lorem->eturn( 'signup_h1', [ "uc" => true ] ); ?></h1>

  <div class="form_wrapper">
  <form method="post" class="be_cli_form" data-action="user_signup" data-target=".watermark" data-callback="check_signup_result" >

      <div id="response"></div>

      <div class="form-group">
        <div class="input-group">
          <span class="input-group-text" ><span class="mdi mdi-account"></span></span>
          <label><?php $loader->lorem->eturn( 'username', [ "uc" => true ] ); ?></label>
  	      <input type="text" name="username" class="form-control" placeholder="<?php $loader->lorem->eturn( 'username', [ "uc" => true ] ); ?>">
        </div>
      </div>

      <div class="form-group">
        <div class="input-group">
          <span class="input-group-text" ><span class="mdi mdi-email"></span></span>
          <label><?php $loader->lorem->eturn( 'email', [ "uc" => true ] ); ?></label>
          <input type="email" name="email" class="form-control" placeholder="<?php $loader->lorem->eturn( 'email', [ "uc" => true ] ); ?>">
        </div>

      </div>
      <div class="form-group">
        <div class="input-group">
          <span class="input-group-text" ><span class="mdi mdi-lock"></span></span>
          <label><?php $loader->lorem->eturn( 'password', [ "uc" => true ] ); ?></label>
          <input type="password" name="password" class="form-control" placeholder="<?php $loader->lorem->eturn( 'password', [ "uc" => true ] ); ?>">
        </div>
      </div>

      <div class="form-group">
        <div class="input-group">
          <span class="input-group-text" ><span class="mdi mdi-lock"></span></span>
          <label><?php $loader->lorem->eturn( 'password_verify', [ "uc" => true ] ); ?></label>
          <input type="password" name="password2" class="form-control" placeholder="<?php $loader->lorem->eturn( 'password', [ "uc" => true ] ); ?>">
        </div>
      </div>

      <div class="form-group form-check">
        <input type="checkbox" name="terms_agreed" class="form-check-input">
        <?php if ( !empty( $terms_link = $loader->theme->set_name()->get_setting( "term-link" ) ) ) : ?>
          <label class="text"><a data-skip_bind='yes' href='<?php echo $terms_link; ?>'><?php $loader->lorem->eturn( 'signup_term_agree' ); ?></a></label>
        <?php else : ?>
          <label class="text"><?php $loader->lorem->eturn( 'signup_term_agree' ); ?></label>
        <?php endif; ?>
      </div>

      <div class="btn_wrapper">
      <?php if ( $this->loader->visitor->user()->has_access( 'group', 'signup' ) ) : ?>
      	<input type="submit" value="<?php $loader->lorem->eturn( 'continue', [ "uc" => true ] ); ?>" class="btn btn-primary">
      <?php else: ?>
      	<input type="submit" value="<?php $loader->lorem->eturn( 'signup_closed' ); ?>" disabled class="btn btn-primary">
      <?php endif; ?>
      	<a href="<?php echo $loader->ui->eurl( 'user_login' ) ?>" class="btn btn-light" target="_blank"><?php $loader->lorem->eturn( 'login', [ "uc" => true ] ); ?></a>
      </div>

  </form>
  </div>

</div>
