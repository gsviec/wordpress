<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


/**
 * RT-Theme General Options
 */
$this->options["rt_header_options"] = array(

		'title' => esc_html_x("Logo Sets", 'Admin Panel', 'naturalife'), 
		"description" => esc_html_x('Your site may have two different sets of logo that will be used on a light or dark "Site Header" background.','Admin Panel','naturalife'),
		'priority' => 1, 
		'sections' => array(

							array(
								'id'       => 'dark_logo_set',
								'title'    => esc_html_x("Dark Logo Set",'Admin Panel',"naturalife"), 
								"description" => '<a class="highlight-section rt-panel-icon-flash" data-section-selector="#logo" href="#" title="'.esc_html_x('Blink the section (if used) in the current page.','Admin Panel','naturalife').'"></a>'. esc_html_x('Use following settings to customize the dark logo set of your website. This logo set will be used on an header that uses "Dark Header Skin" ','Admin Panel',"naturalife"),
								'controls' => array( 

													array(
														"id"          => "logo_dark_l1",	
														"label"       => esc_html_x('Logo Images','Admin Panel', 'naturalife'),																													
														"type"        => "rt_subsection_heading"
													),

													array(
														"id"          => "naturalife_logo_dark", 	
														"label"       => esc_html_x("Default Logo Image",'Admin Panel', 'naturalife'),
														"description" => esc_html_x('Global logo image to be used in the logo box.','Admin Panel', 'naturalife'),
														"transport"   => "refresh",															
														"type"        => "media"
													), 

													array(
														"id"          => "naturalife_sticky_logo_dark", 	
														"label"       => esc_html_x("Logo Image for the Sticky Header (optional)",'Admin Panel', 'naturalife'),
														"description" => esc_html_x('Alternative logo image to be appeared only when the header stuck to the top after scrolled.','Admin Panel', 'naturalife'),
														"transport"   => "refresh",															
														"type"        => "media"
													), 

													array(
														"id"          => "naturalife_mobile_logo_dark", 	
														"label"       => esc_html_x("Logo Image for the Mobile Header (optional)",'Admin Panel', 'naturalife'),
														"description" => esc_html_x('Alternative logo image to be appeared in small screens only.','Admin Panel', 'naturalife'),
														"transport"   => "refresh",															
														"type"        => "media"
													), 

													array(
														"id"          => "logo_dark_l2",	
														"label"       => esc_html_x('Retina Logo Images (optional)','Admin Panel', 'naturalife'),																											
														"type"        => "rt_subsection_heading"
													),

													array(
														"id"          => "naturalife_retina_logo_dark", 	
														"label"       => esc_html_x("2x Logo Image",'Admin Panel', 'naturalife'),
														"description" => esc_html_x('Global logo image to be used in the logo box.','Admin Panel', 'naturalife'),
														"transport"   => "refresh",															
														"type"        => "media"
													), 

													array(
														"id"          => "naturalife_retina_sticky_logo_dark", 	
														"label"       => esc_html_x("2x Logo Image for the Sticky Header",'Admin Panel', 'naturalife'),
														"description" => esc_html_x('Alternative logo image for the logo box to be appeared only when the header stuck to the top.','Admin Panel', 'naturalife'),
														"transport"   => "refresh",															
														"type"        => "media"
													),  
 
 													array(
														"id"          => "naturalife_retina_mobile_logo_dark", 	
														"label"       => esc_html_x("2x Logo Image for the Mobile Header",'Admin Panel', 'naturalife'),
														"description" => esc_html_x('Alternative logo image to be appeared in small screens only.','Admin Panel', 'naturalife'),
														"transport"   => "refresh",															
														"type"        => "media"
													),  

											),
							),		

							array(
								'id'       => 'light_logo_set',
								'title'    => esc_html_x("Light Logo Set",'Admin Panel',"naturalife"), 
								"description" => '<a class="highlight-section rt-panel-icon-flash" data-section-selector="#logo" href="#" title="'.esc_html_x('Blink the section (if used) in the current page.','Admin Panel','naturalife').'"></a>'. esc_html_x('Use following settings to customize the light logo set of your website. This logo set will be used on an header that uses "Light Header Skin" ','Admin Panel',"naturalife"),
								'controls' => array( 


													array(
														"id"          => "logo_light_l1",	
														"label"       => esc_html_x('Logo Images','Admin Panel', 'naturalife'),																													
														"type"        => "rt_subsection_heading"
													),

													array(
														"id"          => "naturalife_logo_light", 	
														"label"       => esc_html_x("Default Logo Image",'Admin Panel', 'naturalife'),
														"description" => esc_html_x('Global logo image to be used in the logo box.','Admin Panel', 'naturalife'),
														"transport"   => "refresh",															
														"type"        => "media"
													), 

													array(
														"id"          => "naturalife_sticky_logo_light", 	
														"label"       => esc_html_x("Logo Image for the Sticky Header (optional)",'Admin Panel', 'naturalife'),
														"description" => esc_html_x('Alternative logo image to be appeared only when the header stuck to the top after scrolled.','Admin Panel', 'naturalife'),
														"transport"   => "refresh",															
														"type"        => "media"
													), 


													array(
														"id"          => "naturalife_mobile_logo_light", 	
														"label"       => esc_html_x("Logo Image for the Mobile Header (optional)",'Admin Panel', 'naturalife'),
														"description" => esc_html_x('Alternative logo image to be appeared in small screens only.','Admin Panel', 'naturalife'),
														"transport"   => "refresh",															
														"type"        => "media"
													), 

													array(
														"id"          => "logo_light_l2",	
														"label"       => esc_html_x('Retina Logo Images (optional)','Admin Panel', 'naturalife'),																											
														"type"        => "rt_subsection_heading"
													),

													array(
														"id"          => "naturalife_retina_logo_light", 	
														"label"       => esc_html_x("2x Logo Image",'Admin Panel', 'naturalife'),
														"description" => esc_html_x('Global logo image to be used in the logo box.','Admin Panel', 'naturalife'),
														"transport"   => "refresh",															
														"type"        => "media"
													), 

													array(
														"id"          => "naturalife_retina_sticky_logo_light", 	
														"label"       => esc_html_x("2x Logo Image for the Sticky Header",'Admin Panel', 'naturalife'),
														"description" => esc_html_x('Alternative logo image for the logo box to be appeared only when the header stuck to the top.','Admin Panel', 'naturalife'),
														"transport"   => "refresh",															
														"type"        => "media"
													), 
 
  													array(
														"id"          => "naturalife_retina_mobile_logo_light", 	
														"label"       => esc_html_x("2x Logo Image for the Mobile Header",'Admin Panel', 'naturalife'),
														"description" => esc_html_x('Alternative logo image to be appeared in small screens only.','Admin Panel', 'naturalife'),
														"transport"   => "refresh",															
														"type"        => "media"
													),  
 
											),
							),		


					)
	);