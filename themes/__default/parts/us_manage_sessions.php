<?php if ( !defined("root" ) ) die; ?>
<?php $sessions = $loader->hit->get_sessions(); ?>
<div class="sessions">
  <?php foreach( (array) $sessions as $session ) : ?>
  <div class="session">

  	<div class="icon" title="<?php echo $loader->secure->escape( $session["platform_type"] ); ?>">
  	  <?php if ( $session["platform_type"] == "desktop" ) : ?>
  	  <span class="mdi mdi-laptop"></span>
  	  <?php elseif( $session["platform_type"] == "tablet" ) : ?>
  	  <span class="mdi mdi-tablet"></span>
  	  <?php elseif( $session["platform_type"] == "mobile" ) : ?>
  	  <span class="mdi mdi-cellphone"></span>
  	  <?php endif; ?>
	</div>
	<div class="data">
	  <div class="os_name"><?php echo $loader->secure->escape( $session["platform_os"] ); ?></div>
	  <div class="ip"><?php echo $loader->secure->escape( $session["ip_country"] ); ?> - <?php $loader->lorem->eturn( "last_activity", ["uc"=>true] ); ?>: <?php echo ( time() - strtotime( $session["time_update"] ) < 10 ) ? $loader->lorem->eturn( "right_now", ["uc"=>true] ) : $loader->general->passed_time_hr( time() - strtotime( $session["time_update"] ), 1 )["string"]; ?></div>
	  <?php if ( $session["ID"] != $loader->hit->session_data["ID"] ) : ?>
	  <div class="close end_session_handle" data-hook="<?php echo $loader->secure->escape( $session["ID"] ); ?>"><span class="mdi mdi-close"></span></div>
	  <?php endif; ?>
	</div>

  </div>
  <?php endforeach; ?>
</div>
