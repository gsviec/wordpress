<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; 

class Widget_RT_Slider extends Widget_Base {

	public function get_name() {
		return 'rt-slider';
	}

	public function get_title() {
		return "[RT] ".esc_html_x( 'Slider', 'Adnin Panel', 'naturalife' );
	}

	public function get_categories() {
		return [ 'rt-elementor-addons' ];
	}

	public function get_icon() {
		return 'eicon-slider-full-screen';
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_slides',
			[
				'label' => esc_html_x( 'Slides','Admin Panel','naturalife' ),
			]
		);

		$repeater = new Repeater();

		$repeater->start_controls_tabs( 'slides_repeater' );

		$repeater->start_controls_tab( 'background', [ 'label' => esc_html_x( 'Background', 'Admin Panel', 'naturalife' ) ] );

				$repeater->add_control('bg_image',
					[
						'label' => esc_html_x( 'Background Image', 'Admin Panel', 'naturalife' ),
						'type' => Controls_Manager::MEDIA,
						'default' => [ 'url' => Utils::get_placeholder_image_src() ],
					]
				);

				$repeater->add_control('bg_size',
		 			[	
		 				'type' => Controls_Manager::SELECT, 
						'label' => esc_html_x( 'Background Image Size', 'Admin Panel', 'naturalife' ),
						'options'      => array( 
											"cover" => esc_html_x("Cover",'Admin Panel','naturalife'),
											"auto auto" => esc_html_x("Auto",'Admin Panel','naturalife'),
											"contain" => esc_html_x("Contain",'Admin Panel','naturalife'),
											"100% auto" => esc_html_x("100%",'Admin Panel','naturalife'),
											"50% auto" => esc_html_x("50%",'Admin Panel','naturalife'),
											"25% auto" => esc_html_x("25%",'Admin Panel','naturalife'),
										),
					]	
				);

		 		$repeater->add_control(
					'background_width',
					[	
						'label' => esc_html_x( 'Background Image Container Width', 'Admin Panel', 'naturalife' ),
						'type'      =>  Controls_Manager::SELECT,
						"options"   => array(
											"fullwidth" => esc_html_x("Full Width",'Admin Panel', 'naturalife'),	
											"default"   => esc_html_x("Content Width",'Admin Panel', 'naturalife'),																				
										),		
					]		
				);

				$repeater->add_control('bg_position',
		 			[	
		 				'type' => Controls_Manager::SELECT,
						'label' => esc_html_x( 'Background Position', 'Admin Panel', 'naturalife' ),
						'options'      => array( 
											"right top" => esc_html_x("Right Top",'Admin Panel','naturalife'),
											"right center" => esc_html_x("Right Center",'Admin Panel','naturalife'),
											"right bottom" => esc_html_x("Right Bottom",'Admin Panel','naturalife'),
											"left top" => esc_html_x("Left Top",'Admin Panel','naturalife'),
											"left center" => esc_html_x("Left Center",'Admin Panel','naturalife'),
											"left bottom" => esc_html_x("Left Bottom",'Admin Panel','naturalife'),
											"center top" => esc_html_x("Center Top",'Admin Panel','naturalife'),
											"center center" => esc_html_x("Center Center",'Admin Panel','naturalife'),
											"center bottom" => esc_html_x("Center Bottom",'Admin Panel','naturalife'),
											"10% center" => esc_html_x("10% Center",'Admin Panel','naturalife'),
											"15% center" => esc_html_x("15% Center",'Admin Panel','naturalife'),
											"25% center" => esc_html_x("25% Center",'Admin Panel','naturalife'),
											"50% center" => esc_html_x("50% Center",'Admin Panel','naturalife'),
											"75% center" => esc_html_x("75% Center",'Admin Panel','naturalife'),
											"85% center" => esc_html_x("85% Center",'Admin Panel','naturalife'),											
										),
					]	
				);

				$repeater->add_control('bg_position_mobile',
		 			[	
		 				'type'     => Controls_Manager::SELECT,
						'label'    => esc_html_x( 'Background Position (Mobile)', 'Admin Panel', 'naturalife' ), 
						'options'  => array(
											"" => "", 
											"right top" => esc_html_x("Right Top",'Admin Panel','naturalife'),
											"right center" => esc_html_x("Right Center",'Admin Panel','naturalife'),
											"right bottom" => esc_html_x("Right Bottom",'Admin Panel','naturalife'),
											"left top" => esc_html_x("Left Top",'Admin Panel','naturalife'),
											"left center" => esc_html_x("Left Center",'Admin Panel','naturalife'),
											"left bottom" => esc_html_x("Left Bottom",'Admin Panel','naturalife'),
											"center top" => esc_html_x("Center Top",'Admin Panel','naturalife'),
											"center center" => esc_html_x("Center Center",'Admin Panel','naturalife'),
											"center bottom" => esc_html_x("Center Bottom",'Admin Panel','naturalife'),
											"10% center" => esc_html_x("10% Center",'Admin Panel','naturalife'),
											"15% center" => esc_html_x("15% Center",'Admin Panel','naturalife'),
											"25% center" => esc_html_x("25% Center",'Admin Panel','naturalife'),
											"50% center" => esc_html_x("50% Center",'Admin Panel','naturalife'),
											"75% center" => esc_html_x("75% Center",'Admin Panel','naturalife'),
											"85% center" => esc_html_x("85% Center",'Admin Panel','naturalife'),		
										)		
					]					
				);

				$repeater->add_control('bg_image_repeat',
		 			[	
		 				'type' => Controls_Manager::SELECT,
						'label' => esc_html_x( 'Background Repeat', 'Admin Panel', 'naturalife' ), 
						'options'      => array( 
												"repeat"       => esc_html_x("Tile",'Admin Panel','naturalife'),
												"repeat-x"     => esc_html_x("Tile Horizontally",'Admin Panel','naturalife'),
												"repeat-y"     => esc_html_x("Tile Vertically",'Admin Panel','naturalife'),
												"no-repeat"    => esc_html_x("No Repeat",'Admin Panel','naturalife'),
										),
					]	
				);

				$repeater->add_control('bg_color',
		 			[	
						'label' => esc_html_x( 'Background Color', 'Admin Panel', 'naturalife' ),
						'type' => Controls_Manager::COLOR,  
					]	
				);

				$repeater->add_control('bg_color_tone',
		 			[	
		 				'type' => Controls_Manager::SELECT,
						'label' => esc_html_x( 'Color Tone', 'Admin Panel', 'naturalife' ),
						'description' => esc_html_x( 'Specify the color tone to match the related color set with the overlapped header (if active), arrows and navigation buttons.', 'Admin Panel','naturalife' ),
						'options'      => array( 
											'dark'  => esc_html_x('Dark', 'Admin Panel', 'naturalife'),
											'light' => esc_html_x('Light', 'Admin Panel', 'naturalife'),
										),
					]	
				);


		$repeater->end_controls_tab();

		$repeater->start_controls_tab( 'contents', [ 'label' => esc_html_x( 'Content', 'Admin Panel', 'naturalife' ) ] );


				$repeater->add_control('heading',
						[
							'label' => esc_html_x( 'Title', 'Admin Panel', 'naturalife' ),
							'type' => Controls_Manager::TEXT,
							'default' => esc_html_x( 'Tab Title', 'Admin Panel', 'naturalife' ),
							'placeholder' => esc_html_x( 'Tab Title', 'Admin Panel', 'naturalife' ),
							'label_block' => true,
						]
				);

				$repeater->add_control('second_heading',
						[
							'label' => esc_html_x('Second Title', 'Admin Panel','naturalife' ),
							'type' => Controls_Manager::TEXT,
							'label_block' => true,
						]	
				);			

				$repeater->add_control('content',
						[
							'label' => esc_html_x( 'Slide Content', 'Admin Panel', 'naturalife' ), 
							'type' => Controls_Manager::TEXTAREA,
							'show_label' => true,
						]
				);			

				$repeater->add_control('nav_text',
						[
							'label' => esc_html_x('Navigation Text', 'Admin Panel','naturalife' ),
							'type' => Controls_Manager::TEXT,
							'placeholder' => esc_html_x('Navigation Text', 'Admin Panel','naturalife' ),
							'label_block' => true,
							'description' => esc_html_x('The text will be displayed as a navigation item if the "Text Navigation" has been enabled for the slider.', 'Admin Panel','naturalife' ),
						]		
				);		

				$repeater->add_control('heading_max_font_size',
						[
							'label' => esc_html_x( 'Heading Max Font Size (px)', 'Admin Panel', 'naturalife' ),
							'type' => Controls_Manager::NUMBER
						]		
				);			

				$repeater->add_control('heading_min_font_size',
						[
							'label' => esc_html_x( 'Heading Min Font Size (px)', 'Admin Panel', 'naturalife' ),
							'type' => Controls_Manager::NUMBER
						]		
				);		

				$repeater->add_control('content_font_size',
						[
							'label' => esc_html_x( 'Content Font Size (px)', 'Admin Panel', 'naturalife' ),
							'type' => Controls_Manager::NUMBER
						]		
				);	

				$repeater->add_control('mobile_heading_font_size',
						[
							'label' => esc_html_x( 'Heading Font Size for Mobile (px)', 'Admin Panel', 'naturalife' ),
							'type' => Controls_Manager::NUMBER
						]		
				);	

				$repeater->add_control('mobile_content_font_size',
						[
							'label' => esc_html_x( 'Content Font Size for Mobile (px)', 'Admin Panel', 'naturalife' ),
							'type' => Controls_Manager::NUMBER
						]		
				);	


				$repeater->add_control('content_color_schema',
						[
			 				'type' => Controls_Manager::SELECT,
							'label' => esc_html_x( 'Content Color Set', 'Admin Panel', 'naturalife' ),
							'description' => esc_html_x( 'Width of the content block. For mobile device screens, this value will be calculated automatically depends the screen width.', 'Admin Panel','naturalife' ),
							'options'      => array( 
												''              => esc_html_x('Global Colors', 'Admin Panel', 'naturalife'),
												'default-style' => esc_html_x('Default Style', 'Admin Panel', 'naturalife'),
												'alt-style-1'   => esc_html_x('Alt Style 1', 'Admin Panel', 'naturalife'),
												'light-style'   => esc_html_x('Light Style', 'Admin Panel', 'naturalife'),
											),
							'separator' => 'default'
						]		
				);	

				$repeater->add_control('content_bg_color',
		 			[	
						'label' => esc_html_x( 'Background Color', 'Admin Panel', 'naturalife' ),
						'type' => Controls_Manager::COLOR,  
					]	
				);

				$repeater->add_control('content_width',
						[
							'label' => esc_html_x( 'Content Width (percent)', 'Admin Panel', 'naturalife' ),
							'description' => esc_html_x('Width of the content block. For mobile device screens, this value will be calculated automatically depends the screen width.', 'Admin Panel','naturalife' ),
							'default' =>'40',
							'type' => Controls_Manager::TEXT
						]		
				);	

				$repeater->add_control('content_align',
						[
			 				'type' => Controls_Manager::SELECT,
							'label' => esc_html_x( 'Content Align', 'Admin Panel', 'naturalife' ),
							'description' => esc_html_x( 'Select a position for the content block. For mobile device screens, the content block will be aligned to the center automatically', 'Admin Panel','naturalife' ),
							'options'      => array( 
												"left" => esc_html_x("Left",'Admin Panel','naturalife'),
												"right" => esc_html_x("Right",'Admin Panel','naturalife'),												
												"center" => esc_html_x("Center",'Admin Panel','naturalife'),
											),
						]		
				);				

				$repeater->add_control('text_align',
						[
			 				'type' => Controls_Manager::SELECT,
							'label' => esc_html_x( 'Text Align', 'Admin Panel', 'naturalife' ),
							'description' => esc_html_x( 'Align the text within the content block.', 'Admin Panel','naturalife' ),
							'options'      => array( 
												"left" => esc_html_x("Left",'Admin Panel','naturalife'),								
												"right" => esc_html_x("Right",'Admin Panel','naturalife'),												
												"center" => esc_html_x("Center",'Admin Panel','naturalife'),
											),
						]		
				);	

				$repeater->add_control('content_padding',
						[
							'label' => esc_html_x( 'Content Padding (px)', 'Admin Panel', 'naturalife' ),
							'type' => Controls_Manager::NUMBER
						]		
				);

				$repeater->add_control('link',
						[
							'label' => esc_html_x("Slide Link", 'Admin Panel','naturalife'),
							'type' => Controls_Manager::URL,
							'placeholder' => 'http://your-link.com',
							'default' => [
								'url' => '',
							],
						]		
				);	

		$repeater->end_controls_tab();

		$repeater->start_controls_tab( 'buttons', [ 'label' => esc_html_x( 'Buttons',  'Admin Panel','naturalife' ) ] );


				$repeater->add_control('button_text',
						[
							'label' => esc_html_x("Button Text", 'Admin Panel','naturalife'),
							'type' => Controls_Manager::TEXT, 
						]		
				);	

				$repeater->add_control('button_style',
						[
			 				'type' => Controls_Manager::SELECT,
							'label' => esc_html_x( 'Button Style', 'Admin Panel', 'naturalife' ),
							'options'      => array( 
													"style-1" => esc_html_x("Style 1", 'Admin Panel','naturalife'),
													"style-2" => esc_html_x("Style 2", 'Admin Panel','naturalife'),
													"style-3" => esc_html_x("Style 3", 'Admin Panel','naturalife'),
													"black"   => esc_html_x("Black", 'Admin Panel','naturalife'),
													"white"   => esc_html_x("White", 'Admin Panel','naturalife'),
													"text"    => esc_html_x("Flat Text", 'Admin Panel','naturalife'), 
											),
						]		
				);	

				$repeater->add_control(
					'button_arrow',
					[
						'label' => esc_html_x("Button Arrow?", 'Admin Panel','naturalife'),
						'type' => Controls_Manager::SWITCHER,
						'default' => '',
						'label_on' => esc_html_x("ON", 'Admin Panel','naturalife'),
						'label_off' => esc_html_x("OFF", 'Admin Panel','naturalife'),
						'return_value' => 'true',
					]
				); 

				$repeater->add_control(
					'button_rounded',
					[
						'label' => esc_html_x("Rounded Button?", 'Admin Panel','naturalife'),
						'type' => Controls_Manager::SWITCHER,
						'default' => '',
						'label_on' => esc_html_x("ON", 'Admin Panel','naturalife'),
						'label_off' => esc_html_x("OFF", 'Admin Panel','naturalife'),
						'return_value' => 'true',
					]
				); 
				$repeater->add_control(
					'button_size',
					[
						'label'     => esc_html_x( 'Button Size', 'Admin Panel','naturalife' ),
						'type'      =>  Controls_Manager::SELECT,
						'default'    => 'small',
						"options"    => array(
											"small" => esc_html_x("Small", 'Admin Panel','naturalife'),
											"medium" => esc_html_x("Medium", 'Admin Panel','naturalife'),
											"big" => esc_html_x("Big", 'Admin Panel','naturalife'),
											"hero" => esc_html_x("Hero", 'Admin Panel','naturalife'), 
										),			
					]
				);  

				$repeater->add_control('button_link',
						[
							'label' => esc_html_x("Button Link", 'Admin Panel','naturalife'),
							'type' => Controls_Manager::URL,
							'placeholder' => 'http://your-link.com',
							'default' => [
								'url' => '',
							],
						]		
				);	

				$repeater->add_control('button2_text',
						[
							'label' => esc_html_x("Button 2 Text", 'Admin Panel','naturalife'),
							'type' => Controls_Manager::TEXT, 
						]		
				);	

				$repeater->add_control('button2_style',
						[
			 				'type' => Controls_Manager::SELECT,
							'label' => esc_html_x( 'Button 2 Style', 'Admin Panel', 'naturalife' ),
							'options'      => array( 
													"style-1" => esc_html_x("Style 1", 'Admin Panel','naturalife'),
													"style-2" => esc_html_x("Style 2", 'Admin Panel','naturalife'),
													"style-3" => esc_html_x("Style 3", 'Admin Panel','naturalife'),
													"black"   => esc_html_x("Black", 'Admin Panel','naturalife'),
													"white"   => esc_html_x("White", 'Admin Panel','naturalife'),
													"text"    => esc_html_x("Flat Text", 'Admin Panel','naturalife'), 
											),
						]		
				);	

				$repeater->add_control('button2_link',
						[
							'label' => esc_html_x("Button 2 Link", 'Admin Panel','naturalife'),
							'type' => Controls_Manager::URL,
							'placeholder' => 'http://your-link.com',
							'default' => [
								'url' => '',
							],
						]		
				);	


				$repeater->add_control(
					'button2_arrow',
					[
						'label' => esc_html_x("Button 2 Arrow?", 'Admin Panel','naturalife'),
						'type' => Controls_Manager::SWITCHER,
						'default' => '',
						'label_on' => esc_html_x("ON", 'Admin Panel','naturalife'),
						'label_off' => esc_html_x("OFF", 'Admin Panel','naturalife'),
						'return_value' => 'true',
					]
				); 

				$repeater->add_control(
					'button2_rounded',
					[
						'label' => esc_html_x("Rounded Button?", 'Admin Panel','naturalife'),
						'type' => Controls_Manager::SWITCHER,
						'default' => '',
						'label_on' => esc_html_x("ON", 'Admin Panel','naturalife'),
						'label_off' => esc_html_x("OFF", 'Admin Panel','naturalife'),
						'return_value' => 'true',
					]
				); 
				$repeater->add_control(
					'button2_size',
					[
						'label'     => esc_html_x( 'Button 2 Size', 'Admin Panel','naturalife' ),
						'type'      =>  Controls_Manager::SELECT,
						'default'    => 'small',
						"options"    => array(
											"small" => esc_html_x("Small", 'Admin Panel','naturalife'),
											"medium" => esc_html_x("Medium", 'Admin Panel','naturalife'),
											"big" => esc_html_x("Big", 'Admin Panel','naturalife'),
											"hero" => esc_html_x("Hero", 'Admin Panel','naturalife'), 
										),			
					]
				);  

		$repeater->end_controls_tab();

		$repeater->end_controls_tabs();

		$this->add_control(
			'slides',
			[
				'label' => esc_html_x( 'Slides', 'Admin Panel', 'naturalife' ),
				'type' => Controls_Manager::REPEATER,
				'show_label' => true,
				'fields' => array_values( $repeater->get_controls() ),
				'title_field' => '{{{ heading }}}',
				'default' => [
					[
						'heading' => __( 'Slide 1 Heading', 'Admin Panel', 'naturalife' ),
						'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer et fringilla orci. Maecenas convallis nisl et massa consequat pellentesque. Vivamus sed condimentum enim.',
						'button_text' => __( 'SHOP NOW', 'Admin Panel', 'naturalife' ),
						'button_style' => "style-2",
						'button_size' => 'medium',
						'button_rounded' => true,
						'bg_color' => '#f2f2f2',
						'bg_color_tone' => 'dark',
						'heading_max_font_size' => '40',
						'heading_min_font_size' => '30',
						'content_font_size' => '16',
						'mobile_heading_font_size' => '22',
						'mobile_content_font_size' => '16'						
					],
					[
						'heading' => __( 'Slide 2 Heading', 'Admin Panel', 'naturalife' ),
						'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer et fringilla orci. Maecenas convallis nisl et massa consequat pellentesque. Vivamus sed condimentum enim.',
						'button_text' => __( 'SHOP NOW', 'Admin Panel', 'naturalife' ),
						'button_style' => "style-2",
						'button_size' => 'medium',
						'button_rounded' => true,
						'bg_color' => '#f2f2f2',
						'bg_color_tone' => 'dark',
						'heading_max_font_size' => '40',
						'heading_min_font_size' => '30',
						'content_font_size' => '16',
						'mobile_heading_font_size' => '22',
						'mobile_content_font_size' => '16'						
					]					
				]		
			]
		); 

		$this->end_controls_section();

		$this->start_controls_section(
			'section_slider_options',
			[
				'label' => esc_html_x( 'Slider Options', 'Admin Panel', 'naturalife' ),
				'type' => Controls_Manager::SECTION,
			]
		);	
 
			$this->add_control(
				'min_height',
				[
					'label' => esc_html_x( 'Minimum Slider Height (px)', 'Admin Panel', 'naturalife' ),
					'type' => Controls_Manager::TEXT,
					'default' => 400
				]		
			);
	 
	 		$this->add_control(
				'tablet_min_height',
				[	
					'label' => esc_html_x( 'Image Height for Tablet (px)', 'Admin Panel', 'naturalife' ),
					'type' => Controls_Manager::TEXT,
					'default' => 300
				]		
			);

	 		$this->add_control(
				'mobile_min_height',
				[	
					'label' => esc_html_x( 'Image Height for Mobile (px)', 'Admin Panel', 'naturalife' ),
					'type' => Controls_Manager::TEXT,
					'default' => 300
				]		
			);

	 		$this->add_control(
				'content_wrapper_width',
				[	
					'label' => esc_html_x( 'Content Width', 'Admin Panel', 'naturalife' ),
					'type'      =>  Controls_Manager::SELECT,
					"options"    => array(
										"default"   => esc_html_x("Default",'Admin Panel', 'naturalife'),
										"fullwidth" => esc_html_x("Full Width",'Admin Panel', 'naturalife'),										
									),		
				]		
			);

	 		$this->add_control(
				'timeout',
				[	
					'label' => esc_html_x( 'Timeout', 'Admin Panel', 'naturalife' ),
					'description' => esc_html_x('Timeout value for each slide. Default is 5000 (equal 5sec)', 'Admin Panel','naturalife' ),
					'type' => Controls_Manager::TEXT,
					'default' => 5000
				]		
			); 

			$this->add_control(
				'text_nav',
				[
					'label' => esc_html_x("Text Navigation", 'Admin Panel','naturalife'),
					'type' => Controls_Manager::SWITCHER,
					'default' => '',
					'label_on' => esc_html_x("ON", 'Admin Panel','naturalife'),
					'label_off' => esc_html_x("OFF", 'Admin Panel','naturalife'),
					'return_value' => 'true',
				]
			); 

			$this->add_control(
				'dots',
				[
					'label' => esc_html_x("Navigation Dots", 'Admin Panel','naturalife'),
					'type' => Controls_Manager::SWITCHER,
					'default' => '',
					'label_on' => esc_html_x("ON", 'Admin Panel','naturalife'),
					'label_off' => esc_html_x("OFF", 'Admin Panel','naturalife'),
					'return_value' => 'true',
					'default' => 'true'
				]
			); 

			$this->add_control(
				'nav',
				[
					'label' => esc_html_x("Navigation Arrows", 'Admin Panel','naturalife'),
					'type' => Controls_Manager::SWITCHER,
					'default' => '',
					'label_on' => esc_html_x("ON", 'Admin Panel','naturalife'),
					'label_off' => esc_html_x("OFF", 'Admin Panel','naturalife'),
					'return_value' => 'true',
					'default' => 'true'
				]
			); 

			$this->add_control(
				'autoplay',
				[
					'label' => esc_html_x("Autoplay", 'Admin Panel','naturalife'),
					'type' => Controls_Manager::SWITCHER,
					'description' => esc_html_x('Start sliding automatically', 'Admin Panel','naturalife' ),
					'label_on' => esc_html_x("ON", 'Admin Panel','naturalife'),
					'label_off' => esc_html_x("OFF", 'Admin Panel','naturalife'),
					'return_value' => 'true',
					'default' => 'true'
				]
			); 

			$this->add_control(
				'parallax',
				[
					'label' => esc_html_x("Parallax Effect", 'Admin Panel','naturalife'),
					'type' => Controls_Manager::SWITCHER,
					'description' => esc_html_x('Enable parallax effect for this slider', 'Admin Panel','naturalife' ),
					'label_on' => esc_html_x("ON", 'Admin Panel','naturalife'),
					'label_off' => esc_html_x("OFF", 'Admin Panel','naturalife'),
					'return_value' => 'true',
					'default' => 'true'					
				]
			); 		

		$this->end_controls_section();  	
	}

	protected function render( ) {

			$settings = $this->get_settings(); 

			$slides = "";
			$nav_items = "";
			$slide_counter = 1;

			foreach ( $settings["slides"] as $slide ) {

				$slide["class"] = "elementor-repeater-item-".$slide["_id"]; 

				$slide["bg_image"] = isset( $slide["bg_image"]["id"] ) ? $slide["bg_image"]["id"] : "";
				$slide["min_height"] = $settings["min_height"];


				$slide_link = $slide["link"];
				$slide["link"] = $slide_link['url'];
				$slide["link_target"] = $slide_link['is_external'] ? '_blank' : '_self';

				$slide_button_link = $slide["button_link"];
				$slide["button_link"] = $slide_button_link['url'];
				$slide["button_link_target"] = $slide_button_link['is_external'] ? '_blank' : '_self';

				$slide_button2_link = $slide["button2_link"];
				$slide["button2_link"] = $slide_button2_link['url'];
				$slide["button2_link_target"] = $slide_button2_link['is_external'] ? '_blank' : '_self';

				$slide["content_wrapper_width"] = ! empty( $settings["content_wrapper_width"] ) ? $settings["content_wrapper_width"] : "default";


				$slides .= rt_slide( $slide, $slide["content"] );

				$nav_items .= sprintf('<a class="url" data-href="%s" href="javascript:void(0);"><span>%s</span>%s</a>', $slide_counter -1, "0".$slide_counter, $slide["nav_text"]);



				$slide_counter++;
			}

			$settings["nav_items_"] = $nav_items;
			$settings["slide_count_"] = $slide_counter - 1;
				
			echo rt_slider( $settings, $slides );
	}

	protected function content_template() {
	}
}


Plugin::instance()->widgets_manager->register_widget_type( new Widget_RT_Slider() );
