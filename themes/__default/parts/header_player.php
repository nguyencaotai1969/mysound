<?php if ( !defined("root" ) ) die; ?>
<div id="player">
<div class="container">
<div class="song_data">
 
  <div class="control_buttons">
    <div class="prev" ><span class="mdi mdi-skip-previous"></span></div>
    <div class="pauseplay" ><span class="mdi mdi-play"></span></div>
    <div class="next" ><span class="mdi mdi-skip-next"></span></div>
    <div class="divider"></div>
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
  
  <div class="progress_wrapper p_w">
    <div class="time_cur"></div>
    <div class="time_all"></div>
    <div class="progress_bg"></div>
    <div class="progress_b"></div>
    <div class="progress_e"></div>
  </div>
  
  <div class="song_detail">
  	<div class="cover" id="holder"><img alt="track cover"></div>
  	<div class="song_title wsnw"><div class="wsnwe"><span></span></div></div>
  	<div class="artist_album_wrapper wsnw">
  	  <div class="wsnwe">
  	    <div class="artist_title"><span></span></div>
  	    <div class="album_title"><span></span></div>
  	  </div>
  	</div>
  	<div class="playlist_buttons">
  	  <div class="heart smer like_dom master" ><span class="mdi mdi-heart"></span></div>
  	  <div class="list sm attp"><span class="mdi mdi-playlist-plus"></span></div>
  	  <div class="list sm gq"><span class="mdi mdi-playlist-music"></span><div id="que_list"></div></div>
  	</div>
  </div>
  
</div>
</div>
</div>