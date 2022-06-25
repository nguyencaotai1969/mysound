<?php if ( !defined( "root" ) ) die;
if ( empty( $page_data["group"] ) ) : ?>

<div class="box-title">
  <div class="icon"><span class="mdi mdi-lock-open"></span></div>
  <div class="title">Manage user groups</div>
</div>

<div class="box">

  <div class="groups">
    <?php foreach( $page_data["groups"] as $_user_group ) : ?>
    <div class="group">
      <div class="label"><?php echo $_user_group["name"]; ?></div>
      <div class="buttons">
      	<a class="button" href="<?php $loader->ui->eurl( "admin_user_groups", null, "GID={$_user_group["ID"]}" ) ?>">Edit</a>
      	<?php if( $_user_group["ID"] > 5 ) : ?>
      	<div class="button remove_user_group_handle" data-hook="<?php echo $_user_group["ID"]; ?>" data-name="<?php echo $_user_group["name"] ?>">Remove</div>
      	<?php endif; ?>
      </div>
    </div>
    <?php endforeach; ?>
  </div>

  <div class="foot_buttons">
    <a class="btn btn-wide btn-primary add_user_group_handle">+ New group</a>
  </div>


</div>

<?php ;else: $group = $page_data["group"]; ?>

<div class="box-title">
  <div class="icon"><span class="mdi mdi-lock-open"></span></div>
  <div class="title">Manage <i>`<?php echo ucfirst( $group["name"] ); ?>`</i> group</div>
</div>

<div class="box">
<form method="post" class="be_cli_form" data-action="admin_users_edit_group" data-target=".watermark">

  <div class="setting">
  <div class="row">
  	<div class="col-10">
  	  <div class="name">Hide Advertisement</div>
  	  <div class="tip">Should app hide advertisement for this group of users?</div>
  	</div>
  	<div class="col-2"><?php echo $loader->html->doms->create_input( "check", "hide_advertisement_access", $group["hide_advertisement_access"] ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-10">
  	  <div class="name">Player access</div>
  	  <div class="tip">Can this group listen to free or premium content through your player?</div>
  	</div>
  	<div class="col-2"><?php echo $loader->html->doms->create_input( "check", "muse_access", $group["muse_access"] ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-10">
  	  <div class="name">Premium content access</div>
  	  <div class="tip">Can this group listen to not-free musics through your player?</div>
  	</div>
  	<div class="col-2"><?php echo $loader->html->doms->create_input( "check", "premium_access", $group["premium_access"] ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-10">
  	  <div class="name">High Quality Audio access</div>
  	  <div class="tip">If there are multiple sources for a track and this group has access to HQ audios, script will play highest quality source otherwise lowest quality source will be played</div>
  	</div>
  	<div class="col-2"><?php echo $loader->html->doms->create_input( "check", "hq_audio_access", $group["hq_audio_access"] ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-10">
  	  <div class="name">Download access</div>
  	  <div class="tip">Can this group download files from your websie?</div>
  	</div>
  	<div class="col-2"><?php echo $loader->html->doms->create_input( "check", "download_access", $group["download_access"] ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-10">
  	  <div class="name">Language access</div>
  	  <div class="tip">Can this group change the language of your website?</div>
  	</div>
  	<div class="col-2"><?php echo $loader->html->doms->create_input( "check", "language_access", $group["language_access"] ) ?></div>
  </div>
  </div>

  <?php if ( $group["name"] == "guest" ) : ?>

  <div class="setting">
  <div class="row">
  	<div class="col-10">
  	  <div class="name">Signup access</div>
  	  <div class="tip">Can guests signup for your website?</div>
  	</div>
  	<div class="col-2"><?php echo $loader->html->doms->create_input( "check", "signup_access", $group["signup_access"] ) ?></div>
  </div>
  </div>

  <?php else : ?>

  <div class="setting">
  <div class="row">
  	<div class="col-10">
  	  <div class="name">Upload access</div>
  	  <div class="tip">Can this group upload music?</div>
  	</div>
  	<div class="col-2"><?php echo $loader->html->doms->create_input( "check", "upload_access", $group["upload_access"] ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-10">
  	  <div class="name">Sell access</div>
  	  <div class="tip">Can this group set a price for their uploaded music?</div>
  	</div>
  	<div class="col-2"><?php echo $loader->html->doms->create_input( "check", "sell_access", $group["sell_access"] ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-10">
  	  <div class="name">Report access</div>
  	  <div class="tip">Can this group report tracks?</div>
  	</div>
  	<div class="col-2"><?php echo $loader->html->doms->create_input( "check", "report_access", $group["report_access"] ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-10">
  	  <div class="name">Notification access</div>
  	  <div class="tip">Can this group have access to notification system?</div>
  	</div>
  	<div class="col-2"><?php echo $loader->html->doms->create_input( "check", "notification_access", $group["notification_access"] ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-10">
  	  <div class="name">Advertisement access</div>
  	  <div class="tip">Can this group use advertisement panel to create ads?</div>
  	</div>
  	<div class="col-2"><?php echo $loader->html->doms->create_input( "check", "advertisement_access", $group["advertisement_access"] ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-10">
  	  <div class="name">Comment approved</div>
  	  <div class="tip">Should system aut-approve comments made by this group?</div>
  	</div>
  	<div class="col-2"><?php echo $loader->html->doms->create_input( "check", "comment_access", $group["comment_access"] ) ?></div>
  </div>
  </div>

  <?php if ( $group["name"] != "paid" && $group["name"] != "admin" ) : ?>
  <div class="setting">
  <div class="row">
  	<div class="col-10">
  	  <div class="name">Upgrade access</div>
  	  <div class="tip">Can this group upgrade to `Paid` user?</div>
  	</div>
  	<div class="col-2"><?php echo $loader->html->doms->create_input( "check", "upgrade_access", $group["upgrade_access"] ) ?></div>
  </div>
  </div>
  <?php endif; ?>

  <?php if ( $group["name"] != "artist" ) : ?>
  <div class="setting">
  <div class="row">
  	<div class="col-10">
  	  <div class="name">Becoming Artist access</div>
  	  <div class="tip">Can this group submit their information and become a verified artist after admin approval?</div>
  	</div>
  	<div class="col-2"><?php echo $loader->html->doms->create_input( "check", "artist_req_access", $group["artist_req_access"] ) ?></div>
  </div>
  </div>
  <?php endif; ?>

  <div class="setting">
  <div class="row">
  	<div class="col-10">
  	  <div class="name">Sales share ratio</div>
  	  <div class="tip">You can set a fee for user sales. Users who can upload and sell their songs, will get this percenge of money as their share everytime their album or track makes a sell. The rest is considered site's fee and yours to keep</div>
  	</div>
  	<div class="col-2"><?php echo $loader->html->doms->create_input( "digit", "sell_share", $group["sell_share"] ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-10">
  	  <div class="name">Admin access</div>
  	  <div class="tip">Can this group access admin area?</div>
  	</div>
  	<div class="col-2"><?php echo $loader->html->doms->create_input( "check", "admin_access", $group["admin_access"] ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-10">
  	  <div class="name">Admin UI access</div>
  	  <div class="tip">Enter * to give this group access to all user-interface pages. Seperate page names by , to define custom access</div>
  	</div>
  	<div class="col-2"><?php echo $loader->html->doms->create_input( "text", "ui_access", is_array( $group["ui_access"] ) ? implode( ",", $group["ui_access"] ) : $group["ui_access"] ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-10">
  	  <div class="name">Admin BE access</div>
  	  <div class="tip">Enter * to give this group access to all back-end actions. Seperate page names by , to define custom access</div>
  	</div>
  	<div class="col-2"><?php echo $loader->html->doms->create_input( "text", "be_access", is_array( $group["be_access"] ) ? implode( ",", $group["be_access"] ) : $group["be_access"] ) ?></div>
  </div>
  </div>

  <div class="setting">
  <div class="row">
  	<div class="col-10">
  	  <div class="name">Verified icon</div>
  	  <div class="tip">Show app display verified tick icon for this group?</div>
  	</div>
  	<div class="col-2"><?php echo $loader->html->doms->create_input( "check", "verified", $group["verified"] ) ?></div>
  </div>
  </div>

  <?php endif; ?>

  <div class="foot_buttons"><input type="submit" value="Save" class="btn btn-success btn-wide"></div>

</form>
</div>

<?php endif; ?>
