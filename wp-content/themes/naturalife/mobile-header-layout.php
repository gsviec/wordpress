<header class="mobile-header">
	<div class="mobile-header-holder">
		<div class="header-elements">
			<div class="header-row naturalife-<?php echo rtframework_get_setting("header_color_skin_mobile");?>-header">
				<div class="header-col left">
					<?php
					/**
					 * rtframework_mobile_header_left hook			
					 * 			 	 
					 * 	@hooked rtframework_mobile_logo_function 30 
					 * 
					 */
					 do_action("rtframework_mobile_header_left"); 
					?>		 
				</div>
 
				<div class="header-col right">
					<?php
					/**
					 * rtframework_mobile_header_right hook
					 * 		 	 
					 * @hooked rtframework_top_shortcut_buttons 30 (optional)
					 * 
					 */
					do_action("rtframework_mobile_header_right");
					?>		
				</div>
			</div><!-- / .header-row -->
		</div>
	</div><!-- / .mobile-header-header -->
</header>
<?php
/**
 * rtframework_after_mobile_header hook
 */
do_action("rtframework_after_mobile_header"); 
?>			