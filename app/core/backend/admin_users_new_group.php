<?php

if ( !defined( "root" ) ) die;

$name = $this->ps["name"];
$name_exists = !empty($loader->user->group_select(["name"=>$name]));
if ( $name_exists ) $this->set_error( "This name already exists, choose another one" );

$loader->user->group_create(["name"=>$name]);
$this->set_response("done");

?>