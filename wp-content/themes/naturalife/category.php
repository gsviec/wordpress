<?php
/* 
* rt-theme categories
*/
get_header();
?>
		<?php
			the_archive_description( '<div class="tax-description">', '</div>' );
		?>

		<?php 
			if ( have_posts() ){
				do_action( "rtframework_blog_post_loop", $wp_query, array("more"=>1) );			
			}else{				
				get_template_part( 'content', 'none' );
			}
		?>


<?php get_footer(); ?>