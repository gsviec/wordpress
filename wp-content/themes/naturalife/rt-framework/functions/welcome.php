<?php
if( ! function_exists("rt_framework_welcome") ){
	/**
	 * 
	 * Welcome
	 * 
	 * @return output
	 * 
	 */	
	function rt_framework_welcome()
	{	
		?>

		<div class="wrap about-wrap">
			<div class="rt-admin-layout-wrapper">
				
				<h1><?php printf( esc_html_x('Welcome to %s start page.','Admin Panel','naturalife'), RT_THEMENAME ) ;?></h1>

				<div class="about-text">
					<?php if (class_exists("Naturalife_Extensions")): ?>
						<?php printf( esc_html_x('Congratulations you have successfuly installed %1$s and %2$s.','Admin Panel','naturalife'), '<strong>'.RT_THEMENAME.'</strong>', '<strong>'.RT_THEME_PLUGINNAME.'</strong>' ) ;?>
						<?php printf( esc_html_x('%1$s is a powerful theme and there are many customization options available inside the %2$sCustomize Panel%3$s. Do not forget to check out the %1$s menu sub pages for additional useful tools and utilites.','Admin Panel','naturalife'), RT_THEMENAME,  '<a href="customize.php">', '</a>' ) ;?>
					<?php else: ?>
						<?php $tgmpa = isset( $GLOBALS['tgmpa'] ) ? $GLOBALS['tgmpa'] : TGM_Plugin_Activation::get_instance(); 

							//check if the extensions plugin needs to be installed or activated
							$install_activate = ! class_exists( 'Naturalife_Extensions' ) ? esc_html_x('Activate','Admin Panel','naturalife') : esc_html_x('Install','Admin Panel','naturalife');

						?>
						<?php printf( esc_html_x('Congratulations you have successfuly installed %s.','Admin Panel','naturalife'), '<strong>'.RT_THEMENAME.'</strong>') ;?>
						<?php printf( esc_html_x('%2$s%3$s%4$s %1$s and other recommended plugins to access all options and tools of the theme.','Admin Panel','naturalife'),  '<strong>'.RT_THEME_PLUGINNAME.'</strong>',  '<a href="'. $tgmpa->get_tgmpa_url().'"">', $install_activate,'</a>' ) ;?>
					<?php endif; ?>
				</div>

				<div class="wp-badge vc-page-logo">
					<?php 
						$theme_data = rtframework_get_theme();
					?>
				</div>

				<hr />

				<div class="three-col">

					<div class="col">
						<h3><?php echo esc_html_x( 'Documentation','Admin Panel','naturalife' ); ?></h3>
						<p>
							<?php printf( esc_html_x('You can the find online documentation of the theme at %s','Admin Panel','naturalife'), '<a href="http://docs.rtthemes.com" target="_blank">http://docs.rtthemes.com</a>' ) ;?>
						</p>
					</div>

					<div class="col">
						<h3><?php echo esc_html_x( 'Support','Admin Panel','naturalife' ); ?></h3>
						<p>
							<?php printf( esc_html_x('If you have any questions regarding this theme, please let us know by using our support forum at %s','Admin Panel','naturalife'), '<a href="http://support.rtthemes.com" target="_blank">http://support.rtthemes.com</a>' ) ;?>
						</p>
					</div>

					<div class="col">
						<h3><?php echo esc_html_x( 'Changelog','Admin Panel','naturalife' ); ?></h3>
						<p>
							<?php printf( esc_html_x('Please check the bottom of the %1$stheme sale page%2$s on themeforest to find the changelogs.','Admin Panel','naturalife'), '<a href="https://themeforest.net/user/stmcan/portfolio?ref=stmcan&sender=naturalife" target="_blank">','</a>' ) ;?>
						</p>
					</div>
				</div>
			</div>
		</div>

		<?php
	}
}


if( ! function_exists("rtframework_theme_page") ){
	/**
	 * Thene page
	 */
	 function rtframework_theme_page() {
		if ( ! class_exists("Naturalife_Extensions")){
			add_theme_page( esc_html_x('NaturaLife','Admin Panel','naturalife'), esc_html_x('NaturaLife','Admin Panel','naturalife'), 'manage_options', 'rt_framework_welcome', "rt_framework_welcome");
		}
	}
}
add_action( 'admin_menu', 'rtframework_theme_page', 10 );


if( ! function_exists("rtframework_activation_redirect") ){
	/**
	 * Redirect to the welcome page
	 */
	 function rtframework_activation_redirect() {
	 	
	 	$theme_data = rtframework_get_theme(); 

		if ( ! get_transient( $theme_data->template . '_rt_redirect' ) ) {
			return;
		}
		
		delete_transient( $theme_data->template . '_rt_redirect' );
		wp_safe_redirect( admin_url( 'admin.php?page=rt_framework_welcome' ) );

		exit;
	}
}
add_action( 'admin_init', 'rtframework_activation_redirect', 20 );

if( ! function_exists("rtframework_activation_start") ){
	/**
	 * Redirect to the welcome page
	 */
	 function rtframework_activation_start() {
	 	
	 	$theme_data = rtframework_get_theme();
	 	set_transient( $theme_data->template . '_rt_redirect', 1 ); 
	}
}
add_action( 'after_switch_theme', 'rtframework_activation_start', 10 );