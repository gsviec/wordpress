<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; 

class Widget_RT_Timeline extends Widget_Base {

	public function get_name() {
		return 'rt-timeline';
	}

	public function get_title() {
		return "[RT] ".esc_html_x( 'Timeline', 'Adnin Panel', 'naturalife' );
	}

	public function get_categories() {
		return [ 'rt-elementor-addons' ];
	}

	public function get_icon() {
		return 'eicon-time-line';
	}

	protected function _register_controls() {

		// Content Controls
  		$this->start_controls_section(
  			'RT_tab_content',
  			[
  				'label' => esc_html_x( 'Tabs','Admin Panel','naturalife' )
  			]
  		); 
  
		$this->add_control(
			'style',
				[	
					'type'    => Controls_Manager::SELECT,
					'label'   => esc_html_x( 'Style', 'Admin Panel', 'naturalife' ),
					'default' => 'style-1',
					'options' => array( 
									"style-1" => esc_html_x("Chained Timeline", 'Admin Panel','naturalife'), 
									"style-2" => esc_html_x("List", 'Admin Panel','naturalife'),  
								),
			]
		); 


			$this->add_control(
				'events',
				[
					'label' => esc_html_x( 'Tabs','Admin Panel','naturalife' ),
					'type' => Controls_Manager::REPEATER,
					'fields' => [
						[
							'name' => 'title',
							'label' => esc_html_x( 'Title', 'Admin Panel', 'naturalife' ),
							'type' => Controls_Manager::TEXT,
							'default' => esc_html_x( 'Title', 'Admin Panel', 'naturalife' ),
							'placeholder' => esc_html_x( 'Title', 'Admin Panel', 'naturalife' ),
							'label_block' => true,
						],
						[
							'name' => 'content',
							'label' => esc_html_x( 'Content', 'Admin Panel', 'naturalife' ), 
							'type' => Controls_Manager::WYSIWYG,
							"default" => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
							'show_label' => false,
						],
						[
							'name' => 'day',
							'label' => esc_html_x( 'Event Day', 'Admin Panel', 'naturalife' ),
							'type' => Controls_Manager::TEXT,
							'placeholder' => esc_html_x( 'Event Day', 'Admin Panel', 'naturalife' ),
							'label_block' => true,
						],
						[
							'name' => 'month',
							'label' => esc_html_x( 'Event Month', 'Admin Panel', 'naturalife' ),
							'type' => Controls_Manager::TEXT,
							'placeholder' => esc_html_x( 'Event Month', 'Admin Panel', 'naturalife' ),
							'label_block' => true,
						],
						[
							'name' => 'year',
							'label' => esc_html_x( 'Event Year', 'Admin Panel', 'naturalife' ),
							'type' => Controls_Manager::TEXT,
							'placeholder' => esc_html_x( 'Event Year', 'Admin Panel', 'naturalife' ),
							'label_block' => true,
						],
					],
					'title_field' => '{{{ title }}}',
				]
		);

		$this->end_controls_section();  
	}

	protected function render( ) {

			$settings = $this->get_settings(); 

  			$events = "";

			foreach ( $settings["events"] as $event ) {
				$events .= rt_tl_event($event, $event["content"]);
			}

			echo rt_timeline( $settings, $events );
	}

	protected function content_template() {
	}
}


Plugin::instance()->widgets_manager->register_widget_type( new Widget_RT_Timeline() );
