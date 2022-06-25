<?php if ( !defined( "root" ) ) die; ?>
<div class="box-title big">
  <div class="icon"><span class="mdi mdi-download"></span></div>
  <div class="title">Manage Sources</div>
</div>

<div class="box cmt big" >

<?php if ( $page_data["sources"] ) : ?>
<div class="table_wrapper">
<table width="100%">
  <thead>
  	<tr>
  	  <td width="40px"><input type="checkbox" value="all"></td>
  	  <td width="20px">ID</td>
  	  <td width="40px">Type</td>
  	  <td>Data</td>
  	  <td width="20px">-</td>
  	</tr>
  </thead>
  <tbody>
    <?php $i=0; foreach( $page_data["sources"] as $source ) : $i++; ?>
  	<tr>
  	  <td class="tar"><input type="checkbox" value="ID<?php echo $source["ID"]; ?>" ></td>
  	  <td><?php echo $source["ID"]; ?></td>
  	  <td><?php echo $source["type"]; ?></td>
  	  <td><?php echo $source["data"] . ( $source["type"] == "file" ? "<br>Bitrate: {$source["bitrate"]}" :"" ); ?></td>
  	  <td>
	    <div class="btn-group btn-group-sm" role="group">
	      <button id="dropdown_btns" type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	        Manage
	      </button>
	      <div class="dropdown-menu" aria-labelledby="dropdown_btns">
	        <a class="dropdown-item delete_source_handle" data-hook="<?php echo $source["ID"]; ?>"><span class="mdi mdi-minus-circle-outline"></span> Delete</a>
	        <a class="dropdown-item delete_source_waves_handle" data-hook="<?php echo $source["ID"]; ?>"><span class="mdi mdi-minus-circle-outline"></span> Delete Waveforms</a>
	      </div>
	    </div>	
	  </td>
  	</tr>
  	<?php endforeach; ?>
  </tbody>
  <tfoot>
  	<tr>
  	  <td colspan="1" class="tar"></td>
  	  <td colspan="4" class="tar p10r">
	    <a class="btn btn-danger btn-sm hoi delete_source_handle"><span class="mdi mdi-minus-circle-outline"></span> Delete</a>
        <a class="btn btn-primary btn-sm new_source_handle" data-hook="<?php echo $page_data["track_id"]; ?>"><span class="mdi mdi-plus"></span> New</a>
	  </td>
  	</tr>
  </tfoot>
</table>
</div>
<?php ;else: ?>
Found nothing<br>
<a class="btn btn-primary btn-sm new_source_handle" data-hook="<?php echo $page_data["track_id"]; ?>"><span class="mdi mdi-plus"></span> New</a>
<?php endif; ?>

</div>