<?php
if( ! function_exists("rt_info_box") ){
	/**
	 * Info Box Shortcode
	 * @param  array $atts
	 * @param  string $content
	 * @return html $output
	 */
	function rt_info_box( $atts, $content = null ) {

	//defaults
	extract(shortcode_atts(array(
		"style"  => 'info', //announcement, ok, attention, info 
		'id' => '',	
		'class' => '',	
	), $atts));

	//icons
	$icons = array(
				"announcement"=>"ui-icon-megaphone",
				"ok"=>"ui-icon-ok",
				"attention"=>"ui-icon-attention",
				"info"=>"ui-icon-info-circled" 
			);

	//id attr
	$id = ! empty( $id ) ? 'id="'.sanitize_html_class($id).'"' : "";	 

	//style
	$class .= $style;

	//extra class
	$class .= " ".sanitize_html_class($class);

	//output
	$output = sprintf('
		<div '.$id.' class="info_box margin-b20 %s" data-rt-animate="animate" data-rt-animation-type="fadeInDown" data-rt-animation-group="single">
			<span class="icon-cancel"></span>
			<p class="%s">
				%s
			</p>
		</div>
	',trim($class),$icons[$style], $content ); 

	return $output;
	}
}

add_shortcode('info_box', 'rt_info_box');