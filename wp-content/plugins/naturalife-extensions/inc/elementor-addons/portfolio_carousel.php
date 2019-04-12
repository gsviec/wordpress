<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; 

class Widget_RT_Portfolio_Carousel extends Widget_Base {

	public function get_name() {
		return 'rt-portfolio-carousel';
	}

	public function get_title() {
		return "[RT] ".esc_html_x( 'Portfolio Carousel', 'Adnin Panel', 'naturalife' );
	}

	public function get_categories() {
		return [ 'rt-elementor-addons' ];
	}

	public function get_icon() {
		return 'eicon-posts-carousel';
	}

	protected function _register_controls() {

		// Content Controls
  		$this->start_controls_section(
  			'RT_portfolio_carousel_content',
  			[
  				'label' => esc_html_x( 'Portfolio Carousel','Admin Panel','naturalife' )
  			]
  		); 

		$this->add_control(
			'list_layout',
			[
				'label'     => esc_html_x( 'Carousel Layout', 'Admin Panel','naturalife' ),
				'description' => esc_html_x('Visible item count for each slide on desktop screens.', 'Admin Panel','naturalife' ),	
				'type'      =>  Controls_Manager::SELECT,
				'default'    =>  "1/4",
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
			'item_style',
			[
				'label'     => esc_html_x( 'Item Style', 'Admin Panel','naturalife' ),
				'description' => esc_html_x('Select a style for the portfolio items', 'Admin Panel','naturalife' ),	
				'type'      =>  Controls_Manager::SELECT,
				'default'    =>  "style-1",
				"options"    => array(
									"style-1" => esc_html_x( 'Style 1 - Info under the featured image', 'Admin Panel','naturalife' ),
									"style-2" => esc_html_x( 'Style 2 - Info embedded to the featured image ', 'Admin Panel','naturalife' ),
								 
								),				
			]
		 
		); 


 		$this->add_control(
			'hover_style',
			[
				'label'     => esc_html_x( 'Hover Style', 'Admin Panel','naturalife' ),
				'description' => esc_html_x('Select an overlay text style.', 'Admin Panel','naturalife' ),	
				'type'      =>  Controls_Manager::SELECT,
				'default'    =>  "hover-1",
				"options"    => array(
									"hover-1" => esc_html_x( 'Style 1', 'Admin Panel','naturalife' ),
									"hover-2" => esc_html_x( 'Style 2', 'Admin Panel','naturalife' ),
								 
								),		

				'condition' => [
									'item_style' => [ "style-2"],
								],										
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
								)								
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
				"options"    => rt_get_portfolio_categories(),					
			]
		 
		); 


		$this->add_control(
			'display_categories',
			[
				'label' => esc_html_x("Display Categories", 'Admin Panel','naturalife'),
				'type' => Controls_Manager::SWITCHER,
				'default' => '',
				'label_on' => esc_html_x("ON", 'Admin Panel','naturalife'),
				'label_off' => esc_html_x("OFF", 'Admin Panel','naturalife'),
				'return_value' => 'true',
			]
		); 

		$this->add_control(
			'display_excerpts',
			[
				'label' => esc_html_x("Display Excerpts", 'Admin Panel','naturalife'),
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
					'default' => 'true',
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
					'default' => '',
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
					]
			);   
   
		$this->end_controls_section();


		/* Featured Images */
  		$this->start_controls_section(
  			'RT_Featured_Images',
  			[
  				'label' => esc_html_x( 'Featured Images','Admin Panel','naturalife' )
  			]
  		); 


			$this->add_control(
				'featured_image_resize',
				[
					'label' => esc_html_x("Resize Featured Images", 'Admin Panel','naturalife'),
					'type' => Controls_Manager::SWITCHER,
					'desctiption' => esc_html_x( 'Enable the "Image Resize" to resize or crop the featured images automatically. These settings will be overwrite the global settings. Please note, since the theme is reponsive the images cannot be wider than the column they are in. Leave values "0" to use theme defaults.', 'Admin Panel', 'naturalife'),
					'label_on' => esc_html_x("ON", 'Admin Panel','naturalife'),
					'label_off' => esc_html_x("OFF", 'Admin Panel','naturalife'),
					'return_value' => 'true',
				]
			); 

			$this->add_control(
				'featured_image_max_width',
				[
					'label'   => esc_html_x("Image Width", 'Admin Panel','naturalife'),
					'type'    =>  Controls_Manager::NUMBER,
					'condition' => [
										'featured_image_resize' => [ "true" ],
									],
					'default' => 1000,
					'min'     => 10,
					'max'     => 2000, 	
					'description' => esc_html_x('Set a width value for the carousel images. Note: Remember that the images width will be resoponsive. Leave blank for auto width.', 'Admin Panel','naturalife' ),					

				]
			); 

	 		$this->add_control(
				'featured_image_max_height',
				[
					'label'   => esc_html_x("Image Height", 'Admin Panel','naturalife'),
					'type'    =>  Controls_Manager::NUMBER,
					'condition' => [
										'featured_image_resize' => [ "true" ],
									],
					'default' => 1000,
					'min'     => 10,
					'max'     => 2000, 		
					'description' => esc_html_x('Set a height value for the images. Remember that the image heights will be resoponsive. Leave blank for auto height.', 'Admin Panel','naturalife' ),

				]
			); 

			$this->add_control(
				'featured_image_crop',
				[
					'label' => esc_html_x("Crop Images", 'Admin Panel','naturalife'),
					'type' => Controls_Manager::SWITCHER,
					'default' => '',
					'label_on' => esc_html_x("ON", 'Admin Panel','naturalife'),
					'label_off' => esc_html_x("OFF", 'Admin Panel','naturalife'),
					'return_value' => 'true',
					'condition' => [
										'featured_image_resize' => [ "true" ],
									],				
				]
			); 

 	
		$this->end_controls_section();		
	}


	protected function render( ) {

		$settings = $this->get_settings(); 
 
 		if( ! $settings["featured_image_resize"] ){
			$settings["featured_image_max_width"] = "";
			$settings["featured_image_max_height"] = "";
			$settings["featured_image_crop"] = ""; 			
 		}

		echo rt_portfolio_carousel( $settings, "" );

	}

	protected function content_template() {
	}
}


Plugin::instance()->widgets_manager->register_widget_type( new Widget_RT_Portfolio_Carousel() );
