<?php
/**
 * Empty cart page
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.0
 */

defined( 'ABSPATH' ) || exit;

?>

<style>
	.page-title { display: none; }
</style>

<div class="row">
	<div class="large-10 text-center large-centered columns">
		
		<?php do_action( 'woocommerce_cart_is_empty' ); ?>
		
		<p class="return-to-shop"><a class="wc-backward" href="<?php echo get_permalink( wc_get_page_id( 'shop' ) ); ?>"><?php esc_html_e( 'Return to shop', 'woocommerce' ); ?></a></p>

	</div><!-- .large-10-->
</div><!-- .row-->