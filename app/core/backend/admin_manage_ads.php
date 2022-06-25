<?php

if ( !defined( "root" ) ) die;

// validate hook
$ad = $loader->ads->select(["ID"=>$this->ps["hook"]]);
if ( empty( $ad ) ) $this->set_error( "invalid_hook", true );

// validate sta
$do_able_actions_per_sta = array(
	-2 => [ -1 ],
	-1 => null,
	0  => [ 1, -2 ],
	1  => [ 2 ],
	2  => [ 1, -1 ]
);
if ( !in_array( $this->ps["sta"], array_keys( $do_able_actions_per_sta ) ) )
$this->set_error( "invalid_sta", true );
$do_able_actions = $do_able_actions_per_sta[ $ad["active"] ];
if ( empty( $do_able_actions ) ? true : !in_array( $this->ps["sta"], $do_able_actions ) )
$this->set_error( "invalid_sta", true );

// Activate Pending Ad
if ( $ad["active"] == 0 ? $this->ps["sta"] == 1 : false ){
	$loader->ads->exe_approve( $ad["ID"] );
}
// Reject Pending Ad
if ( $ad["active"] == 0 ? $this->ps["sta"] == -2 : false ){
	$loader->ads->exe_reject( $ad["ID"] );
}
// Pause Active Ad
if ( $ad["active"] == 1 ? $this->ps["sta"] == 2 : false ){
	$loader->ads->exe_pause( $ad["ID"] );
}
// Resume Paused Ad
if ( $ad["active"] == 2 ? $this->ps["sta"] == 1 : false ){
	$loader->ads->exe_resume( $ad["ID"] );
}
// Removed Paused Ad
if ( $ad["active"] == 2 || $ad["active"] == -2 ? $this->ps["sta"] == -1 : false ){
	$loader->ads->exe_remove( $ad["ID"] );
}

$this->set_response( "done" );

?>
