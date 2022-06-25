<?php

if ( !defined( "root" ) ) die;

$pagedata = [
	"langs" => $loader->admin->get_setting( "langs", null, null, true ),
];
$menu_translations = $page_translations = [];

if ( $requested_language_code = $loader->secure->get( "get", "code", "in_array", [ "values" => array_keys( $pagedata["langs"] ) ] ) ){
	
	$pagedata["r_code"] = $requested_language_code;
	$pagedata["code"] = $pagedata["langs"][$requested_language_code];
	
	$get_en_hooks = $loader->db->query("SELECT * FROM _langs WHERE lang = 'en' ");
	if ( !$get_en_hooks->num_rows ) die;
	while( $en_hook = $get_en_hooks->fetch_assoc() ){
		if ( substr( $en_hook["hook"], 0, 2 ) == "m_" ){
			$menu_translations["en"][$en_hook["hook"]] = $en_hook["text"];
			continue;
		}
		if ( substr( $en_hook["hook"], 0, 2 ) == "p_" ){
			$page_translations["en"][$en_hook["hook"]] = $en_hook["text"];
			continue;
		}
		$pagedata["hooks"]["en"][$en_hook["hook"]] = $en_hook["text"];
	}
	
	if ( $requested_language_code != "en" ){
		$get_en_hooks = $loader->db->query("SELECT * FROM _langs WHERE lang = '{$requested_language_code}' ");
		if ( $get_en_hooks->num_rows ){
			while( $en_hook = $get_en_hooks->fetch_assoc() ){
				if ( substr( $en_hook["hook"], 0, 2 ) == "m_" ){
					$menu_translations[$requested_language_code][$en_hook["hook"]] = $en_hook["text"];
					continue;
				}
				if ( substr( $en_hook["hook"], 0, 2 ) == "p_" ){
					$page_translations[$requested_language_code][$en_hook["hook"]] = $en_hook["text"];
					continue;
				}
			    $pagedata["hooks"][$requested_language_code][$en_hook["hook"]] = $en_hook["text"];
		    }
		}
	}
	
	$menu_groups = $this->loader->ui->load_menus( true, true );
	foreach( $menu_groups as $menu_data ){
		foreach( $menu_data as $menu_parent_data ){
			
			if ( substr( $menu_parent_data["title"], 0, 1 ) == "#" ){
				$_menu_hook = "m_" . substr( $menu_parent_data["title"], 1 );
				if ( !in_array( $_menu_hook, array_keys( $menu_translations["en"] ) ) ){
					$pagedata["hooks"]["en"][$_menu_hook] = "?";
				}
				else {
					$pagedata["hooks"]["en"][$_menu_hook] = $menu_translations["en"][$_menu_hook];
				}
				if ( empty( $menu_translations[$requested_language_code] ) ? true : !in_array( $_menu_hook, array_keys( $menu_translations[$requested_language_code] ) ) ){
					$pagedata["hooks"][$requested_language_code][$_menu_hook] = "?";
				}
				else {
					$pagedata["hooks"][$requested_language_code][$_menu_hook] = $menu_translations[$requested_language_code][$_menu_hook];
				}
			}
			
			if ( !empty( $menu_parent_data["items"] ) ){
				foreach( $menu_parent_data["items"] as $menu_child_data ){
					if ( substr( $menu_child_data["title"], 0, 1 ) == "#" ){
						
						$_menu_hook = "m_" . substr( $menu_child_data["title"], 1 );
						if ( !in_array( $_menu_hook, array_keys( $menu_translations["en"] ) ) ){
							$pagedata["hooks"]["en"][$_menu_hook] = "?";
						} else {
							$pagedata["hooks"]["en"][$_menu_hook] = $menu_translations["en"][$_menu_hook];
						}
						
						if ( empty( $menu_translations[$requested_language_code] ) ? true : !in_array( $_menu_hook, array_keys( $menu_translations[$requested_language_code] ) ) ){
							$pagedata["hooks"][$requested_language_code][$_menu_hook] = "?";
						} else {
							$pagedata["hooks"][$requested_language_code][$_menu_hook] = $menu_translations[$requested_language_code][$_menu_hook];
						}
						
					}
				}
			}
			
		}
	}
	
	$get_pages = $loader->db->_select(["table"=>"_setting_page","limit"=>1000]);
	foreach( $get_pages as $page ){
		
		$_menu_hook = "p_" . $page["name"] . "_title";
		if ( !in_array( $_menu_hook, array_keys( $page_translations["en"] ) ) ){
			$pagedata["hooks"]["en"][$_menu_hook] = "?";
		} else {
			
			$pagedata["hooks"]["en"][$_menu_hook] = $page_translations["en"][$_menu_hook];
		}
		if ( empty( $page_translations[$requested_language_code] ) ? true : !in_array( $_menu_hook, array_keys( $page_translations[$requested_language_code] ) ) ){
			$pagedata["hooks"][$requested_language_code][$_menu_hook] = "?";
		} else {
			$pagedata["hooks"][$requested_language_code][$_menu_hook] = $page_translations[$requested_language_code][$_menu_hook];
		}
		
		$_menu_hook = "p_" . $page["name"] . "_desc";
		if ( !in_array( $_menu_hook, array_keys( $page_translations["en"] ) ) ){
			$pagedata["hooks"]["en"][$_menu_hook] = "?";
		} else {
			
			$pagedata["hooks"]["en"][$_menu_hook] = $page_translations["en"][$_menu_hook];
		}
		if ( empty( $page_translations[$requested_language_code] ) ? true : !in_array( $_menu_hook, array_keys( $page_translations[$requested_language_code] ) ) ){
			$pagedata["hooks"][$requested_language_code][$_menu_hook] = "?";
		} else {
			$pagedata["hooks"][$requested_language_code][$_menu_hook] = $page_translations[$requested_language_code][$_menu_hook];
		}
		
		$page_widgets = $loader->ui->load_page( $page["ID"] );
		if ( !empty( $page_widgets ) ){
			foreach( $page_widgets as $page_widget ){
				
				if ( substr( $page_widget["title"], 0, 1 ) == "#" ){
				    $_menu_hook = "p_w_" . substr( $page_widget["title"], 1 );
				    if ( !in_array( $_menu_hook, array_keys( $page_translations["en"] ) ) ){
					    $pagedata["hooks"]["en"][$_menu_hook] = "?";
				    }
				    else {
					    $pagedata["hooks"]["en"][$_menu_hook] = $page_translations["en"][$_menu_hook];
				    }
				    if ( empty( $page_translations[$requested_language_code] ) ? true : !in_array( $_menu_hook, array_keys( $page_translations[$requested_language_code] ) ) ){
					    $pagedata["hooks"][$requested_language_code][$_menu_hook] = "?";
				    }
				    else {
					    $pagedata["hooks"][$requested_language_code][$_menu_hook] = $page_translations[$requested_language_code][$_menu_hook];
				    }
			    }
				
			}
		}
		
	}
	
}

$this->set_page_data( $pagedata );

$loader->html->set_title( "Manage Languages" );

?>