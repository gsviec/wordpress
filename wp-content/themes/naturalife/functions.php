<?php 
/**
 * RT-THEME Main Functions File
 *
 * @author 		RT-Themes
 * @package 	RT-Framework/Functions
 * @since 		1.0
 * @version    1.0
 */

if( ! function_exists("rtframework_check_WP_version") ){
	/**
	 *  Check WordPress Version
	 * @return bool              
	 */
	function rtframework_check_WP_version(){
		global $wp_version;

		if (version_compare($wp_version,"4.8","<"))
		{
			return '
				<div id="notice" class="error"><p><strong><h3>
				'.esc_html_x("WORDPRESS VERSION ERROR!",'Admin Panel',"naturalife").'
				</h3>
				'.esc_html_x("This theme requires WordPress Version 4.8 or higher to run. Please upgrade your WordPress version!",'Admin Panel',"naturalife").'
				</strong> <br /><br /><a href="http://codex.wordpress.org/Upgrading_WordPress">
				'.esc_html_x("How can I upgrade my WordPress version?",'Admin Panel',"naturalife").'
				</a></p><br /></div>
			';
		}
		
		return false;
	}
} 
define('RT_FRAMEWOK', TRUE);

if( ! function_exists("rtframework_check_PHP_version") ){
	/**
	 *  Check PHP Version
	 * @return bool              
	 */
	function rtframework_check_PHP_version(){
		global $wp_version;

		if (version_compare(PHP_VERSION, '5.6', '<'))
		{
			return '
				<div id="notice" class="error"><p><strong><h3>
				'.esc_html_x("PHP VERSION ERROR!",'Admin Panel',"naturalife").'
				</h3>
				'.esc_html_x("This theme requires PHP Version 5.6 or higher to run. Please upgrade your PHP version!",'Admin Panel',"naturalife").'
				</strong> <br />
				'.esc_html_x("You can contact your hosting provider to upgrade PHP version of your website.",'Admin Panel',"naturalife").'
				</p></div>
			';
		}
		
		return false;
	}
} 

if ( ! function_exists("rtframework_load") ){
	/**
	 *
	 * Load the theme
	 *
	 * @return class [RT Main Class] 
	 *
	 */
	function rtframework_load(){
		
		$control_versions = rtframework_check_WP_version(); 
		$control_versions .= rtframework_check_PHP_version(); 

		if( $control_versions ){
			if(is_admin()){
				add_action( "admin_notices", function() use (&$control_versions){
					echo wp_kses_post( $control_versions );
				},10,1);				
			}
			else{
				wp_die( $control_versions );
			} 
		}else{
			require_once ( get_template_directory() . '/rt-framework/classes/loading.php' );
			$rttheme = new RTFramework();

			/*
			* 	 DO NOT CHANGE slug => "" !!! 
			*/
			$rttheme->start(array('theme' => 'NaturaLife','slug' => 'naturalife','version' => '1.0'));
			
		}	
	}
}
rtframework_load();

if ( ! isset( $content_width ) && defined("RT_CONTENT_FULL_WIDTH") ){
	/**
	 *  Define Content Width
	 */
	$content_width = RT_CONTENT_FULL_WIDTH;	
}

/* 
* Partner ID 
*/
 if ( ! defined( 'ELEMENTOR_PARTNER_ID' ) ) { 
define( 'ELEMENTOR_PARTNER_ID', 999999 ); 
}