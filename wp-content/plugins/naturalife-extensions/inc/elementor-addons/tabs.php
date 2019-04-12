<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; 

class Widget_RT_Tabs extends Widget_Base {

	public function get_name() {
		return 'rt-tabs';
	}

	public function get_title() {
		return "[RT] ".esc_html_x( 'Tabs', 'Adnin Panel', 'naturalife' );
	}

	public function get_categories() {
		return [ 'rt-elementor-addons' ];
	}

	public function get_icon() {
		return 'eicon-tabs';
	}

	protected function _register_controls() {

		// Content Controls
  		$this->start_controls_section(
  			'RT_tab_content',
  			[
  				'label' => esc_html_x( 'Tabs','Admin Panel','naturalife' )
  			]
  		); 
  
		$this->add_control(
			'tabs_style',
				[	
					'type'    => Controls_Manager::SELECT,
					'label'   => esc_html_x( 'Tab Style', 'Admin Panel', 'naturalife' ),
					'default' => 'style-1',
					'options' => array( 
									"style-1" => esc_html_x("Horizontal Tabs", 'Admin Panel','naturalife'),
									"style-4" => esc_html_x("Horizontal Big Tabs", 'Admin Panel','naturalife'),
									"style-2" => esc_html_x("Left Vertical Tabs", 'Admin Panel','naturalife'), 
									"style-3" => esc_html_x("Right Vertical Tabs", 'Admin Panel','naturalife'), 
								),
			]
		); 

			$this->add_control(
				'tabs',
				[
					'label' => esc_html_x( 'Tabs','Admin Panel','naturalife' ),
					'type' => Controls_Manager::REPEATER,
					'default' => [
						[
							'title' => esc_html_x( 'Title', 'Admin Panel', 'naturalife' ),
							'content' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit essecillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'
						],
						[
							'title' => esc_html_x( 'Title', 'Admin Panel', 'naturalife' ),
							'content' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit essecillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'
						],
						[
							'title' => esc_html_x( 'Title', 'Admin Panel', 'naturalife' ),
							'content' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit essecillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'
						]	
					],					
					'fields' => [
						[
							'name' => 'title',
							'label' => esc_html_x( 'Tab Title', 'Admin Panel', 'naturalife' ),
							'type' => Controls_Manager::TEXT,
							'default' => esc_html_x( 'Tab Title', 'Admin Panel', 'naturalife' ),
							'placeholder' => esc_html_x( 'Tab Title', 'Admin Panel', 'naturalife' ),
							'label_block' => true,
						],
						[
							'name' => 'content',
							'label' => esc_html_x( 'Tab Content', 'Admin Panel', 'naturalife' ), 
							'type' => Controls_Manager::WYSIWYG,
							'show_label' => false,
						],
						[	
							'name' => 'icon_name',
							'label' => esc_html_x("Icon", 'Admin Panel','naturalife'),
							'type' => Controls_Manager::ICON,
							'return_value' => 'true',			
						],
						[
							'name' => 'use_image',
							'label' => esc_html_x("Image?", 'Admin Panel','naturalife'),
							'type' => Controls_Manager::SWITCHER,
							'default' => '',
							'label_on' => esc_html_x("ON", 'Admin Panel','naturalife'),
							'label_off' => esc_html_x("OFF", 'Admin Panel','naturalife'),
							'return_value' => 'true',
						],						
 						[
 							'name' => 'image',
							'label' => esc_html_x( 'Select Image', 'Admin Panel', 'naturalife' ),
							'type' => Controls_Manager::MEDIA,
							'return' => true,
							'default' => [
								'url' => Utils::get_placeholder_image_src(),
							],
							'condition' => [
									'use_image' => [ "true" ],
							],							
						],						
 						[
 							'name' => 'image_size',
							'label'   => esc_html_x("Image size", 'Admin Panel','naturalife'),
							'type'    =>  Controls_Manager::SELECT,
							"options" => array_merge( array(""=>esc_html_x("Select", 'Admin Panel','naturalife')), rtframework_get_intermediate_image_sizes() ),
							'condition' => [
									'use_image' => [ "true" ],
							],														
						],		
 						[
 							'name' => 'content_width',
							'label'   => esc_html_x("Text Width", 'Admin Panel','naturalife'), 
							'type'      =>  Controls_Manager::SELECT,
							'default'    =>  "6",
							"options"    => array(
												"1" => "1/12",
												"2" => "2/12",
												"3" => "3/12",
												"4" => "4/12",
												"5" => "5/12",
												"6" => "6/12",
												"7" => "7/12",
												"8" => "8/12",
												"9" => "9/12",
												"10" => "10/12",
												"11" => "11/12",
												"12" => "12/12",
											),	
							'condition' => [
									'use_image' => [ "true" ],
							],							
						],		
					],
					'title_field' => '{{{ title }}}',
				]
		);

		$this->end_controls_section();  
	}


	protected function render( ) {

			$settings = $this->get_settings(); 

			$tabs = $tab_contents = $tab_titles = ""; 
			$tabs_counter = 1;

			foreach ( $settings["tabs"] as $tab ) {

					extract($tab);

					//id
					$id =  'tab-'.$tabs_counter;

					//active tabs
					$class = $tabs_counter == 1 ? " active" : "";

					//icon
					$icon = ! empty( $icon_name ) ? '<span class="'.$icon_name.'"></span>' : "";
					$class .= ! empty( $icon_name ) ? ' with_icon' : "";

					//tab contents
					if( ! empty( $image ) && ! empty( $image["id"] ) ){
						$tab_contents .= sprintf(
									'<div class="tab_content_wrapper animation %2$s" id="%1$s" data-tab-content="%6$s">
										<div id="%1$s-inline-title" class="tab_title tab-inline-title" data-tab-number="%6$s">%5$s%3$s</div>
										<div class="tab_content">
											<div class="row align-items-center">
												<div class="col col-12 col-sm-%9$s tab-image mb-3 mb-sm-0">
													%7$s
												</div>
												<div class="col col-12 col-sm-%8$s tab-text">
													%4$s
												</div>
											</div>
										</div>
									</div>',	
									$id, trim($class), $title, apply_filters("the_content",$content), $icon, $tabs_counter,  wp_get_attachment_image( $image["id"], $image_size, false, array( "class" => "img-responsive aligncenter" )), $content_width, ($content_width == 12 ? 12 : 12-$content_width)  );						
					}else{
						$tab_contents .= sprintf(
									'<div class="tab_content_wrapper animation %2$s" id="%1$s" data-tab-content="%6$s">
										<div id="%1$s-inline-title" class="tab_title tab-inline-title" data-tab-number="%6$s">%5$s%3$s</div>
										<div class="tab_content">%4$s</div>
									</div>',	
									$id, trim($class), $title, apply_filters("the_content",$content), $icon, $tabs_counter );
					}	

					//tab titles
					$tab_titles .= sprintf(
								'<li class="tab_title %2$s" id="%1$s-title" data-tab-number="%5$s">%4$s%3$s</li>',
								$id, $class, $title, $icon, $tabs_counter );

				$tabs_counter++;
			}

			$output = '<ul class="tab_nav">'.$tab_titles.'</ul>';
			$output .= '<div class="tab_contents">'. $tab_contents .'</div>';

			$settings["tab_count_"] = $tabs_counter - 1;
 
			echo rt_shortcode_tabs( $settings, $output );
	}

	protected function content_template() {
	}
}


Plugin::instance()->widgets_manager->register_widget_type( new Widget_RT_Tabs() );
