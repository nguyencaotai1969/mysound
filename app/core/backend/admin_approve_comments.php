<?php

if ( !defined( "root" ) ) die;

// Validate comments IDs
foreach( explode( ",", $this->ps["comments"] ) as $_comment_id ){
	
	if ( !$loader->secure->validate( $_comment_id, "int" ) ) 
		$this->set_error( "invalid_comment_id", true );
	
	$comment = $loader->comment->select(["ID"=>$_comment_id,"approved"=>false]);
	
	if ( empty( $comment ) )
		$this->set_error( "invalid_comment_id", true );
	
}

// Approve comments
foreach( explode( ",", $this->ps["comments"] ) as $_comment_id ){
	
	$approve = $loader->comment->approve( $_comment_id );
	if ( $approve !== true ) $this->set_error( $approve );
	
}

$this->set_response("done");

?>