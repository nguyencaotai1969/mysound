<?php if ( !defined("root" ) ) die; ?>
<div class="box-title big">
  <div class="icon"><span class="mdi mdi-shield-check"></span></div>
  <div class="title">Artist Verification Requests</div>
</div>

<div class="box cmt big" >

<?php if ( $page_data["items"] ) : ?>
<div class="table_wrapper">
<table width="100%">
  <thead>
  	<tr>
  	  <td width="20px" class="p10l">ID</td>
  	  <td width="80px">User</td>
  	  <td>Real Name</td>
  	  <td>Stage Name</td>
  	  <td>Documents</td>
  	  <td>Data</td>
  	  <td width="20px">-</td>
  	</tr>
  </thead>
  <tbody>
    <?php $i=0; foreach( $page_data["items"] as $item ) : $i++; ?>
  	<tr>
  	  <td><?php echo $item["ID"]; ?></td>
  	  <td><?php echo $loader->user->set( $item["user_id"] )->data()->username; ?></td>
  	  <td><?php echo $loader->secure->escape( $item["real_name"] ); ?></td>
  	  <td><?php echo $loader->secure->escape( $item["stage_name"] ); ?></td>
  	  <td><?php $files = $item["files"] ? json_decode( $item["files"], 1 ) : null; if ( !empty( $files ) ){foreach( $files as $file ){
	      echo "<a target='_blank' href='{$loader->general->path_to_addr($file)}'>-File Link-</a>";
      }} ?></td>
  	  <td><?php echo $item["data"] ? $loader->secure->escape( str_replace( PHP_EOL, "<BR>", strip_tags( $item["data"], "<br><b>" ) ) ) : ""; ?></td>
  	  <td>
	    <div class="btn-group btn-group-sm" role="group">
	      <a class="btn btn-success accept_artist_handle" data-hook="<?php echo $item["ID"]; ?>">Accept</a>
	      <a class="btn btn-success reject_artist_handle" data-hook="<?php echo $item["ID"]; ?>">Reject</a>
	    </div>
	  </td>
  	</tr>
  	<?php endforeach; ?>
  </tbody>

</table>
</div>
<?php ;else: ?>
Found nothing
<?php endif; ?>

</div>
