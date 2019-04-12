<?php
/**
 * 
 * The template for displaying all single posts
 *
 */
get_header(); 

//get global post values
$rtframework_single_post_values = rtframework_get_single_post_values( $post );
?>
 
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?> 
		<?php  
			set_query_var( 'post_vars', $rtframework_single_post_values); 
			get_template_part( '/post-contents/single-content', get_post_format() ); 
		?>
	<?php endwhile; else : ?>
		<?php 
			get_template_part( 'content', 'none' ); 
		?>
	<?php endif; ?>			 

	<?php if( $rtframework_single_post_values["show_author_info"] ):?>
		<?php get_template_part("author","bio"); ?>
	<?php endif;?>

	<?php if( ( get_comments_number() > 0 || comments_open() ) && ! is_attachment() ):?>
		<div class='entry commententry'>
			<?php comments_template(); ?>
		</div>
	<?php endif;?>


<?php get_footer(); ?>