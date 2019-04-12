<?php
# 
# rt-theme
# loop item for testimonail custom posts
# image post format
# 
$settings      = rtframework_get_global_value("rtframework_testimonial_settings"); 
$name          = get_post_meta( $post->ID, 'rttheme_name', true); 		
$title         = get_post_meta( $post->ID, 'rttheme_title', true); 
$link          = get_post_meta( $post->ID, 'rttheme_link', true); 
$testimonial   = get_post_meta( $post->ID, 'rttheme_testimonial', true); 		
$link_text     = get_post_meta( $post->ID, 'rttheme_link_text', true); 
?>

<div class="text">
	<span class="quote">&#8220;</span>
	<?php if( $settings["headings"] !== "false" ):?><h6><?php the_title();?></h6><?php endif;?>
	<?php echo apply_filters( "the_content", wp_kses_post($testimonial) ); ?>	
</div>



<?php if( $settings["client_images"] !== "false" && has_post_thumbnail() ) : ?>
	<div class="testimonial-footer">
		<div class="client-image">
			<?php
			// Create thumbnail image
			echo rtframework_get_resized_image_output( array( "image_url" => "", "image_id" => get_post_thumbnail_id(), "w" => 80, "h" => 80, "crop" => true ) )
			?>
		</div>

		<div class="client-info">
			<h6><?php echo esc_html($name); ?></h6>
			<?php echo ! empty( $title ) ? '<span>'. esc_html($title). '</span>' : "" ; ?>		
			<?php echo ! empty( $link ) && ! empty( $link_text ) ? '<a href="'. esc_url($link) . '" target="_blank" title="'.esc_attr($link_text).'" class="client_link">'. str_replace( "http://","",esc_attr($link_text) ). '</a>' : "" ; ?>
			<?php echo ! empty( $link ) && empty( $link_text ) ? '<a href="'. esc_url($link) . '" target="_blank" class="client_link">'. str_replace( "http://","",esc_url($link) ). '</a>' : "" ; ?>	
			<?php echo empty( $link ) && ! empty( $link_text ) ? '<span>'. esc_html($link_text). '</span>' : "" ; ?>	
		</div>
	</div>
<?php else:?>
	<div class="client-info">
			<h6><?php echo esc_html($name); ?></h6>
			<?php echo ! empty( $title ) ? '<span>'. esc_html($title). '</span>' : "" ; ?>		
			<?php echo ! empty( $link ) && ! empty( $link_text ) ? '<a href="'. esc_url($link) . '" target="_blank" title="'.esc_attr($link_text).'" class="client_link">'. str_replace( "http://","",esc_attr($link_text) ). '</a>' : "" ; ?>
			<?php echo ! empty( $link ) && empty( $link_text ) ? '<a href="'. esc_url($link) . '" target="_blank" class="client_link">'. str_replace( "http://","",esc_url($link) ). '</a>' : "" ; ?>	
			<?php echo empty( $link ) && ! empty( $link_text ) ? '<span>'. esc_html($link_text). '</span>' : "" ; ?>	
	</div>
<?php endif;?>