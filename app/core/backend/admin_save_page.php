<?php

if ( !defined( "root" ) ) die;

$this->ps["name"] = strtolower( $this->ps["name"] );
$this->loader->ui->set_page_data();
$page_data = $this->loader->ui->page_data;

// Check sent page name
foreach( $page_data["pages"] as $_page ){
	if ( $_page["name"] == $this->ps["name"] ){
		$existing_page = $_page;
		$page_ID = $existing_page["ID"];
	}
}

// Check sent page data
$data = $this->ps["data"];
if ( empty( $data ) ? true : !is_array( $data ) ) die;

// Verify widgets
foreach( $data as $wID => $widget_data ){

	$verify_widget_data = $loader->ui->verify_page_widget( $widget_data );
	if ( !is_array( $verify_widget_data ) ){

		$widget_title = "An untitled widget";
		$widget_error = "has a problem";

		if ( !empty( $widget_data["sett"]["title"] ) )
			$widget_title = $widget_data["sett"]["title"];

		if ( is_string( $verify_widget_data ) )
			$widget_error .= ": {$verify_widget_data}";

		$this->set_error( "{$widget_title} {$widget_error}. Fix the problem then retry please" );

	}

	$widget_data["title"] = $verify_widget_data["title"];
	$widget_data["sett"] = $verify_widget_data;
	$data[ $wID ] = $widget_data;

}

// Check sent page url
if ( empty( $existing_page ) ? true : $existing_page["url"] != $this->ps["url"] ){
	if ( $this->loader->ui->curl( "page", $this->ps["url"], true ) !== false ){
		$this->set_error( "This url exists" );
	}
}

// Create/update page
if ( empty( $existing_page ) ){

	$stmt = $this->db->prepare( "INSERT INTO _setting_page ( name, url ) VALUES ( ?, ? )" );
	$stmt->bind_param( "ss", $this->ps["name"], $this->ps["url"] );
	$stmt->execute();
	$page_ID = $stmt->insert_id;
	$stmt->close();

}
else {

	$stmt = $this->db->prepare( "UPDATE _setting_page SET url = ? WHERE ID = ?" );
	$stmt->bind_param( "ss", $this->ps["url"], $existing_page["ID"] );
	$stmt->execute();
	$stmt->close();

	$pre_existing_widgets = $this->db->_select([
		"table" => "_setting_page_widgets",
		"where" => [
			[ "page_id", "=", $page_ID ]
		],
		"limit" => 200,
		"singular" => false
	]);

	if ( !empty( $pre_existing_widgets ) ){
		foreach( $pre_existing_widgets as $i => $pre_existing_widget ){

			if ( empty( $pre_existing_widget["widget_setting"] ) ) continue;
			$pre_existing_widget_setting = json_decode( $pre_existing_widget["widget_setting"], 1 );
			if ( empty( $pre_existing_widget_setting ) ) continue;
			if ( empty( $pre_existing_widget_setting["wid"] ) ) continue;

			unset( $pre_existing_widgets[ $i ] );
			$pre_existing_widgets[ $pre_existing_widget_setting["wid"] ] = $pre_existing_widget;

		}
	}

}

// Create sent page url
if ( empty( $existing_page ) ? true : $existing_page["url"] != $this->ps["url"] ){

	$this->loader->ui->murl(
		"page",
		$this->ps["url"],
		$page_ID
	);

}

$order = 1;
foreach( $data as $_wd ){

	if ( empty( $_wd["sett"]["wid"] ) ) die;
	$__wID = $_wd["sett"]["wid"];
	$_wd["sett"] = json_encode( $_wd["sett"] );

	if ( !empty( $pre_existing_widgets ) ? in_array( $__wID, array_keys( $pre_existing_widgets ), true ) : false ){

		$stmt = $this->db->prepare("UPDATE _setting_page_widgets SET widget_order=?, widget_type=?, widget_title=?, widget_setting=? WHERE page_id = ? AND ID = ? ");
	    $stmt->bind_param( "ssssss", $order, $_wd["type"], $_wd["title"], $_wd["sett"], $page_ID, $pre_existing_widgets[ $__wID ]["ID"] );
	    $stmt->execute();
	    $stmt->close();
		unset( $pre_existing_widgets[ $__wID ] );

	} else {

		$stmt = $this->db->prepare("INSERT INTO _setting_page_widgets ( page_id, widget_order, widget_type, widget_title, widget_setting ) VALUES ( ?, ?, ?, ?, ? ) ");
	    $stmt->bind_param( "sssss", $page_ID, $order, $_wd["type"], $_wd["title"], $_wd["sett"] );
	    $stmt->execute();
	    $stmt->close();

	}

	$order++;

}

if ( !empty( $pre_existing_widgets ) ){
	foreach( $pre_existing_widgets as $pre_existing_widget_unwanted ){
		$this->db->query("DELETE FROM _setting_page_widgets WHERE page_id = '{$page_ID}' AND ID = '{$pre_existing_widget_unwanted["ID"]}' ");
	}
}

$this->db->query("OPTIMIZE TABLE _setting_page_widgets");

$this->set_response( "Saved" );

?>
