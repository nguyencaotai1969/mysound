<?php

if ( !defined( "root" ) ) die;

$user = $loader->user->select(["ID"=>$this->ps["ID"]]);
if ( empty( $user ) ) $this->set_error( "invalid ID", true );

extract( $user, EXTR_PREFIX_ALL, "user" );

// Password change
if ( !empty( $this->ps["new_password"] ) ){

	$loader->user->set( $user["ID"] )->change_password( $this->ps["new_password"] );

}

// Username change
if ( $this->ps["username"] != $user["username"] ){

	$add = $loader->user->set( $user["ID"] )->data()->change_username( $this->ps["username"] );

	if ( $add !== true )
		$this->set_error( $add );

}

// Email change
if ( $this->ps["email"] != $user["email"] ){

	$add = $loader->user->set( $user["ID"] )->data()->change_email( $this->ps["email"], false );

	if ( $add !== true )
		$this->set_error( $add );

}

// Group change
if ( $this->ps["group"] != $user["GID"] ){

	// validate group
	if ( empty( $loader->user->group_select(["ID"=>$this->ps["group"]] ) ) ||
		in_array( $this->ps["group"], [ 2, 3, 5 ] ) )
		$this->set_error( "invalid_group", true );

	$user_GID = $this->ps["group"];

}

// Avatar change
if ( $sent_avatar = $loader->secure->get( "file", "avatar" ) ){

	$verify_and_copy_image = $loader->general->save_image( $sent_avatar["tmp_name"], array(
		"input_ext"  => $sent_avatar["extension"],
		"output_ext" => $sent_avatar["extension"],
		"min_width"  => 200,
		"min_height" => 200,
		"dirname"  => "uploaded_avatars"
	));

	if ( empty( $verify_and_copy_image ) ){
		$this->set_error( "invalid_image", true );
	}

	$resize_image = $loader->image
	->set( $verify_and_copy_image )
	->resize([
		"max_width"  => 800,
		"max_height" => 800,
		"min_width"  => 200,
		"min_height" => 200,
		"remove_src" => true
	])
	->square()
	->get([
		"input_ext"  => $sent_avatar["extension"],
		"output_ext" => $sent_avatar["extension"],
		"basename" => $loader->general->image_dir,
		"dirname"  => "uploaded_avatars"
	]);

	if ( !empty( $resize_image ) ){
		$user_avatar = $loader->general->path_to_addr( $resize_image );
		if ( !empty( $user["avatar_o"] ) )
		$loader->general->remove_file( $user["avatar_o"] );
	}

}

$user_name = $this->ps["name"];
$user_fund = $this->ps["fund"] ? $this->ps["fund"] : 0;
$user_time_paid_expire = $this->ps["time_paid_expire"] ? $this->ps["time_paid_expire"] : null;

$loader->db->_update([
	"table" => "_users",
	"where" => [
	    "oper" => "AND",
	    "cond" => [
	        [ "ID", "=", $user["ID"] ]
        ],
    ],
	"set" => [
	    [ "name", $user_name ],
	    [ "fund", $user_fund ],
	    [ "time_paid_expire", $user_time_paid_expire ],
	    [ "GID", $user_GID ],
	    [ "avatar", $user_avatar ]
    ]
]);

$this->set_response( "done" );

?>
