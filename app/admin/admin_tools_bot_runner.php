<?php if ( !defined( "root" ) ) die; ?>
<div class="box-title auto">
  <div class="icon"><span class="mdi mdi-robot"></span></div>
  <div class="title">Spotify Widget Updater</div>
</div>

<div class="logs bot">
  <div class="log">Total spotify widgets: <b><?php echo number_format( count( $page_data["widgets"]["updated"] ) + count( $page_data["widgets"]["outdated"] ) ); ?></b></div>
  <div class="log">Total updated spotify widgets: <b><?php echo number_format( count( $page_data["widgets"]["updated"] ) ); ?></b></div>
  <div class="log">Total outdated spotify widgets: <b><?php echo number_format( count( $page_data["widgets"]["outdated"] ) ); ?></b></div>
</div>


<script>
var $widgets = JSON.parse('<?php echo json_encode( $page_data["widgets"]["outdated"] ? array_keys( $page_data["widgets"]["outdated"] ) : [] ); ?>');

$(document).ready(function(){
	update_widget();
});
	
</script>