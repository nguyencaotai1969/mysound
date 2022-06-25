<?php if ( !defined( "root" ) ) die; ?>

<div class="box-title big">
  <div class="icon"><span class="mdi mdi-message-reply"></span></div>
  <div class="title">Manage Comments</div>
</div>

<div class="box cmt big" >

  <div class="sort_wrapper">
    <div class="row">
      <div class="col-6">
        <form method="get">
          <input name="_sq" type="text" class="form-control" placeholder="Search ..." <?php echo !empty( $page_data["_sq"] ) ? "value=\"{$page_data["_sq"]}\"" : ""; ?> >
        </form>
      </div>
      <div class="col-6 filters tar" >
       
        <label>Approved:</label>
        <?php 
		echo $loader->html->doms->create_input( "select", "approved", $loader->general->http_build_query( $page_data["reqs"], [ "approved" => $page_data["approved"] ], true ), [ 
			$loader->general->http_build_query( $page_data["reqs"], [ "approved" => "all" ], true ) => "All",
			$loader->general->http_build_query( $page_data["reqs"], [ "approved" => "yes" ], true ) => "Yes",
			$loader->general->http_build_query( $page_data["reqs"], [ "approved" => "no" ], true ) => "No" 
		] ); ?>
       
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
    </div>
  </div>
  
<?php if ( $page_data["items"] ) : ?>
<div class="table_wrapper">
<table width="100%">
  <thead>
  	<tr>
  	  <td width="40px"><input type="checkbox" value="all"></td>
  	  <td width="20px">ID</td>
  	  <td width="40px">User</td>
  	  <td>Target</td>
  	  <td>Text</td>
  	  <td width="20px">Status</td>
  	  <td width="20px">-</td>
  	</tr>
  </thead>
  <tbody>
    <?php $i=0; foreach( $page_data["items"] as $item ) : $i++; ?>
  	<tr>
  	  <td class="tar"><input type="checkbox" value="ID<?php echo $item["ID"]; ?>" ></td>
  	  <td><?php echo $item["ID"]; ?></td>
  	  <td><a href="<?php echo $loader->general->http_build_query( $page_data["reqs"], [ "user_id" => $item["user_id"] ], true ); ?>">
  	    @<?php echo $item["user"]["username"]; ?>
  	  </a></td>
  	  <td><a href="<?php echo $loader->general->http_build_query( $page_data["reqs"], [ "target_id" => $item["target_id"], "target_type" => "track" ], true ); ?>">
  	    <?php echo $item["track"]["artist_name"] . " - " . $item["track"]["title"]; ?>
  	  </a></td>
  	  <td><?php echo $item["text"]; ?></td>
  	  <td class="tar"><?php if ( $item["approved"] ) : ?><span class="badge badge-success">Approved</span><?php else : ?><span class="badge badge-danger">Pending</span><?php endif; ?></td>
  	  <td>
	    <div class="btn-group btn-group-sm" role="group">
	      <button id="dropdown_btns" type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	        Manage
	      </button>
	      <div class="dropdown-menu" aria-labelledby="dropdown_btns">
	        <a class="dropdown-item delete_comment_handle" data-hook="<?php echo $item["ID"]; ?>"><span class="mdi mdi-minus-circle-outline"></span> Delete</a>
	        <?php if ( !$item["approved"] ) : ?>
	        <a class="dropdown-item approve_comment_handle" data-hook="<?php echo $item["ID"]; ?>"><span class="mdi mdi-check-circle-outline"></span> Approve</a>
	        <?php endif; ?>
	      </div>
	    </div>	
	  </td>
  	</tr>
  	<?php endforeach; ?>
  </tbody>
  <tfoot>
  	<tr>
  	  <td colspan="1" class="tar"></td>
  	  <td colspan="6" class="tar p10r">
	    <a class="btn btn-danger btn-sm hoi delete_comment_handle"><span class="mdi mdi-minus-circle-outline"></span> Delete</a>	
	    <a class="btn btn-primary btn-sm hoi approve_comment_handle"><span class="mdi mdi-check-circle-outline"></span> Approve</a>	
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
Found nothing<br>
<?php endif; ?>

</div>