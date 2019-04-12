<?php
if( ! function_exists("rt_portfolio_box") ){
	/**
	 * Portfolio Posts	
	 * @param  array $atts 
	 * @param  string $content
	 * @return output
	 */
	function rt_portfolio_box( $atts = array(), $content = null ) { 

		ob_start();
		do_action( "portfolio_post_loop", array(), $atts);
		$output_string = ob_get_contents();
		ob_end_clean(); 

		return $output_string;		
	}
}

add_shortcode('portfolio_box', 'rt_portfolio_box'); 