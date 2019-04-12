<?php
/**
 * 
 * The template for displaying all pages
 *
 */
get_header(); ?>

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
 
<?php get_footer(); ?>