<?php if ( !defined("root" ) ) die; ?>

<li <?php if ( !empty( $not["data"]["hook"]["simplified"]["url"] ) ) : ?>onclick="pager.page_load( '<?php echo $not["data"]["hook"]["simplified"]["url"] ?>' )"<?php endif; ?> class="<?php
echo "type_" . $not["type"] . " ";
if ( $user_time ? strtotime( $not["time_add"] ) > $user_time : true  )
echo "new";
?>">
  <div class="avatar_wrapper">
    <?php if ( !empty( $not["data"]["hook"]["simplified"]["icon"] ) ) : ?>
    <span class="avatar <?php echo $not["data"]["hook"]["simplified"]["icon"]; ?>"></span>
    <?php else : ?>
    <img class="avatar" alt="<?php echo $not["user"]["username"]; ?>" src="<?php echo $not["user"]["avatar"]; ?>">
    <?php endif; ?>
    <span class="mdi mdi-<?php echo $not["type_data"]["icon"]; ?>"></span>
  </div>
  <div class="text">
    <?php echo $not["text"]; ?>
    <div class="time"><?php echo $not["time"]; ?></div>
  </div>
</li>
