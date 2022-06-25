<?php

if ( !defined("root" ) ) die;

class source {

	public function __construct( $loader ){

		$this->loader = $loader;
		$this->db = $loader->db;

	}

	public function select( $args ){

		$ID = null;
		$track_id = null;
		$data = null;
		$type = null;
		$hash = null;
		$prefer_localfile = true;
		$prefer_hq = true;

		$query = null;
		$limit = 1;
		$order = "time_add DESC";
		$ws = [];
		extract( $args );

		if ( !empty( $ID ) )       $ws[] = " ID = '{$ID}' ";
		if ( !empty( $hash ) )     $ws[] = " hash = '{$hash}' ";
		if ( !empty( $data ) )     $ws[] = " data = '{$data}' ";
		if ( !empty( $track_id ) ) $ws[] = " track_id = '{$track_id}' ";
		if ( !empty( $type ) )     $ws[] = $type == "files" ? " type IN ( 'file', 'file_r' ) " : " type = '{$type}' ";

		if ( $prefer_localfile && $prefer_hq ) $order = "type ASC, bitrate DESC";
		elseif ( $prefer_localfile ) $order = "type ASC, bitrate ASC";
		else $order = "type DESC, time_add DESC";

		$ws = $ws ? " WHERE " . implode( " AND ", $ws ) : "";
		$__q = "SELECT * FROM _m_sources {$ws} ORDER BY {$order} LIMIT {$limit}";

		if ( !$this->db->query( $__q )->num_rows ) return false;

		$__results = [];
		$__query = $this->db->query( $__q );
		while( $__i = $__query->fetch_assoc() ){
			$__i["wave_bg_raw"] = $__i["wave_bg"];
			$__i["wave_pr_raw"] = $__i["wave_pr"];
			$__i["wave_bg"] = $this->loader->general->path_to_addr( $__i["wave_bg"] );
			$__i["wave_pr"] = $this->loader->general->path_to_addr( $__i["wave_pr"] );
			$__results[$__i["ID"]] = $__i;
		}

		return $limit == 1 ? reset( $__results ) : $__results;

	}
	public function create( $args ){

		$file = null;
		$file_bitrate = null;
		$file_relocate = null;
		$file_wave_bg = null;
		$file_wave_pr = null;
    $file_name = null;
		$yt_id = null;
		$track_id = null;
		$duration = null;
		$hash = null;
		$convert = false;
		extract( $args );
		$hash = !empty( $hash ) ? $hash : md5( microtime(true) . $track_id . $hash );

		if ( empty( $track_id ) ) return false;

		if ( $file && $file_bitrate ){

			$file_name = $file_name ? $file_name : pathinfo( $file, PATHINFO_BASENAME );

			if ( $convert ){
				$try = $file = $this->loader->ffmpeg->convert( $file, $convert );
				if ( !$try )
				return false;
			}

			if ( !$convert && $this->loader->admin->get_setting( "ffmpeg_convert", 0 ) && $this->loader->admin->get_setting( "ffmpeg", 0 ) ? $file_bitrate > $this->loader->admin->get_setting( "ffmpeg_convert", 0 ) + 30 : false ){
				$this->create( array_merge( $args, array(
					"convert"      => $this->loader->admin->get_setting( "ffmpeg_convert" ),
					"file_bitrate" => $this->loader->admin->get_setting( "ffmpeg_convert" ),
					"file_name"    => pathinfo( $file_name, PATHINFO_FILENAME ) . "_" . substr( uniqid(), 0, 5 ) . ".mp3"
				) ) );
			}

			$type = "file";
			$data = $file;

			if ( $file_relocate ){

				$track_data = $this->loader->track->select(["ID"=>$track_id]);

				$dest = "{$file_relocate}/{$file_name}";
				$move = $this->loader->general->move_file(
					$file,
					$dest,
					array(
						"skip_aws" => $track_data["price"] && $this->loader->admin->get_setting( "aws_protect", 1 ) ? true : false
					)
				);
				if ( !$move ) return false;
				if ( $move["type"] != "FILE" )
				$type = "file_r";
				$data = $move["data"];

			}

		}
		elseif ( $yt_id ){

			$type = "youtube";
			$data = $yt_id;

		}
		else return false;

		if ( $file_wave_bg && $file_wave_pr ){

			$wave_image_folder = $this->loader->general->mkdir( $this->loader->general->image_dir . "/waves/" );
			rename( $file_wave_bg, $wave_image_folder . "/" . pathinfo( $file_wave_bg, PATHINFO_BASENAME ) );
			rename( $file_wave_pr, $wave_image_folder . "/" . pathinfo( $file_wave_pr, PATHINFO_BASENAME ) );
			$file_wave_bg = realpath( $wave_image_folder . "/" . pathinfo( $file_wave_bg, PATHINFO_BASENAME ) );
			$file_wave_pr = realpath( $wave_image_folder . "/" . pathinfo( $file_wave_pr, PATHINFO_BASENAME ) );

		}

		$exists = $this->select( array_merge( [ "data" => $data, "type" => $type ], $args ) );
		if ( !empty( $exists ) ) return $exists;

		$stmt = $this->db->prepare("INSERT INTO _m_sources ( hash, type, data, track_id, bitrate, wave_bg, wave_pr, duration ) VALUES ( ?, ?, ?, ?, ?, ?, ?, ? )");
		$stmt->bind_param( "ssssssss", $hash, $type, $data, $track_id, $file_bitrate, $file_wave_bg, $file_wave_pr, $duration );
		$stmt->execute();
		$ID = $stmt->insert_id;
		$stmt->close();

		return [ "ID" => $ID, "type" => $type ];

	}
	public function remove( $ID ){

		$data = is_array( $ID ) ? $ID : $this->select(["ID"=>$ID]);

		// remove from db
		$this->db->query("DELETE FROM _m_sources WHERE ID = '{$data["ID"]}' ");

		// remove files for local tracks
		if ( $data["type"] == "file" || $data["type"] == "file_r" ){

			if ( !empty( $data["data"] ) ) $this->loader->general->remove_file( $data["data"] );
			if ( !empty( $data["wave_bg_raw"] ) ) $this->loader->general->remove_file( $data["wave_bg_raw"] );
			if ( !empty( $data["wave_pr_raw"] ) ) $this->loader->general->remove_file( $data["wave_pr_raw"] );
		}

	}

}

?>
