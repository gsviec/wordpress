<?php
/**
 * Portfolio Metro Style Gallery
 */
$single_post_values = rtframework_get_global_value("rtframework_single_post_values");


if( ! empty( $single_post_values["gallery_images"] ) ){		

		echo rtframework_create_photo_gallery( 
			apply_filters("single-portfolio-metro-gallery-atts", array( 
				"image_ids"              => $single_post_values["gallery_images"], 
				"layout"                 => $single_post_values["portfolio_options"]["metro_layout"], 
				"layout_style"           => "metro",
				'metro_resize'           => rtframework_convert_bool($single_post_values["portfolio_options"]["metro_resize"]), 
				'itemprop'               => "false", 
				'links'                  => rtframework_convert_bool($single_post_values["portfolio_options"]["lightbox"]) == "true" ? "lightbox" : "",
				'captions'               => rtframework_convert_bool($single_post_values["portfolio_options"]["captions"]),
				'exclude_featured_image' => rtframework_convert_bool($single_post_values["portfolio_options"]["exclude_featured_image"]),
				'nogaps'                 => rtframework_convert_bool($single_post_values["portfolio_options"]["nogaps"])
			))
		);
}