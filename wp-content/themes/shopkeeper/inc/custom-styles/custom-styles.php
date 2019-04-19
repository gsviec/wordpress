<?php

//remove_theme_mods(); // DEBUG

if (isset($_GET["preset"])) { 
	$preset = $_GET["preset"];
} else {
	$preset = "";
}

if ($preset != "") {
	if ( file_exists( get_template_directory() . '/_presets/'.$preset.'.dat' ) ) {
	$presets_raw = getbowtied_get_local_file_contents(get_template_directory() . '/_presets/'.$preset.'.dat');
	$presets = @unserialize( $presets_raw );
	}
}

if ( ! function_exists ('getbowtied_theme_option') ) {
function getbowtied_theme_option( $name, $default = "" ) {
	global $presets;
	return ( isset($presets['mods'][$name]) ) ? $presets['mods'][$name] : get_theme_mod( $name, $default );
} //function
} //if

// Default fonts
global $default_fonts;

$default_fonts = array( 
    "Radnika"                                               => "Radnika",
    "NeueEinstellung"                                       => "NeueEinstellung",
    "Arial, Helvetica, sans-serif"                          => "Arial, Helvetica, sans-serif",
    "Arial Black, Gadget, sans-serif"                     	=> "Arial Black, Gadget, sans-serif",
    "Bookman Old Style, serif"                            	=> "Bookman Old Style, serif",
    "Comic Sans MS, cursive"                              	=> "Comic Sans MS, cursive",
    "Courier, monospace"                                    => "Courier, monospace",
    "Garamond, serif"                                       => "Garamond, serif",
    "Georgia, serif"                                        => "Georgia, serif",
    "Impact, Charcoal, sans-serif"                          => "Impact, Charcoal, sans-serif",
    "Lucida Console, Monaco, monospace"                   	=> "Lucida Console, Monaco, monospace",
    "Lucida Sans Unicode, 'Lucida Grande, sans-serif"    	=> "Lucida Sans Unicode, 'Lucida Grande, sans-serif",
    "MS Sans Serif, Geneva, sans-serif"                   	=> "MS Sans Serif, Geneva, sans-serif",
    "MS Serif, 'New York, sans-serif"                    	=> "MS Serif, 'New York, sans-serif",
    "Palatino Linotype, 'Book Antiqua, Palatino, serif"  	=> "Palatino Linotype, 'Book Antiqua, Palatino, serif",
    "Tahoma,Geneva, sans-serif"                             => "Tahoma,Geneva, sans-serif",
    "Times New Roman, Times,serif"                        	=> "Times New Roman, Times,serif",
    "Trebuchet MS, Helvetica, sans-serif"                 	=> "Trebuchet MS, Helvetica, sans-serif",
    "Verdana, Geneva, sans-serif"                           => "Verdana, Geneva, sans-serif"
);

function getbowtied_customizer_styles(){

	global $shopkeeper_theme_options;
	
		/* Header Styles */
	$shopkeeper_theme_options['main_header_layout'] 						= getbowtied_theme_option('main_header_layout', 1);
	$shopkeeper_theme_options['main_header_font_size'] 						= getbowtied_theme_option('main_header_font_size', 13);
	$shopkeeper_theme_options['main_header_font_color'] 					= getbowtied_theme_option('main_header_font_color', '#000');
	$shopkeeper_theme_options['main_header_transparency'] 					= getbowtied_theme_option('main_header_transparency', false);
	$shopkeeper_theme_options['main_header_transparency_scheme'] 			= getbowtied_theme_option('main_header_transparency_scheme','transparency_light');
	$shopkeeper_theme_options['shop_category_header_transparency_scheme'] 	= getbowtied_theme_option('shop_category_header_transparency_scheme', 'no_transparency');
	$shopkeeper_theme_options['main_header_transparent_light_color'] 		= getbowtied_theme_option('main_header_transparent_light_color', '#fff');
	$shopkeeper_theme_options['light_transparent_header_logo'] 				= getbowtied_theme_option('light_transparent_header_logo');
	$shopkeeper_theme_options['main_header_transparent_dark_color'] 		= getbowtied_theme_option('main_header_transparent_dark_color', '#fff');
	$shopkeeper_theme_options['dark_transparent_header_logo'] 				= getbowtied_theme_option('dark_transparent_header_logo');
	$shopkeeper_theme_options['main_header_background'] 					= getbowtied_theme_option('main_header_background', '#FFFFFF');
	$shopkeeper_theme_options['spacing_above_logo'] 						= getbowtied_theme_option('spacing_above_logo', 20);  
	$shopkeeper_theme_options['spacing_below_logo'] 						= getbowtied_theme_option('spacing_below_logo', 20);
	$shopkeeper_theme_options['header_width'] 								= getbowtied_theme_option('header_width', 'custom');
	$shopkeeper_theme_options['header_max_width'] 							= getbowtied_theme_option('header_max_width', 1680);

	/* Header Elements */
	$shopkeeper_theme_options['main_header_wishlist'] 						= getbowtied_theme_option('main_header_wishlist', true);
	$shopkeeper_theme_options['main_header_wishlist_icon'] 					= getbowtied_theme_option('main_header_wishlist_icon');
	$shopkeeper_theme_options['main_header_shopping_bag'] 					= getbowtied_theme_option('main_header_shopping_bag', true);
	$shopkeeper_theme_options['main_header_shopping_bag_icon'] 				= getbowtied_theme_option('main_header_shopping_bag_icon');
	$shopkeeper_theme_options['option_minicart'] 							= getbowtied_theme_option('option_minicart', 1);
	$shopkeeper_theme_options['option_minicart_open'] 						= getbowtied_theme_option('option_minicart_open', 1);
	$shopkeeper_theme_options['main_header_minicart_message']				= getbowtied_theme_option('main_header_minicart_message');
	$shopkeeper_theme_options['my_account_icon_state'] 						= getbowtied_theme_option('my_account_icon_state',true);
	$shopkeeper_theme_options['custom_my_account_icon'] 					= getbowtied_theme_option('custom_my_account_icon');
	$shopkeeper_theme_options['main_header_search_bar']						= getbowtied_theme_option('main_header_search_bar', true);
	$shopkeeper_theme_options['main_header_search_bar_icon'] 				= getbowtied_theme_option('main_header_search_bar_icon');
	$shopkeeper_theme_options['main_header_off_canvas'] 					= getbowtied_theme_option('main_header_off_canvas', false);
	$shopkeeper_theme_options['main_header_off_canvas_icon'] 				= getbowtied_theme_option('main_header_off_canvas_icon');

	/* Header Logo */
	$shopkeeper_theme_options['site_logo'] 									= getbowtied_theme_option('site_logo', get_template_directory_uri() . '/images/shopkeeper-logo.png');
	$shopkeeper_theme_options['sticky_header_logo'] 						= getbowtied_theme_option('sticky_header_logo', get_template_directory_uri() . '/images/shopkeeper-logo.png');
	$shopkeeper_theme_options['logo_min_height'] 							= getbowtied_theme_option('logo_min_height', 50);
	$shopkeeper_theme_options['logo_height'] 								= getbowtied_theme_option('logo_height', 50);

	/* Top Bar */
	$shopkeeper_theme_options['top_bar_switch'] 							= getbowtied_theme_option('top_bar_switch', false);
	$shopkeeper_theme_options['top_bar_background_color'] 					= getbowtied_theme_option('top_bar_background_color', '#333');
	$shopkeeper_theme_options['top_bar_typography'] 						= getbowtied_theme_option('top_bar_typography', '#fff');
	$shopkeeper_theme_options['top_bar_text'] 								= getbowtied_theme_option('top_bar_text', 'Free Shipping on All Orders Over $75!');
	$shopkeeper_theme_options['top_bar_navigation_position'] 				= getbowtied_theme_option('top_bar_navigation_position', 'right');
	$shopkeeper_theme_options['top_bar_social_icons'] 						= getbowtied_theme_option('top_bar_social_icons', false);
	$shopkeeper_theme_options['sticky_header'] 								= getbowtied_theme_option('sticky_header', true);
	$shopkeeper_theme_options['sticky_header_background_color'] 			= getbowtied_theme_option('sticky_header_background_color', '#fff');
	$shopkeeper_theme_options['sticky_header_color'] 						= getbowtied_theme_option('sticky_header_color', '#000');

	/* Footer */
	$shopkeeper_theme_options['footer_background_color'] 					= getbowtied_theme_option('footer_background_color', '#f4f4f4');
	$shopkeeper_theme_options['footer_texts_color'] 						= getbowtied_theme_option('footer_texts_color', '#868686');
	$shopkeeper_theme_options['footer_links_color'] 						= getbowtied_theme_option('footer_links_color', '#000');
	$shopkeeper_theme_options['footer_social_icons'] 						= getbowtied_theme_option('footer_social_icons', true);
	$shopkeeper_theme_options['footer_copyright_text'] 						= getbowtied_theme_option('footer_copyright_text', 'Shopkeeper - eCommerce WP Theme');
	$shopkeeper_theme_options['expandable_footer'] 							= getbowtied_theme_option('expandable_footer', true);
	$shopkeeper_theme_options['back_to_top_button']							= getbowtied_theme_option('back_to_top_button', false);

	/* Blog */
	$shopkeeper_theme_options['layout_blog'] 								= getbowtied_theme_option('layout_blog', 'layout-3');
	$shopkeeper_theme_options['pagination_blog'] 							= getbowtied_theme_option('pagination_blog', 'infinite_scroll');
	$shopkeeper_theme_options['sidebar_blog_listing'] 						= getbowtied_theme_option('sidebar_blog_listing', false);
	$shopkeeper_theme_options['portfolio_item_slug'] 						= getbowtied_theme_option('portfolio_item_slug', false);

	/* Single Post */
	$shopkeeper_theme_options['post_meta_author'] 							= getbowtied_theme_option('post_meta_author', true);
	$shopkeeper_theme_options['post_meta_date'] 							= getbowtied_theme_option('post_meta_date', true);
	$shopkeeper_theme_options['post_meta_categories'] 						= getbowtied_theme_option('post_meta_categories', true);
	$shopkeeper_theme_options['single_post_width'] 							= getbowtied_theme_option('single_post_width', 708);

	/* Shop */
	$shopkeeper_theme_options['catalog_mode'] 								= getbowtied_theme_option('catalog_mode', false);
	$shopkeeper_theme_options['pagination_shop'] 							= getbowtied_theme_option('pagination_shop', 'infinite_scroll');
	$shopkeeper_theme_options['breadcrumbs'] 								= getbowtied_theme_option('breadcrumbs', true);
	$shopkeeper_theme_options['quick_view'] 								= getbowtied_theme_option('quick_view', false);
	$shopkeeper_theme_options['second_image_product_listing'] 				= getbowtied_theme_option('second_image_product_listing', true);
	$shopkeeper_theme_options['ratings_catalog_page'] 						= getbowtied_theme_option('ratings_catalog_page', true);
	$shopkeeper_theme_options['predictive_search'] 							= getbowtied_theme_option('predictive_search', true);
	$shopkeeper_theme_options['sidebar_style'] 								= getbowtied_theme_option('sidebar_style', 1);
	$shopkeeper_theme_options['add_to_cart_display'] 						= getbowtied_theme_option('add_to_cart_display', 1);
	$shopkeeper_theme_options['notification_mode'] 							= getbowtied_theme_option('notification_mode', 1);
	$shopkeeper_theme_options['notification_style'] 						= getbowtied_theme_option('notification_style', 1);
	$shopkeeper_theme_options['category_style'] 							= getbowtied_theme_option('category_style', 'styled_grid');
	$shopkeeper_theme_options['out_of_stock_label'] 						= getbowtied_theme_option('out_of_stock_label', 'Out of stock');
	$shopkeeper_theme_options['sale_label'] 								= getbowtied_theme_option('sale_label', 'Sale!');
	$shopkeeper_theme_options['mobile_columns'] 							= getbowtied_theme_option('mobile_columns', 2);
	$shopkeeper_theme_options['categories_grid_count'] 						= getbowtied_theme_option('categories_grid_count', true);

	/* Product Page */
	$shopkeeper_theme_options['product_layout'] 							= getbowtied_theme_option('product_layout', 'default');
	$shopkeeper_theme_options['product_quantity_style'] 					= getbowtied_theme_option('product_quantity_style', 'custom');
	$shopkeeper_theme_options['product_gallery_zoom'] 						= getbowtied_theme_option('product_gallery_zoom', true);
	$shopkeeper_theme_options['product_gallery_lightbox']					= getbowtied_theme_option('product_gallery_lightbox', true);
	$shopkeeper_theme_options['related_products'] 							= getbowtied_theme_option('related_products', true);
	$shopkeeper_theme_options['related_products_number'] 					= getbowtied_theme_option('related_products_number', 4);
	$shopkeeper_theme_options['sharing_options'] 							= getbowtied_theme_option('sharing_options', true);
	$shopkeeper_theme_options['review_tab'] 								= getbowtied_theme_option('review_tab', true);
	$shopkeeper_theme_options['ajax_add_to_cart'] 							= getbowtied_theme_option('ajax_add_to_cart', true);
	$shopkeeper_theme_options['disabled_outofstock_variations'] 			= getbowtied_theme_option('disabled_outofstock_variations', true);

	/* Styling */
	$shopkeeper_theme_options['body_color'] 								= getbowtied_theme_option('body_color', '#545454');
	$shopkeeper_theme_options['headings_color'] 							= getbowtied_theme_option('headings_color', '#000000');
	$shopkeeper_theme_options['main_color'] 								= getbowtied_theme_option('main_color', '#EC7A5C');
	$shopkeeper_theme_options['main_background'] 							= getbowtied_theme_option('main_background', array('background-color' => '#FFFFFF'));
	$shopkeeper_theme_options['smooth_transition_between_pages'] 			= getbowtied_theme_option('smooth_transition_between_pages', 0);
	$shopkeeper_theme_options['offcanvas_bg_color'] 						= getbowtied_theme_option('offcanvas_bg_color', '#ffffff');
	$shopkeeper_theme_options['offcanvas_headings_color'] 					= getbowtied_theme_option('offcanvas_headings_color', '#000000');
	$shopkeeper_theme_options['offcanvas_text_color'] 						= getbowtied_theme_option('offcanvas_text_color', '#545454');

	/* Fonts */
	$shopkeeper_theme_options['new_main_font'] 									= getbowtied_theme_option('new_main_font', array(
																													'font-family'    => 'NeueEinstellung',
																													'variant'        => '500',
																													'subsets'        => array( 'latin' )
																												));		      
	$shopkeeper_theme_options['new_secondary_font'] 						= getbowtied_theme_option('new_secondary_font', array('font-family'=> 'Radnika'));
	$shopkeeper_theme_options['headings_font_size'] 						= getbowtied_theme_option('headings_font_size', 23);	 
	$shopkeeper_theme_options['body_font_size']								= getbowtied_theme_option('body_font_size', 16);

	/* Fonts - deprecated */
	$shopkeeper_theme_options['main_font_variants'] 						= getbowtied_theme_option('main_font_variants', 'regular');	      
	$shopkeeper_theme_options['secondary_font_variants'] 					= getbowtied_theme_option('secondary_font_variants', 'regular');	      


	$shopkeeper_theme_options['product_title_font_size']					= getbowtied_theme_option('product_title_font_size', 12);

	/* Social Links */      
	$shopkeeper_theme_options['facebook_link'] 								= getbowtied_theme_option('facebook_link', '#');
	$shopkeeper_theme_options['twitter_link'] 								= getbowtied_theme_option('twitter_link', '#');
	$shopkeeper_theme_options['pinterest_link'] 							= getbowtied_theme_option('pinterest_link');
	$shopkeeper_theme_options['linkedin_link'] 								= getbowtied_theme_option('linkedin_link');
	$shopkeeper_theme_options['googleplus_link'] 							= getbowtied_theme_option('googleplus_link');
	$shopkeeper_theme_options['rss_link'] 									= getbowtied_theme_option('rss_link');
	$shopkeeper_theme_options['tumblr_link'] 								= getbowtied_theme_option('tumblr_link');
	$shopkeeper_theme_options['tripadvisor_link'] 							= getbowtied_theme_option('tripadvisor_link');
	$shopkeeper_theme_options['wechat_link'] 								= getbowtied_theme_option('wechat_link');
	$shopkeeper_theme_options['instagram_link'] 							= getbowtied_theme_option('instagram_link');
	$shopkeeper_theme_options['youtube_link'] 								= getbowtied_theme_option('youtube_link');
	$shopkeeper_theme_options['vimeo_link'] 								= getbowtied_theme_option('vimeo_link');
	$shopkeeper_theme_options['behance_link'] 								= getbowtied_theme_option('behance_link');
	$shopkeeper_theme_options['dribbble_link'] 								= getbowtied_theme_option('dribbble_link');
	$shopkeeper_theme_options['flickr_link'] 								= getbowtied_theme_option('flickr_link');
	$shopkeeper_theme_options['git_link'] 									= getbowtied_theme_option('git_link');
	$shopkeeper_theme_options['skype_link'] 								= getbowtied_theme_option('skype_link');
	$shopkeeper_theme_options['weibo_link'] 								= getbowtied_theme_option('weibo_link');
	$shopkeeper_theme_options['foursquare_link']							= getbowtied_theme_option('foursquare_link');
	$shopkeeper_theme_options['soundcloud_link'] 							= getbowtied_theme_option('soundcloud_link');
	$shopkeeper_theme_options['vk_link'] 									= getbowtied_theme_option('vk_link');
	$shopkeeper_theme_options['houzz_link'] 								= getbowtied_theme_option('houzz_link');
	$shopkeeper_theme_options['naver_line_link'] 							= getbowtied_theme_option('naver_line_link');
	$shopkeeper_theme_options['whatsapp_link'] 								= getbowtied_theme_option('whatsapp_link');
	$shopkeeper_theme_options['telegram_link'] 								= getbowtied_theme_option('telegram_link');
	$shopkeeper_theme_options['viber_link'] 								= getbowtied_theme_option('viber_link');
	$shopkeeper_theme_options['spotify_link'] 								= getbowtied_theme_option('spotify_link');
	$shopkeeper_theme_options['bandcamp_link'] 								= getbowtied_theme_option('bandcamp_link');

	/* Custom Code */
	$shopkeeper_theme_options['custom_css'] 								= getbowtied_theme_option('custom_css');
	$shopkeeper_theme_options['header_js'] 									= getbowtied_theme_option('header_js');
	$shopkeeper_theme_options['footer_js'] 									= getbowtied_theme_option('footer_js');
}
add_action( 'wp_loaded', 'getbowtied_customizer_styles', 99 );


if ( !function_exists ('shopkeeper_custom_styles') ) {
	function shopkeeper_custom_styles() {	
		global 	$post, 
				$shopkeeper_theme_options,
				$default_fonts;
		//convert hex to rgb
		function getbowtied_hex2rgb($hex) {
			$hex = str_replace("#", "", $hex);
			
			if(strlen($hex) == 3) {
				$r = hexdec(substr($hex,0,1).substr($hex,0,1));
				$g = hexdec(substr($hex,1,1).substr($hex,1,1));
				$b = hexdec(substr($hex,2,1).substr($hex,2,1));
			} else {
				$r = hexdec(substr($hex,0,2));
				$g = hexdec(substr($hex,2,2));
				$b = hexdec(substr($hex,4,2));
			}
			$rgb = array($r, $g, $b);
			return implode(",", $rgb); // returns the rgb values separated by commas
			//return $rgb; // returns an array with the rgb values
		}

	    if ( ! function_exists('getbowtied_google_fonts') ) :
		function getbowtied_google_fonts() {

			global $shopkeeper_theme_options;

			$old_mfont= getbowtied_theme_option('main_font');
			$old_sfont= getbowtied_theme_option('secondary_font');

			$mfont = $shopkeeper_theme_options['new_main_font'];
			$sfont = $shopkeeper_theme_options['new_secondary_font']; 

			if (!empty($old_mfont) && is_string($old_mfont)) {
				$temp_mfont = array();
				$temp_mfont['font-family']= $old_mfont;
				if (isset($shopkeeper_theme_options['main_font_variants'])) {
					$temp_mfont['variant'] = $shopkeeper_theme_options['main_font_variants'];
				}

				set_theme_mod('new_main_font', $temp_mfont);
				set_theme_mod('main_font', false);
				$mfont= $temp_mfont;
				$shopkeeper_theme_options['new_main_font']= $mfont;
			}

			if (!empty($old_sfont) && is_string($old_sfont)) {
				$temp_sfont['font-family']= $old_sfont;
				if (isset($shopkeeper_theme_options['secondary_font_variants'])) {
					$temp_sfont['variant'] = $shopkeeper_theme_options['secondary_font_variants'];
				}

				set_theme_mod('new_secondary_font', $temp_sfont);
				set_theme_mod('secondary_font', false);
				$sfont= $temp_sfont;
				$shopkeeper_theme_options['new_secondary_font']= $sfont;
			}

		}            
		getbowtied_google_fonts();
		endif;

		
		ob_start();	
		?>
		
		<!-- ******************************************************************** -->
		<!-- * Theme Options Styles ********************************************* -->
		<!-- ******************************************************************** -->
			
		<style>
			
			/***************************************************************/
			/* Body ********************************************************/
			/***************************************************************/
			
			.st-content {			
				<?php if ( (isset($shopkeeper_theme_options['main_background']['background-color'])) ) : ?>
				background-color:<?php echo esc_html($shopkeeper_theme_options['main_background']['background-color']); ?>;
				<?php endif; ?>
				
				<?php if ( (isset($shopkeeper_theme_options['main_background']['background-image'])) && ($shopkeeper_theme_options['main_background']['background-image'] != "") ) : ?>
				background-image:url(<?php echo esc_url($shopkeeper_theme_options['main_background']['background-image']); ?>);
				<?php endif; ?>
				
				<?php if ( (isset($shopkeeper_theme_options['main_background']['background-repeat'])) && ($shopkeeper_theme_options['main_background']['background-repeat'] != "") ) : ?>
				background-repeat:<?php echo esc_html($shopkeeper_theme_options['main_background']['background-repeat']); ?>;
				<?php endif; ?>
				
				<?php if ( (isset($shopkeeper_theme_options['main_background']['background-position'])) && ($shopkeeper_theme_options['main_background']['background-position'] != "") ) : ?>
				background-position:<?php echo esc_html($shopkeeper_theme_options['main_background']['background-position']); ?>;
				<?php endif; ?>
				
				<?php if ( (isset($shopkeeper_theme_options['main_background']['background-size'])) && ($shopkeeper_theme_options['main_background']['background-size'] != "") ) : ?>
				background-size:<?php echo esc_html($shopkeeper_theme_options['main_background']['background-size']); ?>;
				<?php endif; ?>
				
				<?php if ( (isset($shopkeeper_theme_options['main_background']['background-attachment'])) && ($shopkeeper_theme_options['main_background']['background-attachment'] != "") ) : ?>
				background-attachment:<?php echo esc_html($shopkeeper_theme_options['main_background']['background-attachment']); ?>;
				<?php endif; ?>
			}
			
			/***************************************************************/
			/* Fonts *******************************************************/
			/***************************************************************/
			
			<?php //if ( (isset($shopkeeper_theme_options['main_font'])) && (trim($shopkeeper_theme_options['main_font']) != "" ) ) : ?>			
				h1, h2, h3, h4, h5, h6,
				.comments-title,
				.comment-author,
				#reply-title,
				#site-footer .widget-title,
				.accordion_title,
				.ui-tabs-anchor,
				.products .button,
				.site-title a,
				.post_meta_archive a,
				.post_meta a,
				.post_tags a,
				 #nav-below a,
				.list_categories a,
				.list_shop_categories a,
				.main-navigation > ul > li > a,
				.main-navigation .mega-menu > ul > li > a,
				.more-link,
				.top-page-excerpt,
				.select2-search input,
				.product_after_shop_loop_buttons a,
				.woocommerce .products-grid a.button,
				.page-numbers,
				input.qty,
				.button,
				button,
				.button_text,
				input[type="button"],
				input[type="reset"],
				input[type="submit"],
				button[type="submit"],
				.woocommerce a.button,
				.woocommerce-page a.button,
				.woocommerce button.button,
				.woocommerce-page button.button,
				.woocommerce input.button,
				.woocommerce-page input.button,
				.woocommerce #respond input#submit,
				.woocommerce-page #respond input#submit,
				.woocommerce #content input.button,
				.woocommerce-page #content input.button,
				.woocommerce a.button.alt,
				.woocommerce button.button.alt,
				.woocommerce input.button.alt,
				.woocommerce #respond input#submit.alt,
				.woocommerce #content input.button.alt,
				.woocommerce-page a.button.alt,
				.woocommerce-page button.button.alt,
				.woocommerce-page input.button.alt,
				.woocommerce-page #respond input#submit.alt,
				.woocommerce-page #content input.button.alt,
				.yith-wcwl-wishlistexistsbrowse.show a,
				.share-product-text,
				.tabs > li > a,
				label,
				.comment-respond label,
				.product_meta_title,
				.woocommerce table.shop_table th, 
				.woocommerce-page table.shop_table th,
				#map_button,
				.coupon_code_text,
				.woocommerce .cart-collaterals .cart_totals tr.order-total td strong,
				.woocommerce-page .cart-collaterals .cart_totals tr.order-total td strong,
				.cart-wishlist-empty,
				.cart-empty,
				.return-to-shop .wc-backward,
				.order-number a,
				.account_view_link,
				.post-edit-link,
				.from_the_blog_title,
				.icon_box_read_more,
				.vc_pie_chart_value,
				.shortcode_banner_simple_bullet,
				.shortcode_banner_simple_height_bullet,
				.category_name,
				.woocommerce span.onsale,
				.woocommerce-page span.onsale,
				.out_of_stock_badge_single,
				.out_of_stock_badge_loop,
				.page-numbers,
				.page-links,
				.add_to_wishlist,
				.yith-wcwl-wishlistaddedbrowse,
				.yith-wcwl-wishlistexistsbrowse,
				.filters-group,
				.product-name,
				.woocommerce-page .my_account_container table.shop_table.order_details_footer tr:last-child td:last-child .amount,
				.customer_details dt,
				.widget h3,
				.widget ul a,
				.widget a,
				.widget .total .amount,
				.wishlist-in-stock,
				.wishlist-out-of-stock,
				.comment-reply-link,
				.comment-edit-link,
				.widget_calendar table thead tr th,
				.page-type,
				.mobile-navigation a,
				table thead tr th,
				.portfolio_single_list_cat,
				.portfolio-categories,
				.shipping-calculator-button,
				.vc_btn,
				.vc_btn2,
				.vc_btn3,
				.account-tab-item .account-tab-link,
				.account-tab-list .sep,
				ul.order_details li,
				ul.order_details.bacs_details li,
				.widget_calendar caption,
				.widget_recent_comments li a,
				.edit-account legend,
				.widget_shopping_cart li.empty,
				.cart-collaterals .cart_totals .shop_table .order-total .woocommerce-Price-amount,
				.woocommerce table.cart .cart_item td a, 
				.woocommerce #content table.cart .cart_item td a, 
				.woocommerce-page table.cart .cart_item td a, 
				.woocommerce-page #content table.cart .cart_item td a,
				.woocommerce table.cart .cart_item td span, 
				.woocommerce #content table.cart .cart_item td span, 
				.woocommerce-page table.cart .cart_item td span, 
				.woocommerce-page #content table.cart .cart_item td span,
				.woocommerce-MyAccount-navigation ul li,
				.cd-quick-view .cd-item-info .product_infos .quickview-badges .onsale,	
				body.gbt_custom_notif .woocommerce-message .woocommerce-message-wrapper .notice_text,
				body.gbt_custom_notif .woocommerce-message .product_notification_text,
				.woocommerce-info.wc_points_rewards_earn_points,
				.woocommerce-info, .woocommerce-error, .woocommerce-message,
				body.gbt_custom_notif .woocommerce-info .woocommerce-message-wrapper .notice_text,
				.woocommerce .cart-collaterals .cart_totals .cart-subtotal th,
				.woocommerce-page .cart-collaterals .cart_totals .cart-subtotal th,
				.woocommerce .cart-collaterals .cart_totals tr.shipping th,
				.woocommerce-page .cart-collaterals .cart_totals tr.shipping th,
				.woocommerce .cart-collaterals .cart_totals tr.order-total th,
				.woocommerce-page .cart-collaterals .cart_totals tr.order-total th,
				.woocommerce .cart-collaterals .cart_totals h2,
				.woocommerce .cart-collaterals .cross-sells h2,
				.woocommerce-cart #content table.cart td.actions .coupon #coupon_code,
				form.checkout_coupon #coupon_code,
				.woocommerce-checkout .woocommerce-info,
				.shopkeeper_checkout_coupon,
				.shopkeeper_checkout_login,
				.minicart-message,
				.no-products-info p.woocommerce-error .notice_text,
				.woocommerce .woocommerce-checkout-review-order table.shop_table tfoot td,
				.woocommerce .woocommerce-checkout-review-order table.shop_table tfoot th,
				.woocommerce-page .woocommerce-checkout-review-order table.shop_table tfoot td,
				.woocommerce-page .woocommerce-checkout-review-order table.shop_table tfoot th,
				.no-products-info p,
				.getbowtied_blog_ajax_load_button a,
				.getbowtied_ajax_load_button a,
				.index-layout-2 ul.blog-posts .blog-post article .post-categories li a,
				.index-layout-3 .blog-posts_container ul.blog-posts .blog-post article .post-categories li a,
				.index-layout-2 ul.blog-posts .blog-post .post_content_wrapper .post_content .read_more,
				.index-layout-3 .blog-posts_container ul.blog-posts .blog-post article .post_content_wrapper .post_content .read_more,
				.woocommerce .woocommerce-breadcrumb,
				.woocommerce-page .woocommerce-breadcrumb,
				.woocommerce .woocommerce-breadcrumb a,
				.woocommerce-page .woocommerce-breadcrumb a,
				.product_meta,
				.product_meta span,
				.product_meta a,
				.product_layout_classic div.product span.price,
				.product_layout_classic div.product p.price,
				.product_layout_2 div.product span.price,
				.product_layout_2 div.product p.price,
				.product_layout_3 div.product span.price,
				.product_layout_3 div.product p.price,
				.product_layout_4 div.product span.price,
				.product_layout_4 div.product p.price,
				.related-products-title,
				.product_socials_wrapper .share-product-text,
				#button_offcanvas_sidebar_left .filters-text,
				.woocommerce-ordering select.orderby,
				.fr-position-text,
				.woocommerce #payment div.payment_box p,
	            .woocommerce-page #payment div.payment_box p,
				.woocommerce-checkout-review-order .woocommerce-checkout-review-order-table tr td,
				.catalog-ordering .select2-container.orderby a,
				.catalog-ordering .select2-container span,
				.woocommerce-ordering select.orderby,
				.woocommerce .cart-collaterals .cart_totals table.shop_table_responsive tr td::before, 
				.woocommerce-page .cart-collaterals .cart_totals table.shop_table_responsive tr td::before,
				.login-register-container .lost-pass-link,
				.woocommerce-cart .cart-collaterals .cart_totals table td .amount,
				.wpb_wrapper .add_to_cart_inline .woocommerce-Price-amount.amount,
				.woocommerce-page .cart-collaterals .cart_totals tr.shipping td,
				.woocommerce-page .cart-collaterals .cart_totals tr.shipping td,
				.woocommerce .cart-collaterals .cart_totals tr.cart-discount th,
				.woocommerce-page .cart-collaterals .cart_totals tr.cart-discount th,
				.woocommerce-thankyou-order-received,
				.woocommerce-order-received .woocommerce table.shop_table tfoot th, 
				.woocommerce-order-received .woocommerce-page table.shop_table tfoot th,
				.woocommerce-view-order .woocommerce table.shop_table tfoot th, 
				.woocommerce-view-order .woocommerce-page table.shop_table tfoot th,
				.woocommerce-order-received .woocommerce table.shop_table tfoot td, 
				.woocommerce-order-received .woocommerce-page table.shop_table tfoot td,
				.woocommerce-view-order .woocommerce table.shop_table tfoot td, 
				.woocommerce-view-order .woocommerce-page table.shop_table tfoot td,
				.language-and-currency #top_bar_language_list > ul > li,
				.language-and-currency .wcml_currency_switcher > ul > li.wcml-cs-active-currency,
				.language-and-currency-offcanvas #top_bar_language_list > ul > li,
				.language-and-currency-offcanvas .wcml_currency_switcher > ul > li.wcml-cs-active-currency,
				.woocommerce-order-pay .woocommerce .woocommerce-form-login p.lost_password a,
				.woocommerce-MyAccount-content .woocommerce-orders-table__cell-order-number a,
				.woocommerce form.login .lost_password,
				.comment-reply-title,
				.product_content_wrapper .product_infos .out_of_stock_wrapper .out_of_stock_badge_single,
				.product_content_wrapper .product_infos .woocommerce-variation-availability p.stock.out-of-stock,
				.site-search .widget_product_search .search-field,
				.site-search .widget_search .search-field,
				.site-search .search-form .search-field,
				.site-search .search-text,
				.site-search .search-no-suggestions,
				.woocommerce-privacy-policy-text p,
				.latest_posts_grid_wrapper .latest_posts_grid_title,
				p.has-drop-cap:not(:focus):first-letter,
				body.gbt_classic_notif .notice_text .restore-item,
				body.gbt_custom_notif.woocommerce-account .notice_text .restore-item,
				body.gbt_classic_notif .woocommerce-error a,
				body.gbt_custom_notif.woocommerce-account .woocommerce-error a,
				body.gbt_classic_notif .woocommerce-info a,
				body.gbt_custom_notif.woocommerce-account .woocommerce-info a,
				body.gbt_classic_notif .woocommerce-message a,
				body.gbt_custom_notif.woocommerce-account .woocommerce-message a,
				body.gbt_classic_notif .woocommerce-notice a,
				body.gbt_custom_notif.woocommerce-account .woocommerce-notice a,
				.paypal-button-tagline .paypal-button-text,
				.tinvwl_add_to_wishlist_button,
				.product-addon-totals
				{ 
					font-family: 
					<?php 
						if (isset($shopkeeper_theme_options['new_main_font']['font-family'])):
							if (!in_array($shopkeeper_theme_options['new_main_font']['font-family'], $default_fonts)): ?>
								<?php echo '\'' . $shopkeeper_theme_options['new_main_font']['font-family'] . '\','; ?> 
								sans-serif;
							<?php else: ?>
								<?php echo $shopkeeper_theme_options['new_main_font']['font-family']; ?>;
							<?php endif; ?>
						<?php else: ?>
							NeueEinstellung;
						<?php endif; ?>
				}			
			<?php //endif; ?>
			
			<?php //if ( (isset($shopkeeper_theme_options['secondary_font'])) && (trim($shopkeeper_theme_options['secondary_font']) != "" ) ) : ?>
				body,
				p,
				#site-navigation-top-bar,
				.site-title,
				.widget_product_search #searchsubmit,
				.widget_search #searchsubmit,
				.widget_product_search .search-submit,
				.widget_search .search-submit,
				#site-menu,
				.copyright_text,
				blockquote cite,
				table thead th,
				.recently_viewed_in_single h2,
				.woocommerce .cart-collaterals .cart_totals table th,
				.woocommerce-page .cart-collaterals .cart_totals table th,
				.woocommerce .cart-collaterals .shipping_calculator h2,
				.woocommerce-page .cart-collaterals .shipping_calculator h2,
				.woocommerce table.woocommerce-checkout-review-order-table tfoot th,
				.woocommerce-page table.woocommerce-checkout-review-order-table tfoot th,
				.qty,
				.shortcode_banner_simple_inside h4,
				.shortcode_banner_simple_height h4,
				.fr-caption,
				.post_meta_archive,
				.post_meta,
				.page-links-title,
				.yith-wcwl-wishlistaddedbrowse .feedback,
				.yith-wcwl-wishlistexistsbrowse .feedback,
				.product-name span,
				.widget_calendar table tbody a,
				.fr-touch-caption-wrapper,
				.woocommerce .login-register-container p.form-row.remember-me-row label,
				.woocommerce .checkout_login p.form-row label[for="rememberme"],
				.form-row.remember-me-row a,
				.wpb_widgetised_column aside ul li span.count,
				.woocommerce td.product-name dl.variation dt, 
				.woocommerce td.product-name dl.variation dd, 
				.woocommerce td.product-name dl.variation dt p, 
				.woocommerce td.product-name dl.variation dd p, 
				.woocommerce-page td.product-name dl.variation dt, 
				.woocommerce-page td.product-name dl.variation dd p, 
				.woocommerce-page td.product-name dl.variation dt p, 
				.woocommerce-page td.product-name dl.variation dd p,
				.woocommerce .select2-container,
				.check_label,
				.woocommerce-page #payment .terms label,
				ul.order_details li strong,
				.widget_recent_comments li,
				.widget_shopping_cart p.total,
				.widget_shopping_cart p.total .amount,
				.mobile-navigation li ul li a,
				.woocommerce table.cart .cart_item td:before, 
				.woocommerce #content table.cart .cart_item td:before, 
				.woocommerce-page table.cart .cart_item td:before, 
				.woocommerce-page #content table.cart .cart_item td:before,
				.language-and-currency #top_bar_language_list > ul > li > ul > li > a,
				.language-and-currency .wcml_currency_switcher > ul > li.wcml-cs-active-currency > ul.wcml-cs-submenu li a,
				.language-and-currency #top_bar_language_list > ul > li.menu-item-first > ul.sub-menu li.sub-menu-item span.icl_lang_sel_current,
				.language-and-currency-offcanvas  #top_bar_language_list > ul > li > ul > li > a,
				.language-and-currency-offcanvas  .wcml_currency_switcher > ul > li.wcml-cs-active-currency > ul.wcml-cs-submenu li a,
				.language-and-currency-offcanvas  #top_bar_language_list > ul > li.menu-item-first > ul.sub-menu li.sub-menu-item span.icl_lang_sel_current,
				.woocommerce-order-pay .woocommerce .woocommerce-info,
				body.gbt_classic_notif .notice_text,
				body.gbt_custom_notif.woocommerce-account .notice_text,
				.select2-results__option,
				body.gbt_classic_notif .woocommerce-error,
				body.gbt_custom_notif.woocommerce-account .woocommerce-error,
				body.gbt_classic_notif .woocommerce-info,
				body.gbt_custom_notif.woocommerce-account .woocommerce-info,
				body.gbt_classic_notif .woocommerce-message,
				body.gbt_custom_notif.woocommerce-account .woocommerce-message,
				body.gbt_classic_notif .woocommerce-notice,
				body.gbt_custom_notif.woocommerce-account .woocommerce-notice
				{
					font-family: 
					<?php if (isset($shopkeeper_theme_options['new_secondary_font']['font-family'])): ?>
						<?php if (!in_array($shopkeeper_theme_options['new_secondary_font']['font-family'], $default_fonts)): ?>
							<?php echo '\'' . $shopkeeper_theme_options['new_secondary_font']['font-family'] . '\','; ?> 
							sans-serif;
						<?php else: ?>
							<?php echo $shopkeeper_theme_options['new_secondary_font']['font-family'] .', sans-serif'; ?>;
						<?php endif; ?>
					<?php else: ?>
						'Radnika';
					<?php endif; ?>
				}			
			<?php //endif; ?>
			
			/***************************************************************/
			/* Custom Font sizes *******************************************/
			/***************************************************************/
			
			<?php 

				if (!empty($shopkeeper_theme_options['headings_font_size'])): 

					$headings_base_size = $shopkeeper_theme_options['headings_font_size'];
					$h0_size = $headings_base_size * 3.157;
					$h1_size = $headings_base_size * 2.369;
					$h2_size = $headings_base_size * 1.777; 
					$h3_size = $headings_base_size * 1.333; 
					$h4_size = $headings_base_size * 1; 
					$h5_size = $headings_base_size * 0.75; 
					$mobile_base_size = 13;
					$h0_size_mobile = $mobile_base_size * 3.157;
					$h1_size_mobile = $mobile_base_size * 2.369;
					$h2_size_mobile = $mobile_base_size * 1.777; 
					$h3_size_mobile = $mobile_base_size * 1.333; 
					$h4_size_mobile = $mobile_base_size * 1; 
					$h5_size_mobile = $mobile_base_size * 0.75; 

					?> 

					h1, .woocommerce h1, .woocommerce-page h1 { font-size: <?php echo $h1_size_mobile; ?>px; }
					h2, .woocommerce h2, .woocommerce-page h2 { font-size: <?php echo $h2_size_mobile; ?>px; }
					h3, .woocommerce h3, .woocommerce-page h3 { font-size: <?php echo $h3_size_mobile; ?>px; } 
					h4, .woocommerce h4, .woocommerce-page h4 { font-size: <?php echo $h4_size_mobile; ?>px; }
					h5, .woocommerce h5, .woocommerce-page h5 { font-size: <?php echo $h5_size_mobile; ?>px; }

					.page-title.blog-listing,
					.woocommerce .page-title,
					.page-title,
					.single .entry-title,
					.woocommerce-cart .page-title,
					.woocommerce-checkout .page-title,
					.woocommerce-account .page-title
					{
						font-size: <?php echo $h0_size_mobile; ?>px;
					}

					p.has-drop-cap:first-letter
					{
						font-size: <?php echo $h0_size_mobile; ?>px !important;
					}

					.entry-title-archive
					{
						font-size: <?php echo $h3_size; ?>px;
					}

					.woocommerce #content div.product .product_title, 
					.woocommerce div.product .product_title, 
					.woocommerce-page #content div.product .product_title, 
					.woocommerce-page div.product .product_title
					{
						font-size: <?php echo $h2_size_mobile; ?>px;
					}

					.woocommerce-checkout .content-area h3,
					.woocommerce-view-order h2,
					.woocommerce-edit-address h3,
					.woocommerce-edit-account legend
					{
						font-size: <?php echo $h4_size_mobile; ?>px;
					}

					@media only screen and (max-width: 768px)
					{
						.shortcode_getbowtied_slider .swiper-slide h2
						{
							 font-size: <?php echo $h1_size_mobile; ?>px !important;
						}
					}

					@media only screen and (min-width: 768px) {

						h1, .woocommerce h1, .woocommerce-page h1 { font-size: <?php echo $h1_size; ?>px; }
						h2, .woocommerce h2, .woocommerce-page h2 { font-size: <?php echo $h2_size; ?>px; }
						h3, .woocommerce h3, .woocommerce-page h3 { font-size: <?php echo $h3_size; ?>px; } 
						h4, .woocommerce h4, .woocommerce-page h4 { font-size: <?php echo $h4_size; ?>px; }
						h5, .woocommerce h5, .woocommerce-page h5 { font-size: <?php echo $h5_size; ?>px; }

						.page-title.blog-listing,
						.woocommerce .page-title,
						.page-title,
						.single .entry-title,
						.woocommerce-cart .page-title,
						.woocommerce-checkout .page-title,
						.woocommerce-account .page-title					
						{
							font-size: <?php echo $h0_size; ?>px;
						}

						p.has-drop-cap:first-letter
						{
							font-size: <?php echo $h0_size; ?>px !important; 
						}

						.entry-title-archive
						{
							font-size: <?php echo $h3_size; ?>px;
						}

						.woocommerce-checkout .content-area h3,
						.woocommerce-view-order h2,
						.woocommerce-edit-address h3,
						.woocommerce-edit-account legend,
						.woocommerce-order-received h2,
						.fr-position-text
						{
							font-size: <?php echo $h4_size; ?>px;
						}

					}

					@media only screen and (min-width: 1025px) {

						.woocommerce #content div.product .product_title, 
						.woocommerce div.product .product_title, 
						.woocommerce-page #content div.product .product_title, 
						.woocommerce-page div.product .product_title
						{
							font-size: <?php echo $h2_size; ?>px;
						}

					}

					.@media only screen and (max-width: 1024px) {

						.woocommerce #content div.product .product_title, 
						.woocommerce div.product .product_title, 
						.woocommerce-page #content div.product .product_title, 
						.woocommerce-page div.product .product_title
						{
							font-size: <?php echo $h2_size_mobile; ?>px;
						}

					}

			<?php 

				endif;

			?>


			<?php 


				if (!empty($shopkeeper_theme_options['body_font_size'])): 

					$body_base_size = $shopkeeper_theme_options['body_font_size'];

					?> 

					@media only screen and (min-width: 1025px) { 
						p,
						.woocommerce table.shop_attributes th,
						.woocommerce-page table.shop_attributes th,
						.woocommerce table.shop_attributes td,
						.woocommerce-page table.shop_attributes td,
						.woocommerce-review-link,
						.blog-isotope .entry-content-archive,
						.blog-isotope .entry-content-archive *,
						body.gbt_classic_notif .notice_text,
						body.gbt_custom_notif.woocommerce-account .notice_text,
						.woocommerce-error, .woocommerce-info,
						.woocommerce-store-notice, p.demo_store,
						ul li ul,
						ul li ol,
						ul, ol, dl
						{ font-size: <?php echo $body_base_size; ?>px; }
					}

					.woocommerce ul.order_details li strong,
					.fr-caption,
					.woocommerce-order-pay .woocommerce .woocommerce-info
					{ font-size: <?php echo $body_base_size; ?>px !important; }
			<?php 

				endif;

			?>

			<?php 


				if (!empty($shopkeeper_theme_options['product_title_font_size'])): 

					$product_title_font_size = $shopkeeper_theme_options['product_title_font_size'];

					?> 

					@media only screen and (min-width: 768px) { 
						.woocommerce .product-title-link { 
							font-size: <?php echo $product_title_font_size; ?>px !important; 
						}
					}
						
			<?php 

				endif;

			?>


		
			/***************************************************************/
			/* Body Text Colors  *******************************************/
			/***************************************************************/
			
			<?php if ( (isset($shopkeeper_theme_options['body_color'])) && (trim($shopkeeper_theme_options['body_color']) != "" ) ) : ?>
			body,
			table tr th,
			table tr td,
			table thead tr th,
			blockquote p,
			label,
			.select2-dropdown-open.select2-drop-above .select2-choice,
			.select2-dropdown-open.select2-drop-above .select2-choices, 
			.select2-container,
			.big-select,
			.select.big-select,
			.post_meta_archive a,
			.post_meta a,
			.nav-next a,
			.nav-previous a,
			.blog-single h6,
			.page-description,
			.woocommerce #content nav.woocommerce-pagination ul li a:focus,
			.woocommerce #content nav.woocommerce-pagination ul li a:hover,
			.woocommerce #content nav.woocommerce-pagination ul li span.current,
			.woocommerce nav.woocommerce-pagination ul li a:focus,
			.woocommerce nav.woocommerce-pagination ul li a:hover,
			.woocommerce nav.woocommerce-pagination ul li span.current,
			.woocommerce-page #content nav.woocommerce-pagination ul li a:focus,
			.woocommerce-page #content nav.woocommerce-pagination ul li a:hover,
			.woocommerce-page #content nav.woocommerce-pagination ul li span.current,
			.woocommerce-page nav.woocommerce-pagination ul li a:focus,
			.woocommerce-page nav.woocommerce-pagination ul li a:hover,
			.woocommerce-page nav.woocommerce-pagination ul li span.current,
			.posts-navigation .page-numbers a:hover,
			.woocommerce table.shop_table th,
			.woocommerce-page table.shop_table th,
			.woocommerce-checkout .woocommerce-info,
			.customer_details dt,
			.wpb_widgetised_column .widget a,
			.wpb_widgetised_column .widget.widget_product_categories a:hover,
			.wpb_widgetised_column .widget.widget_layered_nav a:hover,
			.wpb_widgetised_column .widget.widget_layered_nav li,
			.portfolio_single_list_cat a,
			.gallery-caption-trigger,
			.woocommerce .widget_layered_nav ul li.chosen a,
			.woocommerce-page .widget_layered_nav ul li.chosen a,
			.widget_layered_nav ul li.chosen a,
			.woocommerce .widget_product_categories ul li.current-cat > a,
			.woocommerce-page .widget_product_categories ul li.current-cat > a,
			.widget_product_categories ul li.current-cat > a,
			.wpb_widgetised_column .widget.widget_layered_nav_filters a,
			.widget_shopping_cart p.total,
			.widget_shopping_cart p.total .amount,
			.wpb_widgetised_column .widget_shopping_cart li.empty,
			.index-layout-2 ul.blog-posts .blog-post article .post-date,
	 		.cd-quick-view .cd-close:after,
			form.checkout_coupon #coupon_code,
			.woocommerce .product_infos .quantity input.qty, .woocommerce #content .product_infos .quantity input.qty,
			.woocommerce-page .product_infos .quantity input.qty, .woocommerce-page #content .product_infos .quantity input.qty,
			.woocommerce-cart.woocommerce-page #content .quantity input.qty,
			#button_offcanvas_sidebar_left,
			.fr-position-text,
			.quantity.custom input.custom-qty,
			.add_to_wishlist,
			.product_infos .add_to_wishlist:before,
			.product_infos .yith-wcwl-wishlistaddedbrowse:before,
			.product_infos .yith-wcwl-wishlistexistsbrowse:before,
			#add_payment_method #payment .payment_method_paypal .about_paypal,
			.woocommerce-cart #payment .payment_method_paypal .about_paypal,
			.woocommerce-checkout #payment .payment_method_paypal .about_paypal,
			#stripe-payment-data > p > a,
			.product-name .product-quantity,
			.woocommerce #payment div.payment_box,
			.woocommerce-order-pay #order_review .shop_table tr.order_item td.product-quantity strong,
			.tinvwl_add_to_wishlist_button:before
			{
				color: <?php echo esc_html($shopkeeper_theme_options['body_color']); ?>;
			}
			
			.woocommerce a.remove,
			.woocommerce a.remove:after,
			a.woocommerce-remove-coupon:after,
			.shopkeeper-continue-shopping .button,
			.checkout_coupon_inner.focus:after,
			.checkout_coupon_inner:before,
			.woocommerce-cart .entry-content .woocommerce .actions>.button,
			.fr-caption,
			.woocommerce-order-pay .woocommerce .woocommerce-info,
			body.gbt_classic_notif .woocommerce-info::before,
			body.gbt_custom_notif.woocommerce-account .woocommerce-info::before
			{
				color: <?php echo esc_html($shopkeeper_theme_options['body_color']); ?> !important;
			}
			
			.nav-previous-title,
			.nav-next-title,
			.post_tags a,
			.wpb_widgetised_column .tagcloud a,
			.products .add_to_wishlist:before
			{
				color: rgba(<?php echo getbowtied_hex2rgb($shopkeeper_theme_options['body_color']); ?>,0.4);
			}
			
			.required/*,
			.woocommerce a.remove*/
			{
				color: rgba(<?php echo getbowtied_hex2rgb($shopkeeper_theme_options['body_color']); ?>,0.4) !important;
			}
			
			.yith-wcwl-add-button,
			.yith-wcwl-wishlistaddedbrowse,
			.yith-wcwl-wishlistexistsbrowse,
			.share-product-text,
			.product_meta,
			.product_meta a,
			.product_meta_separator,
			.woocommerce table.shop_attributes td,
			.woocommerce-page table.shop_attributes td,
			.tob_bar_shop,
			.post_meta_archive,
			.post_meta,
			del,
			.wpb_widgetised_column .widget li,
			.wpb_widgetised_column .widget_calendar table thead tr th,
			.wpb_widgetised_column .widget_calendar table thead tr td,
			.wpb_widgetised_column .widget .post-date,
			.wpb_widgetised_column .recentcomments,
			.wpb_widgetised_column .amount,
			.wpb_widgetised_column .quantity,
			.products li:hover .add_to_wishlist:before,
			.product_after_shop_loop .price,
			.product_after_shop_loop .price ins,
			
			.wpb_widgetised_column .widget_price_filter .price_slider_amount,
			.woocommerce td.product-name dl.variation dt, 
			.woocommerce td.product-name dl.variation dd, 
			.woocommerce td.product-name dl.variation dt p, 
			.woocommerce td.product-name dl.variation dd p, 
			.woocommerce-page td.product-name dl.variation dt, 
			.woocommerce-page td.product-name dl.variation dd p, 
			.woocommerce-page td.product-name dl.variation dt p, 
			.woocommerce-page td.product-name dl.variation dd p,
			.product_layout_classic div.product .product_infos form.cart .quantity.custom .minus-btn,
			.product_layout_classic div.product .product_infos form.cart .quantity.custom .plus-btn,
			.product_layout_2 div.product .product_infos form.cart .quantity.custom .minus-btn,
			.product_layout_2 div.product .product_infos form.cart .quantity.custom .plus-btn,
			.product_layout_3 div.product .product_infos form.cart .quantity.custom .minus-btn,
			.product_layout_3 div.product .product_infos form.cart .quantity.custom .plus-btn,
			.product_layout_4 div.product .product_infos form.cart .quantity.custom .minus-btn,
			.product_layout_4 div.product .product_infos form.cart .quantity.custom .plus-btn,
			.cd-quick-view .cd-item-info .product_infos .cart .quantity.custom .minus-btn,
			.cd-quick-view .cd-item-info .product_infos .cart .quantity.custom .plus-btn,
			table.shop_table tr.cart_item .quantity.custom .minus-btn,
			table.shop_table tr.cart_item .quantity.custom .plus-btn,
			.product .product_after_shop_loop .product_after_shop_loop_price span.price .woocommerce-Price-amount.amount,
			.woocommerce .woocommerce-breadcrumb,
			.woocommerce-page .woocommerce-breadcrumb,
			.woocommerce .woocommerce-breadcrumb a,
			.woocommerce-page .woocommerce-breadcrumb a,
			.archive .products-grid li .product_thumbnail_wrapper > .price .woocommerce-Price-amount,
			.site-search .search-text,
			.site-search .site-search-close .close-button:hover,
			.menu-close .close-button:hover,
			.site-search .woocommerce-product-search:after,
			.site-search .widget_search .search-form:after
			{
				color: rgba(<?php echo getbowtied_hex2rgb($shopkeeper_theme_options['body_color']); ?>,0.55);
			}

			.products a.button.add_to_cart_button.loading,
			.wpb_wrapper .add_to_cart_inline del .woocommerce-Price-amount.amount
			{
				color: rgba(<?php echo getbowtied_hex2rgb($shopkeeper_theme_options['body_color']); ?>,0.55) !important;
			}

			.yith-wcwl-add-to-wishlist:after,
			.bg-image-wrapper.no-image,
			.site-search .spin:before,
			.site-search .spin:after
			{
				background-color: rgba(<?php echo getbowtied_hex2rgb($shopkeeper_theme_options['body_color']); ?>,0.55);
			}

			.woocommerce-thankyou-order-details
			{
				background-color: rgba(<?php echo getbowtied_hex2rgb($shopkeeper_theme_options['body_color']); ?>,0.25);
			}

			.product_layout_2 .product_content_wrapper .product-images-wrapper .product-images-style-2 .product_images .product-image .caption:before,
			.product_layout_3 .product_content_wrapper .product-images-wrapper .product-images-style-3 .product_images .product-image .caption:before,
			.fr-caption:before,
			.product_content_wrapper .product-images-wrapper .product_images .product-images-controller .dot.current
			{
				background-color: <?php echo $shopkeeper_theme_options['body_color']; ?>;	
			}


			.product_content_wrapper .product-images-wrapper .product_images .product-images-controller .dot
			{
				background-color: rgba(<?php echo getbowtied_hex2rgb($shopkeeper_theme_options['body_color']); ?>,0.55);
			}
			
			#add_payment_method #payment div.payment_box .wc-credit-card-form,
			.woocommerce-account.woocommerce-add-payment-method #add_payment_method #payment div.payment_box .wc-payment-form,
			.woocommerce-cart #payment div.payment_box .wc-credit-card-form,
			.woocommerce-checkout #payment div.payment_box .wc-credit-card-form,
			.cd-quick-view .cd-item-info .product_infos .out_of_stock_wrapper .out_of_stock_badge_single,
			.product_content_wrapper .product_infos .woocommerce-variation-availability p.stock.out-of-stock,
			.product_layout_classic .product_infos .out_of_stock_wrapper .out_of_stock_badge_single,
			.product_layout_2 .product_content_wrapper .product_infos .out_of_stock_wrapper .out_of_stock_badge_single,
			.product_layout_3 .product_content_wrapper .product_infos .out_of_stock_wrapper .out_of_stock_badge_single,
			.product_layout_4 .product_content_wrapper .product_infos .out_of_stock_wrapper .out_of_stock_badge_single
			{
				border-color: rgba(<?php echo getbowtied_hex2rgb($shopkeeper_theme_options['body_color']); ?>,0.55);
			}

			
			.add_to_cart_inline .amount,
			.wpb_widgetised_column .widget,
			.wpb_widgetised_column .widget a:hover,
			.wpb_widgetised_column .widget.widget_product_categories a,
			.wpb_widgetised_column .widget.widget_layered_nav a,
			.widget_layered_nav ul li a,
			.widget_layered_nav,
			.wpb_widgetised_column aside ul li span.count,
			.shop_table.cart .product-price .amount
			
			{
				color: rgba(<?php echo getbowtied_hex2rgb($shopkeeper_theme_options['body_color']); ?>,0.8);
			}
			
			input[type="text"],
			input[type="password"],
			input[type="date"],
			input[type="datetime"],
			input[type="datetime-local"],
			input[type="month"], input[type="week"],
			input[type="email"], input[type="number"],
			input[type="search"], input[type="tel"],
			input[type="time"], input[type="url"],
			textarea,
			select,
			.chosen-container-single .chosen-single,
			.country_select.select2-container,
			#billing_country_field .select2-container,
			#billing_state_field .select2-container,
			#calc_shipping_country_field .select2-container,
			#calc_shipping_state_field .select2-container,
			.woocommerce-widget-layered-nav-dropdown .select2-container .select2-selection--single,
			.woocommerce-widget-layered-nav-dropdown .select2-container .select2-selection--multiple,
			#shipping_country_field .select2-container,
			#shipping_state_field .select2-container,
			.woocommerce-address-fields .select2-container--default .select2-selection--single,
			.woocommerce-shipping-calculator .select2-container--default .select2-selection--single,
			.select2-container--default .select2-search--dropdown .select2-search__field,
			.woocommerce form .form-row.woocommerce-validated .select2-container .select2-selection,
			.woocommerce form .form-row.woocommerce-validated .select2-container,
			.woocommerce form .form-row.woocommerce-validated input.input-text,
			.woocommerce form .form-row.woocommerce-validated select,
			.woocommerce form .form-row.woocommerce-invalid .select2-container,
			.woocommerce form .form-row.woocommerce-invalid input.input-text,
			.woocommerce form .form-row.woocommerce-invalid select,
			.country_select.select2-container,
			.state_select.select2-container,
			#coupon_code
			{
				border-color: rgba(<?php echo getbowtied_hex2rgb($shopkeeper_theme_options['body_color']); ?>,0.1) !important;
			}
			
			input[type="text"]:focus, input[type="password"]:focus,
			input[type="date"]:focus, input[type="datetime"]:focus,
			input[type="datetime-local"]:focus, input[type="month"]:focus,
			input[type="week"]:focus, input[type="email"]:focus,
			input[type="number"]:focus, input[type="search"]:focus,
			input[type="tel"]:focus, input[type="time"]:focus,
			input[type="url"]:focus, textarea:focus,
			select:focus,
			#coupon_code:focus,
			.chosen-container-single .chosen-single:focus,
			.select2-dropdown,
			.woocommerce .product_infos .quantity input.qty,
			.woocommerce #content .product_infos .quantity input.qty,
			.woocommerce-page .product_infos .quantity input.qty,
			.woocommerce-page #content .product_infos .quantity input.qty,
			.post_tags a,
			.wpb_widgetised_column .tagcloud a,
			.coupon_code_wrapper,
			.woocommerce form.checkout_coupon,
			.woocommerce-page form.checkout_coupon,
			.woocommerce ul.digital-downloads:before,
			.woocommerce-page ul.digital-downloads:before,
			.woocommerce ul.digital-downloads li:after,
			.woocommerce-page ul.digital-downloads li:after,
			.widget_search .search-form,
			.woocommerce .widget_layered_nav ul li a:before,
			.woocommerce-page .widget_layered_nav ul li a:before,
			.widget_layered_nav ul li a:before,
			.woocommerce .widget_product_categories ul li a:before,
			.woocommerce-page .widget_product_categories ul li a:before,
			.widget_product_categories ul li a:before,
			.woocommerce-cart.woocommerce-page #content .quantity input.qty,
			.cd-quick-view .cd-item-info .product_infos .cart .quantity input.qty, 
			.cd-quick-view .cd-item-info .product_infos .cart .woocommerce .quantity .qty,
			.woocommerce .order_review_wrapper table.shop_table tfoot tr:first-child td,
			.woocommerce-page .order_review_wrapper table.shop_table tfoot tr:first-child td,
			.woocommerce .order_review_wrapper table.shop_table tfoot tr:first-child th,
			.woocommerce-page .order_review_wrapper table.shop_table tfoot tr:first-child th,
			.select2-container .select2-dropdown--below
			{
				border-color: rgba(<?php echo getbowtied_hex2rgb($shopkeeper_theme_options['body_color']); ?>,0.15) !important;
			}

			.site-search .spin
			{
				border-color: rgba(<?php echo getbowtied_hex2rgb($shopkeeper_theme_options['body_color']); ?>,0.55);
			}
			
			.list-centered li a,
			.my_address_title,
			.woocommerce .shop_table.order_details tbody tr:last-child td,
			.woocommerce-page .shop_table.order_details tbody tr:last-child td,
			.woocommerce #payment ul.payment_methods li,
			.woocommerce-page #payment ul.payment_methods li,
			.comment-separator,
			.comment-list .pingback,
			.wpb_widgetised_column .widget,
			.search_result_item,
			.woocommerce div.product .woocommerce-tabs ul.tabs li:after,
			.woocommerce #content div.product .woocommerce-tabs ul.tabs li:after,
			.woocommerce-page div.product .woocommerce-tabs ul.tabs li:after,
			.woocommerce-page #content div.product .woocommerce-tabs ul.tabs li:after,
			.woocommerce-checkout .woocommerce-customer-details h2,
			.off-canvas .menu-close
			{
				border-bottom-color: rgba(<?php echo getbowtied_hex2rgb($shopkeeper_theme_options['body_color']); ?>,0.15);
			}
			
			table tr td,
			.woocommerce table.shop_table td,
			.woocommerce-page table.shop_table td,
			.product_socials_wrapper,
			.woocommerce-tabs,
			.comments_section,
			.portfolio_content_nav #nav-below,
			.product_meta,
			.woocommerce .shop_table.woocommerce-checkout-review-order-table tr.cart-subtotal th,
			.woocommerce .shop_table.woocommerce-checkout-review-order-table tr.cart-subtotal td
			{
				border-top-color: rgba(<?php echo getbowtied_hex2rgb($shopkeeper_theme_options['body_color']); ?>,0.15);
			}

			.product_socials_wrapper,
			.product_meta
			{
				border-bottom-color: rgba(<?php echo getbowtied_hex2rgb($shopkeeper_theme_options['body_color']); ?>,0.15);
			}

			.woocommerce .cart-collaterals .cart_totals .order-total td,
			.woocommerce .cart-collaterals .cart_totals .order-total th,
			.woocommerce-page .cart-collaterals .cart_totals .order-total td,
			.woocommerce-page .cart-collaterals .cart_totals .order-total th,
			.woocommerce .cart-collaterals .cart_totals h2,
			.woocommerce .cart-collaterals .cross-sells h2,
			.woocommerce-page .cart-collaterals .cart_totals h2,
			.woocommerce-cart .woocommerce table.shop_table.cart tr:not(:nth-last-child(-n+2))
			{
				border-bottom-color: rgba(<?php echo getbowtied_hex2rgb($shopkeeper_theme_options['body_color']); ?>,0.05);
			}


			.woocommerce .cart-collaterals .cart_totals tr.shipping th,
			.woocommerce-page .cart-collaterals .cart_totals tr.shipping th,
			.woocommerce .cart-collaterals .cart_totals tr.order-total th,
			.woocommerce-page .cart-collaterals .cart_totals h2,
			.woocommerce .cart-collaterals .cart_totals table tr.order-total td:last-child,
			.woocommerce-page .cart-collaterals .cart_totals table tr.order-total td:last-child
			{
				border-top-color: rgba(<?php echo getbowtied_hex2rgb($shopkeeper_theme_options['body_color']); ?>,0.05);
			}




			table.shop_attributes tr td,
			.wishlist_table tr td,
			.shop_table.cart tr td
			{
				border-bottom-color: rgba(<?php echo getbowtied_hex2rgb($shopkeeper_theme_options['body_color']); ?>,0.1);
			}
			
			.woocommerce .cart-collaterals,
			.woocommerce-page .cart-collaterals,
			.checkout_right_wrapper,
			.track_order_form,
			.order-info
			{
				background: rgba(<?php echo getbowtied_hex2rgb($shopkeeper_theme_options['body_color']); ?>,0.05);
			}
			
			.woocommerce-cart .cart-collaterals:before,
			.woocommerce-cart .cart-collaterals:after,
			.custom_border:before,
			.custom_border:after,
			.woocommerce-order-pay #order_review:before,
			.woocommerce-order-pay #order_review:after
			{
				background-image: radial-gradient(closest-side, transparent 9px, rgba(<?php echo getbowtied_hex2rgb($shopkeeper_theme_options['body_color']); ?>,0.05) 100%);
			}
			
			.wpb_widgetised_column aside ul li span.count,
			.product-video-icon
			{
				background: rgba(<?php echo getbowtied_hex2rgb($shopkeeper_theme_options['body_color']); ?>,0.05);
			}
			
			.comments_section
			{
				background-color: rgba(<?php echo getbowtied_hex2rgb($shopkeeper_theme_options['body_color']); ?>,0.01) !important;
			}
			
			<?php endif; ?>
			
			<?php if ( (isset($shopkeeper_theme_options['headings_color'])) && (trim($shopkeeper_theme_options['headings_color']) != "" ) ) : ?>
			h1, h2, h3, h4, h5, h6,
			.entry-title-archive a,
			.woocommerce #content div.product .woocommerce-tabs ul.tabs li.active a,
			.woocommerce div.product .woocommerce-tabs ul.tabs li.active a,
			.woocommerce-page #content div.product .woocommerce-tabs ul.tabs li.active a,
			.woocommerce-page div.product .woocommerce-tabs ul.tabs li.active a,
			.woocommerce #content div.product .woocommerce-tabs ul.tabs li.active a:hover,
			.woocommerce div.product .woocommerce-tabs ul.tabs li.active a:hover,
			.woocommerce-page #content div.product .woocommerce-tabs ul.tabs li.active a:hover,
			.woocommerce-page div.product .woocommerce-tabs ul.tabs li.active a:hover,
			.woocommerce table.cart .product-name a,
			.product-title-link,
			.wpb_widgetised_column .widget .product_list_widget a,
			.woocommerce .cart-collaterals .cart_totals .cart-subtotal th,
			.woocommerce-page .cart-collaterals .cart_totals .cart-subtotal th,
			.woocommerce .cart-collaterals .cart_totals tr.shipping th,
			.woocommerce-page .cart-collaterals .cart_totals tr.shipping th,
			.woocommerce-page .cart-collaterals .cart_totals tr.shipping th,
			.woocommerce-page .cart-collaterals .cart_totals tr.shipping td,
			.woocommerce-page .cart-collaterals .cart_totals tr.shipping td,
			.woocommerce .cart-collaterals .cart_totals tr.cart-discount th,
			.woocommerce-page .cart-collaterals .cart_totals tr.cart-discount th,
			.woocommerce .cart-collaterals .cart_totals tr.order-total th,
			.woocommerce-page .cart-collaterals .cart_totals tr.order-total th,
			.woocommerce .cart-collaterals .cart_totals h2,
			.woocommerce .cart-collaterals .cross-sells h2,
			.woocommerce .order_review_wrapper table.shop_table tfoot th,
			.woocommerce .order_review_wrapper table.shop_table thead th,
			.woocommerce-page .order_review_wrapper table.shop_table tfoot th,
			.woocommerce-page .order_review_wrapper table.shop_table thead th,
			.index-layout-2 ul.blog-posts .blog-post .post_content_wrapper .post_content .read_more,
			.index-layout-2 .with-sidebar ul.blog-posts .blog-post .post_content_wrapper .post_content .read_more,
			.index-layout-2 ul.blog-posts .blog-post .post_content_wrapper .post_content .read_more,
			.index-layout-3 .blog-posts_container ul.blog-posts .blog-post article .post_content_wrapper .post_content .read_more,
			.fr-window-skin-fresco.fr-svg .fr-side-next .fr-side-button-icon:before,
			.fr-window-skin-fresco.fr-svg .fr-side-previous .fr-side-button-icon:before,
			.fr-window-skin-fresco.fr-svg .fr-close .fr-close-icon:before,
			#button_offcanvas_sidebar_left .filters-icon,
			#button_offcanvas_sidebar_left .filters-text,
			.select2-container .select2-choice,
			.shop_header .list_shop_categories li.category_item > a,
			.shortcode_getbowtied_slider .swiper-button-prev,
			.shortcode_getbowtied_slider .swiper-button-next,
			.shortcode_getbowtied_slider .shortcode-slider-pagination,
			.yith-wcwl-wishlistexistsbrowse.show a,
			.product_socials_wrapper .product_socials_wrapper_inner a,
			.product_navigation #nav-below .product-nav-previous a, 
			.product_navigation #nav-below .product-nav-next a,
			.cd-top,
			.fr-position-outside .fr-position-text,
			.fr-position-inside .fr-position-text,
			a.add_to_wishlist,
			.yith-wcwl-add-to-wishlist a,
			order_review_wrapper .woocommerce-checkout-review-order-table tr td,
			.order_review_wrapper .woocommerce-checkout-review-order-table ul li label,
			.order_review_wrapper .woocommerce-checkout-payment ul li label,
			.cart-collaterals .cart_totals .shop_table tr.cart-subtotal td,
			.cart-collaterals .cart_totals .shop_table tr.shipping td label,
			.cart-collaterals .cart_totals .shop_table tr.order-total td,
			.catalog-ordering select.orderby,
			.woocommerce .cart-collaterals .cart_totals table.shop_table_responsive tr td::before, 
			.woocommerce .cart-collaterals .cart_totals table.shop_table_responsive tr td 
			.woocommerce-page .cart-collaterals .cart_totals table.shop_table_responsive tr td::before,
			.shopkeeper_checkout_coupon, .shopkeeper_checkout_login,
			.wpb_wrapper .add_to_cart_inline .woocommerce-Price-amount.amount,
			.list-centered li a,
			tr.cart-discount td,
			section.woocommerce-customer-details table.woocommerce-table--customer-details th,
			.woocommerce-order-pay #order_review .shop_table tr td,
			.woocommerce-order-pay #order_review .shop_table tr th,
			.woocommerce-order-pay #order_review #payment ul li label,
			.woocommerce .shop_table.woocommerce-checkout-review-order-table tfoot tr td, 
			.woocommerce-page .shop_table.woocommerce-checkout-review-order-table tfoot tr td,
			.woocommerce .shop_table.woocommerce-checkout-review-order-table tr td,
			.woocommerce-page .shop_table.woocommerce-checkout-review-order-table tr td,
			.woocommerce .shop_table.woocommerce-checkout-review-order-table tfoot th,
			.woocommerce-page .shop_table.woocommerce-checkout-review-order-table tfoot th,
			ul.wc_payment_methods.payment_methods.methods li.wc_payment_method > label,
			form.checkout .shop_table.woocommerce-checkout-review-order-table tr:last-child th,
			#reply-title,
			.product_infos .out_of_stock_wrapper .out_of_stock_badge_single,
			.product_content_wrapper .product_infos .woocommerce-variation-availability p.stock.out-of-stock,
			p.has-drop-cap:first-letter,
			.tinvwl_add_to_wishlist_button
			{
				color: <?php echo esc_html($shopkeeper_theme_options['headings_color']); ?>;
			}

			.index-layout-2 ul.blog-posts .blog-post .post_content_wrapper .post_content h3.entry-title a,
			.index-layout-3 .blog-posts_container ul.blog-posts .blog-post article .post_content_wrapper .post_content .entry-title > a,
			#masonry_grid a.more-link,
			.account-tab-link:hover,
			.account-tab-link:active,
			.account-tab-link:focus,
			.catalog-ordering span.select2-container span,
			.catalog-ordering .select2-container .selection .select2-selection__arrow:before,
			.latest_posts_grid_wrapper .latest_posts_grid_title
			{
				color: <?php echo esc_html($shopkeeper_theme_options['headings_color']) ?>!important;
			}

		
			.index-layout-2 ul.blog-posts .blog-post .post_content_wrapper .post_content .read_more:before,
			.index-layout-3 .blog-posts_container ul.blog-posts .blog-post article .post_content_wrapper .post_content .read_more:before,
			#masonry_grid a.more-link:before		
			{
				background-color: <?php echo esc_html($shopkeeper_theme_options['headings_color']); ?>;
			}
			
			.woocommerce div.product .woocommerce-tabs ul.tabs li a,
			.woocommerce #content div.product .woocommerce-tabs ul.tabs li a,
			.woocommerce-page div.product .woocommerce-tabs ul.tabs li a,
			.woocommerce-page #content div.product .woocommerce-tabs ul.tabs li a
			{
				color: rgba(<?php echo getbowtied_hex2rgb($shopkeeper_theme_options['headings_color']); ?>,0.35);
			}
			
			.woocommerce #content div.product .woocommerce-tabs ul.tabs li a:hover,
			.woocommerce div.product .woocommerce-tabs ul.tabs li a:hover,
			.woocommerce-page #content div.product .woocommerce-tabs ul.tabs li a:hover,
			.woocommerce-page div.product .woocommerce-tabs ul.tabs li a:hover
			{
				color: rgba(<?php echo getbowtied_hex2rgb($shopkeeper_theme_options['headings_color']); ?>,0.45);
			}
			
			
			<?php endif; ?>

			.index-layout-2 ul.blog-posts .blog-post:first-child .post_content_wrapper,
			.index-layout-2 ul.blog-posts .blog-post:nth-child(5n+5) .post_content_wrapper,
			.cd-quick-view.animate-width,
			.woocommerce .button.getbowtied_product_quick_view_button,
			.fr-ui-outside .fr-info-background,
			.fr-info-background,
			.fr-overlay-background
			{
				<?php if ( (isset($shopkeeper_theme_options['main_background']['background-color'])) ) : ?>
				background-color:<?php echo esc_html($shopkeeper_theme_options['main_background']['background-color']); ?> !important;
				<?php endif; ?>
			}

			.product_content_wrapper .product-images-wrapper .product_images .product-images-controller .dot:not(.current),
			.product_content_wrapper .product-images-wrapper .product_images .product-images-controller li.video-icon .dot:not(.current)
			{
				<?php if ( (isset($shopkeeper_theme_options['main_background']['background-color'])) ) : ?>
				border-color: <?php echo esc_html($shopkeeper_theme_options['main_background']['background-color']); ?> !important;
				<?php endif; ?>
			}


			/***************************************************************/
			/* Main Color  *************************************************/
			/***************************************************************/
			
			<?php if ( (isset($shopkeeper_theme_options['main_color'])) && (trim($shopkeeper_theme_options['main_color']) != "" ) ) : ?>
			
			a,
			a:hover, a:focus,
			.woocommerce #respond input#submit:hover, 
			.woocommerce a.button:hover, 
			.woocommerce input.button:hover,
			.comments-area a,
			.edit-link,
			.post_meta_archive a:hover,
			.post_meta a:hover,
			.entry-title-archive a:hover,
			blockquote:before,
			.no-results-text:before,
			.list-centered a:hover,
			.comment-edit-link,
			.filters-group li:hover,
			#map_button,
			.widget_shopkeeper_social_media a,
			.account-tab-link-mobile,
			.lost-reset-pass-text:before,
			.list_shop_categories a:hover,
			.add_to_wishlist:hover,
			.woocommerce div.product span.price,
			.woocommerce-page div.product span.price,
			.woocommerce #content div.product span.price,
			.woocommerce-page #content div.product span.price,
			.woocommerce div.product p.price,
			.woocommerce-page div.product p.price,
			.woocommerce #content div.product p.price,
			.woocommerce-page #content div.product p.price,
			.comment-metadata time,
			.woocommerce p.stars a.star-1.active:after,
			.woocommerce p.stars a.star-1:hover:after,
			.woocommerce-page p.stars a.star-1.active:after,
			.woocommerce-page p.stars a.star-1:hover:after,
			.woocommerce p.stars a.star-2.active:after,
			.woocommerce p.stars a.star-2:hover:after,
			.woocommerce-page p.stars a.star-2.active:after,
			.woocommerce-page p.stars a.star-2:hover:after,
			.woocommerce p.stars a.star-3.active:after,
			.woocommerce p.stars a.star-3:hover:after,
			.woocommerce-page p.stars a.star-3.active:after,
			.woocommerce-page p.stars a.star-3:hover:after,
			.woocommerce p.stars a.star-4.active:after,
			.woocommerce p.stars a.star-4:hover:after,
			.woocommerce-page p.stars a.star-4.active:after,
			.woocommerce-page p.stars a.star-4:hover:after,
			.woocommerce p.stars a.star-5.active:after,
			.woocommerce p.stars a.star-5:hover:after,
			.woocommerce-page p.stars a.star-5.active:after,
			.woocommerce-page p.stars a.star-5:hover:after,
			.yith-wcwl-add-button:before,
			.yith-wcwl-wishlistaddedbrowse .feedback:before,
			.yith-wcwl-wishlistexistsbrowse .feedback:before,
			.woocommerce .star-rating span:before,
			.woocommerce-page .star-rating span:before,
			.product_meta a:hover,
			.woocommerce .shop-has-sidebar .no-products-info .woocommerce-info:before,
			.woocommerce-page .shop-has-sidebar .no-products-info .woocommerce-info:before,
			.woocommerce .woocommerce-breadcrumb a:hover,
			.woocommerce-page .woocommerce-breadcrumb a:hover,
			.intro-effect-fadeout.modify .post_meta a:hover,
			.from_the_blog_link:hover .from_the_blog_title,
			.portfolio_single_list_cat a:hover,
			.widget .recentcomments:before,
			.widget.widget_recent_entries ul li:before,
			#placeholder_product_quick_view .product_title:hover,
			.wpb_widgetised_column aside ul li.current-cat > span.count,
			.shopkeeper-mini-cart .widget.woocommerce.widget_shopping_cart .widget_shopping_cart_content p.buttons a.button.checkout.wc-forward,
			.getbowtied_blog_ajax_load_button:before, .getbowtied_blog_ajax_load_more_loader:before,
			.getbowtied_ajax_load_button:before, .getbowtied_ajax_load_more_loader:before,
			.list-centered li.current-cat > a:hover,
			#button_offcanvas_sidebar_left:hover,
			.shop_header .list_shop_categories li.category_item > a:hover,
			 #button_offcanvas_sidebar_left .filters-text:hover,
			 .products .yith-wcwl-wishlistaddedbrowse a:before, .products .yith-wcwl-wishlistexistsbrowse a:before,
			 .product_infos .yith-wcwl-wishlistaddedbrowse:before, .product_infos .yith-wcwl-wishlistexistsbrowse:before,
	 		.shopkeeper_checkout_coupon a.showcoupon,
			.woocommerce-checkout .showcoupon, .woocommerce-checkout .showlogin,
			.shop_sidebar .woocommerce.widget_shopping_cart p.buttons .button.wc-forward:not(.checkout),
			.woocommerce table.my_account_orders .woocommerce-orders-table__cell-order-actions .button,
			.woocommerce-MyAccount-content .woocommerce-pagination .woocommerce-button,
			body.gbt_classic_notif .woocommerce-message,
			body.gbt_classic_notif .woocommerce-error,
			body.gbt_classic_notif .wc-forward,
			body.gbt_classic_notif .woocommerce-error::before,
			body.gbt_classic_notif .woocommerce-message::before,
			body.gbt_classic_notif .woocommerce-info::before,
			body.gbt_custom_notif.woocommerce-account .woocommerce-error::before,
			body.gbt_custom_notif.woocommerce-account .woocommerce-message::before,
			body.gbt_custom_notif.woocommerce-account .woocommerce-info::before,
			body.gbt_custom_notif.woocommerce-account .woocommerce-error,
			.tinvwl_add_to_wishlist_button:hover,
			.tinvwl_add_to_wishlist_button.tinvwl-product-in-list:before
			{
				color: <?php echo esc_html($shopkeeper_theme_options['main_color']); ?>;
			}
			
			@media only screen and (min-width: 40.063em) {
				
				.nav-next a:hover,
				.nav-previous a:hover
				{
					color: <?php echo esc_html($shopkeeper_theme_options['main_color']) ?>;
				}
			
			}
			
			.widget_shopping_cart .buttons a.view_cart,
			.widget.widget_price_filter .price_slider_amount .button,
			.products a.button,
			.woocommerce .products .added_to_cart.wc-forward,
			.woocommerce-page .products .added_to_cart.wc-forward,
			body.gbt_classic_notif .woocommerce-info .button,
			body.gbt_custom_notif.woocommerce-account .woocommerce-info .button,
			.url:hover,
			.product_infos .yith-wcwl-wishlistexistsbrowse a:hover
			{
				color: <?php echo esc_html($shopkeeper_theme_options['main_color']) ?> !important;
			}
			
			.order-info mark,
			.login_footer,
			.post_tags a:hover,
			.with_thumb_icon,
			.wpb_wrapper .wpb_toggle:before,
			#content .wpb_wrapper h4.wpb_toggle:before,
			.wpb_wrapper .wpb_accordion .wpb_accordion_wrapper .ui-state-default .ui-icon,
			.wpb_wrapper .wpb_accordion .wpb_accordion_wrapper .ui-state-active .ui-icon,
			.widget .tagcloud a:hover,
			section.related h2:after,
			.single_product_summary_upsell h2:after,
			.page-title.portfolio_item_title:after,
			.thumbnail_archive_container:before,
			.from_the_blog_overlay,
			.select2-results .select2-highlighted,
			.wpb_widgetised_column aside ul li.chosen span.count,
			.woocommerce .widget_product_categories ul li.current-cat > a:before,
			.woocommerce-page .widget_product_categories ul li.current-cat > a:before,
			.widget_product_categories ul li.current-cat > a:before,
			#header-loader .bar,
			.index-layout-2 ul.blog_posts .blog_post .post_content_wrapper .post_content .read_more:before,
			.index-layout-3 .blog_posts_container ul.blog_posts .blog_post article .post_content_wrapper .post_content .read_more:before,
			body.gbt_custom_notif:not(.woocommerce-account) .woocommerce-message,
			body.gbt_custom_notif:not(.woocommerce-account) .woocommerce-error,
			body.gbt_custom_notif:not(.woocommerce-account) .woocommerce-info
			{
				background: <?php echo esc_html($shopkeeper_theme_options['main_color']) ?>;
			}
			
			.select2-container--default .select2-results__option--highlighted[aria-selected], 
			.select2-container--default .select2-results__option--highlighted[data-selected]
			{
				background-color: <?php echo esc_html($shopkeeper_theme_options['main_color']) ?> !important;
			}
			
			@media only screen and (max-width: 40.063em) {
				
				.nav-next a:hover,
				.nav-previous a:hover
				{
					background: <?php echo esc_html($shopkeeper_theme_options['main_color']) ?>;
				}
			
			}

			.woocommerce .widget_layered_nav ul li.chosen a:before,
			.woocommerce-page .widget_layered_nav ul li.chosen a:before,
			.widget_layered_nav ul li.chosen a:before,
			.woocommerce .widget_layered_nav ul li.chosen:hover a:before,
			.woocommerce-page .widget_layered_nav ul li.chosen:hover a:before,
			.widget_layered_nav ul li.chosen:hover a:before,
			.woocommerce .widget_layered_nav_filters ul li a:before,
			.woocommerce-page .widget_layered_nav_filters ul li a:before,
			.widget_layered_nav_filters ul li a:before,
			.woocommerce .widget_layered_nav_filters ul li a:hover:before,
			.woocommerce-page .widget_layered_nav_filters ul li a:hover:before,
			.widget_layered_nav_filters ul li a:hover:before,
			.woocommerce .widget_rating_filter ul li.chosen a:before,
			.shopkeeper-mini-cart,
			.minicart-message,
			.woocommerce-message,
			.woocommerce-store-notice, p.demo_store
			{
				background-color: <?php echo esc_html($shopkeeper_theme_options['main_color']) ?>;
			}
			
			
			.woocommerce .widget_price_filter .ui-slider .ui-slider-range,
			.woocommerce-page .widget_price_filter .ui-slider .ui-slider-range,
			.woocommerce .quantity .plus,
			.woocommerce .quantity .minus,
			.woocommerce #content .quantity .plus,
			.woocommerce #content .quantity .minus,
			.woocommerce-page .quantity .plus,
			.woocommerce-page .quantity .minus,
			.woocommerce-page #content .quantity .plus,
			.woocommerce-page #content .quantity .minus,
			.widget_shopping_cart .buttons .button.wc-forward.checkout
			{
				background: <?php echo esc_html($shopkeeper_theme_options['main_color']) ?> !important;
			}
			
			.button,
			input[type="button"],
			input[type="reset"],
			input[type="submit"],
			.woocommerce-widget-layered-nav-dropdown__submit,
			.wc-stripe-checkout-button
			{
				background-color: <?php echo esc_html($shopkeeper_theme_options['main_color']) ?> !important;
			}
			
			
			.product_infos .yith-wcwl-wishlistaddedbrowse a:hover,
			.shipping-calculator-button:hover,
			.products a.button:hover,
			.woocommerce .products .added_to_cart.wc-forward:hover,
			.woocommerce-page .products .added_to_cart.wc-forward:hover,
			.products .yith-wcwl-wishlistexistsbrowse:hover a,
			.products .yith-wcwl-wishlistaddedbrowse:hover a,
			.order-number a:hover,
			.account_view_link:hover,
			.post-edit-link:hover,
			.getbowtied_ajax_load_button a:not(.disabled):hover,
			.getbowtied_blog_ajax_load_button a:not(.disabled):hover
			{
				color:  rgba(<?php echo getbowtied_hex2rgb($shopkeeper_theme_options['main_color']); ?>,0.8) !important;
			}
			
			.product-title-link:hover
			{
				color:  rgba(<?php echo getbowtied_hex2rgb($shopkeeper_theme_options['headings_color']); ?>,0.8);
			}	
			
			.button:hover,
			input[type="button"]:hover,
			input[type="reset"]:hover,
			input[type="submit"]:hover,
			.woocommerce .product_infos .quantity .minus:hover,
			.woocommerce #content .product_infos .quantity .minus:hover,
			.woocommerce-page .product_infos .quantity .minus:hover,
			.woocommerce-page #content .product_infos .quantity .minus:hover,
			.woocommerce .quantity .plus:hover,
			.woocommerce #content .quantity .plus:hover,
			.woocommerce-page .quantity .plus:hover,
			.woocommerce-page #content .quantity .plus:hover,
			.wpb_wrapper .add_to_cart_inline .add_to_cart_button:hover,
			.woocommerce-widget-layered-nav-dropdown__submit:hover,
			.woocommerce-checkout a.button.wc-backward:hover
			{
				background: rgba(<?php echo getbowtied_hex2rgb($shopkeeper_theme_options['main_color']); ?>,0.8) !important;
			}
			
			.post_tags a:hover,
			.widget .tagcloud a:hover,
			.widget_shopping_cart .buttons a.view_cart,
			.account-tab-link-mobile,
			.woocommerce .widget_price_filter .ui-slider .ui-slider-handle,
			.woocommerce-page .widget_price_filter .ui-slider .ui-slider-handle,
			.woocommerce .widget_product_categories ul li.current-cat > a:before,
			.woocommerce-page .widget_product_categories ul li.current-cat > a:before,
			.widget_product_categories ul li.current-cat > a:before,
			.widget_product_categories ul li a:hover:before,
			.widget_layered_nav ul li a:hover:before,
			.widget_product_categories ul li a:hover ~ .count,
			.widget_layered_nav ul li a:hover ~ .count
			{
				border-color: <?php echo esc_html($shopkeeper_theme_options['main_color']) ?>;
			}
			
			.wpb_tour.wpb_content_element .wpb_tabs_nav  li.ui-tabs-active a,
			.wpb_tabs.wpb_content_element .wpb_tabs_nav li.ui-tabs-active a,
			.woocommerce div.product .woocommerce-tabs ul.tabs li.active a,
			.woocommerce #content div.product .woocommerce-tabs ul.tabs li.active a,
			.woocommerce-page div.product .woocommerce-tabs ul.tabs li.active a,
			.woocommerce-page #content div.product .woocommerce-tabs ul.tabs li.active a,
			.main-navigation ul ul li a:hover,
			.language-and-currency #top_bar_language_list > ul > li.menu-item-first > ul.sub-menu li a:hover,
			.language-and-currency .wcml_currency_switcher > ul > li.wcml-cs-active-currency ul.wcml-cs-submenu li a:hover
			{
				border-bottom-color: <?php echo esc_html($shopkeeper_theme_options['main_color']) ?>;
			}
			
			.woocommerce div.product .woocommerce-tabs ul.tabs li.active,
			.woocommerce #content div.product .woocommerce-tabs ul.tabs li.active,
			.woocommerce-page div.product .woocommerce-tabs ul.tabs li.active,
			.woocommerce-page #content div.product .woocommerce-tabs ul.tabs li.active
			{
				border-top-color: <?php echo esc_html($shopkeeper_theme_options['main_color'])  ?> !important;			
			}
			
			
			<?php endif; ?>
			
			/***************************************************************/
			/* Off-Canvas Colors *******************************************/
			/***************************************************************/

			.off-canvas,
			.offcanvas_content_left,
			.offcanvas_content_right
			{
				background-color: <?php echo esc_html($shopkeeper_theme_options['offcanvas_bg_color']); ?>;
				color: <?php echo esc_html($shopkeeper_theme_options['offcanvas_text_color']); ?>;
			}

			.off-canvas table tr th,
			.off-canvas table tr td,
			.off-canvas table thead tr th,
			.off-canvas blockquote p,
			.off-canvas label,
			.off-canvas .widget_search .search-form:after, 
			.off-canvas .woocommerce-product-search:after, 
			.off-canvas .submit_icon, 
			.off-canvas .widget_search #searchsubmit, 
			.off-canvas .widget_product_search .search-submit, 
			.off-canvas .widget_search .search-submit, 
			.off-canvas .woocommerce-product-search button[type="submit"],
			.off-canvas .woocommerce .product-title-link,
			.off-canvas .wpb_widgetised_column .widget a,
			.off-canvas .wpb_widgetised_column .widget a,
			.off-canvas .wpb_widgetised_column .widget_calendar table thead tr th,
			.off-canvas .add_to_cart_inline .amount, 
			.off-canvas .wpb_widgetised_column .widget, 
			.off-canvas .wpb_widgetised_column .widget a:hover, 
			.off-canvas .wpb_widgetised_column .widget.widget_product_categories a, 
			.off-canvas .wpb_widgetised_column .widget.widget_layered_nav a, 
			.off-canvas .widget_layered_nav ul li a, .widget_layered_nav, 
			.off-canvas .wpb_widgetised_column aside ul li span.count, 
			.off-canvas .shop_table.cart .product-price .amount,
			.off-canvas .menu-close .close-button,
			.off-canvas .site-search-close .close-button
			{
				color: <?php echo esc_html($shopkeeper_theme_options['offcanvas_text_color']); ?> !important;
			}

			.off-canvas .widget-title,
			.off-canvas .mobile-navigation a,
			.off-canvas .mobile-navigation ul li .spk-icon-down-small:before,
			.off-canvas .mobile-navigation ul li .spk-icon-up-small:before,
			.off-canvas.site-search .widget_product_search .search-field,
			.off-canvas.site-search .widget_search .search-field,
			.off-canvas.site-search input[type="search"],
			.off-canvas .widget_product_search input[type="submit"],
			.off-canvas.site-search .search-form .search-field
			{
				color: <?php echo esc_html($shopkeeper_theme_options['offcanvas_headings_color']); ?> !important;
			}

			.off-canvas .woocommerce .price,
			.off-canvas .site-search-close .close-button:hover,
			.off-canvas .search-text,
			.off-canvas .widget_search .search-form:after, 
			.off-canvas .woocommerce-product-search:after, 
			.off-canvas .submit_icon, 
			.off-canvas .widget_search #searchsubmit, 
			.off-canvas .widget_product_search .search-submit, 
			.off-canvas .widget_search .search-submit, 
			.off-canvas .woocommerce-product-search button[type="submit"], 
			.off-canvas .woocommerce .product-title-link,
			.off-canvas .wpb_widgetised_column .widget_price_filter .price_slider_amount
			{
				color: rgba(<?php echo getbowtied_hex2rgb($shopkeeper_theme_options['offcanvas_text_color']); ?>,0.55) !important;
			}

			.off-canvas.site-search input[type="search"],
			.off-canvas .menu-close,
			.off-canvas .mobile-navigation,
			.off-canvas .wpb_widgetised_column .widget
			{
				border-color: rgba(<?php echo getbowtied_hex2rgb($shopkeeper_theme_options['offcanvas_text_color']); ?>,0.1) !important;
			}

			.off-canvas.site-search input[type="search"]::-webkit-input-placeholder { color: rgba(<?php echo getbowtied_hex2rgb($shopkeeper_theme_options['offcanvas_text_color']); ?>,0.55) !important; }
			.off-canvas.site-search input[type="search"]::-moz-placeholder { color: rgba(<?php echo getbowtied_hex2rgb($shopkeeper_theme_options['offcanvas_text_color']); ?>,0.55) !important; }
			.off-canvas.site-search input[type="search"]:-ms-input-placeholder { color: rgba(<?php echo getbowtied_hex2rgb($shopkeeper_theme_options['offcanvas_text_color']); ?>,0.55) !important; }
			.off-canvas.site-search input[type="search"]:-moz-placeholder { color: rgba(<?php echo getbowtied_hex2rgb($shopkeeper_theme_options['offcanvas_text_color']); ?>,0.55) !important; }
			
			/***************************************************************/
			/* Top Bar *****************************************************/
			/***************************************************************/
			
			<?php 
			if ( (isset($shopkeeper_theme_options['top_bar_switch'])) && ($shopkeeper_theme_options['top_bar_switch'] == "1" ) ) { 
				$site_top_bar_height = 43;
			} else {
				$site_top_bar_height = 0;
			}
			?>
			
			<?php if ( (isset($shopkeeper_theme_options['top_bar_navigation_position'])) && (trim($shopkeeper_theme_options['top_bar_navigation_position']) == "left" ) ) : ?>
			#site-navigation-top-bar {
				float:left;
			}
			<?php endif; ?>
			
			#site-top-bar {
				height:<?php echo esc_html($site_top_bar_height) ?>px;
			}
			
			#site-top-bar,
			#site-navigation-top-bar .sf-menu ul
			{
				<?php if ( (isset($shopkeeper_theme_options['top_bar_background_color'])) && (trim($shopkeeper_theme_options['top_bar_background_color']) != "" ) ) : ?>
					background: <?php echo esc_html($shopkeeper_theme_options['top_bar_background_color']) ?>;
				<?php endif; ?>
			}
			
			<?php if ( (isset($shopkeeper_theme_options['top_bar_typography'])) && (trim($shopkeeper_theme_options['top_bar_typography']) != "" ) ) : ?>
			#site-top-bar,
			#site-top-bar a,
			.language-and-currency .wcml_currency_switcher > ul > li.wcml-cs-active-currency > a
			{
				color:<?php echo esc_html($shopkeeper_theme_options['top_bar_typography']) ?>;
			}
			<?php endif; ?>
			
			
			
			/***************************************************************/
			/* 	Header *****************************************************/
			/***************************************************************/
			
			<?php if ( (isset($shopkeeper_theme_options['sticky_header_background_color'])) && (trim($shopkeeper_theme_options['sticky_header_background_color']) != "" ) ) : ?>
				.site-header
				{
					background: <?php echo esc_html($shopkeeper_theme_options['sticky_header_background_color']) ?>;
				}
			<?php endif; ?>
			
			@media only screen and (min-width: 63.9375em) {
			.site-header {
				<?php if ( (isset($shopkeeper_theme_options['main_header_background']['background-color'])) ) : ?>
				background-color:<?php echo esc_html($shopkeeper_theme_options['main_header_background']['background-color']); ?>;
				<?php endif; ?>
				
				<?php if ( (isset($shopkeeper_theme_options['main_header_background']['background-image'])) && ($shopkeeper_theme_options['main_header_background']['background-image']) != "" ) : ?>
				background-image:url(<?php echo esc_url($shopkeeper_theme_options['main_header_background']['background-image']); ?>);
				<?php endif; ?>
				
				<?php if ( (isset($shopkeeper_theme_options['main_header_background']['background-repeat'])) ) : ?>
				background-repeat:<?php echo esc_html($shopkeeper_theme_options['main_header_background']['background-repeat']); ?>;
				<?php endif; ?>
				
				<?php if ( (isset($shopkeeper_theme_options['main_header_background']['background-position'])) ) : ?>
				background-position:<?php echo esc_html($shopkeeper_theme_options['main_header_background']['background-position']); ?>;
				<?php endif; ?>
				
				<?php if ( (isset($shopkeeper_theme_options['main_header_background']['background-size'])) ) : ?>
				background-size:<?php echo esc_html($shopkeeper_theme_options['main_header_background']['background-size']); ?>;
				<?php endif; ?>
				
				<?php if ( (isset($shopkeeper_theme_options['main_header_background']['background-attachment'])) ) : ?>
				background-attachment:<?php echo esc_html($shopkeeper_theme_options['main_header_background']['background-attachment']); ?>;
				<?php endif; ?>
			}
			}
			
			
			<?php 
			$site_logo_height = 33;
			if ( (isset($shopkeeper_theme_options['site_logo'])) && (trim($shopkeeper_theme_options['site_logo']) != "" ) ) {
				$site_logo_height = $shopkeeper_theme_options['logo_height']; 
			} else {
				$site_logo_height = 33;
			}
			?>
			
			<?php 
			
			$content_margin = 0;
						
			$page_id = "";
			if ( is_single() || is_page() ) {
				$page_id = get_the_ID();
			} else if ( is_home() ) {
				$page_id = get_option('page_for_posts');						
			}
						
			
			if ( 
			((isset($shopkeeper_theme_options['sticky_header'])) && (trim($shopkeeper_theme_options['sticky_header']) == "1" )) || 
			((isset($shopkeeper_theme_options['main_header_transparency'])) && (trim($shopkeeper_theme_options['main_header_transparency']) == "1" )) ||
			((get_post_meta($page_id, 'page_header_transparency', true)) && (get_post_meta($page_id, 'page_header_transparency', true) != "inherit"))
			) { 
				
				if ( isset($shopkeeper_theme_options['main_header_layout']) ) {		
					if ( $shopkeeper_theme_options['main_header_layout'] == "1" || $shopkeeper_theme_options['main_header_layout'] == "11" ) {
						$content_margin = $content_margin + $site_top_bar_height + $site_logo_height + $shopkeeper_theme_options['spacing_above_logo'] + $shopkeeper_theme_options['spacing_below_logo'];
					} 		
					elseif ( $shopkeeper_theme_options['main_header_layout'] == "2" || $shopkeeper_theme_options['main_header_layout'] == "22" ) {
						$content_margin = $content_margin + $site_top_bar_height + $site_logo_height + $shopkeeper_theme_options['spacing_above_logo'] + $shopkeeper_theme_options['spacing_below_logo'];
					}
					elseif ( $shopkeeper_theme_options['main_header_layout'] == "3" ) {
						$content_margin = $content_margin + $site_top_bar_height + $site_logo_height + $shopkeeper_theme_options['spacing_above_logo'] + $shopkeeper_theme_options['spacing_below_logo'] + 50;
					} 		
				}		
				else {	
					wp_enqueue_style('shopkeeper-header-default', get_template_directory_uri() . '/css/header-default.css', array(), '1.0', 'all' );	
				}
				
			}
			?>
			
			<?php if ( (isset($shopkeeper_theme_options['header_width'])) && ($shopkeeper_theme_options['header_width'] == "full") ) : ?>
			.site-header,
			#site-top-bar
			{
				padding-left:20px;
				padding-right:20px;
			}
			<?php endif; ?>
			
			<?php
			
			if ( (isset($shopkeeper_theme_options['site_logo'])) && (trim($shopkeeper_theme_options['site_logo']) != "" ) ) {
				
				if (is_ssl()) {
					$site_logo = str_replace("http://", "https://", $shopkeeper_theme_options['site_logo']);		
				} else {
					$site_logo = $shopkeeper_theme_options['site_logo'];
				}
				
			?>
			
				<?php if ( (isset($shopkeeper_theme_options['logo_height'])) && (trim($shopkeeper_theme_options['logo_height']) != "" ) ) { ?>
				
				@media only screen and (min-width: 1024px) {
				.site-branding img {
					height:<?php echo esc_html($site_logo_height); ?>px;
					width:auto;
				}
				
				.site-header .main-navigation,
				.site-header .site-tools
				{
					height:<?php echo esc_html($site_logo_height); ?>px;
					line-height:<?php echo esc_html($site_logo_height); ?>px;
				}
				}
				
				<?php } ?>

			<?php
			}
			?>
			
			@media only screen and (min-width: 63.9375em) {
				.site-header.sticky .main-navigation,
				.site-header.sticky .site-tools,
				.site-header.sticky .site-branding img
				{
					height:33px;
					line-height:33px;
					width:auto;
				}
			}

			<?php if ( (isset($shopkeeper_theme_options['spacing_above_logo'])) && (trim($shopkeeper_theme_options['spacing_above_logo']) != "" ) ) { ?>
			@media only screen and (min-width: 1024px) {
				.site-header {
					padding-top:<?php echo esc_html($shopkeeper_theme_options['spacing_above_logo']); ?>px;
				}
			}
			<?php } ?>
			
			<?php if ( (isset($shopkeeper_theme_options['spacing_below_logo'])) && (trim($shopkeeper_theme_options['spacing_below_logo']) != "" ) ) { ?>
			@media only screen and (min-width: 1024px) {
				.site-header {
					padding-bottom:<?php echo esc_html($shopkeeper_theme_options['spacing_below_logo']); ?>px;
				}
			}
			<?php } ?>
			
			@media only screen and (min-width: 63.9375em) {
				#page_wrapper.transparent_header .content-area,
				#page_wrapper.sticky_header .content-area
				{
					padding-top: calc(<?php echo esc_html($content_margin); ?>px + 85px);
				}
				
				.transparent_header .single-post-header .title,
				#page_wrapper.transparent_header .shop_header .page-title,
				#page_wrapper.sticky_header:not(.transparent_header) .page-title-hidden .content-area
				{
					padding-top: <?php echo esc_html($content_margin); ?>px;
				}
				
				.transparent_header .single-post-header.with-thumb .title
				{
					padding-top: <?php echo esc_html(200 + $content_margin); ?>px;
				}

				.transparent_header.sticky_header .page-title-shown .entry-header.with_featured_img,
				{
					margin-top: -<?php echo esc_html($content_margin)+85; ?>px;
				}

				.sticky_header .page-title-shown .entry-header.with_featured_img
				{
					margin-top: -<?php echo esc_html($content_margin); ?>px;
				}

				.page-template-default .transparent_header .entry-header.with_featured_img,
				.page-template-page-full-width .transparent_header .entry-header.with_featured_img
				{
					margin-top: -<?php echo esc_html($content_margin)+85; ?>px;
				}
			}
			
			<?php if ( (isset($shopkeeper_theme_options['main_header_font_size'])) && (trim($shopkeeper_theme_options['main_header_font_size']) != "" ) ) : ?>
			.site-header,
			.default-navigation,
			.main-navigation .mega-menu > ul > li > a
			{
				font-size: <?php echo esc_html($shopkeeper_theme_options['main_header_font_size']) ?>px;
			}
			<?php endif; ?>		
			
			<?php if ( (isset($shopkeeper_theme_options['sticky_header_color'])) && (trim($shopkeeper_theme_options['sticky_header_color']) != "" ) ) : ?>
			.site-header,
			.main-navigation a,
			.site-tools ul li a,
			.shopping_bag_items_number,
			.wishlist_items_number,
			.site-title a,
			.widget_product_search .search-but-added,
			.widget_search .search-but-added
			{
				color:<?php echo esc_html($shopkeeper_theme_options['sticky_header_color']) ?>;
			}

			.site-branding
			{
				border-color: <?php echo esc_html($shopkeeper_theme_options['main_header_font_color']) ?>;
			}
			<?php endif; ?>
			
			<?php if ( (isset($shopkeeper_theme_options['main_header_font_color'])) && (trim($shopkeeper_theme_options['main_header_font_color']) != "" ) ) : ?>
			@media only screen and (min-width: 63.9375em) {
				.site-header,
				.main-navigation a,
				.site-tools ul li a,
				.shopping_bag_items_number,
				.wishlist_items_number,
				.site-title a,
				.widget_product_search .search-but-added,
				.widget_search .search-but-added
				{
					color:<?php echo esc_html($shopkeeper_theme_options['main_header_font_color']) ?>;
				}
		
				.site-branding
				{
					border-color: <?php echo esc_html($shopkeeper_theme_options['main_header_font_color']) ?>;
				}
			}
			<?php endif; ?>
			
			
			<?php if ( (isset($shopkeeper_theme_options['main_header_transparent_light_color'])) && (trim($shopkeeper_theme_options['main_header_transparent_light_color']) != "" ) ) : ?>
			@media only screen and (min-width: 1024px) {
				#page_wrapper.transparent_header.transparency_light .site-header,
				#page_wrapper.transparent_header.transparency_light .site-header .main-navigation a,
				#page_wrapper.transparent_header.transparency_light .site-header .site-tools ul li a,
				#page_wrapper.transparent_header.transparency_light .site-header .shopping_bag_items_number,
				#page_wrapper.transparent_header.transparency_light .site-header .wishlist_items_number,
				#page_wrapper.transparent_header.transparency_light .site-header .site-title a,
				#page_wrapper.transparent_header.transparency_light .site-header .widget_product_search .search-but-added,
				#page_wrapper.transparent_header.transparency_light .site-header .widget_search .search-but-added
				{
					color:<?php echo esc_html($shopkeeper_theme_options['main_header_transparent_light_color']) ?>;
				}
			}
			<?php endif; ?>
			
			
			<?php if ( (isset($shopkeeper_theme_options['main_header_transparent_dark_color'])) && (trim($shopkeeper_theme_options['main_header_transparent_dark_color']) != "" ) ) : ?>
			@media only screen and (min-width: 1024px) {
				#page_wrapper.transparent_header.transparency_dark .site-header,
				#page_wrapper.transparent_header.transparency_dark .site-header .main-navigation a,
				#page_wrapper.transparent_header.transparency_dark .site-header .site-tools ul li a,
				#page_wrapper.transparent_header.transparency_dark .site-header .shopping_bag_items_number,
				#page_wrapper.transparent_header.transparency_dark .site-header .wishlist_items_number,
				#page_wrapper.transparent_header.transparency_dark .site-header .site-title a,
				#page_wrapper.transparent_header.transparency_dark .site-header .widget_product_search .search-but-added,
				#page_wrapper.transparent_header.transparency_dark .site-header .widget_search .search-but-added
				{
					color:<?php echo esc_html($shopkeeper_theme_options['main_header_transparent_dark_color']) ?>;
				}
			}
			<?php endif; ?>

		
			
			/* sticky */
			
			<?php if ( (isset($shopkeeper_theme_options['sticky_header_background_color'])) && (trim($shopkeeper_theme_options['sticky_header_background_color']) != "" ) ) : ?>
			@media only screen and (min-width: 63.9375em) {
				.site-header.sticky,
				#page_wrapper.transparent_header .site-header.sticky
				{
					background: <?php echo esc_html($shopkeeper_theme_options['sticky_header_background_color']) ?>;
				}
			}
			<?php endif; ?>
			
			<?php if ( (isset($shopkeeper_theme_options['sticky_header_color'])) && (trim($shopkeeper_theme_options['sticky_header_color']) != "" ) ) : ?>
			@media only screen and (min-width: 63.9375em) {
				.site-header.sticky,
				.site-header.sticky .main-navigation a,
				.site-header.sticky .site-tools ul li a,
				.site-header.sticky .shopping_bag_items_number,
				.site-header.sticky .wishlist_items_number,
				.site-header.sticky .site-title a,
				.site-header.sticky .widget_product_search .search-but-added,
				.site-header.sticky .widget_search .search-but-added,
				#page_wrapper.transparent_header .site-header.sticky,
				#page_wrapper.transparent_header .site-header.sticky .main-navigation a,
				#page_wrapper.transparent_header .site-header.sticky .site-tools ul li a,
				#page_wrapper.transparent_header .site-header.sticky .shopping_bag_items_number,
				#page_wrapper.transparent_header .site-header.sticky .wishlist_items_number,
				#page_wrapper.transparent_header .site-header.sticky .site-title a,
				#page_wrapper.transparent_header .site-header.sticky .widget_product_search .search-but-added,
				#page_wrapper.transparent_header .site-header.sticky .widget_search .search-but-added
				{
					color:<?php echo esc_html($shopkeeper_theme_options['sticky_header_color']) ?>;
				}
				
				.site-header.sticky .site-branding
				{
					border-color: <?php echo esc_html($shopkeeper_theme_options['sticky_header_color']) ?>;
				}
			}
			<?php endif; ?>
			
			<?php 
			
			if ( 
			(isset($shopkeeper_theme_options['main_header_wishlist'])) && 
			(isset($shopkeeper_theme_options['main_header_shopping_bag'])) && 
			(isset($shopkeeper_theme_options['main_header_search_bar'])) && 
			(isset($shopkeeper_theme_options['main_header_off_canvas'])) && 
			($shopkeeper_theme_options['main_header_wishlist'] == "0") && 
			($shopkeeper_theme_options['main_header_shopping_bag'] == "0") && 
			($shopkeeper_theme_options['main_header_search_bar'] == "0") && 
			($shopkeeper_theme_options['main_header_off_canvas'] == "0") ) : 
			?>
			
			.site-tools { margin:0; }
			
			<?php endif; ?>
			
			
			<?php if ( (isset($shopkeeper_theme_options['sticky_header_logo'])) && (trim($shopkeeper_theme_options['sticky_header_logo']) != "" ) ) : ?>
			@media only screen and (max-width: 63.95em) {
				.site-logo {
					display:none;
				}
				.sticky-logo {
					display:block;
				}
			}
			<?php endif; ?>
			
			
			
			/* header-centered-2menus */
			
			<?php if ( (isset($shopkeeper_theme_options['main_header_layout'])) && ($shopkeeper_theme_options['main_header_layout'] == "2" || $shopkeeper_theme_options['main_header_layout'] == "22") ) : ?>
			
				<?php
				
				$header_col_right_menu_right_padding = 0;
				
				if ( (isset($shopkeeper_theme_options['main_header_wishlist'])) && ($shopkeeper_theme_options['main_header_wishlist'] == "1") ) $header_col_right_menu_right_padding += 60;
				if ( (isset($shopkeeper_theme_options['main_header_shopping_bag'])) && ($shopkeeper_theme_options['main_header_shopping_bag'] == "1") ) $header_col_right_menu_right_padding += 60;
				if ( (isset($shopkeeper_theme_options['main_header_search_bar'])) && ($shopkeeper_theme_options['main_header_search_bar'] == "1") ) $header_col_right_menu_right_padding += 40;
				if ( (isset($shopkeeper_theme_options['main_header_off_canvas'])) && ($shopkeeper_theme_options['main_header_off_canvas'] == "1") ) $header_col_right_menu_right_padding += 40;
				
				?>
				
				.header_col.right_menu {
					padding-right:<?php echo esc_html($header_col_right_menu_right_padding); ?>px;
				}
				
				.rtl .header_col.right_menu {
					padding-right:0;
				}
				.rtl .header_col.left_menu {
					padding-left:<?php echo esc_html($header_col_right_menu_right_padding); ?>px;
				}

				/*.header_col.left_menu {
					padding-left:<?php echo esc_html($header_col_right_menu_right_padding); ?>px;
				}*/
				
				<?php if ( (isset($shopkeeper_theme_options['main_header_layout'])) && ($shopkeeper_theme_options['main_header_layout'] == "2") ) : ?>
				.header_col.left_menu .main-navigation {
					text-align:right !important;
					margin:0 -15px !important;
				}
				.header_col.right_menu .main-navigation {
					text-align:left !important;
					margin:0 -15px !important;
				}
				<?php endif; ?>
				
				<?php if ( (isset($shopkeeper_theme_options['main_header_layout'])) && ($shopkeeper_theme_options['main_header_layout'] == "22") ) : ?>
				.header_col.left_menu .main-navigation {
					text-align:left !important;
					margin:0 -15px !important;
				}
				.header_col.right_menu .main-navigation {
					text-align:right !important;
					margin:0 -15px !important;
				}
				<?php endif; ?>
				
				.site-header .site-tools {
					height:30px !important;
					/*line-height:30px !important;*/
					position:absolute;
					top:2px;
					right:0;
				}
				
				<?php if ( (isset($shopkeeper_theme_options['logo_min_height'])) && (trim($shopkeeper_theme_options['logo_min_height']) != "" ) ) : ?>
				.header_col.branding {
					min-width:<?php echo esc_html($shopkeeper_theme_options['logo_min_height']); ?>px;
				}
				<?php endif; ?>
			
			<?php endif; ?>
			
			
			/* header-centered-menu-under */
			
			<?php if ( (isset($shopkeeper_theme_options['main_header_layout'])) && ($shopkeeper_theme_options['main_header_layout'] == "3") ) : ?>
			
				.main-navigation {
					text-align:center !important;
				}
				
				.site-header .main-navigation {
					height:50px !important;
					line-height:50px !important;
					margin:10px auto -10px auto;
				}
				
				.site-header .site-tools {
					height:30px !important;
					line-height:30px !important;
					position:absolute;
					top:2px;
					right:0;
				}
			
			<?php endif; ?>

			.transparent_header .with-featured-img
			{
				<?php $mt = 85 + 46 + $shopkeeper_theme_options['spacing_above_logo'] + $shopkeeper_theme_options['spacing_below_logo']; ?>
				margin-top: -<?php echo $mt; ?>px;
			}
			
			
			
			
			/***************************************************************/
			/* Footer ******************************************************/
			/***************************************************************/

			#site-footer
			{
				<?php if ( (isset($shopkeeper_theme_options['footer_background_color'])) && (trim($shopkeeper_theme_options['footer_background_color']) != "" ) ) : ?>
					background: <?php echo esc_html($shopkeeper_theme_options['footer_background_color']) ?>;
				<?php endif; ?>
			}
			
			<?php if ( (isset($shopkeeper_theme_options['footer_background_color'])) && (trim($shopkeeper_theme_options['footer_background_color']) == "transparent" ) ) : ?>
				@media only screen and (max-width: 641px) {
					#site-footer {
						padding-top:0;
					}
				}
			<?php endif; ?>
			
			<?php if ( (isset($shopkeeper_theme_options['footer_texts_color'])) && (trim($shopkeeper_theme_options['footer_texts_color']) != "" ) ) : ?>
			#site-footer,
			#site-footer .copyright_text a
			{
				color:<?php echo esc_html($shopkeeper_theme_options['footer_texts_color']) ?>;
			}
			<?php endif; ?>
			
			<?php if ( (isset($shopkeeper_theme_options['footer_links_color'])) && (trim($shopkeeper_theme_options['footer_links_color']) != "" ) ) : ?>
			#site-footer a,
			#site-footer .widget-title,
			.cart-empty-text,
			.footer-navigation-wrapper ul li:after
			{
				color:<?php echo esc_html($shopkeeper_theme_options['footer_links_color']) ?>;
			}		
			<?php endif; ?>

			<?php if ( (isset($shopkeeper_theme_options['expandable_footer'])) && ($shopkeeper_theme_options['expandable_footer'] == "0" ) ) : ?>
			.trigger-footer-widget-area {
				display: none;
			}
			.site-footer-widget-area {
				display: block;
			}
			<?php endif; ?>
			
			
			
			
			/***************************************************************/
			/* Breadcrumbs *************************************************/
			/***************************************************************/
			
			
			<?php if ( (isset($shopkeeper_theme_options['breadcrumbs'])) && ($shopkeeper_theme_options['breadcrumbs']) == "0" ) : ?>
			.woocommerce .woocommerce-breadcrumb,
			.woocommerce-page .woocommerce-breadcrumb
			{
				display:none;
			}
			<?php endif; ?>

		
			/***************************************************************/
			/* Product Quantity Style
			/***************************************************************/

			<?php if ( isset($shopkeeper_theme_options['product_quantity_style']) && $shopkeeper_theme_options['product_quantity_style'] == "custom") : ?>
			
			.quantity.custom {
			  display: inline-block;
			  width: auto;
			  float: none;
			  margin-right: 23px;
			}
			.quantity.custom input[type="number"] {
			  -moz-appearance: textfield;
			}
			.quantity.custom input.custom-qty {
			  width: 45px;
			  border: none;
			  display: inline-block;
			  text-align: center;
			  font-weight: bold;
			  outline: none;
			}
			.quantity.custom .plus {
			  border: none;
			  color: #fff;
			  background-color: purple;
			  height: 30px;
			  width: 30px;
			}
			.quantity.custom .qty {
			  border: 1px solid purple;
			  color: purple;
			  height: 30px;
			}

			.cd-quick-view .quantity.custom

			.cd-quick-view .quantity.custom {
			  display: inline-block;
			  width: auto !important;
			  float: none!important;
			  margin-right: 23px;
			}
			.cd-quick-view .quantity.custom input[type="number"] {
			  -moz-appearance: textfield;
			}
			.cd-quick-view .quantity.custom input.custom-qty {
			  width: 40px;
			  border: none;
			  display: inline-block;
			  text-align: center;
			  font-weight: bold;
			  outline: none;
			}
			.cd-quick-view .quantity.custom .plus {
			  border: none;
			  color: #fff;
			  background-color: purple;
			  height: 30px;
			  width: 30px;
			}
			.cd-quick-view .quantity.custom .qty {
			  border: 1px solid purple;
			  color: purple;
			  height: 30px;
			}


			/* quantity mobile */

			@media only screen and (max-width: 767px) {
				.product:not(.product-type-grouped) form.cart:not(.variations_form) .quantity,
				.woocommerce-variation-add-to-cart .quantity,
				body.single-product .product_content_wrapper .product_infos form.cart .button:hover
				{
					background: <?php echo esc_html($shopkeeper_theme_options['main_color']) ?> !important;
				}

				tr.cart_item .quantity.custom
				{
					margin-right: 0;
				}
			}

			<?php else: ?>

			/* Default Input Type Number */

			@media only screen and (max-width: 767px) {
				.product .product_infos form.cart:not(.variations_form) .quantity:not(.custom)
				{
					margin: 0 !important;
				}

				.product .product_infos form.cart .quantity:not(.custom) input.input-text.qty  
				{
					color: <?php echo esc_html($shopkeeper_theme_options['body_color']) ?> !important;
				}

			}

			<?php endif; ?>

			.cd-quick-view .cd-item-info .product_infos:after
			{
				background: linear-gradient(to bottom, rgba(205,255,255,0) 0%, <?php if ( (isset($shopkeeper_theme_options['main_background']['background-color'])) ) : ?>
				<?php echo esc_html($shopkeeper_theme_options['main_background']['background-color']); ?> <?php echo ' '; ?>
				<?php endif; ?> 70%);
			}


			/***************************************************************/
			/* Notifications
			/***************************************************************/

			<?php if ( isset($shopkeeper_theme_options['notification_mode']) && $shopkeeper_theme_options['notification_mode'] == '1' && isset($shopkeeper_theme_options['notification_style']) && $shopkeeper_theme_options['notification_style'] == '0') : ?>
				
			body.gbt_custom_notif:not(.woocommerce-account) .page-notifications.animate
			{

				animation: slide-in;
				animation-duration: 1.5s;
				animation-delay: .5s;
				animation-fill-mode: forwards; 
				animation-timing-function: ease;
			}

			body.gbt_custom_notif:not(.woocommerce-account) .woocommerce-message .product_notification_wrapper .product_notification_background,
			body.gbt_custom_notif:not(.woocommerce-account) .woocommerce-info .product_notification_wrapper .product_notification_background
			{
				animation: image-in;
				animation-duration: 1.5s;
				animation-delay: .5s;
				animation-fill-mode: forwards; 
				animation-timing-function: ease;
			}

			body.gbt_custom_notif:not(.woocommerce-account) .woocommerce-message .product_notification_wrapper .product_notification_text,
			body.gbt_custom_notif:not(.woocommerce-account) .woocommerce-info .product_notification_wrapper .product_notification_text,
			body.gbt_custom_notif:not(.woocommerce-account) .woocommerce-message .woocommerce-message-wrapper .notice_text,
			body.gbt_custom_notif:not(.woocommerce-account) .woocommerce-info .woocommerce-message-wrapper .notice_text,
			body.gbt_custom_notif:not(.woocommerce-account) .page-notifications.animate .notification .notice-text,
			body.gbt_custom_notif:not(.woocommerce-account) .page-notifications.animate .woocommerce-error li
			{
				animation: opacity_text_in;
				animation-delay: 1.25s;
				animation-duration: .5s;
				animation-fill-mode: forwards; 
			}

			<?php endif; ?>

			
			/***************************************************************/
			/* Product Page Full Screen Description ************************/
			/***************************************************************/
			
			<?php if (isset($post->ID)) : ?>		
			<?php if (get_post_meta( $post->ID, 'product_full_screen_description_meta_box_check', true ) == "on") : ?>
			
			#tab-description .boxed-row
			{
				max-width: 1255px;
				margin: 0 auto;
			}
			
			.woocommerce div.product .woocommerce-tabs #tab-description,
			.woocommerce #content div.product .woocommerce-tabs #tab-description,
			.woocommerce-page div.product .woocommerce-tabs #tab-description,
			.woocommerce-page #content div.product .woocommerce-tabs #tab-description
			{
				padding: 0;
			}
			
			#tab-description .row
			{
				padding: 0;
			}
			
			
			/* Visual Composer Shortcodes */
			
			/* max-width 640px, small screens */
			@media only screen and (max-width: 40.063em) {
				
				.woocommerce div.product .woocommerce-tabs #tab-description,
				.woocommerce #content div.product .woocommerce-tabs #tab-description,
				.woocommerce-page div.product .woocommerce-tabs #tab-description,
				.woocommerce-page #content div.product .woocommerce-tabs #tab-description
				{
					position: relative;
					top: -1px;
				}
				
				#tab-description .columns .columns
				{
					padding-left: 30px !important;
					padding-right: 30px !important;
				}
			}
			
			/*min-width 641px and max-width 1023px, medium screens */
			@media only screen and (min-width: 40.063em) and (max-width: 63.9375em) {
			
				#tab-description .columns .columns
				{
					padding-left: 60px !important;
					padding-right: 60px !important;
				}
				
			}
			
			/* max-width 1023px, small screens/medium screens */
			@media only screen and (max-width: 63.9375em) {
				
				#tab-description .row,
				#tab-description .columns
				{
					padding-left: 0 !important;
					padding-right: 0 !important;
				}
				
				#tab-description .columns .row
				{
					margin-left: 0;
					margin-right: 0;
				}
				
				#tab-description .columns .columns .columns
				{
					padding-left: 0px !important;
					padding-right: 0px !important;
				}
				
				#tab-description .columns .wpb_content_element
				{
					padding-left: 0 !important;
					padding-right: 0 !important;
				}
			}
			
			/* min-width 1023px, large screens */
			@media only screen and (min-width: 63.9375em) {
				
				.woocommerce #tab-description > .row,
				/*.woocommerce #tab-description .row .row,*/
				.woocommerce #tab-description  .row  .large-centered
				{
					width:100% !important;
					max-width:100% !important;
					padding:0 !important;
					margin:0 !important;
				}
			}
				
			<?php endif; ?>		
			<?php endif; ?>


			/********************************************************************/
	        /* Predictive Search Disabled Mobile Off-Canvas *********************/
	        /********************************************************************/

	        <?php if ( (isset($shopkeeper_theme_options['predictive_search'])) && ($shopkeeper_theme_options['predictive_search'] == 0) ) : ?>
				@media all and (max-width: 767px) {
					.site-search {
					    min-height: 170px;
					    height: 170px;
					    -webkit-transform: translateY(-170px);
					    -ms-transform: translateY(-170px);
					    transform: translateY(-170px);
					}
				}
			<?php endif; ?>

	        /********************************************************************/
	        /* Catalog Mode *****************************************************/
	        /********************************************************************/

	        <?php if ( (isset($shopkeeper_theme_options['catalog_mode'])) && ($shopkeeper_theme_options['catalog_mode'] == 1) ) : ?>
	            form.cart div.quantity,
	            form.cart button.single_add_to_cart_button {
	                display: none !important;
	            }
	        <?php endif; ?>

			
			
			/********************************************************************/
			/* Custom CSS *******************************************************/
			/********************************************************************/
			
			<?php if ( (isset($shopkeeper_theme_options['custom_css'])) && (trim($shopkeeper_theme_options['custom_css']) != "" ) ) : ?>
				<?php echo $shopkeeper_theme_options['custom_css'] ?>
			<?php endif; ?>

			/********************************************************************/
			/* Menu Off-Canvas **************************************************/
			/********************************************************************/

			<?php if(is_user_logged_in()) : ?>
			@media all and (min-width: 1024px) and (max-width: 1280px)
			{
				.position-left,
				.position-right
				{
					padding-top: 38px;
				}
			}
			<?php endif; ?>
		
		</style>

		<?php

		if ( GETBOWTIED_DOKAN_MULTIVENDOR_IS_ACTIVE ) {
			include('dokan-styles.php'); // Load Dokan Plugin Styles
		}

		if ( GETBOWTIED_WOOCOMMERCE_GERMANIZED_IS_ACTIVE || GETBOWTIED_GERMAN_MARKET_IS_ACTIVE ) {
			include('german-styles.php'); // Load German Market / Germanized Styles
		}

		$content = ob_get_clean();
		$content = str_replace(array("\r\n", "\r"), "\n", $content);
		$lines = explode("\n", $content);
		$new_lines = array();
		foreach ($lines as $i => $line) { if(!empty($line)) $new_lines[] = trim($line); }
		echo implode($new_lines);
	} //function
} //if
?>
<?php add_action( 'wp_head', 'shopkeeper_custom_styles', 99 ); ?>