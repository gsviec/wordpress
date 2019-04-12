<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; 

class Widget_RT_Breadcrumb extends Widget_Base {

	public function get_name() {
		return 'rt-breadcrumb';
	}

	public function get_title() {
		return "[RT] ".esc_html_x( 'Breadcrumb Menu', 'Adnin Panel', 'naturalife' );
	}

	public function get_categories() {
		return [ 'rt-elementor-addons' ];
	}

	public function get_icon() {
		return 'eicon-navigation-horizontal';
	}
	protected function _register_controls() {
 
		$this->start_controls_section(
			'rt_breadcrumb_typography',
			[
				'label' => esc_html_x( 'Style &amp; Typography', 'Admin Panel', 'naturalife' ),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label' => esc_html_x( 'Alignment', 'Admin Panel', 'naturalife' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html_x( 'Left', 'Admin Panel', 'naturalife' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => esc_html_x( 'Center', 'Admin Panel', 'naturalife' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => esc_html_x( 'Right', 'Admin Panel', 'naturalife' ),
						'icon' => 'fa fa-align-right',
					]
				],
				'selectors' => [
					'{{WRAPPER}} .breadcrumb' => 'text-align: {{VALUE}};',
				],						
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'typography',
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .breadcrumb',
			]
		);		
 
 		$this->add_control(
			'title_color',
			[
				'label' =>  esc_html_x( 'Custom Color', 'Admin Panel','naturalife' ),
				'type' => Controls_Manager::COLOR, 
				'selectors' => [
					'{{WRAPPER}} .breadcrumb' => 'color: {{VALUE}};',
					'{{WRAPPER}} .breadcrumb a' => 'color: {{VALUE}};',
					'{{WRAPPER}} .breadcrumb span:before' => 'color: {{VALUE}};',
					'{{WRAPPER}} .breadcrumb a:before' => 'color: {{VALUE}};'
				], 			
			]
		);



		$this->end_controls_section();
	}


	protected function render( ) {
		echo rtframework_breadcrumb( array("wrap_before" => '<div class="breadcrumb custom-breadcrumb">', "wrap_after" => '</div>') );
	}

	protected function content_template() {
	}
}


Plugin::instance()->widgets_manager->register_widget_type( new Widget_RT_Breadcrumb() );