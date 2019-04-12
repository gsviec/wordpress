<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; 

class Widget_RT_RevSlider extends Widget_Base {

	public function get_name() {
		return 'rt-rev-slider';
	}

	public function get_title() {
		return "[RT] ".esc_html_x( 'Revolution Slider', 'Adnin Panel', 'naturalife' );
	}

	public function get_categories() {
		return [ 'rt-elementor-addons' ];
	}

	public function get_icon() {
		return 'eicon-slider-full-screen';
	}
	protected function _register_controls() {

		// Content Controls
  		$this->start_controls_section(
  			'RT_cf_content',
  			[
  				'label' => esc_html_x( 'Revolution Slider','Admin Panel','naturalife' )
  			]
  		); 

		//get sliders
		$slider = new \RevSlider();
		$alias_array = $slider->getAllSliderAliases();
		$title_array = $slider->getArrSlidersShort();
		$sliderArray = array();
		$default = "";
		
		$r_sldier_counter = 0;
		if(is_array($title_array)){
			foreach ($title_array as $key => $slider_title ) {
				$sliderArray[$alias_array[$r_sldier_counter]] = $slider_title;
				$default = $r_sldier_counter == 0 ? $alias_array[$r_sldier_counter]: $default;
				$r_sldier_counter++;
			}
		}

		$this->add_control(
			'slider',
			[
				'label' => esc_html_x("Slider", 'Admin Panel','naturalife'),
				'type' => Controls_Manager::SELECT,
				'options' => $sliderArray, 
				'default' => $default
			]
		);  
  
		
		$this->end_controls_section();
	}

	protected function render( ) {
		$settings = $this->get_settings(); 
		\RevSliderOutput::putSlider($settings["slider"]);
	}

	protected function content_template() {
	}

}


Plugin::instance()->widgets_manager->register_widget_type( new Widget_RT_RevSlider() );

