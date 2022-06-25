<?php if ( !defined( "root" ) ) die; ?>
<div class="box-title ">
  <div class="icon"><span class="mdi mdi-translate"></span></div>
  <div class="title">Language Editor</div>
</div>

<?php if ( empty( $loader->ui->page_data["hooks"] ) ) : ?>

<div class="box ">

  <div class="groups">
    <?php foreach( $loader->ui->page_data["langs"] as $code => $lang ) : ?>
    <div class="group">
      <div class="label"><?php echo $loader->secure->escape( $lang ); ?></div>
      <div class="buttons">
      	<a class="button" href="<?php $loader->ui->eurl( 'admin_language_editor', null, "code={$code}" ) ?>">Edit</a>
      	<div class="button remove_lang_handle" data-hook="<?php echo $code; ?>" data-name="<?php echo $loader->secure->escape( $lang ); ?>">Remove</div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>

  <div class="foot_buttons">
    <a class="btn btn-wide btn-primary new_lang_handle">+ New Language</a>
  </div>

</div>
<?php else : ?>

<div class="box ">

  <div class="tablewrapper">
  <table>
  	<thead>
  	  <tr>
  	  	<td>Code</td>
  	  	<td><?php echo $loader->ui->page_data["code"]; ?> version</td>
  	  	<td>-</td>
  	  </tr>
  	</thead>
  	<tbody>
  	  <?php foreach( $loader->ui->page_data["hooks"]["en"] as $_hook => $_text ):
		$__text = !empty( $loader->ui->page_data["hooks"][$page_data["r_code"]][$_hook] ) ? $loader->ui->page_data["hooks"][$page_data["r_code"]][$_hook] : "?"; ?>
  	  <tr>
  	  	<td><?php echo $_hook . ( substr( $_hook, 0, 2 ) == "m_" ? "<span class='t1'>used in menu-builder</span>" : "" ) . ( substr( $_hook, 0, 2 ) == "p_" ? "<span class='t2'>used in page-builder</span>" : "" ); ?></td>
  	  	<td><?php echo $loader->secure->escape( $__text );  ?></td>
  	  	<td><a class="btn btn-light btn-sm edit_lang_handle" data-hook="<?php echo $_hook; ?>" data-val="<?php echo $loader->secure->escape( str_replace( PHP_EOL, " __ ", $__text ) ); ?>" data-en-val="<?php echo $loader->secure->escape( str_replace( PHP_EOL, " __ ", $_text ) ); ?>">Edit</a></td>
  	  </tr>
  	  <?php endforeach; ?>
  	</tbody>
  </table>
  </div>

</div>

<?php endif; ?>
