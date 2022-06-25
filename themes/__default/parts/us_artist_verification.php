<?php if ( !defined("root" ) ) die;

$already_in_process = $loader->db->_select([
	"table" => "_user_artist_reqs",
	"where" => [
	    [ "user_id", "=", $loader->visitor->user()->ID ],
	    [ "approved", null, null, true ]
    ]
]);

if ( !empty( $already_in_process ) ) :

echo '<div class="so_empty">';
$loader->lorem->eturn("artist_verify_wait");
echo '</div>';

else :
?>


<form method="post" class="be_cli_form" data-action="user_setting_<?php echo $page_data["setting_part"]; ?>" data-target=".watermark" data-callback-param="artist_verification" data-callback="check_user_setting_response" data-hasFile="true" >

<?php if ( $alert = $loader->lorem->turn( "artist_verify_note", [ "val" => null ] ) ) : ?>
<div class="alert alert-secondary" role="alert">
  <?php echo $loader->secure->escape( $alert ); ?>
</div>
<?php endif; ?>

<div class="input_wrapper">
  <div class="input">
    <label><?php $loader->lorem->eturn( "real_name", ["uc"=>true] ) ?></label>
    <input name="real_name" type="text" class="form-control" >
  </div>
</div>
<div class="input_wrapper">
  <div class="input">
    <label><?php $loader->lorem->eturn( "stage_name", ["uc"=>true] ) ?></label>
    <input name="stage_name" type="text" class="form-control" >
  </div>
</div>
<div class="input_wrapper">
  <div class="input">
    <label><?php $loader->lorem->eturn( "up_photo_doc", ["uc"=>true] ) ?></label>
    <input name="file" id="f1" type="file" class="form-control" >
    <div class="file_handler file_placeholder" data-target="#f1"><?php $loader->lorem->eturn( "click_to_select", ["uc"=>true] ) ?></div>
  </div>
</div>
<div class="input_wrapper">
  <div class="input">
    <label><?php $loader->lorem->eturn( "more_data", ["uc"=>true] ) ?></label>
    <textarea name="data" class="form-control artist_detail" placeholder="<?php $loader->lorem->eturn( "more_data_ph", ["uc"=>true] ) ?>"></textarea>
  </div>
</div>

<input type="submit" class="btn btn-primary btn-wide" value="<?php $loader->lorem->eturn( "send", ["uc"=>true] ) ?>">
</form>

<?php endif; ?>
