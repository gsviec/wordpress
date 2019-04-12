<?php
if( ! function_exists("rt_get_commnets_template") ){

	/**
	 * get commnets template shortcode
	 *
	 * retrives post comments as a string
	 * 
	 * @param  array $atts
	 * @param  string $content
	 * @return string comments 
	 */
	function rt_get_commnets_template( $atts, $content = null ) { 

		ob_start();
		comments_template();
		$output_string = ob_get_contents();
		ob_end_clean();

		return $output_string;
	}

}
add_shortcode('rt_get_commnets_template', 'rt_get_commnets_template'); 