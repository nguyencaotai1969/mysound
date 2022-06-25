<?php if ( !defined( "root" ) ) die; ?>
<div class="box-title big">
  <div class="icon"><span class="mdi mdi-alert"></span></div>
  <div class="title">User Reports</div>
</div>

<div class="box cmt big" >

<?php if ( $page_data["items"] ) : ?>
<div class="table_wrapper">
<table width="100%">
  <thead>
  	<tr>
  	  <td width="40px"><input type="checkbox" value="all"></td>
  	  <td width="80px">Cover</td>
  	  <td>Title</td>
      <td>Album</td>
      <td>Reason</td>
  	  <td>Reported By</td>
  	  <td width="20px">-</td>
  	</tr>
  </thead>
  <tbody>
    <?php $i=0; foreach( $page_data["items"] as $item ) : $i++; ?>
  	<tr>
  	  <td class="tar"><input type="checkbox" value="ID<?php echo $item["track"]["ID"]; ?>" ></td>
  	  <td><?php echo $item["track"]["cover"] ? "<img src='{$item["track"]["cover_addr"]}' class='w50'>" : "-"; ?></td>
  	  <td><?php echo $item["track"]["title"]; ?></td>
      <td><?php echo $item["track"]["album_title"]; ?></td>
      <td><?php echo $item["reason"]; ?></td>
  	  <td>@<?php echo $item["user"]["username"]; ?></td>
  	  <td>
	    <div class="btn-group btn-group-sm" role="group">
	      <button id="dropdown_btns" type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	        Manage
	      </button>
	      <div class="dropdown-menu" aria-labelledby="dropdown_btns">
	        <a class="dropdown-item dismiss_report_handle" data-hook="<?php echo $item["track"]["ID"]; ?>"><span class="mdi mdi-close-circle-outline"></span> Dismiss report</a>
	        <a class="dropdown-item delete_track_handle" data-hook="<?php echo $item["track"]["ID"]; ?>"><span class="mdi mdi-minus-circle-outline"></span> Delete track</a>
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
	    <a class="btn btn-danger btn-sm hoi delete_track_handle"><span class="mdi mdi-minus-circle-outline"></span> Delete Track(s)</a>
      <a class="btn btn-primary btn-sm hoi dismiss_report_handle"><span class="mdi mdi-close-circle-outline"></span> Dismiss Report(s)</a>
	  </td>
  	</tr>
  </tfoot>
</table>
</div>
<?php ;else: ?>
Found nothing<br>
<?php endif; ?>

</div>
