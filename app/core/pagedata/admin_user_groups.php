<?php

if ( !defined( "root" ) ) die;

// get groups
$groups = [];
$get_groups = $loader->db->query("SELECT ID FROM _user_groups");
while( $group = $get_groups->fetch_assoc() ){
	$groups[ $group["ID"] ] = $loader->user->get_group_data( $group["ID"] );
}

$requested_group_ID = $loader->secure->get( "get", "GID", "int" );

$this->set_page_data([
	"groups" => $groups,
	"group"  => !$requested_group_ID ? null : ( in_array( $requested_group_ID, array_keys( $groups ) ) && $requested_group_ID ? $groups[ $requested_group_ID ] : null )
]);

$loader->html->set_title( "Manage User Groups" );

?>