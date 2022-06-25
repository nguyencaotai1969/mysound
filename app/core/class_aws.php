<?php

if ( !defined( "root" ) ) die;
use Aws\S3\S3Client;

class aws {

	public function __construct( $loader ){

		$this->loader = $loader;
		$this->db = $loader->db;

		$this->endpoint = $this->loader->admin->get_setting( "aws_endpoint" );
		if ( substr( $this->endpoint, -1 ) == "/" ) $this->endpoint = substr( $this->endpoint, 0, -1 );
		$this->region   = $this->loader->admin->get_setting( "aws_region" );
		$this->bucket   = $this->loader->admin->get_setting( "aws_bucket" );

	}
	public function getClient(){

		$this->key = $this->loader->admin->get_setting( "aws_key" );
		$this->secret = $this->loader->admin->get_setting( "aws_secret" );

		if ( !$this->region || !$this->bucket || !$this->secret || !$this->key ) return false;
		if ( !empty( $this->client ) ) return $this->client;

		require_once( app_core_root . "/third/AWS_SDK_for_PHP-3.173/vendor/autoload.php" );
		$this->client = $s3 = new S3Client([
			'endpoint' => $this->endpoint,
			'version'  => 'latest',
			'region'   => $this->region,
			'credentials' => [
					'key'    => $this->key,
					'secret' => $this->secret,
			]
		]);

		return $this->client;

	}
	public function url( $filename ){
		return "{$this->endpoint}/{$this->bucket}/{$filename}";
	}
	public function upload( $file, $filename ){

		if ( !( $client = $this->getClient() ) )
		return false;

		$client->putObject([
			'Bucket' => $this->bucket,
			'Key'    => $filename,
			'Body'   => fopen($file, 'r'),
			'ACL'    => 'public-read',
		]);

		return $this->exists( $filename );

	}
	public function exists( $filename ){

		if ( !( $client = $this->getClient() ) )
		return false;

		if ( $client->doesObjectExist( $this->bucket, $filename ) )
		return true;
		return false;

	}
	public function delete( $filename ){

		if ( !( $client = $this->getClient() ) )
		return false;

		if ( !$this->exists( $filename ) )
		return true;

		$client->deleteObject([
				'Bucket' => $this->bucket,
				'Key'    => $filename,
		]);

		if ( !$this->exists( $filename ) )
		return true;
		return false;

	}
	public function test(){

		if ( !( $client = $this->getClient() ) )
		return false;

		try {
			$client->listBuckets();
		} catch( Exception $err ){
			return false;
		}

		return $client->doesBucketExist( $this->bucket );
		return true;
		return false;

	}

}

?>
