<?php

// [search_products]
function search_products_shortcode($params = array(), $content = null) {
	extract(shortcode_atts(array(
		'ids'     => ''
	), $params));

	global $shopkeeper_theme_options;

	$output = '<div class="woocommerce columns-8">';
	$output .= '<ul id="products-grid" class="products small-up-4 medium-up-4 large-up-5 xlarge-up-6 xxlarge-up-8">';

	$ids = explode( ',', $params['ids']);

	foreach ( $ids as $product_id ) {
		$product = wc_get_product( $product_id );

		$output .= '<li class="column">';

		if ( (isset($shopkeeper_theme_options['second_image_product_listing'])) && ($shopkeeper_theme_options['second_image_product_listing'] == "1" ) ) {

			$product_thumbnail_second = [];
			$attachment_ids = $product->get_gallery_image_ids();
			if ( $attachment_ids ) {
				$loop = 0;
				foreach ( $attachment_ids as $attachment_id ) {
					$image_link = wp_get_attachment_url( $attachment_id );
					if (!$image_link) continue;
					$loop++;
					$product_thumbnail_second = wp_get_attachment_image_src($attachment_id, 'shop_catalog');
					if ($loop == 1) break;
				}
			}

			$style = '';
			$class = '';        
			if (isset($product_thumbnail_second[0])) {            
				$style = 'background-image:url(' . $product_thumbnail_second[0] . ')';
				$class = 'with_second_image second_image_loaded';     
			}
		}
		
		$instock_class = '';
		if( !$product->is_in_stock() ){
			$instock_class = 'outofstock';
		}

		$output .= '<div class="product_thumbnail_wrapper ' . $instock_class . '">';
					
		$output .= '<div class="product_thumbnail ' . $class . '">';
		$output .= '<a href="' . get_permalink( $product->get_id() ) . '">';
		$output .= '<span class="product_thumbnail_background" style="'. $style .'"></span>';

		if ( has_post_thumbnail( $product->get_id() ) ) { 	
			$output .= get_the_post_thumbnail( $product->get_id(), 'shop_catalog');
		} else {
			$output .= apply_filters( 'woocommerce_single_product_image_html', sprintf( '<img src="%s" alt="Placeholder" />', wc_placeholder_img_src() ), $product->get_id() );
		}

		$output .= '</a></div>';
					
		if ( (isset($shopkeeper_theme_options['catalog_mode'])) && ($shopkeeper_theme_options['catalog_mode'] == 0) ) {
			if ( $product->is_on_sale() ) :
				$output .= '<span class="onsale">' . esc_html__( 'Sale!', 'woocommerce' ) . '</span>';
			endif;

			if ( !$product->is_in_stock() && !empty($shopkeeper_theme_options['out_of_stock_label']) ) {         
	            $output .= '<div class="out_of_stock_badge_loop">' . esc_html( $shopkeeper_theme_options['out_of_stock_label'], 'woocommerce' ) . '</div>';            
	        }
	    }

		$output .= '</div>';
					
		$output .= '<h3><a class="product-title-link" href="' . get_permalink( $product->get_id() ) . '">' . $product->get_title() . '</a></h3>';   


	    $output .= '<div class="product_after_shop_loop">';					
		
		if ( $price_html = $product->get_price_html() ) :
			$output .= '<span class="price">' . $price_html . '</span>';
		endif;
	
		$output .= '</div>';
		$output .= '</li>';

	}

	$output .= '</ul>';
	$output .= '</div>';

	return $output;
}

add_shortcode('search_products', 'search_products_shortcode');