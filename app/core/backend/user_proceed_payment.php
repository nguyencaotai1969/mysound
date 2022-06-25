<?php

if ( !defined( "root" ) ) die;

$gt_name = $this->ps["name"];
$order_no = $loader->pay->record_payment( $this->ps["amount"], $gt_name );

if ( $gt_name == "kkiapay" || $gt_name == "flutterwave" )
$getLink = [ "sta" => true, "data" => $order_no ];
else
$getLink = $loader->pay->og_get_link( $gt_name, $this->ps["amount"], $order_no );

if ( !$getLink["sta"] )
$this->set_error( $getLink["data"] );
else {
  if ( !empty( $getLink["extraData"] ) ){
    foreach( $getLink["extraData"] as $_k => $_v )
    $loader->pay->record_add_data( $order_no, $_k, $_v );
  }
  $this->set_response( $getLink["data"], false, false, true );
}

?>
