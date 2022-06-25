<?php

if ( !defined( "root" ) ) die;

$loader->theme->set_name( $loader->admin->get_setting( "theme_name" ) )->load_setting();

if ( !empty( $loader->theme->admin_setting ) ) :
foreach( $loader->theme->admin_setting as $as ) :

  $as["valid"] = $as["valid"] == "menus" ? array_merge( [0], array_keys( $loader->ui->load_menus( false ) ) ) : $as["valid"];

  if ( $as["type"] != "image" && isset( $_POST[ $as["hook"] ] ) ){

	  $presented_value = $_POST[ $as["hook"] ];

	  if ( $as["type"] == "select" ){

		  $presented_value = intval( $presented_value );
		  if ( $loader->secure->validate( $presented_value, "in_array", [ "values" => $as["valid"] ] ) )
			  $loader->theme->save_setting( $as["hook"], $presented_value );

	  }
    elseif ( $as["type"] == "color_selector" ){

		  if ( $loader->secure->validate( $presented_value, "string_color_hex" ) )
			  $loader->theme->save_setting( $as["hook"], substr( $presented_value, 1 ) );

	  }
    elseif ( $as["valid"] == "string" ){

		  if ( $loader->secure->validate( $presented_value, "string", [ "empty()" ] ) )
			  $loader->theme->save_setting( $as["hook"], $presented_value );

	  }
    elseif ( $as["valid"] == "url" ){

		  if ( $loader->secure->validate( $presented_value, "url", [ "empty()" ] ) )
			  $loader->theme->save_setting( $as["hook"], $presented_value );

	  }
    elseif ( $as["valid"] == "html" ){
			  $loader->theme->save_setting( $as["hook"], $presented_value );
	  }

  }

  if ( $as["type"] == "image" ? ( $sent_image = $loader->secure->get( "file", $as["hook"] ) ) : false ){

	  $verify_and_copy_image = $loader->general->save_image( $sent_image["tmp_name"], array(
		  "input_ext"  => $sent_image["extension"],
		  "output_ext" => $sent_image["extension"],
		  "basename"   => $loader->general->image_dir,
		  "dirname"    => "admin",
      "final"      => true
	  ));

	  if ( $verify_and_copy_image ){
		 $loader->theme->save_setting( $as["hook"], $verify_and_copy_image );
	  }

  }


endforeach;
endif;

$this->set_response( "done" );

?>
