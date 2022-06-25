<?php

if ( !defined("root" ) ) die;

$loader->theme->setup_setting(array(
	"title"  => "Logo image",
	"tip"    => "Upload your logo. Size should be between 140px*35px - 180px*35px",
	"type"   => "image",
	"hook"   => "logo",
	"valid"  => "image"
));

$loader->theme->setup_setting(array(
	"title"  => "Favicon",
	"tip"    => "Upload your favicon ( jpg or png )",
	"type"   => "image",
	"hook"   => "favicon",
	"valid"  => "image"
));

$loader->theme->setup_setting(array(
	"title"  => "Site font name",
	"tip"    => "Name of font loaded from Google Fonts",
	"type"   => "text",
	"hook"   => "font-family",
	"valid"  => "string",
));

$loader->theme->setup_setting(array(
	"title"  => "Theme color",
	"tip"    => "Select the theme color. Old tracks waves will not change",
	"type"   => "color_selector",
	"hook"   => "color",
	"valid"  => "color"
));

$loader->theme->setup_setting(array(
	"title"  => "Navbar Color",
	"tip"    => "Select the theme color. Old tracks waves will not change",
	"type"   => "color_selector",
	"hook"   => "navbar_color",
	"valid"  => "color"
));

$loader->theme->setup_setting(array(
	"title"  => "Sidebar menu ( desktop )",
	"tip"    => "Select sidebar menu. This sidebar will be shown on non-mobile devices",
	"type"   => "select",
	"values" => "menus",
	"hook"   => "m_s",
	"valid"  => "menus"
));

$loader->theme->setup_setting(array(
	"title"  => "Sidebar menu ( mobile )",
	"tip"    => "Select sidebar menu. This sidebar will be shown on mobile devices. Maximum 3 menu items with/without sub-items",
	"type"   => "select",
	"values" => "menus",
	"hook"   => "m_sm",
	"valid"  => "menus"
));

$loader->theme->setup_setting(array(
	"title"  => "Footer menu",
	"tip"    => "Select list for footer menu. This menu will be shown on bottom of page",
	"type"   => "select",
	"values" => "menus",
	"hook"   => "m_f",
	"valid"  => "menus"
));

$loader->theme->setup_setting(array(
	"title"  => "Footer sign text",
	"tip"    => "Signature text",
	"type"   => "text",
	"hook"   => "signature",
	"valid"  => "string"
));

$loader->theme->setup_setting(array(
	"title"  => "Footer sign URL",
	"tip"    => "Enter full URL if you want link signature text",
	"type"   => "text",
	"hook"   => "sign_url",
	"valid"  => "url"
));

$loader->theme->setup_setting(array(
	"title"  => "Footer social link - Twitter",
	"tip"    => "Enter full URL if you want to display a link to this site",
	"type"   => "text",
	"hook"   => "sl_twitter",
	"valid"  => "url"
));

$loader->theme->setup_setting(array(
	"title"  => "Footer social link - Facebook",
	"tip"    => "Enter full URL if you want to display a link to this site",
	"type"   => "text",
	"hook"   => "sl_facebook",
	"valid"  => "url"
));

$loader->theme->setup_setting(array(
	"title"  => "Footer social link - Instagram",
	"tip"    => "Enter full URL if you want to display a link to this site",
	"type"   => "text",
	"hook"   => "sl_instagram",
	"valid"  => "url"
));

$loader->theme->setup_setting(array(
	"title"  => "Footer social link - Soundcloud",
	"tip"    => "Enter full URL if you want to display a link to this site",
	"type"   => "text",
	"hook"   => "sl_soundcloud",
	"valid"  => "url"
));

$loader->theme->setup_setting(array(
	"title"  => "Footer social link - Spotify",
	"tip"    => "Enter full URL if you want to display a link to this site",
	"type"   => "text",
	"hook"   => "sl_spotify",
	"valid"  => "url"
));

$loader->theme->setup_setting(array(
	"title"  => "Footer social link - Linkedin",
	"tip"    => "Enter full URL if you want to display a link to this site",
	"type"   => "text",
	"hook"   => "sl_linkedin",
	"valid"  => "url"
));

$loader->theme->setup_setting(array(
	"title"  => "Footer social link - Google",
	"tip"    => "Enter full URL if you want to display a link to this site",
	"type"   => "text",
	"hook"   => "sl_google",
	"valid"  => "url"
));

$loader->theme->setup_setting(array(
	"title"  => "`Term` page url",
	"tip"    => "If you want to link `Term` in sign-up page, edit this field",
	"type"   => "text",
	"hook"   => "term-link",
	"valid"  => "url",
));

$loader->theme->setup_setting(array(
	"title"  => "Javascript Codes",
	"tip"    => "If you need to insert third party or custom javascript, paste it here",
	"type"   => "textarea",
	"hook"   => "java",
	"valid"  => "html",
));

$loader->theme->add_advertisement_placements(array(
	"type" => "banner",
	"code" => "track_page",
	"size" => [
		"w" => 970,
		"h" => 90
	]
));

$loader->theme->add_advertisement_placements(array(
	"type" => "banner",
	"code" => "artist_page",
	"size" => [
		"w" => 970,
		"h" => 90
	]
));

$loader->theme->add_advertisement_placements(array(
	"type" => "banner",
	"code" => "album_page",
	"size" => [
		"w" => 970,
		"h" => 90
	]
));

$loader->theme->add_advertisement_placements(array(
	"type" => "banner",
	"code" => "playlist_page",
	"size" => [
		"w" => 970,
		"h" => 90
	]
));

?>
