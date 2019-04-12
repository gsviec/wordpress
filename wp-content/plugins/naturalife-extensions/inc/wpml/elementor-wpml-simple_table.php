<?php
/**
 * @author RT-Themes
 */

if( ! class_exists("RTFramework_WPML_Elementor_SimpleTables") ){
	class RTFramework_WPML_Elementor_SimpleTables extends WPML_Elementor_Module_With_Items  {

		/**
		 * @return string
		 */
		public function get_items_field() { 
			return 'rows';
		}

		/**
		 * @return array
		 */
		public function get_fields() {
			return array( 'col_1','col_2');
		}

		/**
		 * @param string $field
		 *
		 * @return string
		 */
		protected function get_title( $field ) {
			switch( $field ) {
				case 'col_1':
					return esc_html_x( 'Column 1', 'Admin Panel', 'naturalife' );

 				case 'col_2':
					return esc_html_x( 'Column 2', 'Admin Panel', 'naturalife' );

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
				case 'col_1':
					return 'TEXTAREA';

				case 'col_2':
					return 'TEXTAREA'; 
 
				default:
					return '';
			}
		}
	}
}