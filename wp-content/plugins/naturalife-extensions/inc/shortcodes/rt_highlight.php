<?php
if( ! function_exists("rt_highlight") ){
	/**
	 * Highlights Shortcode
	 * 
	 * @param  array $atts
	 * @param  string $content
	 * @return html
	 */		
	function rt_highlight( $atts, $content = null ) { 

	//defaults
	extract(shortcode_atts(array(  
		"style" => "style-1", 
	), $atts));

  
	return '<span class="highlight '.$style.'">'.$content.'</span>';

	}
 }

add_shortcode('rt_highlight', 'rt_highlight'); 