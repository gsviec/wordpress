<?php
/**
 * Portfolio Grid Gallery
 */
$single_post_values = rtframework_get_global_value("rtframework_single_post_values");


if( ! empty( $single_post_values["gallery_images"] ) ){

		echo rtframework_create_photo_gallery( 
			apply_filters("single-portfolio-grid-gallery-atts", array( 
				"image_ids"              => $single_post_values["gallery_images"], 
				"item_width"             => $single_post_values["portfolio_options"]["grid_layout"], 
				'resize'                 => rtframework_convert_bool($single_post_values["portfolio_options"]["resize"]),
				'w'                      => $single_post_values["portfolio_options"]["portfolio_image_width"], 
				'h'                      => $single_post_values["portfolio_options"]["portfolio_image_height"], 
				'crop'                   => rtframework_convert_bool($single_post_values["portfolio_options"]["image_crop"]), 
				'itemprop'               => "false", 
				'links'                  => rtframework_convert_bool($single_post_values["portfolio_options"]["lightbox"]) == "true" ? "lightbox" : "",
				'captions'               => rtframework_convert_bool($single_post_values["portfolio_options"]["captions"]),
				'exclude_featured_image' => rtframework_convert_bool($single_post_values["portfolio_options"]["exclude_featured_image"]),
				'nogaps'                 => rtframework_convert_bool($single_post_values["portfolio_options"]["nogaps"]),
				"image_size"             => rtframework_convert_bool($single_post_values["portfolio_options"]["resize"]) == "true" ? "Custom" : ""
			))
		);

} 