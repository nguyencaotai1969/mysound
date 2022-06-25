<?php if ( !defined("root" ) ) die;
$album = $loader->ui->page_data;
?>

<div class="page_head album">
<div class="container">

  <div class="bg_wrapper" style="background-image: url('<?php echo $album["cover"]; ?>')" ><img alt="<?php echo $album["title"]; ?>" src="<?php echo $album["cover"]; ?>"></div>

  <div class="t_wrapper a_dom dom_album_<?php echo $album["hash"]; ?>">

    <div class="cover_wrapper" >

      <div class="_cover" style="background-image: url('<?php echo $album["cover"]; ?>')"><img alt="<?php echo $album["title"]; ?>" src="<?php echo $album["cover"]; ?>"></div>

    </div>

    <div class="data_wrapper">

	  <div class="play_buttons buttons buttons_<?php echo $album["hash"]; ?>">

      	  <div class="button play_btn">
     	  <a class="btn btn-light play pauseplay m_add" data-type="album" data-hook="<?php echo $album["hash"]; ?>" >
      	    <span class="mdi mdi-play"></span>
      	  </a>
		  </div>

		  <?php if ( !$album["is_paid"] ) : ?>

      	  <div class="button purchase_btn purchase_handle"
			   data-title = "<?php $loader->lorem->eturn( 'purchase_album', [ "uc" => true ] ) ?>"
			   data-fund = "<?php echo $loader->user->data["fund"]; ?>"
			   data-item-title = "<?php echo $loader->secure->escape( $album["artist_name"] . " - " . $album["title"] ); ?>"
			   data-item-price = "<?php echo $album["price"]; ?>"
			   data-item-hook = "<?php echo $album["hash"]; ?>"
			   data-item-type = "album"><a class="btn btn-light more"><span class="mdi mdi-cart"></span></a></div>

      	  <?php elseif ( $this->loader->admin->get_setting("station",1) ) : ?>

		  <div class="button radio_btn m_add" data-type="album" data-hook="<?php echo $album["hash"]; ?>" data-radio="1">
      	    <a class="btn btn-light more"><span class="mdi mdi-antenna"></span></a>
      	  </div>

      	  <?php endif; ?>

		  <div class="button album_like_handle <?php echo $album["liked"] ? "liked" : ""; ?>" data-hook="<?php echo $album["hash"]; ?>">
        <a class="btn btn-light more"><span class="mdi mdi-heart-outline"></span></a>
		  </div>

		  <div class="button more_btn button_more">
      	    <a class="btn btn-light more"><span class="mdi mdi-dots-horizontal"></span></a>
			<?php echo $loader->theme->set_name('__default')->__req( "parts/m_buttons.php", false, [ "type" => "album", "item" => $album ] );  ?>
      	  </div>

      </div>

      <div class="title"><?php echo $album["title"]; ?></div>
      <div class="others">

        <?php if ( $album["type"] != "compilation" && strtolower( $album["artist"]["name"] ) != "various artists" ) : ?>
        <div class="artist"><img alt="<?php echo $album["artist"]["name"]; ?>" src="<?php echo $album["artist"]["image"]; ?>"><a href="<?php $loader->ui->eurl( "artist", $album["artist"]["url"] ); ?>"><?php echo $album["artist"]["name"]; ?></a></div>
    	  <?php else: ?>
    	  <div class="artist"><img alt="<?php echo $album["artist"]["name"]; ?>" src="<?php echo $album["cover"]; ?>"><a href="<?php $loader->ui->eurl( "album", $album["url"] ); ?>"><?php echo $album["artist"]["name"]; ?></a></div>
    	  <?php endif; ?>

        <div class="time">
          <span class="mdi mdi-clock"></span>
          <?php echo $loader->general->passed_time_hr( time() - strtotime( $album["time_release"] ), 1 )[ "string" ]; ?> <?php $loader->lorem->eturn( "ago" ); ?>
        </div>

        <div class="likes">
          <span class="mdi mdi-heart"></span>
          <?php echo $album["likes"] . " " . $loader->lorem->turn( "likes" ); ?>
        </div>

        <?php if( $page_data["uploader"] ) : ?>
          <div class="uploader">
            <a href='<?php $loader->ui->eurl( "user_uploads", $page_data["uploader"]["username"] ) ?>'>
              <span class="mdi mdi-account"></span>
              <?php echo $page_data["uploader"]["name"]; ?>
            </a>
          </div>
        <?php endif; ?>

      </div>

    </div>

  </div>

</div>
</div>

<?php if ( $page_data["uploader"] && !empty( $album["comment"] ) ) : ?>
<div id="track_data">
  <div class="comments owner_comment">
	<div class="comment">
	  <div class="avatar"><a href='<?php $loader->ui->eurl( "user", $page_data["uploader"]["username"] ) ?>'><img alt="<?php echo $page_data["uploader"]["username"]; ?>" src="<?php echo $page_data["uploader"]["avatar"]; ?>"></a></div>
      <div class="name">
        <a href='<?php $loader->ui->eurl( "user", $page_data["uploader"]["username"] ) ?>'><?php echo $page_data["uploader"]["name"]; ?></a>
      </div>
	  <div class="text"><?php echo $album["comment"]; ?></div>
	</div>
  </div>
</div>
<?php endif; ?>

<div id="tracks_table">
  <div class="container page">
  <div class="row">
     <?php
	     $loader->ui->load_page_widget(
	         [
	             "type" => "track_table",
			     "sett" => [
					 "id" => "album_tracks",
					 "limit" => 100,
					 "table_cols" => [ "order" => [ "btn" => "play" ], "title_full_artist", "like_btn", "duration" => [ "btn" => "all" ] ],
	             ]
			 ],
	         $album["tracks"]
	     );
	 ?>

  </div>
  </div>
</div>

<?php
$loader->ui->load_page_widget( [ "type" => "pl", "sett" => [ "pl_code" => "album_page" ] ] );
?>
