<?php
if ( !defined("root" ) ) die;

$loader->theme->add_custom_page( [ "admin_dashboard", "admin_tools_cleaner", "admin_language_editor", "admin_menu_editor", "admin_page_editor", "admin_setting_api", "admin_setting_general", "admin_setting_sessions", "admin_setting_upload", "admin_setting_upload_aws", "admin_theme_setting", "admin_user_groups", "admin_tools_bot_runner", "admin_content_genres", "admin_content_tracks", "admin_content_albums", "admin_content_sources", "admin_content_artists", "admin_content_download_links", "admin_user_comments", "admin_users", "admin_user_payments", "admin_user_transactions", "admin_user_artist_reqs", "admin_user_withdraws", "admin_setting_notifications", "admin_user_ads", "admin_setting_email", "admin_setting_social_login", "admin_setting_pay", "admin_user_reports", "admin_setting_download", "admin_setting_softwares", "admin_setting_programs", "admin_tools_auto_translate" ] );

$loader->theme->set_name('__default')->loader->html->add_style( 'bootstrap_style', 'assets/third/bootstrap-4.6.0-dist/css/bootstrap.min.css' );
$loader->theme->set_name()->loader->html->add_style( 'style', 'assets/css/admin.min.css' );
$loader->theme->set_name('__default')->loader->html->add_style( 'material_design', 'assets/third/materialdesign-webfont-master/css/materialdesignicons.min.css' );
$loader->theme->set_name('__default')->loader->html->add_style( 'chosen_style',    'assets/third/chosen_v1.8.7/chosen.min.css', true );
$loader->theme->set_name('__default')->loader->html->add_style( 'chartjs_style',   'assets/third/Chart.js-2.9.4/dist/Chart.min.css', true );

$loader->theme->set_name('__default')->loader->html->add_java( 'translations',   'assets/js/textsjs?lang=' . $loader->ui->lang );
$loader->theme->set_name('__default')->loader->html->add_java( 'popper',         'assets/third/popper.min.js' );
$loader->theme->set_name('__default')->loader->html->add_java( 'jquery',         'assets/third/jquery-3.5.1.min.js' );
$loader->theme->set_name('__default')->loader->html->add_java( 'jquery_ui',      'assets/third/jquery-ui.min.js' );
$loader->theme->set_name('__default')->loader->html->add_java( 'chartjs_jquery', 'assets/third/Chart.js-2.9.4/dist/Chart.bundle.min.js', false );
$loader->theme->set_name('__default')->loader->html->add_java( 'chosen_jquery',  'assets/third/chosen_v1.8.7/chosen.jquery.min.js', true );
$loader->theme->set_name('__default')->loader->html->add_java( 'bootstrap_js',   'assets/third/bootstrap-4.6.0-dist/js/bootstrap.min.js', true );
$loader->theme->set_name('__default')->loader->html->add_java( 'custom_be_cli',  'assets/js/be_cli.min.js', true );
$loader->theme->set_name('__default')->loader->html->add_java( 'admin_app',      'assets/js/admin.js', true );
$loader->theme->set_name('__default')->loader->html->add_java( 'custom_app',     'assets/js/app.min.js', true );

$admin_links = [

	array(
		"title"    => "Dashboard",
		"icon"     => "view-dashboard",
		"url"      => "admin_dashboard"
	),
	array(
		"title"    => "Contents",
		"icon"     => "folder-multiple-image",
		"url"      => null,
		"children" => array(
			array(
				"title" => "Manage Genres",
				"icon"  => "tag",
				"url"   => "admin_content_genres",
			),
			array(
				"title" => "Manage Artists",
				"icon"  => "account-music",
				"url"   => "admin_content_artists",
			),
			array(
				"title" => "Manage Albums",
				"icon"  => "album",
				"url"   => "admin_content_albums",
			),
			array(
				"title" => "Manage Tracks",
				"icon"  => "play-box-multiple",
				"url"   => "admin_content_tracks",
			),
		),
	),
	array(
		"title"    => "Users",
		"icon"     => "account",
		"url"      => null,
		"children" => array(
			array(
				"title" => "Manage User Groups",
				"icon"  => "lock-open",
				"url"   => "admin_user_groups"
			),
			array(
				"title" => "Manage Users",
				"icon"  => "account-box-multiple",
				"url"   => "admin_users"
			),
			array(
				"title" => "Manage Comments",
				"icon"  => "message-reply",
				"url"   => "admin_user_comments"
			),
			array(
				"title" => "Artist Requests",
				"icon"  => "shield-check",
				"url"   => "admin_user_artist_reqs"
			),
			array(
				"title" => "User Reports",
				"icon"  => "alert",
				"url"   => "admin_user_reports"
			),
		)
	),
	array(
		"title"    => "Commercial",
		"icon"     => "credit-card",
		"url"      => null,
		"children" => array(
			array(
				"title" => "Payment Submissions",
				"icon"  => "cart-plus",
				"url"   => "admin_user_payments"
			),
			array(
				"title" => "Transaction History",
				"icon"  => "cart-outline",
				"url"   => "admin_user_transactions"
			),
			array(
				"title" => "Withdraw Requests",
				"icon"  => "credit-card-outline",
				"url"   => "admin_user_withdraws",
			),
			array(
				"title" => "Advertisement",
				"icon"  => "star",
				"url"   => "admin_user_ads"
			),
		)
	),
	array(
		"title"    => "UI Editor",
		"icon"     => "shape",
		"url"      => null,
		"children" => array(
			array(
				"title" => "Theme Setting",
				"icon"  => "wrench",
				"url"   => "admin_theme_setting"
			),
			array(
				"title" => "Page Builder",
				"icon"  => "video-input-component",
				"url"   => "admin_page_editor"
			),
			array(
				"title" => "Menu Builder",
				"icon"  => "menu-open",
				"url"   => "admin_menu_editor"
			),
			array(
				"title" => "Language Editor",
				"icon"  => "translate",
				"url"   => "admin_language_editor"
			),
		)
	),
	array(
		"title"    => "Setting",
		"icon"     => "hammer-screwdriver",
		"url"      => null,
		"children" => array(

			array(
				"title" => "General Setting",
				"icon"  => "puzzle",
				"url"   => "admin_setting_general"
			),

			array(
				"title" => "API Setting",
				"icon"  => "rocket",
				"url"   => "admin_setting_api"
			),

			array(
				"title" => "Session Setting",
				"icon"  => "cookie",
				"url"   => "admin_setting_sessions"
			),

			array(
				"title" => "Commercial Setting",
				"icon"  => "credit-card-outline",
				"url"   => "admin_setting_pay"
			),

			array(
				"title" => "Upload Setting",
				"icon"  => "cloud-upload",
				"url"   => "admin_setting_upload"
			),

			array(
				"title" => "Third party hosting",
				"icon"  => "cloud-upload",
				"url"   => "admin_setting_upload_aws"
			),

			array(
				"title" => "Download Setting",
				"icon"  => "cloud-download",
				"url"   => "admin_setting_download"
			),

			array(
				"title" => "Email Setting",
				"icon"  => "email",
				"url"   => "admin_setting_email"
			),

			array(
				"title" => "Social Login Setting",
				"icon"  => "account-group",
				"url"   => "admin_setting_social_login"
			),

			array(
				"title" => "Notification Setting",
				"icon"  => "account-alert",
				"url"   => "admin_setting_notifications"
			),

			array(
				"title" => "CLI Programs Setting",
				"icon"  => "apps",
				"url"   => "admin_setting_programs"
			),

		)
	),
	array(
		"title"    => "Tools",
		"icon"     => "hammer-wrench",
		"url"      => null,
		"children" => array(
			array(
				"title" => "Spotify Widget Updater",
				"icon"  => "robot",
				"url"   => "admin_tools_bot_runner"
			),
			array(
				"title" => "Auto Translate",
				"icon"  => "robot",
				"url"   => "admin_tools_auto_translate"
			),
			array(
				"title" => "Cleaner",
				"icon"  => "broom",
				"url"   => "admin_tools_cleaner"
			),
		)
	),

];
foreach( $admin_links as &$admin_link ){

	if ( !empty( $admin_link["children"] ) ){
		foreach( $admin_link["children"] as $admin_link_child ){
			$admin_link["urls"][] = $admin_link_child["url"];
		}
	}
	if ( !empty( $admin_link["invisible_children"] ) ){
		foreach( $admin_link["invisible_children"] as $admin_link_child ){
			$admin_link["urls"][] = $admin_link_child["url"];
		}
	}

}
$loader->ui->admin_menus = $admin_links;

?>
