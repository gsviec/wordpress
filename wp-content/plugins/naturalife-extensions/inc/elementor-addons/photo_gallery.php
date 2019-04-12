<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; 

class Widget_RT_PhotoGallery extends Widget_Base {

	public function get_name() {
		return 'rt-photo-gallery';
	}

	public function get_title() {
		return "[RT] ".esc_html_x( 'Image Gallery', 'Adnin Panel', 'naturalife' );
	}

	public function get_categories() {
		return [ 'rt-elementor-addons' ];
	}

	public function get_icon() {
		return 'eicon-gallery-grid';
	}

	protected function _register_controls() {

		// Content Controls
		$this->start_controls_section(
			'RT_PhotoGallery_content',
			[
				'label' => esc_html_x( 'RT Photo Gallery','Admin Panel','naturalife' )
			]
		); 

		$this->add_control(
			'wp_gallery',
			[
				'label' => esc_html_x( 'Add Images','Admin Panel','naturalife' ),
				'type' => Controls_Manager::GALLERY,
			]
		);

		$this->add_control(
			'layout_style',
			[
				'label'     => esc_html_x( 'Layout Style', 'Admin Panel','naturalife' ),
				'type'      =>  Controls_Manager::SELECT,
				'default'   =>  "grid",
				"options"    => array(
									""        => esc_html_x("Select", 'Admin Panel','naturalife'),
									"grid"    => esc_html_x("Grid",'Admin Panel','naturalife'),
									"masonry" => esc_html_x("Masonry",'Admin Panel','naturalife'),
									"metro"   => esc_html_x("Metro",'Admin Panel','naturalife'),
								),
			]
		 
		);

		$this->add_control(
			'item_width',
			[
				'label'     => esc_html_x( 'Gallery Layout', 'Admin Panel','naturalife' ),
				'type'      =>  Controls_Manager::SELECT,
				'default'   =>  "1/3",
				"options"   => array(
									"1/12" => "1/12", 
									"1/6" => "1/6", 
									"1/4" => "1/4",
									"1/3" => "1/3",
									"1/2" => "1/2",
									"1/1" => "1/1"
								),
				'description' => esc_html_x('Image per row', 'Admin Panel','naturalife' ),	
				'condition' => [
									'layout_style' => [ "grid","masonry" ],
								],					
			]
		 
		);


		$this->add_control(
			'vertical_align',
			[
				'label'     => esc_html_x( 'Vertical Align', 'Admin Panel','naturalife' ),
				'type'      =>  Controls_Manager::SELECT, 
				"options"    => array(
									"" => esc_html_x( 'Top', 'Admin Panel', 'naturalife' ), 
									"center" => esc_html_x( 'Center', 'Admin Panel', 'naturalife' ),
								),		
				'condition' => [
									'layout_style' => [ "grid" ],
								],																		
			]
		); 

		$this->add_control(
			'nogaps',
			[
				'label' => esc_html_x("Remove column gaps", 'Admin Panel','naturalife'),
				'type' => Controls_Manager::SWITCHER,
				'default' => '',
				'label_on' => esc_html_x("ON", 'Admin Panel','naturalife'),
				'label_off' => esc_html_x("OFF", 'Admin Panel','naturalife'),
				'return_value' => 'true',
			]
		); 


		$image_sizes = array_merge(array("Custom","full"),get_intermediate_image_sizes());

		foreach ($image_sizes as $key => $value) {
			$image_sizes_array[$value] = $value;
		}

		$this->add_control(
			'image_size',
			[
				'label'   => esc_html_x("Image size", 'Admin Panel','naturalife'),
				'type'    =>  Controls_Manager::SELECT,
				"options" => array_merge( array(""=>esc_html_x("Select", 'Admin Panel','naturalife')), rtframework_get_intermediate_image_sizes(true) ),
				'condition' => [
									'layout_style' => [ "grid","masonry" ],
								],

			]
		); 


		$this->add_control(
			'w',
			[
				'label'   => esc_html_x("Image Width", 'Admin Panel','naturalife'),
				'type'    =>  Controls_Manager::NUMBER,
				'condition' => [
									'image_size' => [ "custom" ],
								],
				'default' => 100,
				'min'     => 20,
				'max'     => 1000,
				'step'    => 5,			
				'description' => esc_html_x('Set a width value for the images. Note: Remember that the images width will be resoponsive. Leave blank for auto width.', 'Admin Panel','naturalife' ),					

			]
		); 

 		$this->add_control(
			'h',
			[
				'label'   => esc_html_x("Image Height", 'Admin Panel','naturalife'),
				'type'    =>  Controls_Manager::NUMBER,
				'condition' => [
									'image_size' => [ "custom" ],
								],
				'default' => 100,
				'min'     => 20,
				'max'     => 1000,
				'step'    => 5,			
				'description' => esc_html_x('Set a height value for the images. Remember that the image heights will be resoponsive. Leave blank for auto height.', 'Admin Panel','naturalife' ),

			]
		); 
 
		$this->add_control(
			'crop',
			[
				'label' => esc_html_x("Crop Images", 'Admin Panel','naturalife'),
				'type' => Controls_Manager::SWITCHER,
				'default' => '',
				'label_on' => esc_html_x("ON", 'Admin Panel','naturalife'),
				'label_off' => esc_html_x("OFF", 'Admin Panel','naturalife'),
				'return_value' => 'true',
				'condition' => [
									'image_size' => [ "custom" ],
								],				
			]
		); 


		$this->add_control(
			'metro_resize',
			[
				'label' => esc_html_x("Resize and Crop Metro Gallery Images?", 'Admin Panel','naturalife'),
				'type' => Controls_Manager::SWITCHER,
				'default' => '',
				'label_on' => esc_html_x("ON", 'Admin Panel','naturalife'),
				'label_off' => esc_html_x("OFF", 'Admin Panel','naturalife'),
				'return_value' => 'true',
				'condition' => [
									'layout_style' => [ "metro" ],
								],			
				'description' => esc_html_x('Do not upload small or landscape/portrait sized photos to get correct layout.', 'Admin Panel','naturalife' ),									
			]
		); 


		$this->add_control(
			'layout',
			[
				'label'     => esc_html_x( 'Metro Layout', 'Admin Panel','naturalife' ),
				'type'      =>  Controls_Manager::SELECT,
				"options"    => array(
									"1" => esc_html_x("Style 1",'Admin Panel','naturalife'),
									"2" => esc_html_x("Style 2",'Admin Panel','naturalife'),
									"3" => esc_html_x("Style 3",'Admin Panel','naturalife'),
								),
				'description' => esc_html_x('Pre defined layouts', 'Admin Panel','naturalife' ),	
				'condition' => [
									'layout_style' => [ "metro" ],
								],					
			]
		 
		);

 		$this->add_control(
			'links',
			[
				'label'     => esc_html_x( 'Item Links', 'Admin Panel','naturalife' ),
				'type'      =>  Controls_Manager::SELECT,
				"options"    => array(
									"false" => esc_html_x("Disabled",'Admin Panel','naturalife'),
									"lightbox" => esc_html_x("Open Orginal Images in Lightbox",'Admin Panel','naturalife'),
									"custom" => esc_html_x("Custom Links",'Admin Panel','naturalife'),
								),
			]
		 
		);

 		$this->add_control(
			'custom_links',
			[
				'label'     => esc_html_x( 'Custom Links', 'Admin Panel','naturalife' ),
				'type'      =>  Controls_Manager::TEXTAREA,
				'description' => esc_html_x('Enter links for each image. The links must be separated by comma. ( http://link1.com, http://link2.com, http://link3.com ) ', 'Admin Panel','naturalife' ),	
				'condition' => [
									'links' => [ "custom" ],
								],						
			]
		 
		);

		$this->add_control(
			'link_target',
			[
				'label'     => esc_html_x( 'Link Target', 'Admin Panel','naturalife' ),
				'type'      =>  Controls_Manager::SELECT,
				"options"    => array(
									"_self" => esc_html_x("Same Tab", 'Admin Panel','naturalife'),
									"_blank"  => esc_html_x("New Tab", 'Admin Panel','naturalife'),
								), 
				'condition' => [
									'links' => [ "custom" ],
								],					
			]
		 
		);
   

		$this->add_control(
			'captions',
			[
				'label' => esc_html_x("Image Captions", 'Admin Panel','naturalife'),
				'type' => Controls_Manager::SWITCHER,
				'default' => '',
				'label_on' => esc_html_x("ON", 'Admin Panel','naturalife'),
				'label_off' => esc_html_x("OFF", 'Admin Panel','naturalife'),
				'return_value' => 'true',							
			]
		);  	


		$this->end_controls_section();

		$this->start_controls_section(
			'section_border',
			[
				'label' => esc_html_x( 'Item Styling', 'Admin Panel','naturalife' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);


		$this->add_responsive_control(
			'col_padding',
			[
				'label' => esc_html_x( 'Column Padding', 'Admin Panel','naturalife' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .col' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;margin-bottom:0 !important;',
					'{{WRAPPER}} .row' => 'margin-left: -{{LEFT}}{{UNIT}} !important;margin-right: -{{RIGHT}}{{UNIT}} !important;',
				],
				'condition' => [
									'layout_style' => [ "grid"],
								],					
			]
		);

		$this->add_responsive_control(
			'padding',
			[
				'label' => esc_html_x( 'Item Padding', 'Admin Panel','naturalife' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .gallery-item-holder' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
				'condition' => [
									'layout_style' => [ "grid"],
								],					
			]
		);


		$this->start_controls_tabs( 'tabs_border' );

		$this->start_controls_tab(
			'tab_border_normal',
			[
				'label' => esc_html_x( 'Normal', 'Admin Panel','naturalife' ),
			]
		);

		$this->add_control(
			'background_color',
			[
				'label' =>  esc_html_x( 'Background Color', 'Admin Panel','naturalife' ),
				'type' => Controls_Manager::COLOR, 
				'selectors' => [
					'{{WRAPPER}} .gallery-item-holder' => 'background-color: {{VALUE}};',
				]			
			]
		);
		
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'border',
				'selector' => '{{WRAPPER}} .gallery-item-holder',
			]
		);

		$this->add_control(
			'border_radius',
			[
				'label' => esc_html_x( 'Border Radius', 'Admin Panel','naturalife' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .gallery-item-holder'  => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'box_shadow',
				'selector' => '{{WRAPPER}} .gallery-item-holder',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_border_hover',
			[
				'label' => esc_html_x( 'Hover', 'Admin Panel','naturalife' ),
			]
		);

		$this->add_control(
			'background_hover',
			[
				'label' =>  esc_html_x( 'Background Color', 'Admin Panel','naturalife' ),
				'type' => Controls_Manager::COLOR, 
				'selectors' => [
					'{{WRAPPER}} .gallery-item-holder:hover' => 'background-color: {{VALUE}};',
				]			
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'border_hover',
				'selector' => '{{WRAPPER}} .gallery-item-holder:hover',
			]
		);

		$this->add_control(
			'border_radius_hover',
			[
				'label' => esc_html_x( 'Border Radius', 'Admin Panel','naturalife' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .gallery-item-holder:hover ' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'box_shadow_hover',
				'selector' => '{{WRAPPER}} .gallery-item-holder:hover',
			]
		);

		$this->add_control(
			'border_hover_transition',
			[
				'label' => esc_html_x( 'Transition Duration', 'Admin Panel','naturalife' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0.3,
				],
				'range' => [
					'size' => [
						'max' => 3,
						'step' => 0.1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .gallery-item-holder' => 'transition: background {{SIZE}}s, border {{SIZE}}s, border-radius {{SIZE}}s, box-shadow {{SIZE}}s'
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}


	protected function render( ) {
		
      $settings = $this->get_settings();

		$image_ids = array();

		foreach ($settings['wp_gallery'] as $key => $value) {
			$settings["image_ids"][] = $value["id"];
		}

		$settings["image_ids"] = implode(",", $settings["image_ids"]);

		echo rt_photo_gallery( $settings );

	}

	protected function content_template() {
	}
}


Plugin::instance()->widgets_manager->register_widget_type( new Widget_RT_PhotoGallery() );

