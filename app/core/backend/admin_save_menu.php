<?php

if ( !defined( "root" ) ) die;

$name = $this->ps["name"];
$data = $this->ps["data"];

if ( !is_array( $data ) or empty( $data ) ) $this->set_error("invalid_data");

$verified_data = [];
foreach( $data as $_d ){
	
	if ( !is_array( $_d ) ) $this->set_error( "invalid_data", true );
	if ( count( $_d ) != 4 ) $this->set_error( "invalid_data", true );
	
	if ( empty( $_d["title"] ) ? true : !$loader->secure->validate( $_d["title"], "string" ) ) $this->set_error( "Title can't be empty" );
	if ( !isset( $_d["page"] ) ? true : !$loader->secure->validate( $_d["page"], "string", [ "empty()" ] ) ) $this->set_error( "Link address can't be empty" );
	if ( empty( $_d["icon"] ) ? true : !$loader->secure->validate( $_d["icon"], "string", [ "strict" => true, "strict_regex" => "[0-9a-z_-]" ] ) ) $this->set_error( "Icon is invalid/empty" );
	if ( !isset( $_d["items"] ) ) $this->set_error( "invalid_data", true );
	
	$__m = array(
		"title" => $_d["title"],
		"page"  => $_d["page"],
		"icon"  => $_d["icon"],
    );
	
	if ( !empty( $_d["items"] ) ? is_array( $_d["items"] ) : false ){
		foreach( $_d["items"] as $_i ){
			
			if ( count( $_i ) != 3 ) $this->set_error( "invalid_data", true );
			if ( empty( $_i["title"] ) ? true : !$loader->secure->validate( $_i["title"], "string" ) ) $this->set_error( "Title can't be empty" );
	        if ( !isset( $_i["page"] ) ? true : !$loader->secure->validate( $_i["page"], "string", [ "empty()" ] ) ) $this->set_error( "Link address can't be empty" );
	        if ( empty( $_i["icon"] ) ? true : !$loader->secure->validate( $_i["icon"], "string", [ "strict" => true, "strict_regex" => "[0-9a-z_-]" ] ) ) $this->set_error( "Icon is invalid/empty" );
			
			$__m["items"][] = array(
				"title" => $_i["title"],
				"page"  => $_i["page"],
				"icon"  => $_i["icon"]
			);
			
		}
	}
	
	$verified_data[] = $_d;
	
}
$verified_data = json_encode( $verified_data );

$loader->ui->save_menu( $name, $verified_data );
$this->set_response( "Saved" );

?>