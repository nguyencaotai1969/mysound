<?php if ( !defined( "root" ) ) die; ?>
<div class="box-title">
  <div class="icon"><span class="mdi mdi-video-input-component"></span></div>
  <div class="title">Page Builder</div>
</div>

<?php if ( empty( $page_data["active"] ) && !isset( $_GET["new"] ) ) : ?>

<div class="box">

  <div class="groups">
    <?php if ( !empty( $page_data["pages"] ) ) : foreach( $page_data["pages"] as $page ) : ?>
    <div class="group">
      <div class="label"><?php echo $loader->secure->escape( $page["name"] ); if ( $page["landing"] ) echo " <span>( index )</span>" ?></div>
      <div class="buttons">
      	<a class="button" href="<?php $loader->ui->eurl( "admin_page_editor", null, "name={$page["name"]}" ) ?>">Edit</a>
        <?php if ( !$page["landing"] ) : ?>
          <div class="button index_page_handle" data-hook="<?php echo $page["ID"]; ?>">Index</div>
          <div class="button remove_page_handle" data-hook="<?php echo $page["ID"]; ?>" data-name="<?php echo $loader->secure->escape( $page["name"] ); ?>">Remove</div>
        <?php endif; ?>
      </div>
    </div>
    <?php endforeach; endif; ?>
  </div>

  <div class="foot_buttons">
    <a class="btn btn-wide btn-primary" href="<?php $loader->ui->eurl( "admin_page_editor", null, "new" ) ?>">+ New Page</a>
  </div>

</div>


<?php else : ?>

<div class="box">
  <div id="builder" class="menus pb"><div class="row"></div></div>
  <div class="warn_wrapper"></div>
  <div class="foot_buttons">
    <a class="btn btn-wide btn-primary new_page_handle">+ New Widget</a>
    <a class="btn btn-wide btn-success save_page_handle">Save Page</a>
  </div>
</div>

<script>
var $__pageName = <?php echo empty( $page_data["active"] ) ? "null" : "\"{$page_data["active"]["name"]}\""; ?>;
var $__pageUrl = <?php echo empty( $page_data["active"] ) ? "null" : "\"{$page_data["active"]["url"]}\""; ?>;
var $__pageWidgets  = <?php echo empty( $page_data["active"] ) ? "{}" : "JSON.parse('{$page_data["items"]}')"; ?>;
var $__genres = JSON.parse('<?php echo $loader->general->json_encode( $loader->genre->get_all_simplfied() ); ?>');
var $__banner_sizes = JSON.parse('<?php echo $loader->general->json_encode( $loader->ads->getBannerSizes("for_select") ); ?>');
$__genres.unshift( [ "all", "All Genres" ] );

$(document).ready(function(){

	__translate_data_to_doms();
	__hook();

});
</script>

<?php endif; ?>
