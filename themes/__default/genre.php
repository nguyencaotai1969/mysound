<?php if ( !defined("root" ) ) die;  ?>
<div class="container page genre_page <?php echo empty( $page_data["items"] ) ? "no_result" : ""; ?>" >

  <?php if ( empty( $page_data["items"] ) ) : ?>

      <?php if ( !empty( $loader->ui->page_hook ) ) : ?>
      <div class="no_result_text"><?php $loader->lorem->eturn( 'genre_no_res' ); ?></div>
      <?php endif; ?>
      <div class="row">
      <?php
	  $loader->ui->load_page_widget( [
		  "type" => "genre_slider",
		  "sett" => [ "class" => [ "noslide" ], "size" => "large" ],
	  ] );
	  ?>
	  </div>

  <?php else : ?>

   <div id="side">
      <div class="genres">
      <div class="row">
        <?php
		$loader->ui->load_page_widget( [
		    "type" => "genre_slider",
		    "sett" => [ "size" => "medium" ],
	    ] );
		?>
	  </div>
      </div>
    </div>
    <div id="results">

	  <div class="row">
  	  <?php
	  $loader->ui->load_page_widget( [
		  "type" => "album_slider", 
		  "sett" => [ "pagination" => true, "size" => "medium", "class" => [ "noslide" ] ],
		  "limit" => $page_data["items_limit"],
	  ], $page_data["items"] );
	  ?>
	  </div>

	  <?php if ( !empty( $page_data["has_more"] ) ) : ?>
	  <div class="pages">
	    <div class="pager next"><a href="<?php $loader->ui->eurl( null, $loader->ui->page_uri, "p=" . ( $page_data["page"]+1 ) ) ?>"><?php $loader->lorem->eturn( "next_page", [ "uc" => true ] ); ?></a></div>
	  </div>
  	  <?php endif; ?>

  	</div>

  <?php endif; ?>


</div>
