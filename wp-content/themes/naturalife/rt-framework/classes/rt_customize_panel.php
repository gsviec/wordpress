<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * RT-Theme Customizer Class
 *
 * Create theme customizer panel
 *
 * @class 		RTFramework_Customize_Panel
 * @version		1.0
 * @author 		RT-Themes
 */

class RTFramework_Customize_Panel extends RTFramework
{

	/**
	 * Options
	 */
	public $options = array();

	/**
	 * Option files
	 */
	public $option_files = array( "rt_general_options", "rt_logo_options", "rt_woocommerce_options", "rt_portfolio_options", "rt_blog_options", "rt_social_media_options", "rt_color_schemas", "rt_typography_options" );
	
	/**
	 * Skin Related Options
	 */
	public $skin_options = array();

	/**
	 * Utility options
	 */
	public $utility_options = array('naturalife_optimize_css'=>'','naturalife_optimize_js'=>'','naturalife_404_page'=>'','naturalife_maintenance_mode'=>'', 'naturalife_maintenance_page'=>'', 'is_portfolio_active' => 'on', 'is_team_active' => 'on', 'is_testimonials_active' => 'on');

	/**
	 * All Options 
	 */
	public $all_options = array();

	/**
	 * Capability
	 */
	public $capability = "edit_theme_options";

	/**
	 * Fonts
	 */
	public $fonts = array();


	/**
	 * @var RTFramework_Customize_Panel
	 */
	private static $instance;

	/**
	 * Main Class
	 * @return RTFramework_Customize_Panel
	 */
	public static function instance() {

		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof RTFramework_Customize_Panel ) ) {
			self::$instance = new RTFramework_Customize_Panel; 

		
			//check the current user access 
			if ( ! current_user_can( self::$instance->capability ) ){
				return ;
			}

			//load fonts
			self::$instance->load_fonts(); 

			//customizer functions
			self::$instance->customizer_functions(); 

			//Customizer Options 
			add_action('init', array( self::$instance, 'customizer_options'));  

			//Customizer Options 
			add_action('init', array( self::$instance, 'check_new_options'));  

			//init
			add_action( 'after_switch_theme', array( self::$instance, 'save_defaults') ); 
			add_action( 'customize_register', array( self::$instance, 'create_options')); 
			add_action( 'customize_preview_init', array( self::$instance, 'customize_preview_js'));
			add_action( 'admin_enqueue_scripts', array( self::$instance, 'customize_admin_js'));
			add_action( 'customize_controls_print_styles', array( self::$instance, 'customize_admin_css'));	

		}

		return self::$instance;
	}


	/**
	 * Load Fonts
	 */
	public function load_fonts()
	{

			/**
			 * User Custom Fonts 
			 * @var array
			 */
			
			$rt_custom_fonts = unserialize( get_option( "naturalife_custom_fonts" ) );
		
			if( ! empty( $rt_custom_fonts ) ){

				$this->fonts["#2_obt_start"] = esc_html_x("Custom Fonts",'Admin Panel','naturalife');
				
					foreach ( $rt_custom_fonts as $key => $custom_font )
					{
						$this->fonts[ '{"kind": "custom","family": "'.$custom_font["family_name"].'", "subsets": [], "variants": [] }' ] = $custom_font["family_name"]; 
					}

				$this->fonts["#2_obt_end"] = ""; //Web Safe Fonts

			}

			/**
			 * Web Safe Fonts
			 * @var array
			 */
			$rt_websafe_fonts = array(
					"Arial, Helvetica, sans-serif",
					"Arial Black, Gadget, sans-serif",
					"Bookman Old Style, serif",
					"Comic Sans MS, cursive",
					"Courier, monospace", 
					"Garamond, serif",
					"Georgia, serif",
					"Impact, Charcoal, sans-serif",
					"Lucida Console, Monaco, monospace",
					"Lucida Sans Unicode, Lucida Grande, sans-serif",
					"MS Sans Serif, Geneva, sans-serif",
					"MS Serif, New York, sans-serif",
					"Palatino Linotype, Book Antiqua, Palatino, serif",
					"Tahoma, Geneva, sans-serif",
					"Times New Roman, Times, serif",
					"Trebuchet MS, Helvetica, sans-serif",
					"Verdana, Geneva, sans-serif",
					"Webdings, sans-serif",
					"Wingdings, Zapf Dingbats, sans-serif"
			);
	
			$this->fonts["#1_obt_start"] = esc_html_x("Web Safe Fonts",'Admin Panel','naturalife');
			
				foreach ( $rt_websafe_fonts as $family_name )
				{
					$this->fonts[ '{"kind": "websafe","family": "'.$family_name.'", "subsets": [], "variants": [] }' ] = $family_name; 
				}

			$this->fonts["#1_obt_end"] = ""; //Web Safe Fonts

			/**
			 * Google Fonts
			 * @var array
			 */
			$google_fonts = array();

				//include the json file as string
				include( RT_THEMEADMINDIR ."/inc/google_webfonts_json.php" );

				//paste the list output
				if ( $json ){
					
					$json_output = json_decode($json, true);

					if( $json_output ){
				
						foreach ( $json_output["items"] as $font )
						{
							$google_fonts[ '{"kind": "google","family": "'.$font["family"].'", "subsets": '.json_encode( $font["subsets"] ).', "variants": '.json_encode( $font["variants"] ).'}' ] = $font["family"]; 
						}
					}

					asort($google_fonts);
					
					$this->fonts["#3_obt_start"] = esc_html_x("Google Fonts",'Admin Panel','naturalife');
					$this->fonts= array_merge(  $this->fonts, $google_fonts );
					$this->fonts["#3_obt_end"] = ""; //Google Safe Fotns
				}	 				 
	}


	/**
	 * Customizer Functions
	 */
	public function customizer_functions() {
		include( RT_THEMEADMINDIR . '/functions/rt_custom_controls.php');			
	}	


	/**
	 * Customizer Options
	 */
	public function customizer_options() {

		foreach ($this->option_files as $file) {
			include( RT_THEMEADMINDIR . '/inc/'.$file.'.php');	  	
		}

		//options
		$this->options = apply_filters( "rtframework_customizer_options", $this->options );
		
		//create skin related option set
		foreach ( $this->options as $panel => $atts ) {

			if( $panel == "rt_single_options" ){
				continue;
			}

			foreach ( $atts["sections"] as $section ) {
				foreach ( $section["controls"] as $control ) {

					
					if( $control["type"] == "rt_subsection_heading" || $control["type"] == "rt_seperator" ){
						continue;
					}

					if( isset($control["rt_skin"] )  ){
						$this->skin_options[] =  $control["id"];
					}

					$this->all_options[$control["id"]] =  isset($control["default"]) ? $control["default"] : "";
					
				}				
			}
		}

		//single sections
		foreach ( $this->options["rt_single_options"] as $section ) {
			foreach ( $section["controls"] as $control ) {

				if( $control["type"] == "rt_subsection_heading" || $control["type"] == "rt_seperator" ){
					continue;
				}

				if( isset($control["rt_skin"] )  ){
					$this->skin_options[] =  $control["id"];
				}

				$this->all_options[$control["id"]] =  isset($control["default"]) ? $control["default"] : "";
			}				
		}		

		//add utility options to all options array
		$this->all_options = array_merge( $this->all_options, $this->utility_options);	

	}	

	/**
	 * Check New Options
	 */
	public function check_new_options() {
		foreach ( array_diff_key($this->all_options, get_theme_mods() ) as $mod => $default_value ) {
			set_theme_mod( $mod, $default_value );
		}
	}	

	/**
	 * Bind JS handlers to make Theme Customizer preview reload changes asynchronously.
	 */
	public function customize_preview_js() {
		$min_extension = get_theme_mod('naturalife_optimize_css') ? "-min" : ""; 
		wp_enqueue_script( 'rttheme_customizer', RT_THEMEADMINURI . '/js/customizer'.$min_extension.'.js', array( 'customize-preview' ), RT_THEMEVERSION, true );

		//add js params
		$js_params = array("theme_slug" => RT_THEMESLUG);
		wp_localize_script( 'rttheme_customizer', 'rtframework_params', $js_params );
	}

	/**
	 * Customizer Admin JS files
	 */
	public function customize_admin_js() {

		$min_extension = get_theme_mod('naturalife_optimize_css') ? "-min" : ""; 
		wp_register_script( 'customizer-rt-color-js', RT_THEMEADMINURI . '/js/rt-color-control'.$min_extension.'.js', array( 'jquery' ), RT_THEMEVERSION, true );
		wp_register_script( 'customizer-rt-fonts-js', RT_THEMEADMINURI . '/js/rt-font-control'.$min_extension.'.js', array( 'jquery' ), RT_THEMEVERSION, true );
		wp_register_script( 'customizer-rt-skins-js', RT_THEMEADMINURI . '/js/rt-skin-selector'.$min_extension.'.js', array( 'jquery' ), RT_THEMEVERSION, true );

		wp_enqueue_script( 'customizer-rt-color-js' );
		wp_enqueue_script( 'customizer-rt-fonts-js' );
		wp_enqueue_script( 'customizer-rt-skins-js' );

		//localize js params
		$js_params = array(
			"apply_skin" => esc_html_x('Do you want to apply this skin? ','Admin Panel','naturalife'), 
			"select_parts" => esc_html_x('Please select a demo part to install.','Admin Panel','naturalife'), 
			"select_demo" => esc_html_x('Please select a demo.','Admin Panel','naturalife'), 
			"select_builder" => esc_html_x('Select a builder to proceed.','Admin Panel','naturalife'), 
			"install_elementor" => esc_html_x('Install and activate Elementor plugin to proceed.','Admin Panel','naturalife'), 
			"install_revslider" => esc_html_x('Install and activate Revolution Slider plugin to proceed.','Admin Panel','naturalife'), 
			"install_vc" => esc_html_x('Install and activate Visual Composer plugin to proceed.','Admin Panel','naturalife'), 
			"wait_previous_install" => esc_html_x('An installer has already been started. Please wait!','Admin Panel','naturalife'), 
			"theme_slug" => RT_THEMESLUG
		);

		wp_localize_script( 'jquery', 'rtframework_params', $js_params );
	}

	/**
	 * Customizer Admin CSS Files
	 */
	public function customize_admin_css() {
 
	}
 

	/**
	 * Create options
	 */
	public function create_options( $wp_customize )
	{			
		$section_count = $control_count = 1;		

		//sections within panels
		foreach ( $this->options as $panel => $atts ) {


			//jump single options
			if( $panel == "rt_single_options" ){
				continue;
			}



			if ( class_exists( 'RT_Custom_Posts' ) ) {

				//jump product options if disabled			
				if( ! RT_Custom_Posts::is_portfolio_active() && $panel == "rt_portfolio_options" ){
					continue;
				}
				
			}else{
				
				//jump portfolio options if the plugin not installed
				if( $panel == "rt_portfolio_options" ){
					continue;
				}
			}
			

			//jump woocommerce options if not installed			
			if( ! class_exists( 'Woocommerce' ) && $panel == "rt_woocommerce_options" ){
				continue;
			}

			$atts["description"] = isset( $atts["description"] ) ? $atts["description"] : "";

			$this->add_panel( $wp_customize, array( "panel" => $panel, "title" => $atts["title"], "description" => $atts["description"], "priority" => $atts["priority"] )  );

			foreach ( $atts["sections"] as $section ) {
				$this->add_section( $wp_customize, array( "panel" => $panel, "options" => $section, "priority" =>  $section_count++ )  );
	
				foreach ( $section["controls"] as $control ) {
					$this->add_setting( $wp_customize, array( "setting" => $control["id"], "control" => $control )  );

					$control["priority"] = $control_count++;
					$this->add_control( $wp_customize, array( "section" => $panel .'_'. $section["id"], "options" => $control )  );
				}				
			}
		}

		//single sections
		foreach ( $this->options["rt_single_options"] as $section ) {
			$this->add_section( $wp_customize, array( "options" => $section, "priority" =>  $section_count++ )  );

			foreach ( $section["controls"] as $control ) {
				$this->add_setting( $wp_customize, array( "setting" => $control["id"], "control" => $control )  );

				$control["priority"] = $control_count++;
				$this->add_control( $wp_customize, array( "section" => $section["id"], "options" => $control )  );
			}				
		}

	}

	/**
	 * Add a panel
	 */
	public function add_panel( $wp_customize, $atts )
	{

		$wp_customize->add_panel( $atts["panel"], array(
			'priority' => $atts["priority"],
			'capability' => $this->capability,
			'theme_supports' => '',
			'title' => $atts["title"],
			'description' => isset( $atts['description'] ) ? $atts['description'] : "",
		) );

	}

	/**
	 * Add a section
	 */
	public function add_section( $wp_customize, $atts )
	{
		
		$section_id = isset( $atts["panel"] ) ? $atts["panel"].'_'.$atts["options"]["id"] : $atts["options"]["id"];

		$wp_customize->add_section( $section_id, array(
			'title' => $atts["options"]["title"],
			'description' => isset($atts["options"]["description"]) ? $atts["options"]["description"] : "",
			'panel' => isset( $atts["panel"] ) ? $atts["panel"] : "",
			'priority' => $atts["priority"]
		) );
 
	}

	/**
	 * Add a setting
	 */
	public function add_setting( $wp_customize, $atts )
	{

		//create the setting
		$wp_customize->add_setting( $atts["setting"], array(
			'default' => isset( $atts['control']['default'] ) ? $atts['control']['default'] : "",
            'type' => 'theme_mod',
            'capability' => $this->capability,
            'transport' => isset( $atts['control']['transport'] ) ? $atts['control']['transport'] : "postMessage",
            'sanitize_callback' => isset( $atts['control']['callback'] ) ? $atts['control']['callback'] : array(&$this, 'rt_sanitize_field')
		) );
 
	}
 
	 /**
	  * Default sanitization function for each custom setting
	  * 
	  * @param  string $val 
	  * @return string $val 
	  */
	public function rt_sanitize_field( $val = "" )
	{
		if( ! is_array( $val ) ){
			return esc_html($val);	
		}else{
			return $val;
		}
	}


	/**
	  * Sanitize Number
	  * 
	  * @param  string $val 
	  * @return string $val 
	  */
	public function rt_sanitize_number( $val = "" )
	{	
		return ! empty( $val ) ? (int) $val : "";
	}

	/**
	 * Add a control
	 */
	public function add_control( $wp_customize, $atts )
	{

		$atts["options"]["section"] = $atts["section"];
		$atts["options"]["settings"] = $atts["options"]["id"]; 

		//add data-rt-control-type to postMessage items 
		if( ! isset($atts["options"]["transport"]) || ( isset($atts["options"]["transport"]) && $atts["options"]["transport"] == "postMessage" ) ){
			if( isset($atts["options"]["input_attrs"]) && is_array( $atts["options"]["input_attrs"] ) ){
				array_merge($atts["options"]["input_attrs"], array("data-rt-control-type"=>"postMessage"));	
			}else{
				$atts["options"]["input_attrs"] = array("data-rt-control-type"=>"postMessage");	
			}
		}

		//add the control 
		if( $atts["options"]["type"] == "color"){
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $atts["options"]["id"], $atts["options"] ) );	
		//add the rt media control 
		}elseif( $atts["options"]["type"] == "rt_media"){
			$wp_customize->add_control( new RT_Customize_Media_Control( $wp_customize, $atts["options"]["id"], $atts["options"] ) );						
		//add the media control 
		}elseif( $atts["options"]["type"] == "media"){
			$wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, $atts["options"]["id"], $atts["options"] ) );									
		//add the alpha color control 
		}elseif( $atts["options"]["type"] == "rt_color"){
			$wp_customize->add_control( new RT_Color_Control( $wp_customize, $atts["options"]["id"], $atts["options"] ) );							
		//add the select control 
		}elseif( $atts["options"]["type"] == "rt_select"){
			$wp_customize->add_control( new RT_Select_Control( $wp_customize, $atts["options"]["id"], $atts["options"] ) );													
		//add the content control 
		}elseif( $atts["options"]["type"] == "rt_content"){
			$wp_customize->add_control( new RT_Content_Control( $wp_customize, $atts["options"]["id"], $atts["options"] ) );		
		//add the checkbox control 
		}elseif( $atts["options"]["type"] == "rt_checkbox"){
			$wp_customize->add_control( new RT_Checkbox_Control( $wp_customize, $atts["options"]["id"], $atts["options"] ) );	  
		//add the seperator control 
		}elseif( $atts["options"]["type"] == "rt_seperator"){
			$wp_customize->add_control( new RT_Seperator_Control( $wp_customize, $atts["options"]["id"], $atts["options"] ) );																			
		//add the subsection heading control 
		}elseif( $atts["options"]["type"] == "rt_subsection_heading"){
			$wp_customize->add_control( new RT_SubSection_Heading( $wp_customize, $atts["options"]["id"], $atts["options"] ) );																						
		}else{
			$wp_customize->add_control( $atts["options"]["id"], $atts["options"] );	
		}
 
	} 

	/**
	 * 
	 * Save default value
	 * @param  boolean $reset 
	 * 
	 */
	public function save_defaults( $reset = "" )
	{

		//theme options resetted for the first time and detault vars installed
		$is_defaults_saved = get_option('naturalife_'.RT_UTHEME_NAME.'_defaults'); 

		if( $is_defaults_saved == "saved" && $reset !== "true" ){
			return ;
		}

		foreach ( $this->all_options as $mod => $default_value ) {			
			set_theme_mod( $mod, $default_value ); 
		}

		//add a db note
		update_option('naturalife_'.RT_UTHEME_NAME.'_defaults','saved'); 

		//actions
		do_action( 'rtframework_after_reset' );
	}
 
}

/**
 * Returns the main instance 
 *
 * @return RTFramework_Customize_Panel
 */
function RTFramework_Customize_Panel() {
	return RTFramework_Customize_Panel::instance();
}

// start
RTFramework_Customize_Panel();