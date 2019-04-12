<?php
if( ! function_exists("rt_counter_function") ){
	/**
	 * Counter Shortcode
	 * 
	 * @param  array $atts
	 * @param  string $content
	 * @return html $output
	 */			
	function rt_counter_function( $atts, $content = null ) {		

	//defaults
	extract(shortcode_atts(array(  
		"id"     => '',
		"class"  => '',
		"number" => 0,
		"text" => "",
		"font" => "",
		"font_size" => "",
		"align" => "",
	), $atts));

	//id attr
	$id_attr = ! empty( $id ) ? 'id="'.$id.'"' : "";


	//classes
	$classes = array();
	$classes[] = "rt_counter_wrapper";

	//class 
	$classes[] = $class;

	//align 
	$classes[] = $align;


	//number
	$number = intval($number);

	//custom font size
	$css = ! empty( $font_size ) ? "font-size:".rtframework_check_unit($font_size).";" : "";

	//style output
	$css = ! empty( $css ) ? ' style="'.$css.'"' : "";

	//button format
	$output_format = '<div %1$s class="%2$s"><div class="rt_counter"><span class="number%6$s"%7$s><span>%3$s</span>%4$s</span>%5$s</div></div>';

	$output = sprintf($output_format, $id, implode(" ", array_filter($classes) ), intval($number), $text, sanitize_text_field($content), ! empty( $font ) ? " ".$font : "", $css );

	return $output;
	}
}

add_shortcode('rt_counter', 'rt_counter_function');	