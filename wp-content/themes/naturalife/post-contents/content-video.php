<?php
# 
# rt-theme
# post content for video post types in listing pages
# 
extract(rtframework_get_global_value("rtframework_post_values"));
extract(rtframework_get_global_value("rtframework_blog_list_atts"));
?> 

<!-- blog box-->
	<?php 
	//display featured image
	if( ! empty( $thumbnail_image_output ) && $video_usage_listing == "only_featured_image"  ): ?>
	<figure class="featured_image featured_media">
		<?php 
			//create lightbox link
			do_action("rtframework_display_loop_image",
				array(
					'class'     => 'imgeffect video',
					'href'      => esc_url($permalink),
					'title'     => $title,
					'thumbnail' => $thumbnail_image_output
				)
			);
		?>		
	</figure> 
	<?php endif;?>

	<?php 
	//display the video
	if( rtframework_convert_bool($show_featured_media) != "false" &&  $video_usage_listing == "same" && ( $external_video || $video_mp4 ) ) : ?>
	<div class="featured_video featured_media">
		<?php
		//self hosted videos
		if( $video_mp4 ){
			do_action("rtframework_create_media_output",
				array(
					'id' => 'video-'.get_the_ID(),
					'type' => "video",
					'file_mp4' => $video_mp4,
					'file_webm' => $video_webm,
					'poster'=> $featured_image_url
				)
			);
		}

		//external videos
		if ($external_video){
			 
			if( strpos($external_video, 'youtube')  ) { //youtube
				echo '<div class="video-container embed-responsive embed-responsive-16by9"><iframe class="embed-responsive-item" src="//www.youtube.com/embed/'.rtframework_find_tube_video_id(esc_url($external_video)).'?rel=0&amp;showinfo=0" allowfullscreen></iframe></div>';
			}
			
			if( strpos($external_video, 'vimeo')  ) { //vimeo
				echo '<div class="video-container embed-responsive embed-responsive-16by9"><iframe class="embed-responsive-item" src="//player.vimeo.com/video/'.rtframework_find_tube_video_id(esc_url($external_video)).'?color=d6d6d6&title=0&amp;byline=0&amp;portrait=0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe></div>';
			}			
		}
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
