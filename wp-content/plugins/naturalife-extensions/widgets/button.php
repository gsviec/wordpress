<?php
/**
 * RT-Theme Button Widget
 *
 * @author RT-Themes
 * @version 1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'RT_Button' ) ) :

class RT_Button extends WP_Widget {

	public function __construct() {
		$opts =array(
					'classname' 	=> 'widget_rt_button',
					'description' 	=> _x( 'Displays a button.', 'Admin Panel','naturalife' ),
					'customize_selective_refresh' => true
				);

		parent::__construct('RT_Button', '['. RT_THEMENAME.']   '._x('Button', 'Admin Panel','naturalife'), $opts);
	}

	function widget( $args, $instance ) {
		extract( $args );
		
		$instance["button_text"] = !empty( $instance['button_text'] ) ? rtframework_wpml_t( RT_THEMESLUG , $this->id . " - " . esc_html_x("Button Text", 'Admin Panel','naturalife'), esc_attr( $instance['button_text'] ) ) : "";
		echo $before_widget;
		
		if( isset( $instance["button_style"] ) && $instance["button_style"] == "linkonly" ){

			//css classes
			$class = array();
			$class[] = esc_attr($instance["class"]);
			$class[] = ! empty( $instance["button_icon"] ) ? "icon ".esc_attr($instance["button_icon"]) : "";
			$class_attr = ! empty($class) ? ' class="'.trim(implode(" ", $class)).'"' : "";
	 
			//the link
			printf('<a%s%s href="%s" target="%s"%s>%s%s</a>',
				! empty( $instance["id"] ) ? ' id="'.esc_attr($instance["id"]).'"' : "",
				$class_attr,
				esc_url($instance["button_link"]),				
				esc_attr($instance["link_open"]),
				! empty( $instance["href_title"] ) ? ' title="'.esc_attr($instance["href_title"]).'"' : "",
				esc_attr($instance["button_text"]),
				! empty( $instance["button_arrow"] ) ? ' <span class="ui-icon-right-arrow-1"></span>' : ""
			);
		}else{
			echo rt_shortcode_button( $instance, $instance["button_text"] );
		}

		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		 
		$instance = $old_instance;

		$instance['button_text']    = strip_tags($new_instance['button_text']); 
		$instance['button_style']   = strip_tags($new_instance['button_style']); 
		$instance['button_size']   = strip_tags($new_instance['button_size']); 
		$instance['button_arrow']   = isset( $new_instance['button_arrow'] ) && ! empty( $new_instance['button_arrow'] ) ? 1 : 0;
		$instance['button_rounded'] = isset( $new_instance['button_rounded'] ) && ! empty( $new_instance['button_rounded'] ) ? 1 : 0;
		$instance['button_icon']    = strip_tags($new_instance['button_icon']); 
		$instance['button_link']    = strip_tags($new_instance['button_link']); 
		$instance['link_open']      = strip_tags($new_instance['link_open']); 
		$instance['href_title']     = strip_tags($new_instance['href_title']); 
		$instance['id']             = strip_tags($new_instance['id']); 
		$instance['class']          = strip_tags($new_instance['class']); 

		return $instance;
	}

	function form( $instance ) {
		$button_text    = isset($instance['button_text']) ? esc_attr($instance['button_text']) : ''; 
		$button_style   = isset($instance['button_style']) ? esc_attr($instance['button_style']) : ''; 
		$button_size   = isset($instance['button_size']) ? esc_attr($instance['button_size']) : ''; 
		$button_arrow   = isset($instance['button_arrow']) ? $instance['button_arrow'] : ''; 		
		$button_rounded = isset($instance['button_rounded']) ? $instance['button_rounded'] : ''; 			 
		$button_icon    = isset($instance['button_icon']) ? esc_attr($instance['button_icon']) : ''; 			 
		$button_link    = isset($instance['button_link']) ? esc_attr($instance['button_link']) : ''; 			 
		$link_open      = isset($instance['link_open']) ? esc_attr($instance['link_open']) : ''; 			 
		$href_title     = isset($instance['href_title']) ? esc_attr($instance['href_title']) : ''; 			 
		$id             = isset($instance['id']) ? esc_attr($instance['id']) : ''; 			 
		$class          = isset($instance['class']) ? esc_attr($instance['class']) : ''; 			 

?> 

		<p>
			<label for="<?php echo $this->get_field_id('button_text'); ?>"><?php echo esc_html_x('Button Text', 'Admin Panel','naturalife'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('button_text'); ?>" name="<?php echo $this->get_field_name('button_text'); ?>" type="text" value="<?php echo $button_text ?>" />
		</p>

		<p><label for="<?php echo $this->get_field_id('button_style'); ?>"><?php echo esc_html_x('Button Style', 'Admin Panel',  'naturalife'); ?></label>
			<?php
			$button_styles = array(
									"style-1" => esc_html_x("Style 1", 'Admin Panel','naturalife'),
									"style-2" => esc_html_x("Style 2", 'Admin Panel','naturalife'),
									"style-3" => esc_html_x("Style 3", 'Admin Panel','naturalife'),
									"black"   => esc_html_x("Black", 'Admin Panel','naturalife'),
									"white"   => esc_html_x("White", 'Admin Panel','naturalife'),
									"flattext"=> esc_html_x("Flat Text", 'Admin Panel','naturalife'),  
									"linkonly" => esc_html_x("Regular Link", 'Admin Panel','naturalife'),  
								);
			?>
			<select class="widefat" name="<?php echo $this->get_field_name('button_style'); ?>" id="<?php echo $this->get_field_id('button_style'); ?>">
				<?php foreach ($button_styles as $style=>$name) { ?>
					<option value="<?php echo $style;?>" <?php selected( $style, $button_style, 1 ); ?>><?php echo $name;?></option>
				<?php } ?>
			</select>
		</p>

		<p><label for="<?php echo $this->get_field_id('button_size'); ?>"><?php echo esc_html_x('Button Size', 'Admin Panel',  'naturalife'); ?></label>
			<?php
			$button_styles = array(
									"small" => esc_html_x("Small", 'Admin Panel','naturalife'),
									"medium" => esc_html_x("Medium", 'Admin Panel','naturalife'),
									"big" => esc_html_x("Big", 'Admin Panel','naturalife'),
									"hero" => esc_html_x("Hero", 'Admin Panel','naturalife'), 
								);		
			?>
			<select class="widefat" name="<?php echo $this->get_field_name('button_size'); ?>" id="<?php echo $this->get_field_id('button_size'); ?>">
				<?php foreach ($button_styles as $style=>$name) { ?>
					<option value="<?php echo $style;?>" <?php selected( $style, $button_size, 1 ); ?>><?php echo $name;?></option>
				<?php } ?>
			</select>
		</p>

			<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('button_rounded'); ?>" name="<?php echo $this->get_field_name('button_rounded'); ?>" <?php checked( $button_rounded ); ?> />
			<label for="<?php echo $this->get_field_id('button_rounded'); ?>"> <?php echo esc_html_x("Rounded Button?", 'Admin Panel','naturalife'); ?> </label>
				
			<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('button_arrow'); ?>" name="<?php echo $this->get_field_name('button_arrow'); ?>" <?php checked( $button_arrow ); ?> />
			<label for="<?php echo $this->get_field_id('button_arrow'); ?>"> <?php echo esc_html_x("Button Arrow?", 'Admin Panel','naturalife'); ?> </label>

		<p>
			<label for="<?php echo $this->get_field_id('button_icon'); ?>"><?php echo esc_html_x('Button Icon', 'Admin Panel','naturalife'); ?></label>
			<input class="widefat icon_selection" id="<?php echo $this->get_field_id('button_icon'); ?>" name="<?php echo $this->get_field_name('button_icon'); ?>" type="text" value="<?php echo $button_icon ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('button_link'); ?>"><?php echo esc_html_x('Link', 'Admin Panel','naturalife'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('button_link'); ?>" name="<?php echo $this->get_field_name('button_link'); ?>" type="text" value="<?php echo $button_link ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('link_open'); ?>"><?php echo esc_html_x('link_open', 'Admin Panel',  'naturalife'); ?></label>
			<select class="widefat" name="<?php echo $this->get_field_name('link_open'); ?>" id="<?php echo $this->get_field_id('link_open'); ?>">	
				<option value="_self" <?php selected( "_self", $link_open, 1 ); ?>><?php echo esc_html_x("Same Tab", 'Admin Panel','naturalife');?></option>		
				<option value="_blank" <?php selected( "_blank", $link_open, 1 ); ?>><?php echo esc_html_x("New Tab", 'Admin Panel','naturalife');?></option>		
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('href_title'); ?>"><?php echo esc_html_x('Link Title', 'Admin Panel','naturalife'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('href_title'); ?>" name="<?php echo $this->get_field_name('href_title'); ?>" type="text" value="<?php echo $href_title ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('id'); ?>"><?php echo esc_html_x('CSS ID', 'Admin Panel','naturalife'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('id'); ?>" name="<?php echo $this->get_field_name('id'); ?>" type="text" value="<?php echo $id ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('class'); ?>"><?php echo esc_html_x('CSS Class Name', 'Admin Panel','naturalife'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('class'); ?>" name="<?php echo $this->get_field_name('class'); ?>" type="text" value="<?php echo $class ?>" />
		</p>

<?php } } 

endif;
register_widget('RT_Button');
?>