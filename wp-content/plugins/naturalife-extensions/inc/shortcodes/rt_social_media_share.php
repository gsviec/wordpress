<?php

if( ! function_exists("rtframework_social_media_share_shortcode") ){
	/**
	 * Social Media Share Shortcode
	 * 
	 * @global class $post 
	 * 
	 * @param  array $atts
	 * @param  string $content
	 * @return string $output
	 */
	function rtframework_social_media_share_shortcode( $atts = array(), $content = null ) {	 		
	 	if( function_exists( "rtframework_social_media_share" ) ){
	 	 return	rtframework_social_media_share(  $atts = array(), $content = null  );
	 	} 
	}
}

add_shortcode('rt_social_media_share', 'rtframework_social_media_share_shortcode');