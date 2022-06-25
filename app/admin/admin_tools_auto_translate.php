<?php if ( !defined( "root" ) ) die; ?>

<div class="box-title">
  <div class="icon"><span class="mdi mdi-robot"></span></div>
  <div class="title">Auto Translate</div>
</div>

<div class="box">
 
  <?php if ( empty( $page_data["reqed_lang"] ) ) : ?>
	
  This tools uses <a class="gtp" href="https://github.com/Stichoza/google-translate-php">Google Translate PHP</a> to automatically translate your untranslated texts from English to other languages. Click on `Translate` button then kindly wait please. There is a 5 second delay between each translate request to avoid spamming on Google service
 
  <div class="groups m30t">
    <?php foreach( $page_data["langs"] as $code => $lang ) :
	  if ( $code == "en" ) continue; ?>
    <div class="group">
      <div class="label"><?php echo $lang; ?></div>
      <div class="buttons">
      	<a class="button" href="<?php $loader->ui->eurl( 'admin_tools_auto_translate', null, "code={$code}" ) ?>" >Translate</a>
      </div>
    </div>	  
    <?php endforeach; ?>
  </div>
	
  <?php else : ?>
	
	<?php 
	foreach( $page_data["hooks"][ "en" ] as $code => $data ){
		if ( empty( $page_data["hooks"][ $page_data["reqed_lang"] ][ $code ][ "text" ] ) ){
			$untranslated[] = $data["ID"];
		}
	}
	if ( empty( $untranslated ) ) : echo "There are no untranslated texts";
	else :
	?>
	  <div id="logs"></div>
	  <script>
	  var $ids = JSON.parse('<?php echo json_encode( $untranslated ); ?>');
	  $(document).ready(function(){
		  translate('<?php echo $page_data["reqed_lang"]; ?>');
	  });
	  </script>
	<?php endif; ?>
	
  <?php endif; ?>
	
</div>