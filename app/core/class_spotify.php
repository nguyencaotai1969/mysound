<?php

if ( !defined( "root" ) ) die;

class spotify {

	public $api_base = "https://api.spotify.com/v1/";
	public $api_id   = null;
	public $api_key  = null;
	public $api_access = false;
	public $dled = [];
	public $rest = 0;

	// API functions
	public function __simplify( $type, $data, $ed = null ){

		$simplified_data = [];

		if ( $type == "track" || $type == "track_in_album" || $type == "album" ){

			// sanitize title
			$this->loader->secure->validate( $data["name"], "string", [ "strip_emoji" => true ] );
			$simplified_data["title"] = $data["name"];
			$simplified_data["ID"]    = $data["id"];
			$simplified_data["hits"]  = !empty( $data["popularity"] ) ? $data["popularity"] : null;
		    $simplified_data["cover"] = !empty( $data["images"][1]["url"] ) ? $data["images"][1]["url"] : ( !empty( $data["album"]["images"][1]["url"] ) ? $data["album"]["images"][1]["url"] : null );

			// sanitize artist name
			$this->loader->secure->validate( $data["artists"][0]["name"], "string", [ "strip_emoji" => true ] );
			$simplified_data["artist_name"] = $data["artists"][0]["name"];
			$simplified_data["artist_ID"]   = $data["artists"][0]["id"];

			$simplified_data["artists_featured"]  = [];
			if ( is_array( $data["artists"] ) ? count( $data["artists"] ) > 1 : false ){
			    foreach( array_slice( $data["artists"], 1 ) as $artist_featured ){
					// sanitize artist name
					$this->loader->secure->validate( $artist_featured["name"], "string", [ "strip_emoji" => true ] );
					$simplified_data["artists_featured"][] = $artist_featured["name"];
			    }
		    }

		}
		if ( $type == "album" ){

			$simplified_data["label"]        = !empty( $data["label"] ) ? $data["label"] : null;
			$simplified_data["time"]         = $this->loader->general->strtotime( $data["release_date"] );
			$simplified_data["year"]         = substr( $data["release_date"], 0, 4 );
			$simplified_data["total_tracks"] = $data["total_tracks"];
			$simplified_data["type"]         = $data["album_type"] == "album" ? "studio" : $data["album_type"];

			if ( !empty( $data["tracks"]["items"] ) ){
				foreach( $data["tracks"]["items"] as $__i => $__t ){
					$simplified_data["tracks"][] = $this->__simplify( "track_in_album", $__t, array_merge( $simplified_data, [ "i" => ($__i+1) ] ) );
				}
			}

		}
		if ( $type == "track" || $type == "track_in_album" ){

			$simplified_data["explicit"]    = isset( $data["explicit"] ) ? $data["explicit"] : null;
			$simplified_data["duration"]    = round( $data["duration_ms"] / 1000 );

			if ( !empty( $data["album"] ) ){
				$simplified_data["album_order"] = !empty( $data["track_number"] ) ? $data["track_number"] : 0;
				$simplified_data["album_ID"]    = $data["album"]["id"];
				$simplified_data["album_type"]  = $data["album"]["album_type"] == "album" ? "studio" : $data["album"]["album_type"];
				$this->loader->secure->validate( $data["album"]["name"], "string", [ "strip_emoji" => true ] );
				$simplified_data["album_title"] = $data["album"]["name"];
				$simplified_data["album_cover"] = !empty( $data["album"]["images"][0]["url"] ) ? $data["album"]["images"][0]["url"] : null;
				$simplified_data["album_time"]  = $this->loader->general->strtotime( $data["album"]["release_date"] );
				$this->loader->secure->validate( $data["album"]["artists"][0]["name"], "string", [ "strip_emoji" => true ] );
				$simplified_data["album_artist_name"]  = $data["album"]["artists"][0]["name"];
			}

		}
		if ( $type == "track_in_album" ){

			if ( !empty( $ed ) ){
				$simplified_data["album_order"]        = $ed["i"];
				$simplified_data["cover"]              = $ed["cover"];
				$simplified_data["album_ID"]           = $ed["ID"];
				$simplified_data["album_type"]         = $ed["type"];
				$this->loader->secure->validate( $ed["title"], "string", [ "strip_emoji" => true ] );
				$simplified_data["album_title"]        = $ed["title"];
				$simplified_data["album_cover"]        = $ed["cover"];
				$simplified_data["album_time"]         = $ed["time"];
				$this->loader->secure->validate( $ed["artist_name"], "string", [ "strip_emoji" => true ] );
				$simplified_data["album_artist_name"]  = $ed["artist_name"];
			}

		}
		if ( $type == "artist" ){

			$simplified_data["ID"]         = $data["id"];
			$simplified_data["followers"]  = $data["followers"]["total"];
			$simplified_data["genres"]     = !empty( $data["genres"] ) ? $data["genres"] : [];
			$simplified_data["image"]      = !empty( $data["images"] ) ? $data["images"][0]["url"] : null;
			$this->loader->secure->validate( $data["name"], "string", [ "strip_emoji" => true ] );
			$simplified_data["name"]       = $data["name"];
			$simplified_data["type"]       = $data["type"];
			$simplified_data["popularity"] = $data["popularity"];

		}
		if ( $type == "playlist" ){

			$simplified_data["followers"]   = !empty( $data["followers"]["total"] ) ? $data["followers"]["total"] : null;
			$simplified_data["ID"]          = $data["id"];
			$simplified_data["description"] = $data["description"];
			$this->loader->secure->validate( $data["name"], "string", [ "strip_emoji" => true ] );
			$simplified_data["name"]        = $data["name"];
			$simplified_data["image"]       = !empty( $data["images"][0]["url"] ) ? $data["images"][0]["url"] : null;

			if ( !empty( $data["tracks"]["items"] ) ){
				foreach( $data["tracks"]["items"] as $playlist_track ){
					$playlist_track_simplified = $this->__simplify( "track", $playlist_track["track"] );
					$simplified_data["tracks"][] = $playlist_track_simplified;
				}
			}

		}

		return $simplified_data;

	}

	public function __construct( $loader ){

		$this->loader = $loader;
		$this->db = $loader->db;
		$this->api_access = $this->loader->admin->get_setting( "spotify_access", null );

	}
	public function search( $type, $q, $range = 25, $limit=0 ){

		$args = [ "type" => $type, "q" => $q, "offset" => $limit, "limit" => $range ];
		$search_spotify = $this->request( "search", $args );
		return $search_spotify;

	}
	public function search_tracks( $track_title, $track_artist = null ){

		if ( empty( $track_artist ) ) $q = urlencode( $track_title );
		else $q = 'artist:'.(urlencode($track_artist)).'%20track:'.(urlencode($track_title));
		$search = $this->search( "track", $q );
		if ( empty( $search["tracks"] ) ) return [ 0, "no_tracks" ];
		if ( $search["tracks"]["total"] < 1 ) return [ 0, "no_tracks" ];
		return [1, $search["tracks"]["items"] ];

	}
	public function search_track( $track_title, $track_artist = null ){

		$track_title = $this->loader->general->purify_track_title( $track_title );
		// search all tracks
		$search_tracks = $this->search_tracks( $track_title, $track_artist );
		if ( !$search_tracks[0] ) return $search_tracks;

		// go through tracks and find the best one
		foreach( $search_tracks[1] as $search_track ){

			if ( empty( $search_track["name"] ) ) continue;

			$search_track_name = $this->loader->general->purify_track_title( $search_track["name"] );

			if ( $track_artist ){
				similar_text( strtolower(trim("{$track_artist} - {$track_title}")), trim(strtolower("{$search_track["artists"][0]["name"]} - {$search_track_name}")), $sim );
				$minSim = 65;
			} else {
				similar_text( strtolower(trim("{$track_title}")), trim(strtolower("{$search_track_name}")), $sim );
				$minSim = 80;
			}

			if ( $sim >= $minSim && !empty( $search_track["name"] ) && !empty( $search_track["album"] ) && !empty( $search_track["artists"][0]["name"] ) ){

				return [1,$this->__simplify( "track", $search_track )];

			}

		}

		return [ 0, "spotify_no_track" ];

	}
	public function search_albums( $album_title, $album_artist = null ){

		if ( empty( $album_title ) ) $q = urlencode( $album_title );
		else $q = 'artist:'.(urlencode($album_artist)).'%20album:'.(urlencode($album_title));
		$search = $this->search( "album", $q );
		if ( empty( $search["albums"] ) ) return [ 0, "no_albums" ];
		if ( $search["albums"]["total"] < 1 ) return [ 0, "no_albums" ];
		return [1, $search["albums"]["items"] ];

	}
	public function search_album( $album_title, $album_artist = null ){

		// search all tracks
		$search_albums = $this->search_albums( $album_title, $album_artist );
		if ( !$search_albums[0] ) return $search_albums;

		// search thro titles
		$best_match = 0;
		$__fa = null;
		foreach( $search_albums[1] as $key => $album ){
			similar_text( trim(strtolower($album_title)), trim(strtolower($album["name"])), $similarity );
			if ( $similarity > $best_match && $similarity > 75 ){
				$best_match = $similarity;
				$__fa = $album;
			}
		}

		if ( empty( $__fa ) ) return [ 0, "spotify_no_album" ];

		return [1, $this->__simplify( "album", $__fa ) ];

	}
	public function search_artists( $artist_name ){

		$q = urlencode( $artist_name );
		$search = $this->search( "artist", $q );
		if ( empty( $search["artists"] ) ) return [ 0, "no_artists" ];
		if ( $search["artists"]["total"] < 1 ) return [ 0, "no_artists" ];
		return [1, $search["artists"]["items"] ];

	}
	public function search_artist( $artist_name ){

		// search all tracks
		$search_artists = $this->search_artists( $artist_name );
		if ( !$search_artists[0] ) return $search_artists;

		// search thro titles
		$best_match = 0;
		$__fa = null;
		foreach( $search_artists[1] as $key => $artist ){
			similar_text( trim(strtolower($artist_name)), trim(strtolower($artist["name"])), $similarity );
			if ( $similarity > $best_match && $similarity > 75 ){
				$best_match = $similarity;
				$__fa = $artist;
			}
		}

		if ( empty( $__fa ) ) return [ 0, "spotify_no_artist" ];

		return [1, $this->__simplify( "artist", $__fa ) ];

	}
	public function search_playlists( $query ){

		$q = urlencode( $query );
		$search = $this->search( "playlist", $q );
		if ( empty( $search["playlists"] ) ) return [ 0, "no_playlists" ];
		if ( $search["playlists"]["total"] < 1 ) return [ 0, "no_playlists" ];
		return [1, $search["playlists"]["items"] ];

	}

	public function get_album_data( $id ){

		$get_album_data = $this->request( "albums/{$id}", [] );
		if ( empty( $get_album_data ) ) return [ 0, "no_album_data" ];
		return [1,$this->__simplify( "album", $get_album_data )];

	}
	public function get_track_data( $id ){

		$get_track_data = $this->request( "tracks/{$id}", [] );
		if ( empty( $get_track_data ) ) return [ 0, "no_track_data" ];
		return [1,$this->__simplify( "track", $get_track_data )];

	}
	public function get_playlist_data( $id ){

		$get_playlist_data = $this->request( "playlists/{$id}", [] );
		if ( empty( $get_playlist_data ) ) return [ 0, "no_playlist_data" ];
		return [1,$this->__simplify( "playlist", $get_playlist_data )];

	}
	public function get_artist_data ( $artistID ){

		$get_artist = $this->request( "artists/{$artistID}/", [] );
		if ( empty( $get_artist["id"] ) ) return [ 0, "no_artist" ];
		return [ 1, $this->__simplify( "artist", $get_artist ) ];

	}
	public function get_artist_top_tracks( $artistID, $complete = false ){

		$tracks = [];
		$get_tracks = $this->request( "artists/{$artistID}/top-tracks", [ "limit" => 50, "country" => "us" ] );
		if ( empty( $get_tracks["tracks"] ) ) return [ 0, "no_artist_track" ];

		foreach( $get_tracks["tracks"] as $_item ){
			$tracks[] = $this->__simplify( "track", $_item );
		}

		$pages = 1;
		while( $complete && !empty( $get_tracks["next"] ) ){

			if ( $pages > 10 ) continue;
			$pages++;

			$get_tracks = $this->request( $get_tracks["next"] );
			if ( !empty( $get_tracks["tracks"] ) ){
				foreach( $get_tracks["tracks"] as $_item ){
			        $tracks[] = $this->__simplify( "track", $_item );
		        }
			}

		}

		return [ 1, $tracks ];

	}
	public function get_artist_top_albums( $artistID, $groups = [ "album", "appears_on", "single", "compilation" ] , $limit = 50, $complete = false ){

		$albums = [];
		$get_albums = $this->request( "artists/{$artistID}/albums", [ "limit" => $limit, "include_groups" => implode( ",", $groups ) ] );
		if ( empty( $get_albums["items"] ) ) return [ 0, "no_artist_album" ];

		foreach( $get_albums["items"] as $_item ){
			$albums[] = $this->__simplify( "album", $_item );
		}

		$pages = 1;
		while( $complete && !empty( $get_albums["next"] ) && $pages <= 10 ){

			$pages++;

			$get_albums = $this->request( $get_albums["next"] );
			if ( !empty( $get_albums["items"] ) ){
				foreach( $get_albums["items"] as $_item ){
					$albums[] = $this->__simplify( "album", $_item );
				}
			}

		}

		return [ 1, $albums ];

	}
	public function get_artist_related_artists( $artistID ){

		$get_artists = $this->request( "artists/{$artistID}/related-artists" );
		if ( empty( $get_artists["artists"] ) ) return [ 0, "no_artist_related_artists" ];

		$artists = [];
		foreach( $get_artists["artists"] as $_artist ){
			$artists[] = $this->__simplify( "artist", $_artist );
		}

		return [ 1, $artists ];

	}

	public function save_image( $url, $save_args ){

		$code = $this->loader->general->make_code( $url );
		if ( !empty( $this->dled[ $code ] ) ) return $this->dled[ $code ];
		$this->dled[ $code ] = $this->loader->general->save_image( file_get_contents( $url ), $save_args );
		return $this->save_image( $url, $save_args );

	}

	// request function
	public function request( $type, $args = array(), $retry = false ){

		if ( empty( $this->api_id ) )  $this->api_id  = $this->loader->admin->get_setting('spotify_id');
		if ( empty( $this->api_key ) ) $this->api_key = $this->loader->admin->get_setting('spotify_key');
		if ( empty( $this->api_key ) || empty( $this->api_id ) ) return false;

		if ( !empty( $args ) ){
	    	// fetch http request string
	    	foreach( $args as $k => $v ){
	    		$na[] = "{$k}={$v}";
	    	}
	    	// fetch request string
	    	$http_request_string = implode( "&", $na );
		} else {
			$http_request_string = "";
		}

		if ( !empty( $this->api_access ) ){
			$headers = array( "Authorization: Bearer " . $this->api_access );
		} else {
			$headers = array();
		}

		$res = $this->loader->general->curl(array(
			"url"         => $this->api_base . str_replace( $this->api_base, "", $type ) . ( !empty( $http_request_string ) ? "?" . $http_request_string : "" ),
			"headers"     => $headers,
			"cache_load"  => $retry ? false : true,
			"cache_range" => 72
		));

		$res = json_decode( $res[1], 1 );

		if ( !empty( $res["error"] ) ? $res["error"]["status"] == 401 : false ){

			$request_token = $this->loader->general->curl(array(
				"url"     => "https://accounts.spotify.com/api/token",
			    "posts"   => "grant_type=client_credentials",
				"headers" => ["Authorization: Basic " . base64_encode( $this->api_id.":".$this->api_key )],
				"cache_load" => false,
				"cache_save" => false
			));

			$request_token = json_decode( $request_token[1], 1 );
			if ( empty( $request_token["access_token"] ) ) die ("can't obtain spotify new access token!!");
			$this->api_access = $request_token["access_token"];
			$this->loader->admin->save_setting( "spotify_access", $this->api_access, "/^[a-zA-Z0-9_\-. ]{20,150}$/" );
			return $this->request( $type, $args, true );

		}
		elseif ( !empty( $res["error"] ) ? $res["error"]["status"] == 429 : false ){
			sleep( rand( 10, 20 ) );
			return $this->request( $type, $args, true );
		}

		if ( $this->rest ) sleep( $this->rest );

		return $res;

	}

}
?>
