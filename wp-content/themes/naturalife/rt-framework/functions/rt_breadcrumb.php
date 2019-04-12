<?php
#-----------------------------------------
#	RT-Theme rtframework_breadcrumb.php
#-----------------------------------------

add_action("rtframework_breadcrumb_menu", "rtframework_breadcrumb", 10, 1 );

/* RT-Breadcrumb Function */ 
if( ! function_exists('rtframework_breadcrumb') ){
	function rtframework_breadcrumb( $args = array() ){

		global $rtframework_taxonomy, $post, $rtframework_delimiter, $rt_item_position, $wp_query;

		//the breadcrumb text before the menu
		$breadcrumb_text = "";

		//default values
		$defaults =  array(
			'rtframework_delimiter' => ' <span class="icon-angle-right"></span> ',
			'wrap_before'           => '',
			'wrap_after'            => '',
			'breadcrumb_text'       => ''.rtframework_wpml_t(RT_THEMESLUG, 'Breadcrumb Menu Text', $breadcrumb_text ).'',
			'home'                  => esc_html__( 'Home', 'naturalife' ),
		);

		$args = wp_parse_args( $args, $defaults );

		//extract variables
		extract( $args );

		//define variables
		$breadcrumb = ""; 
	 
		/*  WooCommerce Breadcrumb */ 
		if ( function_exists( 'woocommerce_breadcrumb' ) && ! rtframework_get_setting( 'rt_shopstartpage' ) ) {
			if( is_woocommerce() ){
				$defaults = array(
					'delimiter'  => "",
					'wrap_before'  => $wrap_before. '<ol vocab="http://schema.org/" typeof="BreadcrumbList">' . '<li property="itemListElement" typeof="ListItem"><a class="ui-icon-home" property="item" typeof="WebPage" href="'. RT_BLOGURL .'"><span property="name">'.$home.'</span></a><meta content="1" property="position">' .$rtframework_delimiter. '</li>',
					'wrap_after' => '</ol>'.$wrap_after,
					'before'   => '<li property="itemListElement" typeof="ListItem">',
					'after'   => $rtframework_delimiter.'</li>',
					'home'    => false,
				);
			
				ob_start();
				woocommerce_breadcrumb($defaults);
				$breadcrumb = ob_get_contents();
				ob_end_clean();
				return $breadcrumb; 
			}
		} 

		/*  YOAST Breadcrumb */ 
		if ( function_exists( 'yoast_breadcrumb' ) ) {
			$yoast_options = get_option( 'wpseo_internallinks' );
			if(isset($yoast_options['breadcrumbs-enable'])  && !empty($yoast_options['breadcrumbs-enable'])){
				ob_start();
				yoast_breadcrumb($wrap_before ,$wrap_after);
				$breadcrumb = ob_get_contents();
				ob_end_clean();		
				return $breadcrumb; 		
			}
		} 

		/*
		  BBPRESS Breadcrumb
		  use BBpress Breadcrumb if for bbpress pages
		*/ 
		if ( function_exists( 'bbp_breadcrumb' ) ) {

			//check the current page is if it is part of bbpress
			if ( is_bbpress() ){  
				$breadcrumb .= bbp_get_breadcrumb(array(
					// HTML
					'before'          => '<div class="breadcrumb"><span class="icon-home"></span>',
					'after'           => '</div>',

					// Separator
					'sep'             => ' ',
					'pad_sep'         => 1,
					'sep_before'      => '<span class="icon-angle-right">',
					'sep_after'       => '</span>',

					// Crumbs
					'crumb_before'    => '',
					'crumb_after'     => '',

					// Home 
					'home_text'       => $defaults["home"],
					'include_home'   => 1,

					'rtframework'    => true
				));  
				return $breadcrumb;
			}  
		} 


		$breadcrumb .= $wrap_before;
		$breadcrumb .= ! empty( $breadcrumb_text ) ? $breadcrumb_text." " : "";
		$breadcrumb .= '<ol vocab="http://schema.org/" typeof="BreadcrumbList">'."\n";

				//Home Page
				if( ! is_front_page() ){
					$breadcrumb .= rtframework_create_breadcrumb_item( array( "class" => "ui-icon-home", "sublink" => false, "url"=> RT_BLOGURL, "title"=> get_bloginfo('name'), "link_name" => $home ) );
				}

				//Pages
				if ( is_page() && ! is_front_page() && $post ){

					//woocommerce pages
					if ( function_exists( 'woocommerce_breadcrumb' )){
						if(  is_woocommerce() || is_cart() || is_checkout() ){
							$breadcrumb .= rtframework_get_base_page("woo_product");	
						}						
					}

					//regular pages
					$breadcrumb .= rtframework_page_parents( $post, "" ) . rtframework_create_breadcrumb_item( array( "rtframework_delimiter" => "", "title" => get_the_title( rtframework_wpml_translated_page_id( $post->ID ) ) ) );
				}

				//Single posts
				elseif ( is_single() && !is_attachment() ){ 

					// Get post type
					$post_type = get_post_type();

					//regular single posts 
					if($post_type == 'post'){ 

						//get base page
			 			$breadcrumb .= rtframework_get_base_page("blog");

						$this_category = get_the_category();  

						if( isset( $this_category[0] ) ){
							$breadcrumb .= rtframework_get_category_parents( $this_category[0] );
						}

						$breadcrumb .= rtframework_create_breadcrumb_item( array( "title"=> $post->post_title, "rtframework_delimiter" => "" ) );

					}

					//product single posts 
					elseif($post_type == 'product'){ 
			 
			 			//get base page
			 			$breadcrumb .= rtframework_get_base_page("woo_product");

						//categories of post
						$terms = wp_get_post_terms( $post->ID, "product_cat",  array( 'orderby' => 'parent', 'order' => 'DESC' ) );

						//select only 1st one and create breadcrumb link
						if( isset( $terms[0] ) ){

							$term_link = get_term_link( $terms[0]->slug, $terms[0]->taxonomy );
							$term_name = $terms[0]->name;

							//check term has parents
							if( $terms[0]->parent ){
								$breadcrumb .= rtframework_get_term_parents( $terms[0]->term_id, $terms[0]->taxonomy );
							}

							//breadcrumb link of the term
							$breadcrumb .= rtframework_create_breadcrumb_item( array( "title"=> esc_attr( sprintf( esc_html__( "View all products in %s", "naturalife" ), $term_name ) ), "link_name"=> esc_attr( $term_name ), "url" =>  esc_url( $term_link ) ) );

						}
						
						//breadcrumb link of current post
						$breadcrumb .= rtframework_create_breadcrumb_item( array( "title"=> $post->post_title, "rtframework_delimiter" => "" ) );

					}	


					//portfolio single posts 
					elseif($post_type == 'portfolio'){ 
			 
			 			//get base page
			 			$breadcrumb .= rtframework_get_base_page("portfolio");

						//categories of post
						$terms = wp_get_post_terms( $post->ID, "portfolio_categories",  array( 'orderby' => 'parent', 'order' => 'DESC' ) );

						//select only 1st one and create breadcrumb link
						if( isset( $terms[0] ) ){

							$term_link = get_term_link( $terms[0]->slug, $terms[0]->taxonomy );
							$term_name = $terms[0]->name;

							//check term has parents
							if( $terms[0]->parent ){
								$breadcrumb .= rtframework_get_term_parents( $terms[0]->term_id, $terms[0]->taxonomy );
							}

							//breadcrumb link of the term
							$breadcrumb .= rtframework_create_breadcrumb_item( array( "title"=> esc_attr( sprintf( esc_html__( "View all works in %s", "naturalife" ), $term_name ) ), "link_name"=> esc_attr( $term_name ), "url" =>  esc_url( $term_link ) ) );

						}
						
						//breadcrumb link of current post
						$breadcrumb .= rtframework_create_breadcrumb_item( array( "title"=> $post->post_title, "rtframework_delimiter" => "" ) );

					}		

					//staff single posts 
					elseif($post_type == 'staff'){ 
			 
			 			//get base page
			 			$breadcrumb .= rtframework_get_base_page("staff"); 
			 			
						//breadcrumb link of current post
						$breadcrumb .= rtframework_create_breadcrumb_item( array( "title"=> $post->post_title, "rtframework_delimiter" => "" ) );

					}		

					//other single custom posts
					else{ 						
						
						//breadcrumb link of current post
						$breadcrumb .= rtframework_create_breadcrumb_item( array( "title"=> $post->post_title, "rtframework_delimiter" => "" ) );

					}	
				}

				//Taxonomies
				elseif ( is_tax() ){

						//get base page for product_cat & product_tag
						if( get_query_var( 'taxonomy' ) == "product_cat" || get_query_var( 'taxonomy' ) == "product_tag" ){
						 	$breadcrumb .= rtframework_get_base_page("woo_product");
						}

						//get base page for portfolio
						if( get_query_var( 'taxonomy' ) == "portfolio_categories" ){
						 	$breadcrumb .= rtframework_get_base_page("portfolio");
						}			

						$this_term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) ); 

						$breadcrumb .= rtframework_get_term_parents( $this_term->term_id, $this_term->taxonomy );			 
						$breadcrumb .= rtframework_create_breadcrumb_item( array( "title"=> esc_attr( $this_term->name ), "rtframework_delimiter"=>""  ) );
				}

				//categories
				elseif ( is_category() ){

			 			//get base page
			 			$breadcrumb .= rtframework_get_base_page("blog");

						$this_category_obj = $wp_query->get_queried_object();
						$this_category = get_category( $this_category_obj->term_id ); 

						if( $this_category->parent ){
							$breadcrumb .= rtframework_get_category_parents( $this_category->parent );
						}

						$breadcrumb .= rtframework_create_breadcrumb_item( array( "title"=> esc_attr( $this_category->name ), "rtframework_delimiter"=>""  ) );
			 
				//404
				} elseif ( is_404() ) {

					$breadcrumb .= rtframework_create_breadcrumb_item( array( "title"=> esc_html__( 'Error 404', 'naturalife' ),  "rtframework_delimiter"=>""  ) );

				//search
				} elseif ( is_search() ) {

					$breadcrumb .= rtframework_create_breadcrumb_item( array( "title"=> sprintf( esc_html__( 'Search results for: %s', 'naturalife' ), get_search_query() ),  "rtframework_delimiter"=>""  ) );

				//tag
				} elseif ( is_tag() ) {

					$breadcrumb .= rtframework_create_breadcrumb_item( array( "title"=> sprintf( esc_html__( 'Posts tagged: %s', 'naturalife' ), single_tag_title('', false) ),  "rtframework_delimiter"=>""  ) );

				//author
				} elseif ( is_author() ) {

					$breadcrumb .= rtframework_create_breadcrumb_item( array( "title"=> sprintf( esc_html__( 'Author: %s', 'naturalife' ), get_the_author() ),  "rtframework_delimiter"=>""  ) );

				//attachment
				} elseif ( is_attachment() ) {


					$this_category = get_the_category();  

					if( $this_category ){
						$breadcrumb .= rtframework_get_category_parents( $this_category );
					}

					$breadcrumb .= rtframework_create_breadcrumb_item( array( "title"=> $post->post_title, "rtframework_delimiter" => "" ) );
 
				//archive
				}elseif ( is_archive() ) { 

					$breadcrumb .= rtframework_create_breadcrumb_item( array( "title"=> rtframework_get_title(), "rtframework_delimiter" => "" ) );

				//posts page
				}elseif ( is_home() ) { 

					$breadcrumb .= rtframework_create_breadcrumb_item( array( "title"=> get_the_title( get_option( 'page_for_posts' ) ), "rtframework_delimiter" => "" ) );
		
				}else {

					if( ! is_front_page() ){
						$breadcrumb .= rtframework_create_breadcrumb_item( array( "title"=> wp_title('|',false), "link_name"=> wp_title('|',false), "rtframework_delimiter"=>""  ) );
					}
				}			

		//close
		$breadcrumb .= "</ol>"."\n"; 

		$breadcrumb .= $wrap_after;

		$breadcrumb_menu = $breadcrumb;
	 
		//echo breadcrumb
		return $breadcrumb_menu;
	}
}

// page category parents function
if( ! function_exists('rtframework_get_term_parents') ){
	function rtframework_get_term_parents( $term_id, $rtframework_taxonomy) {
	 		
	 		$item = "";
			$the_term = get_term_by( 'id', $term_id , $rtframework_taxonomy );		 
			$get_ancestors = array_reverse( get_ancestors( $the_term->term_id, $rtframework_taxonomy ) );
	 
			foreach ( $get_ancestors as $ancestor ) {
				$ancestor = get_term( $ancestor, $rtframework_taxonomy );
				$link = get_term_link( $ancestor->slug, $rtframework_taxonomy ) ;
				$name = esc_html( $ancestor->name ) ;
				$item .= rtframework_create_breadcrumb_item( array( "title"=> esc_attr( $name ), "link_name"=> $name, "url" =>  esc_url( $link ) ) );
			} 

			return $item;
	}
}

// page category parents function
if( ! function_exists('rtframework_get_category_parents') ){	
	function rtframework_get_category_parents( $id, $visited = array() ) {
		$chain = '';
		$parent = get_term( $id, 'category' );

		if ( is_wp_error( $parent ) )
			return $parent; 
	 
		$name = $parent->name;

		if ( $parent->parent && ( $parent->parent != $parent->term_id ) && !in_array( $parent->parent, $visited ) ) {
			$visited[] = $parent->parent;
			$chain .= rtframework_get_category_parents( $parent->parent, $visited );
		}

		$chain .= rtframework_create_breadcrumb_item( array( "title"=> esc_attr( sprintf( esc_html__( "View all posts in %s", "naturalife" ), $parent->name ) ), "link_name"=> esc_attr( $parent->name ), "url" =>  esc_url( get_category_link( $parent->term_id ) ) ) );

		return $chain;
	}
}

// page parents function
if( ! function_exists('rtframework_create_breadcrumb_item') ){	

	function rtframework_create_breadcrumb_item( $atts = array() ){
		global $rtframework_delimiter, $rt_item_position;

		//defaults
		extract(shortcode_atts(array(
			"sublink" => "true",
			"url"     => "",
			"title"   => "",
			"link_name"=> "",
			"rtframework_delimiter" => $rtframework_delimiter,
			"class" => ""
		), $atts));

		$link_name = ! empty( $link_name ) ? $link_name : $title;

		if ( empty( $link_name ) ){
			return;
		}

		if ( ! isset( $rt_item_position ) || empty( $rt_item_position ) ){
			$rt_item_position = 1;
		}else{
			$rt_item_position++;
		}

		$item = "";

		$item .=  '<li property="itemListElement" typeof="ListItem">'."\n";

		$item .= ! empty( $url ) ? '<a property="item" typeof="WebPage" class="'.$class.'" href="'.$url.'">' : "";

		$item .= ! empty( $url ) ?  '<span property="name">' . $link_name . '</span>' :  '<span property="name">' . $link_name . '</span>';

		$item .= '<meta property="position" content="'.$rt_item_position.'">' ;

		$item .= ! empty( $url ) ? '</a>' : ""; 		

		$item .= $rtframework_delimiter; 

		$item .= '</li>'."\n";

		return $item;
	}
}

// page parents function
if( ! function_exists('rtframework_page_parents') ){	
	function rtframework_page_parents( $post, $items ){

		//parent pages
		if ( isset($post) && $post->post_parent ){		

				//find parent page of this page
				$parent_page = get_page( $post->post_parent );

				//create breadcrum item for this page
				$items = rtframework_create_breadcrumb_item( array( "url"=> get_permalink( rtframework_wpml_translated_page_id( $parent_page->ID ) ), "title"=> get_the_title( rtframework_wpml_translated_page_id( $parent_page->ID ) ) ) ) . $items;

				//find parent page of the parent page			
				return rtframework_page_parents( $parent_page, $items );

		}else{
			return $items; 
		}
		
	}
}

//get base page
if( ! function_exists('rtframework_get_base_page') ){	
	function rtframework_get_base_page( $for = "" ){

		$page = "";

		if( $for == "woo_product"  && rtframework_get_setting( 'rt_shopstartpage' ) ){ 

			$page = rtframework_page_parents( get_post(rtframework_wpml_translated_page_id( rtframework_get_setting( 'rt_shopstartpage' ) )) , "" ) . rtframework_create_breadcrumb_item( array( "url"=> get_permalink( rtframework_wpml_translated_page_id( rtframework_get_setting( 'rt_shopstartpage' ) ) ), "title"=> get_the_title( rtframework_wpml_translated_page_id( rtframework_get_setting( 'rt_shopstartpage' ) ) ) ) ) ;

		}elseif( $for == "portfolio" && rtframework_get_setting( 'rt_portfoliopage' ) ){ 

			$page = rtframework_page_parents( get_post(rtframework_wpml_translated_page_id( rtframework_get_setting( 'rt_portfoliopage' ) )) , "" ) . rtframework_create_breadcrumb_item( array( "url"=> get_permalink( rtframework_wpml_translated_page_id( rtframework_get_setting( 'rt_portfoliopage' ) ) ), "title"=> get_the_title( rtframework_wpml_translated_page_id( rtframework_get_setting( 'rt_portfoliopage' ) ) ) ) ) ;

		}elseif( $for == "staff" && rtframework_get_setting( 'rt_staffpage' ) ){ 

			$page = rtframework_page_parents( get_post(rtframework_wpml_translated_page_id( rtframework_get_setting( 'rt_staffpage' ) )) , "" ) . rtframework_create_breadcrumb_item( array( "url"=> get_permalink( rtframework_wpml_translated_page_id( rtframework_get_setting( 'rt_staffpage' ) ) ), "title"=> get_the_title( rtframework_wpml_translated_page_id( rtframework_get_setting( 'rt_staffpage' ) ) ) ) ) ;

		}elseif( $for == "blog" && rtframework_get_setting( 'rt_blogpage' ) ){ 

			$page = rtframework_page_parents( get_post(rtframework_wpml_translated_page_id( rtframework_get_setting( 'rt_blogpage' ) )) , "" ) . rtframework_create_breadcrumb_item( array( "url"=> get_permalink( rtframework_wpml_translated_page_id( rtframework_get_setting( 'rt_blogpage' ) ) ), "title"=> get_the_title( rtframework_wpml_translated_page_id( rtframework_get_setting( 'rt_blogpage' ) ) ) ) ) ;
		}

		return $page;
	}
}