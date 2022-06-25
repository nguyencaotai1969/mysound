<?php if ( !defined( "root" ) ) die; ?>
<div class="box-title big">
  <div class="icon"><span class="mdi mdi-credit-card-outline"></span></div>
  <div class="title">Artist Withdraw Requests</div>
</div>

<div class="box cmt big" >

  <div class="sort_wrapper">
    <div class="row">
      <div class="col-12 filters tar" >

        <label>Paid: </label>
        <?php
        echo $loader->html->doms->create_input( "select", "paid", $loader->general->http_build_query( $page_data["reqs"], [ "paid" => $page_data["paid"] ], true ), [
     	  	 $loader->general->http_build_query( $page_data["reqs"], [ "paid" => "all" ], true ) => "All",
     	  	 $loader->general->http_build_query( $page_data["reqs"], [ "paid" => "yes" ], true ) => "Yes",
     	  	 $loader->general->http_build_query( $page_data["reqs"], [ "paid" => "no" ], true )  => "No",
        ] ); ?>


      </div>
    </div>
  </div>

<?php if ( $page_data["items"] ) : ?>
<div class="table_wrapper">
<table width="100%">
  <thead>
  	<tr>
  	  <td width="20px">ID</td>
  	  <td>Order_no</td>
  	  <td>User/Artist</td>
  	  <td>Amount</td>
  	  <td>Data</td>
  	  <td>Time</td>
  	  <td width="20px">-</td>
  	  <td width="20px">-</td>
  	</tr>
  </thead>
  <tbody>
    <?php $i=0; foreach( $page_data["items"] as $item ) : $i++; ?>
  	<tr>
  	  <td><?php echo $item["ID"]; ?></td>
  	  <td><?php echo $item["order_no"] . ( $item["data_txn_id"] ? "<BR><small><b>txn:</b> {$item["data_txn_id"]}</small>" : "" ); ?></td>
  	  <td><?php echo $item["user"]["username"]; ?></td>
  	  <td><?php $loader->general->display_price( $item["amount"] ); ?></td>
  	  <td><?php echo str_replace( PHP_EOL, "<BR>", $item["data"]["data"] ); ?></td>
  	  <td><?php echo $item["time_add"]; ?></td>
  	  <td><?php echo $item["completed"] != -1 ? ( $item["paid"] ? "<span class='badge badge-success'>Paid</span>" : "<span class='badge badge-warning'>Pending</span>" ) : "-"; ?></td>
  	  <td>
	    <div class="btn-group btn-group-sm" role="group">
	      <button id="dropdown_btns" type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	        Manage
	      </button>
	      <div class="dropdown-menu" aria-labelledby="dropdown_btns">
            <?php if ( $item["completed"] == -1 || !$item["completed"] ) : ?>
	        <a class="dropdown-item approve_withdraw_handle" data-hook="<?php echo $item["ID"]; ?>"><span class="mdi mdi-check-circle"></span> Mark as paid</a>
	        <?php endif; ?>
            <?php if ( $item["completed"] != -1 ) : ?>
	        <a class="dropdown-item reject_withdraw_handle" data-hook="<?php echo $item["ID"]; ?>"><span class="mdi mdi-minus-circle"></span> Remove Request</a>
	        <?php endif; ?>
	      </div>
	    </div>
	  </td>
  	</tr>
  	<?php endforeach; ?>
  </tbody>
  <tfoot>
  	<tr>
  	  <td colspan="1" class="tar" ></td>
  	  <td colspan="7" class="tar p10r" >
	    <div class="pages_buttons">
     	  <?php if ( $page_data["page"] > 1 ) : ?>
      	  <a href="<?php echo $loader->general->http_build_query( $page_data["reqs"], [ "p" => $page_data["page"]-1 ], true ); ?>"><span class="mdi mdi-chevron-left"></span></a>
      	  <?php endif; ?>
     	  <?php if ( $page_data["more"] ) : ?>
      	  <a href="<?php echo $loader->general->http_build_query( $page_data["reqs"], [ "p" => $page_data["page"]+1 ], true ); ?>"><span class="mdi mdi-chevron-right"></span></a>
      	  <?php endif; ?>
      	</div>
	  </td>
  	</tr>
  </tfoot>
</table>
</div>
<?php ;else: ?>
Found nothing
<?php endif; ?>

</div>
