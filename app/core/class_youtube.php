<?php

if ( !defined("root" ) ) die;

class youtube {
	
	public $keys = null;
	public $go_unofficial = false;
	
	public function __construct( $loader ){
		
		$this->loader = $loader;
		$this->db = $loader->db;
		$this->keys = explode( PHP_EOL, $this->loader->admin->get_setting( "yt_key", null ) );
		$this->go_unofficial = $this->loader->admin->get_setting( "utube_api" );
		
	}
	
	protected function __req( $queryType, $queryData ){
		
		$queryData = array_merge(
			$queryData,
			[ "key" => $this->__key() ]
		);
		
		$api_data = $this->loader->general->curl([
			"url" => "https://www.googleapis.com/youtube/v3/{$queryType}?" . http_build_query( $queryData ),
		]);
		
		if ( empty( $api_data[1] ) ) 
			return [ 0, "empty_response_body" ];
		
		$api_data = json_decode( $api_data[1], 1 );
		
		if ( !empty( $api_data["error"]["message"] ) )
			return [ 0, $api_data["error"]["message"] ];
		
		return [ 1, $api_data ];
		
	}
	protected function __key(){
		
		// I could use array_rand here but my experience tells me array_rand is not as random as it should be
		// So i used this little hack for it, it is much better and more random than original function
		return $this->keys[ rand( 0, count( $this->keys )-1 ) ];
		
	}
	
	public function search_videos( $query ){
		
		$query = urlencode( $query );
		
		$search = $this->__req( "search", array(
			"part"            => "snippet",
			"maxResults"      => 3,
			"videoCategoryId" => 10,
			"type"            => "video",
			"videoEmbeddable" => "true",
			"q"               => $query
		) );

		if ( !$search[0] ) return $search;
		return [ 1, $search[1]["items"] ];
		
	}
	public function find_track( $artist_name, $title ){
		
		$search_youtube_music_videos = $this->search_videos( "{$artist_name} - {$title}" );
		if ( !$search_youtube_music_videos[0] )
			return $search_youtube_music_videos;
					
		$yt_id = null;
		$yt_sim = 0;

		foreach( $search_youtube_music_videos[1] as $track_in_youtube ){
			similar_text( mb_strtolower( "{$artist_name} - {$title}", "UTF-8" ), mb_strtolower( $track_in_youtube["snippet"]["title"], "UTF-8" ), $sim );
			if ( $sim > $yt_sim ){
				$yt_id  = $track_in_youtube["id"]["videoId"];
				$yt_sim = $sim;
			}
		}
			
		return [ 1, $yt_id ];
		
	}
	public function get_track( $id, $reqed_data = "contentDetails" ){
		
		$track_data = $this->__req( "videos", array(
			"part" => $reqed_data,
			"id"   => $id,
		) );
		
		if ( !$track_data[0] ) return $track_data;
		if ( $reqed_data == "contentDetails" ){
			$data = $track_data[1]["items"][0]["contentDetails"];
			$__d = new DateInterval( $data["duration"] );
			$data["duration"] = ($__d->format("%H")*60*60)+($__d->format("%I")*60)+($__d->format("%S"));
			unset( $__d );
		}
		
		return [ 1, array_merge( $data, [ "ID" => $id ] ) ];
		
	}
	
	public function find_track_full( $artist_name, $title ){
		
		$title = htmlspecialchars_decode( mb_strtolower( $title, "UTF-8" ), ENT_QUOTES );
		$artist_name = htmlspecialchars_decode( mb_strtolower( $artist_name, "UTF-8" ), ENT_QUOTES );
		
		if ( $this->go_unofficial ){
			return $this->loader->utube->find_track_full( $artist_name, $title );
		}
		
		$search_yt = $this->find_track( $artist_name, $title );
		if ( !$search_yt[0] )
			return $search_yt;
		
		$yt_data = $this->get_track( $search_yt[1] );
		if ( !$yt_data[0] )
			return $yt_data;
		
		return $yt_data;
		
	}
	
}

?>