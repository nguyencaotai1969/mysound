<?php

if ( !defined( "root" ) ) die;

set_time_limit( $loader->admin->get_setting( 'up_timeout', 90 ) );
ini_set( 'max_execution_time', $loader->admin->get_setting( 'up_timeout', 90 ) );

if ( !( $upload_ID = $loader->secure->get( "get", "ID", "md5", [ "length" => 20 ] ) ) )
$this->set_error_header('HTTP/1.0 400 Bad Request')->set_error( "failed" );

if ( !( $sent_file = $loader->secure->get( "file", '$file', "file", [ "acceptable_extensions" => [ "mp3" ], "acceptable_types" => [ "audio/mpeg", "application/octet-stream" ] ] ) ) )
$this->set_error_header('HTTP/1.0 400 Bad Request')->set_error( "failed" );

$file = $this->loader->general->handle_chunk_upload(array(
	'chunkSize' => $loader->admin->get_setting( 'chunk_size', 2 ) * 1000000,
	'maxSize'   => $loader->admin->get_setting( 'max_size', 20 ) * 1000000,
	"validExtensions" => [ "mp3" ]
));

if ( $file === true ){
	$this->set_error( "uploaded_chunk" );
}
else if ( $file === false ){
	$this->set_error_header('HTTP/1.0 400 Bad Request')->set_error( "failed" );
}
else {

	if ( !is_file( $file ) )
	$this->set_error_header('HTTP/1.0 400 Bad Request')->set_error( "failed" );

	if ( $loader->upload->add_from_file( $file, $sent_file["name"], $upload_ID ) )
	$this->set_response( "uploaded" );

	$this->set_error_header('HTTP/1.0 400 Bad Request')->set_error( "failed" );

}

?>
