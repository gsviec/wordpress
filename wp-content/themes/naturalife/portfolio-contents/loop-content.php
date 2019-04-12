<?php
/**
 * The template for displaying portfolio content within loops.
 *
 * @author 		RT-Themes
 * 
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

extract(rtframework_get_global_value("rtframework_portfolio_post_values"));
extract(rtframework_get_global_value("rtframework_portfolio_list_atts"));
?> 

<!-- portfolio box-->
<div <?php post_class("loop ".$item_style." ".$hover_style." ".$box_style." ". $portfolio_format)?> id="portfolio-<?php the_ID(); ?>">

	<div class="portfolio-loop-item-wrapper">
		<?php 
			//title output
			$title_output = $permalink ? sprintf('<%1$s class="title"><a href="%2$s" target="%3$s" rel="bookmark">%4$s</a></%1$s>',$heading_size,esc_url($permalink),esc_attr($target),$title) : sprintf('<%1$s class="title">%2$s</%1$s>',$heading_size,$title) ;

			//item link
			$link = $permalink ? sprintf('<a class="portfolio-link" href="%s" target="%s"></a>',esc_url($permalink),esc_attr($target)) : "";

			//read more
			$read_more = $permalink ? sprintf('<a class="read_more" href="%s" target="%s">%s</a>',esc_url($permalink),esc_attr($target), apply_filters( "rtframework_portfolio_more_text", esc_html__( 'read more', 'naturalife' ) ) ) : "";

			//shor desc output 
			$desc_output = ! empty( $short_desc ) && rtframework_convert_bool($display_excerpts) == "true" ? sprintf( '<p>%s</p>', $short_desc ) : "" ;

			//getterms list
			$term_list = rtframework_convert_bool($display_categories) == "true" ? get_the_term_list( $post->ID, 'portfolio_categories', '<span class="terms">', ', ', '</span>' ) : "";

			//thumbnail with link
			$thumbnail_with_link = $permalink ? sprintf('<a href="%2$s" target="%3$s" title="%4$s">%1$s</a>', $thumbnail_image_output, esc_url($permalink), esc_attr($target), esc_attr($title) ) : $thumbnail_image_output;			

			//output
			if( $item_style == "style-1" ){

				printf(' 
					<figure class="image-thumbnail">
						%1$s
					</figure>

					<section class="text">
						%2$s
						%3$s
						%4$s
					</section>  
				', $thumbnail_with_link, $title_output, $term_list, $desc_output );

			}else{
				
				if( $hover_style == "hover-1" ){

					printf('

						<figure class="image-thumbnail">
							%1$s
						</figure>

						<div class="visible-title-wrapper">
							<%7$s class="title visible-title">%2$s</%7$s>
						</div>

						<div class="overlay">

							<section class="text">
								%3$s
								%4$s
								%5$s			
							</section> 	

							%6$s

						</div>

					', $thumbnail_with_link, esc_attr($title), $title_output, $term_list, $desc_output, $link, $heading_size );

				}else{

					printf('

						<figure class="image-thumbnail">
							%1$s			
						</figure>
					
						<div class="overlay">

							<section class="text">
								%2$s
								%3$s
								%4$s			
							</section> 	
							
							%5$s
						</div>

					', $thumbnail_image_output,  $title_output, $term_list, $desc_output, $link );

				}

			}
		?>
	</div>
</div> 
<!-- / portfolio box-->
