<?php if ( !defined("root" ) ) die; ?>
<div id="que_list"></div>
<div id="player">
<div class="container">
<div class="song_data">

  <div class="progress_wrapper p_w">
    <div class="progress_bg a_bar" ></div>
    <div class="progress_b a_bar"></div>
    <div class="progress_e a_bar"></div>
  </div>

  <div class="artist_detail">
    <div class="artist_cover" id="artist_holder"><img alt="artist_cover" src="<?php echo $loader->general->path_to_addr( $loader->theme->set_name()->get_setting( "logo" ) ); ?>" ></div>
    <div class="artist_title">
	  <div class="tip"><?php $loader->lorem->eturn( "song_by" ); ?></div>
      <div class="wsnw">
        <div class="wsnwe"><span></span></div>
      </div>
    </div>
  </div>

  <div class="control_buttons">
    <div class="prev" ><span class="mdi mdi-skip-previous"></span></div>
    <div class="pauseplay" ><span class="mdi mdi-play"></span></div>
    <div class="next" ><span class="mdi mdi-skip-next"></span></div>
  </div>

  <div class="song_detail">
  	<div class="cover" id="holder"><img alt="song_cover" src="<?php echo $loader->general->path_to_addr( $loader->theme->set_name()->get_setting( "logo" ) ); ?>" ></div>
  	<div class="song_title wsnw"><div class="wsnwe"><span></span></div></div>
  	<div class="artist_album_wrapper wsnw">
  	  <div class="wsnwe">
  	    <div class="album_title"><span></span></div>
  	  </div>
  	</div>
  	<div class="playlist_buttons">
  	  <div class="heart smer like_dom master" ><span class="mdi mdi-heart"></span></div>
  	  <div class="yt_handler"><span class="mdi mdi-youtube"></span></div>
  	  <div class="list sm gq"><span class="mdi mdi-playlist-music"></span></div>
  	</div>
  </div>

  <div class="control_secondary_buttons">
    <div class="repeat sm"><span class="mdi mdi-repeat"></span></div>
    <div class="volume sm">
      <span class="mdi mdi-volume-high"></span>
      <div class="sound_wrapper">
      	<div class="bg">
      	  <div class="pr"></div>
      	</div>
      </div>
    </div>
  </div>

  <div class="times">
    <div class="time_cur"></div>
    <div class="time_all"></div>
  </div>

</div>
</div>
</div>
