<?php if ( !defined("root" ) ) die;
echo $loader->html->load_part( "user_navbar", [ "page_data" => $page_data ] ); ?>

<div class="container user_container">
<div>

	<div id="user_sidebar"><?php  echo $loader->html->load_part( "user_sidebar", [ "page_data" => $page_data ] ); ?></div>
	<div id="user_content" >
	  <div class="users acts">
	    <?php if ( empty( $page_data["followers"]["acts"] ) ) : ?>
	    <div class="icon empty">
	  	  <span class="mdi mdi-emoticon-dead-outline"></span>
	    </div>
	    <div class="text">
	  	  <?php $loader->lorem->eturn( "no_result", ["uc"=>true] ); ?><br>
	    </div>
	    <?php ;else: ?>

		  <?php foreach( $page_data["followers"]["acts"] as $_f ) : ?>
          <div class="user">
			<div class="avatar"><a href="<?php $loader->ui->eurl( "user", $_f["user"]["username"] ); ?>"><img alt="<?php echo $_f["user"]["username"]; ?>" src="<?php echo $_f["user"]["avatar"]; ?>"></a></div>
			<div class="name"><a href="<?php $loader->ui->eurl( "user", $_f["user"]["username"] ); ?>"><?php echo $_f["user"]["name"]; ?></a></div>
          </div>
	      <?php endforeach; ?>

	      <?php if ( !empty( $page_data["followers"]["has_more"] ) ) : ?>
		  <div class="load_more_wrapper">
		    <a class="load_more_link" href="<?php echo $page_data["followers"]["has_more"]; ?>"><?php $loader->lorem->eturn( "load_more", [ "uc" => true ] ); ?></a>
		  </div>
		  <?php endif; ?>

		<?php endif; ?>
	  </div>
	</div>

</div>
</div>
