<?php
if( ! function_exists("rt_latest_news") ){
	/**
	 * Latest News Shortcode
	 * @param  array $atts 
	 * @param  string $content
	 * @return html $output
	 */
	function rt_latest_news( $atts = array(), $content = null ) { 

		global $rtframework_post_values, $rtframework_blog_list_atts;   

		//defaults
		$atts = shortcode_atts( array(  
			"id"              => "", 
			"image_width"     => 250,
			"image_height"    => 250,
			"style"           => "style-1",
			"list_orderby"    => "date",
			"list_order"      => "DESC",
			"list_layout"     => "1/4",
			"list_layout_tablet" => "1/4",
			"heading_size"    => "h4",
			"max_item"        => 10,
			"categories"      => "", 
			"excerpt_length"  => 100,
			"show_dates"      => false,
			"thumbnails"      => false,
			"show_categories" => false,
			"show_button"     => false
		), $atts);

		extract($atts); 

		//id attr
		$id_attr = ! empty( $id ) ? 'id="'.$id.'"' : "";

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

		$post_count = $wp_query->post_count;


		$output = "";

 		//column class
 		$add_column_class = rtframework_column_class( $list_layout, "lg" );
 		$add_column_class .= " ".rtframework_column_class( $list_layout_tablet, "md" );


		//row count
		$column_count = rtframework_column_count( $list_layout );

		//counter
		$counter = 1;			

		//get posts
		if ( $wp_query->have_posts() ){ 			 

			//the loop
			while ( $wp_query->have_posts() ) : $wp_query->the_post();
 

				$post_title        = get_the_title();
				$link              = get_permalink();
				$date              = apply_filters( "rtframework_latest_news_date_format", get_the_date());
				$comment_count     = get_comment_count( $wp_query->post->ID );				
				$get_the_excerpt   = ($excerpt_length > 0) ? '<p>'.wp_html_excerpt(get_the_excerpt(),$excerpt_length).'...</p>' : "" ;		

				// Create thumbnail image
				$thumbnail_image_output = "";


				if( rtframework_convert_bool( $thumbnails ) != "false" ){
					$featured_image_id = get_post_thumbnail_id(); 
					$thumbnail_image_output = ! empty( $featured_image_id ) ? rtframework_get_resized_image_output( array( "retina" => true, "image_url" => "", "image_id" => $featured_image_id, "w" => $image_width, "h" => $image_height, "crop" => "true", "class"=>"posts-image" ) ) : ""; 
				}

					/**
					 * Output
					 */
  
						$post_classes = get_post_class("", get_the_ID() ) ;
						array_push( $post_classes, "col col-12 ", $add_column_class );

						$output .= '<article id="'.get_the_ID().'" class="'.implode(" ", $post_classes ).'">'."\n" ;		

						$output .= ! empty( $thumbnail_image_output ) ?  sprintf( ' <figure>%1$s</figure> '."\n", $thumbnail_image_output ) : "";

						$date =  rtframework_convert_bool( $show_dates ) != "false" ? '<span class="date">'.$date.'</span>' : "";					

						$get_the_category = get_the_category_list(", ");
						$categories = rtframework_convert_bool( $show_categories ) != "false" && $get_the_category ? '<span class="categories">'.$get_the_category.'</span>' : "";
				
						$meta_bar_visible = ! empty( $date ) || ! empty( $categories );

						$meta_bar = $meta_bar_visible ? sprintf('<div class="meta-bar">%s%s%s</div>',$categories, ! empty( $categories ) && ! empty( $date ) ? ", " : "" , $date) : "";

						$button = rtframework_convert_bool( $show_button ) != "false" ? sprintf('<a href="%s" title="%s"><span class="latest-news-button ui-icon-right-arrow-1"></span></a>',$link,esc_html__( 'Continue reading', 'naturalife' )) : "";

						$output .= sprintf( '
						<div class="text">
							%3$s
							<%5$s class="heading"><a class="title" href="%1$s" title="%2$s" rel="bookmark">%2$s</a></%5$s>						
							%4$s
							%6$s
						</div>
						'."\n",$link, $post_title, $meta_bar, $get_the_excerpt, $heading_size, $button);

						$output .= '</article>'."\n";

			$counter++;					
			endwhile;   
 
 			//reset post data for the new query
			wp_reset_postdata(); 	 

		}


		//create holder html
		$output = ! empty( $output) ? '<div class="latest_news '.$style.' row">'.$output.'</div>' : "";

		return $output;
	}
}

add_shortcode('rt_latest_news', 'rt_latest_news'); 
