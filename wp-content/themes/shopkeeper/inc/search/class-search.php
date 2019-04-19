<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

if(class_exists('woocommerce')) {

	class GBT_Ajax_Search {

		/*
		 * Suggestions limit
		 * int
		 */
		private $limit = 100;

		/*
		 * Empty slots
		 * int
		 */
		private $slots = 100;

		function __construct() {

			add_action( 'wp_enqueue_scripts', array( $this, 'getbowtied_js_scripts' ) );
			// add_filter( 'posts_search', array( $this, 'getbowtied_search_filters' ), 501, 2 );

			// Search results ajax action
			add_action( 'wc_ajax_' . 'search_ajax_search', array( $this, 'getbowtied_get_search_results' ) );
		}

		/*
		 * Register scripts.
		 */
		public function getbowtied_js_scripts() {

			if ( !is_admin() ) {

				// Main JS
				$localize = array(
					'ajax_search_endpoint'	 => WC_AJAX::get_endpoint( 'search_ajax_search' ),
					'action_search'			 => 'search_ajax_search',
					'min_chars'				 => 3,
					'show_preloader'		 => true,
				);

				wp_enqueue_script( 'jquery-search', get_template_directory_uri() . '/js/components/ajax-search.js', array( 'jquery' ), getbowtied_theme_version(), true );
				
				wp_localize_script( 'jquery-search', 'search', $localize );
			}
		}

		/*
		 * Get search results via ajax
		 */

		public function getbowtied_get_search_results() {
			global $woocommerce;

			$output	 = array();
			$results = array();
			$keyword = sanitize_text_field( $_REQUEST[ 'search_keyword' ] );

			// Continue searching in products if there are room in the slots
			/* SEARCH IN PRODUCTS */
			if ( $this->slots > 0 ) {

				if ( 'yes' === get_option( 'woocommerce_hide_out_of_stock_items' ) ) {
					$tax_query = array(
						'relation' 	   => 'AND',
		              	array(
							'taxonomy' => 'product_visibility',
							'field'    => 'name',
							'terms'    => 'exclude-from-search',
							'operator' => 'NOT IN',
						),
						array(
							'taxonomy' => 'product_visibility',
							'field'    => 'name',
							'terms'    => 'outofstock',
							'operator' => 'NOT IN',
						)
					);
				} else {
					$tax_query = array(
		              	array(
							'taxonomy' => 'product_visibility',
							'field'    => 'name',
							'terms'    => 'exclude-from-search',
							'operator' => 'NOT IN',
						)
		            );
				}

				$args = array(
					's'						 => $keyword,
					'posts_per_page'		 => 8,
					'post_type'				 => 'product',
					'post_status'			 => 'publish',
					'ignore_sticky_posts'	 => 1,
					// 'orderby'				 => 'title',
					// 'order'					 => 'asc',
					'suppress_filters'		 => false,
					'tax_query'				 => $tax_query
				);

				$args = apply_filters('search_products_args', $args);

				$products = get_posts( $args );

				$ids = '';

				if ( !empty( $products ) ) {

					foreach ( $products as $post ) {

						$product = wc_get_product( $post );
						$ids .= $product->get_id() . ',';
					}
				}
				wp_reset_postdata();
			} /* END SEARCH IN PRODUCTS */

			if( !empty( $ids ) ) {
				$output[ 'suggestions' ] = (string) do_shortcode('[search_products columns="8" orderby="title" order="" ids="' . rtrim($ids,',') . '"]');
			} else {
				$output['suggestions'] =  '';
			}

			echo json_encode( $output );
			die();
		}

		/*
		 * Search only in products titles
		 * 
		 * @param string $search SQL
		 * 
		 * @return string prepared SQL
		 */

		public function getbowtied_search_filters( $search, $wp_query ) {
			global $wpdb;

			if ( empty( $search ) || is_admin() ) {
				return $search; // skip processing - there is no keyword
			}

			$q = $wp_query->query_vars;

			if ( $q[ 'post_type' ] !== 'product' ) {
				return $search; // skip processing
			}

			$n = !empty( $q[ 'exact' ] ) ? '' : '%';

			$search		 = $searchand	 = '';

			if ( !empty( $q[ 'search_terms' ] ) ) {
				foreach ( (array) $q[ 'search_terms' ] as $term ) {
					$term = esc_sql( $wpdb->esc_like( $term ) );

					$search .= "{$searchand} (";

					// Search in title
					$search .= "($wpdb->posts.post_title LIKE '{$n}{$term}{$n}')";

					$search .= ")";

					$searchand = ' AND ';
				}
			}

			if ( !empty( $search ) ) {
				$search = " AND ({$search}) ";
				if ( !is_user_logged_in() )
					$search .= " AND ($wpdb->posts.post_password = '') ";
			}

			return $search;
		}
	}

	$search = new GBT_Ajax_Search;
}

?>