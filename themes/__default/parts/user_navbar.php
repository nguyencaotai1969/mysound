<?php if ( !defined( "root" ) ) die; ?>
<div id="user_nav">
<div class="container">
  <div class="user_nav_wrapper">

	<div class="bg_wrapper" style="background-image: url('<?php echo $page_data["user_data"]["bg_img"] ? $page_data["user_data"]["bg_img"] : $page_data["user_data"]["avatar"]; ?>')"><img src="<?php echo $page_data["user_data"]["bg_img"] ? $page_data["user_data"]["bg_img"] : $page_data["user_data"]["avatar"]; ?>" alt="<?php echo $page_data["user_data"]["username"]; ?> background"></div>

    <div class="avatar">
      <img src="<?php echo $page_data["user_data"]["avatar"]; ?>" alt="<?php echo $page_data["user_data"]["username"]; ?>">
    </div>

    <div class="name">
    	<?php echo $page_data["user_data"]["name"]; ?>
		<div class="links">
		  <?php if ( !empty( $page_data["user_data"]["external_addresses"]["website"] ) ) : ?>
		  <a href="<?php echo $page_data["user_data"]["external_addresses"]["website"]; ?>" target="_blank"><span class="mdi mdi-web"></span></a>
	      <?php endif; ?>
		  <?php if ( !empty( $page_data["user_data"]["external_addresses"]["facebook"] ) ) : ?>
		  <a href="https://www.facebook.com/<?php echo $loader->secure->escape( $page_data["user_data"]["external_addresses"]["facebook"] ); ?>" target="_blank"><span class="mdi mdi-facebook"></span></a>
	      <?php endif; ?>
		  <?php if ( !empty( $page_data["user_data"]["external_addresses"]["instagram"] ) ) : ?>
		  <a href="https://www.instagram.com/<?php echo $loader->secure->escape( $page_data["user_data"]["external_addresses"]["instagram"] ); ?>" target="_blank"><span class="mdi mdi-instagram"></span></a>
	      <?php endif; ?>
		  <?php if ( !empty( $page_data["user_data"]["external_addresses"]["soundcloud"] ) ) : ?>
		  <a href="https://soundcloud.com/<?php echo $loader->secure->escape( $page_data["user_data"]["external_addresses"]["soundcloud"] ); ?>" target="_blank"><span class="mdi mdi-soundcloud"></span></a>
	      <?php endif; ?>
		  <?php if ( !empty( $page_data["user_data"]["external_addresses"]["twitter"] ) ) : ?>
		  <a href="https://twitter.com/<?php echo $loader->secure->escape( $page_data["user_data"]["external_addresses"]["twitter"] ); ?>" target="_blank"><span class="mdi mdi-twitter"></span></a>
	      <?php endif; ?>
		</div>
    </div>

    <div class="buttons">
      <?php if ( $page_data["owner"] ) : ?>
      <a class="btn btn-secondary btn-sm cpm_handler"><?php $loader->lorem->eturn( "new_playlist", ["uc"=>true] ); ?></a>
      <a href="<?php $loader->ui->eurl( "user_setting", $page_data["user_data"]["username"] ) ?>" class="btn btn-primary btn-sm"><?php $loader->lorem->eturn( "edit_profile", ["uc"=>true] ); ?></a>
      <?php ;else: ?>
        <a class="btn btn-primary btn-sm follow_user_handle" data-target="<?php echo $page_data["user_data"]["username"]; ?>"><?php $loader->lorem->eturn( $loader->visitor->user()->check_log( 6, $page_data["user_data"]["ID"] ) ? "unfollow" : "follow" ); ?></a>
      <?php endif; ?>
    </div>

  </div>
</div>
</div>
