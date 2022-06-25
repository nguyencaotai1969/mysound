<?php if ( !defined("root" ) ) die; ?>
<style><?php
$color = $loader->secure->escape( $loader->theme->set_name()->get_setting( "color", "2687fb" ) );
$darker_color = $loader->secure->escape( $loader->general->color_adjust_brightness( $color, -80 ) );
$very_darker_color = $loader->secure->escape( $loader->general->color_adjust_brightness( $color, -110 ) );
if ( ( $fontname = $loader->theme->set_name()->get_setting( "font-family", "Montserrat" ) ) != "Montserrat" ) :
?>
body {
  font-family: '<?php echo $fontname ?>'
}
<?php endif; ?>
#nav,
#nav .user_menu .user_wrapper,
#nav .buttons.opp .button.search.opened,
#nav .buttons.opp .button.search.opened .search_box_wrapper .form-control {
    background: #<?php echo $loader->secure->escape( $loader->theme->set_name()->get_setting( "navbar_color", "222629" ) ); ?>;
}
@keyframes flash {
  0% { background: #<?php echo $loader->secure->escape( $loader->theme->set_name()->get_setting( "navbar_color", "222629" ) ); ?>}
  100% {}
}
#nav .buttons.opp .button.search.opened > .mdi {
	color: #<?php echo $loader->secure->escape( $loader->theme->set_name()->get_setting( "navbar_color", "222629" ) ); ?>;
}
#sidebar,
body.search_open:after,
#sidebar ul.menu_wrapper li ul {
    background: #<?php echo $loader->secure->escape( $loader->theme->set_name()->get_setting( "sidebar_color", "222629" ) ); ?>;
}
#player{
    background: #<?php echo $loader->secure->escape( $loader->theme->set_name()->get_setting( "player_color", "222629" ) ); ?>;
}
.watermark .text,
#player .song_data .p_w .progress_e,
#player .song_data .p_w .progress_e:after,
#player .control_secondary_buttons .volume .sound_wrapper .pr,
#player .control_secondary_buttons .volume .sound_wrapper .pr:after,
#main .page .widget_slider .slider .a_row .slider_item .buttons a,
#main .page .widget_slider .arrows .arrow:hover,
.active_que_list #player .song_data .song_detail .playlist_buttons .list > span:after,
.active_yt.active_muse_video #player .song_data .song_detail .playlist_buttons .yt_handler span.mdi:after,
.progress-bar,
#main #side .tabs .tab.active,
#sidebar ul.menu_wrapper li.p.opened > a:after,
div#scroller::-webkit-scrollbar-thumb,
#nav ul.a_dropdown.a_m_dropdown.nots_ul li .avatar_wrapper .avatar.mdi,
#nav .buttons.nots .count {
	background: #<?php echo $color ; ?>
}
#player .song_data .p_w .progress_b {
	background: <?php echo $very_darker_color; ?>;
}
#main .user_container #user_content.us .user_setting_main .inputs .alert {
	border-color: #<?php echo $color; ?>70;
}
.btn-primary:not(:disabled):not(.disabled).active, .btn-primary:not(:disabled):not(.disabled):active, .show>.btn-primary.dropdown-toggle {
	background: <?php echo $darker_color; ?>;
	border-color: <?php echo $darker_color; ?>;
}
#nav .user_menu .user_wrapper ul li.upgrade {
	background: <?php echo $darker_color; ?>8a;
}
.btn.btn-primary,
#main .user_container #user_content.us .user_setting_widget ul li a {
    background: #<?php echo $color; ?>;
    border-color: #<?php echo $color; ?>;
}
#sidebar ul li.active > a {
	background: #<?php echo $color; ?>3d;
	color: #<?php echo $color; ?>;
}
#sidebar ul li.c.active,
#sidebar ul li.p.single.active,
#main .page .widget_table .table_wrapper table tbody tr.playing td.col-title,
#main .page .widget_table .table_wrapper table tbody tr.paused td.col-title,
#main .page .widget_table .table_wrapper table tbody tr.loading td.col-title,
#main .page .widget_slider .slider .a_row .slider_item.paused .data .title,
#main .page .widget_slider .slider .a_row .slider_item.playing .data .title,
#main .page .widget_slider .slider .a_row .slider_item.loading .data .title,
#que_list .que_tracks_wrapper .track.playing .buttons .button.pauseplay,
.active_que_list #player .song_data .song_detail .playlist_buttons .list,
#que_list .que_tracks_wrapper .track.playing .title,
#uploader:hover .dz-message,
#uploader:hover .icon,
#main .user_container #user_sidebar ul li.active,
.active_yt.active_muse_video #player .song_data .song_detail .playlist_buttons .yt_handler span.mdi,
#nav ul.a_dropdown.a_m_dropdown.nots_ul li:first-child:after {
    color: #<?php echo $color; ?>;
}
#uploader:hover,
#main .user_container #user_content.us .user_setting_main .inputs .input_wrapper .form-control:focus {
	border-color: #<?php echo $color; ?>;
}
body.uap:before {
	background: linear-gradient( 36deg, <?php echo $darker_color; ?>, #<?php echo $color; ?> );
}
#nav ul.a_dropdown.a_m_dropdown.nots_ul:before {
  content: "<?php $loader->lorem->eturn("notifications",["uc"=>true]); ?>"
}
</style>
