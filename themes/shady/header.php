<?php if ( !defined("root" ) ) die; ?>
<?php
$loader->html->add_inline_style( $loader->theme->set_name()->__req( "parts/header_css.php" ) );
echo $loader->theme->set_name()->__req( "parts/header_navbar.php" );
echo $loader->theme->set_name()->__req( "parts/header_player.php" );
echo $loader->html->load_part( "header_javas" );
?>