<?php
#-----------------------------------------
#	RT-Theme wpml_functions.php 
#-----------------------------------------


if( ! function_exists("rtframework_wpml_get_current_language") ){
	/**
	 * rtframework_wpml_get_current_language
	 * @return string language
	 */
	function rtframework_wpml_get_current_language(){
		return apply_filters( 'wpml_current_language', NULL );
	}
}


#
# WPML match page id 
# returns the page of default language
# @returns $id 
#
if( ! function_exists("rtframework_wpml_page_id") ){
	function rtframework_wpml_page_id($id){	 
		$default_language = apply_filters( 'wpml_default_language', null );
		return apply_filters( 'wpml_object_id', $id, 'page', true, $default_language);
	}
}

#
# WPML match page id 
# returns the current language version of the page
# @returns $id 
#
if( ! function_exists("rtframework_wpml_translated_page_id") ){
	function rtframework_wpml_translated_page_id($id){	 
		return apply_filters( 'wpml_object_id', $id, 'page' );
	}
}


#
# WPML match post id
# return the id's translated version
#
if( ! function_exists("rtframework_wpml_post_id") ){
	function rtframework_wpml_post_id( $id = "", $post_type = "post"){
		return apply_filters( 'wpml_object_id', $id, $post_type, true);
	}
}

#
# WPML match category id
#
if( ! function_exists("rtframework_wpml_category_id") ){
	function rtframework_wpml_category_id($id){
		$default_language = apply_filters( 'wpml_default_language', null );
		return apply_filters( 'wpml_object_id', $id, 'category', true, $default_language);
	}
}

#
# WPML match portfolio category id
#
if( ! function_exists("rtframework_wpml_portfolio_category_id") ){
	function rtframework_wpml_portfolio_category_id($id){
		$default_language = apply_filters( 'wpml_default_language', null );
		return apply_filters( 'wpml_object_id', $id, 'portfolio_categories', true, $default_language);
	}
}


#
# WPML match categories
#
if( ! function_exists("rtframework_wpml_lang_object_ids") ){
	function rtframework_wpml_lang_object_ids($ids_array = array(), $type = "", $language = "") {
		if(function_exists('icl_object_id')) {
			global $sitepress;
			 
			if( empty( $language ) ){
				$language = apply_filters( 'wpml_default_language', null );
			}

			//if provided ids is an array
			if( is_array( $ids_array ) ){
				$res = array();
				foreach ($ids_array as $id) {
					$xlat = apply_filters( 'wpml_object_id', $id, $type, false, $language);
					if(!is_null($xlat)) $res[] = $xlat;
				}
				return $res;				
			}else{

				$res = array();
				$ids_array = explode(",", $ids_array); 

				foreach ($ids_array as $id) {
					$xlat = apply_filters( 'wpml_object_id', $id, $type, false, $language);
					if(!is_null($xlat)) $res[] = $xlat;
				}

				return implode($res, ",");				
			}

		} else {
			return $ids_array;
		}
	}
}

#
# Get WPML Plugin Flags
#
if( ! function_exists("rtframework_wpml_languages_list") ){
	function rtframework_wpml_languages_list( $flags = true ){

		if( ! function_exists('icl_get_languages')) {
			return;
		}
				
	    $languages = icl_get_languages('skip_missing=0'); 

		if(!empty($languages)){
			
				echo '<ul class="naturalife-flags">';
				foreach($languages as $l){

					echo '<li>';
					if($l['country_flag_url']){
						if($flags){
							echo '<img src="'.$l['country_flag_url'].'" height="12" alt="'.$l['native_name'].'" width="18" />';	
						}
						echo '<a href="'.$l['url'].'" title="'.$l['native_name'].'"><span>'.$l['native_name'].'</span></a>';
					}
					echo '</li>';
				}
			echo '</ul>';
		}

	}
}


#
# Get WPML Plugin Flags
#
if( ! function_exists("rtframework_wpml_languages_custom_flags") ){
	function rtframework_wpml_languages_custom_flags(){

		if( ! function_exists('icl_get_languages')) {
			return;
		}

	    $languages = icl_get_languages('skip_missing=0');  
		if(!empty($languages)){
			
				echo '<ul>'."\n";
				foreach($languages as $l){

					$code = isset( $l['language_code'] ) ? $l['language_code'] : "";
					$code = isset( $l['code'] ) ? $l['code'] : $code;

					if( ! strpos($l['country_flag_url'], "sitepress-multilingual-cms") || ! file_exists(get_template_directory()."/images/flags/".$code.".png") ){
						$img_url = $l['country_flag_url'];
					}else{
						$img_url =  get_template_directory_uri()."/images/flags/".$code.".png";						
					}
					
					echo '<li>'."\n";
					if($l['country_flag_url']){
						echo "\t".'<a href="'.$l['url'].'" title="'.$l['native_name'].'"><span class="rt-flag" style="background-image:url('.esc_url($img_url).')"></span><span lang="'. $l['default_locale']. '">'.$l['native_name'].'</span></a>'."\n";
					}
					echo '</li>'."\n";
				}
			echo '</ul>'."\n";
		}

	}
}


#
#	WPML Home URL
#
if( ! function_exists("rtframework_wpml_get_home_url") ){
	function rtframework_wpml_get_home_url(){
		$home_url = apply_filters( 'wpml_home_url', home_url() );
		return rtrim( $home_url, '/') . '/';		
	}
}

#
#	WPML String Register
#
if( ! function_exists("rtframework_wpml_register_string") ){
	function rtframework_wpml_register_string($context, $name, $value){
		if ( trim( $value ) ){
			do_action( 'wpml_register_single_string', $context, $name, $value );
		}  
	}
}

#
#	WPML Get Registered String

if( ! function_exists("rtframework_wpml_t") ){
	/**
	 * Get string translation of a theme mod value
	 * @return string 
	 */
	function rtframework_wpml_t($name="", $field="", $value=""){
		if(function_exists('icl_translate')) {			
			return apply_filters( 'wpml_translate_single_string', $value, $field, $name );
		}

		return $value;
	}
}
?>