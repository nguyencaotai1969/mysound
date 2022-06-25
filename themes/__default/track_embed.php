<?php if ( !defined( "root" ) ) die;
$track = $page_data["track"];
$source = $page_data["source"];
$color = $loader->secure->get( "get", "color", "string_color_hex", [], $loader->secure->escape( $loader->theme->set_name()->get_setting( "color", "2687fb" ) ) );
?>
<!DOCTYPE html>
<html lang='en' dir='ltr'>
<head>
  <script src='<?php echo web_addr; ?>themes/__default/assets/third/jquery-3.5.1.min.js'></script>
  <script src='<?php echo web_addr; ?>themes/__default/assets/third/amplitudejs-5.2.0/dist/amplitude.min.js'></script>
  <script src='<?php echo web_addr; ?>themes/__default/assets/js/muse.js?t=1615355888.2438'></script>
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500&display=swap" rel="stylesheet">
  <link href='<?php echo web_addr; ?>themes/__default/assets/third/materialdesign-webfont-master/css/materialdesignicons.min.css' rel='stylesheet' media='all' type='text/css'>
</head>
<style>
a {
  font-style: normal;
  text-decoration: none;
  color: #fff
}
body {
    margin: 0;
    padding: 0;
    font-family: Roboto;
    background-color: #151719
}
#player {
    height: 160px;
    position: relative;
}
#player .song_data {
    padding-left: 180px;
    position: relative;
}
#player .song_data .song_detail {
    /* position: absolute; */
}
#player .song_data .song_detail .cover {
    position: absolute;
    left: 10px;
    top: 10px;
    height: 140px;
    width: 140px;
}
#player .song_data .song_detail .cover img {
    max-width: 100%;
    max-height: 100%;
}
#player .song_data .artist_detail {
    /* display: none; */
    position: absolute;
    top: 43px;
    left: 240px;
    font-size: 10pt;
}
#player .song_data .control_buttons {
    position: absolute;
    top: 40px;
    font-size: 19pt;
    width: 40px;
    height: 40px;
    text-align: center;
    line-height: 40px;
    background: #<?php echo $color; ?>;
    border-radius: 50%;
    color: #fff;
}
#player .song_data .control_buttons > div {
    display: none;
}
#player .song_data .control_buttons > .pauseplay {
    display: block;
}
#player .song_data .artist_detail .artist_cover {
    display: none;
}
#player .song_data .artist_detail .artist_title .tip {
    display: none;
}
#player .song_data .song_detail .playlist_buttons {
    display: none;
}
#player .song_data .control_secondary_buttons {
  display: none
}
#player .song_data .song_detail .artist_album_wrapper {
    display: none;
}
#player .song_data .song_detail .song_title {
    position: absolute;
    top: 60px;
    left: 240px;
}
#player .song_data .p_w {
    position: absolute;
    top: 105px;
    right: 10px;
    left: 180px;
    height: 5px;
}
#player .song_data .p_w > .a_bar {
    position: absolute;
    top: 0;
    bottom: 0;
    left: 0;
    width: auto;
}
#player .song_data .p_w .progress_bg {
    width: 100%;
    background: rgba( 255, 255, 255, 0.07 )
}
#player .song_data .p_w {
    right: 70px;
    left: 240px;
}
#player .song_data .times {}
#player .song_data .times > div {
  position: absolute;
  top: 100px;
  left: 190px;
  font-size: 9pt;
  color: rgb(255 255 255 / 45%);
}
#player .song_data .times > .time_all {
    right: 20px;
    left: auto;
}
#player .song_data .p_w > .progress_b {
    background: rgba( 255, 255, 255, 0.1 );
}
#player .song_data .p_w > .progress_e {
    background: #<?php echo $color; ?>;
}
</style>
<body>
  <div id="yt_holder"></div>
  <?php echo $loader->theme->set_name()->__req( "parts/header_player.php" ); ?>
  <script>
  var $_home = "<?php echo web_addr; ?>";
  var $_play_hash = "<?php echo $this->loader->visitor->play_hash; ?>";
  var $_texts = {
    play: "play",
    loading: "loading",
    pause: "pause",
    no_source: "no_source",
  };
  $(document).ready(function(){
    muse.song_data = {
      title: "<?php echo $track["title"]; ?>",
      cover: "<?php echo $track["cover_addr"]; ?>",
      url: "<?php $loader->ui->eurl( "track", $track["url"] ); ?>",
      hash: "<?php echo $track["hash"]; ?>",
      key: "<?php echo $_SESSION["play_track_key"]; ?>",
      album_title: "<?php echo $track["album_title"]; ?>",
      album_url: "<?php $loader->ui->eurl( "album", $track["album_url"] ); ?>",
      artist_name: "<?php echo $track["artist_name"]; ?>",
      artist_url: "<?php $loader->ui->eurl( "artist", $track["artist_url"] ); ?>",
      artist_image: null,
      source_hash: "<?php echo $source["hash"]; ?>",
      source_type: "<?php echo $source["type"]; ?>",
      source_data: <?php echo $source["type"] == "youtube" ? "\"{$source["data"]}\"" : "null" ; ?>,
      duration: "<?php echo $source["duration"]; ?>",
      duration_hr: "<?php echo $loader->general->hr_seconds( $source["duration"] ); ?>",
      duration_fr: "<?php echo round( $source["duration"] ); ?>",
      stream_url: "<?php echo $source["type"] == "file_r" ? $loader->general->path_to_addr( $source["data"] ) : ""; ?>",
      liked: false,
      paid: true,
      from: false,
      volume: 100,
      repeat: true,
      force_refresh: false
    };
    muse.update_dom_data();
    muse.update_dom_waves(true);
    muse.update_dom_buttons();
    muse.song_time_total = muse.song_data.duration;
    muse.setup_player(false);
  });
  function decode_htmlspecialchars( text ){
    var map = {
      '&amp;': '&',
      '&#038;': "&",
      '&#38;': "&",
      '&lt;': '<',
      '&gt;': '>',
      '&quot;': '"',
      '&#039;': "'",
      '&#39;': "'",
      '&#8217;': "’",
      '&#8216;': "‘",
      '&#8211;': "–",
      '&#8212;': "—",
      '&#8230;': "…",
      '&#8221;': '”'
    };
    return text.replace(/\&[\w\d\#]{2,5}\;/g, function(m) {
      return map[m];
    });
  }
  </script>
</body>
</html>
<?php die; ?>
