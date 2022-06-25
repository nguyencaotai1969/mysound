<?php

if ( !defined( "root" ) ) die;

$page_data["pages"] = $this->loader->ui->load_pages( false );
$page_data["html"] = [];

if ( $reqed_page = $loader->secure->get( "get", "name", "string", [ "strict" => true ] ) ){
	foreach( $page_data["pages"] as $_page ){
		if ( $_page["name"] == $reqed_page ){

			$items = array_values( $this->loader->ui->load_page( $_page["ID"] ) );
			$new_items = [];
			foreach( $items as $i => $item ){

				if ( !empty( $item["sett"]["wID"] ) ){
					$item["sett"]["wid"] = $item["sett"]["wID"];
					unset( $item["sett"]["wID"] );
				}

				$item["sett"]["wid"] = empty( $item["sett"]["wid"] ) ? substr( md5( uniqid() ), 0, 8 ) : $item["sett"]["wid"];

				$new_items[ $item["sett"]["wid"] ] = [
					"type" => $item["type"],
					"sett" => $item["sett"],
				];

			}

			$page_data["active"] = $_page;
			$page_data["items"]  = $this->loader->general->json_encode( $new_items, false );

		}
	}
}

$page_data["_pages"] = $page_data["pages"];

usort( $page_data["pages"], function ($item1, $item2) {
	return strcmp( $item1['name'], $item2['name'] );
});

$this->set_page_data( $page_data );

$loader->html->set_title( "Page Builder" );

?>
