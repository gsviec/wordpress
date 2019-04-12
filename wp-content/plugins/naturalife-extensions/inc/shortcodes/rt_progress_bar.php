<?php
if( ! function_exists("rt_progress_bar_function") ){
	/**
	 * Progress Bar Shortcode
	 * 
	 * @param  array $atts
	 * @param  string $content
	 * @return html $output
	 */			
	function rt_progress_bar_function( $atts, $content = null ) {		

	//defaults
	extract(shortcode_atts(array(  
		"id"     => '',
		"class"   => '',
		"heading" => '',
		"percent" => 0,
		"base_color" => "",
		"bar_color" => ""
	), $atts));

	//id attr
	$id_attr = ! empty( $id ) ? ' id="'.$id.'"' : "";

	//class attr
	$class_attr = ! empty( $class ) ? ' class="'.$class.'"' : "";

	//percent
	$percent = intval($percent);

	//button format
	$output_format = '
			<div%1$s class="naturalife-progress-bar-holder%2$s" data-percent="%3$s">
				<div class="naturalife-progress-desc">
					%4$s
					<span>0</span>
				</div>
				<div class="naturalife-progress-bar-base"%5$s>
					<div class="naturalife-progress-bar"%6$s></div>
				</div>
			</div>
	';

	$output = sprintf(
		$output_format,
		$id,
		$class,
		$percent,
	 	! empty($heading) ? '<h5 class="naturalife-progress-title">'.$heading.'</h5>' : "",
	  	! empty($base_color) ? ' style="background-color:'.$base_color.'"' : "",
	  	! empty($bar_color) ? ' style="background-color:'.$bar_color.'"' : ""
   );

	return $output;
	}
}

add_shortcode('rt_progress_bar', 'rt_progress_bar_function');	