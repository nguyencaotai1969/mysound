<?php if ( !defined("root" ) ) die;
$loader->ui->includes = [];
$loader->html->add_body_class( "uap" );
$loader->theme->set_name('__default')->loader->html->add_java( 'translations', 'assets/js/textsjs?lang=' . $loader->ui->lang );
$loader->html->add_inline_style( $loader->theme->set_name()->__req( "parts/header_css.php" ) );
echo $loader->html->load_part( "header_javas" );
?>
<a href="/" class="logo">
  <img alt="signup" src="<?php echo $loader->general->path_to_addr( $loader->theme->set_name()->get_setting( "logo" ) ); ?>">
</a>
