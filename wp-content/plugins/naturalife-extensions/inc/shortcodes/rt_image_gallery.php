<?php

if( ! function_exists("rt_image_gallery") ){
	/**
	 * Image Gallery Holder Shortcode
	 * 
	 * @param  array $atts
	 * @param  string $content
	 * @return html
	 */															
	function rt_image_gallery( $atts, $content = null ) {		
	global $rt_image_gallery_globals;

	//defaults
	extract(shortcode_atts(array(  
		"id" => '',
		"class" => '',			
		"list_layout" => '1/4',
		"crop"  => 'true',
		"tooltips" => 'true',
		"frames" => "false"
	), $atts)); 

	//global values
	$rt_image_gallery_globals["gallery_id"] = ! empty( $id ) ? $id : rand(100000, 1000000); 	
	$rt_image_gallery_globals["counter"] = 1;
	$rt_image_gallery_globals["list_layout"] = $list_layout; 
	$rt_image_gallery_globals["crop"] = ! empty( $crop ) ? $crop : "false";		
	$rt_image_gallery_globals["tooltips"] =  $tooltips;		
	$rt_image_gallery_globals["frames"] =  $frames;		
	$rt_image_gallery_globals["item_count"] = substr_count($content,'[rt_gal_item'); //find total item
	$rt_image_gallery_globals["column_count"] = rtframework_column_count( $rt_image_gallery_globals["list_layout"] ); 
	//id attr
	$id_attr = ! empty( $id ) ? 'id="'.$id.'"' : "";

	//content
	$content = do_shortcode($content);

	//output
	$output = sprintf('	 
		<div %1$s class="photo_gallery rt_lightbox_gallery %2$s">
			%3$s
		</div>
	', $id_attr, $class, $content );

	return $output;
	}
}

if( ! function_exists("rt_gal_item") ){
	/**
	 * Image Gallery - Single Image Shortcode
	 * 
	 * @param  array $atts
	 * @param  string $content
	 * @return html
	 */												
	function rt_gal_item( $atts, $content = null ) {	
	global $rt_image_gallery_globals;

	//defaults
	extract(shortcode_atts(array(  
		"id"              => '',
		"class"           => '',			
		"image_id"        => '',
		"image_url"       => '', 
		"custom_link"     => '',
		"title"           => '',
		"action"          => 'lightbox',
		"link_target"     => '_self'
	), $atts));

	//variables
	$output = $caption_output = $lightbox_link = $image_effect = ""; 


	// Thumbnail width & height
	$w = rtframework_get_min_resize_size( $rt_image_gallery_globals["list_layout"] );
	$h = $rt_image_gallery_globals["crop"] == "true" ? $w : 10000;	

	// Get image data
	$image_args = array( 
		"image_url" => $image_url,
		"image_id" => $image_id,
		"w"=> $w,
		"h"=> $h,
		"crop" => $rt_image_gallery_globals["crop"],
	);

	$image_output = rtframework_get_image_data( $image_args );   

	//tooltip
	$tooltip =  $rt_image_gallery_globals["tooltips"] == "true" ? ' data-placement="top" data-toggle="tooltip" data-original-title="'. $title .'"' : "";

	//frame
	$frame =  $rt_image_gallery_globals["frames"] == "true" ? ' rt-frame' : "";

	//create lightbox link
	if( $action == "lightbox" ){

		$image = rtframework_create_lightbox_link(
			array(
				'class' => 'imgeffect zoom',
				'href' => $image_output["image_url"],
				'title' => $title,
				'data_group' => $rt_image_gallery_globals["gallery_id"] ,
				'data_title' => $title,
				'data_description' => "",
				'tooltip' => $rt_image_gallery_globals["tooltips"],
				'data_thumbnail' => $image_output["lightbox_thumbnail"],
				'inner_content' => '<img src="'.$image_output["thumbnail_url"].'" alt="'.$title.'" class="img-responsive'.$frame.'">',
				'echo' => false,
			)
		);

	}elseif( $action == "custom_link" ){

		$image = sprintf('
			<a href="%1$s" title="%2$s" target="%3$s" class="link icon imgeffect">
				<img src="%4$s" class="img-responsive%6$s" alt="%2$s"%5$s>
			</a>',
			$custom_link, $title, $link_target, $image_output["thumbnail_url"], $tooltip, $frame  );

	}else{

		$image = sprintf('<img src="%s" class="img-responsive%s" alt="%s"%s> ', $image_output["thumbnail_url"], $frame, $title, $tooltip);
	}
  

	//create caption
	$caption_output = ! empty( $content ) ? '<div class="caption">' .rt_visual_composer_content_fix($content,"true"). '</div>' : "" ;


	//open holder
	if( $rt_image_gallery_globals["counter"] % $rt_image_gallery_globals["column_count"] == 1 || $rt_image_gallery_globals["column_count"] == 1 ){
		$output .= '<div class="row">';
	}

	//id attr
	$id_attr = ! empty( $id ) ? 'id="'.$id.'"' : "";

	//list items output
	$output .= sprintf('
		<div %1$s class="col %3$s %2$s"> 		
 			<div class="gallery-image-wrapper">%4$s</div>
 			%5$s
		</div>
	', $id_attr, $class, rtframework_column_class( $rt_image_gallery_globals["list_layout"] ), $image, $caption_output );
	
	//close holder 
	if( $rt_image_gallery_globals["counter"] % $rt_image_gallery_globals["column_count"] == 0 || $rt_image_gallery_globals["item_count"] == $rt_image_gallery_globals["counter"] ){
		$output .= '</div>';
	}

	//increase counter
	$rt_image_gallery_globals["counter"]++;

	return $output;
	}	
}

add_shortcode('rt_image_gallery', 'rt_image_gallery');
add_shortcode('rt_gal_item', 'rt_gal_item');