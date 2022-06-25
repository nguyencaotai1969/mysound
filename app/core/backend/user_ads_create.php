<?php

if ( !defined( "root" ) ) die;

if ( $this->ps["fund"] > $loader->visitor->user()->get_data()["fund"] )
$this->set_error( "fund_shortage" );
$ad_type = $this->ps["ad_type"];


// validate placement
if ( $ad_type != "audio_v" ){
	foreach( explode( ",", $this->ps["placements"] ) as $_pl ){
		if ( !in_array( $_pl, array_keys( $loader->ads->getPlacements() ) ) )
		$this->set_error( "invalid_placement", true );
	}
	if ( empty( $this->ps["placements"] ) )
	$this->set_error( "invalid_placement", true );
}
else {
	$this->ps["placements"] = "";
}

// validate files
if ( $ad_type == "audio_v" ){

	$sent_image = $loader->secure->get( "file", "audio_banner" );
	if ( !$sent_image )
	$this->set_error( "invalid_banner" );

	$verify_and_copy_image = $loader->general->save_image( $sent_image["tmp_name"], array(
		"input_ext" => $sent_image["extension"],
		"min_width" => 200,
		"min_height" => 50
	));

	if ( !empty( $verify_and_copy_image ) ){

		$banner = $loader->image
		->set( $verify_and_copy_image )
		->resize([
			"max_width"  => 2000,
			"max_height" => 2000,
			"min_width"  => 200,
			"min_height" => 50,
			"remove_src" => true
		])
		->get([
			"basename" => $loader->general->image_dir,
			"dirname"  => "ads",
		]);

	}

	if ( empty( $banner ) )
	$this->set_error( "invalid_banner" );
	$files["banner"] = $banner;

  $sent_file = $loader->secure->get( "file", "audio", "file", [ "acceptable_extensions" => [ "mp3" ], "acceptable_types" => [ "audio/mpeg" ] ] );
	$sent_file_data = $this->loader->id3->read_tags( $sent_file["tmp_name"] );

	if ( $sent_file_data["tags"]["duration"] > 30 )
	$this->set_error( "invalid_audio" );

	if ( $sent_file_data["tags"]["bitrate"] > 320 )
	$this->set_error( "invalid_audio" );

	$audio_file = $loader->general->move_file( $sent_file["tmp_name"], $loader->general->image_dir . "/ads_audio/" . uniqid() . ".mp3" );
	if ( empty( $audio_file ) )
	$this->set_error( "invalid_audio" );

	$files["audio"] = $audio_file["data"];
	$files["audio_duration"] = $sent_file_data["tags"]["duration"];

}
else {

	$sent_image = $loader->secure->get( "file", "banner" );
	if ( !$sent_image )
	$this->set_error( "invalid_banner" );

	$verify_and_copy_image = $loader->general->save_image( $sent_image["tmp_name"], array(
		"input_ext" => $sent_image["extension"],
		"min_width" => 50,
		"min_height" => 50
	));

	if ( !empty( $verify_and_copy_image ) ){

		$banner = $loader->image
		->set( $verify_and_copy_image )
		->resize([
			"max_width"  => 2000,
			"max_height" => 2000,
			"min_width"  => 50,
			"min_height" => 50,
			"remove_src" => true
		])
		->get([
			"basename" => $loader->general->image_dir,
			"dirname"  => "ads",
		]);

	}

	if ( empty( $banner ) )
	$this->set_error( "invalid_banner" );

	$files["banner"] = $banner;

}

// create ad
$create = $loader->ads->create([
	"user_id" => $loader->visitor->user()->ID,
	"user_charge" => true,
	"name" => $this->ps["name"],
	"type"  => $this->ps["ad_type"],
	"files" => $files,
	"url" => $this->ps["url"],
	"placements" => $this->ps["placements"],
	"fund_total" => $this->ps["fund"],
	"fund_remain" => $this->ps["fund"],
	"fund_limit" => $this->ps["limit"],
]);

$this->set_response( "done" );

?>
