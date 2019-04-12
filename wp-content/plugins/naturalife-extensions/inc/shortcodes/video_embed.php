<?php
if( ! function_exists("rt_video_embed") ){
	/**
	 * Responsive Video Embed
	 * returns html ouput of posts for carousel
	 * 
	 * @param  array   $atts   
	 * @return output 
	 */

	function rt_video_embed( $atts, $content = null ) {
	global $wp_embed;

	$video = "";
		//external videos
		if ($content){
			$video .= $wp_embed->run_shortcode('[embed]' . esc_url($content) . '[/embed]');
		} 
		
		ob_start();
		echo do_shortcode( $video );
		$output = ob_get_contents();
		ob_end_clean();

	return $output;

	}
}

add_shortcode('rt_embed', 'rt_video_embed'); 	
