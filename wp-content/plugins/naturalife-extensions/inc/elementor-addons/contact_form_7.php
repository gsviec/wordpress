<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; 

class Widget_RT_Contact_Form_7 extends Widget_Base {

	public function get_name() {
		return 'rt-contact-form-7';
	}

	public function get_title() {
		return "[RT] ".esc_html_x( 'Contact Form 7', 'Adnin Panel', 'naturalife' );
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
  				'label' => esc_html_x( 'Contact Form 7','Admin Panel','naturalife' )
  			]
  		); 

  		//get forms
		$forms = query_posts('posts_per_page=-1&post_type=wpcf7_contact_form&orderby=title&order=ASC');
		$form_array = array();

		if(is_array($forms)){
			foreach ($forms as $form ) {
				$form_array[$form->post_title] = $form->post_title;
			}
		}

		wp_reset_query();
 
  		$first_one = ! empty( $forms ) && isset( $forms[0]->post_title ) ? $forms[0]->post_title : "";


		$this->add_control(
			'form',
			[
				'label' => esc_html_x("Form", 'Admin Panel','naturalife'),
				'type' => Controls_Manager::SELECT,
				'options' => $form_array, 
				'default' => $first_one
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
					], 
				],
				'prefix_class' => 'elementor%s-align-'
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


		echo do_shortcode(sprintf('[contact-form-7 title="%s"]', $settings["form"]));

	}

	protected function content_template() {
	}
}


Plugin::instance()->widgets_manager->register_widget_type( new Widget_RT_Contact_Form_7() );

