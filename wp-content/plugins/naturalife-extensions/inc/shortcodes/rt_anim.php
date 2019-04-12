<?php
if( ! function_exists("rt_anim_function") ){
	/**
	 * Text Animation
	 * @param  array $atts
	 * @param  string $content
	 * @return html $divider
	 */
	function rt_anim_function( $atts, $content = null ) {		
 
 	//defaults
	extract(shortcode_atts(array(
		"id"            => '',
		"class"         => '',
		"style"         => '1',
		"timeout"       => 3000,//ms
	), $atts));

	//id attr
	$id_attr = ! empty( $id ) ? 'id="'.sanitize_html_class($id).'"' : "";	  
 
	//style
	$class .= " rt-anim style-".$style;

	//craete texts
	$texts = explode("|", $content);

	$inner_output = "";
	foreach ($texts as $text) {
		$inner_output .= "<span>".$text."</span>";
	}	

	//timeout
	$timeout = ! empty( $timeout ) ? intval( $timeout ) : 3000;

	//output
	$output = sprintf('<span %1$s class="%2$s" data-timeout="%4$s">%3$s</span>', $id_attr, trim($class), $inner_output, $timeout);

	return $output;


	}
}

add_shortcode('rt_anim', 'rt_anim_function'); 		 
