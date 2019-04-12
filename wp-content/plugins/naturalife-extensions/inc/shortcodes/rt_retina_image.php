<?php
if( ! function_exists("rt_retina_image") ){
	/**
	 * Content Box With Image
	 * @param  array $atts
	 * @param  string $content
	 * @return html $output
	 */
	function rt_retina_image( $atts, $content = null ) {

		//defaults
		extract(shortcode_atts(array(  
			"id" => "",
			"class" => "",		
			"img_align" => "left",
			"img_bottom_margin" => "",
			"img_top_margin" => "",
			"img_left_margin" => "",
			"img_right_margin" => "",
			"link" => "",
			"link_target" => "",
			"link_title" => "",
			"img" => "",
			"auto_resize" => "",
			"img_1x" => "",
		), $atts));

		$img_output = "";

		//classes
		$classes = array();

		//id attr
		$id_attr = ! empty( $id ) ? ' id="'.sanitize_html_class($id).'"' : "";	 

		//classes
		$classes[] .= 'retina-image';
		$classes[] .= $class;
		$classes[] .= ! empty($img_align) ? 'align'.$img_align : "";

		//featured image output
		if( ! empty( $img ) ){
	 	

	 		//2x image
			$image_alternative_text = get_post_meta($img, '_wp_attachment_image_alt', true); 			
			$image =  wp_get_attachment_image_src($img,"full"); 
			$image_url = is_array( $image ) ? $image[0] : "";

			//1x image 
			if( ! empty( $img_1x ) ){					
					$standard_image =  wp_get_attachment_image_src($img_1x,"full"); 			
					
					if( is_array( $standard_image ) ){
						$standard_image["url"] = $standard_image[0];
						$standard_image["width"] = $standard_image[1];
						$standard_image["height"] = $standard_image[2];						
					}else{
						$standard_image["url"] = "";
						$standard_image["width"] = "";
						$standard_image["height"] = "";												
					}

			}else{
				$standard_image = rtframework_resize( $img, '', $image[1] / 2, $image[2] / 2, false );		
			}


			if( ! empty( $image_url ) ){ 

				//margins
				$img_css  = ! empty($img_bottom_margin) ? 'margin-bottom:'.rtframework_check_unit($img_bottom_margin ).';' : ""; 
				$img_css .= ! empty($img_top_margin) ? 'margin-top:'.rtframework_check_unit($img_top_margin ).';' : ""; 
				$img_css .= ! empty($img_left_margin) ? 'margin-left:'.rtframework_check_unit($img_left_margin ).';' : ""; 
				$img_css .= ! empty($img_right_margin) ? 'margin-right:'.rtframework_check_unit($img_right_margin ).';' : ""; 
				$img_css  = ! empty($img_css) ? ' style="'.$img_css.'"' : ""; //final

				//create img src			
				$img_output = sprintf('<img class="%s" src="%s" width="%s" height="%s" alt="%s"%s%s />',
					implode(" ", array_filter($classes, 'strlen')),
					$standard_image["url"],
					$standard_image["width"],
					$standard_image["height"],
					$image_alternative_text,
					' srcset="'.$image_url.' 1.3x"',
					$img_css
				 );

				//add links to the image
				$img_output =  ! empty( $link ) ? '<a href="'.$link.'" title="'.$link_title.'" target="'.$link_target.'">'.$img_output.'</a>' : $img_output;		

			} 

		} 

		return $img_output;

	}
}
 
add_shortcode('rt_retina_image', 'rt_retina_image');