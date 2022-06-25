<?php

if ( !defined( "root" ) ) die;

$loader->html->set_title( "Setting - Notifications" );

$notifications = $loader->user->getActions(["admin_setting"=>true,"admin"=>true]);
usort( $notifications, function($a, $b) {

  $a["doer"] = empty( $a["detail_doer"] ) ? 0 : 1;
  $b["doer"] = empty( $b["detail_doer"] ) ? 0 : 1;
  $a["receiver"] = empty( $a["detail_receiver"] ) ? 0 : 1;
  $b["receiver"] = empty( $b["detail_receiver"] ) ? 0 : 1;

  return
  ( $a['doer'] - $b['doer'] ) -
  ( $a['receiver'] - $b['receiver'] );

});

$this->set_page_data(array(
  "notifications" => $notifications
));

?>
