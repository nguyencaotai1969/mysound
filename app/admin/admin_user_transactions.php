<?php if ( !defined("root" ) ) die; ?>
<div class="box-title big">
  <div class="icon"><span class="mdi mdi-cart-outline"></span></div>
  <div class="title">Transaction History</div>
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
  	  <td width="20px">ID</td>
  	  <td>order_id</td>
      <td>User</td>
      <td>Info</td>
      <td width="30px">Amount</td>
      <td width="30px">Revenue</td>
  	  <td>Time</td>
  	  <td width="30px">Completed</td>
  	</tr>
  </thead>
  <tbody>
    <?php $i=0; foreach( $page_data["items"] as $item ) : $i++; ?>
  	<tr class="<?php echo $item["completed"] != 1 ? "pay-unpaid" : "pay-paid"; ?>">
  	  <td><?php echo $item["ID"]; ?></td>
  	  <td><?php echo $item["order_no"] ; ?></td>
      <td><?php echo $item["user"]["username"]; ?></td>
      <td><?php echo $item["info"]; ?></td>
      <td style="color:<?php echo $item["funding"] ? "" : ( $item["type"] == "in" ? "red" : "green;font-weight:500" ); ?>"><?php $loader->general->display_price( $item["amount"] ); ?></td>
      <td style="color:green;font-weight:500"><?php if ( $item["revenue"] ) $loader->general->display_price( $item["revenue"] ); ?></td>
  	  <td><?php echo $item["time_add"]; ?></td>
  	  <td><?php echo $item["completed"] == 1 ? "<span class='badge badge-success'>Yes</span>" : "<span class='badge badge-warning'>No</span>"; ?></td>
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
