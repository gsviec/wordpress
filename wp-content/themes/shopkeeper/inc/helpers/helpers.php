<?php

// -----------------------------------------------------------------------------
// String to Slug
// -----------------------------------------------------------------------------

if ( ! function_exists( 'getbowtied_string_to_slug' ) ) :
function getbowtied_string_to_slug($str) {
	$str = strtolower(trim($str));
	$str = preg_replace('/[^a-z0-9-]/', '_', $str);
	$str = preg_replace('/-+/', "_", $str);
	return $str;
}
endif;

// -----------------------------------------------------------------------------
// Theme Name
// -----------------------------------------------------------------------------

if ( ! function_exists( 'getbowtied_theme_name' ) ) :
function getbowtied_theme_name() {
	$getbowtied_theme = wp_get_theme();
	return $getbowtied_theme->get('Name');
}
endif;

// -----------------------------------------------------------------------------
// Theme Name
// -----------------------------------------------------------------------------

if ( ! function_exists( 'getbowtied_parent_theme_name' ) ) :
function getbowtied_parent_theme_name()
{
	$theme = wp_get_theme();
	if ($theme->parent()):
		$theme_name = $theme->parent()->get('Name');
	else:
		$theme_name = $theme->get('Name');
	endif;

	return $theme_name;
}
endif;

// -----------------------------------------------------------------------------
// Theme Slug
// -----------------------------------------------------------------------------

if ( ! function_exists( 'getbowtied_theme_slug' ) ) :
function getbowtied_theme_slug() {
	$getbowtied_theme = wp_get_theme();
	return getbowtied_string_to_slug( $getbowtied_theme->get('Name') );
}
endif;


// -----------------------------------------------------------------------------
// Theme Author
// -----------------------------------------------------------------------------

if ( ! function_exists( 'getbowtied_theme_author' ) ) :
function getbowtied_theme_author() {
	$getbowtied_theme = wp_get_theme();
	return $getbowtied_theme->get('Author');
}
endif;

// -----------------------------------------------------------------------------
// Theme Description
// -----------------------------------------------------------------------------

if ( ! function_exists( 'getbowtied_theme_description' ) ) :
function getbowtied_theme_description() {
	$getbowtied_theme = wp_get_theme();
	return $getbowtied_theme->get('Description');
}
endif;


// -----------------------------------------------------------------------------
// Theme Version
// -----------------------------------------------------------------------------

if ( ! function_exists( 'getbowtied_theme_version' ) ) :
function getbowtied_theme_version() {
	$getbowtied_theme = wp_get_theme(get_template());
	return $getbowtied_theme->get('Version');
}
endif;


// -----------------------------------------------------------------------------
// File Contents
// -----------------------------------------------------------------------------

function getbowtied_get_local_file_contents($file_path) {
    
    $url_get_contents_data = false;

	if (function_exists('ob_start') && function_exists('ob_get_clean') && ($url_get_contents_data == false))
    {
        ob_start();
	    include $file_path;
	    $url_get_contents_data = ob_get_clean();
    }

    /*if (function_exists('file_get_contents') && ($url_get_contents_data == false))
    {
        $url_get_contents_data = file_get_contents($file_path);
    }*/

    /*if (function_exists('fopen') && function_exists('stream_get_contents') && ($url_get_contents_data == false))
    {
        $handle = fopen ($file_path, "r");
        $url_get_contents_data = stream_get_contents($handle);
    }*/

    return $url_get_contents_data;
    
}

// -----------------------------------------------------------------------------
// Woocommerce Active
// -----------------------------------------------------------------------------

define( 'GETBOWTIED_WOOCOMMERCE_IS_ACTIVE', 	class_exists( 	'WooCommerce' ) );

// -----------------------------------------------------------------------------
// German Market Active
// -----------------------------------------------------------------------------

define( 'GETBOWTIED_GERMAN_MARKET_IS_ACTIVE', 	class_exists( 	'Woocommerce_German_Market' ) );

// -----------------------------------------------------------------------------
// Woocommerce Germanized Active
// -----------------------------------------------------------------------------

define( 'GETBOWTIED_WOOCOMMERCE_GERMANIZED_IS_ACTIVE', 	class_exists( 	'WooCommerce_Germanized' ) );

// -----------------------------------------------------------------------------
// Dokan Multivendor
// ----------------------------------------------------------------------------

define( 'GETBOWTIED_DOKAN_MULTIVENDOR_IS_ACTIVE', 	class_exists( 	'WeDevs_Dokan' ) );

// -----------------------------------------------------------------------------
// Woocommerce Product Addons
// -----------------------------------------------------------------------------

define( 'GETBOWTIED_WOOCOMMERCE_PRODUCT_ADDONS_IS_ACTIVE', 	class_exists( 	'WC_Product_Addons' ) );

// -----------------------------------------------------------------------------
// Woocommerce Wishlists
// -----------------------------------------------------------------------------

define( 'GETBOWTIED_WOOCOMMERCE_WISHLISTS_IS_ACTIVE', 	class_exists( 	'WC_Wishlists_Plugin' ) );