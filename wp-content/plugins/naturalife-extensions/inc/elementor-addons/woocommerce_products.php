<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; 

class Widget_RT_WC_Products extends Widget_Base {

	public function get_name() {
		return 'rt-woocommerce-products';
	}

	public function get_title() {
		return "[RT] ".esc_html_x( 'WooCommerce Products', 'Adnin Panel', 'naturalife' );
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
  				'label' => esc_html_x( 'WooCommerce Products','Admin Panel','naturalife' )
  			]
  		); 

		$this->add_control(
			'filter',
			[
				'label'     => esc_html_x( 'List Type', 'Admin Panel','naturalife' ),
				'type'      =>  Controls_Manager::SELECT,
				'default'    =>  "recent_products",
				"options"    => array(
									"recent_products" =>  esc_html_x( 'Recent Products', 'Admin Panel','naturalife' ),
									"featured_products" =>  esc_html_x( 'Featured Products', 'Admin Panel','naturalife' ),
									"sale_products" =>  esc_html_x( 'Sale Products', 'Admin Panel','naturalife' ),
									"best_selling_products" =>  esc_html_x( 'Best-Selling Products', 'Admin Panel','naturalife' ),
									"top_rated_products" =>  esc_html_x( 'Top Rated Products', 'Admin Panel','naturalife' ),
								),				
			]
		 
		);


 		$this->add_control(
			'cat_slugs',
			[
				'label'     => esc_html_x( 'Categories', 'Admin Panel','naturalife' ),
				'description' => esc_html_x('Filter the posts by selected categories.', 'Admin Panel','naturalife' ),	
				'type'      =>  Controls_Manager::SELECT2,
				'default'    =>  "",
				'multiple' => true,
				"options"    => rt_get_woo_product_categories_slugs(),					
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

 		$this->add_control(
			'per_page',
			[
				'label'   => esc_html_x("Products Count", 'Admin Panel','naturalife'),
				'type'    =>  Controls_Manager::NUMBER, 
				'default' => 8,
				'min'     => 1,
				'max'     => 200, 		 
			]
		); 
 	
		$this->end_controls_section();		
	}

	protected function render( ) {
		$settings = $this->get_settings(); 
 		$categories = is_array(  $settings["cat_slugs"] ) && ! empty( $settings["cat_slugs"] ) ? implode(",", $settings["cat_slugs"]) : "";
		$shortcode = sprintf('[%s columns="%s" category="%s" orderby="%s" order="%s" per_page="%s"]', $settings["filter"], $settings["columns"], $categories, $settings["orderby"], $settings["order"], $settings["per_page"]);
		echo do_shortcode($shortcode);
	}

	protected function content_template() {
	}
}


Plugin::instance()->widgets_manager->register_widget_type( new Widget_RT_WC_Products() );
