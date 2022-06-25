<?php if ( !defined("root" ) ) die; ?>
<div id="form_holder">

  <h1><?php $loader->lorem->eturn( 'recover_h1', [ "uc" => true ] ); ?></h1>
  
  <?php if ( $page_data["step"] == 1 ) : ?>
  
  <div class="form_wrapper">
  <form method="post" class="be_cli_form" data-action="user_recover" data-target="#response" >
  
      <div id="response"></div>
      
      <div class="form-group">
      	<label><?php $loader->lorem->eturn( 'email', [ "uc" => true ] ); ?></label>
	    <input type="email" name="email" class="form-control" placeholder="<?php $loader->lorem->eturn( 'email', [ "uc" => true ] ); ?>">
      </div>
      
      <div class="form-group form-check">
        <label class="text"><?php $loader->lorem->eturn( 'forget_pass_tip' ); ?></label>
      </div>
      
      <div class="btn_wrapper">
      	<input type="submit" value="<?php $loader->lorem->eturn( 'continue', [ "uc" => true ] ); ?>" class="btn btn-primary">
      	<a href="<?php echo $loader->ui->eurl( 'user_login' ) ?>" class="btn btn-light"><?php $loader->lorem->eturn( 'login', [ "uc" => true ] ); ?></a>
      </div>
	  
  </form>	
  </div>
  
  <?php elseif ( $page_data["valid"] ) : ?>
  
  <div class="form_wrapper">
  <form method="post" class="be_cli_form" data-action="user_recover2" data-target="#response" >
  
      <div id="response"></div>
      
      <div class="form-group">
      	<label><?php $loader->lorem->eturn( 'new_password', [ "uc" => true ] ); ?></label>
	    <input type="password" name="password" class="form-control" placeholder="<?php $loader->lorem->eturn( 'password', [ "uc" => true ] ); ?>">
      </div>
      
      <div class="form-group">
      	<label><?php $loader->lorem->eturn( 'password_verify', [ "uc" => true ] ); ?></label>
	    <input type="password" name="password2" class="form-control" placeholder="<?php $loader->lorem->eturn( 'password', [ "uc" => true ] ); ?>">
      </div>
      
      <div class="btn_wrapper">
      	<input type="submit" value="<?php $loader->lorem->eturn( 'save', [ "uc" => true ] ); ?>" class="btn btn-primary">
      </div>
	  
  </form>	
  </div>
    
  <?php ;else: ?>
          
      <div class="alert alert-danger"><?php $loader->lorem->eturn("recover_failed"); ?></div>
  
  <?php endif; ?>

</div>


