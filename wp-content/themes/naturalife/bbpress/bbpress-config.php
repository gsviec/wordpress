<?php

/*
 * Remove the default breadcrumb 
 */
add_filter("bbp_get_breadcrumb",function( $trail, $crumbs, $r ){
	if( ! isset( $r["rtframework"] ) ){
		return false;
	}
	return $trail;
},1000,3);

/*
 * Prevent double container 
 */
add_filter("rtframework_is_composer_allowed",function( $bool ){
	
	if( function_exists("is_bbpress") ){
		if( is_bbpress() ){ 
			return "false";
		}		
	}

	return $bool;
},10);

/*
 * CSS
 */
add_filter("wp_enqueue_scripts",function(){
	wp_register_style('naturalife-bbpress', RT_THEMEURI.'/css/bbpress/bbpress.css','',RT_THEMEVERSION);	
	wp_enqueue_style('naturalife-bbpress');
},10);


/**
 * BBPress Sidebar
 */
add_filter("rtframework_sidebar_position",function( $sidebar ){
	$bbpress_sidebar = rtframework_get_setting("sidebar_bbpress");
	if( is_bbpress() ){ 
		return $bbpress_sidebar;
	}
	return $sidebar;
},10);

