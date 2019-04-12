<?php
/**
 *
 * Various Helper Functions
 *
 * @author RT-Themes
 */
if( ! function_exists("rt_portfolio_post_loop") ){
	/**
	 * Portfolio Loop
	 * @param  array  $wp_query
	 * @param  array  $atts
	 * @return output
	 */
	function rt_portfolio_post_loop( $wp_query = array(), $atts = array() ) {
		global $rtframework_portfolio_post_values, $rtframework_portfolio_list_atts;

		//sanitize fields
		$atts["id"] = isset( $atts["id"] ) ? sanitize_html_class( $atts["id"] ) : 'portfolio-dynamicID-'.rand(100000, 1000000);

		//defaults
		$rtframework_portfolio_list_atts = shortcode_atts(array(
			"id"  => 'portfolio-dynamicID-'.rand(100000, 1000000),
			"class"  => '',
			"list_layout" => get_theme_mod('naturalife_portfolio_layout'),
			"metro_layout" => "1",
			"layout_style" => get_theme_mod('naturalife_portfolio_layout_style'),
			"item_style" => get_theme_mod('naturalife_portfolio_item_style'),
			"hover_style" => "hover-1",
			"filterable" => "false",
			"pagination" => "true",
			"ajax_pagination" => "false",
			"featured_image_resize" => get_theme_mod("naturalife_portfolio_image_resize"),
			"featured_image_max_width" => get_theme_mod("naturalife_portfolio_image_width"),
			"featured_image_max_height" => get_theme_mod("naturalife_portfolio_image_height"),
			"featured_image_crop" => get_theme_mod("naturalife_portfolio_image_crop"),
			"metro_resize" => "true",
			"list_orderby" => "date",
			"list_order" => "DESC",
			"item_per_page"=> 10,
			"categories" => "",
			"ajax" => "false",
			"ids" => "",
			"paged" => 0,
			"wpml_lang" => "",
			"nogaps" => "false",
			"box_style" => get_theme_mod("naturalife_portfolio_box_style"),
			"display_categories" => get_theme_mod("naturalife_portfolio_display_categories"),
			"display_excerpts" => get_theme_mod("naturalife_portfolio_display_excerpts"),
			"heading_size" => "h5"
		), $atts);

		extract($rtframework_portfolio_list_atts);

		$wp_reset_postdata = false;

		//counter
		$counter = 1;

		//box style
		$rtframework_portfolio_list_atts["box_style"] = $box_style;

		//custom query
		if( ! $wp_query ){

			//paged
			if( $pagination && $paged == 0 ){
				if (get_query_var('paged') ) {$paged = get_query_var('paged');} elseif ( get_query_var('page') ) {$paged = get_query_var('page');} else {$paged = 1;}
			}


			//create a post status array
			$post_status = is_user_logged_in() ? array( 'private', 'publish' ) : "publish";

			//general query
			$args = array(
						'post_status'    => $post_status,
						'post_type'      => 'portfolio',
						'orderby'        => esc_attr($list_orderby),
						'order'          => esc_attr($list_order),
						'posts_per_page' => absint($item_per_page),
						'paged'          => absint($paged)
					);

			if( ! empty ( $ids ) ){
				$ids = ! empty( $ids ) ? explode(",", trim( $ids ) ) : array();
				$args = array_merge($args, array( 'post__in'  => $ids) );
			}

			if( ! empty ( $categories ) ){

				$categories = is_array( $categories ) ? $categories : explode(",", rtframework_wpml_lang_object_ids( $categories, "portfolio_categories",$wpml_lang ) );

				$args = array_merge($args, array(

					'tax_query' => array(
							array(
								'taxonomy' =>	'portfolio_categories',
								'field'    =>	'id',
								'terms'    =>	$categories,
								'operator' => 	"IN"
							)
						),
				) );
			}

			$wp_query  = new WP_Query($args);

			//filter navigation
			if( $filterable !== "false" && $layout_style != "grid" ){
				//categories - turn into an array
				$sortCategories = $categories;
				$sortNavigation = "";

				if( ! empty( $sortCategories ) ){
					if(is_array($sortCategories)){
						foreach ($sortCategories as $arrayorder => $termID) {
							$sortCategories = get_term_by('id', $termID, 'portfolio_categories');
							$sortNavigation .= '<li><a href="#" data-filter=".portfolio-'. $sortCategories->term_id.'">'. esc_html($sortCategories->name).'</a></li>'."\n";
						}
					}

				}else{
					$sortCategories  = get_terms( 'portfolio_categories', 'orderby=name&hide_empty=1&order=ASC' );
					$sortCategories  = is_array($sortCategories) ? $sortCategories : "";

					foreach ($sortCategories as $key => $term) {
						$sortNavigation  .= '<li><a data-filter=".portfolio-'. $term->term_id.'" title="'.esc_attr($term->name).'">'. esc_html($term->name).'</a></li>'."\n";
					}
				}

				$filter_holder = ! empty( $sortNavigation ) ?
				sprintf('
						<div class="filter-holder" data-list-id="%1$s">
							<ul class="filter_navigation">
								<li>
									<span>%2$s</span>
										<ul>
											<li><a href="#" data-filter="*" class="active" title="%3$s">%3$s</a></li>
											%4$s
										</ul>
								</li>
							</ul>
						</div>',
						$id,
						apply_filters("filter_nav_filter_text",__("FILTER","naturalife")),
						apply_filters("filter_nav_all_text",__("ALL","naturalife")),
						$sortNavigation
					) : "";

				echo $filter_holder;
			}

			$wp_reset_postdata = true;
		}

		//get page & post counts
		$post_count = $wp_query->post_count;
		$page_count = $wp_query->max_num_pages;

		//item width percentage
		$list_layout = ! empty( $list_layout ) ? $list_layout : "1/3";

		//layout style
		switch ( $layout_style ) {
			case 'masonry':

				$add_holder_class = " masonry-gallery";				

				break;

			case 'metro':

				$add_holder_class = " metro-gallery";
				$item_style = $rtframework_portfolio_list_atts["item_style"] = "style-2";

				break;

			default:

				$add_holder_class = " grid-gallery";

				break;
		}

		//custom class name
		$add_holder_class .= ! empty($class) ? " ".$class : "";

		//gaps
		$add_holder_class .= rtframework_convert_bool($nogaps) == "true" ? " nogaps" : "";

		//filter menu
		$add_holder_class .= $filterable !== "false" ? " filterable" : "";

 		//column class
 		$add_column_class = "";
		$grid_global_class = rtframework_column_class( $list_layout, "sm" ); 

		//double column width values
		$double_width = array("1"=> "1/1", "2"=> "1/1","3"=> "8/12","4"=> "1/2","6"=> "4/12");

 		//dynamic positions
 		$add_column_class .= $layout_style != "grid" ? " rt-dynamic" : "";

		//row count
		$column_count = rtframework_column_count( $list_layout );

		/// Metro Dimensions
		if( $layout_style == "metro" ){
			$dimensions_array = $nogaps == "false" ? rtframework_get_metro_dimensions(false, $metro_layout ) : rtframework_get_metro_dimensions(true, $metro_layout );
		}

		if ( $wp_query->have_posts() ){

			//open the wrapper
			if(  $layout_style == "grid" ){
				echo "\n".'<div id="'.$id.'" class="portfolio_list rt-gallery fixed_heights'.$add_holder_class.'" data-column-width="'. $column_count .'">'."\n";
			}else{
				echo "\n".'<div id="'.$id.'" class="row portfolio_list rt-gallery'.$add_holder_class.'" data-column-width="'. $column_count .'">'."\n";
			}


			//the loop
			while ( $wp_query->have_posts() ) : $wp_query->the_post();

				$grid_class = $grid_global_class;

				//metro image sizes
				if( $layout_style == "metro" ){

					if( $layout_style == "metro" && $metro_resize == "true" ){
						$rtframework_portfolio_list_atts["featured_image_max_width"] = $dimensions_array[ fmod($counter-1, count( $dimensions_array ) ) ][1];
						$rtframework_portfolio_list_atts["featured_image_max_height"] = $dimensions_array[ fmod($counter-1, count( $dimensions_array ) ) ][2];
						$rtframework_portfolio_list_atts["featured_image_crop"] = "true";
					}

					$grid_class = $dimensions_array[ fmod($counter-1, count( $dimensions_array ) ) ][0];

				}

				//masonry double width
				$masonry_view = get_post_meta( $wp_query->post->ID, RT_COMMON_THEMESLUG .'_masonry_view', true);
				if( $masonry_view == "double" && $layout_style == "masonry" ){
					$grid_class = rtframework_column_class($double_width[$column_count],"sm");
				}

				//get post values
				$rtframework_portfolio_post_values = rt_get_portfolio_loop_post_values( $wp_query->post, $rtframework_portfolio_list_atts );


				//selected term list of each post
				$term_list = get_the_terms($wp_query->post->ID, 'portfolio_categories');

				//add terms as class name
				$addTermsClass = "";
				if($term_list){
					if(is_array($term_list)){
						foreach ($term_list as $termSlug) {
							$addTermsClass .= " portfolio-". $termSlug->term_id;
						}
					}
				}

				//open row block
				if(  $layout_style == "grid" && ( $counter % $column_count == 1 || $column_count == 1 ) ){
					echo '<div class="row fixed_heights">'."\n";
				}

					echo '<div class="col col-12 '.trim($grid_class.' '.$add_column_class.' '.$addTermsClass).'">'."\n" ;

						get_template_part( 'portfolio-contents/loop','content');

					echo '</div>'."\n" ;


				//close row block
				if( $layout_style == "grid" && ( $counter % $column_count == 0 || $post_count == $counter ) ){
					echo '</div>'."\n";
				}

			$counter++;
			endwhile;

			//close wrapper
			echo '</div>'."\n";

			//ajax load more button
			$ajax_pagination = rtframework_convert_bool( $ajax_pagination );

			if( ( $pagination !== "false" && $ajax_pagination === "false" ) || ( $pagination !== "false" && $layout_style == "grid" ) ){
				rtframework_get_pagination( $wp_query );
			}

			if( $ajax_pagination !== "false" && ( $layout_style == "metro" || $layout_style == "masonry") && $page_count > 1 && $ajax === "false" ){

				$rtframework_portfolio_list_atts["purpose"] = "portfolio";
				rtframework_get_ajax_loader_button( $rtframework_portfolio_list_atts, $page_count );

			}

		}

		//reset post data for the new query
		if( $wp_reset_postdata ){
			wp_reset_postdata();
		}
	}
}
add_action('portfolio_post_loop', 'rt_portfolio_post_loop', 10, 2);

if( ! function_exists("rt_get_portfolio_loop_post_values") ){
	/**
	 * Get post values for loops
	 * gets all data of a portfolio item including metas
	 *
	 * @param  array $post
	 * @param  array $atts [atts of rt_portfolio_post_loop function]
	 * @return array
	 */
	function rt_get_portfolio_loop_post_values( $post = array(), $atts = array(), $purpose = "" ){

		extract( $atts );

		//masonry view
		$masonry_view = get_post_meta( $post->ID, RT_COMMON_THEMESLUG .'_masonry_view', true);

		//featured image
		$featured_image_id  = get_post_thumbnail_id();
		$featured_image_url = ! empty( $featured_image_id ) ? wp_get_attachment_image_src( $featured_image_id, "full" ) : "";
		$featured_image_url = is_array( $featured_image_url ) ? $featured_image_url[0] : "";
		$layout_style       = isset( $layout_style ) ? $layout_style : "";


		if( ($purpose == "carousel" && $featured_image_resize !== "false") ||  ($layout_style != "metro" && $featured_image_resize !== "false") || ($layout_style == "metro" && $metro_resize !== "false") ){

			// thumbnail min width
			$w = ! empty( $featured_image_max_width ) ? $featured_image_max_width : rtframework_get_min_resize_size( $list_layout );

			// thumbnail max height
			$h = ! empty( $featured_image_max_height ) ? $featured_image_max_height : 10000;

			//masonry double width
			if( $masonry_view == "double" && $layout_style == "masonry" ){
				$w = $w*2;
				$h = $h*2;
			}

			//thumbnail output
			$thumbnail_image_output = ! empty( $featured_image_id ) ? rtframework_get_resized_image_output( array( "image_url" => "", "image_id" => $featured_image_id, "w" => $w, "h" => $h, "crop" => $featured_image_crop, "srcset" => "" ) ) : "";

		}else{
			//thumbnail output
			$thumbnail_image_output = ! empty( $featured_image_id ) ? rtframework_get_image_output( array( "image_url" => "", "image_id" => $featured_image_id ) ) : "";
		}


		// Tiny image thumbnail for lightbox gallery feature
 		$lightbox_thumbnail = "" ;

		//get post format
		$portfolio_format = get_post_meta( $post->ID, RT_COMMON_THEMESLUG.'_portfolio_post_format', true);

		//external link
		$external_link = get_post_meta( $post->ID, RT_COMMON_THEMESLUG .'_external_link', true);

		//open in
		$target = get_post_meta( $post->ID, RT_COMMON_THEMESLUG.'_open_in_new_tab', true);

		//remove the link to single page
		$remove_link = get_post_meta( $post->ID, RT_COMMON_THEMESLUG .'_portf_no_detail', true);

		//permalink
		$permalink = ! empty( $remove_link ) ? "" : get_permalink();
		$permalink = ! empty( $external_link ) ? $external_link : $permalink;

		//create global values array
		$rt_portfolio_post_values = array(
				"title"                  => get_the_title(),
				"permalink"              => $permalink,
				"featured_image_id"      => $featured_image_id ,
				"featured_image_url"     => $featured_image_url,
				"portfolio_format"       => get_post_meta( $post->ID, RT_COMMON_THEMESLUG.'_portfolio_post_format', true),
				"remove_link"            => $remove_link,
				"disable_lightbox"       => get_post_meta( $post->ID, RT_COMMON_THEMESLUG .'_disable_lightbox', true),
				"external_link"          => $external_link,
				"target"                 => ! empty( $target ) ? '_blank' : "_self",
				"video_mp4"              => get_post_meta( $post->ID, RT_COMMON_THEMESLUG .'_portfolio_video_m4v', true),
				"video_webm"             => get_post_meta( $post->ID, RT_COMMON_THEMESLUG .'_portfolio_video_webm', true),
				"external_video"         => get_post_meta( $post->ID, RT_COMMON_THEMESLUG .'_portfolio_video', true),
				"audio_mp3"              => get_post_meta( $post->ID, RT_COMMON_THEMESLUG .'_portfolio_audio_mp3', true),
				"audio_ogg"              => get_post_meta( $post->ID, RT_COMMON_THEMESLUG .'_portfolio_audio_oga', true),
				"thumbnail_image_output" => $thumbnail_image_output,
				"lightbox_thumbnail"     => $lightbox_thumbnail,
				"short_desc"             => get_the_excerpt(),
				"masonry_view"           => $masonry_view 
		);


		return $rt_portfolio_post_values;
	}
}

if( ! function_exists("rt_get_portfolio_single_post_values") ){
	/**
	 * Get post values for single portfolio pages
	 * gets data of a portfolio item including metas
	 *
	 * @param  array $post
	 * @param  array $atts
	 * @return array
	 */
	function rt_get_portfolio_single_post_values( $post = array(), $atts = array()){

		//get post format
		$portfolio_format = get_post_meta( $post->ID, RT_COMMON_THEMESLUG.'_portfolio_post_format', true);
		$portfolio_format = empty( $portfolio_format ) ? "image" : $portfolio_format;

		//permalink
		$permalink = ! empty( $remove_link ) ? "" : get_permalink();
		$permalink = ! empty( $external_link ) ? $external_link : $permalink;

		//portfolio_options
		$portfolio_options = get_post_meta( $post->ID, RT_COMMON_THEMESLUG .'_portfolio_options', true );
		$portfolio_options = is_array( $portfolio_options ) ? $portfolio_options : array();


		//default portfolio options
	 	$portfolio_options = shortcode_atts( array(
			"gallery_usage"              => "masonry",
			"grid_layout"                => "1/3",
			"masonry_layout"             => "1/3",
			"metro_layout"               => "1",
			"resize"                     => "",
			"portfolio_image_width"      => "960",
			"portfolio_image_height"     => "960",
			"external_link"              => "",
			"image_crop"                 => "false",
			"metro_resize"               => "false",
			"lightbox"                   => "false",
			"captions"                   => "false",
			"exclude_featured_image"     => "false",
			"nogaps"                     => "false"
		), $portfolio_options );


		//gallery images
		$rt_gallery_images = get_post_meta( $post->ID, RT_COMMON_THEMESLUG . "rt_gallery_images", true );
		$rt_gallery_images = ! empty( $rt_gallery_images ) ? ! is_array( $rt_gallery_images ) ? explode(",", $rt_gallery_images) : $rt_gallery_images : array(); //turn into an array
		$rt_gallery_images = rtframework_convert_bool($portfolio_options["exclude_featured_image"]) == "true" ? $rt_gallery_images : rtframework_merge_featured_images_by_id( $rt_gallery_images ); //add the wp featured image to the array

		//poster image
		$poster_img_url = "";

		if( $portfolio_format == "video" ){
			$poster_img_id  = is_array( $rt_gallery_images ) && isset( $rt_gallery_images[0] ) ? $rt_gallery_images[0] : "";
			$poster_img_url = ! empty( $poster_img_id ) ? wp_get_attachment_image_src( $poster_img_id, "full" ) : "";
			$poster_img_url = is_array( $poster_img_url ) ? $poster_img_url[0] : "";
		}

		//create global values array
		$rt_portfolio_post_values = array(
			"title"             => get_the_title(),
			"permalink"         => $permalink,
			"portfolio_format"  => $portfolio_format,
			"video_mp4"         => get_post_meta( $post->ID, RT_COMMON_THEMESLUG .'_portfolio_video_m4v', true),
			"video_webm"        => get_post_meta( $post->ID, RT_COMMON_THEMESLUG .'_portfolio_video_webm', true),
			"external_video"    => get_post_meta( $post->ID, RT_COMMON_THEMESLUG .'_portfolio_video', true),
			"page_layout"       => get_post_meta( $post->ID, RT_COMMON_THEMESLUG .'_page_layout', true),
			"key_details"       => get_post_meta( $post->ID, RT_COMMON_THEMESLUG .'_key_details', true),
			"gallery_images"    => $rt_gallery_images,
			"portfolio_options" => $portfolio_options,
			"poster_img_url"    => $poster_img_url
		);

		//defaults
		$rt_portfolio_post_values = shortcode_atts(apply_filters("single_portfolio_values",$rt_portfolio_post_values), $atts);

		return $rt_portfolio_post_values;
	}
}

if( ! function_exists("rtframework_portfolio_buttons") ){
	/**
	 * Action buttons
	 * generates a pair of buttons
	 * first one is for lightbox link - requires entire html code
	 * second one is regular link - requires link and title
	 *
	 * @param  array  $atts
	 * @return string $buttons
	 */
	function rtframework_portfolio_buttons( $atts = array() ) {

		$atts = shortcode_atts(array(
			"lightbox_link" => "",
			"link" => "",
			"title" => "",
			"external_link" => "",
			"target" => "_self",
			"echo" => false
		),$atts);

		extract( $atts );


		if( empty( $external_link ) ){
			$lightbox_button = ! empty( $lightbox_link ) ? sprintf("<li>%s</li>",$lightbox_link) : "";
			$link_button = ! empty( $link ) ? sprintf('<li><a class="icon-new-link-1" href="%s" title="%s" target="%s"></a></li>',$link,$title,$target) : "";
		}else{
			$lightbox_button = "";
			$link_button = sprintf('<li><a class="icon-link-ext" href="%s" title="%s" target="%s"></a></li>',$external_link,$title,$target);
		}

		$buttons = empty( $lightbox_button ) && empty( $link_button ) ? "" : sprintf('<ul class="action_buttons">%s%s</ul>',$lightbox_button,$link_button);

		if( $echo ){
			echo $buttons;
		}else{
			return $buttons;
		}

	}
}
add_action('rtframework_portfolio_buttons','rtframework_portfolio_buttons',10,1);


if( ! function_exists("rt_tax_pagination_fix") ){
	/**
	 * Taxonomy Query & Pagination Fix
	 *
	 * Changes item per page
	 * Changes OrderBy and Order Parameter of the query
	 * Prevents 404 pages of paginations
	 *
	 * @param  object $query the wp_query
	 * @return object $query
	 */
	function rt_tax_pagination_fix($query) {

		if ( ! class_exists( 'RTFramework' ) ){
			return;
		}

		$rtframework_taxonomy = isset( $query->query_vars["taxonomy"] ) ? $query->query_vars["taxonomy"] : "";

		if ( $rtframework_taxonomy == "portfolio_categories" ){


			$post_per_page = get_theme_mod(RT_THEMESLUG.'_portf_pager') ;
			$post_per_page = is_numeric( $post_per_page ) ? $post_per_page : 10 ;

			$list_orderby = get_theme_mod(RT_THEMESLUG."_portf_list_orderby");
			$list_orderby = !empty( $list_orderby ) ? $list_orderby : "date" ;

			$list_order = get_theme_mod(RT_THEMESLUG."_portf_list_order");
			$list_order = !empty( $list_order ) ? $list_order : "DESC" ;


			$query->set('posts_per_page',  $post_per_page );
			$query->set('orderby', $list_orderby);
			$query->set('order', $list_order);
			$query->set('post_type', "portfolio");

			return $query;
		}

		else{
			return;
		}
	}
}
add_filter('pre_get_posts','rt_tax_pagination_fix');

if( ! function_exists("rt_get_pages") ){
	/**
	 * Get Pages as array
	 * @return array $rt_getpages
	 */
	function rt_get_pages(){

		// Pages
		$pages = query_posts('posts_per_page=-1&post_type=page&orderby=title&order=ASC');
		$rt_getpages = array();

		if(is_array($pages)){
			foreach ($pages as $page_list ) {
				$rt_getpages[$page_list->ID] = $page_list ->post_title;
			}
		}

		wp_reset_query();
		return $rt_getpages;
	}
}

if( ! function_exists("rt_get_categories") ){
	/**
	 * Get Blog Categories - only post categories
	 * @return array $rt_getcat
	 */
	function rt_get_categories(){

		if( ! taxonomy_exists("category") ){
			return array();
		}

		// Categories
		$args = array(
			'type'                     => 'post',
			'child_of'                 => 0,
			'orderby'                  => 'name',
			'order'                    => 'ASC',
			'hide_empty'               => 1,
			'hierarchical'             => 1,
			'taxonomy'                 => 'category',
			'pad_counts'               => false
			);


		$categories = get_categories($args);
		$rt_getcat = array();

		if(is_array($categories)){
			foreach ($categories as $category_list ) {
				$rt_getcat[$category_list->cat_ID] = $category_list->cat_name;
			}
		}

		return $rt_getcat;
	}
}


if( ! function_exists("rt_get_woo_product_categories_slugs") ){
	/**
	 * Get Woo Product Categories 
	 * @return array $rt_product_getcat;
	 */
	function rt_get_woo_product_categories_slugs(){

		if( ! taxonomy_exists("product_cat") ){
			return array();
		}

		// Product Categories		
		$product_args = array(
			'type'                     => 'post',
			'child_of'                 => 0, 
			'orderby'                  => 'name',
			'order'                    => 'ASC',
			'hide_empty'               => 1,
			'hierarchical'             => 1,  
			'taxonomy'                 => 'product_cat',
			'pad_counts'               => false
			);
		
		
		$product_categories = get_categories($product_args);
		$rt_product_getcat = array();
		
		if(is_array($product_categories)){
			foreach ($product_categories as $category_list ) {
				@$rt_product_getcat[$category_list->slug] = @$category_list->cat_name;
			}
		}
		
		return $rt_product_getcat;
		
	}
}


if( ! function_exists("rt_get_woo_product_categories") ){
	/**
	 * Get Woo Product Categories 
	 * @return array $rt_product_getcat;
	 */
	function rt_get_woo_product_categories(){

		if( ! taxonomy_exists("product_cat") ){
			return array();
		}

		// Product Categories		
		$product_args = array(
			'type'                     => 'post',
			'child_of'                 => 0, 
			'orderby'                  => 'name',
			'order'                    => 'ASC',
			'hide_empty'               => 1,
			'hierarchical'             => 1,  
			'taxonomy'                 => 'product_cat',
			'pad_counts'               => false
			);
		
		
		$product_categories = get_categories($product_args);
		$rt_product_getcat = array();
		
		if(is_array($product_categories)){
			foreach ($product_categories as $category_list ) {
				@$rt_product_getcat[$category_list->cat_ID] = @$category_list->cat_name;
			}
		}
		
		return $rt_product_getcat;
		
	}
}

if( ! function_exists("rt_get_portfolio_categories_with_slugs") ){
	/**
	 * Get Portfolio Categories
	 * @return [type] [descarray
	 */
	function rt_get_portfolio_categories_with_slugs(){

		if( ! taxonomy_exists("portfolio_categories") ){
			return array();
		}

		// Product Categories
		$product_args = array(
			'type'                     => 'post',
			'child_of'                 => 0,
			'orderby'                  => 'name',
			'order'                    => 'ASC',
			'hide_empty'               => 1,
			'hierarchical'             => 1,
			'taxonomy'                 => 'portfolio_categories',
			'pad_counts'               => false
			);


		$portfolio_categories = get_categories($product_args);
		$rt_portfolio_getcat = array();

		if(is_array($portfolio_categories)){
			foreach ($portfolio_categories as $category_list ) {
				$rt_portfolio_getcat[$category_list->slug] = $category_list->cat_name;
			}
		}

		return $rt_portfolio_getcat;
	}
}


if( ! function_exists("rt_get_portfolio_categories") ){
	/**
	 * Get Portfolio Categories
	 * @return [type] [descarray
	 */
	function rt_get_portfolio_categories(){

		if( ! taxonomy_exists("portfolio_categories") ){
			return array();
		}

		// Product Categories
		$product_args = array(
			'type'                     => 'post',
			'child_of'                 => 0,
			'orderby'                  => 'name',
			'order'                    => 'ASC',
			'hide_empty'               => 1,
			'hierarchical'             => 1,
			'taxonomy'                 => 'portfolio_categories',
			'pad_counts'               => false
			);


		$portfolio_categories = get_categories($product_args);
		$rt_portfolio_getcat = array();

		if(is_array($portfolio_categories)){
			foreach ($portfolio_categories as $category_list ) {
				$rt_portfolio_getcat[$category_list->cat_ID] = $category_list->cat_name;
			}
		}

		return $rt_portfolio_getcat;
	}
}

if( ! function_exists("rt_get_woocommerce_categories") ){
	/**
	 * Get WooCommerce Categories
	 * @return [type] [descarray]
	 */
	function rt_get_woocommerce_categories(){

		if( ! taxonomy_exists("product_cat") ){
			return array();
		}

		// Product Categories
		$product_args = array(
			'type'                     => 'post',
			'child_of'                 => 0,
			'orderby'                  => 'name',
			'order'                    => 'ASC',
			'hide_empty'               => 1,
			'hierarchical'             => 1,
			'taxonomy'                 => 'product_cat',
			'pad_counts'               => false
			);


		$pcategories = get_categories($product_args);
		$getcats = array();

		if(is_array($pcategories)){
			foreach ($pcategories as $category_list ) {
				$getcats[$category_list->cat_ID] = $category_list->cat_name;
			}
		}

		return $getcats;
	}
}


if( ! function_exists("rt_get_testimonial_categories") ){
	/**
	 * Get Testimonial Categories
	 * @return array $rt_testimonial_getcat
	 */
	function rt_get_testimonial_categories(){

		if( ! taxonomy_exists("testimonial_categories") ){
			return array();
		}

		// Categories
		$args = array(
			'type'                     => 'post',
			'child_of'                 => 0,
			'orderby'                  => 'name',
			'order'                    => 'ASC',
			'hide_empty'               => 1,
			'hierarchical'             => 1,
			'taxonomy'                 => 'testimonial_categories',
			'pad_counts'               => false
			);


		$testimonial_categories = get_categories($args);
		$rt_testimonial_getcat = array();

		if(is_array($testimonial_categories)){
			foreach ($testimonial_categories as $category_list ) {
				$rt_testimonial_getcat[$category_list->cat_ID] = $category_list->cat_name;
			}
		}

		return $rt_testimonial_getcat;
	}
}

if( ! function_exists("rt_get_portfolio_list") ){
	/**
	 * Get Portolio
	 * @return array $rt_get_portfolio
	 */
	function rt_get_portfolio_list(){


		$posts  = query_posts('posts_per_page=-1&post_type=portfolio&orderby=title&order=ASC');
		$portfolio_list = array();

		if(is_array($posts)){
			foreach ($posts as $post_list ) {	// add posts to the list
				$portfolio_list[$post_list->ID] = $post_list ->post_title;
			}
		}

		wp_reset_query();
		return $portfolio_list;
	}
}

if( ! function_exists("rt_get_testimonial_list") ){
	/**
	 * Get Testimonial List
	 * @return array $testimonial_array;
	 */
	function rt_get_testimonial_list(){

		$testimonial_query  = query_posts('posts_per_page=-1&post_type=testimonial&orderby=title&order=ASC');
		$testimonial_array = array();

		if(is_array($testimonial_array)){
			foreach ($testimonial_query as $testimonial ) {	// add posts to the list
				$testimonial_array[$testimonial->ID] = _x("Testimonial",'Admin Panel','naturalife') . ' - ' . $testimonial->ID;
			}
		}

		wp_reset_query();
		return $testimonial_array;
	}
}

if( ! function_exists("rt_get_staff_list") ){
	/**
	 * Get Staff List
	 * @return array $staff_array
	 */
	function rt_get_staff_list(){

		$staff_query  = query_posts('posts_per_page=-1&post_type=staff&orderby=title&order=ASC'); // Products
		$staff_array = array();

		if(is_array($staff_array)){
			foreach ($staff_query as $staff ) {	// add product posts to the list
				$staff_array[$staff->ID] = $staff->post_title;
			}
		}

		wp_reset_query();
		return $staff_array;
	}
}

if( ! function_exists("rt_find_image_org_path") ){
	/**
	 * Find image orginal path
	 * gets orginal paths of images when multi site mode active
	 * @param string $image
	 * @return string $image
	 */
	function rt_find_image_org_path($image) {
		if(is_multisite()){
			global $blog_id;
			if (isset($blog_id) && $blog_id > 0) {
				if(strpos($image, esc_url( home_url() ) )!==false){//image is local
					if(empty(get_current_site(1)->path)){
						$the_image_path = get_current_site(1)->path.str_replace(get_blog_option($blog_id,'fileupload_url'),get_blog_option($blog_id,'upload_path'),$image);
					}else{
						$the_image_path = $image;
					}
				}else{
					$the_image_path = $image;
				}
			}else{
				$the_image_path = $image;
			}
		}else{
			$the_image_path = $image;
		}

		return rtframework_clean_thumbnail_ext($the_image_path);
	}
}

if( ! function_exists("rt_get_nav_menus") ){
	/**
	 * Get nav menus
	 * gets navigation menus as an array pair slug=>name
	 * @return array
	 */
	 function rt_get_nav_menus(){

		$menus = get_terms( 'nav_menu', array( 'hide_empty' => false ) );

		$menus_array = array();

		if(is_array($menus)){
			foreach ($menus as $menu ) {
				$menus_array[$menu->slug] = $menu->name;
			}
		}

		return $menus_array;
	}
}

if( ! function_exists("rt_ajax_contact_form") ){
	/**
	 * Ajax contact form
	 * @return array
	 */

	function rt_ajax_contact_form()
	{

		load_theme_textdomain('naturalife', get_template_directory().'/languages' );

		$errorMessage = $hasError = "";
		$your_web_site_name= trim(get_bloginfo('name'));
		$your_email = sanitize_email(base64_decode($_POST['your_email']));

		//texts
		$text_1 = esc_html__('Thanks','naturalife');
		$text_2 = esc_html__('Your email was successfully sent. We will be in touch soon.','naturalife');
		$text_3 = esc_html__('There was an error submitting the form.','naturalife');
		$text_4 = esc_html__('Please enter a valid email address!','naturalife');
		$text_5 = esc_html__('Wrong answer for the security question! Please make sure that the sum of the two numbers is correct!','naturalife');

		//If the form is submitted
		if(isset($_POST['name'])) {


			$math         = isset($_POST['math']) ? esc_attr($_POST['math']) : "" ;
			$rt_form_data = isset($_POST['rt_form_data']) ? base64_decode(esc_attr($_POST['rt_form_data'])) : "" ;
			$name         = isset($_POST['name']) ? sanitize_text_field($_POST['name']) : "" ;
			$email        = isset($_POST['email']) ? sanitize_email($_POST['email']) : "" ;
			$message      = isset($_POST['message']) ? $_POST['message'] : "" ;

			//Check the sum of the numbers
			if( $rt_form_data != "nosecurity" && $math != $rt_form_data )  {
				$hasError = true;
				$errorMessage = $text_5;
			}

			//Check to make sure that the name field is not empty
			if( empty( $name ) ) {
				$hasError = true;
			}

			//Check to make sure sure that a valid email address is submitted
			if( empty( $email ) || ! $email ) {
				$hasError = true;
				$errorMessage = $text_4;
			}

			//Check to make sure comments were entered
			if( empty( $message ) ) {
				$hasError = true;
			}

			//If there is no error, send the email
			if(! $hasError ) {

				$subject = esc_html__('Contact Form Submission from' , 'naturalife').' '.$name;


				//message
				if(function_exists('stripslashes')) {
					$message = stripslashes($message);
				}

				$message = strip_tags( $message );
				$message = str_replace(array("content-type","bcc:","to:","cc:","href"),"", $message);

				//message body
				$body  = esc_html__('Name' , 'naturalife').": $name \n\n";
				$body .= esc_html__('Email' , 'naturalife').": $email \n\n";
				$body .= esc_html__('Message' , 'naturalife').": $message \n\n";

				$body .= "\n\n --------\n" ;

				$body .= esc_html__('URL' , 'naturalife'). ":". $_SERVER['HTTP_REFERER'];

				if(function_exists('stripslashes')) {
					$body = stripslashes($body);
				}

				$headers = array();
				$headers[] = 'From: '.$name.' <'.$email.'>';
				$headers[] = 'Reply-To: '.$email;


				wp_mail($your_email, $subject, $body, $headers);
				$emailSent = true;
			}

			//dynamic form class
			if(isset($_POST['dynamic_class'])) $dynamic_class = trim( sanitize_text_field( $_POST['dynamic_class'] ) );
		}

		if( isset($emailSent) && $emailSent == true) {

			printf('
					<div class="info_box margin-b20 %1$s">
						<span class="icon-cancel"></span>
						<p class="%2$s">

							<b>%3$s, %4$s</b><br />
							%5$s
							<script>
								jQuery(document).ready(function(){
									jQuery(".%6$s").find("input,textarea").attr("disabled", "disabled");
									jQuery(".%6$s").find(".button").remove();
								});
							</script>
						</p>
					</div>
				','ok','icon-thumbs-up-1',$text_1, $name, $text_2, $dynamic_class);
		}

		if( isset( $hasError ) && $hasError == true ) {


			printf('
				<div class="info_box margin-b20 %1$s">
					<span class="icon-cancel"></span>
					<p class="%2$s">
						<b>%3$s</b><br />
						%4$s
					</p>
				</div>
			','attention','icon-attention',$text_3, $errorMessage);

		}

		die();
	}
}

if( ! function_exists("rt_get_tax_meta") ){
	/**
	 * Get taxonomy term meta
	 * @return array
	 */
	 function rt_get_tax_meta( $term_id ){

		return  get_option( "taxonomy_$term_id" );//get tax meta
	}
}


if( ! function_exists("rtframework_get_sidebar_list") ){
	/**
	 * Get registered sidebars
	 * @return bool | array
	 */
	 function rtframework_get_sidebar_list(){

		global $wp_registered_sidebars;

		$sidebar_array = array();

		if( ! isset( $wp_registered_sidebars ) || empty( $wp_registered_sidebars ) ){
			return false;
		}

		foreach ($wp_registered_sidebars as $sidebar_id => $val) {
			$sidebar_array[ $val["id"] ] = $val["name"];
		}

		return $sidebar_array;
	}
}


if( ! function_exists("rtframework_remove_revslider_register_notices") ){
	/**
	 * Removes RevSlider plugin register notices
	 * @return output
	 */
	function rtframework_remove_revslider_notices(){
		define('REV_SLIDER_AS_THEME', true);
	}
}
add_action("plugins_loaded","rtframework_remove_revslider_register_notices",-1);


if( ! function_exists("rtframework_remove_revslider_update_notices") ){
	/**
	 * Removes RevSlider plugin update notices
	 * @return output
	 */
	function rtframework_remove_revslider_update_notices(){
		remove_action('admin_notices', array('RevSliderAdmin', 'add_plugins_page_notices'));
	}
}
add_action("init","rtframework_remove_revslider_update_notices",100);

if( ! function_exists("rtframework_coming_soon") ){
	/**
	 * Redirect to coming soon page
	 */
	function rtframework_coming_soon(){

		if( is_admin() ){
			return;
		}

		$maintenance_mode = get_theme_mod( "naturalife_maintenance_mode" );

		//check the current user access
		if ( current_user_can( "edit_theme_options" ) ){
			return ;
		}

		if( empty( $maintenance_mode ) ){
			return;
		}

		$coming_soon_page = get_theme_mod( "naturalife_maintenance_page" );

		if( empty( $coming_soon_page ) ){
			return;
		}

		if( is_singular("page") ){

			//get queried object
			$query_object = get_queried_object();

			//get the page id
			$page_id = isset( $query_object->ID ) ? $query_object->ID : "";


			if( $page_id == $coming_soon_page ){

				// DISABLE RSS FEEDS
				remove_action( 'wp_head', 'feed_links_extra', 3 ); // Display the links to the extra feeds such as category feeds
				remove_action( 'wp_head', 'feed_links', 2 ); // Display the links to the general feeds: Post and Comment Feed
				remove_action( 'wp_head', 'rsd_link' ); // Display the link to the Really Simple Discovery service endpoint, EditURI link
				remove_action( 'wp_head', 'wlwmanifest_link' ); // Display the link to the Windows Live Writer manifest file.
				remove_action( 'wp_head', 'index_rel_link' ); // index link
				remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 ); // prev link
				remove_action( 'wp_head', 'start_post_rel_link', 10, 0 ); // start link
				remove_action( 'wp_head', 'adjacent_posts_rel_link', 10, 0 ); // Display relational links for the posts adjacent to the current post.
				remove_action( 'wp_head', 'wp_generator' ); // Display the XHTML generator that is generated on the wp_head hook, WP version

				return;
			}

		}

		$redirect_url = get_the_permalink( $coming_soon_page );

		if( empty( $redirect_url ) ){
			return;
		}

		header("HTTP/1.1 302 Moved Temporarily");
		header('Expires: 0');
		header('Location: '.$redirect_url);
	}
}
add_action( 'template_redirect', 'rtframework_coming_soon', 1 );


if( ! function_exists("rtframework_404_page") ){
	/**
	 * Redirect to coming soon page
	 */
	function rtframework_404_page(){

 		if( ! is_404() || is_admin() ){
 			return;
		}

		$rt_404_page = get_theme_mod( "naturalife_404_page" );

		if( empty( $rt_404_page ) ){
			return;
		}

		$redirect_url = get_the_permalink( $rt_404_page );

		if( empty( $redirect_url ) ){
			return;
		}

		header("HTTP/1.1 404 Not Found");
		header('Expires: 0');
		header('Location: '.$redirect_url);
	}
}
add_action( 'template_redirect', 'rtframework_404_page', 2 );


if ( ! function_exists("rtframework_rev_slider_responsive_values") ){
	 /**
	  * Set Responsive Breakpoints for RevSlider
	  * @return array
	  */
	 function rtframework_rev_slider_responsive_values(){

	 	if( ! is_admin() ){
	 		return;
	 	}

		if( ! class_exists('RevSliderFront') ) {
			return;
		}

		$is_updated_before = get_option("rtframework-revslider-settings-updated");

		if( $is_updated_before ){
			return;
		}

		$options = get_option('revslider-global-settings');

		//$options["width"] = "1440";
		$options["width_notebook"] = "1025";
		//$options["width_tablet"] = "1160";
		//$options["width_mobile"] = "780";


		update_option( "revslider-global-settings", $options );
		update_option( "rtframework-revslider-settings-updated", true );

	}
}
add_action("init", "rtframework_rev_slider_responsive_values",100);

 
if( ! function_exists("rtframework_print_social_media_share") ){
	/**
	 * Social Media Share Function
	 * 
	 * @global class $post 
	 * 
	 * @param  array $atts
	 * @param  string $content
	 * @return string $output
	 */
	function rtframework_print_social_media_share( $atts = array(), $content = null ) {
	 		
		//defaults
		extract(shortcode_atts(array(  
			"postid"  => '', 
		), $atts));

		if( empty( $postid) ){
			global $post;	
			$postid = $post->ID;
		}

		//Available Social Media Icons
		$rt_social_share_list =apply_filters("rt_social_share_list",array(  
					"Email"       => array("icon_name" => "mail", "url" => "mailto:?body=[URL]", "popup" => false ), 
					"Twitter"     => array("icon_name" => "twitter", "url" => "http://twitter.com/home?status=[TITLE]+[URL]", "popup" => true ), 
					"Facebook"    => array("icon_name" => "facebook", "url" => "http://www.facebook.com/sharer/sharer.php?u=[URL]&amp;title=[TITLE]", "popup" => true ), 
					"Google +"    => array("icon_name" => "gplus", "url" => "https://plus.google.com/share?url=[URL]", "popup" => true ), 
					"Pinterest"   => array("icon_name" => "pinterest", "url" => "http://pinterest.com/pin/create/bookmarklet/?media=[MEDIA]&amp;url=[URL]&amp;is_video=false&amp;description=[TITLE]", "popup" => true ), 
					"Tumblr"      => array("icon_name" => "tumblr", "url" => "http://tumblr.com/share?url=[URL]&amp;title=[TITLE]", "popup" => true ), 
					"Linkedin"    => array("icon_name" => "linkedin", "url" => "http://www.linkedin.com/shareArticle?mini=true&amp;url=[URL]&amp;title=[TITLE]&amp;source=", "popup" => true ),   
					//"StumbleUpon" => array("icon_name" => "stumbleupon", "url" => "http://www.stumbleupon.com/submit?url=[URL]&amp;title=[TITLE]", "popup" => true ), 
					//"Evernote"    => array("icon_name" => "evernote", "url" => "http://www.evernote.com/clip.action?url=[URL]&amp;title=[TITLE]", "popup" => true ), 
					"Vkontakte"   => array("icon_name" => "vkontakte", "url" => "http://vkontakte.ru/share.php?url=[URL]", "popup" => true ), 
					//"Delicious"   => array("icon_name" => "delicious", "url" => "http://del.icio.us/post?url=[URL]&amp;title=[TITLE]]&amp;notes=", "popup" => true ),	
					//"Reddit"	  => array("icon_name" => "reddit", "url" => "http://www.reddit.com/submit?url=[URL]&amp;title=[TITLE]", "popup" => true )
			));



		$title = urlencode(get_the_title( $postid ));
		$permalink = urlencode(get_the_permalink( $postid ));
		$image = urlencode(rtframework_get_attachment_image_src(get_post_thumbnail_id( $postid )));
		$output = "";

		foreach ($rt_social_share_list as $key => $value){

				$value["url"] = str_replace("[URL]", $permalink, $value["url"] );
				$value["url"] = str_replace("[TITLE]", $title, $value["url"] );
				$value["url"] = str_replace("[MEDIA]", $image, $value["url"] );
	 
				$output .= '<li class="'.$value["icon_name"].'">';
				$output .= $value["popup"] ?
							'<a class="ui-icon-'.$value["icon_name"].' " href="#" data-url="'. $value["url"] .'" title="'. $key .'">':
							'<a class="ui-icon-'.$value["icon_name"].' " href="'. $value["url"] .'" title="'. $key .'">';			
				$output .= '<span>'. $key .'</span>';

				$output .= '</a>';
				$output .= '</li>';
		}

		return '<div class="social_share"><span class="ui-icon-line-share"><span>'.esc_html__("SHARE","naturalife").'</span></span><ul>'.$output.'</ul></div>';
	}
}

add_filter("rtframework_print_social_media_share","rtframework_print_social_media_share",10);



if( ! function_exists("rtframework_the_content_filters") ){
	/**
	 * 
	 * RT the_content filters
	 * Many plugins are adding filters to the original apply_filters( "the_content" ) 
	 * and it causes issues when the filter used multiple times in a document. 
	 */
	function rtframework_the_content_filters( $atts = array(), $content = null ) {

		add_filter( 'rtframework_the_content', 'wptexturize' );
		add_filter( 'rtframework_the_content', 'convert_smilies' );
		add_filter( 'rtframework_the_content', 'convert_chars' );
		add_filter( 'rtframework_the_content', 'wpautop' );
		add_filter( 'rtframework_the_content', 'shortcode_unautop' );
		add_filter( 'rtframework_the_content', 'prepend_attachment' );

	}
}
add_action("template_redirect","rtframework_the_content_filters",10);




if( ! function_exists("rtframework_get_intermediate_image_sizes") ){
	/**
	 * 
	 * Get image sizes with size names
	 * @return array
	 *  
	 */
	function rtframework_get_intermediate_image_sizes( $custom_size = false ) {

		foreach (get_intermediate_image_sizes() as $key => $value) {
			$image_sizes_array[$value] = $value;
		}		 
 
		$image_names = array(
			'custom'    => esc_html_x('Custom', 'Admin Panel','naturalife'),
			'thumbnail' => esc_html_x('Thumbnail', 'Admin Panel','naturalife'),
			'medium'    => esc_html_x('Medium', 'Admin Panel','naturalife'),
			'large'     => esc_html_x('Large', 'Admin Panel','naturalife'),
			'full'      => esc_html_x('Full Size', 'Admin Panel','naturalife'),
		);

		if( ! $custom_size ){
			unset( $image_names["custom"] );
		}

		$sizes = apply_filters( 'image_size_names_choose', $image_names );

		return array_merge($image_sizes_array, $sizes);
	}
} 

if( ! function_exists("rtframework_calculate_image_srcset") ){
	/**
	 * 
	 * get image srcset and sizes
	 * alias function of wp_calculate_image_srcset
	 * @return array
	 *  
	 */
	function rtframework_calculate_image_srcset( $size_array, $src, $image_meta, $image_id ) {
		return wp_calculate_image_srcset($size_array, $src, $image_meta, $image_id);
	}
}