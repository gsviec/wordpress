<?php
/**
 * RT-THEME Global Theme Functions
 *
 * Various Functions for the theme
 *
 * @author 		RT-Themes
 * @package 	RT-Framework/Functions
 * @since 		1.0
 * @version    1.0
 */

    
if( ! function_exists("rtframework_create_media_output") ){
	/**
	 * Create media players
	 * @param  array $atts
	 * @return html
	 */
	function rtframework_create_media_output( $atts ){

		//defaults
		extract(shortcode_atts(array(  
			"id"  => 'player-'.rand(100000, 1000000), 
			"type" => "",
			"poster" => "",
			"file_mp3" => "",
			"file_oga" => "",
			"file_mp4" => "",
			"file_webm" => "",
		), $atts));	


		//audio output
		if( $type == "audio" ){
			printf('
				<div id="%s" class="rt-hosted-media mejs-wrapper mejs-orange">
					<audio controls="controls" preload="none">
						<source src="%s" type="video/mp3" title="mp4">
						<source src="%s" type="video/ogg" title="ogg">
					</audio>
				</div><!-- close .responsive-wrapper -->
			',$id, $file_mp3, $file_oga);
		}

		//video output
		if( $type == "video" ){
			printf('
				<div id="%1$s" class="rt-hosted-media mejs-wrapper mejs-orange">
				<video controls="controls" preload="none" poster="%2$s">
					<source src="%3$s" type="video/mp4" title="mp4">
					<source src="%4$s" type="video/webm" title="mp4">
				</video>

				</div><!-- close .responsive-wrapper -->
			',$id, $poster, $file_mp4, $file_webm);
		}
	}
}
add_action( "rtframework_create_media_output", "rtframework_create_media_output", 10, 1 );

if( ! function_exists("rtframework_blog_post_loop") ){
	/**
	 * Blog Loop
	 * @param  boolean/array $wp_query
	 * @param  array $atts
	 * @return html
	 */
	function rtframework_blog_post_loop( $wp_query = false, $atts = array() ) { 
		global $rtframework_post_values, $rtframework_blog_list_atts;   

		//sanitize fields
		$atts["id"] = isset( $atts["id"] ) ? sanitize_html_class( $atts["id"] ) : 'blog-dynamicID-'.rand(100000, 1000000);

		//defaults
		$rtframework_blog_list_atts = shortcode_atts(array(  
			"id" => 'blog-dynamicID-'.rand(100000, 1000000), 
			"archive" => "false",
			"list_layout" => get_theme_mod('naturalife_blog_layout'),
			"layout_style" => get_theme_mod('naturalife_blog_layout_style'),
			"show_author" => get_theme_mod('naturalife_show_author') ? "true" : "false",
			"show_categories" => get_theme_mod('naturalife_show_categories') ? "true" : "false",
			"show_comment_numbers" => get_theme_mod('naturalife_show_comment_numbers') ? "true" : "false",
			"show_date" => get_theme_mod('naturalife_show_date') ? "true" : "false",
			"show_share" => get_theme_mod('naturalife_show_share') ? "true" : "false",
			"featured_image_resize" => get_theme_mod("naturalife_blog_image_resize"),
			"featured_image_max_width" => get_theme_mod("naturalife_blog_image_width"),				
			"featured_image_max_height" => get_theme_mod("naturalife_blog_image_height"),
			"featured_image_crop" => get_theme_mod("naturalife_blog_image_crop"),
			"pagination" => "true",
			"ajax_pagination" => "false",
			"use_excerpts" => get_theme_mod("naturalife_use_excerpts") ? "true" : "false",
			"list_orderby" => "date",
			"list_order" => "DESC",
			"item_per_page"=> 10,
			"categories" => "",
			"ajax" => "false",
			"paged" => 0,
			"wpml_lang" => "",
		), $atts);

		extract($rtframework_blog_list_atts);

		//counter
		$counter = 1;			


		if( ! $wp_query ){

			//paged
			if( $pagination !== "false" && $paged == 0 ){
				if (get_query_var('paged') ) {$paged = get_query_var('paged');} elseif ( get_query_var('page') ) {$paged = get_query_var('page');} else {$paged = 1;} 
			}

			//create a post status array
			$post_status = is_user_logged_in() ? array( 'private', 'publish' ) : "publish";

			//categoried 
			$categories = is_array( $categories ) || empty( $categories ) ? $categories : explode(",", rtframework_wpml_lang_object_ids( $categories, "category",$wpml_lang ) ); 	

			//general query
			$args=array( 
				'post_status'    => $post_status,
				'post_type'      => 'post',
				'orderby'        => $list_orderby,
				'order'          => $list_order,
				'posts_per_page' => $item_per_page,
				'paged'          => $paged, 
				'category__in'   => $categories,
			);

			$wp_query  = new WP_Query($args); 

		}

		//get page & post counts
		$post_count = $wp_query->post_count;
		$page_count = $wp_query->max_num_pages;

		//item width percentage
		$list_layout = ! empty( $list_layout ) ? $list_layout : "1/3";
 
 		//layout style
		$add_holder_class = $list_layout == "1/1" ? " row" : ( $layout_style == "masonry" ? " masonry" : " fixed_heights" ) ; 


 		//column class
 		$add_column_class = rtframework_column_class( $list_layout );
		$add_column_class .= $layout_style == "masonry" ? " isotope-item" : "";

		//row count
		$column_count = rtframework_column_count( $list_layout );


		if ( $wp_query->have_posts() ){ 
			
			//open the wrapper
			echo "\n".'<div id="'.sanitize_html_class($id).'" class="blog_list '.trim($add_holder_class).'" data-column-width="'. $column_count .'">'."\n";
 

			//the loop
			while ( $wp_query->have_posts() ) : $wp_query->the_post();


				//get post values
				$rtframework_post_values = rtframework_get_loop_post_values( $wp_query->post, $rtframework_blog_list_atts );
				
				//open row block
				if(  $layout_style != "masonry" && $list_layout != "1/1" && ( $counter % $column_count == 1 || $column_count == 1 ) ){
					echo '<div class="row">'."\n";
				}	

					$post_classes = get_post_class("col ".$add_column_class, get_the_ID() ) ;

					echo '<article id="'.get_the_ID().'" class="'.implode(" ", $post_classes ).'">'."\n" ;

						do_action( "rtframework_before_blog_loop");

						get_template_part( '/post-contents/content', get_post_format() ); 

						do_action( "rtframework_after_blog_loop");

					echo '</article>'."\n" ;

						 
				//close row block
				if( $layout_style != "masonry" && $list_layout != "1/1" && ( $counter % $column_count == 0 || $post_count == $counter ) ){
					echo '</div>'."\n";  
				}

			$counter++;
			endwhile;  
			
			//reset post data for the new query
			wp_reset_postdata(); 		
 

			//close wrapper
			echo '</div>'."\n"; 		


			if( ( $pagination !== "false" && $ajax_pagination === "false" ) || ( $pagination !== "false" && $layout_style != "masonry" ) ){
				rtframework_get_pagination( $wp_query );	
			} 
			
			if( $ajax_pagination !== "false" && $layout_style == "masonry" && $page_count > 1 && $ajax === "false" ){

				$rtframework_blog_list_atts["purpose"] = "blog";
				rtframework_get_ajax_loader_button( $rtframework_blog_list_atts, $page_count );	

			}

		}		
	}
}
add_action('rtframework_blog_post_loop', 'rtframework_blog_post_loop', 10, 2); 

if( ! function_exists("rtframework_get_loop_post_values") ){
	/**
	 * Get post values for loops
	 * gets all data of a post including metas
	 * 
	 * @param  array $post
	 * @param  array $atts [atts of rtframework_blog_post_loop function]
	 * @return array
	 */
	function rtframework_get_loop_post_values( $post = array(), $atts = array(), $purpose = "" ){

		extract( $atts );

		//featured image
		$featured_image_id     = get_post_thumbnail_id(); 
		$featured_image_url    = ! empty( $featured_image_id ) ? wp_get_attachment_image_src( $featured_image_id, "full" ) : "";
		$featured_image_url    = is_array( $featured_image_url ) ? $featured_image_url[0] : "";	


		//custom thumbnail max height & crop settings for this post			
		if( $purpose != "carousel" ){	
			if( get_post_meta( $post->ID, 'rttheme_featured_image_settings', true) == "new" ){
				$featured_image_resize     = esc_attr(get_post_meta( $post->ID, 'rttheme_blog_image_resize', true));
				$featured_image_max_width  = esc_attr(get_post_meta( $post->ID, 'rttheme_blog_image_width', true));
				$featured_image_max_height = esc_attr(get_post_meta( $post->ID, 'rttheme_blog_image_height', true));
				$featured_image_crop       = esc_attr(get_post_meta( $post->ID, 'rttheme_blog_image_crop', true));
			}
		}


		if( $featured_image_resize !== "false"){
			// thumbnail min width
			$w = ! empty( $featured_image_max_width ) ? $featured_image_max_width : rtframework_get_min_resize_size( $list_layout );

			// thumbnail max height
			$h = ! empty( $featured_image_max_height ) ? $featured_image_max_height : 10000;

			//thumbnail output
			$thumbnail_image_output = ! empty( $featured_image_id ) ? rtframework_get_resized_image_output( array( "image_url" => "", "image_id" => $featured_image_id, "w" => $w, "h" => $h, "crop" => $featured_image_crop ) ) : ""; 	

		}else{
			//thumbnail output
			$thumbnail_image_output = ! empty( $featured_image_id ) ? rtframework_get_image_output( array( "image_url" => "", "image_id" => $featured_image_id ) ) : ""; 						
		}


		// Tiny image thumbnail for lightbox gallery feature
		$lightbox_thumbnail = ! empty( $featured_image_id ) ? rtframework_resize( $featured_image_id, "", 75, 50, true ) : rtframework_resize( $featured_image_id, "", 75, 50, true ); 
		$lightbox_thumbnail = is_array( $lightbox_thumbnail ) ? $lightbox_thumbnail["url"] : "" ; 

		//gallery usage 
		$gallery_usage         = esc_attr(get_post_meta( $post->ID, 'rttheme_gallery_usage', true)); 
		$gallery_usage_listing = esc_attr(get_post_meta( $post->ID, 'rttheme_gallery_usage_listing', true));	 

		// gallery images
		$gallery_images = esc_attr(get_post_meta( $post->ID, "rtthemert_gallery_images", true )); 
		$gallery_images = ! empty( $gallery_images ) ? ! is_array( $gallery_images ) ? explode(",", $gallery_images) : $gallery_images : array(); //turn into an array

		//video_usage_listing
		$video_usage_listing = get_post_meta( $post->ID, 'rttheme_video_usage_listing', true); 
		$video_usage_listing = isset( $layout_style ) && $layout_style == "masonry" && $video_usage_listing == "same" ? "only_featured_image" : $video_usage_listing;


		//create global values array
		$rtframework_post_values = array(
			"title"                    => get_the_title(),
			"permalink"                => get_permalink(),
			"featured_image_id"        => $featured_image_id ,
			"featured_image_url"       => esc_url($featured_image_url), 
			"post_format_link"         => esc_url(get_post_meta( $post->ID, 'rtthemepost_format_link', true)),
			"video_mp4"                => esc_url(get_post_meta( $post->ID, 'rttheme_post_video_m4v', true)),
			"video_webm"               => esc_url(get_post_meta( $post->ID, 'rttheme_post_video_webm', true)),
			"external_video"           => esc_url(get_post_meta( $post->ID, 'rtthemevideo_url', true)),
			"video_usage_listing"      => $video_usage_listing, 
			"audio_mp3"                => esc_url(get_post_meta( $post->ID, 'rttheme_post_audio_mp3', true)),
			"audio_ogg"                => esc_url(get_post_meta( $post->ID, 'rttheme_post_audio_oga', true)),
			"audio_usage_listing"      => get_post_meta( $post->ID, 'rttheme_audio_usage_listing', true),
			"gallery_images"           => $gallery_images,
			"gallery_usage"            => $gallery_usage,
			"gallery_usage_listing"    => $gallery_usage_listing,
			"thumbnail_image_output"   => $thumbnail_image_output,
			"lightbox_thumbnail"       => $lightbox_thumbnail,
			"slider_images_crop"       => esc_attr(get_post_meta( $post->ID, 'rtthemegallery_images_crop', true)),
			"slider_images_max_height" => esc_attr(get_post_meta( $post->ID, 'rtthemegallery_images_height', true)),
		);


		return $rtframework_post_values;
	}
}

if( ! function_exists("rtframework_get_single_post_values") ){
	/**
	 * Get post values for single
	 * gets all data of a post including metas
	 * 
	 * @param  array $post
	 * @param  array $atts [atts of rtframework_blog_post_loop function]
	 * @return array
	 */
	function rtframework_get_single_post_values( $post = array(), $atts = array() ){


		//defaults
		$atts = shortcode_atts(array(  
			"layout"                     => "1/1",
			"show_author"                => get_theme_mod( "naturalife_show_author_single" ) ? "true" : "false",
			"show_categories"            => get_theme_mod( "naturalife_show_categories_single" ) ? "true" : "false",
			"show_comment_numbers"       => "false",
			"show_date"                  => get_theme_mod( "naturalife_show_date_single" ) ? "true" : "false",
			"show_tags"                  => "true",
			"show_share"                 => get_theme_mod( "naturalife_show_share_single" ) ? "true" : "false",
			"show_author_info"           => get_theme_mod( "naturalife_show_author_info" ),
			"featured_image_single_page" => get_post_meta( $post->ID, 'rtthemefeatured_image_single_page', true), 
			"featured_image_resize"      => get_theme_mod("naturalife_single_blog_image_resize"),
			"featured_image_max_width"   => get_theme_mod("naturalife_single_blog_image_width"),				
			"featured_image_max_height"  => get_theme_mod("naturalife_single_blog_image_height"),
			"featured_image_crop"        => get_theme_mod("naturalife_single_blog_image_crop")
		), $atts);

		extract( $atts );


		//featured image
		$featured_image_id     = get_post_thumbnail_id(); 
		$featured_image_url    = ! empty( $featured_image_id ) ? wp_get_attachment_image_src( $featured_image_id, "full" ) : "";
		$featured_image_url    = is_array( $featured_image_url ) ? $featured_image_url[0] : "";	


		//custom thumbnail max height & crop settings for this post			
		if( get_post_meta( $post->ID, 'rttheme_single_featured_image_settings', true) == "new" ){
			$featured_image_resize     = esc_attr(get_post_meta( $post->ID, 'rttheme_single_blog_image_resize', true));
			$featured_image_max_width  = esc_attr(get_post_meta( $post->ID, 'rttheme_single_blog_image_width', true));
			$featured_image_max_height = esc_attr(get_post_meta( $post->ID, 'rttheme_single_blog_image_height', true));
			$featured_image_crop       = esc_attr(get_post_meta( $post->ID, 'rttheme_single_blog_image_crop', true));
		}


		if( $featured_image_resize !== "false"){
			// thumbnail min width
			$w = ! empty( $featured_image_max_width ) ? $featured_image_max_width : rtframework_get_min_resize_size( $layout );

			// thumbnail max height
			$h = ! empty( $featured_image_max_height ) ? $featured_image_max_height : 10000;

			//thumbnail output
			$thumbnail_image_output = ! empty( $featured_image_id ) ? rtframework_get_resized_image_output( array( "image_url" => "", "image_id" => $featured_image_id, "w" => $w, "h" => $h, "crop" => $featured_image_crop ) ) : ""; 	

		}else{
			//thumbnail output
			$thumbnail_image_output = ! empty( $featured_image_id ) ? rtframework_get_image_output( array( "image_url" => "", "image_id" => $featured_image_id ) ) : ""; 						
		}



		// Tiny image thumbnail for lightbox gallery feature
		$lightbox_thumbnail = ! empty( $featured_image_id ) ? rtframework_resize( $featured_image_id, "", 75, 50, true ) : rtframework_resize( $featured_image_id, "", 75, 50, true ); 
		$lightbox_thumbnail = is_array( $lightbox_thumbnail ) ? $lightbox_thumbnail["url"] : "" ; 

		//gallery usage 
		$gallery_usage = get_post_meta( $post->ID, 'rttheme_gallery_usage', true);			

		// gallery images
		$gallery_images = get_post_meta( $post->ID, "rtthemert_gallery_images", true ); 
		$gallery_images = ! empty( $gallery_images ) ? ! is_array( $gallery_images ) ? explode(",", $gallery_images) : $gallery_images : array(); //turn into an array

		//create global values array
		$rtframework_post_values = array(
			"title"                    => get_the_title(),
			"permalink"                => get_permalink(),
			"featured_image_id"        => $featured_image_id ,
			"featured_image_url"       => $featured_image_url, 
			"post_format_link"         => get_post_meta( $post->ID, 'rtthemepost_format_link', true),
			"video_mp4"                => get_post_meta( $post->ID, 'rttheme_post_video_m4v', true),
			"video_webm"               => get_post_meta( $post->ID, 'rttheme_post_video_webm', true), 
			"external_video"           => get_post_meta( $post->ID, 'rtthemevideo_url', true),
			"audio_mp3"                => get_post_meta( $post->ID, 'rttheme_post_audio_mp3', true), 
			"audio_ogg"                => get_post_meta( $post->ID, 'rttheme_post_audio_oga', true), 
			"gallery_images"           => $gallery_images,
			"gallery_usage"            => $gallery_usage,
			"thumbnail_image_output"   => $thumbnail_image_output,
			"lightbox_thumbnail"       => $lightbox_thumbnail,
			"slider_images_crop"       => get_post_meta( $post->ID, 'rtthemegallery_images_crop', true),
			"slider_images_max_height" => get_post_meta( $post->ID, 'rtthemegallery_images_height', true),							
		);

		$rtframework_post_values = array_merge($rtframework_post_values, $atts);


		return $rtframework_post_values;
	}
}

if( ! function_exists("rtframework_get_page_count") ){
	/**
	 *  Get page count
	 * @return number $count
	 */
	function rtframework_get_page_count(){
		global $wp_query;	
		$count=array('page_count'=>$wp_query->max_num_pages,'post_count'=>$wp_query->post_count);
		return $count;
	}
}
 
if( ! function_exists("rtframework_limit_search_results") ){
	/**
	 * Limit search results
	 * @param  string $query
	 * @return string $query
	 */
	function rtframework_limit_search_results($query) { 
		if ($query->is_search) {
				$query->set('posts_per_page', 10);
		}
		return $query; 
	}
}
add_filter('pre_get_posts','rtframework_limit_search_results');

if( ! function_exists("rtframework_HexToRGB") ){
	/**
	 * Convert Hex values to RGB
	 * @param  string $hex
	 * @return string $color
	 */
	function rtframework_HexToRGB($hex) {
		$hex = str_replace("#", "", $hex);
		$color = array();
	 
		if(strlen($hex) == 3) {
			$color['r'] = hexdec(substr($hex, 0, 1) . $r);
			$color['g'] = hexdec(substr($hex, 1, 1) . $g);
			$color['b'] = hexdec(substr($hex, 2, 1) . $b);
		}
		else if(strlen($hex) == 6) {
			$color['r'] = hexdec(substr($hex, 0, 2));
			$color['g'] = hexdec(substr($hex, 2, 2));
			$color['b'] = hexdec(substr($hex, 4, 2));
		}
		 
		return $color;
	}
}

if( ! function_exists("rtframework_rgba2hex") ){
	/**
	 * RGB Fallback color for RGBA colors for IE8
	 * 
	 * @param  string $rgb rgb value
	 * @return string hex value
	 */
	function rtframework_rgba2hex($rgb) {

		if( strpos( $rgb, "rgba" ) === false ){
			return $rgb;	
		} 
		
		$regex = '/[^\d\,|.]/i'; 
		$value_set = preg_replace($regex, "", $rgb);

		$hex = explode(",",$value_set);

		$r = dechex($hex[0]);
		$g = dechex($hex[1]);
		$b = dechex($hex[2]);

		return "#".$r.$g.$b;
	}
} 
 
if( ! function_exists("rtframework_merge_featured_images") ){
	/**
	 * Merge Featured Images
	 * @param  array $rt_gallery_images
	 * @return array $rt_gallery_images
	 */
	function rtframework_merge_featured_images( $rt_gallery_images ){

		// wp - featured image 
		$featured_image_id     = get_post_thumbnail_id(); 
		$featured_image_url    = ! empty( $featured_image_id ) ? wp_get_attachment_image_src( $featured_image_id, "full" ) : ""; 
		
		if( is_array( $featured_image_url ) && isset( $featured_image_url[0] ) && is_array( $rt_gallery_images ) ){
			array_unshift($rt_gallery_images,  $featured_image_url[0] );
		}

		return $rt_gallery_images;
	}
}

if( ! function_exists("rtframework_merge_featured_images_by_id") ){
	/**
	 * Merge Featured Images by ID
	 * @param  array $rt_gallery_images
	 * @return array $rt_gallery_images
	 */
	function rtframework_merge_featured_images_by_id( $rt_gallery_images ){

		//new array
		$new_list = array();

		// wp - featured image 
		$featured_image_id = get_post_thumbnail_id(); 
		
		if( ! empty( $featured_image_id ) ){
			array_unshift( $new_list, $featured_image_id );
		}

		if( ! empty( $rt_gallery_images ) && is_array( $rt_gallery_images ) ){
			$new_list = array_merge( $new_list, $rt_gallery_images );
		}

		return $new_list;
	}
}

if( ! function_exists("rtframework_post_meta") ){
	/**
	 * Post meta bar
	 * @param  array $atts
	 * @return html
	 */
	function rtframework_post_meta( $atts ){
		
		//defaults
		extract(shortcode_atts(array(  
			"show_author" => "true",
			"show_categories" => "true",
			"show_comment_numbers" => "true",
			"show_tags" => "false",
			"show_date" => "true",
			"show_share" => "false"
		), $atts));

		
		//if all paramaters is false don't display the wrapper
		if( ! is_singular() ){
			if  ( $show_author == "false" && $show_categories == "false" && $show_comment_numbers == "false" && $show_tags == "false" && $show_date == "false" ){		
				return;
			}
		}

		if( is_singular() ){
			if  ( $show_author == "false" && $show_categories == "false" && $show_date == "false" ){
				return;
			}
		}

	?>

		<!-- meta data -->
		<div class="post_data">

			<?php if( $show_date !== "false" ):?>
			<!-- date -->                                     
			<span class="icon-line-clock date margin-right20"><a href="<?php echo esc_url( get_the_permalink() ); ?>"><?php echo get_the_date();?></a></span>
			<?php endif;?>
				

			<?php if( $show_author !== "false" ):?>
			<!-- user -->                                     
			<span class="icon-new-user-1 user margin-right20"><?php the_author_posts_link();?></span>
			<?php endif;?>
				
			<?php 
			if( $show_categories !== "false" && get_the_category() ):?>
			<!-- categories -->
			<span class="icon-flow-cascade categories"><?php the_category(', ');?></span>
			<?php endif;?>

			<?php 
			if( $show_tags !== "false" && get_the_tags() ):?>
			<!-- categories -->
			<span class="icon-line-tag tags"><?php the_tags("",", ","");?></span>
			<?php endif;?>

			<?php if( $show_comment_numbers !== "false" && comments_open() ):?>
			<!-- comments --> 
			<span class="icon-comment-empty comment_link"><a href="<?php comments_link(); ?>" title="<?php comments_number( esc_html__('0 Comment','naturalife'), esc_html__('1 Comment','naturalife'), esc_html__('% Comments','naturalife') ); ?>" class="comment_link"><?php comments_number( esc_html__('0 Comment','naturalife'), esc_html__('1 Comment','naturalife'), esc_html__('% Comments','naturalife') ); ?></a></span>
			<?php endif;?>

			<?php if( $show_share !== "false" ):?>
				<?php 
					//Social Share buttons
					echo rtframework_social_media_share( $atts = array("postid" => get_the_ID()) );
				?>
			<?php endif;?>

		</div><!-- / end div  .post_data -->
	<?php
	}
}
add_action( "rtframework_post_meta_bar", "rtframework_post_meta", 10 );

if( ! function_exists("rtframework_get_min_resize_size") ){
	/**
	 *  Get min image resize size according to column width
	 * @param  string $column_width  
	 * @return number              
	 */
	function rtframework_get_min_resize_size( $column_width = "1/12" ){

		$column_width = $column_width == "" ? 1 : rtframework_column_count($column_width);
		$content_width = 1000;		

		$max_image_width = $content_width; //max image size for the design
		$min_image_width = 480; //min image size for mobile view
		$resize_width = 0;		

		if( isset( $column_width ) && is_numeric( $column_width ) ){
			$resize_width = $max_image_width / ( $column_width );
			$resize_width = $resize_width > $min_image_width ? $resize_width : $min_image_width;
		}

		return intval( $resize_width );
	}
}

if( ! function_exists("rtframework_get_image_data") ){
	/**
	 * Get data of a resized image
	 * @param  array $args
	 * @return array      
	 */
	function rtframework_get_image_data($args){
		global $post;  
	   
		//args
		extract(shortcode_atts(array(  
			"image_id"  => "", 
			"image_url"  => "", 
			"w" => "",
			"h" => "",
			"crop" => false 
		), $args));


		//save the global post if any
		$save_post = $post;

		//find post id from src 
		if ( empty( $image_id ) && ! empty( $image_url ) ){
			$image_id = rtframework_get_attachment_id_from_src($image_url);			

		}

		//get the post attachment
		$attachment = ! empty ( $image_id ) ? get_post( rtframework_wpml_translated_page_id( $image_id ) ) : false ;	

		if( $attachment ){

			//attachment data
			$image_title =  esc_attr($attachment->post_title);			
			$image_caption =  esc_attr($attachment->post_excerpt);			
			$image_description =  $attachment->post_content;			
			$image_alternative_text = esc_attr(get_post_meta( $image_id , '_wp_attachment_image_alt', true));		

			//image url - if not provided
			$orginal_image_url = empty( $image_url ) ? $attachment->guid : esc_url($image_url) ;
 
			//resized img src - resize the image if $w and $h suplied 
			$thumbnail_url = ( ! empty( $w ) && ! empty( $h ) ) ? rtframework_resize( $image_id, '', $w, $h, $crop ) : $orginal_image_url;	
			$thumbnail_url = is_array( $thumbnail_url ) ? $thumbnail_url["url"] : $thumbnail_url ;
	 
			// Tiny image thumbnail for lightbox gallery feature
			$lightbox_thumbnail = rtframework_resize( $image_id, '', 75, 50, true ); 
			$lightbox_thumbnail = is_array( $lightbox_thumbnail ) ? $lightbox_thumbnail["url"] : $thumbnail_url ;		
		}


		//give back the global post
		$post = $save_post; 


		if( $attachment ){
			//output
			return array(
				"image_title"   => $image_title, 
				"image_caption" => $image_caption, 
				"image_alternative_text" => $image_alternative_text,
				"image_url" => $orginal_image_url,
				"thumbnail_url" => $thumbnail_url,
				"lightbox_thumbnail" => $lightbox_thumbnail
			);			
		}else{

			//output
			return array(
				"image_title"   => "", 
				"image_caption" => "", 
				"image_alternative_text" => "",
				"image_url" => $image_url,
				"thumbnail_url" => $image_url,
				"lightbox_thumbnail" => $image_url
			);			
		}

	}
}

if( ! function_exists("rtframework_create_lightbox_link") ){
	/**
	 * Create a link for lightbox
	 * @param  array $args
	 * @return html      
	 */
	function rtframework_create_lightbox_link($atts){

		//defaults
		extract(shortcode_atts(array(  
			"id"  => 'lightbox-'.rand(100000, 1000000), 
			"title" => "",
			"href" => "",
			"class" => "",
			"data_group" => "",
			"data_thumbnail" => "",
			"data_thumbTooltip" => "",
			"data_title" => "", 
			"data_description" => "", 
			"data_scaleUp" => "", 
			"data_href" => "", 
			"data_width" => "", 
			"data_height" => "", 
			"data_flashHasPriority" => "", 
			"data_poster" => "", 
			"data_autoplay" => "", 
			"data_audiotitle" => "", 
			"inner_content" => "",
			"tooltip" => false,
			"echo"=> true
		), $atts));

		//tooltip
		$tooltip = $tooltip == "true" ? ' data-placement="top" data-toggle="tooltip"' : "";

		//output
		$lightbox_link = sprintf(
			'<a 
			id="%s" 
			class="%s" 
			data-gal-id="%s" 
			data-rel="rt_lightbox" 
			title="%s" 			
			data-title="%s" 
			data-sub-html="%s" 
			data-thumbnail="%s" 
			data-thumbTooltip="%s" 
			data-scaleUp="%s" 
			data-src="%s" 
			data-width="%s" 
			data-height="%s" 
			data-flashHasPriority="%s" 
			data-poster="%s" 
			data-autoplay="%s" 
			data-audiotitle="%s" 
			data-download-url="false"
			href="%s" 
			%s
			>%s</a>',
			$id,
			$class,
			$data_group,
			esc_attr($title),
			esc_attr($data_title),
			esc_attr($data_description),
			esc_url($data_thumbnail),
			$data_thumbTooltip,
			$data_scaleUp,
			esc_url($data_href),
			$data_width,
			$data_height,
			$data_flashHasPriority,
			$data_poster,
			$data_autoplay,
			$data_audiotitle,
			esc_url($href),
			$tooltip,
			$inner_content
		);

		//echo 
		echo ( $echo ) ? $lightbox_link : "";

		return $lightbox_link;
	}
}
add_action( "rtframework_create_lightbox_link", "rtframework_create_lightbox_link", 10, 1 );

if( ! function_exists("rtframework_get_resized_image_output") ){
	/**
	 * Get html output of a resized image
	 * @param  array $atts
	 * @return html 
	 */
	function rtframework_get_resized_image_output( $atts = array() ){

		//defaults
		extract(shortcode_atts(array(  
			"image_url" => "", 	   
			"image_id" => "", 	   
			"w" => "", 	  
			"h" => "", 	   
			"crop" => false,
			"class" => ""
		), $atts)); 

		
		if ( empty( $image_id ) && empty( $image_url ) ){
			return false;
		}else{

			$image_id = empty( $image_id ) && ! empty( $image_url ) ? rtframework_get_attachment_id_from_src( $image_url ) : $image_id ;

			$image_thumb = ! empty( $image_id ) ? rtframework_resize( $image_id, '', $w, $h, $crop ) : rtframework_resize( '', $image_url, $w, $h, $crop );

			$image_alternative_text = ! empty( $image_id ) ? get_post_meta($image_id, '_wp_attachment_image_alt', true) : "";		

			$image_output = is_array($image_thumb) ? '<img src="'.esc_url($image_thumb['url']).'" alt="'.esc_attr($image_alternative_text).'" class="'.sanitize_html_class($class).'" />' : "";	

			return $image_output;
		}
	}
}

if( ! function_exists("rtframework_get_image_output") ){
	/**
	 * Get html output of an image
	 * @param  array $atts
	 * @return html 
	 */	
	function rtframework_get_image_output( $atts = array() ){

		//defaults
		extract(shortcode_atts(array(  
			"image_url" => "", 	   
			"image_id" => "", 	   
			"class" => "",
			"id" => "",
			"itemprop" => false
		), $atts)); 
		
		if ( empty( $image_id ) && empty( $image_url ) ){
			return false;
		}else{

			//find img id from src 
			if ( empty( $image_id ) && ! empty( $image_url ) ){
				$image_id = rtframework_get_attachment_id_from_src($image_url);
			}

			//image alt text
			$image_alternative_text = ! empty( $image_id ) ? get_post_meta($image_id, '_wp_attachment_image_alt', true) : "";		

			//image src
			$image_src = ! empty( $image_id ) ? rtframework_get_attachment_image_src( $image_id ) : $image_url;

			//if img src couldn't found return false
			if( ! $image_src ){
				return ;
			}

			//itemprop
			$itemprop = $itemprop ? ' itemprop="image"' : ""; 
	 	
	 		//image id attr
			$id = ! empty( $id ) ? 'id="'.sanitize_html_class($id).'"' : "";

			//the output
			$image_output = '<img '.$id.''.$itemprop.' src="'.esc_url($image_src).'" alt="'.esc_attr($image_alternative_text).'" class="'.sanitize_html_class($class).'" />';	

			return $image_output;
		}
	}
}

if( ! function_exists("rtframework_get_pagination") ){
	/**
	 * 
	 * Get Pagination
	 * gets the WP pagination for the post list
	 *
	 * @param  boolean/object $wp_query
	 * @param  integer $range   
	 * @param  boolean $before  
	 * @param  boolean $after   
	 * @param  boolean $echo    
	 * @return html           
	 */
	function rtframework_get_pagination($wp_query = false, $range = 8, $before = false, $after = false, $echo = true ){
		global $paged;
		$max_page = $wp_query->max_num_pages; 

		$array = array(
			'current' => max( 1, $paged ),
			'total' => $wp_query->max_num_pages,
			'type' => 'list',
			'show_all' => false,
			'prev_next' => true,
			'prev_text' => '<span class="icon-angle-left"></span>',
			'next_text' => '<span class="icon-angle-right"></span>',	
		);		

		if( is_front_page() ){ 
			$array["format"] = '?page=%#%';
		}

		$output = '<div class="paging_wrapper margin-t30 margin-b30">';
		$output .= paginate_links( $array );
		$output .= '</div>'; 

		if( $echo ){
			echo $output;
		}else{
			return $output;
		}
	}
}

if( ! function_exists("rtframework_get_attachment_image_src") ){

	/**
	 * Get Attachment Image Source
	 * Returns url of the attachment image by using native WP function
	 * in some shortcode settins the image can be ID or URL. 
	 * This function only works when ID provided
	 *
	 * @since 1.0
	 *
	 * @param  string $image image id or url
	 * @param  string $size  thumbnail width
	 * @return array $url 
	 */
	function rtframework_get_attachment_image_src( $image = "", $size = "full" ) {

		$url = is_numeric(trim($image)) ? wp_get_attachment_image_src( $image, $size ) : $image ;
		$url = is_array( $url ) ? $url[0] : $url ;	

		return $url;
	}
}

if( ! function_exists("rtframework_get_title") ){

	/**
	 * Get title
	 * gets the title of current page according the content types
	 *
	 * @since 1.0
	 * 
	 * @global $post, $wp_query;
	 * @return string $title;
	 */
	function rtframework_get_title() {
		global $post, $wp_query;

		// the page title

		//frontpage
		if( is_front_page() ){
			$title = get_bloginfo('description');
		}

		//single
		if( is_single() || is_page() ){ 
			$title = get_the_title();
		}

		//single
		$blog_name = get_theme_mod("naturalife_blog_page_name");
		if( is_single() && $post->post_type == "post" && $blog_name ){ 
			$title = $blog_name;
		} 		

		//categories
		if ( is_category() ) { 
			$title = single_cat_title("",false);
		}

		//taxamonies
		if ( is_tax() ) { 
			$title = single_term_title("",false);
		}

		//tags
		if ( is_tag() ) { 
			$title = single_tag_title("",false);
		}

		//authors
		if ( is_author() ) { 
			$title = get_the_author();
		}

		//search
		if ( is_search() ) { 
			$title = sprintf( esc_html__( 'Search Results for: %s', 'naturalife' ), get_search_query() );
		}

		//404
		if ( is_404() ) { 
			$title = esc_html__("Page not found",'naturalife'); 
		}

		//woocommerce page title
		if ( class_exists( 'Woocommerce' ) ) { //woocommerce title
			if ( is_woocommerce() ){
				$title = rtframework_get_woocommerce_page_title();
			}
		}

		//archive
		if ( is_archive() ){
			if ( is_day() ) {
				$title = sprintf( esc_html__( 'Daily Archives: %s', 'naturalife' ), get_the_date() );
			} elseif ( is_month() ) {
				$title = sprintf( esc_html__( 'Monthly Archives: %s', 'naturalife' ), get_the_date( esc_html__( 'F Y', 'naturalife' ) ) );
			} elseif ( is_year() ) {
				$title = sprintf( esc_html__( 'Yearly Archives: %s', 'naturalife' ), get_the_date( esc_html__( 'Y', 'naturalife' ) ) );
			} elseif ( is_author() ) {
				$title = sprintf( esc_html__( 'All posts by: %s', 'naturalife' ), get_the_author()  ); 
			} elseif ( is_tag() ) {
				$title = sprintf( esc_html__( 'Tag Archives: %s', 'naturalife' ), single_tag_title( '', false ) );
			}
		}

		//posts page
		if ( is_home() && ! isset( $title ) ) { 
			$title = get_the_title( get_option( 'page_for_posts' ) );
		}

		//fallback
		if ( ! isset( $title ) || empty( $title ) ) { 
			$title = wp_get_document_title(); 
		}

		return $title;
	}
}

if( ! function_exists("rtframework_column_class") ){

	/**
	 * Column Class Name
	 * returns the class name of the column by given number
	 *
	 * @since 1.0
	 * 
	 * @param  float/string $width if string provided, it will be converted to float for 12 columns. Ex: 4 will be 1/4
	 * @return string $class;
	 */
	function rtframework_column_class( $width = "1/1", $screen = "sm" ) {

		//the class list
		$class_list = array(
			"12/12" => "col-{$screen}-12",			
			"1/1" => "col-{$screen}-12",
			"11/12" => "col-{$screen}-11",
			"10/12" => "col-{$screen}-10",			
			"5/6" => "col-{$screen}-10",
			"9/12" => "col-{$screen}-9",
			"3/4" => "col-{$screen}-9",			
			"8/12" => "col-{$screen}-8",
			"4/6" => "col-{$screen}-8",
			"2/3" => "col-{$screen}-8",
			"7/12" => "col-{$screen}-7",
			"6/12" => "col-{$screen}-6",
			"1/2" => "col-{$screen}-6",
			"5/12" => "col-{$screen}-5",
			"1/3" => "col-{$screen}-4",
			"4/12" => "col-{$screen}-4",
			"2/6" => "col-{$screen}-4",
			"1/4" => "col-{$screen}-3", 
			"3/12" => "col-{$screen}-3",
			"1/6" => "col-{$screen}-2",
			"2/12" => "col-{$screen}-2",
			"1/12" => "col-{$screen}-1",
		);

		/* fix the provided width value if its not float */
		$width = strpos($width,"/") ? $width : "1/".intval($width);
		
		$class = array_key_exists( $width , $class_list ) ? $class_list[ $width ] : $class_list["1/1"];

		return $class;
	}
}

if( ! function_exists("rtframework_column_count") ){

	/**
	 * Column count according fractional number
	 *
	 * @since 1.0
	 * 
	 * @param  string $width 
	 * @return number $count;
	 */
	function rtframework_column_count( $width = "1/1" ) {
		
		$number = explode("/", $width);
		$number = is_array($number) && isset( $number[1] ) && isset( $number[0] ) && is_numeric( $number[0] ) && is_numeric( $number[1] ) ? $number[1]/$number[0] : 1;
		$number = is_numeric( $number ) ? $number : 1 ;

		return $number;
	}
}

if( ! function_exists("rtframework_create_carousel") ){
	/**
	 * Creates a carousel
	 *
	 * @since 1.0
	 * 
	 * @param  array $contents
	 * @param  string $id  
	 * @return output
	 */
	function rtframework_create_carousel( $contents = array(), $atts = array(), $thumbnails = array() ){
 
		//defaults
		extract(shortcode_atts(array(  
			"id"  => 'slider-'.rand(100000, 1000000), 
			"item_width"  => 4, 
			"class" => "",
			"dots" => "false",
			"nav" => "true",
			"margin" => 15,
			"autoplay" => "false",
			"timeout" => "5000",
			"thumb_nav" => "false",
			"boxed" => "false",
			"min_height" => "",
			"hash_navigation" => false,
			"lightbox" => "true"
		), $atts));
	
		$output = $contents_output  = "";

		//create carousel items
		$i = 1;
		foreach ( $contents as $content ) {
			$contents_output .= $hash_navigation ? sprintf('<div data-hash="%s-%s">%s</div>', $id, $i, $content) : sprintf('<div>%s</div>', $content);
			$i++;
		} 

		//dots holder
		$dots_holder = ( $dots == "true" ) ? sprintf('
				<div id="%1$s-dots" class="dots-holder">
				</div>
			', $id) : "";


		//boxed carousel
		$class .= ( $boxed == "true" ) ? " boxed" : "";

		//lightbox
		$class .= ( $lightbox == "true" ) ? " rt_lightbox_gallery" : "";

		//thumbnail navigation
		$thumbnail_navigation_holder = "";
		if ( $thumb_nav == "true" && count( $thumbnails ) > 1 ) {
			
			$thumbnails_output = "";

			$i = 1;
			foreach ( $thumbnails as $thumbnail_url ) {
				$thumbnails_output .= sprintf('<a class="url" href="#%s-%s"><img src="%s" /></a>', $id, $i, $thumbnail_url);
				$i++;
			}

			$thumbnail_navigation_holder = sprintf('
					<div id="%1$s-thumbnails" class="thumbnail-navigation-holder">
						%2$s
					</div>
				', $id, $thumbnails_output ) ;
		} 

		//create final output
		$output = sprintf('
				<div id="%1$s" class="rt-carousel carousel-holder %2$s" data-item-width="%4$s" data-nav="%5$s" data-dots="%6$s" data-margin="%8$s" data-autoplay="%9$s" data-timeout="%10$s" data-thumbnails="%12$s" data-boxed="%13$s" data-min-height="%14$s">
					<div class="owl-carousel">
						%3$s
					</div>
					%7$s
					%11$s
				</div>
			', $id, trim($class), $contents_output, $item_width, $nav, $dots, $dots_holder, $margin, $autoplay, $timeout, $thumbnail_navigation_holder, $thumb_nav, $boxed, $min_height ); 		
  
		return $output;
	}
}

if( ! function_exists("rtframework_create_photo_gallery") ){
	/**
	 * Create photo gallery 
	 * by using provided image urls as an array
	 * 
	 * @param  array $atts 
	 * @return output
	 */
	function rtframework_create_photo_gallery( $atts ){

		//defaults
		extract(shortcode_atts(array(  
			"gallery_id"  => 'gallery-'.rand(100000, 1000000),   
			"crop" => false, 	   
			"h"	 => "",
			"image_urls" => array(),
			"image_ids" => array(),
			"lightbox" => false,
			"captions" => true,
			"item_width" => "1/6",
			"layout_style" => "grid"
		), $atts));

		//item width percentage
		$item_width = ! empty( $item_width ) ? $item_width : "1/3";

		//image array
		$image_array = ! empty( $image_urls ) ? $image_urls : $image_ids ;

		//create values
		$items_output = $caption_output = $lightbox_link = $image_effect = ""; 

		// Thumbnail width & height
		$w = rtframework_get_min_resize_size( $item_width );
		
		if( empty( $h ) ){
			$h = $crop ? $w / 1.5 : 10000;	
		}

		//layout style
		$add_holder_class = $item_width == "1/1" ? "" : ( $layout_style == "grid" ? " border_grid fixed_heights" : " masonry" ) ;

		//add column class
		$add_column_class = rtframework_column_class( $item_width );
		$add_column_class .= $layout_style == "masonry" ? " isotope-item" : "";
		
		//row count
		$column_count = rtframework_column_count( $item_width );

		//item counter
		$counter = 1;

		foreach ($image_array as $image) { 								 
 
			// Resize Image
			$image_data = is_numeric( $image ) ? rtframework_get_image_data( array( "image_id" => trim($image), "w" => $w, "h" => $h, "crop" => $crop )) : rtframework_get_image_data( array( "image_url" => trim($image), "w" => $w, "h" => $h, "crop" => $crop ) ); 	


			//create image html output
			if( $lightbox ){

				$image_output = rtframework_create_lightbox_link(
					array(
						'class' => 'rt_lightbox zoom imgeffect',
						'href' => $image_data["image_url"],
						'title' => esc_html__('Enlarge Image','naturalife'),
						'data_group' => $gallery_id,
						'data_title' => $image_data["image_title"],
						'data_description' => $image_data["image_caption"],
						'data_thumbnail' => $image_data["lightbox_thumbnail"],
						'echo' => false,
						'inner_content' => sprintf('<img src="%s" alt="%s">',$image_data["thumbnail_url"], $image_data["image_alternative_text"])
					)
				);

			}else{

				$image_output = sprintf('<img src="%s" alt="%s">',$image_data["thumbnail_url"], $image_data["image_alternative_text"] );

			}


			//create caption
			$caption_output = $captions && ! empty( $image_data["image_caption"] ) ? sprintf('
				<p class="gallery-caption-text">%s</p>
			', $image_data["image_caption"] ) : "";
		

			//open row block
			if(  $layout_style != "masonry" && $item_width != "1/1" && ( $counter % $column_count == 1 || $column_count == 1 ) ){
				$items_output .= '<div class="row">'."\n";
			}	

				//list items output
				$items_output .= sprintf('
					<div class="col %s">
						%s
						%s 	
					</div>
				', $add_column_class, $image_output, $caption_output);


			//close row block
			if( $layout_style != "masonry" && $item_width != "1/1" && ( $counter % $column_count == 0 || count($image_array) == $counter ) ){
				$items_output .= '</div>'."\n";  
			}

		$counter++;
		}

		//the gallery holder output
		$gallery_holder_output = sprintf('
			<div class="photo_gallery rt_lightbox_gallery %s" id="%s" data-column-width="%s">%s</div> 
		',$add_holder_class, $gallery_id, $column_count, $items_output ); 

		echo $gallery_holder_output; 
	}
}
add_action( "rtframework_create_photo_gallery", "rtframework_create_photo_gallery", 10, 1 );

if( ! function_exists("rtframework_ajax_loader") ){
	/**
	 * Load ajax posts
	 *
	 * @since 1.0
	 * 
	 * @param  array $atts 
	 * @return output
	 */

	function rtframework_ajax_loader( $atts = array() )
	{

		$atts = sanitize_text_field($_POST["atts"]);

		//create array from atts $key*$value|$key*$value
		$new_atts = array();
		foreach (explode("|",$atts) as $value) {
			$values = explode("*", $value);
			$new_atts[$values[0]] = isset( $values[1] ) ? $values[1] : "";
		}

		$page = sanitize_text_field( $_POST["page"] );
		$new_atts["paged"] = $page;
		$new_atts["wpml_lang"] = $_POST["wpml_lang"];

		//current lang
		if( isset( $_POST["wpml_lang"] ) && ! empty( $_POST["wpml_lang"] ) ){
			global $sitepress;
			$sitepress->switch_lang( sanitize_text_field($_POST['wpml_lang']), true);
			load_theme_textdomain('naturalife', get_template_directory().'/languages' );
		}

		//conditional contens
		if( $new_atts["purpose"] == "portfolio" ){
			echo rt_portfolio_post_loop( array(), $new_atts );	 								
		}else{
			echo rtframework_blog_post_loop( array(), $new_atts ); 
		}
		
		die();
	}
}
add_action( 'wp_ajax_rtframework_ajax_loader', 'rtframework_ajax_loader' );
add_action( 'wp_ajax_nopriv_rtframework_ajax_loader', 'rtframework_ajax_loader' );

if( ! function_exists("rtframework_get_ajax_loader_button") ){
	/**
	 * Get ajax load more button
	 *
	 * @since 1.0
	 * 
	 * @param  array $atts 
	 * @return output
	 */

	function rtframework_get_ajax_loader_button( $atts = array(), $page_count = 0 )
	{
		$serialized_atts = "";
		$i = 1;
		$size = count($atts);
		foreach ($atts as $key => $value) {
			$serialized_atts .= $key."*".$value;
			$serialized_atts .= $size !== $i ? "|" : ""; 	
 			$i++;
		}

		printf('<button href="#" class="load_more button_ medium color aligncenter" autocomplete="off" data-atts="%1$s" data-page_count="%2$s" data-current_page="%3$s" data-listid="%5$s"><span class="icon-angle-double-down"></span>%4$s</button>',
				$serialized_atts,
				$page_count,
				1,
				esc_html__("LOAD MORE","naturalife"),
				$atts["id"]
			);
	}
}

if( ! function_exists("rtframework_create_product_image_slider") ){
	/**
	 * Create slider for product images
	 *
	 * @since 1.0
	 * 
	 * @param  array $rt_gallery_images  
	 * @param  string $id  
	 * @return output html
	 */
	function rtframework_create_product_image_slider( $rt_gallery_images = array(), $id = "", $itemprop=true, $column_width = 12 ){

		//slider id
		$slider_id = "slider-".$id;

		//image dimensions for product image slider
		$w = rtframework_get_min_resize_size( $column_width );

		//itemprop
		$itemprop = ' itemprop="image"'; 

		//create slides and thumbnails outputs
		$output  = array();


		foreach ($rt_gallery_images as $image) { 								 

			// Resize Image
			$image_output = is_numeric( $image ) ? rtframework_get_image_data( array( "image_id" => trim($image), "w" => $w, "h" => 1000, "crop" => "" )) : rtframework_get_image_data( array( "image_url" => trim($image), "w" => $w, "h" => 1000, "crop" => "" ) ); 	
	 
			//create lightbox link
			$lightbox_link = rtframework_create_lightbox_link(
				array(
					'class'            => 'icon-zoom-in single lightbox_',
					'href'             => $image,
					'title'            => esc_html__('Enlarge Image','naturalife'),
					'data_group'       => 'group_product_slider',
					'data_title'       => $image_output["image_title"],
					'data_description' => $image_output["image_caption"],
					'data_thumbnail'   => $image_output["thumbnail_url"],
					'echo'             => false
				)
			);

			$output[] .= sprintf('					 
				<div class="imgeffect">								
					%1$s
					<img src="%2$s" alt="%3$s"%4$s>
				</div>  
			',$lightbox_link, $image_output["thumbnail_url"], $image_output["image_alternative_text"], $itemprop );
 
		}
   
		//slider atts
		$atts = array(  
			"id"  => "product-image-carosel", 
			"item_width"  => 1, 
			"class" => "product-image-carosel",
			"nav" => "true",
			"dots" => "false"
		);

		//create slider
		echo rtframework_create_carousel( $output, $atts );

	}
}
add_action( "rt_product_image_slider", "rtframework_create_product_image_slider", 10, 3 );

if( ! function_exists("rtframework_create_image_carousel") ){
	/**
	 * Create a carousel from the provided images
	 *
	 * @since 1.0
	 * 
	 * @param  array $rt_gallery_images  
	 * @param  string $id  
	 * @return output html
	 */
	function rtframework_create_image_carousel( $atts = array() ){

		//defaults
		extract(shortcode_atts(array(  
			"id"  => 'carousel-'.rand(100000, 1000000),   
			"crop" => false, 	   
			"h" => 10000,
			"w" =>  10000,
			"rt_gallery_images" => array(),
			"column_width" => "1/1",
			"carousel_atts" => array(),
			"echo" => true,
			"lightbox" => "true",
			"itemprop" => false,
			"captions" => false
		), $atts));

		//slider id
		$slider_id = "slider-".$id; 

		//itemprop
		$itemprop = $itemprop ? ' itemprop="image"' : ""; 

		//crop
		$crop = ($crop === "false") ? false : $crop;	

		//image dimensions for product image slider
		$w = empty( $w ) ? rtframework_get_min_resize_size( $column_width ) : $w;
		
		//height		
		if( empty( $h ) ){
			$h = $crop ? $w / 1.5 : 10000;	
		}

		//create slides and thumbnails outputs
		$output  = array();

		//thumbnails output
		$thumbnails  = array();


		foreach ($rt_gallery_images as $image) { 								 

			// Resize Image
			$image_output = is_numeric( $image ) ? rtframework_get_image_data( array( "image_id" => trim($image), "w" => $w, "h" => $h, "crop" => $crop )) : rtframework_get_image_data( array( "image_url" => trim($image), "w" => $w, "h" => $h, "crop" => $crop ) ); 	

			//thumbnails
			$thumbnails[] = $image_output["lightbox_thumbnail"];

			$create_outout = "";
			if( $lightbox != "false" ){
				
				//create lightbox link
				$create_outout .= rtframework_create_lightbox_link(
					array(
						'class'            => 'imgeffect zoom rt_lightbox',
						'href'             => $image_output["image_url"],
						'title'            => esc_html__('Enlarge Image','naturalife'),
						'data_group'       => $slider_id,
						'data_title'       => $image_output["image_title"],
						'data_description' => $image_output["image_caption"],
						'data_thumbnail'   => $image_output["lightbox_thumbnail"],
						'echo'             => false,
						'inner_content'    => sprintf('<img src="%s" alt="%s"%s>',$image_output["thumbnail_url"], $image_output["image_alternative_text"], $itemprop )
					)
				);

			}else{
				$create_outout .= sprintf('<img src="%s" alt="%s"%s>',$image_output["thumbnail_url"], $image_output["image_alternative_text"], $itemprop );
			}
			
			$create_outout .= $captions && ! empty( $image_output["image_caption"] ) ? '<span class="caption">'.$image_output["image_caption"].'</span>' : "";				
			$output[] = $create_outout;

		}

		//create slider
		if($echo){
			echo rtframework_create_carousel( $output, $carousel_atts, $thumbnails );
		}else{
			return rtframework_create_carousel( $output, $carousel_atts, $thumbnails );
		}

	}
}
add_action( "rtframework_create_image_carousel", "rtframework_create_image_carousel", 10, 1 );


if( ! function_exists("rtframework_create_bg_image_carousel") ){
	/**
	 * Create a carousel from the provided images
	 * display the images as background image 
	 *
	 * @since 1.0
	 * 
	 * @param  array $rt_gallery_images  
	 * @param  string $id  
	 * @return output html
	 */
	function rtframework_create_bg_image_carousel( $atts = array() ){

		//defaults
		extract(shortcode_atts(array(   
			"crop" => false, 	   
			"h" => 10000,
			"w" =>  10000,
			"rt_gallery_images" => array(),
			"column_width" => "",
			"carousel_atts" => array(),
			"echo" => true,
			"lightbox" => "true", 
			"captions" => false,
			"min_height" => 500
		), $atts));


 		//group id
 		$group_id =  isset( $carousel_atts["id"] ) ? $carousel_atts["id"] : "";
 		
		//crop
		$crop = ($crop === "false") ? false : $crop;	

		//image dimensions for product image slider
		$w = ! empty( $column_width ) ? rtframework_get_min_resize_size( $column_width ) : $w;

		//height		
		if( empty( $h ) ){
			$h = $crop ? $w / 1.5 : 10000;	
		}

		//create slides and thumbnails outputs
		$output  = array();

		//thumbnails output
		$thumbnails  = array();


		foreach ($rt_gallery_images as $image) { 								 

			// Resize Image
			$image_output = is_numeric( $image ) ? rtframework_get_image_data( array( "image_id" => trim($image), "w" => $w, "h" => $h, "crop" => $crop )) : rtframework_get_image_data( array( "image_url" => trim($image), "w" => $w, "h" => $h, "crop" => $crop ) ); 	

			//thumbnails
			$thumbnails[] = $image_output["lightbox_thumbnail"];

			$create_outout = "";
			if( $lightbox != "false" ){
				
				//create lightbox link
				$create_outout .= rtframework_create_lightbox_link(
					array(
						'class'            => 'imgeffect zoom',
						'href'             => $image_output["image_url"],
						'title'            => esc_html__('Enlarge Image','naturalife'),
						'data_group'       => $group_id,
						'data_title'       => $image_output["image_title"],
						'data_description' => $image_output["image_caption"],
						'data_thumbnail'   => $image_output["lightbox_thumbnail"],
						'echo'             => false,
						'inner_content'    => sprintf('<div class="has-bg-image" style="background-image:url(%1$s);min-height:%2$spx;background-position:center;background-size:cover"></div>',$image_output["thumbnail_url"], $min_height )
					)
				);
			
			}else{
				$create_outout .= sprintf('<div class="has-bg-image" style="background-image:url(%1$s);min-height:%2$spx;background-position:center;background-size:cover"></div>',$image_output["thumbnail_url"] , $min_height);
			}
 			
			$create_outout .= $captions && ! empty( $image_output["image_caption"] ) ? '<span class="caption">'.$image_output["image_caption"].'</span>' : "";				
			$output[] = $create_outout;

		}

		//pass lightbox paramater to caraousel atts
		$carousel_atts["lightbox"] = $lightbox;

		//create slider
		if($echo){
			echo rtframework_create_carousel( $output, $carousel_atts, $thumbnails );
		}else{
			return rtframework_create_carousel( $output, $carousel_atts, $thumbnails );
		}

	}
}
add_action( "rtframework_create_bg_image_carousel", "rtframework_create_bg_image_carousel", 10, 1 );

if( ! function_exists("rtframework_get_global_value") ){
	/**
	 * Retrives a global value
	 * 
	 * @return output
	 */
	function rtframework_get_global_value( $var ){
		global $$var;
		return $$var;
	}
}

if( ! function_exists("rtframework_social_media_share") ){
	/**
	 * Social Media Share Function
	 * 
	 * @global class $post 
	 * 
	 * @param  array $atts
	 * @param  string $content
	 * @return string $output
	 */
	function rtframework_social_media_share( $atts = array(), $content = null ) {
	 		
		//defaults
		extract(shortcode_atts(array(  
			"postid"  => ''
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
							'<a class="icon-'.$value["icon_name"].' " href="#" data-url="'. $value["url"] .'" title="'. $key .'">':
							'<a class="icon-'.$value["icon_name"].' " href="'. $value["url"] .'" title="'. $key .'">';			
				$output .= '<span>'. $key .'</span>';

				$output .= '</a>';
				$output .= '</li>';
		}

		return '<span class="social_share icon-line-share"><ul>'.$output.'</ul></span>';
	}
}

if( ! function_exists("rtframework_create_html_list") ){
	/**
	 * Converts a multi-line string into an html list
	 * Removes empty lines
	 * Removes spaces before and after the line
	 * 
	 * @return output
	 */
	function rtframework_create_html_list( $string="" , $class="" ){ 

		$class = ! empty( $class ) ? 'class="'.$class.'"' : "";

		$re = "/\\n?(.*)/"; 
		$all_features_list = preg_replace_callback(
			$re,
			function ($matches) {
				$line = trim($matches[0]);
					if ( ! empty( $line ) ) {
						return "<li>{$line}</li>";
					}            
				},
			$string
		);

		return sprintf('<ul%1$s>%2$s</ul>',$class,$all_features_list);

	}
}	
add_action("rtframework_after_body","rtframework_create_html_list");

if( ! function_exists("rtframework_check_unit") ){
	/**
	 * Checks the value for px or % and adds px if there is none
	 * @return output
	 */
	function rtframework_check_unit(  $number ){ 

		$check = preg_match("/(px)|(\\%)/",$number,$result);
		
		if( count( $result ) === 0 ){
			$number = $number. "px";
		}

		return esc_attr( $number );

	}
}	
add_action("rtframework_after_navigation","rtframework_check_unit",20);



#-----------------------------------------
#	RT-Theme wpml_functions.php 
#-----------------------------------------


if( ! function_exists("rtframework_wpml_get_current_language") ){
	/**
	 * rtframework_wpml_get_current_language
	 * @return string language
	 */
	function rtframework_wpml_get_current_language(){
		return apply_filters( 'wpml_current_language', NULL );
	}
}


#
# WPML match page id 
# returns the page of default language
# @returns $id 
#
if( ! function_exists("rtframework_wpml_page_id") ){
	function rtframework_wpml_page_id($id){	 
		$default_language = apply_filters( 'wpml_default_language', null );
		return apply_filters( 'wpml_object_id', $id, 'page', true, $default_language);
	}
}

#
# WPML match page id 
# returns the current language version of the page
# @returns $id 
#
if( ! function_exists("rtframework_wpml_translated_page_id") ){
	function rtframework_wpml_translated_page_id($id){	 
		return apply_filters( 'wpml_object_id', $id, 'page' );
	}
}


#
# WPML match post id
#
if( ! function_exists("rtframework_wpml_post_id") ){
	function rtframework_wpml_post_id($id){
		global $post;
		$default_language = apply_filters( 'wpml_default_language', null );
		$post_type = isset( $post->post_type ) ? $post->post_type : 'post';

		return apply_filters( 'wpml_object_id', $id, $post_type, true, $default_language);
	}
}

#
# WPML match category id
#
if( ! function_exists("rtframework_wpml_category_id") ){
	function rtframework_wpml_category_id($id){
		$default_language = apply_filters( 'wpml_default_language', null );
		return apply_filters( 'wpml_object_id', $id, 'category', true, $default_language);
	}
}

#
# WPML match portfolio category id
#
if( ! function_exists("rtframework_wpml_portfolio_category_id") ){
	function rtframework_wpml_portfolio_category_id($id){
		$default_language = apply_filters( 'wpml_default_language', null );
		return apply_filters( 'wpml_object_id', $id, 'portfolio_categories', true, $default_language);
	}
}


#
# WPML match categories
#
if( ! function_exists("rtframework_wpml_lang_object_ids") ){
	function rtframework_wpml_lang_object_ids($ids_array = array(), $type = "", $language = "") {
		if(function_exists('icl_object_id')) {
			global $sitepress;
			 
			if( empty( $language ) ){
				$language = apply_filters( 'wpml_default_language', null );
			}

			//if provided ids is an array
			if( is_array( $ids_array ) ){
				$res = array();
				foreach ($ids_array as $id) {
					$xlat = apply_filters( 'wpml_object_id', $id, $type, false, $language);
					if(!is_null($xlat)) $res[] = $xlat;
				}
				return $res;				
			}else{

				$res = array();
				$ids_array = explode(",", $ids_array); 

				foreach ($ids_array as $id) {
					$xlat = apply_filters( 'wpml_object_id', $id, $type, false, $language);
					if(!is_null($xlat)) $res[] = $xlat;
				}

				return implode($res, ",");				
			}

		} else {
			return $ids_array;
		}
	}
}

#
# Get WPML Plugin Flags
#
if( ! function_exists("rtframework_wpml_languages_list") ){
	function rtframework_wpml_languages_list( $flags = false ){

		if( ! function_exists('icl_get_languages')) {
			return;
		}
				
	    $languages = icl_get_languages('skip_missing=0&orderby=code'); 

		if(!empty($languages)){
			
				echo '<ul class="naturalife-flags">';
				foreach($languages as $l){

					echo '<li>';
					if($l['country_flag_url']){
						if($flags){
							echo '<img src="'.$l['country_flag_url'].'" height="12" alt="'.$l['native_name'].'" width="18" />';	
						}
						echo '<a href="'.$l['url'].'" title="'.$l['native_name'].'"><span>'.$l['native_name'].'</span></a>';
					}
					echo '</li>';
				}
			echo '</ul>';
		}

	}
}


#
#	WPML Home URL
#
if( ! function_exists("rtframework_wpml_get_home_url") ){
	function rtframework_wpml_get_home_url(){
		$home_url = apply_filters( 'wpml_home_url', home_url() );
		return rtrim( $home_url, '/') . '/';		
	}
}

#
#	WPML String Register
#
if( ! function_exists("rtframework_wpml_register_string") ){
	function rtframework_wpml_register_string($context, $name, $value){
		if ( trim( $value ) ){
			do_action( 'wpml_register_single_string', $context, $name, $value );
		}  
	}
}

#
#	WPML Get Registered String

if( ! function_exists("rtframework_wpml_t") ){
	/**
	 * Get string translation of a theme mod value
	 * @return string 
	 */
	function rtframework_wpml_t($name="", $field="", $value=""){
		if(function_exists('icl_translate')) {			
			return apply_filters( 'wpml_translate_single_string', $value, $field, $name );
		}

		return $value;
	}
}



global $rtframework_social_media_icons;
$rtframework_social_media_icons = array();
?>