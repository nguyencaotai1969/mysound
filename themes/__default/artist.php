<?php if ( !defined("root" ) ) die;
extract( $loader->ui->page_data );
?>

<div id="artist" class="<?php echo $index === true ? "index" : "{$index} n_index"; ?>">
<div class="container page">

  <div class="side">

	<div class="bg_wrapper" style="background-image: url('<?php echo $user ? $user["avatar"] : $data["image"]; ?>')">
      <img alt="<?php echo $data["name"]; ?>" src="<?php echo $user ? $user["avatar"] : $data["image"]; ?>">
    </div>

  	<div class="image_wrapper">
  	  <img alt="<?php echo $data["name"]; ?>" src="<?php echo $user ? $user["avatar"] : $data["image"]; ?>">
  	</div>
  	<div class="name"><a href="<?php $loader->ui->eurl( "artist", $data["url"] ); ?>" ><?php echo $user ? $user["name"] : $data["name"]; ?></a></div>

      <div class="play_buttons buttons buttons_<?php echo $data["code"]; ?> a_dom dom_artist_<?php echo $data["code"]; ?>">

      	  <div class="button play_btn">
     	  <a class="btn btn-light play pauseplay m_add" data-type="artist" data-hook="<?php echo $data["code"]; ?>" >
      	    <span class="mdi mdi-play"></span>
      	  </a>
		  </div>

		  <?php if ( $this->loader->admin->get_setting("station",1) ) : ?>
      	  <div class="button radio_btn m_add" data-type="artist" data-hook="<?php echo $data["code"]; ?>" data-radio="1">
      	    <a class="btn btn-light more"><span class="mdi mdi-antenna"></span></a>
      	  </div>
		  <?php endif; ?>

      <div class="button artist_subsribe_handle" data-code="<?php echo $data["code"] ?>" title="<?php $loader->lorem->eturn( $data["followed"] ? "unsubscribe" : "subscribe", [ "uc" => true ] ) ?>">
        <a class="btn btn-light more"><span class="mdi mdi-<?php echo $data["followed"] ? "bell-check-outline" : "bell-outline"; ?>"></span></a>
      </div>

		  <div class="button more_btn button_more">
      	    <a class="btn btn-light more"><span class="mdi mdi-dots-horizontal"></span></a>
			<?php echo $loader->theme->set_name('__default')->__req( "parts/m_buttons.php", false, [ "type" => "artist", "item" => $data ] );  ?>
      	  </div>

      </div>

    <div class="widget_slider"><ul class="slider som_scroll_h artist_links"><li class="slider_item"><a href="<?php $loader->ui->eurl( "artist", $data["url"], 'w=tracks_popular' ); ?>" ><span class="mdi mdi-star-circle"></span><span class="text"><?php $loader->lorem->eturn("popular_tracks"); ?></span></a></li><li class="slider_item"><a href="<?php $loader->ui->eurl( "artist", $data["url"], 'w=albums_studio' ); ?>" ><span class="mdi mdi-music-box-multiple"></span><span class="text"><?php $loader->lorem->eturn("studio_albums"); ?></span></a></li><li class="slider_item"><a href="<?php $loader->ui->eurl( "artist", $data["url"], 'w=albums_single' ); ?>" ><span class="mdi mdi-album"></span><span class="text"><?php $loader->lorem->eturn("single_albums"); ?></span></a></li><li class="slider_item"><a href="<?php $loader->ui->eurl( "artist", $data["url"], 'w=albums_as_guest' ); ?>" ><span class="mdi mdi-charity"></span><span class="text"><?php $loader->lorem->eturn("albums_as_guest"); ?></span></a></li><?php if ( !empty( $loader->admin->get_setting( "spotify_d_ar", 1 ) ) && !empty( $data["spotify_id"] ) ) : ?><li class="slider_item"><a href="<?php $loader->ui->eurl( "artist", $data["url"], 'w=artists_related' ); ?>" ><span class="mdi mdi-radar"></span><span class="text"><?php $loader->lorem->eturn("related_artists"); ?></span></a></li><?php endif; ?><?php if ( $user ) : ?><li class="slider_item"><a href="<?php $loader->ui->eurl( "user", $user["username"] ); ?>"><span class="mdi mdi-heart-pulse"></span><span class="text"><?php $loader->lorem->eturn("activities",["uc"=>true]); ?></span></a></li><li class="slider_item"><a href="<?php $loader->ui->eurl( "user_uploads", $user["username"] ); ?>"><span class="mdi mdi-cloud-upload"></span><span class="text"><?php $loader->lorem->eturn("uploads",["uc"=>true]); ?></span></a></li><li class="slider_item"><a href="<?php $loader->ui->eurl( "user_likes", $user["username"] ); ?>"><span class="mdi mdi-heart"></span><span class="text"><?php $loader->lorem->eturn("likes",["uc"=>true]); ?></span></a></li><li class="slider_item"><a href="<?php $loader->ui->eurl( "user_reposts", $user["username"] ); ?>"><span class="mdi mdi-repeat"></span><span class="text"><?php $loader->lorem->eturn("reposts",["uc"=>true]); ?></span></a></li><li class="slider_item"><a href="<?php $loader->ui->eurl( "user_playlists", $user["username"] ); ?>"><span class="mdi mdi-playlist-music"></span><span class="text"><?php $loader->lorem->eturn("playlists",["uc"=>true]); ?></span></a></li><li class="slider_item"><a href="<?php $loader->ui->eurl( "user_followers", $user["username"] ); ?>"><span class="mdi mdi-account-check"></span><span class="text"><?php $loader->lorem->eturn("followers",["uc"=>true]); ?></span></a></li><li class="slider_item"><a href="<?php $loader->ui->eurl( "user_followings", $user["username"] ); ?>"><span class="mdi mdi-account-check-outline"></span><span class="text"><?php $loader->lorem->eturn("followings",["uc"=>true]); ?></span></a></li><?php endif; ?></ul><div class="arrows"><div class="arrow next"><span class="mdi mdi-chevron-right"></span></div><div class="arrow prev"><span class="mdi mdi-chevron-left"></span></div></div></div>

  </div>

  <div class="main page">
  <div class="row">

    <?php
    
    $loader->ui->load_page_widget( [ "type" => "pl", "sett" => [ "pl_code" => "artist_page" ] ] );

	  if ( !empty( $items["tracks_popular"] ) ) $loader->ui->load_page_widget( [ "type" => $index === true ? "track_slider" : "track_slider", "sett" => [ "linked"  => $index !== true ? null : $loader->ui->page_uri . "?w=tracks_popular", "size" => $index === true ? "medium" : "medium", "class" => $index === true ? [] : [ "noslide" ], "id" => "tracks_popular", "limit" => $index === true ? 10 : 10 ], "title" => $loader->lorem->turn("popular_tracks") ], $index === true ? $items["tracks_popular"] : $items["tracks_popular"] );

	  if ( !empty( $items["albums_studio"] ) ) $loader->ui->load_page_widget( [ "type" => "album_slider", "sett" => [ "linked"  => $index !== true ? null : $loader->ui->page_uri . "?w=albums_studio", "size" => $index === true ? "medium" : "medium" , "class" => $index === true ? [] : [ "noslide" ], "id" => "albums_studio", "limit" => $index === true ? 20 : 500 ], "title" => $loader->lorem->turn("studio_albums") ], $items["albums_studio"] );

	  if ( !empty( $items["albums_single"] ) ) $loader->ui->load_page_widget( [ "type" => "album_slider", "sett" => [ "linked"  => $index !== true ? null : $loader->ui->page_uri . "?w=albums_single", "size" => $index === true ? "medium" : "medium", "class" => $index === true ? [] : [ "noslide" ], "id" => "albums_single", "limit" => $index === true ? 20 : 500 ], "title" => $loader->lorem->turn("single_albums") ], $items["albums_single"] );

	  if ( !empty( $items["albums_as_guest"] ) ) $loader->ui->load_page_widget( [ "type" => "album_slider", "sett" => [ "linked" => $index !== true ? null : $loader->ui->page_uri . "?w=albums_as_guest", "size" => $index === true ? "medium" : "medium", "class" => $index === true ? [] : [ "noslide" ], "id" => "albums_as_guest", "limit" => $index === true ? 20 : 500 ], "title" => $loader->lorem->turn("albums_as_guest") ], $items["albums_as_guest"] );

	  if ( !empty( $items["artists_related"] ) ) $loader->ui->load_page_widget( [ "type" => "artist_slider", "sett" => [ "linked"  => $index !== true ? null : $loader->ui->page_uri . "?w=artists_related", "size" => $index === true ? "large" : "medium", "class" => $index === true ? [] : [ "noslide" ], "id" => "artists_related", "limit" => $index === true ? 10 : 10 ], "title" => $loader->lorem->turn("related_artists") ], $items["artists_related"] );

	  if ( empty( $items[ $index ] ) && $index !== true )
		  $loader->lorem->eturn("no_result",["uc"=>true]);

    ?>

  </div>
  </div>

</div>
</div>
