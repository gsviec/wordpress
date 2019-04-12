<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; 

class Widget_RT_PieCart extends Widget_Base {

	public function get_name() {
		return 'rt-piecart';
	}

	public function get_title() {
		return "[RT] ".esc_html_x( 'Pie Chart', 'Adnin Panel', 'naturalife' );
	}

	public function get_categories() {
		return [ 'rt-elementor-addons' ];
	}

	public function get_icon() {
		return 'eicon-counter-circle';
	}
	protected function _register_controls() {

		// Content Controls
  		$this->start_controls_section(
  			'RT_pie_content',
  			[
  				'label' => esc_html_x( 'Pie Chart','Admin Panel','naturalife' )
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
			'icon_name',
			[
				'label' => esc_html_x("Icon", 'Admin Panel','naturalife'),
				'type' => Controls_Manager::ICON,
				'return_value' => 'true',			
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


		$this->add_control(
			'size',
			[
				'label' =>  esc_html_x( 'Bar Size', 'Admin Panel','naturalife' ),
				'description' => esc_html_x( 'Leave blank for the default value. Default value is 180px', 'Admin Panel','naturalife' ),
				'type' => Controls_Manager::NUMBER, 
			]
		);

		$this->add_control(
			'linewidth',
			[
				'label' => esc_html_x("Line Width", 'Admin Panel','naturalife'),
				'type' => Controls_Manager::NUMBER, 
			]
		);  

		$this->add_control(
			'font_size',
			[
				'label' => esc_html_x("Font Size", 'Admin Panel','naturalife'),
				'type' => Controls_Manager::NUMBER,
				'default' => 50,
			]
		);  
 
		$this->add_control(
			'font_color',
			[
				'label' =>  esc_html_x( 'Font Color', 'Admin Panel','naturalife' ),
				'type' => Controls_Manager::COLOR,  		
			]
		);

		$this->end_controls_section();
	}


	protected function render( ) {

		$settings = $this->get_settings(); 
		echo rt_pie_chart_function( $settings );

	}

	protected function content_template() {
	}
}


Plugin::instance()->widgets_manager->register_widget_type( new Widget_RT_PieCart() );

