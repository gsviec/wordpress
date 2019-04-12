<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; 

class Widget_RT_Blog extends Widget_Base {

	public function get_name() {
		return 'rt-blog';
	}

	public function get_title() {
		return "[RT] ".esc_html_x( 'Blog List', 'Adnin Panel', 'naturalife' );
	}

	public function get_categories() {
		return [ 'rt-elementor-addons' ];
	}

	public function get_icon() {
		return 'eicon-post-list';
	}

	protected function _register_controls() {

		// Content Controls
  		$this->start_controls_section(
  			'RT_blog_carousel_content',
  			[
  				'label' => esc_html_x( 'Blog List','Admin Panel','naturalife' )
  			]
  		); 

		$this->add_control(
			'list_layout',
			[
				'label'     => esc_html_x( 'Layout', 'Admin Panel','naturalife' ),
				'description' => esc_html_x('Column layout for the list"', 'Admin Panel','naturalife' ),	
				'type'      =>  Controls_Manager::SELECT,
				'default'    =>  "1/1",
				"options"    => array(
									"1/1" => "1",
									"1/2" => "2",													
									"1/3" => "3",													
									"1/4" => "4",		 											
									"1/6" => "6",
								),				
			]
		 
		);

 
   		$this->add_control(
			'heading_size',
			[
				'label'     => esc_html_x( 'Heading Size', 'Admin Panel','naturalife' ), 
				'type'      =>  Controls_Manager::SELECT,
				'default'    =>  "h5",
				"options"    => array(
									"h1" => "H1", 
									"h2" => "H2", 
									"h3" => "H3", 
									"h4" => "H4", 
									"h5" => "H5", 
									"h6" => "H6", 
								)							
			]
		 
		); 

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label'     => esc_html_x( 'Heading Typography', 'Admin Panel','naturalife' ), 
				'name' => 'heading_typography',
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .entry-title',
			]
		);		

 		$this->add_control(
			'layout_style',
			[
				'label'     => esc_html_x( 'Layout Style', 'Admin Panel','naturalife' ), 
				'type'      =>  Controls_Manager::SELECT,
				'default'    =>  "",
				"options"    => array(
									"" => esc_html_x( 'Default', 'Admin Panel','naturalife' ),
									"masonry" => esc_html_x( 'Masonry', 'Admin Panel','naturalife' ),
								 
								),								
			]
		 
		); 


 		$this->add_control(
			'box_style',
			[
				'label'     => esc_html_x( 'Box Style', 'Admin Panel','naturalife' ), 
				'type'      =>  Controls_Manager::SELECT,
				'default'    =>  "",
				"options"    => array(
									"" => esc_html_x( 'Default', 'Admin Panel','naturalife' ),
									"boxed" => esc_html_x( 'Boxed', 'Admin Panel','naturalife' ),
								 
								),								
			]
		 
		); 


 		$this->add_control(
				'item_per_page',
				[
					'label'   => esc_html_x( 'Amount of item to display', 'Admin Panel', 'naturalife' ),
					'type'    => Controls_Manager::NUMBER,
					'default' =>  "10"
				]
		);  


		$this->add_control(
			'use_excerpts',
			[
				'label' => esc_html_x("Excerpts", 'Admin Panel','naturalife'),
				"description" => _x("As default the full blog content will be displayed for this list.  Enable this option to minify the content automatically by using WordPress's excerpt option.  You can keep disabled and split your content manually by using <a href=\"http://en.support.wordpress.com/splitting-content/more-tag/\">The More Tag</a>",'Admin Panel','naturalife'),
				'type' => Controls_Manager::SWITCHER,
				'default' => '',
				'label_on' => esc_html_x("ON", 'Admin Panel','naturalife'),
				'label_off' => esc_html_x("OFF", 'Admin Panel','naturalife'),
				'return_value' => 'true',
			]
		); 

 		$this->add_control(
				'excerpt_length',
				[
					'label'   => esc_html_x( 'Excerpt Length', 'Admin Panel', 'naturalife' ),
					"description" => esc_html_x("Customize the excerpt length. Leave blank for the default value.",'Admin Panel','naturalife'),
					'type'    => Controls_Manager::NUMBER,
					'default' =>  "100",
					'condition' => [
										'use_excerpts' => [ "true" ],
									],					
				]
		);  
 
 		$this->add_control(
			'pagination',
			[
				'label' => esc_html_x("Pagination", 'Admin Panel','naturalife'),
				"description" => esc_html_x("Splits the list into pages",'Admin Panel','naturalife'),
				'type' => Controls_Manager::SWITCHER,
				'default' => '',
				'label_on' => esc_html_x("ON", 'Admin Panel','naturalife'),
				'label_off' => esc_html_x("OFF", 'Admin Panel','naturalife'),
				'return_value' => 'true',
			]
		); 

 		$this->add_control(
			'ajax_pagination',
			[
				'label' => esc_html_x("Ajax Pagination", 'Admin Panel','naturalife'),
				"description" => esc_html_x("Works with Masonry layout only",'Admin Panel','naturalife'),
				'type' => Controls_Manager::SWITCHER,
				'default' => '',
				'label_on' => esc_html_x("ON", 'Admin Panel','naturalife'),
				'label_off' => esc_html_x("OFF", 'Admin Panel','naturalife'),
				'return_value' => 'true',
				'condition' => [
									'pagination' => [ "true" ],
								],						
			]
		); 


 		$this->add_control(
			'list_orderby',
			[
				'label'     => esc_html_x( 'List Order By', 'Admin Panel','naturalife' ),
				'description' => esc_html_x('Sorts the posts by this parameter', 'Admin Panel','naturalife' ),	
				'type'      =>  Controls_Manager::SELECT,
				'default'    =>  "date",
				"options"    => array(
									'date' => esc_html_x('Date',"Admin Panel","naturalife"),
									'author' => esc_html_x('Author',"Admin Panel","naturalife"),
									'title' => esc_html_x('Title',"Admin Panel","naturalife"),
									'modified' => esc_html_x('Modified',"Admin Panel","naturalife"),
									'ID' => esc_html_x('ID',"Admin Panel","naturalife"),
									'rand' => esc_html_x('Randomized',"Admin Panel","naturalife"),
								)							
			]
		 
		); 

 		$this->add_control(
			'list_order',
			[
				'label'     => esc_html_x( 'List Order', 'Admin Panel','naturalife' ),
				'description' => esc_html_x('Designates the ascending or descending order of the list_orderby parameter', 'Admin Panel','naturalife' ),	
				'type'      =>  Controls_Manager::SELECT,
				'default'    =>  "DESC",
				"options"    => array(
									"DESC" => esc_html_x('Descending',"Admin Panel","naturalife"),
									"ASC" => esc_html_x('Ascending',"Admin Panel","naturalife"),
								)							
			]
		 
		); 


 		$this->add_control(
			'categories',
			[
				'label'     => esc_html_x( 'Categories', 'Admin Panel','naturalife' ),
				'description' => esc_html_x('Filter the posts by selected categories.', 'Admin Panel','naturalife' ),	
				'type'      =>  Controls_Manager::SELECT2,
				'default'    =>  "",
				'multiple' => true,
				"options"    => rt_get_categories(),					
			]
		 
		); 

		$this->add_control(
			'show_featured_media',
			[
				'label' => esc_html_x("Display Featured Images / Media", 'Admin Panel','naturalife'),
				'type' => Controls_Manager::SWITCHER,
				'default' => "true",
				'label_on' => esc_html_x("ON", 'Admin Panel','naturalife'),
				'label_off' => esc_html_x("OFF", 'Admin Panel','naturalife'),
				'return_value' => 'true',
			]
		); 

		$this->add_control(
			'show_date',
			[
				'label' => esc_html_x("Display Date", 'Admin Panel','naturalife'),
				'type' => Controls_Manager::SWITCHER,
				'default' => "true",
				'label_on' => esc_html_x("ON", 'Admin Panel','naturalife'),
				'label_off' => esc_html_x("OFF", 'Admin Panel','naturalife'),
				'return_value' => 'true',
			]
		); 

		$this->add_control(
			'show_author',
			[
				'label' => esc_html_x("Display Post Author", 'Admin Panel','naturalife'),
				'type' => Controls_Manager::SWITCHER,
				'default' => "true",
				'label_on' => esc_html_x("ON", 'Admin Panel','naturalife'),
				'label_off' => esc_html_x("OFF", 'Admin Panel','naturalife'),
				'return_value' => 'true',
			]
		); 


		$this->add_control(
			'show_categories',
			[
				'label' => esc_html_x("Display Categories", 'Admin Panel','naturalife'),
				'type' => Controls_Manager::SWITCHER,
				'default' => '',
				'label_on' => esc_html_x("ON", 'Admin Panel','naturalife'),
				'label_off' => esc_html_x("OFF", 'Admin Panel','naturalife'),
				'return_value' => 'true',
			]
		); 

		$this->add_control(
			'show_comment_numbers',
			[
				'label' => esc_html_x("Display Comment Numbers", 'Admin Panel','naturalife'),
				'type' => Controls_Manager::SWITCHER,
				'default' => '',
				'label_on' => esc_html_x("ON", 'Admin Panel','naturalife'),
				'label_off' => esc_html_x("OFF", 'Admin Panel','naturalife'),
				'return_value' => 'true',
			]
		); 

		$this->add_control(
			'show_share',
			[
				'label' => esc_html_x("Display Social Share", 'Admin Panel','naturalife'),
				'type' => Controls_Manager::SWITCHER,
				'default' => '',
				'label_on' => esc_html_x("ON", 'Admin Panel','naturalife'),
				'label_off' => esc_html_x("OFF", 'Admin Panel','naturalife'),
				'return_value' => 'true',
			]
		); 
				
		$this->end_controls_section();


		/* Featured Images */
  		$this->start_controls_section(
  			'RT_Featured_Images',
  			[
  				'label' => esc_html_x( 'Featured Images','Admin Panel','naturalife' )
  			]
  		); 


			$this->add_control(
				'featured_image_resize',
				[
					'label' => esc_html_x("Resize Featured Images", 'Admin Panel','naturalife'),
					'type' => Controls_Manager::SWITCHER,
					'desctiption' => esc_html_x( 'Enable the "Image Resize" to resize or crop the featured images automatically. These settings will be overwrite the global settings. Please note, since the theme is reponsive the images cannot be wider than the column they are in. Leave values "0" to use theme defaults.', 'Admin Panel', 'naturalife'),
					'label_on' => esc_html_x("ON", 'Admin Panel','naturalife'),
					'label_off' => esc_html_x("OFF", 'Admin Panel','naturalife'),
					'return_value' => 'true',
				]
			); 

			$this->add_control(
				'featured_image_max_width',
				[
					'label'   => esc_html_x("Image Width", 'Admin Panel','naturalife'),
					'type'    =>  Controls_Manager::NUMBER,
					'condition' => [
										'featured_image_resize' => [ "true" ],
									],
					'default' => 1000,
					'min'     => 10,
					'max'     => 2000, 	
					'description' => esc_html_x('Set a width value for the carousel images. Note: Remember that the images width will be resoponsive. Leave blank for auto width.', 'Admin Panel','naturalife' ),					

				]
			); 

	 		$this->add_control(
				'featured_image_max_height',
				[
					'label'   => esc_html_x("Image Height", 'Admin Panel','naturalife'),
					'type'    =>  Controls_Manager::NUMBER,
					'condition' => [
										'featured_image_resize' => [ "true" ],
									],
					'default' => 1000,
					'min'     => 10,
					'max'     => 2000, 		
					'description' => esc_html_x('Set a height value for the images. Remember that the image heights will be resoponsive. Leave blank for auto height.', 'Admin Panel','naturalife' ),

				]
			); 

			$this->add_control(
				'featured_image_crop',
				[
					'label' => esc_html_x("Crop Images", 'Admin Panel','naturalife'),
					'type' => Controls_Manager::SWITCHER,
					'default' => '',
					'label_on' => esc_html_x("ON", 'Admin Panel','naturalife'),
					'label_off' => esc_html_x("OFF", 'Admin Panel','naturalife'),
					'return_value' => 'true',
					'condition' => [
										'featured_image_resize' => [ "true" ],
									],				
				]
			); 

 	
		$this->end_controls_section();		
	}


	protected function render( ) {

		$settings = $this->get_settings(); 

 
 		if( ! $settings["featured_image_resize"] ){
			$settings["featured_image_max_width"] = "";
			$settings["featured_image_max_height"] = "";
			$settings["featured_image_crop"] = ""; 			
 		}		

		$settings["show_featured_media"] = rtframework_convert_bool( $settings["show_featured_media"] );
		$settings["show_date"] = rtframework_convert_bool( $settings["show_date"] );
		$settings["show_author"] = rtframework_convert_bool( $settings["show_author"] );
		$settings["show_categories"] = rtframework_convert_bool( $settings["show_categories"] );
		$settings["show_comment_numbers"] = rtframework_convert_bool( $settings["show_comment_numbers"] );
		$settings["show_share"] = rtframework_convert_bool( $settings["show_share"] );
		$settings["use_excerpts"] = rtframework_convert_bool( $settings["use_excerpts"] );
		$settings["pagination"] = rtframework_convert_bool( $settings["pagination"] );
		$settings["ajax_pagination"] = rtframework_convert_bool( $settings["ajax_pagination"] );

		rtframework_blog_post_loop( "", $settings );

	}

	protected function content_template() {
	}
}


Plugin::instance()->widgets_manager->register_widget_type( new Widget_RT_Blog() );
