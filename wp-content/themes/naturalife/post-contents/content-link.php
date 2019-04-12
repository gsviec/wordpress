<?php
# 
# rt-theme
# post content for standart post types in listing pages
# 
extract(rtframework_get_global_value("rtframework_post_values"));
extract(rtframework_get_global_value("rtframework_blog_list_atts"));
?> 

<!-- blog box-->

	<?php if( ! empty( $thumbnail_image_output )  ):?>
	<figure class="featured_image featured_media">
		<?php 
			//create lightbox link
			do_action("rtframework_display_loop_image",
				array(
					'class'     => 'imgeffect extlink',
					'href'      => esc_url($post_format_link),
					'title'     => $title,
					'thumbnail' => $thumbnail_image_output
				)
			);
		?>		
	</figure> 
	<?php endif;?>
	
	<div class="entry-content text">

		<!-- blog headline-->
		<<?php echo esc_attr($heading_size)?> class="entry-title"><a href="<?php echo esc_url($permalink); ?>" rel="bookmark"><?php the_title(); ?></a></<?php echo esc_attr($heading_size)?>> 
 
	 	<?php 
			//post data		
			do_action( "rtframework_post_meta_bar", array( "show_date"=> $show_date, "show_author"=> $show_author, "show_categories" => $show_categories, "show_comment_numbers" => $show_comment_numbers ) ); 
		?>				

		<?php 

			if( $use_excerpts !== "false" ){
						
				if( $excerpt_length != "" && intval( $excerpt_length ) > 0 ) {
					echo '<p>'.wp_html_excerpt(get_the_excerpt(),$excerpt_length,"...").'</p>';
				}elseif( $excerpt_length == "" ){
					the_excerpt();
				}
					
			}else{
				the_content("");
				wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'naturalife' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) );
			}
		?>
	</div> 
	
	<div class="entry-footer">

		<?php 
			//remove more link
			echo ( "false" !== $use_excerpts ||  strpos( $post->post_content, '<!--more-->' )) ? '<a href="'.esc_url($permalink).'" class="entry-read-more">'.esc_html__( 'read more', 'naturalife' ).'</a>' : ""; 

			//Social Share buttons
			echo ( 'false' !== $show_share ) ?rtframework_social_media_share( $atts = array("postid" => get_the_ID()) ) : ""; 
		?>

	</div>

<!-- / blog box-->