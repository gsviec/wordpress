<?php
# 
# rt-theme
# single post content for gallery post types
# 
extract($post_vars);
?>  

<article <?php post_class("single")?> id="post-<?php the_ID(); ?>">
	
	<?php if( ! empty( $thumbnail_image_output ) && ! $featured_image_single_page ):?>
	<figure class="featured_image featured_media">
		<?php 
			//create lightbox link
			do_action("rtframework_create_lightbox_link",
				array(
					'class'          => 'imgeffect zoom rt_lightbox featured_image',
					'href'           => $featured_image_url,
					'title'          => esc_html__('Enlarge Image','naturalife'),
					'data_group'     => 'image_'.$featured_image_id,
					'data_title'     => $title,
					'data_thumbnail' => $lightbox_thumbnail,
					'inner_content'  => $thumbnail_image_output
				)
			);
		?>
		<span class="format-icon icon-pencil"></span>
	</figure> 
	<?php endif;?>

	<?php
	/*
	*
	* Multiple Image
	*
	*/



	if( is_array( $gallery_images ) && count( $gallery_images ) > 0 ){

		if( $gallery_usage == "slider" ){ //create sldier from the images ?>
			<div class="slideshow featured_media">
				<?php
					// Get image slider
					do_action("rtframework_create_image_carousel",
						apply_filters("single-post-slider-atts", array( 
							"id"  => 'post-carousel-'.get_the_ID(),   
							"crop" => $slider_images_crop, 
							"h"	 => $slider_images_max_height,
							"rt_gallery_images" => $gallery_images,
							"column_width" => $layout,
							"links" => "lightbox",
							"carousel_atts" => array( 
												"id"          => 'post-single-gallery-'.get_the_ID(),  
												"item_width"  => 1, 
												"class"       => "post-carousel",
												"dots"        => "false",
												"nav"         => "true"												
											)
						))
					);
				?>
				<span class="format-icon icon-picture"></span>
			</div> 

		<?php }else{  //create photo gallery from the images ?>

			<div class="photo-gallery featured_media">
				<?php

					// Get image gallery
					do_action("rtframework_create_photo_gallery",
						apply_filters("single-post-grid-gallery-atts", array( 
							"slider_id"    => 'post-single-gallery-'.get_the_ID(),  
							"crop"         => true, 	    
							'image_ids'    => $gallery_images, 
							"links"        => "lightbox",
							"w"            => 480,
							"h"            => 480,
							"captions"     => true,
							"item_width"   => "1/3",
							"layout_style" => "grid",
							"nogaps"       => false,
							"image_size"   => "custom"
						))
					);
				?>
			</div>

		<?php
		}

	}

	?> 

	<div class="text entry-content">		

		<!-- title --> 
		<?php printf('<%2$s class="entry-title">%1$s</%2$s>', get_the_title(), rtframework_get_setting( "heading_tag" ) ) ?>

		<?php 
			//post meta bar
			do_action( "rtframework_post_meta_bar", array( "show_author"=> $show_author, "show_categories" => $show_categories, "show_comment_numbers" => $show_comment_numbers, "show_date" => $show_date, "show_tags" => "false") ); 
		?>
		
		<!-- content--> 
		<?php the_content(); ?>

		<!-- pagination--> 
		<?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'naturalife' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>

		<!-- updated--> 
		<span class="updated hidden"><?php echo esc_html(the_modified_date());?></span>

	</div> 


	<div class="entry-footer d-sm-flex justify-content-between align-items-center">

		<div class="entry-footer-left">
			<?php if( $show_tags !== "false" && get_the_tags() ):?>
			<!-- tags -->
			<span class="tags"><?php the_tags("","","");?></span>
			<?php endif;?>
		</div>

		<div class="entry-footer-right">
			<?php			
				//Social Share buttons
				echo ( 'false' !== $show_share ) ?rtframework_social_media_share( $atts = array("postid" => get_the_ID()) ) : ""; 
			?>
		</div>

	</div>

</article>