<?php

if( ! function_exists("rt_photo_gallery") ){
	/**
	 * Image Carousel Shortcode
	 * 
	 * @param  array $atts
	 * @param  string $content
	 * @return html
	 */															
	function rt_photo_gallery( $atts, $content = null ) {

	//defaults
	$atts = shortcode_atts(array(  
		"id"           => '',   
		"class"        => '',   
		"crop"         => false, 	   
		"w"            => "", 
		"h"            => "", 
		"image_ids"    => array(), 
		"image_urls"   => array(),
		"item_width"   => "1/3",
		"layout"       => "1", //metro gallery layout
		"metro_resize" => "true", //metro gallery resize 
		"image_size"   => "",
		"layout_style" => "grid",
		"itemprop"     => "false",
		"captions"     => "false",
		"links"        => "false",
		"custom_links" => "",
		"link_target"  => "_self",   
		"echo"         => false,
		"nogaps"       => "false",
		"vertical_align" => ""
	), $atts); 

	//images 
	$atts["image_ids"] = ! empty( $atts["image_ids"] ) ? explode(",", $atts["image_ids"] ) : array();

	$output = rtframework_create_photo_gallery( $atts );
	$output = apply_filters( "rtframework_shortcode_output", $output );
	return $output;
	}
}

add_shortcode('rt_photo_gallery', 'rt_photo_gallery');