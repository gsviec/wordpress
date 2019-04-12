<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; 

class Widget_RT_Button extends Widget_Base {

	public function get_name() {
		return 'rt-button';
	}

	public function get_title() {
		return "[RT] ".esc_html_x( 'Button', 'Adnin Panel', 'naturalife' );
	}

	public function get_categories() {
		return [ 'rt-elementor-addons' ];
	}

	public function get_icon() {
		return 'eicon-button';
	}
	protected function _register_controls() {

		// Content Controls
  		$this->start_controls_section(
  			'RT_button_content',
  			[
  				'label' => esc_html_x( 'Button','Admin Panel','naturalife' )
  			]
  		); 
 
		$this->add_control(
			'button_text',
			[
				'label' => esc_html_x("Button Text", 'Admin Panel','naturalife'),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html_x("Button Text", 'Admin Panel','naturalife'),			
			]
		);   

		$this->add_control(
			'button_arrow',
			[
				'label' => esc_html_x("Button Arrow?", 'Admin Panel','naturalife'),
				'type' => Controls_Manager::SWITCHER,
				'default' => '',
				'label_on' => esc_html_x("ON", 'Admin Panel','naturalife'),
				'label_off' => esc_html_x("OFF", 'Admin Panel','naturalife'),
				'return_value' => 'true',
			]
		); 

		$this->add_control(
			'button_rounded',
			[
				'label' => esc_html_x("Rounded Button?", 'Admin Panel','naturalife'),
				'type' => Controls_Manager::SWITCHER,
				'default' => '',
				'label_on' => esc_html_x("ON", 'Admin Panel','naturalife'),
				'label_off' => esc_html_x("OFF", 'Admin Panel','naturalife'),
				'return_value' => 'true',
			]
		); 
 
 		$this->add_control(
			'link',
			[
				'label' => esc_html_x("Link", 'Admin Panel','naturalife'),
				'type' => Controls_Manager::URL,
				'placeholder' => 'http://your-link.com',
				'default' => [
					'url' => '#',
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
 
 		$this->add_control(
			'lightbox',
			[
				'label' => esc_html_x("Open in Ligtbox", 'Admin Panel','naturalife'),
				'type' => Controls_Manager::SWITCHER,
				'default' => '',
				'label_on' => esc_html_x("ON", 'Admin Panel','naturalife'),
				'label_off' => esc_html_x("OFF", 'Admin Panel','naturalife'),
				'return_value' => 'true',
				'description' => esc_html_x('Works with only image, YouTube and Vimeo video links.', 'Admin Panel','naturalife' ),
			]
		); 
		
 
		$this->add_control(
			'button_icon',
			[
				'label' => esc_html_x("Icon", 'Admin Panel','naturalife'),
				'type' => Controls_Manager::ICON,
				'return_value' => 'true',			
				'description' => esc_html_x('Click inside the field to select an icon or type the icon name', 'Admin Panel','naturalife' ),					
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
						'{{WRAPPER}} .button-icon:before' => 'font-size: {{SIZE}}{{UNIT}}',
					],
				]
		);  


		$this->end_controls_section();


		$this->start_controls_section(
			'rt_button_typography',
			[
				'label' => esc_html_x( 'Style &amp; Typography', 'Admin Panel', 'naturalife' ),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_control(
			'button_style',
			[
				'label'     => esc_html_x( 'Button Style', 'Admin Panel','naturalife' ),
				'type'      =>  Controls_Manager::SELECT,
				'default'    => 'style-1',
				"options"    => array(
									"style-1" => esc_html_x("Style 1", 'Admin Panel','naturalife'),
									"style-2" => esc_html_x("Style 2", 'Admin Panel','naturalife'),
									"style-3" => esc_html_x("Style 3", 'Admin Panel','naturalife'),
									"black"   => esc_html_x("Black", 'Admin Panel','naturalife'),
									"white"   => esc_html_x("White", 'Admin Panel','naturalife'),
									"text"    => esc_html_x("Flat Text", 'Admin Panel','naturalife'), 
									"custom"  => esc_html_x("Custom", 'Admin Panel','naturalife'), 
								),			
			]
		);  

		$this->add_control(
			'button_size',
			[
				'label'     => esc_html_x( 'Button Size', 'Admin Panel','naturalife' ),
				'type'      =>  Controls_Manager::SELECT,
				'default'    => 'small',
				"options"    => array(
									"small" => esc_html_x("Small", 'Admin Panel','naturalife'),
									"medium" => esc_html_x("Medium", 'Admin Panel','naturalife'),
									"big" => esc_html_x("Big", 'Admin Panel','naturalife'),
									"hero" => esc_html_x("Hero", 'Admin Panel','naturalife'), 
								),			
			]
		);  

		$this->add_control(
			'e_bg_color',
			[
				'label' =>  esc_html_x( 'Background Color', 'Admin Panel','naturalife' ),
				'type' => Controls_Manager::COLOR, 
				'selectors' => [
					'{{WRAPPER}} .button_' => 'background-color: {{VALUE}} !important;',
				],
				'condition' => [
									'button_style' => [ "custom" ],
								],					
			]
		);

		$this->add_control(
			'e_text_color',
			[
				'label' =>  esc_html_x( 'Text Color', 'Admin Panel','naturalife' ),
				'type' => Controls_Manager::COLOR, 
				'selectors' => [
					'{{WRAPPER}} .button_ > span' => 'color: {{VALUE}};',
				],
				'condition' => [
									'button_style' => [ "custom" ],
								],					
			]
		);

		$this->add_control(
			'e_border_color',
			[
				'label' =>  esc_html_x( 'Border Color', 'Admin Panel','naturalife' ),
				'type' => Controls_Manager::COLOR, 
				'selectors' => [
					'{{WRAPPER}} .button_' => 'border-color: {{VALUE}};',
				],
				'condition' => [
									'button_style' => [ "custom" ],
								],					
			]
		);

		$this->add_control(
				'e_border_width',
				[
					'label' => esc_html_x( 'Border Width', 'Admin Panel', 'naturalife' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
					    'px' => [
					        'min' => 1,
					        'max' => 30,
					        'step' => 1,
					    ]
					],			
					'size_units' => [ 'px'],
					'selectors' => [
						'{{WRAPPER}} .button_' => 'border-width: {{SIZE}}{{UNIT}}',
					],
					'condition' => [
										'button_style' => [ "custom" ],
									],							
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

		$this->add_responsive_control(
			'rt_button_padding',
			[
				'label' => esc_html_x( 'Button Padding', 'Admin Panel', 'naturalife' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .button_ > span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'rt_button_margin',
			[
				'label' => esc_html_x( 'Button Margin', 'Admin Panel', 'naturalife' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .button_, {{WRAPPER}} .read_more' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
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
				'selector' => '{{WRAPPER}} .button_, {{WRAPPER}} .read_more',
			]
		);		


		$this->end_controls_section();  
	}


	protected function render( ) {

		$settings = $this->get_settings(); 

		if ( ! empty( $settings['link']['url'] ) ) {
			$settings["button_link"] = $settings['link']['url'];
			$settings["link_open"] = $settings['link']['is_external'] ? '_blank' : '_self';
			$settings["nofollow"] = $settings['link']['nofollow'] ? 'true' : '';
		}		

		echo rt_shortcode_button( $settings, $settings["button_text"] );

	}

	protected function content_template() {
	}
}


Plugin::instance()->widgets_manager->register_widget_type( new Widget_RT_Button() );
