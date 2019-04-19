<?php
/**
 * Product quantity inputs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/quantity-input.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the ver4sion of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see       https://docs.woocommerce.com/document/template-structure/
 * @author     WooThemes
 * @package   WooCommerce/Templates
 * @version     3.4.0
 */
 
defined( 'ABSPATH' ) || exit;
 
global $shopkeeper_theme_options;  
 
if ( $max_value && $min_value === $max_value ) {
	?>
	<div class="quantity hidden">
		<input type="hidden" id="<?php echo esc_attr( $input_id ); ?>" class="qty" name="<?php echo esc_attr( $input_name ); ?>" value="<?php echo esc_attr( $min_value ); ?>" />
	</div>
	<?php
} else {
	/* translators: %s: Quantity. */
	$labelledby = ! empty( $args['product_name'] ) ? sprintf( __( '%s quantity', 'woocommerce' ), strip_tags( $args['product_name'] ) ) : '';
	if ( isset($shopkeeper_theme_options['product_quantity_style']) && $shopkeeper_theme_options['product_quantity_style'] == "custom") { ?>
		<div class="quantity custom">
			<label class="screen-reader-text" for="<?php echo esc_attr( $input_id ); ?>"><?php esc_html_e( 'Quantity', 'woocommerce' ); ?></label>
			<a href="#" class="<?php echo is_rtl() ? 'plus-btn' : 'minus-btn' ?>">
				<i class="spk-icon <?php echo is_rtl() ? 'spk-icon-plus' : 'spk-icon-minus' ?>"></i>
			</a>
			<input
				type="number"
				id="<?php echo esc_attr( $input_id ); ?>"
				class="input-text custom-qty qty text"
				onkeyup="this.value=this.value.replace(/[^\d]/,'')"
				step="<?php echo esc_attr( $step ); ?>"
				min="<?php echo esc_attr( $min_value ); ?>"
				max="<?php echo esc_attr( 0 < $max_value ? $max_value : '' ); ?>"
				name="<?php echo esc_attr( $input_name ); ?>"
				value="<?php echo esc_attr( $input_value ); ?>"
				title="<?php echo esc_attr_x( 'Qty', 'Product quantity input tooltip', 'woocommerce' ); ?>"
				size="4"
				pattern="<?php echo esc_attr( $pattern ); ?>"
				inputmode="<?php echo esc_attr( $inputmode ); ?>"
				aria-labelledby="<?php echo esc_attr( $labelledby ); ?>" />
			<a href="#" class="<?php echo is_rtl() ? 'minus-btn' : 'plus-btn' ?>">
				<i class="spk-icon <?php echo is_rtl() ? 'spk-icon-minus' : 'spk-icon-plus' ?>"></i>
			</a>
		</div>
 	<?php } else { ?>
		<div class="quantity">
			<label class="screen-reader-text" for="<?php echo esc_attr( $input_id ); ?>"><?php esc_html_e( 'Quantity', 'woocommerce' ); ?></label>
			<input
				type="number"
				id="<?php echo esc_attr( $input_id ); ?>"
				class="input-text default-qty qty text"
				step="<?php echo esc_attr( $step ); ?>"
				min="<?php echo esc_attr( $min_value ); ?>"
				max="<?php echo esc_attr( 0 < $max_value ? $max_value : '' ); ?>"
				name="<?php echo esc_attr( $input_name ); ?>"
				value="<?php echo esc_attr( $input_value ); ?>"
				title="<?php echo esc_attr_x( 'Qty', 'Product quantity input tooltip', 'woocommerce' ); ?>"
				size="4"
				pattern="<?php echo esc_attr( $pattern ); ?>"
				inputmode="<?php echo esc_attr( $inputmode ); ?>"
				aria-labelledby="<?php echo esc_attr( $labelledby ); ?>" />
		</div>
   <?php }
}
