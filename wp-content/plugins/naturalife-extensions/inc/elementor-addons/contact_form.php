<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; 

class Widget_RT_Contact_Form extends Widget_Base {

	public function get_name() {
		return 'rt-contact-form';
	}

	public function get_title() {
		return "[RT] ".esc_html_x( 'Contact Form', 'Adnin Panel', 'naturalife' );
	}

	public function get_categories() {
		return [ 'rt-elementor-addons' ];
	}

	public function get_icon() {
		return 'eicon-mail';
	}
	protected function _register_controls() {

		// Content Controls
  		$this->start_controls_section(
  			'RT_cf_content',
  			[
  				'label' => esc_html_x( 'Contact Form','Admin Panel','naturalife' )
  			]
  		); 

  		global $current_user;

		$this->add_control(
			'email',
			[
				'label' => esc_html_x("Email", 'Admin Panel','naturalife'),
				'type' => Controls_Manager::TEXT,
				'default' =>  $current_user->user_email,
				'description' => esc_html_x('The contact form will be submited to this email.', 'Admin Panel','naturalife' ),	
			]
		);  
  
		$this->add_control(
			'security',
			[
				'label' => esc_html_x("Security Question", 'Admin Panel','naturalife'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html_x("ON", 'Admin Panel','naturalife'),
				'label_off' => esc_html_x("OFF", 'Admin Panel','naturalife'),
				'return_value' => 'true', 
				'default' => 'true', 
				'description' => esc_html_x('Enable the security question to prevent spam messages.', 'Admin Panel','naturalife' ),
			]
		); 

		$this->add_control(
			'confirmation',
			[
				'label' => esc_html_x("Confirmation Checkbox", 'Admin Panel','naturalife'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html_x("ON", 'Admin Panel','naturalife'),
				'label_off' => esc_html_x("OFF", 'Admin Panel','naturalife'),
				'return_value' => 'true', 
				'default' => '', 
				'description' => esc_html_x('Enable the confirmation checkbox for GDPR.', 'Admin Panel','naturalife' ),
			]
		); 

		$this->end_controls_section();

		$this->start_controls_section(
			'rt_heading',
			[
				'label' => esc_html_x( 'Style &amp; Typography', 'Admin Panel', 'naturalife' ),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'typography',
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} *',
			]
		);		


		$this->add_control(
			'font_color_placeholder',
			[
				'label'     => esc_html_x( 'Field Placeholder Text Color', 'Admin Panel','naturalife' ),
				'type' => Controls_Manager::COLOR, 
				'selectors' => [
								'{{WRAPPER}} *::-webkit-input-placeholder' => 'color: {{VALUE}};',
								'{{WRAPPER}} *::-moz-placeholder' => 'color: {{VALUE}};',
								'{{WRAPPER}} *:-ms-input-placeholder' => 'color: {{VALUE}};', 
								'{{WRAPPER}} *::-ms-input-placeholder' => 'color: {{VALUE}};'
				],
			]
		);  

		$this->add_control(
			'font_color',
			[
				'label'     => esc_html_x( 'Field Text Color', 'Admin Panel','naturalife' ),
				'type' => Controls_Manager::COLOR, 
				'selectors' => [
					'{{WRAPPER}} input:not([type=checkbox]):not([type=radio]):not([type=submit]):not([type=button]),
					 {{WRAPPER}} textarea, 
					 {{WRAPPER}} select, 
					 {{WRAPPER}} .select2-container--default .select2-selection--single' => 'color: {{VALUE}};',
				],	
			]
		);  

		$this->add_control(
			'el_item_padding',
			[
				'label' =>  esc_html_x( 'Field Padding', 'Admin Panel','naturalife' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} input:not([type=checkbox]):not([type=radio]):not([type=submit]):not([type=button]),
					 {{WRAPPER}} textarea, 
					 {{WRAPPER}} select, 
					 {{WRAPPER}} .select2-container--default .select2-selection--single' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'el_bg_color',
			[
				'label' =>  esc_html_x( 'Form Field Background Color', 'Admin Panel','naturalife' ),
				'type' => Controls_Manager::COLOR,  
				'selectors' => [
					'{{WRAPPER}} input:not([type=checkbox]):not([type=radio]):not([type=submit]):not([type=button]),
					 {{WRAPPER}} textarea, 
					 {{WRAPPER}} select, 
					 {{WRAPPER}} .select2-container--default .select2-selection--single' => 'background-color: {{VALUE}};',
				]						
			]
		);

		$this->add_group_control(
			Group_Control_border::get_type(),
			[
				'name' => 'el_border_color', 
				'selector' => '{{WRAPPER}} input:not([type=checkbox]):not([type=radio]):not([type=submit]):not([type=button]),
					 {{WRAPPER}} textarea, 
					 {{WRAPPER}} select, 
					 {{WRAPPER}} .select2-container--default .select2-selection--single',
			]
		);		 

		$this->add_control(
			'el_border_radius',
			[
				'label' =>  esc_html_x( 'Border Radius', 'Admin Panel','naturalife' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} input:not([type=checkbox]):not([type=radio]),
					 {{WRAPPER}} textarea, 
					 {{WRAPPER}} select, 
					 {{WRAPPER}} .select2-container--default .select2-selection--single' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'el_box_shadow', 
				'selector' => '{{WRAPPER}} input:not([type=checkbox]):not([type=radio]):not([type=submit]):not([type=button]),
					 {{WRAPPER}} textarea, 
					 {{WRAPPER}} select, 
					 {{WRAPPER}} .select2-container--default .select2-selection--single',
			]
		);	

		$this->end_controls_section();


	}


	protected function render( ) {

		$settings = $this->get_settings(); 
		echo rt_shortcode_contact_form( $settings, "" );

	}

	protected function content_template() {
	}
}


Plugin::instance()->widgets_manager->register_widget_type( new Widget_RT_Contact_Form() );

