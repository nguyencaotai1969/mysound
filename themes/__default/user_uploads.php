<?php if ( !defined("root" ) ) die;
echo $loader->html->load_part( "user_navbar", [ "page_data" => $page_data ] ); ?>

<div class="container user_container">
<div>

	<div id="user_sidebar"><?php  echo $loader->html->load_part( "user_sidebar", [ "page_data" => $page_data ] ); ?></div>
	<div id="user_content" class="page" >
	  <div class="tracks widget">
      <div class="slider">
	    <?php if ( empty( $page_data["user_uploads"]["acts"] ) ) : ?>
	    <div class="icon empty">
	  	  <span class="mdi mdi-emoticon-dead-outline"></span>
	    </div>
	    <div class="text">
	  	  <?php $loader->lorem->eturn( "no_result", ["uc"=>true] ); ?><br>
	  	  <?php if ( $page_data["owner"] ? $loader->visitor->user()->has_access( "group", "upload" ) : false ) : ?>
	  	  <a class="btn btn-sm btn-light" href="<?php $loader->ui->eurl( "user_upload" ); ?>"><?php $loader->lorem->eturn( "upload", ["uc"=>true] ); ?></a>
	  	  <?php endif; ?>
	    </div>
	    <?php ;else: ?>

		  <div class="row">
		  <?php
		  $user_uploads = [];
		  foreach( $page_data["user_uploads"]["acts"] as $user_upload ){
			  $user_uploads[] = $user_upload["data"]["track"];
		  }
		  $loader->ui->load_page_widget(
			  [
				  "type" => "track_slider",
				  "sett" => [
					  "size"  => "medium",
					  "class" => [ "noslide" ],
					  "id"    => "tracks_uploaded",
					  "limit" => 200
				  ],
			  ],
			  $user_uploads
		  ); ?>
		  </div>

		  <?php if ( !empty( $page_data["user_uploads"]["has_more"] ) ) : ?>
		  <div class="load_more_wrapper">
		    <a class="load_more_link" href="<?php echo $page_data["user_uploads"]["has_more"]; ?>"><?php $loader->lorem->eturn( "load_more", ["uc"=>true] ); ?></a>
		  </div>
		  <?php endif; ?>

		<?php endif; ?>
	  </div>
	  </div>
	</div>

</div>
</div>
