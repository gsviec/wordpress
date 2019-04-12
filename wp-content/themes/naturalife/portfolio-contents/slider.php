<?php
/**
 * Portfolio Slideshow
 */
$single_post_values = rtframework_get_global_value("rtframework_single_post_values");


if( ! empty( $single_post_values["gallery_images"] ) ){	

	//carousel atts
	$carousel_atts = apply_filters("single-portfolio-carousel-atts", array(  
		"id"  => $post->ID."-portfolio-image-carosel", 
		"item_width"  => 1, 
		"class" => "single-portfolio-carousel",
		"nav" =>  "true",
		"dots" => "false",
		"autoplay" => "false",
		"min_height" => "",
		"margin" => 0,
		"padding" => 0,
		"loop" => "false" ,
		"fullheight" => "false" 
	));

	echo rtframework_create_image_carousel( 
		apply_filters("single-portfolio-carousel-content-atts", array( 
			"rt_gallery_images" => $single_post_values["gallery_images"], 
			"column_width" => "12/12", 
			"carousel_atts" => $carousel_atts, 
			'crop' => "false", 
			'itemprop'=> "false", 
			'links' => "lightbox"
		))
	);

}