<?php

if( ! function_exists("rt_image_carousel") ){
	/**
	 * Image Carousel Shortcode
	 * 
	 * @param  array $atts
	 * @param  string $content
	 * @return html
	 */															
	function rt_image_carousel( $atts, $content = null ) {

	//defaults
	extract(shortcode_atts(array(  
		"id"  => 'image-carousel-'.rand(100000, 1000000),	
		"class" => '',			
		"images" => '',
		"img_width" => 980,
		"img_height" => 980,
		"crop" => "false",
		"carousel_layout" => 1,
		"tablet_layout"   => "",
		"mobile_layout"   => 1,		
		"margin" => "",
		"nav" => "true",
		"dots" => "false",
		"autoplay" => "false",
		"timeout" => 5000,
		"padding" => "",
		"loop" => "false",
		"boxed" => "false",
		"shadows" => "false",
		"links" => "false",
		"custom_links" => "",
		"link_target" => "",
		"captions" => "false",
		"image_size" => "",
		"scaled_imgs" => ""
	), $atts)); 

	//images 
	$images = ! empty( $images ) ? explode(",", $images ) : array();

	//scaled images
	$class .= ! empty( $scaled_imgs ) ? " scaled-imgs" : "";

	//carousel atts
	$carousel_atts = array(  
		"id"                => sanitize_html_class($id), 
		"item_width"        => $carousel_layout, 
		"mobile_item_width" => $mobile_layout, 
		"tablet_item_width" => $tablet_layout, 		
		"class"             => sanitize_html_class($class),
		"nav"               => $nav,
		"dots"              => $dots,
		"autoplay"          => $autoplay,
		"timeout"           => $timeout,
		"margin"            => intval($margin),
		"padding"           => intval($padding),
		"loop"              => $loop,
		"boxed"             => $boxed,
		"shadows"           => $shadows
	);


	$output = rtframework_create_image_carousel(array("rt_gallery_images" => $images, "carousel_atts" => $carousel_atts, "w" => $img_width, "h" => $img_height, "crop" => $crop, "echo" => false, "links" => $links, "custom_links" => $custom_links, "link_target" => $link_target, "captions" => $captions, "image_size" => $image_size ) ) ;
	$output = apply_filters( "rtframework_shortcode_output", $output );

	return $output;

	}
}

add_shortcode('rt_image_carousel', 'rt_image_carousel');