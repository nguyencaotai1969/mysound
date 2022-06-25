<?php

if ( !defined( "root" ) ) die;

$loader->html->set_title( "Tools - Cleaner" );

$uploadingDirNames = [];
$dirs = $loader->general->scan_folder( $loader->general->upload_dir . "uploading", [ "recursive" => false ] )["dirs"];
foreach( array_slice( $dirs, 1 ) as $_dir ){
	$__e = explode( "/", $_dir );
	$uploadingDirNames[] = end( $__e );
}

$loader->ui->set_page_data([
	"uploading_folders" => $uploadingDirNames
]);

?>
