<?php
if( ! function_exists("rt_shortcode_tabs") ){
	/**
	 * Tabs Holder Shortcode
	 * 
	 * @param  array $atts
	 * @param  string $content
	 * @return html
	 */			
	function rt_shortcode_tabs( $atts, $content = null ) {	
	global $rt_total_tabs, $rt_tab_counter, $rt_tab_contents, $rt_tab_titles, $tabs_style;	

	//defaults
	extract(shortcode_atts(array(
		"tabs_style" => 'style-1',
		"id" => '',
		"class" => '',
		"tab_count_" => ""	 
	), $atts));

	//find total slide number
	if( ! empty( $tab_count_ ) ){
		$rt_total_tabs = $tab_count_;
	}else{
		$rt_total_tabs = substr_count($content,'[vc_tta_section');	

		if( $rt_total_tabs == 0 ){
			$rt_total_tabs = substr_count($content,'[rt_tab');	
		}
	}

	//start the counter
	$rt_tab_counter = 1;

	//reset the contents
	$rt_tab_contents = $rt_tab_titles = "";

	//id attr
	$id_attr = ! empty( $id ) ? 'id="'.$id.'"' : "";

	//vertical nav align
	$class .= $tabs_style == "style-2" ? " left" : "";
	$class .= $tabs_style == "style-3" ? " right" : "";

	//tab style
	$tabs_position = $tabs_style == "style-1" || $tabs_style == "style-4" ? "tab-position-1" : "tab-position-2";

	//content
	$content = do_shortcode($content);  
  
	$output =  '<div class="rt_tabs '.$class.' '.$tabs_position.' '.$tabs_style.'" '.$id_attr.' data-tab-position="'.$tabs_position.'" data-tab-count="'.$rt_total_tabs.'">'.($content).'</div>';

	$output = apply_filters( "rtframework_shortcode_output", $output );
	return $output;
	}
}

if( ! function_exists("rt_shortcode_tab") ){
	/**
	 * Tabs Single Tab Shortcode
	 * 
	 * @param  array $atts
	 * @param  string $content
	 * @return html $output
	 */			
	function rt_shortcode_tab( $atts, $content = null ) {
	global $rt_total_tabs, $rt_tab_counter, $rt_tab_contents, $rt_tab_titles, $tabs_style;

	//defaults
	extract(shortcode_atts(array(
		"title" => '',
		"id" => '',
		"class" => '',
		"icon_name" => '', 
	), $atts));	
 
	//id
	$id =  empty( $id ) ? 'tab-'.$rt_tab_counter : $id;

	//active tabs
	$class = $rt_tab_counter == 1 ? " active" : "";

	//icon
	$icon = ! empty( $icon_name ) ? '<span class="'.$icon_name.'"></span>' : "";
	$class .= ! empty( $icon_name ) ? ' with_icon' : "";

	//tab contents
	if( $rt_tab_counter <= $rt_total_tabs ){
		$rt_tab_contents .= sprintf(
					'<div class="tab_content_wrapper animation %2$s" id="%1$s" data-tab-content="%6$s">
						<div id="%1$s-inline-title" class="tab_title tab-inline-title" data-tab-number="%6$s">%5$s%3$s</div>
						<div class="tab_content">%4$s</div>
					</div>',	
					$id, trim($class), $title, apply_filters("the_content",$content), $icon, $rt_tab_counter );
	}

	//tab titles
	if( $rt_tab_counter <= $rt_total_tabs ){
		$rt_tab_titles .= sprintf(
					'<li class="tab_title %2$s" id="%1$s-title" data-tab-number="%5$s">%4$s%3$s</li>',
					$id, $class, $title, $icon, $rt_tab_counter );
	}

	//final output
	if( $rt_tab_counter == $rt_total_tabs ){
		$output = '<ul class="tab_nav">'.$rt_tab_titles.'</ul>';
		$output .= '<div class="tab_contents">'. $rt_tab_contents .'</div>';
			
		return $output;

	}

	//count the tabs
	$rt_tab_counter++;

	}
}

add_shortcode('rt_tabs', 'rt_shortcode_tabs');
add_shortcode('rt_tab', 'rt_shortcode_tab');


