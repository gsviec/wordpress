<?php
if( ! function_exists("rt_dividers") ){
	/**
	 * Divider
	 * @param  array $atts
	 * @param  string $content
	 * @return html $divider
	 */
	function rt_dividers( $atts, $content = null ) {		
 
 	//defaults
	extract(shortcode_atts(array(
		"id"            => '',
		"class"         => '',		
		"style"         => 'style-5',
		"margins"       => '',
		"color"         => "",
		"border_width"  => "",
		"width"         => "",
		"height"        => "", 
		"color_type"    => "",
	), $atts));

	//id attr
	$id_attr = ! empty( $id ) ? 'id="'.sanitize_html_class($id).'"' : "";


	//custom css
	$css = $style_output = "";
	
	$css .= $color != "" ? "background-color:".$color."!important;" : "";		 	 
	$css .= $height != "" ? "height:".rtframework_check_unit($height)."!important;" : "";
	$css .= $width != "" ? "width:".rtframework_check_unit($width)."!important;" : ""; 

	//margins
	$margins = strpos( $margins, "," ) !== false ? explode(",", $margins) : "";

	if(is_array( $margins ) ){
		$css .= $margins[0] != "" ? 'margin-top:'.rtframework_check_unit( $margins[0] ).';': "";
		$css .= $margins[1] != "" ? 'margin-bottom:'.rtframework_check_unit( $margins[1] ).';': "";
		$css .= $margins[2] != "" ? 'margin-left:'.rtframework_check_unit( $margins[2] ).';': "";
		$css .= $margins[3] != "" ? 'margin-right:'.rtframework_check_unit( $margins[3] ).';': "";	
	}

	//class names
	$classes[] = "rt_divider";
	$classes[] = $class;
	$classes[] = $style; 
	$classes[] = $color_type == "primary" ? "primary-bg-color" : "";

	$class_attr = 'class="'.implode(" ", array_filter($classes)).'"';

	$style_output = ! empty( $css ) ? ' style="'.$css.'"' : "";	
 

	//output
	$divider = sprintf('<div %1$s %2$s%3$s></div>', $id_attr, $class_attr, $style_output);

	return $divider;

	}
}

add_shortcode('rt_divider', 'rt_dividers');