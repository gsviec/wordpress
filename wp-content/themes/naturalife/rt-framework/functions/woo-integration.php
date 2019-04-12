<?php
/**
 * RT-THEME WooCommerce Integration
 *
 * Various Functions and hooks for WC
 *
 * @author 		RT-Themes
 *
 */

global $woocommerce;

/**
 *
 *
 * HOOKS
 *
 *
 */

//remove default css files
add_filter( 'woocommerce_enqueue_styles', 'rtframework_remove_wc_default_css_files' );

//remove woo wrapper
remove_action("woocommerce_before_main_content","woocommerce_output_content_wrapper",10);
remove_action("woocommerce_after_main_content","woocommerce_output_content_wrapper_end",10);

//remove breadcrumb
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );

//remove pagination
remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination', 10 );

//remove woo sidebar
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10);

//pagination
add_action( 'woocommerce_after_shop_loop', 'rtframework_woocommerce_pagination', 10 );

//hide woocommerce page title
add_filter('woocommerce_show_page_title', 'rtframework_woocommerce_show_page_title');


//Custom Loop Item Title
//remove_action("woocommerce_shop_loop_item_title", "woocommerce_template_loop_product_title");
remove_action("woocommerce_before_shop_loop_item", "woocommerce_template_loop_product_link_open", 10);
remove_action("woocommerce_after_shop_loop_item", "woocommerce_template_loop_product_link_close", 5);
add_action("woocommerce_shop_loop_item_title", "woocommerce_template_loop_product_link_open",5);
add_action("woocommerce_after_shop_loop_item_title", "woocommerce_template_loop_product_link_close",4);

//product thumbnail
remove_action("woocommerce_before_shop_loop_item_title", "woocommerce_template_loop_product_thumbnail", 10);
add_action("woocommerce_before_shop_loop_item_title", "rtframework_wc_loop_product_thumbnail_holder", 10);

add_action("rtframework_wc_loop_product_thumbnail", "woocommerce_template_loop_product_link_open", 5);
add_action("rtframework_wc_loop_product_thumbnail", "woocommerce_template_loop_product_thumbnail", 10);
add_action("rtframework_wc_loop_product_thumbnail", "woocommerce_template_loop_product_link_close", 20);

//ratings
remove_action("woocommerce_after_shop_loop_item_title", "woocommerce_template_loop_rating", 5);
add_action("rtframework_wc_loop_product_thumbnail", "woocommerce_template_loop_rating", 5);

// Cart total items
add_filter('woocommerce_add_to_cart_fragments', 'rtframework_cart_items');

//before shop loop
remove_action("woocommerce_before_shop_loop", "woocommerce_result_count",20);
remove_action("woocommerce_before_shop_loop", "woocommerce_catalog_ordering",30);

//sub page header
add_action("rtframework_start_main_content", "rtframework_before_shop_loop_wrapper",15);
add_action("rtframework_before_shop_loop", "woocommerce_result_count",20);
add_action("rtframework_before_shop_loop", "woocommerce_catalog_ordering",30);

//define post per page
add_filter('loop_shop_per_page', 'rtframework_loop_shop_per_page');

//loop column count
add_filter('loop_shop_columns', 'rtframework_wc_loop_columns', 999);

//WC 3.0 galleries
add_action( 'template_redirect', 'rtframework_woo_supports' );

//product loop content wrapper
add_action("woocommerce_shop_loop_item_title", "rtframework_loop_content_wrapper_open",2);
add_action("woocommerce_after_shop_loop_item_title", "rtframework_loop_content_wrapper_close",20);

//add to cart
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
add_action('woocommerce_after_shop_loop_item_title', 'rtframework_woocommerce_template_loop_add_to_cart', 10);

//price
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
add_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 15);


remove_action( 'wp_footer', 'woocommerce_demo_store' );
add_action( 'rtframework_start_main_content', 'woocommerce_demo_store' );

/**
 * 
 * Layout Specific hooks
 * 
 */
if ( ! function_exists( 'rtframework_layout2_hooks' ) ) {
	/**
	 * Layout 2 hooks
	 */
	function rtframework_layout2_hooks()
	{
	
		if( ! strpos(get_page_template_slug(), "single-product-layout2.php") ){
			return;
		}
		//tabs
		remove_action("woocommerce_after_single_product_summary", "woocommerce_output_product_data_tabs", 10);		 
		add_action("woocommerce_single_product_summary", "woocommerce_output_product_data_tabs",70); 

	}
}

add_action( "template_redirect", "rtframework_layout2_hooks", 100 );

if ( ! function_exists( 'rtframework_set_row_post_class' ) ) {
	/**
	 * Add extra class to single product page wrapper
	 */
	function rtframework_set_row_post_class($classes, $class, $post_id){
		global $woocommerce_loop;

		if( ! is_product() || isset(  $woocommerce_loop  ) ){
			return $classes;
		}

		$classes[] = 'single-product-div';    
	    return $classes;
	}
}
add_filter('post_class', 'rtframework_set_row_post_class', 10,3);

/**
 *
 *
 * FUNCTIONS
 *
 *
 */

if ( ! function_exists( 'rtframework_woocommerce_template_loop_add_to_cart' ) ) {
	/**
	 * Custom add to cart button for product listings
	 */
	function rtframework_woocommerce_template_loop_add_to_cart( $args = array() )
	{

		global $product;

		if ( $product ) {
			$defaults = array(
				'quantity'   => 1,
				'class'      => implode( ' ', array_filter( array(
					'button',
					'product_type_' . $product->get_type(),
					$product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
					$product->supports( 'ajax_add_to_cart' ) ? 'ajax_add_to_cart' : '',
				) ) ),
				'attributes' => array(
					'data-product_id'  => $product->get_id(),
					'data-product_sku' => $product->get_sku(),
					'aria-label'       => $product->add_to_cart_description(),
					'rel'              => 'nofollow',
				),
			);

			$args = apply_filters( 'woocommerce_loop_add_to_cart_args', wp_parse_args( $args, $defaults ), $product );

			wc_get_template( 'loop/custom-add-to-cart.php', $args );
		}
	}
} 

if ( ! function_exists( 'rtframework_woo_supports' ) ) {
	/**
	 * Add WooCommerce Gallery Support - 3.0
	 */
	function rtframework_woo_supports()
	{
		$disable_zoom = get_theme_mod( 'naturalife_woo_disable_zoom');
		$disable_lightbox = get_theme_mod( 'naturalife_woo_disable_lightbox');

		if( ! $disable_zoom ){
			add_theme_support( 'wc-product-gallery-zoom' );
		}

		if( ! $disable_lightbox ){
			add_theme_support( 'wc-product-gallery-lightbox' );
		}
		add_theme_support( 'wc-product-gallery-slider' );
	}
}



if ( ! function_exists( 'rtframework_before_shop_loop_wrapper' ) ) {
	/**
	 * Loop content wrapper open
	 */
	function rtframework_before_shop_loop_wrapper()
	{

		if( ! is_shop() && ! is_product_category() && ! is_product_tag()  ){
			return;
		}

		echo '<div class="naturalife-before-shop content-row default-style fullwidth">'."\n";
		echo '<div class="content-row-wrapper default">'."\t\n";
		echo '<div class="col col-sm-12">'."\t\t\n";

			do_action( "rtframework_before_shop_loop" );

		echo '</div>'."\t\t\n";
		echo '</div>'."\t\n";
		echo '</div>'."\n";
	}
}


if ( ! function_exists( 'rtframework_before_shop_wrapper_open' ) ) {
	/**
	 * Loop content wrapper open
	 */
	function rtframework_before_shop_wrapper_open()
	{
		echo '<div class="naturalife-before-shop">'."\n";
	}
}

 if ( ! function_exists( 'rtframework_before_shop_wrapper_close' ) ) {
	/**
	 * Loop content wrapper close
	 */
	function rtframework_before_shop_wrapper_close()
	{
		echo '</div>'."\n";
	}
}



if (!function_exists('rtframework_wc_loop_columns')) {
	function rtframework_wc_loop_columns( $default_layout ) {
		
		$layout = rtframework_get_setting("woo_layout");
	
		$layout = ! empty( $layout ) ? $layout : $default_layout ;

		

		return $layout;	
	}
}

 if ( ! function_exists( 'rtframework_loop_shop_per_page' ) ) {
	/**
	 * Product Per Page
	 * Number of products displayed per page
	 * @return numberic woo_product_list_pager
	 */
	function rtframework_loop_shop_per_page() {
		$woo_product_list_pager = rtframework_get_setting("woo_list_pager");
		if($woo_product_list_pager!="" && is_numeric($woo_product_list_pager) ) {
			return  $woo_product_list_pager;
		}
	}
}


 if ( ! function_exists( 'rtframework_loop_content_wrapper_open' ) ) {
	/**
	 * Loop content wrapper open
	 */
	function rtframework_loop_content_wrapper_open()
	{
		echo '<div class="naturalife-product-content-holder">'."\n";
	}
}

 if ( ! function_exists( 'rtframework_loop_content_wrapper_close' ) ) {
	/**
	 * Loop content wrapper close
	 */
	function rtframework_loop_content_wrapper_close()
	{
		echo '</div>'."\n";
	}
}



 if ( ! function_exists( 'rtframework_wc_loop_product_thumbnail_holder' ) ) {
	/**
	 * Thumbnail Holder
	 */
	function rtframework_wc_loop_product_thumbnail_holder()
	{
		echo '<div class="naturalife-wc-image-holder">'."\n";
		do_action("rtframework_wc_loop_product_thumbnail");
		echo '</div>'."\n";
	}
}

if ( ! function_exists( 'rtframework_remove_wc_default_css_files' ) ) {
	/**
	 * Remove default woo css files
	 * @return $enqueue_styles
	 */
	function rtframework_remove_wc_default_css_files( $enqueue_styles )
	{
		unset( $enqueue_styles['woocommerce-general'] ); // Remove the gloss
		unset( $enqueue_styles['woocommerce-layout'] ); // Remove the layout
		unset( $enqueue_styles['woocommerce-smallscreen'] ); // Remove the smallscreen optimisation
		return $enqueue_styles;
	}
}

if ( ! function_exists( 'rtframework_get_woocommerce_page_title' ) ) {
	/**
	 * woocommerce_page_title function.
	 *
	 * replace the rtframework_get_woocommerce_page_title function
	 *
	 * @access public
	 * @return void
	 */
	function rtframework_get_woocommerce_page_title() {
		return woocommerce_page_title( false );
	}
}

if ( ! function_exists( 'rtframework_woocommerce_pagination' ) ) {
	/**
	 * Pagination
	 * @return output rtframework_get_pagination()
	 */
	function rtframework_woocommerce_pagination(){
		global $wp_query;

		if( $wp_query->max_num_pages > 1 ){
			rtframework_get_pagination( $wp_query );
		}
	}
}


if ( ! function_exists( 'rtframework_woocommerce_show_page_title' ) ) {
	/**
	 * Remove WooCommerce show page title
	 * @return false
	 */
	function rtframework_woocommerce_show_page_title() {
		return false;
	}
}

if ( ! function_exists( 'rtframework_cart_items' ) ) {
	/**
	 * Cart items count
	 * @param  array $fragments
	 * @return html
	 */
	function rtframework_cart_items( $fragments ) {
		global $woocommerce;
		ob_start();
		?>
		<sub class="naturalife-cart-items <?php echo ( 0 == $woocommerce->cart->cart_contents_count ) ? "empty" : "";?>"><?php echo esc_attr( $woocommerce->cart->cart_contents_count );?></sub>
		<?php
		$fragments['.header-tools .cart .naturalife-cart-items'] = ob_get_clean();
		return $fragments;
	}
}


if ( ! function_exists( 'rtframework_product_meta_wrapper_start' ) ) {
	/**
	 * Product meta wrapper start
	 * @return html
	 */
	function rtframework_product_meta_wrapper_start() {
		?>
		<div class="product-meta-row d-flex justify-content-between align-items-center">
			<div class="product-meta-col">	 			
 		<?php
 		do_action( "rtframework_product_meta_before_start");
	}
}
add_action( "woocommerce_product_meta_start", "rtframework_product_meta_wrapper_start", 20 );

if ( ! function_exists( 'rtframework_product_meta_wrapper_end' ) ) {
	/**
	 * Product meta wrapper start
	 * @return html
	 */
	function rtframework_product_meta_wrapper_end() {
		do_action( "rtframework_product_meta_before_end");
		?>
			</div>
 		</div>
 		<?php
	}
}
add_action( "woocommerce_product_meta_end", "rtframework_product_meta_wrapper_end", 20 );


if ( ! function_exists( 'rtframework_woo_social_share' ) ) {
	/**
	 * Add social share to woo single page
	 * @return html
	 */
	function rtframework_woo_social_share( $fragments ) {
		?>
		</div>
		<div class="product-meta-col">
 			<?php echo rtframework_social_media_share( $atts = array("postid" => get_the_ID()) );?>
 		<?php
	}
}
add_action( "rtframework_product_meta_before_end", "rtframework_woo_social_share", 20 );


if ( ! function_exists( 'rtframework_woo_hrs' ) ) {
	/**
	 * HR
	 * @return html
	 */
	function rtframework_woo_hrs(  ) {
 
 		echo '<hr />';
 		 
	}
}
add_action( "woocommerce_single_product_summary", "rtframework_woo_hrs", 10 );

