<?php

if ( !defined( "root" ) ) die;

class search {

	public $limit = 20;

	public function __construct( $loader ){

		$this->loader = $loader;
		$this->db = $loader->db;

	}
	public function parse_query( $queries, $hook = "title" ){

		$queries = is_array( $queries ) ? $queries : explode( " ", $queries );
		if ( empty( $queries ) ) return false;
		foreach( $queries as $query ){

			if ( empty( $query ) || strlen( $query ) < 3 ) continue;
			$query = $this->loader->general->make_code( $query );
			$qs[] = [ $hook, "LIKE%", $query ];

		}
		if ( empty( $qs ) ) return false;
		return $qs;

	}
	public function exe( $query, $type, $page = 1 ){

		if ( empty( $query ) ? true : mb_strlen( $query, "UTF-8" ) < 3 ) return false;

		$query = htmlspecialchars_decode( $query, ENT_QUOTES );

		$results = array(
			"albums"  => [],
			"tracks"  => [],
			"artists" => []
		);

		// Search in spotify
		if ( $this->loader->admin->get_setting( "spotify_search", 1, [0,1] ) ){

			$search_spotify = $this->loader->spotify->search( "track,artist,album", urlencode( $query ), $this->limit, ($page-1)*$this->limit );

			// Albums
			if ( !empty( $search_spotify["albums"] ) && ( $type == "albums" || $type == "all" ) ){
			    foreach( $search_spotify["albums"]["items"] as $spotify_album ){

					$spotify_album = $this->loader->spotify->__simplify( "album", $spotify_album );
					$item_code = $this->loader->general->make_code( $spotify_album["artist_name"] . $spotify_album["title"] );
					if ( empty( $results["albums"][ $item_code ] ) )
				    $results["albums"][ $item_code ] = array_merge(
					    $spotify_album,
					    [ "source" => "spotify" ]
				    );

			    }
		    }

			// Tracks
		    if ( !empty( $search_spotify["tracks"] ) && ( $type == "tracks" || $type == "all" ) ){
			    foreach( $search_spotify["tracks"]["items"] as $spotify_track ){
					$spotify_track = $this->loader->spotify->__simplify( "track", $spotify_track );
					$item_code = $this->loader->general->make_code( $spotify_track["artist_name"] . $spotify_track["album_title"] . $spotify_track["title"] );
					if ( empty( $results["tracks"][ $item_code ] ) )
				    $results["tracks"][ $item_code ] = array_merge(
					    $spotify_track,
					    [ "source" => "spotify" ]
				    );
			    }
		    }

			// Artists
		    if ( !empty( $search_spotify["artists"] ) && ( $type == "artists" || $type == "all" ) ){
			    foreach( $search_spotify["artists"]["items"] as $spotify_artist ){
					$spotify_artist = $this->loader->spotify->__simplify( "artist", $spotify_artist );
					$item_code = $this->loader->general->make_code( $spotify_artist["name"] );
					if ( empty( $results["artists"][ $item_code ] ) )
				    $results["artists"][ $item_code ] = array_merge(
					    $spotify_artist,
					    [ "source" => "spotify" ]
				    );
			    }
		    }

		}

		// Search in database
		foreach( [ "album", "track", "artist" ] as $__i ){

			if ( $type != "{$__i}s" && $type != "all" ) continue;

			$qs = $this->parse_query( $query, "code" );
			$search_db = $this->loader->$__i->select([
				"where"    => $qs,
				"where_o"  => "OR",
				"limit"    => $this->limit,
				"offset"   => ($page-1)*$this->limit,
				"singular" => false,
			]);

			if ( empty( $search_db ) ) continue;

		    foreach( $search_db as $__r ){

				$results[ "{$__i}s" ][ $__r["code"] ] = array_merge(
					$__r,
					[ "source" => "db" ]
				);

			}

		}

		return $results;

	}

}

?>
