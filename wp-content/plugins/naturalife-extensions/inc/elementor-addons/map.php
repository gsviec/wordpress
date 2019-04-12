<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; 

class Widget_RT_Google_Map extends Widget_Base {

	public function get_name() {
		return 'rt-google-maps';
	}

	public function get_title() {
		return "[RT] ".esc_html_x( 'Google Maps', 'Adnin Panel', 'naturalife' );
	}

	public function get_categories() {
		return [ 'rt-elementor-addons' ];
	}

	public function get_icon() {
		return 'eicon-google-maps';
	}

	protected function _register_controls() {

		// Content Controls
  		$this->start_controls_section(
  			'RT_map_content',
  			[
  				'label' => esc_html_x( 'Google Maps','Admin Panel','naturalife' )
  			]
  		); 
  
   		$this->add_control(
			'rt_map_warning',
			[
				'name'            => 'rt_map_warning',
				'raw'             => sprintf(_x('%1$sPlease note:%2$s Google Maps require an API key that provided by Google. Enter the key to the field inside the %1$sCustomize > General Options > Google Maps%2$s. If you have not created an API key yet, refer the online documentation of the theme to learn how to create one.', 'Admin Panel','naturalife' ),"<strong>",'</strong>'),
				'type'            => Controls_Manager::RAW_HTML,
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-warning'
			]
		); 

 		$this->add_control(
			'height',
			[
				'label'   => esc_html_x("Height", 'Admin Panel','naturalife'),
				'type'    =>  Controls_Manager::NUMBER, 
				'default' => 500,
				'min'     => 100,
				'max'     => 2000, 		
				'description' => esc_html_x('Map Height', 'Admin Panel','naturalife' ),
			]
		); 

 		$this->add_control(
			'zoom',
			[
				'label'   => esc_html_x("Zoom Level", 'Admin Panel','naturalife'),
				'type'    =>  Controls_Manager::NUMBER, 
				'default' => 5,
				'min'     => 1,
				'max'     => 19, 		
				'description' => esc_html_x('Zoom level. Works only with single map location. Enter a zoom level between 1 and 19', 'Admin Panel','naturalife' ),
			]
		); 

		$this->add_control(
			'bwcolor',
			[
				'label' => esc_html_x("Black & White Map", 'Admin Panel','naturalife'),
				'type' => Controls_Manager::SWITCHER,
				'description' => esc_html_x('Make the map only black and white', 'Admin Panel','naturalife' ),
				'label_on' => esc_html_x("ON", 'Admin Panel','naturalife'),
				'label_off' => esc_html_x("OFF", 'Admin Panel','naturalife'),
				'return_value' => 'true',
			]
		); 		

 

			$this->add_control(
				'locations',
				[
					'label' => esc_html_x( 'Locations','Admin Panel','naturalife' ),
					'type' => Controls_Manager::REPEATER,
					'default' => [
						[
							'lat' => '51.5007046',
							'lon' => '-0.12457480000000487',		
							'title' => 'Big Ben'
						]
					],					
					'fields' => [
						[
							'name'            => 'rt_map_warning',
							'raw'             => sprintf(_x('Please check this %1$sdocumentation%2$s to learn how to find the latitude and the longitude values of a place.', 'Admin Panel','naturalife' ),'<a href="https://support.google.com/maps/answer/18539?co=GENIE.Platform%3DDesktop&hl=en" target="_blank">','</a>'),
							'type'            => Controls_Manager::RAW_HTML,
							'content_classes' => 'elementor-panel-alert elementor-panel-alert-warning'
						],
						[
							'name' => 'lat',
							'label' => esc_html_x( 'Latitude', 'Admin Panel', 'naturalife' ),
							'type' => Controls_Manager::TEXT, 
							'placeholder' => esc_html_x( 'Latitude', 'Admin Panel', 'naturalife' ),
							'label_block' => true,
						],
						[
							'name' => 'lon',
							'label' => esc_html_x( 'Longitude', 'Admin Panel', 'naturalife' ),
							'type' => Controls_Manager::TEXT, 
							'placeholder' => esc_html_x( 'Longitude', 'Admin Panel', 'naturalife' ),
							'label_block' => true,
						],
						[	
							'name' => 'title',
							'label' => esc_html_x("Location Title", 'Admin Panel','naturalife'),
							'type' => Controls_Manager::TEXT,
							'return_value' => 'true',			
						],						
						[
							'name' => 'content',
							'placeholder' => esc_html_x( 'Location Description', 'Admin Panel', 'naturalife' ), 
							'type' => Controls_Manager::TEXTAREA,
							'show_label' => false,
						]

					],
					'title_field' => '{{{ title }}}',
				]
		);

		$this->end_controls_section();  
	}

	protected function render( ) {

		$settings = $this->get_settings(); 
		$locations = ""; 
 
		foreach ( $settings["locations"] as $location ) {
			$locations .= sprintf('[location title="%s" lat="%s" lon="%s"]%s[/location]',$location["title"],$location["lat"],$location["lon"],$location["content"]); 
		}

		$map = sprintf('[google_maps height="%s" zoom="%s" bwcolor="%s"]%s[/google_maps]',$settings["height"],$settings["zoom"],$settings["bwcolor"],$locations); 

		echo do_shortcode( $map, false );
	}

	protected function content_template() {
	}
}


Plugin::instance()->widgets_manager->register_widget_type( new Widget_RT_Google_Map() );
