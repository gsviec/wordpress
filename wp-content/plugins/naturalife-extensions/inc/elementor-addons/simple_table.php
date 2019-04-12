<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; 

class Widget_RT_Simple_Table extends Widget_Base {

	public function get_name() {
		return 'rt-simple-table';
	}

	public function get_title() {
		return "[RT] ".esc_html_x( 'Simple Table', 'Adnin Panel', 'naturalife' );
	}

	public function get_categories() {
		return [ 'rt-elementor-addons' ];
	}

	public function get_icon() {
		return 'eicon-table';
	}

	protected function _register_controls() {

		// Content Controls
		$this->start_controls_section(
			'RT_table_content',
			[
				'label' => esc_html_x( 'Simple Table','Admin Panel','naturalife' )
			]
		); 
  
		$this->add_control(
			'style',
				[	
					'type'    => Controls_Manager::SELECT,
					'label'   => esc_html_x( 'Style', 'Admin Panel', 'naturalife' ),
					'default' => 'service',
					'options' => array( 
									"table-clean" => esc_html_x("Clean", 'Admin Panel','naturalife'), 
									"table-bordered" => esc_html_x("Bordered", 'Admin Panel','naturalife'), 
									"table-striped" => esc_html_x("Striped", 'Admin Panel','naturalife'),  
								),
			]
		); 

		$this->add_control(
				'first_col_width',
				[
					'label' => esc_html_x( 'First Column Width (%)', 'Admin Panel', 'naturalife' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
					    '%' => [
					        'min' => 0,
					        'max' => 100,
					        'step' => 5,
					    ]
					],			
					'size_units' => [ '%'],
					'selectors' => [
						'{{WRAPPER}} tr > td:first-child' => 'width: {{SIZE}}%',
					],
				]
		);  

		$this->add_responsive_control(
			'col_1_align',
			[
				'label' => esc_html_x( 'Column 1 Alignment', 'Admin Panel', 'naturalife' ),
				'type' => Controls_Manager::CHOOSE,
				'selectors' => [
					'{{WRAPPER}} td:first-child' => 'text-align: {{VALUE}};',
				],						
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
			'col_2_align',
			[
				'label' => esc_html_x( 'Column 2 Alignment', 'Admin Panel', 'naturalife' ),
				'type' => Controls_Manager::CHOOSE,
				'selectors' => [
					'{{WRAPPER}} td:nth-child(2)' => 'text-align: {{VALUE}};',
				],				
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
					]
				]
			]
		);

		$this->add_responsive_control(
			'rt_heading_padding',
			[
				'label' => esc_html_x( 'Column Paddings', 'Admin Panel', 'naturalife' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} td' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);


			$this->add_control(
				'rows',
				[
					'label' => esc_html_x( 'Columns','Admin Panel','naturalife' ),
					'type' => Controls_Manager::REPEATER,
					'fields' => [
						[
							'name' => 'col_1',
							'label' => esc_html_x( 'Column 1', 'Admin Panel', 'naturalife' ),
							'type' => Controls_Manager::TEXTAREA,
							'default' => esc_html_x( 'Column 1', 'Admin Panel', 'naturalife' ),							
							'label_block' => true
						],
						[
							'name' => 'col_2',
							'label' => esc_html_x( 'Column 2', 'Admin Panel', 'naturalife' ),
							'type' => Controls_Manager::TEXTAREA,
							'default' => esc_html_x( 'Price', 'Admin Panel', 'naturalife' ),
							'default' => esc_html_x( 'Column 2', 'Admin Panel', 'naturalife' ),							
							'label_block' => true
						],
						[
							'name' => 'heading_row',
							'label' => esc_html_x( 'Heading Row?', 'Admin Panel', 'naturalife' ),
							'type' => Controls_Manager::SWITCHER, 
							'label_on' => esc_html_x("ON", 'Admin Panel','naturalife'),
							'label_off' => esc_html_x("OFF", 'Admin Panel','naturalife'),
							'return_value' => 'true'
						]						 
					],
					'title_field' => '{{{ col_1 }}}',
				]
		);

		$this->end_controls_section();  
	}

	protected function render( ) {

			$settings = $this->get_settings(); 
			$tbody = $thead = "";
			foreach ( $settings["rows"] as $row ) {

				if( $row["heading_row"] ){
					$thead .= sprintf(' 
							<tr>
								<td scope="row">%1$s</td>
								<td>%2$s</td>
							</tr>
							',
							$row["col_1"],
							$row["col_2"] 
						);					
				}else{
					$tbody .= sprintf(' 
							<tr>
								<td scope="row">%1$s</td>
								<td>%2$s</td>
							</tr>  
							',
							$row["col_1"],
							$row["col_2"] 
						);					
				}
			}

			$thead = ! empty( $thead ) ? sprintf('<thead>%s</thead>',$thead) : "";
			$tbody = ! empty( $tbody ) ? sprintf('<tbody>%s</tbody>',$tbody) : "";

			printf('
			<table class="table rt-simple-table %3$s">
				%1$s  
				%2$s 
			</table>
			',
			$thead,
			$tbody,
			$settings["style"]
			);

	}

	protected function content_template() {
	}
}

Plugin::instance()->widgets_manager->register_widget_type( new Widget_RT_Simple_Table() );
