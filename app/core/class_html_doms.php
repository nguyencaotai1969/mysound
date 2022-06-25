<?php

if ( !defined("root" ) ) die;

class doms extends html {

	public $colors = [ "245, 149, 14", "189, 51, 102", "50, 141, 255", "5, 192, 192", "155, 89, 182", "255, 99, 132" ];

	public function __construct( $loader ){

		$this->loader = $loader;
		$this->db = $loader->db;

	}

	public function create_input( $type, $name, $value, $values = [], $placeholder = null ){

		if ( $type != "image" ) $value = $this->loader->secure->escape( $value );
		$placeholder = $placeholder ? $this->loader->secure->escape( $placeholder ) : null;

		if ( $type == "select" ){
			return $this->create_select( $name, $value, $values );
		}
		elseif ( $type == "text" ){
			return $this->create_text( $name, $value, $placeholder );
		}
		elseif ( $type == "textarea" ){
			return $this->create_textarea( $name, $value, $placeholder );
		}
		elseif ( $type == "digit" ){
			return $this->create_digit( $name, $value, $placeholder );
		}
		elseif ( $type == "check" ){
			return $this->create_check( $name, $value );
		}
		elseif ( $type == "color_selector" ){
			return $this->create_color_selector( $name, $value );
		}
		elseif ( $type == "image" ){
			return $this->create_image_uploader( $name, $value );
		}

	}

	protected function create_select( $name, $value, $values ){

		$html = "<select name='{$name}' class='form-control select'>";
		foreach( $values as $r => $l ){

			$r = $this->loader->secure->escape( $r );
			$l = $this->loader->secure->escape( $l );

			$html .= "<option ".($r==$value?" selected='selected'":"")." value='{$r}'>{$l}</option>";

		}
		$html .= "</select>";
		return $html;

	}

	protected function create_text( $name, $value, $placeholder ){

		$html = "<input type='text' class='form-control' name='{$name}' placeholder='{$placeholder}' value='{$value}'>";
		return $html;

	}

	protected function create_textarea( $name, $value, $placeholder ){

		$html = "<textarea class='form-control' name='{$name}' placeholder='{$placeholder}'>{$value}</textarea>";
		return $html;

	}

	protected function create_digit( $name, $value, $placeholder ){

		$html = "<input type='number' class='form-control digit' name='{$name}' placeholder='{$placeholder}' value='{$value}' step='0.01'>";
		return $html;

	}

	protected function create_check( $name, $checked ){

		$html = "<div class='checkbox_wrapper'>";
		$html .= "<input type='checkbox' name='{$name}' ".($checked?"checked='checked'":"")." >";
		$html .= "<span class='checkmark'>";
		$html .= "</div>";
		return $html;

	}

	protected function create_color_selector( $name, $value ){

		$html = "<input type='color' class='form-control' name='{$name}' value='#{$value}'>";
		return $html;

	}

	protected function create_image_uploader( $name, $value ){

		$html = "<div class='uploader_wrapper'>";
		$html .= "<input type='file' class='form-control' name='{$name}' >";
		if ( $value ){
			$value = $this->loader->general->path_to_addr( $value );
			$html .= "<div class='preview_image uploader'><a href='{$value}' target='_blank'><img src='{$value}'></a></div>";
		}
		$html .= "</div>";

		return $html;

	}

	public function create_graph( $graphData, $graphOptions = [] ){

		$graph_reverse = false;
		$graph_reverse_y = false;
		$graph_id = uniqid();
		$graph_height = 325;
		$graph_type = "line";
		$graph_options = (object)[];
		$graph_colors = $this->colors;
		$graph_colors_reverse = false;
		$graph_aGraph = true;
		extract( $graphOptions, EXTR_PREFIX_ALL, "graph" );

		$graph_colors = $graph_colors_reverse ? array_values( array_reverse( $graph_colors, true ) ) : $graph_colors;

		if( $graph_reverse ){

			$old_hooks = $graphData["hooks"];
			$old_datas = $graphData["datas"];
			$graphData["hooks"] = [];
			$graphData["datas"] = [];
			foreach( array_reverse( $old_hooks ) as $old_hook ){
				$graphData["hooks"][] = $old_hook;
			}
			foreach( $old_datas as $graphDataName => $graphDataValues ){
				foreach( array_reverse( $graphDataValues, true ) as $old_hook => $old_value ){
					$graphData["datas"][$graphDataName][$old_hook] = $old_value;
				}
			}

		}

		// data sets
		$i=0;
		if ( !empty( $graphData["datas"] ) ){

		    foreach( $graphData["datas"] as $data_set_name => $data_set_values ){

			    $dataset_options = $graphData["datas_options"][ $data_set_name ];

			    $dataset_width = isset( $dataset_options[ "width" ] ) ? $dataset_options[ "width" ] : 2;
			    $dataset_color = !empty( $dataset_options[ "color" ] ) ? $dataset_options[ "color" ] : $graph_colors[ $i ];

			    if ( !empty( $dataset_options[ "bg_color" ] ) ? $dataset_options[ "bg_color" ] == "_def" : false ){

					$dataset_bg = [];
					foreach( $this->colors as $color ){
				        $a_clr = "rgba({$color}, 0.5)";
						$dataset_bg[] = $a_clr;
					}


				} elseif ( !empty( $dataset_options[ "bg_color" ] ) ? is_array( $dataset_options[ "bg_color" ] ) : false ){

				    $dataset_bg = $dataset_options[ "bg_color" ];

			    } else {

				    $dataset_bg_color = !empty( $dataset_options[ "bg_color" ] ) ? $dataset_options[ "bg_color" ] : $dataset_color;
			        $dataset_bg_opacity = !empty( $dataset_options[ "bg_opacity" ] ) ? $dataset_options[ "bg_opacity" ] : "0.2";
				    $dataset_bg = "rgba({$dataset_bg_color}, {$dataset_bg_opacity})";

			    }

			    $dataset = [];
			    $dataset[ "label" ] = $dataset_options["label"];
			    $dataset[ "borderColor" ] = isset( $dataset_options[ "border_color" ] ) ? $dataset_options[ "border_color" ] : "rgba({$dataset_color}, 0.5)";
			    $dataset[ "pointBackgroundColor" ] = "rgba({$dataset_color}, 0.8)";
			    $dataset[ "backgroundColor" ] = $dataset_bg;
			    $dataset[ "borderWidth" ] = $dataset_width;
			    $dataset[ "pointRadius" ] = isset( $dataset_options[ "point_width" ] ) ? $dataset_options[ "point_width" ] : $dataset_width+1;
			    $dataset[ "data" ] = array_values( $data_set_values );

			    if ( !empty( $dataset_options[ "fill" ] ) ){
				    $dataset[ "fill" ] = $i;
				    $dataset[ "fill" ] = $dataset[ "fill" ] == 0 ? "start" : "-1";
			    } else {
				    $dataset[ "fill" ] = false;
			    }

				if ( !empty( $dataset_options[ "stack" ] ) ){
				    $dataset[ "stack" ] = $dataset_options[ "stack" ];
			    }

			    $datasets[] = (object) $dataset;
			    $i++;

		    }

		}
		else {

			$dataset = [];
			$graphData["hooks"] = [null,null,null,null,null,null,null,null,null];
			$datasets[] = (object) array(
				"data" => [0,20,15,30,18,40,35,49,45],
				"label" => "l1",
				"borderColor" => "rgba(0, 0, 0, 0.05)",
				"pointBackgroundColor" => "rgba(0, 0, 0, 0)",
				"backgroundColor" => "rgba(0, 0, 0, 0.016)",
				"borderWidth" => "3",
				"pointRadius" => "0",
			);

		}

		// graph data
		$graph = json_encode( (object)[
			"data" => (object)[
	    		"labels" => $graphData["hooks"],
	    		"datasets" => $datasets,
	    	],
			"options" => $graph_options,
			"type" => $graph_type
		], JSON_UNESCAPED_UNICODE );


		if ( $graph_aGraph ){
			$wrapper_string = "<div class='aGraph a_graph' style='height: {$graph_height}px' >__IN__</div>";
		} else {
			$wrapper_string = "<div class='a_graph' style='height: {$graph_height}px;'>__IN__</div>";
		}

		$inner_string = "<canvas id='{$graph_id}'></canvas>";
		if ( empty( $graphData["datas"] ) ) $inner_string .= "<div class='nada'>Not enough data to create a graph!</div>";

		$graph_string = str_replace( "__IN__", $inner_string, $wrapper_string );
		$graph_string .= "<script>$(document).ready(function(){new Chart($('#{$graph_id}'),{$graph})});</script>";

		echo $graph_string;

	}

}

?>
