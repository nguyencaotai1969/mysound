<?php

if ( !defined( "root" ) ) die;

class db extends mysqli {

	protected $cache = array();
	public $debug = false;
	public $log   = false;

	public function __construct( $loader ){

		$this->loader = $loader;

		// Try to connect to DB
		parent::__construct( db_host, db_user, db_pass, db_name );

		if( mysqli_connect_errno() ) {
			echo "Failed to connect to Database <br>\n";
			echo "You have to run the installer or edit app/config.php and put in the right database information";
			throw new exception(mysqli_connect_error(), mysqli_connect_errno());
			exit;
			die;
		}

		parent::set_charset("utf8mb4");

	}

	protected function __log( $args ){

		if ( !$this->log ) return;

		$query    = null;
		$__cf     = null;
		$safe     = 0;
		$generic  = 0;
		$exe_time = null;
		extract( $args );
		$type  = null;
		$table = null;

		if ( strtolower( substr( $query, 0, strlen( "update " ) ) ) == "update "  ){
			$type  = "update";
			$__query = strtolower( substr( $query, strlen( "update " ) ) );
			$_query = explode( "set", $__query );
			$table = reset( $_query );
			unset( $_query );
		}
		else if ( strtolower( substr( $query, 0, strlen( "insert into " ) ) ) == "insert into " ){
			$type  = "insert";
			$__query = strtolower( trim( substr( $query, strlen( "insert into " ) ) ) );
			$_query = explode( " ", $__query );
			$table = reset( $_query );
			unset( $_query );
		}
		else if ( strtolower( substr( $query, 0, strlen( "select " ) ) ) == "select " ){
			$type  = "select";
			$___query = explode( "from", strtolower( $query ) );
			$__query = trim( end( $___query ) );
			$_query = explode( " ", $__query );
			$table = reset( $_query );
			unset( $_query );
		}

		$table = trim( str_replace( [ "'", '"', "`" ], "", $table ) );
		$query = json_encode( $query );

		$d = parent::prepare( "INSERT INTO _debug ( `table`, `type`, query, generic, safe ) VALUES ( ?, ?, ?, ?, ? )" );
		$d->bind_param( "sssss", $table, $type, $query, $generic, $safe );
		$d->execute();
		$d->close();

	}

	public function query( $query, $resultmode = NULL ){

		$st  = microtime( true );
		$run = parent::query( $query, $resultmode );
		$tt  = round( microtime( true ) - $st, 2 );

		$this->__log(array(
			"query"    => $query,
			"__cf"     => "query",
			"safe"     => 0,
			"generic"  => 0,
			"exe_time" => $tt
		));

		return $run;

	}
	public function prepare( $query, $generic = false ){

		$run = parent::prepare( $query );

		$this->__log(array(
			"query"    => $query,
			"__cf"     => "prepare",
			"safe"     => 1,
			"generic"  => $generic ? 1 : 0,
		));

		return $run;

	}

	public function _select( $args ){

		$table    = null;
		$limit    = 1;
		$offset   = 0;
		$order    = "DESC";
		$order_by = null;
		$where    = null;
		$columns  = "*";
		$group    = null;
		$cache    = false;
		$single   = false;
		extract( $args );
		$offset   = $offset ? $offset : 0;

		list( $where_query, $where_vals ) = $this->parse_where( $where );
		$where_query = $where_query ? "WHERE {$where_query}" : null;

		$select = $this->_query([
			"action" => "select",
			"query"  => "SELECT {$columns} FROM {$table} {$where_query}" . ( $group ? " {$group}" : "" ) . ( $order_by ? " ORDER BY {$order_by} {$order}" : "" ) . ( $limit ? " LIMIT {$offset}, {$limit} " : "" ),
			"params" => $where_vals,
			"cache"  => $cache,
		]);

		if ( $select && $limit == 1 && $single )
			return reset( $select );

		return $select;

	}
	public function _update( $args ){

		$table    = null;
		$limit    = null;
		$offset   = null;
		$order    = null;
		$order_by = null;
		$where    = null;
		$set      = null;
		extract( $args );

		$where_query = "";
		$where_vals  = [];
		if ( !empty( $where ) ){
			list( $where_query, $where_vals ) = $this->parse_where( $where );
	    	$where_query = $where_query ? "WHERE {$where_query}" : null;
		}

		list( $set_query, $set_vals ) = $this->parse_set_update( $set );
		$set_query = $set_query ? "SET {$set_query}" : null;

		$this->_query([
			"action" => "update",
			"query"  => "UPDATE {$table} {$set_query} {$where_query}" . ( $order_by ? " ORDER BY {$order_by} {$order}" : "" ) . ( $limit ? " LIMIT {$offset}, {$limit} " : "" ),
			"params" => array_merge( $set_vals, $where_vals ),
		]);

		return true;

	}
	public function _delete( $args ){

		$table    = null;
		$limit    = null;
		$offset   = null;
		$order    = null;
		$order_by = null;
		$where    = null;
		extract( $args );

		list( $where_query, $where_vals ) = $this->parse_where( $where );
	    $where_query = $where_query ? "WHERE {$where_query}" : null;

		$this->_query([
			"action" => "delete",
			"query"  => "DELETE FROM {$table} {$where_query}" . ( $order_by ? " ORDER BY {$order_by} {$order}" : "" ) . ( $limit ? " LIMIT {$offset}, {$limit} " : "" ),
			"params" => $where_vals,
		]);

		return true;

	}
	public function _insert( $args ){

		$table = null;
		$set   = null;
		extract( $args );

		list( $key_query, $qm_query, $set_vals ) = $this->parse_set_insert( $set );

		return $this->_query([
			"action" => "insert",
			"query"  => "INSERT INTO {$table} {$key_query} VALUES {$qm_query}",
			"params" => $set_vals,
		]);

	}
	public function _query( $args ){

		$action = null;
		$query  = null;
		$params = null;
		$cache  = false;
		extract( $args );
		$result = null;

		$__c_id = $this->loader->general->make_code( $query . ( $params ? json_encode( $params ) : "" ) );

		if ( $cache ? in_array( $__c_id, array_keys( $this->cache ) ) : false ){
			return $this->cache[$__c_id];
		}

		// Start the statement
		$stmt = $this->prepare( $query, true );

		// Bind paramets ( if any )
		if( $params ){

			$types = "";
			for( $i=0; $i<count($params); $i++ ) {
				$types .= "s";
			}

			$bind_names = [ $types ];

            for( $i=0; $i<count($params); $i++ ) {

                $var_name  = 'var_' . $i;
                $$var_name = $params[$i];
                $bind_names[] = &$$var_name;

            }

						$return = call_user_func_array( array( $stmt, 'bind_param' ), $bind_names );

		}

		// Execute the statement
		$stmt->execute();


		if ( !empty( $stmt->error ) ){

			if ( $this->debug ){
				var_dump( $query, $params, $stmt->error );
			}
			trigger_error( $stmt->error, E_USER_ERROR );
			die;
			exit;

		}

		// Collect required information
		if ( $action == "select" ){

            $stmt->store_result();
            if ( $stmt->num_rows ){

                $md = $stmt->result_metadata();
                $fields = [];
                while( $field = $md->fetch_field() ) {
                    $fields[] = $field->name;
                }

                for ( $i=0; $i<$stmt->num_rows; $i++ ){

                    $__r = array();
                    $__p = array();

                    foreach( $fields as $field ){
                        $__p[] = &$__r[ $field ];
                    }

                    call_user_func_array( array( $stmt, 'bind_result' ), $__p );

                    if( $stmt->fetch() )
                        $result[] = $__r;

                }


            }
            $stmt->free_result();

		}

		if ( $action == "insert" ){
			$result = $stmt->insert_id;
		}

		$stmt->close();

		if ( $cache ){
			$this->cache[$__c_id] = $result;
		}

		return $result;

	}

	protected function parse_where( $where ){

		if ( empty( $where ) ? true : !is_array( $where ) ) return [ null, null ];

		if ( empty( $where["oper"] ) && empty( $where["cond"] ) ){
			$where = [ "cond" => $where ];
		}

		list( $where_vars, $where_vals ) = array_values( $this->parse_where_level( $where ) );
		$where_vars = substr( $where_vars, 2, -2 );

		return [ $where_vars, $where_vals ];

	}
	protected function parse_where_level( $array ){

		if ( !isset( $array["cond"] ) ){
			trigger_error( "Bad arguemtns passed to parse_where_level" . json_encode( $array ), E_USER_ERROR );
		}

		$oper = isset( $array["oper"] ) ? $array["oper"] : "AND";
		$cond = $array["cond"];

		$vars = [];
		$vals = [];

		foreach( $cond as $__l ){

			if ( !empty( $__l["oper"] ) && !empty( $__l["cond"] ) ){

				$p = $this->parse_where_level( $__l );
				$vars[] = $p["vars"];
				if ( $p["vals"] ) $vals = array_merge( $vals, $p["vals"] );

			} else {

				$p = $this->parse_cond( $__l );
				$vars[] = $p["var"];
				if ( !$p["raw"] ) $vals[] = $p["val"];

			}

		}

		return [
			"vars" => "( ". implode( " {$oper} ", $vars ) ." )",
			"vals" => $vals,
		];

	}
	protected function parse_cond( $array ){

		$column = $array[0];
		$oper   = $array[1];
		$value  = $array[2];
		$raw    = !empty( $array[3] );

		$string = "";

		if ( in_array( $oper, [ "=", ">", "<", "!=", ">=" ,"<=" ] ) ){

			$string = "`{$column}` {$oper} " . ( !$raw ? "?" : "{$value}" );

		}
		elseif( $oper == "LIKE%" ) {

			$string = "`{$column}` LIKE " . ( !$raw ? "?" : "'%{$value}%'" );
			$value  = !$raw ? "%{$value}%" : "";

		}
		elseif( $oper == "LIKE" ) {

			$string = "`{$column}` LIKE " . ( !$raw ? "?" : "'{$value}'" );

		}
		elseif( $oper == "IN" ) {

			$string = "`{$column}` IN ( {$value} )";

		}
		elseif( $oper === null && $value === null ) {

			$string = "`{$column}` IS NULL";

		}

		return [
			"var" => $string,
			"val" => $raw ? null : $value,
			"raw" => $raw,
		];

	}
	protected function parse_set_update( $array ){

		$vars = $vals = [];

		foreach( $array as $__i ){

			$raw = count( $__i ) == 3 ? true : false;
			$var = $__i[0];
			$val = $__i[1];

			$vars[] = "{$var} = " . ( $raw ? $val : "?" );
			if ( !$raw ) $vals[] = $val;

		}

		return [ implode( ", ", $vars ), $vals ];

	}
	protected function parse_set_insert( $array ){

		$keys = $vals = $qm = [];

		foreach( $array as $__i ){

			$raw = count( $__i ) == 3 ? true : false;
			$var = $__i[0];
			$val = $__i[1];

			$keys[] = "`{$var}`";

			if ( $raw ){
				$qm[]   = $val;
			} else {
				$qm[]   = "?";
				$vals[] = $val;
			}

		}

		return [
			"( " . implode( ", ", $keys ) . " )",
			"( " . implode( ", ", $qm ) . " )",
			$vals
		];

	}

}

?>
