<?php
/**
 * RT-Theme Flickr Widget
 *
 * @author RT-Themes
 * @version 1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'Flickr_Widget' ) ) :

class Flickr_Widget extends WP_Widget {

	public function __construct() {
		$opts =array(
					'classname' 	=> 'widget_flickr',
					'description' 	=> _x( 'Displays your Flickr feeds', 'Admin Panel','naturalife' )
				);

		parent::__construct('flickr', '['. RT_THEMENAME.']   '._x('Flickr', 'Admin Panel','naturalife'), $opts);
	}
	
	function widget( $args, $instance ) {
		extract( $args );
		
		$title           =	! empty( $instance['title'] ) ? apply_filters('widget_title', $instance['title'] ) : "";
		$flickr_username =	! empty( $instance['flickr_username'] ) ? $instance['flickr_username'] : "";
		$show_image      =	empty($instance['show_image']) ? 8 : $instance['show_image'];
		$randomID        =	'flickr-'.rand(10000, 1000000);
		

		echo $before_widget;
		if ($title) echo $before_title . $title . $after_title;
	 
		echo '<ul id="'.$randomID.'"  class="flickr_thumbs"></ul>';		
		
		
			echo '
			<script type="text/javascript">
			/* <![CDATA[ */
				jQuery(document).ready(function(){
					jQuery("#'.$randomID.'").jflickrfeed({limit: '.$show_image.',qstrings: {id: \''.$flickr_username.'\' }, itemTemplate: \'<li><span class="border"><a href="{{image_b}}"><img src="{{image_s}}" alt="{{title}}" /></a></span></li>\'});
				});		
			/* ]]> */	
			</script>
			';
		
		wp_enqueue_script ('<script type="text/javascript">jQuery("#'.$randomID.'").jflickrfeed({limit: '.$show_image.',qstrings: {id: \''.$flickr_username.'\' }, itemTemplate: \'<li><span class="border"><a href="{{image_b}}"><img src="{{image_s}}" alt="{{title}}" /></a></span></li>\'});</script>');		


		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title']			= strip_tags($new_instance['title']); 
		$instance['flickr_username']	= strip_tags($new_instance['flickr_username']);
		$instance['show_image']		= strip_tags($new_instance['show_image']);
		return $instance;
	}

	function form( $instance ) {
		$title 			= 	isset($instance['title']) ? esc_attr($instance['title']) : '';
		$flickr_username 	=	isset($instance['flickr_username']) ? esc_attr($instance['flickr_username']) : '';
		$show_image		=	isset($instance['show_image']) && Is_Numeric($instance['show_image']) ? absint($instance['show_image']) : 8; 

?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _ex('Title:', 'Admin Panel','naturalife'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title ?>" /></p>
	
		<p><label for="<?php echo $this->get_field_id('flickr_username'); ?>"><?php _ex('Flickr Username:', 'Admin Panel','naturalife'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('flickr_username'); ?>" name="<?php echo $this->get_field_name('flickr_username'); ?>" type="text" value="<?php echo $flickr_username; ?>" /></p>
	
		<p><label for="<?php echo $this->get_field_id('show_image'); ?>"><?php _ex('Number of Photo to Display:', 'Admin Panel','naturalife'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('show_image'); ?>" name="<?php echo $this->get_field_name('show_image'); ?>" type="text" value="<?php echo empty($show_image) ? 4 : $show_image; ?>" /></p>
		
<?php } } 

endif;
register_widget('Flickr_Widget');
?>