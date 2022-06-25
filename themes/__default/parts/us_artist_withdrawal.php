<?php if ( !defined("root" ) ) die; ?>
<form method="post" class="be_cli_form" data-action="user_setting_<?php echo $page_data["setting_part"]; ?>" data-target=".watermark" data-callback-param="transaction_history" data-callback="check_user_setting_response" >

<?php if ( $alert = $loader->lorem->turn( "artist_pay_note", [ "val" => null ] ) ) : ?>
<div class="alert alert-secondary" role="alert">
  <?php echo $loader->secure->escape( $alert ); ?>
</div>
<?php endif; ?>

<div class="input_wrapper">
  <div class="input">
    <label><?php $loader->lorem->eturn( "amount", ["uc"=>true] ) ?></label>
    <input name="amount" type="text" class="form-control" >
  </div>
</div>

<div class="input_wrapper">
  <div class="input">
    <label><?php $loader->lorem->eturn( "email", ["uc"=>true] ) ?></label>
    <input name="email" type="email" class="form-control" >
  </div>
</div>

<div class="input_wrapper">
  <div class="input">
    <label><?php $loader->lorem->eturn( "more_data", ["uc"=>true] ) ?></label>
    <textarea name="data" class="form-control artist_detail" placeholder="<?php $loader->lorem->eturn( "more_data_ph2", ["uc"=>true] ) ?>"></textarea>
  </div>
</div>

<input type="submit" class="btn btn-primary btn-wide" value="<?php $loader->lorem->eturn( "send", ["uc"=>true] ) ?>">
</form>
