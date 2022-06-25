<?php if ( !defined( "root" ) ) die; ?>
<?php
$page_data = $this->loader->ui->page_data;
$items = $page_data["items"];
?>

<div class="box-title">
  <div class="icon"><span class="mdi mdi-menu-open"></span></div>
  <div class="title">Menu Builder</div>
</div>

<?php if ( empty( $page_data["name"] ) ) : ?>

<div class="box">

  <div class="groups">
    <?php if( !empty( $page_data["menus"] ) ) : foreach( $page_data["menus"] as $_menu_group_name ) : ?>
    <div class="group">
      <div class="label"><?php echo $loader->secure->escape( $_menu_group_name ); ?></div>
      <div class="buttons">
      	<a class="button" href="<?php $loader->ui->eurl( "admin_menu_editor", null, "name={$_menu_group_name}" ) ?>">Edit</a>
      	<div class="button remove_menu_handle" data-name="<?php echo $loader->secure->escape( $_menu_group_name ); ?>">Remove</div>
      </div>
    </div>
    <?php endforeach; endif; ?>
  </div>

  <div class="foot_buttons">
    <a class="btn btn-wide btn-primary" href="<?php $loader->ui->eurl( "admin_menu_editor", null, "name=menu_name" ) ?>">+ New menu</a>
  </div>

</div>

<?php else : ?>

<div class="box">

  <div id="builder" class="menus"></div>

  <div class="foot_buttons">
    <a class="btn btn-wide btn-primary add_menu_item_handle">+ New Item</a>
    <a class="btn btn-wide btn-success save_menu_handle">Save Menu</a>
  </div>

</div>

<script>

var $menu_name = <?php echo $page_data["name"] ? "\"{$page_data["name"]}\"" : "false" ?>;
var $items = JSON.parse('<?php echo json_encode( $items ); ?>');
var $selected_item = null;
var $selected_e = null;

$(document).ready(function(){
	buildItems();
	hook();
});

</script>

<?php endif; ?>
