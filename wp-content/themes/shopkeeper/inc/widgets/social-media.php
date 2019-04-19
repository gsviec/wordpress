<?php

add_action( 'widgets_init', 'register_social_media_widget' );

function register_social_media_widget() {
	register_widget( 'Social_Media_Widget' );
}

class Social_Media_Widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'shopkeeper_social_media', // Base ID
			__('Shopkeeper Social Media Profiles', 'shopkeeper'), // Name
			array( 'description' => __( 'A widget that displays Social Media Profiles', 'shopkeeper' ), ) // Args
		);
	}

	public function widget( $args, $instance ) {

		if( isset( $instance['title'] ) ) {
			$title = apply_filters( 'widget_title', $instance['title'] );
		}

		echo $args['before_widget'];
		
		if ( ! empty( $title ) )
			echo $args['before_title'] . $title . $args['after_title'];
		
		global $shopkeeper_theme_options, $social_media_profiles;
		
		foreach($social_media_profiles as $social) :

			if ( isset($shopkeeper_theme_options[$social['link']]) && !empty($shopkeeper_theme_options[$social['link']]) ) :

				echo('<a href="' . $shopkeeper_theme_options[$social['link']] . '" target="_blank"><span class="' . $social['icon'] . '"></span></a>' );

			endif;

		endforeach;

		echo $args['after_widget'];
	}

	public function form( $instance ) {
		
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = __( 'Get Connected', 'shopkeeper' );
		}
		?>
		
        <p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'shopkeeper' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		
		<?php 
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

		return $instance;
	}

}