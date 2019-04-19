<?php

/******************************************************************************/
/* Ajax Product Search ********************************************************/
/******************************************************************************/	

function getbowtied_product_search() {
	?>

	<div class="widget_product_search">
		<div class="search-wrapp">
		    <form class="woocommerce-product-search search-form" role="search" method="get" action="<?php echo esc_url( home_url( '/'  ) ) ?>">
		        <div>
		            <input type="search"
		                   value="<?php echo get_search_query(); ?>"
		                   name="s"
		                   id="search-input"
		                   class="search-field search-input"
		                   placeholder="<?php echo esc_html_e( 'Search products&hellip;', 'woocommerce' ); ?>"
		                   data-min-chars="3" 
		                   autocomplete="off" />
		            <div class="search-preloader"></div>

		            <input type="submit" value="<?php echo esc_html( 'Search', 'woocommerce' );  ?>" />
		            <input type="hidden" name="post_type" value="product" />

		            <?php if ( defined( 'ICL_LANGUAGE_CODE' ) ): // WPML compatible ?>
		              <input type="hidden" name="lang" value="<?php echo( ICL_LANGUAGE_CODE ); ?>" />
		            <?php endif; ?>
		        </div>
		    </form>
		</div>
	</div>

	<?php
}
add_action( 'getbowtied_product_search', 'getbowtied_product_search' );