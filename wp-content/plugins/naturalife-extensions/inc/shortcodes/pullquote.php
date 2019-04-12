<?php
if( ! function_exists("rt_pullquote") ){
	/**
	 * Pullquote Shortcode
	 * 
	 * @param  array $atts
	 * @param  string $content
	 * @return html $output
	 */					
	function rt_pullquote( $atts, $content = null ) {

	//defaults
	extract(shortcode_atts(array(
		"align"  => 'left',
	), $atts));
 
	//check p tag
	$content = ! strpos($content, "<p>") ? '<p>'.$content.'</p>' : $content;

	$output = sprintf('
		<blockquote class="pullquote align%s">%s</blockquote>
	',$align, rt_remove_idle_p($content) ); 

	return $output;
	}
}

add_shortcode('pullquote', 'rt_pullquote'); 		