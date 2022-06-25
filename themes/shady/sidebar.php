<?php if ( !defined("root" ) ) die; ?>
<div id="sidebar">
  <div id="logo">
  	<a href="<?php $loader->ui->eurl( "index" ) ?>">
  	  <img alt="logo" src="<?php echo $loader->general->path_to_addr( $loader->theme->set_name()->get_setting( "logo" ) ); ?>">
  	</a>
  </div>
<?php
$loader->ui->display_menu( $loader->theme->set_name()->get_setting( $loader->hit->agent_data["device"]["type"] == "mobile" ? "m_sm" : "m_s" ), [], [
  [
		"icon"  => "magnify",
		"class" => "sos search",
		"page"  => "search",
		"title" => $loader->lorem->turn( "search" )
	],
	[
		"icon"  => "account",
		"class" => "sos account has-child",
		"page"  => "",
		"title" => $loader->lorem->turn( "account" ),
		"items" => [
			[
				"icon" => "lock-open",
				"page" => "user_login",
				"title" => $loader->lorem->turn( "login" ),
			],
			[
				"icon" => "star",
				"page" => "user_signup",
				"title" => $loader->lorem->turn( "signup" ),
			]
		]
	]
], $loader->hit->agent_data["device"]["type"] == "mobile" ? 3 : null );
?>
</div>
<div id="main">
<div id="scroller">
