<?php if ( !defined("root" ) ) die; $ads = $loader->ads->select(["user_id"=>$loader->visitor->user()->ID,"limit"=>100]); ?>
<div class="new_one btn btn-primary btn-sm campaign_handler">+ <?php $loader->lorem->eturn( "new_ad", ["uc"=>true,"eol_br"=>true] ); ?></div>
<div class="payments">
  <?php if ( empty( $ads ) ) : ?>
  <div class="so_empty"><?php $loader->lorem->eturn( "no_ads_yet" ); ?></div>
  <?php else : ?>
    <table width="100%">
      <thead>
      	<tr>
          <td class="td_name"><?php $loader->lorem->eturn( "name", ["uc"=>true] ); ?></td>
          <td class="td_type"><?php $loader->lorem->eturn( "type", ["uc"=>true] ); ?></td>
          <td class="td_target"><?php $loader->lorem->eturn( "target", ["uc"=>true] ); ?></td>
          <td class="td_fund_total"><?php $loader->lorem->eturn( "fund_total", ["uc"=>true] ); ?></td>
          <td class="td_fund_remain"><?php $loader->lorem->eturn( "fund_remain", ["uc"=>true] ); ?></td>
          <td class="td_status"><?php $loader->lorem->eturn( "status", ["uc"=>true] ); ?></td>
      	</tr>
      </thead>
      <tbody>
        <?php foreach( (array) $ads as $ad ) : ?>
        <tr class="<?php echo $ad["active"] > 0 ? "done" : "failed" ?>">
          <td class="td_detail"><?php echo $ad["name"]; ?></td>
          <td class="td_detail"><?php echo $ad["type_hr"] . "<BR>" . $ad["files_urls_inline"]; ?></td>
          <td class="td_detail"><?php echo $ad["url_host"]; ?></td>
          <td class="td_detail"><?php $loader->general->display_price( $ad["fund_total"] ); ?></td>
          <td class="td_detail"><?php $loader->general->display_price( $ad["fund_remain"] ); ?></td>
          <td class="td_status"><?php echo $ad["active"] == 1 ? $ad["act_clicks"] . " " . $loader->lorem->turn("clicks") . "<br>" . $ad["act_views"] . " " . $loader->lorem->turn("views") : "<span class='mdi mdi-alert-circle-outline'></span> {$ad["active_hr"]}"; ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</div>
<script>
var $placements = JSON.parse('<?php echo $loader->general->json_encode( $loader->ads->getPlacements("for_select"), true ); ?>');
</script>
