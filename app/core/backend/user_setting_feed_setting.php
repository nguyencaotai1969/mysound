<?php

if ( !defined( "root" ) ) die;

$actions = $loader->user->getActions(["admin_setting"=>true,"user_setting"=>true]);

foreach( [ "feed", "not", "email" ] as $act_type ){

	if ( !empty( $this->ps[ $act_type ] ) ){
		foreach( explode( ",", $this->ps[ $act_type ] ) as $_id ){

			if ( !$loader->secure->validate( $_id, "int" ) )
			$this->set_error("invalid_id",true);

			if ( empty( $actions[ $_id ]["ua_{$act_type}"] ) || !empty( $actions[ $_id ]["admin"] ) )
			$this->set_error("invalid_id",true);

		}
	}

}

$loader->db->_update([
	"table" => "_users",
	"set" => [
		[ "feed_setting", $this->ps["feed"] ],
		[ "not_setting", $this->ps["not"] ],
		[ "email_setting", !empty( $this->ps["email"] ) ? $this->ps["email"] : "" ]
	],
	"where" => [
		[ "ID", "=", $loader->visitor->user()->ID ]
	]
]);

$this->set_response( "done" );

?>
