<?php

if ( !defined( "root" ) ) die;

class general {

	public $upload_dir = null;
	public $uploading_dir = null;
	public $protected_dir = null;
	public $image_dir = null;
	public $day_string = null;
	public $curl_debug = false;

	public function __construct( $loader ){

		$this->loader = $loader;
		$this->db = $loader->db;

		$this->day_string = date( "ymd" );
		$this->month_string = date( "ym" );
		$this->upload_dir = root . "/uploads/";
		$this->uploading_dir = $this->upload_dir . "/uploading/" . $this->day_string;
		$this->protected_dir = $this->upload_dir . "/protected/" . $this->day_string;
		$this->image_dir = $this->upload_dir . "/images/" . $this->day_string;

	}

	// simplify default functions
	public function mkdir( $path, $mode = 0777, $rec = true ){

		if ( !is_dir( $path ) ) mkdir( $path, $mode, $rec );
		return realpath( $path );

	}
	public function strtotime( $string, $turn=false ){

		$_m = null;
		$_d = null;
		$_h = null;
		$_mi = null;
		$_s = null;
		$__p = 1;

		// 20200101
		if ( strlen( $string ) == 8 && ( ctype_digit( $string ) || is_int( $string ) ) ){
			$_y = substr( $string, 0, 4 );
			$_m = substr( $string, 4, 2 );
			$_d = substr( $string, 6, 2 );
		}
		// 2020
		else if ( strlen( $string ) == 4 && ( ctype_digit( $string ) || is_int( $string ) ) ){
			$_y = $string;
		}
		// 2020-01 2020/01 2020-1 2020/1
		else if ( strlen( $string ) == 6 || strlen( $string ) == 7 ){
			$__seperate = explode( " ", str_replace( [ "/", "-", "_", "\\", ",", ".", ":", "  " ], " ", $string ) );
			if ( count( $__seperate ) == 2 ? strlen( $__seperate[0] ) == 4 : false ){
				list( $_y, $_m ) = $__seperate;
			}
		}
		// 2020-01-01 2020/01/01 2020-1-1 2020/1/1 2020/1-1
		else if ( strlen( $string ) == 8 || strlen( $string ) == 9 || strlen( $string ) == 10 ) {
			$__seperate = explode( " ", str_replace( [ "/", "-", "_", "\\", ",", ".", ":", "  " ], " ", $string ) );
			if ( count( $__seperate ) == 3 && ctype_digit( implode( "", $__seperate ) ) ? strlen( $__seperate[0] ) == 4 : false ){
				list( $_y, $_m, $_d ) = $__seperate;
			}
		}
		// 2020/01/01 00:00:00   2020-01-01 00/00/00
		else if ( strlen( $string ) == 19 ) {
			$__seperate = explode( " ", str_replace( [ "/", "-", "_", "\\", ",", ".", ":", "  " ], " ", $string ) );
			if ( count( $__seperate ) == 6 && ctype_digit( implode( "", $__seperate ) ) ? strlen( $__seperate[0] ) == 4 && strlen( $__seperate[1] ) == 2 && strlen( $__seperate[2] ) == 2 && strlen( $__seperate[3] ) == 2 && strlen( $__seperate[4] ) == 2 && strlen( $__seperate[5] ) == 2 : false ){
				list( $_y, $_m, $_d, $_h, $_mi, $_s ) = $__seperate;
			}
		}

		if ( empty( $_y ) ? true : intval( $_y ) > 2022 || intval( $_y ) < 1900 )
			return false;

		if ( empty( $_m ) ? false : intval( $_m ) < 1 || intval( $_m ) > 12 )
			return false;
		elseif ( !empty( $_m ) ) $__p = 2;

		if ( empty( $_d ) ? false : intval( $_d ) < 1 || intval( $_d ) > 31 )
			return false;
		elseif ( !empty( $_d ) ) $__p = 3;

		if ( empty( $_h ) ? false : intval( $_h ) < 0 || intval( $_h ) > 23 )
			return false;
		elseif ( !empty( $_h ) ) $__p = 4;

		if ( empty( $_mi ) ? false : intval( $_mi ) < 0 || intval( $_mi ) > 59 )
			return false;
		elseif ( !empty( $_mi ) ) $__p = 5;

		if ( empty( $_s ) ? false : intval( $_s ) < 0 || intval( $_s ) > 59 )
			return false;
		elseif ( !empty( $_s ) ) $__p = 6;

		$_m  = empty( $_m ) ? "01" : $_m;
		$_d  = empty( $_d ) ? "01" : $_d;
		$_h  = empty( $_h ) ? "00" : $_h;
		$_mi = empty( $_mi ) ? "00" : $_mi;
		$_s  = empty( $_s ) ? "00" : $_s;
		$_m  = strlen( $_m ) == 1 ? "0{$_m}" : $_m;
		$_d  = strlen( $_d ) == 1 ? "0{$_d}" : $_d;

		$_fs = "{$_y}-{$_m}-{$_d} {$_h}:{$_mi}:{$_s}";
		return [ $turn ? strtotime( $_fs ) : $_fs, $__p ];

	}
	public function json_encode( $data, $full=true ){

		return $full ?
			str_replace( [ '\r', "'", "\\\\", '\"', '\r\n', '\n', '<BR>', '<br>' ], [ '', "\'", "\\\\\\\\", "", '\\\\r\\\\n', '\\\\r\\\\n', '\\\\r\\\\n', '\\\\r\\\\n' ], json_encode( $data, JSON_UNESCAPED_UNICODE|JSON_HEX_QUOT|JSON_HEX_APOS ) ) :
			addslashes( json_encode( $data, JSON_UNESCAPED_UNICODE|JSON_HEX_QUOT|JSON_HEX_APOS ) );

	}
	public function json_decode( $string ){

		return json_decode( stripslashes( $string ) , 1 );

	}
	public function substr( $string, $offset, $length, $show_dots = true, $encode = "UTF-8" ){

		$string_length = mb_strlen( $string, $encode ) - $offset;
		$string_cut = mb_substr( $string, $offset, $length, $encode );
		return $show_dots ? ( $string_length > $length ? "{$string_cut} <span class='dots'>...</span>" : $string_cut ) : $string_cut;

	}
	public function curl( $args ){

		$url = null;
		$posts = null;
		$proxy = $this->loader->admin->get_setting( "req_proxy", null );
		$proxyAuth = $this->loader->admin->get_setting( "req_proxy_a", null );
		$headers = null;
		$agent = null;
		$timeout = 30;
		$ctimeout = 5;
		$connect_timeout = 5;
		$follow_location = true;
		$follow_location_max = 3;
		$cache_save = true;
		$cache_load = true;
		$cache_range = 12;
		$cached = null;
		extract( $args );

		if ( empty( $url ) ) return false;
		$hashID = md5( json_encode( $args ) );

		// Try to load this requeust from cache
		if ( $cache_load ){

			$cached = $this->db->_select([
				"table" => "_curl_cache",
				"where" => [
					[ "hashID", "=", $hashID ],
					[ "time_start", ">", "SUBDATE( now(), INTERVAL {$cache_range} HOUR )", true ]
				],
				"order_by" => "time_start",
				"limit" => 1
			]);

			if ( !empty( $cached ) ){
				$cached = reset( $cached );
				if ( $this->curl_debug ) echo "CURL: {$url} was cached, returning the data\n";
				return[
					!empty( $cached["response_header"] ) ? json_decode( $cached["response_header"], 1 ) : null,
					!empty( $cached["response_body"] )   ? $cached["response_body"] : null
				];
			}

		}

		$c = curl_init( $url );
		curl_setopt( $c, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $c, CURLOPT_VERBOSE, 0);
		curl_setopt( $c, CURLOPT_HEADER, 1);
		curl_setopt( $c, CURLOPT_FOLLOWLOCATION, $follow_location );
		curl_setopt( $c, CURLOPT_CONNECTTIMEOUT, $connect_timeout );
		curl_setopt( $c, CURLOPT_TIMEOUT, $timeout );
		curl_setopt( $c, CURLOPT_CONNECTTIMEOUT, $ctimeout );
		curl_setopt( $c, CURLOPT_MAXREDIRS, $follow_location_max );
		if ( $agent ) curl_setopt( $c, CURLOPT_USERAGENT, $agent );
		if ( $proxy ) curl_setopt( $c, CURLOPT_PROXY, $proxy );
		if ( $proxy && $proxyAuth ) curl_setopt( $c, CURLOPT_PROXYUSERPWD, $proxyAuth );
		if ( $headers ) curl_setopt( $c, CURLOPT_HTTPHEADER, $headers );
		if ( $posts ){
			curl_setopt( $c, CURLOPT_POST, true );
			curl_setopt( $c, CURLOPT_POSTFIELDS, is_array( $posts ) ? http_build_query( $posts ) : $posts );
		}

		$__res = curl_exec( $c );
		$header_size = curl_getinfo( $c, CURLINFO_HEADER_SIZE );
		$response_headers = explode( PHP_EOL, substr( $__res, 0, $header_size ) );
		if ( !empty( $response_headers ) ){
			foreach( $response_headers as $_i => $_v ){
				if ( empty( $_v ) ) unset( $response_headers[ $_i ] );
				else $response_headers[ $_i ] = trim( $_v );
			}
		}
		$body = substr( $__res, $header_size );
		unset( $__res, $header_size );
		curl_close( $c );
		if ( $this->curl_debug ) echo "CURL: {$url} finished. Response length: " . strlen( $body ) . PHP_EOL;

		// Save this request to cache?
		if ( $cache_save && !empty( $body ) && !empty( $response_headers ) ){

			$__o = json_encode( $args );
			$__rqb = !empty( $posts ) ? ( is_array( $posts ) ? http_build_query( $posts ) : $posts ) : null;
			$__rqh = !empty( $headers ) ? json_encode( $headers ) : null;
			$__rph = !empty( $response_headers ) ? json_encode( $response_headers ) : null;
			$is = $this->db->prepare("INSERT INTO _curl_cache ( hashID, url, options, request_body, request_header, response_body, response_header ) VALUES ( ?, ?, ?, ?, ?, ?, ? )");
			$is->bind_param( "sssssss", $hashID, $url, $__o, $__rqb, $__rqh, $body, $__rph );
			$is->execute();
			$is->close();

		}

		return [ $response_headers, $body ];

	}

	// handle uploads
	public function handle_chunk_upload( $args = [] ){

		$paramName = '$file';
		$accept    = 'both';
		$chunkSize = 2000000;
		$maxSize   = 10000000;
		$validExtensions = [ "jpg", "jpeg", "gif", "png" ];
		extract( $args );
		$maxChunks = ceil( $maxSize / $chunkSize );

    if ( !$sent_file = $this->loader->secure->get( "file", $paramName, "file", [ "acceptable_extensions" => [ "mp3" ], "acceptable_types" => [ "audio/mpeg", "application/octet-stream" ] ] ) )
	  	return false;

		// Detect upload type ( chunked or uncut? )
		$dzuuid = $this->loader->secure->get( "post", "dzuuid", "string", [ "strict" => true, "strict_regex" => "[a-z0-9\-]", "min_length" => 20, "max_length" => 60 ] );
		$dzchunkindex = $this->loader->secure->get( "post", "dzchunkindex", "int", [ "min" => 0 ] );
		$dztotalfilesize = $this->loader->secure->get( "post", "dztotalfilesize", "int", [ "min" => 100000 ] );
		$dzchunksize = $this->loader->secure->get( "post", "dzchunksize", "int", [ "min" => 100000 ] );
		$dztotalchunkcount = $this->loader->secure->get( "post", "dztotalchunkcount", "int", [ "max" => 100 ] );
		$dzchunkbyteoffset = $this->loader->secure->get( "post", "dzchunkbyteoffset", "int", [ "min" => 0 ] );

    $__all_chunk_param_exists = !is_null( $dzuuid ) && !is_null( $dzchunkindex ) && !is_null( $dztotalfilesize ) && !is_null( $dztotalchunkcount ) && !is_null( $dzchunksize ) && !is_null( $dzchunkbyteoffset );
		$upload_type = $__all_chunk_param_exists ? "chunked" : "uncut";

		// Accepted upload_type?
		if ( $accept == 'both' ? false : ( $accept != $upload_type ) ){
			return false;
		}

		// Valid chunked file?
		if ( $upload_type == "chunked" ){

			if ( $dzchunksize != $chunkSize || $sent_file['size'] > $chunkSize )
				return false;

			if ( $dztotalfilesize > $maxSize )
				return false;

			if ( $dzchunkindex > $maxChunks || $dzchunkindex < 0 )
				return false;

			if ( $dztotalchunkcount != ceil( $dztotalfilesize / $dzchunksize ) )
				return false;

			if ( $sent_file["type"] != 'application/octet-stream' )
				return false;

		}
		// Valid uncut file?
		else {

			if ( $sent_file["size"] > $maxSize )
				return false;

			if ( $sent_file["type"] != 'audio/mpeg' )
				return false;

		}

		// Save chunked file
		if ( $upload_type == "chunked" ){

			$chunk_dir = $this->mkdir( $this->uploading_dir . "/chunks/" . md5( $dzuuid ) );
			if ( is_file( "{$chunk_dir}/{$dzchunkindex}.part" ) ) unlink( "{$chunk_dir}/{$dzchunkindex}.part" );
			move_uploaded_file( $sent_file['tmp_name'], "{$chunk_dir}/{$dzchunkindex}.part" );

			// All chunks ready?
			$__all_chunk_ready = true;
			for( $i=0; $i<$dztotalchunkcount; $i++ ){
				if ( !is_file( "{$chunk_dir}/{$i}.part" ) ){
					$__all_chunk_ready = false;
				}
			}


			if ( $__all_chunk_ready ){

				$__chunks_combied = $chunk_dir . "/file.ready";
				if ( is_file( $__chunks_combied ) ) unlink( $__chunks_combied );
		    	touch( $__chunks_combied );
				for( $i=0; $i<$dztotalchunkcount; $i++ ){
					file_put_contents( $__chunks_combied, file_get_contents( "{$chunk_dir}/{$i}.part" ), FILE_APPEND );
					unlink( "{$chunk_dir}/{$i}.part" );
				}

				$__se = $sent_file["extension"];
				$__df = realpath( $__chunks_combied );

			}
			else {
				return true;
			}
			unset( $__all_chunk_ready );

		}
		else {

			$__se = $sent_file["extension"];
			$__df = $sent_file['tmp_name'];

		}

		if ( !empty( $validExtensions ) ? !in_array( $__se, $validExtensions ) : false ){
			return false;
		}

		if ( !empty( $__df ) ){

			$raw_dir = $this->mkdir( $this->uploading_dir . "/raw" );

			$__fd = "{$raw_dir}/" . uniqid() . "." . $__se;

			if ( $upload_type != "chunked" )
				move_uploaded_file( $__df, $__fd );
			else{
				rename( $__df, $__fd );
				if ( is_dir( dirname( $__df ) ) )
					rmdir( dirname( $__df ) );
			}

			return realpath( $__fd );

		}

		return false;

	}
	public function save_image( $i, $args = [] ){

		$basename   = $this->image_dir;
		$dirname    = "covers";
		$name       = uniqid();
		$input_ext  = null;
		$output_ext = "jpg";
		$min_width  = null;
		$min_height = null;
		$max_width  = 3000;
		$max_height = 3000;
		$final      = false;
		extract( $args );
		$dir  = $this->mkdir( $basename . "/{$dirname}" );

		// Create image object from input ( string, file or resource )
		$image = $this->loader->image->createfrom( $i, [ "ext" => $input_ext ] );
		if( empty( $image ) ) return false;

		// Create new image same as original image
		$o_width  = imagesx( $image );
		$o_height = imagesy( $image );

		if ( $min_width ? $min_width > $o_width : false ) return false;
		if ( $min_height ? $min_height > $o_height : false ) return false;
		if ( $max_width ? $max_width < $o_width : false ) return false;
		if ( $max_height ? $max_height < $o_height : false ) return false;

		// Create new image same as original image ( just to verify that this image is actually an image )
		$new_image = imagecreatetruecolor( $o_width, $o_height );

		if ( $output_ext == "png" ){
			$_tp_color = imagecolorallocatealpha( $new_image, 0, 0, 0, 127 );
			imagecolortransparent( $new_image, $_tp_color );
			imagefill( $new_image, 0, 0, $_tp_color );
			imagecopy( $new_image, $image, 0, 0, 0, 0, $o_width, $o_height );
			imagesavealpha( $new_image, true );
		}
		else {
			imagecopyresampled( $new_image, $image, 0, 0, 0, 0, $o_width, $o_height, $o_width, $o_height );
		}

		if ( $output_ext == "jpg" || $output_ext == "jpeg" )
	    	imagejpeg( $new_image, $dir . "/" . $name . ".{$output_ext}" );
		else if ( $output_ext == "gif" )
	    	imagegif( $new_image, $dir . "/" . $name . ".gif" );
		else if ( $output_ext == "png" )
	    	imagepng( $new_image, $dir . "/" . $name . ".png", 9 );

		imagedestroy( $new_image );
		$image_path = realpath( $dir . "/" . $name . ".{$output_ext}" );
		$image_path_from_root = str_replace( [ root, "\\" ], [ "", "/" ], $image_path );
		if ( substr( $image_path_from_root, 0, 1 ) == "/" ) $image_path_from_root = substr( $image_path_from_root, 1 );

		// 3rd party hosting
		if ( $final ? $this->loader->admin->get_setting( "aws", false ) : false ){
			if ( $this->loader->aws->upload( $image_path, $image_path_from_root ) ){
				unlink( $image_path );
				$image_path = "AWS_{$image_path_from_root}";
			}
		}
		elseif ( $final ? $this->loader->admin->get_setting( "ftp", false ) : false ){
			if ( $this->loader->ftp->upload( $image_path, $image_path_from_root ) ){
				unlink( $image_path );
				$image_path = "FTP_{$image_path_from_root}";
			}
		}

		return $image_path;

	}
	public function path_to_addr( $path ){

		if ( substr( $path, 0, strlen( "http" ) ) == "http" )
		return $path;

		if ( substr( $path, 0, strlen( root ) ) == root )
		return str_replace(
			[ root, "\\", "///", "//", "http:/", "https:/" ],
			[ $this->loader->admin->get_setting( 'web_addr' ), "/", "/", "/", "http://", "https://" ]
			, $path
		);

		if ( substr( $path, 0, 4 ) == "AWS_" )
		return $this->loader->aws->url( substr( $path, 4 ) );

		if ( substr( $path, 0, 4 ) == "FTP_" )
		return $this->loader->ftp->url( substr( $path, 4 ) );

		return $path;

	}
	public function addr_to_path( $addr ){

		return count(explode($this->loader->admin->get_setting( 'web_addr' ),$addr))>1 ? realpath( str_replace( $this->loader->admin->get_setting( 'web_addr' ), root . "/", $addr ) ) : $addr;

	}
	public function remove_file( $filename ){

		if ( substr( $filename, 0, 4 ) == "AWS_" )
		return $this->loader->aws->delete( substr( $filename, 4 ) );

		if ( substr( $filename, 0, 4 ) == "FTP_" )
		return $this->loader->ftp->delete( substr( $filename, 4 ) );

		if ( substr( $filename, 0 , 4 ) == "http" ? $this->loader->admin->get_setting( "web_addr" ) == substr( $filename, 0, strlen( $this->loader->admin->get_setting( "web_addr" ) ) ) : false )
		$filename = str_replace( $this->loader->admin->get_setting( "web_addr" ), root . "/" , $filename );

		if ( $this->is_local( $filename ) ? file_exists( $filename ) : false )
		return unlink( $filename );

		return false;

	}
	public function move_file( $file, $dest, $args=[] ){

		$skip_aws = false;
		$dest_from_root = str_replace( [ root, "\\", "//" ], [ "", "/", "/" ], $dest );
		$dest_dir = dirname( $dest );
		extract( $args );

		$data = null;
		$type = null;

		if ( substr( $dest_from_root, 0, 1 ) == "/" ) $dest_from_root = substr( $dest_from_root, 1 );

		if ( !$skip_aws ? $this->loader->admin->get_setting( "aws", false ) : false ){

			if ( !$this->loader->aws->upload( $file, $dest_from_root ) )
			return false;

			$data = "AWS_{$dest_from_root}";
			$type = "AWS";

		}
		elseif ( !$skip_aws ? $this->loader->admin->get_setting( "ftp", false ) : false ){

			if ( !$this->loader->ftp->upload( $file, $dest_from_root ) )
			return false;

			$data = "FTP_{$dest_from_root}";
			$type = "FTP";

		}
		else {

			$dest_dir = $this->loader->general->mkdir( $dest_dir );
			if ( !copy( $file, $dest ) )
			return false;

			$data = realpath( $dest );
			$type = "FILE";

		}

		if ( is_file( $file ) )
		unlink( $file );

		return [
			"type" => $type,
			"data" => $data
		];

	}

	// handle download & streaming
	public function is_local( $path ){

		if ( count( explode( root, $path ) ) > 1 )
			return true;

		return false;

	}

	// file functions
	public function scan_folder( $main_dir_path, $args = [] ){

		$recursive = true;
		$files = [];
		$files_valid_extensions = [ "mp4", "mkv", "mp3", "avi", "mov", "wmv" ];
		$files_ignore = [];
		$dirs_to_scan = [];
		$dirs = [];
		$dirs_ignore_default = [ "\$RECYCLE.BIN", "Recovery", "System Volume Information" ];
		$dirs_ignore = [];
		extract( $args );
		$dirs_ignore = array_merge( $dirs_ignore_default, $dirs_ignore );
		$dirs_to_scan[] = $main_dir_path;

		if ( empty( $main_dir_path ) ? true : !is_dir( $main_dir_path ) || !is_readable( $main_dir_path ) ) return false;

	    // Scan files
	    while( !empty( $dirs_to_scan ) ){

		    $dir = array_shift( $dirs_to_scan );
		    $dirs[] = $dir;
		    if ( !$dir ) continue;

		    $dir_ents = scandir( $dir );
		    foreach( $dir_ents as $dir_ent ){

			    if ( in_array( $dir_ent, [ ".", ".." ] ) ) continue;
			    if ( $dirs_ignore ? in_array( $dir_ent, $dirs_ignore ) : false ) continue;

			    $dir_ent = realpath( $dir . "/" . $dir_ent );
			    if( is_dir( $dir_ent ) && !in_array( $dir_ent, $dirs ) ){
					if ( $recursive ){
						$dirs_to_scan[] = $dir_ent;
					} else {
						$dirs[] = $dir_ent;
					}
			    }
			    elseif( is_file( $dir_ent ) && in_array( pathinfo( $dir_ent, PATHINFO_EXTENSION ), $files_valid_extensions ) ){

				    // File data
				    $file_data = [
					    "path" => $dir_ent,
					    "dir" => dirname( $dir_ent ),
					    "dir_name" => @end( explode( "/", dirname( $dir_ent ) ) ),
					    "name" => pathinfo( $dir_ent, PATHINFO_FILENAME ),
					    "base" => pathinfo( $dir_ent, PATHINFO_BASENAME ),
					    "extension" => pathinfo( $dir_ent, PATHINFO_EXTENSION ),
					    "size" => filesize( $dir_ent ),
					    "time_create" => filectime( $dir_ent ),
					    "time_update" => fileatime( $dir_ent ),
				    ];

				    $files[] = $file_data;

			    }

		    }

	    }

	    return [ "files" => $files, "dirs" => $dirs ];

	}

	// string helpers
	public function make_code( $string, $regex = "\p{L}0-9", $max_length = 150 ){

		return mb_substr( preg_replace('/[^'.$regex.']/u', '', mb_strtolower( htmlspecialchars_decode( $string, ENT_QUOTES ), "UTF-8" ) ), 0, $max_length, "UTF-8" );

	}
	public function hr_seconds( $seconds ){

		$s = intval( $seconds );

		foreach( [ "d" => 24*60*60, "h" => 60*60, "m" => 60 ] as $__k => $__m ){
			$$__k = "00";
			if ( $s > $__m ){
				$$__k = floor( $s / $__m );
				$s = $s - ( $$__k * $__m );
				if ( strlen( $$__k ) == 1 ) $$__k = "0{$$__k}";
			}
		}

		if ( strlen( $s ) == 1 ) $s = "0{$s}";

		if ( !empty( intval( $d ) ) ) return "{$d}:{$h}:{$m}:{$s}";
		if ( !empty( intval( $h ) ) ) return "{$h}:{$m}:{$s}";
		if ( !empty( intval( $m ) ) ) return "{$m}:{$s}";
		return "00:{$s}";

	}
	public function purify_track_title( $string ){

		if ( empty( $string ) ? true : !is_string( $string ) ) return $string;
		$_str = explode( "|__dIgIMusE__|", str_replace( [ " (", " [", " feat", " live", " skit", " remastered", "single track" ], "|__dIgIMusE__|", mb_strtolower( $string, "utf-8" ) ) );
		return( reset( $_str ) );
		unset( $_str );

	}
	public function purify_album_title( $string ){

		if ( empty( $string ) ? true : !is_string( $string ) ) return $string;
		$_str = explode( "|__dIgIMusE__|", str_replace( [ " [", " feat", " live", " skit", " remastered", "single track" ], "|__dIgIMusE__|", mb_strtolower( $string, "utf-8" ) ) );
		return( reset( $_str ) );
		unset( $_str );

	}
	public function color_adjust_brightness( $hex, $steps ){

    $steps = max(-255, min(255, $steps));

    $hex = str_replace('#', '', $hex);
    if (strlen($hex) == 3) {
        $hex = str_repeat(substr($hex,0,1), 2).str_repeat(substr($hex,1,1), 2).str_repeat(substr($hex,2,1), 2);
    }

    $color_parts = str_split($hex, 2);
    $return = '#';

    foreach ($color_parts as $color) {
        $color   = hexdec($color);
        $color   = max(0,min(255,$color + $steps));
        $return .= str_pad(dechex($color), 2, '0', STR_PAD_LEFT);
    }

    return $return;

  }
	public function display_price( $price, $return=false, $args=[] ){

		$format = trim( $this->loader->admin->get_setting( "currency_format", "%CURRENCY%%.2f" ) );
		$currency = $this->loader->admin->get_setting('currency');
		$price_wrapper = "%PRICE%";
		$currency_wrapper = "%CURRENCY%";
		extract( $args );

		// get currency position
		$currency_pos = "after";
		if ( substr( $format, 0, strlen("%CURRENCY%") ) == "%CURRENCY%" )
		$currency_pos = "pre";

		// remove currency replacer
		$format = trim( str_replace( "%CURRENCY%", "", $format ) );

		// format price
		$str = $price = sprintf( $format, $price );

		// re-add currency
		if ( $currency_pos == "after" ) $str = "{$price} {$currency}";
		else $str = "{$currency}{$price}";

		if ( $return ) return $str;
		echo $str;

	}
	public function http_build_query( $i, $replace=false, $return_url=false ){

		if ( !is_array( $i ) )
			parse_str( $i, $i );

		if ( $replace ) $i = array_merge( $i, $replace );

		return $return_url ? $this->loader->ui->rurl( null, $this->loader->ui->page_uri, http_build_query( $i ) ) : http_build_query( $i );

	}

	// time helpers
	public function passed_time_hr( $seconds, $maximum = 3, $delimiter = null ){

		$seconds   = is_string( $seconds ) ? time() - strtotime( $seconds ) : $seconds;
		$seconds   = $seconds < 0 ? 0 : $seconds;
		$delimiter = $delimiter == null ? "," : $delimiter;
		$hr_data = [];
		$hr_strings = [];

		foreach(array_reverse(array(

			"second"  => 1,
			"minute"  => 60,
			"hour"    => 60*60,
			"day"     => 24*60*60,
			"month"   => 31*24*60*60,
			"year"    => 365*24*60*60

		)) as $seperator_key => $seperator_interval ){

			$seperator_count = 0;
			if ( $seconds >= $seperator_interval ){

				$seperator_count = floor( $seconds / $seperator_interval );
				$seconds -= $seperator_count * $seperator_interval;

				$hr_data[ $seperator_key ][ "count" ] = $seperator_count;
				$hr_data[ $seperator_key ][ "text" ]  = $seperator_count == 1 ? $this->loader->lorem->turn( $seperator_key ) : $this->loader->lorem->turn( "{$seperator_key}s" );
				if ( count( $hr_strings ) < $maximum )
					$hr_strings[] = "{$hr_data[ $seperator_key ][ "count" ]} {$hr_data[ $seperator_key ][ "text" ]}";

			}

		}

		return array(
			"string" => implode( $delimiter , $hr_strings ),
			"data" => $hr_data
		);

	}

}

?>
