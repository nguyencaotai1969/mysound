<?php if ( !defined( "root" ) ) die;
$__ID = substr( md5( uniqid() . microtime(1) ), 0, 20 );
$loader->html->set_title( $loader->lorem->turn( "upload", ["uc"=>true] ) );
?>

<div id="uploader" class="dropzone" data-id="<?php echo $__ID; ?>">
  <div class="icon"><span class="mdi mdi-upload"></span></div>
  <div class="dz-default dz-message"><?php $loader->lorem->eturn( "upload_drop_text" ); ?></div>
  <div class="prg">
    <div class="text"><?php $loader->lorem->eturn( "upload_drop_text2" ); ?></div>
    <div id="uploading" class="dropzone" onmouseleave="if($(this).hasClass('touched')){$(this).removeClass('opened').removeClass('touched')}" onMouseOver="$(this).addClass('touched')"></div>
    <div class="progress">
      <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
    </div>
    <div class="continue">
    	<a class="btn btn-primary" href="<?php $loader->ui->eurl('user_upload_edit', null, "ID={$__ID}" ) ?>"><?php $loader->lorem->eturn( "continue", ["uc"=>true] ); ?></a>
    </div>
  </div>
</div>