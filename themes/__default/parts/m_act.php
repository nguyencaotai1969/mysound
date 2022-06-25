<?php if ( !defined("root" ) ) die; ?>
<div class="track <?php echo !empty( $user_act["class"] ) ? $user_act["class"] : ""; ?>">

  <div class="user_wrapper">
    <div class="avatar a1"><a href="<?php $loader->ui->eurl( "user", $user_act["user"]["username"] ); ?>"><img alt="<?php echo $user_act["user"]["username"] ?>" src="<?php echo $user_act["user"]["avatar"]; ?>"></a></div>
    <div class="avatar a2"><a href="<?php echo $user_act["data"]["hook"]["simplified"]["url"]; ?>"><img alt="<?php echo $user_act["data"]["hook"]["simplified"]["title"] ?>" src="<?php echo $user_act["data"]["hook"]["simplified"]["image"]; ?>"></a></div>
    <div class="data"><?php echo $user_act["text"] ?></div>
    <div class="time"><?php $loader->lorem->eturn( "time_ago", [ "params" => ["time" => $user_act["time" ] ] ] ); ?></div>
  </div>

  <?php if ( $user_act["type_data"]["display_type"] == "track" ) : ?>
  <div class="act_data_wrapper track_wrapper">

    <div class="cover"><a href="<?php $loader->ui->eurl( "track", $user_act["data"]["track"]["url"] ); ?>"><img alt="<?php echo $user_act["data"]["track"]["title"] ?>" src="<?php echo $user_act["data"]["track"]["cover_addr"]; ?>"></a></div>
    <div class="title">
      <div class="buttons buttons_<?php echo $user_act["data"]["track"]["hash"]; ?>">
        <a data-hook="<?php echo $user_act["data"]["track"]["hash"]; ?>" class="pauseplay m_add"><span class="mdi mdi-play"></span></a>
      </div>
      <a href="<?php $loader->ui->eurl( "track", $user_act["data"]["track"]["url"] ); ?>"><?php echo $user_act["data"]["track"]["title"]; ?></a>
    </div>
    <div class="stats">

      <div class="stat"><span class="mdi mdi-eye"></span> <?php echo number_format($user_act["data"]["track"]["views"]); ?></div>
      <div class="stat"><span class="mdi mdi-music-note"></span> <?php echo number_format($user_act["data"]["track"]["play_full"]); ?></div>
      <div class="stat"><span class="mdi mdi-heart"></span> <?php echo number_format($user_act["data"]["track"]["likes"]); ?></div>

    </div>
  </div>
  <?php elseif ( $user_act["type_data"]["display_type"] == "comment" ) : ?>
  <div class="act_data_wrapper comment_wrapper">
    <a href="<?php echo $loader->ui->rurl( "track", $user_act["data"]["comment"]["track"]["url"], "#comment_{$user_act["data"]["comment"]["ID"]}" ); ?>"><?php echo $user_act["data"]["comment"]["text"]; ?></a>
  </div>
  <?php elseif ( $user_act["type_data"]["display_type"] == "user" ) : ?>
  <?php endif; ?>

</div>
