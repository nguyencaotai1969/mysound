<?php

if ( !defined("root" ) ) die;

class ffmpeg {

	public function __construct( $loader ){

		$this->loader = $loader;
		$this->db = $loader->db;
		$this->path = html_entity_decode( $this->loader->admin->get_setting( "ffmpeg_path", null ) );

	}

	public function make_waveform( $music_path ){

		if ( empty( $this->path ) ) return null;

		$color   = $this->loader->theme->set_name( $this->loader->admin->get_setting( 'theme_name' ) )->get_setting( "color" );

		$path    = $this->loader->general->uploading_dir . "/ffmpeg_waves/";
		$dest    = $this->loader->general->mkdir( $path ) . "/" . uniqid() . ".png";
		$dest_pr = $this->loader->general->mkdir( $path ) . "/" . uniqid() . ".png";

		exec( " \"{$this->path}\" -y -i \"{$music_path}\" -filter_complex \"[0:a]aformat=channel_layouts=mono,showwavespic=s=800x100:colors=#dddddd \" -frames:v 1 \"{$dest}\" " );
		exec( " \"{$this->path}\" -y -i \"{$music_path}\" -filter_complex \"[0:a]aformat=channel_layouts=mono,showwavespic=s=800x100:colors=#{$color} \" -frames:v 1 \"{$dest_pr}\" " );
		if ( !file_exists( $dest ) || !file_exists( $dest_pr ) ) return null;

		$bg_wave = $this->loader->image
			->set( $dest )
			->style_wave()
			->get( [ "output_ext" => "png", "dirname" => "ffmpeg_waves", "basename" => $this->loader->general->image_dir ] );

		$pr_wave = $this->loader->image
			->set( $dest_pr )
			->style_wave()
			->get( [ "output_ext" => "png", "dirname" => "ffmpeg_waves", "basename" => $this->loader->general->image_dir ] );

		if ( is_file( $dest) ) unlink( $dest );
		if ( is_file( $dest_pr ) ) unlink( $dest_pr );

		return $this->loader->general->json_encode(array(
			"bg" => $bg_wave,
			"pr" => $pr_wave
		));

	}
	public function convert( $file, $dest_bitrate ){

		$pi = pathinfo( $file );
		$dest = "{$pi["dirname"]}/{$pi["filename"]}_2.{$pi["extension"]}";
		$oo = exec( " \"{$this->path}\" -y -i \"{$file}\" -codec:a libmp3lame -b:a {$dest_bitrate}k \"{$dest}\" ", $o );
		if ( is_file( $dest ) ) return realpath( $dest );
		return false;

	}

}

?>
