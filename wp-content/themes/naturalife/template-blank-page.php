<?php
/**
 * 
 * Template Name: Blank Page
 * Template Post Type: page,portfolio,post,staff,elementor
 *
 */
?>
<!doctype html>
<html <?php language_attributes(); ?> class="no-js">
<head> 
<meta charset="<?php bloginfo( 'charset' ); ?>" />  
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php endif; ?>
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>  
<?php do_action("rtframework_after_body"); ?>

<!-- background wrapper -->
<div id="container">    
<?php do_action("rtframework_start_container"); ?> 

	<!-- main contents -->
	<div id="main-content">

		<?php if ( have_posts() ) : ?> 

			<?php /* The loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>		
				
					<?php if ( has_post_thumbnail() && ! post_password_required() ) : ?>
					<div class="entry-thumbnail">
						<?php the_post_thumbnail(); ?>
					</div>
					<?php endif; ?>
					
					<?php the_content(); ?>
					<?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'naturalife' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>			

					<?php
						/**
						 * Comments
						 */
						if( get_theme_mod( 'naturalife_page_comments' ) != "disabled" && ( comments_open() || get_comments_number() ) ):
					?>
						<div class='entry commententry'>
							<?php comments_template(); ?>
						</div>
					<?php endif;?>


			<?php endwhile; ?>		
		<?php else : ?>
			<?php get_template_part( 'content', 'none' ); ?>
		<?php endif; ?>
	 
	</div><!-- / end #main-content -->

<?php do_action("rtframework_end_container"); ?> 
</div><!-- / end #container --> 

<?php wp_footer(); ?>
</body>
</html>