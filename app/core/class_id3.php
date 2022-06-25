<?php

if ( !defined("root" ) ) die;

class id3 {

	protected $cores = array();

	public function __construct( $loader ){

		$this->loader = $loader;
		$this->db = $loader->db;

	}
	public function core( $type ){

		if ( isset( $cores[ $type ] ) )
			return $cores[ $type ];

		if ( $type == "reader" ){

			require_once( app_core_root . "/third/getID3-1.9.2/getid3/getid3.php" );
		    $id3 = new getID3;
		    $id3->setOption(array('encoding'=>"UTF-8"));
			$this->cores[ "reader" ] = $id3;
		    return $id3;

		}
		elseif ( $type == "writer" ){

			require_once( app_core_root . "/third/getID3-1.9.2/getid3/getid3.php" );
			require_once( app_core_root . "/third/getID3-1.9.2/getid3/write.php" );
			$id3 = new getID3;
			$id3->setOption(array('encoding'=>"UTF-8"));
			$id3_writer = new getid3_writetags;
			$id3_writer->tagformats = array('id3v2.3');
			$id3_writer->overwrite_tags = true;
			$id3_writer->tag_encoding = "UTF-8";
			$id3_writer->remove_other_tags = true;
			$this->cores[ "writer" ] = $id3_writer;
			return $id3_writer;

		}

		return false;

	}
	public function read_tags( $filePath ){

		$data = $this->core("reader")->analyze( $filePath );

		if ( !empty( $data["error"] ) )
			return false;

		$tags = !empty( $data["tags"]["id3v2"] ) ? $data["tags"]["id3v2"]: $data["tags"]["id3v1"];
		if ( !empty( $tags ) ){

			foreach( $tags as $__tk => $__tv ){
				$__nts[ $__tk ] = reset( $__tv );
			}

			$__simplified["title"]             = null;
			$__simplified["artist_name"]       = null;
			$__simplified["album_order"]       = null;
			$__simplified["album_title"]       = null;
			$__simplified["album_artist_name"] = null;
			$__simplified["album_time"]        = null;
			$__simplified["genre"]             = null;
			$__simplified["duration"]          = null;
			$__simplified["bitrate"]           = null;

			if ( !empty( $__nts["title"] ) ? $this->loader->secure->validate( $__nts["title"], "string", [ "strip_emoji" => true ] ) : false )
				$__simplified["title"] = $__nts["title"];

			if ( !empty( $__nts["artist"] ) ? $this->loader->secure->validate( $__nts["artist"], "string", [ "strip_emoji" => true ] ) : false )
				$__simplified["artist_name"] = $__nts["artist"];

			if ( !empty( $__nts["album"] ) ? $this->loader->secure->validate( $__nts["album"], "string", [ "strip_emoji" => true ] ) : false )
				$__simplified["album_title"] = $__nts["album"];

			if ( !empty( $__nts["band"] ) ? $this->loader->secure->validate( $__nts["band"], "string", [ "strip_emoji" => true ] ) : false )
				$__simplified["album_artist_name"] = $__nts["band"];

			if ( empty( $__simplified["album_artist_name"] ) && !empty( $__simplified["artist_name"] ) )
				$__simplified["album_artist_name"] = $__simplified["artist_name"];

			if ( !empty( $__nts["track_number"] ) ){

				$__tn = explode( " ", str_replace( [ "/","-","_","of","\\",".",","], " ", $__nts["track_number"] ) );
				$__tn = reset( $__tn );
				if ( $this->loader->secure->validate( $__tn, "int" ) )
					$__simplified["album_order"] = $__tn;

			}

			if ( !empty( $__nts["year"] ) ? $this->loader->secure->validate( $__nts["year"], "string_date" ) : false )
				$__simplified["album_time"] = $this->loader->general->strtotime( $__nts["year"] );

			if ( !empty( $__nts["genre"] ) ? $this->loader->genre->return_valid( $__nts["genre"], "name", true ) : false )
				$__simplified["genre"] = $this->loader->genre->return_valid( $__nts["genre"], "name", true );

			if ( !empty( $data["playtime_seconds"] ) ? $this->loader->secure->validate( $data["playtime_seconds"], "float" ) : false )
				$__simplified["duration"] = $data["playtime_seconds"];

			if ( !empty( $data["bitrate"] ) ? $this->loader->secure->validate( $data["bitrate"], "int" ) : false )
				$__simplified["bitrate"] = round($data["bitrate"]/1000);

			$data["tags"] = $__simplified;

		} else {

			$__simplified["duration"] = null;
			$__simplified["bitrate"]  = null;

			if ( !empty( $data["playtime_seconds"] ) ? $this->loader->secure->validate( $data["playtime_seconds"], "float" ) : false )
				$__simplified["duration"] = $data["playtime_seconds"];

			if ( !empty( $data["bitrate"] ) ? $this->loader->secure->validate( $data["bitrate"], "int" ) : false )
				$__simplified["bitrate"] = round($data["bitrate"]/1000);

			$data["tags"] = $__simplified;

		}

		return $data;

	}
	public function write_tags( $filePath, $tags ){

    foreach( $tags as $i => $v ){
			if ( is_array( $v ) ){
				foreach( $v as $i2 => $v2 ){
					if ( is_string( $v2 ) ){
						$tags[ $i ][ $i2 ] = htmlspecialchars_decode( $v2, ENT_QUOTES );
					}
				}
			}
		}

		$writer = $this->core("writer");
		$writer->tag_data = $tags;
		$writer->filename = $filePath;
		$writer->WriteTags();
		if ( !empty( $writer->warnings ) ) return false;
		return true;

	}

}

?>
