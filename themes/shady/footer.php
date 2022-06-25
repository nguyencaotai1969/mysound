<?php if ( !defined("root" ) ) die;
$footer_menu = $loader->ui->load_menu( $loader->theme->set_name()->get_setting( "m_f" ), [], [], 3 );
if ( !empty( $footer_menu ) ) :
?>
<div class="footer_wrapper">
  <?php $loader->ui->display_menu( $footer_menu ); ?>
  <?php if ( !empty( $signature_text = $loader->theme->set_name()->get_setting( "signature" ) ) ) : ?>
  <div class="sign_text"><?php if ( !empty( $signature_url = $loader->theme->set_name()->get_setting( "sign_url" ) ) ) :
    echo "<a href='{$signature_url}' target='_blank'>{$signature_text}</a>";
    else :
    echo $signature_text;
  endif; ?></div>
  <?php endif; ?>
  <div class="socs">
    <?php
    foreach( ["twitter","facebook","instagram","soundcloud","spotify","linkedin","google"] as $_sl ) :
    if ( !empty( $url = $loader->theme->set_name()->get_setting( "sl_{$_sl}" ) ) ) : ?>
    <a href="<?php echo $url ?>" target="_blank" class="soc"><span class="mdi mdi-<?php echo $_sl; ?>"></span></a>
    <?php
    endif;
    endforeach;
    ?>
  </div>
</div>
<?php endif; ?>
</div></div>
<?php
if ( !empty( $java = $loader->theme->set_name()->get_setting( "java" ) ) ){
  $java = substr( $java, 0, strlen( "<script>" ) ) == "<script>" ? substr( $java, strlen( "<script>" ), -strlen( "</script>" ) ) : $java;
  echo "<script>{$java}</script>";
}
echo $loader->html->load_part( "footer_player" );
?>
