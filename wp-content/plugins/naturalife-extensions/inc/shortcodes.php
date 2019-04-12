<?php
/**
 * RT-Theme Shortcodes
 *
 * Main file that includes the shortcodes and contains helper functions
 *
 * @author 		RT-Themes
 */

/* Shortcode files to include */
$shortcodes = array(
				"blog_carousel",  
				"video_embed", 
				"divider",
				"testimonials", 
				"testimonial_carousel",
				"contact_form",
				"rt_social_media_icons",
				"rt_social_media_share",
				"rt_get_commnets_template",
				"widget_caller",
				"google_maps",
				"space_box",
				"rt_slider",
				"blog_box",
				"pricing_tables",
				"staff_box",
				"info_box",
				"content_box",
				"content_image_box", 
				"rt_heading",
				"rt_highlight",
				"rt_timeline",
				"rt_tabs",
				"button",
				"rt_accordion",
				"rt_tooltip",
				"rt_image_gallery",
				"rt_image_carousel",
				"pullquote",
				"rt_icon_list",
				"rt_counter",
				"rt_latest_news",
				"rt_quote", 
				"rt_bullet_list", 
				"rt_photo_gallery",
				"rt_split_text",
				"portfolio_box",
				"portfolio_carousel",
				"rt_pie_chart",
				"rt_progress_bar",
				"rt_icon",
				"rt_anim",
				"rt_retina_image",
				"rt_countdown"
			);

//if( ! is_admin() || ( defined( 'DOING_AJAX') && DOING_AJAX ) ){
	foreach ($shortcodes as $shortcode) {
		include(RT_EXTENSIONS_PATH . "inc/shortcodes/{$shortcode}.php");
	}
//}

/*  Use shortcode in widget texts */
add_filter( 'widget_text', 'shortcode_unautop');
add_filter( 'widget_text', 'do_shortcode', 20);


/* Helper Functions */ 
if( ! function_exists("rt_visual_composer_fix") ){
	/**
	 * Visual Composer Content Fix
	 * Corrects the wrong p tags caused by VComposer plugin by using its native function
	 * 
	 * @param  string $content
	 * @return html $content
	 */
	function rt_visual_composer_content_fix( $content = null ) {
		if( function_exists("wpb_js_remove_wpautop") ){		
			$content = wpb_js_remove_wpautop($content,"true");
		}
		
		return $content;
	}
}

if( ! function_exists("rt_content_filter") ){
	/**
	 * Fix Shortcodes
	 * @param  string $content
	 * @return html $rep
	 */
	function rt_content_filter($content) {

	// array of custom shortcodes requiring the fix for extra p tags 
	$shortcodes = array( 
						"rt_slider",
						"rt_slide",
						"rt_tooltip", 
						"rt_icon_list",
						"rt_icon_list_line",
						"rt_tabs",
						"rt_tab",
						"staff_box",
						"rt_pricing_table",
						"rt_table_column",
						"rt_compare_table",
						"rt_compare_table_column",
						"contact_form",
						"icon",
						"info_box",
						"pullquote",
						"banner",
						"button",  
						"google_maps",
						"location",
						"rt_divider",  
						"content_box",
						"content_image_box",	
						"content_icon_box",	
						"rt_heading",
						"rt_highlight",
						"rt_timeline",
						"rt_tl_event",
						"rt_image_gallery",
						"rt_image_carousel",
						"rt_gal_item",
						"rt_chained_contents",
						"rt_chained_content",
						"rt_accordion",
						"rt_accordion_content",
						"rt_horizontal_accordion",
						"rt_ha_content",
						"rt_counter",
						"rt_latest_news",
						"rt_quote", 
						"rt_bullet_list",
						"rt_photo_gallery",
						"rt_split_text",
						"rt_pie_chart",
						"rt_progress_bar",
						"rt_icon",
						"rt_anim",
						"rt_retina_image",
						"rt_countdown",
	);

 
	$block = join("|",$shortcodes);	

	// opening tag
	$rep = preg_replace("/(<p>)?\[($block)(\s[^\]]+)?\](<\/p>|<br \/>)?/","[$2$3]", $content);
	// closing tag
	$rep = preg_replace("/(<p>)?\[\/($block)](<\/p>|<br \/>)?/","[/$2]",$rep);

	return $rep;
	}
}

add_filter("the_content", "rt_content_filter"); 

if( ! function_exists("rt_clean_text") ){
	/**
	 * Cleans p and br tags from a shortcode content that is not allowed for some of the theme's shortcodes
	 * @param  string $content
	 * @return html $rep
	 */
	function rt_clean_text( $content ) {

		$shortcodes = array("rt_heading");
		$block = join("|",$shortcodes);	
		$content = preg_replace_callback("~rt_heading((.|\n)*?)rt_heading~i",function($matches){
				return preg_replace("/<p>|<\/p>|<br>|<br \/>|\n/i","",$matches[0]);
			},$content);
 
		return $content;

	}
}

if( ! function_exists("rt_remove_idle_p") ){
	/**
	 * Remove empty p tags
	 * @param  string $content
	 * @return html $rep
	 */
	function rt_remove_idle_p( $content ) {
		return str_replace("<p></p>", "", $content);
	}
}


add_filter("the_content", "rt_clean_text"); 

?>