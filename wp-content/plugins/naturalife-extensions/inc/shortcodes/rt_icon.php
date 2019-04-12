<?php
if( ! function_exists("rt_icon_function") ){
	/**
	 * Heading Shortcode
	 * 
	 * @param  array $atts
	 * @param  string $content
	 * @return html $heading_output
	 */	
	function rt_icon_function( $atts, $content = null ) {

	//defaults
	extract(shortcode_atts(array(
		"id"               => '',
		"class"            => '',
		"icon_name"        => '',
		"align"            => '', 
		"color_type"       => '',
		"color"            => '',
		"background_color" => '',
		"font_size"        => '',
		"margin_top"       => '',
		"margin_bottom"    => '',
		"margin_left"      => '',
		"margin_right"     => '',
		"padding_top"      => '',
		"padding_bottom"   => '',
		"padding_left"     => '',
		"padding_right"    => '',
		"border_width"     => '',		
		"border_color"     => '',
		"border_radius"    => '',
	), $atts));

	$css = "";

	//id attr
	$id = ! empty( $id ) ? ' id="'.sanitize_html_class($id).'"' : "";	

	//align
	$class .= ! empty( $align ) ? ' align'.$align : "";	 

	//custom font size
	$css .= ! empty( $font_size ) ? "font-size:".rtframework_check_unit($font_size).";" : "";

	//custom background color
	$css .= ! empty( $background_color ) ? "background-color:{$background_color};" : "";	

	//primary font color
	$class .= $color_type == "primary" ? ' primary-color' : "";

	//custom font color
	$css .= ! empty( $color ) ? "color:{$color};" : "";

	//border size
	$css .= $border_width != "" ? 'border-width:'.rtframework_check_unit( $border_width ).';': "";

	//border radius
	$css .= $border_radius != "" ? 'border-radius:'.rtframework_check_unit( $border_radius ).';': "";

	//border color
	$css .= $border_color != "" ? 'border-color:'.$border_color.';': "";


	//margins
	$css .= $margin_top != "" ? 'margin-top:'.rtframework_check_unit( $margin_top ).';': "";
	$css .= $margin_bottom != "" ? 'margin-bottom:'.rtframework_check_unit( $margin_bottom ).';': "";
	$css .= $margin_left != "" ? 'margin-left:'.rtframework_check_unit( $margin_left ).';': "";
	$css .= $margin_right != "" ? 'margin-right:'.rtframework_check_unit( $margin_right ).';': "";	

	//paddings
	$css .= $padding_top != "" ? 'padding-top:'.rtframework_check_unit( $padding_top ).';': "";
	$css .= $padding_bottom != "" ? 'padding-bottom:'.rtframework_check_unit( $padding_bottom ).';': "";
	$css .= $padding_left != "" ? 'padding-left:'.rtframework_check_unit( $padding_left ).';': "";
	$css .= $padding_right != "" ? 'padding-right:'.rtframework_check_unit( $padding_right ).';': "";	

	//style output
	$css = ! empty( $css ) ? ' style="'.$css.'"' : ""; 
	
	//output
	$output = sprintf(
					'<span%1$s class="naturalife-icon %4$s %2$s"%3$s></span>',
						$id,
						$class,
						$css,
						$icon_name
					);

	return $output; 

	}
}

add_shortcode('rt_icon', 'rt_icon_function'); 