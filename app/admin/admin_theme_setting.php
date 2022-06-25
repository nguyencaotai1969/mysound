<?php if ( !defined("root" ) ) die;
$loader->theme->set_name('__default')->loader->html->add_style( 'spectrum', 'assets/third/spectrum-1.8.1/spectrum.css' );
$loader->theme->set_name('__default')->loader->html->add_java( 'spectrum', 'assets/third/spectrum-1.8.1/spectrum.js' );
$loader->theme->set_name( $loader->admin->get_setting( "theme_name" ) )->load_setting( );
?>
<div class="box-title">
  <div class="icon"><span class="mdi mdi-wrench"></span></div>
  <div class="title">Theme <i>"<?php echo $loader->admin->get_setting( "theme_name" ); ?>"</i> Setting</div>
</div>
<div class="box">
<form method="post" class="be_cli_form" data-action="admin_save_theme_setting" data-target=".watermark" data-hasFile="true">
<?php
if ( !empty( $loader->theme->admin_setting ) ) :
foreach( $loader->theme->admin_setting as $as ) :
?>

  <div class="setting">
  <div class="row">
  	<div class="col-8">
  	  <div class="name"><?php echo $loader->secure->escape( $as["title"] ); ?></div>
  	  <div class="tip"><?php echo $loader->secure->escape( $as["tip"] ); ?></div>
  	</div>
  	<div class="col-4"><?php

		$as["value"]  = !empty( $as["value"] ) ? $as["value"] : $this->loader->theme->get_setting( $as["hook"] );
		$as["values"] = !empty( $as["values"] ) ? $as["values"] : null;
		$as["values"] = $as["values"] == "menus" ? [ "none" ] + $page_data : $as["values"];
		echo $loader->html->doms->create_input( $as["type"], $as["hook"], $as["value"], $as["values"] );

	?></div>
  </div>
  </div>

<?php
endforeach;
?>
  <div class="foot_buttons"><input type="submit" value="Save" class="btn btn-success btn-wide"></div>
<?php
endif;
?>
</form>
</div>
