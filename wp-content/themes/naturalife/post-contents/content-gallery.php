<?php
# 
# rt-theme
# post content for gallery post types in listing pages
# 
extract(rtframework_get_global_value("rtframework_post_values"));
extract(rtframework_get_global_value("rtframework_blog_list_atts"));
?> 



<!-- blog box-->

	<?php if( ! empty( $thumbnail_image_output ) && $gallery_usage_listing == "only_featured_image" ):?>
	<figure class="featured_image featured_media">
		<?php 
			//create lightbox link
			do_action("rtframework_display_loop_image",
				array(
					'class'     => 'imgeffect gallery',
					'href'      => esc_url($permalink),
					'title'     => $title,
					'thumbnail' => $thumbnail_image_output
				)
			);
		?>		
	</figure> 
	<?php endif;?>

	<?php
	/*
	*
	* Multiple Image
	*
	*/

	if( rtframework_convert_bool($show_featured_media) != "false" && is_array( $gallery_images ) && count( $gallery_images ) > 0 && (  $gallery_usage_listing == "same" )  ){

		if( $gallery_usage == "slider" ){ //create sldier from the images ?>
			<div class="slideshow featured_media">
				<?php
					// Get image slider
					do_action("rtframework_create_image_carousel",
						apply_filters("loop-post-slider-atts", array( 
							"id"  => 'post-carousel-'.get_the_ID(),   
							"crop" => $slider_images_crop, 
							"h"	 => $slider_images_max_height,
							"rt_gallery_images" => $gallery_images,
							"column_width" => $list_layout,
							"carousel_atts" => array( 
												"id"          => 'post-single-gallery-'.get_the_ID(),  
												"item_width"  => 1, 
												"class"       => "post-carousel",
												"dots"        => "false",
												"nav"         => "true"
											),
							"lightbox" => true
						))
					);
				?>
			</div> 

		<?php }else{  //create photo gallery from the images ?>

			<div class="photo-gallery featured_media">
				<?php

					// Get image gallery
					do_action("rtframework_create_photo_gallery",
						apply_filters("loop-post-grid-gallery-atts", array(  
							"slider_id"    => 'post-single-gallery-'.get_the_ID(),  
							"crop"         => true, 	    
							'image_ids'    => $gallery_images, 
							"links"        => "lightbox",
							"w"            => 480,
							"h"            => 480,
							"captions"     => false,
							"item_width"   => "1/3",
							"layout_style" => "grid",
							"nogaps"       => true,
							"image_size"   => "custom"
						))
					);
				?>
			</div>

		<?php
		}
	}
	?> 

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