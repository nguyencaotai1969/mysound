<?php if ( !defined("root" ) ) die;
$demo = defined( "demo" ) ? demo && $loader->visitor->user()->ID != 1 : false; ?>
<div class="box-title">
  <div class="icon"><span class="mdi mdi-credit-card-outline"></span></div>
  <div class="title">Commercial Setting</div>
</div>
<div class="box">
<form method="post" class="be_cli_form" data-action="admin_save_setting_pay" data-target=".watermark">

  <div class="setting">
  <div class="row">
  	<div class="col-6">
  	  <div class="name">Currency</div>
  	  <div class="tip">The symbol of your website currency</div>
  	</div>
  	<div class="col-6"><?php echo $loader->html->doms->create_input( "text", "currency", $loader->admin->get_setting( "currency", "$" ) ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-6">
  	  <div class="name">Currency Code</div>
  	  <div class="tip">The code of your website currency</div>
  	</div>
  	<div class="col-6"><?php echo $loader->html->doms->create_input( "text", "currency_code", $loader->admin->get_setting( "currency_code", "usd" ) ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-6">
  	  <div class="name">Currency Display Format</div>
  	  <div class="tip">%CURRENCY% will be replaced with currency. The rest is <a href='https://www.php.net/manual/en/function.sprintf.php'>sprintf format</a> for price number</div>
  	</div>
  	<div class="col-6"><?php echo $loader->html->doms->create_input( "text", "currency_format", $loader->admin->get_setting( "currency_format", "%CURRENCY%%.2f" ) ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-6">
  	  <div class="name">Sell prices</div>
  	  <div class="tip">Users who have access to 'Sell' feature can select one of these prices for their uploaded tracks. Seperate prices by comma</div>
  	</div>
  	<div class="col-6"><?php echo $loader->html->doms->create_input( "text", "sell_music_prices", $loader->admin->get_setting( "sell_music_prices", 1 ) ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-6">
  	  <div class="name">`Paid` plan monthly subscription price</div>
  	  <div class="tip">The price that user have to pay in order to get access to `Paid` plan features for a month</div>
  	</div>
  	<div class="col-6"><?php echo $loader->html->doms->create_input( "digit", "upgrade_price", $loader->admin->get_setting( "upgrade_price", 1 ) ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-6">
  	  <div class="name">Minimum withraw amount for artists</div>
  	  <div class="tip">The least amount of fund that can be requested for withraw by artists or users who have access to sell</div>
  	</div>
  	<div class="col-6"><?php echo $loader->html->doms->create_input( "digit", "withdrawal_min", $loader->admin->get_setting( "withdrawal_min", 1 ) ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-6">
  	  <div class="name">Online payments auto approve</div>
  	  <div class="tip">If you need to approve online payments before giving users the funds, uncheck this box. If left checked, system will approve payments after calling gateway API</div>
  	</div>
  	<div class="col-6"><?php echo $loader->html->doms->create_input( "check", "og_approved", $loader->admin->get_setting( "og_approved", 1 ) ) ?></div>
  </div>
  </div>

  <div class="head">
  <div class="row">
    <div class="col-12"><span class="mdi mdi-star"></span>Advertisement</div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-6">
  	  <div class="name">Google AdSense Code</div>
  	  <div class="tip">If you want to display Google Adsense in your website with "Auto Ads" enabled, paste your <a href='https://support.google.com/adsense/answer/9274019?hl=en&ref_topic=28893' target='_blank'>Google Adsense code ( click for more info )</a> here. If you wish to use Google adsense "Ads Unit" instead of "Auto Ads", use Admin -> Commercial -> Advertisement </div>
  	</div>
  	<div class="col-6"><?php echo $loader->html->doms->create_input( "textarea", "adsense", $loader->admin->get_setting( "adsense" ) ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-6">
  	  <div class="name">Banner impression cost</div>
  	  <div class="tip">How much do you want to charge everytime you show a banner ad to a visitor?</div>
  	</div>
  	<div class="col-6"><?php echo $loader->html->doms->create_input( "digit", "banner_v_cost", $loader->admin->get_setting( "banner_v_cost" ) ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-6">
  	  <div class="name">Banner click cost</div>
  	  <div class="tip">How much do you want to charge everytime a banner ad gets clicked by a visitor?</div>
  	</div>
  	<div class="col-6"><?php echo $loader->html->doms->create_input( "digit", "banner_c_cost", $loader->admin->get_setting( "banner_c_cost" ) ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-6">
  	  <div class="name">Audio impression cost</div>
  	  <div class="tip">How much do you want to charge everytime you play an audio ad for a visitor?</div>
  	</div>
  	<div class="col-6"><?php echo $loader->html->doms->create_input( "digit", "audio_v_cost", $loader->admin->get_setting( "audio_v_cost" ) ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-6">
  	  <div class="name">Audio ad interval</div>
  	  <div class="tip">How often do you want to play audio ads for users? Enter in minutes</div>
  	</div>
  	<div class="col-6"><?php echo $loader->html->doms->create_input( "digit", "ad_audio_iv", $loader->admin->get_setting( "ad_audio_iv" ) ) ?></div>
  </div>
  </div>

  <div class="head">
  <div class="row">
    <div class="col-12"><span class="mdi mdi-bank"></span>Offline Purchase</div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-6">
  	  <div class="name">Enable</div>
  	  <div class="tip">Do you want to enable offline bank transfer?<br>Users will receive your bank information, transfer the money then upload the receipt. If you approve that receipt user will have his funds up</div>
  	</div>
  	<div class="col-6"><?php echo $loader->html->doms->create_input( "check", "pg_op", $loader->admin->get_setting( "pg_op" ) ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-6">
  	  <div class="name">Bank information</div>
  	  <div class="tip">Your bank information to be displayed in `add funds by bank transfer` page</div>
  	</div>
  	<div class="col-6"><?php echo $loader->html->doms->create_input( "textarea", "bank_data", $loader->admin->get_setting( "bank_data" ) ) ?></div>
  </div>
  </div>

  <div class="head">
  <div class="row">
    <div class="col-12"><span class="mdi mdi-credit-card-outline"></span>Coinpayments</div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-6">
  	  <div class="name">Enable</div>
  	  <div class="tip">Do you want to enable Coinpayments.net as a payment gateway?</div>
  	</div>
  	<div class="col-6"><?php echo $loader->html->doms->create_input( "check", "pg_cp", $loader->admin->get_setting( "pg_cp" ) ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-6">
  	  <div class="name">Public Key</div>
  	  <div class="tip">Coinpayments Public Key ( Create <a href='https://www.coinpayments.net/acct-api-keys'>here</a>. Don't forget to enable <b>create_transaction</b> and <b>get_tx_info</b> access for this API )</div>
  	</div>
  	<div class="col-6"><?php echo $loader->html->doms->create_input( "text", "pg_cp_k1", $demo ? "********" : $loader->admin->get_setting( "pg_cp_k1" ) ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-6">
  	  <div class="name">Private Key</div>
  	  <div class="tip">Coinpayments Private Key</div>
  	</div>
  	<div class="col-6"><?php echo $loader->html->doms->create_input( "text", "pg_cp_k2", $demo ? "********" : $loader->admin->get_setting( "pg_cp_k2" ) ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-6">
  	  <div class="name">IPN Secret</div>
  	  <div class="tip">Coinpayments IPN Secret ( Create <a href='https://www.coinpayments.net/acct-settings'>here</a> )</div>
  	</div>
    <div class="col-6"><?php echo $loader->html->doms->create_input( "text", "pg_cp_k3", $demo ? "********" : $loader->admin->get_setting( "pg_cp_k3" ) ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-6">
  	  <div class="name">Merchant ID</div>
  	  <div class="tip">Coinpayments Merchant ID ( Visible <a href='https://www.coinpayments.net/acct-settings'>here</a> )</div>
  	</div>
    <div class="col-6"><?php echo $loader->html->doms->create_input( "text", "pg_cp_k4", $demo ? "********" : $loader->admin->get_setting( "pg_cp_k4" ) ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-6">
  	  <div class="name">Accepted Coin</div>
  	  <div class="tip">Coinpayments accepted coin ( Enable coin <a href='https://www.coinpayments.net/acct-coins'>here</a> )</div>
  	</div>
    <div class="col-6"><?php echo $loader->html->doms->create_input( "select", "pg_cp_cr", $loader->admin->get_setting( "pg_cp_cr" ), $loader->pay->og( "coinpayments" )->getCurrencies() ) ?></div>
  </div>
  </div>

  <div class="head">
  <div class="row">
    <div class="col-12"><span class="mdi mdi-credit-card-outline"></span>Paypal</div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-6">
  	  <div class="name">Enable</div>
  	  <div class="tip">Do you want to enable Paypal as a payment gateway?</div>
  	</div>
  	<div class="col-6"><?php echo $loader->html->doms->create_input( "check", "pg_pp", $loader->admin->get_setting( "pg_pp" ) ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-6">
  	  <div class="name">Mode</div>
  	  <div class="tip">Sandbox allows you to test everything before going live</div>
  	</div>
  	<div class="col-6"><?php echo $loader->html->doms->create_input( "select", "pg_pp_sb", $loader->admin->get_setting( "pg_pp_sb" ), [ "live" => "live", "sandbox" => "sandbox" ] ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-6">
  	  <div class="name">Key</div>
  	  <div class="tip">Paypal Key</div>
  	</div>
  	<div class="col-6"><?php echo $loader->html->doms->create_input( "text", "pg_pp_k1", $demo ? "********" : $loader->admin->get_setting( "pg_pp_k1" ) ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-6">
  	  <div class="name">Secret</div>
  	  <div class="tip">Paypal secret</div>
  	</div>
  	<div class="col-6"><?php echo $loader->html->doms->create_input( "text", "pg_pp_k2", $demo ? "********" : $loader->admin->get_setting( "pg_pp_k2" ) ) ?></div>
  </div>
  </div>

  <div class="head">
  <div class="row">
    <div class="col-12"><span class="mdi mdi-credit-card-outline"></span>Stripe</div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-6">
  	  <div class="name">Enable</div>
  	  <div class="tip">Do you want to enable Stripe as a payment gateway?</div>
  	</div>
  	<div class="col-6"><?php echo $loader->html->doms->create_input( "check", "pg_st", $loader->admin->get_setting( "pg_st" ) ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-6">
  	  <div class="name">Key</div>
  	  <div class="tip">Stripe Key</div>
  	</div>
  	<div class="col-6"><?php echo $loader->html->doms->create_input( "text", "pg_st_k1", $demo ? "********" : $loader->admin->get_setting( "pg_st_k1" ) ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-6">
  	  <div class="name">Secret</div>
  	  <div class="tip">Stripe secret</div>
  	</div>
  	<div class="col-6"><?php echo $loader->html->doms->create_input( "text", "pg_st_k2", $demo ? "********" : $loader->admin->get_setting( "pg_st_k2" ) ) ?></div>
  </div>
  </div>

  <div class="head">
  <div class="row">
    <div class="col-12"><span class="mdi mdi-credit-card-outline"></span>Paystack</div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-6">
  	  <div class="name">Enable</div>
  	  <div class="tip">Do you want to enable Paystack as a payment gateway?</div>
  	</div>
  	<div class="col-6"><?php echo $loader->html->doms->create_input( "check", "pg_ps", $loader->admin->get_setting( "pg_ps" ) ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-6">
  	  <div class="name">Public Key</div>
  	  <div class="tip">Paystack Public Key</div>
  	</div>
  	<div class="col-6"><?php echo $loader->html->doms->create_input( "text", "pg_ps_k1", $demo ? "********" : $loader->admin->get_setting( "pg_ps_k1" ) ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-6">
  	  <div class="name">Secret Key</div>
  	  <div class="tip">Paystack Secret Key</div>
  	</div>
  	<div class="col-6"><?php echo $loader->html->doms->create_input( "text", "pg_ps_k2", $demo ? "********" : $loader->admin->get_setting( "pg_ps_k2" ) ) ?></div>
  </div>
  </div>

  <div class="head">
  <div class="row">
    <div class="col-12"><span class="mdi mdi-credit-card-outline"></span>KKiaPay</div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-6">
  	  <div class="name">Enable</div>
  	  <div class="tip">Do you want to enable KKiaPay as a payment gateway?</div>
  	</div>
  	<div class="col-6"><?php echo $loader->html->doms->create_input( "check", "pg_kk", $loader->admin->get_setting( "pg_kk" ) ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
    <div class="col-6">
      <div class="name">Mode</div>
      <div class="tip">Sandbox allows you to test everything before going live</div>
    </div>
    <div class="col-6"><?php echo $loader->html->doms->create_input( "select", "pg_kk_sb", $loader->admin->get_setting( "pg_kk_sb" ), [ "live" => "live", "sandbox" => "sandbox" ] ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-6">
  	  <div class="name">Public API Key</div>
  	  <div class="tip">KKiaPay Public API Key</div>
  	</div>
  	<div class="col-6"><?php echo $loader->html->doms->create_input( "text", "pg_kk_k1", $demo ? "********" : $loader->admin->get_setting( "pg_kk_k1" ) ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-6">
  	  <div class="name">Private Api Key</div>
  	  <div class="tip">KKiaPay Private Api Key</div>
  	</div>
  	<div class="col-6"><?php echo $loader->html->doms->create_input( "text", "pg_kk_k2", $demo ? "********" : $loader->admin->get_setting( "pg_kk_k2" ) ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-6">
  	  <div class="name">Secret</div>
  	  <div class="tip">KKiaPay secret</div>
  	</div>
  	<div class="col-6"><?php echo $loader->html->doms->create_input( "text", "pg_kk_k3", $demo ? "********" : $loader->admin->get_setting( "pg_kk_k3" ) ) ?></div>
  </div>
  </div>

  <div class="head">
  <div class="row">
    <div class="col-12"><span class="mdi mdi-credit-card-outline"></span>Flutterwave</div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-6">
  	  <div class="name">Enable</div>
  	  <div class="tip">Do you want to enable Flutterwave as a payment gateway?</div>
  	</div>
  	<div class="col-6"><?php echo $loader->html->doms->create_input( "check", "pg_fw", $loader->admin->get_setting( "pg_fw" ) ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
    <div class="col-6">
      <div class="name">Mode</div>
      <div class="tip">Sandbox allows you to test everything before going live</div>
    </div>
    <div class="col-6"><?php echo $loader->html->doms->create_input( "select", "pg_fw_sb", $loader->admin->get_setting( "pg_fw_sb" ), [ "live" => "live", "sandbox" => "sandbox" ] ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-6">
  	  <div class="name">Public Key</div>
  	  <div class="tip">Fluterwave public key</div>
  	</div>
  	<div class="col-6"><?php echo $loader->html->doms->create_input( "text", "pg_fw_k1", $demo ? "********" : $loader->admin->get_setting( "pg_fw_k1" ) ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-6">
  	  <div class="name">Secret Key</div>
  	  <div class="tip">Fluterwave secret key</div>
  	</div>
  	<div class="col-6"><?php echo $loader->html->doms->create_input( "text", "pg_fw_k2", $demo ? "********" : $loader->admin->get_setting( "pg_fw_k2" ) ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-6">
  	  <div class="name">Encryption Key</div>
  	  <div class="tip">Fluterwave encryption key</div>
  	</div>
  	<div class="col-6"><?php echo $loader->html->doms->create_input( "text", "pg_fw_k3", $demo ? "********" : $loader->admin->get_setting( "pg_fw_k3" ) ) ?></div>
  </div>
  </div>

  <div class="head">
  <div class="row">
    <div class="col-12"><span class="mdi mdi-credit-card-outline"></span>Razorpay</div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-6">
  	  <div class="name">Enable</div>
  	  <div class="tip">Do you want to enable Razorpay as a payment gateway?<br>Make sure you enable <b>Auto-capture all payments</b>. <a href='https://razorpay.com/docs/payment-gateway/payments/capture-settings/#auto-capture-all-payments' target='_blank'>Click for more info</a></div>
  	</div>
  	<div class="col-6"><?php echo $loader->html->doms->create_input( "check", "pg_rp", $loader->admin->get_setting( "pg_rp" ) ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
    <div class="col-6">
      <div class="name">Mode</div>
      <div class="tip">Sandbox allows you to test everything before going live</div>
    </div>
    <div class="col-6"><?php echo $loader->html->doms->create_input( "select", "pg_rp_sb", $loader->admin->get_setting( "pg_rp_sb" ), [ "live" => "live", "sandbox" => "sandbox" ] ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-6">
  	  <div class="name">Key ID</div>
  	  <div class="tip">Razorpay API Key ID. Generate one <a href='https://dashboard.razorpay.com/app/keys' target="_blank">here</a></div>
  	</div>
  	<div class="col-6"><?php echo $loader->html->doms->create_input( "text", "pg_rp_k1", $demo ? "********" : $loader->admin->get_setting( "pg_rp_k1" ) ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-6">
  	  <div class="name">Key Secret</div>
  	  <div class="tip">Razorpay API Key Secret</div>
  	</div>
  	<div class="col-6"><?php echo $loader->html->doms->create_input( "text", "pg_rp_k2", $demo ? "********" : $loader->admin->get_setting( "pg_rp_k2" ) ) ?></div>
  </div>
  </div>

  <div class="foot_buttons"><input type="submit" value="Save" class="btn btn-success btn-wide"></div>

</form>
</div>
