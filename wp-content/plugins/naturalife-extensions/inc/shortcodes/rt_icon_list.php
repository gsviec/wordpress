<?php
if( ! function_exists("rt_icon_list") ){
	/**
	 * Icon Lists Holder Shortcode
	 * 
	 * @param  array $atts
	 * @param  string $content
	 * @return html $output
	 */				
	function rt_icon_list( $atts, $content = null ) { 

	extract(shortcode_atts(array(  
		"id" => '',
		"class" => '',			
		"list_style" => "style-1",
		"chained" => false
	), $atts));

	$list_holder_output = "";
 
	//id attr
	$id_attr = ! empty( $id ) ? 'id="'.$id.'"' : "";

	//fix shortcode
	$content = do_shortcode(rt_content_filter($content)); 

	$list_holder_output = sprintf('	 
		<div %1$s class="with_icons %2$s %3$s">
		%4$s
		</div>
	', $id_attr, $list_style, $class, $content );

	return $list_holder_output;
	}
}

if( ! function_exists("rt_icon_list_line") ){
	/**
	 * Icon Lists Single Line Shortcode
	 * 
	 * @param  array $atts
	 * @param  string $content
	 * @return html $output
	 */			
	function rt_icon_list_line( $atts, $content = null ) { 
 	extract(shortcode_atts(array(  
		"id" => '',
		"class" => '', 
		"icon_name" => ''
	), $atts));	

	//content
	$content = do_shortcode($content);

	//icon output
	$icon_output = ! empty( $icon_name ) ? '<span class="'.$icon_name.' icon"></span>' : "";
 
 	//id attr
	$id_attr = ! empty( $id ) ? 'id="'.$id.'"' : "";

 	//class attr
	$class_attr = ! empty( $class ) ? 'class="'.$class.'"' : "";

	//output
	$output = sprintf('	 
		<div %1$s %2$s>
		%3$s<div class="list-content">%4$s</div>
		</div>
	', $id_attr, $class_attr, $icon_output, rt_visual_composer_content_fix($content) );

	return $output;
	}
}

add_shortcode('rt_icon_list', 'rt_icon_list');
add_shortcode('rt_icon_list_line', 'rt_icon_list_line');