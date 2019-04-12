<?php
/**
 * RT-Theme Custom Posts
 * 
 * Create custom posts
 *
 * @author 	RT-Themes
 * @since   1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'RT_Custom_Posts' ) ) {

	/**
	 * RT_Custom_Posts Class
	 */
	class RT_Custom_Posts{

		/**
		 * Default Slug Names
		 */
		public $default_portfolio_slug; 
		public $default_portfolio_categories_slug;
		public $default_testimonial_categories_slug;
		public $default_team_slug; 

		/**
		 * Construct
		 */
		public function __construct() {

			add_action( 'init', array(&$this,'testimonials'), 2);
			add_action( 'init', array(&$this,'portfolio'), 2);
			add_action( 'init', array(&$this,'team'), 2);


			add_action( 'init', array(&$this,'is_portfolio_active'), 2);
			add_action( 'init', array(&$this,'is_team_active'), 2); 
			add_action( 'init', array(&$this,'is_testimonials_active'), 2);


			if( is_admin()){

				add_filter('admin_init', array(&$this,'permalink_settings'), 10); 	
				add_filter('admin_init', array(&$this,'save_permalink_settings'), 10); 	

				add_filter('manage_portfolio_posts_columns', array(&$this,'ui_columns_head'), 10); 	
				add_filter('manage_staff_posts_columns', array(&$this,'ui_columns_head'), 10); 	 
				add_filter('manage_testimonial_posts_columns', array(&$this,'ui_columns_head'), 10); 	 

				add_action('manage_portfolio_posts_custom_column', array(&$this,'ui_columns_content'), 10, 2);
				add_action('manage_staff_posts_custom_column', array(&$this,'ui_columns_content'), 10, 2);
				add_action('manage_testimonial_posts_custom_column', array(&$this,'ui_columns_content'), 10, 2);


				add_filter( 'get_user_option_meta-box-order_portfolio', array(&$this,'metabox_order'), 10, 2);

			}


		}


		/**
		 * Order single portfolio metaboxes
		 */
		function metabox_order( $order ) {

		return array(
			'normal' => join( 
				",", 
					array(       // vvv  Arrange here as you desire
						'wpb_visual_composer',
						'portfolio_project_details',		
						'portfolio_custom_fields',										
						'rt_design_custom_fields',

					)
				),
			);
		}

		/**
		 * Portfolio
		 */
		function portfolio(){
 
			if( ! $this->is_portfolio_active() ){
				return ;
			}

			// Default Slug Names			
			$this->default_portfolio_slug              = _x( "portfolio", 'URL slug', 'naturalife' );  // singular portfolio item
			$this->default_portfolio_categories_slug   = _x( "portfolio-category", 'URL slug', 'naturalife' );		// portfolio categories 			

			// Slug Names			
			$portfolio_slug              = get_option(RT_EXTENSIONS_SLUG."_portfolio_single_slug"); 		// singular portfolio item
			$portfolio_categories_slug   = get_option(RT_EXTENSIONS_SLUG."_portfolio_category_slug");		// portfolio categories 
			

			//Labels
			$labels = array(
				'name'               => _x('Portfolio', 'Admin Panel','naturalife'),
				'singular_name'      => _x('Portfolio', 'Admin Panel','naturalife'),
				'add_new'            => _x('Add New', 'Admin Panel','naturalife'),
				'add_new_item'       => _x('Add New Portfolio Item', 'Admin Panel','naturalife'),
				'edit_item'          => _x('Edit Portfolio Item', 'Admin Panel','naturalife'),
				'new_item'           => _x('New Portfolio Item', 'Admin Panel','naturalife'),
				'view_item'          => _x('View Portfolio Item', 'Admin Panel','naturalife'),
				'search_items'       => _x('Search Portfolio Item', 'Admin Panel','naturalife'),
				'not_found'          => _x('No portfolio item found', 'Admin Panel','naturalife'),
				'not_found_in_trash' => _x('No portfolio item found in Trash', 'Admin Panel','naturalife'), 
				'parent_item_colon'  => ''
			);
			
			//Args
			$args = array(
				'labels'              => $labels,
				'public'              => true,
				'publicly_queryable'  => true,
				'exclude_from_search' => false,
				'show_ui'             => true, 
				'query_var'           => true,
				'can_export'          => true,
				'show_in_nav_menus'   => true,		
				'capability_type'     => 'post',
				'hierarchical'        => false, 
				'menu_position'       => null, 
				'rewrite'             => array( 'slug' => ! empty($portfolio_slug) ? $portfolio_slug : $this->default_portfolio_slug, 'with_front' => true, 'pages' => true, 'feeds'=>false ), 
				'menu_icon'           => "dashicons-portfolio",
				'supports'            => array('title','editor','author','comments','thumbnail','revisions',"excerpt")
			);
			
			register_post_type('portfolio',$args);
			
			// Portfolio Categories
			$labels = array(
				'name'              => _x( 'Portfolio Categories', 'Admin Panel','naturalife'),
				'singular_name'     => _x( 'Portfolio Category', 'Admin Panel','naturalife'),
				'search_items'      => _x( 'Search Portfolio Category', 'Admin Panel','naturalife'),
				'all_items'         => _x( 'All Portfolio Categories', 'Admin Panel','naturalife'),
				'parent_item'       => _x( 'Parent Portfolio Category', 'Admin Panel','naturalife'),
				'parent_item_colon' => _x( 'Parent Portfolio Category:', 'Admin Panel','naturalife'),
				'edit_item'         => _x( 'Edit Portfolio Category', 'Admin Panel','naturalife'), 
				'update_item'       => _x( 'Update Portfolio Category', 'Admin Panel','naturalife'),
				'add_new_item'      => _x( 'Add New Portfolio Category', 'Admin Panel','naturalife'),
				'new_item_name'     => _x( 'New Portfolio Category', 'Admin Panel','naturalife'),
			); 	
			
			register_taxonomy('portfolio_categories',array('portfolio'), array(
				'hierarchical'      => true,
				'labels'            => $labels,
				'show_ui'           => true,
				'query_var'         => false,
				'show_admin_column' => true,
				'_builtin'          => false,
				'paged'             => true,
				'rewrite'           => array('slug'=> ! empty($portfolio_categories_slug) ? $portfolio_categories_slug : $this->default_portfolio_categories_slug ,'with_front'=>false),
			));
		}	

		/**
		 * Team
		 */
		function team(){

			if( ! $this->is_team_active() ){
				return ;
			}

			// Default Slug Names			
			$this->default_team_slug  = _x( "team", 'URL slug', 'naturalife' );  

			// Slug Names			
			$team_slug              = get_option(RT_EXTENSIONS_SLUG."_team_single_slug"); 

			//Labels
			$labels = array(
				'menu_name'          => _x('Team', 'Admin Panel','naturalife'),
				'name'               => _x('Team', 'Admin Panel','naturalife'),
				'singular_name'      => _x('Team', 'Admin Panel','naturalife'),
				'add_new'            => _x('Add New Member', 'Admin Panel','naturalife'),
				'add_new_item'       => _x('Add New Member', 'Admin Panel','naturalife'),
				'edit_item'          => _x('Edit Member', 'Admin Panel','naturalife'),
				'new_item'           => _x('New Member', 'Admin Panel','naturalife'),
				'view_item'          => _x('View Member', 'Admin Panel','naturalife'),
				'search_items'       => _x('Search for Member', 'Admin Panel','naturalife'),
				'not_found'          => _x('No member found', 'Admin Panel','naturalife'),
				'not_found_in_trash' => _x('No member found in Trash', 'Admin Panel','naturalife'), 
				'parent_item_colon'  => ''
			);
			
			//Args
			$args = array(
				'labels'              => $labels,
				'public'              => true,
				'publicly_queryable'  => true,
				'exclude_from_search' => false,
				'show_ui'             => true, 
				'query_var'           => false,
				'can_export'          => true,
				'show_in_nav_menus'   => false,		
				'capability_type'     => 'post',
				'menu_position'       => null, 
				'rewrite'             => array( 'slug' => ! empty($team_slug) ? $team_slug : $this->default_team_slug, 'with_front' => true, 'pages' => true, 'feeds'=>false ), 
				'menu_icon'           => "dashicons-groups",
				'supports'            => array('title','editor','thumbnail','revisions')
			);
			
			register_post_type('staff',$args);
		 
		}	 			

		/**
		 * Testimonials
		 */
		function testimonials(){

			if( ! $this->is_testimonials_active() ){
				return ;
			}

			// Default Slug Names			
			$this->default_testimonial_categories_slug   = _x( "testimonials", 'Admin Panel','naturalife' );		// testimonial categories 			

			// Slug Names			
			$testimonial_categories_slug   = get_option(RT_EXTENSIONS_SLUG."_testimonial_category_slug");		// testimonial categories 
			

			//Labels
			$labels = array(
				'menu_name'          => _x('Testimonials', 'Admin Panel','naturalife'),
				'name'               => _x('Testimonials', 'Admin Panel','naturalife'),
				'singular_name'      => _x('Testimonial', 'Admin Panel','naturalife'),
				'add_new'            => _x('Add New', 'Admin Panel','naturalife'),
				'add_new_item'       => _x('Add New Testimonial', 'Admin Panel','naturalife'),
				'edit_item'          => _x('Edit Testimonial', 'Admin Panel','naturalife'),
				'new_item'           => _x('New Testimonial', 'Admin Panel','naturalife'),
				'view_item'          => _x('View Testimonial', 'Admin Panel','naturalife'),
				'search_items'       => _x('Search Testimonial', 'Admin Panel','naturalife'),
				'not_found'          => _x('No testimonial found', 'Admin Panel','naturalife'),
				'not_found_in_trash' => _x('No testimonial found in Trash', 'Admin Panel','naturalife'), 
				'parent_item_colon'  => ''
			);
			
			//Args
			$args = array(
				'labels'              => $labels,
				'public'              => false,
				'publicly_queryable'  => true,
				'exclude_from_search' => true,
				'show_ui'             => true, 
				'query_var'           => true,
				'can_export'          => true,
				'hierarchical'        => false,
				'show_in_nav_menus'   => false,		
				'capability_type'     => 'post',
				'menu_position'       => null, 
				'menu_icon'           => "dashicons-format-quote",
				'supports'            => array('title','thumbnail','revisions')
			);


			register_post_type('testimonial',$args);	 


			// Testimonial Categories
			$labels = array(
				'name'              => _x( 'Testimonial Categories', 'Admin Panel','naturalife'),
				'singular_name'     => _x( 'Testimonial Category', 'Admin Panel','naturalife'),
				'search_items'      => _x( 'Search Testimonial Category' , 'Admin Panel','naturalife'),
				'all_items'         => _x( 'All Testimonial Categories' , 'Admin Panel','naturalife'),
				'parent_item'       => _x( 'Parent Testimonial Category' , 'Admin Panel','naturalife'),
				'parent_item_colon' => _x( 'Parent Testimonial Category:' , 'Admin Panel','naturalife'),
				'edit_item'         => _x( 'Edit Testimonial Category' , 'Admin Panel','naturalife'), 
				'update_item'       => _x( 'Update Testimonial Category' , 'Admin Panel','naturalife'),
				'add_new_item'      => _x( 'Add New Testimonial Category' , 'Admin Panel','naturalife'),
				'new_item_name'     => _x( 'New Testimonial Category' , 'Admin Panel','naturalife'),
			); 	
			

			register_taxonomy('testimonial_categories',array('testimonial'), array(
				'hierarchical'      => true,
				'labels'            => $labels,
				'show_ui'           => true,
				'query_var'         => false,
				'show_in_nav_menus' => false,
				'show_admin_column' => true,
				'_builtin'          => false,
				'paged'             => true,
				'rewrite'           => array('slug'=> ! empty($testimonial_categories_slug) ? $testimonial_categories_slug : $this->default_testimonial_categories_slug ,'with_front'=>false),
			));

		}		

		/**
		 * Is Portfolio Active
		 * @return boolean
		 */
		public static function is_portfolio_active( ){
			return apply_filters("portfolio_active",get_theme_mod("is_portfolio_active", true));
		}

		/**
		 * Is Team Active
		 * @return boolean
		 */
		public static function is_team_active( ){
			return apply_filters("team_active",get_theme_mod("is_team_active", true));
		}


		/**
		 * Is Testimonials Active
		 * @return boolean
		 */
		public static function is_testimonials_active( ){
			return apply_filters("testimonials_active",get_theme_mod("is_testimonials_active", true));
		}
		

		/**
		 * UI Columns - ID
		 * @param  array $defaults  
		 * @return $defaults
		 */
		function ui_columns_head($defaults) { 
			$defaults['rt-id-column'] = 'ID';
			return $defaults;
		}

		/**
		 * UI Columns - Content
		 * @param  string $column_name 
		 * @param  string $post_ID 
		 * @return $post_ID
		 */
		function ui_columns_content($column_name, $post_ID) { 
			echo $post_ID;
		}


		/**
		 * Permalink Settings
		 */
		public function permalink_settings() {
			
			if( ! $this->is_portfolio_active() && ! $this->is_team_active() ){
				return ;
			}

			add_settings_section( 'rttheme-custom-permalinks', _x( 'Custom Post Base Paths', 'Admin Panel','naturalife' ), array( $this, 'custom_permalinks_section' ), 'permalink' );


			// portfolio
			if( $this->is_portfolio_active() ){
				add_settings_field(
					'rttheme_portfolio_category_slug',
					_x( 'Portfolio category base', 'Admin Panel','naturalife' ),
					array( $this, 'rttheme_portfolio_category_slug_input' ),
					'permalink',
					'rttheme-custom-permalinks'
				);

				add_settings_field(
					'rttheme_portfolio_single_page_slug',
					_x( 'Portfolio single page base', 'Admin Panel','naturalife' ),
					array( $this, 'rttheme_portfolio_single_page_slug_input' ),
					'permalink',
					'rttheme-custom-permalinks'
				);
			}

			// team
			if( $this->is_team_active() ){
				add_settings_field(
					'rttheme_team_single_page_slug',
					_x( 'Team single page base', 'Admin Panel','naturalife' ),
					array( $this, 'rttheme_team_single_page_slug_input' ),
					'permalink',
					'rttheme-custom-permalinks'
				);
			}

			// testimonail categories
			if( $this->is_testimonials_active() ){
				add_settings_field(
					'rttheme_testimonial_category_slug',
					_x( 'Testimonials category base', 'Admin Panel','naturalife' ),
					array( $this, 'rttheme_testimonial_category_slug_input' ),
					'permalink',
					'rttheme-custom-permalinks'
				);
			}

		}

		/**
		 * Custom Permalinks Section
		 */
		public function custom_permalinks_section() {
			echo wpautop( _x( 'These settings control the permalinks used for custom post types comes with naturalife.', 'Admin Panel','naturalife' ) );
		}


		/**
		 * Portfolio category base input
		 * @return html
		 */
		public function rttheme_portfolio_category_slug_input() {
			$base = esc_attr(get_option( RT_EXTENSIONS_SLUG."_portfolio_category_slug" ));
			?>
				<input name="rttheme_portfolio_category_slug" type="text" class="regular-text code" value="<?php echo $base;?>" placeholder="<?php echo $this->default_portfolio_categories_slug; ?>" />
			<?php
		}

		/**
		 * Portfolio single page base input
		 * @return html
		 */
		public function rttheme_portfolio_single_page_slug_input() {
			$base = esc_attr(get_option( RT_EXTENSIONS_SLUG."_portfolio_single_slug" ));
			?>
				<input name="rttheme_portfolio_single_page_slug" type="text" class="regular-text code" value="<?php echo $base;?>" placeholder="<?php echo $this->default_portfolio_slug; ?>" />
			<?php
		}

		/**
		 * Team single page base input
		 * @return html
		 */
		public function rttheme_team_single_page_slug_input() {
			$base = esc_attr(get_option( RT_EXTENSIONS_SLUG."_team_single_slug" ));
			?>
				<input name="rttheme_team_single_page_slug" type="text" class="regular-text code" value="<?php echo $base;?>" placeholder="<?php echo $this->default_team_slug; ?>" />
			<?php
		}

		/**
		 * Testimonial category base input
		 * @return html
		 */
		public function rttheme_testimonial_category_slug_input() {
			$base = esc_attr(get_option( RT_EXTENSIONS_SLUG."_testimonial_category_slug" ));
			?>
				<input name="rttheme_testimonial_category_slug" type="text" class="regular-text code" value="<?php echo $base;?>" placeholder="<?php echo $this->default_testimonial_categories_slug; ?>" />
			<?php
		}		

		/**
		 * Save permalink settings
		 */
		public function save_permalink_settings() {
			if ( ! current_user_can( "edit_theme_options" ) ){
				return;
			}
			
			if ( isset( $_POST['rttheme_testimonial_category_slug'] ) ) {
				update_option( RT_EXTENSIONS_SLUG."_testimonial_category_slug", esc_attr($_POST['rttheme_testimonial_category_slug']) );
			}		

			if ( isset( $_POST['rttheme_portfolio_category_slug'] ) ) {
				update_option( RT_EXTENSIONS_SLUG."_portfolio_category_slug", esc_attr($_POST['rttheme_portfolio_category_slug']) );
			}

			if ( isset( $_POST['rttheme_portfolio_single_page_slug'] ) ) {
				update_option( RT_EXTENSIONS_SLUG."_portfolio_single_slug", esc_attr($_POST['rttheme_portfolio_single_page_slug']) );
			}

			if ( isset( $_POST['rttheme_team_single_page_slug'] ) ) {
				update_option( RT_EXTENSIONS_SLUG."_team_single_slug", esc_attr($_POST['rttheme_team_single_page_slug']) );
			}

		}

		/**
		 * Conflict Notice For WooCommerce Product Slug
		 * @return html
		 */
		function woo_product_base_notice(){ 
			echo '<div class="error"> 
					<p>
					<br />
					<H3>ERROR : Slugname conflict resulting in a 404 on Woocommerce product categories</H3><br />
					Two custom post types are using the same slugname which are WooCommerce and '.RT_THEMENAME.' Product Showcase. <br />
					<br />
					Go to Settings->Permalinks and change the "Product showcase single page base" or "Custom Base" under "Product permalink base" section to another one.
					</p>
				</div>';
		}

		/**
		 * Conflict Notice For WooCommerce Product Categories Slug
		 * @return html
		 */
		function woo_category_base_notice(){ 		
			echo '<div class="error"> 
					<p>
					<br />
					<H3>ERROR : Slugname conflict resulting in a 404 on Woocommerce product categories</H3><br />
					Two custom post types are using the same slugname which are WooCommerce and '.RT_THEMENAME.' Product Showcase. <br />
					<br />
					Go to Settings->Permalinks and change the "Product showcase category base" or "Product category base" to another one. 
					</p>
				</div>';
		}



		/**
		 * Add upload image field to product categories
		 * @return html
		 */
		function rt_taxonomy_add_new_meta_field() {
			?>
			<div class="form-field rt-category-image">
				<label for="rt_product_category_image"><?php _ex( 'Category Thumbnail','Admin Panel','naturalife'); ?></label>

				<div class="upload">
					<input name="term_meta[product_category_image]" id="rt_product_category_image" class="upload_field" type="hidden" data-customize-setting-link="rt_product_category_image" autocomplete="off">
					<button class="button icon-upload rttheme_image_upload_button" type="button" data-inputid="rt_product_category_image"><?php _ex('Upload','Admin Panel','naturalife'); ?></button>
				</div>

				<div class="uploaded_file taxonomy" data-holderid="rt_product_category_image">
					<img class="loadit" data-image="rt_product_category_image" src="">
					<span class="icon-cancel delete_single" data-inputid="rt_product_category_image" title="<?php _ex("remove image",'Admin Panel','naturalife'); ?>"></span>
				</div>
			</div>
		<?php
		} 
		
		/**
		 * Edit upload image field to product categories
		 * @return html
		 */
		function rt_taxonomy_edit_meta_field($term) {
		 
			// put the term ID into a variable
			$t_id = $term->term_id;
		 
			// retrieve the existing value(s) for this meta field. This returns an array
			$term_meta = get_option( "taxonomy_$t_id" ); ?>
			<tr class="form-field rt-category-image">
			<th scope="row" valign="top"><label for="term_meta[product_category_image]"><?php _ex( 'Category Thumbnail', 'Admin Panel','naturalife' ); ?></label></th>
				<td>

					<?php 
						//get the attachment image
						$cat_image_id = esc_attr( $term_meta['product_category_image'] ) ? esc_attr( $term_meta['product_category_image'] ) : "";
					?>
					<div class="upload">
						<input name="term_meta[product_category_image]" id="rt_product_category_image" class="upload_field" type="hidden" data-customize-setting-link="rt_product_category_image" autocomplete="off" value="<?php echo $cat_image_id ?>">
						<button class="button icon-upload rttheme_image_upload_button" type="button" data-inputid="rt_product_category_image"><?php _ex('Upload','Admin Panel','naturalife'); ?></button>
					</div>

					<?php
						$cat_image_url = "";
						
						if( $cat_image_id ){
							$get_cat_image = wp_get_attachment_image_src( $cat_image_id, "thumbnail" );
							$cat_image_url = is_array( $get_cat_image ) ? $get_cat_image[0] : "";
						}

						echo ! empty( $cat_image_url ) ? '<div class="uploaded_file visible taxonomy" data-holderid="rt_product_category_image">' : '<div class="uploaded_file taxonomy" data-holderid="rt_product_category_image">' ;
						echo '<img class="loadit" data-image="rt_product_category_image" src="'.$cat_image_url.'">';
						echo '<span class="icon-cancel delete_single" data-inputid="rt_product_category_image" title="'. _x("remove image",'Admin Panel','naturalife') .'"></span>';
						echo '</div>';
					
					?>
				</td>
			</tr>


		<?php
		}		

		/**
		 * Save upload image field to product categories
		 * @return void
		 */
		function save_taxonomy_custom_meta( $term_id ) {

			if ( ! current_user_can( "edit_theme_options" ) ){
				return;
			}

			if ( isset( $_POST['term_meta'] ) ) {
				$t_id = $term_id;
				$term_meta = get_option( "taxonomy_$t_id" );
				$cat_keys = array_keys( $_POST['term_meta'] );
				foreach ( $cat_keys as $key ) {
					if ( isset ( $_POST['term_meta'][$key] ) ) {
						$term_meta[$key] = $_POST['term_meta'][$key];
					}
				}
				// Save the option array.
				update_option( "taxonomy_$t_id", $term_meta );
			}
		}  

	}

}

new RT_Custom_Posts();
?>