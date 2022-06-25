<?php
if ( !defined("root" ) ) die;
$playlist = $loader->ui->page_data["playlist"];
if ( empty( $playlist["tracks"] ) ) :

$loader->lorem->eturn( "user_empty_playlist" );

else : ?>
<div class="page_head album playlist" data-id="<?php echo $playlist["hash"]; ?>">
<div class="container">

  <div class="bg_wrapper" style="background-image: url('<?php echo $playlist["cover"]; ?>')"><img alt="<?php echo $playlist["name"]; ?>" src="<?php echo $playlist["cover"]; ?>"></div>

  <div class="t_wrapper a_dom dom_playlist_<?php echo $playlist["hash"] ?>">

    <div class="cover_wrapper">
      <div class="_cover" style="background-image: url('<?php echo $playlist["cover"]; ?>')"><img alt="<?php echo $playlist["name"]; ?>" src="<?php echo $playlist["cover"]; ?>"></div>
    </div>

    <div class="data_wrapper">

	  <div class="play_buttons buttons buttons_<?php echo $playlist["hash"]; ?>">

      	  <div class="button play_btn">
		  <a class="btn btn-light play pauseplay m_add" data-type="playlist" data-hook="<?php echo $playlist["hash"]; ?>" >
      	    <span class="mdi mdi-play"></span>
      	  </a>
		  </div>

		  <?php if ( $this->loader->admin->get_setting("station",1) ) : ?>
      	  <div class="button radio_btn m_add" data-type="playlist" data-hook="<?php echo $playlist["hash"]; ?>" data-radio="1" >
      	    <a class="btn btn-light more"><span class="mdi mdi-antenna"></span></a>
      	  </div>
		  <?php endif; ?>

      <div class="button playlist_like_handle <?php echo $playlist["liked"] ? "liked" : ""; ?>" data-hook="<?php echo $playlist["hash"]; ?>">
        <a class="btn btn-light more"><span class="mdi mdi-heart-outline"></span></a>
      </div>

      <div class="button more_btn button_more" data-type="playlist" data-hash="<?php echo $playlist["hash"]; ?>">
        <a class="btn btn-light more"><span class="mdi mdi-dots-horizontal"></span></a>
      </div>

      </div>

      <div class="title"><?php echo $playlist["name"]; ?></div>

      <div class="others">

        <?php if ( $playlist["user_id"] ) : ?>
        <div class="artist">
          <a href="<?php $loader->ui->eurl( "user_playlists", $playlist["owner"]["username"] ); ?>"><img alt="<?php echo $playlist["owner"]["username"]; ?>" src="<?php echo $playlist["owner"]["avatar"]; ?>"></a>
          <label><?php $loader->lorem->eturn( "created_by" ); ?></label><a href="<?php $loader->ui->eurl( "user_playlists", $playlist["owner"]["username"] ); ?>"><?php echo $playlist["owner"]["username"]; ?></a>
        </div>

        <?php endif; ?>
        <div class="subs">
          <span class="mdi mdi-account"></span>
          <?php echo $playlist["followers"] . " " . $loader->lorem->turn( "subscribes" ); ?>
        </div>

        <div class="time">
          <span class="mdi mdi-clock"></span>
          <?php echo $loader->general->passed_time_hr( time() - strtotime( $playlist["time_update"] ), 1 )[ "string" ]; ?> <?php $loader->lorem->eturn( "ago" ); ?>
        </div>

      </div>

    </div>

  </div>

</div>
</div>
<div id="tracks_table">
  <div class="container page">
  <div class="row">

    <?php
    $cols = [ "cover", "i" => [ "btn" => "play" ], "title", "like_btn", "duration" => [ "btn" => "all" ] ];
    if ( $playlist["collabed"] ) array_unshift( $cols, "sort" );
    $loader->ui->load_page_widget(
      [
        "type" => "track_table",
        "sett" => [
          "id" => "album_tracks",
          "limit" => 100,
          "table_cols" => $cols,
        ]
      ],
      $playlist["tracks"]
    );
    if ( $playlist["collabed"] ) : ?>
    <script>
    $(document).on("pageInlined",function(){
      sortable_table({
        hook: "<?php echo $playlist["hash"]; ?>"
      });
    });
    </script>
    <?php endif; ?>

  </div>
  </div>
</div>
<?php endif; ?>

<?php
$loader->ui->load_page_widget( [ "type" => "pl", "sett" => [ "pl_code" => "playlist_page" ] ] );
?>
