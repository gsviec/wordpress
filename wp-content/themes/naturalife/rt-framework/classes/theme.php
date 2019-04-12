<?php
#-----------------------------------------
#	RT-Theme theme.php
#	version: 1.2
#-----------------------------------------

#
#	Site Class
#
 
class RTFrameworkSite extends RTFramework {
 
	function theme_init(){ 

		//Loading Theme Scripts
		add_action('wp_enqueue_scripts', array(&$this,'load_scripts'),10);

		//Loading Theme Styles
		add_action('wp_enqueue_scripts', array(&$this,'load_styles'),5);

		//Loading WP Style
		add_action('wp_enqueue_scripts', array(&$this,'load_wp_style'),7);

		//Loading Google Fonts 
		add_action('wp_enqueue_scripts', array(&$this,'rt_load_external_fonts'),40);	

		//Load Typekit Fonts 
		add_action('wp_enqueue_scripts', array(&$this,'rt_load_typekit_fonts'),1); 

		//Remove no-js
		add_action('wp_head', array(&$this,'rt_page_loading'),1);

	}  


	#
	# Loading Theme Scripts
	#
	
	function load_scripts(){

		if( get_theme_mod('naturalife_optimize_js') && class_exists("Naturalife_Extensions") ){
			wp_enqueue_script('naturalife-scripts', RT_THEMEURI . '/js/app-min.js', array('jquery'), RT_THEMEVERSION, true );
		}else{			
			wp_enqueue_script('modernizr', RT_THEMEURI  . '/js/modernizr-min.js', 1, RT_THEMEVERSION, false );
			wp_enqueue_script('jquery-isotope', RT_THEMEURI . '/js/isotope-pkgd-min.js', array('jquery'),  RT_THEMEVERSION, true );
			wp_enqueue_script('imagesloaded', RT_THEMEURI . '/js/imagesloaded-min.js', array('jquery'),  RT_THEMEVERSION, true );
			wp_enqueue_script('waitForImages', RT_THEMEURI . '/js/waitforimages-min.js', array('jquery'),  RT_THEMEVERSION, true );
			wp_enqueue_script('easy-pie-chart', RT_THEMEURI . '/js/easy-pie-chart-min.js', array('jquery'),  RT_THEMEVERSION, true );
			wp_enqueue_script('owl-carousel', RT_THEMEURI . '/js/owl-carousel-min.js', array('jquery'),  RT_THEMEVERSION, true );
			wp_enqueue_script('jflickrfeed', RT_THEMEURI . '/js/jflickrfeed-min.js', array('jquery'),  RT_THEMEVERSION, true );
			wp_enqueue_script('customselect', RT_THEMEURI . '/js/customselect-min.js', array('jquery'),  RT_THEMEVERSION, true );
			wp_enqueue_script('lightgallery', RT_THEMEURI  . '/js/lightgallery-all-min.js', array('jquery'), RT_THEMEVERSION, true  );
			wp_enqueue_script('placeholders', RT_THEMEURI  . '/js/placeholders-min.js', array('jquery'), RT_THEMEVERSION, true );
			wp_enqueue_script('perfect-scrollbar', RT_THEMEURI  . '/js/perfect-scrollbar-min.js', array('jquery'), RT_THEMEVERSION, true );
			wp_enqueue_script('jquery-countdown', RT_THEMEURI  . '/js/countdown-min.js', array('jquery'), RT_THEMEVERSION, true );
			wp_enqueue_script('jquery-appear', RT_THEMEURI  . '/js/jquery-appear-min.js', array('jquery'), RT_THEMEVERSION, true );
			wp_enqueue_script('naturalife-scripts', RT_THEMEURI  . '/js/scripts.js', array('jquery'), RT_THEMEVERSION, true );
		}	

		//ajax url depended WPML plugin
		$ajax_url = function_exists('icl_object_id') ? admin_url('admin-ajax.php?lang='.ICL_LANGUAGE_CODE.'') : admin_url('admin-ajax.php');

		//localize js params
		$js_params = array(
				'ajax_url'               => $ajax_url,
				'rttheme_template_dir'   => RT_THEMEURI,
				'popup_blocker_message'  => esc_html_x('Please disable your pop-up blocker and click the "Open" link again.','Admin Panel','naturalife'),
				'wpml_lang'              => esc_attr(rtframework_wpml_get_current_language()),
				"theme_slug"             => RT_THEMESLUG,
				"home_url"               => get_home_url()
		);

		wp_localize_script( 'naturalife-scripts', 'rtframework_params', $js_params );

		//thread comments
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

	}


	#
	# Replace no-js class with js
	# It must be inline script to prevent flickering
	#
	function rt_page_loading() { 
		echo '<script type="text/javascript">/*<![CDATA[ */ var html = document.getElementsByTagName("html")[0]; html.className = html.className.replace("no-js", "js"); window.onerror=function(e,f){var body = document.getElementsByTagName("body")[0]; body.className = body.className.replace("rt-loading", ""); var e_file = document.createElement("a");e_file.href = f;console.log( e );console.log( e_file.pathname );}/* ]]>*/</script>'."\n";
	}

	
	#
	# Loading Theme Styles
	#	
	function load_styles(){ 

		if( get_theme_mod('naturalife_optimize_css') && class_exists("Naturalife_Extensions") ){

			//register styles
			wp_register_style('naturalife-style-all', RT_THEMEURI . '/css/app-min.css','',RT_THEMEVERSION);  	
			wp_register_style('fontello', rtframework_locate_media_file( '/css/fontello/css/fontello.css' ),'',RT_THEMEVERSION); 	


			if ( class_exists( 'Woocommerce' ) ) { 				
				wp_register_style('woocommerce', RT_THEMEURI.'/css/woocommerce/woocommerce-min.css','',RT_THEMEVERSION);
				
				if(is_rtl()){
					wp_register_style('woocommerce-rtl', RT_THEMEURI.'/css/woocommerce/woocommerce-rtl-min.css','',RT_THEMEVERSION);	
				}

			}			

			//enqueue styles
			wp_enqueue_style('naturalife-style-all');  
			wp_enqueue_style('woocommerce');  		 
			wp_enqueue_style('fontello');  
 
			//rtl
			if(is_rtl()){
				wp_register_style('naturalife-style-rtl', RT_THEMEURI . '/css/rtl-min.css','',RT_THEMEVERSION);		  				
				wp_enqueue_style('naturalife-style-rtl');	 	
				wp_enqueue_style('woocommerce-rtl');  		 
			}

		}else{

			//register styles
			wp_register_style('bootstrap', RT_THEMEURI . '/css/bootstrap/bootstrap.css','',RT_THEMEVERSION);
			wp_register_style('naturalife-style-all', RT_THEMEURI . '/css/style.css','',RT_THEMEVERSION);  
			wp_register_style('fontello', rtframework_locate_media_file( '/css/fontello/css/fontello.css' ),'',RT_THEMEVERSION); 
			wp_register_style('jquery-owl-carousel', RT_THEMEURI . '/css/owl-carousel-min.css','',RT_THEMEVERSION);  
			wp_register_style('lightgallery', RT_THEMEURI . '/css/lightgallery-min.css','',RT_THEMEVERSION);		  

			if ( class_exists( 'Woocommerce' ) ) { 				
				wp_register_style('woocommerce', RT_THEMEURI.'/css/woocommerce/woocommerce.css','',RT_THEMEVERSION);
				
				if(is_rtl()){
					wp_register_style('woocommerce-rtl', RT_THEMEURI.'/css/woocommerce/woocommerce-rtl.css','',RT_THEMEVERSION);	
				}

			}			

			//enqueue styles
			wp_enqueue_style('bootstrap'); 		
			wp_enqueue_style('naturalife-style-all'); 	
			wp_enqueue_style('woocommerce');  	
			wp_enqueue_style('fontello');  
			wp_enqueue_style('jquery-owl-carousel'); 
			wp_enqueue_style('lightgallery');

			//rtl
			if(is_rtl()){
				wp_register_style('naturalife-style-rtl', RT_THEMEURI . '/css/rtl.css','',RT_THEMEVERSION);		 
				wp_enqueue_style('naturalife-style-rtl');  		
				wp_enqueue_style('woocommerce-rtl'); 		
			}

		}


		//if it is customizer preview window and theme is not activated yet
		if( is_customize_preview() ) {
			if( ! get_theme_mods() ){
				wp_enqueue_style('naturalife-preview', RT_THEMEURI . '/css/preview-style.css','',RT_THEMEVERSION);	
			}
		}


				
	}


	#
	# Loading WP default stylesheet 
	#	
	function load_wp_style(){ 
			wp_register_style('naturalife-theme-style', get_bloginfo( 'stylesheet_url' ));		
			wp_enqueue_style('naturalife-theme-style');
	}

	#
	#   Load Google Fonts
	#
	function rt_load_external_fonts(){

		$selected_fonts = rtframework_get_selected_fonts_list();

		$group_fonts = array();
		$subsets = array();
		$include_string = "";
		$add_body_variants = apply_filters( "rtframework_add_body_font_variants", true );

		//import google fonts
		foreach( $selected_fonts as $purpose => $data) {

			if( is_array( $data ) && $data["kind"] == "google" ){ //check if it is a google font

				if( ! isset( $group_fonts[ $data["family"] ] ) ){
					$group_fonts[ $data["family"] ] = $data["family"] ;
					$group_fonts[ $data["family"] ] = array();
					$group_fonts[ $data["family"] ]["variants"] = array( $data["variant"] );
				}else{
					array_push( $group_fonts[ $data["family"] ]["variants"] , $data["variant"] );
				}

				//add italic and bold to the body font
				if( $purpose == "body" && $add_body_variants ){
					
					$bsize = "500";//bold
					$isize = "400i";//italic

					if( $data["variant"] !== "regular" && intval( $data["variant"] ) ){
						$bsize = $data["variant"]+200;//bold
						$isize = $data["variant"]."i";//italic					
					}

					array_push( $group_fonts[ $data["family"] ]["variants"] , $bsize );
					array_push( $group_fonts[ $data["family"] ]["variants"] , $isize );
				}

				$subsets = is_array( $data["subset"] ) ? array_merge( $subsets, $data["subset"] ) : $subsets ;
				
			}
		}

		//create include list
		foreach( $group_fonts as $family => $extend ) {
			$include_string .= ! empty( $include_string ) ? "|" : "";
			$include_string .= $family.':'. implode( array_unique( $extend["variants"] ) , "," ); 			
		}

		$include_string .= ! empty( $subsets ) ? '&subset='. implode( array_unique( $subsets ) ,"," ) : "" ; 

		if( ! empty( $include_string ) ){
			$font_url = add_query_arg( 'family', $include_string, "//fonts.googleapis.com/css" );
			wp_enqueue_style( 'naturalife-google-fonts', $font_url, array(), '1.0.0' ); 
		}

	}


	#
	#   Load Typekit Fonts
	#
	function rt_load_typekit_fonts(){

		$saved_fonts = unserialize( get_option( "naturalife_custom_fonts" ) );

		if( empty( $saved_fonts ) || ! is_array( $saved_fonts ) ){
			return;
		}

		$kitids = array(); 

		//collect kitids into an array
		foreach( $saved_fonts as $key => $font) {		

			if( $font["font-type"] != "typekit" ){
				continue;
			}

			$kitids[] = $font["kitid"];
		}

		array_unique($kitids);

		$this->kitids = $kitids;


		if( ! empty( $this->kitids ) ){
			//create include list
			foreach( $kitids as $kitid) {
				wp_enqueue_script( "naturalife-typekit-fonts-".$kitid, '//use.typekit.net/'.$kitid.'.js', 1, "", false); 			
			}
		}		

		add_action('wp_head', array(&$this,'add_typekit_script'));

	}

	#   Add Typekit Script
	#	
	function add_typekit_script(){
		echo '<script type="text/javascript">/*<![CDATA[ */ try{Typekit.load();}catch(e){} /* ]]>*/</script>'."\n";
	}
}


?>