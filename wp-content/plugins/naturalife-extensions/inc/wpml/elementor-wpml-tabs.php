<?php
/**
 * @author RT-Themes
 */

if( ! class_exists("RTFramework_WPML_Elementor_Toggle") ){
	class RTFramework_WPML_Elementor_Toggle extends WPML_Elementor_Module_With_Items  {

		/**
		 * @return string
		 */
		public function get_items_field() { 
			return 'tabs';
		}

		/**
		 * @return array
		 */
		public function get_fields() {
			return array( 'title', 'content' );
		}

		/**
		 * @param string $field
		 *
		 * @return string
		 */
		protected function get_title( $field ) {
			switch( $field ) {
				case 'title':
					return esc_html_x( 'Tab Title', 'Admin Panel', 'naturalife' );

				case 'content':
					return esc_html_x( 'Tab Content', 'Admin Panel', 'naturalife' ); 

				default:
					return '';
			}
		}

		/**
		 * @param string $field
		 *
		 * @return string
		 */
		protected function get_editor_type( $field ) {
			switch( $field ) {
				case 'title':
					return 'LINE';

				case 'content':
					return 'VISUAL';

				default:
					return '';
			}
		}
	}
}