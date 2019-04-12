<?php
# 
# rt-theme
# post content for audio post types in listing pages
# 
extract(rtframework_get_global_value("rtframework_post_values"));
extract(rtframework_get_global_value("rtframework_blog_list_atts"));
?> 

<!-- blog box-->
	<?php 
	//display featured image
	if( ! empty( $thumbnail_image_output ) && $audio_usage_listing == "only_featured_image"  ): ?>

	<figure class="featured_image featured_media">
		<?php 
			//create lightbox link
			do_action("rtframework_display_loop_image",
				array(
					'class'     => 'imgeffect audio',
					'href'      => esc_url($permalink),
					'title'     => $title,
					'thumbnail' => $thumbnail_image_output
				)
			);
		?>		
	</figure> 


	<?php endif;?>

	<?php 
	//display the audio
	if( rtframework_convert_bool($show_featured_media) != "false" && $audio_usage_listing == "same" && $audio_mp3 ) : ?>
	<div class="featured_audio featured_media">

		<?php
		//self hosted audio
		do_action("rtframework_create_media_output",
			array(
				'id' => 'audio-'.get_the_ID(),
				'type' => "audio",
				'file_mp3' => $audio_mp3,
				'file_oga' => $audio_ogg,
				'poster'=> $featured_image_url					
			)
		);
		?>
	</div> 		
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
