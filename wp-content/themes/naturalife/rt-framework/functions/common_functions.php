<?php
#-----------------------------------------
#	RT-Theme common_functions.php
#	version: 1.1
#-----------------------------------------

#
# Check a file exists in the child theme from path 
# @return file url
#
function rtframework_locate_media_file( $file_path ){
	if ( is_child_theme() ){
		$child_file_path = get_stylesheet_directory() . $file_path ; 

		if ( file_exists( $child_file_path ) ){
			$file_url = get_stylesheet_directory_uri() . $file_path ; 
		}else{
			$file_url = RT_THEMEURI . $file_path ; 
		}
	}else{
		$file_url = RT_THEMEURI . $file_path ; 
	}

	return $file_url;
}
 
#
# returns a post ID from a url
#
function rtframework_get_attachment_id_from_src($image_src) { 
	global $wpdb; 

	$id = $wpdb->get_var( $wpdb->prepare(
		"SELECT ID FROM {$wpdb->posts} WHERE guid = %s",
		$image_src
	));

	return $id; 
}


#
# find vimeo and youtube id from url
#
function rtframework_find_tube_video_id($url){
	$tubeID="";

	$url = esc_url( $url );
	
	if( strpos($url, 'youtube') || strpos($url, 'youtu.be')  ) {	
		$tubeID=parse_url($url);		

		isset( $tubeID['path'] ) && strpos($url, 'http://youtu.be') 
			and $tubeID=str_replace("/", "", $tubeID['path']);	

		isset( $tubeID['query'] ) 
			and parse_str($tubeID['query'], $url_parts);

		isset( $url_parts ) && is_array( $url_parts ) 
			and $tubeID=$url_parts["v"];
	}
	
	if( strpos($url, 'vimeo')  ) {
		$tubeID=parse_url($url, PHP_URL_PATH);			
		$tubeID=str_replace("/", "", $tubeID);	
	}	


	if( is_string( $tubeID ) ) return $tubeID;
}


#
# find orginal image url - clean thumbnail extensions
#

function rtframework_clean_thumbnail_ext($image_src) { 
	$search = '#-\d+x\d+#';  
	return preg_replace($search, "", $image_src);
}

#
# generate shortcode function
#
function rtframework_generate_shortcode($class,$shorcode_name=""){

	$shorcode_name = !empty( $shorcode_name ) ? $shorcode_name : $class->content_type;

	$template_shortcode ='['.$shorcode_name.' ';
	foreach ($class as $key => $value) {
		$template_shortcode  .= $key.'="'.$value.'" ';
	}

	return $template_shortcode.']';	
}

#
# Remove slashes from strings, arrays and objects
#
if( ! function_exists("rtframework_stripslashesFull") ){
	function rtframework_stripslashesFull($input){
		if (is_array($input)) {
			$input = array_map('rtframework_stripslashesFull', $input);
		} elseif (is_object($input)) {
			$vars = get_object_vars($input);
			foreach ($vars as $k=>$v) {
				$input->{$k} = rtframework_stripslashesFull($v);
			}
		} else {
			$input = stripcslashes($input);
		}
		return $input;
	}
}


