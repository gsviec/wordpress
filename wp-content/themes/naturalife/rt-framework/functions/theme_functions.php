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
if( ! function_exists("rtframework_settings") ){
	/**
	 * Get Theme Settings
	 * 
	 * @global array $rttheme_settings
	 * 
	 * @global string $rtframework_taxonomy
	 * @global string $rtframework_post_type
	 * @global object $post
	 * @global object $wp_query
	 */
	function rtframework_settings(){ 
		global $rtframework_settings, $rtframework_taxonomy, $rtframework_post_type;
		
		//loaded before
		if(isset( $rtframework_settings["loaded"] )){
			return;
		}

		//get queried object
		$query_object = get_queried_object(); 

		//get taxomony name
		$rtframework_taxonomy = isset( $query_object->taxonomy ) ? $query_object->taxonomy : "";

		//get taxomony name
		$rtframework_post_type = get_post_type(); 
																	 
		//All theme settings
		if( empty( $rtframework_settings ) ){		
			$rtframework_settings = rtframework_get_settings();
		}		

		/**
		 * additional mods and controls
		 */

		//sidebars
		if( $rtframework_taxonomy == "category" ){
			$rtframework_settings['sidebar_position'] = $rtframework_settings['sidebar_blog_cats'];
		}

		if( $rtframework_taxonomy == "portfolio_categories" ){
			$rtframework_settings['sidebar_position'] = $rtframework_settings['sidebar_portfolio_cats'];
		}  

		//check if shop start page
		if ( class_exists( 'Woocommerce' ) ) {
			if( $rtframework_taxonomy == "product_cat" || $rtframework_taxonomy == "product_tag" ){
				$rtframework_settings['sidebar_position'] = $rtframework_settings['sidebar_woo_cats'];
			}
		}  		

		//single blog post default sidebar position 
		if( is_singular() && $rtframework_post_type == "post" && empty( $rtframework_settings['single_page_sidebar'] ) ){
			$rtframework_settings['sidebar_position'] = isset( $rtframework_settings['sidebar_blog_single'] ) ? $rtframework_settings['sidebar_blog_single'] : "right";
		}  

		//set a default sidebar position
		$rtframework_settings['sidebar_position'] = empty( $rtframework_settings['sidebar_position'] ) ? "fullwidth" : $rtframework_settings['sidebar_position'];
		$rtframework_settings['sidebar_position'] = apply_filters( "rtframework_sidebar_position", $rtframework_settings['sidebar_position']  );

		//heading tag
		$rtframework_settings["heading_tag"] = apply_filters("rtframework_heaading_tag", $rtframework_settings["hide_page_title"] ? "h1" : "h2" );	
		
		//content holder width 	[ doesn't change widths for the theme, adds only fullwidth class for the parent content rows ]
		$rtframework_settings["default_content_row_width"] = apply_filters("rtframework_default_content_row_width", "fullwidth"); 
	
		//content wrapper width		
		$rtframework_settings["default_content_wrapper_width"] = apply_filters("rtframework_default_content_wrapper_width", $rtframework_settings['default_content_wrapper_width'] );
												
		//start pages
		$rtframework_settings['rt_blogpage'] = rtframework_wpml_page_id($rtframework_settings['blog_page']);
		$rtframework_settings['rt_portfoliopage'] = rtframework_wpml_page_id($rtframework_settings['portfolio_page']);
		$rtframework_settings['rt_staffpage'] = rtframework_wpml_page_id($rtframework_settings['staff_page']);
		$rtframework_settings['rt_shopstartpage'] = rtframework_wpml_page_id($rtframework_settings['shop_start_page']);

		//content widhts - used for only image resizing
		$rtframework_settings["content_full_width"] = apply_filters("rtframework_content_full_width", RT_CONTENT_FULL_WIDTH);
		$rtframework_settings["content_sidebar_width"] = apply_filters("rtframework_content_sidebar_width", RT_CONTENT_SIDEBAR_WIDTH);					

		//template settings check
		$rtframework_settings["loaded"] = true;
	}
}
add_action( 'template_redirect', 'rtframework_settings', 10 );
add_action( 'elementor/widgets/widgets_registered', 'rtframework_settings', 10 );
add_action( 'wp_ajax_rtframework_ajax_loader', 'rtframework_settings', 0 );



if( ! function_exists("rtframework_get_settings") ){
	/**
	 * 
	 * Get Theme Settings
	 * 
	 * @global object $post
	 * @global object $wp_customize
	 * @return array
	 * 
	 */	
	function rtframework_get_settings( $function_call = false ){
		global $post, $wp_customize;
		
		//check if it is a WPML translation page
		$post_id = ( isset( $post ) && is_singular() ) || ( isset( $post ) && is_admin() ) ? rtframework_wpml_translated_page_id( $post->ID ) : "";

		//check if shop start page
		$woocommerce_start_page = false;
		if ( class_exists( 'Woocommerce' ) ) {
			//if shop base page set - use the page design options of the base page
			if( is_shop() ){
				$shop_page_id = get_option( 'woocommerce_shop_page_id' );
				if( ! empty( $shop_page_id ) ){
					$post_id = rtframework_wpml_translated_page_id($shop_page_id);
					$woocommerce_start_page = true;
				}
			}
		}  		  

		//variables that effects the stored dynamic css output
		$styling_variables = array(
			"header_style",
			"header_height_first",
			"header_height_second",
			"header_height_single",
			"header_vertical_padding",
			"header_bg_color",
			"sticky_header_bg_color",  		
			"sub_header_font_color",
			"sub_header_top_padding",
			"sub_header_bottom_padding",
			"breadcrumb_font_color",
			"breadcrumb_link_color",
			"breadcrumb_font_color",
			"breadcrumb_link_color",
			"breadcrumb_bg_color",
			"body_background_image",
			"body_background_position",
			"body_background_attachment",
			"body_background_repeat",
			"body_background_size",
			"body_background_color"			
		);

		//additional variables to add 
		$additional_variables = array( 
			"custom_sidebar_locations" => "", 
			"custom_main_menu" => "",
			"header_first_row_widgets_1" => "",
			"header_first_row_widgets_2" => "",
			"header_second_row_widgets_1" => "",
			"header_second_row_widgets_2" => "",	
			"header_first_row_custom_widgets_1" => "",
			"header_first_row_custom_widgets_2" => "",
			"header_second_row_custom_widgets_1" => "",
			"header_second_row_custom_widgets_2" => ""
		);

		//functionality variables - that doesn't effect the design & css output
		$functionality_variables = array(
			"custom_main_menu",
			"display_main_menu",
			"sidebar_position",
			"custom_sidebar_locations",
			"hide_sub_header",
			"hide_page_title",
			"hide_breadcrumb_menu"
		);

		//theme design options
		$theme_options = array();

		//get page design options - page meta 
		$page_design_options = $post_id ? get_post_meta( $post_id, "rttheme_design_options", true ) : "";		
		$page_design_options = is_array( $page_design_options ) ? $page_design_options : array();	

		//is preview?
		if( is_preview() && $post_id ){
			$page_design_preview_options = get_post_meta( $post_id, "rttheme_design_preview_options", true );
			$page_design_options = is_array( $page_design_preview_options ) && ! empty( $page_design_preview_options ) ? $page_design_preview_options : $page_design_options ;	
		}
		
		//get teheme mods
		$theme_mods = get_theme_mods();

		//add additional variables to match
		$theme_mods = array_merge($theme_mods, $additional_variables);
		
		//standalone css file
		//true = the page/post needs to have its own dynamic css file
		$standalone_css = false;

		//different design 
		//true = at least one page design option is different than the global value
		//excluding the 
		$different_design = false;

		
		//check if this is a post/page and singlular or called manually or wp_customize active
		if( is_singular() || $function_call || $wp_customize || $woocommerce_start_page ){

				// get all theme mods and collect them in the $theme_options array
				// & compare values with the page design options 
				foreach ($theme_mods as $mod => $mod_value) {
					
					//mod value - when customizer window is active get the unsaved one with get_theme_mod
					$mod_value = $wp_customize ? get_theme_mod( $mod ) : $mod_value;

					//remove the theme slug name from the key
					$theme_option_key = str_replace("naturalife_", "", $mod);					
						
					//check if the value exists inside the page design options			 
					if ( array_key_exists( $theme_option_key, $page_design_options ) ){
						

						if( $page_design_options[ $theme_option_key ] != "" && $page_design_options[ $theme_option_key ] !== $mod_value ){
 	
							// the value different in the page design options
							$theme_options[ $theme_option_key ] = $page_design_options[ $theme_option_key ];

							//check if the changed variable is one of the $styling_variables
							if( in_array( $theme_option_key, $styling_variables) ){
								$standalone_css = true;
							}	 

							//design is different than global
							if( ! in_array( $theme_option_key, $functionality_variables) ){
								$different_design = true;
							}

						}else{
							//value not changed or it was empty
							$theme_options[ $theme_option_key ] = $mod_value;
						}

					}else{
						//value not exists in the page design options
						$theme_options[ $theme_option_key ] = $mod_value;
					}
				}		 	

				//add page design options which has no pair in the customizer settings
				foreach ( array_diff_key ( $page_design_options, $theme_options )  as $pd_key => $pd_value) {
					$theme_options[ $pd_key ] = $page_design_options[ $pd_key ];
				}

		}else{
			// no need to need to compare theme 
			// copy all mods to the $theme_options
			// by removing the theme slug name
			
			$theme_options = $theme_mods;
			$theme_options = array_combine(
			array_map(function($mod)
				{
					return str_replace("naturalife_", "", $mod);
				}, array_keys($theme_options)), array_values($theme_options)
			);
		}

		//single page meta sidebar to be compared with defaults
		$theme_options["single_page_sidebar"] = is_singular() && isset( $page_design_options["sidebar_position"] ) ? $page_design_options["sidebar_position"] : "";

		//different dynamic css output
		$theme_options["different_css_output"] = $standalone_css;

		//different design
		$theme_options["different_design"] = $different_design;	 

		//apply filters
		$theme_options = apply_filters("rtframework_settings", $theme_options );

		//return theme_options
		return $theme_options;

	}
}


if( ! function_exists("rtframework_get_setting") ){
	/**
	 * 
	 * Get Single Setting
	 * 
	 * @global object $rtframework_get_settings
	 * @return string|array
	 * 
	 */
	function rtframework_get_setting( $mod_name = "", $default = ""  ){
		global $rtframework_settings;

		//remove the theme slugnama from the key
		$mod_name = str_replace("naturalife_", "", $mod_name);

		//get settings if it has not beed created before
		$rtframework_settings = ! isset( $rtframework_settings ) ? rtframework_get_settings() : $rtframework_settings;

		//return
		if( isset( $rtframework_settings[$mod_name] ) ){
			
			if( $rtframework_settings[$mod_name] === "false" ){
				return false;
			}else{
				return $rtframework_settings[$mod_name];
			}
				
		}else{
			if( ! empty( $default ) ){
				return $default;
			}  

			return false;
		}

	}
}

if( ! function_exists("rtframework_control_theme_version") ){
	/**
	 * 
	 * Checks the stored theme version and compares with the current version
	 * if the theme updated runs an action
	 * 
	 * @return bool
	 */
	function rtframework_control_theme_version(){

		//latest stored theme version
		$latest_stored_theme_version = get_option( "naturalife_stored_theme_verion" );

		//get current theme data
		$theme_data = rtframework_get_theme();

		if( $theme_data["Version"] != $latest_stored_theme_version ){

			//store the new version
			update_option( "naturalife_stored_theme_verion" , $theme_data["Version"] );			

			//run action
			do_action("rtframework_theme_updated", $latest_stored_theme_version, $theme_data["Version"]);

			return true;
		}

		return false;
	}
}
add_action( 'init' , 'rtframework_control_theme_version' ); 


if( ! function_exists("rtframework_footer_output_function") ){
	/**
	 * Footer output
	 * @return html
	 */
	function rtframework_footer_output_function(){ 

		echo '<div class="footer-contents">';

		//column count
		$column_count = rtframework_get_setting("footer_column_count"); 

		//featured column
		$featured_column = rtframework_get_setting('footer_featured');

		if( rtframework_get_setting("display_footer_widgets") ){
 
			echo '<section class="footer-widgets content-row footer footer_contents fullwidth"><div class="content-row-wrapper row '.esc_attr(rtframework_get_setting("footer_width")).'">'."\n";
			
				do_action( "rtframework_before_footer_widgets" );

					if (function_exists('dynamic_sidebar')){

						for( $i = 1; $i <= $column_count; $i++ ){

							$column_class = rtframework_column_class( rtframework_get_setting("footer_col_".$i), "lg");
							$column_class .= " ".rtframework_column_class( rtframework_get_setting("footer_col_".$i.'_m'), "sm");
							$column_class .= $i == 1 && $featured_column ? " featured-col" : "";
						
							echo "\t".'<div id="footer-column-'.$i.'" class="col col-12 '.$column_class.' widgets_holder">'."\n";
								echo "\t\t".'<div class="column-inner">'."\n";
									dynamic_sidebar('naturalife-sidebar-for-footer-column-'.$i);  
								echo "\t\t".'</div>'."\n";
							echo "\t".'</div>'."\n";
						}
					} 
				
				do_action( "rtframework_after_footer_widgets" );
			echo '</div></section>'."\n";		
		}

		//footer navigation
		if ( has_nav_menu( 'naturalife-footer-navigation' ) ){ // check if user created a custom menu and assinged to the rt-theme's location

			$footer_menu_vars = array(
				'menu_id'        => "footer-navigation",
				'container'      => 'div',
				'container_class' => apply_filters("footer-navigation-class", "footer-navigation-container" ),
				'echo'           => false,
				'theme_location' => 'naturalife-footer-navigation',
				'fallback_cb'    => false,
				'depth'          => 1,
			);
			
			$footer_menu=wp_nav_menu($footer_menu_vars);

		}else{
			
			$footer_menu_vars = array(
				'menu'           => 'Footer Navigation',  
				'menu_id'        => "footer-navigation",
				'container'      => 'div',
				'container_class' => apply_filters("footer-navigation-class", "footer-navigation-container" ),
				'echo'           => false,
				'theme_location' => 'naturalife-footer-navigation',
				'fallback_cb'    => false,
				'depth'          => 1,
			);
			
			$footer_menu = wp_nav_menu($footer_menu_vars);
		}	
		
		//copyright text
		$copyright = do_shortcode( get_theme_mod('naturalife_copyright') );

		if( ! empty( $copyright ) || ! $footer_menu ){
			echo '<div class="content-row footer_contents footer-info-bar fullwidth"><div class="content-row-wrapper d-lg-flex align-items-center default text-sm-center '.esc_attr(rtframework_get_setting("footer_width")).'">';			
			
					echo '<div class="copyright">'. apply_filters( "rt_footer_copyright_text", wp_kses_post( $copyright ) ) .'</div>';
					
					echo ! empty( $footer_menu ) ? $footer_menu : "";//wp menu output
 
					if ( has_action( "rtframework_footer_bottom_right" ) ){
						echo '<div class="footer-info-right">';
							/**
							 * rtframework_footer_bottom_right hook			
							 * 
							 * @hooked rtframework_display_social_media 
							 * 
							 */
							do_action("rtframework_footer_bottom_right"); 
						echo '</div>';
					}
			echo '</div></div>';
		}

		echo '</div>';

	}
}
add_action( 'rtframework_footer_output', 'rtframework_footer_output_function', 10, 0 ); 

if( ! function_exists("rtframework_display_social_media") ){
	/**
	 * Display social media icons
	 * @return html
	 */
	function rtframework_display_social_media(){
		if( function_exists("rt_social_media")){
			echo rt_social_media();
		}		
	}
}

if( ! function_exists("rtframework_footer_social_media") ){
	/**
	 * Add social media icons to the footer
	 * @return html
	 */
	function rtframework_footer_social_media(){ 
		if( ! rtframework_get_setting("display_social_media") ){
			return;
		}

		add_action( 'rtframework_footer_bottom_right', 'rtframework_display_social_media' );
	}
}
add_action( 'template_redirect', 'rtframework_footer_social_media');


if( ! function_exists("rtframework_comment_form_before_fields") ){
	/**
	 * Add html before comment form fields
	 * @return html
	 */
	function rtframework_comment_form_before_fields(){
		print '<div class="text-boxes"><ul>';
	}
}
add_action( 'comment_form_before_fields', 'rtframework_comment_form_before_fields' );

if( ! function_exists("rtframework_comment_form_after_fields") ){
	/**
	 * Add html after comment form fields
	 * @return html
	 */	
	function rtframework_comment_form_after_fields(){
		print '</ul></div>';
	}
}
add_action( 'comment_form_after_fields', 'rtframework_comment_form_after_fields' );

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
			$video_output = '[audio mp3="'.$file_mp3.'" ogg="'.$file_oga.'"]';
			echo do_shortcode( $video_output );
		}

		//video output
		if( $type == "video" ){
			$video_output = '[video poster="'.$poster.'" mp4="'.$file_mp4.'" webm="'.$file_webm.'" width="1920" height="1080"]';
			echo do_shortcode( $video_output );
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
			"heading_size" => rtframework_get_setting( "heading_tag" ),
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
			"excerpt_length" => "",
			"list_orderby" => "date",
			"list_order" => "DESC",
			"item_per_page"=> 10,
			"categories" => "",
			"ajax" => "false",
			"paged" => 0,
			"wpml_lang" => "",
			"box_style" => "",
			"show_featured_media" => "true"
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
				'orderby'        => esc_attr($list_orderby),
				'order'          => esc_attr($list_order),
				'posts_per_page' => absint($item_per_page),
				'paged'          => absint($paged), 
				'category__in'   => $categories
			);

			$wp_query  = new WP_Query($args); 

		}

		//get page & post counts
		$post_count = $wp_query->post_count;
		$page_count = $wp_query->max_num_pages;

		//item width percentage
		$list_layout = ! empty( $list_layout ) ? $list_layout : "1/3";


		//column class
		switch ($list_layout) {
			case '1/4':
				
				$add_column_class = rtframework_column_class( $list_layout, "lg" ). " col-12 col-sm-6";

				break;

			case '1/3':
				
				$add_column_class = rtframework_column_class( $list_layout, "lg" ). " col-12 col-sm-12";

				break;

			case '1/2':
				
				$add_column_class = rtframework_column_class( $list_layout, "lg" ). " col-12 col-sm-12";

				break;

			default:
				
				$add_column_class = rtframework_column_class( $list_layout );

				break;
		}

		$add_column_class .= $layout_style == "masonry" ? " rt-dynamic" : "";
		$add_column_class .= $list_layout == "1/1" ? " full-width-col" : "";

		//row count
		$column_count = rtframework_column_count( $list_layout );

		//layout style
		$add_holder_class = $list_layout == "1/1" ? "blog_list row" : ( $layout_style == "masonry" ? "blog_list row masonry-gallery" : "blog_list" ) ; 

		//box style
		$box_style = esc_attr( $box_style );

		if ( $wp_query->have_posts() ){ 
			
			//open the wrapper
			echo "\n".'<div id="'.sanitize_html_class($id).'" class="'.trim($add_holder_class).'" data-column-width="'. $column_count .'">'."\n";
 

			//the loop
			while ( $wp_query->have_posts() ) : $wp_query->the_post();


				//get post values
				$rtframework_post_values = rtframework_get_loop_post_values( $wp_query->post, $rtframework_blog_list_atts );
				
				//open row block
				if(  $layout_style != "masonry" && $list_layout != "1/1" && ( $counter % $column_count == 1 || $column_count == 1 ) ){
					echo '<div class="row">'."\n";
				}	

					$post_classes = get_post_class("col blog-loop blog-loop-default {$add_column_class}", get_the_ID() ) ;

					echo '<article id="'.get_the_ID().'" class="'.implode(" ", $post_classes ).'"><div class="'.trim("post-content-wrapper {$box_style}").'">'."\n" ;					

						do_action( "rtframework_before_blog_loop");

						get_template_part( '/post-contents/content', get_post_format() ); 

						do_action( "rtframework_after_blog_loop");

					echo '</div></article>'."\n" ;

						 
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


			//ajax load more button
			$ajax_pagination = $pagination !== "false" ? rtframework_convert_bool( $ajax_pagination ) : "false"; 


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


		if ( rtframework_convert_bool($show_featured_media) != "false" && ! empty( $featured_image_id ) ){

			if( rtframework_convert_bool($featured_image_resize) !== "false"){
				// thumbnail min width
				$w = ! empty( $featured_image_max_width ) ? $featured_image_max_width : rtframework_get_min_resize_size( $list_layout );

				// thumbnail max height
				$h = ! empty( $featured_image_max_height ) ? $featured_image_max_height : 10000;

				// thumbnail output
				$thumbnail_image_output = rtframework_get_resized_image_output( array( "image_url" => "", "image_id" => $featured_image_id, "w" => $w, "h" => $h, "crop" => $featured_image_crop ) ); 	

			}else{
				// thumbnail output
				if( rtframework_get_setting( 'sidebar_position' ) == "left" || rtframework_get_setting( 'sidebar_position' ) == "right" ){
					$thumbnail_image_output = wp_get_attachment_image( $featured_image_id, "rtframework-sidebarwidth" ); 						
				}else{
					$thumbnail_image_output = wp_get_attachment_image( $featured_image_id, "rtframework-fullwidth" ); 											
				}
			}
		}else{
			//dont show image, gallery, media, audio if featured images has been disabled
			$thumbnail_image_output = "";
		}

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
			"slider_images_crop"       => esc_attr(get_post_meta( $post->ID, 'rtthemegallery_images_crop', true)),
			"slider_images_max_height" => intval(esc_attr(get_post_meta( $post->ID, 'rtthemegallery_images_height', true))),
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

		if ( ! empty( $featured_image_id ) ){
			if ( rtframework_convert_bool($featured_image_resize) != "false"){
				// thumbnail min width
				$w = ! empty( $featured_image_max_width ) ? $featured_image_max_width : rtframework_get_min_resize_size( $layout );

				// thumbnail max height
				$h = ! empty( $featured_image_max_height ) ? $featured_image_max_height : 10000;

				//thumbnail output
				$thumbnail_image_output = rtframework_get_resized_image_output( array( "image_url" => "", "image_id" => $featured_image_id, "w" => $w, "h" => $h, "crop" => $featured_image_crop ) ) ; 	

			}else{

				// thumbnail output
				if( rtframework_get_setting( 'sidebar_position' ) == "left" || rtframework_get_setting( 'sidebar_position' ) == "right" ){
					$thumbnail_image_output = wp_get_attachment_image( $featured_image_id, "rtframework-sidebarwidth" ); 						
				}else{
					$thumbnail_image_output = wp_get_attachment_image( $featured_image_id, "rtframework-fullwidth" ); 											
				}

			}
		}else{
			$thumbnail_image_output = "";
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
			"slider_images_max_height" => intval(get_post_meta( $post->ID, 'rtthemegallery_images_height', true)),							
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

if( ! function_exists("rtframework_is_blog_page") ){
	/**
	 * checks theme parts that reserved for blog
	 * @return bool
	 */
	function rtframework_is_blog_page(){

		global $rtframework_taxonomy, $rtframework_post_type, $post; 
	 
		$post_id = is_object( $post ) ? rtframework_wpml_page_id( $post->ID ) : "";

		if( rtframework_get_setting( 'rt_blogpage' ) != "" && $post_id == rtframework_get_setting( 'rt_blogpage' ) ){
			return true;
		}	

		if( $rtframework_taxonomy == "category" || $rtframework_post_type == 'post' ){
			return true;
		}				
	}
}

if( ! function_exists("rtframework_is_portfolio_page") ){
	/**
	 * checks theme parts that reserved for portfolios
	 * @return bool
	 */	
	function rtframework_is_portfolio_page(){
		global $rtframework_taxonomy, $rtframework_post_type, $post; 
	 
		$post_id = is_object( $post ) ? rtframework_wpml_page_id( $post->ID ) : "";


		if( rtframework_get_setting( 'rt_portfoliopage' ) != "" && $post_id == rtframework_get_setting( 'rt_portfoliopage' ) ){
			return true;
		}

		if( $rtframework_taxonomy == "portfolio_categories" || $rtframework_post_type == 'portfolio' ){
			return true;
		}
	}
}


if( ! function_exists("rtframework_body_class_name") ){
	/**
	 * Append body classes
	 * @param array $classes
	 * @return array $classes
	 */
	function rtframework_body_class_name($classes) { 

		// page loading
		$classes[] = get_theme_mod( 'naturalife_page_loading_effect' ) ? "rt-loading rt-loading-active" : ""; 

 		// page transition
		$classes[] = get_theme_mod( 'naturalife_page_transition_effect' ) ? "rt-transition" : ""; 


		// overlapped header
		$classes[] = rtframework_get_setting( "overlapped_header" ) ? "overlapped-header" : ""; 

		//sticky header classes
		if( rtframework_get_setting( "sticky_header" ) ){
		
			$classes[] = "sticky-header" ; 
			
			//sticky header style
			$sticky_header_style = rtframework_get_setting( "sticky_header_style" );
			$classes[] = empty( $sticky_header_style ) ? "sticky-header-style-1" : 'sticky-header-style-'.$sticky_header_style; 
		}

					 
						//sticky logo class
						$sticky_logo = rtframework_get_setting( 'naturalife_sticky_logo_'.rtframework_get_setting( "header_color_skin_sticky" ) );		
						$sticky_logo = empty( $sticky_logo ) && rtframework_get_setting( "header_color_skin" ) != rtframework_get_setting( "header_color_skin_sticky" ) ? rtframework_get_setting( 'naturalife_logo_'.rtframework_get_setting( "header_color_skin_sticky" ) ) : $sticky_logo;
						$classes[] = ! empty( $sticky_logo ) ? "sticky-logo" : "";   


		//header style
		$classes[] = 'header-style-'.rtframework_get_setting( "header_style" );    

		//FS menu button
		$classes[] = rtframework_get_setting( "header_sidepanel" ) ? "header-sidepanel" : "";    
		$classes[] = rtframework_get_setting( "header_sidepanel_mobile" ) ? "header-sidepanel-mobile" : "";

		//header search button
		$classes[] = rtframework_get_setting( "header_search" ) ? "header-search-button" : "";    

		//header wpml menu
		$classes[] =  function_exists('icl_get_languages') && rtframework_get_setting( "header_wpml" ) ? "header-wpml-button" : "";    

		//header width
		$classes[] = 'naturalife-'.rtframework_get_setting('header_width').'-header-width';    

		//sticky header width
		$classes[] = 'naturalife-'.rtframework_get_setting('sticky_header_width').'-sticky-header-width';    

		//footer width
		$classes[] = 'naturalife-'.rtframework_get_setting('footer_width').'-footer-width';    		

		//has sub header
		$classes[] = ! rtframework_get_setting( "hide_page_title" ) || ! rtframework_get_setting( "hide_breadcrumb_menu" ) ? 'has-sub-header' : "";

		//boxed body
		$classes[] = rtframework_get_setting( "boxed_body" ) ? 'boxed-body-style' : "";

		//underlapped footer
  		$classes[] = ! rtframework_get_setting( "boxed_body" ) && rtframework_get_setting( "underlapped_footer" ) ? 'naturalife-fixed-footer' : "";

  		//sticky mobile header
		$classes[] = rtframework_get_setting( "naturalife_sticky_mobile_header" ) ? 'sticky-mobile-header' : "";

		// return the $classes array
		return $classes;
	}
}
add_filter('body_class','rtframework_body_class_name');

if( ! function_exists("rtframework_limit_search_results") ){
	/**
	 * Limit search results
	 * @param  string $query
	 * @return string $query
	 */
	function rtframework_limit_search_results($query) { 

		if( is_admin() && defined( 'DOING_AJAX' ) ){
			return $query;
		}
				
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
 
if( ! function_exists("rtframework_search_highlight") ){
	/**
	 * Search Highlight
	 * @param  string $needle  
	 * @param  string $haystack
	 * @return string          
	 */
	function rtframework_search_highlight($needle, $haystack) {
		$ind = stripos($haystack, $needle);
		$len = strlen($needle);
			if($ind !== false) {
			return substr($haystack, 0, $ind) . '<span class="search_highlight">' . substr($haystack, $ind, $len) . "</span>" . rtframework_search_highlight($needle, substr($haystack, $ind + $len));
		} else {
			return $haystack;
		}
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
		
		global $rtframework_post_type;

		//defaults
		extract(shortcode_atts(array(  
			"show_author" => "true",
			"show_categories" => "true",
			"show_comment_numbers" => "true",
			"show_tags" => "false",
			"show_date" => "true",
			"show_share" => "false",
		), $atts));


		//if all paramaters is false don't display the wrapper
		if( ! is_singular() || ( is_singular() && $rtframework_post_type != "post" ) ){
			if  ( $show_author == "false" && $show_categories == "false" && $show_comment_numbers == "false" && $show_tags == "false"){		
				return;
			}
		}else{
			if  ( $show_author == "false" && $show_categories == "false" && $show_date == "false" ){
				return;
			}
		}

	?>

		<!-- meta data -->
		<div class="post_data">
			<?php if( $show_author !== "false" ):?>
			<!-- user -->                                     
			<span class="user">
			<?php  
				if( ! is_rtl() ){
					printf( esc_html__('by %1$s %2$s','naturalife'), (is_singular() && $rtframework_post_type == "post") ? get_avatar( get_the_author_meta( 'user_email' ), 25 ) : "", get_the_author_posts_link() );
				}else{
					printf( esc_html__('%1$s %2$s by', 'naturalife'), get_the_author_posts_link(), (is_singular() && $rtframework_post_type == "post") ? get_avatar( get_the_author_meta( 'user_email' ), 25 ) : "" );
				}
			?>				
			</span>

			<?php endif;?>
				
			<?php 
			if( $show_categories !== "false" && get_the_category() ):?>
			<!-- categories -->
			<span class="categories">
			<?php 
				if( ! is_rtl() ){
					esc_html_e('in ','naturalife').the_category(', ');
				}else{
					the_category(', ').esc_html_e(' in','naturalife');
				}
			?>				
			</span>
			<?php endif;?>

			<?php 
			if( $show_tags !== "false" && get_the_tags() ):?>
			<!-- categories -->
			<span class="tags"><?php the_tags("",", ","");?></span>
			<?php endif;?>

			<?php if( $show_comment_numbers !== "false" && comments_open() ):?>
			<!-- comments --> 
			<span class="comment_link"><a href="<?php comments_link(); ?>" title="<?php comments_number( esc_html__('0 Comment','naturalife'), esc_html__('1 Comment','naturalife'), esc_html__('% Comments','naturalife') ); ?>" class="comment_link"><?php comments_number( esc_html__('0 Comment','naturalife'), esc_html__('1 Comment','naturalife'), esc_html__('% Comments','naturalife') ); ?></a></span>
			<?php endif;?>			

			<?php if( $show_date !== "false" ):?>
			<!-- date -->                                     
			<span class="date"><a href="<?php echo esc_url( get_the_permalink() ); ?>"><?php echo get_the_date();?></a></span>
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
		$content_width = rtframework_get_setting( 'sidebar_position' ) == "left" || rtframework_get_setting( 'sidebar_position' ) == "right" ? rtframework_get_setting( "content_sidebar_width" ) : rtframework_get_setting( "content_full_width" );		

		$max_image_width = $content_width; //max image size for the design
		$min_image_width = apply_filters( "rtframework_min_image_width", 695 ); //min image size for mobile view
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

		//args
		extract(shortcode_atts(array(  
			"image_id"  => "", 
			"image_url"  => "", 
			"w" => "",
			"h" => "",
			"crop" => false,
			"image_size" => "",
			"thumbnails" => false
		), $args));


		//vars
		$lightbox_thumbnail = $srcset = $sizes = $hwstring = "";

		$image_size = $image_size == "custom" ? "" : $image_size;

		//find post id from src 
		if ( empty( $image_id ) && ! empty( $image_url ) ){
			$image_id = rtframework_get_attachment_id_from_src($image_url);			
		}

		$image = ! empty ( $image_id ) ? wp_get_attachment_image_src($image_id, $image_size ) : false ;
		
		if( $image ){

				list($src, $width, $height) = $image;

				if( ! empty( $image_size ) ){
					
					$image_meta = wp_get_attachment_metadata( $image_id );

					if( $image_size == "rtframework_retina" ){
						$srcset = wp_get_attachment_url( $image_id ) ." 1.3x";
					}else{						
						if ( is_array( $image_meta ) && function_exists("rtframework_calculate_image_srcset") ) {
							$size_array = array( absint( $width ), absint( $height ) );
							$srcset     = rtframework_calculate_image_srcset( $size_array, $src, $image_meta, $image_id );
							$sizes      = rtframework_calculate_image_srcset( $size_array, $src, $image_meta, $image_id );
						}
					}
				}

				//attachment data
				$attachment             = get_post( rtframework_wpml_post_id($image_id), "attachment" );	
				$image_title            = esc_attr($attachment->post_title);			
				$image_caption          = esc_attr($attachment->post_excerpt);			
				$image_description      = $attachment->post_content;			
				$image_alternative_text = esc_attr(get_post_meta( $image_id , '_wp_attachment_image_alt', true));		

		
				if( ! empty( $image_size ) ){ //images size - wp resized image 			
					$thumbnail_url = $src;
					$hwstring = image_hwstring($width, $height);

					//full image
					$image_full = ! empty ( $image_id ) ? wp_get_attachment_image_src($image_id, "full" ) : false ;
					$src = $image_full[0];

				}else{//auto resize the image if $w and $h defined 
				
					$thumbnail = ( ! empty( $w ) && ! empty( $h ) ) ? rtframework_resize( $image_id, '', $w, $h, $crop ) : "";	
								 
					if( is_array( $thumbnail ) ){
						$thumbnail_url = $thumbnail["url"] ;
						$hwstring = image_hwstring($thumbnail["width"], $thumbnail["height"]);
					}else{
						$thumbnail_url = $src ;
					}				
				}
		 
				// Tiny image thumbnail for lightbox or carousel thumbs
				if( $thumbnails ){				
					$lightbox_thumbnail = rtframework_resize( $image_id, '', 75, 50, true ); 
					$lightbox_thumbnail = is_array( $lightbox_thumbnail ) ? $lightbox_thumbnail["url"] : $thumbnail_url ;		
				}


				//output
				return array(
					"image_title"            => $image_title, 
					"image_caption"          => $image_caption, 
					"image_alternative_text" => $image_alternative_text,
					"image_url"              => $src,
					"thumbnail_url"          => $thumbnail_url,
					"lightbox_thumbnail"     => $lightbox_thumbnail,
					"srcset"                 => $srcset,
					"sizes"                  => $sizes,
					"hwstring"               => $hwstring
				);		

		}else{

				//output
				return array(
					"image_title"            => "", 
					"image_caption"          => "", 
					"image_alternative_text" => "",
					"image_url"              => $image_url,
					"thumbnail_url"          => $image_url,
					"lightbox_thumbnail"     => $image_url,
					"srcset"                 => "",
					"sizes"                  => "",
					"hwstring"               => ""
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
			"data_title" => "", 
			"data_description" => "",  
			"data_href" => "", 
			"data_width" => "", 
			"data_height" => "",  
			"data_poster" => "", 
			"data_autoplay" => "", 
			"data_audiotitle" => "", 
			"inner_content" => "",
			"tooltip" => false,
			"echo"=> true
		), $atts));

		//tooltip
		$tooltip = $tooltip == "true" ? ' data-placement="top" data-toggle="tooltip"' : "";

		//add desc to te title
		$data_title = ! empty($data_description) ?  esc_attr( $data_title ).'<br>'. esc_attr($data_description) : esc_attr( $data_title );

		//output
		$lightbox_link = sprintf(
			'<a id="%s" class="%s" data-gal-id="%s" data-rel="rt_lightbox" title="%s" data-sub-html="%s" data-src="%s" data-width="%s" data-height="%s" data-poster="%s" data-autoplay="%s" data-audiotitle="%s" data-download-url="false" href="%s"%s>%s</a>',
			$id,
			$class,
			$data_group,
			esc_attr($title), 
			$data_title, 
			esc_url($data_href),
			$data_width,
			$data_height, 
			$data_poster,
			$data_autoplay,
			$data_audiotitle,
			esc_url($href),
			$tooltip,
			$inner_content
		);

		//echo 
		echo ( true == $echo ) ? $lightbox_link : "";

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
			"class" => "",
			"retina" => false
		), $atts)); 
		
		if ( empty( $image_id ) && empty( $image_url ) ){
			return false;
		}else{

			$image_id = empty( $image_id ) && ! empty( $image_url ) ? rtframework_get_attachment_id_from_src( $image_url ) : $image_id ;

			$image_thumb = ! empty( $image_id ) ? rtframework_resize( $image_id, '', $w, $h, $crop ) : rtframework_resize( '', $image_url, $w, $h, $crop );

			$image_alternative_text = ! empty( $image_id ) ? get_post_meta($image_id, '_wp_attachment_image_alt', true) : "";		

			$srcset = "";

			if( $retina ){

				$image_thumb_retina = ! empty( $image_id ) ? rtframework_resize( $image_id, '', $w*2, $h*2, $crop ) : rtframework_resize( '', $image_url, $w*2, $h*2, $crop );

				$srcset = is_array( $image_thumb_retina ) ? ' srcset="'.$image_thumb_retina['url'].' 1.3x"' : "";
			}

			$image_output = is_array($image_thumb) ? '<img src="'.esc_url($image_thumb['url']).'" alt="'.esc_attr($image_alternative_text).'" class="'.sanitize_html_class($class).'"'.$srcset.' width="'.$image_thumb['width'].'" height="'.$image_thumb['height'].'" />' : "";	

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

if( ! function_exists("rtframework_display_loop_image") ){
	/**
	 * Get html output of the loop image
	 * @param  array $atts
	 * @return html 
	 */	
	function rtframework_display_loop_image( $atts = array() ){

		//defaults
		extract(shortcode_atts(array(  
			'class'     => '',
			'href'      => '',
			'title'     => '',
			'thumbnail' => ''
		), $atts)); 
		
		printf(
			'<a href="%s" title="%s" class="%s">%s</a>',
				$href,
				$title,
				$class,					
				$thumbnail
			);
	}
}
add_action( "rtframework_display_loop_image", "rtframework_display_loop_image", 10, 1 );



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
		global $paged,$page;

		if( empty( $paged )){
			$paged = $page;
		}

		$array = array(
			'current' => max( 1, $paged ),
			'total' => $wp_query->max_num_pages,
			'type' => 'list',
			'show_all' => false,
			'prev_next' => true,
			'prev_text' => esc_html__("previous", "naturalife"),
			'next_text' => esc_html__("next", "naturalife"),	
		);		

		$pagination = paginate_links( $array );

		if( empty( $pagination ) ){
			return;
		}

		$output = '<div class="paging_wrapper margin-t30 margin-b30">';
		$output .= $pagination;
		$output .= '</div>'; 

		if( $echo ){
			echo wp_kses_post($output);
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


if( ! function_exists("rtframework_remove_content_container") ){

	/**
	 * Remove Content Container for builders
	 *
	 * @since 1.0
	 *
	 * @return bool
	 */
	function rtframework_remove_content_container() {

		if(rtframework_get_setting("sidebar_position") != "fullwidth" ){
			return;//we need the content container for pages with sidebar
		}

		$query_object = get_queried_object(); 
		$page_id = isset( $query_object->ID ) ? $query_object->ID : "";
 		$current_template_name = get_page_template_slug($page_id);
 		$is_elementor_active = get_post_meta( $page_id, '_elementor_edit_mode', true );
 		$remove = false;

		//full or part of the template names
		$builder_templates = array(
			"elementor"
		);

		foreach ($builder_templates as $template_name) {
			if( strpos( $current_template_name, $template_name ) > -1 ){
				$remove = true;
			}
		}

		if( $remove || ( $is_elementor_active && is_page() ) ){
			remove_action( 'rtframework_start_main_content', "rtframework_start_content_container",20);
			remove_action( 'rtframework_end_main_content', "rtframework_end_content_container",20); 			
		}

		return;
	}
}
add_action( 'template_redirect', "rtframework_remove_content_container",20); 


if( ! function_exists("rtframework_start_content_container") ){

	/**
	 * Content Container
	 * Opens a content container 
	 *
	 * @since 1.0
	 *
	 * @return string $output html output
	 */
	function rtframework_start_content_container() {

		$atts = apply_filters("rtframework_start_content_container_atts",array(
			"sidebar" => rtframework_get_setting("sidebar_position"),
			"class"	  => 'default-style main-content-row '.rtframework_get_setting("default_content_row_width"), 
			"wrapper_class" => rtframework_get_setting("default_content_wrapper_width"),
			"col_class" => 'col col-lg-9 col-12 content '.rtframework_get_setting("sidebar_position").'-sidebar',
			"col_class_fullwidth" => 'col col-lg-12 col-12 content fullwidth',
		));

		$atts["class"] .= rtframework_get_setting("sidebar_position") == "fullwidth" ? " no-sidebar" : "";

		//woocommerce columns
		if ( class_exists( 'Woocommerce' ) ) {
			if( is_shop() || is_product_category() || is_product_tag() ){
				$atts["class"] .= " woocommerce columns-".apply_filters("loop_shop_columns", 4 );
			}
		}
			
		?>
		<div id="main-content-row" class="content-row <?php echo esc_attr($atts["class"]);?>">
			<div class="content-row-wrapper row <?php echo esc_attr($atts["wrapper_class"]);?>">

 			<?php if( $atts["sidebar"] != "fullwidth" ): ?>
				<main class="<?php echo trim($atts["col_class"])?>"> 
			<?php else: ?>
				<main class="<?php echo trim($atts["col_class_fullwidth"])?>"> 
			<?php endif; ?>
					<div class="column-inner">
					<?php do_action( "rtframework_before_post_content"); ?>

		<?php
	} 
}
add_action( 'rtframework_start_main_content', "rtframework_start_content_container",20); 

if( ! function_exists("rtframework_end_content_container") ){

	/**
	 * Content Container
	 * Opens a content container 
	 *
	 * @since 1.0
	 *
	 * @return string $output html output
	 */
	function rtframework_end_content_container() {

		$atts = apply_filters("rtframework_end_content_container_atts",array(
			'sidebar' => rtframework_get_setting("sidebar_position"),
			'col_class' => 'col col-lg-3 col-12 default-style sidebar sticky-sidebar widgets_holder '.rtframework_get_setting("sidebar_position")
		));
		?>			<?php do_action( "rtframework_after_post_content"); ?>
					</div>
				</main>

			<?php if( $atts["sidebar"] != "fullwidth" ): ?>
				<aside class="<?php echo trim($atts["col_class"]);?>"> 
					<div class="column-inner">
						<?php get_template_part("sidebar");?>
					</div>
				</aside>
			<?php endif; ?>

			</div>	
		</div><!-- / end #main-content-row -->
		<?php
	} 
}
add_action( 'rtframework_end_main_content', "rtframework_end_content_container",20); 


if( ! function_exists("rtframework_portfolio_content_container") ){

	/**
	 * Remove global content container from portfolio single pages
	 *
	 * @since 1.0
	 *
	 * @return bool
	 */
	function rtframework_portfolio_content_container() {

		if ( ! is_singular( "portfolio" ) || rtframework_get_setting("sidebar_position") != "fullwidth" ){
			return;
		}
 
		remove_action( 'rtframework_start_main_content', "rtframework_start_content_container",20);
		remove_action( 'rtframework_end_main_content', "rtframework_end_content_container",20); 			

		return;
	}
}
add_action( 'template_redirect', "rtframework_portfolio_content_container",20); 


if( ! function_exists("rtframework_sub_page_header_function") ){

	/**
	 * Sub page header
	 * Creates page title and breadcrumb menu html output for sub page headers
	 *
	 * @since 1.0
	 * 
	 * @return string $output
	 */
	function rtframework_sub_page_header_function() {

		if( rtframework_get_setting( "hide_sub_header" ) ){
			return;
		}

		//title
		$title = ! rtframework_get_setting( "hide_page_title" ) ? sprintf('<section class="page-title"><%2$s>%1$s</%2$s></section>', rtframework_get_title(), "h1" ) : "";

		//breadcrumb
		$breadcrumb = ! rtframework_get_setting( "hide_breadcrumb_menu" ) && ! is_front_page() ? rtframework_breadcrumb( array("wrap_before" => '<div class="breadcrumb">', "wrap_after" => '</div>') ) : "";

		$style = $bg_style = $output = $class = $overlay = "";

		/*
		*	Background options  
		*/
		
		//background image
		$bg_image_url = rtframework_get_setting( "sub_header_bg_image" ) ?  rtframework_get_attachment_image_src( rtframework_get_setting( "sub_header_bg_image" ) ) : "" ; 		


		//classic bg values
		if( ! empty( $bg_image_url ) && rtframework_get_setting("sub_header_bg_img_option") != "none" ){
			//background image
			$bg_style  .= 'background-image: url('.$bg_image_url.');';
			
			//background repeat
			$bg_style  .= rtframework_get_setting( "sub_header_bg_repeat" ) != "" ? 'background-repeat: '.rtframework_get_setting( "sub_header_bg_repeat" ).';': "";

			//background size
			$bg_style  .= rtframework_get_setting( "sub_header_bg_size" ) != "" ? 'background-size: '.rtframework_get_setting( "sub_header_bg_size" ).';': "";

			//background attachment
			$bg_style  .= rtframework_get_setting( "sub_header_bg_attachment" ) != "" ? 'background-attachment: '.rtframework_get_setting( "sub_header_bg_attachment" ).';': "";

			//background position
			$bg_style  .= rtframework_get_setting( "sub_header_bg_position" ) != "" ? 'background-position: '.rtframework_get_setting( "sub_header_bg_position" ) .';': "";		
		}	

		//remove image
		if( rtframework_get_setting("sub_header_bg_img_option") == "none" ){			
			$bg_style  .= 'background-image: none;';
		}	

		/**
		 * BG Overlay
		 */
		if( ! empty( rtframework_get_setting( "sub_header_overlay_color" ) ) ){

			//color overlay layer
			$overlay = '<div class="background-overlay" style="background-color:'. rtframework_get_setting( "sub_header_overlay_color" ).'"></div>'."\n";

			$class .= " has-bg-overlay";
		}

		//background color
		$bg_style  .= rtframework_get_setting( "sub_header_bg_color" ) != "" ? 'background-color: '.rtframework_get_setting( "sub_header_bg_color" ).';': "";

		//alignment
		$class .= rtframework_get_setting( "sub_header_style" ) == "" ? " style-1" : " ".rtframework_get_setting( "sub_header_style" );

		//create styles
		$style .= $bg_style;
		$style_output = ! empty( $style ) ? 'style="'.$style.'"' : ""; 

		//content output
		$content_output = '<div class="content-row-wrapper '.rtframework_get_setting("header_width").'"><div class="col col-sm-12">'. apply_filters( "sub-page-header_content", $title.$breadcrumb ) .'</div></div>';

		$output .= "\n".'<div class="content-row row sub-page-header fullwidth '.trim($class).'" '.$style_output.'>';
		$output .= "\n\t".$overlay.$content_output;
		$output .= "\n".'</div>'."\n";

		echo ! empty( $output ) ? $output : "";

	}
}
add_action( 'rtframework_start_main_content', "rtframework_sub_page_header_function", 10 ); 

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
	function rtframework_column_class( $width = "1/1", $screen = "" ) {

		$screen = ! empty( $screen ) ? "-". $screen : "";

		//the class list
		$class_list = array(
			"12/12" => "col{$screen}-12",			
			"1/1" => "col{$screen}-12",
			"11/12" => "col{$screen}-11",
			"10/12" => "col{$screen}-10",			
			"5/6" => "col{$screen}-10",
			"9/12" => "col{$screen}-9",
			"3/4" => "col{$screen}-9",			
			"8/12" => "col{$screen}-8",
			"4/6" => "col{$screen}-8",
			"2/3" => "col{$screen}-8",
			"7/12" => "col{$screen}-7",
			"6/12" => "col{$screen}-6",
			"3/6" => "col{$screen}-6",
			"1/2" => "col{$screen}-6",
			"5/12" => "col{$screen}-5",
			"1/3" => "col{$screen}-4",
			"4/12" => "col{$screen}-4",
			"2/6" => "col{$screen}-4",
			"1/4" => "col{$screen}-3", 
			"3/12" => "col{$screen}-3",
			"1/6" => "col{$screen}-2",
			"2/12" => "col{$screen}-2",
			"1/12" => "col{$screen}-1",
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
			"tablet_item_width"  => "",			
			"mobile_item_width"  => 1,
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
			"lightbox" => "true",
			"padding" => "",
			"loop" => "false",
			"frame" => "false",
			"shadows" => "false"
		), $atts));
	
		$output = $contents_output  = $holder_class = "";


		//boxed carousel
		if( $boxed == "true" ){
			$class .= " boxed-carousel" ;
			$holder_class = ' class="boxed"';			
		}

		//create carousel items
		$i = 1;
		foreach ( $contents as $content ) {
			$contents_output .= $hash_navigation ? sprintf('<div data-hash="%s-%s"%s>%s</div>', $id, $i, $holder_class, $content) : sprintf('<div%s>%s</div>', $holder_class, $content);
			$i++;
		} 

		//dots holder
		$dots_holder = ( $dots == "true" ) ? sprintf('
				<div id="%1$s-dots" class="dots-holder">
				</div>
			', $id) : "";



		//lightbox
		$class .= ( $lightbox == "true" ) ? " rt_lightbox_gallery" : "";

		//shadows
		$class .= ( $shadows == "true" ) ? " shadows" : "";

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
				<div id="%1$s" class="rt-carousel carousel-holder %2$s" data-item-width="%4$s" data-nav="%5$s" data-dots="%6$s" data-margin="%8$s" data-autoplay="%9$s" data-timeout="%10$s" data-thumbnails="%12$s" data-boxed="%13$s" data-min-height="%14$s" data-padding="%15$s" data-loop="%16$s" data-tablet-item-width="%17$s" data-mobile-item-width="%18$s">
					<div class="owl-carousel">
						%3$s
					</div>
					%7$s
					%11$s
				</div>
			', $id, trim($class), $contents_output, $item_width, $nav, $dots, $dots_holder, $margin, $autoplay, $timeout, $thumbnail_navigation_holder, $thumb_nav, $boxed, $min_height, $padding, $loop, $tablet_item_width, $mobile_item_width ); 		
 
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
			"id"           => 'gallery-'.rand(100000, 1000000),   
			"class"        => '',
			"crop"         => false, 	   
			"w"            => "", 
			"h"            => "", 
			"image_ids"    => array(), 
			"image_urls"   => array(),
			"item_width"   => "1/3",
			"layout"       => "1", //metro gallery layout 
			"metro_resize" => "true",
			"layout_style" => "grid",
			"itemprop"     => false,
			"captions"     => "false",
			"links"        => "false",
			"custom_links" => "",
			"link_target"  => "_self",   
			"echo"         => true,
			"nogaps"       => "false",
			"image_size"   => "",
			"vertical_align" => ""
		), $atts));

		//vars
		$final_output = "";

		//class
		$add_holder_class = $class;

		//item width percentage
		$item_width = ! empty( $item_width ) ? $item_width : "1/3";

		//image array
		$image_array = ! empty( $image_urls ) ? $image_urls : $image_ids ;

		//itemprop
		$itemprop = $itemprop != "false"  ? ' itemprop="image"' : ""; 

		//custom links
		if( ! empty( $custom_links ) ){
			$links_array = explode(",", wp_strip_all_tags( $custom_links ) );
		}

		//items array
		$items  = array();

		//thumbnails output
		$thumbnails  = array();

		/// Metro Dimensions
		if( $layout_style == "metro" ){
			$dimensions_array = rtframework_convert_bool($nogaps) == "false" ? rtframework_get_metro_dimensions(true, $layout ) : rtframework_get_metro_dimensions(false, $layout );
		}

		// Thumbnail width & height
		if( $layout_style != "metro" ){

			if( $image_size == "custom" ){

				if( empty( $w ) && $crop ){
					$w = rtframework_get_min_resize_size( $item_width );
				}

				if( empty( $h ) && $crop ){
					$h =  ! empty( $w ) ? $w / 1.5 : 10000;
				}

			}else{
				$w = $h = $crop = "";
			}

		}else{
			$image_size = "";
		}

		/**
		 * Create image outputs
		 */
		$i = 0;
		foreach ( $image_array as $key => $image ) { 
			
			$final_output = $item_output = $image_html_output = $content_before_links = "";
			$nolink = true;

			// Thumbnail width & height - metro
			if( $layout_style == "metro" ){
				$w = $metro_resize == "true" ? $dimensions_array[$i][1] : "";
				$h = $metro_resize == "true" ? $dimensions_array[$i][2] : "";
				$crop = $metro_resize == "true" ? true : false;	
			}

			// Resize Image
			$image_output = is_numeric( $image ) ? rtframework_get_image_data( array( "image_id" => trim($image), "w" => $w, "h" => $h, "crop" => $crop, "image_size" => $image_size )) : rtframework_get_image_data( array( "image_url" => trim($image), "w" => $w, "h" => $h, "crop" => $crop, "image_size" => $image_size ) ); 	

			//srcset
			$srcset =  ! empty( $image_output["srcset"] ) ? ' srcset="'.$image_output["srcset"].'"' : ""; 

			//sizes
			$sizes = ! empty( $image_output["sizes"] ) ? ' sizes="'.$image_output["sizes"].'"': ""; 

			//image html output
			$image_html_output = sprintf('<img src="%s" alt="%s"%s%s%s %s>',$image_output["thumbnail_url"], $image_output["image_alternative_text"], $itemprop, $srcset, $sizes, trim($image_output["hwstring"]));


			/**
			 * item html output		
			 */
			if( $captions != "true" ){
				$content_before_links = '<div class="image-thumbnail">'.$image_html_output.'</div>';
			}else{

				if( empty( $image_output["image_title"] ) && empty( $image_output["image_caption"] )  ){
						$content_before_links = sprintf('
															<div class="image-thumbnail">
																%1$s
															</div>
															',
															$image_html_output);					
					}else{
						$content_before_links = sprintf('
															<div class="image-thumbnail">
																%1$s
															</div>

															<div class="overlay-text">
																%2$s
																%3$s
															</div>
															',
															$image_html_output,
															! empty( $image_output["image_title"] ) ? '<span>'.$image_output["image_title"].'</span>': "",
															! empty( $image_output["image_caption"] ) ? '<p>'.$image_output["image_caption"].'</p>': ""
														);	
					}

			}

			/**
			 * item html output after links		
			 */
			
			//Lightbox output 
			if( $links == "lightbox" ){
				
				//create lightbox link
				$item_output .= rtframework_create_lightbox_link(
					array(
						'class'            => 'imgeffect zoom rt_lightbox',
						'href'             => $image_output["image_url"],
						'title'            => esc_html__('Enlarge Image','naturalife'),
						'data_group'       => $id,
						'data_title'       => $image_output["image_title"],
						'data_description' => $image_output["image_caption"],
						'data_thumbnail'   => $image_output["lightbox_thumbnail"],
						'echo'             => false,
						'inner_content'    => $content_before_links
					)
				);

				$nolink = false;
			}

			//custom links
			if ( $links == "custom" && isset( $links_array[$key] ) && ! empty( $links_array[$key] ) ) {					
				$item_output .= sprintf(
						'<a href="%s" title="%s" target="%s" class="imgeffect link">%s</a>',
						esc_url($links_array[$key]), 
						esc_attr($image_output["image_title"]), 
						esc_attr($link_target), 
						$content_before_links
						);
				$nolink = false;
			}

			//no link
			if( $nolink ){
				$item_output .= $content_before_links;
			}

			$items[] = $item_output;

			if( $layout_style == "metro" ){
				$i = count( $dimensions_array ) - 1 == $i ? $i = 0 : $i + 1;
			}
		}

		/**
		 * Create grid
		 */

		//item counter
		$counter = 1;

		//layout style
		switch ( $layout_style ) {
			case 'masonry':
				
				$add_holder_class .= " row masonry-gallery";

				break;

			case 'metro':
				
				$add_holder_class .= " row metro-gallery";
				
				break;

			default:
				
				$add_holder_class .= " grid-gallery";

				break;
		}

		//vertical align
		$add_holder_class .= $vertical_align == "center" ? " vertical-align-center" : "";

		//gaps
		$add_holder_class .= $nogaps == "true" ? " nogaps" : "";

		//add column class
		$add_column_class = $layout_style != "metro" ? rtframework_column_class( $item_width, "sm" ). " col-12" : "";

		//dynamic positions
		$add_column_class .= $layout_style != "grid" ? " rt-dynamic" : ""; 


		//row count
		$column_count = rtframework_column_count( $item_width );


		foreach ($items as $item ) {

			//metro column class
			$metro_column_class = "";
			if( $layout_style == "metro" ){ 
				$metro_column_class = $dimensions_array[ fmod($counter-1, count( $dimensions_array ) ) ][0];
			}

			//open row block
			if( $layout_style == "grid" && $item_width != "1/1" && ( $counter % $column_count == 1 || $column_count == 1 ) ){
				$final_output .= '<div class="row">'."\n";
			}	

				//cols
				$final_output .= sprintf('
					<div class="col %1$s">
						<div class="gallery-item-holder%2$s">
							%3$s
						</div>
					</div>', 
				trim($add_column_class.' '.$metro_column_class),
				$captions == "true" ? " has-overlay" : "",
				$item);

			//close row block
			if( $layout_style == "grid" && $item_width != "1/1" && ( $counter % $column_count == 0 || count($image_array) == $counter ) ){
				$final_output .= '</div>'."\n";  
			}

			$counter++;
		}


		//id attr
		$id_attr = ! empty( $id ) ? ' id="'.$id.'"' : "";

		//the gallery holder output
		$final_output = sprintf('
			<div class="%1s"%2s>%3s</div> 
		',trim("rt-gallery ".$add_holder_class), $id_attr, $final_output ); 


		//create slider
		if($echo){
			echo wp_kses_post( $final_output );//photo gallery html output
		}else{
			return $final_output;
		}

	}
}
add_action( "rtframework_create_photo_gallery", "rtframework_create_photo_gallery", 10, 1 );


if( ! function_exists("rtframework_get_metro_dimensions") ){
	/**
	 * Generates an size path for metro galleries
	 *
	 * @since 1.0
	 * 
	 * @param $gaps = bool, $style = string
	 * @return array
	 */

	function rtframework_get_metro_dimensions( $gaps = false, $style = "1" )
	{
		//style 1
		$dimensions_array["1"] = array(
			array("double-height double-width", 900, 900), 		
			array("", 900, 900), 
			array("", 900, 900), 
			array("", 900, 900), 
			array("", 900, 900), 
			array("", 900, 900), 
			array("", 900, 900), 
			array("double-height double-width", 900, 900), 	
			array("", 900, 900), 
			array("", 900, 900), 
		);

		//style 2
		$dimensions_array["2"] = array(
			array("", 900, 900), 		
			array("", 900, 900), 	  						
			array("double-height double-width", 900, 900), 	 		
			array("double-width", 960, 420), 	 		
			array("double-height double-width", 900, 900), 	 		
			array("double-width", 960, 420),
			array("", 900, 900), 		
			array("", 900, 900), 	  		
		);

		$dimensions_array["3"] = array(
			array("", 900, 900), 		
			array("double-height", 900, 900), 	
			array("", 900, 900), 	 		
			array("", 900, 900), 	 		
			array("", 900, 900), 	 		
			array("double-height", 900, 900), 		
			array("double-width", 960, 420),
			array("", 900, 900), 	 		
			array("", 900, 900), 	 	
		);
 
		return $dimensions_array["{$style}"];
	}
}

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
		global $rtframework_settings;

		$atts = esc_attr(urldecode( $_POST["atts"] ) ) ;

		//create array from atts $key*$value|$key*$value
		$new_atts = array();
		foreach (explode("|",$atts) as $value) { 
			$values = explode("*", $value);
			$new_atts[$values[0]] = isset( $values[1] ) ? $values[1] : "";
		}

		$page = esc_attr( $_POST["page"] );
		$new_atts["paged"] = $page;
		$new_atts["wpml_lang"] = $_POST["wpml_lang"];

		//current lang
		if( isset( $_POST["wpml_lang"] ) && ! empty( $_POST["wpml_lang"] ) ){
			global $sitepress;
			$sitepress->switch_lang( esc_attr($_POST['wpml_lang']), true);
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

		printf('<button href="#" class="load_more button_ small style-1 aligncenter" autocomplete="off" data-atts="%1$s" data-page_count="%2$s" data-current_page="%3$s" data-listid="%5$s"><span><span class="button-icon ui-icon-angle-down"></span><span>%4$s</span></span></button>',
				urlencode($serialized_atts),
				$page_count,
				1,
				esc_html__("LOAD MORE","naturalife"),
				$atts["id"]
			);
	}
}


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
			"itemprop" => false,
			"captions" => false,
			"links" => "",
			"custom_links" => "",
			"link_target" => "_self", 
			"image_size" => "",
			"thumbnails" => false
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

		//custom links
		if( ! empty( $custom_links ) ){
			$links_array = explode(",", wp_strip_all_tags( $custom_links ) );
		}

		//create slides and thumbnails outputs
		$output  = array();

		//thumbnails output
		$thumbnails  = array();


		foreach ($rt_gallery_images as $key => $image) { 								 


			$create_output = $image_html_output = $content_output = "";


			// Resize Image
			$image_output = is_numeric( $image ) ? rtframework_get_image_data( array( "image_id" => trim($image), "w" => $w, "h" => $h, "crop" => $crop, "image_size" => $image_size, "thumbnails" => $thumbnails )) : rtframework_get_image_data( array( "image_url" => trim($image), "w" => $w, "h" => $h, "crop" => $crop, "image_size" => $image_size, "thumbnails" => $thumbnails ) ); 	

			//thumbnails
			$thumbnails[] = $image_output["lightbox_thumbnail"];

			
			$nolink = true;


				//srcset
				$srcset =  ! empty( $image_output["srcset"] ) ? ' srcset="'.$image_output["srcset"].'"' : ""; 

				//sizes
				$sizes = ! empty( $image_output["sizes"] ) ? ' sizes="'.$image_output["sizes"].'"': ""; 

				//image html output
				$image_html_output = sprintf('<img src="%s" %salt="%s"%s%s%s>',$image_output["thumbnail_url"], $image_output["hwstring"],  $image_output["image_alternative_text"], $itemprop, $srcset, $sizes);
 
				//content output		
				if( rtframework_convert_bool($captions) == "false" ){
					$content_output = $image_html_output;
				}else{
					$content_output = sprintf('<div class="has-overlay">
													<div class="carosel-image">
														%1$s
													</div>

													<div class="overlay-text">
														%2$s
														%3$s
													</div>
												</div>
												',
												$image_html_output,
												! empty( $image_output["image_title"] ) ? '<span>'.$image_output["image_title"].'</span>': "",
												! empty( $image_output["image_caption"] ) ? '<p>'.$image_output["image_caption"].'</p>': ""
											);
				}

				//Lightbox output 
				if( $links == "lightbox" ){

					//create lightbox link
					$create_output .= rtframework_create_lightbox_link(
						array(
							'class'            => 'imgeffect zoom rt_lightbox',
							'href'             => $image_output["image_url"],
							'title'            => esc_html__('Enlarge Image','naturalife'),
							'data_group'       => $slider_id,
							'data_title'       => $image_output["image_title"],
							'data_description' => $image_output["image_caption"],
							'data_thumbnail'   => $image_output["lightbox_thumbnail"],
							'echo'             => false,
							'inner_content'    => $content_output
						)
					);

					$nolink = false;
				}

				//custom links
				if ( $links == "custom" && isset( $links_array[$key] ) && ! empty( $links_array[$key] ) ) {					
					$create_output .= sprintf(
							'<a href="%s" title="%s" target="%s" class="imgeffect link">%s</a>',
							esc_url($links_array[$key]), 
							esc_attr($image_output["image_title"]), 
							esc_attr($link_target), 
							$content_output
							);
					$nolink = false;
				}

				//no link
				if( $nolink ){
					$create_output .= $content_output;
				}

			
			$output[] = $create_output;
		}

		//create slider
		$carousel_atts["class"] = "rt-image-carousel ".$carousel_atts["class"];

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
			"resize" => false,
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

		//image dimensions
		if( rtframework_convert_bool($resize) == "true"  ){
			$w = ! empty( $w ) ? $w : 2000;
			$h = ! empty( $h ) ? $h : 2000;
		}else{
			$w = "";
			$h = "";		
			$crop = false;	
		}

		//create slides and thumbnails outputs
		$output  = array();

		foreach ($rt_gallery_images as $image) { 								 

			// Resize Image
			$image_output = is_numeric( $image ) ? rtframework_get_image_data( array( "image_id" => trim($image), "w" => $w, "h" => $h, "crop" => $crop )) : rtframework_get_image_data( array( "image_url" => trim($image), "w" => $w, "h" => $h, "crop" => $crop ) ); 	


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
			echo rtframework_create_carousel( $output, $carousel_atts );
		}else{
			return rtframework_create_carousel( $output, $carousel_atts );
		}

	}
}
add_action( "rtframework_create_bg_image_carousel", "rtframework_create_bg_image_carousel", 10, 1 );


if( ! function_exists("rtframework_get_selected_fonts_list") ){
	/**
	 * Get selected fotns 
	 * 
	 * @return array $selected_fonts 
	 */
	function rtframework_get_selected_fonts_list() { 

		//fonts
		$heading_font = get_theme_mod( 'naturalife_heading_font' );
		$body_font = get_theme_mod( 'naturalife_body_font' );
		$secondary_font = get_theme_mod( 'naturalife_secondary_font' );
		$menu_font = get_theme_mod( 'naturalife_menu_font' );
		$sub_menu_font = get_theme_mod( 'naturalife_sub_menu_font' ); 
		$empty_font = array( 0 => "websafe", 1 => "arial" );

		$heading_font = ! empty( $heading_font ) ? explode("||", $heading_font ) : $empty_font;
		$body_font = ! empty( $body_font ) ? explode("||", $body_font ) : $empty_font;
		$secondary_font = ! empty( $secondary_font ) ? explode("||", $secondary_font ) : $empty_font;
		$menu_font = ! empty( $menu_font ) ? explode("||", $menu_font ) : $empty_font;
		$sub_menu_font = ! empty( $sub_menu_font ) ? explode("||", $sub_menu_font ) : $empty_font;
		$slider_heading_font = ! empty( $slider_heading_font ) ? explode("||", $slider_heading_font ) : $empty_font;
		$slider_sub_heading_font = ! empty( $slider_sub_heading_font ) ? explode("||", $slider_sub_heading_font ) : $empty_font;

		$selected_fonts["heading"] = is_array( $heading_font ) ? array( "kind" => $heading_font[0], "family" => $heading_font[1],  "subset" => get_theme_mod( RT_THEMESLUG.'_heading_font_subset' ), "variant" => get_theme_mod( RT_THEMESLUG.'_heading_font_variant' )  ) : "";
		$selected_fonts["body"] = is_array( $body_font ) ? array( "kind" => $body_font[0], "family" => $body_font[1],  "subset" => get_theme_mod( RT_THEMESLUG.'_body_font_subset' ), "variant" => get_theme_mod( RT_THEMESLUG.'_body_font_variant' )  ) : "";
		$selected_fonts["secondary"] = is_array( $secondary_font ) ? array( "kind" => $secondary_font[0], "family" => $secondary_font[1],  "subset" => get_theme_mod( RT_THEMESLUG.'_secondary_font_subset' ), "variant" => get_theme_mod( RT_THEMESLUG.'_secondary_font_variant' )  ) : "";
		$selected_fonts["menu"] = is_array( $menu_font ) ? array( "kind" => $menu_font[0], "family" => $menu_font[1],  "subset" => get_theme_mod( RT_THEMESLUG.'_menu_font_subset' ), "variant" => get_theme_mod( RT_THEMESLUG.'_menu_font_variant' )  ) : "";
		$selected_fonts["sub_menu"] = is_array( $sub_menu_font ) ? array( "kind" => $sub_menu_font[0], "family" => $sub_menu_font[1],  "subset" => get_theme_mod( RT_THEMESLUG.'_sub_menu_font_subset' ), "variant" => get_theme_mod( RT_THEMESLUG.'_sub_menu_font_variant' )  ) : "";


		return $selected_fonts;
	}
}
add_filter('template_redirect','rtframework_get_selected_fonts_list');


if( ! function_exists("rtframework_is_composer_allowed") ){
	/**
	 * RT Is composer allowed
	 * 
	 * check if the current content allowed to use visual composer
	 * @return bool
	 */
	function rtframework_is_composer_allowed() { 
		global $rtframework_post_type;

		if ( ! class_exists( 'RT_Custom_Posts' ) ) {
			return false;
		}

		if ( is_page() ){
			return true;
		}

		if ( is_single() && ( $rtframework_post_type == 'portfolio' ) ){
			return true;
		}		

		return false;
	}
} 
add_action( "init", "rtframework_is_composer_allowed");


if( ! function_exists("rtframework_is_built_with_elementor") ){
	/**
	 * Check if is built with elementor
	 * 
	 * @return bool
	 */
	function rtframework_is_built_with_elementor() { 
		$postid = get_the_ID();
		return ! ! get_post_meta( $postid, '_elementor_edit_mode', true );
	}
} 

if( ! function_exists("rtframework_is_css_dir_writeable") ){
	/**
	 * Check if the css dir is writable
	 * 
	 * @return bool
	 */
	function rtframework_is_css_dir_writeable() { 
		return is_writable( rtframework_get_custom_css_dir() );
	}
} 

if( ! function_exists("rtframework_get_custom_css_dir") ){
	/**
	 * Get custom css dir
	 * 
	 * @return $dir
	 */
	function rtframework_get_custom_css_dir() {  

		$upload_path = wp_upload_dir();

		$dir = $upload_path['basedir'] ."/". strtolower(RT_THEMESLUG). "/";
		return $dir;
	}
} 

if( ! function_exists("rtframework_get_custom_css_url") ){
	/**
	 * Get custom css url
	 * 
	 * @return $dir
	 */
	function rtframework_get_custom_css_url() { 

		$upload_path = wp_upload_dir();

		if(is_ssl()){
			$upload_path['baseurl'] = str_replace("http://", "https://", $upload_path['baseurl']);
			$upload_path['url'] = str_replace("http://", "https://", $upload_path['url']);
		}

		$url = $upload_path['baseurl'] ."/". strtolower(RT_THEMESLUG). "/";
		return $url;
	}
} 

if( ! function_exists("rtframework_create_dir") ){
	/**
	 * Creates a new dir
	 * 
	 * @return $dir
	 */
	function rtframework_create_dir( $dir = "" ) { 
		if( $dir == "" ) {
			return ;
		}
				
		wp_mkdir_p($dir);  
	}
} 

if( ! function_exists("rtframework_create_css_dir") ){
	/**
	 * Create the dynamic custom css dir
	 * 
	 * @return $dir
	 */
	function rtframework_create_css_dir() { 
		if( ! is_admin() ){
			return ;
		}

		rtframework_create_dir(rtframework_get_custom_css_dir());
	}
} 
add_action( 'init','rtframework_create_css_dir' );

if( ! function_exists("rtframework_custom_oembed_filter") ){
	/**
	 * 
	 * Responsive Videos
	 * 
	 * @param  string $html 
	 * @param  string $url
	 * @param  array $attr 
	 * @param  number $post_ID
	 * @return html
	 */
	function rtframework_custom_oembed_filter($html, $url, $attr, $post_ID) {
		$return = '<div class="video-container">'.$html.'</div>';
		return $return;
	}
} 
add_filter( 'embed_oembed_html', 'rtframework_custom_oembed_filter', 10, 4 ) ;

if( ! function_exists("rtframework_get_theme") ){
	/**
	 * Get Theme Data 
	 *
	 * Returns the theme data of orginal theme only not childs
	 * 
	 * @return void
	 */
	function rtframework_get_theme(){ 

		$theme_data = wp_get_theme(); 
		$main_theme_data = $theme_data->parent(); 

		if( ! empty( $main_theme_data ) ){		
			return $main_theme_data;
		}else{		
			return $theme_data;
		}
	}
}	

if( ! function_exists("rtframework_body_background_video") ){
	/**
	 * Body background video 
	 * 
	 * @return void
	 */
	function rtframework_body_background_video(){ 

		if( rtframework_get_setting("body_background_video_mp4") && rtframework_get_setting("body_background_video_webm") ){
			echo '<div id="body-bg-video" data-vide-bg="mp4: '.esc_html(rtframework_get_setting("body_background_video_mp4")).', webm: '.esc_html(rtframework_get_setting("body_background_video_webm")).', poster: none" ata-vide-options="posterType: none, loop: true, muted: true, position: 0% 0%"></div>';
		}		

	}
}	
add_action("rtframework_after_body","rtframework_body_background_video");

if( ! function_exists("rtframework_is_wc_shop") ){
	/**
	 * Check if WooCommerce installed and is it the shop page
	 * 
	 * @return void
	 */
	function rtframework_is_wc_shop(){ 

		if( ! function_exists("is_shop") ){
			return;
		}

		return is_shop();
	}
}	 

if( ! function_exists("rtframework_go_to_top") ){
	/**
	 * Go to top link 
	 * 
	 * @return output
	 */
	function rtframework_go_to_top(){ 		
		echo '<div class="go-to-top ui-icon-angle-up"></div>';		
	}
}	
if ( get_theme_mod( "naturalife_go_top_button" ) ) {
	add_action("wp_footer","rtframework_go_to_top", 10);
}

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
		echo apply_filters("rtframework_print_social_media_share","");
	}
}

if( ! function_exists("rtframework_page_loading_output") ){
	/**
	 * Page Loading Output
	 * 
	 * @return output
	 */
	function rtframework_page_loading_output( $url ){

		if( ! rtframework_get_setting("page_loading_effect") ){
			return;
		}

		$loading_logo = get_theme_mod( 'naturalife_loading_logo' );		 
	?>		
		<!-- loader -->
		<div id="loader-wrapper"> 
			<?php 
				//logo image output
				echo ! empty( $loading_logo ) ? wp_get_attachment_image( $loading_logo, "rtframework_retina", false, array( "class" => "loading-logo" )) : "";
			?>
		</div>
		<!-- / #loader -->
	<?php
	}
}

add_filter( 'rtframework_after_body', "rtframework_page_loading_output" );


if( ! function_exists("rtframework_get_logo_sets") ){
	/**
	 * Site logo
	 * 
	 * @return output
	 */
	function rtframework_get_logo_sets(){
			global $logo_sets;

			if( ! empty( $logo_sets ) ){
				return $logo_sets;
			}

			//get logo sets
			$logo_sets = array(
							"logo_dark" => array( "id"=> rtframework_get_setting('logo_dark') , "url" => "" ),
							"retina_logo_dark" => array( "id"=> rtframework_get_setting('retina_logo_dark') , "url" => "" ),
							"sticky_logo_dark" => array( "id"=> rtframework_get_setting('sticky_logo_dark') , "url" => "" ),
							"retina_sticky_logo_dark" => array( "id"=> rtframework_get_setting('retina_sticky_logo_dark') , "url" => "" ),
							"mobile_logo_dark" => array( "id"=> rtframework_get_setting('mobile_logo_dark') , "url" => "" ),
							"retina_mobile_logo_dark" => array( "id"=> rtframework_get_setting('retina_mobile_logo_dark') , "url" => "" ),
							"logo_light" => array( "id"=> rtframework_get_setting('logo_light') , "url" => "" ),
							"retina_logo_light" => array( "id"=> rtframework_get_setting('retina_logo_light') , "url" => "" ),
							"sticky_logo_light" => array( "id"=> rtframework_get_setting('sticky_logo_light') , "url" => "" ),
							"retina_sticky_logo_light" => array( "id"=> rtframework_get_setting('retina_sticky_logo_light') , "url" => "" ),
							"mobile_logo_light" => array( "id"=> rtframework_get_setting('mobile_logo_light') , "url" => "" ),
							"retina_mobile_logo_light" => array( "id"=> rtframework_get_setting('retina_mobile_logo_light') , "url" => "" ),
						);

			//retrive logo urls
			foreach ($logo_sets as $logoname => $logodata) {
				$logo_sets[$logoname]["url"] = ! empty( $logodata["id"] ) ? wp_get_attachment_image_src( $logodata["id"], "full" ) : "";
			}
			
			return $logo_sets;
	}
}


if( ! function_exists("rtframework_logo_function") ){
	/**
	 * Site logo
	 * 
	 * @return output
	 */
	function rtframework_logo_function(){

			//get logo sets
			$logo_sets = rtframework_get_logo_sets(); 			

			//retina srcsets
			$logo_dark_srcset = ! empty( $logo_sets["retina_logo_dark"]["url"] ) ? ' srcset="'.$logo_sets["retina_logo_dark"]["url"][0].' 1.3x"' : ""; 
			$logo_light_srcset = ! empty( $logo_sets["retina_logo_light"]["url"] ) ? ' srcset="'.$logo_sets["retina_logo_light"]["url"][0].' 1.3x"' : ""; 		 

			//logo outputs
			$logo_dark_output =  ! empty( $logo_sets["logo_dark"]["url"] ) ? sprintf( '<img width="%1$s" height="%2$s" src="%3$s" alt="%4$s" class="dark-logo logo-image"%5$s />', esc_attr( $logo_sets["logo_dark"]["url"][1] ), esc_attr( $logo_sets["logo_dark"]["url"][2] ), esc_url($logo_sets["logo_dark"]["url"][0]), esc_html(get_bloginfo('name')), $logo_dark_srcset ) : "" ;
			$logo_light_output =  ! empty( $logo_sets["logo_light"]["url"] ) ? sprintf( '<img width="%1$s" height="%2$s" src="%3$s" alt="%4$s" class="light-logo logo-image"%5$s />', esc_attr( $logo_sets["logo_light"]["url"][1] ), esc_attr( $logo_sets["logo_light"]["url"][2] ), esc_url($logo_sets["logo_light"]["url"][0]), esc_html(get_bloginfo('name')), $logo_light_srcset ) : "" ;
		?>	
			<div id="logo" class="site-logo"> 
			<?php							
			//logo output
			echo ( ! empty( $logo_dark_output ) ||  ! empty( $logo_light_output ) ) ? 
							sprintf( ' <a href="%1$s" title="%2$s">%3$s%4$s</a> ', RT_BLOGURL, esc_html(get_bloginfo('name')), $logo_dark_output, $logo_light_output ) :
							sprintf( ' <a href="%1$s" title="%2$s"><span class="sitename">%2$s</span></a> ', RT_BLOGURL, esc_html(get_bloginfo('name')) ) ;
			?>		
			</div><!-- / end #logo -->
	<?php
	}
}

if( ! function_exists("rtframework_sticky_logo_function") ){
	/**
	 * Sticky header logo
	 * 
	 * @return output
	 */
	function rtframework_sticky_logo_function(){

			//get logo sets
			$logo_sets = rtframework_get_logo_sets(); 			

			//sticky header skin
			$skin = rtframework_get_setting("header_color_skin_sticky");

			//use the main logo if empty	
			$sticky_logo = ! empty( $logo_sets["sticky_logo_".$skin]["url"] ) ? $logo_sets["sticky_logo_".$skin]["url"] : $logo_sets["logo_".$skin]["url"];
			$retina_sticky_logo = ! empty( $logo_sets["retina_sticky_logo_".$skin]["url"] ) ? $logo_sets["retina_sticky_logo_".$skin]["url"] : $logo_sets["retina_logo_".$skin]["url"];

			//retina srcsets
			$logo_srcset = ! empty( $retina_sticky_logo ) ? ' srcset="'.$retina_sticky_logo[0].' 1.3x"' : "";  

			//logo outputs
			$logo_output =  ! empty( $sticky_logo ) ? sprintf( '<img width="%1$s" height="%2$s" src="%3$s" alt="%4$s" class="sticky-logo"%5$s />', esc_attr( $sticky_logo[1] ), esc_attr( $sticky_logo[2] ), esc_url($sticky_logo[0]), esc_html(get_bloginfo('name')), $logo_srcset ) : "" ;

		?>	

		<div id="sticky-logo" class="site-logo">
			<?php							
			//logo output
			echo ( ! empty( $logo_output )  ) ? 
							sprintf( ' <a href="%1$s" title="%2$s">%3$s</a> ', RT_BLOGURL, esc_html(get_bloginfo('name')), $logo_output ) :
							sprintf( ' <a href="%1$s" title="%2$s"><span class="sitename">%2$s</span></a> ', RT_BLOGURL, esc_html(get_bloginfo('name')) ) ;
			?>		
		</div><!-- / end #sticky-logo -->

	<?php
	}
}

if( ! function_exists("rtframework_display_logo_function") ){
	/**
	 * Display Main Navigation
	 *
	 * Hooks rtframework_display_logo_function to display main logo
	 * @return action
	 */
	function rtframework_display_logo_function() {

		$header_logo_location = rtframework_get_setting("header_logo_location");

		//header second row is available for the header style 1
		if( rtframework_get_setting( "header_style" ) == 1 ){
			$header_logo_location = $header_logo_location > 3 ? 1 : $header_logo_location;
		}

		add_action( rtframework_get_location_name( $header_logo_location ), "rtframework_logo_function", 5 );	

		add_action( rtframework_get_location_name( rtframework_get_setting("sticky_header_logo_location"), true ), "rtframework_sticky_logo_function", 5 );	 				
 		 
	}
}
add_action( "template_redirect", "rtframework_display_logo_function");



if( ! function_exists("rtframework_mobile_logo_function") ){
	/**
	 * Mobile logo
	 * 
	 * @return output
	 */
	function rtframework_mobile_logo_function(){

			//get logo sets
			$logo_sets = rtframework_get_logo_sets(); 			

			//mobile header skin
			$skin = rtframework_get_setting("header_color_skin_mobile");

			//use the main logo if empty	
			$mobile_logo = ! empty( $logo_sets["mobile_logo_".$skin]["url"] ) ? $logo_sets["mobile_logo_".$skin]["url"] : $logo_sets["logo_".$skin]["url"];
			$retina_mobile_logo = ! empty( $logo_sets["retina_mobile_logo_".$skin]["url"] ) ? $logo_sets["retina_mobile_logo_".$skin]["url"] : $logo_sets["retina_logo_".$skin]["url"];

			//retina srcsets
			$logo_srcset = ! empty( $retina_mobile_logo ) ? ' srcset="'.$retina_mobile_logo[0].' 1.3x"' : "";  

			//logo outputs
			$logo_output =  ! empty( $mobile_logo ) ? sprintf( '<img width="%1$s" height="%2$s" src="%3$s" alt="%4$s" class="mobile-logo"%5$s />', esc_attr( $mobile_logo[1] ), esc_attr( $mobile_logo[2] ), esc_url($mobile_logo[0]), esc_html(get_bloginfo('name')), $logo_srcset ) : "" ;

		?>	

		<div id="mobile-logo" class="mobile-logo-holder">
			<?php							
			//logo output
			echo ( ! empty( $logo_output )  ) ? 
							sprintf( ' <a href="%1$s" title="%2$s">%3$s</a> ', RT_BLOGURL, esc_html(get_bloginfo('name')), $logo_output ) :
							sprintf( ' <a href="%1$s" title="%2$s"><span class="sitename">%2$s</span></a> ', RT_BLOGURL, esc_html(get_bloginfo('name')) ) ;
			?>		
		</div><!-- / end #mobile-logo -->

 
	<?php
	}
}

add_action( 'rtframework_mobile_header_left', "rtframework_mobile_logo_function", 30 );





if( ! function_exists("rtframework_navigation_function") ){
	/**
	 * Site logo
	 * 
	 * @return output
	 */
	function rtframework_navigation_function( $args = array() ){	
	?>
		<?php if( rtframework_get_setting("display_main_menu") ):?>
			
			<?php
				//check target
				$is_sticky_header_nav = isset( $args["target"] ) && $args["target"] == "sticky-header" ? true : false;

				//call the main navigation
				if ( rtframework_get_setting("custom_main_menu") != "" ){ // check if the current post has a custom menu

					$menuVars = array(
						'menu'            => rtframework_get_setting("custom_main_menu"),
						'menu_id'         => ! $is_sticky_header_nav ? "header-navigation" : "sticky-header-navigation",
						'menu_class'      => "main-menu",
						'echo'            => false,
						'container'       => 'nav', 
						'container_class' => 'main-menu-wrapper',
						'items_wrap'      => '<ul class="%2$s">%3$s</ul>',
						'container_id'    => '', 
						'theme_location'  => 'naturalife-main-navigation',
						'walker'          => new rtframework_menu_walker
					);

				}elseif ( has_nav_menu( 'naturalife-main-navigation' ) ){ // check if user created a custom menu and assinged to the rt-theme's location

					$menuVars = array(
						'menu_id'         => ! $is_sticky_header_nav ? "header-navigation" : "sticky-header-navigation",
						'menu_class'      => "main-menu",
						'echo'            => false,
						'container'       => 'nav', 
						'container_class' => 'main-menu-wrapper',
						'items_wrap'      => '<ul class="%2$s">%3$s</ul>',
						'container_id'    => '', 
						'theme_location'  => 'naturalife-main-navigation',
						'walker'          => new rtframework_menu_walker
					);
					
				}else{
					 
					$menuVars = array(
						'menu'            => esc_html_x('Main Navigation','Admin Panel','naturalife'),  
						'menu_id'         => ! $is_sticky_header_nav ? "header-navigation" : "sticky-header-navigation",
						'menu_class'      => "main-menu",
						'echo'            => false,
						'container'       => 'nav',  
						'container_class' => 'main-menu-wrapper' ,
						'items_wrap'      => '<ul class="%2$s">%3$s</ul>',
						'container_id'    => '',  
						'theme_location'  => 'naturalife-main-navigation',
						'walker'          => new rtframework_menu_walker
					);
				}

			?>    
					
			<?php echo wp_nav_menu($menuVars); //wp menu?> 
				
		<?php endif;?>

	<?php
	}
}

if( ! function_exists("rtframework_display_main_navigation") ){
	/**
	 * Display Main Navigation
	 *
	 * Hooks rtframework_display_main_navigation to display main navigation
	 * @return action
	 */
	function rtframework_display_main_navigation() {

		if( ! rtframework_get_setting("display_main_menu") ){
			return;
		}

		$header_menu_location = rtframework_get_setting("header_menu_location");

		//header second row is available for the header style 1
		if( rtframework_get_setting( "header_style" ) == 1 ){
			$header_menu_location = $header_menu_location > 3 ? 1 : $header_menu_location;
		}

		add_action( rtframework_get_location_name( $header_menu_location ), "rtframework_navigation_function", 20 );	
 		
		//sticky menu	
		add_action( rtframework_get_location_name( rtframework_get_setting("sticky_header_menu_location"), true ), "rtframework_navigation_function", 20 );	 

	}
}
add_action( "template_redirect", "rtframework_display_main_navigation");




if( ! function_exists("rtframework_get_location_name") ){
	/**
	 * Returns the header location name by id
	 * 
	 * @return string
	 */
	function rtframework_get_location_name( $number = 1, $sticky = false ){

	if( $number == "" )	{
		return;
	}

	if( ! $sticky ){
		$location_names = array(
			1 => "rtframework_header_first_left",
			2 => "rtframework_header_first_center",
			3 => "rtframework_header_first_right",
			4 => "rtframework_header_second_left",
			5 => "rtframework_header_second_center",
			6 => "rtframework_header_second_right"
		);
	}else{
		$location_names = array(
			1 => "rtframework_sticky_header_left",
			2 => "rtframework_sticky_header_center",
			3 => "rtframework_sticky_header_right"
		);
	}
	return  is_numeric( $number ) ? $location_names[$number] : "";
	}
}

if( ! function_exists("rtframework_change_cf7_loader") ){
	/**
	 * Changes CF7 plugins loader image
	 * 
	 * @return output
	 */
	function rtframework_change_cf7_loader( $url ){

	$url = RT_THEMEURI. '/images/preloader.gif';

	return $url;
	}
}

add_filter( 'wpcf7_ajax_loader', "rtframework_change_cf7_loader" );

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


if( ! function_exists("rtframework_mobile_menu") ){
	/**
	 * Creates mobile  menu
	 * @return output
	 */
	function rtframework_mobile_menu( $string="" , $class="" ){
			if( ! rtframework_get_setting("mobile_menu") ){
				return;
			}	 
		?>		 
				<?php
				/**
				 * rtframework_mobile_nav_before hook
				 * 
				 */
				do_action("rtframework_mobile_nav_before");
				?>		
	
				<nav class="mobile-nav">
					<?php
						//call the main navigation		
						if ( has_nav_menu( 'naturalife-mobile-navigation' ) ){ // check if user created a custom menu and assinged to the rt-theme's mobile location
							$menuVars = array(
								'menu_id'         => "mobile-navigation",
								'class'           => "menu",
								'echo'            => false,
								'container'       => '', 
								'container_class' => '',
								'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
								'theme_location'  => 'naturalife-mobile-navigation',
								'walker'          => new rtframework_menu_walker
							);							
						}elseif ( rtframework_get_setting( "custom_main_menu" ) != "" ){ // check if the current post has a custom menu

							$menuVars = array(
								'menu'            => rtframework_get_setting( "custom_main_menu" ),
								'menu_id'         => "mobile-navigation",
								'class'           => "menu",
								'echo'            => false,
								'container'       => '', 
								'container_class' => '',
								'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
								'theme_location'  => 'naturalife-main-navigation',
								'walker'          => new rtframework_menu_walker
							);							
						}elseif ( has_nav_menu( 'naturalife-main-navigation' ) ){ // check if user created a custom menu and assinged to the rt-theme's main location

							$menuVars = array(
								'menu_id'         => "mobile-navigation",
								'class'           => "menu",
								'echo'            => false,
								'container'       => '', 
								'container_class' => '',
								'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
								'theme_location'  => 'naturalife-main-navigation',
								'walker'          => new rtframework_menu_walker
							);							
						}else{
							
							$menuVars = array(
								'menu'            => esc_html_x('Main Navigation','Admin Panel','naturalife'),  
								'menu_id'         => "mobile-navigation",
								'class'           => "menu",
								'echo'            => false,
								'container'       => '',  
								'container_class' => '' ,
								'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
								'theme_location'  => 'naturalife-main-navigation',
								'walker'          => new rtframework_menu_walker
							);							
						}
						echo wp_nav_menu( $menuVars );			
					?>    
				</nav>

				<?php
				/**
				 * rtframework_mobile_nav_after hook
				 * 
				 */
				do_action("rtframework_mobile_nav_after");
				?>		
		<?php
	}
}	
add_action("rt_side_panel_contents","rtframework_mobile_menu",20);


if( ! function_exists("rtframework_check_unit") ){
	/**
	 * Checks the value for px or % and adds px if there is none
	 * @return output
	 */
	function rtframework_check_unit( $number ){ 

		$number = (string)$number;
		
		$check = preg_match("/(em)|(px)|(\\%)/",$number,$result);
		
		if( count( $result ) === 0 && $number != "" ){
			$number = preg_replace('/\D/', '', $number). "px";
		}

		return esc_attr( $number );

	}
}	  

if( ! function_exists("rtframework_convert_bool") ){
	/**
	 * Converts the bools, 1/0 or on/off to string true false 
	 * @return output
	 */
	function rtframework_convert_bool( $string ){ 

		if( is_bool( $string ) && $string == false ){
			return "false";
		}

		if( is_bool( $string ) && $string == true ){
			return "true";
		}

		if( ! $string || $string === "false" || $string == "false" || $string == "0" || $string == "off" ){
			return "false";
		}

		if( $string || $string === "true" || $string == "true" || $string == "1" || $string == "on" ){
			return "true";
		}

		return $string;

	}
}

if( ! function_exists("rtframework_staff_media_links") ){
	/**
	 * Staff Social Media Icons List  
	 * @param  string $post_id  
	 * @return html
	 */
	function rtframework_staff_media_links( $post_id = "" ){
		global $rtframework_social_media_icons;

		$social_media_output ='';			
		$target = "";					
		foreach ($rtframework_social_media_icons as $key => $value){
			

			//get the option values
			$link = get_post_meta($post_id, 'rttheme_'.$value, true); 
			$followText = get_post_meta($post_id, 'rttheme_'.$value.'_text', true); 		 
				

			if($value=="mail"){//e-mail icon link 
				
				if(strpos($link, "@")){
					$link = 'mailto:'.str_replace("mailto:", "", $link);
				}else{
					$link = str_replace("mailto:", "", $link);				
				} 

				$target = "_self";	

			}else{
				$link = $link;
				$target = "_blank";	
			} 


			//all icons
			if($link){
				$social_media_output .= '<li class="'.$value.'">';
				$social_media_output .= '<a class="ui-icon-'.$value.'" target="'.$target.'" href="'. $link .'" title="'. esc_attr( $key ) .'">';
				
				! empty( $followText )
				and	$social_media_output .= '<span>'. esc_attr( $followText ) .'</span>';

				empty( $followText )
				and	$social_media_output .= '<span>'. esc_attr( $key ) .'</span>';

				$social_media_output .= '</a>';
				$social_media_output .= '</li>';
			}
		}

		if($social_media_output){
			echo  '<div class="person_links_wrapper"><ul class="social_media staff">'.$social_media_output.'</ul></div>';
		}
	}
}
add_action( "rtframework_staff_media_links", "rtframework_staff_media_links", 10 , 1);	


if( ! function_exists("rtframework_meta_generator") ){
	/**
	 * Adds generator note related with the theme and plugins
	 * 
	 * @return output
	 */
	function rtframework_meta_generator(){ 
	
		$string = esc_html_x("Powered by",'Admin Panel','naturalife');
		$theme_data = rtframework_get_theme();

		$string .= " ". $theme_data["Name"];
		$string .= " ". $theme_data["Description"];

		if ( is_child_theme() ) {
			$string .= " CT:1";
		}

		$string .= ' TV:'. $theme_data["Version"];	 		

		if ( class_exists( 'Naturalife_Extensions' ) ) {

			if ( isset( Naturalife_Extensions::$version ) ){

				$string .= ' PV:'. Naturalife_Extensions::$version ;
			}
		}

		echo apply_filters('naturalife_meta_note', '<meta name="generator" content="'.$string.'" />'."\n");

	}
}	
add_action("wp_head","rtframework_meta_generator");


if( ! function_exists("rt_topbar_left_sidebar") ){
	/**
	 * Top bar left sidebar
	 */
	function rt_topbar_left_sidebar(){
		dynamic_sidebar('naturalife-sidebar-for-topbar-left');
	}
}

if(is_active_sidebar( "naturalife-sidebar-for-topbar-left" )){
	add_action( 'rt_topbar_left' , 'rt_topbar_left_sidebar', 10);
}

if( ! function_exists("rt_topbar_right_sidebar") ){
	/**
	 * Top bar right sidebar
	 */
	function rt_topbar_right_sidebar(){
		dynamic_sidebar('naturalife-sidebar-for-topbar-right');
	}
}

if(is_active_sidebar( "naturalife-sidebar-for-topbar-right" )){
	add_action( 'rt_topbar_right' , 'rt_topbar_right_sidebar', 10);
}


if( ! function_exists("rtframework_header_first_left_sidebar") ){
	/**
	 * Header first row - left sidebar
	 */
	function rtframework_header_first_left_sidebar(){

		//custom ?
		if( rtframework_get_setting( "header_first_row_widgets_1" ) == "custom" ) {
			rtframework_load_sidebar_list( rtframework_get_setting( "header_first_row_custom_widgets_1" ) );
			return;
		}

		//disabled ?
		if(  rtframework_get_setting( "header_first_row_widgets_1" ) == "disabled" || ! is_active_sidebar( "naturalife-sidebar-for-header-first-row-1" ) ) {
			return;
		}

		dynamic_sidebar('naturalife-sidebar-for-header-first-row-1');
	}
}
add_action( 'rtframework_header_first_left' , 'rtframework_header_first_left_sidebar', 40);


if( ! function_exists("rtframework_header_first_right_sidebar") ){
	/**
	 * Header first row - right sidebar
	 */
	function rtframework_header_first_right_sidebar(){

		//custom ?
		if( rtframework_get_setting( "header_first_row_widgets_2" ) == "custom" ) {
			rtframework_load_sidebar_list( rtframework_get_setting( "header_first_row_custom_widgets_2" ) );
			return;
		}

		//disabled ?
		if(  rtframework_get_setting( "header_first_row_widgets_2" ) == "disabled" || ! is_active_sidebar( "naturalife-sidebar-for-header-first-row-2" ) ) {
			return;
		}

		dynamic_sidebar('naturalife-sidebar-for-header-first-row-2');
	}
}

add_action( 'rtframework_header_first_right' , 'rtframework_header_first_right_sidebar', 10);



if( ! function_exists("rtframework_header_second_left_sidebar") ){
	/**
	 * Header second row - left sidebar
	 */
	function rtframework_header_second_left_sidebar(){

		//custom ?
		if( rtframework_get_setting( "header_second_row_widgets_1" ) == "custom" ) {
			rtframework_load_sidebar_list( rtframework_get_setting( "header_second_row_custom_widgets_1" ) );
			return;
		}

		//disabled ?
		if(  rtframework_get_setting( "header_second_row_widgets_1" ) == "disabled" || ! is_active_sidebar( "naturalife-sidebar-for-header-second-row-1" ) ) {
			return;
		}

		dynamic_sidebar('naturalife-sidebar-for-header-second-row-1');
	}
}
add_action( 'rtframework_header_second_left' , 'rtframework_header_second_left_sidebar', 40);


 
if( ! function_exists("rtframework_header_second_right_sidebar") ){
	/**
	 * Header second row - right sidebar
	 */
	function rtframework_header_second_right_sidebar(){

		//custom ?
		if( rtframework_get_setting( "header_second_row_widgets_2" ) == "custom" ) {
			rtframework_load_sidebar_list( rtframework_get_setting( "header_second_row_custom_widgets_2" ) );
			return;
		}

		//disabled ?
		if(  rtframework_get_setting( "header_second_row_widgets_2" ) == "disabled" || ! is_active_sidebar( "naturalife-sidebar-for-header-second-row-2" ) ) {
			return;
		}

		dynamic_sidebar('naturalife-sidebar-for-header-second-row-2');
	}
}
add_action( 'rtframework_header_second_right' , 'rtframework_header_second_right_sidebar', 10);


if( ! function_exists("rtframework_sticky_header_left_sidebar") ){
	/**
	 * Sticky Header Left Sidebar
	 */
	function rtframework_sticky_header_left_sidebar(){
		dynamic_sidebar('naturalife-sidebar-for-sticky-header-left');
	}
}
add_action( 'rtframework_sticky_header_left' , 'rtframework_sticky_header_left_sidebar', 40);

if( ! function_exists("rtframework_sticky_header_right_sidebar") ){
	/**
	 * Sticky Header Right Sidebar
	 */
	function rtframework_sticky_header_right_sidebar(){
		dynamic_sidebar('naturalife-sidebar-for-sticky-header-right');
	}
}
add_action( 'rtframework_sticky_header_right' , 'rtframework_sticky_header_right_sidebar', 10);

if( ! function_exists("rtframework_load_sidebar_list") ){
	/**
	 * 	
	 * Loads the sidebar list
	 * 
	 * @param  array $sidebar_list  
	 * @return function
	 * 
	 */
	function rtframework_load_sidebar_list( $sidebar_list = array() ){
		if( is_array( $sidebar_list )  && ! empty( $sidebar_list ) ){
			foreach ($sidebar_list as $key => $custom_sidebar_id ) {
				dynamic_sidebar($custom_sidebar_id);
			}
			return;
		}
	}
}



if( ! function_exists("rtframework_get_post_navigation") ){
	/**
	 * [rt_get_post_navigation description]
	 * @return [type] [description]
	 */
	function rtframework_get_post_navigation(){
		global $post;		
		
		if ( is_singular( "post" ) ){
			if( ! rtframework_get_setting("blog_navigation") ){
				return false;
			}

			$taxomony = "portfolio_categories";
			$button_texts = array(
									esc_html__("Next Post","naturalife"),
									esc_html__("Previous Post","naturalife"),									
									esc_html__("All Posts","naturalife")
								);
			
			$start_page = rtframework_wpml_page_id( rtframework_get_setting( 'rt_blogpage' ) );
		}

		if ( is_singular( "portfolio" ) ){
			if( ! rtframework_get_setting("portfolio_navigation") ){
				return false;
			}

			$taxomony = "portfolio_categories";
			$button_texts = array(
									esc_html__("Next Project","naturalife"),
									esc_html__("Previous Project","naturalife"),									
									esc_html__("All Projects","naturalife")
								);
			
			$start_page = rtframework_wpml_page_id( rtframework_get_setting( 'rt_portfoliopage' ) );
		}

		if ( post_password_required() || ! isset( $taxomony ) ){
			return false;
		}	

		if( ! empty( $start_page ) ){
			$start_page = get_post( $start_page );		
		}


		//next and previous links 
		$prev = get_adjacent_post(apply_filters("rtframework_post_nav_in_same_term", false ),"",true, $taxomony);
		$next = get_adjacent_post(apply_filters("rtframework_post_nav_in_same_term", false ),"",false, $taxomony);

		$next_button  = $next ? sprintf('<a href="%1$s" title="%2$s" class="rt-next-post">%3$s</a>',get_permalink($next->ID), $next->post_title, $next->post_title ) : "";
		$prev_button  = $prev ? sprintf('<a href="%1$s" title="%2$s" class="rt-prev-post">%3$s</a>',get_permalink($prev->ID), $prev->post_title, $prev->post_title ) : "";
		$all_button  =  $start_page ? sprintf('<a href="%1$s" title="%2$s" class="all-posts ui-icon-cubes"></a>',get_permalink($start_page->ID), $start_page->post_title ) : "";


		printf('
		<div class="content-row default-style fullwidth naturalife-post-navigation">
			 <div class="content-row-wrapper default row align-items-center">
				<div class="col col-12 col-lg-5">%1$s</div>
				<div class="col col-12 col-lg-2">%2$s</div>
				<div class="col col-12 col-lg-5">%3$s</div>
			 </div>
		</div>
		',$prev_button, $all_button, $next_button);
	}
}
add_action( "rtframework_end_main_content", "rtframework_get_post_navigation", 30 );


if( ! function_exists("rtframework_is_content_empty") ){
	/**
	 * Checks the given post content is empty 
	 * @return bool
	 */
	function rtframework_is_content_empty( $content = "" ){
		return trim(str_replace('&nbsp;','',strip_tags($content))) == '';
	}
}

if( ! function_exists("rtframework_side_panel_languages") ){
	/**
	 * Creates language list for side panel
	 * @return output
	 */
	function rtframework_side_panel_languages(){

		if( ! function_exists('icl_get_languages') || ! rtframework_get_setting( "header_wpml" ) ){
			return;
		}	

		$languages = icl_get_languages('skip_missing=0'); 
		foreach($languages as $l){
			if( $l["active"] ){
				$current_language = $l;
				break;
			}
		}

		if( ! isset( $current_language ) ){
			return;
		}

		$code = isset( $current_language['code'] ) ? $current_language['code'] : "";
		$code = isset( $current_language['language_code'] ) ? $current_language['language_code'] : $code;
		$img_url = file_exists(get_template_directory()."/images/flags/".$code.".png") ? get_template_directory_uri()."/images/flags/".$code.".png" : $current_language['country_flag_url'];
		?>
		<nav class="naturalife-language-switcher">
			<ul class="menu">
				<li class="menu-item-has-children">
					<a href="#" title="<?php esc_attr_e("Switch the language","naturalife");?>">
						<span class="rt-flag" style="background-image:url('<?php echo esc_url($img_url);?>')"></span>
						<span class="rt-language-name" lang="<?php echo esc_attr( $current_language['default_locale']);?>"><?php echo esc_attr($current_language['native_name'])?></span>
					</a>
					<?php rtframework_wpml_languages_custom_flags();?>
				</li>
			</ul>
		</nav>
		<?php
	}
}
add_action("rt_side_panel_contents","rtframework_side_panel_languages",10);


if( ! function_exists("rtframework_header_languages") ){
	/**
	 * Creates language list for header
	 * @return output
	 */
	function rtframework_header_languages(){

		if( ! function_exists('icl_get_languages') || ! rtframework_get_setting( "header_wpml" ) ){
			return;
		}	

		$languages = icl_get_languages('skip_missing=0'); 
		foreach($languages as $l){
			if( $l["active"] ){
				$current_language = $l;
				break;
			}
		}

		if( ! isset( $current_language ) ){
			return;
		}

		$code = isset( $current_language['code'] ) ? $current_language['code'] : "";
		$code = isset( $current_language['language_code'] ) ? $current_language['language_code'] : $code;
		$img_url = file_exists(get_template_directory()."/images/flags/".$code.".png") ? get_template_directory_uri()."/images/flags/".$code.".png" : $current_language['country_flag_url'];
		?>
		<div class="naturalife-language-switcher widget">
			<ul>
				<li>
					<a href="#" title="<?php esc_attr_e("Switch the language","naturalife");?>">
						<span class="rt-flag" style="background-image:url('<?php echo esc_url($img_url);?>')"></span>
						<span class="rt-language-name"><?php echo esc_attr($current_language['native_name'])?></span>
					</a>
					<?php rtframework_wpml_languages_custom_flags();?>
				</li>
			</ul>
		</div>
		<?php
	}
}

if( ! function_exists("rtframework_top_shortcut_buttons") ){
	/**
	 * RT Shortcut Buttons
	 *
	 * Creates the HTML output of the shortcut buttons on the header
	 * @return output
	 */
	function rtframework_top_shortcut_buttons() {
		global $rt_post_type;

		$current_action = current_action();
		$display_wrapper = false;

		if( class_exists('Woocommerce') && rtframework_get_setting( "header_cart" ) ){
			$display_wrapper = true;
		}

		if( class_exists('Woocommerce') && rtframework_get_setting( "header_user" ) ){
			$display_wrapper = true;
		}

		if( rtframework_get_setting( "header_search" ) ){
			$display_wrapper = true;
		}

		if( $current_action == "rtframework_mobile_header_right"  && rtframework_get_setting( "header_sidepanel_mobile" ) ){
			$display_wrapper = true;
		}

		if( $current_action == "rtframework_header_first_right"  && rtframework_get_setting( "header_sidepanel" ) ){
			$display_wrapper = true;
		}

		if( ! $display_wrapper ){
			return;
		}

		?>
			<div class="header-tools">
				<ul>
					<?php
					/**
					 * rt_nav_buttons hook
					 *
					 * @hooked rtframework_user_button - 15
					 * @hooked rtframework_cart_button - 20
					 * @hooked rtframework_hamburger_search_button - 30
					 * @hooked rtframework_side_panel_button - 40
					 */
					do_action("rt_nav_buttons");
					?>
				</ul>
			</div><!-- / end .nav-buttons -->
		<?php
	}
}

if( ! function_exists("rtframework_display_shortcut_buttons") ){
	/**
	 * Display place for top shortcut buttons
	 *
	 * @return action
	 */
	function rtframework_display_shortcut_buttons() {

		$header_icon_location = rtframework_get_setting("header_icon_location");

		//header second righ and left  are not available for the header 3-4
		if( rtframework_get_setting( "header_style" ) == 1 ){
			$header_icon_location = $header_icon_location > 3 ? 3 : $header_icon_location;
		}

		//main header shortcut buttons
		add_action( rtframework_get_location_name( $header_icon_location ), "rtframework_header_languages", 25 );			
		add_action( rtframework_get_location_name( $header_icon_location ), "rtframework_top_shortcut_buttons", 30 );			

		//sticky header shortcut buttons
		add_action( rtframework_get_location_name( rtframework_get_setting("sticky_header_icon_location"), true ), "rtframework_header_languages", 25 );	 
		add_action( rtframework_get_location_name( rtframework_get_setting("sticky_header_icon_location"), true ), "rtframework_top_shortcut_buttons", 30 );	 

		//mobile 
		add_action( 'rtframework_mobile_header_right', "rtframework_top_shortcut_buttons", 30 );	
	}
}
add_action( "template_redirect", "rtframework_display_shortcut_buttons");


if( ! function_exists("rtframework_cart_button") ){
	/**
	 * Creates a cart button
	 * @return output
	 */
	function rtframework_cart_button(){

		if( ! class_exists('Woocommerce') || ! rtframework_get_setting( "header_cart" ) ){
			return;
		}

		global $woocommerce;
		?>
			<li class="cart tools-icon">
				<a href="#" class="naturalife-cart-menu-button">
					<span class="ui-icon-cart"><sub class="naturalife-cart-items<?php echo ( 0 == $woocommerce->cart->cart_contents_count ) ? " empty" : "";?>"><?php echo esc_attr($woocommerce->cart->cart_contents_count) ?></sub></span>
				</a>
			</li>
		<?php

	}
}
add_action("rt_nav_buttons","rtframework_cart_button",20);

if( ! function_exists("rtframework_user_button") ){
	/**
	 * Creates a user button
	 * @return output
	 */
	function rtframework_user_button(){

		if( ! class_exists('Woocommerce') || ! rtframework_get_setting( "header_user" ) ){
			return;
		}

		echo '<li class="user tools-icon"><a href="#" class="naturalife-user-menu-button"><span class="ui-icon-profile"></span></a></li>'."\n";

	}
}
add_action("rt_nav_buttons","rtframework_user_button",15);

if( ! function_exists("rtframework_search_button") ){
	/**
	 * Creates a search button
	 * @return output
	 */
	function rtframework_search_button(  $number ){

		if( ! rtframework_get_setting( "header_search" ) ){
			return;
		}

		echo '<li class="search-button tools-icon"><a href="#" class="naturalife-search-button" title="'.esc_html__("Search","naturalife").'"><span class="ui-icon-top-search"></span></a></li>'."\n";

	}
}
add_action("rt_nav_buttons","rtframework_search_button",30);

if( ! function_exists("rtframework_side_panel_button") ){
	/**
	 * Creates a side paanel button
	 * @return output
	 */
	function rtframework_side_panel_button(  $number ){

		if( ! rtframework_get_setting( "header_sidepanel" )  && ! rtframework_get_setting( "header_sidepanel_mobile" ) ){
			return;
		}

		echo '<li class="naturalife-sidepanel-button-holder"><a href="#" class="naturalife-sidepanel-button"><span></span><span></span><span></span></a></li>'."\n";

	}
}
add_action("rt_nav_buttons","rtframework_side_panel_button",40);


if( ! function_exists("rtframework_side_panel") ){
	/**
	 * Creates a side panel
	 * @return output
	 */
	function rtframework_side_panel( $string="" , $class="" ){

			echo '<div class="naturalife-panel-holder">'."\n";
			echo "\t".'<div class="naturalife-panel-wrapper">'."\n";
			echo "\t\t".'<div class="naturalife-panel-contents">'."\n";

			/**
			 * rt_side_panel_contents hook
			 * 
			 * @hooked rtframework_mobile_menu - 20 
			 * @hooked rtframework_side_panel_desktop_widgets - 30
			 * @hooked rtframework_side_panel_mobile_widgets - 40
			 * @hooked rtframework_side_panel_global_widgets - 50
			 * @hooked rtframework_side_panel_cart - 50
			 *
			 */

			do_action('rt_side_panel_contents');

			echo "\t\t".'</div>'."\n";
			echo "\t".'</div>'."\n";			
			echo '</div>'."\n";
			echo '<div class="naturalife-panel-background"></div>'."\n";
			echo '<div class="naturalife-panel-close ui-icon-exit"></div>'."\n";
	}
}
add_action("wp_footer","rtframework_side_panel",10);

 
if( ! function_exists("rtframework_side_panel_desktop_widgets") ){
	/**
	 * Calls sidebar-for-side-panel-desktop in side panel
	 * @return output
	 */
	function rtframework_side_panel_desktop_widgets(){
		echo '<div class="side-panel-widgets-desktop">'."\n";
			dynamic_sidebar('naturalife-sidebar-for-side-panel-desktop');
		echo '</div>'."\n";
	}
}
add_action("rt_side_panel_contents","rtframework_side_panel_desktop_widgets",30);

if( ! function_exists("rtframework_side_panel_mobile_widgets") ){
	/**
	 * Calls sidebar-for-side-panel-desktop in side panel
	 * @return output
	 */
	function rtframework_side_panel_mobile_widgets(){
		echo '<div class="side-panel-widgets-mobile">'."\n";
			dynamic_sidebar('naturalife-sidebar-for-side-panel-mobile');
		echo '</div>'."\n";
	}
}
add_action("rt_side_panel_contents","rtframework_side_panel_mobile_widgets",40);

if( ! function_exists("rtframework_side_panel_global_widgets") ){
	/**
	 * Calls sidebar-for-side-panel-global in side panel
	 * @return output
	 */
	function rtframework_side_panel_global_widgets(){
		echo '<div class="side-panel-widgets-global">'."\n";
			dynamic_sidebar('naturalife-sidebar-for-side-panel-global');
		echo '</div>'."\n";
	}
}
add_action("rt_side_panel_contents","rtframework_side_panel_global_widgets",50);


if( ! function_exists("rtframework_side_panel_cart") ){
	/**
	 * Displays cart in side panel
	 * @return output
	 */
	function rtframework_side_panel_cart(){
		if ( ! class_exists( 'Woocommerce' ) ) {
			return;
		}

		echo '<div class="widget woocommerce widget_shopping_cart">'."\n";
		echo '<h5>'. esc_html__('Cart','naturalife') .'</h5>'."\n";
		echo '<div class="widget_shopping_cart_content"></div>'."\n";
		echo '</div>'."\n";
	}
}
add_action("rt_side_panel_contents","rtframework_side_panel_cart",50);


if( ! function_exists("rtframework_side_panel_user") ){
	/**
	 * Displays user login in side panel
	 * @return output
	 */
	function rtframework_side_panel_user(){

		if( ! class_exists('Woocommerce') || ! rtframework_get_setting( "header_user" ) ){
			return;
		}
		 
	?>

		<?php if ( is_user_logged_in() ) : ?>
			
			<div class="widget rt_woocommerce_login">

				<h5><?php esc_html_e('Your Account','naturalife'); ?></h5>

				<p>
					<?php
						global $current_user;
						printf( esc_html__( 'Hello', 'naturalife' ).' <strong>%1$s</strong>', $current_user->display_name );
					?>
					<br />
					<?php
						printf( '<a href="%1$s" title="%2$s">%2$s</a> | <a href="%3$s" title="%4$s">%4$s</a>', 
							get_permalink( rtframework_wpml_translated_page_id( get_option('woocommerce_myaccount_page_id') ) ),
							esc_html__("account page","naturalife"),																									
							wp_logout_url( get_permalink( wc_get_page_id( 'myaccount' ) ) ),
							esc_html__("logout","naturalife")
						);
					?>
				</p>

			</div>

		<?php else: ?>

			<div class="widget rt_woocommerce_login">
				<h5><?php esc_html_e('Login','naturalife'); ?></h5>

				<?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ): ?>
					<?php esc_html_e("Not registered yet?",'naturalife')?> <a href="<?php echo esc_url( get_permalink( get_option('woocommerce_myaccount_page_id') ) ); ?>" title="<?php esc_html_e('Register','naturalife'); ?>"><?php esc_html_e('Register','naturalife'); ?></a></p>
				<?php endif;?>

				<form method="post" class="login" action="<?php echo esc_url( get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) ); ?>">

					<?php do_action( 'woocommerce_login_form_start' ); ?>

					<p class="form-row form-row-wide">
						<label for="username"><?php esc_html_e( 'Username or email address', 'naturalife' ); ?> <span class="required">*</span></label>
						<input type="text" class="input-text" name="username" id="username" value="<?php if ( ! empty( $_POST['username'] ) ) echo esc_attr( $_POST['username'] ); ?>" />
					</p>
					<p class="form-row form-row-wide">
						<label for="password"><?php esc_html_e( 'Password', 'naturalife' ); ?> <span class="required">*</span></label>
						<input class="input-text" type="password" name="password" id="password" />
					</p>

					<?php do_action( 'woocommerce_login_form' ); ?>

					<p class="form-row">
						<?php wp_nonce_field( 'woocommerce-login' ); ?>
						<input type="submit" class="button" name="login" value="<?php esc_attr_e( 'Login', 'naturalife' ); ?>" />
						<label for="rememberme" class="inline">
							<input name="rememberme" type="checkbox" id="rememberme" value="forever" /> <?php esc_html_e( 'Remember me', 'naturalife' ); ?>
						</label>
					</p>
					<p class="lost_password">
						<a href="<?php echo esc_url( wc_lostpassword_url() ); ?>"><?php esc_html_e( 'Lost your password?', 'naturalife' ); ?></a>
					</p>

					<?php do_action( 'woocommerce_login_form_end' ); ?>

				</form>
			</div>

		<?php endif;?>

	<?php
	}
}
add_action("rt_side_panel_contents","rtframework_side_panel_user",50);


if( ! function_exists("rtframework_popup_search") ){
	/**
	 * Popup search
	 * @return output
	 */
	function rtframework_popup_search(){

		if( ! rtframework_get_setting( "header_search" ) ){
			return;
		}

		get_template_part( "popup-search" );
	}
}
add_action("wp_footer","rtframework_popup_search",1);

if( ! function_exists("rtframework_popup_share") ){
	/**
	 * Popup social share 
	 * @return output
	 */
	function rtframework_popup_share(){
	?>	
	<div class="rt-popup rt-popup-share">
		<div class="rt-popup-content-wrapper d-flex align-items-center">
			<button class="rt-popup-close ui-icon-exit"></button>
			<div class="rt-popup-content default-style">
				<div class="naturalife-share-content">				
					<ul></ul>
				</div>
			</div>
		</div>
	</div>
	<?php
	}
}
add_action("wp_footer","rtframework_popup_share",1);


if( ! function_exists("rtframework_half_image_resize_dimensions") ){
	/**
	 * Adds a filter to image resize default dimensions and creates %50 smaller of the orhinal size for retina
	 * @return output
	 */
	function rtframework_half_image_resize_dimensions( $payload, $orig_w, $orig_h, $dest_w, $dest_h, $crop ){
		if($dest_w === 50000){ //if half image size
			$width = $orig_w/2;
			$height = $orig_h/2;
			return array( 0, 0, 0, 0, $width, $height, $orig_w, $orig_h );
		} else { //do not use the filter
			return $payload;
		}
	}
}
add_filter( 'image_resize_dimensions', 'rtframework_half_image_resize_dimensions', 5, 6 );
add_image_size('rtframework_retina', 50000, 50000);


if( ! function_exists("rtframework_retina_srcset") ){
	/**
	 * adds 1.3x srcset string to rtframework_retina size images
	 * @return array
	 */
	function rtframework_retina_srcset( $attr, $attachment, $size ){

		if( $size != "rtframework_retina" ){
			return $attr;
		}

		$image = wp_get_attachment_image_src( $attachment->ID, "full" );
		$image_url = is_array( $image ) ? $image[0] : "";

		$attr["srcset"] .= ','.$image_url.' 1.3x';

		return $attr;		
	}
}
add_filter("wp_get_attachment_image_attributes", "rtframework_retina_srcset", 50, 3);


if( ! function_exists("rtframework_header_menu_widget_arguments") ){
	/**
	 * Manipulates the arguments of the default menu widget for header widget areas
	 * @return output
	 */
	function rtframework_header_menu_widget_arguments( $nav_menu_args, $nav_menu, $args, $instance ){

		if( ! isset( $args["id"] ) ){		
			$nav_menu_args["container"] = "nav"; 
			$nav_menu_args["container_class"] = "main-menu-wrapper"; 
			$nav_menu_args["menu_class"] = "main-menu"; 
			$nav_menu_args["walker"] =  new rtframework_menu_walker;
			$nav_menu_args["items_wrap"] =  '<ul class="%2$s">%3$s</ul>';			
			return $nav_menu_args;
		}

		if(
			$args["id"]=="naturalife-sidebar-for-header-first-row-1" ||
			$args["id"]=="naturalife-sidebar-for-header-first-row-2" || 
			$args["id"]=="naturalife-sidebar-for-header-second-row-1" || 
			$args["id"]=="naturalife-sidebar-for-header-second-row-2"
		){
			$nav_menu_args["container"] = "nav"; 
			$nav_menu_args["container_class"] = "main-menu-wrapper"; 
			$nav_menu_args["menu_class"] = "main-menu"; 
			$nav_menu_args["walker"] =  new rtframework_menu_walker;
			$nav_menu_args["items_wrap"] =  '<ul class="%2$s">%3$s</ul>';
		}
		return $nav_menu_args;
	}	
}
add_filter( "widget_nav_menu_args", "rtframework_header_menu_widget_arguments", 10, 4 );	


if ( ! function_exists("rtframework_save_elementor_defaults") ){
	/**
	 *
	 * Save default schemes for elementor
	 *
	 */
	function rtframework_save_elementor_defaults(){

		if( ! class_exists("Elementor\Plugin") ){
			return;
		}

		if( ! get_option( "rtframework_elementor_defaults_updated" ) ){

			//default typography
			$default_fonts = array(); 			
			$default_fonts[1] = array('font_family' => '', 'font_weight' => '');
			$default_fonts[2] = array('font_family' => '', 'font_weight' => '');
			$default_fonts[3] = array('font_family' => '', 'font_weight' => '');
			$default_fonts[4] = array('font_family' => '', 'font_weight' => '');

			update_option( "elementor_scheme_typography", $default_fonts );

			//default color scheme
			$default_colors = array(); 			 
			$default_colors[1] = "#383D41";
			$default_colors[2] = "#b9b9b9";
			$default_colors[3] = "#808891";
			$default_colors[4] = "#84BE38";

			update_option( "elementor_scheme_color", $default_colors );			

			//settings
			update_option( "elementor_container_width", 1240 );						
			update_option( "elementor_disable_color_schemes", "yes" );
			update_option( "elementor_disable_typography_schemes", "yes" );

			//activate cpts
			$activated_cpts = get_option( "elementor_cpt_support", array() );
			$activate_cpts = array("page","post","portfolio");

			foreach ( $activate_cpts as $cpt) {
				if( ! in_array( $cpt, $activated_cpts) ){
					$activated_cpts[] = $cpt;
				}
			}

			update_option( "elementor_cpt_support", $activated_cpts, null );

			//color picker colors
			$color_picker_colors = array(); 
			
			$color_picker_colors[1] = "#84BE38";
			$color_picker_colors[2] = "#808891";
			$color_picker_colors[3] = "#b9b9b9";
			$color_picker_colors[4] = "#ffffff";
			$color_picker_colors[5] = "#383D41";
			$color_picker_colors[6] = "#E1E8EE";
			$color_picker_colors[7] = "#528510";
			$color_picker_colors[8] = "#f7f8f9"; 

 
			update_option( "elementor_scheme_color-picker", $color_picker_colors );		

		}

		//saved
		update_option( "rtframework_elementor_defaults_updated", 1);
	}
} 

if ( ! function_exists("rtframework_after_elementor_activated") ){
	/**
	 *
	 *  After Elementor Activated
	 *
	 */
	function rtframework_after_elementor_activated( $plugin, $network_activation ) {
		if( $plugin == "elementor/elementor.php" ){
			rtframework_save_elementor_defaults();
		}
	}
}	

add_action( 'activated_plugin', 'rtframework_after_elementor_activated', 10, 2 );
add_action( 'after_switch_theme', 'rtframework_save_elementor_defaults', 10 );

if ( ! function_exists("rtframework_fix_multiple_widget_ids") ){
	/**
	 *
	 *  Fixes multiple widget ids that causes HTML validation error
	 *
	 */
	function rtframework_fix_multiple_widget_ids($params) {
			global $rtframework_collect_widget_ids;

			$rtframework_collect_widget_ids = empty( $rtframework_collect_widget_ids ) ? array() : $rtframework_collect_widget_ids;

			if( in_array( $params[0]["widget_id"], $rtframework_collect_widget_ids ) ){
				preg_match_all('/id=\"([^"]*)\"/', $params[0]['before_widget'], $find_id, PREG_SET_ORDER, 0);
				if( isset( $find_id[0][1] ) ){
					$params[0]['before_widget'] = str_replace($find_id[0][1], $find_id[0][1]."-".count($rtframework_collect_widget_ids), $params[0]['before_widget']);
				}
			}

			$rtframework_collect_widget_ids[] = $params[0]['widget_id'];

			return $params;				
	}
}			
add_filter( 'dynamic_sidebar_params', 'rtframework_fix_multiple_widget_ids', 100);



if ( ! function_exists("rtframework_hex2rgba") ){
	/**
	 *
	 *  Converts hex color to rgba
	 *
	 */
	function rtframework_hex2rgba($color, $opacity = false) {
	 
		//Return default if no color provided or not hex
		if( empty($color) || strpos( $color, "#" ) === false ){
			return $color;
		}
	 
		$color = substr( $color, 1 ); 
 
		//Check if color has 6 or 3 characters and get values
		if (strlen($color) == 6) {
				$hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
		} elseif ( strlen( $color ) == 3 ) {
				$hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
		} else {
				return $color;
		}
 
		//Convert hexadec to rgb
		$rgb =  array_map('hexdec', $hex);
 
		//Check if opacity is set(rgba or rgb)
		if($opacity){
			if(abs($opacity) > 1)
				$opacity = 1.0;
			$output = 'rgba('.implode(",",$rgb).','.$opacity.')';
		} else {
			$output = 'rgb('.implode(",",$rgb).')';
		}
 
		//Return rgb(a) color string
		return $output;
	}
}

if ( ! function_exists("rtframework_exclude_update_checks") ){
	/**
	 *
	 *  Exclude the theme from update checks
	 *
	 */
	function rtframework_exclude_update_checks( $r, $url ) {

		if ( 0 !== strpos( $url, 'http://api.wordpress.org/themes/update-check' ) || 0 !== strpos( $url, 'https://api.wordpress.org/themes/update-check' ) ){
			return $r;
		}

		$themes = unserialize( $r['body']['themes'] );
		unset( $themes[ get_option( 'template' ) ] );
		unset( $themes[ get_option( 'stylesheet' ) ] );
		$r['body']['themes'] = serialize( $themes );
		return $r;
	}
}
add_filter( 'http_request_args', 'rtframework_exclude_update_checks', 5, 2 );



if ( ! function_exists("rtframework_blog_loop_divider") ){
	/**
	 *
	 *  Add divider blog loops
	 *
	 */
	function rtframework_blog_loop_divider() {

		$rtframework_blog_list_atts = rtframework_get_global_value("rtframework_blog_list_atts");

		if( $rtframework_blog_list_atts["list_layout"] != "1/1" || $rtframework_blog_list_atts["list_layout"] == "boxed" ){
			return;
		}

		echo '<svg class="entry-divider" width="312" height="22" viewBox="0 0 312 22" xmlns="http://www.w3.org/2000/svg"><path d="M156.236 11.093L146.404 1.01l9.832 10.083 9.548-9.536-9.548 9.536zm0 0l9.617 9.863-9.617-9.863-9.89 9.877 9.89-9.877zm27.514.157h128.01-128.01zm-183.5 0h128.01H.25z" stroke-width=".5" fill="none" fill-rule="evenodd" stroke-linecap="square"/></svg>';
	}
}
add_action( 'rtframework_after_blog_loop', 'rtframework_blog_loop_divider', 5, 2 );



if( ! function_exists("rtframework_importer_fix_elementor_imgurls") ){
	/**
	 *
	 * Fix Elementor Media URLs
	 * Replace all demo media urls in elementor data during import 
	 *
	 */
	function rtframework_importer_fix_elementor_imgurls( $post_meta ){

		foreach ( $post_meta as &$meta ) {
			if ( '_elementor_data' === $meta['key'] ) {
					
				$page_data = $meta['value'];
				$upload_dir = wp_upload_dir();  

				$re = "/(\"url\"\:\")(.*?)(\")/i";
				preg_match_all($re, $page_data, $matches); 

				if( $matches ) {
					foreach ( $matches[2] as $url ) {
						if( strpos($url, "uploads") ){ 
							$url = stripcslashes($url); 
							$new_url = preg_replace("/(.*)(.{8}+\/.+)/i", $upload_dir['baseurl'].'$2', $url);  
							$page_data = str_replace( addcslashes( $url , '/' ) , addcslashes($new_url, '/' ), $page_data); 
							$page_data = str_replace( $url , $new_url, $page_data);  				
						}
					}
				}

				$meta['value'] = $page_data;
				break;							
			}
		}

		return $post_meta; 
 	}
}
add_filter( 'wp_import_post_meta', 'rtframework_importer_fix_elementor_imgurls', 1);

if( ! function_exists("rtframework_importer_fix_elementor_slashes") ){
	/**
	 *
	 * Fix Elementor Slashes
	 * Elementor data needs to be slashed during import
	 *
	 */
	function rtframework_importer_fix_elementor_slashes( $post_meta ){

		foreach ( $post_meta as &$meta ) {
			if ( '_elementor_data' === $meta['key'] ) {
					
				$page_data = $meta['value']; 

				if( ! defined("ELEMENTOR_VERSION") ){
					$meta['value'] = wp_slash( $page_data );	
				}else{
					if( version_compare( ELEMENTOR_VERSION , "2.1.0", '<' ) || version_compare( ELEMENTOR_VERSION , "2.1.2", '>=' ) || ! isset( $_GET['part'] ) ){
						$meta['value'] = $page_data;
					}else{
						$meta['value'] = wp_slash( $page_data );	
					}
				}
				
				break;							
			}
		}

		return $post_meta; 
 	}
}
add_filter( 'wp_import_post_meta', 'rtframework_importer_fix_elementor_slashes', 1);

if( ! function_exists("rtframework_prevent_duplicated_images") ){
	/**
	 *
	 * Prevent images being imported more than once when a template imported first
	 * via demo import then elementor template library
	 *
	 */
	function rtframework_prevent_duplicated_images( $post_meta, $post_id, $post ){

 		if ( 'attachment' != $post['post_type'] ) {
 			return $post_meta;
 		}
 
 		$new_url =  $post['attachment_url'];  
 
 		update_post_meta( $post_id, '_elementor_source_image_hash', sha1( $new_url ) );

		return $post_meta; 
 	}
}
add_filter( 'wp_import_post_meta', 'rtframework_prevent_duplicated_images', 1, 3);

/**
 * Render header of HFE Plugin
 */
if ( ! function_exists("rtframework_render_hfe_header") ){
	function rtframework_render_hfe_header() {
		if ( function_exists( 'hfe_render_header' ) ) {
			hfe_render_header();
		}
	}
}
add_action( 'rtframework_after_header', 'rtframework_render_hfe_header' );

/** 
 * Render footer of HFE Plugin
 */
if ( ! function_exists("rtframework_render_hfe_footer") ){
	function rtframework_render_hfe_footer() {
		if ( function_exists( 'hfe_render_footer' ) ) {
			if( ! rtframework_get_setting("display_footer") ){				
				add_action( "rtframework_before_footer", function(){
					echo '<footer id="footer" class="footer">';
					Header_Footer_Elementor::get_footer_content();
					echo '</footer>';
				});
			}else{
				add_action( "rtframework_footer_output", function(){
					Header_Footer_Elementor::get_footer_content();
				},0);				
			}
		}
	}
}
add_action( 'template_redirect', 'rtframework_render_hfe_footer' );

/**
 * Header & Footer Plugin Support 
 */
if ( ! function_exists("rtframework_header_footer_elementor_support") ){
	function rtframework_header_footer_elementor_support() {
		add_theme_support( 'header-footer-elementor' );
	}
}
add_action( 'after_setup_theme', 'rtframework_header_footer_elementor_support' );