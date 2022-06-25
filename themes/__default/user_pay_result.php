<?php if ( !defined("root" ) ) die; ?>
<div class="container" id="not_found">

  <img alt="wallet" src="<?php echo $loader->theme->set_name('__default')->addr; ?>assets/icons/wallet.png">
  <div class="title"><?php $loader->lorem->eturn( 'payment', [ "uc" => true ] ); ?> <?php echo $page_data["paid"] ? "<span class='badge badge-success'>{$loader->lorem->turn( 'successful', [ "uc" => true ] )}</span>" : "<span class='badge badge-danger'>{$loader->lorem->turn( 'failed', [ "uc" => true ] )}</span>" ; ?></div>
  <div class="detail">
    <?php
	if ( $page_data["completed"] ){
		$loader->lorem->eturn( "pay_done", [ "params" => [ "amount" => $loader->general->display_price( $page_data["amount"], true ) ] ] );
    }
	elseif ( $page_data["paid"] ) {
		$loader->lorem->eturn( "pay_pending", [ "params" => [ "amount" => $loader->general->display_price( $page_data["amount"], true ) ] ] );
	}
	else {
		$loader->lorem->eturn( "pay_fail", [ "params" => [ "amount" => $loader->general->display_price( $page_data["amount"], true ) ] ] );
	}
	?>
  </div>
  <div class="button"><a href="<?php $loader->ui->eurl( "index" ) ?>" class="btn btn-primary"><?php $loader->lorem->eturn( "404_goback" ); ?></a></div>

</div>
