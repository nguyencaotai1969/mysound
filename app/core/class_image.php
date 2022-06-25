<?php

if ( !defined("root" ) ) die;

class image {

	public $path = null;
	public $source = null;
	public $width = null;
	public $height = null;
	public $format = "jpg";

	public function __construct( $loader ){

		$this->loader = $loader;
		$this->db = $loader->db;

	}

	public function createfrom( $i, $args = [] ){

		$ext = null;
		extract( $args );

		if ( gettype( $i ) == "string" && ctype_print( $i ) ? is_file( $i ) : false ){

			if ( ( $ext ? $ext : pathinfo( $i, PATHINFO_EXTENSION ) ) == "png" ){

				// Create an image wrapper and fill it with transparent color
				$_dimensions = getimagesize( $i );
				$_tp_image  = imagecreatetruecolor( $_dimensions[0], $_dimensions[1] );
				$_tp_color = imagecolorallocatealpha( $_tp_image, 0, 0, 0, 127 );
				imagecolortransparent( $_tp_image, $_tp_color );
				imagefill( $_tp_image, 0, 0, $_tp_color );

				// Create image from source and copy it to wrapper
				$_src_image = imagecreatefrompng( $i );
				imagecopy( $_tp_image, $_src_image, 0, 0, 0, 0, $_dimensions[0], $_dimensions[1] );
				imagesavealpha( $_tp_image, true );

				$image = $_tp_image;

			}

			else if ( ( $ext ? $ext : pathinfo( $i, PATHINFO_EXTENSION ) ) == "gif" )
				$image = imagecreatefromgif( $i );

			else if ( in_array( ( $ext ? $ext : pathinfo( $i, PATHINFO_EXTENSION ) ), [ "jpg", "jpeg" ] ) )
				$image = imagecreatefromjpeg( $i );

			else
				return false;

			$this->path = $i;

		}
		elseif ( gettype( $i ) == "string" ? is_string( $i ) : false ){
			$image = imagecreatefromstring( $i );
		}
		elseif( PHP_MAJOR_VERSION >= 8 ? gettype( $i ) == "object" && get_class( $i ) == "GdImage" : get_resource_type( $i ) == "gd" ){
			$image = $i;
		}

		return empty( $image ) ? false : $image;

	}

	public function set( $i ){

		$this->path = null;
		if ( gettype( $i ) == "string" && ctype_print( $i ) ? is_file( $i ) : false ) $this->path = $i;
		$_s = $this->createfrom( $i );
		if ( empty( $_s ) ) die('invalid_image');
		$this->source = $_s;
		$this->width = imagesx( $this->source );
		$this->height = imagesy( $this->source );
		return $this;

	}

	public function resize( $args ){

		$abs_width = null;
		$abs_height = null;
		$max_width = null;
		$max_height = null;
		$min_width = null;
		$min_height = null;
		$remove_src = false;
		extract( $args );

		if ( empty( $this->source ) ) return $this;

		if ( !empty( $abs_width )  ? $abs_width  > $this->width  : false ) return $this;
		if ( !empty( $abs_height ) ? $abs_height > $this->height : false ) return $this;

		if ( $abs_width && $abs_height ){

			$_nw = $abs_width;
			$_nh = $abs_height;

		} elseif ( $max_width && $max_height ) {

			// Should we make this image smaller?
			$_wr = $this->width  / $max_width;
			$_hr = $this->height / $max_height;
			$_r  = $_wr > $_hr ? $_wr : $_hr;
			if ( 1 > $_r ) return $this;

			// Make it small
			$_nw = round( $this->width / $_r );
			$_nh = round( $this->height / $_r );

			// Should we don't let this image get too small?
			if ( !empty( $min_width ) || !empty( $min_height ) ){

				// Is this image too small?
				$_wr = $_nw / $min_width;
				$_hr = $_nh / $min_height;
				$_r  = $_wr > $_hr ? $_hr : $_wr;

				// Make it bigger
				if ( 1 > $_r ){
					$_nw = round( $_nw / $_r );
					$_nh = round( $_nh / $_r );
				}

				// Too big? noway to edit this image
				if ( $_nw > $this->width || $_nh > $this->height )
					return $this;

			}

		} else {

			die("bad_args");

		}

		$_ni = imagecreatetruecolor( $_nw, $_nh );
		$_tp_color = imagecolorallocatealpha( $_ni, 0, 0, 0, 127 );
		imagecolortransparent( $_ni, $_tp_color );
		imagefill( $_ni, 0, 0, $_tp_color );
		imagealphablending( $_ni, false );
		imagesavealpha( $_ni, true );
		imagecopyresampled( $_ni, $this->source, 0, 0, 0, 0, $_nw, $_nh, $this->width, $this->height );
		imagesavealpha( $_ni, true );
		imagedestroy( $this->source );
		if ( $remove_src && $this->path ) unlink( $this->path );
		$this->source = $_ni;
		$this->width  = $_nw;
		$this->height = $_nh;
		$this->path   = null;
		return $this;

	}

	public function square( $args = [] ){

		$remove_src = false;
		extract( $args );

		$_s  = $this->width > $this->height ? $this->height : $this->width;
		$_ow = ( $this->width  - $_s ) / 2;
		$_oh = ( $this->height - $_s ) / 2;
		$_ni = imagecreatetruecolor( $_s, $_s );
		$_tp_color = imagecolorallocatealpha( $_ni, 0, 0, 0, 127 );
		imagecolortransparent( $_ni, $_tp_color );
		imagefill( $_ni, 0, 0, $_tp_color );
		imagecopyresampled( $_ni, $this->source, 0, 0, $_ow, $_oh, $this->width, $this->height, $this->width, $this->height );
		imagesavealpha( $_ni, true );
		imagedestroy( $this->source );
		if ( $remove_src && $this->path ) unlink( $this->path );
		$this->source = $_ni;
		$this->width  = $_s;
		$this->height = $_s;
		$this->path   = null;
		return $this;

	}

	public function style_wave(){

		$new_height = ( $this->height*.5 ) + ( $this->height*.5 *.5 );
		$new_image = imagecreatetruecolor( $this->width, $new_height );
		$transparent = imagecolorallocatealpha( $new_image, 255, 255, 255, 127 );
		imagealphablending( $new_image, false );
		imagesavealpha( $new_image, true );
		imagefilledrectangle( $new_image, 0, 0, $this->width, $new_height, $transparent );
		imagecopyresampled( $new_image, $this->source, 0, 0, 0, 0, $this->width, $this->height/2, $this->width, $this->height/2 );
		imagecopyresampled( $new_image, $this->source, 0, ($this->height*.5)+1, 0, $this->height*.5, $this->width, ($this->height*.5*.5), $this->width, $this->height*.5 );
		imagedestroy( $this->source );
		$this->source = $new_image;
		$this->width = $this->width;
		$this->height = $new_height;
		$this->path = null;

		return $this;

	}

	public function change_color( $new_color ){

		list( $r, $g, $b ) = sscanf( $new_color, "#%02x%02x%02x" );
		imagefilter( $this->source, IMG_FILTER_COLORIZE, $r, $g, $b );
		return $this;

	}

	public function get( $args = [] ){

		$final = true;
		extract( $args );

		$args = array_merge( $args, [ "final" => $final ] );
		return $this->loader->general->save_image( $this->source, $args );

	}

}

?>
