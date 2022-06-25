<?php if ( !defined( "root" ) ) die; ?>

<div class="container page">
<div class="row">
<?php

// Widget request
if ( $page_data["widget_ID"] ){
	$loader->ui->load_page_widget( $page_data["widgets"][ $page_data["widget_ID"] ], null, null, $page_data["widget_page"] );
}
	
// Widgets ( page ) request
else {
	foreach( (array) $page_data["widgets"] as $widget ){
		$loader->ui->load_page_widget( $widget );
	}
}

?>

</div>
</div>