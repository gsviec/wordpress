<?php
/**
 * RT-Theme Latest Posts With Thumbnails Widget
 *
 * @author RT-Themes
 * @version 1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'Latest_Posts' ) ) :

class Latest_Posts extends WP_Widget {

	public function __construct() {
		$opts =array(
					'classname' 	=> 'widget_latest_posts',
					'description' 	=> _x( 'The most recent posts on your site with post thumbnails and date boxes.', 'Admin Panel','naturalife' )
				);

		parent::__construct('latest_posts_2', '['. RT_THEMENAME.']   '._x('Recent Posts ', 'Admin Panel','naturalife'), $opts);
	}
	

	function widget( $args, $instance ) {
		extract( $args ); 

		$title           = ! empty( $instance['title'] ) ? apply_filters('widget_title', $instance['title']) : "";
		$categories      = ! empty( $instance['categories']) ? implode($instance['categories'],',') : "";
		$count           = ! empty( $instance['count']) ? $instance['count'] : 5;
		$limit           = ! empty( $instance['limit']) ? $instance['limit'] : 100;
		$show_thumbnails = ! empty( $instance['show_thumbnails'] ) ? $instance['show_thumbnails'] : "";
		$show_excerpt    = ! empty( $instance['show_excerpt'] ) ? $instance['show_excerpt'] : "";
		$thumb_width     = ! empty( $instance['thumb_width']) ? $instance['thumb_width'] : 50;
		$thumb_height    = ! empty( $instance['thumb_height']) ? $instance['thumb_height'] : 50;
	 	
		
		//remove aside and quote post formats from the list
		$postargs			= array('tax_query' => array( array( 'operator' => 'NOT IN', 'taxonomy' => 'post_format', 'field' => 'slug', 'terms' => array( 'post-format-quote' , 'post-format-aside' ) ) ),'post_type'=>'post','showposts'=>$count,'cat'=>$categories, 'nopaging' => 0, 'post_status' => 'publish', 'ignore_sticky_posts' => 1 ) ;
							
		$post_query 		= 	new WP_Query($postargs); 
		


		$rt_posts = "";

		if ($post_query->have_posts()) : while ($post_query->have_posts()) : $post_query->the_post();							
				
			$post_title        = get_the_title();
			$link              = get_permalink();
			$date              = get_the_date();
			$comment_count     = get_comment_count( $post_query->post->ID );
			$featured_image_id = get_post_thumbnail_id(); 
			$get_the_excerpt   = ($show_excerpt) ? '<p>'.wp_html_excerpt(get_the_excerpt(),$limit).'...</p>' : "" ;			 			

			// Create thumbnail image
			$thumbnail_image_output = ! empty( $featured_image_id ) ? rtframework_get_resized_image_output( array("retina" => true, "image_url" => "", "image_id" => $featured_image_id, "w" => $thumb_width, "h" => $thumb_height, "crop" => 1, "class"=>"post-thumb" ) ) : ""; 

			if ( empty( $thumbnail_image_output ) || ! empty( $show_thumbnails ) ) {
				$thumbnail_image_output = "";
			} 


			$rt_posts .= sprintf( '
				<div>
					%1$s
						<span class="meta">%4$s</span>
						<a class="title" href="%2$s" title="%3$s" rel="bookmark">%3$s</a>						
					%5$s
				</div>
			', $thumbnail_image_output, $link, $post_title, get_the_date() , $get_the_excerpt );


		endwhile;
		wp_reset_postdata();
		endif; 

		echo $before_widget;
		if ($title) echo $before_title . $title . $after_title;
		echo $rt_posts;
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		 
		$instance                     = $old_instance;
		$instance['title']            = strip_tags($new_instance['title']); 
		$instance['categories']       = $new_instance['categories'];
		$instance['newWidget']        = $new_instance['newWidget']; 
		$instance['limit']            = (int) $new_instance['limit'];
		$instance['count']            = (int) $new_instance['count'];
		$instance['show_thumbnails']  = !empty($new_instance['show_thumbnails']) ? 1 : 0;
		$instance['show_excerpt']     = !empty($new_instance['show_excerpt']) ? 1 : 0;
		$instance['thumb_width']      = !empty($new_instance['thumb_width']) ? intval($new_instance['thumb_width']) : 50;
		$instance['thumb_height']     = !empty($new_instance['thumb_height']) ? intval($new_instance['thumb_height']) : 50; 

		return $instance;
	}

	function form( $instance ) {
		$title           = isset($instance['title']) ? esc_attr($instance['title']) : '';
		$categories      = isset($instance['categories']) ? $instance['categories'] : array();
		$newWidget       = isset($instance['newWidget']) ? $instance['newWidget']: '';
		$limit           = empty($instance['limit']) ? 100 : $instance['limit'];
		$count           = empty($instance['count']) ? 5 : $instance['count'];
		$show_thumbnails = isset($instance['show_thumbnails']) ? $instance['show_thumbnails']: '';
		$show_excerpt    = isset($instance['show_excerpt']) ? $instance['show_excerpt']: '';
		$thumb_width     = empty($instance['thumb_width']) ? 220 : $instance['thumb_width'];
		$thumb_height    = empty($instance['thumb_height']) ? 80 : $instance['thumb_height'];		
		
		// Categories
		$rt_getcat = rt_get_categories();
		

?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _ex('Title:', 'Admin Panel','naturalife'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title ?>" /></p>
		
		
		<p><label for="<?php echo $this->get_field_id('categories'); ?>"><?php _ex('Select Categories:', 'Admin Panel','naturalife'); ?></label>
		
		<select class="widefat <?php echo empty($newWidget)? '' : 'multiple'; ?>"   name="<?php echo $this->get_field_name('categories'); ?>[]" id="<?php echo $this->get_field_id('categories'); ?>" multiple="multiple" title="<?php _ex('Select','Admin Panel','naturalife'); ?>">

			<?php
			foreach ($rt_getcat as $op_val=>$option) {
				if($categories){
					foreach($categories as $a_key => $a_value){
						if (	$a_value ==  $op_val ){
							$selected	= "selected";
						}				
					}
				}
			 ?>
				<option value="<?php echo $op_val;?>" <?php echo empty($selected) ? "" :  'selected="selected"'; ?> >
					<?php  echo $option; ?>
				</option>
			<?php
			$selected='';
			}
			?>
		</select>

		<p><label for="<?php echo $this->get_field_id('count'); ?>"><?php _ex('Number of posts to show:', 'Admin Panel','naturalife'); ?></label>
		<input id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" type="text" value="<?php echo $count; ?>" size="4" /></p>

		<p><input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('show_excerpt'); ?>" name="<?php echo $this->get_field_name('show_excerpt'); ?>" <?php checked( $show_excerpt ); ?> />
		<label for="<?php echo $this->get_field_id('show_excerpt'); ?>"><?php _ex( 'Display Excerpt', 'Admin Panel','naturalife' ); ?></label></p>

		<p><label for="<?php echo $this->get_field_id('limit'); ?>"><?php _ex('Limit excerpt characters: ', 'Admin Panel','naturalife'); ?></label>
		<input id="<?php echo $this->get_field_id('limit'); ?>" name="<?php echo $this->get_field_name('limit'); ?>" type="text" value="<?php echo $limit; ?>" size="4" /></p>			

		<p><input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('show_thumbnails'); ?>" name="<?php echo $this->get_field_name('show_thumbnails'); ?>" <?php checked( $show_thumbnails ); ?> />
		<label for="<?php echo $this->get_field_id('show_thumbnails'); ?>"><?php _ex( 'Don\'t display post thumbnails', 'Admin Panel','naturalife' ); ?></label></p>
	
		<p><label for="<?php echo $this->get_field_id('thumb_width'); ?>"><?php _ex('Thumbnail Width (px):', 'Admin Panel','naturalife'); ?></label>
		<input id="<?php echo $this->get_field_id('thumb_width'); ?>" name="<?php echo $this->get_field_name('thumb_width'); ?>" type="text" value="<?php echo $thumb_width; ?>" size="4" /></p>
	
		<p><label for="<?php echo $this->get_field_id('thumb_height'); ?>"><?php _ex('Thumbnail Height (px):', 'Admin Panel','naturalife'); ?></label>
		<input id="<?php echo $this->get_field_id('thumb_height'); ?>" name="<?php echo $this->get_field_name('thumb_height'); ?>" type="text" value="<?php echo $thumb_height; ?>" size="4" /></p>		 
				
		<input class="widefat" id="<?php echo $this->get_field_id('newWidget'); ?>" name="<?php echo $this->get_field_name('newWidget'); ?>" type="hidden" value="1" />
		
<?php } } 

endif;
register_widget('Latest_Posts');
?>