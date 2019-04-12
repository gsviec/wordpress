<?php
if( ! function_exists("rt_content_image_box") ){
	/**
	 * Content Box With Image
	 * @param  array $atts
	 * @param  string $content
	 * @return html $output
	 */
	function rt_content_image_box( $atts, $content = null ) {

	//defaults
	extract(shortcode_atts(array(  
		"id" => "",
		"class" => "",		
		"heading" => "", 
		"heading_size" => "",
		"heading_bottom_margin" => "",
		"style" => "",
		"box_height" => "",
		"text_align" => "",
		"text_width" => "",
		"img_pos" => "",
		"retina_image" => "",
		"img_align" => "left",
		"img_valign" => "top",
		"img_bottom_margin" => "",
		"img_top_margin" => "",
		"img_left_margin" => "",
		"img_right_margin" => "",
		"text_color" => "",
		"text_bg_color" => "",
		"button_style" => "",
		"link" => "",
		"link_text" => "",
		"link_target" => "",
		"img" => "",
		"img_resize" => "",
		"img_width" => "",
		"img_height" => "",
		"img_crop" => "",
		"mobile_layout" => "true",

		"bg_image" => "",
		"bg_color" => "",
		"button_style" => "",
		"button_size" => "small",
		"padding_top" => "",
		"padding_bottom" => "",
		"padding_left" => "",
		"padding_right" => ""
	), $atts));


	//vars
	$text_color_css = $text_holder_css = $mask_css = $css = $img_output = $image_url = $link_css = "";

	//classes
	$classes = array();

	//id attr
	$id_attr = ! empty( $id ) ? ' id="'.sanitize_html_class($id).'"' : "";	 

	//default classes
	$classes[] .= 'image-content-box';
	$classes[] .= 'content-box';
	$classes[] .= $mobile_layout != "true" ? 'not-responsive' : "";
	$classes[] .= 'box-'.$style;
	$classes[] .= 'valign-'.$img_valign;
	$classes[] .= ! empty( $box_height ) ? "custom-height" : "";

	//text align
	$classes[] .= $text_align;

	//text width
	$text_width = ! empty( $text_width ) && 100 >= intval( $text_width ) ? intval( $text_width ) : "";


	//text styling
	$text_holder_css .= ! empty($text_color) ? 'color:'.$text_color.';' : "";
	$text_holder_css .= ! empty($text_bg_color) ? 'background-color:'.$text_bg_color.';padding:40px;' : "";
	$text_holder_css .= ! empty($text_width) ? 'width:'.$text_width.'%;' : "";
	$text_holder_css = ! empty($text_holder_css) ? ' style="'.$text_holder_css.'"' : ""; //final

	$text_color_css =  ! empty( $text_color ) ? ' style="color:'.$text_color.';"' : "";	

	//heading styling
	$heading_css = ! empty($text_color) ? 'color:'.$text_color.';' : "";
	$heading_css .= ! empty($heading_bottom_margin) ? 'margin-bottom:'.rtframework_check_unit($heading_bottom_margin).';' : "";
	$heading_css = ! empty($heading_css) ? ' style="'.$heading_css.'"' : ""; //final


	//featured image output
	if( ! empty( $img ) ){
 
		$image_alternative_text = get_post_meta($img, '_wp_attachment_image_alt', true); 			
		$image =  wp_get_attachment_image_src($img,"full"); 
		$image_url = is_array( $image ) ? $image[0] : "";

		if( ! empty( $image_url ) ){ 

			if($retina_image == "true"){
				$resize_image = rtframework_resize( $img, '', $image[1] / 2, $image[2] / 2, false );	
			}

			//create img src			
			$img_output = sprintf('<img class="img-responsive %s" src="%s" width="%s" height="%s" alt="%s"%s />',
				$img_align,
				$retina_image == "true" ? $resize_image["url"] : $image_url,  
				$retina_image == "true" ? $resize_image["width"] : $image[1], 
				$retina_image == "true" ? $resize_image["height"] : $image[2],
				$image_alternative_text,
				$retina_image == "true" ? ' srcset="'.$image_url.' 1.3x"' : ""
			 );

			//add links to the featured image
			$img_output =  ! empty( $link ) ? '<a href="'.$link.'" title="'.$link_text.'" target="'.$link_target.'">'.$img_output.'</a>' : $img_output;		

			//img holder css
			$img_margin = ($img_margin = intval($img_left_margin) + intval($img_right_margin)) > 0 ? '- '.rtframework_check_unit($img_margin) : '+ '.rtframework_check_unit($img_margin) ; 

			$img_css = ! empty($text_width) && 100 > intval( $text_width ) ? 'width:calc( '.(100 - $text_width).'% '. $img_margin .' );' : "";

			$img_css .= $img_bottom_margin != "" ? 'margin-bottom:'.rtframework_check_unit($img_bottom_margin ).';' : ""; 
			$img_css .= ! empty($img_top_margin) ? 'margin-top:'.rtframework_check_unit($img_top_margin ).';' : ""; 
			$img_css .= ! empty($img_left_margin) ? 'margin-left:'.rtframework_check_unit($img_left_margin ).';' : ""; 
			$img_css .= ! empty($img_right_margin) ? 'margin-right:'.rtframework_check_unit($img_right_margin ).';' : ""; 

			$img_css = ! empty($img_css) ? ' style="'.$img_css.'"' : ""; //final

			//add holder
			$img_output = '<div class="featured_image_holder"'.$img_css.'>'.$img_output.'</div>';
		} 

	} 

	//box height
	if( $style == "style-2" ){		 		
		$css .= ! empty( $box_height ) ? 'height:'.rtframework_check_unit($box_height).';' : "";
	}else{
		$css .= ! empty( $box_height ) ? 'min-height:'.rtframework_check_unit($box_height).';' : "";
	}

	//styles
	if( $style == "style-2" ){		 		
		$css .= 'background:url('.$image_url.') no-repeat scroll center center / cover;';	
	}

	//styles
	if( $style == "style-1" ){		 

		if( ! empty( $bg_image ) ){
			$bg_image_url =  wp_get_attachment_image_src($bg_image,"full"); 
			$css .= 'background:url('.$bg_image_url[0].') no-repeat scroll center center / cover;';	
		}

		$css .= ! empty( $bg_color ) ? 'background-color:'.$bg_color.';' : "";	
	}

	$css  .= $padding_top != "" ? 'padding-top:'.rtframework_check_unit($padding_top ).';': "";
	$css  .= $padding_bottom != "" ? 'padding-bottom:'.rtframework_check_unit($padding_bottom ).';': "";
	$css  .= $padding_left != "" ? 'padding-left:'.rtframework_check_unit($padding_left ).';': "";
	$css  .= $padding_right != "" ? 'padding-right:'.rtframework_check_unit($padding_right ).';': "";

	//heading
	$heading_output = ! empty( $heading ) ? sprintf('<%1$s class="heading"%3$s>%2$s</%1$s>', $heading_size, $heading, $heading_css ) : "";	
	$heading_output = ! empty( $link ) && ! empty( $heading ) && $style != "style-3" ? sprintf('
	<%1$s class="heading" %6$s>
		<a href="%3$s" title="%4$s" target="%5$s" %6$s>
			%2$s
		</a>
	</%1$s>', $heading_size, $heading, $link, sanitize_text_field($heading), $link_target, $heading_css ) : $heading_output ;	

	//text  
	$text = rt_visual_composer_content_fix(do_shortcode($content));	

	//link target
	$link_target = ! empty( $link_target ) ? $link_target : '_self';

	//link output
	$link_output = "";
	$button_class = "";

	if ( ! empty( $link ) && ! empty( $link_text ) ) {

		if( empty( $button_style ) || $button_style == "text" ){
			$button_class = "read_more";
		}else{
			$button_class = "button_ ".$button_size." ".$button_style;
		}

		if($button_style != "text"){
			$link_output .= '<a class="'.$button_class.'" href="'.$link.'" title="'.$link_text.'" target="'.$link_target.'"><span>'.$link_text.'</span></a>';
		}else{
			$link_output .= '<a class="'.$button_class.'" href="'.$link.'" title="'.$link_text.'" target="'.$link_target.'" '.$text_color_css.'>'.$link_text.'</a>';
		}

	}

	//class attr
	$class = ! empty( $classes ) ? ' class="'.implode(" ", $classes).'"' : "";	 

	//css
	$css = ! empty( $css ) ? ' style="'.$css.'"' : "";	 

	//final output 
	if( $style == "style-1" ){
		//style 1
		$output="";
		$output.= '<article'.$id_attr.$class.''.$css.'>';
		$output.= $img_pos == "before" ? $img_output : "";
		$output.= '<div class="text-holder"'.$text_holder_css.'>'.$heading_output.' '.$text.''.$link_output.'</div>';
		$output.= $img_pos == "after" ? $img_output : "";		
		$output.= '</article>'; 
	}else{
		//style 2
		$output="";
 
		$output.= '
				<article'.$id_attr.''.$class.''.$css.'> 				
					<div class="text-holder"'.$text_holder_css.'>
						'.$heading_output.' '.$text.' '.$link_output.'
					</div>
				</article>
		'; 
	}

	return $output;
	}
}
 
add_shortcode('content_image_box', 'rt_content_image_box');