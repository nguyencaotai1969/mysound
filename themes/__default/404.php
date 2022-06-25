<?php if ( !defined("root" ) ) die; 
$loader->ui->includes = [];
$loader->html->set_title( "404" );
?>

<div class="container" id="not_found">

  <img src="<?php echo $loader->theme->set_name('__default')->addr; ?>assets/icons/404.png" alt="not found">
  <div class="title"><?php $loader->lorem->eturn( "404_title" ); ?></div>
  <div class="detail"><?php $loader->lorem->eturn( "404_tip" ); ?></div>
  <div class="button"><a href="<?php $loader->ui->eurl( "index" ) ?>" class="btn btn-primary"><?php $loader->lorem->eturn( "404_goback" ); ?></a></div>
  
</div>