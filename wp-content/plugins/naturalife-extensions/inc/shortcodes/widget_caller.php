<?php
if( ! function_exists("rt_widget_caller") ){
	/**
	 * Widget Caller Shortcode
	 * @param  array $atts
	 * @param  null $content 
	 * @return $output_string
	 */
	function rt_widget_caller($atts, $content = null){

	//defaults
	extract(shortcode_atts(array(  
		"id" => ''
	), $atts));
	
	ob_start();

	 //check id
	if(!empty($id)){
		dynamic_sidebar($id);
	}
	
	$output_string = ob_get_contents();
	ob_end_clean(); 

	return $output_string;
	}
}	

add_shortcode('widget_caller', 'rt_widget_caller');
