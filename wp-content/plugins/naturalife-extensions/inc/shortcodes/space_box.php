<?php
if( ! function_exists("rt_space_box") ){
	/**
	 * Space Box
	 * 
	 * @param  array $atts
	 * @param  null $content
	 * @return html $output
	 */
	function rt_space_box( $atts, $content = null ) { 

	//defaults
	extract(shortcode_atts(array(
		"id"  => '', 
		"height"  => 0, 
	), $atts));

	$style = intval( $height ) > 0 ? 'style="height:'.$height.'px"' : "";
	
	$output = ! empty( $id ) ? sprintf('<div id="%s" class="clearfix" %s></div>', $id, $style) : sprintf('<div class="clearfix" %s></div>',$style);

	return $output; 
	}
}
add_shortcode('space_box', 'rt_space_box'); 