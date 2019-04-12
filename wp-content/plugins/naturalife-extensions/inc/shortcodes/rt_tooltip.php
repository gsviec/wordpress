<?php
if( ! function_exists("rt_tooltip") ){
	/**
	 * Tooltip Shortcode
	 * 
	 * @param  array $atts
	 * @param  string $content
	 * @return html $rt_tooltip
	 */				
	function rt_tooltip( $atts, $content = null ) {

	//defaults
	extract(shortcode_atts(array(  
		"text"   => '',
		"link"   => '',
		"target" => ''
	), $atts));	

	$rt_tooltip	= ""; 
	
	if($link)	$rt_tooltip .= '<a href="'.$link.'" target="'.$target.'" title="'.$text.'">';
	if(!$link)	$rt_tooltip .= '<span class="rt-tooltip-text"">';

	$rt_tooltip .= do_shortcode( $content );

	$rt_tooltip .= '<mark>'.$text.'</mark>';
	if(!$link)	$rt_tooltip .= '</span>';	
	if($link)	$rt_tooltip .= '</a>';
	
	return $rt_tooltip;
	}
}

add_shortcode('tooltip', 'rt_tooltip'); 