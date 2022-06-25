<?php

if ( !defined("root" ) ) die;

class utube {

	public function __construct( $loader ){

		$this->loader = $loader;
		$this->db = $loader->db;

	}

	public function find_track_full( $artist_name, $title ){

		$utube_data = $this->loader->boac->utube( $artist_name, $title );

		if ( !$utube_data["sta"] || empty( $utube_data["data"] ) ? true : $utube_data["data"] == "nada" ){
			return [0,"failed_to_find"];
		}

		return [ 1, json_decode( $utube_data["data"], 1 ) ];

	}

	public function download( $youtube_id, $test = false ){

		// Get & Check setting
		$youtube_dl          = $this->loader->admin->get_setting( "youtube_dl", 0, [0,1] );
		$youtube_dl_location = $this->loader->admin->get_setting( "youtube_dl_path" );
		$ffmpeg              = $this->loader->admin->get_setting( "ffmpeg", 0, [0,1] );
		$ffmpeg_location     = $this->loader->admin->get_setting( "ffmpeg_path" );
		if ( !$youtube_dl || !$youtube_dl_location || !$ffmpeg || !$ffmpeg_location ) return [ false, "not_allowed" ];

		// Variables
		$random_file_name  = substr( md5( $youtube_id ), 0, 20 );
		$youtube_dir_path  = $this->loader->general->mkdir( $this->loader->general->uploading_dir . "/youtube_audio" );
		$youtube_file_path = null;
		$youtube_mp3_path  = null;

		// Run youtube-dl and catch the output
		$process = proc_open(
			"{$youtube_dl_location} -f bestaudio \"https://www.youtube.com/watch?v={$youtube_id}\" --output \"{$youtube_dir_path}/{$random_file_name}.%(ext)s\" ",
			array(
		    	0 => array("pipe", "r"),
		    	1 => array("pipe", "w"),
		   	    2 => array("pipe", "w"),
		    ),
			$pipes
		);

		$stdout  = stream_get_contents( $pipes[1] );
		fclose( $pipes[1] );
		$stderr  = stream_get_contents( $pipes[2] );
		fclose( $pipes[2] );
		$ret     = proc_close( $process );

		// Get youtube_dl output. we don't know the extension so search all dir ents for the file
		foreach( scandir( $youtube_dir_path ) as $youtube_dir_ent ){
			if ( substr( $youtube_dir_ent, 0, strlen( $random_file_name ) ) == $random_file_name ){
				$youtube_file_path = realpath( $youtube_dir_path . "/" . $youtube_dir_ent );
			}
		} if ( empty( $youtube_file_path ) ) return [ false, !empty( $stderr ) ? $stderr : "failed" ];

		// If output is not mp3, convert it to mp3
		if ( substr( $youtube_file_path, -4 ) == ".mp3" ){

			$youtube_mp3_path = $youtube_file_path;

		} else {

			$youtube_mp3_path = $youtube_dir_path . "/{$random_file_name}.mp3";
			exec( "{$ffmpeg_location} -i \"{$youtube_file_path}\" -acodec mp3 -vn \"{$youtube_mp3_path}\" ", $o );
			$youtube_mp3_path = realpath( $youtube_mp3_path );
			unlink( $youtube_file_path );

			var_dump ( $o );

		}

		if ( empty( $youtube_mp3_path ) ) return [ false, "no_mp3_file_found_ffmpeg_failed" ];

		if ( $test ) unlink( $youtube_mp3_path );

		return [ true, $youtube_mp3_path ];

	}

}

?>
