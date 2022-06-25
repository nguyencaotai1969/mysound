<?php

if ( !defined( "root" ) ) die;

$v = $loader->admin->get_setting( "version", 100 ) / 100;
// custom pages
$loader->theme->add_custom_page( [ "track", "pre_404", "pre_no_access", "pre_user_pay_result", "pre_user_login", "pre_user_signup", "pre_user_recover" ] );

// favicon
if ( ( $favicon = $loader->theme->set_name()->get_setting( "favicon" ) ) )
$loader->theme->set_name()->loader->html->add_meta( 'favicon', '<link rel="icon" type="image/png" href="'.$loader->general->path_to_addr($favicon).'" />' );

// styles
$loader->theme->set_name('__default')->loader->html->add_style( 'bootstrap_style', 'assets/third/bootstrap-4.6.0-dist/css/bootstrap.min.css' );
$loader->theme->set_name()->loader->html->add_style( 'style', 'assets/css/style.min.css?v='.$v );
if( $loader->html->get_body_class( "rtl" ) ) $loader->theme->set_name()->loader->html->add_style( 'style_rtl', 'assets/css/style_rtl.min.css?v='.$v );
$loader->theme->set_name()->loader->html->add_style( 'style_responsive', 'assets/css/style_responsive.min.css?v='.$v );
$loader->theme->set_name()->loader->html->add_style( 'style_font', 'https://fonts.googleapis.com/css2?family='.urlencode($loader->theme->set_name()->get_setting( "font-family", "Montserrat" )).':ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;1,200;1,300&display=swap' );

$loader->theme->set_name('__default')->loader->html->add_style( 'material_design', 'assets/third/materialdesign-webfont-master/css/materialdesignicons.min.css' );
$loader->theme->set_name('__default')->loader->html->add_style( 'b_dropzone',      'assets/third/dropzone-5.7.0/dist/dropzone.css' );

// header js
$loader->theme->set_name('__default')->loader->html->add_java( 'translations', 'assets/js/textsjs?lang=' . $loader->ui->lang );
$loader->theme->set_name('__default')->loader->html->add_java( 'popper',       'assets/third/popper.min.js' );
$loader->theme->set_name('__default')->loader->html->add_java( 'jquery',       'assets/third/jquery-3.5.1.min.js' );
$loader->theme->set_name('__default')->loader->html->add_java( 'jquery_ui',    'assets/third/jquery-ui.min.js' );
$loader->theme->set_name('__default')->loader->html->add_java( 'jquery_wfi',   'assets/third/jquery.waitforimages.min.js' );
$loader->theme->set_name('__default')->loader->html->add_java( 'jquery_tp',    'assets/third/jquery.ui.touch-punch.min.js' );
$loader->theme->set_name('__default')->loader->html->add_java( 'vivus',        'assets/third/vivus.min.js' );

// footer js
$loader->theme->set_name('__default')->loader->html->add_java( 'd_dropzone',   'assets/third/dropzone-5.7.0/dist/dropzone.js', true );
$loader->theme->set_name('__default')->loader->html->add_java( 'bootstrap_js', 'assets/third/bootstrap-4.6.0-dist/js/bootstrap.min.js', true );
$loader->theme->set_name('__default')->loader->html->add_java( 'amplitude_js', 'assets/third/amplitudejs-5.2.0/dist/amplitude.min.js', true );
$loader->theme->set_name('__default')->loader->html->add_java( 'custom_be_cli','assets/js/be_cli.js?v='.$v, true );
$loader->theme->set_name('__default')->loader->html->add_java( 'custom_pager', 'assets/js/pager.js?v='.$v, true );
$loader->theme->set_name('__default')->loader->html->add_java( 'custom_app',   'assets/js/app.js?v='.$v, true );
$loader->theme->set_name('__default')->loader->html->add_java( 'custom_muse',  'assets/js/muse.js?v='.$v, true );
$loader->theme->set_name()->loader->html->add_java( 'custom_app2', 'assets/js/app.js?v='.$v, true );

$loader->html->add_meta( 'r9_1', "<meta name=\"theme-color\" content=\"#{$loader->theme->set_name()->get_setting( "color", "2687fb" )}\">" );
$loader->html->add_meta( 'r9_2', "<meta name=\"msapplication-navbutton-color\" content=\"#{$loader->theme->set_name()->get_setting( "color", "2687fb" )}\">" );
$loader->html->add_meta( 'r9_3', "<meta name=\"apple-mobile-web-app-status-bar-style\" content=\"#{$loader->theme->set_name()->get_setting( "color", "2687fb" )}\">" );

if ( ( $adSense = trim( $loader->admin->get_setting( "adsense" ) ) ) ? substr( $adSense, 0, strlen("<script") ) == "<script" && substr( $adSense, -strlen( "</script>" ) ) == "</script>" : false ){
  $loader->html->set_code( "adsense", $adSense );
}

?>
