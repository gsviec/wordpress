<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; 

class Widget_RT_Progress_Bar extends Widget_Base {

	public function get_name() {
		return 'rt-progress-bar';
	}

	public function get_title() {
		return "[RT] ".esc_html_x( 'Progress Bar', 'Adnin Panel', 'naturalife' );
	}

	public function get_categories() {
		return [ 'rt-elementor-addons' ];
	}

	public function get_icon() {
		return 'eicon-skill-bar';
	}
	protected function _register_controls() {

		// Content Controls
  		$this->start_controls_section(
  			'RT_progress_bar_content',
  			[
  				'label' => esc_html_x( 'Progress Bar','Admin Panel','naturalife' )
  			]
  		); 
 

		$this->add_control(
			'heading',
			[
				'label' =>  esc_html_x( 'Heading', 'Admin Panel','naturalife' ),
				'type' => Controls_Manager::TEXT,  	
				'default' => esc_html_x( 'Heading', 'Admin Panel','naturalife' ),
			]
		);

		$this->add_control(
			'percent',
			[
				'label' => esc_html_x("Percent", 'Admin Panel','naturalife'),
				'type' => Controls_Manager::NUMBER,
				'default' => 50,
				'min' => 0,
				'max' => 100, 
				'step' => 5,  	
			]
		);  
 
		$this->add_control(
			'base_color',
			[
				'label' =>  esc_html_x( 'Base Color', 'Admin Panel','naturalife' ),
				'type' => Controls_Manager::COLOR,  		
			]
		);

		$this->add_control(
			'bar_color',
			[
				'label' =>  esc_html_x( 'Bar Color', 'Admin Panel','naturalife' ),
				'type' => Controls_Manager::COLOR,  		
			]
		);
 

		$this->end_controls_section();
	}


	protected function render( ) {

		$settings = $this->get_settings(); 
		echo rt_progress_bar_function( $settings );

	}

	protected function content_template() {
	}
}


Plugin::instance()->widgets_manager->register_widget_type( new Widget_RT_Progress_Bar() );

