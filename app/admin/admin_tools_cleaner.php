<?php if ( !defined( "root" ) ) die; ?>

<div class="box-title auto">
  <div class="icon"><span class="mdi mdi-broom"></span></div>
  <div class="title">Cleaner</div>
</div>

This tool can help you remove unused files and optimize database tables. You should run it every other weekend <br><br>


<div id="cleaner_logs" style="font-size:10pt">
  <div class="btn btn-primary" id="cleaner_handler">Start</div>
</div>

<script>
var $__uploadingDirsNames = JSON.parse('<?php echo $loader->general->json_encode( $page_data["uploading_folders"], true ); ?>');
</script>
