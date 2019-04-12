<?php
if( ! function_exists("rt_blog_shortcode") ){
	/**
	 * Blog Posts
	 * @param  array $atts 
	 * @param  string $content
	 * @return output
	 */
	function rt_blog_shortcode( $atts = array(), $content = null ) { 

		ob_start();
		do_action( "rtframework_blog_post_loop", array(), $atts);
		$output_string = ob_get_contents();
		ob_end_clean(); 

		return $output_string;		
	}
}

add_shortcode('blog_box', 'rt_blog_shortcode'); 