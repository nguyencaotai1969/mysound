<?php

if ( !defined( "root" ) ) die;

$gs = $loader->user->group_get_all_simplfied();
foreach( $gs as $g ){
	$gz[ $g[0] ] = $g[1];
}

unset( $gz[1], $gz[2], $gz[3], $gz[5] );

$this->loader->ui->set_page_data( [ 
	"themes" => $this->loader->admin->load_themes(),
	"langs"  => $loader->admin->get_setting( "langs", null, null, true ),
	"groups" => $gz
] );

$loader->html->set_title( "Setting - General" );

?>