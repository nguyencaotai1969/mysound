<?php if ( !defined( "root" ) ) die; ?>
<div class="box-title big">
  <div class="icon"><span class="mdi mdi-play-box-multiple"></span></div>
  <div class="title">Manage Tracks</div>
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

     	  	<?php if ( $page_data["album_id"] ) : ?>
     	  	<div class="filter">
     	  	  <label>Album ID:</label>
     	  	  <input type="text" class="form-control" disabled="disabled" value="<?php echo $loader->secure->escape( $page_data["album_id"] ); ?>">
     	  	</div>
     	  	<?php endif; ?>

     	  	<?php if ( $page_data["artist_id"] ) : ?>
     	  	<div class="filter">
     	  	  <label>Artist ID:</label>
     	  	  <input type="text" class="form-control" disabled="disabled" value="<?php echo $loader->secure->escape( $page_data["artist_id"] ); ?>">
     	  	</div>
     	  	<?php endif; ?>

     	  	<?php if ( $page_data["user_id"] ) : ?>
     	  	<div class="filter">
     	  	  <label>User ID:</label>
     	  	  <input type="text" class="form-control" disabled="disabled" value="<?php echo $loader->secure->escape( $page_data["user_id"] ); ?>">
     	  	</div>
     	  	<?php endif; ?>

     	  	<div class="filter">
     	  	  <label>Price:</label>
     	  	  <?php
     	  	  echo $loader->html->doms->create_input( "select", "price", $loader->general->http_build_query( $page_data["reqs"], [ "price" => $page_data["price"] ], true ), [
     	  	      $loader->general->http_build_query( $page_data["reqs"], [ "price" => "all" ], true ) => "All",
     	  	      $loader->general->http_build_query( $page_data["reqs"], [ "price" => "pre" ], true ) => "Premium",
     	  	      $loader->general->http_build_query( $page_data["reqs"], [ "price" => "free" ], true ) => "Free",
     	  	  ] ); ?>
     	  	</div>

     	  	<div class="filter">
     	  	  <label>Genre:</label>
     	  	  <?php
     	  	  $vals = [ $loader->general->http_build_query( $page_data["reqs"], [ "genre" => "all" ], true ) => "All" ];
     	  	  foreach( $page_data["genres"] as $_genre ){
     	  	      $vals[ $loader->general->http_build_query( $page_data["reqs"], [ "genre" => $_genre[0] ], true ) ] = $_genre[1];
     	  	  }
     	  	  echo $loader->html->doms->create_input( "select", "genre", $loader->general->http_build_query( $page_data["reqs"], [ "genre" => $page_data["genre"] ], true ), $vals );
     	  	  ?>
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

    	    <a class="filter" href="<?php $loader->ui->eurl( "admin_content_tracks" ); ?>">Clear</a>

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
  	  <td width="80px">Cover</td>
  	  <td>Title</td>
  	  <td>Album</td>
  	  <td>Artist</td>
  	  <td width="20px">-</td>
  	</tr>
  </thead>
  <tbody>
    <?php $i=0; foreach( $page_data["items"] as $item ) : $i++; ?>
  	<tr>
  	  <td class="tar"><input type="checkbox" value="ID<?php echo $item["ID"]; ?>" ></td>
  	  <td><?php echo $item["ID"]; ?></td>
  	  <td><?php echo $item["cover"] ? "<img src='{$item["cover_addr"]}' class='w50'>" : "-"; ?></td>
  	  <td><?php echo $item["title"]; ?></td>
  	  <td><?php echo $item["album_title"]; ?></td>
  	  <td><?php echo $item["artist_name"]; ?></td>
  	  <td>
	    <div class="btn-group btn-group-sm" role="group">
	      <button id="dropdown_btns" type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	        Manage
	      </button>
	      <div class="dropdown-menu" aria-labelledby="dropdown_btns">
	        <a class="dropdown-item edit_track_handle" data-hook="<?php echo $item["ID"]; ?>"><span class="mdi mdi-circle-edit-outline"></span> Edit</a>
	        <a class="dropdown-item delete_track_handle" data-hook="<?php echo $item["ID"]; ?>"><span class="mdi mdi-minus-circle-outline"></span> Delete</a>
	        <a class="dropdown-item" href="<?php $loader->ui->eurl( "admin_content_sources", null, "track_id={$item["ID"]}" ); ?>"><span class="mdi mdi-download"></span> Manage Sources</a>
	        <a class="dropdown-item" href="<?php $loader->ui->eurl( "admin_user_comments", null, "target_type=track&target_id={$item["ID"]}" ); ?>"><span class="mdi mdi-message-reply"></span> Manage Comments</a>
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
	    <a class="btn btn-danger btn-sm hoi delete_track_handle"><span class="mdi mdi-minus-circle-outline"></span> Delete</a>
        <a class="btn btn-primary btn-sm new_track_handle"><span class="mdi mdi-plus"></span> New</a>
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
<a class="btn btn-primary btn-sm new_track_handle"><span class="mdi mdi-plus"></span> New</a>
<?php endif; ?>

</div>
<script>
var $__tracks = JSON.parse('<?php echo $loader->general->json_encode( $page_data["items"], true ); ?>');
var $__genres = JSON.parse('<?php echo $loader->general->json_encode( $page_data["genres"], true ); ?>');
</script>
