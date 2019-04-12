<?php
/**
 *
 *  Shortcodes for RT Content Slider
 *
 */

if( ! function_exists("rt_slider") ){
	/**
	 * RT Slider Holder
	 * returns html ouput of the content slider
	 *
	 * @param  [array] $atts
	 * @param  [string] $content
	 * @return [string] $output
	 */
	function rt_slider( $atts, $content = null ) {
		global $rt_slider_min_height,$nav_items,$slide_counter,$slider_id,$slide_count,$rt_slider_content_wrapper_width;

		//defaults
		extract(shortcode_atts(array(
			"id"  => 'content-slider-'.rand(100000, 1000000),
			"class" => "",
			"min_height" => 300,
			"mobile_min_height" => 300,
			"tablet_min_height" => 300,
			"autoplay" => true,
			"timeout" => 5000,
			"parallax" => false,
			"fullheight" => false,
			"dots" => "false",
			"nav" => "false",
			"text_nav" => "false",
			"nav_items_" => "",
			"slide_count_" => "",
			"content_wrapper_width" => "default",
		), $atts));

		//id
		$id = !empty( $id ) ? sanitize_html_class( $id ) : 'slider-dynamicID-'.rand(100000, 1000000);

		//min height
		$rt_slider_min_height = (double) $min_height;

		//rt_slider_content_wrapper_width
		$rt_slider_content_wrapper_width = $content_wrapper_width;

		//parallax
		$parallax = $parallax === "true" ? "true" : "false";

		//autoplay
		$autoplay = $autoplay === "true" ? "true" : "false";

		//fullheight
		$fullheight = $fullheight === "true" ? "true" : "false";

		//text_nav
		$text_nav = $text_nav === "true" ? "true" : "false";

		//dots
		$dots = $dots === "true" ? "true" : "false";

		//nav
		$nav = $nav === "true" ? "true" : "false";

		//nav items
		$nav_items = ! empty( $nav_items_ ) ? $nav_items_ : $nav_items;

		//slider id
		$slider_id = $id;

		//slide count
		$slide_count = ! empty( $slide_count_ ) ? $slide_count_ : substr_count($content,'[rt_slide');

		//slide counter
		$slide_counter = 0;

		//get slides
		ob_start();
		echo (do_shortcode($content));
		$get_slides = ob_get_contents();
		ob_end_clean();

		//dots holder
		$dots_holder = ( $dots == "true" ) ? sprintf('
				<div id="%1$s-dots" class="dots-holder">
				</div>
			', $id) : "";

		//create the slider holder
		$output = '<div id="'.$id.'" class="rt-carousel main-carousel carousel-holder clearfix'.trim(" ".$class).'" data-thumbnails="'.$text_nav.'" data-item-width="1" data-mobile-height="'.intval($mobile_min_height).'" data-tablet-height="'.intval($tablet_min_height).'"  style="min-height:'.intval($min_height).'px" data-nav="'.$nav.'" data-dots="'.$dots.'" data-parallax="'.$parallax.'" data-fullheight="'.$fullheight.'" data-timeout="'.$timeout.'" data-autoplay="'.$autoplay.'">'."\n";
		$output .= '<div class="rt-carousel-holder" style="min-height:'.intval($min_height).'px"><div class="owl-carousel">'."\n";
		$output .= $get_slides;
		$output .= '</div></div><div class="rt-carousel-loading"></div>'."\n";
		$output .= $dots_holder."\n";


		$output .= $text_nav == "true" ? sprintf('
					<div class="text-navigation-holder" data-slide-count="'.$slide_count.'">
						<div id="%1$s-thumbnails" class="text-navigation-wrapper">
							%2$s
						</div>
					</div>
				', $id, $nav_items ) : "" ;


			$output .= '</div>'."\n";


		$output = apply_filters( "rtframework_shortcode_output", $output );
		return $output;


 	}
}
add_shortcode('rt_slider', 'rt_slider');


if( ! function_exists("rt_slide") ){
	/**
	 * RT Slide
	 * returns html ouput of a slide
	 *
	 * @param  [array] $atts
	 * @param  [string] $content
	 * @return [string] $output
	 */
	function rt_slide( $atts, $content = null ) {
		global $rt_slider_min_height,$nav_items,$slide_counter,$slider_id, $rt_slider_content_wrapper_width;

		//defaults
		extract(shortcode_atts(array(
			"class" => '',
			"content_width" => 40,
			"content_bg_color" => "", 
			"content_padding" => "", 
			"content_color_schema" => "",
			"content_align" =>  "right",
			"text_align" =>  "left",

			'bg_color_tone' => '',
			'bg_color' => '',
			'bg_image' => '',
			'bg_image_repeat' => '',
			'bg_position' => '',
			'bg_position_mobile' => '',
			'bg_size' => '',
			'background_width' => 'fullwidth',

			'link'=> '',
			'link_target'=> '_self',
			'link_title'=> '',

			"button_text"   => '',
			"button_icon"   => '',
			"button_link"   => '',
			"button_link_target"   => '',
			"button_size"   => 'small',
			"button_style"  => 'style-1',
			"button_href_title" => "",
			"button_arrow" => "",
			"button_rounded" => "",

			"button2_text"  => '',
			"button2_icon"  => '',
			"button2_link"  => '',
			"button2_link_target"   => '',
			"button2_size"  => 'small',
			"button2_style" => 'style-1',
			"button2_href_title" => "",
			"button2_arrow" => "",
			"button2_rounded" => "",

			"heading"   => '',
			"second_heading"   => '',
			"nav_text"  => '',
			"heading_max_font_size"   => '60',
			"heading_min_font_size"   => '40',
			"content_font_size"   => '',

			"mobile_heading_font_size"   => '',
			"mobile_content_font_size"   => '',

			"min_height" => '',
			"content_wrapper_width" => ''
		), $atts));

		$style_output = $content_style_output = $content_class = $content_wrapper_style = $background_output = "";

		//min height
		$min_height = empty( $min_height ) ? $rt_slider_min_height : $min_height;

		//heading output
		$heading_style = "";

		$heading_max_font_size = $heading_max_font_size == "" ? 60 : $heading_max_font_size;
		$heading_min_font_size = $heading_min_font_size == "" ? 40 : $heading_min_font_size;

		$heading_style .= ! empty( $heading_max_font_size ) ? "font-size:".rtframework_check_unit($heading_max_font_size).";" : "";
		$heading_style = ! empty( $heading_style ) ? 'style="'.trim($heading_style).'"' : "";

		$heading_data = "";
		$heading_data .= ! empty( $heading_max_font_size ) ? ' data-maxfont-size="'.str_replace("px","",$heading_max_font_size).'"' : "";
		$heading_data .= ! empty( $heading_min_font_size ) ? ' data-minfont-size="'.str_replace("px","",$heading_min_font_size).'"' : "";

		$mobile_heading_font_size = ! empty( $mobile_heading_font_size ) ? 'data-mobile-value="'.intval($mobile_heading_font_size).'"' : 'data-mobile-value="28"';

		$heading_output =  ! empty( $heading ) ? '<h2 class="slide_heading" '. $heading_style .' '.$mobile_heading_font_size.' '.$heading_data.'>'.$heading.'</h2>' : "";
		$second_heading_output =  ! empty( $second_heading ) ? '<span class="slide_second_heading heading-font">'.$second_heading.'</span>' : "";


		//button 1
		$button_format = '
			[button
				button_size = "'.$button_size.'"
				button_text = "'.$button_text.'"
				button_link = "'.$button_link.'"
				button_icon = "'.$button_icon.'"
				button_style = "'.$button_style.'"
				href_title = "'.$button_text.'"
				link_open = "'.$button_link_target.'" 
				button_arrow = "'.$button_arrow.'" 
				button_rounded = "'.$button_rounded.'" 
				wrapper_class="button-1"
			]
		';

		$button_output =  ! empty( $button_text ) ? do_shortcode($button_format) : "";

		//button 2
		$button2_format = '
			[button
				button_size = "'.$button2_size.'"
				button_text = "'.$button2_text.'"
				button_link = "'.$button2_link.'"
				button_icon = "'.$button2_icon.'"
				button_style = "'.$button2_style.'"
				href_title = "'.$button2_text.'"
				link_open = "'.$button2_link_target.'"
				button_arrow = "'.$button2_arrow.'" 
				button2_rounded = "'.$button2_rounded.'" 
				wrapper_class="button-2"
			]
		';

		$button2_output =  ! empty( $button2_text ) ? do_shortcode($button2_format) : "";

		//buttons output
		$buttons_output =  "";
		if ( ! empty( $button_output ) ||  ! empty( $button2_output ) ){

			$buttons_output = sprintf('
				<div class="slider-buttons-wrapper d-flex align-items-center">
					%1$s%2$s
				</div>
			',$button_output, $button2_output);

		}
	
		//css class
		$class = ! empty( $class ) ? sanitize_html_class( $class ) : "";

		//color schema
		$class .= ! empty( $content_color_schema ) ? " ".sanitize_html_class( $content_color_schema ) : "";

		//bg values
		if( ! empty( $bg_image ) ){

			$bg_image = rtframework_get_attachment_image_src($bg_image);

			//background image
			$background_output  .= 'background-image: url('.$bg_image.');';

			//background repeat
			$background_output  .= ! empty( $bg_image_repeat ) ? 'background-repeat: '.$bg_image_repeat.';': "";

			//background size
			$background_output  .= ! empty( $bg_size ) ? 'background-size: '.$bg_size.';': "";

			//background attachment
			//$style_output  .= ! empty( $bg_attachment ) ? 'background-attachment: '.$bg_attachment.';': "";

			//background position
			$background_output  .= ! empty( $bg_position ) ? 'background-position: '.$bg_position.';': "";
		}

		//background color
		$style_output  .= ! empty( $bg_color ) ? 'background-color: '.$bg_color.';': "";

		//height
		$style_output  .= ! empty( $min_height ) ? 'min-height: '.intval($min_height).'px;': "";

		//wrapper height
		$content_wrapper_style  .= ! empty( $min_height ) ? 'min-height: '.intval($min_height).'px;': "";

		//content width
		$content_style_output  .= ! empty( $content_width ) ? 'width: '.intval($content_width).'%;': "";

		//background color
		$content_style_output  .= ! empty( $content_bg_color ) ? 'background-color: '.$content_bg_color.';': "";

		//content align
		$content_class .= ! empty( $content_align ) ? " {$content_align}":"";

		//content top margin
		$content_style_output  .= $content_align == "center" ? 'left: '.intval((100-intval( $content_width ))/2).'%;': "";

		//content padding
		$content_style_output  .= ! empty( $content_padding ) ? 'padding: '.intval($content_padding).'px;': "";

		//text align
		$content_class .= ! empty( $text_align ) ? " text-{$text_align}":"";

		//slide text font size
		$text_style_output = ! empty( $content_font_size ) ? "font-size:".rtframework_check_unit($content_font_size).";" : "";
		$mobile_content_font_size = $mobile_content_font_size == "" ? 18 : $mobile_content_font_size;

		//get slide content
		ob_start();
		echo do_shortcode(rt_visual_composer_content_fix($content));
		$get_slide_content = ob_get_contents();
		$get_slide_content = ! empty( $get_slide_content ) ? '<div class="slide-text" data-mobile-value="'.intval($mobile_content_font_size).'" style="'.$text_style_output.'">'.$get_slide_content.'</div>' : "";
		ob_end_clean();


		//style outputs
		$style_output = ! empty( $style_output ) ? 'style="'.$style_output.'"' : "";
		$content_style_output = ! empty( $content_style_output ) ? 'style="'.$content_style_output.'"' : "";
		$content_wrapper_style_output = ! empty( $content_wrapper_style ) ? 'style="'.$content_wrapper_style.'"' : "";

		$link_output = ! empty( $link ) ? '<a href="'.esc_url($link).'" target="'.$link_target.'" title="'.sanitize_text_field( $link_title ).'"></a>' : "";


		//slide content output
 		if(empty( $heading_output ) && empty( $get_slide_content ) && empty( $button_output ) && empty( $button2_output )){
 			$slide_content_output = "";
 		}else{
			$slide_content_output = sprintf('
				<div class="slide-content-wrapper %1$s" %7$s>
					<div class="slide-content %2$s" %3$s>
						%4$s
						%5$s
						%6$s 
					</div>
				</div>
			',
			! empty( $content_wrapper_width ) ? $content_wrapper_width : $rt_slider_content_wrapper_width,
			$content_class,
			$content_style_output,
			$second_heading_output.$heading_output,
			$get_slide_content,
			$buttons_output,
			$content_wrapper_style_output
			);
		}

		//text navigation
		$slide_counter++;
		$nav_items .= sprintf('<a class="url" data-href="%s" href="javascript:void(0);"><span>%s</span>%s</a>', $slide_counter -1, "0".$slide_counter, $nav_text);


		return sprintf('
		<div class="item has-bg-image %1$s" %2$s data-color-tone="%5$s">
			%3$s
			%6$s
			<div class="slide-background %8$s" style="%4$s" data-bgpos="%7$s"></div>
		</div>',
		$class,
		$style_output,
		$link_output,
		$background_output,
		$bg_color_tone,
		$slide_content_output,
		$bg_position_mobile,
		$background_width
		);

 	}
}

add_shortcode('rt_slide', 'rt_slide');
