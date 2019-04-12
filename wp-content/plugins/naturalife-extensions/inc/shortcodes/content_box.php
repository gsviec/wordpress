<?php
if( ! function_exists("rt_content_box") ){
	/**
	 * Content Box With Image
	 * @param  array $atts
	 * @param  string $content
	 * @return html $output
	 */
	function rt_content_box( $atts, $content = null ) {

	//defaults
	extract(shortcode_atts(array(  
		"id" => "",
		"class" => "",		
		"heading" => "", 
		"heading_size" => "",
		"heading_style" => "",
		"h_margin_bottom" => "",
		"punchline" => "",
		"style" => "",
		"width" => "",
		"link" => "",
		"link_text" => "",
		"link_target" => "",
		"button_style" => "",
		"button_icon" => "",
		"button_size" => "small",
 		"button_rounded"  => '',
		"button_arrow"    => ''
	), $atts));


	//classes
	$classes = array();

	//default classes
	$classes[] = 'content-box';
	$classes[] = 'content-box2';



	//with padding
	$classes[] = $heading_style == "style-1" ? 'content-padding' : "";	


	//heading
	$heading_output = rt_heading_function(array( 
		"style"      => $heading_style, 
		"punchline"  => $punchline,
		"size"       => $heading_size,
		"link"       => $link,
		"link_open"  => $link_target,
		"href_title" => $link_text,
		"margin_bottom" => $h_margin_bottom
		),$heading);


	//button
	$button_output = ! empty( $link_text ) && ! empty( $link ) ? rt_shortcode_button(array( 
		"button_size"    => 'small',
		"button_text"    => $link_text,
		"button_link"    => $link,
		"button_icon"    => $button_icon,
		"button_align"   => '',
		"link_open"      => $link_target,
		"button_style"   => $button_style,
		"button_rounded" => $button_rounded,
		"button_arrow"   => $button_arrow,
		"href_title"     => $link_text,
		),$heading) : "";

	//text  
	$text = rt_visual_composer_content_fix(do_shortcode($content));	

	//id attr
	$id_attr = ! empty( $id ) ? ' id="'.sanitize_html_class($id).'"' : "";	 

	//class attr
	$class = ! empty( $classes ) ? ' class="'.trim(implode(" ", $classes)).'"' : "";	 
 

	//final output 
	$output = sprintf('
		<article%1$s%2$s>
		%3$s
		<div class="content-holder">
			%4$s
			%5$s
		</div>
		</article>
		',
		$id_attr,
		$class,
		$heading_output,
		$text,
		$button_output
	);


	return $output;

	}
}
 
add_shortcode('content_box', 'rt_content_box');