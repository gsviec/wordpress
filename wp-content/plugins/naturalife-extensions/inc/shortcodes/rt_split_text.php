<?php
if( ! function_exists("rt_split_text") ){
	/**
	 * Split Text
	 * 
	 * @param  array $atts
	 * @param  string $content
	 * @return html
	 */			
	function rt_split_text( $atts, $content = null ) {	 

	//defaults
	$atts = shortcode_atts(array(
		"col" => 1
	), $atts);

	extract($atts);
 
	//content
	$content = do_shortcode($content);  
  
	return sprintf('<div class="rt-text-columns" style="-webkit-column-count:%1$s;-moz-column-count:%1$s;column-count:%1$s;">%2$s</div>', $col, $content );

	}
}

add_shortcode('rt_split_text', 'rt_split_text');