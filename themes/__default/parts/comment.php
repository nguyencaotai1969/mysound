<?php if ( !defined("root" ) ) die;
$depth = empty( $depth ) ? 1 : $depth;
?>
<div class="comment <?php echo $comment["liked"] ? "liked" : ""; echo " depth-{$depth}" ?>" id="comment_<?php echo $comment["ID"]; ?>">
  <div class="avatar"><a href='<?php $loader->ui->eurl( "user", $comment["user"]["username"] ) ?>'><img alt="<?php echo $comment["user"]["username"]; ?>" src="<?php echo $comment["user"]["avatar"]; ?>"></a></div>
  <div class="name">
    <a href='<?php $loader->ui->eurl( "user", $comment["user"]["username"] ) ?>'><?php echo $comment["user"]["name"]; ?></a>
    <div class="time"><?php echo $loader->general->passed_time_hr( $comment["time_add"], 1, " , " )["string"] . " " . $loader->lorem->turn("ago"); ?></div>
    <?php if ( !empty( $comment["likes"] ) ) : ?>
    <div class="like_count"><?php echo number_format( $comment["likes"] ) . " " . $loader->lorem->turn("likes"); ?></div>
    <?php endif; ?>
  </div>
  <div class="text"><?php echo $comment["text"]; ?></div>
    <div class="buttons">
      <a class="btn btn-light btn-sm like_comment_handle" data-ID="<?php echo $comment["ID"]; ?>"><span class="mdi mdi-heart"></span><?php $loader->lorem->eturn( !$comment["liked"] ? "like" : "unlike",["uc"=>true]); ?></a>
      <?php if ( !empty( $comment["likes"] ) ) : ?>
      <span class="likes_count">+<?php echo number_format( $comment["likes"] ); ?></span>
      <?php endif; ?>
      <?php if ( $depth < 3 ) : ?>
      <a class="btn btn-light btn-sm reply_comment_handle" data-ID="<?php echo $comment["ID"]; ?>" data-target="<?php echo $comment["user"]["username"]; ?>"><?php $loader->lorem->eturn("reply",["uc"=>true]); ?></a>
      <?php endif; ?>
      <?php if ( $comment["user"]["ID"] == $loader->user->ID ) : ?>
      <a class="btn btn-light btn-sm delete_comment_handle" data-ID="<?php echo $comment["ID"]; ?>"><?php $loader->lorem->eturn("delete",["uc"=>true]); ?></a>
      <?php endif; ?>
    </div>
</div>
<?php if ( !empty( $comment["childs"] ) ) {
  foreach( $comment["childs"] as $child_comment ) {
    echo $loader->theme->set_name('__default')->__req( "parts/comment.php", false, [ "comment" => $child_comment, "depth" => $depth+1 ] );
  }
} ?>
