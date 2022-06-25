<?php if ( !defined("root" ) ) die; ?>
<?php if ( empty( $no_ul ) ) : ?>
<ul class="dropdown-menu all_buttons buttons <?php echo !empty( $item["hash"] ) ? "buttons_{$item["hash"]}" : ""; ?>">
<?php endif; ?>

<?php
if ( $type == "artist" )
  $item["hash"] = $item["code"];
elseif ( $type == "widget" )
  $item["hash"] = $item["ID"];
?>

<li class="pauseplay m_add" data-type="<?php echo $type; ?>" data-hook="<?php echo $item["hash"]; ?>"><span class="mdi mdi-play"></span> <span class="text"><?php $loader->lorem->eturn( "play", [ "uc"=>true ] ); ?></span></li>

<?php if ( $this->loader->admin->get_setting("station",1) ) : ?>
<li class="m_add" data-type="<?php echo $type; ?>" data-hook="<?php echo $item["hash"]; ?>" data-radio="1"><span class="mdi mdi-antenna"></span> <?php $loader->lorem->eturn("start_station",["uc"=>true]); ?></li>
<?php endif; ?>

<?php if ( !empty( $item["tracks_hashes"] ) ) : ?>
<li class="m_attp" data-hook="<?php echo implode( ",", $item["tracks_hashes"] ); ?>"><span class="mdi mdi-plus-circle"></span> <?php $loader->lorem->eturn("add_to_pl",["uc"=>true]); ?></li>
<?php elseif( $type != "artist" ) : ?>
<li class="m_attp" data-hook="<?php echo $item["hash"]; ?>"><span class="mdi mdi-plus-circle"></span> <?php $loader->lorem->eturn("add_to_pl",["uc"=>true]); ?></li>
<?php endif; ?>

<li class="m_add" data-type="<?php echo $type; ?>" data-hook="<?php echo $item["hash"]; ?>" data-que="0"><span class="mdi mdi-play-circle"></span> <?php $loader->lorem->eturn("add_to_qu",["uc"=>true]); ?></li>

<?php if ( !empty( $item["url"] ) ) : ?>
<li class="share_handle"
  data-title="<?php $loader->lorem->eturn( "share_this", [ "uc"=>true, "params"=> [ "target" => $loader->lorem->turn( $type, ["uc"=>true])] ] ) ?>"
  data-url="<?php $loader->ui->eurl( $type, $item["url"] ) ?>"
  data-image="<?php echo !empty( $item["cover_addr"] ) ? $item["cover_addr"] : ( !empty( $item["avatar"] ) ? $item["avatar"] : ( !empty( $item["image"] ) ? $item["image"] : null ) ) ?>"
  data-name="<?php echo $loader->secure->escape( !empty( $item["artist_name"] ) ? $item["artist_name"] . " - " . $item["title"] : $item["name"] ); ?>"
  data-type="<?php echo $type; ?>"
><span class="mdi mdi-share"></span> <?php $loader->lorem->eturn("share",["uc"=>true]); ?></li>
<?php endif; ?>

<?php if ( $type == "track" ) :
$item["is_paid"]  = isset( $item["is_paid"] )  ? $item["is_paid"]  : $loader->track->is_paid( $item["ID"] );
$item["is_liked"] = isset( $item["is_liked"] ) ? $item["is_liked"] : $loader->track->is_liked( $item["ID"] );
?>

  <?php if ( !$item["is_paid"] ) : ?>
  <li><a href='<?php $loader->ui->eurl( $type, $item["url"] ); ?>'><span class="mdi mdi-cart"></span> <?php $loader->lorem->eturn( "buy", [ "uc"=>true ] ); ?> <?php $loader->general->display_price( $item["price"] ); ?></a></li>
  <?php endif; ?>

  <?php if ( !empty( $item["is_download_able"] ) ) : ?>
  <li class="m_dl" data-hook="<?php echo $item["hash"]; ?>"><span class="mdi mdi-cloud-download"></span> <?php $loader->lorem->eturn( "download", [ "uc"=>true ] ); ?></li>
  <?php endif; ?>

  <?php if ( isset( $item["is_reposted"] ) ) : ?>
  <li class="m_repost" data-hook="<?php echo $item["hash"]; ?>"><span class="mdi mdi-repeat"></span> <?php $loader->lorem->eturn( $item["is_reposted"] ? "unrepost" : "repost", [ "uc"=>true ] ); ?></li>
  <?php endif; ?>

  <?php if ( $loader->ui->page_type == "playlist" ? $loader->ui->page_data["playlist"]["collabed"] : false ) : ?>
  <li class="m_rtfp" data-hook="<?php echo $item["hash"]; ?>"><span class="mdi mdi-minus-circle"></span> <?php $loader->lorem->eturn("remove_from_pl",["uc"=>true]); ?></li>
  <?php endif; ?>

  <li class="like_btn like_btn_<?php echo $item["hash"] . ( $item["is_liked"] ? " liked" : "" ); ?> m_like" data-hook="<?php echo $item["hash"]; ?>"><span class="mdi mdi-heart"></span> <span class="text"><?php $loader->lorem->eturn( $item["is_liked"] ? "unlike" : "like", ["uc"=>true] ); ?></span></li>

  <?php if ( $loader->user->has_access( "group", "report" ) ) : ?>
  <li class="report_handle" data-hash="<?php echo $item["hash"]; ?>"><span class="mdi mdi-alert"></span> <span class="text">Report</span></li>
  <?php endif; ?>

<?php elseif ( $type == "album" ) :
$item["is_paid"]  = isset( $item["is_paid"] ) ? $item["is_paid"]  : $loader->album->is_paid( $item["ID"] );
?>

<li class="album_like_handle" data-hook="<?php echo $item["hash"]; ?>"><span class="mdi mdi-heart"></span> <?php $loader->lorem->eturn(!empty($item["liked"])?"unllike":"like",["uc"=>true]); ?></li>

  <?php if ( !$item["is_paid"] ) : ?>
  <li><a href="<?php $loader->ui->eurl( $type, $item["url"] ); ?>"><span class="mdi mdi-cart"></span> <?php $loader->lorem->eturn( "buy", [ "uc"=>true ] ); ?> <?php $loader->general->display_price( $item["price"] ); ?></a></li>
  <?php endif; ?>

  <?php if ( !empty( $item["is_download_able"] ) ) : ?>
  <li class="m_dl" data-hook="<?php echo implode( ",", $item["tracks_hashes"] ); ?>" ><span class="mdi mdi-cloud-download"></span> <?php $loader->lorem->eturn("download",["uc"=>true]); ?></li>
  <?php endif; ?>

<?php elseif ( $type == "artist" ) : ?>
  <li class="artist_subsribe_handle" data-code="<?php echo $item["code"] ?>"><a><span class="mdi mdi-bell"></span> <?php $loader->lorem->eturn( $item["followed"] ? "unsubscribe" : "subscribe", [ "uc"=>true ] ); ?> </a></li>
<?php elseif ( $type == "playlist" ) : ?>

  <li class="playlist_like_handle" data-hook="<?php echo $item["hash"]; ?>" ><span class="mdi mdi-heart"></span> <?php $loader->lorem->eturn(!empty($item["liked"])?"unllike":"like",["uc"=>true]); ?></li>
  <li class="playlist_subscribe_handle" data-hook="<?php echo $item["hash"]; ?>"><span class="mdi mdi-bell"></span> <?php $loader->lorem->eturn(!empty($item["followed"])?"unsubscribe":"subscribe",["uc"=>true]); ?></li>

   <?php if ( $item["owner"]["ID"] == $loader->visitor->user()->ID ) : ?>
   <li class="remove_playlist_handle" data-hook="<?php echo $item["hash"]; ?>"><span class="mdi mdi-delete"></span> <?php $loader->lorem->eturn("delete",["uc"=>true]); ?></li>
   <li class="edit_playlist_handle" data-hook="<?php echo $item["hash"]; ?>" data-name="<?php echo $item["name"]; ?>" data-collabs="<?php echo $item["collabs_o"]; ?>"><span class="mdi mdi-pencil"></span> <?php $loader->lorem->eturn("edit",["uc"=>true]); ?></li>
   <?php endif; ?>

  <?php if ( !empty( $item["is_download_able"] ) ) : ?>
  <li class="m_dl" data-hook="<?php echo implode( ",", $item["tracks_hashes"] ); ?>"><span class="mdi mdi-cloud-download"></span> <?php $loader->lorem->eturn("download",["uc"=>true]); ?></li>
  <?php endif; ?>

<?php endif; ?>

<?php if ( empty( $no_ul ) ) : ?>
</ul>
<?php endif; ?>
