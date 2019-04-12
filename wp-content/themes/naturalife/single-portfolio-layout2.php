<?php
/**
 * The template for displaying single portfolio content
 * 
 * Template Name: Portfolio 2 Columns
 * Template Post Type: portfolio
 * 
 */

//get post values
$rtframework_single_post_values = rt_get_portfolio_single_post_values( $post );

get_header(); ?>

	<?php if ( have_posts() ) : ?> 

		<?php /* The loop */ ?>
		<?php while ( have_posts() ) : the_post(); ?>		
			
			<?php 
			/* content */
			$content = get_the_content();

			/* show default gallery */
			$show_default_gallery = ( ! empty( $rtframework_single_post_values["gallery_images"] ) || ! empty( $rtframework_single_post_values["external_video"] ) || ! empty( $rtframework_single_post_values["video_mp4"] ) ) && $rtframework_single_post_values["portfolio_options"]["gallery_usage"] != "hidden" ;
 			?>
 			
 			<div class="portfolio-info-row content-row default-style fullwidth">
				<div class="row portfolio-info content-row-wrapper">
					<div class="col col-12 col-lg-8 content">	
						<div class="column-inner">
							<?php
								/**
								 *  Get Media 
								 */ 

								if( ! empty( $rtframework_single_post_values["portfolio_format"] ) ){
									
									if( $rtframework_single_post_values["portfolio_format"] == "image" && $rtframework_single_post_values["portfolio_options"]["gallery_usage"] != "hidden" ){
										get_template_part( "portfolio-contents/".$rtframework_single_post_values["portfolio_options"]["gallery_usage"] );
									}

									if( $rtframework_single_post_values["portfolio_format"] == "video" ){
										get_template_part( "portfolio-contents/video" );
									}					

								}
							?>	 
						</div>
					</div>
					<div class="col col-12 col-lg-4 portfolio-sidebar sticky-sidebar">	
						<div class="column-inner">
							<div class="portfolio-text"> 
									<?php 
										/**
										 * Main Content
										 */
										the_content();			
									?> 
							</div>

							<?php if( $rtframework_single_post_values["page_layout"] == "default" &&  ! empty( $rtframework_single_post_values["key_details"] ) ): ?>
							<div class="key-details">
									<?php 
										/**
										 * Key Details
										 */
										echo apply_filters( "rtframework_the_content", wp_kses_post( $rtframework_single_post_values["key_details"] ) );									
									?>

									<?php 
									/**
									 * Social Share
									 */
									if( apply_filters("rtframework_portfolio_share" , rtframework_get_setting("portfolio_share") ) ): ?>
											<?php 
												//Social Share buttons
												echo rtframework_social_media_share( $atts = array("postid" => get_the_ID()) );
											?> 
									<?php endif; ?>				
							</div>
							<?php endif; ?>	
						</div> 
					</div>
				</div>
 			</div>

		<?php endwhile; ?>		
	<?php else : ?>
		<?php get_template_part( 'content', 'none' ); ?>
	<?php endif; ?>
 
<?php get_footer(); ?>