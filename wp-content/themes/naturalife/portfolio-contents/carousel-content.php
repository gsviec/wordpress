<?php
/**
 * The template for displaying portfolio content within carousel loops.
 *
 * @author 		RT-Themes
 * 
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

extract(rtframework_get_global_value("rtframework_portfolio_post_values"));
extract(rtframework_get_global_value("rtframework_portfolio_list_atts"));
?> 

<!-- portfolio box-->
<div <?php post_class("loop ".$item_style." ".$hover_style." ". $portfolio_format)?> id="portfolio-<?php the_ID(); ?>">

	<?php 

		//title output
		$title_output = $permalink ? sprintf('<h5 class="title"><a href="%s" target="%s" rel="bookmark">%s</a></h5>',esc_url($permalink),esc_attr($target),esc_html($title)) : sprintf('<h5 class="title">%s</h5>',esc_html($title)) ;

		//shor desc output
		$desc_output = ! empty( $short_desc ) && $display_excerpts == "true" ? sprintf( '<p>%s</p>', $short_desc ) : "" ;

		//read more
		$read_more = $permalink ? sprintf('<a class="read_more" href="%s" target="%s" rel="bookmark">%s</a>',esc_url($permalink),esc_attr($target), esc_html__( 'read more', 'naturalife' ) ) : "";

		//getterms list
		$term_list = $display_categories == "true" ? get_the_term_list( $post->ID, 'portfolio_categories', '<span class="terms">', ', ', '</span>' ) : "";


		//output
		if( $item_style == "style-1" ){

			printf(' 
				<figure class="image-thumbnail">
					<a href="%2$s" target="%3$s" title="%4$s">%1$s</a>
				</figure>

				<section class="text">
					%5$s
					%6$s
					%7$s	
					%8$s	
				</section>  
			', $thumbnail_image_output, esc_url($permalink), esc_attr($target), esc_html($title), $title_output, $term_list, $desc_output, $read_more );

		}else{
			
			printf('

				<figure class="image-thumbnail">
					%1$s				
				</figure>

				<div class="overlay">
					<a href="%2$s" target="%3$s" title="%4$s"></a>

					<section class="text">
						%5$s
						%6$s
						%7$s				
					</section> 	

				</div>

			', $thumbnail_image_output, esc_url($permalink), esc_attr($target), esc_html($title), $title_output, $term_list, $desc_output );
		}

	?>

</div> 
<!-- / portfolio box-->
