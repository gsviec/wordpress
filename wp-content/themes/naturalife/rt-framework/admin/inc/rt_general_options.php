<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * RT-Theme Options Without Panels
 */
$this->options["rt_single_options"] = array(

			array(
				'id'       => 'copyright',
				'title'    => esc_html_x("Copyright Text", 'Admin Panel', 'naturalife'), 
				'controls' => array( 

									array(
										"id"          => "naturalife_copyright", 	
										"label"       => esc_html_x("Copyright Text",'Admin Panel', 'naturalife'),
										"description" => esc_html_x('The copyright text will be displayed in the footer of your website.','Admin Panel', 'naturalife'),
										"transport"   => "refresh",		
										"default"     => esc_html_x('Copyright &copy; Company Name, Inc.','Admin Panel', 'naturalife'),											
										"type"        => "textarea",
										"callback"    => "wp_kses_post"
									), 

							),
			), 
	);

/**
 * RT-Theme General Options
 */
$this->options["rt_general_options"] = array(

		'title' => esc_html_x("General Options", 'Admin Panel', 'naturalife'), 
		'priority' => 1,
		//'description' => esc_html_x("General Options Desc", 'Admin Panel', 'naturalife'), 
		'sections' => array(


							array(
								'id'       => 'breadcrumb',
								'title'    => esc_html_x("Breadcrumb Menus", 'Admin Panel', 'naturalife'), 
								'controls' => array( 

													array(
														"id"          => "naturalife_blog_page",															
														"label"       => esc_html_x("Blog Start Page",'Admin Panel', 'naturalife'),
														"description" => esc_html_x("Select blog start page to add after home link.",'Admin Panel', 'naturalife'),
														"default"   => "0",
														"transport" => "refresh", 
														"type"      => "dropdown-pages"
													),													

													array(
														"id"          => "naturalife_portfolio_page",															
														"label"       => esc_html_x("Portfolio Start Page",'Admin Panel', 'naturalife'),
														"description" => esc_html_x("Select a start page to add after home link for single portfolio pages and categories.",'Admin Panel', 'naturalife'),
														"default"   => "0",
														"transport" => "refresh", 
														"type"      => "dropdown-pages"
													),																							

													array(
														"id"          => "naturalife_staff_page",															
														"label"       => esc_html_x("Team Start Page",'Admin Panel', 'naturalife'),
														"description" => esc_html_x("Select a start page to add after home link for team member single pages and categories",'Admin Panel', 'naturalife'),
														"default"   => "0",
														"transport" => "refresh", 
														"type"      => "dropdown-pages"
													),		

													array(
														"id"          => "naturalife_shop_start_page",															
														"label"       => esc_html_x("WooCommerce Shop Start Page",'Admin Panel', 'naturalife'),
														"description" => esc_html_x("Select shop start page to add after the home link for WooCommerce links. Note: When you define a start page by using this option, the default WooCommerce breadcrumb menu will be disabled.",'Admin Panel', 'naturalife'),
														"default"   => "0",
														"transport" => "refresh", 
														"type"      => "dropdown-pages"
													),
											),
							),


							array(
								'id'       => 'sidebars',
								'title'    => esc_html_x("Sidebar Options", 'Admin Panel', 'naturalife'), 
								'controls' => array( 
													
													array(
														"id"          => "naturalife_sidebar_position",	
														"label"       => esc_html_x("Default Sidebar Position",'Admin Panel', 'naturalife'),
														"description" => "",
														"transport"   => "refresh",															
														"choices"     => array(		
																			"fullwidth" => esc_html_x("No Sidebar",'Admin Panel', 'naturalife'),
																			"left"  => esc_html_x("Left Sidebar",'Admin Panel', 'naturalife'),
																			"right" => esc_html_x("Right Sidebar",'Admin Panel', 'naturalife'), 
																		),  
														"type" => "select",
														"default" => "fullwidth",
														"rt_skin"   => true
													),

													array(
														"id"          => "naturalife_sidebar_blog_single",	
														"label"       => esc_html_x("Sidebar Position for Single Blog Posts",'Admin Panel', 'naturalife'),
														"description" => "",
														"transport"   => "refresh",															
														"choices"     => array(		
																			"fullwidth" => esc_html_x("No Sidebar",'Admin Panel', 'naturalife'),
																			"left"  => esc_html_x("Left Sidebar",'Admin Panel', 'naturalife'),
																			"right" => esc_html_x("Right Sidebar",'Admin Panel', 'naturalife'), 
																		),  
														"type" => "select",
														"default" => "right",
														"rt_skin"   => true
													), 
													
													array(
														"id"          => "naturalife_sidebar_blog_cats",	
														"label"       => esc_html_x("Sidebar Position for Blog Categories",'Admin Panel', 'naturalife'),
														"description" => "",
														"transport"   => "refresh",															
														"choices"     => array(		
																			"fullwidth" => esc_html_x("No Sidebar",'Admin Panel', 'naturalife'),
																			"left"  => esc_html_x("Left Sidebar",'Admin Panel', 'naturalife'),
																			"right" => esc_html_x("Right Sidebar",'Admin Panel', 'naturalife'), 
																		),  
														"type" => "select",
														"default" => "right",
														"rt_skin"   => true
													), 

													array(
														"id"          => "naturalife_sidebar_portfolio_cats",	
														"label"       => esc_html_x("Sidebar Position for Portfolio Categories",'Admin Panel', 'naturalife'),
														"description" => "",
														"transport"   => "refresh",															
														"choices"     => array(		
																			"fullwidth" => esc_html_x("No Sidebar",'Admin Panel', 'naturalife'),
																			"left"  => esc_html_x("Left Sidebar",'Admin Panel', 'naturalife'),
																			"right" => esc_html_x("Right Sidebar",'Admin Panel', 'naturalife'), 
																		),  
														"type" => "select",
														"default" => "fullwidth",
														"rt_skin"   => true
													), 

													array(
														"id"          => "naturalife_sidebar_bbpress",	
														"label"       => esc_html_x("Sidebar Position for bbPress",'Admin Panel', 'naturalife'),
														"description" => "",
														"transport"   => "refresh",															
														"choices"     => array(		
																			"fullwidth" => esc_html_x("No Sidebar",'Admin Panel', 'naturalife'),
																			"left"  => esc_html_x("Left Sidebar",'Admin Panel', 'naturalife'),
																			"right" => esc_html_x("Right Sidebar",'Admin Panel', 'naturalife'), 
																		),  
														"type" => "select",
														"default" => "fullwidth",
														"rt_skin"   => true
													), 
													
													array(
														"id"          => "naturalife_sidebar_woo_cats",	
														"label"       => esc_html_x("Sidebar Position for WooCommerce Categories",'Admin Panel', 'naturalife'),
														"description" => "",
														"transport"   => "refresh",															
														"choices"     => array(		
																			""      => esc_html_x("No Sidebar",'Admin Panel', 'naturalife'),
																			"left"  => esc_html_x("Left Sidebar",'Admin Panel', 'naturalife'),
																			"right" => esc_html_x("Right Sidebar",'Admin Panel', 'naturalife'),
																		),  
														"type" => "select",
														"default" => "right",
														"rt_skin"   => true
													),	
													

											),
							),


							array(
								'id'          => 'page_comments',
								'title'       => esc_html_x("Page Comments", 'Admin Panel', 'naturalife'), 
								"description" => esc_html_x("Use this option to control the page comments of all pages. Turn ON this option if you want to hide comment part of pages. If you don't see the page comments even if you select 'Enabled' option; make sure 'Allow Comments' box is also checked for individual pages (in edit page screen). If you dont see that option in your pages make sure to turn on the &#39;discussions&#39; option in the screen options below the admin name while you are in that page editing the content. ",'Admin Panel', 'naturalife'),				
								'controls'    => array( 

													array(
														"id"          => "naturalife_page_comments",	
														"label"       => esc_html_x("Enabled/Disable page comments of all pages",'Admin Panel', 'naturalife'),
														"description" => "",
														"transport"   => "refresh",															
														"choices"     => array(		
																			""  => esc_html_x("Enabled",'Admin Panel', 'naturalife'),
																			"disabled" => esc_html_x("Disabled",'Admin Panel', 'naturalife'), 
																		),  
														"type" => "select",
														"default" => "",
														"rt_skin"   => true
													),	

											),
							),
   

							array(
								'id'          => 'page_loading',
								'title'       => esc_html_x("Page Loading Effect", 'Admin Panel', 'naturalife'), 
								"description" => esc_html_x("Check this option to enable page loading effect",'Admin Panel', 'naturalife'),				
								'controls'    => array( 


														array(
															"id"          => "naturalife_loading_logo", 	
															"label"       => esc_html_x("Loading Logo Image",'Admin Panel', 'naturalife'),
															"description" => esc_html_x('HiDPI / Retina image. Upload a 2x bigger image file.','Admin Panel', 'naturalife'),
															"transport"   => "refresh",															
															"type"        => "media"
														), 

														array(
															"id"        => "naturalife_page_loading_effect",															
															"label"     => esc_html_x("Page Loading Effect",'Admin Panel', 'naturalife'),														
															"default"   => "on",
															"transport" => "refresh",
															"type"      => "checkbox",
														),	

														array(
															"id"        => "naturalife_page_transition_effect",															
															"label"     => esc_html_x("Page Transition Effect",'Admin Panel', 'naturalife'),														
															"default"   => "",
															"transport" => "refresh",
															"type"      => "checkbox",
														),	

														array(
															"id"          => "naturalife_loading_background_color",	
															"label"       => esc_html_x("Loading Screen Background Color",'Admin Panel','naturalife'),
															"description" => "",
															"transport"   => "refresh",
															"default"     => "#fff",															
															"type"        => "rt_color",
															"rt_skin"   => true
														),		 
														
														array(
															"id"          => "naturalife_loading_bar_color",	
															"label"       => esc_html_x("Loading Screen Bar Color",'Admin Panel','naturalife'),
															"description" => "",
															"transport"   => "refresh",
															"default"     => "#84BE38",															
															"type"        => "rt_color",
															"rt_skin"   => true
														),		 

											),
							),


							array(
								'id'          => 'google_maps',
								'title'       => esc_html_x("Google Maps", 'Admin Panel', 'naturalife'), 
								"description" => esc_html_x("Enter your Google API key. Refer online documentation of the theme to learn how to get your API key.", 'Admin Panel', 'naturalife'), 				
								'controls'    => array( 

														array(
															"id"        => "naturalife_google_api_key",															
															"label"     => esc_html_x("Google API Key", 'Admin Panel', 'naturalife'), 													
															"default"   => "",
															"transport" => "refresh",
															"type"      => "text",
														),	

											),
							),	

							array(
								'id'          => 'go_to_top',
								'title'       => esc_html_x("Go to Top Button", 'Admin Panel', 'naturalife'), 
								"description" => esc_html_x("Check this option to display a 'go to top' button right bottom corner of your website",'Admin Panel', 'naturalife'),				
								'controls'    => array( 

													array(
														"id"        => "naturalife_go_top_button",															
														"label"     => esc_html_x("Display go to top button",'Admin Panel', 'naturalife'),														
														"default"   => 1,
														"transport" => "refresh",
														"type"      => "checkbox",
													),	

											),
							),

					)
	);