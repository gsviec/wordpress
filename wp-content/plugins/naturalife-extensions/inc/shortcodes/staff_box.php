<?php
if( ! function_exists("rt_staff") ){
	function rt_staff( $atts, $content = null ) { 
	/**
	 * Staff Posts	
	 * @param  array $atts
	 * @param  string $content
	 * @return output
	 */

	//counter
	$counter = 1;	

	//defaults
	$atts = shortcode_atts(array(  
		"id"           => 'staff-'.rand(100000, 1000000), 
		"class"        => "", 
		"list_layout"  => "1/1", 
		"list_orderby" => "date",
		"list_order"   => "DESC",
		"ids"          => array(),
		"box_style"    => "",
		"link_position"	=> "1",
		"image_effect" => true
	), $atts);

	extract( $atts );

	//product id numbders
	$ids = ! empty( $ids ) ? explode(",", trim( $ids ) ) : array();


	//item width percentage
	$list_layout = ! empty( $list_layout ) ? $list_layout : "1/3";
	$item_width = $list_layout;

	//item width number
	$item_width_number = str_replace("1/", "", $list_layout);

	//row count
	$column_count = rtframework_column_count( $list_layout );

	//general query
	$args=array( 
		'post_status'    =>	'publish',
		'post_type'      =>	'staff',
		'orderby'        =>	$list_orderby,
		'order'          =>	$list_order,
		'posts_per_page' => 1000								
	);


	if( ! empty ( $ids ) ){
		$args = array_merge($args, array( 'post__in'  => $ids) );
	}
	 
	ob_start();

	$query  = new WP_Query($args); 

	//column class
	$add_column_class = rtframework_column_class( $list_layout, "sm" ); 

	//get page & post counts
	$post_count = $query->post_count;
	$page_count = $query->max_num_pages;

	echo '<section id="'.$id.'" class="team rt-flex-wrapper '.$class.'">';
	if ( $query->have_posts() ){
		while ( $query->have_posts() ) : $query->the_post();

			//open row block
			if( $counter % $column_count == 1 || $column_count == 1 ){
				echo '<div class="row">';
			}			

			$post_classes = get_post_class("loop staff {$box_style}", get_the_ID() ) ;

			printf('<div class="col col-12 %s">'."\n",$add_column_class);
			echo '<div id="'.get_the_ID().'" class="'.implode(" ", $post_classes ).'">'."\n";

					set_query_var( 'post_vars', [
						"box_style" => $box_style, 
						"link_position" => $link_position, 
						"image_effect" => $image_effect,
						'item_width' => $item_width
					] ); 

					get_template_part( 'staff-contents/loop','content', $atts);

			echo '</div>'."\n";
			echo '</div>'."\n";

			//close row block
			if( $counter % $column_count == 0 || $post_count == $counter ){
				echo '</div>';				
			}			
 
			$counter++;

		endwhile; 
	}
	echo '</section>';
	 
	rtframework_get_pagination( $query );
	wp_reset_query();
		
	$output_string = ob_get_contents();
	ob_end_clean(); 

	return $output_string;
	}
 }

add_shortcode('staff_box', 'rt_staff'); 