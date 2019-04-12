<?php
if( ! rtframework_get_setting("display_header") && ! rtframework_get_setting( "sticky_header" ) ){
	return;
}
?>

	<header class="top-header" data-color="<?php echo esc_attr( rtframework_get_setting("header_color_skin") )?>">
		<?php if( rtframework_get_setting( "display_header" ) ) : ?>
		<div class="main-header-holder naturalife-<?php echo rtframework_get_setting("header_color_skin");?>-header dynamic-skin">
			<div class="header-elements">

				<div class="header-row first">
					<div class="header-col left">
						<?php
						/**
						 * rtframework_header_first_left hook			
						 * 
						 * @hooked rtframework_logo_function 5 (optional)		
	 					 * @hooked rtframework_navigation_function 20 (optional)				 	 
						 * @hooked rtframework_header_languages 25 (optional)
						 * @hooked rtframework_top_shortcut_buttons 30 (optional)
						 * @hooked rtframework_header_first_left_sidebar 40
						 * 
						 */
						 do_action("rtframework_header_first_left"); 
						?>		 
					</div>

					<?php if( has_action( "rtframework_header_first_center" ) ): ?>
					<div class="header-col center">
						<?php
						/**
						 * rtframework_header_first_center hook			
						 * 
	 					 * @hooked rtframework_logo_function 5 (optional)		
						 * 
						 */
						 do_action("rtframework_header_first_center"); 
						?>		
					</div>
					<?php endif;?>

					<div class="header-col right">
						<?php
						/**
						 * rtframework_header_first_right hook
						 * 
						 * @hooked rtframework_logo_function 5 (optional)		
					 	 * @hooked rtframework_header_first_right_sidebar 10
	 					 * @hooked rtframework_navigation_function 20 (optional)				 	 
						 * @hooked rtframework_header_languages 25 (optional)
						 * @hooked rtframework_top_shortcut_buttons 30 (optional)
						 * 
						 */
							do_action("rtframework_header_first_right");
						?>		
					</div>
				</div><!-- / .header-row.first -->

				<?php if( has_action( "rtframework_header_second_left" ) || has_action( "rtframework_header_second_center" ) || has_action( "rtframework_header_second_right" ) ): ?>
				<div class="header-row second">
					<div class="header-col left">
						<?php
						/**
						 * rtframework_header_second_left hook
						 * 
						 * @hooked rtframework_logo_function 5 (optional)		
	 					 * @hooked rtframework_navigation_function 20 (optional)				 	 
						 * @hooked rtframework_header_languages 25 (optional)
						 * @hooked rtframework_top_shortcut_buttons 30 (optional)
						 * @hooked rtframework_header_second_left_sidebar 40
						 * 
						 */	
						 do_action("rtframework_header_second_left"); 
						?>			
					</div>

					<?php if( has_action( "rtframework_header_second_center" ) ): ?>
					<div class="header-col center">
						<?php
						/**
						 * rtframework_header_second_center hook
						 * 
						 * @hooked rtframework_logo_function 5 (optional)		
						 */
						 do_action("rtframework_header_second_center"); 
						?>		
					</div>
					<?php endif;?>

					<div class="header-col right">
						<?php
						/**
						 * rtframework_header_second_right hook
						 *
						 * @hooked rtframework_logo_function 5 (optional)		
						 * @hooked rtframework_header_second_right_sidebar 10
	 					 * @hooked rtframework_navigation_function 20 (optional)				 	 
						 * @hooked rtframework_header_languages 25 (optional)
						 * @hooked rtframework_top_shortcut_buttons 30 (optional)
						 * 
						 */
						do_action("rtframework_header_second_right"); 
						?>
					</div>
				</div><!-- / .header-row.second --> 	
				<?php endif;?>

			</div><!-- / .header-elements -->
		</div><!-- / .main-header-header -->
		<?php endif;?>

		<?php if( rtframework_get_setting( "sticky_header" ) ) : ?>
		<div class="sticky-header-holder">
			<div class="header-elements">
				<div class="header-row naturalife-<?php echo rtframework_get_setting("header_color_skin_sticky");?>-header">
					<div class="header-col left">
						<?php
						/**
						 * rtframework_sticky_header_left hook
						 *
						 *	@hooked rtframework_logo_function 5 (optional)	
						 *	@hooked rtframework_navigation_function 20 (optional)	
						 *  @hooked rtframework_sticky_header_left_sidebar 40
						 */
						do_action("rtframework_sticky_header_left", array("target" => "sticky-header"));
						?>		
					</div>

					<?php if( has_action( "rtframework_sticky_header_center" ) ): ?>
					<div class="header-col center">
						<?php
						/**
						 * rtframework_sticky_header_cennter hook
						 *	
						 *	@hooked rtframework_logo_function 5 (optional)	
						 *	@hooked rtframework_navigation_function 20 (optional)	
						 * 
						 */
						do_action("rtframework_sticky_header_center", array("target" => "sticky-header"));
						?>		
					</div>
					<?php endif;?>

					<div class="header-col right">
						<?php
						/**
						 * rtframework_header_first_right hook
						 *
						 * @hooked rtframework_logo_function 5 (optional)		
						 * @hooked rtframework_sticky_header_right_sidebar 10
	 					 * @hooked rtframework_navigation_function 20 (optional)				 	 
						 * @hooked rtframework_header_languages 25 (optional)
						 * @hooked rtframework_top_shortcut_buttons 30 (optional)
						 * 
						 */
						do_action("rtframework_sticky_header_right", array("target" => "sticky-header")); 
						?>		
					</div>
				</div><!-- / .header-row.first --> 
			</div>
		</div><!-- / .sticky-header-header -->
		<?php endif;?>
	</header>