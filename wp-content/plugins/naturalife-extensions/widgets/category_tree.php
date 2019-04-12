<?php
/**
 * RT-Theme Product Categories Widget
 *
 * @author RT-Themes
 * @version 1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'RT_Category_Tree' ) ) :

class RT_Category_Tree extends WP_Widget {

	function __construct() {
		$opts =array(
					'classname' 	=> 'widget_rt_category_tree widget_categories',
					'description' 	=> esc_html_x('Display a category list with category tree option.', 'Admin Panel',  'naturalife' )
				);

		parent::__construct('RT_Category_Tree', '['. RT_THEMENAME.']  '.esc_html_x('Category List', 'Admin Panel',  'naturalife'), $opts);
	}
	
	function widget( $args, $instance ) {
		
		extract( $args ); 

		$title               = isset( $instance['title'] ) ?  apply_filters('widget_title', $instance['title']) : "" ;		 
		$taxonomy            = isset( $instance['taxonomy'] ) ?   $instance['taxonomy']: "" ;		 
		$show_product_counts = isset( $instance['show_product_counts'] ) ? $instance['show_product_counts'] : "" ; 
		$hide_empty          = isset( $instance['hide_empty'] ) ? $instance['hide_empty'] : "" ;
		$category_tree       = isset( $instance['category_tree'] ) ? $instance['category_tree'] : "" ;
 		
 		if( empty( $taxonomy ) ){
 			return;
 		}

		//get categories output
		$args = apply_filters("rt_category_tree_taxonomies_atts",array(
					'show_option_all'    => '',
					'orderby'            => 'name',
					'order'              => 'ASC',
					'style'              => 'list',
					'show_count'         => $show_product_counts,
					'hide_empty'         => $hide_empty,
					'use_desc_for_title' => 1,
					'child_of'           => false,
					'feed'               => '',
					'feed_type'          => '',
					'feed_image'         => '',
					'exclude'            => '',
					'exclude_tree'       => '',
					'include'            => '',
					'hierarchical'       => true,
					'title_li'           => "", 
					'number'             => null,
					'echo'               => 0,
					'depth'              => 30,
					'current_category'   => 0,
					'pad_counts'         => 0,
					'taxonomy'           => $taxonomy,
					'walker'             => null,
					'show_option_none'   =>''
				));

		$output = wp_list_categories( $args );

		if( ! empty( $output ) ){
			echo $before_widget;
			echo ! empty($title) ? $before_title . $title . $after_title : "";
			echo $category_tree ? '<ul class="rt-category-tree">' : '<ul>';
			echo $output;
			echo '</ul>'; 
			echo $after_widget;
		}

	}

	function update( $new_instance, $old_instance ) {
		 
		$instance                        = $old_instance;
		$instance['title']               = strip_tags($new_instance['title']); 
		$instance['taxonomy']            = $new_instance['taxonomy']; 
		$instance['show_product_counts'] = isset( $new_instance['show_product_counts'] ) && ! empty( $new_instance['show_product_counts'] ) ? 1 : 0; 
		$instance['hide_empty']          = isset( $new_instance['hide_empty'] ) && ! empty( $new_instance['hide_empty'] ) ? 1 : 0;
		$instance['category_tree']       = isset( $new_instance['category_tree'] ) && ! empty( $new_instance['category_tree'] ) ? 1 : 0;

		return $instance;
	}

	function form( $instance ) {
		$title               = isset($instance['title']) ? esc_attr($instance['title']) : ''; 
		$show_product_counts = isset($instance['show_product_counts']) ? $instance['show_product_counts']: ""; 
		$category_tree       = isset($instance['category_tree']) ? $instance['category_tree']: "";
		$hide_empty          = isset($instance['hide_empty']) ? $instance['hide_empty']: "";
		$taxonomy            = isset($instance['taxonomy']) ? $instance['taxonomy']: ""; 	

 		$available_taxonomies = apply_filters("rt_category_tree_taxonomies", array(
 				"product_cat" => esc_html_x("WooCommerce Categories", 'Admin Panel',  'naturalife'), 
 				"portfolio_categories" => esc_html_x("Portfolio Categories", 'Admin Panel',  'naturalife'),
 				"category" => esc_html_x("Blog Categories", 'Admin Panel',  'naturalife'),
 			));
?>

		<p>	
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php echo esc_html_x('Title:', 'Admin Panel',  'naturalife'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title ?>" />			
		</p>

		<p><label for="<?php echo $this->get_field_id('taxonomy'); ?>"><?php echo esc_html_x('Select Taxonomy', 'Admin Panel',  'naturalife'); ?></label>

		<select class="widefat" name="<?php echo $this->get_field_name('taxonomy'); ?>" id="<?php echo $this->get_field_id('taxonomy'); ?>">
			<?php foreach ($available_taxonomies as $taxonomy_key=>$name) { ?>
				<option value="<?php echo $taxonomy_key;?>" <?php selected( $taxonomy_key, $taxonomy, 1 ); ?>><?php echo $name;?></option>
			<?php } ?>
		</select>
				
		<p>

			<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('category_tree'); ?>" name="<?php echo $this->get_field_name('category_tree'); ?>" <?php checked( $category_tree ); ?> />
			<label for="<?php echo $this->get_field_id('category_tree'); ?>"> <?php echo esc_html_x( 'Enable category tree (expandable)', 'Admin Panel',  'naturalife' ); ?> </label>

			<br />

			<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('show_product_counts'); ?>" name="<?php echo $this->get_field_name('show_product_counts'); ?>" <?php checked( $show_product_counts ); ?> />
			<label for="<?php echo $this->get_field_id('show_product_counts'); ?>"> <?php echo esc_html_x( 'Show product counts', 'Admin Panel',  'naturalife' ); ?> </label>

			<br />
			
			<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('hide_empty'); ?>" name="<?php echo $this->get_field_name('hide_empty'); ?>" <?php checked( $hide_empty ); ?> />
			<label for="<?php echo $this->get_field_id('hide_empty'); ?>"> <?php echo esc_html_x( 'Hide empty categories', 'Admin Panel',  'naturalife' ); ?> </label>
		</p>
		
<?php } } 

endif;
register_widget('RT_Category_Tree');
?>