<?php
/**
 * Elementor Addons & Config
 * 
 * @author RT-Themes
 */


if( ! function_exists("rt_elementor_addons")){
	/**
	 * Includes
	 */	
	function rt_elementor_addons()
	{
		$module_list = array( 
			"heading", 
			"button", 
			"blog",
			"blog_carousel",
			"contact_form", 
			"counter",
			"latest_news",
			"quote",
			"image_carousel",
			"photo_gallery",
			"piechart",
			"progress-bar", 
			"countdown",
			"tabs",
			"accordions",
			"slider",
			"pricing_tables", 
			"simple_table", 
			"timeline", 
			"map",			
			"image_box",
			"breadcrumb"
		);


		if ( class_exists( 'RT_Custom_Posts' ) ) {

			if( RT_Custom_Posts::is_testimonials_active() ){
				array_push($module_list, 'testimonial');
				array_push($module_list, 'testimonial_carousel');
			}

			if( RT_Custom_Posts::is_portfolio_active() ){
				array_push($module_list, 'portfolio');
				array_push($module_list, 'portfolio_carousel');
			}
			if( RT_Custom_Posts::is_team_active() ){
				array_push($module_list, 'staff');
			}
		}

		//check woocommerce
		if ( class_exists( 'Woocommerce' ) ) {
			array_push($module_list, 'woocommerce_products');
			array_push($module_list, 'woocommerce_categories');
			array_push($module_list, 'woocommerce_carousel');
		}
	 
	 	//check CF7
		if ( class_exists( "WPCF7" ) ){
			array_push($module_list, 'contact_form_7');
		}

	 	//check revslider
		if ( class_exists( "RevSlider" ) ){
			array_push($module_list, 'rev_slider');
		}


		foreach ($module_list as $module_name) {
			include( RT_EXTENSIONS_PATH . "/inc/elementor-addons/".$module_name.".php" );
		}
 
	}
}
add_action( "elementor/widgets/widgets_registered", "rt_elementor_addons", 10, 1 );



if( ! function_exists("rt_elementor_icons")){
	/**
	 * Includes
	 */	
	function rt_elementor_icons()
	{
	 
		//Controls
		include( RT_EXTENSIONS_PATH . "/inc/elementor-addons/icon-control.php" );

	}
}
add_action( "elementor/init", "rt_elementor_icons", 10, 1 );

if( ! function_exists("rt_elementor_addons_category")){
	/**
	 * Addons Category
	 */	
	function rt_elementor_addons_category(){
		Elementor\Plugin::instance()->elements_manager->add_category(
			'rt-elementor-addons',
			[
				'title'  => RT_THEMENAME .' '. esc_html_x( 'Addons for Elementor', 'Adnin Panel', 'naturalife' ),
				'icon' => 'font'
			],
			1
		);
	}
}
add_action('elementor/init','rt_elementor_addons_category');

if( ! function_exists("rt_elementor_addons_css")){
	/**
	 * CSS Files
	 */	
	function rt_elementor_addons_css(){
		wp_enqueue_style('theme-fonts', rtframework_locate_media_file( '/css/fontello/css/fontello.css' ));     
	}
}
add_action( "elementor/editor/after_enqueue_styles", "rt_elementor_addons_css", 10, 1 );

if( ! function_exists("rt_elementor_addons_js")){
	/**
	 * JS Files
	 */	
	function rt_elementor_addons_js(){

		//load google api
		$api_key = get_theme_mod(RT_THEMESLUG.'_google_api_key');

		if( ! empty( $api_key ) ){
			$googlemaps_url = add_query_arg( 'key', urlencode( $api_key ), "//maps.googleapis.com/maps/api/js" );
			wp_enqueue_script('googlemaps',$googlemaps_url,array(), '1.0.0'); 	
		}else{
			wp_enqueue_script('googlemaps','//maps.googleapis.com/maps/api/js'); 
		}

		wp_enqueue_script('rt-elementor-addons', RT_EXTENSIONS_URI. 'js/elementor-addons.js' , array('jquery'),'1.0', true);    

	}
}
add_action( "elementor/preview/enqueue_scripts", "rt_elementor_addons_js", 10, 1 );



if( ! function_exists("rtframework_elementor_parallax_effect") ){
	/**
	 * Parallax Effect
	 * Adds parallax effect settings to elementor
	 *
	 * @since 1.0
	 *  
	 */
	function rtframework_elementor_parallax_effect( $section, $args ) {

		  $section->add_control(
			'rt_parallax',
			[
				'label'              => esc_html_x("Parallax Background", 'Admin Panel','naturalife'),
				'type'               => Elementor\Controls_Manager::SWITCHER,
				'default'            => '',
				'label_on'           => esc_html_x("ON", 'Admin Panel','naturalife'),
				'label_off'          => esc_html_x("OFF", 'Admin Panel','naturalife'),
				'return_value'       => 'rt-el-parallax-background',
				'frontend_available' => true,
				'prefix_class'       => ''                   
			]
		  ); 

		 $section->add_control(
			'rt_bg_parallax_warning' ,
			[
				'raw'             => esc_html_x('Note: The parallax effect won\'t work on the editor mode. Save and visit the page to see it.', 'Admin Panel','naturalife' ), 
				'type'            => Elementor\Controls_Manager::RAW_HTML,
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-warning',
				'condition'       => [
									'rt_parallax'     => [ "rt-el-parallax-background" ],
									],
			]
		 );      

		 $section->add_control(
			'rt_bg_parallax_effect' ,
			[
				'label'        => esc_html_x( 'Parallax Effect', 'Admin Panel','naturalife' ), 
				'description'  => esc_html_x('Select the parallax style set repeat mode direction for the background image.', 'Admin Panel','naturalife' ), 
				'type'         => Elementor\Controls_Manager::SELECT,
				'default'      => '3',
				'options'      => array( 
									"1" => _x("Horizontally, from left to right",'Admin Panel','naturalife'),
									"2" => _x("Horizontally, from right to left",'Admin Panel','naturalife'),
									"3" => _x("Vertically, from top to bottom",'Admin Panel','naturalife'),
									"4" => _x("Vertically, from bottom to top",'Admin Panel','naturalife'),
								),
				'label_block'  => true,
				'frontend_available' => true,
				'condition' => [
					'rt_parallax' => [ "rt-el-parallax-background" ],
				],  
			]
		 );

		 $section->add_control(
			'rt_bg_parallax_speed' ,
			[
			   'label'        => esc_html_x( 'Parallax Speed', 'Admin Panel','naturalife' ),  
			   'type'         => Elementor\Controls_Manager::SELECT,
			   'default'      => '1',
			   'options'      => array( 
										  "1" => "1",  
										  "2" => "2",  
										  "3" => "3",   
								),
			   'label_block'  => true,
			   'frontend_available' => true,
				'condition' => [
				  'rt_parallax' => [ "rt-el-parallax-background" ],
				],  

			]
		 );                
	}
}
add_action('elementor/element/section/section_background/before_section_end', 'rtframework_elementor_parallax_effect', 100, 3 );
add_action('elementor/element/column/section_style/before_section_end', 'rtframework_elementor_parallax_effect', 100, 3 );



if( ! function_exists("rtframework_section_snap") ){
	/**
	 * Snap section
	 *
	 * @since 1.0
	 *  
	 */
	function rtframework_section_snap( $section, $args ) {

		$section->start_controls_section(
		  'rt_align_section',
		  [
			'label' =>  esc_html_x( 'Align','Admin Panel','naturalife' ),
			'tab' => Elementor\Controls_Manager::TAB_STYLE,
		  ]                      
		); 

		$section->add_control(
			'rt_align',
			[
				'label' => esc_html_x( 'Section Align', 'Admin Panel', 'naturalife' ),
				'type' => Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html_x( 'Right', 'Admin Panel', 'naturalife' ),
						'icon' => 'fa fa-align-left',
					],
					'' => [
						'title' => esc_html_x( 'Center', 'Admin Panel', 'naturalife' ),
						'icon' => 'fa fa-align-center',
					],					
					'right' => [
						'title' => esc_html_x( 'Right', 'Admin Panel', 'naturalife' ),
						'icon' => 'fa fa-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}} > .elementor-container' => 'margin-{{VALUE}}: 0;',
				],
			]
		);

		$section->end_controls_section();
	}
}
add_action('elementor/element/section/section_typo/after_section_end', 'rtframework_section_snap', 100, 3 );


if( ! function_exists("rtframework_elementor_background_text") ){
	/**
	 * Background Text
	 *
	 * @since 1.0
	 *  
	 */
	function rtframework_elementor_background_text( $section, $args ) {

	  // Content Controls
		$section->start_controls_section(
		  'rt_section_background_text',
		  [
			'label' =>  esc_html_x( 'Background Text','Admin Panel','naturalife' ),
			'tab' => Elementor\Controls_Manager::TAB_STYLE,
		  ]                      
		); 

		$section->add_control(
			'rt_background_text_enabled' ,
			[

				'label' => esc_html_x("Background Text?", 'Admin Panel','naturalife'), 
				'type' => Elementor\Controls_Manager::SWITCHER,
				'default' => '',
				'label_on' => esc_html_x("ON", 'Admin Panel','naturalife'),
				'label_off' => esc_html_x("OFF", 'Admin Panel','naturalife'),
				'return_value' => 'rt-background-text',
				'prefix_class' => '',		
			]
		); 	

		$section->add_control(
			'rt_background_text',
			[
				'label' => esc_html_x("Background Text", 'Admin Panel','naturalife'),
				'default' => esc_html_x("Background Text", 'Admin Panel','naturalife'),
				'type' => Elementor\Controls_Manager::TEXTAREA, 
				'selectors' => [
					'{{WRAPPER}}:before' => 'content:"{{VALUE}}"',
				],				
				'condition' => [
									'rt_background_text_enabled' => [ "rt-background-text" ],
								],		
			]
		);   
 
 		$section->add_responsive_control(
				'icon_size_elementor',
				[
					'label' => esc_html_x( 'Text Size (px)', 'Admin Panel', 'naturalife' ),
					'type' => Elementor\Controls_Manager::SLIDER,
					'range' => [
					    'px' => [
					        'min' => 0,
					        'max' => 300,
					        'step' => 1,
					    ]
					],			
					'size_units' => ['px'],
					'selectors' => [
						'{{WRAPPER}}:before' => 'font-size: {{SIZE}}{{UNIT}}',
					],
					'condition' => [
										'rt_background_text_enabled' => [ "rt-background-text" ],
									],							
				]
		);  

		$section->end_controls_section();
	}
}
add_action('elementor/element/section/section_background/after_section_end', 'rtframework_elementor_background_text', 110, 3 );


if( ! function_exists("rtframework_elementor_color_set") ){
	/**
	 * Color Sets
	 *
	 * @since 1.0
	 *  
	 */
	function rtframework_elementor_color_set( $section, $args ) {

	  // Content Controls
		$section->start_controls_section(
		  'rt_section_color_set',
		  [
			'label' =>  esc_html_x( 'Color Set','Admin Panel','naturalife' ),
			'tab' => Elementor\Controls_Manager::TAB_STYLE,
		  ]                      
		); 

		 $section->add_control(
			'rt_color_sets' ,
			[
			   'label'        => esc_html_x( 'Color Sets', 'Admin Panel','naturalife' ), 
			   'type'         => Elementor\Controls_Manager::SELECT,
			   'default'      => 'default-style',
			   'options'      => array( 
									  ''              => esc_html_x('Global Colors', 'Admin Panel', 'naturalife'),
									  'default-style' => esc_html_x('Default Style', 'Admin Panel', 'naturalife'),
									  'alt-style-1'   => esc_html_x('Alt Style 1', 'Admin Panel', 'naturalife'),
									  'light-style'   => esc_html_x('Light Style', 'Admin Panel', 'naturalife'),
								),
			   'prefix_class' => '',
			   'label_block'  => true,
			   'frontend_available' => true,
			]
		 );

		 $section->add_control(
			'rt_column_style' ,
			[
			   'label'        => esc_html_x( 'Column Style', 'Admin Panel','naturalife' ), 
			   'type'         => Elementor\Controls_Manager::SELECT, 
			   'options'      => array( 
									  ''            => esc_html_x('Default', 'Admin Panel', 'naturalife'),
									  'border_grid' => esc_html_x('Grid view', 'Admin Panel', 'naturalife'),
								),
			   'prefix_class' => ''
			]
		 );                  


		$section->end_controls_section();
	}
}
add_action('elementor/element/section/section_background/before_section_start', 'rtframework_elementor_color_set', 100, 3 );

if( ! function_exists("rtframework_elementor_color_set_column") ){
	/**
	 * Color Sets
	 *
	 * @since 1.0
	 *  
	 */
	function rtframework_elementor_color_set_column( $section, $args ) {

	  // Content Controls
		$section->start_controls_section(
		  'rt_section_color_set',
		  [
			'label' =>  esc_html_x( 'Color Set','Admin Panel','naturalife' ),
			'tab' => Elementor\Controls_Manager::TAB_STYLE,
		  ]                      
		); 

		 $section->add_control(
			'rt_color_sets' ,
			[
			   'label'        => esc_html_x( 'Color Sets', 'Admin Panel','naturalife' ), 
			   'type'         => Elementor\Controls_Manager::SELECT,
			   'default'      => '',
			   'options'      => array( 
									  ''              => esc_html_x('Global Colors', 'Admin Panel', 'naturalife'),
									  'default-style' => esc_html_x('Default Style', 'Admin Panel', 'naturalife'),
									  'alt-style-1'   => esc_html_x('Alt Style 1', 'Admin Panel', 'naturalife'),
									  'light-style'   => esc_html_x('Light Style', 'Admin Panel', 'naturalife'),
								),
			   'prefix_class' => ''
			]
		 );

		$section->end_controls_section();

	}
}
add_action('elementor/element/column/section_style/before_section_start', 'rtframework_elementor_color_set_column', 100, 3 );

if( ! function_exists("rtframework_elementor_disable_column_borders") ){
	/**
	 * Color Sets
	 *
	 * @since 1.0
	 *  
	 */
	function rtframework_elementor_disable_column_borders( $section, $args ) {

 
		 $section->add_responsive_control(
			'rt-border' ,
			[
				'label' => esc_html_x("Responsive Border Widths", 'Admin Panel','naturalife'),
				'type' => Elementor\Controls_Manager::DIMENSIONS, 
				'size_units' => [ 'px' ],
				'selectors' => [
					'{{WRAPPER}} .elementor-column-wrap' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
									'border_border' => [ "solid", "double", "dotted", "dashed" ],
								],						
			]
		 );
 
	}
}
add_action('elementor/element/column/section_border/before_section_end', 'rtframework_elementor_disable_column_borders', 100, 3 );


if( ! function_exists("rtframework_elementor_icon_list_addons") ){
	/**
	 * Color Sets
	 *
	 * @since 1.0
	 *  
	 */
	function rtframework_elementor_icon_list_addons( $section, $args ) {
		$section->add_control(
			'rt_color_background' ,
			[
				'label' =>  esc_html_x( 'Background Color', 'Admin Panel','naturalife' ),
				'type' => Elementor\Controls_Manager::COLOR, 
				'selectors' => [
					'{{WRAPPER}} .elementor-icon-list-icon i' => 'background-color: {{VALUE}};display:inline-block;',
				]
			]
		);

		$section->add_control(
			'rt_icon_padding',
			[
				'label' => esc_html__( 'Padding', 'Admin Panel', 'naturalife' ),
				'type' => Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors' => [
					'{{WRAPPER}} .elementor-icon-list-icon i' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};display:inline-block;',
				],
			]
		);  

		$section->add_control(
			'rt_box_size' ,
			[
				'label' =>  esc_html_x( 'Box Size', 'Admin Panel','naturalife' ),
				'type' => Elementor\Controls_Manager::NUMBER, 
				'selectors' => [
					'{{WRAPPER}} .elementor-icon-list-icon i' => 'width: {{VALUE}}px;height: {{VALUE}}px;line-height: {{VALUE}}px;display:inline-block;',
				]
			]
		);		
	}
}		
add_action('elementor/element/icon-list/section_icon_style/before_section_end', 'rtframework_elementor_icon_list_addons', 100, 3 );


if( ! function_exists("rtframework_elementor_new_icon_styles") ){
	/**
	 * Color Sets
	 *
	 * @since 1.0
	 *  
	 */
	function rtframework_elementor_new_icon_styles( $section, $args ) {
	 

		$section->add_control(
			'rt_custom_icon_style' ,
			[

				'label' => esc_html_x("Styled Borders?", 'Admin Panel','naturalife'), 
				'type' => Elementor\Controls_Manager::SWITCHER,
				'default' => '',
				'label_on' => esc_html_x("ON", 'Admin Panel','naturalife'),
				'label_off' => esc_html_x("OFF", 'Admin Panel','naturalife'),
				'return_value' => 'rt-custom-style',
				'prefix_class' => '', 
				'condition' => [
									'view' => [ "framed"],
								],						
			]
		); 	
	}
}		
add_action('elementor/element/icon/section_icon/before_section_end', 'rtframework_elementor_new_icon_styles', 100, 3 );


if( ! function_exists("rtframework_add_elementor_templates") ){
	/**
	 * Add Templates 
	 *  
	 */
	function rtframework_add_elementor_templates( $templates ) {  
		
		if( ! defined( "ELEMENTOR_VERSION" ) ){
			return;
		}

		require( RT_EXTENSIONS_PATH . "/inc/elementor-templates.php" );
		$source = new RTFramework_Templates_Source();
		$theme_templates = $source->get_items(); 

		if (version_compare( ELEMENTOR_VERSION,"2.0","<")){
			$templates = array_merge($theme_templates, $templates);
		}else{
			$templates["templates"] = array_merge($theme_templates, $templates["templates"]);
		}
 
		return $templates;
	}
}
add_filter( 'option_elementor_remote_info_library', 'rtframework_add_elementor_templates' ); 
add_filter( 'option_elementor_remote_info_templates_data', 'rtframework_add_elementor_templates' );


if( ! function_exists("rtframework_get_elementor_template_data") ){
	/**
	 * Get Template Data 
	 *  
	 */
	function rtframework_get_elementor_template_data() {  

		if ( ! isset( $_REQUEST['template_id'] ) || empty( $_REQUEST['template_id'] ) ) {
			return;
		}

		if ( strpos( $_REQUEST['template_id'], RT_THEMESLUG) === false ) {
			return;
		}

		if( ! class_exists("RTFramework_Templates_Source") ){
			require( RT_EXTENSIONS_PATH . "/inc/elementor-templates.php" );	
			$source = new RTFramework_Templates_Source();
		} 

		wp_send_json_success( $source->get_data( $_REQUEST ) );
	}
}
add_action( 'wp_ajax_elementor_get_template_data', 'rtframework_get_elementor_template_data', 0 );


if( ! function_exists("rtframework_get_elementor_library_data") ){
	/**
	 * 
	 * Get Library Data 
	 *  
	 */
	function rtframework_get_elementor_library_data() {  

		if( ! class_exists("RTFramework_Templates_Manager") ){
			require( RT_EXTENSIONS_PATH . "/inc/elementor-templates.php" );	
			$source = new RTFramework_Templates_Manager();
		} 

		wp_send_json_success( $source->get_library_data( $_REQUEST ) );
	}
}
add_action( 'wp_ajax_elementor_get_library_data', 'rtframework_get_elementor_library_data', 0 );


if( ! function_exists("rtframework_get_elementor_editor_styles") ){
	/**
	 *
	 * Extra editor styles
	 *  
	 */
	function rtframework_get_elementor_editor_styles() {  
		
		wp_add_inline_style( 'elementor-editor', '
			.elementor-template-library-template:hover .elementor-template-library-template-screenshot {
				background-position: 0 100%;
				transition: all 1.5s;
			}
		');
 
	}
}
add_action( 'elementor/editor/after_enqueue_styles', 'rtframework_get_elementor_editor_styles', 0 );