<?php
/**
 * Plugin Name: NaturaLife | Extensions Plugin
 * Plugin URI: http://themeforest.net/item/naturalife-creative-multi-concept-wordpress-theme/16211759
 * Description: Extensions plugin for NaturaLife WordPress Theme
 * Author: RT-Themes
 * Author URI: http://rtthemes.com
 * Version: 1.3
 * Text Domain: naturalife
 * Domain Path: languages
 *
 * @author RT-Themes
 * @version 1.3
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'Naturalife_Extensions' ) ) :

/**
 * Main Naturalife_Extensions Class
 *
 * @since 1.0
 */
final class Naturalife_Extensions {

	/**
	 * @var string
	 */
	public static $version = '1.3';

	/**
	 * @var string
	 */
	public static $plugin_name = 'NaturaLife | Extensions Plugin';

	/**
	 * @var string
	 */
	public static $plugin_for = 'NaturaLife';

	/**
	 * @var string
	 */
	public static $theme_data;

	/**
	 * @var Naturalife_Extensions
	 */
	private static $instance;

	/**
	 * @var Admin Notices
	 */
	public static $admin_notices = array();

	/**
	 * Main Class
	 * @return Naturalife_Extensions
	 */
	public static function instance() {

		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Naturalife_Extensions ) ) {
			self::$instance = new Naturalife_Extensions; 

			//theme data
			self::$instance->rtframework_get_theme();

			//check
			$check = self::$instance->check_other_rt_themes();

			//actions
			add_action( 'admin_notices', array(self::$instance,'rt_admin_notices')); 	

			if( $check ){

				add_action( 'init', array( self::$instance, 'plugable_functions' ) );
				add_action( 'wp_enqueue_scripts', array(self::$instance,'load_scripts' ) );
				add_action( 'admin_enqueue_scripts', array(self::$instance,'load_admin_scripts' ));
				add_action( 'admin_enqueue_scripts', array(self::$instance,'load_admin_styles' ) );			
				add_action( 'widgets_init', array( self::$instance, 'load_widgets' ) );
				add_action( 'init', array(self::$instance,'create_metaboxes' ) ); 
				add_action( 'init', array( self::$instance, 'fallback_functions' ) );
				add_action( 'wp_ajax_my_action', array( self::$instance,'rt_admin_ajax') );
				add_action( 'wp_before_admin_bar_render', array(self::$instance,'custom_toolbar') , 99 ); 
				add_action( 'admin_head', array(self::$instance,'remove_update_messages_css') , 1000 ); 

				//definitions
				self::$instance->definitions();

				//includes
				self::$instance->includes();

				//activitation hooks
				register_activation_hook( __FILE__, array( self::$instance, 'on_activate' ) );

				//flush rewrite rules
				add_action('rt_flush_rewrite_rules', 'flush_rewrite_rules',10);

				//Ajax Contact Form 
				add_action('wp_ajax_rt_ajax_contact_form', 'rt_ajax_contact_form');
				add_action('wp_ajax_nopriv_rt_ajax_contact_form', 'rt_ajax_contact_form');
			}
			
		}

		return self::$instance;
	}


	/**
	 * Tasks when plugin activated
	 * @return bool
	 */
	public function on_activate() {
		do_action('rt_flush_rewrite_rules' );
	} 


	/**
	 * Check Other RT-Theme Themes
	 * @return bool
	 */
	public function check_other_rt_themes() {

		$theme = self::$theme_data;

		if ( defined( 'RT_THEME_EXTENSION' ) ){

				if( self::$plugin_for != $theme["Name"] ){
					$message = "<strong>". self::$plugin_name . "</strong> detected. Please deactivate the plugin to prevent possible conflicts between <strong>". $theme["Name"]."</strong>";
				}else{
					$message = "<strong>". RT_THEME_PLUGINNAME . "</strong> detected. Please deactivate the plugin to prevent possible conflicts between <strong>". $theme["Name"]."</strong>";
				}				

				if( is_admin() ){ 
					//print admin notification
					array_push( self::$admin_notices , array("type" => "error", "text" => $message ) ); 
				}else{
					wp_die( $message );
				}

			return;
		}

		return true;
	} 

	/**
	 * Admin Panel Notices
	 * @return html 
	 */
	public function rt_admin_notices(){  

		if( is_array( self::$admin_notices ) ){
			foreach ( self::$admin_notices as $key => $value) {
				echo '<div id="notice" class="'.sanitize_html_class($value["type"]).'"><p>'.$value["text"].'</p></div>';
			}
		}
	}  

	/**
	 * Definitions
	 * @return void
	 */
	public function definitions() {

		if ( ! defined( 'RT_EXTENSIONS_SLUG' ) )  define('RT_EXTENSIONS_SLUG', 'naturalife');
		if ( ! defined( 'RT_EXTENSIONS_PATH' ) )  define('RT_EXTENSIONS_PATH', plugin_dir_path( __FILE__ ) );
		if ( ! defined( 'RT_EXTENSIONS_URI' ) )  define('RT_EXTENSIONS_URI', plugin_dir_url( __FILE__ ) );	
		if ( ! defined( 'RT_THEMENAME' ) )  define('RT_THEMENAME', "NaturaLife" );
		if ( ! defined( 'RT_THEMESLUG' ) )  define('RT_THEMESLUG', "naturalife"); // a unique slugname for this theme
		if ( ! defined( 'RT_COMMON_THEMESLUG' ) )  define('RT_COMMON_THEMESLUG', "rttheme"); // a common slugnam for all rt-themes
		if ( ! defined( 'RT_EXTENSIONS_PLUGIN_FOR' ) )  define('RT_EXTENSIONS_PLUGIN_FOR', self::$plugin_for);
		if ( ! defined( 'RT_THEME_EXTENSION' ) )  define('RT_THEME_EXTENSION', TRUE );
		if ( ! defined( 'RT_THEME_PLUGINNAME' ) )  define('RT_THEME_PLUGINNAME', self::$plugin_name );		
		if ( ! defined( 'ELEMENTOR_PARTNER_ID' ) )  define('ELEMENTOR_PARTNER_ID', 2143 );		

	} 

	/**
	 * Include required files
	 *
	 * @access private
	 * @return void
	 */
	private function includes() { 
		require_once RT_EXTENSIONS_PATH  . '/inc/post-types.php';
		require_once RT_EXTENSIONS_PATH  . '/inc/shortcode_helper.php';
		require_once RT_EXTENSIONS_PATH  . '/inc/tools.php'; 
		require_once RT_EXTENSIONS_PATH  . '/inc/elementor-config.php';
		require_once RT_EXTENSIONS_PATH  . '/inc/wpml/elementor-wpml-config.php';		 
		require_once RT_EXTENSIONS_PATH  . '/inc/imports/envato-market/github.php';		
	}

	/**
	 * Include plugable functions
	 *
	 * @access private
	 * @return void
	 */
	public function plugable_functions() { 
		require_once RT_EXTENSIONS_PATH  . '/inc/shortcodes.php'; 
		require_once RT_EXTENSIONS_PATH  . '/inc/helper-functions.php'; 
	}

	/**
	 * Include Fallback Functions
	 *
	 * @access private
	 * @return void
	 */
	public function fallback_functions() { 
		if ( ! class_exists( 'RTFramework' ) ) {
			require_once RT_EXTENSIONS_PATH  . '/inc/fallback_functions.php'; 
			require_once RT_EXTENSIONS_PATH  . '/inc/rt_resize.php';
		}
	}

	/**
	 * Load Widgets
	 *
	 * @access public
	 * @return void
	 */
	public function load_widgets() { 

		include( RT_EXTENSIONS_PATH . "widgets/text.php"); //text	
		include( RT_EXTENSIONS_PATH . "widgets/flickr.php"); //flickr
		include( RT_EXTENSIONS_PATH . "widgets/latest_posts.php"); //recent posts with thumbnails	
		include( RT_EXTENSIONS_PATH . "widgets/popular_posts.php"); //popular posts
		include( RT_EXTENSIONS_PATH . "widgets/contact_info.php"); //contact info
 		include( RT_EXTENSIONS_PATH . "widgets/social_media.php"); //social media
		include( RT_EXTENSIONS_PATH . "widgets/category_tree.php"); //categries
		include( RT_EXTENSIONS_PATH . "widgets/button.php"); //button
	}

	/**
	 * Create Metaboxes
	 * 
	 * @return void
	 */
	public function create_metaboxes() {			

		//check the current user access 
		if ( ! is_admin() || ! current_user_can( "edit_posts" ) ){
			return ;
		}

		//load metabox class
		include(RT_EXTENSIONS_PATH . "inc/metaboxes.php"); 

		//gallery upload options
		include(RT_EXTENSIONS_PATH . "inc/metabox-gallery.php");  


		//portfolio
		include(RT_EXTENSIONS_PATH . "inc/metaboxes/portfolio_custom_fields.php"); 				 		

		//testimonial
		include(RT_EXTENSIONS_PATH . "inc/metaboxes/testimonial_custom_fields.php"); 

		//posts
		include(RT_EXTENSIONS_PATH . "inc/metaboxes/post_custom_fields.php"); 

		//design custom fields
		include(RT_EXTENSIONS_PATH . "inc/metaboxes/design_custom_fields.php"); 


		//staff custom fields
		include(RT_EXTENSIONS_PATH . "inc/metaboxes/staff_custom_fields.php"); 

	}

	/**
	 * Loading Extension Scripts
	 * @return void
	 */
	function load_scripts(){		

		if ( ! class_exists( 'RTFramework' ) ) {
			wp_enqueue_script('naturalife', plugins_url( 'js/app.min.js', __FILE__ ), array('jquery'),  "", "true" );
		}

	}

	/**
	 * Loading Admin Scripts
	 * @return void
	 */
	function load_admin_scripts(){		

		if(is_admin()){

			global $pagenow;
			if( $pagenow == "post.php" || $pagenow == "post-new.php" ){

				$api_key = get_theme_mod(RT_THEMESLUG.'_google_api_key');

				if(  ! empty( $api_key ) ){


				$googlemaps_url = add_query_arg( 'key', urlencode( $api_key ), "//maps.googleapis.com/maps/api/js" );

				wp_enqueue_script('googlemaps',$googlemaps_url,array(), '1.0.0'); 	
				wp_enqueue_script('rt-google-maps', plugins_url('js/rt_location_finder.js',__FILE__),'','',true);  
				
					//localize js params
				$map_selector = array(
					'map_html' =>'
					<div class="rt_modal rt-location-selector">
						<div class="window_bar">
							<div class="title">'. _x('Find Locations', 'Admin Panel','naturalife').'</div>
							<div class="rt_modal_close rt_modal_control" title="'. _x('Close', 'Admin Panel','naturalife').'"><span class="rt-panel-icon-cancel"></span></div>
						</div>
						<div class="modal_content"> 
							<div class="gllpLatlonPicker">
									<ul>
										<li class="text_align_right">'._x('Search','Admin Panel','naturalife').':</li>
										<li><input type="text" class="gllpSearchField"></li>
										<li><input type="button" class="gllpSearchButton button light" value="'._x('search','Admin Panel','naturalife').'"></li>		
									</ul>
									<div class="gllpMap">'._x('Google Maps','Admin Panel','naturalife').'</div>
									<ul>
										<li class="text_align_right">'._x('lat/lon','Admin Panel','naturalife').':<input type="text" class="gllpLatitude" value="0"/>/<input type="text" class="gllpLongitude" value="0"/>
										<input type="button" class="select_map button light" value="'._x('select','Admin Panel','naturalife').'">
										<input type="hidden" class="gllpZoom" value="3"/>
										<input type="hidden" class="selected_field" value="1"/>
										<input type="button" class="gllpUpdateButton" value="'._x('update map','Admin Panel','naturalife').'">
									</ul>
							</div>
						</div>
					</div>

					',
				);
				wp_localize_script( 'jquery', 'rt_location_finder', $map_selector );

				}


			}
		}

	}

	/**
	 * Loading Admin Styles
	 * @return void
	 */
	function load_admin_styles(){		
		if ( ! class_exists( 'RTFramework' ) ) {
			wp_register_style('admin-styles', plugins_url( 'css/admin.min.css', __FILE__ ) );  
			wp_enqueue_style('admin-styles');
		}
	}

	/**
	 * Get Theme Data 
	 *
	 * Returns the theme data of orginal theme only not childs
	 * 
	 * @return void
	 */
	public static function rtframework_get_theme(){ 

		$theme_data = wp_get_theme(); 
		$main_theme_data = $theme_data->parent(); 

		if( ! empty( $main_theme_data ) ){		
			self::$theme_data=$main_theme_data;
		}else{		
			self::$theme_data=$theme_data;
		}
			
		return self::$theme_data;
	}

	/**
	 * Icon Selection Menu
	 *
	 * Returns html codes for icon selection lightbox window
	 * 
	 * @return html
	 */
	function icon_selection() {  
		
		echo'
			<div class="rt_modal icon-selection">
				<div class="window_bar">
					<div class="title">'. _x('Icons', 'Admin Panel','naturalife').'</div>
					<div class="left"><input type="text" name="icon_search" id="rt_icon_search" value="" placeholder="'. _x('search', 'Admin Panel','naturalife').'"><span id="rt_icon_search_result"></span></div>
					<div class="icon_selection_close rt_modal_control" title="'. _x('Close', 'Admin Panel','naturalife').'"><span class="icon-cancel"></span></div>
				</div>
			<div class="modal_content"><ul class="list-icons">
		';

		$json = "";

		//the json file of the fontello
		$fontello_json_file =  "/css/fontello/config.json";

		//get json file of the fontello font url with locate media file check if a json file is exist in the child theme
		$fontello_json_url = rtframework_locate_media_file( $fontello_json_file ) ; 

		$fontello_css_file =  "/css/fontello/css/fontello.css";
		
		//load icons
		echo "<link rel='stylesheet' id='admin-bar-css' href='".rtframework_locate_media_file( $fontello_css_file )."' type='text/css' media='all' />";		

		//try with wp_remote_fopen first
		$json = wp_remote_fopen( $fontello_json_url ); 
 
		//try to include if no json returned
		if ( ! json_decode($json) ){
			ob_start(); 

			if( file_exists( get_stylesheet_directory(). $fontello_json_file ) ){
				include( get_stylesheet_directory(). $fontello_json_file ); 
			}else{
				include( get_template_directory() . $fontello_json_file  ); 
			}
				
			$json = ''.ob_get_contents().'';
			ob_end_clean(); 
		}

		//paste the list output
		if ( $json ){
			$json_output = json_decode($json);

			if( $json_output ){
				$icon_prefix = $json_output->css_prefix_text;

				$format = '<li class="%2$s%1$s"><span>%2$s%1$s</span></li>';
				echo sprintf($format, "blank", "");

				foreach ( $json_output->glyphs as $icon_name )
				{			     
					echo sprintf($format, $icon_name->css, $icon_prefix);
				}			
			}
		}	

		echo '</ul></div>';

	}	

	/**
	 * Admin Ajax Process
	 * 
	 * @return html
	 */
	function rt_admin_ajax() {

		if( isset( $_POST['iconSelector'] ) ){//icon selection
			$this->icon_selection();
		} 

		if( isset( $_POST['shortcode_helper'] ) ){//icon selection		
				$rt_shortcode_helper = new rt_shortcode_helper;
				echo $rt_shortcode_helper->create_shortcode_list();
		} 

		die();
		
	} 


	/**
	 * 
	 * Add Toolbar Menus 
	 * 
	 */

	function custom_toolbar() {
		global $wp_admin_bar;
 
 		if( ! is_admin() ){
 			return;
 		}
 		
		$args = array(
			'id'     => 'rt_icons',
			'title'  => '<div><span class="ab-icon"></span><span class="ab-label">'._x( 'Icons', 'Admin Panel','naturalife' ) .'</div>',		
			'group'  => false 
		);

		$wp_admin_bar->add_menu( $args ); 
	}

	/**
	 *
	 * Remove bundled plugin update messages
	 * 
	 */

	function remove_update_messages_css() {
		echo '<style>tr[data-slug="slider-revolution"] + .plugin-update-tr, .vc_license-activation-notice, .rs-update-notice-wrap, tr.plugin-update-tr.active#js_composer-update, #vc_license-activation-notice, .rs-update-notice-wrap { display: none !important;}</style>';
	}	

}

endif;


/**
 * Returns the main instance 
 *
 * @return Naturalife_Extensions
 */
function Naturalife_Extensions() {
	return Naturalife_Extensions::instance();
}

// start
Naturalife_Extensions();