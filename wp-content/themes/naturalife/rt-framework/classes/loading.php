<?php
#-----------------------------------------
#	RT-Theme loading.php
#	version: 1.0
#-----------------------------------------

#
# 	Load the theme
#

class RTFramework{
 
	//Available Social Media Icons
	public $rtframework_social_media_icons=array(  
			"RSS"             => "rss", 
			"Email"           => "mail", 
			"Twitter"         => "twitter", 
			"Facebook"        => "facebook", 
			"Flickr"          => "flickr", 
			"Google +"        => "gplus", 
			"Pinterest"       => "pinterest", 
			"Tumblr"          => "tumblr", 
			"Linkedin"        => "linkedin", 
			"Dribbble"        => "dribbble", 
			"Skype"           => "skype", 
			"Behance"         => "behance", 
			"Github"          => "github", 
			"Vimeo"           => "vimeo", 
			"StumbleUpon"     => "stumbleupon", 
			"Lastfm"          => "lastfm", 
			"Spotify"         => "spotify", 
			"Instagram"       => "instagram", 
			"Dropbox"         => "dropbox", 
			"Evernote"        => "evernote", 
			"Flattr"          => "flattr", 
			"Paypal"          => "paypal", 
			"Picasa"          => "picasa", 
			"Vkontakte"       => "vkontakte", 
			"YouTube"         => "youtube-play", 
			"SoundCloud"      => "soundcloud",
			"Foursquare"      => "foursquare",
			"Delicious"       => "delicious",
			"Forrst"          => "forrst",
			"eBay"            => "ebay",
			"Android"         => "android", 
			"Xing"            => "xing",
			"Reddit"          => "reddit",
			"Digg"            => "digg",
			"Apple App Store" => "macstore",
			"MySpace"         => "myspace",
			"Stack Overflow"  => "stackoverflow",
			"Slide Share"     => "slideshare",
			"Weibo"           => "sina-weibo",
			"Odnoklassniki"   => "odnoklassniki",		
			"Telegram"        => "telegram",
			"WhatsApp"        => "whatsapp"				
	);
				
 
	#
	# Start
	#    
	function start($v){

		global $rtframework_social_media_icons;
		$rtframework_social_media_icons 	= apply_filters("rt_social_media_list", $this->rtframework_social_media_icons ); 
 
		//Create Menus 
		add_action('registered_taxonomy', array(&$this,'global_constants'));

		// Load text domain
		load_theme_textdomain('naturalife', get_template_directory().'/languages' );

		//Call Theme Constants
		$this->theme_constants($v);	  

		//Load Classes
		$this->load_classes($v);
		
		//Load Functions
		$this->load_functions($v);

		//Create Menus 
		add_action('after_setup_theme', array(&$this,'rt_create_menus'));
		
		//Images Sizes
		add_action('after_setup_theme', array(&$this,'image_sizes'));

		//Images Size Names
		add_filter( 'image_size_names_choose', array(&$this,'image_size_names'));

		//Theme Supports
		add_action('after_setup_theme', array(&$this,'theme_supports')); 

		//check woocommerce
		if ( class_exists( 'Woocommerce' ) ) {
			include(RT_THEMEFRAMEWORKDIR . "/functions/woo-integration.php");
		}
		
		//check bbpress
		if ( class_exists( 'bbPress' ) ) {
			include(RT_THEMEDIR . "/bbpress/bbpress-config.php");
		}	 
	}
 

	#
	#	Global Constants
	#
	function global_constants($v) {
		if( ! defined( 'RT_FRAMEWOK' ) ) define('RT_FRAMEWOK', TRUE);

	}   
	
	#
	#	Theme Constants
	#
	function theme_constants($v) {

		if( ! defined( 'RT_THEMENAME' ) ) define('RT_THEMENAME', $v['theme']);
		if( ! defined( 'RT_THEMESLUG' ) ) define('RT_THEMESLUG', $v['slug']); // a unique slugname for this theme
		if( ! defined( 'RT_COMMON_THEMESLUG' ) ) define('RT_COMMON_THEMESLUG', "rttheme"); // a commone slugnam for all rt-themes
		if( ! defined( 'RT_THEMEVERSION' ) ) define('RT_THEMEVERSION', $this->get_theme_version()); 
		if( ! defined( 'RT_THEMEDIR' ) ) define('RT_THEMEDIR', get_template_directory());
		if( ! defined( 'RT_THEMEURI' ) ) define('RT_THEMEURI', get_template_directory_uri());
		if( ! defined( 'RT_FRAMEWORKSLUG' ) ) define('RT_FRAMEWORKSLUG', 'rt-framework'); 
		if( ! defined( 'RT_THEMEFRAMEWORKDIR' ) ) define('RT_THEMEFRAMEWORKDIR', get_template_directory().'/rt-framework'); 
		if( ! defined( 'RT_THEMEADMINDIR' ) ) define('RT_THEMEADMINDIR', get_template_directory().'/rt-framework/admin');
		if( ! defined( 'RT_THEMEADMINURI' ) ) define('RT_THEMEADMINURI', get_template_directory_uri().'/rt-framework/admin');
		if( ! defined( 'RT_WPADMINURI' ) ) define('RT_WPADMINURI', get_admin_url());
		if( ! defined( 'RT_THEMESTYLE' ) ) define('RT_THEMESTYLE', get_option("naturalife_style")); 
		if( ! defined( 'RT_EXTENSIONS_PLUGIN' ) ) define('RT_EXTENSIONS_PLUGIN', "Naturalife_Extensions"); 
		if ( ! defined( 'RT_THEME_PLUGINNAME' ) )  define('RT_THEME_PLUGINNAME', 'Naturalife | Extensions Plugin' );		
		if ( ! defined( 'RT_CONTENT_FULL_WIDTH' ) )  define('RT_CONTENT_FULL_WIDTH', 1220 );  
		if ( ! defined( 'RT_CONTENT_SIDEBAR_WIDTH' ) )  define('RT_CONTENT_SIDEBAR_WIDTH', 915 );  
		if ( ! defined( 'ELEMENTOR_PARTNER_ID' ) )  define('ELEMENTOR_PARTNER_ID', 2143 );		

		//unique theme name for default settings
		if( ! defined( 'RT_UTHEME_NAME' ) ) define('RT_UTHEME_NAME', "naturalife");

		if( ! defined( 'RT_BLOGURL' ) ){
			if( function_exists('icl_get_home_url') ){
				define('RT_BLOGURL', icl_get_home_url());
			}else{
				define('RT_BLOGURL', esc_url(home_url('/')) );  
			}
		}			

	}    
	
	#
	#	Load Functions
	#
	
	function load_functions($v) {
		include(RT_THEMEFRAMEWORKDIR . "/functions/common_functions.php");		
		include(RT_THEMEFRAMEWORKDIR . "/functions/rt_comments.php");		
		include(RT_THEMEFRAMEWORKDIR . "/functions/theme_functions.php");
		include(RT_THEMEFRAMEWORKDIR . "/functions/welcome.php");
		include(RT_THEMEFRAMEWORKDIR . "/functions/rt_breadcrumb.php");
		include(RT_THEMEFRAMEWORKDIR . "/functions/wpml_functions.php");
		include(RT_THEMEFRAMEWORKDIR . "/functions/custom_styling.php");
		include(RT_THEMEFRAMEWORKDIR . "/functions/rt_resize.php");		
	}

	#
	#	Load Classes
	#
	
	function load_classes($v) {
		global $rtframework_sidebars_class, $wp_customize;

		//Backend only jobs
		if(is_admin()){		
			require_once (RT_THEMEFRAMEWORKDIR.'/classes/admin.php'); 
			$RTadmin = new RTFrameworkAdmin();
			$RTadmin->admin_init(); 
 
			//activate plugins
			include(RT_THEMEFRAMEWORKDIR . "/plugins/class-tgm-plugin-activation.php");	 
			add_action( 'tgmpa_register', array(&$this,'activate_plugins'));		
		}

		//Customize Panel
		if( is_admin() || $wp_customize ){			
			include(RT_THEMEFRAMEWORKDIR . "/classes/rt_customize_panel.php");
		}

		//Create Sidebars
		include(RT_THEMEFRAMEWORKDIR . "/classes/sidebar.php");  
		$rtframework_sidebars_class = new RTFrameworkSidebar(); 

		//is login or register page		
		$is_login = in_array( $GLOBALS['pagenow'], array( 'wp-login.php', 'wp-register.php' ));

		//Frontend only jobs
		if(!$is_login){
			require_once (RT_THEMEFRAMEWORKDIR.'/classes/theme.php'); 
			$RTFrameworkSite = new RTFrameworkSite();
			$RTFrameworkSite->theme_init();
		} 

		//Navigation Walker
		include(RT_THEMEFRAMEWORKDIR . "/classes/navigation_walker.php");

		//Common Classes
		include(RT_THEMEFRAMEWORKDIR . "/classes/common_classes.php");   
		
	}    	 

	#
	#	Create WP Menus
	#

	function rt_create_menus() {
		
		register_nav_menu( 'naturalife-main-navigation', esc_html_x( 'Main Navigation' , 'Admin Panel','naturalife') ); 
		register_nav_menu( 'naturalife-footer-navigation', esc_html_x( 'Footer Navigation' , 'Admin Panel','naturalife' ));  
		register_nav_menu( 'naturalife-mobile-navigation', esc_html_x( 'Mobile Navigation' , 'Admin Panel','naturalife' ));  

		wp_create_nav_menu( esc_html_x( 'Main Navigation' , 'Admin Panel','naturalife'), array( 'slug' => 'naturalife-main-navigation' ) ); 
		wp_create_nav_menu( esc_html_x( 'Footer Navigation', 'Admin Panel','naturalife'), array( 'slug' => 'naturalife-footer-navigation') ); 
	
	}

	#
	#	Theme Supports
	#
	 
	function theme_supports(){
 
		//Automatic Feed Links
		add_theme_support( 'automatic-feed-links' );
		
		//Let WordPress manage the document title.
		add_theme_support( 'title-tag' );		
		
		//post thumbnails
		add_theme_support( 'post-thumbnails' );  

		//woocommerce support
		add_theme_support( 'woocommerce' ); 

		//customizer
		add_theme_support( 'customize-selective-refresh-widgets' );

		//gutenberg
		add_theme_support(
			'gutenberg',
			array( 'wide-images' => true )
		);		
	}	


	/*
	 * Image Sizes
	 */	
	function image_sizes() {
		add_image_size( 'rtframework-fullwidth', RT_CONTENT_FULL_WIDTH ); 
		add_image_size( 'rtframework-sidebarwidth', RT_CONTENT_SIDEBAR_WIDTH ); 
		add_image_size( 'rtframework-two-columns', (RT_CONTENT_FULL_WIDTH - 20) / 2 ); 
		add_image_size( 'rtframework-three-columns', (RT_CONTENT_FULL_WIDTH - 40) / 3 ); 
		add_image_size( 'rtframework-four-columns', (RT_CONTENT_FULL_WIDTH - 60) / 4 ); 
	}

	/*
	 * Custom Size Names
	 */	
	function image_size_names($sizes) {
		return array_merge( $sizes, array(
			'rtframework_retina' => esc_html_x( 'HiDPI / Retina', 'Admin Panel','naturalife'),			
			'rtframework-sidebarwidth' => esc_html_x( 'Default Content Area', 'Admin Panel','naturalife'),
			'rtframework-fullwidth' => esc_html_x( 'Full Width Content Area', 'Admin Panel','naturalife'),			
			'rtframework-two-columns' => esc_html_x( 'Two Columns Size', 'Admin Panel','naturalife'),
			'rtframework-three-columns' => esc_html_x( 'Three Columns Size', 'Admin Panel','naturalife'),
			'rtframework-four-columns' => esc_html_x( 'Four Columns Size', 'Admin Panel','naturalife'),
		) );
	}

	#
	#	Get Pages as array
	#

	public static function rt_get_pages(){
		  
		// Pages		
		$pages = query_posts('posts_per_page=-1&post_type=page&orderby=title&order=ASC');
		$rt_getpages = array();
		
		if(is_array($pages)){
			foreach ($pages as $page_list ) {
				$rt_getpages[$page_list->ID] = $page_list ->post_title;
			}
		}
		
		return $rt_getpages;
		
	}


	#
	#	Get Blog Categories - only post categories
	#

	public static function rt_get_categories(){

		if( ! taxonomy_exists("category") ){
			return array();
		}

		// Categories
		$args = array(
			'type'                     => 'post',
			'child_of'                 => 0, 
			'orderby'                  => 'name',
			'order'                    => 'ASC',
			'hide_empty'               => 1,
			'hierarchical'             => 1,  
			'taxonomy'                 => 'category',
			'pad_counts'               => false
			);
		
		
		$categories = get_categories($args);
		$rt_getcat = array();
		
		if(is_array($categories)){
			foreach ($categories as $category_list ) {
				$rt_getcat[$category_list->cat_ID] = $category_list->cat_name;
			}
		}
	
		return $rt_getcat;
	}


	/**
	 * Get Theme Version 
	 *
	 * Returns the theme version of orginal theme only not childs
	 * 
	 * @return void
	 */
	public function get_theme_version(){ 

		$theme_data = wp_get_theme(); 
		$main_theme_data = $theme_data->parent(); 

		if( ! empty( $main_theme_data ) ){		
			return $main_theme_data->get("Version");
		}else{		
			return $theme_data->get("Version");
		}
	}
	

	#
	#	Include plugins
	#

	function activate_plugins() { 
 
		//activate revslider 
				$plugins = array(

					array(
						'name'                  => esc_html_x('NaturaLife | Extensions Plugin','Admin Panel','naturalife'), // The plugin name
						'slug'                  => 'naturalife-extensions', // The plugin slug (typically the folder name)
						'source'                => RT_THEMEFRAMEWORKDIR . '/plugins/packages/naturalife-extensions.zip', // The plugin source
						'required'              => true, // If false, the plugin is only 'recommended' instead of required
						'version'               => '1.3', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
						'force_activation'      => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
						'force_deactivation'    => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
						'external_url'          => '', // If set, overrides default API URL and points to an external URL
					), 

					array(
						'name'      => esc_html_x('Elementor','Admin Panel','naturalife'),
						'slug'      => 'elementor',
						'required'  => false,
					),
					array(
						'name'      => esc_html_x('Contact Form 7','Admin Panel','naturalife'),
						'slug'      => 'contact-form-7',
						'required'  => false,
					),
					
					array(
						'name'                  => esc_html_x('Slider Revolution','Admin Panel','naturalife'), // The plugin name
						'slug'                  => 'revslider', // The plugin slug (typically the folder name)
						'source'                => RT_THEMEFRAMEWORKDIR . '/plugins/packages/revslider.zip', // The plugin source
						'required'              => false, // If false, the plugin is only 'recommended' instead of required
						'version'               => '5.4.8', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
						'force_activation'      => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
						'force_deactivation'    => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
						'external_url'          => '', // If set, overrides default API URL and points to an external URL
					), 		

				);

				$builder_message = '<div class="updated" style="
					    padding: 20px;
					    border-width: 4px !important;
					    border-style: solid;
					    border-color: #46b450;
					"><p style="
					    font-size: 1.2em;
					"></p><ul>
					<li><span class="dashicons dashicons-arrow-right-alt2"></span> '.esc_html_x("You can install and update bundled premium plugins through this page. Revolution Slider plugins has been included to the theme with an exclusive sub-license. You don't need to buy and register the plugin unless you need to access their premium contents. The plugin is optional.",'Admin Panel','naturalife').'</li>
					</ul></div>';
								 


				// Change this to your theme text domain, used for internationalising strings
				$theme_text_domain = 'naturalife';
			 
				/**
				 * Array of configuration settings. Amend each line as needed.
				 * If you want the default strings to be available under your own theme domain,
				 * leave the strings uncommented.
				 * Some of the strings are added into a sprintf, so see the comments at the
				 * end of each line for what each argument will be.
				 */

				$config = array(
					'id'           => 'tgmpa',                 // Unique ID for hashing notices for multiple instances of TGMPA.
					'default_path' => '',                      // Default absolute path to bundled plugins.
					'menu'         => 'tgmpa-install-plugins', // Menu slug.
					'parent_slug'  => 'themes.php',            // Parent menu slug.
					'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
					'has_notices'  => true,                    // Show admin notices or not.
					'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
					'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
					'is_automatic' => false,                   // Automatically activate plugins after installation or not.
					'message'      => $builder_message,                      // Message to output right before the plugins table.
					'strings'           => array(
						'page_title'                                => esc_html_x( 'Install Required Plugins', 'Admin Panel','naturalife' ),
						'menu_title'                                => esc_html_x( 'Install Plugins', 'Admin Panel','naturalife' ),
						'installing'                                => esc_html_x( 'Installing Plugin: %s', 'Admin Panel','naturalife' ), // %1$s = plugin name
						'oops'                                      => esc_html_x( 'Something went wrong with the plugin API.', 'Admin Panel','naturalife' ),
						'notice_can_install_required'               => _nx_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'Admin Panel','naturalife' ), // %1$s = plugin name(s)
						'notice_can_install_recommended'            => _nx_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'Admin Panel','naturalife' ), // %1$s = plugin name(s)
						'notice_cannot_install'                     => _nx_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'Admin Panel','naturalife' ), // %1$s = plugin name(s)
						'notice_can_activate_required'              => _nx_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'Admin Panel','naturalife' ), // %1$s = plugin name(s)
						'notice_can_activate_recommended'           => _nx_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'Admin Panel','naturalife' ), // %1$s = plugin name(s)
						'notice_cannot_activate'                    => _nx_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'Admin Panel','naturalife' ), // %1$s = plugin name(s)
						'notice_ask_to_update'                      => _nx_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'Admin Panel','naturalife' ), // %1$s = plugin name(s)
						'notice_cannot_update'                      => _nx_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'Admin Panel','naturalife' ), // %1$s = plugin name(s)
						'install_link'                              => _nx_noop( 'Begin installing plugin', 'Begin installing plugins', 'Admin Panel','naturalife' ),
						'activate_link'                             => _nx_noop( 'Activate installed plugin', 'Activate installed plugins', 'Admin Panel','naturalife' ),
						'return'                                    => esc_html_x( 'Return to Required Plugins Installer', 'Admin Panel','naturalife' ),
						'plugin_activated'                          => esc_html_x( 'Plugin activated successfully.', 'Admin Panel','naturalife' ),
						'complete'                                  => esc_html_x( 'All plugins installed and activated successfully. %s', 'Admin Panel','naturalife' ) // %1$s = dashboard link
					)
				);
			 
				tgmpa( $plugins, $config );
	}

 
}


?>