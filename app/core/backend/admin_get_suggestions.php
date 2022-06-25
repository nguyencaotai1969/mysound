<?php

if ( !defined( "root" ) ) die;

$results = [];

if ( $this->ps["type"] == "user" ){
	
	$search = $loader->user->select([
		"_sq" => $this->ps["q"],
		"limit" => 10,
	]);
	
	if ( !empty( $search) ){
		foreach( $search as $__s ){
			$results[ $__s["ID"] ] = $__s["username"];
		}
	}
	
}
else if ( $this->ps["type"] == "track_id" ){
	
	$search = $loader->track->select([
		"_sq" => $this->ps["q"],
		"limit" => 10
	]);
	
	if ( !empty( $search ) ){
		foreach( $search as $__s ){
			$results[ $__s["ID"] ] = $__s["artist_name"] . " - " . $__s["title"];  
		}
	}
	
}
else if ( $this->ps["type"] == "album_id" ){
	
	$search = $loader->album->select([
		"_sq" => $this->ps["q"],
		"limit" => 10
	]);
	
	if ( !empty( $search ) ){
		foreach( $search as $__s ){
			$results[ $__s["ID"] ] = $__s["title"] . " " . $__s["year"];  
		}
	}
	
}
else if ( $this->ps["type"] == "artist_id" ){
	
	$search = $loader->artist->select([
		"_sq" => $this->ps["q"],
		"limit" => 10
	]);
	
	if ( !empty( $search ) ){
		foreach( $search as $__s ){
			$results[ $__s["ID"] ] = $__s["name"];  
		}
	}
	
}
else if ( $this->ps["type"] == "artist_name" ){
	
	$search = $loader->artist->select([
		"_sq" => $this->ps["q"],
		"limit" => 10
	]);
	
	if ( !empty( $search ) ){
		foreach( $search as $__s ){
			$results[ $__s["name"] ] = $__s["name"];  
		}
	}
	
}
else if ( $this->ps["type"] == "album_title" ){
	
	$search = $loader->album->select([
		"_sq" => $this->ps["q"],
		"limit" => 10
	]);
	
	if ( !empty( $search ) ){
		foreach( $search as $__s ){
			$results[ $__s["title"] ] = $__s["title"] . " " . $__s["year"];  
		}
	}
	
}
else if ( $this->ps["type"] == "genre_id" ){
	
	$search = $loader->genre->select([
		"_sq" => $this->ps["q"],
		"limit" => 10
	]);
	
	if ( !empty( $search ) ){
		foreach( $search as $__s ){
			$results[ $__s["ID"] ] = $__s["name"];  
		}
	}
	
}

if ( empty( $results ) ){
	$results[ 0 ] = "No Suggestions";
}

$this->set_response( $results, false, false, true );

?>