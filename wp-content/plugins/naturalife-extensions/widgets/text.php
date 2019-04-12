<?php
/**
 * RT-Theme Latest Posts With Thumbnails Widget
 *
 * @author RT-Themes
 * @version 1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'RTFramework_Text' ) ) :

class RTFramework_Text extends WP_Widget {

	public function __construct() {
		$opts =array(
					'classname' 	=> 'widget-naturalife-text',
					'description' 	=> _x( 'Dispay a text with optional markup and icon.', 'Admin Panel','naturalife' )
				);

		parent::__construct('RTFramework_Text', '['. RT_THEMENAME.']   '._x('Text ', 'Admin Panel','naturalife'), $opts);
	}

	function widget( $args, $instance ) {

		//defaults
		$instance = wp_parse_args( $instance, array(
					"text" => "",
					"icon" => "",
					"tag" => ""
			));
  

		extract( $args ); 
 
		$text = ! empty( $instance['text'] ) ? $instance['text'] : ""; 
		$icon = ! empty( $instance['icon'] ) ? $instance['icon'] : ""; 
		$tag = ! empty( $instance['tag'] ) ? $instance['tag'] : ""; 


		echo $before_widget;
		
		echo ! empty( $tag ) ? sprintf('<%s>',$tag) : "";
		echo ! empty( $icon ) ? sprintf('<span class="icon %s"></span>',$icon) : "";
		echo apply_filters( 'widget_text', $text, $instance, $this );
		echo ! empty( $tag ) ? sprintf('</%s>',$tag) : "";

		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		 
		$instance         = $old_instance;
		$instance['text'] = $new_instance['text'];
		$instance['icon'] = $new_instance['icon'];
		$instance['tag']  = $new_instance['tag'];  


		return $instance;
	}

	function form( $instance ) {
		$instance['text'] = isset($instance['text']) ? $instance['text'] : '';
		$instance['icon'] = isset($instance['icon']) ? $instance['icon'] : '';
		$instance['tag']  = isset($instance['tag']) ? $instance['tag'] : '';

?>

		<p><label for="<?php echo $this->get_field_id( 'text' ); ?>"><?php _ex('Text', 'Admin Panel','naturalife'); ?></label>
		<textarea class="widefat" rows="16" cols="20" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo esc_textarea( $instance['text'] ); ?></textarea></p>

		<p><label for="<?php echo $this->get_field_id( 'icon' ); ?>"><?php _ex('Icon Name', 'Admin Panel','naturalife'); ?></label>
		<input type="text" class="widefat" rows="16" cols="20" id="<?php echo $this->get_field_id('icon'); ?>" name="<?php echo $this->get_field_name('icon'); ?>" value="<?php echo esc_textarea( $instance['icon'] ); ?>"></p>


		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'tag' ) ); ?>"><?php _ex('Tag', 'Admin Panel','naturalife'); ?></label>
			<select name="<?php echo esc_attr( $this->get_field_name( 'tag' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'tag' ) ); ?>" class="widefat">
				<option value=""><?php _ex('No tag', 'Admin Panel','naturalife'); ?></option> 
				<option value="p"<?php selected( $instance['tag'], 'p' ); ?>>p</option> 
				<option value="span"<?php selected( $instance['tag'], 'span' ); ?>>span</option> 
				<option value="h1"<?php selected( $instance['tag'], 'h1' ); ?>>h1</option> 
				<option value="h2"<?php selected( $instance['tag'], 'h2' ); ?>>h2</option> 
				<option value="h3"<?php selected( $instance['tag'], 'h3' ); ?>>h3</option> 
				<option value="h4"<?php selected( $instance['tag'], 'h4' ); ?>>h4</option> 
				<option value="h5"<?php selected( $instance['tag'], 'h5' ); ?>>h5</option> 
				<option value="h6"<?php selected( $instance['tag'], 'h6' ); ?>>h6</option> 
			</select>
		</p>
				
		<input class="widefat" id="<?php echo $this->get_field_id('newWidget'); ?>" name="<?php echo $this->get_field_name('newWidget'); ?>" type="hidden" value="1" />
		
<?php } } 

endif;
register_widget('RTFramework_Text');
?>