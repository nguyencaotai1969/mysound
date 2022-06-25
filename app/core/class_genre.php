<?php

if ( !defined( "root" ) ) die;

class genre {

	protected $cache = [];

	public function __construct( $loader ){

		$this->loader = $loader;
		$this->db = $loader->db;

	}

	public function select( $args ){

		$query    = null;
		$limit    = 1;
		$offset   = null;
		$order_by = "name";
		$order    = "asc";
		$where    = [];
		$where_o  = "AND";
		$singular = true;

		// Where shortcodes
		$ID      = null;
		$name    = null;
		$code    = null;
		$deleted = false;
		$_sq     = null;

		extract( $args );
		$code = $code ? $code : ( $name ? $this->loader->general->make_code( $name ) : null );

		if ( $deleted === true || $deleted === 1 )
			$where[] = [ "deleted", ">", "0" ];

		if ( $deleted === false || $deleted === 0 )
			$where[] = [ "deleted", "=", "0" ];

		if ( $_sq )
	    	$where[] = [ "code", "LIKE%", strtolower($_sq) ];

		if ( !empty( $ID ) )             $where[] = [ "ID", "=", $ID ];
		elseif ( !empty( $code ) )       $where[] = [ "code", "=", $code ];
		elseif ( !empty( $spotify_id ) ) $where[] = [ "spotify_id", "=",$spotify_id ];

		$args = array(

			"table"    => "_m_genres",
			"where"    => array(
			    "oper" => $where_o,
			    "cond" => $where
		    ),
			"order_by" => $order_by,
			"order"    => $order,
			"limit"    => $limit,
			"offset"   => $offset,
			"cache"    => true

		);

		$raw_results = $this->loader->db->_select( $args );
		if ( empty( $raw_results ) ) return false;

		$__results = [];
		foreach( $raw_results as $__i ){

			$__i["name"] = $this->loader->secure->escape( $__i["name"] );

			$__i["image_o"] = $__i["image"];
			$__i["image_addr"] = $__i["image"] ? $this->loader->general->path_to_addr( $__i["image"] ) : null;

			$__results[$__i["code"]] = $__i;

		}

		return $limit == 1 && $singular ? reset( $__results ) : $__results;

	}

	public function get_all( $forceNew = false ){

		if ( !empty( $this->cache["all"] ) && !$forceNew )
			return $this->cache["all"];

		$genres = $this->select([
			"limit" => 3000
		]);

		$this->cache["all"] = $genres;
		return $genres;

	}
	public function get_all_simplfied( $forceNew = false ){

		$all = $this->get_all( $forceNew );
		if ( empty( $all ) ) return [];

		$genres = [];
		foreach( $all as $genre ){
			$genres[] = [ $genre["code"], $genre["name"] ];
		}
		return $genres;

	}

	public function valid( $string, $deleted = null ){

		$string_code = $this->loader->general->make_code( $string );
		$genre_db_data = $this->select( [ "code" => $string_code, "deleted" => $deleted ] );

		if ( empty( $genre_db_data ) ) return false;

		if ( $deleted ? $genre_db_data["deleted"] != 0 && $genre_db_data["deleted"] !== null : false ){
			$genre_db_data = $this->select([ "ID" => $genre_db_data["deleted"] ]);
		}

		return $genre_db_data;

	}
	public function return_valid( $string, $column = "name", $deleted = null ){

		$validate = $this->valid( $string, $deleted );
		return !empty( $validate[$column] ) ? $validate[$column] : null;

	}
	public function return_from_array( $genres ){

		if ( empty( $genres ) ) return "No-Genre";

		$genre = null;
		// Get a genre that already exists
		foreach( $genres as $_genre ){
			if ( !empty( $validate_genre = $this->return_valid( $_genre, "name", 1 ) ) ){
				$genre = $validate_genre;
				break;
			}
		}

		// Got a genre that exists in our database
		if ( !empty( $genre ) )
			return $genre;

		// Does admin allow dynamic genre creation? then choose first genre, create and return it
		if ( $this->loader->admin->get_setting( "spotify_g_c", 1, [0,1] ) ){
			$genre = reset( $genres );
			$this->create( $genre );
			return $genre;
		}

		return "No-Genre";

	}

	public function recover( $genreArray ){

		$url = $this->loader->ui->murl(
			"genre",
			$genreArray["code"],
			$genreArray["ID"]
		);
		$this->db->query("UPDATE _m_genres SET url = '{$url}', deleted = 0 WHERE ID = '{$genreArray["ID"]}' ");

	}
	public function create( $string ){

		$code = $this->loader->general->make_code( $string );
		$exists = $this->select([ "code" => $code, "deleted" => true ]);

		if ( $exists ){
			if ( $exists["deleted"] != 0 ){
				$this->recover( $exists );
			}
			return $exists["ID"];
		}

		$string = ucwords( $string );
		$stmt = $this->db->prepare("INSERT INTO _m_genres ( name, code ) VALUES ( ?, ? ) ");
		$stmt->bind_param( "ss", $string, $code );
		$stmt->execute();
		$genre_id = $stmt->insert_id;
		$stmt->close();

		$url = $this->loader->ui->murl(
			"genre",
			$code,
			$genre_id
		);
		$this->db->query("UPDATE _m_genres SET url = '{$url}' WHERE ID = '{$genre_id}' ");

		// reset cache
		$this->cache = [];

		return $genre_id;

	}
	public function remove( $ID, $new_ID ){

		// remove from _m_genres
		$this->db->query("UPDATE _m_genres SET deleted = '{$new_ID}' WHERE ID = '{$ID}' ");

		// change tracks to new genreID
		$this->db->query("UPDATE _m_tracks SET genre_id = '{$new_ID}' WHERE genre_id = '{$ID}' ");

		// change albums to new genreID
		$this->db->query("UPDATE _m_albums SET genre_id = '{$new_ID}' WHERE genre_id = '{$ID}' ");

	}
	public function edit( $ID, $new_data ){

		$data = is_array( $ID ) ? $ID : $this->select(["ID"=>$ID]);
		extract( array_merge( $data, $new_data ) );

		if ( !empty( $new_data["name"] ) ? $data["name"] != $new_data["name"] : false ){

			// new code
        	$code = $this->loader->general->make_code( $new_data["name"] );

			if ( !empty( $this->select( [ "code" => $code ] ) ) ){
				return "exists";
			}

        	// new url
        	$url = $this->loader->ui->murl(
				"genre",
				$code,
				$ID
			);

		}

		$stmt = $this->db->prepare("UPDATE _m_genres SET code=?, name=?, image=?, url=?, deleted=? WHERE ID=? ");
		$stmt->bind_param( "ssssss", $code, $name, $image, $url, $deleted, $ID );
		$stmt->execute();
		$stmt->close();

		return true;

	}

}

?>
