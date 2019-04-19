<?php
// theme textdomain - must be loaded before redux
load_theme_textdomain( 'shopkeeper', get_template_directory() . '/languages' );
define( 'GETBOWTIED_VISUAL_COMPOSER_IS_ACTIVE', defined( 		'WPB_VC_VERSION' ) );

/******************************************************************************/
/***************************** Theme Options **********************************/
/******************************************************************************/

global $shopkeeper_theme_options;

if (!class_exists( 'Kirki')):
	require_once('settings/kirki/kirki.php');
	add_filter( 'kirki/config', 'getbowtied_kirki_update_url' );
	function getbowtied_kirki_update_url( $config ) {
	    $config['url_path'] = get_template_directory_uri() . '/settings/kirki/';
	    return $config;
	}
endif;
require_once('settings/kirki.config.php');


/******************************************************************************/
/******************************** Includes ************************************/
/******************************************************************************/

require_once( get_template_directory() . '/inc/helpers/helpers.php');
require_once( get_template_directory() . '/inc/tgm/class-tgm-plugin-activation.php' );
require_once( get_template_directory() . '/inc/tgm/plugins.php' );
require_once( get_template_directory() . '/inc/admin/wizard/class-gbt-helpers.php' );
require_once( get_template_directory() . '/inc/social-media/social-media-profiles.php' );
require_once( get_template_directory() . '/inc/admin/wizard/class-gbt-install-wizard.php' );
require_once( get_template_directory() . '/inc/demo/ocdi-setup.php');

function remove_getbowtied_tools() {
	if (class_exists( 'GetBowtied_Tools' )):
    ?>
	    <div class="notice notice-warning is-dismissible">
	        <p><?php _e('The <strong>GetBowtied Tools</strong> plugin is no longer required. You can deactivate and delete it. use the <strong>Envato Market</strong> plugin for future updates.', 'shopkeeper');?>
	        <a href="https://shopkeeper.wp-theme.help/hc/en-us/articles/207365285-How-to-update-the-theme-" target="_blank"><?php _e('Read More', 'shopkeeper'); ?> →</a></p>
	    </div>
    <?php
	endif;
}
add_action( 'admin_notices', 'remove_getbowtied_tools' );

/**
 * On theme activation redirect to splash page
 */
global $pagenow;

if ( is_admin() && 'themes.php' == $pagenow && isset( $_GET['activated'] ) ) {

	wp_redirect(admin_url("themes.php?page=gbt-setup")); // Your admin page URL
	
}


//Include Custom Posts
require('inc/custom-posts/portfolio.php');


include('inc/custom-styles/custom-styles.php'); // Load Custom Styles
include('inc/custom-styles/gutenberg-styles.php'); // Load Gutenberg Custom Styles
include('inc/templates/post-meta.php'); // Load Post meta template
include('inc/templates/template-tags.php'); // Load Template Tags
include('inc/widgets/social-media.php'); // Load Widget Social Media

//Include Shortcodes
include('inc/shortcodes/product-categories.php');
include('inc/shortcodes/socials.php');
include('inc/shortcodes/from-the-blog.php');
include('inc/shortcodes/google-map.php');
include('inc/shortcodes/banner.php');
include('inc/shortcodes/icon-box.php');
include('inc/shortcodes/portfolio.php');
include('inc/shortcodes/add-to-cart.php');
include('inc/shortcodes/wc-mod-product.php');
include('inc/shortcodes/slider.php');
include('inc/shortcodes/search-products.php');


//Include Metaboxes
include_once('inc/metaboxes/page.php');
include_once('inc/metaboxes/post.php');
include_once('inc/metaboxes/portfolio.php');
include_once('inc/metaboxes/product.php');


//Custom Menu
include_once('inc/custom-menu/custom-menu.php');


//Quick View
include_once('inc/woocommerce/quick_view.php');

//Product Layout
include_once('inc/woocommerce/product-layout.php');

//portfolio Layout
include_once('inc/custom-posts/portfolio-layout.php');

//Product Search
include_once('inc/woocommerce/product-search.php');

//Social Media
include_once('inc/social-media/social-media.php');

// //Theme welcome page
// if (is_admin() && !defined('ENVATO_HOSTED_SITE')):
// 	include_once('inc/admin/admin.php');
// endif;


// /**
//  * 	Envato Hosted
//  */

// if (defined('ENVATO_HOSTED_SITE')) {
// 	require_once('inc/demo/ocdi-setup.php');
// }

/******************************************************************************/
/*************************** Visual Composer **********************************/
/******************************************************************************/

if (class_exists('WPBakeryVisualComposerAbstract')) {
	
	add_action( 'init', 'visual_composer_stuff' );
	function visual_composer_stuff() {
		
		//disable update
		// Vc_Manager::getInstance()->disableUpdater(true);

		
		//enable vc on post types
		if(function_exists('vc_set_default_editor_post_types')) vc_set_default_editor_post_types( array('post','page','product','portfolio') );
		
		// Modify and remove existing shortcodes from VC
		include_once('inc/shortcodes/visual-composer/custom_vc.php');
		
		// VC Templates
		$vc_templates_dir = get_template_directory() . '/inc/shortcodes/visual-composer/vc_templates/';
		vc_set_shortcodes_templates_dir($vc_templates_dir);
		
		// Add new shortcodes to VC
		include_once('inc/shortcodes/visual-composer/from-the-blog.php');
		include_once('inc/shortcodes/visual-composer/social-media-profiles.php');
		include_once('inc/shortcodes/visual-composer/google-map.php');
		include_once(locate_template('inc/shortcodes/visual-composer/banner.php'));
		include_once('inc/shortcodes/visual-composer/icon-box.php');
		include_once('inc/shortcodes/visual-composer/portfolio.php');
		include_once(locate_template('inc/shortcodes/visual-composer/slider.php'));
		
		// Add new Shop shortcodes to VC
		if (class_exists('WooCommerce')) {
			include_once('inc/shortcodes/visual-composer/wc-product-categories-grid.php');
		}
		
		// Remove vc_teaser
		if (is_admin()) :
			function remove_vc_teaser() {
				remove_meta_box('vc_teaser', '' , 'side');
			}
			add_action( 'admin_head', 'remove_vc_teaser' );
		endif;
	
	}

}

add_action( 'vc_before_init', 'shopkeeper_vcSetAsTheme' );
function shopkeeper_vcSetAsTheme() {
    vc_manager()->disableUpdater(true);
	vc_set_as_theme();
}


/******************************************************************************/
/****************************** Ajax url **************************************/
/******************************************************************************/

add_action('wp_head','shopkeeper_ajaxurl');
function shopkeeper_ajaxurl() {

	$ajax_url = admin_url('admin-ajax.php', 'relative');
	if ( class_exists('SitePress') ) {
		$my_current_lang = apply_filters( 'wpml_current_language', NULL );
		if ( $my_current_lang ) {
		    $ajax_url = add_query_arg( 'wpml_lang', $my_current_lang, $ajax_url );
	}}
?>
    <script type="text/javascript">
        var shopkeeper_ajaxurl = '<?php echo $ajax_url; ?>';
    </script>
<?php
}


//==============================================================================
// Localize dynamic add to cart message
//==============================================================================
add_action('wp_head','shopkeeper_dynamic_added_to_cart_message');
function shopkeeper_dynamic_added_to_cart_message() {
?>
	<script type="text/javascript">
		var addedToCartMessage = "<?php printf( esc_html__( '%s has been added to your cart.', 'woocommerce' ), '' ); ?>";
	</script>
<?php 
}


/******************************************************************************/
/*********************** shopkeeper setup *************************************/
/******************************************************************************/


if ( ! function_exists( 'shopkeeper_setup' ) ) :
function shopkeeper_setup() {
	
	global $shopkeeper_theme_options;

	// frontend presets
	if (isset($_GET["preset"])) { 
		$preset = $_GET["preset"];
	} else {
		$preset = "";
	}

	if ($preset != "") {
		if ( file_exists( dirname( __FILE__ ) . '/_presets/'.$preset.'.json' ) ) {
		$theme_options_json = file_get_contents( dirname( __FILE__ ) . '/_presets/'.$preset.'.json' );
		$shopkeeper_theme_options = json_decode($theme_options_json, true);
		}
	}
	
	/** Theme support **/
	add_theme_support( 'title-tag' );
	add_theme_support( 'menus' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'customize-selective-refresh-widgets' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'woocommerce');
	function custom_header_custom_bg() {
		add_theme_support( 'custom-header' );
		add_theme_support( 'custom-background' );
	}

	// woocommerce gallery
	add_theme_support( 'wc-product-gallery-slider' );

	$shopkeeper_theme_options['product_gallery_zoom'] = getbowtied_theme_option('product_gallery_zoom', 1);
	if( isset($shopkeeper_theme_options['product_gallery_zoom']) && $shopkeeper_theme_options['product_gallery_zoom'] == 1 ) {
		add_theme_support( 'wc-product-gallery-zoom' );
	} else {
		remove_theme_support( 'wc-product-gallery-zoom' );
	}

	add_theme_support( 'woocommerce', array(

	    // Product grid theme settings
	    'product_grid'        => array(
	        'default_rows'    => get_option('woocommerce_catalog_rows', 5),
	        'min_rows'        => 2,
	        'max_rows'        => '',
	        
	        'default_columns' => get_option('woocommerce_catalog_columns', 5),
	        'min_columns'     => 1,
	        'max_columns'     => 6,
	    ),
	) );
	
	
	//==============================================================================
	//	WooCommerce thumb size for product gallery (single) 
	//==============================================================================
	add_filter( 'woocommerce_gallery_thumbnail_size', function( $size ) {
		return 'thumbnail';
	} );	
	
	
	// gutenberg
	add_theme_support( 'align-wide' );
	add_theme_support( 'editor-styles' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'responsive-embeds' );
   	
	add_editor_style( 'css/editor-styles.css' );

	add_post_type_support('page', 'excerpt');
	
	
	/** Add Image Sizes **/
	$shop_catalog_image_size = get_option( 'shop_catalog_image_size' );
	$shop_single_image_size = get_option( 'shop_single_image_size' );
	add_image_size('product_small_thumbnail', (int)$shop_catalog_image_size['width']/3, (int)$shop_catalog_image_size['height']/3, isset($shop_catalog_image_size['crop']) ? true : false); // made from shop_catalog_image_size
	add_image_size('shop_single_small_thumbnail', (int)$shop_single_image_size['width']/3, (int)$shop_single_image_size['height']/3, isset($shop_catalog_image_size['crop']) ? true : false); // made from shop_single_image_size
	add_image_size( 'blog-isotope', 620, 500, true ); 
	
	/** Register menus **/	
	register_nav_menus( array(
		'top-bar-navigation' => __( 'Top Bar Navigation', 'shopkeeper' ),
		'main-navigation' => __( 'Main Navigation', 'shopkeeper' ),
		'footer-navigation' => __( 'Footer Navigation', 'shopkeeper' ),
	) );
}
endif; // shopkeeper_setup
add_action( 'after_setup_theme', 'shopkeeper_setup' );

/******************************************************************************/
/*************************** Ajax Search **************************************/
/******************************************************************************/

if ( ! function_exists( 'getbowtied_ajax_search' ) ) :
	function getbowtied_ajax_search() {

		global $shopkeeper_theme_options;

		$shopkeeper_theme_options['predictive_search'] = getbowtied_theme_option('predictive_search', true);

		if( isset($shopkeeper_theme_options['predictive_search']) && $shopkeeper_theme_options['predictive_search'] ) {
			include('inc/search/class-search.php');
		}
	}
	add_action( 'after_setup_theme', 'getbowtied_ajax_search' );
endif;

/**
 * Register nav menus based on theme option
 */
if (!function_exists( 'getbowtied_custom_nav_menus' )) {
	function getbowtied_custom_nav_menus() {

		global $shopkeeper_theme_options;

		$shopkeeper_theme_options['main_header_off_canvas'] 					= getbowtied_theme_option('main_header_off_canvas', false);
		$shopkeeper_theme_options['main_header_layout'] 						= getbowtied_theme_option('main_header_layout', 1);

		if ( (isset($shopkeeper_theme_options['main_header_off_canvas'])) && (trim($shopkeeper_theme_options['main_header_off_canvas']) == "1" ) ) {
			register_nav_menus( array(
				'secondary_navigation' => __( 'Secondary Navigation (Off-Canvas)', 'shopkeeper' ),
			) );
		}
		
		if ( (isset($shopkeeper_theme_options['main_header_layout'])) && ( $shopkeeper_theme_options['main_header_layout'] == "2" || $shopkeeper_theme_options['main_header_layout'] == "22" ) ) {
			register_nav_menus( array(
				'centered_header_left_navigation' => __( 'Centered Header - Left Navigation', 'shopkeeper' ),
				'centered_header_right_navigation' => __( 'Centered Header - Right Navigation', 'shopkeeper' ),
			) );
		}
	}
	add_action('init', 'getbowtied_custom_nav_menus');
}



/******************************************************************************/
/**************************** Enqueue styles **********************************/
/******************************************************************************/

// frontend
function shopkeeper_styles() {
	
	global $shopkeeper_theme_options;


	/******************************************************************************/
	/* WooCommerce remove review tab **********************************************/
	/******************************************************************************/
	if ( (isset($shopkeeper_theme_options['review_tab'])) && ($shopkeeper_theme_options['review_tab'] == "0" ) ) {
	add_filter( 'woocommerce_product_tabs', 'shopkeeper_remove_reviews_tab', 98);
		function shopkeeper_remove_reviews_tab($tabs) {
			unset($tabs['reviews']);
			return $tabs;
		}
	}

	if ( (isset($shopkeeper_theme_options['smooth_transition_between_pages'])) && ($shopkeeper_theme_options['smooth_transition_between_pages'] == "1" ) ) {
		wp_enqueue_style('shopkeeper-page-in-out', get_template_directory_uri() . '/css/page-in-out.css', NULL, getbowtied_theme_version(), 'all' );
	}
	wp_enqueue_style('shopkeeper-styles', get_template_directory_uri() . '/css/styles.css', NULL, getbowtied_theme_version(), 'all' );

	wp_enqueue_style('shopkeeper-icon-font', get_template_directory_uri() . '/inc/fonts/shopkeeper-icon-font/style.css', NULL, getbowtied_theme_version(), 'all' );	
	
	wp_enqueue_style('shopkeeper-font-linea-arrows', get_template_directory_uri() . '/inc/fonts/linea-fonts/arrows/styles.css', NULL, getbowtied_theme_version(), 'all' );
	wp_enqueue_style('shopkeeper-font-linea-basic', get_template_directory_uri() . '/inc/fonts/linea-fonts/basic/styles.css', NULL, getbowtied_theme_version(), 'all' );
	wp_enqueue_style('shopkeeper-font-linea-basic_elaboration', get_template_directory_uri() . '/inc/fonts/linea-fonts/basic_elaboration/styles.css', NULL, getbowtied_theme_version(), 'all' );
	wp_enqueue_style('shopkeeper-font-linea-ecommerce', get_template_directory_uri() . '/inc/fonts/linea-fonts/ecommerce/styles.css', NULL, getbowtied_theme_version(), 'all' );
	wp_enqueue_style('shopkeeper-font-linea-music', get_template_directory_uri() . '/inc/fonts/linea-fonts/music/styles.css', NULL, getbowtied_theme_version(), 'all' );
	wp_enqueue_style('shopkeeper-font-linea-software', get_template_directory_uri() . '/inc/fonts/linea-fonts/software/styles.css', NULL, getbowtied_theme_version(), 'all' );
	wp_enqueue_style('shopkeeper-font-linea-weather', get_template_directory_uri() . '/inc/fonts/linea-fonts/weather/styles.css', NULL, getbowtied_theme_version(), 'all' );	
	
	wp_enqueue_style('shopkeeper-fresco', get_template_directory_uri() . '/css/fresco/fresco.css', NULL, '1.3.0', 'all' );	
	
	if ( isset($shopkeeper_theme_options['main_header_layout']) ) {		
		if ( $shopkeeper_theme_options['main_header_layout'] == "1" || $shopkeeper_theme_options['main_header_layout'] == "11" ) {
			wp_enqueue_style('shopkeeper-header-default', get_template_directory_uri() . '/css/header-default.css', NULL, getbowtied_theme_version(), 'all' );
		} 		
		elseif ( $shopkeeper_theme_options['main_header_layout'] == "2" || $shopkeeper_theme_options['main_header_layout'] == "22" ) {
			wp_enqueue_style('shopkeeper-header-centered-2menus', get_template_directory_uri() . '/css/header-centered-2menus.css', NULL, getbowtied_theme_version(), 'all' );
		}
		elseif ( $shopkeeper_theme_options['main_header_layout'] == "3" ) {
			wp_enqueue_style('shopkeeper-header-centered-menu-under', get_template_directory_uri() . '/css/header-centered-menu-under.css', NULL, getbowtied_theme_version(), 'all' );
		} 		
	}		
	else {	
		wp_enqueue_style('shopkeeper-header-default', get_template_directory_uri() . '/css/header-default.css', NULL, getbowtied_theme_version(), 'all' );	
	}

	//plugin styles

	if( GETBOWTIED_GERMAN_MARKET_IS_ACTIVE || GETBOWTIED_WOOCOMMERCE_GERMANIZED_IS_ACTIVE ) {
		wp_enqueue_style('shopkeeper-german-market-styles', get_template_directory_uri() . '/css/plugins/german-market.css', NULL, getbowtied_theme_version(), 'all' );
	}

	if ( GETBOWTIED_DOKAN_MULTIVENDOR_IS_ACTIVE ) {
		wp_enqueue_style('shopkeeper-dokan-styles', get_template_directory_uri() . '/css/plugins/dokan.css', NULL, getbowtied_theme_version(), 'all' );
	}

	if ( GETBOWTIED_WOOCOMMERCE_PRODUCT_ADDONS_IS_ACTIVE ) {
		wp_enqueue_style('shopkeeper-addons-styles', get_template_directory_uri() . '/css/plugins/woo-addons.css', NULL, getbowtied_theme_version(), 'all' );
	}

	if ( GETBOWTIED_WOOCOMMERCE_WISHLISTS_IS_ACTIVE ) {
		wp_enqueue_style('shopkeeper-wishlists-styles', get_template_directory_uri() . '/css/plugins/woo-wishlists.css', NULL, getbowtied_theme_version(), 'all' );
	}
	
	wp_enqueue_style('shopkeeper-default-style', get_stylesheet_uri());

}
add_action( 'wp_enqueue_scripts', 'shopkeeper_styles', 99 );



// admin area
function shopkeeper_admin_styles() {
    if ( is_admin() ) {
        
		wp_enqueue_style("wp-color-picker");
		wp_enqueue_style("shopkeeper_admin_styles", get_template_directory_uri() . "/css/wp-admin-custom.css", false, getbowtied_theme_version(), "all");
		
		if (class_exists('WPBakeryVisualComposerAbstract')) { 
			wp_enqueue_style('shopkeeper_visual_composer', get_template_directory_uri() .'/css/visual-composer.css', false, getbowtied_theme_version(), 'all');
			wp_enqueue_style('shopkeeper-font-linea-arrows', get_template_directory_uri() . '/inc/fonts/linea-fonts/arrows/styles.css', false, getbowtied_theme_version(), 'all' );
			wp_enqueue_style('shopkeeper-font-linea-basic', get_template_directory_uri() . '/inc/fonts/linea-fonts/basic/styles.css', false, getbowtied_theme_version(), 'all' );
			wp_enqueue_style('shopkeeper-font-linea-basic_elaboration', get_template_directory_uri() . '/inc/fonts/linea-fonts/basic_elaboration/styles.css', false, getbowtied_theme_version(), 'all' );
			wp_enqueue_style('shopkeeper-font-linea-ecommerce', get_template_directory_uri() . '/inc/fonts/linea-fonts/ecommerce/styles.css', false, getbowtied_theme_version(), 'all' );
			wp_enqueue_style('shopkeeper-font-linea-music', get_template_directory_uri() . '/inc/fonts/linea-fonts/music/styles.css', false, getbowtied_theme_version(), 'all' );
			wp_enqueue_style('shopkeeper-font-linea-software', get_template_directory_uri() . '/inc/fonts/linea-fonts/software/styles.css', false, getbowtied_theme_version(), 'all' );
			wp_enqueue_style('shopkeeper-font-linea-weather', get_template_directory_uri() . '/inc/fonts/linea-fonts/weather/styles.css', false, getbowtied_theme_version(), 'all' );
		}
    }
}
add_action( 'admin_enqueue_scripts', 'shopkeeper_admin_styles' );


/******************************************************************************/
/*************************** Enqueue scripts **********************************/
/******************************************************************************/

// frontend

function shopkeeper_scripts_header_priority_0() {

	global $shopkeeper_theme_options;

	if ( (isset($shopkeeper_theme_options['smooth_transition_between_pages'])) && ($shopkeeper_theme_options['smooth_transition_between_pages'] == "1" ) ) {
		wp_enqueue_script('shopkeeper-nprogress', get_template_directory_uri() . '/js/components/nprogress.js', NULL, getbowtied_theme_version(), FALSE);
		wp_enqueue_script('shopkeeper-page-in-out', get_template_directory_uri() . '/js/components/page-in-out.js', array('shopkeeper-nprogress', 'jquery'), getbowtied_theme_version(), FALSE);
	}

}
add_action( 'wp_enqueue_scripts', 'shopkeeper_scripts_header_priority_0', 0 );

function shopkeeper_scripts() {
	
	global $shopkeeper_theme_options;
	
	/** In Footer **/
	if( is_rtl() )
	{
		wp_enqueue_script('shopkeeper-rtl-js', get_template_directory_uri() . '/js/components/rtl.js', array('jquery'), getbowtied_theme_version(), TRUE);
	}

	if( class_exists('WooCommerce') && !is_woocommerce() )
	{
		wp_enqueue_script('shopkeeper-salvattore-js', get_template_directory_uri() . '/js/vendor/salvattore.js', array('jquery'), getbowtied_theme_version(), TRUE);
	}
	
	// wp_enqueue_script('shopkeeper-scripts-dist', get_template_directory_uri() . '/js/scripts-dist.js', array('jquery'), getbowtied_theme_version(), TRUE);

	if ( GETBOWTIED_VISUAL_COMPOSER_IS_ACTIVE) // If VC exists/active load scripts after VC
	{
		$dependencies = array('jquery', 'wpb_composer_front_js');
	}
	else // Do not depend on VC
	{
		$dependencies = array('jquery');
	}

	wp_enqueue_script('shopkeeper-scripts-dist', get_template_directory_uri() . '/js/scripts-dist.js', $dependencies, getbowtied_theme_version(), TRUE);
	
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}


	$getbowtied_scripts_vars_array = array(
		
		'ajax_load_more_locale' 	=> __( 'Load More Items', 'shopkeeper' ),
		'ajax_loading_locale' 		=> __( 'Loading', 'shopkeeper' ),
		'ajax_no_more_items_locale' => __( 'No more items available.', 'shopkeeper' ),

		'notification_mode'			=> (isset($shopkeeper_theme_options['notification_mode']) && $shopkeeper_theme_options['notification_mode'] == '1') ? '1' : '0',
		'notification_style'		=> (isset($shopkeeper_theme_options['notification_style']) && $shopkeeper_theme_options['notification_style'] == '0') ? '1' : '0',

		'pagination_blog' 			=> isset($shopkeeper_theme_options['pagination_blog'])? $shopkeeper_theme_options['pagination_blog'] : 'infinite_scroll',
		'layout_blog' 				=> isset($shopkeeper_theme_options['layout_blog'])? 	$shopkeeper_theme_options['layout_blog'] 	 : 'layout-1',
		'shop_pagination_type' 		=> isset($shopkeeper_theme_options['pagination_shop'])? $shopkeeper_theme_options['pagination_shop'] : 'infinite_scroll',

		'option_minicart' 			=> isset($shopkeeper_theme_options['option_minicart'])? $shopkeeper_theme_options['option_minicart'] : '1',
		'option_minicart_open' 		=> isset($shopkeeper_theme_options['option_minicart_open'])? $shopkeeper_theme_options['option_minicart_open'] : '1',
		'catalog_mode'				=> (isset($shopkeeper_theme_options['catalog_mode']) && $shopkeeper_theme_options['catalog_mode'] == 1) ? '1' : '0',
		'product_lightbox'			=> (isset($shopkeeper_theme_options['product_gallery_lightbox']) && $shopkeeper_theme_options['product_gallery_lightbox'] == 1) ? '1' : '0',
		'product_gallery_zoom'			=> (isset($shopkeeper_theme_options['product_gallery_zoom']) && $shopkeeper_theme_options['product_gallery_zoom'] == 1) ? '1' : '0'

	);
	
	wp_localize_script( 'shopkeeper-scripts-dist', 'getbowtied_scripts_vars', $getbowtied_scripts_vars_array );

}
add_action( 'wp_enqueue_scripts', 'shopkeeper_scripts', 99 );



// admin area
function shopkeeper_admin_scripts() {
    if ( is_admin() ) {
        global $post_type;
		
		if ( (isset($_GET['post_type']) && ($_GET['post_type'] == 'portfolio')) || ($post_type == 'portfolio')) :
			wp_enqueue_script("shopkeeper_admin_scripts", get_template_directory_uri() . "/js/components/wp-admin-portfolio.js", array('wp-color-picker'), false, getbowtied_theme_version());
		endif;

		wp_enqueue_script('shopkeeper-customizer', get_template_directory_uri() . '/js/components/wp-customizer.js', array('jquery'), getbowtied_theme_version(), TRUE);
		
    }
}
add_action( 'admin_enqueue_scripts', 'shopkeeper_admin_scripts' );



function getbowtied_favicon(){
	if (has_site_icon() == false)
	    echo '<link rel="icon" href="' . get_stylesheet_directory_uri() . '/favicon.png" />';
}
add_action('wp_head', 'getbowtied_favicon');

/*********************************************************************************************/
/******************************** Tweak WP admin bar  ****************************************/
/*********************************************************************************************/

add_action( 'wp_head', 'shopkeeper_override_toolbar_margin', 11 );
function shopkeeper_override_toolbar_margin() {	
	if ( is_admin_bar_showing() ) {
		?>
			<style type="text/css" media="screen">
				@media only screen and (max-width: 63.9375em) {
					html { margin-top: 0 !important; }
					* html body { margin-top: 0 !important; }
				}

				@media all and (min-width: 1024px) and (max-width: 1280px) {
					.site-search .site-search-inner{
						margin: 60px auto 0 auto;
					}
				}
			</style>
		<?php 
	}
}


/******************************************************************************/
/****** Register widgetized area and update sidebar with default widgets ******/
/******************************************************************************/

function shopkeeper_widgets_init() {
	
	$sidebars_widgets = wp_get_sidebars_widgets();	
	$footer_area_widgets_counter = "0";	
	if (isset($sidebars_widgets['footer-widget-area'])) $footer_area_widgets_counter  = count($sidebars_widgets['footer-widget-area']);
	
	switch ($footer_area_widgets_counter) {
		case 0:
			$footer_area_widgets_columns ='large-12';
			break;
		case 1:
			$footer_area_widgets_columns ='large-12';
			break;
		case 2:
			$footer_area_widgets_columns ='large-6';
			break;
		case 3:
			$footer_area_widgets_columns ='large-4';
			break;
		case 4:
			$footer_area_widgets_columns ='large-3';
			break;
		default:
			$footer_area_widgets_columns ='large-3';
	}
	
	//default sidebar
	register_sidebar(array(
		'name'          => __( 'Sidebar', 'shopkeeper' ),
		'id'            => 'default-sidebar',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	));
	
	//footer widget area
	register_sidebar( array(
		'name'          => __( 'Footer Widget Area', 'shopkeeper' ),
		'id'            => 'footer-widget-area',
		'before_widget' => '<div class="' . $footer_area_widgets_columns . ' columns"><aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside></div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	
	//catalog widget area
	register_sidebar( array(
		'name'          => __( 'Shop Sidebar', 'shopkeeper' ),
		'id'            => 'catalog-widget-area',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	//offcanvas widget area
	register_sidebar( array(
		'name'          => __( 'Right Offcanvas Sidebar', 'shopkeeper' ),
		'id'            => 'offcanvas-widget-area',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'shopkeeper_widgets_init' );


/**
 * Add notification class to body
 *
 */
function getbowtied_notification_class( $classes ) {
	global $shopkeeper_theme_options;

	if ($shopkeeper_theme_options['notification_mode'] == 1) {
	    $classes[] = 'gbt_custom_notif';
	} else {
		$classes[] = 'gbt_classic_notif';
	}
    return $classes;    
}
add_filter( 'body_class','getbowtied_notification_class' );

/******************************************************************************/
/****** Remove Woocommerce prettyPhoto ***********************************************/
/******************************************************************************/

add_action( 'wp_enqueue_scripts', 'shopkeeper_remove_woo_lightbox', 99 );
function shopkeeper_remove_woo_lightbox() {
    wp_dequeue_script('prettyPhoto-init');
}



/*********************************************************************************************/
/****************************** WooCommerce Category Image ***********************************/
/*********************************************************************************************/

if ( ! function_exists( 'woocommerce_add_category_header_img' ) ) :
	require_once('inc/addons/woocommerce-header-category-image.php');
endif;



/******************************************************************************/
/****** Add Fresco to Galleries ***********************************************/
/******************************************************************************/

add_filter( 'wp_get_attachment_link', 'sant_prettyadd', 10, 6);
function sant_prettyadd ($content, $id, $size, $permalink, $icon, $text) {
    if ($permalink) {
    	return $content;    
    }
    $content = preg_replace("/<a/","<span class=\"fresco\" data-fresco-group=\"\"", $content, 1);
    return $content;
}



/******************************************************************************/
/* Change breadcrumb separator on woocommerce page ****************************/
/******************************************************************************/

add_filter( 'woocommerce_breadcrumb_defaults', 'jk_change_breadcrumb_delimiter' );
function jk_change_breadcrumb_delimiter( $defaults ) {
	// Change the breadcrumb delimeter from '/' to '>'  
	$defaults['delimiter'] = ' <span class="breadcrump_sep">/</span> ';
	return $defaults;
}




/******************************************************************************/
/* Remove Admin Bar - Only display to administrators **************************/
/******************************************************************************/

add_action('after_setup_theme', 'remove_admin_bar');
function remove_admin_bar() {
	if (!current_user_can('administrator') && !is_admin()) {
		show_admin_bar(false);
	}
}




/******************************************************************************/
/* WooCommerce Update Number of Items in the cart *****************************/
/******************************************************************************/

add_action('woocommerce_ajax_added_to_cart', 'shopkeeper_ajax_added_to_cart');
function shopkeeper_ajax_added_to_cart() {

}


//================================================================================
// Update local storage with cart counter each time
//================================================================================

add_filter('woocommerce_add_to_cart_fragments', 'shopkeeper_shopping_bag_items_number');
function shopkeeper_shopping_bag_items_number( $fragments ) 
{
	global $woocommerce;
	ob_start(); ?>

    <span class="shopping_bag_items_number"><?php echo esc_html(WC()->cart->get_cart_contents_count()); ?></span>
	<?php
	$fragments['.shopping_bag_items_number'] = ob_get_clean();
	return $fragments;
}





/******************************************************************************/
/* WooCommerce Number of Related Products *************************************/
/******************************************************************************/

function woocommerce_output_related_products() {
	$atts = array(
		'posts_per_page' => '4',
		'orderby'        => 'rand'
	);
	woocommerce_related_products($atts);
}






/******************************************************************************/
/* WooCommerce Add data-src & lazyOwl to Thumbnails ***************************/
/******************************************************************************/
function woocommerce_get_product_thumbnail( $size = 'product_small_thumbnail', $placeholder_width = 0, $placeholder_height = 0  ) {
	global $post;

	if ( has_post_thumbnail() ) {
		$image_src = wp_get_attachment_image_src( get_post_thumbnail_id(), 'shop_catalog' );
		return get_the_post_thumbnail( $post->ID, $size, array('data-src' => $image_src[0], 'class' => 'lazyOwl') );
		//return '<div><img data-src="' . $image_src[0] . '" class="lazyOwl"></div>';
	} elseif ( wc_placeholder_img_src() ) {
		return wc_placeholder_img( $size );
	}
}






/******************************************************************************/
/* WooCommerce Wrap Oembed Stuff **********************************************/
/******************************************************************************/
add_filter('embed_oembed_html', 'shopkeeper_embed_oembed_html', 99, 4);
function shopkeeper_embed_oembed_html($html, $url, $attr, $post_id) {
	if ( strstr( $html,'youtube.com/embed/' ) || strstr( $html,'player.vimeo.com' ) ) {
		return '<div class="video-container responsive-embed widescreen">' . $html . '</div>';
	}

	return '<div class="video-container">' . $html . '</div>';
}




/******************************************************************************/
/* Share Product **************************************************************/
/******************************************************************************/

function getbowtied_single_share_product() {
    global $post, $product, $shopkeeper_theme_options;
    if ( (isset($shopkeeper_theme_options['sharing_options'])) && ($shopkeeper_theme_options['sharing_options'] == "1" ) ) :

	$src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), false, ''); //Get the Thumbnail URL
	
	?>

    <div class="product_socials_wrapper show-share-text-on-mobiles">
		<div class="share-product-text"><?php __( 'Share this product', 'shopkeeper'); ?></div>
		<div class="product_socials_wrapper_inner">
			<a href="//www.facebook.com/sharer.php?u=<?php the_permalink(); ?>" target="_blank" class="social_media social_media_facebook"><span class="spk-icon-facebook-f"></span></a>
			<a href="//twitter.com/share?url=<?php the_permalink(); ?>" target="_blank" class="social_media social_media_twitter"><span class="spk-icon-twitter"></span></a>
			<a href="//pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>&amp;media=<?php echo esc_url($src[0]) ?>&amp;description=<?php echo urlencode(get_the_title()); ?>" target="_blank" class="social_media social_media_pinterest"><span class="spk-icon-pinterest"></span></a>
		</div><!--.product_socials_wrapper_inner-->
			
	</div><!--.product_socials_wrapper-->

<?php
    endif;
}
add_filter( 'getbowtied_woocommerce_before_single_product_summary_data_tabs', 'getbowtied_single_share_product', 50 );



/******************************************************************************/
/****** Set woocommerce images sizes ******************************************/
/******************************************************************************/

/**
 * Hook in on activation
 */
global $pagenow;
if ( is_admin() && isset( $_GET['activated'] ) && $pagenow == 'themes.php' ) add_action( 'init', 'shopkeeper_woocommerce_image_dimensions', 1 );

/**
 * Define image sizes
 */
function shopkeeper_woocommerce_image_dimensions() {
  	$catalog = array(
		'width' 	=> '350',	// px
		'height'	=> '435',	// px
		'crop'		=> 1 		// true
	);

	$single = array(
		'width' 	=> '570',	// px
		'height'	=> '708',	// px
		'crop'		=> 1 		// true
	);

	$thumbnail = array(
		'width' 	=> '70',	// px
		'height'	=> '87',	// px
		'crop'		=> 1 		// false
	);

	// Image sizes
	update_option( 'shop_catalog_image_size', $catalog ); 		// Product category thumbs
	update_option( 'shop_single_image_size', $single ); 		// Single product image
	update_option( 'shop_thumbnail_image_size', $thumbnail ); 	// Image gallery thumbs
}

if ( ! function_exists('shopkeeper_woocommerce_image_dimensions') ) :
	function shopkeeper_woocommerce_image_dimensions() {
		global $pagenow;
	 
		if ( ! isset( $_GET['activated'] ) || $pagenow != 'themes.php' ) {
			return;
		}

	  	$catalog = array(
			'width' 	=> '350',	// px
			'height'	=> '435',	// px
			'crop'		=> 1 		// true
		);

		$single = array(
			'width' 	=> '570',	// px
			'height'	=> '708',	// px
			'crop'		=> 1 		// true
		);

		$thumbnail = array(
			'width' 	=> '70',	// px
			'height'	=> '87',	// px
			'crop'		=> 0 		// false
		);

		// Image sizes
		update_option( 'shop_catalog_image_size', $catalog ); 		// Product category thumbs
		update_option( 'shop_single_image_size', $single ); 		// Single product image
		update_option( 'shop_thumbnail_image_size', $thumbnail ); 	// Image gallery thumbs
	}
	add_action( 'after_switch_theme', 'shopkeeper_woocommerce_image_dimensions', 1 );
endif;

if ( ! isset( $content_width ) ) $content_width = 900;

/******************************************************************************/
/****** Limit number of cross-sells *******************************************/
/******************************************************************************/
add_filter('woocommerce_cross_sells_total', 'cartCrossSellTotal');
function cartCrossSellTotal($total) {
	$total = '2';
	return $total;
}

//delete_option('getbowtied_tools_force_activate');

/******************************************************************************/
/****** Custom Sale label *****************************************************/
/******************************************************************************/

add_filter('woocommerce_sale_flash', 'woocommerce_custom_sale_tag_sale_flash', 10, 3);
function woocommerce_custom_sale_tag_sale_flash($original, $post, $product) {
	global $shopkeeper_theme_options;

	if (!empty($shopkeeper_theme_options['sale_label'])):
		echo '<span class="onsale">'. __( $shopkeeper_theme_options['sale_label'], 'woocommerce' ) .'</span>';
	else: 
		echo '';
	endif;
}

/******************************************************************************/
/****** whitelist style for wp_kses_post() *******************************/
/******************************************************************************/

add_action('init', 'my_html_tags_code', 10);
function my_html_tags_code() {
  global $allowedposttags;
    $allowedposttags["style"] = array();
}

/******************************************************************************/
/****** add image to added to cart notification *******************************/
/******************************************************************************/
if(	getbowtied_theme_option('notification_mode', 1) ) {
	add_filter('wc_add_to_cart_message_html', 'custom_add_to_cart_message', 10, 2);
	function custom_add_to_cart_message( $message, $product_id) {

		$img = false;

		if (isset($_POST['variation_id'])) {
			$id = $_POST['variation_id'];
			$img = wp_get_attachment_image_src( get_post_thumbnail_id($id), 'shop_catalog' );
		} 

		if ($img === false || empty($img)) {
			$img = wp_get_attachment_image_src( get_post_thumbnail_id(key($product_id)), 'shop_catalog' );
		}


		$img_url = $img[0];

		$added_to_cart = '<div class="product_notification_wrapper"><style type="text/css">
		.product_notification_background 
		{ 
			background:url('.$img_url.');
		}
			</style>
			 <div class="product_notification_background"></div><div class="product_notification_text">'.$message.'</div></div>';
		return $added_to_cart;
	}
}

//==============================================================================
// Wrap success notification text
//==============================================================================
add_filter('woocommerce_add_success', 'custom_add_success', 10, 1);
function custom_add_success($message) {
	if (strpos($message, 'product_notification_background') === false):
		return '<div class="woocommerce-message-wrapper"><span class="success-icon"><i class="spk-icon spk-icon-cart-shopkeeper"></i></span><span class="notice_text">'. $message .'</span></div>';
	else:
		return $message;
	endif;
}



//==============================================================================
// Wrap notice text
//==============================================================================
add_filter('woocommerce_add_notice', 'custom_add_notice', 10, 1);
function custom_add_notice($message) {
	if (strpos($message, 'product_notification_background') === false):
		return '<div class="woocommerce-message-wrapper"><span class="success-icon"><i class="spk-icon spk-icon-icon-like-it"></i></span><span class="notice_text">'. $message .'</span></div>';
	else:
	endif;
}


add_action('woocommerce_archive_description', 'custom_add_notice_search', 10, 1);

function custom_add_notice_search($message) {
	
	if ( is_search() ) {
		return false;
	}
}




//==============================================================================
// Show Woocommerce Cart Widget Everywhere
//==============================================================================
if ( ! function_exists('getbowtied_woocommerce_widget_cart_everywhere') ) :
function getbowtied_woocommerce_widget_cart_everywhere() { 
    return false; 
};
add_filter( 'woocommerce_widget_cart_is_hidden', 'getbowtied_woocommerce_widget_cart_everywhere', 10, 1 );
endif;


//==============================================================================
// Wishlist message notification remove
//==============================================================================

function yith_wcwl_added_to_cart_message( $message ){
   return false;
}
add_action( 'yith_wcwl_added_to_cart_message', 'yith_wcwl_added_to_cart_message' );




//==============================================================================
// Woocommerce Product Page Get Caption Text
//==============================================================================
function wp_get_attachment( $attachment_id ) {
    $attachment = get_post( $attachment_id );
    return array(
        'alt' => get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ),
        'caption' => $attachment->post_excerpt,
        'description' => $attachment->post_content,
        'href' => get_permalink( $attachment->ID ),
        'src' => $attachment->guid,
        'title' => $attachment->post_title
    );
}

//==============================================================================
//	Continue shopping button on cart page
//==============================================================================
add_action( 'woocommerce_after_cart', 'shopkeeper_add_continue_shopping_button_to_cart' );
if  ( ! function_exists('shopkeeper_add_continue_shopping_button_to_cart') ) :
	function shopkeeper_add_continue_shopping_button_to_cart() {
	$shop_page_url = get_permalink( wc_get_page_id( 'shop' ) );
	if (!empty($shop_page_url)):
		echo '<div class="shopkeeper-continue-shopping">';
		echo ' <a href="'.$shop_page_url.'" class="button">'.__('Continue shopping', 'woocommerce').'</a>';
		echo '</div>';
	endif;
}
endif;

//==============================================================================
//	Custom WooCommerce related products
//==============================================================================
if ( ! function_exists( 'getbowtied_output_related' ) ) {
	function getbowtied_output_related() {
		global $shopkeeper_theme_options;
		if ( isset($shopkeeper_theme_options['related_products']) && ($shopkeeper_theme_options['related_products'] == 1) ) {

			$related_products_number = isset($shopkeeper_theme_options['related_products_number']) ? $shopkeeper_theme_options['related_products_number'] : '4';

			echo '<div class="row">';
				echo '<div class="large-12 large-centered columns">';
			    $atts = array(
					'columns'		 => $related_products_number,
					'posts_per_page' => $related_products_number,
					'orderby'        => 'rand'
				);
				woocommerce_related_products($atts); // Display 3 products in rows of 3
		    	echo '</div>';
		    echo '</div>';
		}
	}
}

//==============================================================================
//	Custom WooCommerce upsells 
//==============================================================================
if ( ! function_exists( 'getbowtied_output_upsells' ) ) {
	function getbowtied_output_upsells() {
		global $shopkeeper_theme_options;
		
		echo '<div class="row">';
			echo '<div class="large-12 large-centered columns">';

			$related_products_number = isset($shopkeeper_theme_options['related_products_number']) ? $shopkeeper_theme_options['related_products_number'] : '4';
			woocommerce_upsell_display( $related_products_number, $related_products_number ); // Display 3 products in rows of 3 
	    	echo '</div>';
	    echo '</div>';
	}
}

if ( ! function_exists( 'get_customize_section_url' ) ) {
	function get_customize_section_url() {
		switch($_POST['page']) {
			case 'shop': 
				echo get_permalink( wc_get_page_id( 'shop' ) ); 
				break;
			case 'blog': 
				echo get_permalink( get_option( 'page_for_posts' ) ); 
				break;
			case 'product': 
				$args = array('orderby' => 'rand', 'limit' => 1); 
				$product = wc_get_products($args); 
				echo get_permalink( $product[0]->get_id() ); 
				break;
			case 'post': 
				$args = array('orderby' => 'rand', 'posts_per_page' => 1); 
				$post = get_posts($args); 
				echo get_permalink( $post[0]->ID ); 
				break;
			default:
				echo get_home_url();
				break;
		}
		exit();
	}
	add_action( 'wp_ajax_get_url', 'get_customize_section_url' );
}


//==============================================================================
//	Top Bar Languages DropDown
//==============================================================================
function languages_top_bar(){
    $languages = icl_get_languages('skip_missing=0&orderby=code');

    if(!empty($languages)) : ?>

       <div id="top_bar_language_list" class="topbar-language-switcher">

       <ul>
			<li class="menu-item-first"><a href="#"><?php echo ICL_LANGUAGE_NAME; ?></a>

			<ul class="sub-menu">

	       <?php
	        foreach($languages as $l) {
	            echo '<li class="sub-menu-item">';
	            if($l['country_flag_url']){
	                if(!$l['active']) echo '<a class="flag" href="'.$l['url'].'">';
	                echo '<img src="'.$l['country_flag_url'].'" height="12" alt="'.$l['language_code'].'" width="18" />';
	                if(!$l['active']) echo '</a>';
	            }
	            if(!$l['active']) echo '<a href="'.$l['url'].'">';
	            echo apply_filters( 'wpml_display_language_names', NULL, $l['native_name'], $l['translated_name'] );
	            if(!$l['active']) echo '</a>';
	            echo '</li>';
	        }

	        echo '</ul></li>';
	        ?>

    <?php endif; ?>
	<?php echo '</ul></div>'; 
}


if( GETBOWTIED_GERMAN_MARKET_IS_ACTIVE ) {

	function german_market_compatibility() {
		remove_filter( 'woocommerce_product_get_name',				array( 'WGM_Template', 'add_virtual_product_notice' ), 1, 2 );
		remove_filter( 'woocommerce_product_title', 				array( 'WGM_Template', 'add_virtual_product_notice' ), 1, 2 );
		remove_action( 'woocommerce_single_product_summary',		array( 'WGM_Template', 'woocommerce_de_price_with_tax_hint_single' ), 7 );
		remove_action( 'woocommerce_after_shop_loop_item_title',	array( 'WGM_Template', 'woocommerce_de_price_with_tax_hint_loop' ), 5 );

		add_action( 'woocommerce_single_product_german_market_info',	array( 'WGM_Template', 'woocommerce_de_price_with_tax_hint_single' ), 7 );
		add_filter( 'woocommerce_single_product_german_market_info', 	'__return_true' );
	}

	german_market_compatibility();
}

if( GETBOWTIED_WOOCOMMERCE_GERMANIZED_IS_ACTIVE ) {

	function germanized_compatibility() {

		if ( get_option( 'woocommerce_gzd_display_product_detail_unit_price' ) == 'yes' ) {
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_gzd_template_single_price_unit', wc_gzd_get_hook_priority( 'single_price_unit' ) );
			add_action( 'woocommerce_single_product_germanized_info', 'woocommerce_gzd_template_single_price_unit', wc_gzd_get_hook_priority( 'single_price_unit' ) );
		}

		if ( get_option( 'woocommerce_gzd_display_product_detail_tax_info' ) == 'yes' || get_option( 'woocommerce_gzd_display_product_detail_shipping_costs' ) == 'yes' ) {
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_gzd_template_single_legal_info', wc_gzd_get_hook_priority( 'single_legal_info' ) );
			add_action( 'woocommerce_single_product_germanized_info', 'woocommerce_gzd_template_single_legal_info', wc_gzd_get_hook_priority( 'single_legal_info' ) );
		}

		if ( get_option( 'woocommerce_gzd_display_product_detail_delivery_time' ) == 'yes' ) {
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_gzd_template_single_delivery_time_info', wc_gzd_get_hook_priority( 'single_delivery_time_info' ) );
			add_action( 'woocommerce_single_product_germanized_info', 'woocommerce_gzd_template_single_delivery_time_info', wc_gzd_get_hook_priority( 'single_delivery_time_info' ) );
		}

		if ( get_option( 'woocommerce_gzd_display_product_detail_product_units' ) == 'yes' ) {
			remove_action( 'woocommerce_product_meta_start', 'woocommerce_gzd_template_single_product_units', wc_gzd_get_hook_priority( 'single_product_units' ) );
			add_action( 'woocommerce_single_product_germanized_info', 'woocommerce_gzd_template_single_product_units', wc_gzd_get_hook_priority( 'single_product_units' ) );
		}

		if ( get_option( 'woocommerce_gzd_display_listings_unit_price' ) == 'yes' ) {
	        remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_gzd_template_single_price_unit', wc_gzd_get_hook_priority( 'loop_price_unit' ) );
	        add_action( 'woocommerce_germanized_unit_price', 'woocommerce_gzd_template_single_price_unit', 1 );
	    }
	}

	germanized_compatibility();
}

//==============================================================================
//	External Product in new tab
//==============================================================================

remove_action( 'woocommerce_external_add_to_cart', 'woocommerce_external_add_to_cart', 30 );
add_action( 'woocommerce_external_add_to_cart', 'getbowtied_rei_external_add_to_cart', 30 );
function getbowtied_rei_external_add_to_cart(){

    global $product;

    if ( ! $product->add_to_cart_url() ) {
        return;
    }

    $product_url = $product->add_to_cart_url();
    $button_text = $product->single_add_to_cart_text();

    do_action( 'woocommerce_before_add_to_cart_button' ); ?>
    <p class="cart">
        <a href="<?php echo esc_url( $product_url ); ?>" target="_blank" rel="nofollow" class="single_add_to_cart_button button alt"><?php echo esc_html( $button_text ); ?></a>
    </p>
    <?php do_action( 'woocommerce_after_add_to_cart_button' );
}

//==============================================================================
//	Shop loop columns
//==============================================================================
//
if ( !function_exists('shopkeeper_loop_columns_class')):
	function shopkeeper_loop_columns_class() {
		global $shopkeeper_theme_options, $woocommerce_loop;
		if ( ( isset($woocommerce_loop['columns']) && $woocommerce_loop['columns'] != "" ) ) {
			$products_per_column = $woocommerce_loop['columns'];
		} else {
			$products_per_column = get_option('woocommerce_catalog_columns', 5);

			if (isset($_GET["products_per_row"])) {
				$products_per_column = $_GET["products_per_row"];
			}
		}

		if ($products_per_column == 6) {
			$products_per_column_xlarge = 6;
			$products_per_column_large = 4;
			$products_per_column_medium = 3;
		}

		if ($products_per_column == 5) {
			$products_per_column_xlarge = 5;
			$products_per_column_large = 4;
			$products_per_column_medium = 3;
		}

		if ($products_per_column == 4) {
			$products_per_column_xlarge = 4;
			$products_per_column_large = 4;
			$products_per_column_medium = 3;
		}

		if ($products_per_column == 3) {
			$products_per_column_xlarge = 3;
			$products_per_column_large = 3;
			$products_per_column_medium = 2;
		}

		if ($products_per_column == 2) {
			$products_per_column_xlarge = 2;
			$products_per_column_large = 2;
			$products_per_column_medium = 2;
		}

		if ($products_per_column == 1) {
			$products_per_column_xlarge = 1;
			$products_per_column_large = 1;
			$products_per_column_medium = 1;
		}
		echo $shopkeeper_theme_options['mobile_columns'] == 1 ? 'small-up-1' : 'small-up-2'; ?> medium-up-<?php echo $products_per_column_medium; ?> large-up-<?php echo $products_per_column_large; ?> xlarge-up-<?php echo $products_per_column_xlarge; ?> xxlarge-up-<?php echo $products_per_column;
	}
endif;

// Deactivate out of stock variations in select
add_filter( 'woocommerce_variation_is_active', 'gbt_variation_is_active', 10, 2 );
if( !function_exists('gbt_variation_is_active') ) {
	function gbt_variation_is_active( $active, $variation ) {
		global $shopkeeper_theme_options;

		if( $shopkeeper_theme_options['disabled_outofstock_variations'] ) {
			if( ! $variation->is_in_stock() ) {
				return false;
			}
		}

		return $active;
	}
}

// Deactivate AJAX Add to Cart when incompatible plugin is active
function gbt_deactivate_ajax_add_to_cart() {

	global $shopkeeper_theme_options;

	if( class_exists('WC_Product_Addons') || class_exists('Wcff') ) {

		set_theme_mod( 'ajax_add_to_cart', false);
	}
}
add_action( 'init', 'gbt_deactivate_ajax_add_to_cart' );

function gbt_customizer_deactivate_ajax_add_to_cart() {

	$active_option['active_option'] = '1';
	$active_option['plugin'] = '';

	if( class_exists('WC_Product_Addons') ) {
		$active_option['active_option'] = '0';
		$active_option['plugin'] .= 'incompatible-woo-addons ';
	}

	if( class_exists('Wcff') ) {
		$active_option['active_option'] = '0';
		$active_option['plugin'] .= 'incompatible-fields-factory ';
	}

	wp_localize_script( 'shopkeeper-customizer', 'getbowtied_customizer_vars', $active_option );
}
add_action( 'admin_enqueue_scripts', 'gbt_customizer_deactivate_ajax_add_to_cart' );