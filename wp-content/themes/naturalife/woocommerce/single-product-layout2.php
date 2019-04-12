<?php
/**
 * The template for displaying single woocommerce product
 * 
 * Template Name: Product Layout 2
 * Template Post Type: product
 * 
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header( 'shop' ); ?>

	<?php
		/**
		 * woocommerce_before_main_content hook.
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 */
		do_action( 'woocommerce_before_main_content' );
	?>

		<?php while ( have_posts() ) : the_post(); ?>
				<?php
					/**
					 * woocommerce_before_single_product hook.
					 *
					 * @hooked wc_print_notices - 10
					 */
					 do_action( 'woocommerce_before_single_product' );

					 if ( post_password_required() ) {
					 	echo get_the_password_form();
					 	return;
					 }
				?>

				<div id="product-<?php the_ID(); ?>" <?php post_class("row"); ?>>
					<div class="<?php echo apply_filters( "rtframework-single-product-col-classes-1", "col col-12 col-lg-6 sticky-sidebar" );?>">	
						<div class="column-inner">

									<?php
										/**
										 * woocommerce_before_single_product_summary hook.
										 *
										 * @hooked woocommerce_show_product_sale_flash - 10
										 * @hooked woocommerce_show_product_images - 20
										 */
										do_action( 'woocommerce_before_single_product_summary' );
									?>

						</div>
					</div>
					<div class="<?php echo apply_filters( "rtframework-single-product-col-classes-2", "col col-12 col-lg-6 content" );?>">	
						<div class="column-inner">
 
									<div class="summary entry-summary">

										<?php
											/**
											 * woocommerce_single_product_summary hook.
											 *
											 * @hooked woocommerce_template_single_title - 5
											 * @hooked woocommerce_template_single_rating - 10
											 * @hooked woocommerce_template_single_price - 15
											 * @hooked woocommerce_template_single_excerpt - 20
											 * @hooked woocommerce_template_single_add_to_cart - 30
											 * @hooked woocommerce_template_single_meta - 40
											 * @hooked woocommerce_template_single_sharing - 50
											 * @hooked WC_Structured_Data::generate_product_data() - 60
											 * @hooked woocommerce_output_product_data_tabs - 70
											 */
											do_action( 'woocommerce_single_product_summary' );
										?>

									</div><!-- .summary -->

						</div>
					</div>
				</div><!-- #product-<?php the_ID(); ?> -->


				<?php
					/**
					 * woocommerce_after_single_product_summary hook.
					 *
					 * @hooked woocommerce_upsell_display - 15
					 * @hooked woocommerce_output_related_products - 20
					 */
					do_action( 'woocommerce_after_single_product_summary' );
				?>

				<?php do_action( 'woocommerce_after_single_product' ); ?>


		<?php endwhile; // end of the loop. ?>

	<?php
		/**
		 * woocommerce_after_main_content hook.
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action( 'woocommerce_after_main_content' );
	?>

	<?php
		/**
		 * woocommerce_sidebar hook.
		 *
		 * @hooked woocommerce_get_sidebar - 10
		 */
		do_action( 'woocommerce_sidebar' );
	?>

<?php get_footer( 'shop' );

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */