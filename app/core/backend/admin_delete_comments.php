<?php

if ( !defined( "root" ) ) die;

// Validate comments IDs
foreach( explode( ",", $this->ps["comments"] ) as $_comment_id ){
	
	if ( !$loader->secure->validate( $_comment_id, "int" ) )
		$this->set_error( "invalid_comment_id", true );
	
	$comment = $loader->comment->select(["ID"=>$_comment_id,"approved"=>null]);
	
	if ( empty( $comment ) )
		$this->set_error( "invalid_comment_id", true );
	
}

// Remove old comments one by one
foreach( explode( ",", $this->ps["comments"] ) as $_comment_id ){
	$delete = $loader->comment->delete( $_comment_id );
	if ( $delete !== true ) $this->set_error( $delete );
}

$this->set_response("done");

?>