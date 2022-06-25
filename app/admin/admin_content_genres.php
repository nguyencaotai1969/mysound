<?php if ( !defined( "root" ) ) die; ?>
<div class="box-title big">
  <div class="icon"><span class="mdi mdi-tag"></span></div>
  <div class="title">Manage Genres</div>
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
     	  	
     	  	  <label>Status:</label>
     	  	  <?php 
     	  	  echo $loader->html->doms->create_input( "select", "status", $loader->general->http_build_query( $page_data["reqs"], [ "status" => $page_data["status"] ], true ), [ 
     	  	      $loader->general->http_build_query( $page_data["reqs"], [ "status" => 0 ], true ) => "All", 
     	  	      $loader->general->http_build_query( $page_data["reqs"], [ "status" => 1 ], true ) => "Active", 
     	  	      $loader->general->http_build_query( $page_data["reqs"], [ "status" => 2 ], true ) => "Removed" 
     	  	  ] ); ?>
     	  	
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

<?php if ( $page_data["genres"] ) : ?>
<div class="table_wrapper">
<table width="100%">
  <thead>
  	<tr>
  	  <td width="40px"><input type="checkbox" value="all"></td>
  	  <td width="20px">ID</td>
  	  <td width="80px">Image</td>
  	  <td>Name</td>
  	  <td width="40px">Status</td>
  	  <td width="20px">-</td>
  	</tr>
  </thead>
  <tbody>
    <?php $i=0; foreach( $page_data["genres"] as $genre ) : $i++; ?>
  	<tr>
  	  <td class="tar"><input type="checkbox" value="ID<?php echo $genre["ID"]; ?>" <?php if ($genre["deleted"]!=0) echo " disabled='disabled'"; ?> ></td>
  	  <td><?php echo $genre["ID"]; ?></td>
  	  <td><?php echo $genre["image"] ? "<img src='{$genre["image_addr"]}' class='w50'>" : "-"; ?></td>
  	  <td><?php echo $genre["name"]; ?></td>
  	  <td class="tar"><?php if ( $genre["deleted"] == 0 ) : ?><span class="badge badge-success">Active</span><?php else : ?><span class="badge badge-secondary">Removed</span><?php endif; ?></td>
  	  <td>
	    <div class="btn-group btn-group-sm" role="group">
	      <button id="dropdown_btns" type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	        Manage
	      </button>
	      <div class="dropdown-menu" aria-labelledby="dropdown_btns">
            <?php if ( $genre["deleted"] == 0 ) : ?>
	        <a class="dropdown-item edit_genre_handle" data-hook="<?php echo $genre["code"]; ?>"><span class="mdi mdi-circle-edit-outline"></span> Edit</a>
	        <a class="dropdown-item delete_genre_handle" data-hook="<?php echo $genre["ID"]; ?>"><span class="mdi mdi-minus-circle-outline"></span> Delete</a>
	        <?php else: ?>
	        <a class="dropdown-item recover_genre_handle" data-hook="<?php echo $genre["ID"]; ?>"><span class="mdi mdi-undo"></span> Recover</a>
	        <a class="dropdown-item truncate_genre_handle" data-hook="<?php echo $genre["ID"]; ?>"><span class="mdi mdi-delete"></span> Delete permanently</a>
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
	    <a class="btn btn-danger btn-sm hoi delete_genre_handle"><span class="mdi mdi-minus-circle-outline"></span> Delete</a>	
	    <a class="btn btn-primary btn-sm new_genre_handle"><span class="mdi mdi-plus"></span> New</a>
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
<script>
var $__genres = JSON.parse('<?php echo $loader->general->json_encode( $page_data["genres"], true ); ?>');	
</script>
<?php ;else: ?>
Found nothing<br>
<a class="btn btn-primary btn-sm new_genre_handle"><span class="mdi mdi-plus"></span> New</a>
<?php endif; ?>
</div>