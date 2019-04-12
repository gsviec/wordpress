<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; 

class Widget_RT_Heading extends Widget_Base {

	public function get_name() {
		return 'rt-heading';
	}

	public function get_title() {
		return "[RT] ".esc_html_x( 'Heading', 'Adnin Panel', 'naturalife' );
	}

	public function get_categories() {
		return [ 'rt-elementor-addons' ];
	}

	public function get_icon() {
		return 'eicon-type-tool';
	}
	protected function _register_controls() {

		// Content Controls
  		$this->start_controls_section(
  			'RT_heading_content',
  			[
  				'label' => esc_html_x( 'Heading','Admin Panel','naturalife' )
  			]
  		); 

		$this->add_control(
			'heading_text',
			[
				'label' => esc_html_x("Heading Text", 'Admin Panel','naturalife'),
				'type' => Controls_Manager::TEXTAREA,
				'default' => esc_html_x("Heading Text", 'Admin Panel','naturalife'),			
			]
		);  

		$this->add_control(
			'punchline',
			[
				'label' => esc_html_x("Punchline", 'Admin Panel','naturalife'),
				'type' => Controls_Manager::TEXT,
				'description' => esc_html_x("Optional puchline text", 'Admin Panel','naturalife'),		
				'condition' => [
									'style' => [ "","style-1","style-2","style-4","style-5" ],
								],						
			]
		);  


		$this->add_control(
			'style',
			[
				'label'     => esc_html_x( 'Style', 'Admin Panel','naturalife' ),
				'type'      =>  Controls_Manager::SELECT,
				"options"    => array(
									"" => esc_html_x("No-Style", 'Admin Panel', "naturalife") ,
									"style-1" => esc_html_x("Style One - ( w/ a short thin line before )", 'Admin Panel', "naturalife") ,
									"style-2" => esc_html_x("Style Two - ( w/ a short thin line after )", 'Admin Panel', "naturalife") ,
									"style-3" => esc_html_x("Style Three - ( w/ lines before and after )", 'Admin Panel', "naturalife") ,
									"style-4" => esc_html_x("Style Four - ( w/ a thin line below - centered ) ", 'Admin Panel', "naturalife") ,
									"style-5" => esc_html_x("Style Five - ( w/ a thin line below - left aligned ) ", 'Admin Panel', "naturalife") ,
									"style-6" => esc_html_x("Style Six - ( w/ a long line after - left aligned )  ", 'Admin Panel', "naturalife") ,
								),			
			]
		);  


		$this->add_control(
			'size',
			[
				'label'     => esc_html_x( 'Tag', 'Admin Panel','naturalife' ),
				'type'      =>  Controls_Manager::SELECT,
				'default'   => "h4",
				"options"   => array(
										"H1" => "h1",
										"H2" => "h2",
										"H3" => "h3",
										"H4" => "h4",
										"H5" => "h5",
										"H6" => "h6",
										"p" => "p",
										"span" => "span"
								),			
				'description' => esc_html_x( 'Select the tag of the heading', 'Admin Panel','naturalife' ),
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
				'icon_size_elementor',
				[
					'label' => esc_html_x( 'Icon Size (px)', 'Admin Panel', 'naturalife' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
					    'px' => [
					        'min' => 0,
					        'max' => 300,
					        'step' => 1,
					    ]
					],			
					'size_units' => [ 'px'],
					'selectors' => [
						'{{WRAPPER}} .heading_icon:before' => 'font-size: {{SIZE}}{{UNIT}}',
					],
				]
		);  


 		$this->add_control(
			'heading_link',
			[
				'label' => esc_html_x("Link", 'Admin Panel','naturalife'),
				'type' => Controls_Manager::URL,
				'placeholder' => 'http://your-link.com',
				'default' => [
					'url' => '',
				],
			]
		);

 		$this->add_control(
			'href_title',
			[
				'label' => esc_html_x("Link Title", 'Admin Panel','naturalife'),
				'type' => Controls_Manager::TEXT
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'rt_heading_typography',
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
					],
					'justify' => [
						'title' => esc_html_x( 'Justified', 'Admin Panel', 'naturalife' ),
						'icon' => 'fa fa-align-justify',
					],
				]
			]
		);

		$this->add_responsive_control(
			'rt_heading_padding',
			[
				'label' => esc_html_x( 'Heading Padding', 'Admin Panel', 'naturalife' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .rt-heading' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'rt_heading_margin',
			[
				'label' => esc_html_x( 'Heading Margin', 'Admin Panel', 'naturalife' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				
				'selectors' => [
					'{{WRAPPER}} .rt-heading' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'font_color_type',
			[
				'label'     => esc_html_x( 'Font Color', 'Admin Panel','naturalife' ),
				'type'      =>  Controls_Manager::SELECT,
				"options"    => array(
									"" => esc_html_x("Default Heading Color", 'Admin Panel','naturalife'),
									"custom" => esc_html_x("Custom Color", 'Admin Panel','naturalife'),
									"primary" => esc_html_x("Primary Color", 'Admin Panel','naturalife'),
									"secondary" => esc_html_x("Secondary Color", 'Admin Panel','naturalife'),
								),			
			]
		);  

		$this->add_control(
			'title_color',
			[
				'label' =>  esc_html_x( 'Custom Color', 'Admin Panel','naturalife' ),
				'type' => Controls_Manager::COLOR, 
				'selectors' => [
					'{{WRAPPER}} .rt-heading' => 'color: {{VALUE}};',
				],
				'condition' => [
									'font_color_type' => [ "custom" ],
								],					
			]
		);

		$this->add_control(
			'el_bg_color',
			[
				'label' =>  esc_html_x( 'Heading Background Color', 'Admin Panel','naturalife' ),
				'type' => Controls_Manager::COLOR,  
				'selectors' => [
					'{{WRAPPER}} .rt-heading' => 'background-color: {{VALUE}};',
				]						
			]
		);


		$this->add_control(
			'font',
			[
				'label'     => esc_html_x( 'Global Font Family', 'Admin Panel','naturalife' ),
				'type'      =>  Controls_Manager::SELECT,
				"options"    => array(
										""               => esc_html_x("Default", 'Admin Panel','naturalife'),                                          
										"heading-font"   => esc_html_x("Heading Font", 'Admin Panel','naturalife'),        
										"body-font"      => esc_html_x("Body Font", 'Admin Panel','naturalife'),                    
										"secondary-font" => esc_html_x("Secondary Font", 'Admin Panel','naturalife'),
										"menu-font"      => esc_html_x("Menu Font", 'Admin Panel','naturalife'),                      
								),			
			]
		);  

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'typography',
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rt-heading',
			]
		);		

		$this->add_responsive_control(
			'writing_mode',
			[
				'label'     => esc_html_x( 'Writing Mode', 'Admin Panel','naturalife' ),
				'type'      =>  Controls_Manager::SELECT,
				"options"    => array(
										""            => esc_html_x("Default", 'Admin Panel','naturalife'),      
										"horizontal-tb" => esc_html_x("Horizontal Top to Bottom", 'Admin Panel','naturalife'),                                        
										"vertical-lr" => esc_html_x("Vertical Left to Right", 'Admin Panel','naturalife'),                                        
										"vertical-rl" => esc_html_x("Vertical Right to Left", 'Admin Panel','naturalife'),        
								),			
				'selectors' => [
					'{{WRAPPER}} .rt-heading' => 'writing-mode: {{VALUE}};white-space:nowrap;',
				]					
			]
		);  

		$this->add_responsive_control(
			'writing_mode_reverse',
			[
				'label' => esc_html_x("Reversed?", 'Admin Panel','naturalife'),
				'type' => Controls_Manager::SELECT,
				'default' => "",
				"options"    => array(
										"0" => esc_html_x("Disabled", 'Admin Panel','naturalife'),
										"-180"  => esc_html_x("Enabled", 'Admin Panel','naturalife'),      										
								),						
				'condition' => [
									'writing_mode' => [ "horizontal-tb", "vertical-lr", "vertical-rl" ],
								],				
				'return_value' => 'true',
				'selectors' => [
					'{{WRAPPER}} .rt-heading' => 'transform: rotate({{VALUE}}deg);',
				]					
			]
		); 




		$this->end_controls_section();
	}


	protected function render( ) {

		$settings = $this->get_settings(); 
		
		$settings["tablet_align"] = $settings["align_tablet"];
		$settings["mobile_align"] = $settings["align_mobile"]; 

		$settings["class"][] = ! empty( $settings["writing_mode"] ) ? "ie-".str_replace("rl", "lr", $settings["writing_mode"]) : "";
		$settings["class"][] = ! empty( $settings["writing_mode_tablet"] ) ? "ie-".str_replace("rl", "lr", $settings["writing_mode_tablet"])."-tablet" : "";
		$settings["class"][] = ! empty( $settings["writing_mode_mobile"] ) ? "ie-".str_replace("rl", "lr", $settings["writing_mode_mobile"])."-mobile" : "";

		$settings["class"] = implode(" ", $settings["class"]);
 
		if ( ! empty( $settings['heading_link']['url'] ) ) {
			$settings["link"] = $settings['heading_link']['url'];
			$settings["link_open"] = $settings['heading_link']['is_external'] ? '_blank' : '_self';
			$settings["nofollow"] = $settings['heading_link']['nofollow'] ? 'true' : '';
		}		

		echo rt_heading_function( $settings, $settings["heading_text"] );

	}

	protected function content_template() {
	}
}


Plugin::instance()->widgets_manager->register_widget_type( new Widget_RT_Heading() );