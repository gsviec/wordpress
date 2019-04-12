<?php
if( ! function_exists("rt_timeline") ){
	/**
	 * Timeline Holder Shortcode
	 * 
	 * @param  array $atts
	 * @param  string $content
	 * @return html $holder_output
	 */		
	function rt_timeline( $atts, $content = null ) { 

	extract(shortcode_atts(array(  
		"id" => '',
		"class" => '',			
		"style" => '' 
	), $atts));

	$holder_output = "";
 
	//fix shortcode
	$content = do_shortcode($content); 

	//id attr
	$id_attr = ! empty( $id ) ? 'id="'.$id.'"' : "";

	$holder_output = sprintf('	 
		<div %1$s class="timeline %2$s %3$s">
		%4$s
		</div>
	', $id_attr, $style, $class, $content );

	return $holder_output;

	}
}

if( ! function_exists("rt_tl_event") ){
	/**
	 * Timeline Single Event Shortcode
	 * 
	 * @param  array $atts
	 * @param  string $content
	 * @return html $holder_output
	 */		
	function rt_tl_event( $atts, $content = null ) {

 	extract(shortcode_atts(array(  
		"id" => '',
		"class" => '', 
		"day" => '',
		"month" => '',
		"year" => '',
		"title" => ''
	), $atts));	

	//content
	$content = rt_visual_composer_content_fix(do_shortcode($content));

	//title
	$title_output = ! empty( $title ) ? '<h4 class="event-title">'.$title.'</h4>' : "";

 	//output
	$date_output = sprintf('	 
		<span class="event-date">
			%1$s%2$s%3$s
		</span>
	', 
	! empty( $day ) ? '<span class="day">'.$day.'</span>':"",
	! empty( $month ) ? '<span class="month">'.$month.'</span>':"",
	! empty( $year ) ? '<span class="year">'.$year.'</span>':"" 
	);

	//id attr
	$id_attr = ! empty( $id ) ? 'id="'.$id.'"' : "";

	//class attr
	$class_attr = ! empty( $class ) ? 'class="'.$class.'"' : "";

	//output
	$output = sprintf('	 
		<div %1$s %2$s>
		%3$s<div class="event-details">%4$s%5$s</div>
		</div>
	', $id_attr, $class_attr, $date_output, $title_output, $content );

	return $output;
	}
}

add_shortcode('rt_timeline', 'rt_timeline');
add_shortcode('rt_tl_event', 'rt_tl_event');