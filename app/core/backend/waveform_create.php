<?php

if ( !defined( "root" ) ) die;

if ( empty( $_SESSION["wave_hash"] ) || empty( $_SESSION["wave_file"] ) || empty( $_SESSION["wave_expire"] ) ? true : time() > $_SESSION["wave_expire"] )
	die('1');

$loader->ui->set_page_data();

if ( $this->ps["track_hash"] != $loader->ui->page_data["hash"] || $this->ps["track_hash"] != $_SESSION["wave_track_hash"] )
	die('2');

if ( $this->ps["hash"] != $_SESSION["wave_hash"] )
	die('3');

if ( $loader->ui->page_data["source"]["type"] != "file" && $loader->ui->page_data["source"]["type"] != "file_r" ? true : !empty( $track["source"]["wave_bg"] ) && !empty( $track["source"]["wave_pr"] ) )
	die('4');

if ( $this->loader->admin->get_setting( "ffmpeg", 0 ) && $this->loader->admin->get_setting( "ffmpeg_wave", 0 ) && empty( $_POST["data"] ) ){

	$_wavedata = $loader->general->json_decode( $this->loader->ffmpeg->make_waveform( $_SESSION["wave_file"] ) );
	if ( !$_wavedata ) return false;

	$stmt = $loader->db->prepare("UPDATE _m_sources SET wave_bg = ?, wave_pr = ? WHERE ID = ? ");
	$stmt->bind_param( "sss", $_wavedata["bg"], $_wavedata["pr"], $loader->ui->page_data["source"]["ID"] );
	$stmt->execute();
	$stmt->close();
	$done = true;

}
else {

	if ( !$posted_data = $loader->secure->get( "post", "data", "string", [ "min_length" => 2000 ] ) )
		die('5');

	if ( substr( $posted_data, 0, strlen( "data:image/png;base64," ) ) == "data:image/png;base64," ){

	    $data_decoded = null;
	    try {
		    $data_decoded = base64_decode( str_replace( " ", "+", substr( $posted_data, strlen( "data:image/png;base64," ) ) ) );
	    } catch( Exception $err ){}

	    if ( !empty( $data_decoded ) ){

		    $loader->image
			    ->set( $data_decoded )
			    ->resize( [ "abs_width" => 800, "abs_height" => 100 ] );

		    $bg_wave = $loader->image
			    ->set( $data_decoded )
			    ->resize( [ "abs_width" => 800, "abs_height" => 100 ] )
			    ->style_wave()
			    ->change_color( "#dddddd" )
			    ->get( [ "output_ext" => "png", "dirname" => "waves", "basename" => $loader->general->image_dir ] );

		    $pr_wave = $loader->image
			    ->set( $data_decoded )
			    ->resize( [ "abs_width" => 800, "abs_height" => 100 ] )
			    ->style_wave()
			    ->change_color( "#" . $loader->theme->set_name()->get_setting( "color" ) )
			    ->get( [ "output_ext" => "png", "dirname" => "waves", "basename" => $loader->general->image_dir ] );

			if ( empty( $bg_wave ) || empty( $pr_wave ) )
				return false;

		    $stmt = $loader->db->prepare("UPDATE _m_sources SET wave_bg = ?, wave_pr = ? WHERE ID = ? ");
		    $stmt->bind_param( "sss", $bg_wave, $pr_wave, $loader->ui->page_data["source"]["ID"] );
		    $stmt->execute();
		    $stmt->close();
			$done = true;

	    }

    }

}

unset( $_SESSION["wave_track_hash"], $_SESSION["wave_hash"], $_SESSION["wave_file"], $_SESSION["wave_expire"] );

if ( !empty( $done ) ) $this->set_response( "done" );
else $this->set_error( "failed" );

?>
