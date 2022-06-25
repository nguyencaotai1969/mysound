<?php if ( !defined( "root" ) ) die; ?>
<div class="box-title">
  <div class="icon"><span class="mdi mdi-account-alert"></span></div>
  <div class="title">Notification Setting</div>
</div>
<div class="box nots">

  <div class=" head top">
  <div class="row">
    <div class="col-12"><span class="mdi mdi-alert"></span>Admin Notifications</div>
  </div>
  </div>

  <table>
    <thead>
      <tr>
        <td>#</td>
        <td>Detail</td>
        <td class="option" data-toggle='tooltip' title="Want to receive this notification?">Notification</td>
        <td class="option" data-toggle='tooltip' title="Want to receive this notification by email?">Email</td>
      </tr>
    </thead>
    <tbody>
      <?php foreach( $page_data["notifications"] as $notification ) :
      if ( empty( $notification["admin"] ) ) continue; ?>
        <tr>
          <td class="i"><?php echo "{$notification["type_name"]}_{$notification["hook_type"]}"; ?></td>
          <td><?php echo !empty( $notification["detail"] ) ? $notification["detail"] : ""; ?></td>
          <td class="option"><?php echo $loader->html->doms->create_input( "check", "not_{$notification["type"]}", $notification["ua_not"] ); ?></td>
          <td class="option"><?php echo $loader->html->doms->create_input( "check", "email_{$notification["type"]}", $notification["ua_email"] ); ?></td>
        </tr>
      <?php endforeach ;?>
    </tbody>
  </table>

  <div class="setting">
  <div class="row">
  	<div class="col-6">
      <div class="name">Admin IDs</div>
      <div class="tip">Enter comma separated user-id of users you want to receive admin notifications. Example: 1,23,43,3</div>
  	</div>
  	<div class="col-6"><?php echo $loader->html->doms->create_input( "text", "not_adids", $loader->admin->get_setting( "admin_ids", "1" ) ) ?></div>
  </div>
  </div>

  <div class="head">
  <div class="row">
    <div class="col-12"><span class="mdi mdi-alert-circle"></span>User Notifications</div>
  </div>
  </div>

  <table>
    <thead>
      <tr>
        <td>#</td>
        <td>Detail</td>
        <td data-toggle='tooltip' title="Should users see this type of action from followed users in their own feed">Performer<br>Receiver</td>
        <td class="option" data-toggle='tooltip' title="Should this type of action appear on users activity page?">Activity</td>
        <td class="option" data-toggle='tooltip' title="Should users see this type of action from followed users in their own feed">Feed</td>
        <td class="option" data-toggle='tooltip' title="Can users enable receiving this notification?">Notifications</td>
        <td class="option" data-toggle='tooltip' title="Can users enable receiving this notification by email?">Email</td>
      </tr>
    </thead>
    <tbody>
      <?php foreach( $page_data["notifications"] as $notification ) :
      if ( !empty( $notification["admin"] ) ) continue; ?>
        <tr>
          <td class="i"><?php echo "{$notification["type_name"]}_{$notification["hook_type"]}"; ?></td>
          <td><?php echo !empty( $notification["detail2"] ) ? "<span class='t'>Performer:</span> " . $notification["detail2"] . "<br>" : ""; ?>
            <?php echo !empty( $notification["detail"] ) ? "<span class='t'>Receiver:</span> " . $notification["detail"] : ""; ?></td>
          <td style="white-space:nowrap"><?php echo !empty( $notification["detail_doer"] ) ? ucfirst( $notification["detail_doer"] ) : "--"; ?>
            <br><?php echo !empty( $notification["detail_receiver"] ) ? ucfirst( $notification["detail_receiver"] ) : "--"; ?></td>
          <td class="option"><?php echo !empty( $notification["detail_doer"] ) ? $loader->html->doms->create_input( "check", "act_{$notification["type"]}", $notification["ua_act"] ) : ""; ?></td>
          <td class="option"><?php echo !empty( $notification["detail_doer"] ) ? $loader->html->doms->create_input( "check", "feed_{$notification["type"]}", $notification["ua_feed"] ) : ""; ?></td>
          <td class="option"><?php echo !empty( $notification["detail_receiver"] ) ? $loader->html->doms->create_input( "check", "not_{$notification["type"]}", $notification["ua_not"] ) : ""; ?></td>
          <td class="option"><?php echo !empty( $notification["detail_receiver"] ) ? $loader->html->doms->create_input( "check", "email_{$notification["type"]}", $notification["ua_email"] ) : ""; ?></td>
        </tr>
      <?php endforeach ;?>
    </tbody>
  </table>

  <div class="foot_buttons"><input type="button" value="Save" class="btn btn-success btn-wide" onclick="save_notification_form()"></div>

</div>
