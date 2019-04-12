<?php
if( ! function_exists("rt_testimonials") ){
	/**
	 * Testimonanials
	 * @param  array $atts
	 * @param  string $content
	 * @return output
	 */
	function rt_testimonials( $atts, $content = null ) {  
	global $rtframework_testimonial_settings;

	//counter
	$counter = 1;	

	//defaults
	$atts = shortcode_atts(array(  
		"id"  => 'testimonial-'.rand(100000, 1000000), 
		"class" => '',
		"list_layout"  => "1/1", 
		"ids" => array(),
		"item_per_page"=> 9,
		"list_orderby" => "date",
		"list_order" => "DESC",
		"pagination" => "false",
		"style"=> "left",
		"headings" => "true",
		"client_images" => "true",
		"categories" => ""
	), $atts);
	extract( $atts );

	$rtframework_testimonial_settings = $atts;
	
	//product id numbders
	$ids = ! empty( $ids ) ? explode(",", trim( $ids ) ) : array();

	//item width percentage
	$list_layout = ! empty( $list_layout ) ? $list_layout : "1/3";

	//row count
	$column_count = rtframework_column_count( $list_layout );

	//paged
	if( $pagination !== "false" ){
		if (get_query_var('paged') ) {$paged = get_query_var('paged');} elseif ( get_query_var('page') ) {$paged = get_query_var('page');} else {$paged = 1;} 
	}else{
		$paged = 0;
	} 	  

	//create a post status array
	$post_status = is_user_logged_in() ? array( 'private', 'publish' ) : "publish";

	//general query
	$args=array( 
		'post_status'    => $post_status,
		'post_type'      => 'testimonial',
		'orderby'        => $list_orderby,
		'order'          => $list_order,
		'posts_per_page' => $item_per_page,
		'paged'          => $paged															
	);

	if( ! empty ( $ids ) ){
		$args = array_merge($args, array( 'post__in'  => $ids) );
	}
 
	if( ! empty ( $categories ) ){

		$categories = is_array( $categories ) ? $categories : explode(",", rtframework_wpml_lang_object_ids( $categories, "testimonial_categories" ) ); 	

		$args = array_merge($args, array( 

			'tax_query' => array(
					array(
						'taxonomy' =>	'testimonial_categories',
						'field'    =>	'id',
						'terms'    =>	$categories,
						'operator' => 	"IN"
					)
				),
		) );
	} 

	ob_start();

	$theQuery  = new WP_Query($args); 
 
	//get page & post counts
	$post_count = $theQuery->post_count;  
	
	//add additional classes
	$class .= " ".$style; 

	//column class
	$add_column_class = rtframework_column_class( $list_layout, "sm" );


	//id attr
	$id_attr = ! empty( $id ) ? 'id="'.sanitize_html_class($id).'"' : "";	 

	echo '<section '.$id_attr.' class="testimonials '.$class.' " data-column-width="'. $column_count .'">';

 
		while ( $theQuery->have_posts() ) : $theQuery->the_post();

			//has image
			$add_column_class .= has_post_thumbnail() && $client_images !== "false" ? " has-image" : "";


			//add first last classes if filterable is off 
			$add_class = "";

			if( $counter % $column_count == 1 || $column_count == 1 ){
				$add_class .= " first";
			}

			if( ( $counter % $column_count == 0 || $post_count == $counter ) && $add_class == "" ){
				$add_class .= " last";
			}

			//post class
			$add_class .= " ". implode(get_post_class("loop")," ");

			//open row block
			if( $counter % $column_count == 1 || $column_count == 1 ){
				echo '<div class="row">';
			}			
			printf('<div id="%s" class="testimonial col col-12 %s %s">'."\n", get_the_ID(), $add_column_class ,$add_class);
				get_template_part( 'testimonial-contents/content'); 				
			echo '</div>'."\n";

			//close row block and add hr
			if( $counter % $column_count == 0 || $post_count == $counter ){
				echo '</div>';				
			}			

			$counter++;

		endwhile; 

	echo '</section>';

	if( $pagination !== "false" ){
		rtframework_get_pagination( $theQuery );	
	} 

	wp_reset_postdata(); 
		
	$output_string = ob_get_contents();

	ob_end_clean(); 

	return $output_string;
	}
 }

add_shortcode('testimonial_box', 'rt_testimonials'); 