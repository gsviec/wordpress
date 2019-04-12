<?php
/**
 * 
 * template for displaying staff detail page
 *
 */
get_header(); ?>
 
<?php if ( have_posts() ) : ?> 
	<div <?php post_class("single")?> id="person-<?php the_ID(); ?>">	

		<?php /* The loop */ ?>
		<?php while ( have_posts() ) : the_post(); ?>		
			<?php get_template_part( 'staff-contents/single-content' ); ?>
		<?php endwhile; ?>		
	</div>
<?php else : ?>
	<?php get_template_part( 'content', 'none' ); ?>
<?php endif; ?>

<?php get_footer(); ?>