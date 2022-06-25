<?php

if ( !defined( "root" ) ) die;

$group = $loader->user->group_select(["ID"=>$this->ps["ID"]]);
if ( empty( $group ) ) $this->set_error( "invalid_ID", true );
$loader->user->group_delete( $group );
$this->set_response( "done" );

?>