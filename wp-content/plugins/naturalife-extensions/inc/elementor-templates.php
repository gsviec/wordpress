<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( ! class_exists("RTFramework_Templates_Source") ){
	class RTFramework_Templates_Source extends Elementor\TemplateLibrary\Source_Base {

		/**
		 * @since 1.0.0
		 * @access public
		*/
		public function get_id() {
			return 'naturalife-library';
		}

		/**
		 * @since 1.0.0
		 * @access public
		*/
		public function get_title() {
			return esc_html_x( 'NaturaLife Templates', 'Admin Panel', 'naturalife' );
		}

		/**
		 * @since 1.0.0
		 * @access public
		*/
		public function register_data() {}

		/**
		 * @since 1.0.0
		 * @access public
		*/
		public function get_items( $args = [] ) {

			if ( ! current_user_can( "edit_theme_options" ) ){
				return;
			}

			require( RT_EXTENSIONS_PATH . "/inc/templates/source/template-list.php" );

			$templates = [];

			if ( ! empty( $template_list ) ) {
				foreach ( $template_list as $template_data ) {
					$templates[] = $this->get_item( $template_data );
				}
			}

			if ( ! empty( $args ) ) {
				$templates = wp_list_filter( $templates, $args );
			}

			return $templates;
		}

		/**
		 * @since 1.0.0
		 * @access public
		 * @param array $template_data
		 *
		 * @return array
		 */
		public function get_item( $template_data ) {
			$favorite_templates = $this->get_user_meta( 'favorites' );

			return [
				'id' => RT_THEMESLUG."-".$template_data['id'],
				'source' => $this->get_id(),
				'title' => RT_THEMENAME. ' - ' .$template_data['title'],
				"thumbnail" => RT_EXTENSIONS_URI. 'inc/templates/template-images/'.$template_data['id'].'.jpg',
				'date' => "",
				'author' => "RT-Themes",		
				'tags' => $template_data['tags'],
				'isPro' => 0,
				'popularityIndex' => 1,
				'trendIndex' => 1,
				'hasPageSettings' => 0,
				'url' => $template_data['url'],
				'favorite' => ! empty( $favorite_templates[ $template_data['id'] ] ),
				"menu_order" => '1',
				'is_pro' => 0,
				'popularity_index' => 1,
				'trend_index' => 1,
				'has_page_settings' => 0,
				'tmpl_created' => "",
				'type'  => $template_data['type'],
				'subtype' => $template_data['subtype']
			];
		}

		/**
		 * @since 1.0.0
		 * @access public
		*/
		public function save_item( $template_data ) {
			return false;
		}

		/**
		 * @since 1.0.0
		 * @access public
		*/
		public function update_item( $new_data ) {
			return false;
		}

		/**
		 * @since 1.0.0
		 * @access public
		*/
		public function delete_template( $template_id ) {
			return false;
		}

		/**
		 * @since 1.0.0
		 * @access public
		*/
		public function export_template( $template_id ) {
			return false;
		}

		/**
		 * @since 1.5.0
		 * @access public
		*/
		public function get_data( array $args, $context = 'display' ) {

			if ( ! current_user_can( "edit_theme_options" ) ){
				return;
			}

			ob_start();
			include( RT_EXTENSIONS_PATH . '/inc/templates/source/'. str_replace( RT_THEMESLUG."-", "", $args["template_id"] ) .'.json' );		
			$data = json_decode( ob_get_clean(), true );

			// TODO: since 1.5.0 to content container named `content` instead of `data`.
			if ( ! empty( $data['data'] ) ) {
				$data['content'] = $data['data'];
				unset( $data['data'] );
			}

			$data['content'] = $this->replace_elements_ids( $data['content'] );
			$data['content'] = $this->process_export_import_content( $data['content'], 'on_import' );

			if ( ! empty( $args['page_settings'] ) && ! empty( $data['page_settings'] ) ) {
				$page = new Page( [
					'settings' => $data['page_settings'],
				] );

				$page_settings_data = $this->process_element_export_import_content( $page, 'on_import' );
				$data['page_settings'] = $page_settings_data['settings'];
			}

			return $data;
		}
	}
}

if( ! class_exists("RTFramework_Templates_Manager") ){
	class RTFramework_Templates_Manager extends Elementor\TemplateLibrary\Manager {

			/**
			 * Get library data.
			 *
			 * Retrieve the library data.
			 *
			 * @since 1.9.0
			 * @access public
			 *
			 * @param array $args Library arguments.
			 *
			 * @return array Library data.
			 */
			public function get_library_data( array $args ) {

				$library_data = Elementor\Api::get_library_data( ! empty( $args['sync'] ) );

				return [
					'templates' => $this->get_templates(),
					'config' => [
						'categories' => array_merge(array(
							"NaturaLife - Section",
							"NaturaLife - Slider"
						),$library_data['categories']),
					],
				];
			}
	}
}