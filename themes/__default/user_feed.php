<?php if ( !defined("root" ) ) die;
echo $loader->html->load_part( "user_navbar", [ "page_data" => $page_data ] ); ?>

<div class="container user_container">
<div>

	<div id="user_sidebar"><?php  echo $loader->html->load_part( "user_sidebar", [ "page_data" => $page_data ] ); ?></div>
	<div id="user_content" >
	  <div class="tracks acts">
	    <?php if ( empty( $page_data["user_feed"]["acts"] ) ) : ?>
	    <div class="icon empty">
	  	  <span class="mdi mdi-emoticon-dead-outline"></span>
	    </div>
	    <div class="text">
	  	  <?php $loader->lorem->eturn( "user_feed_empty" ); ?><br>
	    </div>
	    <?php ;else:
				foreach( $page_data["user_feed"]["acts"] as $user_act )
				echo $loader->theme->set_name('__default')->__req( "parts/m_act.php", false, [ "user_act" => $user_act ] );
				if ( !empty( $page_data["user_feed"]["has_more"] ) ) : ?>
		  <div class="load_more_wrapper">
		    <a class="load_more_link" href="<?php echo $page_data["user_feed"]["has_more"]; ?>"><?php $loader->lorem->eturn( "load_more", [ "uc" => true ] ); ?></a>
		  </div>
		  <?php endif; ?>

		<?php endif; ?>
	  </div>
	</div>

</div>
</div>
