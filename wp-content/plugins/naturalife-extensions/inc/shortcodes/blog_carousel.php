<?php
if( ! function_exists("rt_blog_carousel") ){
	/**
	 * Blog Carousel	
	 * returns html ouput of posts for carousel
	 * 
	 * @param  array   $atts   
	 * @return output 
	 */
	
	function rt_blog_carousel( $atts = array() ) { 
		global $rtframework_post_values, $rtframework_blog_list_atts;   

		//sanitize fields
		$atts["id"] = isset( $atts["id"] ) ? sanitize_html_class( $atts["id"] ) : 'blog-carousel-dynamicID-'.rand(100000, 1000000);

		//defaults
		$rtframework_blog_list_atts = shortcode_atts( array(  
			"id"                        => 'blog-carousel-dynamicID-'.rand(100000, 1000000), 
			"list_layout"               => "1/3",
			"tablet_layout"             => "",
			"mobile_layout"             => 1,				
			"heading_size"              => "h5",
			"nav"                       => "true",
			"dots"                      => "false",
			"featured_image_resize"     => "true",
			"featured_image_max_width"  => 0,
			"featured_image_max_height" => 0,
			"featured_image_crop"       => "false",
			"list_orderby"              => "date",
			"list_order"                => "DESC",
			"max_item"                  => 10,
			"categories"                => "",
			"ids"                       => "", 
			"show_author"               => "true",
			"show_categories"           => "true",
			"show_comment_numbers"      => "true",
			"show_date"                 => "true",
			"show_share"                => "false",
			"use_excerpts"              => "true",
			"excerpt_length"            => 100,
			"autoplay"                  => "false",
			"timeout"                   => 5000,
			"padding"                   => "",
			"loop"                      => "false",
			"margin"                    => "15",		 
			"item_style"                => "style-1",
			"box_style"                 => "",
			"show_featured_media"      => "true"
		), $atts);

		extract($rtframework_blog_list_atts); 

		//counter
		$counter = 1;

		//create a post status array
		$post_status = is_user_logged_in() ? array( 'private', 'publish' ) : "publish";

		//general query
		$args = array( 
			'post_status'    =>	$post_status,
			'post_type'      =>	'post',
			'orderby'        =>	$list_orderby,
			'order'          =>	$list_order,
			'showposts' 	 =>	$max_item,					
		);

		if( ! empty ( $ids ) ){				
			$ids = ! empty( $ids ) ? explode(",", trim( $ids ) ) : array();							
			$args = array_merge( $args, array( 'post__in' => $ids ) );
		}

		if( ! empty ( $categories ) ){

			$categories = is_array( $categories ) ? $categories : explode(",", rtframework_wpml_lang_object_ids( $categories, "category" ) ); 	

			$args = array_merge($args, array( 

				'tax_query' => array(
						array(
							'taxonomy' =>	'category',
							'field'    =>	'id',
							'terms'    =>	$categories,
							'operator' => 	"IN"
						)
					),
			) );
		} 

		$wp_query  = new WP_Query($args); 
		wp_reset_postdata();
		//column count
		$item_width = rtframework_column_count( $list_layout );


		if ( $wp_query->have_posts() ){ 
			
			$output = array();

			//the loop
			while ( $wp_query->have_posts() ) : $wp_query->the_post();

				//get post values
				$rtframework_post_values = rtframework_get_loop_post_values( $wp_query->post, $rtframework_blog_list_atts, "carousel" );

				$post_classes = get_post_class("item blog-loop blog-carousel-loop", get_the_ID() ) ;

				ob_start();


					echo '<article id="'.get_the_ID().'" class="'.implode(" ", $post_classes ).'"><div class="post-content-wrapper">'."\n" ;					

						do_action( "rtframework_before_blog_carousel_loop");

						get_template_part( '/post-contents/carousel','content'); 

						do_action( "rtframework_after_blog_carousel_loop");

					echo '</div></article>'."\n" ;



				$output[] .=  ob_get_contents();
				ob_end_clean();
						 
			$counter++;
			endwhile;  
 
 			//reset post data for the new query
			wp_reset_postdata(); 	

			//carousel atts
			$atts = array(  
				"id"                => sanitize_html_class($id), 
				"item_width"        => $item_width, 
				"mobile_item_width" => $mobile_layout, 
				"tablet_item_width" => $tablet_layout, 						
				"class"             => "blog-carousel ".$item_style,
				"nav"               => $nav,
				"dots"              => $dots,
				"margin"            => 29,
				"autoplay"          => $autoplay,
				"timeout"           => $timeout,
				"boxed"             => ! empty( $box_style ) ? "true" : "",
				"margin"            => intval($margin),
				"padding"           => intval($padding),
				"loop"              => $loop,				
			);

			//create carousel 
			$output = rtframework_create_carousel( $output, $atts );
			$output = apply_filters( "rtframework_shortcode_output", $output );
			return $output;

		}
	}
}
add_shortcode('blog_carousel', 'rt_blog_carousel'); 
?>