<?php
/**
 * @author RT-Themes
 */

if( ! class_exists("RTFramework_WPML_Elementor_Pricing") ){
	class RTFramework_WPML_Elementor_Pricing extends WPML_Elementor_Module_With_Items  {

		/**
		 * @return string
		 */
		public function get_items_field() { 
			return 'columns';
		}

		/**
		 * @return array
		 */
		public function get_fields() {
			return array( 'caption','info','price','content');
		}

		/**
		 * @param string $field
		 *
		 * @return string
		 */
		protected function get_title( $field ) {
			switch( $field ) {
				case 'caption':
					return esc_html_x( 'Column caption', 'Admin Panel', 'naturalife' );

				case 'info':
					return esc_html_x( 'Info', 'Admin Panel', 'naturalife' );

				case 'price':
					return esc_html_x( 'Price', 'Admin Panel', 'naturalife' );

				case 'content':
					return esc_html_x( 'Content', 'Admin Panel', 'naturalife' );

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
				case 'caption':
					return 'LINE';

				case 'info':
					return 'LINE';

				case 'price':
					return 'LINE';

				case 'content':
					return 'VISUAL';
 
				default:
					return '';
			}
		}
	}
}