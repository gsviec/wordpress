<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; 

class Widget_RT_Image_box extends Widget_Base {

	public function get_name() {
		return 'rt-image-box';
	}

	public function get_title() {
		return "[RT] ".esc_html_x( 'Image Box', 'Adnin Panel', 'naturalife' );
	}

	public function get_categories() {
		return [ 'rt-elementor-addons' ];
	}

	public function get_icon() {
		return 'eicon-image-box';
	}
	protected function _register_controls() {

		// Content Controls
		$this->start_controls_section(
			'heading',
			[
				'label' => esc_html_x( 'Content','Admin Panel','naturalife' )
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
						'label'     => esc_html_x( 'Heading Style', 'Admin Panel','naturalife' ),
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
						'label'     => esc_html_x( 'Heading Tag', 'Admin Panel','naturalife' ),
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


				$this->add_responsive_control(
					'heading_padding',
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
					'heading_margin',
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
					'text',
					[
						'label' => esc_html_x("Text", 'Admin Panel','naturalife'),
						'type' => Controls_Manager::WYSIWYG,
						'separator' => "before"		
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
						],
						'selectors' => [
							'{{WRAPPER}} .rt-image-box-content' => 'text-align: {{VALUE}};',
						],			
						'separator' => "before"		
					]
				);


		$this->end_controls_section();

				$this->start_controls_section(
					'image_box',
					[
						'label' => esc_html_x( 'Image','Admin Panel','naturalife' )
					]
				); 

				$this->add_control(
					'img',
					[
						'label'     => esc_html_x( 'Select Image', 'Admin Panel','naturalife' ),
						'type'      =>  Controls_Manager::MEDIA,
						'default' => [
							'url' => Utils::get_placeholder_image_src(),
						],				
					]
				);

				$this->add_control(
					'image_size',
					 [
						'label'   => esc_html_x("Image size", 'Admin Panel','naturalife'),
						'type'    =>  Controls_Manager::SELECT,
						'options' => array_merge( array(""=>esc_html_x("Select", 'Admin Panel','naturalife')), rtframework_get_intermediate_image_sizes() ),
					]
				);  

				$this->add_control(
					'img_pos',
					[
						'label'     => esc_html_x( 'Image Position', 'Admin Panel','naturalife' ),
						'type'      =>  Controls_Manager::SELECT,
						'default'   => 'style-1',
						"options"   => array(
											"left" => esc_html_x("Left", 'Admin Panel','naturalife'), 
											"right" => esc_html_x("Right", 'Admin Panel','naturalife'), 
											"top" => esc_html_x("Top", 'Admin Panel','naturalife'), 
											"bottom" => esc_html_x("Bottom", 'Admin Panel','naturalife'), 
										),			
						'prefix_class' => 'rt-image-box-pos-'           
					]
				);  

				$this->add_responsive_control(
					'image_padding',
					[
						'label' => esc_html_x( 'Image Padding', 'Admin Panel', 'naturalife' ),
						'type' => Controls_Manager::DIMENSIONS,
						'size_units' => [ 'px', 'em', '%' ],
						'selectors' => [
							'{{WRAPPER}} figure img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
					]
				);

				$this->add_responsive_control(
					'image_col_width',
					[
						'label' => __( 'Image Column Width',  'Admin Panel', 'naturalife' ),
						'type'      =>  Controls_Manager::SELECT,
						'default'    => 'style-1',
						"options"    => array(
											"12" => "12/12",
											"11" => "11/12",
											"10" => "10/12",
											"9" => "9/12",
											"8" => "8/12",
											"7" => "7/12",
											"6" => "6/12",
											"5" => "5/12",
											"4" => "4/12",
											"3" => "3/12",
											"2" => "2/12",
											"1" => "1/12", 
										),			
					]
				);  

				$this->add_control(
					'img_align',
					[
						'label'     => esc_html_x( 'Image Aligment', 'Admin Panel','naturalife' ),
						'type'      =>  Controls_Manager::SELECT,
						'default'   => 'start',
						"options"   => array(
											"start" => esc_html_x("Top", 'Admin Panel','naturalife'), 
											"center" => esc_html_x("Center", 'Admin Panel','naturalife'), 
											"end" => esc_html_x("Bottom", 'Admin Panel','naturalife'),  
										)    
					]
				);  				


		$this->end_controls_section();

		$this->start_controls_section(
			'button',
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
					'button_link',
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

				$this->add_responsive_control(
					'button_padding',
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
					'button_margin',
					[
						'label' => esc_html_x( 'Button Margin', 'Admin Panel', 'naturalife' ),
						'type' => Controls_Manager::DIMENSIONS,
						'size_units' => [ 'px', 'em', '%' ],
						'selectors' => [
							'{{WRAPPER}} .button_, {{WRAPPER}} .read_more' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
					]
				);


		$this->end_controls_section();

		$this->start_controls_section(
			'box_link_section',
			[
				'label' => esc_html_x( 'Link','Admin Panel','naturalife' )
			]
		); 

 		$this->add_control(
			'box_link',
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
			'box_link_title',
			[
				'label' => esc_html_x("Link Title", 'Admin Panel','naturalife'),
				'type' => Controls_Manager::TEXT
			]
		);

		$this->end_controls_section();
	}

	protected function render( ) {

		$settings = $this->get_settings();  


		$settings["image_col_width"] = (int) $settings["image_col_width"];
		$settings["image_col_width_tablet"] = (int) $settings["image_col_width_tablet"];
		$settings["image_col_width_mobile"] = (int) $settings["image_col_width_mobile"];



		$image_class[] = "col";
		$image_class[] = ! empty( $settings["image_col_width"] ) ? "col-lg-". $settings["image_col_width"] : "";
		$image_class[] = ! empty( $settings["image_col_width_tablet"] ) ? "col-sm-". $settings["image_col_width_tablet"] : "";
		$image_class[] = ! empty( $settings["image_col_width_mobile"] ) ? "col-". $settings["image_col_width_mobile"] : "col-12";

		$content_class[] = "col";
		$content_class[] = ! empty( $settings["image_col_width"] ) ? "col-lg-". (12- $settings["image_col_width"] == 0 ? 12 : 12 - $settings["image_col_width"] ) : "";
		$content_class[] = ! empty( $settings["image_col_width_tablet"] ) ? "col-sm-". (12-$settings["image_col_width_tablet"] == 0 ? 12 : 12 - $settings["image_col_width_tablet"] ) : "";
		$content_class[] = ! empty( $settings["image_col_width_mobile"] ) ? "col-". (12-$settings["image_col_width_mobile"] == 0 ? 12 : 12 - $settings["image_col_width_mobile"] ) : "col-12";

		$box_link = ! empty( $settings['box_link']['url'] ) ? sprintf('<a class="rt-image-box-link" href="%1$s" title="%2$s" target="%3$s"></a>',$settings['box_link']['url'], $settings['box_link_title'], ($settings['box_link']['is_external'] ? '_blank' : '_self')) : "";

		$html = sprintf(
					'<div class="rt-image-box row align-items-%7$s">
						%8$s
						<div class="rt-image-box-content %5$s">
							%1$s
							%2$s
							%3$s
						</div>
						<figure class="%6$s">
							%4$s
						</figure>
					</div>',	
					rt_heading_function(array("punchline"=>$settings["punchline"],"style"=>$settings["style"],"size"=>$settings["size"]),$settings["heading_text"]),
					$settings["text"],
					! empty( $settings["button_text"] ) ? rt_shortcode_button(array("button_arrow" => $settings["button_arrow"],"button_rounded" => $settings["button_rounded"],"button_link" => $settings["button_link"]["url"],"href_title" => $settings["href_title"],"button_style" => $settings["button_style"],"button_size" => $settings["button_size"], "button_text" => $settings["button_text"], "link_open" => ($settings['button_link']['is_external'] ? '_blank' : '_self') ) ) : "",
					wp_get_attachment_image( $settings["img"]["id"], $settings["image_size"], false, array( "class" => "img-responsive aligncenter" )),
					implode(" ", $content_class),
					implode(" ", $image_class),
					$settings["img_align"],
					$box_link
				);						

		echo $html;
	}

	protected function content_template() {
	}
}


Plugin::instance()->widgets_manager->register_widget_type( new Widget_RT_Image_box() );

