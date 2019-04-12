<?php
if( ! function_exists("rt_shortcode_button") ){
	/**
	 * Buttons Shortcode
	 * 
	 * @param  array $atts
	 * @param  string $content
	 * @return html $button
	 */			
	function rt_shortcode_button( $atts, $content = null ) {		

	//defaults
	extract(shortcode_atts(array(  
		"id"              => '',
		"class"           => '',
		"button_size"     => 'small',
		"button_text"     => '',
		"button_link"     => '',
		"button_icon"     => '',
		"button_align"    => '',
		"link_open"       => '_self', 
		"nofollow"        => '',
		"button_style"    => 'default',
		"href_title"      => '',	 
		"button_rounded"  => '',
		"button_arrow"    => '', 
		"lightbox"        => '',
		"font"            => ""	
	), $atts));

	$button = $css = $wrapper_class = ""; 

	$href_title = ! empty( $href_title ) ? $href_title : $button_text;

	//icon output 
	$icon_output = $button_icon ? '<span class="button-icon '.$button_icon.'"></span>' : ""; 

	//classes
	$class .= " ".$button_style;
	$class .= " ".$button_size;

	//lightbox
	$class .= $lightbox ? " rt_lightbox" : "";

	//id attr
	$id_attr = ! empty( $id ) ? ' id="'.$id.'"' : "";

	//font fammily	
	$class .= ! empty( $font ) ? ' '.$font : "";

	//hero button
	$wrapper_class .= $button_size == "hero" ? " hero" : "";

	//arrow
	$wrapper_class .= ! empty( $button_arrow ) ? " arrow" : "";

	//rounded
	$wrapper_class .= ! empty( $button_rounded ) ? " rounded" : "";

	//button align
	$button_align = ! empty( $button_align ) && $button_size != "hero" ? " align".$button_align : "";

	//link target
	$link_open = ! empty( $link_open ) ? $link_open : "_self";

	$button_text = ! empty( $button_text ) ? '<span>'.$button_text.'</span>' : "";

	//nofollow
	$nofollow = ! empty( $nofollow ) ? ' rel="nofollow"' : "";

	//createa button formats
	if( $button_style != "text" ){

		//button format
		$button_format = '<div class="button_wrapper %8$s"><a%1$s href="%2$s" target="%3$s" title="%4$s" class="button_ %5$s"%9$s%10$s><span>%6$s%7$s</span></a></div>';

		$button = sprintf($button_format, $id_attr, $button_link, $link_open, sanitize_text_field( $href_title ), $class, $icon_output, $button_text, $button_align.$wrapper_class,$css,$nofollow);
	}else{

		//flat text format
		$flat_text_format = '<a%1$s href="%2$s" target="%3$s" title="%4$s" class="%5$s"%7$s%8$s>%6$s</a>';

		$button = sprintf($flat_text_format, $id_attr, $button_link, $link_open, sanitize_text_field( $href_title ), trim("read_more ".$class.$button_align), $button_text,$css,$nofollow);
	}


	return $button;
	}
}

add_shortcode('button', 'rt_shortcode_button');	