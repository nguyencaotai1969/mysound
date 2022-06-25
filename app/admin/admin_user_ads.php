<?php if ( !defined( "root" ) ) die; ?>
<div class="box-title big">
  <div class="icon"><span class="mdi mdi-star"></span></div>
  <div class="title">Advertisement</div>
</div>

<div class="box cmt big" >

  <div class="sort_wrapper">
    <div class="row">
      <div class="col-12 filters tar" >

        <label>Status: </label>
        <?php
        echo $loader->html->doms->create_input(
          "select",
          "paid",
          $loader->general->http_build_query( $page_data["reqs"], [ "active" => $page_data["active"] ], true ),
          [
            $loader->general->http_build_query( $page_data["reqs"], [ "active" => "all" ], true ) => "All",
            $loader->general->http_build_query( $page_data["reqs"], [ "active" => -2 ], true )  => "Rejected",
            $loader->general->http_build_query( $page_data["reqs"], [ "active" => -1 ], true )  => "Removed",
            $loader->general->http_build_query( $page_data["reqs"], [ "active" => 0 ], true ) => "Pending",
            $loader->general->http_build_query( $page_data["reqs"], [ "active" => 1 ], true ) => "Active",
            $loader->general->http_build_query( $page_data["reqs"], [ "active" => 2 ], true )  => "Paused",
            ]
          );
          ?>

      </div>
    </div>
  </div>

<?php if ( $page_data["items"] ) : ?>
<div class="table_wrapper">
<table width="100%">
  <thead>
  	<tr>
  	  <td width="20px">ID</td>
      <td>Name</td>
      <td>Type</td>
      <td>Target</td>
      <td>Fund <?php echo $loader->admin->get_setting("currency"); ?><br>Total/Spent</td>
      <td>Clicks/Views</td>
      <td>Time Add</td>
      <td width="20px">-</td>
  	  <td width="20px">-</td>
  	</tr>
  </thead>
  <tbody>
    <?php $i=0; foreach( $page_data["items"] as $item ) : $i++; ?>
  	<tr>
  	  <td><?php echo $item["ID"]; ?></td>
      <td><?php echo $item["name"]; ?><br>@<?php echo $item["user"]["username"]; ?></td>
      <td><?php echo $item["type_hr"] . "<BR>" . $item["files_urls_inline"]; ?></td>
      <td><a href="<?php echo $item["url"]; ?>" target="_blank"><?php echo $item["url_host"]; ?></a></td>
      <td><?php echo number_format( $item["fund_total"] ) . "/" . number_format( $item["fund_spent"] ); ?></td>
      <td><?php echo number_format( $item["act_clicks"] ) . "/" . number_format( $item["act_views"] ); ?></td>
  	  <td><?php echo $item["time_add_sml"]; ?></td>
  	  <td><span class="badge badge-<?php echo $item["active_color"]; ?>"><?php echo $item["active_hr"]; ?></span></td>
  	  <td>
	    <div class="btn-group btn-group-sm" role="group">
	      <button id="dropdown_btns" type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	        Manage
	      </button>
	      <div class="dropdown-menu" aria-labelledby="dropdown_btns">
          <a class="dropdown-item admin_ad_edit_handle" data-hook="<?php echo $item["ID"]; ?>"><span class="mdi mdi-pencil"></span> Edit</a>
          <?php if ( $item["active"] == 0 ) : ?>
          <a class="dropdown-item admin_ad_handle" data-action="1" data-hook="<?php echo $item["ID"]; ?>"><span class="mdi mdi-check-circle"></span> Approve</a>
          <a class="dropdown-item admin_ad_handle" data-action="-2" data-hook="<?php echo $item["ID"]; ?>"><span class="mdi mdi-minus-circle"></span> Reject</a>
          <?php endif; ?>
          <?php if ( $item["active"] == 1 ) : ?>
          <a class="dropdown-item admin_ad_handle" data-action="2" data-hook="<?php echo $item["ID"]; ?>"><span class="mdi mdi-pause-circle"></span> Pause</a>
          <?php endif; ?>
          <?php if ( $item["active"] == 2 ) : ?>
          <a class="dropdown-item admin_ad_handle" data-action="1" data-hook="<?php echo $item["ID"]; ?>"><span class="mdi mdi-play-circle"></span> Resume</a>
          <?php endif; ?>
          <?php if ( $item["active"] == -2 || $item["active"] == 2 ) : ?>
          <a class="dropdown-item admin_ad_handle" data-action="-1" data-hook="<?php echo $item["ID"]; ?>"><span class="mdi mdi-delete-circle"></span> Remove</a>
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
      <td colspan="8" class="tar p10r" >
        <a class="btn btn-primary btn-sm new_adsense_handle"><span class="mdi mdi-plus"></span> Google Adsense</a>
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
var $__ads = JSON.parse('<?php echo $loader->general->json_encode( $page_data["items"], false ); ?>');
var $__placements = JSON.parse('<?php echo $loader->general->json_encode( $loader->ads->getPlacements("for_select"), false ); ?>');
</script>
<?php ;else: ?>
Found nothing
<a class="btn btn-primary btn-sm new_adsense_handle"><span class="mdi mdi-plus"></span> Google Adsense</a>
<?php endif; ?>

</div>
