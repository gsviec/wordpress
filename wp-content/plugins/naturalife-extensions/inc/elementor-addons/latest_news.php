<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; 

class Widget_RT_latest_news extends Widget_Base {

	public function get_name() {
		return 'rt-latest_news';
	}

	public function get_title() {
		return "[RT] ".esc_html_x( 'Latest News', 'Adnin Panel', 'naturalife' );
	}

	public function get_categories() {
		return [ 'rt-elementor-addons' ];
	}

	public function get_icon() {
		return 'eicon-posts-ticker';
	}

	protected function _register_controls() {

		// Content Controls
		$this->start_controls_section(
			'RT_latest_news',
			[
				'label' => esc_html_x( 'Latest News','Admin Panel','naturalife' )
			]
		); 

		$this->add_control(
			'list_layout',
			[
				'label'     => esc_html_x( 'Layout', 'Admin Panel','naturalife' ),
				'description' => esc_html_x('Column layout for the list"', 'Admin Panel','naturalife' ),	
				'type'      =>  Controls_Manager::SELECT,
				'default'    =>  "1/4",
				"options"    => array(
									"1/1" => "1",
									"1/2" => "2",													
									"1/3" => "3",													
									"1/4" => "4",		 											
									"1/6" => "6",
								),				
			]
		 
		);
 
 		$this->add_control(
			'list_layout_tablet',
			[
				'label'     => esc_html_x( 'Layout (Tablet)', 'Admin Panel','naturalife' ), 
				'type'      =>  Controls_Manager::SELECT,
				'default'    =>  "1/4",
				"options"    => array(
									"1/1" => "1",
									"1/2" => "2",													
									"1/3" => "3",													
									"1/4" => "4",		 											
									"1/6" => "6",
								),				
			]
		 
		);

   		$this->add_control(
			'heading_size',
			[
				'label'     => esc_html_x( 'Heading Size', 'Admin Panel','naturalife' ), 
				'type'      =>  Controls_Manager::SELECT,
				'default'    =>  "h5",
				"options"    => array(
									"h1" => "H1", 
									"h2" => "H2", 
									"h3" => "H3", 
									"h4" => "H4", 
									"h5" => "H5", 
									"h6" => "H6", 
								)							
			]
		 
		); 

 		$this->add_control(
			'style',
			[
				'label'     => esc_html_x( 'Style', 'Admin Panel','naturalife' ), 
				'type'      =>  Controls_Manager::SELECT,
				'default'    =>  "style-1",
				"options"    => array(
									"style-1" => esc_html_x( 'Style 1', 'Admin Panel','naturalife' ),
									"style-2" => esc_html_x( 'Style 2', 'Admin Panel','naturalife' ),								 
								),								
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
				'excerpt_length',
				[
					'label'   => esc_html_x( 'Excerpt Length', 'Admin Panel', 'naturalife' ),
					"description" => esc_html_x("Customize the excerpt length. Leave blank for the default value.",'Admin Panel','naturalife'),
					'type'    => Controls_Manager::NUMBER,
					'default' =>  "100"			
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
				"options"    => rt_get_categories(),					
			]
		 
		); 

		$this->add_control(
			'thumbnails',
			[
				'label' => esc_html_x("Display Post Thumbnails", 'Admin Panel','naturalife'),
				'type' => Controls_Manager::SWITCHER,
				'default' => "true",
				'label_on' => esc_html_x("ON", 'Admin Panel','naturalife'),
				'label_off' => esc_html_x("OFF", 'Admin Panel','naturalife'),
				'return_value' => 'true',
			]
		); 

		$this->add_control(
			'show_dates',
			[
				'label' => esc_html_x("Display Post Dates", 'Admin Panel','naturalife'),
				'type' => Controls_Manager::SWITCHER,
				'default' => "true",
				'label_on' => esc_html_x("ON", 'Admin Panel','naturalife'),
				'label_off' => esc_html_x("OFF", 'Admin Panel','naturalife'),
				'return_value' => 'true',
			]
		); 


		$this->add_control(
			'show_categories',
			[
				'label' => esc_html_x("Display Post Categories", 'Admin Panel','naturalife'),
				'type' => Controls_Manager::SWITCHER,
				'default' => '',
				'label_on' => esc_html_x("ON", 'Admin Panel','naturalife'),
				'label_off' => esc_html_x("OFF", 'Admin Panel','naturalife'),
				'return_value' => 'true',
			]
		); 
  
  		$this->add_control(
			'show_button',
			[
				'label' => esc_html_x("Display Read More Button", 'Admin Panel','naturalife'),
				'type' => Controls_Manager::SWITCHER,
				'default' => '',
				'label_on' => esc_html_x("ON", 'Admin Panel','naturalife'),
				'label_off' => esc_html_x("OFF", 'Admin Panel','naturalife'),
				'return_value' => 'true',
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
				'image_width',
				[
					'label'   => esc_html_x("Featured Image Max Width", 'Admin Panel','naturalife'),
					'type'    =>  Controls_Manager::NUMBER,
					'default' => 100,
					'min'     => 10,
					'max'     => 1000, 	
					'description' => esc_html_x('Set a width value for the carousel images. Note: Remember that the images width will be resoponsive. Leave blank for auto width.', 'Admin Panel','naturalife' ),					

				]
			); 

	 		$this->add_control(
				'image_height',
				[
					'label'   => esc_html_x("Featured Image Max Height", 'Admin Panel','naturalife'),
					'type'    =>  Controls_Manager::NUMBER,
					'default' => 100,
					'min'     => 10,
					'max'     => 1000, 		 
				]
			); 
 	
		$this->end_controls_section();		
	}


	protected function render( ) {

		$settings = $this->get_settings(); 


		$settings["show_categories"] = rtframework_convert_bool( $settings["show_categories"] );
		$settings["show_dates"] = rtframework_convert_bool( $settings["show_dates"] );
		$settings["show_button"] = rtframework_convert_bool( $settings["show_button"] );
		$settings["thumbnails"] = rtframework_convert_bool( $settings["thumbnails"] ); 

		echo rt_latest_news( $settings );

	}

	protected function content_template() {
	}
}


Plugin::instance()->widgets_manager->register_widget_type( new Widget_RT_latest_news() );
