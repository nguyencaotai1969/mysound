<?php

if ( !defined( "root" ) ) die;

class ftp {

	public function __construct( $loader ){

		$this->loader = $loader;
		$this->db = $loader->db;
		$this->web_address = $this->loader->admin->get_setting( "ftp_web_address" );
		if ( substr( $this->web_address, -1 ) == "/" ) $this->web_address = substr( $this->web_address, 0, -1 );

	}
	public function getClient( $fresh = false ){

		$this->ssl = $this->loader->admin->get_setting( "ftp_ssl" );
		$this->address = $this->loader->admin->get_setting( "ftp_address" );
		$this->username = $this->loader->admin->get_setting( "ftp_username" );
		$this->password = $this->loader->admin->get_setting( "ftp_password" );
		$this->port = $this->loader->admin->get_setting( "ftp_port" );
		$this->path = $this->loader->admin->get_setting( "ftp_path" );
		if ( substr( $this->path, -1 ) != "/" ) $this->path = "{$this->path}/";

		if ( !$this->address || !$this->username || !$this->password || !$this->port || !$this->path || !$this->web_address ) return false;
		if ( $fresh ) $this->client = false;
		if ( !empty( $this->client ) ) return $this->client;

		require_once( app_core_root . "/third/nicolab-php-ftp-client/autoload.php" );

		$ftp = new \FtpClient\FtpClient();

		try {
			$ftp->connect( $this->address, !empty( $this->ssl ), $this->port );
		} catch( Exception $err ){
			return false;
		}

		try {
			$ftp->login( $this->username, $this->password );
		} catch( Exception $err ){
			return false;
		}

		$this->_base = $ftp->pwd();
		$this->client = $ftp;
		return $ftp;

	}
	public function url( $filename ){
		return "{$this->web_address}/{$filename}";
	}
	public function upload( $file, $filename ){

		if ( !( $client = $this->getClient( true ) ) )
		return false;

		$filename = "{$this->path}{$filename}";
		$dirname  = pathinfo( $filename, PATHINFO_DIRNAME );
		$rfilename  = pathinfo( $filename, PATHINFO_BASENAME );

		if ( !$this->dir_exists( $dirname ) ){
			$this->dir_create( $dirname, true );
			if ( !$this->dir_exists( $dirname ) ){
				return false;
			}
		}

		$client->pasv( true );
		$client->chdir( str_replace( "//", "/", "{$this->_base}{$dirname}" ) );

		/*
		echo "pwd:";
		echo $client->pwd();
		echo PHP_EOL;
		echo "file:";
		echo $file;
		echo PHP_EOL;
		echo "filename:";
		echo $filename;
		echo PHP_EOL;
		echo "rfilename:";
		echo $rfilename;
		echo PHP_EOL;
		*/

		$uploaded = $client->putFromPath( $rfilename, $file );
		$client->close();

		return $uploaded;

	}
	public function delete( $filename ){

		if ( !( $client = $this->getClient( true ) ) )
		return false;

		$filename = "{$this->path}{$filename}";
		$name    = pathinfo( $filename, PATHINFO_BASENAME );
		$dirname = pathinfo( $filename, PATHINFO_DIRNAME );

		$client->chdir( $dirname );
		$client->pasv( true );
		if ( $client->remove( $name ) )
		return true;
		return false;

	}
	public function dir_exists( $path ){

		if ( !( $client = $this->getClient() ) )
		return false;

		$client->chdir( $this->_base );
		return $client->isDir( $this->_base . $path );

	}
	public function dir_create( $path, $rec = false ){

		if ( !( $client = $this->getClient() ) )
		return false;

		if ( $this->dir_exists( $path ) )
		return true;

		$client->chdir( $this->_base );
		$client->mkdir( $path, $rec );

		return $this->dir_exists( $path );

	}
	public function dir_delete( $path, $rec = false ){

		if ( !( $client = $this->getClient() ) )
		return false;

		if ( !$this->dir_exists( $path ) ) return true;
		$client->rmdir( $path, $rec );
		return !$this->dir_exists( $path );

	}
	public function test(){

		if ( !extension_loaded("ftp") )
		return "FTP extension is not loaded by PHP";
		if ( !( $client = $this->getClient( true ) ) )
		return false;
		return true;

	}

}

?>
