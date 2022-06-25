<?php if ( !defined("root" ) ) die;
echo $loader->html->load_part( "user_navbar", [ "page_data" => $page_data ] ); ?>

<div class="container user_container">
<div>
	
	<div id="user_sidebar"><?php  echo $loader->html->load_part( "user_sidebar", [ "page_data" => $page_data ] ); ?></div>
	<div id="user_content" class="page" >
	  <div class="tracks widget">
      <div class="slider">
	    <?php if ( empty( $page_data["user_purchased"] ) ) : ?>
	    <div class="icon empty">
	  	  <span class="mdi mdi-emoticon-dead-outline"></span>
	    </div>
	    <div class="text">
	  	  <?php $loader->lorem->eturn( "no_result", ["uc"=>true] ); ?><br>
	    </div>
	    <?php ;else: ?>
		  <div class="row">
		  <?php $loader->ui->load_page_widget( 
			  [
				  "type" => "track_slider",
				  "sett" => [ 
					  "size"  => "medium",
					  "class" => [ "noslide" ],
					  "id"    => "tracks_purchased",
					  "limit" => 200
				  ],
			  ],
			  $page_data["user_purchased"] 
		  ); ?> 
		  </div>
		<?php endif; ?>
	  </div>
	  </div>
	</div>
	
</div>
</div>
