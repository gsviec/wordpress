<?php
if( ! function_exists("rt_shortcode_accordion") ){
	/**
	 * Accordions Holder Shortcode
	 * 
	 * @param  array $atts
	 * @param  string $content
	 * @return html $accordion_holder
	 */				
	function rt_shortcode_accordion( $atts, $content = null ) {
	//[accordion style="" first_one_open=""][/accordion]
	 global $rt_accordion_number_count, $rt_accordion_style, $rt_accordion_first_open;

	//defaults
	extract(shortcode_atts(array(  
		"id" => '',
		"class"=> '',
		"style" => 'numbered',
		"first_one_open" => 'false', 
	), $atts));
	
	
	//global variables
	$rt_accordion_number_count= 1;
	$rt_accordion_style = $style;

	$rt_accordion_first_open = ($first_one_open=="true") ? "true" : "";
	 
	//id attr
	$id_attr = ! empty( $id ) ? 'id="'.sanitize_html_class($id).'"' : "";

	$content = do_shortcode($content); 

	$accordion_holder  ="";
	$accordion_holder .='<div '.$id_attr.' class="rt-toggle '.sanitize_html_class($class).'';
	$accordion_holder .= " ".$style;
	$accordion_holder .='"><ol>'.$content.'</ol></div>'; 

	return $accordion_holder;
	}
}

if( ! function_exists("rt_shortcode_accordion_panel") ){
	/**
	 * Accordions Single Content Shortcode
	 * 
	 * @param  array $atts
	 * @param  string $content
	 * @return html $panes
	 */			
	function rt_shortcode_accordion_panel( $atts, $content = null ) { 
	global $rt_accordion_number_count, $rt_accordion_style, $rt_accordion_first_open;

	//defaults
	extract(shortcode_atts(array(  
		"id" => '',
		"class"=> '',		
		"title" => '',
		"icon_name" => 'icon_name', 
	), $atts));	 

	//id attr
	$id_attr = ! empty( $id ) ? 'id="'.sanitize_html_class($id).'"' : "";

	//class
	$class .= ($rt_accordion_first_open && $rt_accordion_number_count==1) ? " open" : "";

	$panes  = ""; 	
	$panes .='<li '.$id_attr.' class="'.sanitize_html_class($class).'">'; 
	$panes .= '<div class="toggle-head">';
	
	$panes .= $rt_accordion_style == "numbered" ? '<div class="toggle-number">'.$rt_accordion_number_count.'</div>' : "";
	$panes .= $rt_accordion_style == "icons" ? '<div class="toggle-title"><span class="'.$icon_name.'"></span>'.$title.'</div>' : '<div class="toggle-title">'.$title.'</div>' ;
	$panes .= '</div>'; 
	$panes .= '<div class="toggle-content">';
	$panes .= apply_filters("the_content",$content); 
	$panes .= '</div>';
	$panes .= '</li>';

	$rt_accordion_number_count++;
	return $panes;
	}
}

add_shortcode('rt_accordion', 'rt_shortcode_accordion');
add_shortcode('rt_accordion_content', 'rt_shortcode_accordion_panel');