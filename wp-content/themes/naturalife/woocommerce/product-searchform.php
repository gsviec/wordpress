<?php
/**
 * The template for displaying product search form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/product-searchform.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.3.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

<form role="search" method="get" class="woocommerce-product-search rt_form" action="<?php echo esc_url( home_url( '/'  ) ); ?>">
	<ul>
		<li>
			<input type="search" id="woocommerce-product-search-field" class="search search-field" placeholder="<?php echo esc_attr_x( 'Search Products&hellip;', 'placeholder', 'naturalife' ); ?>" value="<?php echo esc_attr(get_search_query()); ?>" name="s" title="<?php echo esc_attr_x( 'Search for:', 'label', 'naturalife' ); ?>" /><span class="search-icon ui-icon-search-1"></span>
			<input type="hidden" name="post_type" value="product" />
		</li>
	</ul>
</form>