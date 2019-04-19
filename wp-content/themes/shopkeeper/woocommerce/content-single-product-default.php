<?php
 
	if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
	
    global $post, $product, $shopkeeper_theme_options;

    //woocommerce_before_single_product
	//nothing changed
	
	//woocommerce_before_single_product_summary
	remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
	remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
	
	add_action( 'woocommerce_before_single_product_summary_sale_flash', 'woocommerce_show_product_sale_flash', 10 );
	add_action( 'woocommerce_before_single_product_summary_product_images', 'woocommerce_show_product_images', 20 );
	
	//woocommerce_single_product_summary
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );
	
	add_action( 'woocommerce_single_product_summary_single_title', 'woocommerce_template_single_title', 5 );
	add_action( 'woocommerce_single_product_summary_single_rating', 'woocommerce_template_single_rating', 10 );
	add_action( 'woocommerce_single_product_summary_single_price', 'woocommerce_template_single_price', 10 );
	add_action( 'woocommerce_single_product_summary_single_excerpt', 'woocommerce_template_single_excerpt', 20 );
	add_action( 'woocommerce_single_product_summary_single_add_to_cart', 'woocommerce_template_single_add_to_cart', 30 );
	add_action( 'woocommerce_single_product_summary_single_meta', 'woocommerce_template_single_meta', 40 );
	add_action( 'woocommerce_single_product_summary_single_sharing', 'woocommerce_template_single_sharing', 50 );
	
	//woocommerce_after_single_product_summary
	remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
	remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
	remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
	
	add_action( 'woocommerce_after_single_product_summary_data_tabs', 'woocommerce_output_product_data_tabs', 10 );

	//woocommerce_after_single_product
	//nothing changed

	//custom actions
	add_action( 'woocommerce_before_main_content_breadcrumb', 'woocommerce_breadcrumb', 20, 0 );

	if(class_exists('WC_Wishlists_Plugin')) {
		remove_action('woocommerce_single_product_summary', array($GLOBALS['wishlists'], 'bind_wishlist_button'), 0);
		add_action('woocommerce_single_product_summary_single_add_to_cart', array($GLOBALS['wishlists'], 'bind_wishlist_button'), 0);
	}

?>

<div class="product_layout_classic">

	<?php if ( !post_password_required() ) : ?>

		<div  id="product-<?php the_ID(); ?>" <?php function_exists('wc_product_class')? wc_product_class() : post_class(); ?>>
			<div class="row">
		        <div class="large-12 xlarge-10 xxlarge-9 large-centered columns">     
					<div class="product_content_wrapper">
						
						<?php do_action( 'woocommerce_before_single_product' ); ?>
					
						<div class="row">
							
							<div class="large-6 medium-12 columns">
								<div class="product-images-wrapper">

									<?php				
										do_action( 'woocommerce_before_single_product_summary_product_images' );
										do_action( 'woocommerce_before_single_product_summary' );
									?>

									<div class="product-badges">
										<!-- sale -->
										<div class="product-sale">
												<?php do_action( 'woocommerce_before_single_product_summary_sale_flash' ); ?>
										</div>

									</div>

								</div>

						

							</div><!-- .columns -->
							
							<?php
							
							$viewed_products = ! empty( $_COOKIE['woocommerce_recently_viewed'] ) ? (array) explode( '|', $_COOKIE['woocommerce_recently_viewed'] ) : array();
							$viewed_products = array_filter( array_map( 'absint', $viewed_products ) );
							
							?>
							
							<div class="large-1 xlarge-1 xxlarge-1 columns">&nbsp;</div>
							
							<div class="large-4 xlarge-5 xxlarge-5 large-push-0 columns">
							
								<div class="product_infos">
									
									 <div class="product_summary_top">

									 	<?php do_action('woocommerce_before_main_content_breadcrumb');

									 		if ( !((isset($shopkeeper_theme_options['review_tab'])) && ($shopkeeper_theme_options['review_tab'] == "0" )) ) : 
											do_action( 'woocommerce_single_product_summary_single_rating' );
											endif;	
											
									 	 ?>

									 </div>
									 
									 <div class="product_summary_middle">
										<?php
											
											do_action( 'woocommerce_single_product_summary_single_title' );
											
											if ( post_password_required() ) {
												echo get_the_password_form();
												return;
											}
										?>
									</div><!--.product_summary_top-->
									
									<?php do_action( 'woocommerce_single_product_summary_single_price' ); ?>

										<?php if( GETBOWTIED_GERMAN_MARKET_IS_ACTIVE ) : ?>
											<div class="german-market-info">
												<?php do_action( 'woocommerce_single_product_german_market_info' ); ?>
											</div>
										<?php elseif( GETBOWTIED_WOOCOMMERCE_GERMANIZED_IS_ACTIVE ) : ?>
											<div class="germanized-active">
												<?php do_action( 'woocommerce_single_product_germanized_info' ); ?>
											</div>
										<?php endif; ?>

									<?php
										do_action( 'woocommerce_single_product_summary_single_excerpt' ); ?>
											
										<!-- out of stock --> 
                                       <?php if ( (isset($shopkeeper_theme_options['catalog_mode'])) && ($shopkeeper_theme_options['catalog_mode'] == 0) ) : ?> 
                                           <?php if ( !$product->is_in_stock() && !empty($shopkeeper_theme_options['out_of_stock_label']) ) : ?>    
                                                   <div class="out_of_stock_wrapper">          
                                                       <div class="out_of_stock_badge_single <?php if (!$product->is_on_sale()) : ?>first_position<?php endif; ?>"><?php _e( $shopkeeper_theme_options['out_of_stock_label'], 'woocommerce' ); ?> 
                                                            
                                                       </div>    
                                                   </div>          
                                           <?php endif; ?> 
                                       <?php endif; ?> 

										<?php
										do_action( 'woocommerce_single_product_summary_single_add_to_cart' );
										do_action( 'woocommerce_single_product_summary' );
										do_action( 'getbowtied_woocommerce_before_single_product_summary_data_tabs' ); 
										do_action( 'woocommerce_single_product_summary_single_meta' ); 
									?>
								
								</div>
					
							</div><!-- .columns -->

							<div class="large-1 columns show-for-large-only">&nbsp;</div>
								   
						</div><!-- .row -->
						
					</div><!--.product_content_wrapper-->
			
			   </div><!--large-9-->
		    </div><!-- .row -->
			
			<?php do_action( 'woocommerce_after_single_product_summary_data_tabs' ); ?>
			
		    <div class="row">
		        <div class="large-9 large-centered columns">
		            <?php					
						do_action( 'woocommerce_single_product_summary_single_sharing' );
						do_action( 'woocommerce_after_single_product_summary' );
					?>
		            
		        </div><!-- .columns -->
		    </div><!-- .row -->
		    
		    <meta itemprop="url" content="<?php the_permalink(); ?>" />

		</div><!-- #product-<?php the_ID(); ?> -->

		<div class="row">
		    <div class="xlarge-9 xlarge-centered columns">

				<?php do_action( 'woocommerce_after_single_product' ); ?>
				
		    </div><!-- .columns -->
		</div><!-- .row -->		
		
		<!-- product navigation -->
		<div class="product_navigation">

		   <?php shopkeeper_product_nav( 'nav-below' ); ?>

	   </div> 



		<?php if ( $product->get_upsell_ids() ) : ?>
			<div class="single_product_summary_upsell">
			    <div class="row">
					<div class="xlarge-9 xlarge-centered columns">
						<?php do_action( 'woocommerce_after_single_product_summary_upsell_display' ); ?>
					</div><!--.large-9-->
			    </div><!-- .row -->         
			</div><!-- .single_product_summary_upsell -->
		<?php endif; ?>


		<div class="single_product_summary_related">
		    <div class="row">
				<div class="xlarge-9 xlarge-centered columns">
					<?php do_action( 'woocommerce_after_single_product_summary_related_products' ); ?>
				</div><!--.large-9-->
		    </div><!-- .row -->
		</div><!-- .single_product_summary_related -->

				
	<?php else: ?>

		<div class="row">
		    <div class="large-9 large-centered columns">
		    <br/><br/><br/><br/>
				<?php echo get_the_password_form(); ?>
			</div>
		</div>

	<?php endif; ?>
	


</div>