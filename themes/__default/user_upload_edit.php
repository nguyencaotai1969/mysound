<?php if ( !defined("root" ) ) die;
$uploadings = $loader->ui->page_data;
?>

<div class="container edit" >

	<div class="alert alert-info" role="alert"><?php $loader->lorem->eturn( "upload_edit_tip" ); ?></div>

	<?php $i=0; foreach( $uploadings["albums"] as $_album ) : $i++; ?>
	<div class="album s1 <?php echo $i == count( $uploadings["albums"] ) ? "last" : "n{$i}"; ?>">

	  <div class="cover_wrapper">

	    <div class="cover <?php echo $_album["cover"] ? "hasCover" : "noCover"; ?> upload_cover_handle">
          <img src="<?php
		  echo count(explode(root,$_album["cover"]))>1 ? $loader->ui->eurl( "user_upload_edit", null, "ID={$uploadings["ID"]}&play_uploading&hash={$_album["rID"]}&cover" ) : $_album["cover"];
		  ?>">
	      <div class="edit"><span class="mdi mdi-cloud-upload"></span></div>
	    </div>

	    <form class="be_cli_form" data-hasFile="true" data-action="user_update_uploading_cover" data-callback="updated_uploading_cover" method="post">
	      <input type="file" name="file" class="file_handler" accept=".jpg,.jpeg,.png,.gif" >
	      <input type="hidden" name="uploadID" value="<?php echo $uploadings["ID"]; ?>">
	      <input type="hidden" name="album_code" value="<?php echo $_album["code"]; ?>">
	    </form>

	    <div class="detail">
          <?php $loader->lorem->eturn( "album_tracks_data", [ "params" => [ "count" => $_album["tracks_count"], "duration" => floor( $_album["tracks_duration"] / 60 ) ] ] ); ?>
	    </div>

	  </div>

	  <div class="data_wrapper">

	  	<h2><?php echo $loader->secure->escape( $_album["title"] ); ?></h2>
	  	<div class="subline">
	  	  <button type="button" class="btn btn-sm btn-secondary caem_handle" data-hook="<?php echo $_album["code"] ?>"><?php $loader->lorem->eturn( "edit", ["uc"=>true] ); ?></button>
	  	  <?php echo !empty( $_album["artist_name"] ) ? "<div>" . $_album["artist_name"] . "</div>" : ""; ?>
	  	  <?php echo !empty( $_album["time"] ) ? "<div>" . substr( $_album["time"], 0, 4 ) . "</div>" : ""; ?>
	  	  <?php echo !empty( $_album["genre"] ) ? "<div>{$loader->genre->return_valid($_album["genre"])}</div>" : ""; ?>
	  	  <?php echo !empty( $_album["type"] ) ? "<div>{$_album["type"]}</div>" : ""; ?>
	  	  <?php echo !empty( $_album["price"] ) ? "<div>".$loader->general->display_price( $_album["price"], true )."</div>" : ""; ?>
  	    </div>
	  	<div class="tracks">

	  	  <table width="100%">
	  	    <thead>
	  	      <tr>
	  	        <td width="30px">#</td>
	  	        <td><?php $loader->lorem->eturn( "name", ["uc"=>true] ); ?></td>
	  	        <td><?php $loader->lorem->eturn( "artist", ["uc"=>true] ); ?></td>
	  	        <td><?php $loader->lorem->eturn( "genre", ["uc"=>true] ); ?></td>
	  	        <td width="75px"><?php $loader->lorem->eturn( "duration", ["uc"=>true] ); ?></td>
	  	        <td width="60px"><?php $loader->lorem->eturn( "bitrate", ["uc"=>true] ); ?></td>
	  	        <td width="60px"><?php $loader->lorem->eturn( "price", ["uc"=>true] ); ?></td>
	  	        <td width="30px"><?php $loader->lorem->eturn( "edit", ["uc"=>true] ); ?></td>
	  	      </tr>
	  	    </thead>
	  	    <tbody>
	  	    <?php foreach( $_album["tracks_full"] as $track ) : ?>

	  	      <tr id="tr_<?php echo $track["rID"]; ?>" class="ctem_handle" data-hook="<?php echo $track["rID"]; ?>">
	  	        <td><?php echo $track["album_order"]; ?></td>
	  	        <td class="boldMe"><?php echo $loader->secure->escape( $track["title"] ); ?><span><?php echo $loader->secure->escape( $track["originalName"] ); ?></span></td>
	  	        <td><?php echo $loader->secure->escape( $track["artist_name"] ); ?></td>
	  	        <td><?php echo $loader->genre->return_valid( $track["genre"] ); ?></td>
	  	        <td><?php echo $loader->general->hr_seconds( $track["duration"] ); ?></td>
	  	        <td><?php echo $track["bitrate"]; ?></td>
	  	        <td><?php echo $track["price"] == 0 ? $loader->lorem->turn("free") : "{$track["price"]}$"; ?></td>
	  	        <td class="buttons"><span class="mdi mdi-pencil"></span></td>
	  	      </tr>

	  	    <?php endforeach; ?>
	  	    </tbody>
	  	  </table>

	  	</div>

	  </div>

	</div>

	<?php endforeach; ?>

	<div class="continue_button_wrapper">
		<a class="btn btn-primary continue_button upload_finalize_handle" ><?php $loader->lorem->eturn( "continue", ["uc"=>true] ); ?></a>
	</div>

</div>
<script>
var $__upload_id = '<?php echo $uploadings["ID"]; ?>';
var $__albums = JSON.parse('<?php echo $loader->general->json_encode( $uploadings["albums"], true ); ?>');
var $__tracks = JSON.parse('<?php echo $loader->general->json_encode( $uploadings["tracks"], true ); ?>');
var $__genres = JSON.parse('<?php echo $loader->general->json_encode( $uploadings["genres"], true ); ?>');
var $__prices = JSON.parse('<?php echo $loader->general->json_encode( $uploadings["prices"], true ); ?>');
</script>
