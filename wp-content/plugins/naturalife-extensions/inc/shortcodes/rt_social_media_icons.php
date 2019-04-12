<?php
if( ! function_exists("rt_social_media") ){
	/**
	 * Social Media Icons Shortcode
	 * 
	 * @global class $rttheme 
	 * 
	 * @param  array $atts
	 * @param  string $content
	 * @return string $output
	 */
	function rt_social_media( $atts=array(), $content = null ) {
 
		//defaults
		extract(shortcode_atts(array(
			"id"        => '',
			"class"     => '',
			"multiline" => 'false',
			"timeout"   => 3000,//ms
		), $atts));


		global $rtframework_social_media_icons;

		ksort($rtframework_social_media_icons); 

		//id attr
		$id_attr = ! empty( $id ) ? 'id="'.sanitize_html_class($id).'"' : "";	 

		//class
		$class_names = array();
		$class_names[] = 'social_media';		
		$class_names[] = rtframework_convert_bool( $multiline ) == "false" ? 'inline-list' : 'multiline-list';		
		$class_names[] = $class;


		$social_media_output ='';			
		$target = "";					
		foreach ($rtframework_social_media_icons as $key => $value){			

			//skype
			if( $value == "skype" ){
				$skype_link = explode("?",  get_theme_mod( RT_THEMESLUG.'_'.$value ) );
				$link = is_array( $skype_link ) && ! empty( $skype_link ) ? $skype_link[0] : "";
				$link .= is_array( $skype_link ) && isset( $skype_link[1] ) ? '?'.$skype_link[1] : "";
			}else{
				$link = esc_attr( get_theme_mod( RT_THEMESLUG.'_'.$value ));
			}
			
			$followText = esc_attr(get_theme_mod( RT_THEMESLUG.'_'.$value.'_text' ));
			$target     = esc_attr(get_theme_mod( RT_THEMESLUG.'_'.$value.'_target' ));
			$target     = empty( $target ) ? "_self" : $target;

			if($value=="mail"){//e-mail icon link   
				if(strpos($link, "@")){
					$link = 'mailto:'.str_replace("mailto:", "", $link);  
				}else{
					$link = str_replace("mailto:", "", $link);				
				}  

			}else{
				$link = $link; 
			} 


			//all icons
			if($link){
				$social_media_output .= '<li class="'.$value.'">';
				$social_media_output .= '<a class="ui-icon-'.$value.'" target="'.$target.'" href="'. $link .'" title="'. esc_attr( $key ) .'">';
				
				if( rtframework_convert_bool( $multiline ) == "false" ){
					$social_media_output .= sprintf('<span>%s</span>', ! empty( $followText ) ? esc_attr( $followText ) : esc_attr( $key ) );
				}else{
					$social_media_output .= ! empty( $followText ) ? esc_attr( $followText ) : esc_attr( $key );
				}

				$social_media_output .= '</a>';
				$social_media_output .= '</li>';
			}
		}



		if($social_media_output){
			return  '<ul class="'.implode(" ", array_filter($class_names) ).'">'.$social_media_output.'</ul>';
		}
		
	}
}

add_shortcode('rt_social_media_icons', 'rt_social_media');