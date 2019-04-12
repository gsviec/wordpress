<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; 

class Widget_RT_Staff extends Widget_Base {

	public function get_name() {
		return 'rt-staff';
	}

	public function get_title() {
		return "[RT] ".esc_html_x( 'Team', 'Adnin Panel', 'naturalife' );
	}

	public function get_categories() {
		return [ 'rt-elementor-addons' ];
	}

	public function get_icon() {
		return 'eicon-person';
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
			'ids',
			[
				'label'     => esc_html_x( 'Select Members', 'Admin Panel','naturalife' ),
				'description' => esc_html_x('List posts of selected members only.', 'Admin Panel','naturalife' ),	
				'type'      =>  Controls_Manager::SELECT2,
				'default'    =>  "",
				'multiple' => true,
				"options"    => rt_get_staff_list(),					
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
			'link_position',
			[
				'label'     => esc_html_x( 'Social Media Links Location', 'Admin Panel','naturalife' ), 
				'type'      =>  Controls_Manager::SELECT,
				'default'    =>  "1",
				"options"    => array(
									"1" => esc_html_x( 'Inside the Photo', 'Admin Panel','naturalife' ), 
									"2" => esc_html_x( 'Under the Text', 'Admin Panel','naturalife' ),									
								),		 									
			]
		 
		);

 		$this->add_control(
				'image_round',
				[
					'label' => esc_html_x( 'Image Corner Radius (px)', 'Admin Panel', 'naturalife' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
					    'px' => [
					        'min' => 0,
					        'max' => 800,
					        'step' => 1,
					    ]
					],			
					'size_units' => ['px'],
					'selectors' => [
						'{{WRAPPER}} .person_image' => 'border-radius: {{SIZE}}{{UNIT}} !important',
						'{{WRAPPER}} .person_image img' => 'border-radius: {{SIZE}}{{UNIT}} !important',
					]				
				]
		);  

		$this->add_control(
			'image_effect',
			[
				'label' => esc_html_x( 'Image B/W Effect', 'Admin Panel', 'naturalife' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => '',
				'label_on' => esc_html_x("ON", 'Admin Panel','naturalife'),
				'label_off' => esc_html_x("OFF", 'Admin Panel','naturalife'),
				'return_value' => 'true',
			]
		); 

		$this->add_responsive_control(
			'content_padding',
			[
				'label' => esc_html_x( 'Content Padding', 'Admin Panel', 'naturalife' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .person_data' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


	}


	protected function render( ) {

		$settings = $this->get_settings(); 

		$settings["ids"] = is_array(  $settings["ids"] ) && ! empty( $settings["ids"] ) ? implode(",", $settings["ids"]) : ""; 

		echo rt_staff( $settings, "" );

	}

	protected function content_template() {
	}
}


Plugin::instance()->widgets_manager->register_widget_type( new Widget_RT_Staff() );
