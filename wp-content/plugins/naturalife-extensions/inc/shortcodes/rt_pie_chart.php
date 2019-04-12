<?php
if( ! function_exists("rt_pie_chart_function") ){
	/**
	 * Pie Chart Shortcode
	 * 
	 * @param  array $atts
	 * @param  string $content
	 * @return html $output
	 */			
	function rt_pie_chart_function( $atts, $content = null ) {		

	//defaults
	extract(shortcode_atts(array(  
		"id"     => '',
		"class"   => '',
		"percent" => 0,
		"base_color" => "",
		"bar_color" => "",
		"size" => 180,
		"linewidth" => 15,
		"font_size" => "",
		"icon_name" => "",
		"font_color" => ""
	), $atts));

	//id attr
	$id_attr = ! empty( $id ) ? ' id="'.$id.'"' : "";

	//class attr
	$class_attr = ! empty( $class ) ? ' class="'.$class.'"' : "";

	//percent
	$percent = intval($percent);

	//size
	$size = empty($size) ? 180 : str_replace("px", "", $size);

	$span_style = "";

	//font size
	$span_style .= ! empty($font_size) ? 'font-size:'.rtframework_check_unit($font_size).';': "";

	//font color
	$span_style .= ! empty($font_color) ? 'color:'.$font_color.';': "";	

	//custom size
	$span_style .= $size != 180 ? 'line-height:'.$size.'px;width:'.$size.'px;' : "";

	//span inline style
	$span_style = ! empty( $span_style ) ? 'style="'.$span_style.'"' : "";

	//linewidth
	$linewidth = empty($linewidth) ? 15 : str_replace("px", "", $linewidth);

	//bar color
	$bar_color = empty( $bar_color ) ? rtframework_get_setting("default_primary_color") : $bar_color;

	//base color
	$base_color = empty( $base_color ) ? "#eeeeee": $base_color;

	//icon name
	$icon_class = ! empty( $icon_name ) ? "icon ". $icon_name : "percent";


	//button format
	$output_format = '<span%1$s class="rt-pie-chart aligncenter %2$s" data-percent="%3$s" data-basecolor="%4$s" data-barcolor="%5$s" data-wsize="%6$s" data-linewidth="%7$s"><span class="%9$s"%8$s></span></span>';

	$output = sprintf($output_format, $id, $class, $percent, $base_color, $bar_color, $size, $linewidth, $span_style, $icon_class );

	return $output;
	}
}

add_shortcode('rt_pie_chart', 'rt_pie_chart_function');	