<?php if ( !defined("root" ) ) die;
echo $loader->html->load_part( "user_navbar", [ "page_data" => $page_data ] ); ?>

<div class="container user_container">
<div>

	<div id="user_sidebar"><?php  echo $loader->html->load_part( "user_sidebar", [ "page_data" => $page_data ] ); ?></div>
	<div id="user_content" >
	  <div class="playlists">
	    <?php if ( empty( $page_data["user_playlists"] ) ) : ?>
	    <div class="icon empty">
	  	  <span class="mdi mdi-emoticon-dead-outline"></span>
	    </div>
	    <div class="text">
	  	  <?php $loader->lorem->eturn( "no_result", ["uc"=>true] ); ?><br>
	  	  <?php if ( $page_data["owner"] ) : ?>
	  	  <a class="btn btn-sm btn-light cpm_handler"><?php $loader->lorem->eturn( "create_new_playlist", ["uc"=>true] ); ?></a>
	  	  <?php endif; ?>
	    </div>
	    <?php ;else: ?>
		  <?php foreach( $page_data["user_playlists"] as $user_playlist ) : ?>
	      <div class="playlist inline a_dom dom_playlist_<?php echo $user_playlist["hash"] ?>">
	        <div class="playlist_cover">
			  <?php if ( !empty( $user_playlist["cover"] ) ) : ?>
	          <a href="<?php $loader->ui->eurl( "playlist", $user_playlist["url"] ) ?>"><img alt="<?php echo $user_playlist["name"] ?>" src="<?php echo $user_playlist["cover"]; ?>"></a>
			  <?php endif; ?>
	        </div>
	        <div class="head">
	          <div class="icon pauseplay m_add" data-type="playlist" data-hook="<?php echo $user_playlist["hash"]; ?>">
	            <span class="mdi mdi-play"></span>
	          </div>
	          <div class="data">
	          	<div class="name"><a href="<?php $loader->ui->eurl( "user", $user_playlist["owner"]["username"] ) ?>">@<?php echo $user_playlist["owner"]["username"]; ?></a></div>
	          	<div class="title"><a href="<?php $loader->ui->eurl( "playlist", $user_playlist["url"] ) ?>"><?php echo $user_playlist["name"]; ?></a></div>
	          </div>
	          <div class="times">
	          	<div class="time"><?php $loader->lorem->eturn("updated",["uc"=>true]); ?> <?php $loader->lorem->eturn("time_ago",["params"=>["time"=>$user_playlist["passed_time_update"]]]); ?></div>
	          </div>
	        </div>
	        <?php if ( !empty( $user_playlist["tracks"] ) ) : ?>
	        <div class="tracks">
	          <?php $i=0; foreach( $user_playlist["tracks"] as $user_playlist_track ) : $i++; ?>
	          <div class="track track_dom track_dom_<?php echo $user_playlist_track["hash"]; ?>" >
	          	<div class="cover"><a href="<?php $loader->ui->eurl( "track", $user_playlist_track["url"] ) ?>"><img alt="<?php echo $user_playlist_track["title"] ?>" src="<?php echo $user_playlist_track["cover_addr"]; ?>"></a></div>
	          	<div class="data">
	          	  <div class="i">
	          	    <div class="o"><?php echo $i; ?></div>
	          	    <div class="buttons buttons_<?php echo $user_playlist_track["hash"]; ?> m_add" data-hook="<?php echo $user_playlist_track["hash"]; ?>"><span class="pauseplay"><span class="mdi mdi-play"></span></span></div>
	          	  </div>
	          	  <div class="artist"><a href="<?php $loader->ui->eurl( "artist", $user_playlist_track["artist_url"] ) ?>"><?php echo $user_playlist_track["artist_name"]; ?></a></div>
	          	  <div class="title"><a href="<?php $loader->ui->eurl( "track", $user_playlist_track["url"] ) ?>"><?php echo $user_playlist_track["title"]; ?></a></div>
	          	  <div class="icons">
	          	  	<div class="icon"><?php echo $user_playlist_track["likes"]; ?><span class="mdi mdi-heart"></span></div>
	          	  	<div class="icon"><?php echo $user_playlist_track["play_full"]; ?><span class="mdi mdi-play"></span></div>
	          	  </div>
	          	</div>
	          </div>
	          <?php endforeach; ?>
	          <?php if ( $user_playlist["track_count"] > 20 ) : ?>
	          <a class="load_more" href="<?php $loader->ui->eurl( "playlist", $user_playlist["url"] ) ?>" >
	          <?php $loader->lorem->eturn( "load_more", ["uc"=>true] ); ?>
	          </a>
	          <?php endif; ?>
	        </div>
	        <?php ;else: ?>
	        <div class="empty_tracks"><?php $loader->lorem->eturn( "user_empty_playlist" ); ?></div>
	        <?php endif; ?>
	        <?php if ( $page_data["owner"] ) : ?>
	        <div class="foot_buttons">
	          <a class="btn btn-light btn-sm" href="<?php $loader->ui->eurl( "playlist", $user_playlist["url"] ) ?>"><span class="mdi mdi-lead-pencil"></span><?php $loader->lorem->eturn( "edit", ["uc"=>true] ); ?></a>
	          <a class="btn btn-light btn-sm remove_playlist_handle" data-hook="<?php echo $user_playlist["hash"]; ?>"><span class="mdi mdi-delete"></span><?php $loader->lorem->eturn( "delete", ["uc"=>true] ); ?></a>
	        </div>
	        <?php endif; ?>
	      </div>
	      <?php endforeach; ?>
		<?php endif; ?>
	  </div>
	</div>

</div>
</div>
