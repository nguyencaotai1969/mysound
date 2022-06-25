<?php if ( !defined("root" ) ) die;
if ( !empty( $widget["title"] ) ) : 
$widget["title"] = substr( $widget["title"], 0, 1 ) == "#" ? $loader->lorem->turn( "p_w_" . substr( $widget["title"], 1 ) ) : $loader->secure->escape( $widget["title"] ); 
?>
<div class="title">
  <?php echo !empty( $setting["linked"] ) ? 
	"<a href='{$loader->ui->rurl( null, $setting["linked"] )}'>{$widget["title"]}</a><span class='mdi mdi-chevron-right'></span>" :
	( !empty( $setting["has_more"] ) && $setting["page"] == 1 && empty( $page ) ? 
	  "<a href='{$loader->ui->rurl( null, $loader->ui->page_uri, "w={$widget["ID"]}&p=1" )}'>{$widget["title"]}</a><span class='mdi mdi-chevron-right'></span>" : 
	  $widget["title"] 
	);  ?>
</div>
<?php endif; ?>
<?php if ( substr( $widget["type"], 0, 6 ) == "track_" && !empty( $page ) && !empty( $widget["ID"] ) ) : ?>
      <div class="play_buttons buttons buttons_<?php echo $widget["title"]; ?>">
		  
      	  <div class="button play_btn">
     	  <a class="btn btn-light play pauseplay m_add" data-type="widget" data-hook="<?php echo $widget["ID"]; ?>">
      	    <span class="mdi mdi-play"></span>
      	  </a>
		  </div>
		  
		  <?php if ( $this->loader->admin->get_setting("station",1) ) : ?>
      	  <div class="button radio_btn m_add" data-type="widget" data-hook="<?php echo $widget["ID"]; ?>" data-radio="1">
      	    <a class="btn btn-light more"><span class="mdi mdi-antenna"></span></a>
      	  </div>
		  <?php endif; ?>

		  <div class="button more_btn button_more">
      	    <a class="btn btn-light more"><span class="mdi mdi-dots-horizontal"></span></a>
			<?php echo $loader->theme->set_name('__default')->__req( "parts/m_buttons.php", false, [ "type" => "widget", "item" => $widget ] );  ?>
      	  </div>
		  
      </div>
<?php endif; ?>