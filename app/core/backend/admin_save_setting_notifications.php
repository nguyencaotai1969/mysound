<?php

if ( !defined( "root" ) ) die;

$admin_ids = $this->ps["admin_ids"];
foreach( explode( ",", $admin_ids ) as $_admin_id ){
  if ( !$loader->secure->validate( $_admin_id, "int" ) )
  $this->set_error("invalid_admin_id");
  if ( !$loader->user->select(["ID"=>$_admin_id]) )
  $this->set_error("invalid_admin_id");
}
$loader->admin->save_setting("admin_ids",$this->ps["admin_ids"]);

$notifications = $loader->user->getActions(["admin"=>true]);
foreach( $notifications as $_not ){

  if ( !empty( $_not["detail_receiver"] ) || !empty( $_not["admin"] ) ){
    $_nots_allowed[ "nots" ][] = $_not["type"];
    $_nots_allowed[ "emails" ][] = $_not["type"];
  }

  if ( !empty( $_not["detail_doer"] ) ){
    $_nots_allowed[ "acts" ][] = $_not["type"];
    $_nots_allowed[ "feeds" ][] = $_not["type"];
  }

}

$uas = [];
foreach( [ "not", "act", "feed", "email" ] as $__t ){
  foreach( explode( ",", $this->ps["ua_{$__t}s"] ) as $_not_id ){

    if ( !in_array( $_not_id, $_nots_allowed["{$__t}s"] ) )
    $this->set_error("invalid_request",true);

    $uas[ $__t ][] = $_not_id;

  }

  if ( empty( $uas[ $__t ] ) )
  $this->set_error("invalid_request",true);

  $_val = implode( ",", $uas[ $__t ] );
  $loader->admin->save_setting( "ua_{$__t}", $_val );

}

$this->set_response( "done" );

?>
