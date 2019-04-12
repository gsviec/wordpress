<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; 

class Widget_RT_Quote extends Widget_Base {

	public function get_name() {
		return 'rt-quote';
	}

	public function get_title() {
		return "[RT] ".esc_html_x( 'Quote', 'Adnin Panel', 'naturalife' );
	}

	public function get_categories() {
		return [ 'rt-elementor-addons' ];
	}

	public function get_icon() {
		return 'eicon-blockquote';
	}

	protected function _register_controls() {

		// Content Controls
  		$this->start_controls_section(
  			'RT_quote_content',
  			[
  				'label' => esc_html_x( 'Quote','Admin Panel','naturalife' )
  			]
  		); 
 
 		$this->add_control(
			'content',
			[
				'label'     => esc_html_x( 'Content', 'Admin Panel','naturalife' ), 
				'type'      =>  Controls_Manager::TEXTAREA,
				'default'   => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur euismod enim a metus adipiscing aliquam. Vestibulum in vestibulum lorem.'
			]
		); 

		$this->add_control(
			'name',
			[
				'label'     => esc_html_x( 'Name', 'Admin Panel','naturalife' ), 
				'type'      =>  Controls_Manager::TEXT,
				'default'   => 'John Doe'
 			]
		); 

		$this->add_control(
			'position',
			[
				'label'     => esc_html_x( 'Position', 'Admin Panel','naturalife' ), 
				'type'      =>  Controls_Manager::TEXT,
				'default'   => 'CEO'				
			]
		); 
 
		$this->add_control(
			'link',
			[
				'label'     => esc_html_x( 'Link', 'Admin Panel','naturalife' ), 
				'type'      =>  Controls_Manager::TEXT
			]
		); 

		$this->add_control(
			'link_title',
			[
				'label'     => esc_html_x( 'Link Title', 'Admin Panel','naturalife' ), 
				'type'      =>  Controls_Manager::TEXT
			]
		); 

 		$this->add_control(
			'style',
			[
				'label'     => esc_html_x( 'Style', 'Admin Panel','naturalife' ), 
				'type'      =>  Controls_Manager::SELECT,
				'default'    =>  "center big",
				"options"    => array(
									"style-1" => esc_html_x("Style One",'Admin Panel','naturalife'),
									"style-2" => esc_html_x("Style Two",'Admin Panel','naturalife'), 
								),				
			]
		); 
 
		$this->end_controls_section();


	}


	protected function render( ) {

		$settings = $this->get_settings(); 

		echo rt_quote_function( $settings, $settings["content"] );

	}

	protected function content_template() {
	}
}


Plugin::instance()->widgets_manager->register_widget_type( new Widget_RT_Quote() );
