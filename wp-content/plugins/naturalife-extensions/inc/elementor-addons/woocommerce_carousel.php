<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; 

class Widget_RT_WooCommerce_Carousel extends Widget_Base {

	public function get_name() {
		return 'rt-woocommerce-carousel';
	}

	public function get_title() {
		return "[RT] ".esc_html_x( 'WooCommerce Carousel', 'Adnin Panel', 'naturalife' );
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
  			'RT_woocommerce_carousel_content',
  			[
  				'label' => esc_html_x( 'WooCommerce Carousel','Admin Panel','naturalife' )
  			]
  		); 

		$this->add_control(
			'list_layout',
			[
				'label'     => esc_html_x( 'Carousel Layout', 'Admin Panel','naturalife' ),
				'description' => esc_html_x('Visible item count for each slide on desktop screens.', 'Admin Panel','naturalife' ),	
				'type'      =>  Controls_Manager::SELECT,
				'default'    =>  "1/4",
				"options"    => array(
									"1/1" => "1",
									"1/2" => "2",													
									"1/3" => "3",													
									"1/4" => "4",													
									"1/5" => "5",													
									"1/6" => "6",
								),				
			]
		 
		);

		$this->add_control(
			'tablet_layout',
			[
				'label'     => esc_html_x( 'Carousel Layout (Tablet)', 'Admin Panel','naturalife' ),
				'description' => esc_html_x('Visible item count for each slide on medium screens', 'Admin Panel','naturalife' ),	
				'type'      =>  Controls_Manager::SELECT,
				'default'    =>  "",
				"options"    => array(
									"" => esc_html_x( 'Default', 'Admin Panel','naturalife' ),
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
			'mobile_layout',
			[
				'label'     => esc_html_x( 'Carousel Layout (Mobile)', 'Admin Panel','naturalife' ),
				'description' => esc_html_x('Visible item count for each slide on small screens', 'Admin Panel','naturalife' ),	
				'type'      =>  Controls_Manager::SELECT,
				'default'    =>  "",
				"options"    => array(
									"" => esc_html_x( 'Default', 'Admin Panel','naturalife' ),
									"1" => "1",
									"2" => "2",													
									"3" => "3",													
									"4" => "4",		 	 
								),				
			]
		 
		);

 		$this->add_control(
			'box_style',
			[
				'label'     => esc_html_x( 'Box Style', 'Admin Panel','naturalife' ), 
				'type'      =>  Controls_Manager::SELECT,
				'default'    =>  "style-1",
				"options"    => array(
									"" => esc_html_x( 'Default', 'Admin Panel','naturalife' ),
									"boxed" => esc_html_x( 'Boxed', 'Admin Panel','naturalife' ),
								 
								)								
			]
		 
		); 

 
 		$this->add_control(
				'max_item',
				[
					'label'   => esc_html_x( 'Amount of item to display', 'Admin Panel', 'naturalife' ),
					'type'    => Controls_Manager::NUMBER,
					'default' =>  "10"
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
				"options"    => rt_get_woocommerce_categories(),					
			]
		 
		); 
 
				
		$this->end_controls_section();


		/* Carousel Settings */
  		$this->start_controls_section(
  			'RT_Carousel_settings',
  			[
  				'label' => esc_html_x( 'Carousel Settings','Admin Panel','naturalife' )
  			]
  		); 

			$this->add_control(
				'dots',
				[
					'label' => esc_html_x("Navigation Dots", 'Admin Panel','naturalife'),
					'type' => Controls_Manager::SWITCHER,
					'default' => 'true',
					'label_on' => esc_html_x("ON", 'Admin Panel','naturalife'),
					'label_off' => esc_html_x("OFF", 'Admin Panel','naturalife'),
					'return_value' => 'true',
				]
			); 

			$this->add_control(
				'nav',
				[
					'label' => esc_html_x("Navigation Arrows", 'Admin Panel','naturalife'),
					'type' => Controls_Manager::SWITCHER,
					'default' => '',
					'label_on' => esc_html_x("ON", 'Admin Panel','naturalife'),
					'label_off' => esc_html_x("OFF", 'Admin Panel','naturalife'),
					'return_value' => 'true',
				]
			); 

			$this->add_control(
				'autoplay',
				[
					'label' => esc_html_x("Autoplay", 'Admin Panel','naturalife'),
					'type' => Controls_Manager::SWITCHER,
					'description' => esc_html_x('Start sliding automatically', 'Admin Panel','naturalife' ),
					'label_on' => esc_html_x("ON", 'Admin Panel','naturalife'),
					'label_off' => esc_html_x("OFF", 'Admin Panel','naturalife'),
					'return_value' => 'true',
				]
			); 

			$this->add_control(
				'loop',
				[
					'label' => esc_html_x("Loop", 'Admin Panel','naturalife'),
					'type' => Controls_Manager::SWITCHER,
					'default' => '',
					'label_on' => esc_html_x("ON", 'Admin Panel','naturalife'),
					'label_off' => esc_html_x("OFF", 'Admin Panel','naturalife'),
					'return_value' => 'true',
				]
			); 

			$this->add_control(
					'margin',
					[
						'label' => esc_html_x( 'Item Margin (px)', 'Admin Panel', 'naturalife' ),
						'description' => esc_html_x('Set a value for the margin between carousel items. Default is 15px', 'Admin Panel','naturalife' ),
						'type' => Controls_Manager::NUMBER,
						'default' => 15,
						'min' => 0,
						'max' => 200,  
					]
			);  

			$this->add_control(
					'padding',
					[
						'label' => esc_html_x( 'Stage Padding (px)', 'Admin Panel', 'naturalife' ),
						'description' => esc_html_x('Set a value for the padding of the carousel stage. This will cut first and last visible items', 'Admin Panel','naturalife' ),
						'type' => Controls_Manager::NUMBER,
						'min' => 0,
						'max' => 200,  
					]
			);    

 	
		$this->end_controls_section();		
	}


	protected function render( ) {

		$settings = $this->get_settings(); 

		extract($settings); 


		//create a post status array
		$post_status = is_user_logged_in() ? array( 'private', 'publish' ) : "publish";

		//general query
		$args = array( 
			'post_status'    =>	$post_status,
			'post_type'      =>	'product',
			'orderby'        =>	$list_orderby,
			'order'          =>	$list_order,
			'showposts' 	 =>	$max_item,					
		);
 
		if( ! empty ( $categories ) ){
			
			$categories = is_array( $categories ) ? $categories : explode(",", rtframework_wpml_lang_object_ids( $categories, "product_cat",$wpml_lang ) ); 	

			$args = array_merge($args, array( 

				'tax_query' => array(
						array(
							'taxonomy' =>	'product_cat',
							'field'    =>	'id',
							'terms'    =>	$categories,
							'operator' => 	"IN"
						)
					),
			) );
		} 

		$wp_query  = new \WP_Query($args); 

 		//column class
 		$add_column_class = "item product "; 


		if ( $wp_query->have_posts() ){ 
			
			$output = array();

			//the loop
			while ( $wp_query->have_posts() ) : $wp_query->the_post();

				//selected term list of each post
				$term_list = get_the_terms($wp_query->post->ID, 'product_cat');
				
				//add terms as class name
				$addTermsClass = "";
				if($term_list){
					if(is_array($term_list)){
						foreach ($term_list as $termSlug) {
							$addTermsClass .= " ". $termSlug->slug;
						}
					}
				}

				ob_start();

				?>
					<div <?php post_class("item product"); ?>>
						<?php
						/**
						 * woocommerce_before_shop_loop_item hook.
						 *
						 * @hooked woocommerce_template_loop_product_link_open - 10
						 */
						do_action( 'woocommerce_before_shop_loop_item' );

						/**
						 * woocommerce_before_shop_loop_item_title hook.
						 *
						 * @hooked woocommerce_show_product_loop_sale_flash - 10
						 * @hooked woocommerce_template_loop_product_thumbnail - 10
						 */
						do_action( 'woocommerce_before_shop_loop_item_title' );

						/**
						 * woocommerce_shop_loop_item_title hook.
						 *
						 * @hooked woocommerce_template_loop_product_title - 10
						 */
						do_action( 'woocommerce_shop_loop_item_title' );

						/**
						 * woocommerce_after_shop_loop_item_title hook.
						 *
						 * @hooked woocommerce_template_loop_rating - 5
						 * @hooked woocommerce_template_loop_price - 10
						 */
						do_action( 'woocommerce_after_shop_loop_item_title' );

						/**
						 * woocommerce_after_shop_loop_item hook.
						 *
						 * @hooked woocommerce_template_loop_product_link_close - 5
						 * @hooked woocommerce_template_loop_add_to_cart - 10
						 */
						do_action( 'woocommerce_after_shop_loop_item' );
						?>
					</div>

				<?php
				$output[] .=  ob_get_contents();
				ob_end_clean();
		 
			endwhile;  
 
			//reset post data for the new query
			wp_reset_postdata(); 	

			//column count
			$item_width = rtframework_column_count( $list_layout );

			//carousel atts
			$atts = array(  
				"id"                => 'WC-Carousel-dynamicID-'.rand(100000, 1000000), 
				"item_width"        => $item_width, 
				"mobile_item_width" => $mobile_layout, 
				"tablet_item_width" => $tablet_layout, 	
				"class"             => "woocommerce-carousel products",
				"nav"               => $nav,
				"dots"              => $dots,
				"autoplay"          => $autoplay,
				"timeout"           => 5000,
				"margin"            => intval($margin),
				"padding"           => intval($padding),
				"loop"              => $loop,
				"boxed"             => ! empty( $box_style ) ? "true" : ""
			);

			//create carousel 
			$output = rtframework_create_carousel( $output, $atts ); 

			?>


			<div class="woocommerce">
				<?php echo $output; ?>
			</div>

			<?php 
		}

	}

	protected function content_template() {
	}
}


Plugin::instance()->widgets_manager->register_widget_type( new Widget_RT_WooCommerce_Carousel() );
