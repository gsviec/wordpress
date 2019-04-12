<?php
#-----------------------------------------
#	RT-Theme admin.php
#	version: 1.0
#-----------------------------------------

#
#	Admin Class
#

class RTFrameworkAdmin extends RTFramework{

	private $panel_pages = array(); 
	private $admin_notices = array();

	function admin_init(){ 

		//admin notices 
		add_action('admin_notices', array(&$this,'rt_admin_notices')); 	

		//Load Admin Functions
		$this->load_admin_functions();

		//Load Scripts
		add_action('admin_enqueue_scripts', array(&$this,'load_admin_scripts'));
		
		//Load Styles
		add_action('admin_enqueue_scripts', array(&$this,'load_admin_styles'));	 

		//editor style
		add_action( "admin_init", array(&$this,'load_editor_style'));	 
	} 


	#
	#	Admin notices
	#
	function rt_admin_notices(){  

		if( is_array( $this->admin_notices ) ){
			foreach ( $this->admin_notices as $key => $value) {
				echo '<div id="notice" class="'.sanitize_html_class($value["type"]).'"><p>'.$value["text"].'</p></div>';
			}
		}
	}   

	#
	#	Load Admin Functions
	#
	function load_admin_functions() {			
	}
 
 
	#
	#	Load Admin Scripts
	#

	function load_admin_scripts(){
		global $pagenow;

		wp_enqueue_script('jquery-ui-core');
		wp_enqueue_script('jquery-ui-sortable');
		wp_enqueue_script('jquery-ui-droppable');
		wp_enqueue_script('jquery-ui-draggable'); 
		wp_enqueue_script('jquery-ui-tabs'); 
		wp_enqueue_script('jquery-ui-widget');
		wp_enqueue_script('jquery-ui-mouse');  
		wp_enqueue_script('jquery-effects-core');  
		wp_enqueue_script('jquery-effects-scale');  
		wp_enqueue_script('jquery-effects-fade');  
		wp_enqueue_script('jquery-effects-highlight');  
		wp_enqueue_script('jquery-effects-transfer');  
		wp_enqueue_script('jquery-ui-button');  


		if( $pagenow == "edit-tags.php" || $pagenow == "term.php" ){
			if(function_exists( 'wp_enqueue_media' ) ){
				wp_enqueue_media();
			}else{
				wp_enqueue_style('thickbox');
				wp_enqueue_script('media-upload');
				wp_enqueue_script('thickbox');
			}
		}

		
		wp_enqueue_script('jquery-custom-select', RT_THEMEADMINURI.'/js/jquery-customselect-min.js','',RT_THEMEVERSION);		
		wp_enqueue_script('spectrum', RT_THEMEADMINURI . '/js/spectrum/spectrum-min.js','',RT_THEMEVERSION); 
		wp_enqueue_script('jquery-tools', RT_THEMEADMINURI . '/js/rangeinput-min.js','',RT_THEMEVERSION);
		wp_enqueue_script('jquery-amselect', RT_THEMEADMINURI . '/js/jquery-asmselect-min.js','',RT_THEMEVERSION);  
 

		$min_extension = get_theme_mod('naturalife_optimize_js') ? "-min" : "";
		wp_enqueue_script('admin-scripts', RT_THEMEADMINURI . '/js/script'.$min_extension.'.js','',RT_THEMEVERSION,true);

		$variables=array( 
				"reset_theme" => esc_html_x('Are you sure that you want reset the theme settings? ','Admin Panel','naturalife'),
				"delete_image" => esc_html_x('Are you sure that you want remove this image? ','Admin Panel','naturalife'),
				"delete_font" => esc_html_x('Are you sure that you want remove this font? ','Admin Panel','naturalife'),
				"vcbackend_only" => esc_html_x('Please use the "Backend Editor" to add / edit this element.','Admin Panel','naturalife'),
				"reset_design_options" => esc_html_x('Are you sure that you want to reset the design options of this page/post and use the global settings?','Admin Panel','naturalife'),
				"theme_slug" => RT_THEMESLUG
				);

		wp_localize_script( 'jquery', 'rtframework_variables', $variables );

	}

	#
	#	Load Admin Styles
	#
	
	function load_admin_styles(){
		
		if( ! get_theme_mod('naturalife_optimize_css') ){
			wp_enqueue_style('admin-style', RT_THEMEADMINURI . '/css/admin.css','',RT_THEMEVERSION);   
		}else{
			wp_enqueue_style('admin-style', RT_THEMEADMINURI . '/css/admin-min.css','',RT_THEMEVERSION);   
		}

		wp_enqueue_style('spectrum-style', RT_THEMEADMINURI . '/js/spectrum/spectrum.css','',RT_THEMEVERSION); 	
		wp_enqueue_style('fontello', RT_THEMEADMINURI . '/css/panel-fonts/css/rt-panel.css','',RT_THEMEVERSION);		

	}

	#
	#	Editor Style
	#	 
 
	function load_editor_style() {
		add_editor_style( 'css/editor-style.css' );
	}

}
?>
