<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * RT-Theme Tools
 *
 * Create theme tools
 *
 * @class 		RT_Tools
 * @version		1.0
 * @author 		RT-Themes
 */

class RT_Tools
{

	/**
	 * Capability
	 */
	public $capability = "edit_theme_options";

	/**
	 * Construct
	 */
	public function __construct()
	{

		//Additional customizer settings
		add_action('init', array(&$this, 'customizer_hooks'));  			
		
		
		//Rest of the class is only for admin area 
		if( ! is_admin() ){
			return;
		}

		//load tools
		add_action('registered_taxonomy', array(&$this, 'lood_tools'));  	
	}


	/**
	 * Load Tools
	 * @return array $skin_list
	 */
	public function lood_tools() {

		//if it is not an RT-Theme or this one is not belong to the current RT-Theme
		if ( RT_THEMENAME != RT_EXTENSIONS_PLUGIN_FOR || ! defined("RT_FRAMEWOK") ) { 	
			return ;	
		}

		//init
		add_action('admin_menu', array(&$this, 'add_menu_item'),1);   
		add_action('admin_init', array(&$this, 'demo_import'));  
		add_action('admin_init', array(&$this, 'export_settings'));  
		add_action('admin_init', array(&$this, 'import_settings'));  
		add_action('admin_init', array(&$this, 'custom_css'));  
		add_action('admin_init', array(&$this, 'reset_settings')); 		
		add_action('admin_init', array(&$this, 'save_custom_fonts'));  
		add_action('init', array(&$this, 'save_utilities'),1);  	
		add_filter( "wp_importframework_post_meta",  array(&$this, 'cf7_mail_fix'));

		//load skin changer
		add_action('customize_controls_print_footer_scripts', array( &$this, 'skin_selector'));   

		//skin loader actions
		add_action('wp_ajax_rt_ajax_skin_loader', array( &$this,'load_skins'));
		add_action('wp_ajax_nopriv_rt_ajax_skin_loader', array( &$this,'load_skins'));		
		add_action('wp_ajax_rt_ajax_get_skin_data', array( &$this,'get_skin_data_json'));
		add_action('wp_ajax_nopriv_rt_ajax_get_skin_data', array( &$this,'get_skin_data_json'));		

	}


	/**
	 * Get Skin List
	 * @return array $skin_list
	 */
	public function get_skin_list() {
		
		/**
		 * Skin list
		 */
		$skin_list = array();

		
		// to do : get user drafts / skins

			
		//get theme skins
		$theme_skins = array();

		$theme_skins[] = array(
							"type" => "theme",
							"id" => "1",
							"imgid" => "1.jpg",
							"name" => esc_html_x('Header Style','Admin Panel','naturalife') . " - 1",
							"layout" => "header"
						);

		$theme_skins[] = array(
							"type" => "theme",
							"id" => "1-t",
							"imgid" => "1-t.jpg",
							"name" => esc_html_x('Header Style','Admin Panel','naturalife') . " - 1 " . esc_html_x('Transparent','Admin Panel','naturalife'),
							"layout" => "header"
						);

		$theme_skins[] = array(
							"type" => "theme",
							"id" => "2",
							"imgid" => "2.jpg",
							"name" => esc_html_x('Header Style','Admin Panel','naturalife') . " - 2",
							"layout" => "header"
						);

		$theme_skins[] = array(
							"type" => "theme",
							"id" => "2-t",
							"imgid" => "2-t.jpg",
							"name" => esc_html_x('Header Style','Admin Panel','naturalife') . " - 2 " . esc_html_x('Transparent','Admin Panel','naturalife'),
							"layout" => "header"
						);

		$theme_skins[] = array(
							"type" => "theme",
							"id" => "3",
							"imgid" => "3.jpg",
							"name" => esc_html_x('Header Style','Admin Panel','naturalife') . " - 3",
							"layout" => "header"
						);

		$theme_skins[] = array(
							"type" => "theme",
							"id" => "3-t",
							"imgid" => "3-t.jpg",
							"name" => esc_html_x('Header Style','Admin Panel','naturalife') . " - 3 " . esc_html_x('Transparent','Admin Panel','naturalife'),
							"layout" => "header"
						);

		$theme_skins[] = array(
							"type" => "theme",
							"id" => "4",
							"imgid" => "4.jpg",
							"name" => esc_html_x('Header Style','Admin Panel','naturalife') . " - 4",
							"layout" => "header"
						);

		$theme_skins[] = array(
							"type" => "theme",
							"id" => "4-t",
							"imgid" => "4-t.jpg",
							"name" => esc_html_x('Header Style','Admin Panel','naturalife') . " - 4 " . esc_html_x('Transparent','Admin Panel','naturalife'),
							"layout" => "header"
						);

		$theme_skins[] = array(
							"type" => "theme",
							"id" => "5",
							"imgid" => "5.jpg",
							"name" => esc_html_x('Header Style','Admin Panel','naturalife') . " - 5",
							"layout" => "header"
						);

		$theme_skins[] = array(
							"type" => "theme",
							"id" => "5-t",
							"imgid" => "5-t.jpg",
							"name" => esc_html_x('Header Style','Admin Panel','naturalife') . " - 5 " . esc_html_x('Transparent','Admin Panel','naturalife'),
							"layout" => "header"
						);

		$theme_skins[] = array(
							"type" => "theme",
							"id" => "6",
							"imgid" => "6.jpg",
							"name" => esc_html_x('Header Style','Admin Panel','naturalife') . " - 6",
							"layout" => "header"
						);

		$theme_skins[] = array(
							"type" => "theme",
							"id" => "6-t",
							"imgid" => "6-t.jpg",
							"name" => esc_html_x('Header Style','Admin Panel','naturalife') . " - 6 " . esc_html_x('Transparent','Admin Panel','naturalife'),
							"layout" => "header"
						);

		$theme_skins[] = array(
							"type" => "theme",
							"id" => "7",
							"imgid" => "7.jpg",
							"name" => esc_html_x('Header Style','Admin Panel','naturalife') . " - 7",
							"layout" => "header"
						);

		$theme_skins[] = array(
							"type" => "theme",
							"id" => "7-t",
							"imgid" => "7-t.jpg",
							"name" => esc_html_x('Header Style','Admin Panel','naturalife') . " - 7 " . esc_html_x('Transparent','Admin Panel','naturalife'),
							"layout" => "header"
						);

		return $theme_skins;
	}


	/**
	 * Get Skin Data Json
	 * @return json data $json
	 */
	public function get_skin_data_json() {
		
		if(isset( $_POST["skin-id"] )){
			$skin_id = sanitize_text_field( $_POST["skin-id"] );
		}

		require_once( RT_EXTENSIONS_PATH . '/inc/skins/'.$skin_id.'.php' );		

 		echo( json_encode($skin_data) );

		die;
	}


	/**
	 * Skin & Draft Selector
	 */
	public function load_skins() {
 
		$skins = $this->get_skin_list();

		foreach ($skins as $k => $skin) {
				?>
					<div class="skin" data-skin-id="<?php echo $skin["id"]; ?>" data-skin-type="<?php echo $skin["type"]; ?>">
						<img class="skin-image" src="<?php echo RT_THEMEADMINURI; ?>/images/skins/<?php echo $skin["imgid"]; ?>">
						<p><?php echo $skin["name"]; ?></p>
					</div>
				<?php
				}

			die;
	}


	/**
	 * Skin & Draft Selector
	 */
	public function skin_selector() {

		echo '
		
			<div id="available-rt-skins">

				<img src="images/spinner.gif" class="skins-loading-spinner">
			
			</div><!-- #available-rt-skins -->

		';
	}

	/**
	 * Customizer Related Hooks
	 */
	public function customizer_hooks(){
		add_filter( "rt_customizer_options",  array(&$this, 'additional_theme_settings') );
	}


 	/**
	 * Additional theme settings
	 */
	public function additional_theme_settings( $options )
	{
		//disabled
		return;

		// //Sking Selector
		// $skin_selector = array(
		// 							'id'       => 'skins_selector_section',
		// 							'title'    => esc_html_x("Pre-Made Skins", 'Admin Panel','naturalife'), 
		// 							'controls' => array( 

		// 												array(
		// 													'id'        => 'rt_skin_selector_html',
		// 													'label'     => esc_html_x("Skin Selector",'Admin Panel','naturalife'),
		// 													'type'      => 'rt_content', 
		// 													"transport" => "postMessage",
		// 													'description' => '<p>'.esc_html_x("Select a pre-made skin to use. Once you select a skin from the list, it's settings will be applied to the live preview only and won't affect your website unliness you save & publish the changes.",'Admin Panel','naturalife').'</p><span id="rt-skin-selector" class="button-secondary rt-skin-selector" tabindex="0">'.esc_html_x('Select a Skin','Admin Panel','naturalife').'</span>',
		// 												), 

		// 										),
		// 						);

		// array_unshift( $options["rt_color_schemas"]["sections"], $skin_selector );

		// return $options;
	}


	/**
	 * Add admin menu item
	 */
	public function add_menu_item()
	{
		add_menu_page( esc_html_x('NaturaLife','Admin Panel','naturalife'), esc_html_x('NaturaLife','Admin Panel','naturalife'), $this->capability, 'rt_framework_welcome', 'rt_framework_welcome', NULL, NULL, 61 );
		add_submenu_page( 'rt_framework_welcome', esc_html_x('Customize','Admin Panel','naturalife'), esc_html_x('Customize','Admin Panel','naturalife'), $this->capability , 'customize.php' );	
		add_submenu_page( 'rt_framework_welcome', esc_html_x('Utilities','Admin Panel','naturalife'), esc_html_x('Utilities','Admin Panel','naturalife'), $this->capability, 'rt_utilities', array(&$this,"utilities_page") );
		add_submenu_page( 'rt_framework_welcome', esc_html_x('Import','Admin Panel','naturalife'), esc_html_x('Import','Admin Panel','naturalife'), $this->capability, 'rt_import', array(&$this,"import_page") );
		add_submenu_page( 'rt_framework_welcome', esc_html_x('Export','Admin Panel','naturalife'), esc_html_x('Export','Admin Panel','naturalife'), $this->capability, 'rt_export', array(&$this,"export_page") );				
		add_submenu_page( 'rt_framework_welcome', esc_html_x('Reset','Admin Panel','naturalife'), esc_html_x('Reset','Admin Panel','naturalife'), $this->capability, 'rt_reset', array(&$this,"reset_page") );	
		add_submenu_page( 'rt_framework_welcome', esc_html_x('Custom Fonts','Admin Panel','naturalife'), esc_html_x('Custom Fonts','Admin Panel','naturalife'), $this->capability, 'rt_custom_fonts', array(&$this,"custom_fonts_page") ); 
		//add_submenu_page( 'rt_framework_welcome', esc_html_x('Custom CSS','Admin Panel','naturalife'), esc_html_x('Custom CSS','Admin Panel','naturalife'), $this->capability, 'rt_custom_css', array(&$this,"custom_css_page") );
		add_submenu_page( 'rt_framework_welcome', esc_html_x('Demo Import','Admin Panel','naturalife'), esc_html_x('Demo Import','Admin Panel','naturalife'), $this->capability, 'rt_demo_import', array(&$this,"demo_import_page") );		


		//chanage the title of the first page in the sub menu
		global $submenu;

		if ( isset( $submenu['rt_framework_welcome'] ) ) {
			$submenu['rt_framework_welcome'][0][0] = __( 'Welcome', esc_html_x('Demo Import','Admin Panel','naturalife'));
		}

	}

	/**
	 * Add Admin Notices
	 */
	public function add_notices( $message = "", $type = "error" )
	{
		add_action( 'admin_notices', function() use ($message, $type){
			printf('<div class="%s"><p>%s</p></div>',$type,$message);
		});
	}

	/**
	 * Utilities
	 */
	public function utilities_page()
	{	

	?>

		<div class="wrap"  id="rt_utilities_page">
			<h1><?php printf( _x('Utilities','Admin Panel','naturalife'), RT_THEMENAME ) ;?></h1>

			<hr />	

			<form action="<?php echo wp_nonce_url(admin_url('admin.php?page=rt_utilities')); ?>" method="post" enctype="multipart/form-data">
					<input type="hidden" value="save_utilities" name="action">

					<h2><?php printf( _x('Performance','Admin Panel','naturalife'), RT_THEMENAME ) ;?></h2>

					<p><?php _ex('Speed up your website by using minified and combined versions of the css/js files that used for the theme. ','Admin Panel', 'naturalife');?></p>

					<table class="form-table">
						<tbody>

							<tr>
								<th scope="row">
									<label><?php _ex('CSS Files','Admin Panel','naturalife') ?></label>
								</th>
								<td>
									<?php
										$naturalife_optimize_css = get_theme_mod("naturalife_optimize_css");
									?>
									<label for="rt_utility_vals[naturalife_optimize_css]">
										<input type="checkbox" id="rt_utility_vals[naturalife_optimize_css]" name="rt_utility_vals[naturalife_optimize_css]" <?php echo $naturalife_optimize_css == "on" ? "checked" : "" ?>/>
										<?php _ex('Use optimized CSS files of the theme','Admin Panel','naturalife') ?>
									</label>
					 	
								</td>
							</tr>


							<tr>
								<th scope="row">
									<label><?php _ex('JS Files','Admin Panel','naturalife') ?></label>
								</th>
								<td>
									<?php
										$naturalife_optimize_js = get_theme_mod("naturalife_optimize_js");
									?>
									<label for="rt_utility_vals[naturalife_optimize_js]">
										<input type="checkbox" id="rt_utility_vals[naturalife_optimize_js]" name="rt_utility_vals[naturalife_optimize_js]" <?php echo $naturalife_optimize_js == "on" ? "checked" : "" ?>/>
										<?php _ex('Use optimized JS files of the theme','Admin Panel','naturalife') ?>
									</label>
					 	
								</td>
							</tr>

						</tbody>
					</table>

					<hr />	

					<h2><?php printf( _x('Special Pages','Admin Panel','naturalife'), RT_THEMENAME ) ;?></h2>
					<table class="form-table">
						<tbody>

							<tr>
								<th scope="row">
									<label><?php _ex('404 Page','Admin Panel','naturalife') ?></label>
								</th>
								<td>
									<select name="rt_utility_vals[naturalife_404_page]" autocomplete="off">
										<?php
											$pages = RTFramework::rt_get_pages();
											$stored_404 = get_theme_mod("naturalife_404_page");
 
											printf('<option value="">%s</option>', _x('Select a page','Admin Panel','naturalife') );

											foreach ($pages as $id => $page) {
												printf('<option value="%s"%s>%s</option>', $id, $stored_404 == $id ? " selected" : "", $page);
											}
										?>
									</select>
									<p class="description"><?php _ex('Select a page to be used as a 404 page.','Admin Panel','naturalife') ?></p>										
								</td>
							</tr> 	

							<tr>
								<th scope="row">
									<?php _ex('Maintenance Mode','Admin Panel','naturalife') ?>
								</th>
								<td>

									<fieldset>

										<?php
											$naturalife_maintenance_mode = get_theme_mod("naturalife_maintenance_mode");
										?>									
										<label for="rt_utility_vals[naturalife_maintenance_mode]">
											<input type="checkbox" id="rt_utility_vals[naturalife_maintenance_mode]" name="rt_utility_vals[naturalife_maintenance_mode]" <?php echo $naturalife_maintenance_mode == "on" ? "checked" : "" ?>/>
											<?php _ex('Enable/disable the maintenance mode.','Admin Panel','naturalife') ?>
										</label>
										
										<p class="description"><?php _ex('When this option enabled, all your front-end URLs will be redirected to the selected page below. 
										The redirection will be ignored if the user role is "Administrator". 
										So, you need to sign out to see the changes and be sure all caches has been cleared if you have any caching plugin installed.','Admin Panel','naturalife') ?></p>
										
										<br />

										<label for="rt_utility_vals[naturalife_maintenance_page]">
											<select name="rt_utility_vals[naturalife_maintenance_page]" autocomplete="off">
												<?php
													$pages = RTFramework::rt_get_pages();
													$stored_404 = get_theme_mod("naturalife_maintenance_page");

													printf('<option value="">%s</option>', _x('Select a page','Admin Panel','naturalife') );

													foreach ($pages as $id => $page) {
														printf('<option value="%s"%s>%s</option>', $id, $stored_404 == $id ? " selected" : "", $page);
													}
												?>
											</select>
										</label>
										<p class="description"><?php _ex('Select a page to be used as a Maintenance or Coming Soon page.','Admin Panel','naturalife') ?></p>										

									</fieldset>
								</td>
							</tr> 	 										
						</tbody>
					</table>

					<hr />	

					<h2><?php printf( _x('Custom Posts','Admin Panel','naturalife'), RT_THEMENAME ) ;?></h2>
					<table class="form-table">
						<tbody>

							<tr>
								<th scope="row">
									<label><?php _ex('Portfolio','Admin Panel','naturalife') ?></label>
								</th>
								<td>
									<?php
										$is_portfolio_active = get_theme_mod("is_portfolio_active", true);
									?>
									<label for="rt_utility_vals[is_portfolio_active]">
										<input type="checkbox" id="rt_utility_vals[is_portfolio_active]" name="rt_utility_vals[is_portfolio_active]" <?php echo $is_portfolio_active == "on" ? "checked" : "" ?>/>
										<?php _ex('Enable/disable the portfolio custom post type.','Admin Panel','naturalife') ?>
									</label>					 
								</td>
							</tr>

							<tr>
								<th scope="row">
									<label><?php _ex('Team','Admin Panel','naturalife') ?></label>
								</th>
								<td>
									<?php
										$is_team_active = get_theme_mod("is_team_active", true);
									?>
									<label for="rt_utility_vals[is_team_active]">
										<input type="checkbox" id="rt_utility_vals[is_team_active]" name="rt_utility_vals[is_team_active]" <?php echo $is_team_active == "on" ? "checked" : "" ?>/>
										<?php _ex('Enable/disable the team custom post type.','Admin Panel','naturalife') ?>
									</label>					 
								</td>
							</tr>

							<tr>
								<th scope="row">
									<label><?php _ex('Testimonials','Admin Panel','naturalife') ?></label>
								</th>
								<td>
									<?php
										$is_testimonials_active = get_theme_mod("is_testimonials_active", true);
									?>
									<label for="rt_utility_vals[is_testimonials_active]">
										<input type="checkbox" id="rt_utility_vals[is_testimonials_active]" name="rt_utility_vals[is_testimonials_active]" <?php echo $is_testimonials_active == "on" ? "checked" : "" ?>/>
										<?php _ex('Enable/disable the team testimonials post type.','Admin Panel','naturalife') ?>
									</label>					 
								</td>
							</tr>
						</tbody>
					</table>

					<hr />	
	 		<?php echo submit_button();?>				
	 		</form>
		</div>

		<?php
	}

	/**
	 * Save Utilities
	 */
	public function save_utilities()
	{

		//check the current user access 
		if ( ! current_user_can( $this->capability ) ){
			return ;
		}

		//check
		if( ! isset( $_GET['page'] ) || ! isset( $_POST['action'] ) || ! isset( $_POST['rt_utility_vals'] ) ){
			return ;
		}

		if( $_GET['page'] != "rt_utilities" || $_POST['action'] != "save_utilities" ){
			return ;
		}

		$post_values = isset($_POST['rt_utility_vals']) ? $_POST['rt_utility_vals'] : "";


		if( empty( $post_values ) ){
			return;
		}

		foreach ( RTFramework_Customize_Panel()->utility_options as $option_name => $value ) {
			set_theme_mod( $option_name, isset($post_values[$option_name]) ? $post_values[$option_name]: "" );			
		}

		$this->add_notices( esc_html_x("Settings updated successfully.",'Admin Panel','naturalife') ,"updated" );
	}


	/**
	 * Demo Import settings page
	 */
	public function demo_import_page()
	{	

		echo '
		<div class="wrap" id="rt_demo_import_settings">
		<h1>'.RT_THEMENAME.' '._x('Demo Import','Admin Panel','naturalife').'</h1>
		';

		$plugin_messages = "";
		if ( ! class_exists( 'Woocommerce' ) ) {
			$plugin_messages .='
					<li class="rt-panel-icon-attention" style="color:red;">
						'._x('If you are planning to use WooCommerce, install and/or activate it first to import the plugin related contents.','Admin Panel','naturalife').'
						<a href="'.admin_url( 'plugin-install.php?s=woocommerce&tab=search&type=term').'">'._x('Install','Admin Panel','naturalife').' & '._x('activate','Admin Panel','naturalife').'</a>
					</li>				
			';
		}

		if ( ! class_exists( "WPCF7" ) ){			
			$plugin_messages .='
					<li class="rt-panel-icon-attention" style="color:red;">
						'._x('If you are planning to use Contact Form 7, install and/or activate it first to import the plugin related contents.','Admin Panel','naturalife').'
						<a href="'.admin_url( 'themes.php?page=tgmpa-install-plugins').'">'._x('Install','Admin Panel','naturalife').' & '._x('activate','Admin Panel','naturalife').'</a>
					</li>						
			';
		}

 		if ( ! class_exists( "RevSliderFront" ) ){
 			$revslider_link = '';
			$plugin_messages .='
					<li class="rt-panel-icon-attention" style="color:red;">
						'._x('If you are planning to use Revolution Slider, install and/or activate it first to import the demo sliders.','Admin Panel','naturalife').'
						<a href="'.admin_url( 'themes.php?page=tgmpa-install-plugins').'">'._x('Install','Admin Panel','naturalife').' & '._x('activate','Admin Panel','naturalife').'</a>
					</li>						
			';
		}

		$is_elementor_installed = class_exists("Elementor\Plugin") ? "true" : "false";
		$is_vc_installed = class_exists("Vc_Manager") ? "true" : "false"; 
		$is_revslider_installed = class_exists("RevSliderFront") ? "true" : "false"; 

 		echo '
 			<div class="wrap" id="rt_demo_import_settings">					
				
				<div class="import_desc">
					<p>
						'._x('This demo importer tool will help you to import a demo website of the theme to let you have a quick start or learn how it is done. Please carefully read the following remarks before start.','Admin Panel','naturalife').'
					</p>

					<h2 class="important">'. _x('STEP 1: Notes','Admin Panel','naturalife') .'</h2>
					<ul>
						<li class="rt-panel-icon-check">
							'._x('It is always recommended to use this tool with a clean install to get a perfect demo clone. The importer will clean the navigations and replace with the demo navigations.','Admin Panel','naturalife').'
						</li>						
						<li class="rt-panel-icon-check">
							<strong>'._x('Do not close this window before the import process completed.','Admin Panel','naturalife').'</strong>
						</li>
						<li class="rt-panel-icon-check">
							'._x('Select your home page from Settings -> Reading -> Front page displays -> Front page, after the demo contents installed.','Admin Panel','naturalife').'
						</li>
						'.$plugin_messages.'					
					</ul>
				</div>
 
				<form class="wp-upload-form" method="get">

					<h2 class="important">'. _x('STEP 2: Import','Admin Panel','naturalife') .'</h2>

					<!--	<img class="demo-image"  src="'.RT_THEMEADMINURI .'/images/skins/1.png" data-base_url="'.RT_THEMEADMINURI .'" /> -->

					<table>
						<tr>
							<td class="parts">
								<p>

									<input type="hidden" value="import" name="action">

									<label for="upload">'._x('Select parts','Admin Panel','naturalife').':</label>

									<select name="parts" id="rt-demo-parts" autocomplete="off">
										<option value="">'._x('Select','Admin Panel','naturalife').'</option>
										<option value="all">'._x('All','Admin Panel','naturalife').'</option>
										<option value="contents">'._x('Contents & Media','Admin Panel','naturalife').'</option>
										<option value="widgets">'._x('Widgets','Admin Panel','naturalife').'</option>
										<option value="options">'._x('Theme Options','Admin Panel','naturalife').'</option>
										<option value="revslider" data-active="'.$is_revslider_installed.'">'._x('Revolution Slider Samples','Admin Panel','naturalife').'</option>
									</select>

									<input type="hidden" value="import" name="action"> 

								</p>
							</td> 

						</tr>
					</table>

					<div id="contents-result" class="">
						<p>
						<span class="animate-spin">'._x('Importing Contents:','Admin Panel','naturalife').' <strong></strong></span>
						<span class="ok">'._x('Contents has been imported','Admin Panel','naturalife').'</span>
						<span class="failed">'._x('Error','Admin Panel','naturalife').'</span>
						<a href="#" class="see_logs">see the logs</a></p>
						<p class="logs"></p>
					</div>
					<div id="widgets-result" class="">
						<p>
						<span class="animate-spin">'._x('Importing widgets','Admin Panel','naturalife').'</span>
						<span class="ok">'._x('Widgets has been imported','Admin Panel','naturalife').'</span>
						<span class="failed">'._x('Error','Admin Panel','naturalife').'</span>
						<a href="#" class="see_logs">see the logs</a></p>
						<p class="logs"></p>
					</div>
					<div id="options-result" class="">
						<p>
						<span class="animate-spin">'._x('Importing theme options','Admin Panel','naturalife').'</span>
						<span class="ok">'._x('Theme options has been imported','Admin Panel','naturalife').'</span>
						<span class="failed">'._x('Error','Admin Panel','naturalife').'</span>
						<a href="#" class="see_logs">see the logs</a></p>
						<p class="logs"></p>						
					</div>

					<div id="revslider-result" class="">
						<p>
						<span class="animate-spin">'._x('Importing Revolution Slider samples','Admin Panel','naturalife').'</span>
						<span class="ok">'._x('Revolution Slider samples has been imported','Admin Panel','naturalife').'</span>
						<span class="failed">'._x('Error','Admin Panel','naturalife').'</span>
						<a href="#" class="see_logs">see the logs</a></p>
						<p class="logs"></p>						
					</div>

					<p class="submit"><input id="rt-demo-import-button" type="button" value="'._x('Start Importing','Admin Panel','naturalife').'" class="button button-primary" name="submit"></p>

				</form>
			</div>
		';
	
		echo '</div>';
	}

	/**
	 * Demo Import Process
	 */
	public function demo_import()
	{	

		//check the current user access 
		if ( ! current_user_can( $this->capability ) ){
			return;
		}

		//check
		if( ! isset( $_GET['action'] ) || ! isset( $_GET['part'] ) ){
			return;
		}

		if( $_GET['action'] != "demo_import" ){
			return;
		}

		//file server		
		$file_server = "http://rtthemes.com/demo-imports/naturalife/";

		//file locations
		$file_location = "internal";		


		define('WP_LOAD_IMPORTERS', true);

		//demo
		$demo = isset( $_GET['demo'] ) && ! empty( $_GET['demo'] ) ? intval( $_GET['demo'] ) : 1;
			
		//contens & media
		if( $_GET['part'] == "contents" ){	

			//step
			$step = $_GET['step'];


			// Load Importer API
			require_once ABSPATH . 'wp-admin/includes/import.php';

			if ( ! class_exists( 'WP_Importer' ) ) {
				$class_wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
				if ( file_exists( $class_wp_importer ) ){
					require $class_wp_importer;
				}
			}

			if ( class_exists( 'WP_Importer' ) ) {
				include( RT_EXTENSIONS_PATH ."/inc/imports/wordpress-importer.php" );
			}else{
				echo "{{importer_error}}";
				_ex("ERROR: IMPORTER COULD NOT FOUND",'Admin Panel','naturalife');
				die();
			}

			if ( ! class_exists( 'WP_Import' ) ) {
				echo "{{importer_error}}";
				_ex("ERROR: IMPORTER COULD NOT FOUND",'Admin Panel','naturalife');
				die();
			}

			if( $step == 1 ){
				//delete menus
				wp_delete_nav_menu( esc_html_x( 'Main Navigation' , 'Admin Panel','naturalife') );
				wp_delete_nav_menu( esc_html_x( 'Footer Navigation' , 'Admin Panel','naturalife') );
				wp_delete_nav_menu( esc_html_x( 'Side Panel Navigation' , 'Admin Panel','naturalife') );
				wp_delete_nav_menu( esc_html_x( 'Mobile Navigation' , 'Admin Panel','naturalife') );			
			}
			
			//read the file			
			if( $file_location == "external" ){
				$file_url = $file_server ."/demo-{$demo}/contents/contents_{$step}.xml";
				$file_name = "contents_{$step}.xml";
				
				$get_file = $this->get_external_content( "dir", $file_url , $file_name );

				if( $get_file["error"] ){
					echo $get_file["error_message"];
					die();
				}else{
					$content_xml = $get_file["content"];	
				}				

			}else{
				$content_xml = RT_EXTENSIONS_PATH ."/inc/imports/demos/demo-{$demo}/contents/contents_{$step}.xml";
			}

			echo "----- STEP {$step} -----\n\n<br />";

			if( ! is_file( $content_xml ) ) {
				echo "{{importer_error}}";
				echo sprintf( _x("The dummy content file is not available or could not be read in <pre>%s/inc/imports/demos/.</pre>", 'Admin Panel','naturalife' ), RT_EXTENSIONS_PATH );
				die();
			} else {
				$wp_import = new WP_Import();
				$wp_import->fetch_attachments = true;
				$wp_import->import($content_xml);			
			}	
			if( $step == 10 ){
				do_action('rt_flush_rewrite_rules' );
			}
		}

		//widgets
		if( $_GET['part'] == "widgets" ){

			//remove default widgets
			delete_option("widget_search");
			delete_option("widget_categories");
			delete_option("widget_recent-posts");
			delete_option("widget_recent-comments");
			delete_option("widget_meta");
			delete_option("widget_archives");
			
			if ( ! function_exists("wie_import_data") ) {
				include( RT_EXTENSIONS_PATH ."/inc/imports/widgets-importer.php" );
			}
	
			//read the file
			if( $file_location == "external" ){

				$file_url = $file_server ."/demo-{$demo}/widgets.txt";	
				$get_file = $this->get_external_content( "content", $file_url );

				if( $get_file["error"] ){
					echo $get_file["error_message"];
					die();
				}else{
					$data = $get_file["content"];	
				}				

				$widgets_data = json_decode( $data );

			}else{
				require RT_EXTENSIONS_PATH ."/inc/imports/demos/demo-{$demo}/widgets.php";
				$widgets_data = json_decode( $data );				
			}

			wie_import_data( $widgets_data );
			
			echo _x('Done','Admin Panel','naturalife' );

		}

		//theme options
		if( $_GET['part'] == "options" ){


			//read the file
			if( $file_location == "external" ){

				$file_url = $file_server ."/demo-{$demo}/theme-options.txt";	
				$get_file = $this->get_external_content( "content", $file_url );

				if( $get_file["error"] ){
					echo $get_file["error_message"];
					die();
				}else{
					$skin_data = $get_file["content"];	
				}				
				
			}else{
				require RT_EXTENSIONS_PATH ."/inc/imports/demos/demo-{$demo}/theme-options.php";
			}

			//decode
			$settings = unserialize( base64_decode( $skin_data )); 

			//import now
			$get_options = RTFramework_Customize_Panel()->all_options;

			foreach ($settings as $name => $value) {
				if( isset( $get_options[$name] ) ){

					//replaces
					$value = str_replace("{{theme-image-directory}}", get_template_directory_uri()."/images/", $value );
					$value = $name == RT_EXTENSIONS_SLUG."_maintenance_mode" ? "" : $value;

					set_theme_mod( $name, $value );
				}
			}

			_ex("Settings imported successfully.",'Admin Panel','naturalife');

			//actions
			sleep(0.25);
			do_action( 'rtframework_after_reset' );

		}

		//revslider
		if( $_GET['part'] == "revslider" ){

			if ( class_exists( "RevSliderFront" ) ){

				$absolute_path = __FILE__;
				$path_to_file = explode( 'wp-content', $absolute_path );
				$path_to_wp = $path_to_file[0];

				require_once( $path_to_wp.'/wp-load.php' );
				require_once( $path_to_wp.'/wp-includes/functions.php');

				$slider_array = array("naturalife.zip","naturalife-2.zip");

				$import_path = RT_EXTENSIONS_PATH ."/inc/imports/demos/demo-{$demo}/revslider/";	

				$slider = new RevSlider();
				
				$log = "";

				foreach($slider_array as $filepath){
					$response = $slider->importSliderFromPost(true,true,$import_path.$filepath);  

					if($response["success"] == false){
						$message = $response["error"];
						echo "{{importer_error}}";
						echo $response["error"];
						die();
					}

				}

				echo _x('Done','Admin Panel','naturalife' );				
			}
		}

		die();
	}

	/**
	 * Export options page
	 */
	public function export_page()
	{	
		?>
			<div class="wrap" id="">
					<h2><?php _ex( 'Export Theme Customizations', 'Admin Panel','naturalife' ); ?></h2>

					<p><?php _ex( 'Click to the export button to download the settings.', 'Admin Panel','naturalife' ); ?></p>

					<form novalidate="novalidate" action="" method="post">
						<p class="submit"><input name="submit" id="submit" class="button button-primary" value="<?php _ex( 'Export', 'Admin Panel','naturalife' ); ?>" type="submit"></p>
						<input type="hidden" name="action" value="download">
					</form>

			</div>
		<?php
	}

	/**
	 * Export Settings
	 */
	public function export_settings()
	{
		if ( ! current_user_can( "edit_theme_options" ) ){
			return;
		}

		//check
		if( ! isset( $_GET['page'] ) || ! isset( $_POST['action'] ) ){
			return ;
		}

		if( $_GET['page'] != "rt_export" || $_POST['action'] != "download" ){
			return ;
		}


		// server time 
		$file_time = date('y-M-d-H-i-s');

		// sent file to user
		header('Content-type: text/plain');  
		header('Content-Disposition: attachment; filename=" '.get_bloginfo('name').' Theme Settings '.$file_time.'.txt"'); 


		print base64_encode( serialize( get_theme_mods() ) ); //write into the export file

		die();
	}

	/**
	 * Import settings page
	 */
	public function import_page()
	{	

		//import form
		$file_byte     = wp_max_upload_size() ;
		$file_size     = size_format( $file_byte );
		$wp_upload_dir = wp_upload_dir();

		//check if multisite
		$multisite_notice = "";
		if ( is_multisite() ) {
		 	$multisite_notice = '<strong>'._x('NOTE 3:','Admin Panel','naturalife').'</strong>';
		 	$multisite_notice .= _x('You need to add "txt" in your allowed file types list before upload the file if it does not exist. For further reading: http://premium.wpmudev.org/blog/how-to-change-the-allowed-file-upload-types-in-wordpress-multisite/','Admin Panel','naturalife');
		}

		if ( ! empty( $wp_upload_dir['error'] ) ){
			echo "<h3>"._ex("ERROR",'Admin Panel','naturalife').":</h3><br />".$wp_upload_dir['error'];
		}else{

	 		echo '
	 			<div class="wrap" id="rt_import_settings">

					<h2>'._x('Import Customizations','Admin Panel','naturalife').'</h2>
					
					<div class="import_desc">
						<p>
							'._x('Upload your exported settings (txt) file and to import.','Admin Panel','naturalife').'<br />  
							'._x('<strong>NOTE 1: </strong> This importer will overwrite to the current settings.','Admin Panel','naturalife').'<br />
							'._x('<strong>NOTE 2: </strong> This tool will only import the settings. You need to upload your images that used within settings and correct the image urls by manually after settings imported.','Admin Panel','naturalife').'<br />
							'.$multisite_notice.'
						</p>
					</div>
	 
					<form class="wp-upload-form" action="" method="post" enctype="multipart/form-data">
						<p>
							<label for="upload">'._x('Choose a file from your computer','Admin Panel','naturalife').':</label> ('.sprintf( _x('Maximum size: %s', 'Admin Panel','naturalife' ), $file_size ).') <input type="file" size="25" name="import" id="upload">
							<input type="hidden" value="import" name="action">
						</p>

						<p class="submit"><input type="submit" value="'._x('Upload file and import','Admin Panel','naturalife').'" class="button" name="submit"></p>

					</form>

				</div>
			';
		}
	}	

	/**
	 * Import Settings
	 */
	public function import_settings()
	{

		global $wp_filesystem;
		
		//check the current user access 
		if ( ! current_user_can( $this->capability ) ){
			return ;
		}

		//check
		if( ! isset( $_GET['page'] ) || ! isset( $_POST['action'] ) ){
			return ;
		}

		if( $_GET['page'] != "rt_import" || $_POST['action'] != "import" ){
			return ;
		}

		//include wp handle upload
		if ( ! function_exists( 'wp_handle_upload' ) ){
			require_once( ABSPATH . 'wp-admin/includes/file.php' );
		}

		$uploadedfile = isset( $_FILES['import'] ) ? $_FILES['import'] : "";

		if ( ! $uploadedfile ) {
			$error = _x("No file selected", 'Admin Panel','naturalife') . $uploadedfile["error"];

			$this->add_notices($error);			
			return false; 
		}

		//check upload error
		if ( $uploadedfile && $uploadedfile["error"] ) {
			$error = _x("Error!", 'Admin Panel','naturalife') . $uploadedfile["error"];

			$this->add_notices($error);
			return false;
		}

		//check file type
		if ( $uploadedfile && $uploadedfile["type"] != "text/plain" ) {
			$error = _x("Invalid file type!", 'Admin Panel','naturalife'); 

			$this->add_notices($error);
			return false;
		}

		$upload_overrides = array( 'test_form' => false );
		$movefile = wp_handle_upload( $uploadedfile, $upload_overrides );

		if ( isset( $movefile ) ) {

			//check file error
			if ( $movefile && isset( $movefile["error"] ) ) {
				$error = _x("Error!", 'Admin Panel','naturalife') . $movefile["error"];
 
				$this->add_notices($error);
				return false;
			}

			//Get Credentials
			$url = wp_nonce_url('admin.php?page=rt_import&action=import','rt-theme-import');
			if (false === ( $creds = request_filesystem_credentials($url, '', false, false, null ) ) ) {
				return; // stop processing here
			}

			//Initialize WP_Filesystem_Base   
			if ( ! WP_Filesystem( $creds ) ) {
				request_filesystem_credentials($url, '', true, false, null);
				return;
			}

			$file_content = $wp_filesystem->get_contents( $movefile["file"] );			


			//check file content
			if( empty( $file_content ) ){
				$error = _x("This file is empty!", 'Admin Panel','naturalife') . $movefile["error"];

				$this->add_notices($error);
				return false;
			}

			//decode
			$settings = unserialize( base64_decode( $file_content )); 

			if( ! is_array( $settings ) ){
				$error = _x("This settings file is broken!", 'Admin Panel','naturalife') . $movefile["error"];

				$this->add_notices($error);			
				return false;
			}

			//import now
			foreach ($settings as $name => $value) {
				set_theme_mod( $name, str_replace("{{theme-image-directory}}", get_template_directory_uri()."/images/", $value ) );
			}

			$this->add_notices( _x("Settings imported successfully.",'Admin Panel','naturalife') ,"updated" );

			//actions
			do_action( 'rtframework_after_reset' );

		} else {
			//Possible file upload attack!

			$error = _x("File cannot be uploaded!", 'Admin Panel','naturalife');
			$this->add_notices($error);

			return false;
		}
	}	

	/**
	 * Custom CSS Page
	 */
	public function custom_css_page()
	{	
		?>
			<div class="wrap" id="rt_theme_custom_css">
					<h2><?php _ex( 'Custom CSS', 'Admin Panel','naturalife' ); ?></h2>

					<p><?php _ex( 'Enter your custom CSS into the text area below', 'Admin Panel','naturalife' ); ?></p>

					<form action="<?php echo wp_nonce_url(admin_url('admin.php?page=rt_custom_css')); ?>" method="post" enctype="multipart/form-data">
						<p class="textarea"><textarea name="custom_css" id="css" class="textarea rt_custom_css" cols="120" rows="40"><?php echo stripcslashes( get_option( RT_THEMESLUG."_user_custom_css") ); ?></textarea></p>

						<p class="submit"><input name="submit" id="submit" class="button button-primary" value="<?php _ex( 'Update', 'Admin Panel','naturalife' ); ?>" type="submit"></p>
						<input type="hidden" name="action" value="save">
					</form>

			</div>
		<?php
	}


	/**
	 * Custom CSS Customize
	 */
	public function custom_css()
	{		

		//check the current user access 
		if ( ! current_user_can( $this->capability ) ){
			return ;
		}		
		 
		//check
		if( ! isset( $_GET['page'] ) || ! isset( $_POST['action'] ) ){
			return ;
		}

		if( $_GET['page'] != "rt_custom_css" || $_POST['action'] != "save" ){
			return ;
		}

		$this->add_notices(esc_html_x( 'Custom CSS File Updated!', 'Admin Panel','naturalife' ),"updated");

		if( isset( $_POST['custom_css'] ) ){
			update_option( RT_THEMESLUG."_user_custom_css", $_POST['custom_css'] );	
		}
		
		update_option( RT_THEMESLUG."_custom_css_output", "");
		
		//actions
		do_action( 'rtframework_after_user_custom_css' );
	}


	/**
	 * Reset Options Page
	 */
	public function reset_page()
	{	
		?>
			<div class="wrap" id="rt_theme_reset_settings">
					<h2><?php _ex( 'Reset Theme Customizations', 'Admin Panel','naturalife' ); ?></h2>

					<p><?php printf( esc_html_x( 'Click to the reset button to reset all the theme settings to default values that changed by using the %sCustomizer%s', 'Admin Panel','naturalife' ), '<a href="'.wp_nonce_url(admin_url('admin.php')).'">', '</a>' ); ?></p>

					<p><strong><?php printf( esc_html_x( 'Dont\' forget to %sExport%s the settings before if you want to save them.', 'Admin Panel','naturalife' ), '<a href="'.wp_nonce_url(admin_url('admin.php?page=rt_export')).'">', '</a>' ); ?></strong></p>

					<form action="<?php echo wp_nonce_url(admin_url('admin.php?page=rt_reset')); ?>" method="post">
						<p class="submit"><input name="submit" id="submit" class="button button-primary" value="<?php _ex( 'Reset', 'Admin Panel','naturalife' ); ?>" type="submit"></p>
						<input type="hidden" name="action" value="reset_settings">
					</form>

			</div>
		<?php
	}


	/**
	 * Reset Theme Customize
	 */
	public function reset_settings()
	{		

		//check the current user access 
		if ( ! current_user_can( $this->capability ) ){
			return ;
		}		
		 
		//check
		if( ! isset( $_GET['page'] ) || ! isset( $_POST['action'] ) ){
			return ;
		}

		if( $_GET['page'] != "rt_reset" || $_POST['action'] != "reset_settings" ){
			return ;
		}

		$this->add_notices( esc_html_x( 'Theme settings resetted to their default values.', 'Admin Panel','naturalife' ),"update-nag");

		
		//remove_theme_mods();
		update_option( RT_THEMESLUG."_custom_css_output", "");
		RTFramework_Customize_Panel()->save_defaults("true"); 

	}

	/**
	 * Custom Fonts Page
	 */
	public function custom_fonts_page()
	{	
		//get saved fonts 
		$saved_fonts = get_option( RT_THEMESLUG ."_custom_fonts" );

		$upload_path = wp_upload_dir();
		$recommended_dir = $upload_path['basedir']."/custom_fonts";
		$recommended_url = $upload_path['baseurl']."/custom_fonts";
	?>		
		<div class="wrap" id="rt_theme_custom_fonts">
			<h2><?php _ex('Custom Fonts','Admin Panel','naturalife')?></h2>

			<hr />	

			<form action="<?php echo wp_nonce_url(admin_url('admin.php?page=rt_custom_fonts')); ?>" method="post" enctype="multipart/form-data">
					<input type="hidden" value="save_custom_fonts" name="action">

					<?php
						//Saved fonts
						if( ! empty( $saved_fonts ) ):

				
		
							//list previously save fonts
							foreach ( unserialize( $saved_fonts ) as $key => $font):

								$font["font-type"] = ! isset( $font["font-type"] ) ? "self-hosted" : $font["font-type"];
								$font["kitid"] = isset( $font["kitid"] ) ? $font["kitid"] : ""; 
							?>	
							<div class="font-holder">		
								<h3 class="title"><?php echo $font["family_name"] ?> <span class="delete-font"><?php _ex("remove this font",'Admin Panel','naturalife')?></span></h3>

								<table class="form-table">
									<tbody>

										<tr>
											<th scope="row">
												<label for="eot"><?php _ex("Font Type",'Admin Panel','naturalife')?></label>
											</th>
											<td>
												<div class="upload">
													<select name="rt_custom_fonts[<?php echo $key;?>][font-type]" class="rt-font-type" autocomplete="off">
														<option value="self-hosted" <?php echo $font["font-type"] == "self-hosted" ? "selected" : "" ?>><?php _ex("Self Hosted",'Admin Panel','naturalife') ?></option>
														<option value="typekit" <?php echo $font["font-type"] == "typekit" ? "selected" : "" ?>><?php _ex("Typekit",'Admin Panel','naturalife')?></option>
														<option value="external" <?php echo $font["font-type"] == "external" ? "selected" : "" ?>><?php _ex("Other",'Admin Panel','naturalife')?></option>
													</select>
												</div>
											</td>
										</tr> 	

										<tr>
											<th scope="row">
												<label for="eot"><?php _ex("Font Family Name",'Admin Panel','naturalife')?></label>
											</th>
											<td>
												<div class="upload">
													<input name="rt_custom_fonts[<?php echo $key;?>][family_name]" type="text" autocomplete="off" value="<?php echo $font["family_name"] ?>">
												</div>
											</td>
										</tr> 	

										<tr class="kitid">
											<th scope="row">
												<label for="eot"><?php _ex("Kit ID",'Admin Panel','naturalife')?></label>
											</th>
											<td>
												<div class="upload">
													<input name="rt_custom_fonts[<?php echo $key;?>][kitid]" type="text" autocomplete="off" value="<?php echo $font["kitid"] ?>">
												</div>
											</td>
										</tr> 										

										<tr class="self_hosted_font">
											<th scope="row">
												<label for="eot"><?php _ex("EOT file URL",'Admin Panel','naturalife')?></label>
											</th>
											<td>
												<div class="upload">
													<input name="rt_custom_fonts[<?php echo $key;?>][eot]" type="text" autocomplete="off" class="large-text" value="<?php echo $font["eot"] ?>">						
												</div>
											</td>
										</tr> 

										<tr class="self_hosted_font">
											<th scope="row">
												<label for="woff"><?php _ex("WOFF file URL",'Admin Panel','naturalife')?></label>
											</th>
											<td>
												<div class="upload">
													<input name="rt_custom_fonts[<?php echo $key;?>][woff]" type="text" autocomplete="off" class="large-text" value="<?php echo $font["woff"] ?>">
												</div>
											</td>
										</tr> 

										<tr class="self_hosted_font">
											<th scope="row">
												<label for="woff"><?php _ex("WOFF2 file URL",'Admin Panel','naturalife')?></label>
											</th>
											<td>
												<div class="upload">
													<input name="rt_custom_fonts[<?php echo $key;?>][woff2]" type="text" autocomplete="off" class="large-text" value="<?php echo $font["woff2"] ?>">
												</div>
											</td>
										</tr> 

										<tr class="self_hosted_font">
											<th scope="row">
												<label for="woff"><?php _ex("TTF file URL",'Admin Panel','naturalife')?></label>
											</th>
											<td>
												<div class="upload">
													<input name="rt_custom_fonts[<?php echo $key;?>][ttf]" type="text" autocomplete="off" class="large-text" value="<?php echo $font["ttf"] ?>">
												</div>
											</td>
										</tr> 

										<tr class="self_hosted_font">
											<th scope="row">
												<label for="woff"><?php _ex("SVG file URL",'Admin Panel','naturalife')?></label>
											</th>
											<td>
												<div class="upload">
													<input name="rt_custom_fonts[<?php echo $key;?>][svg]" type="text" autocomplete="off" class="large-text" value="<?php echo $font["svg"] ?>">
												</div>
											</td>
										</tr> 

									</tbody>
								</table>
								
								<hr />	
							</div>
					<?php 
							endforeach;
						endif;
					?>

					<h3 class="title"><?php _ex('New Font','Admin Panel','naturalife')?></h3>

					<p>
						<?php printf(
						_x('You can add your own fonts, typekit or another external font family by using the form below. The new font will be dispayed in the font list along with Google Fonts and WebSafe Fonts inside the Typography Options of the Customize Panel. In order to use a self hosted font please upload the font files into the %s folder. Create the folder if it does not exists. Then type their full urls like shown in the form. You can use any file name for the custom font but make sure it is url frienly like %s. For %s fonts, the font family name must be the same as Typekit website.','Admin Panel','naturalife'),
						'<code>'.$recommended_dir.'</code>',
						'<code>font-name</code>',
						'<a href="http://typekit.com" target="_new">Typekit</a>'); 
						?>
					</p>

					<table class="form-table">
						<tbody>
							<tr>
								<th scope="row">
									<label for="eot"><?php _ex("Font Type",'Admin Panel','naturalife')?></label>
								</th>
								<td>
									<div class="upload">
										<select name="rt_custom_fonts[new][font-type]" class="rt-font-type" autocomplete="off">
											<option value="self-hosted"><?php _ex("Self Hosted",'Admin Panel','naturalife')?></option>
											<option value="typekit"><?php _ex("Typekit",'Admin Panel','naturalife')?></option>
											<option value="external"><?php _ex("Other",'Admin Panel','naturalife')?></option>
										</select>
									</div>
								</td>
							</tr> 	

							<tr>
								<th scope="row">
									<label for="eot"><?php _ex("Font Family Name",'Admin Panel','naturalife')?></label>
								</th>
								<td>
									<div class="upload">
										<input name="rt_custom_fonts[new][family_name]" type="text" autocomplete="off" placeholder="<?php _ex("My Custom Font",'Admin Panel','naturalife')?>">
									</div>
								</td>
							</tr> 

							<tr class="kitid">
								<th scope="row">
									<label for="eot"><?php _ex("Kit ID",'Admin Panel','naturalife')?></label>
								</th>
								<td>
									<div class="upload">
										<input name="rt_custom_fonts[new][kitid]" type="text" autocomplete="off" placeholder="<?php _ex("Typekit Kit ID",'Admin Panel','naturalife')?>">
									</div>
								</td>
							</tr> 										

							<tr class="self_hosted_font">
								<th scope="row">
									<label for="eot"><?php _ex("EOT file URL",'Admin Panel','naturalife')?></label>
								</th>
								<td>
									<div class="upload">
										<input name="rt_custom_fonts[new][eot]" type="text" autocomplete="off" class="large-text" size="130" placeholder="<?php echo esc_url($recommended_url); ?>/your-custom-font.eot">
									</div>
								</td>
							</tr> 

							<tr class="self_hosted_font">
								<th scope="row">
									<label for="woff"><?php _ex("WOFF file URL",'Admin Panel','naturalife')?></label>
								</th>
								<td>
									<div class="upload">
										<input name="rt_custom_fonts[new][woff]" type="text" autocomplete="off" class="large-text" size="130" placeholder="<?php echo esc_url($recommended_url); ?>/your-custom-font.woff">
									</div>
								</td>
							</tr> 

							<tr class="self_hosted_font">
								<th scope="row">
									<label for="woff"><?php _ex("WOFF2 file URL",'Admin Panel','naturalife')?></label>
								</th>
								<td>
									<div class="upload">
										<input name="rt_custom_fonts[new][woff2]" type="text" autocomplete="off" class="large-text" size="130" placeholder="<?php echo esc_url($recommended_url); ?>/your-custom-font.woff2">
									</div>
								</td>
							</tr> 

							<tr class="self_hosted_font">
								<th scope="row">
									<label for="woff"><?php _ex("TTF file URL",'Admin Panel','naturalife')?></label>
								</th>
								<td>
									<div class="upload">
										<input name="rt_custom_fonts[new][ttf]" type="text" autocomplete="off" class="large-text" size="130" placeholder="<?php echo esc_url($recommended_url); ?>/your-custom-font.ttf">
									</div>
								</td>
							</tr> 

							<tr class="self_hosted_font">
								<th scope="row">
									<label for="woff"><?php _ex("SVG file URL",'Admin Panel','naturalife')?></label>
								</th>
								<td>
									<div class="upload">
										<input name="rt_custom_fonts[new][svg]" type="text" autocomplete="off" class="large-text" size="130" placeholder="<?php echo esc_url($recommended_url); ?>/your-custom-font.svg">
									</div>
								</td>
							</tr> 
																					
						</tbody>
					</table> 

					<hr />	

					<?php echo submit_button();?>				
			</form>
		</div>
    
		<?php	
	}

	/**
	 * Save Custom Fonts
	 */
	public function save_custom_fonts()
	{

		//check the current user access 
		if ( ! current_user_can( $this->capability ) ){
			return ;
		}

		//check
		if( ! isset( $_GET['page'] ) || ! isset( $_POST['action'] ) || ! isset( $_POST['rt_custom_fonts'] ) ){
			return ;
		}

		if( $_GET['page'] != "rt_custom_fonts" || $_POST['action'] != "save_custom_fonts" ){
			return ;
		}

		$rt_custom_fonts = $_POST['rt_custom_fonts'];

 		if( 
			empty( $rt_custom_fonts["new"]["eot"] ) &&
			empty( $rt_custom_fonts["new"]["ttf"] ) && 
			empty( $rt_custom_fonts["new"]["woff2"] ) && 
			empty( $rt_custom_fonts["new"]["woff"] ) && 
			empty( $rt_custom_fonts["new"]["svg"] )  &&
			empty( $rt_custom_fonts["new"]["kitid"] ) && 
			empty( $rt_custom_fonts["new"]["family_name"] )
 		){

 			unset($rt_custom_fonts["new"]);

 		}else{
 	
			$family_name = ! empty( $rt_custom_fonts["new"]["family_name"] ) ? $rt_custom_fonts["new"]["family_name"] : 'custom-font-'.rand(100000, 1000000);

			//add the new font to the list
			$rt_custom_fonts[$family_name] = $rt_custom_fonts["new"];
			unset($rt_custom_fonts["new"]);

 		}

 		if( ! empty( $rt_custom_fonts ) ){
			update_option( RT_THEMESLUG ."_custom_fonts",  serialize( $rt_custom_fonts ) );			
			$this->add_notices( esc_html_x("Custom fonts list updated successfully.",'Admin Panel','naturalife') ,"updated" );
 		}else{
 			delete_option( RT_THEMESLUG ."_custom_fonts" );			
 		}

	}

	/**
	 * Contact Form 7 Email Fixes
	 *
	 * Replace sample emails with users email which used in the demo cotnents
	 * 
	 */
	public function cf7_mail_fix( $postmeta )
	{

		$post['postmeta'] = $postmeta;
		$current_user = wp_get_current_user();
		
		if ( ! empty( $post['postmeta'] ) ) {
			foreach ( $post['postmeta'] as $meta_key => $meta ) {
				$key = $meta['key'];
			 
				if ( '_mail' == $key ) {

					$value = maybe_unserialize( $meta['value'] );
					$new_value = array();

					if( is_array( $value) ){
						foreach ($value as $v_key => $v_value) {
							$new_value[$v_key] = str_replace("mail@your-website.com", $current_user->user_email, $v_value ); 
						}	

						$post['postmeta'][$meta_key]['value'] = serialize( $new_value );				
					}
				}
			}
		}	

		return $post['postmeta'];
	 
	}		


	/**
	 * Get external content for importer
	 *
	 * @return array["error"=>"","content"=>file dir or file content] 
	 *
	 * 
	 */
	public function get_external_content( $output_type = "dir", $file_url = "", $file_name = "" )
	{	
		$output = array("error"=>false,"error_message"=>"","content"=>"");

		if( empty( $file_url ) ){
			$output["error"] = true;
			return;
		}

		$get_file = wp_remote_get( $file_url, array( 'timeout' => 90, 'httpversion' => '1.1' ) ); 

		//wperror file could not be opened
		if ( is_wp_error( $get_file ) ) {
			
			$error_string = $get_file->get_error_message();

			$output["error"] = true;
			$output["error_message"] .= "{{importer_error}}";
			$output["error_message"] .= "Import file could not be opened!<br />";
			$output["error_message"] .= $error_string;
			 
			return $output;
		}

		//not found
		if ( isset( $get_file["response"] ) && $get_file["response"]["code"] !== 200  ) {

			$output["error"] = true;
			$output["error_message"] .= "{{importer_error}}";
			$output["error_message"] .= "Import file could not be read!<br />";
			$output["error_message"] .= $get_file["response"]["message"];			 

			return $output;			
		}

		//success 
		if ( isset( $get_file["response"] ) && $get_file["response"]["code"] === 200  ) {

			if( $output_type == "dir" ){

				//get xml content & store 
				global $wp_filesystem;

				if (empty($wp_filesystem)) {
					require_once (ABSPATH . '/wp-admin/includes/file.php');
					WP_Filesystem();
				}
	 	
	 			//dir
				$upload_path = wp_upload_dir();
				$dir = $upload_path['basedir'] ."/". strtolower(RT_THEMESLUG). "-demo-imports/";			

				//create dir 
				if( ! $wp_filesystem->is_dir( $dir ) ) {
					@$wp_filesystem->mkdir( $dir );
				}

				//check if dir writable
				if( ! is_writable( $dir ) && ! $wp_filesystem ){

					$output["error"] = true;
					$output["error_message"] .= "{{importer_error}}";
					$output["error_message"] .= "Import file could not be stored!";

					return $output;								
				}

				//write the file
				$wp_filesystem->put_contents(
					$dir."/".$file_name,
					$get_file["body"],
					FS_CHMOD_FILE // predefined mode settings for WP files
				); 				

				$output["content"] = $dir."/".$file_name;
				return $output;	

			}else{
				$output["content"] = $get_file["body"];
				return $output;					
			}		

		}else{

			$output["error"] = true;
			$output["error_message"] .= "{{importer_error}}";
			$output["error_message"] .= "Import failed!";
			
			return $output;	
		}
	}

}

new RT_Tools();