<?php if ( !defined("root" ) ) die; ?>
<div class="box-title big">
  <div class="icon"><span class="mdi mdi-cart-plus"></span></div>
  <div class="title">Payment Submissions</div>
</div>

<div class="box cmt big" >

  <div class="sort_wrapper">
    <div class="row">
      <div class="col-8">
        <form method="get">
          <input name="_sq" type="text" class="form-control" placeholder="Search ..." <?php echo !empty( $page_data["_sq"] ) ? "value=\"{$page_data["_sq"]}\"" : ""; ?> >
        </form>
      </div>
      <div class="col-4 filters tar" >

        <div class="filters_wrapper">

     	  <div class="handler"><span class="mdi mdi-filter-variant"></span></div>

     	  <div class="filters">

     	    <div class="filter">
     	      <label>Limit:</label>
     	      <?php
     	      echo $loader->html->doms->create_input( "select", "l", $loader->general->http_build_query( $page_data["reqs"], [ "l" => $page_data["limit"] ], true ), [
			      $loader->general->http_build_query( $page_data["reqs"], [ "l" => 10 ], true ) => "10",
			      $loader->general->http_build_query( $page_data["reqs"], [ "l" => 20 ], true ) => "20",
			      $loader->general->http_build_query( $page_data["reqs"], [ "l" => 50 ], true ) => "50",
			      $loader->general->http_build_query( $page_data["reqs"], [ "l" => 100 ], true ) => "100",
			      $loader->general->http_build_query( $page_data["reqs"], [ "l" => 1000 ], true ) => "1000"
     	      ] ); ?>
     	    </div>

     	    <a class="filter" href="<?php $loader->ui->eurl( "admin_content_albums" ); ?>">Clear</a>

     	  </div>

        </div>

      </div>
    </div>
  </div>

<?php if ( $page_data["items"] ) : ?>
<div class="table_wrapper">
<table width="100%">
  <thead>
  	<tr>
  	  <td width="40px"><input type="checkbox" value="all"></td>
  	  <td width="20px">ID</td>
  	  <td>order_id</td>
  	  <td>User</td>
  	  <td width="30px">Amount</td>
  	  <td width="30px">Method</td>
  	  <td>Time</td>
  	  <td width="30px">Paid</td>
  	  <td width="30px">Approved</td>
  	  <td width="20px">-</td>
  	</tr>
  </thead>
  <tbody>
    <?php $i=0; foreach( $page_data["items"] as $item ) : $i++;
    $paid = "unpaid";
    if ( $item["paid"] ) $paid = "paid";
    if ( $item["data"]["method"] == "bank_transfer" ) $paid = "pending";
    ?>
  	<tr class="pay-<?php echo $paid; ?>">
  	  <td class="tar"><input type="checkbox" value="ID<?php echo $item["ID"]; ?>" ></td>
  	  <td><?php echo $item["ID"]; ?></td>
  	  <td><?php echo $item["order_no"] ; ?></td>
  	  <td><?php echo $item["user"]["username"]; ?></td>
  	  <td><?php $loader->general->display_price( $item["amount"] ); ?></td>
  	  <td><?php echo $item["data"]["method"]; echo $item["data"]["method"] != "bank_transfer" ? "<br><small><b>ID:</b> {$item["data_txn_id"]}</small>" : "<BR><small><a href='{$loader->general->path_to_addr($item["image"])}'><b>Receipt Image</b></a></small>" ?></td>
  	  <td><?php echo $item["time_add"]; ?></td>
  	  <td><?php echo "<span class='badge badge-".($paid=="paid"?"success":($paid=="unpaid"?"danger":"warning"))."'>".ucfirst($paid)."</span>"; ?></td>
  	  <td><?php echo $item["completed"] != -1 ? ( $item["completed"] ? "<span class='badge badge-success'>Approved</span>" : "<span class='badge badge-warning'>Pending</span>" ) : "<span class='badge badge-danger'>Rejected</span>"; ?></td>
  	  <td>
	    <div class="btn-group btn-group-sm" role="group">
	      <button id="dropdown_btns" type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	        Manage
	      </button>
	      <div class="dropdown-menu" aria-labelledby="dropdown_btns">
            <?php if ( $item["completed"] == -1 || !$item["completed"] ) : ?>
	        <a class="dropdown-item approve_payment_handle" data-hook="<?php echo $item["ID"]; ?>"><span class="mdi mdi-check-circle"></span> Approve Payment</a>
	        <?php endif; ?>
            <?php if ( $item["completed"] != -1 ) : ?>
	        <a class="dropdown-item reject_payment_handle" data-hook="<?php echo $item["ID"]; ?>"><span class="mdi mdi-minus-circle"></span> Reject Payment</a>
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
  	  <td colspan="9" class="tar p10r" >
	    <a class="btn btn-danger btn-sm hoi reject_payment_handle"><span class="mdi mdi-minus-circle"></span> Reject</a>
	    <a class="btn btn-success btn-sm hoi approve_payment_handle"><span class="mdi mdi-check-circle"></span> Approve</a>
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
