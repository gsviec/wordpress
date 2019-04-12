<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; 

class Widget_RT_Pricing_Table extends Widget_Base {

	public function get_name() {
		return 'rt-pricing-table';
	}

	public function get_title() {
		return "[RT] ".esc_html_x( 'Pricing & Compare Table', 'Adnin Panel', 'naturalife' );
	}

	public function get_categories() {
		return [ 'rt-elementor-addons' ];
	}

	public function get_icon() {
		return 'eicon-price-table';
	}

	protected function _register_controls() {

		// Content Controls
  		$this->start_controls_section(
  			'RT_table_content',
  			[
  				'label' => esc_html_x( 'Pricing & Compare Table','Admin Panel','naturalife' )
  			]
  		); 
  
		$this->add_control(
			'style',
				[	
					'type'    => Controls_Manager::SELECT,
					'label'   => esc_html_x( 'Style', 'Admin Panel', 'naturalife' ),
					'default' => 'service',
					'options' => array( 
									"service" => esc_html_x("Service", 'Admin Panel','naturalife'), 
									"compare" => esc_html_x("Compare", 'Admin Panel','naturalife'),  
								),
			]
		); 


			$this->add_control(
				'columns',
				[
					'label' => esc_html_x( 'Tabs','Admin Panel','naturalife' ),
					'type' => Controls_Manager::REPEATER,
					'default' => [
						[
							'style' => '',
							'caption' => 'BASIC PACKAGE',		
							'info' => 'yearly plan',
							'price' => '<sup>$</sup>19',
							'content' => '	<ul>
											 	<li>[tooltip text="Tooltip Text"]Description With Tooltip[/tooltip]</li>
											 	<li>10 MB Max File Size</li>
											 	<li>2 GHZ CPU</li>
											 	<li>512 MB Memory</li>
											 	<li>[button button_link="#" button_text="BUY NOW" button_size="medium" button_rounded="true" button_style="black"]</li>
											</ul>'
						],
						[
							'style' => 'highlight',
							'caption' => 'PRO PACKAGE',		
							'info' => 'yearly plan',
							'price' => '<sup>$</sup>49',
							'content' => '	<ul>
											 	<li>[tooltip text="Tooltip Text"]Description With Tooltip[/tooltip]</li>
											 	<li>20 MB Max File Size</li>
											 	<li>2 GHZ CPU</li>
											 	<li>512 MB Memory</li>
											 	<li>[button button_link="#" button_text="BUY NOW" button_size="medium" button_rounded="true" button_style="style-1"]</li>
											</ul>'
						],
						[
							'style' => '',
							'caption' => 'DEVELOPER PACKAGE',		
							'info' => 'yearly plan',
							'price' => '<sup>$</sup>109',
							'content' => '	<ul>
											 	<li>[tooltip text="Tooltip Text"]Description With Tooltip[/tooltip]</li>
											 	<li>200 MB Max File Size</li>
											 	<li>2 GHZ CPU</li>
											 	<li>512 MB Memory</li>
											 	<li>[button button_link="#" button_text="BUY NOW" button_size="medium" button_rounded="true" button_style="black"]</li>
											</ul>'
						],												
					],							
					'fields' => [
						[
							'name' => 'style',
							'label' => esc_html_x( 'Style', 'Admin Panel', 'naturalife' ),
							'type' => Controls_Manager::SELECT, 
							'default' => '',
							'options' => array( 
											"" => esc_html_x("Regular column", 'Admin Panel','naturalife'), 
											"features" => esc_html_x("Features column for compare tables", 'Admin Panel','naturalife'),  
											"highlight" => esc_html_x("Highlighted column", 'Admin Panel','naturalife'),  
										),
						],
						[
							'name' => 'caption',
							'label' => esc_html_x( 'Column caption', 'Admin Panel', 'naturalife' ),
							'type' => Controls_Manager::TEXT,
							'default' => esc_html_x( 'Column caption', 'Admin Panel', 'naturalife' ),
							'placeholder' => esc_html_x( 'Column caption', 'Admin Panel', 'naturalife' ),
							'label_block' => true,
							'condition' => [
												'style' => [ "","highlight" ],
											],
						],
						[
							'name' => 'info',
							'label' => esc_html_x( 'Info', 'Admin Panel', 'naturalife' ),
							'type' => Controls_Manager::TEXT,
							'default' => esc_html_x( 'Info', 'Admin Panel', 'naturalife' ),
							'placeholder' => esc_html_x( 'Info', 'Admin Panel', 'naturalife' ),
							'label_block' => true,
							'condition' => [
												'style' => [ "","highlight" ],
											],
						],

						[
							'name' => 'price',
							'label' => esc_html_x( 'Price', 'Admin Panel', 'naturalife' ),
							'type' => Controls_Manager::TEXT,
							'default' => esc_html_x( 'Price', 'Admin Panel', 'naturalife' ),
							'placeholder' => esc_html_x( 'Price', 'Admin Panel', 'naturalife' ),
							'label_block' => true,
							'condition' => [
												'style' => [ "","highlight" ],
											],
						],
						[
							'name' => 'content',
							'label' => esc_html_x( 'Content', 'Admin Panel', 'naturalife' ), 
							'type' => Controls_Manager::WYSIWYG,
							'default'       => '<ul>
												 	<li>[tooltip text="Tooltip Text"]Description With Tooltip[/tooltip]</li>
												 	<li>20 MB Max File Size</li>
												 	<li>2 GHZ CPU</li>
												 	<li>512 MB Memory</li>
												 	<li>[button button_link="#" button_text="BUY NOW" button_size="medium" button_rounded="true" button_style="style-1"]</li>
												</ul>',
							'show_label' => false,
						]
					],
					'title_field' => '{{{ caption }}}',
				]
		);

		$this->end_controls_section();  
	}

	protected function render( ) {

			$settings = $this->get_settings(); 

  			$columns = "";

			foreach ( $settings["columns"] as $column ) {
				$columns .= rt_table_columns($column, $column["content"]);
			}

			echo rt_table_holder( $settings, $columns );
	}

	protected function content_template() {
	}
}


Plugin::instance()->widgets_manager->register_widget_type( new Widget_RT_Pricing_Table() );
