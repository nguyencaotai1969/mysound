<?php
$darker_color = $loader->general->color_adjust_brightness( $color, -22 );
$brighter_color = $loader->general->color_adjust_brightness( $color, -22 );
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html><body style="background: #b8cce2">

<div style='width:550px;max-width:96%;margin:20px auto;position:relative;font-family: Google Sans,Roboto,RobotoDraft,Helvetica,Arial,sans-serif;text-align: left;direction: ltr'>

  <div style="background: <?php echo $darker_color ?>;padding:20px">
    <a href="<?php echo $siteurl; ?>"><img style="max-width:230px;max-height:100%;width:auto;height:auto" src="<?php echo $logo; ?>" alt="logo"></a>
  </div>

  <div style='font-size:12pt;line-height:1.5; padding:30px 20px; background: #fff; color:#222'>
    <div><?php echo $text; ?></div>
  </div>

  <div style="background: #fff">
  <div style='font-size:10pt;color:#797979;background-color: #<?php echo $color; ?>1a; padding:20px'>
    <?php $loader->lorem->eturn( "dont_talk_back", [ "lang" => $loader->admin->get_setting( "lang" ) ] ); ?>
    <a style="color: #000; text-decoration: none; display: block;margin-top: 5px" href="<?php echo $siteurl; ?>"><?php echo $loader->secure->escape( $sitename ); ?></a>
  </div>
  </div>

</div>

</body></html>
