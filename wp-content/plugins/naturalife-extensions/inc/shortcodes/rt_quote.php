<?php
if( ! function_exists("rt_quote_function") ){
	/**
	 * Heading Shortcode
	 * 
	 * @param  array $atts
	 * @param  string $content
	 * @return html $heading_output
	 */	
	function rt_quote_function( $atts, $content = null ) {

	//defaults
	extract(shortcode_atts(array(
		"id" => '',
		"class" => '',
		"name" => '',
		"position" => '',
		"link" => '',
		"link_title" => '',
		"style" => ''
	), $atts));
 

	//id attr
	$id = ! empty( $id ) ? 'id="'.sanitize_html_class($id).'"' : "";	

	//class attr
	$class = ! empty( $class ) ? ' '.sanitize_html_class($class) : "";

	//style
	$class .= ! empty( $style ) ? ' '.$style : "";	

	//author link
	$link = esc_url( $link );
	$link_output = ! empty( $link ) && ! empty( $link_title ) ? '<a href="'. $link. '" target="_blank" title="'.$link_title.'" class="client_link">'. $link_title. '</a>' : "" ;
	$link_output = ! empty( $link ) &&  empty( $link_title ) ? '<a href="'. $link. '" target="_blank" title="" class="client_link">'. str_replace( "http://","",$link ). '</a>' : $link_output;

	//check p tag
	$content = ! strpos($content, "<p>") ? '<p>'.$content.'</p>' : $content;

	//author name
	$author = ! empty( $name ) ? '<span>'. $name .'</span>' : "" ; 

	//position
	$author .= ! empty( $position ) ? ", ".$position : "";

	//author output
	$author_output = ! empty($author) || ! empty( $link_output ) ? sprintf(
					'<cite class="author_info">
						%1$s %2$s
					</cite>',
					$author, $link_output) : "";

	//output
	$output = sprintf(
					'<blockquote class="rt_quote %2$s" %1$s>
						%3$s%4$s						
					</blockquote>',
					$id, trim($class), $content, $author_output);

	return $output; 

	}
}

add_shortcode('rt_quote', 'rt_quote_function'); 