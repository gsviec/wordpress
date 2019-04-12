<?php
/* 
* rt-theme product taxomony categories
*/
get_header();	
?>

<section id="search-results" >		

	<?php if ( have_posts() ) : 

		while ( have_posts() ) : the_post(); ?>

				<article class="search_result loop" id="post-<?php the_ID(); ?>"> 

					<div class="search-post-title">
						<a href="<?php echo esc_url(get_permalink()); ?>" rel="bookmark"><span class="icon-right-hand"></span><?php the_title(); ?></a> 				 
					</div><!-- / end div  .post-title-holder -->

					<?php 
						echo rtframework_search_highlight( trim( get_search_query() ), get_the_excerpt() );
					?>

				</article>  

		<?php
		endwhile;

		rtframework_get_pagination( $wp_query );
		else : ?>

		<?php get_template_part( 'content', 'none' ); ?>
	<?php endif; ?>

</section><!-- / end section #search-results -->  

<?php get_footer(); ?>