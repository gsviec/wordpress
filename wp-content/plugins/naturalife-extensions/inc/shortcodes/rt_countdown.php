<?php
if( ! function_exists("rt_countdown_function") ){
	/**
	 * Countdown Shortcode
	 * 
	 * @param  array $atts
	 * @param  string $content
	 * @return html $output
	 */			
	function rt_countdown_function( $atts, $content = null ) {		

	//defaults
	extract(shortcode_atts(array(  
		"id"     => '',
		"class"  => '',
		"date"   => '',
	), $atts));

	//id attr
	$id_attr = ! empty( $id ) ? 'id="'.$id.'"' : "";

	//class attr
	$class = ! empty( $class ) ? ' '.$class : "";

	//date
	$date = empty( $date ) ? '2028/01/01' : $date;

	//default format
	$content = empty( $content ) ? sprintf(
			'<i><b>%%D</b>%1$s</i> <i><b>%%H</b>%2$s</i> <i><b>%%M</b>%3$s</i> <i><b>%%S</b>%4$s</i>',
			__("DAYS","naturalife"),
			__("HOURS","naturalife"),
			__("MINUTES","naturalife"),
			__("SECONDS","naturalife")
		): $content ;

	//button format
	$output_format = '<div %1$s class="rt-countdown%2$s" data-date="%3$s">%4$s</div>';

	$output = sprintf($output_format, $id, $class, apply_filters("rt_countdown_date",$date), $content );

	return $output;
	}
}

add_shortcode('rt_countdown', 'rt_countdown_function');	