<?php if ( !defined("root" ) ) die; 
$loader->ui->includes = [];
$loader->html->set_title( $loader->lorem->turn( "no_access_title" ) );
$loader->html->set_http_header('status', 'HTTP/1.0 403 Forbidden');
?>

<div class="container" id="not_found">

  <img src="<?php echo $loader->theme->set_name('__default')->addr; ?>assets/icons/no_access.png" alt="no access. Sry">
  <div class="title"><?php $loader->lorem->eturn( "no_access_title" ); ?></div>
  
  <div class="detail"><?php $loader->lorem->eturn( "no_access_tip" ); ?></div>
  <div class="button"><a href="<?php $loader->ui->eurl( "index" ) ?>" class="btn btn-primary"><?php $loader->lorem->eturn( "404_goback" ); ?></a></div>
  
</div>