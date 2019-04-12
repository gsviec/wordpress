<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; 

class Widget_RT_Testimonial extends Widget_Base {

	public function get_name() {
		return 'rt-testimonial';
	}

	public function get_title() {
		return "[RT] ".esc_html_x( 'Testimonials', 'Adnin Panel', 'naturalife' );
	}

	public function get_categories() {
		return [ 'rt-elementor-addons' ];
	}

	public function get_icon() {
		return 'eicon-testimonial';
	}

	protected function _register_controls() {

		// Content Controls
  		$this->start_controls_section(
  			'RT_pportfolio_content',
  			[
  				'label' => esc_html_x( 'Testimonials','Admin Panel','naturalife' )
  			]
  		); 


		$this->add_control(
			'list_layout',
			[
				'label'     => esc_html_x( 'Layout', 'Admin Panel','naturalife' ),
				'description' => esc_html_x('Column layout for the list"', 'Admin Panel','naturalife' ),	
				'type'      =>  Controls_Manager::SELECT,
				'default'    =>  "1/2",
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
				'item_per_page',
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

 		$this->add_control(
			'pagination',
			[
				'label' => esc_html_x("Pagination", 'Admin Panel','naturalife'),
				"description" => esc_html_x("Splits the list into pages",'Admin Panel','naturalife'),
				'type' => Controls_Manager::SWITCHER,
				'default' => '',
				'label_on' => esc_html_x("ON", 'Admin Panel','naturalife'),
				'label_off' => esc_html_x("OFF", 'Admin Panel','naturalife'),
				'return_value' => 'true',
			]
		); 

		$this->end_controls_section();


	}


	protected function render( ) {

		$settings = $this->get_settings(); 

		$settings["headings"] = rtframework_convert_bool( $settings["headings"] );
 		$settings["client_images"] = rtframework_convert_bool( $settings["client_images"] ); 
		$settings["pagination"] = rtframework_convert_bool( $settings["pagination"] ); 

		echo rt_testimonials( $settings, "" );

	}

	protected function content_template() {
	}
}


Plugin::instance()->widgets_manager->register_widget_type( new Widget_RT_Testimonial() );
