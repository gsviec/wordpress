<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; 

class Widget_RT_WC_Categories extends Widget_Base {

	public function get_name() {
		return 'rt-woocommerce-categories';
	}

	public function get_title() {
		return "[RT] ".esc_html_x( 'WooCommerce Categories', 'Adnin Panel', 'naturalife' );
	}

	public function get_categories() {
		return [ 'rt-elementor-addons' ];
	}

	public function get_icon() {
		return 'eicon-woocommerce';
	}

	protected function _register_controls() {

		// Content Controls
  		$this->start_controls_section(
  			'RT_wc_content',
  			[
  				'label' => esc_html_x( 'WooCommerce Categories','Admin Panel','naturalife' )
  			]
  		); 

 
 		$this->add_control(
			'cat_ids',
			[
				'label'       => esc_html_x( 'Categories', 'Admin Panel','naturalife' ),
				'type'        =>  Controls_Manager::SELECT2,
				'default'     =>  "",
				'multiple'    => true,
				"options"     => rt_get_woo_product_categories(),							
			]
		);  

		$this->add_control(
			'columns',
			[
				'label'     => esc_html_x( 'Layout', 'Admin Panel','naturalife' ),
				'description' => esc_html_x('Column layout for the list', 'Admin Panel','naturalife' ),	
				'type'      =>  Controls_Manager::SELECT,
				'default'    =>  "4",
				"options"    => array(
									"1" => "1",
									"2" => "2",													
									"3" => "3",													
									"4" => "4",													
									"5" => "5",													
									"6" => "6",
								),				
			]
		 
		);
 
  		$this->add_control(
			'orderby',
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
			'order',
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

 	
		$this->end_controls_section();		
	}


	protected function render( ) {

		$settings = $this->get_settings(); 
	  
 		$ids = is_array(  $settings["cat_ids"] ) && ! empty( $settings["cat_ids"] ) ? implode(",", $settings["cat_ids"]) : ""; 
		$shortcode = sprintf('[product_categories columns="%s" ids="%s" orderby="%s" order="%s"]',   $settings["columns"], $ids, $settings["orderby"], $settings["order"]);
		echo do_shortcode($shortcode);

	}

	protected function content_template() {
	}
}


Plugin::instance()->widgets_manager->register_widget_type( new Widget_RT_WC_Categories() );
