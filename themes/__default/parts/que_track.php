<?php if ( !defined("root" ) ) die; ?>
<div class="track track_dom track_dom_<?php echo $track["hash"]; ?>">
 
  <a href="<?php $loader->ui->eurl( "track", $track["url"] ); ?>"><img class="cover" src='<?php echo $loader->general->path_to_addr($track["cover"]); ?>'></a>
  
  <div class="data_wrapper">
  	<div class="title"><a href="<?php $loader->ui->eurl( "track", $track["url"] ); ?>"><?php echo $track["title"]; ?></a></div>
  	<div class="artist_album">
  	  <span class="artist"><a href="<?php $loader->ui->eurl( "artist", $track["artist_url"] ); ?>"><?php echo $track["artist_name"]; ?></a></span>
  	  <span class="album"><a href="<?php $loader->ui->eurl( "album", $track["album_url"] ); ?>"><?php echo $track["album_title"]; ?></a></span>  
  	</div>
  </div>
  
  <div class="duration"><?php echo $track["duration_hr"]; ?></div>
  
  <div class="buttons buttons_<?php echo $track["hash"]; ?>">
    <div class="button pauseplay m_add" data-hook="<?php echo $track["hash"]; ?>"><span class="mdi mdi-play"></span></div>
    <div class="button m_rfq" data-hook="<?php echo $track["hash"]; ?>"><span class="mdi mdi-minus"></span></div>
  </div>
  
</div>