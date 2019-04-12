<?php
/*
* ------------------------------------------------- *
*		PRICING TABLES
* ------------------------------------------------- *
*/

//table holder
if( ! function_exists("rt_table_holder") ){
	function rt_table_holder( $atts, $content = null ) {
	// [pricing_table style=""]

	//defaults
	extract(shortcode_atts(array(
		"id" => '',
		"class" => '',
		"style"  => '',
	), $atts));

	$output = '<div id="'.$id.'" class="pricing_table '.$style.' '.$class.'" data-rt-animation-group="group">'; 

	$content = preg_replace('/<br \/>$/', '', trim($content));
	$content = preg_replace('/<br \/>/', '', $content, 1);

	$output .= do_shortcode($content);
	$output .= '</div>';

	return $output;
	}
}

add_shortcode('rt_pricing_table', 'rt_table_holder'); 		
add_shortcode('rt_compare_table', 'rt_table_holder'); 			

//table columns
if( ! function_exists("rt_table_columns") ){
	function rt_table_columns( $atts, $content = null ) {
	//[table_column caption="" price="" info="" style=""]

	//defaults
	extract(shortcode_atts(array(
		"id" => '',
		"class" => '',		
		"style"  => '',
		"caption" => '',
		"price" => '',
		"info" => ''
	), $atts));

	$output = '<div id="'.$id.'" class="table_wrap '.$style.' '.$class.'" data-rt-animate="animate" data-rt-animation-type="fadeInDown"><ul>';	 
	

	$info_output = sprintf('
	<small>
		%s 
	</small>
	',$info);
 
	$output .= ! empty( $caption ) && $style != "features" ? sprintf('
		<li class="caption">
			<div class="title">%s%s</div>
		</li>
		',$caption,$info_output) : '<li class="caption empty"></li>';

	$output .= ! empty( $price ) && $style != "features"  ? sprintf('
		<li class="price">
			<div>
				<span>%s</span>
			</div>
		</li>
		',$price) : '<li class="price empty"></li>';


	$content = preg_replace('/<ul>/', '', $content, 1);

	if( $style != "features" ){
		$content = preg_replace('/<li>/', '<li class="start_position">', $content, 1);
	}else{
		$content = preg_replace('/<li>/', '<li class="features_start_position">', $content, 1);
	}

	$output .= do_shortcode($content);
	$output .= '</div>';

	return $output;
	}
}

add_shortcode('rt_table_column', 'rt_table_columns'); 		
add_shortcode('rt_compare_table_column', 'rt_table_columns'); 		



