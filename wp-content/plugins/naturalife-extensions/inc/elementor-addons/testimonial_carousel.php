<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; 

class Widget_RT_Testimonial_Carousel extends Widget_Base {

	public function get_name() {
		return 'rt-testimonial-carousel';
	}

	public function get_title() {
		return "[RT] ".esc_html_x( 'Testimonial Carousel', 'Adnin Panel', 'naturalife' );
	}

	public function get_categories() {
		return [ 'rt-elementor-addons' ];
	}

	public function get_icon() {
		return 'eicon-testimonial-carousel';
	}

	protected function _register_controls() {

		// Content Controls
  		$this->start_controls_section(
  			'RT_testimonial_carousel_content',
  			[
  				'label' => esc_html_x( 'Testimonial Carousel','Admin Panel','naturalife' )
  			]
  		); 

		$this->add_control(
			'list_layout',
			[
				'label'     => esc_html_x( 'Carousel Layout', 'Admin Panel','naturalife' ),
				'description' => esc_html_x('Visible item count for each slide on desktop screens.', 'Admin Panel','naturalife' ),	
				'type'      =>  Controls_Manager::SELECT,
				'default'    =>  "1/1",
				"options"    => array(
									"1/1" => "1",
									"1/2" => "2",													
									"1/3" => "3",													
									"1/4" => "4",													
									"1/5" => "5",													
									"1/6" => "6",
								),				
			]
		 
		);

		$this->add_control(
			'tablet_layout',
			[
				'label'     => esc_html_x( 'Carousel Layout (Tablet)', 'Admin Panel','naturalife' ),
				'description' => esc_html_x('Visible item count for each slide on medium screens', 'Admin Panel','naturalife' ),	
				'type'      =>  Controls_Manager::SELECT,
				'default'    =>  "",
				"options"    => array(
									"" => esc_html_x( 'Default', 'Admin Panel','naturalife' ),
									"1" => "1",
									"2" => "2",													
									"3" => "3",													
									"4" => "4",													
									"5" => "5",													
									"6" => "6",			 
								),				
			]
		 
		);

		$this->add_control(
			'mobile_layout',
			[
				'label'     => esc_html_x( 'Carousel Layout (Mobile)', 'Admin Panel','naturalife' ),
				'description' => esc_html_x('Visible item count for each slide on small screens', 'Admin Panel','naturalife' ),	
				'type'      =>  Controls_Manager::SELECT,
				'default'    =>  "",
				"options"    => array(
									"" => esc_html_x( 'Default', 'Admin Panel','naturalife' ),
									"1" => "1",
									"2" => "2",													
									"3" => "3",													
									"4" => "4",		 	 
								),				
			]
		 
		);
 
 		$this->add_control(
			'style',
			[
				'label'     => esc_html_x( 'Style', 'Admin Panel','naturalife' ), 
				'type'      =>  Controls_Manager::SELECT,
				'default'    =>  "center big",
				"options"    => array(
									"left" => esc_html_x("Left Aligned Text",'Admin Panel','naturalife'),
									"center" => esc_html_x("Centered Small Text ",'Admin Panel','naturalife'),
									"center big" => esc_html_x("Centered Big Text ",'Admin Panel','naturalife'),
								),				
			]
		 
		); 
 

 		$this->add_control(
			'box_style',
			[
				'label'     => esc_html_x( 'Box Style', 'Admin Panel','naturalife' ), 
				'type'      =>  Controls_Manager::SELECT,
				'default'    =>  "",
				"options"    => array(
									"" => esc_html_x( 'Default', 'Admin Panel','naturalife' ),
									"boxed" => esc_html_x( 'Boxed', 'Admin Panel','naturalife' ),
								 
								),								
			]
		 
		); 


		$this->add_control(
			'box_border_radius',
			[
				'label' => esc_html_x( 'Box Border Radius', 'Admin Panel', 'naturalife' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 300,
						'step' => 1,
					]
				],
				'selectors' => [
					'{{WRAPPER}} .boxed' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
								'box_style' => [ "boxed" ],
							],					
			]
		);



 		$this->add_control(
				'max_item',
				[
					'label'   => esc_html_x( 'Amount of item to display', 'Admin Panel', 'naturalife' ),
					'type'    => Controls_Manager::NUMBER,
					'default' =>  "10"
				]
		);  
 


 		$this->add_control(
			'list_orderby',
			[
				'label'     => esc_html_x( 'List Order By', 'Admin Panel','naturalife' ),
				'description' => esc_html_x('Sorts the posts by this parameter', 'Admin Panel','naturalife' ),	
				'type'      =>  Controls_Manager::SELECT,
				'default'    =>  "date",
				"options"    => array(
									'date' => esc_html_x('Date',"Admin Panel","naturalife"),
									'author' => esc_html_x('Author',"Admin Panel","naturalife"),
									'title' => esc_html_x('Title',"Admin Panel","naturalife"),
									'modified' => esc_html_x('Modified',"Admin Panel","naturalife"),
									'ID' => esc_html_x('ID',"Admin Panel","naturalife"),
									'rand' => esc_html_x('Randomized',"Admin Panel","naturalife"),
								)							
			]
		 
		); 


 		$this->add_control(
			'list_order',
			[
				'label'     => esc_html_x( 'List Order', 'Admin Panel','naturalife' ),
				'description' => esc_html_x('Designates the ascending or descending order of the list_orderby parameter', 'Admin Panel','naturalife' ),	
				'type'      =>  Controls_Manager::SELECT,
				'default'    =>  "DESC",
				"options"    => array(
									"DESC" => esc_html_x('Descending',"Admin Panel","naturalife"),
									"ASC" => esc_html_x('Ascending',"Admin Panel","naturalife"),
								)							
			]
		 
		); 

 		$this->add_control(
			'categories',
			[
				'label'     => esc_html_x( 'Categories', 'Admin Panel','naturalife' ),
				'description' => esc_html_x('Filter the posts by selected categories.', 'Admin Panel','naturalife' ),	
				'type'      =>  Controls_Manager::SELECT2,
				'default'    =>  "",
				'multiple' => true,
				"options"    => rt_get_testimonial_categories(),					
			]
		 
		); 


		$this->add_control(
			'headings',
			[
				'label' => esc_html_x("Display Headings", 'Admin Panel','naturalife'),
				'type' => Controls_Manager::SWITCHER,
				'default' => '',
				'label_on' => esc_html_x("ON", 'Admin Panel','naturalife'),
				'label_off' => esc_html_x("OFF", 'Admin Panel','naturalife'),
				'return_value' => 'true',
			]
		); 

		$this->add_control(
			'client_images',
			[
				'label' => esc_html_x("Display Client Images", 'Admin Panel','naturalife'),
				'type' => Controls_Manager::SWITCHER,
				'default' => '',
				'label_on' => esc_html_x("ON", 'Admin Panel','naturalife'),
				'label_off' => esc_html_x("OFF", 'Admin Panel','naturalife'),
				'return_value' => 'true',
			]
		); 

				
		$this->end_controls_section();


		/* Carousel Settings */
  		$this->start_controls_section(
  			'RT_Carousel_settings',
  			[
  				'label' => esc_html_x( 'Carousel Settings','Admin Panel','naturalife' )
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
				]
			); 

			$this->add_control(
				'nav',
				[
					'label' => esc_html_x("Navigation Arrows", 'Admin Panel','naturalife'),
					'type' => Controls_Manager::SWITCHER,
					'default' => 'true',
					'label_on' => esc_html_x("ON", 'Admin Panel','naturalife'),
					'label_off' => esc_html_x("OFF", 'Admin Panel','naturalife'),
					'return_value' => 'true',
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
				]
			); 

			$this->add_control(
					'timeout',
					[
						'label' => esc_html_x( 'Auto Play Speed (ms)', 'Admin Panel', 'naturalife' ),
						'description' => esc_html_x('Auto play speed value in milliseconds. For example; set 5000 for 5 seconds', 'Admin Panel','naturalife' ),
						'type' => Controls_Manager::NUMBER,
						'min' => 100,
						'max' => 20000 	 
					]
			);

			$this->add_control(
				'loop',
				[
					'label' => esc_html_x("Loop", 'Admin Panel','naturalife'),
					'type' => Controls_Manager::SWITCHER,
					'default' => '',
					'label_on' => esc_html_x("ON", 'Admin Panel','naturalife'),
					'label_off' => esc_html_x("OFF", 'Admin Panel','naturalife'),
					'return_value' => 'true',
				]
			); 

			$this->add_control(
					'margin',
					[
						'label' => esc_html_x( 'Item Margin (px)', 'Admin Panel', 'naturalife' ),
						'description' => esc_html_x('Set a value for the margin between carousel items. Default is 15px', 'Admin Panel','naturalife' ),
						'type' => Controls_Manager::NUMBER,
						'default' => 15,
						'min' => 0,
						'max' => 200, 
					]
			);  

			$this->add_control(
					'padding',
					[
						'label' => esc_html_x( 'Stage Padding (px)', 'Admin Panel', 'naturalife' ),
						'description' => esc_html_x('Set a value for the padding of the carousel stage. This will cut first and last visible items', 'Admin Panel','naturalife' ),
						'type' => Controls_Manager::NUMBER,
						'min' => 0,
						'max' => 200, 
						'size_units' => ['px'],
					]
			);   
   
		$this->end_controls_section();

	}


	protected function render( ) {

		$settings = $this->get_settings(); 
		$settings["client_images"] = rtframework_convert_bool($settings["client_images"]);
		$settings["headings"] = rtframework_convert_bool($settings["headings"]);
		echo rt_testimonial_carousel( $settings, "" );

	}

	protected function content_template() {
	}
}


Plugin::instance()->widgets_manager->register_widget_type( new Widget_RT_Testimonial_Carousel() );
