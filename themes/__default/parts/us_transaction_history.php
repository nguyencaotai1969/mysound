<?php if ( !defined("root" ) ) die;
$transactions = $loader->pay->select(["user_id"=>$loader->visitor->user()->ID,"limit"=>100,"_eg"=>["target"]]); ?>
<div class="payments">
  <?php if ( empty( $transactions ) ) : ?>
  <div class="so_empty"><?php $loader->lorem->eturn( "no_transactions_yet" ); ?></div>
  <?php else : ?>
    <table width="100%">
      <thead>
      	<tr>
      	  <td class="td_detail"><?php $loader->lorem->eturn( "detail", ["uc"=>true] ); ?></td>
      	  <td class="td_amount"><?php $loader->lorem->eturn( "amount", ["uc"=>true] ); ?></td>
      	  <td class="td_balance"><?php $loader->lorem->eturn( "balance", ["uc"=>true] ); ?></td>
      	  <td class="td_time"><?php $loader->lorem->eturn( "time", ["uc"=>true] ); ?></td>
      	  <td class="td_status"><?php $loader->lorem->eturn( "status", ["uc"=>true] ); ?></td>
      	</tr>
      </thead>
      <tbody>
        <?php foreach( (array) $transactions as $transaction ) : ?>
        <tr class="<?php echo $transaction["completed"] == 1 ? "done" : "failed" ?>">
          <td class="td_detail">
          	<?php echo $transaction["info"]; ?>
          </td>
          <td class="td_amount">
            <div class="type <?php echo $transaction["type"]; ?>">
              <span class="mdi mdi-chevron-up"></span>
            </div>
            <?php $loader->general->display_price( $transaction["amount"] ); ?>
          </td>
          <td class="td_balance"><?php echo $transaction["user_fund"] . ( $transaction["completed"] == 1 ? "<i class='{$transaction["type"]}'>{$transaction["amount"]}</i>" : "" ) . " " . $loader->admin->get_setting("currency"); ?></td>
          <td class="td_time"><?php echo $loader->general->passed_time_hr( $transaction["time_add"], 1 )["string"] . " " . $loader->lorem->turn("ago"); ?></td>
          <td class="td_status"><?php echo $transaction["completed"] == 1 ? "<span class='mdi mdi-check-all'></span> {$loader->lorem->eturn( "successful", ["uc"=>true] )}" :
			  ( $transaction["completed"] == -1 ? "<span class='mdi mdi-alert-circle-outline'></span> {$loader->lorem->eturn( "failed", ["uc"=>true] )}" : "<span class='mdi mdi-alert-circle-outline'></span> {$loader->lorem->eturn( "pending", ["uc"=>true] )}" ) ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</div>
