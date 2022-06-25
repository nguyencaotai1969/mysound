<?php if ( !defined("root" ) ) die; ?>
<div class="box-title big">
  <div class="icon"><span class="mdi mdi-account-box-multiple"></span></div>
  <div class="title">Manage Users</div>
</div>

<div class="box cmt big" >

  <div class="sort_wrapper">
    <div class="row">
      <div class="col-8">
        <form method="get">
          <input name="_sq" type="text" class="form-control" placeholder="Search ..." <?php echo !empty( $page_data["_sq"] ) ? "value=\"{$page_data["_sq"]}\"" : ""; ?> >
        </form>
      </div>
      <div class="col-4 filters tar">

     	<div class="filters_wrapper">

     	  <div class="handler"><span class="mdi mdi-filter-variant"></span></div>

     	  <div class="filters">

     	  	<div class="filter">
     	  	  <label>Group:</label>
              <?php
		      $group_links[ $loader->general->http_build_query( $page_data["reqs"], [ "group" => null ], true ) ] = "All";
		      foreach( $page_data["groups"] as $group_key => $group_data ){
			      $group_links[ $loader->general->http_build_query( $page_data["reqs"], [ "group" => $group_key ], true ) ] = ucfirst( $group_data[1] );
		      }
		      echo $loader->html->doms->create_input( "select", "group", $loader->general->http_build_query( $page_data["reqs"], [ "group" => $page_data["group"] ], true ), $group_links ); ?>
    	    </div>

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
  	  <td width="80px">Avatar</td>
  	  <td>Username</td>
  	  <td>Email</td>
  	  <td width="20px">Fund</td>
  	  <td width="20px">Groups</td>
  	  <td width="20px">-</td>
  	</tr>
  </thead>
  <tbody>
    <?php $i=0; foreach( $page_data["items"] as $item ) : $i++; ?>
  	<tr>
  	  <td class="tar" ><input type="checkbox" value="ID<?php echo $item["ID"]; ?>" ></td>
  	  <td><?php echo $item["ID"]; ?></td>
  	  <td><?php echo $item["avatar"] ? "<img src='{$item["avatar"]}' class='w50'>" : "<div class='avatar_fake_holder'></div>"; ?></td>
  	  <td><?php echo $item["username"]; ?></td>
  	  <td><?php echo $item["email"]; ?></td>
  	  <td><?php echo $item["fund"]; ?></td>
  	  <td class="tar" >
  	    <span class="badge badge-<?php echo $item["group_data"]["name"] == "admin" ? "dark" : ( $item["group_data"]["name"] == "user" ? "secondary" : "info" ); ?>"><?php echo ucfirst( $item["group_data"]["name"] ); ?></span>
	    <?php if ( $item["artist"] ) : ?><br><span class="badge badge-primary">Artist</span><?php endif; ?>
	    <?php if ( $item["paid"] ) : ?><br><span class="badge badge-success">Paid</span><?php endif; ?>
	    <?php if ( $item["group_access"]["admin"] && $item["group_data"]["name"] != "admin" ) : ?><br><span class="badge badge-dark">Admin</span><?php endif; ?>
	    <?php if ( !$item["verified"] ) : ?><br><span class="badge badge-danger">Not Verified</span><?php endif; ?>
 	  </td>
  	  <td>
	    <div class="btn-group btn-group-sm" role="group">
	      <button id="dropdown_btns" type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	        Manage
	      </button>
	      <div class="dropdown-menu" aria-labelledby="dropdown_btns">
	        <a class="dropdown-item edit_user_handle" data-hook="<?php echo $item["ID"]; ?>"><span class="mdi mdi-circle-edit-outline"></span> Edit</a>
	        <a class="dropdown-item delete_user_handle" data-hook="<?php echo $item["ID"]; ?>"><span class="mdi mdi-minus-circle-outline"></span> Delete</a>
	        <?php if ( !$item["artist"] ) : ?>
	        <a class="dropdown-item connect_artist_handle" data-hook="<?php echo $item["ID"]; ?>"><span class="mdi mdi-power-plug"></span> Connect to artist</a>
	        <?php else : ?>
	        <a class="dropdown-item disconnect_artist_handle" data-hook="<?php echo $item["ID"]; ?>"><span class="mdi mdi-power-plug"></span> Disconnect from artist</a>
	        <?php endif; ?>
	        <?php if ( !$item["verified"] ) : ?>
	        <a class="dropdown-item verify_user_handle" data-hook="<?php echo $item["ID"]; ?>"><span class="mdi mdi-check-circle-outline"></span> Verify</a>
	        <?php endif; ?>
	        <a class="dropdown-item" href="<?php $loader->ui->eurl( "admin_content_albums", null, "user_id={$item["ID"]}" ) ?>"><span class="mdi mdi-album"></span> Manage Albums</a>
	        <a class="dropdown-item" href="<?php $loader->ui->eurl( "admin_content_tracks", null, "user_id={$item["ID"]}" ) ?>"><span class="mdi mdi-play-box-multiple"></span> Manage Tracks</a>
	        <a class="dropdown-item" href="<?php $loader->ui->eurl( "admin_user_comments", null, "user_id={$item["ID"]}" ) ?>"><span class="mdi mdi-message-reply"></span> Manage Comments</a>
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
        <a class="btn btn-danger btn-sm hoi delete_user_handle"><span class="mdi mdi-minus-circle-outline"></span> Delete</a>
        <!-- TODO -->
        <!--a class="btn btn-primary btn-sm new_user_handle"><span class="mdi mdi-plus"></span> New</a-->
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
<script>
var $__users  = JSON.parse('<?php echo $loader->general->json_encode( $page_data["items"], true ); ?>');
var $__groups = JSON.parse('<?php unset ( $page_data["groups"]["notverified"], $page_data["groups"]["artist"], $page_data["groups"]["paid"] ); echo $loader->general->json_encode( array_values( $page_data["groups"] ),  true ); ?>');
</script>
