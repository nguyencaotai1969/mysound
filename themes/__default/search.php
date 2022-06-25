<?php if ( !defined("root" ) ) die; ?>
<div class="container search_container">
	
  <div id="side">
  	<div class="tabs som_scroll_h">
  	  <a class="tab<?php echo $page_data["type"] == "all" ? " active" : ""; ?>" href="<?php $loader->ui->eurl( 'search', null, "type=all&qn={$page_data["query"]}" ); ?>">
  	  	<div class="icon"><span class="mdi mdi-magnify"></span></div>
  	  	<div class="title"><?php $loader->lorem->eturn( "all", [ "uc" => true ] ) ?></div>
  	  </a>
  	  <a class="tab<?php echo $page_data["type"] == "tracks" ? " active" : ""; ?>" href="<?php $loader->ui->eurl( 'search', null, "type=tracks&qn={$page_data["query"]}" ); ?>">
  	  	<div class="icon"><span class="mdi mdi-volume-high"></span></div>
  	  	<div class="title"><?php $loader->lorem->eturn( "tracks", [ "uc" => true ] ) ?></div>
  	  </a>
  	  <a class="tab<?php echo $page_data["type"] == "albums" ? " active" : ""; ?>" href="<?php $loader->ui->eurl( 'search', null, "type=albums&qn={$page_data["query"]}" ); ?>">
  	  	<div class="icon"><span class="mdi mdi-album"></span></div>
  	  	<div class="title"><?php $loader->lorem->eturn( "albums", [ "uc" => true ] ) ?></div>
  	  </a>
  	  <a class="tab<?php echo $page_data["type"] == "artists" ? " active" : ""; ?>" href="<?php $loader->ui->eurl( 'search', null, "type=artists&qn={$page_data["query"]}" ); ?>">
  	  	<div class="icon"><span class="mdi mdi-account-music"></span></div>
  	  	<div class="title"><?php $loader->lorem->eturn( "artists", [ "uc" => true ] ) ?></div>
  	  </a>
  	</div>
  </div>
  <div id="results">
  
    <?php if ( in_array( $page_data["type"], [ "all", "tracks" ] ) ) : ?>
  	<div class="title"><?php $loader->lorem->eturn( "tracks", [ "uc" => true ] ) ?></div>
  	<div class="items tracks">
  	  <?php if ( empty( $page_data["tracks"] ) ) : ?>
	  <div class="empty"><?php $loader->lorem->eturn( 'no_result' ); ?></div>
  	  <?php ; else : ?>
  	    <?php foreach( $page_data["tracks"] as $i => $track ) : ?>
  	    <div class="item rti_handle" data-source-type="<?php echo $track["source"]; ?>" data-target-type="track" data-target-hook="<?php echo $track["source"] == "db" ? $loader->ui->rurl( "track", $track["url"] ) : $track["ID"] ?>">
  	      <div class="image">
  	      	<img alt="<?php echo $loader->secure->escape( $track["title"] ); ?>" src="<?php echo $track["source"] == "db" ? $track["cover_addr"] : $track["cover"]; ?>">
  	      </div>
  	      <div class="item_title wsnw">
  	        <div class="wsnwe"><?php echo $loader->secure->escape( $track["title"] ); ?></div>
  	      </div>
  	      <div class="artist">
  	      	<?php echo $loader->secure->escape( $track["artist_name"] ); ?>
  	      </div>
  	    </div>
  	    <?php endforeach; ?>
  	  <?php endif; ?>
  	</div>
  	  <?php if ( !empty( $page_data["tracks"] ) ? count( $page_data["tracks"] ) == $loader->search->limit : false ) : ?>
	  <div class='load_more_wrapper'><a class='load_more_link' href='<?php echo $loader->ui->page_uri . "?qn={$page_data["query"]}&p=".($page_data["page"]+1)."&type=tracks" ?>'><?php $loader->lorem->eturn( "load_more", [ "uc" => true ] ); ?></a></div>
  	  <?php endif; ?>
  	<?php endif; ?>
  	 
    <?php if ( in_array( $page_data["type"], [ "all", "albums" ] ) ) : ?>
  	<div class="title"><?php $loader->lorem->eturn( "albums", [ "uc" => true ] ) ?></div>
  	<div class="items albums">
  	  <?php if ( empty( $page_data["albums"] ) ) : ?>
	  <div class="empty"><?php $loader->lorem->eturn( 'no_result' ); ?></div>
  	  <?php ; else : ?>
  	    <?php foreach( $page_data["albums"] as $album ) : ?>
  	    <div class="item rti_handle" data-source-type="<?php echo $album["source"]; ?>" data-target-type="album" data-target-hook="<?php echo $album["source"] == "db" ? $loader->ui->rurl( "album", $album["url"] ) : $album["ID"] ?>">
  	      <div class="image">
  	      	<img alt="<?php echo $loader->secure->escape( $album["title"] ); ?>" src="<?php echo $album["source"] == "db" ? $album["cover_addr"] : $album["cover"]; ?>">
  	      </div>
  	      <div class="item_title wsnw">
  	        <div class="wsnwe"><?php echo $loader->secure->escape( $album["title"] ); ?></div>
  	      </div>
  	      <div class="artist">
  	      	<?php echo $loader->secure->escape( $album["artist_name"] ); ?>
  	      </div>
  	    </div>
  	    <?php endforeach; ?>
  	  <?php endif; ?>
  	</div>
  	  <?php if ( !empty( $page_data["albums"] ) ? count( $page_data["albums"] ) == $loader->search->limit : false ) : ?>
	  <div class='load_more_wrapper'><a class='load_more_link' href='<?php echo $loader->ui->page_uri . "?qn={$page_data["query"]}&p=".($page_data["page"]+1)."&type=albums" ?>'><?php $loader->lorem->eturn( "load_more", [ "uc" => true ] ); ?></a></div>
  	  <?php endif; ?>
  	<?php endif; ?>
  	 
    <?php if ( in_array( $page_data["type"], [ "all", "artists" ] ) ) : ?>
  	<div class="title"><?php $loader->lorem->eturn( "artists", [ "uc" => true ] ) ?></div>
  	<div class="items artists">
  	  <?php if ( empty( $page_data["artists"] ) ) : ?>
	  <div class="empty"><?php $loader->lorem->eturn( 'no_result' ); ?></div>
  	  <?php ; else : ?>
  	    <?php foreach( $page_data["artists"] as $artist ) : ?>
  	    <div class="item rti_handle" data-source-type="<?php echo $artist["source"]; ?>" data-target-type="artist" data-target-hook="<?php echo $artist["source"] == "db" ? $loader->ui->rurl( "artist", $artist["url"] ) : $artist["ID"] ?>">
  	      <div class="image">
  	      	<img alt="<?php echo $loader->secure->escape( $artist["name"] ); ?>" src="<?php echo $artist["source"] == "db" ? $artist["image"] : $artist["image"]; ?>">
  	      </div>
  	      <div class="item_title wsnw">
  	        <div class="wsnwe"><?php echo $loader->secure->escape( $artist["name"] ); ?></div>
  	      </div>
  	    </div>
  	    <?php endforeach; ?>
  	  <?php endif; ?>
  	</div>
  	  <?php if ( !empty( $page_data["artists"] ) ? count( $page_data["artists"] ) == $loader->search->limit : false ) : ?>
	  <div class='load_more_wrapper'><a class='load_more_link' href='<?php echo $loader->ui->page_uri . "?qn={$page_data["query"]}&p=".($page_data["page"]+1)."&type=artists" ?>'><?php $loader->lorem->eturn( "load_more", [ "uc" => true ] ); ?></a></div>
  	  <?php endif; ?>
  	<?php endif; ?>
  	
  </div>
</div>