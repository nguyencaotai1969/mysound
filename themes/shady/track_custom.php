<?php if ( !defined("root" ) ) die;

$track = $loader->ui->page_data;

$random_tracks = $loader->track->select( [
	"singular"  => false,
	"limit"     => 10,
	"order_by"  => "rand()",
  "order" => ""
] );

$random_tracks2 = $loader->track->select( [
	"singular"  => false,
	"limit"     => 4,
	"order_by"  => "rand()",
  "order" => ""
] );

?>
<style>
#main .page_head.track .stats {
    margin-top: 20px;
}

#main .page_head.track .stats .stat {
    float: left;
    margin-right: 10px;
    opacity: 0.4;
    background: rgba(0,0,0,0.2);
    padding: 4px 8px;
    line-height: 1;
    border-radius: 3px;
    font-size: 11pt;
}

#main .page_head.track .stats:after {
    content: "";
    display: block;
    clear: both;
    float: none;
}

#main .page_head.track .stats .stat span {
    margin-right: 3px;
    opacity: 0.6;
}

#main .play_buttons.buttons .button .btn.custom {
    white-space: nowrap;
    font-size: 11pt;
    display: inline-block;
    background: rgb(0 0 0 / 15%);
    border-radius: 6px;
    padding: 8px 15px;
    margin-left: 10px;
}

#main .play_buttons.buttons .button .btn.custom span {
    display: inline-block;
    margin-right: 10px;
}

#main .track_sidebar .sideside .side_widget:first-child {
  margin-top: 0
}

@media (max-width: 1023px){
  #main .page_head.track .stats {
    text-align: center;
  }
  #main .page_head.track .stats .stat {
    display: inline-block;
    float: none
  }
}
@media (max-width: 1000px ){
	#main .play_buttons.buttons .button.custom_wp {
		display: block;
		margin: auto;
		width: auto;
	}
}
</style>
<div class="page_head track <?php echo ( !empty( $track["source"] ) ? $track["source"]["type"] == "file" || $track["source"]["type"] == "file_r" : false ) && $loader->hit->agent_data["device"]["type"] == "desktop" ? "has_wave" : "no_wave"; ?>">
  <div class="container">

	<div class="bg_wrapper track" style="background-image: url('<?php echo $track["cover"]; ?>')"><img alt="<?php echo $track["title"]; ?>" src="<?php echo $track["cover"]; ?>"></div>

    <div class="t_wrapper">

      <div class="cover" style="background-image: url('<?php echo $track["cover"]; ?>')"><img alt="<?php echo $track["title"]; ?>" src="<?php echo $track["cover"]; ?>"></div>
      <div class="play_buttons buttons buttons_<?php echo $track["hash"]; ?>">

        <div class="button play_btn">
          <a class="btn btn-light play pauseplay m_add" data-hook="<?php echo $track["hash"]; ?>">
            <span class="mdi mdi-play"></span>
          </a>
        </div>

        <?php if ( !$track["is_paid"] ) : ?>

          <div class="button purchase_btn purchase_handle"
          data-title="<?php $loader->lorem->eturn( 'purchase_song', [ "uc" => true ] ) ?>"
          data-item-title="<?php echo $loader->secure->escape( $track["artist_name"] . " - " . $track["title"] ); ?>"
          data-item-price="<?php echo $track["price"]; ?>"
          data-fund="<?php echo $loader->user->data["fund"]; ?>"
          data-item-hook="<?php echo $track["hash"]; ?>"
          data-item-type="track">
          <a class="btn btn-light more"><span class="mdi mdi-cart"></span></a>
        </div>

      <?php else : ?>

        <?php if ( $this->loader->admin->get_setting("station",1) ) : ?>
          <div class="button radio_btn m_add" data-hook="<?php echo $track["hash"]; ?>" data-radio="1">
            <a class="btn btn-light more"><span class="mdi mdi-antenna"></span></a>
          </div>
        <?php endif; ?>

        <div class="button like_btn like_btn_<?php echo $track["hash"] . ( $track["is_liked"] ? " liked" : "" ); ?> m_like" data-hook="<?php echo $track["hash"]; ?>">
          <a class="btn btn-light more"><span class="mdi mdi-heart-outline"></span></a>
        </div>

      <?php endif; ?>

      <div class="button more_btn button_more" data-type="track" data-hash="<?php echo $track["hash"]; ?>">
        <a class="btn btn-light more"><span class="mdi mdi-dots-horizontal"></span></a>
      </div>

      <?php if ( !$track["is_paid"] ) : ?>

        <div class="button custom_wp purchase_btn purchase_handle"
        data-title="<?php $loader->lorem->eturn( 'purchase_song', [ "uc" => true ] ) ?>"
        data-item-title="<?php echo $loader->secure->escape( $track["artist_name"] . " - " . $track["title"] ); ?>"
        data-item-price="<?php echo $track["price"]; ?>"
        data-fund="<?php echo $loader->user->data["fund"]; ?>"
        data-item-hook="<?php echo $track["hash"]; ?>"
        data-item-type="track">
          <a class="btn btn-light custom"><span class="mdi mdi-cart"></span><?php $loader->lorem->eturn( "buy", [ "uc"=>true ] ); ?> <?php $loader->general->display_price( $track["price"] ); ?></a>
        </div>

      <?php elseif ( !empty( $track["is_download_able"] ) ) : ?>

      <div class="button custom_wp m_dl" data-hook="<?php echo $track["hash"]; ?>">
        <a class="btn btn-light custom"><span class="mdi mdi-cloud-download"></span><?php $loader->lorem->eturn( "download", [ "uc"=>true ] ); ?></a>
      </div>

      <?php endif; ?>

      <div class="stats">
  	    <div class="stat"><span class="mdi mdi-eye"></span> <?php echo number_format($track["views"]); ?></div>
  	    <div class="stat"><span class="mdi mdi-music-note"></span> <?php echo number_format($track["play_full"]); ?></div>
  	    <div class="stat"><span class="mdi mdi-heart"></span> <?php echo number_format($track["likes"]); ?></div>
  	    <div class="stat"><span class="mdi mdi-view-list"></span> <?php echo number_format($track["playlisteds"]); ?></div>
  	    <div class="stat"><span class="mdi mdi-repeat"></span> <?php echo number_format($track["reposts"]); ?></div>
  	    <div class="stat"><span class="mdi mdi-comment"></span> <?php echo number_format($track["comments"]); ?></div>
  	  </div>

      </div>
      <div class="data_wrapper">

        <div class="title"><?php echo $track["title"]; ?></div>
        <div class="others">
          <div class="artist">
            <a href="<?php $loader->ui->eurl( "artist", $track["artist"]["url"] ); ?>">
              <img src="<?php echo $track["artist"]["image"]; ?>" alt="<?php echo $track["artist"]["name"]; ?>">
              <?php echo $track["artist"]["name"]; ?>
            </a>
          </div>
          <div class="album">
            <a href="<?php $loader->ui->eurl( "album", $track["album"]["url"] ); ?>">
              <span class="mdi mdi-album"></span>
              <?php echo $track["album"]["title"]; ?>
            </a>
          </div>
          <?php if ( $track["genre"]["ID"] > 1 ) : ?>
            <div class="genre">
              <a href="<?php $loader->ui->eurl( "genre", $track["genre"]["url"] ); ?>">
                <span class="mdi mdi-tag"></span>
                <?php echo $track["genre"]["name"]; ?>
              </a>
            </div>
          <?php endif; ?>
          <div class="time">
            <span class="mdi mdi-clock"></span>
            <?php echo $loader->general->passed_time_hr( time() - strtotime( $track["time_release"] ), 1 )[ "string" ]; ?> <?php $loader->lorem->eturn( "ago" ); ?>
          </div>
          <?php if( $page_data["uploader"] ) : ?>
            <div class="uploader">
              <a href='<?php $loader->ui->eurl( "user_uploads", $page_data["uploader"]["username"] ) ?>'>
                <span class="mdi mdi-account"></span>
                <?php echo $page_data["uploader"]["name"]; ?>
              </a>
            </div>
          <?php endif; ?>
        </div>

        <?php if( !empty( $track["other_artists"] ) ): ?>
          <div class="artists_featured">
            <?php $loader->lorem->eturn( "featuring", [ "uc" => true ] ); ?>
            <?php foreach( $track["other_artists"] as $other_artist ) : ?>
              <div class="artist_featured">
                <a href="<?php $loader->ui->eurl( "artist", $other_artist["url"] ); ?>"><img src="<?php echo $other_artist["image"]; ?>" alt="<?php echo $other_artist["name"]; ?>"><?php echo $other_artist["name"]; ?></a>
              </div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>

      </div>

	  <?php if ( !empty( $track["source"]["type"] ) && !empty( $loader->hit->agent_data["device"]["type"] ) ? ( $track["source"]["type"] == "file" || $track["source"]["type"] == "file_r" ) && $loader->hit->agent_data["device"]["type"] == "desktop" : false ) : ?>
	  <div id="waveform" data-hash="<?php echo $track["hash"]; ?>" class="wave_<?php echo $track["hash"]; ?> p_w">

        <?php if ( !empty( $track["source"]["wave_bg"] ) && !empty( $track["source"]["wave_pr"] ) ) : ?>

          <img class="bg" alt="progress_Bg" src="<?php echo $track["source"]["wave_bg"]; ?>">
          <div class="pr">
      	    <img alt="progress_Pr" src="<?php echo $track["source"]["wave_pr"]; ?>">
          </div>

          <?php if ( $page_data["user_comments_time"] ) : ?>
            <div class="comments">
	          <?php foreach( $page_data["user_comments_time"] as $comment ) : ?>
              <div class="comment <?php echo $comment["pos"] > 70 ? "right" : ( $comment["pos"] < 20 ? "left first" : "left" ); ?>" data-time="<?php echo $comment["target_seek"] ?>" style="left: <?php echo $comment["pos"] ?>%" >
                <div class="avatar"><img alt="<?php echo $comment["user"]["username"]; ?>" src="<?php echo $comment["user"]["avatar"]; ?>"></div>
                <div class="text">
                  <div class="name">@<?php echo $comment["user"]["username"] ?> AT <?php echo $loader->general->hr_seconds( $comment["target_seek"] ) ?></div>
                  <?php echo $comment["text"]; ?>
                </div>
              </div>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>

        <?php elseif ( !$loader->admin->get_setting("ffmpeg") || !$loader->admin->get_setting("ffmpeg_wave") || $track["source"]["type"] == "file_r" ) : ?>

          <div id="wavesurfer_wrapper">

          	<div class="text_overlay">Generating waveform, wait please ...</div>
          	<div id="wavesurfer_container"></div>

          </div>
          <script>
          $.getScript( $_home + "themes/__default/assets/third/wavesurfer.js" ).done(function( script, textStatus ) {
            var wavesurfer = WaveSurfer.create({
              container: '#wavesurfer_container',
              fillParent: true,
              waveColor: '#000',
              progressColor: '#fff',
              cursorColor: '#aaa',
              height: 100,
              barWidth: 2,
              barGap: 1
            });

            <?php
            $_SESSION["wave_track_hash"]  = $track["hash"];
            $_SESSION["wave_hash"]   = md5( uniqid() . microtime(1) . rand(1,66666666) );
            $_SESSION["wave_file"]   = $track["source"]["data"];
            $_SESSION["wave_expire"] = time() + (3*60);
            if ( $track["source"]["type"] == "file_r" ){
              $durl = $loader->general->path_to_addr( $track["source"]["data"] );
            }
            ?>
            wavesurfer.load('<?php echo $track["source"]["type"] == "file" ? $loader->ui->rurl( null, "waveform.php", "hash={$_SESSION["wave_hash"]}" ) : $durl ?>');

            wavesurfer.on('ready', function () {

              setTimeout(function(){

                let waveform = wavesurfer.exportImage();
                waveform = typeof( waveform ) == "string" ? waveform : waveform[0];

                be_cli({
                  action: "waveform_create",
                  url: "<?php $loader->ui->eurl( "track", $track["url"] ) ?>",
                  data: {
                    data: waveform,
                    hash: '<?php echo $_SESSION["wave_hash"]; ?>',
                    track_hash: '<?php echo $track["hash"] ?>'
                  },
                  goodHeader: 200,
                  callBack: function(){
                    pager.page_reload();
                  }
                });



              },2500);

            });

          });
          </script>

        <?php else : ?>

          <div id="wavesurfer_wrapper">

          	<div class="text_overlay">Generating waveform, wait please ...</div>
          	<div id="wavesurfer_container"></div>

          </div>

          <?php
          $_SESSION["wave_track_hash"]  = $track["hash"];
          $_SESSION["wave_hash"]   = md5( uniqid() . microtime(1) . rand(1,66666666) );
          $_SESSION["wave_file"]   = $track["source"]["data"];
          $_SESSION["wave_expire"] = time() + (3*60);
          ?>

          <script>
          $(document).ready(function(){
            be_cli({
              action: "waveform_create",
              url: "<?php $loader->ui->eurl( "track", $track["url"] ) ?>",
              data: {
                hash: '<?php echo $_SESSION["wave_hash"]; ?>',
                track_hash: '<?php echo $track["hash"] ?>'
              },
              goodHeader: 200,
              callBack: function(){
                pager.page_reload();
              }
            });
          });
          </script>

        <?php endif; ?>
	  </div>
    <?php endif; ?>

    </div>

  </div>
</div>

<div id="track_data" class="<?php echo $page_data["comments"] ? "has_comment" : "no_comment"; ?>">
<div class="container">

  <div class="track_sidebar page">

    <div class="row">
      <div class="col-12 col-lg-7 col-xl-9">

        <div class="add_comment">
              <form id="post_comment" data-track-id="<?php echo $track["hash"]; ?>">
                <div class="avatar"><img alt="<?php echo $loader->user->username; ?>" src="<?php echo $loader->user->avatar; ?>"></div>
                <input id="PID" name="PID" type="hidden">
                <input id="comment" name="comment" type="text" autocomplete="off" class="form-control" placeholder="<?php $loader->lorem->eturn( "comment_placeholder" ); ?>">
              </form>
        </div>

        <?php if( $page_data["uploader"] && ( $page_data["text_data"]["comment"] || $page_data["text_data"]["lyrics"] ) ) : ?>
        <div class="comments owner_comment">
          <div class="comment">
            <div class="avatar"><a href='<?php $loader->ui->eurl( "user", $page_data["uploader"]["username"] ) ?>'><img alt="<?php echo $page_data["uploader"]["username"]; ?>" src="<?php echo $page_data["uploader"]["avatar"]; ?>"></a></div>
            <div class="name">
              <a href='<?php $loader->ui->eurl( "user", $page_data["uploader"]["username"] ) ?>'><?php echo $page_data["uploader"]["name"]; ?></a>
            </div>
            <div class="text"><?php echo $page_data["text_data"]["comment"] . ( $page_data["text_data"]["comment"] && $page_data["text_data"]["lyrics"] ? "<div class='divider'></div>" : "" ) . $page_data["text_data"]["lyrics"]; ?></div>
          </div>
        </div>
        <?php endif; ?>

        <?php if( $page_data["comments"] ) :?>
        <div class="comments">
          <div class="title"><span class="mdi mdi-comment"></span><?php $loader->lorem->eturn( "comments_title",[ "params" => [ "count" => number_format( $page_data["comments"] ) ] ] ); ?></div>
            <?php foreach( $page_data["user_comments"] as $comment ){
              echo $loader->theme->set_name('__default')->__req( "parts/comment.php", false, [ "comment" => $comment ] );
            }; ?>
        </div>
        <?php endif; ?>

        <?php if ( $page_data["related"] ) : ?>
          <div class="side_widget tracks">
            <div class="title"><span class="mdi mdi-headphones"></span><?php $loader->lorem->eturn( "ts_more_track", ["uc"=>true] ); ?></div>
            <div class="content">
              <?php $loader->ui->load_page_widget( [ "type" => "track_slider", "sett" => [ "arrows" => true ] ], $page_data["related"] ); ?>
            </div>
          </div>
        <?php endif; ?>

        <div class="side_widget tracks">
          <div class="title"><span class="mdi mdi-headphones"></span><?php $loader->lorem->eturn( "ts_random_track", ["uc"=>true] ); ?></div>
          <div class="content">
            <?php $loader->ui->load_page_widget( [ "type" => "track_slider", "sett" => [ "arrows" => true ] ], $random_tracks ); ?>
          </div>
        </div>

      </div>
      <div class="col-12 col-lg-5 col-xl-3 sideside"><?php if ( $page_data["related"] ) : ?>

        <div class="side_widget tracks">
          <div class="title"><span class="mdi mdi-headphones"></span><?php $loader->lorem->eturn( "ts_random_track", ["uc"=>true] ); ?></div>
          <div class="content">
            <?php $loader->ui->load_page_widget( [ "type" => "track_slider", "sett" => [ "arrows" => true, "class" => [ "noslide" ], "size" => "small" ] ], $random_tracks2 ); ?>
          </div>
        </div>

        <?php if ( $page_data["playlists"] ) : ?>
          <div class="side_widget playlists">
            <div class="title"><span class="mdi mdi-playlist-music"></span><?php $loader->lorem->eturn( "ts_in_playlists", ["uc"=>true] ); ?></div>
            <div class="content user_list">
              <?php foreach( $page_data["playlists"] as $playlist ) :
                $user = $loader->user->set( $playlist["user_id"] )->get_data(); ?>
                <div class="user">
                  <a href="<?php $loader->ui->eurl( "playlist", $playlist["url"] ); ?>"><div class="avatar"><img alt="<?php echo $playlist["name"]; ?>" src="<?php echo $playlist["cover"]; ?>"></div></a>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        <?php endif; ?>
        <?php if ( $page_data["likers"] ) : ?>
          <div class="side_widget likers">
            <div class="title"><span class="mdi mdi-heart"></span><?php $loader->lorem->eturn( "ts_likes", ["uc"=>true] ); ?></div>
            <div class="content user_list">
              <?php foreach( $page_data["likers"] as $user ) : ?>
                <div class="user">
                  <a href="<?php $loader->ui->eurl( "user", $user["username"] ); ?>"><div class="avatar"><img alt="<?php echo $user["username"]; ?>" src="<?php echo $user["avatar"]; ?>"></div></a>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        <?php endif; ?>
        <?php if ( $page_data["reposters"] ) : ?>
          <div class="side_widget reposters">
            <div class="title"><span class="mdi mdi-repeat"></span><?php $loader->lorem->eturn( "ts_reposts", ["uc"=>true] ); ?></div>
            <div class="content user_list">
              <?php foreach( $page_data["reposters"] as $user ) : ?>
                <div class="user">
                  <a href="<?php $loader->ui->eurl( "user", $user["username"] ); ?>"><div class="avatar"><img alt="<?php echo $user["username"]; ?>" src="<?php echo $user["avatar"]; ?>"></div></a>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        <?php endif; ?>

      <?php endif; ?></div>
    </div>

    <div class="row">
    <?php
    $loader->ui->load_page_widget( [ "type" => "pl", "sett" => [ "pl_code" => "track_page" ] ] );
    ?>
    </div>

  </div>


</div>
</div>
