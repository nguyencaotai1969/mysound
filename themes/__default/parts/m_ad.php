<?php if ( !defined("root" ) ) die;
if ( empty( $loader->ads->getPlacements()[$placement] ) ) return;
$placement_data = $loader->ads->getPlacements()[$placement]; ?>

<div class="pl_wrapper pl_<?php echo $placement; ?> pl_size_<?php echo "{$placement_data["size"]["w"]}_{$placement_data["size"]["h"]}"; ?>" data-ad-id="<?php echo $ad["order_no"]; ?>">

  <?php if ( $ad["type"] == "adsense" ) : ?>
    <?php echo $ad["code"]; ?>
  <?php else : ?>
  <div class="pl" style='background-image:url("<?php echo $ad["files_urls"]["banner"]; ?>")'>
    <img src='<?php echo $ad["files_urls"]["banner"]; ?>'>
  </div>
  <?php endif; ?>

</div>
