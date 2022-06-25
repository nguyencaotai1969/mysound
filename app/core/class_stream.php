<?php

if ( !defined("root" ) ) die;

class stream {

  public function handle_download( $location, $filename, $paid, $mimeType = 'audio/mpeg' ){

    if ( !is_file( $location ) ) return false;
    
    $size = filesize($location);
    $time = date('r', filemtime($location));

    $fm = fopen($location, 'rb');

    if ( !$paid ) $size = intval( $size * 0.2 );

    $begin = 0;
    $end = $size - 1;

    if ( isset( $_SERVER['HTTP_RANGE'] ) ? preg_match('/bytes=\h*(\d+)-(\d*)[\D.*]?/i', $_SERVER['HTTP_RANGE'], $matches) : false ){

      $begin = intval( $matches[1] );
      if ( !empty( $matches[2] ) ? $end+1 >= $matches[2] : false )
      $end = intval( $matches[2] );

    }

    if ( isset( $_SERVER['HTTP_RANGE'] ) ){
      header( 'HTTP/1.1 206 Partial Content' );
    } else {
      header( 'HTTP/1.1 200 OK' );
    }

    if ( isset( $_SERVER['HTTP_RANGE'] ) )
    header("Content-Range: bytes {$begin}-{$end}/{$size}");

    header("Content-Type: {$mimeType}");
    header("Cache-Control: public, must-revalidate, max-age=0");
    header("Pragma: no-cache");
    header("Accept-Ranges: bytes");
    header("Content-Length:" .( ( $end-$begin ) + 1) );
    header("Content-Encoding: none");
    header("Content-Disposition: inline; filename={$filename}");
    header("Content-Transfer-Encoding: binary");
    header("Last-Modified: {$time}");

    $cur = $begin;
    fseek($fm, $begin, 0);

    while( !feof($fm) && $cur <= $end && ( connection_status() == 0 ) ){

      print fread($fm, min(1024 * 64, ($end - $cur) + 1));
      ob_flush();
      flush();
      $cur += 1024 * 64;

    }

  }

}

?>
