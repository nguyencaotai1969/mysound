<?php if ( !defined("root" ) ) die;
if ( !empty( $setting["has_more"] ) ? ( empty( $page ) ? !empty( $setting["linked"] ) && !empty( $setting["title"] ) : true ) : false ) : ?>
<div class="pages">
  <?php if ( !empty( $page ) && $setting["page"] > 1 ) : ?>
  <div class="pager prev"><a href="<?php $loader->ui->eurl( null, $loader->ui->page_uri, "w={$widget["ID"]}&p=" . ($setting["page"]-1)) ?>"><?php $loader->lorem->eturn("prev_page") ?></a></div>
  <?php endif; ?>
  <?php if ( !empty( $setting["has_more"] ) ? ( empty( $page ) ? !empty( $setting["linked"] ) && !empty( $setting["title"] ) : true ) : false ) : ?>
  <div class="pager next"><a href="<?php $loader->ui->eurl( null, $loader->ui->page_uri, "w={$widget["ID"]}&p=" . ($setting["page"]+1)) ?>"><?php $loader->lorem->eturn("next_page") ?></a></div>
  <?php endif; ?>
</div>
<?php endif; ?>