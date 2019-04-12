<?php
/**
 * RT-Theme Social Media Icons Widget
 *
 * @author RT-Themes
 * @version 1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'Social_Media_Icons_Widget' ) ) :

class Social_Media_Icons_Widget extends WP_Widget {

	public function __construct() {
		$opts =array(
					'classname' 	=> 'widget_social_media_icons',
					'description' 	=> _x( 'Displays your social media icons.', 'Admin Panel','naturalife' )
				);

		parent::__construct('social_media_icons', '['. RT_THEMENAME.']   '._x('Social Media Icons', 'Admin Panel','naturalife'), $opts);
	}
	
	function widget( $args, $instance ) {
		extract( $args );

		$title = !empty( $instance['title'] ) ? apply_filters('widget_title', $instance['title'])  : "";
		$instance['multiline']  = ! empty( $instance['multiline'] ) ? "true" : "false";

		echo $before_widget;
		if ($title) echo $before_title . $title . $after_title;
		echo '<div class="naturalife-social-media-widget">'."\n"; 
		echo rt_social_media( array("multiline" => $instance['multiline'] ) );
		echo '</div>'."\n"; 
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance['title'] = strip_tags($new_instance['title']); 
		$instance['multiline']  = !empty($new_instance['multiline']) ? 1 : 0;

		return $instance;
	}

	function form( $instance ) {
		$title = isset($instance['title']) ? esc_attr($instance['title']) : '';
		$multiline = isset($instance['multiline']) ? $instance['multiline']: '';

?>
		<p><?php _ex("This widget displays your social media icons. Go to Appearence -> Customize / Social Media Options to manage your social media links.", 'Admin Panel','naturalife')?></p>

		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _ex('Title:', 'Admin Panel','naturalife'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title ?>" /></p>

		<p><input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('multiline'); ?>" name="<?php echo $this->get_field_name('multiline'); ?>" <?php checked( $multiline ); ?> />
		<label for="<?php echo $this->get_field_id('multiline'); ?>"><?php _ex( 'Display as multiline', 'Admin Panel','naturalife' ); ?></label></p>

<?php } } 

endif;
register_widget('Social_Media_Icons_Widget');
?>