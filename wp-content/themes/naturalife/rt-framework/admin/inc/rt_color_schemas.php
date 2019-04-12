<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


/**
 * Create options
 */
$this->options["rt_color_schemas"] = array(
		'title' => esc_html_x("Styling Options", 'Admin Panel', "naturalife"),  
		'priority'=> 2,
		'sections' => array(

							array(
								'id'       => 'topbar',
								'title'    => esc_html_x("Top Bar", 'Admin Panel', 'naturalife'),
								"description" => '<a class="highlight-section rt-panel-icon-flash" data-section-selector=".naturalife-top-bar" href="#" title="'.esc_html_x('Blink the section (if used) in the current page.','Admin Panel', 'naturalife').'"></a>'. esc_html_x('Use the following settings to customize your top bar.','Admin Panel', 'naturalife'),
								'controls' => array(

													array(
														"id"          => "naturalife_display_topbar",		
														"label"       => esc_html_x("Display Top Bar",'Admin Panel','naturalife'),
														"description" => "",
														"transport"   => "refresh",															
														"default"     => false,
														"type"        => "checkbox",
														"rt_skin"     => true
													),

													array(
														"id"          => "naturalife_top_bar_content_width",
														"label"       => esc_html_x("Top Bar Content Width",'Admin Panel', 'naturalife'),
														"description" => "",
														"transport"   => "refresh",
														"choices"     => array(
																			"fullwidth" => esc_html_x("Full Width",'Admin Panel', 'naturalife'),
																			"default"   => esc_html_x("Default",'Admin Panel', 'naturalife'),
																		),
														"type"    => "select",
														"default" => "default",
														"rt_skin" => true
													),

													array(
														"id"          => "naturalife_top_bar_colors",
														"label"       => esc_html_x('Color Set for Top Bar','Admin Panel', 'naturalife'),
														"type"        => "rt_seperator"
													),


	 												array(
														"id"          => "naturalife_topbar_bg_color",
														"label"       => esc_html_x("Background Color",'Admin Panel', 'naturalife'),
														"description" => "",
														"transport"   => "refresh",
														"default"     => "#484a4e",
														"type"        => "rt_color",
														"rt_skin"     => true
													),

													array(
														"id"          => "naturalife_topbar_font_color",
														"label"       => esc_html_x("Font Color",'Admin Panel', 'naturalife'),
														"description" => "",
														"transport"   => "refresh",
														"default"     => "#ffffff",
														"type"        => "rt_color",
														"rt_skin"     => true
													),

													array(
														"id"          => "naturalife_topbar_link_color",
														"label"       => esc_html_x("Link Color",'Admin Panel', 'naturalife'),
														"description" => "",
														"transport"   => "refresh",
														"default"     => "#ffffff",
														"type"        => "rt_color",
														"rt_skin"     => true
													),

													array(
														"id"          => "naturalife_topbar_link_hover_color",
														"label"       => esc_html_x("Link Hover Color",'Admin Panel', 'naturalife'),
														"description" => "",
														"transport"   => "refresh",
														"default"     => "#84BE38",
														"type"        => "rt_color",
														"rt_skin"     => true
													),

													array(
														"id"          => "naturalife_topbar_border_color",
														"label"       => esc_html_x("Elements Border Color",'Admin Panel', 'naturalife'),
														"description" => "",
														"transport"   => "refresh",
														"default"     => "rgba(255, 255, 255, 0.15)",
														"type"        => "rt_color",
														"rt_skin"     => true
													),

													array(
														"id"          => "naturalife_topbar_bottom_border_color",
														"label"       => esc_html_x("Bottom Border Color",'Admin Panel', 'naturalife'),
														"description" => "",
														"transport"   => "refresh",
														"default"     => "",
														"type"        => "rt_color",
														"rt_skin"     => true
													),


											),
							),

							array(
								'id'       => 'body',
								'title'    => esc_html_x("Body",'Admin Panel', "naturalife"), 
								"description" => '<a class="highlight-section rt-panel-icon-flash" data-section-selector="body" href="#" title="'.esc_html_x('Blink the section (if used) in the current page.','Admin Panel','naturalife').'"></a>'. esc_html_x('Following settings will be applied to the page body and the content holder.','Admin Panel',"naturalife"),
								'controls' => array( 


													array(
														"id"          => "naturalife_boxed_body", 	
														"label"       => esc_html_x("Boxed",'Admin Panel','naturalife'),
														"description" => esc_html_x("Make the main container boxed.",'Admin Panel','naturalife'), 
														"transport"   => "refresh",														
														"default"     => "",
														"type"        => "checkbox",
														"rt_skin"     => true	
													),


 													array(
														"id"          => "naturalife_body_seperator2",	
														"label"       => esc_html_x('Body Background','Admin Panel','naturalife'),
														"description" => esc_html_x("Note: Page body will only be visible when a content row width is not full width or has a transparent background.",'Admin Panel','naturalife'),															
														"type"        => "rt_subsection_heading"
													),


													array(
														"id"          => "naturalife_body_background_color",	
														"label"       => esc_html_x("Background Color",'Admin Panel','naturalife'),
														"description" => "",
														"transport"   => "postMessage",
														"default"     => "#ffffff",															
														"type"        => "rt_color",
														"rt_skin"     => true
													),
													
													array(
														"id"          => "naturalife_body_background_image", 	
														"label"       => esc_html_x("Background Image",'Admin Panel','naturalife'),
														"description" => "",
														"transport"   => "refresh",															
														"type"        => "media",
														"default"     => "",
														"rt_skin"     => true
													), 
													 
													array(
														"id"          => "naturalife_body_background_position",	
														"label"       => esc_html_x("Position",'Admin Panel','naturalife'),
														"description" => "",
														"transport"   => "refresh",															
														"choices"     => array(		
																					"right top"     => esc_html_x("Right Top",'Admin Panel',"naturalife"),
																					"right center"  => esc_html_x("Right Center",'Admin Panel',"naturalife"),
																					"right bottom"  => esc_html_x("Right Bottom",'Admin Panel',"naturalife"),
																					"left top"      => esc_html_x("Left Top",'Admin Panel',"naturalife"),
																					"left center"   => esc_html_x("Left Center",'Admin Panel',"naturalife"),
																					"left bottom"   => esc_html_x("Left Bottom",'Admin Panel',"naturalife"),
																					"center top"    => esc_html_x("Center Top",'Admin Panel',"naturalife"),
																					"center center" => esc_html_x("Center Center",'Admin Panel',"naturalife"),
																					"center bottom" => esc_html_x("Center Bottom",'Admin Panel',"naturalife"),
																				),  
														"type"        => "select",
														"default"     => "center center",
														"rt_skin"     => true
													), 
												
													array(
														"id"          => "naturalife_body_background_attachment",	
														"label"       => esc_html_x("Attachment",'Admin Panel','naturalife'),
														"description" => "",
														"transport"   => "refresh",															
														"choices"     => array("scroll" =>esc_html_x("Scroll",'Admin Panel',"naturalife"), "fixed"  =>esc_html_x("Fixed",'Admin Panel',"naturalife")),  
														"type"        => "radio",
														"default"     => "scroll",
														"rt_skin"     => true
													),

													array(
														"id"          => "naturalife_body_background_repeat",	
														"label"       => esc_html_x("Repeat",'Admin Panel','naturalife'),
														"description" => "",
														"transport"   => "refresh",															
														"choices"     => array(		
																					"repeat"       => esc_html_x("Tile",'Admin Panel',"naturalife"),
																					"repeat-x"     => esc_html_x("Tile Horizontally",'Admin Panel',"naturalife"),
																					"repeat-y"     => esc_html_x("Tile Vertically",'Admin Panel',"naturalife"),
																					"no-repeat"    => esc_html_x("No Repeat",'Admin Panel',"naturalife"),
																				),  
														"type"        => "radio",
														"default"     => "repeat",
														"rt_skin"     => true
													),

													array(
														"id"          => "naturalife_body_background_size",	
														"label"       => esc_html_x("Background Size",'Admin Panel','naturalife'),
														"description" => "",
														"transport"   => "refresh",															
														"choices"     => array(		
																				"auto auto" => esc_html_x("Auto",'Admin Panel',"naturalife"),
																				"cover"     => esc_html_x("Cover",'Admin Panel',"naturalife"),
																				"contain"   => esc_html_x("Contain",'Admin Panel',"naturalife"),
																				"100% auto" => esc_html_x("100%",'Admin Panel',"naturalife"),
																				"50% auto"  => esc_html_x("50%",'Admin Panel',"naturalife"),
																				"25% auto"  => esc_html_x("25%",'Admin Panel',"naturalife"),
																			),  
														"default" => "auto auto",
														"type"    => "select",
														"rt_skin"   => true
													),   
											),
							),

							array(
								'id'       => 'content-rows',
								'title'    => esc_html_x("Content Rows", 'Admin Panel','naturalife'), 
								'controls' => array( 

													array(
														"id"          => "naturalife_default_content_wrapper_width",	
														"label"       => esc_html_x("Default Content Width",'Admin Panel','naturalife'),
														"description" => esc_html_x("Select a global width for the content rows.",'Admin Panel','naturalife'),
														"transport"   => "refresh",															
														"choices"     => array(		
																			"default" => esc_html_x("Default",'Admin Panel','naturalife'),
																			"fullwidth" => esc_html_x("Full Width",'Admin Panel','naturalife'),
																		),  
														"type"    => "select",
														"default" => "default",
														"rt_skin" => true
													)												
											),
							),

							array(
								'id'       => 'main_header',
								'title'    => esc_html_x("Header",'Admin Panel',"naturalife"), 
								"description" => '<a class="highlight-section rt-panel-icon-flash" data-section-selector=".main-header-holder" href="#" title="'.esc_html_x('Blink the section (if used) in the current page.','Admin Panel','naturalife').'"></a>'. esc_html_x('Use following settings to customize the header section of your website.','Admin Panel',"naturalife"),
								'controls' => array( 

												
													array(
														"id"          => "naturalife_default_header_settings",
														"label"       => esc_html_x('Preset Header Styles','Admin Panel','naturalife'),	

														"description" => esc_html_x('Select a preset header style to apply. Remember, you can always customize the header style manually by using the header related settings.','Admin Panel','naturalife')
																		.'<br /><br />'. sprintf(esc_html_x('%1$sNote:%2$s You may also need to re-organize the header related widgets via the %3$sWidgets%4$s section.','Admin Panel','naturalife'),'<strong>','</strong>','<strong><a href="#" class="rt-focus-widgets">','</a></strong>')
																		.'<br /><br /><span class="button-primary rt-skin-selector" tabindex="0" style="font-style:normal;"  data-value="layout1">'.esc_html_x('Select a Preset Header Style','Admin Panel','naturalife').'</span>',

														"type"        => "rt_seperator"
													),

													array(
														"id"          => "naturalife_display_header", 	
														"label"       => esc_html_x("Header Visibility",'Admin Panel','naturalife'),
														"description" => esc_html_x("Control the visibility of the header",'Admin Panel','naturalife'), 
														"transport"   => "refresh",															
														"default"     => true,
														"type"        => "checkbox",
														"rt_skin"     => true
													),


													array(
														"id"          => "naturalife_header_seperator_2",	
														"label"       => esc_html_x('Header Functionality','Admin Panel','naturalife'),															
														"type"        => "rt_subsection_heading"
													),

													array(
														"id"          => "naturalife_overlapped_header", 	
														"label"       => esc_html_x("Overlapped Header",'Admin Panel','naturalife'),
														"description" => esc_html_x("If checked the main header or a part of it will be overlapped onto the next content.",'Admin Panel','naturalife'), 
														"transport"   => "refresh",															
														"default"     => false,
														"type"        => "checkbox",
														"rt_skin"     => true
													),													

													array(
														"id"          => "naturalife_display_main_menu",		
														"label"       => esc_html_x("Display Main Menu",'Admin Panel','naturalife'),
														"description" => esc_html_x("Control the visibility of the the main navigation menu.",'Admin Panel','naturalife'), 
														"transport"   => "refresh",
														"default"     => true,
														"type"        => "checkbox",
														"rt_skin"     => true
													),																										


													array(
														"id"          => "naturalife_header_seperator_3",	
														"label"       => esc_html_x('Header Styling','Admin Panel','naturalife'),															
														"description" => wp_kses_post('Note: Skin related header colors can be found inside the "Styling Options > Dark Header Skin" and "Styling Options > Light Header Skin" sections.','Admin Panel','naturalife'),															
														"type"        => "rt_subsection_heading"
													),

													array(
														"id"          => "naturalife_header_width",	
														"label"       => esc_html_x("Global Header Width",'Admin Panel', 'naturalife'),
														"description" => "",
														"transport"   => "refresh",															
														"choices"     => array(		
																					"default"   => esc_html_x("Content Width",'Admin Panel', 'naturalife'),
																					"fullwidth" => esc_html_x("Full Width",'Admin Panel', 'naturalife'),  
																			),  
														"type" => "select",
														"default" => "default",
														"rt_skin"   => true
													),


													array(
														"id"          => "naturalife_header_color_skin",	
														"label"       => esc_html_x("Global Header Skin",'Admin Panel', 'naturalife'),
														"description" => "",
														"transport"   => "refresh",															
														"choices"     => array(		
																					"dark"  => esc_html_x("Header Dark Skin",'Admin Panel', 'naturalife'),
																					"light" => esc_html_x("Header Light Skin",'Admin Panel', 'naturalife'), 
																			),  
														"type" => "select",
														"default" => "dark",
														"rt_skin"   => true
													),

													array(
															"id"          => "naturalife_header_bg_color",	
															"label"       => esc_html_x("Background Color",'Admin Panel','naturalife'),
															"description" => "",
															"transport"   => "refresh",
															"default"     => "#ffffff",	 										
															"type"        => "rt_color",
															"rt_skin"     => true
													),		

													array(
														"id"          => "naturalife_header_style",	
														"label"       => esc_html_x("Global Header Style",'Admin Panel', 'naturalife'), 														
														"transport"   => "refresh",															
														"choices"     => array(		
																				"1"  => esc_html_x("Style 1",'Admin Panel', 'naturalife') ." - ". esc_html_x("One Row",'Admin Panel', 'naturalife'),
																				"2"  => esc_html_x("Style 2",'Admin Panel', 'naturalife') ." - ". esc_html_x("Two Rows",'Admin Panel', 'naturalife'), 
																			),  
														"type" => "select",
														"default" => "1",
														"rt_skin"   => true
													),

 													array(
														"id"          => "naturalife_header_height_single",	
														"label"       => esc_html_x("Header Height (px) - First Row",'Admin Panel','naturalife'),
														"description" =>  esc_html_x("Height of the first row of the header. The value should not be lower than 50px.",'Admin Panel','naturalife'), 
														"type"        => "number",
														"transport"   => "refresh",
														"default"     => 70,
														"input_attrs" => array("min"=>50,"max"=>500, "data-depends-id" => "naturalife_header_style", "data-depends-values" => "1"),
														"rt_skin"     => true
													),

 													array(
														"id"          => "naturalife_header_height_first",	
														"label"       => esc_html_x("Header Height (px) - First Row",'Admin Panel','naturalife'),
														"description" =>  esc_html_x("Height of the first row of the header. The value should not be lower than 50px.",'Admin Panel','naturalife'), 
														"type"        => "number",
														"transport"   => "refresh",
														"default"     => 60,
														"input_attrs" => array("min"=>50,"max"=>500, "data-depends-id" => "naturalife_header_style", "data-depends-values" => "2"),
														"rt_skin"     => true
													),

 													array(
														"id"          => "naturalife_header_height_second",	
														"label"       => esc_html_x("Header Height (px) - Second Row",'Admin Panel','naturalife'),
														"description" =>  esc_html_x("Height of the second row of the header. The value should not be lower than 30px.",'Admin Panel','naturalife'), 
														"type"        => "number",
														"transport"   => "refresh",
														"default"     => 30,
														"input_attrs" => array("min"=>30,"max"=>500,"data-depends-id" => "naturalife_header_style", "data-depends-values" => "2"),
														"rt_skin"     => true
													),

 													array(
														"id"          => "naturalife_header_vertical_padding",	
														"label"       => esc_html_x("Header Vertical Padding",'Admin Panel','naturalife'),
														"type"        => "number",
														"transport"   => "refresh",
														"default"     => 15,
														"input_attrs" => array("min"=>0,"max"=>200),
														"rt_skin"     => true
													),

													array(
														"id"          => "naturalife_header_seperator_4",	
														"description" => "",
														"label"       => esc_html_x('Header Item Locations','Admin Panel','naturalife'),															
														"type"        => "rt_subsection_heading"
													),

													array(
														"id"          => "naturalife_header_logo_location",	
														"label"       => esc_html_x("Logo Location",'Admin Panel', 'naturalife'),
														"description" => "",
														"transport"   => "refresh",															
														"choices"     => array(		
																				"1"  => esc_html_x("First Row - Left",'Admin Panel', 'naturalife'),
																				"2"  => esc_html_x("First Row - Center",'Admin Panel', 'naturalife'),
																				"3"  => esc_html_x("First Row - Right",'Admin Panel', 'naturalife'),
																				"4"  => esc_html_x("Second Row - Left",'Admin Panel', 'naturalife'),
																				"5"  => esc_html_x("Second Row - Center",'Admin Panel', 'naturalife'),
																				"6"  => esc_html_x("Second Row - Right",'Admin Panel', 'naturalife'),
																			),  
														"type" => "select",
														"default" => "1",
														"rt_skin"   => true
													),

													array(
														"id"          => "naturalife_header_menu_location",	
														"label"       => esc_html_x("Menu Location",'Admin Panel', 'naturalife'),
														"description" => "",
														"transport"   => "refresh",															
														"choices"     => array(		
																				"1"  => esc_html_x("First Row - Left",'Admin Panel', 'naturalife'),
																				"2"  => esc_html_x("First Row - Center",'Admin Panel', 'naturalife'),
																				"3"  => esc_html_x("First Row - Right",'Admin Panel', 'naturalife'),
																				"4"  => esc_html_x("Second Row - Left",'Admin Panel', 'naturalife'),
																				"5"  => esc_html_x("Second Row - Center",'Admin Panel', 'naturalife'),
																				"6"  => esc_html_x("Second Row - Right",'Admin Panel', 'naturalife'),
																			),  
														"type" => "select",
														"default" => "1",
														"rt_skin"   => true
													),

													array(
														"id"          => "naturalife_header_icon_location",	
														"label"       => esc_html_x("Header Tools Location",'Admin Panel', 'naturalife'),
														"description" => "",
														"transport"   => "refresh",															
														"choices"     => array(		
																				"1"  => esc_html_x("First Row - Left",'Admin Panel', 'naturalife'), 
																				"3"  => esc_html_x("First Row - Right",'Admin Panel', 'naturalife'),
																				"4"  => esc_html_x("Second Row - Left",'Admin Panel', 'naturalife'), 
																				"6"  => esc_html_x("Second Row - Right",'Admin Panel', 'naturalife'),
																			),  
														"type" => "select",
														"default" => "3",
														"rt_skin"   => true
													),

													array(
														"id"          => "naturalife_header_seperator_5",	
														"description" => "",
														"label"       => esc_html_x('Navigation Paddings','Admin Panel','naturalife'),															
														"type"        => "rt_subsection_heading"
													),

													array(
														"id"          => "naturalife_nav_item_vertical_padding",	
														"label"       => esc_html_x("Item Vertical Padding (px)",'Admin Panel','naturalife'),
														"type"        => "number",
														"transport"   => "refresh",
														"default"     => 8,
														"input_attrs" => array("min"=>0,"max"=>100),
														"rt_skin"     => true
													),

													array(
														"id"          => "naturalife_nav_item_horizontal_padding",	
														"label"       => esc_html_x("Item Horizontal Padding (px)",'Admin Panel','naturalife'),
														"type"        => "number",
														"transport"   => "refresh",
														"default"     => 12,
														"input_attrs" => array("min"=>0,"max"=>100),
														"rt_skin"     => true
													),

													array(
														"id"          => "naturalife_sub_nav_item_horizontal_padding",	
														"label"       => esc_html_x("Sub Item Horizontal Padding (px)",'Admin Panel','naturalife'),
														"type"        => "number",
														"transport"   => "refresh",
														"default"     => 20,
														"input_attrs" => array("min"=>0,"max"=>100),
														"rt_skin"     => true
													),
											),
							),		

							array(
								'id'       => 'sticky_header',
								'title'    => esc_html_x("Sticky Header",'Admin Panel',"naturalife"), 
								"description" => '<a class="highlight-section rt-panel-icon-flash" data-section-selector=".sticky-header-holder" href="#" title="'.esc_html_x('Blink the section (if used) in the current page.','Admin Panel','naturalife').'"></a>'. esc_html_x('Use following settings to customize the header section of your website.','Admin Panel',"naturalife"),
								'controls' => array( 


													array(
														"id"          => "naturalife_sticky_header", 	
														"label"       => esc_html_x("Sticky Header",'Admin Panel','naturalife'),
														"description" => esc_html_x("Enable / disable the sticky header.",'Admin Panel','naturalife'), 
														"transport"   => "refresh",															
														"default"     => true,
														"type"        => "checkbox",
														"rt_skin"     => true
													),


													array(
														"id"          => "naturalife_sticky_header_style",	
														"label"       => esc_html_x("Sticky Header Behaviour",'Admin Panel', 'naturalife'),
														"description" => "",
														"transport"   => "refresh",															
														"choices"     => array(		
																				"1" => esc_html_x("Stick when scrolling up",'Admin Panel', 'naturalife'),
																				"2" => esc_html_x("Stick always",'Admin Panel', 'naturalife'),
																			),  
														"type" => "select",
														"default" => "1",
														"rt_skin"   => true
													),

													array(
														"id"          => "naturalife_sticky_header_seperator_1",	
														"label"       => esc_html_x('Sticky Header Styling','Admin Panel','naturalife'),															
														"description" => wp_kses_post('Note: Skin related header colors can be found inside the "Styling Options > Dark Header Skin" and "Styling Options > Light Header Skin" sections.','Admin Panel','naturalife'),															
														"type"        => "rt_subsection_heading"
													),

													array(
														"id"          => "naturalife_sticky_header_width",	
														"label"       => esc_html_x("Global Sticky Header Width",'Admin Panel', 'naturalife'),
														"description" => "",
														"transport"   => "refresh",															
														"choices"     => array(		
																					"default"   => esc_html_x("Content Width",'Admin Panel', 'naturalife'),
																					"fullwidth" => esc_html_x("Full Width",'Admin Panel', 'naturalife'),  
																			),  
														"type" => "select",
														"default" => "default",
														"rt_skin"   => true
													),													

													array(
														"id"          => "naturalife_header_color_skin_sticky",	
														"label"       => esc_html_x("Global Sticky Header Skin",'Admin Panel', 'naturalife'),
														"description" => "",
														"transport"   => "refresh",															
														"choices"     => array(		
																				"dark"  => esc_html_x("Header Dark Skin",'Admin Panel', 'naturalife'),
																				"light" => esc_html_x("Header Light Skin",'Admin Panel', 'naturalife'), 
																			),  
														"type" => "select",
														"default" => "dark",
														"rt_skin"   => true
													),

													array(
														"id"          => "naturalife_sticky_header_bg_color",	
														"label"       => esc_html_x("Sticky Header Background Color",'Admin Panel','naturalife'),
														"description" => "",
														"transport"   => "refresh",
														"default"     => "#ffffff",															
														"type"        => "rt_color",
														"rt_skin"     => true
													),		

													array(
														"id"          => "naturalife_sticky_header_seperator_2",	
														"description" => "",
														"label"       => esc_html_x('Sticky Header Item Locations','Admin Panel','naturalife'),															
														"type"        => "rt_subsection_heading"
													),

													array(
														"id"          => "naturalife_sticky_header_logo_location",	
														"label"       => esc_html_x("Logo Location",'Admin Panel', 'naturalife'),
														"description" => "",
														"transport"   => "refresh",															
														"choices"     => array(		
																				"1"  => esc_html_x("First Row - Left",'Admin Panel', 'naturalife'),
																				"2"  => esc_html_x("First Row - Center",'Admin Panel', 'naturalife'),
																				"3"  => esc_html_x("First Row - Right",'Admin Panel', 'naturalife'), 
																				"none"   => esc_html_x("Disabled",'Admin Panel', 'naturalife'), 
																			),  
														"type" => "select",
														"default" => "1",
														"rt_skin"   => true
													),

													array(
														"id"          => "naturalife_sticky_header_menu_location",	
														"label"       => esc_html_x("Menu Location",'Admin Panel', 'naturalife'),
														"description" => "",
														"transport"   => "refresh",															
														"choices"     => array(		
																				"1"  => esc_html_x("First Row - Left",'Admin Panel', 'naturalife'),
																				"2"  => esc_html_x("First Row - Center",'Admin Panel', 'naturalife'),
																				"3"  => esc_html_x("First Row - Right",'Admin Panel', 'naturalife'), 
																				"none"   => esc_html_x("Disabled",'Admin Panel', 'naturalife'), 
																			),  
														"type" => "select",
														"default" => "1",
														"rt_skin"   => true
													),

													array(
														"id"          => "naturalife_sticky_header_icon_location",	
														"label"       => esc_html_x("Header Tools Location",'Admin Panel', 'naturalife'),
														"description" => "",
														"transport"   => "refresh",															
														"choices"     => array(		
																				"1"  => esc_html_x("First Row - Left",'Admin Panel', 'naturalife'), 
																				"3"  => esc_html_x("First Row - Right",'Admin Panel', 'naturalife'), 
																				"none"   => esc_html_x("Disabled",'Admin Panel', 'naturalife'), 
																			),  
														"type" => "select",
														"default" => "3",
														"rt_skin"   => true
													),
											),
							),

							array(
								'id'       => 'mobile_header',
								'title'    => esc_html_x("Mobile Header",'Admin Panel',"naturalife"), 
								"description" => '<a class="highlight-section rt-panel-icon-flash" data-section-selector=".mobile-header" href="#" title="'.esc_html_x('Blink the section (if used) in the current page.','Admin Panel','naturalife').'"></a>'. esc_html_x('Use following settings to customize the header section of your website.','Admin Panel',"naturalife"),
								'controls' => array( 

													array(
														"id"          => "naturalife_display_mobile_header",		
														"label"       => esc_html_x("Mobile Header Visibility",'Admin Panel','naturalife'),
														"description" => esc_html_x('Control the visibility of the mobile header.','Admin Panel','naturalife'),
														"transport"   => "refresh",															
														"default"     => true,
														"type"        => "checkbox",
														"rt_skin"     => true
													),

													array(
														"id"          => "naturalife_sticky_mobile_header",		
														"label"       => esc_html_x("Sticky Mobile Header",'Admin Panel','naturalife'),
														"description" => esc_html_x("Enable / disable the sticky mobile header.",'Admin Panel','naturalife'), 
														"transport"   => "refresh",															
														"default"     => true,
														"type"        => "checkbox",
														"rt_skin"     => true
													),


													array(
														"id"          => "naturalife_header_color_skin_mobile",	
														"label"       => esc_html_x("Mobile Header Skin",'Admin Panel', 'naturalife'),
														"description" => "",
														"transport"   => "refresh",															
														"choices"     => array(		
																					"dark"  => esc_html_x("Header Dark Skin",'Admin Panel', 'naturalife'),
																					"light" => esc_html_x("Header Light Skin",'Admin Panel', 'naturalife'), 
																			),  
														"type" => "select",
														"default" => "dark",
														"rt_skin"   => true
													),

 													array(
														"id"          => "naturalife_mobile_header_height",	
														"label"       => esc_html_x("Mobile Header Max Height (px)",'Admin Panel','naturalife'),
														"description" =>  esc_html_x("Maximum height of the mobile header.",'Admin Panel','naturalife'), 
														"type"        => "number",
														"transport"   => "refresh",
														"default"     => 50,
														"input_attrs" => array("min"=>20,"max"=>200),
														"rt_skin"     => true
													),

													array(
														"id"          => "naturalife_mobile_header_top_padding",	
														"label"       => esc_html_x("Top Padding (px)",'Admin Panel','naturalife'),
														"type"        => "number",
														"transport"   => "refresh",
														"default"     => 10,
														"input_attrs" => array("min"=>0,"max"=>100),
														"rt_skin"     => true
													),

													array(
														"id"          => "naturalife_mobile_header_bottom_padding",	
														"label"       => esc_html_x("Bottom Padding (px)",'Admin Panel','naturalife'),
														"type"        => "number",
														"transport"   => "refresh",
														"default"     => 10,
														"input_attrs" => array("min"=>0,"max"=>100),
														"rt_skin"     => true
													),
 
													array(
														"id"          => "naturalife_mobile_header_row_bg_color",	
														"label"       => esc_html_x("Background Color",'Admin Panel','naturalife'),
														"description" => "",
														"transport"   => "refresh",
														"default"     => "#ffffff",															
														"type"        => "rt_color",
														"rt_skin"     => true
													),		
 
												), 
							),		

							array(
								'id'       => 'header_icons',
								'title'    => esc_html_x("Header Tools",'Admin Panel',"naturalife"), 
								"description" => '<a class="highlight-section rt-panel-icon-flash" data-section-selector=".header-tools" href="#" title="'.esc_html_x('Blink the section (if used) in the current page.','Admin Panel','naturalife').'"></a>'. esc_html_x('Use following settings to customize the header section of your website.','Admin Panel',"naturalife"),
								'controls' => array( 

													array(
														"id"          => "naturalife_header_wpml",		
														"label"       => esc_html_x("Display Languages Menu Icon",'Admin Panel','naturalife'),
														"description" => "",
														"transport"   => "refresh",															
														"default"     => true,
														"type"        => "checkbox",
														"rt_skin"     => true
													),

													array(
														"id"          => "naturalife_header_search",		
														"label"       => esc_html_x("Display Search Icon",'Admin Panel','naturalife'),
														"description" => "",
														"transport"   => "refresh",															
														"default"     => true,
														"type"        => "checkbox",
														"rt_skin"     => true
													),

													array(
														"id"          => "naturalife_header_cart",		
														"label"       => esc_html_x("Display Cart Icon",'Admin Panel','naturalife'),
														"description" => "",
														"transport"   => "refresh",															
														"default"     => true,
														"type"        => "checkbox",
														"rt_skin"     => true
													),

													array(
														"id"          => "naturalife_header_user",		
														"label"       => esc_html_x("Display User Icon",'Admin Panel','naturalife'),
														"description" => "",
														"transport"   => "refresh",															
														"default"     => false,
														"type"        => "checkbox",
														"rt_skin"     => true
													),
											),
							),

							array(
								'id'       => 'main_header_dark_skin',
								'title'    => esc_html_x("Dark Header Skin",'Admin Panel',"naturalife"), 
								"description" => '<a class="highlight-section rt-panel-icon-flash" data-section-selector=".naturalife-dark-header  .top-header" href="#" title="'.esc_html_x('Blink the section (if used) in the current page.','Admin Panel','naturalife').'"></a>'. esc_html_x('Use following settings to customize the dark header skin of your website.','Admin Panel',"naturalife"),
								'controls' => array( 


													array(
														"id"          => "main_header_dark_skin_c1",	
														"label"       => esc_html_x('Colors','Admin Panel','naturalife'),															
														"description" => "",															
														"type"        => "rt_subsection_heading"
													),

 													array(
														"id"          => "naturalife_main_header_primary_color_dark",	
														"label"       => esc_html_x("Primary Color",'Admin Panel','naturalife'),
														"description" => "",
														"transport"   => "refresh",
														"default"     => "#84BE38",															
														"type"        => "rt_color",
														"rt_skin"     => true
													),		 

 													array(
														"id"          => "naturalife_main_header_border_color_dark",	
														"label"       => esc_html_x("Border Color",'Admin Panel','naturalife'),
														"description" => "",
														"transport"   => "refresh",
														"default"     => "rgba(0, 0, 0, 0.07)",															
														"type"        => "rt_color",
														"rt_skin"     => true
													),		 
 	 
													array(
														"id"          => "naturalife_main_header_font_color_dark",	
														"label"       => esc_html_x("Header Text Font Color",'Admin Panel','naturalife'),
														"transport"   => "refresh",
														"default"     => "#808080",
														"type"        => "rt_color",
														"rt_skin"     => true
													),


													array(
														"id"          => "main_header_dark_skin_s2",	
														"label"       => esc_html_x('Top Level Menu Items','Admin Panel','naturalife'),															
														"description" => esc_html_x("Customize the top level menu items of the main navigation which appears top of the page.",'Admin Panel','naturalife'),															
														"type"        => "rt_subsection_heading"
													),

													array(
														"id"          => "naturalife_nav_item_background_color_dark",	
														"label"       => esc_html_x("Menu Item Background Color",'Admin Panel','naturalife'),
														"description" => "",
														"transport"   => "postMessage",
														"default"     => "",															
														"type"        => "rt_color",
														"rt_skin"   => true
													),
													 
													array(
														"id"          => "naturalife_nav_item_font_color_dark",	
														"label"       => esc_html_x("Menu Item Font Color",'Admin Panel','naturalife'),
														"description" => "",
														"transport"   => "postMessage",
														"default"     => "#444444",															
														"type"        => "rt_color",
														"rt_skin"   => true
													),		 

													array(
														"id"          => "naturalife_nav_item_border_color_dark",	
														"label"       => esc_html_x("Menu Item Border Color",'Admin Panel','naturalife'),
														"description" => "",
														"transport"   => "postMessage",
														"default"     => "",															
														"type"        => "rt_color",
														"rt_skin"   => true
													),		 

													array(
														"id"          => "naturalife_nav_item_background_color_active_dark",	
														"label"       => esc_html_x("Active Menu Item Background Color",'Admin Panel','naturalife'),
														"description" => "",
														"transport"   => "refresh",
														"default"     => "",															
														"type"        => "rt_color",
														"rt_skin"   => true
													),
													 
													array(
														"id"          => "naturalife_nav_item_font_color_active_dark",	
														"label"       => esc_html_x("Active Menu Item Font Color",'Admin Panel','naturalife'),
														"description" => "",
														"transport"   => "refresh",
														"default"     => "#808080",															
														"type"        => "rt_color",
														"rt_skin"   => true
													),

													array(
														"id"          => "naturalife_nav_item_indicator_color_active_dark",	
														"label"       => esc_html_x("Active Menu Item Indicator Color",'Admin Panel','naturalife'),
														"description" => "",
														"transport"   => "refresh",
														"default"     => "#84BE38",															
														"type"        => "rt_color",
														"rt_skin"   => true
													),


													array(
														"id"          => "main_header_dark_skin_s3",	
														"label"       => esc_html_x('Sub Level Menu Items','Admin Panel','naturalife'),															
														"description" => esc_html_x('Customize the sub level menu items of the main navigation.','Admin Panel','naturalife'),															
														"type"        => "rt_subsection_heading"
													),

													array(
														"id"          => "naturalife_sub_nav_item_background_color_dark",	
														"label"       => esc_html_x("Sub Menu Item Background Color",'Admin Panel','naturalife'),
														"description" => "",
														"transport"   => "postMessage",
														"default"     => "#ffffff",															
														"type"        => "rt_color",
														"rt_skin"   => true
													),
													 
													array(
														"id"          => "naturalife_sub_nav_item_font_color_dark",	
														"label"       => esc_html_x("Sub Menu Item Font Color",'Admin Panel','naturalife'),
														"description" => "",
														"transport"   => "postMessage",
														"default"     => "#666666",															
														"type"        => "rt_color",
														"rt_skin"   => true
													),						 

													array(
														"id"          => "naturalife_sub_nav_item_desc_font_color_dark",	
														"label"       => esc_html_x("Sub Menu Item Description Font Color",'Admin Panel','naturalife'),
														"description" => "",
														"transport"   => "postMessage",
														"default"     => "#999999",															
														"type"        => "rt_color",
														"rt_skin"   => true
													),		

													array(
														"id"          => "naturalife_sub_nav_item_border_color_dark",	
														"label"       => esc_html_x("Sub Menu Item Border Color",'Admin Panel','naturalife'),
														"description" => "",
														"transport"   => "postMessage",
														"default"     => "#efefef",															
														"type"        => "rt_color",
														"rt_skin"   => true
													),		 

													array(
														"id"          => "naturalife_sub_nav_item_background_color_active_dark",	
														"label"       => esc_html_x("Active Sub Menu Item Background Color",'Admin Panel','naturalife'),
														"description" => "",
														"transport"   => "refresh",
														"default"     => "",															
														"type"        => "rt_color",
														"rt_skin"   => true
													),
													 
													array(
														"id"          => "naturalife_sub_nav_item_font_color_active_dark",	
														"label"       => esc_html_x("Active Sub Menu Item Font Color",'Admin Panel','naturalife'),
														"description" => "",
														"transport"   => "refresh",
														"default"     => "#84BE38",															
														"type"        => "rt_color",
														"rt_skin"   => true
													),

													array(
														"id"          => "naturalife_sub_nav_item_indicator_color_active_dark",	
														"label"       => esc_html_x("Active Sub Menu Item Indicator Color",'Admin Panel','naturalife'),
														"description" => "",
														"transport"   => "refresh",
														"default"     => "#84BE38",															
														"type"        => "rt_color",
														"rt_skin"   => true
													),
 
 													array(
														"id"          => "naturalife_mega_title_item_font_color_dark",	
														"label"       => esc_html_x("Multi Column Title Item Font Color",'Admin Panel','naturalife'),
														"description" => "",
														"transport"   => "refresh",
														"default"     => "#999999",															
														"type"        => "rt_color",
														"rt_skin"   => true
													),		 

													array(
														"id"          => "naturalife_mega_title_item_border_color_dark",	
														"label"       => esc_html_x("Multi Column Title Item Border Color",'Admin Panel','naturalife'),
														"description" => "",
														"transport"   => "refresh",
														"default"     => "#efefef",															
														"type"        => "rt_color",
														"rt_skin"   => true
													),		 

											),
							),		

							array(
								'id'       => 'main_header_light_skin',
								'title'    => esc_html_x("Light Header Skin",'Admin Panel',"naturalife"), 
								"description" => '<a class="highlight-section rt-panel-icon-flash" data-section-selector=".naturalife-light-header .top-header" href="#" title="'.esc_html_x('Blink the section (if used) in the current page.','Admin Panel','naturalife').'"></a>'. esc_html_x('Use following settings to customize the light header skin of your website.','Admin Panel',"naturalife"),
								'controls' => array( 

													array(
														"id"          => "main_header_light_skin_c1",	
														"label"       => esc_html_x('Colors','Admin Panel','naturalife'),															
														"description" => "",															
														"type"        => "rt_subsection_heading"
													),


 													array(
														"id"          => "naturalife_main_header_primary_color_light",	
														"label"       => esc_html_x("Primary Color",'Admin Panel','naturalife'),
														"description" => "",
														"transport"   => "refresh",
														"default"     => "rgba(255, 255, 255, 0.85)",															
														"type"        => "rt_color",
														"rt_skin"     => true
													),		 

 													array(
														"id"          => "naturalife_main_header_border_color_light",	
														"label"       => esc_html_x("Border Color",'Admin Panel','naturalife'),
														"description" => "",
														"transport"   => "refresh",
														"default"     => "rgba(255, 255, 255, 0.2)",															
														"type"        => "rt_color",
														"rt_skin"     => true
													),		 

													array(
														"id"          => "naturalife_main_header_font_color_light",	
														"label"       => esc_html_x("Text Logo Font Color",'Admin Panel','naturalife'),
														"transport"   => "refresh",
														"default"     => "#ffffff",
														"type"        => "rt_color",
														"rt_skin"     => true
													),

													array(
														"id"          => "main_header_light_skin_s2",	
														"label"       => esc_html_x('Top Level Menu Items','Admin Panel','naturalife'),															
														"description" => esc_html_x("Customize the top level menu items of the main navigation which appears top of the page.",'Admin Panel','naturalife'),															
														"type"        => "rt_subsection_heading"
													),


													array(
														"id"          => "naturalife_nav_item_background_color_light",	
														"label"       => esc_html_x("Menu Item Background Color",'Admin Panel','naturalife'),
														"description" => "",
														"transport"   => "postMessage",
														"default"     => "",															
														"type"        => "rt_color",
														"rt_skin"   => true
													),
													 
													array(
														"id"          => "naturalife_nav_item_font_color_light",	
														"label"       => esc_html_x("Menu Item Font Color",'Admin Panel','naturalife'),
														"description" => "",
														"transport"   => "postMessage",
														"default"     => "#ffffff",															
														"type"        => "rt_color",
														"rt_skin"   => true
													),		 

													array(
														"id"          => "naturalife_nav_item_border_color_light",	
														"label"       => esc_html_x("Menu Item Border Color",'Admin Panel','naturalife'),
														"description" => "",
														"transport"   => "postMessage",
														"default"     => "",															
														"type"        => "rt_color",
														"rt_skin"   => true
													),		 

													array(
														"id"          => "naturalife_nav_item_background_color_active_light",	
														"label"       => esc_html_x("Active Menu Item Background Color",'Admin Panel','naturalife'),
														"description" => "",
														"transport"   => "refresh",
														"default"     => "",															
														"type"        => "rt_color",
														"rt_skin"   => true
													),
													 
													array(
														"id"          => "naturalife_nav_item_font_color_active_light",	
														"label"       => esc_html_x("Active Menu Item Font Color",'Admin Panel','naturalife'),
														"description" => "",
														"transport"   => "refresh",
														"default"     => "rgba(255, 255, 255, 0.5)",															
														"type"        => "rt_color",
														"rt_skin"   => true
													),

													array(
														"id"          => "naturalife_nav_item_indicator_color_active_light",	
														"label"       => esc_html_x("Active Menu Item Indicator Color",'Admin Panel','naturalife'),
														"description" => "",
														"transport"   => "refresh",
														"default"     => "rgba(255, 255, 255, 0.52)",															
														"type"        => "rt_color",
														"rt_skin"   => true
													),


													array(
														"id"          => "main_header_light_skin_s3",	
														"label"       => esc_html_x('Sub Level Menu Items','Admin Panel','naturalife'),															
														"description" => esc_html_x('Customize the sub level menu items of the main navigation.','Admin Panel','naturalife'),															
														"type"        => "rt_subsection_heading"
													),

													array(
														"id"          => "naturalife_sub_nav_item_background_color_light",	
														"label"       => esc_html_x("Sub Menu Item Background Color",'Admin Panel','naturalife'),
														"description" => "",
														"transport"   => "postMessage",
														"default"     => "#ffffff",															
														"type"        => "rt_color",
														"rt_skin"   => true
													),
													 
													array(
														"id"          => "naturalife_sub_nav_item_font_color_light",	
														"label"       => esc_html_x("Sub Menu Item Font Color",'Admin Panel','naturalife'),
														"description" => "",
														"transport"   => "postMessage",
														"default"     => "#666666",															
														"type"        => "rt_color",
														"rt_skin"   => true
													),						 

													array(
														"id"          => "naturalife_sub_nav_item_desc_font_color_light",	
														"label"       => esc_html_x("Sub Menu Item Description Font Color",'Admin Panel','naturalife'),
														"description" => "",
														"transport"   => "postMessage",
														"default"     => "#999999",															
														"type"        => "rt_color",
														"rt_skin"   => true
													),		

													array(
														"id"          => "naturalife_sub_nav_item_border_color_light",	
														"label"       => esc_html_x("Sub Menu Item Border Color",'Admin Panel','naturalife'),
														"description" => "",
														"transport"   => "postMessage",
														"default"     => "#efefef",															
														"type"        => "rt_color",
														"rt_skin"   => true
													),		 

													array(
														"id"          => "naturalife_sub_nav_item_background_color_active_light",	
														"label"       => esc_html_x("Active Sub Menu Item Background Color",'Admin Panel','naturalife'),
														"description" => "",
														"transport"   => "refresh",
														"default"     => "",															
														"type"        => "rt_color",
														"rt_skin"   => true
													),
													 
													array(
														"id"          => "naturalife_sub_nav_item_font_color_active_light",	
														"label"       => esc_html_x("Active Sub Menu Item Font Color",'Admin Panel','naturalife'),
														"description" => "",
														"transport"   => "refresh",
														"default"     => "#84BE38",															
														"type"        => "rt_color",
														"rt_skin"   => true
													),

													array(
														"id"          => "naturalife_sub_nav_item_indicator_color_active_light",	
														"label"       => esc_html_x("Active Sub Menu Item Indicator Color",'Admin Panel','naturalife'),
														"description" => "",
														"transport"   => "refresh",
														"default"     => "#84BE38",															
														"type"        => "rt_color",
														"rt_skin"   => true
													),
 
  													array(
														"id"          => "naturalife_mega_title_item_font_color_light",	
														"label"       => esc_html_x("Multi Column Title Item Font Color",'Admin Panel','naturalife'),
														"description" => "",
														"transport"   => "refresh",
														"default"     => "#999999",															
														"type"        => "rt_color",
														"rt_skin"   => true
													),		 

													array(
														"id"          => "naturalife_mega_title_item_border_color_light",	
														"label"       => esc_html_x("Multi Column Title Item Border Color",'Admin Panel','naturalife'),
														"description" => "",
														"transport"   => "refresh",
														"default"     => "#efefef",															
														"type"        => "rt_color",
														"rt_skin"   => true
													),		 

											),
							),		
 
							array(
								'id'       => 'sub_header',
								'title'    => esc_html_x("Sub Header", 'Admin Panel',"naturalife"), 
								"description" => '<a class="highlight-section rt-panel-icon-flash" data-section-selector=".sub-page-header" href="#" title="'.esc_html_x('Blink the section (if used) in the current page.','Admin Panel','naturalife').'"></a>'. esc_html_x('Use following settings to customize the sub header section of your website.','Admin Panel',"naturalife"),
								'controls' => array( 

													array(
														"id"          => "naturalife_hide_sub_header", 	
														"label"       => esc_html_x("Hide the entire sub header",'Admin Panel','naturalife'),
														"description" => "",
														"transport"   => "refresh",															
														"default"     => "",
														"type"        => "checkbox",
														"rt_skin"     => true
													),

													array(
														"id"          => "naturalife_hide_page_title", 	
														"label"       => esc_html_x("Hide the page title",'Admin Panel','naturalife'),
														"description" => "",
														"transport"   => "refresh",															
														"default"     => "",
														"type"        => "checkbox",
														"rt_skin"     => true
													),

													array(
														"id"          => "naturalife_hide_breadcrumb_menu", 	
														"label"       => esc_html_x("Hide the breadcrumb menu",'Admin Panel','naturalife'),
														"description" => "",
														"transport"   => "refresh",															
														"default"     => "",
														"type"        => "checkbox",
														"rt_skin"     => true
													),

													array(
														"id"          => "naturalife_sub_header_seperator",	
														"label"       => esc_html_x('Sub Header Styling','Admin Panel','naturalife'),															
														"type"        => "rt_subsection_heading"
													),													

													array(
														"id"          => "naturalife_sub_header_style",	
														"label"       => esc_html_x("Style",'Admin Panel','naturalife'),
														"description" => "",
														"transport"   => "refresh",															
														"choices"     => array(		
																			"style-1"  => esc_html_x("Style 1",'Admin Panel','naturalife') ."-". esc_html_x("Classic",'Admin Panel','naturalife'), 
																			"style-2"  => esc_html_x("Style 2",'Admin Panel','naturalife') ."-". esc_html_x("Centered Title & Breadcrumb Menu",'Admin Panel','naturalife'), 
																		),  
														"default" => "style-1",
														"type"    => "select",
														"rt_skin" => true
													), 

													array(
														"id"          => "naturalife_sub_header_top_padding",	
														"label"       => esc_html_x("Top Padding (px)",'Admin Panel','naturalife'),
														"type"        => "number",
														"transport"   => "refresh",
														"default"     => 60,
														"input_attrs" => array("min"=>0,"max"=>100),
														"rt_skin"     => true
													),

													array(
														"id"          => "naturalife_sub_header_bottom_padding",	
														"label"       => esc_html_x("Bottom Padding (px)",'Admin Panel','naturalife'),
														"type"        => "number",
														"transport"   => "refresh",
														"default"     => 60,
														"input_attrs" => array("min"=>0,"max"=>100),
														"rt_skin"     => true
													),

													array(
														"id"          => "naturalife_sub_header_seperator_4",	
														"label"       => esc_html_x('Page Title','Admin Panel','naturalife'),															
														"type"        => "rt_subsection_heading"
													),

													array(
														"id"          => "naturalife_sub_header_font_color",	
														"label"       => esc_html_x("Page Title Font Color",'Admin Panel','naturalife'),
														"description" => "",
														"transport"   => "refresh",
														"default"     => "#ffffff",															
														"type"        => "color",
														"rt_skin"     => true
													),			

													array(
														"id"          => "naturalife_sub_header_seperator_1",	
														"label"       => esc_html_x('Background','Admin Panel','naturalife'),															
														"type"        => "rt_subsection_heading"
													),

													array(
														"id"          => "naturalife_sub_header_bg_color",	
														"label"       => esc_html_x("Background Color",'Admin Panel','naturalife'),
														"description" => "",
														"transport"   => "refresh",
														"default"     => "#84BE38",
														"type"        => "rt_color",
														"rt_skin"     => true
													),			

													array(
														"id"          => "naturalife_sub_header_bg_image", 	
														"label"       => esc_html_x("Background Image",'Admin Panel','naturalife'),
														"description" => "",
														"transport"   => "refresh",															
														"type"        => "media",
														"rt_skin"     => true
													), 
													
													array(
														"id"          => "naturalife_sub_header_bg_position",	
														"label"       => esc_html_x("Position",'Admin Panel','naturalife'),
														"description" => "",
														"transport"   => "refresh",															
														"choices"     => array(		
																			"right top"     => esc_html_x("Right Top",'Admin Panel','naturalife'),
																			"right center"  => esc_html_x("Right Center",'Admin Panel','naturalife'),
																			"right bottom"  => esc_html_x("Right Bottom",'Admin Panel','naturalife'),
																			"left top"      => esc_html_x("Left Top",'Admin Panel','naturalife'),
																			"left center"   => esc_html_x("Left Center",'Admin Panel','naturalife'),
																			"left bottom"   => esc_html_x("Left Bottom",'Admin Panel','naturalife'),
																			"center top"    => esc_html_x("Center Top",'Admin Panel','naturalife'),
																			"center center" => esc_html_x("Center Center",'Admin Panel','naturalife'),
																			"center bottom" => esc_html_x("Center Bottom",'Admin Panel','naturalife'),
																		),  
														"type"    => "select",
														"rt_skin" => true
													), 

												
													array(
														"id"          => "naturalife_sub_header_bg_attachment",	
														"label"       => esc_html_x("Attachment",'Admin Panel','naturalife'),
														"description" => "",
														"transport"   => "refresh",															
														"choices"     => array("scroll" =>esc_html_x("Scroll",'Admin Panel','naturalife'), "fixed"  =>esc_html_x("Fixed",'Admin Panel','naturalife')),  
														"type"        => "radio",
														"default"     => "scroll",
														"rt_skin"   => true
													),


													array(
														"id"          => "naturalife_sub_header_bg_repeat",	
														"label"       => esc_html_x("Repeat",'Admin Panel','naturalife'),
														"description" => "",
														"transport"   => "refresh",															
														"choices"     => array(		
																		"repeat"       => esc_html_x("Tile",'Admin Panel','naturalife'),
																		"repeat-x"     => esc_html_x("Tile Horizontally",'Admin Panel','naturalife'),
																		"repeat-y"     => esc_html_x("Tile Vertically",'Admin Panel','naturalife'),
																		"no-repeat"    => esc_html_x("No Repeat",'Admin Panel','naturalife'),
																		),  
														"type"    => "radio",
														"default" => "no-repeat",
														"rt_skin"   => true
													),

													array(
														"id"          => "naturalife_sub_header_bg_size",	
														"label"       => esc_html_x("Background Size",'Admin Panel','naturalife'),
														"description" => "",
														"transport"   => "refresh",															
														"choices"     => array(		
																		"auto auto" => esc_html_x("Auto",'Admin Panel','naturalife'),
																		"cover" => esc_html_x("Cover",'Admin Panel','naturalife'),
																		"contain" => esc_html_x("Contain",'Admin Panel','naturalife'),
																		"100% auto" => esc_html_x("100%",'Admin Panel','naturalife'),
																		"50% auto" => esc_html_x("50%",'Admin Panel','naturalife'),
																		"25% auto" => esc_html_x("25%",'Admin Panel','naturalife'),
																		),  
														"default" => "auto auto",
														"type"    => "select",
														"rt_skin"   => true
													),  


													array(
														"id"          => "naturalife_sub_header_overlay_color",	
														"label"       => esc_html_x("Overlay Color",'Admin Panel','naturalife'),
														"description" => "",
														"transport"   => "refresh",
														"default"     => "",
														"type"        => "rt_color",
														"rt_skin"     => true
													),			

													array(
														"id"          => "naturalife_sub_header_seperator_2",	
														"label"       => esc_html_x('Breadcrumb Menu Styling','Admin Panel','naturalife'),															
														"type"        => "rt_subsection_heading"
													),

													array(
														"id"          => "naturalife_breadcrumb_font_color",	
														"label"       => esc_html_x("Breadcrumb Font Color",'Admin Panel','naturalife'),
														"description" => "",
														"transport"   => "postMessage",
														"default"     => "rgba(255, 255, 255, 0.7)",															
														"type"        => "rt_color",
														"rt_skin"     => true
													),

													array(
														"id"          => "naturalife_breadcrumb_link_color",	
														"label"       => esc_html_x("Breadcrumb Link Color",'Admin Panel','naturalife'),
														"description" => "",
														"transport"   => "postMessage",
														"default"     => "#ffffff",															
														"type"        => "rt_color",
														"rt_skin"     => true
													),

													array(
														"id"          => "naturalife_breadcrumb_bg_color",	
														"label"       => esc_html_x("Breadcrumb Background Color",'Admin Panel','naturalife'),
														"description" => "",
														"transport"   => "postMessage",
														"default"     => "",															
														"type"        => "rt_color",
														"rt_skin"     => true
													),

											),
							),						

			)
	);


if( ! function_exists("rtframework_create_color_set_options") ){
	/**
	 * Add additional controls to the footer colors
	 * @return array
	 */
	function rtframework_create_color_set_options( $options ){

		$color_list = array();

		//Color Schemas
		$color_list[".naturalife-panel-holder"] = array(
			"id" => "side_panel",
			"label" => esc_html_x("Side Panel",'Admin Panel','naturalife'),
			"description" => '<a class="highlight-section rt-panel-icon-flash" data-section-selector=".naturalife-side-panel-holder" href="#" title="'.esc_html_x('Blink the section (if used) in the current page.','Admin Panel','naturalife').'"></a>'. esc_html_x('A color set that can be applied to any content rows or column.','Admin Panel','naturalife'),
			"colors" => array(
				"primary_color"         => array("color"=> "#84BE38", "label" => esc_html_x("Primary Color",'Admin Panel','naturalife')),
				//"bg_color"              => array("color"=> "#ffffff", "label" => esc_html_x("Background Color",'Admin Panel','naturalife')),				
				"font_color"            => array("color"=> "#808891", "label" => esc_html_x("Text Color",'Admin Panel','naturalife')),
				"secondary_font_color"  => array("color"=> "#b9b9b9", "label" => esc_html_x("Secondary Text Color",'Admin Panel','naturalife')),
				"light_text_color"      => array("color"=> "#ffffff", "label" => esc_html_x("Opposite Text Color",'Admin Panel','naturalife')),
				"link_color"            => array("color"=> "#84BE38", "label" => esc_html_x("Link Color",'Admin Panel','naturalife')),
				"heading_color"         => array("color"=> "#585e61", "label" => esc_html_x("Heading Color",'Admin Panel','naturalife')),
				"border_color"          => array("color"=> "#E1E8EE", "label" => esc_html_x("Border Color",'Admin Panel','naturalife')),
				"form_bg_color"         => array("color"=> "#f7f8f9", "label" => esc_html_x("Form Input Background Color",'Admin Panel','naturalife')),
				"form_button_bg_color"  => array("color"=> "#84BE38", "label" => esc_html_x("Form Button Color",'Admin Panel','naturalife')),
				"form_button_hover_color"  => array("color"=> "#383D41", "label" => esc_html_x("Form Button Color",'Admin Panel','naturalife') . ":" . esc_html_x("Hover",'Admin Panel','naturalife')),
				"social_media_bg_color" => array("color"=> "#ffffff", "label" => esc_html_x("Social Media Icons Background Color",'Admin Panel','naturalife')), 
			));
		
		$color_list[".default-style"] = array( 
			"id" => "default",
			"label" => esc_html_x("Color Set 1",'Admin Panel','naturalife'),
			"description" => '<a class="highlight-section rt-panel-icon-flash" data-section-selector=".default-style" href="#" title="'.esc_html_x('Blink the section (if used) in the current page.','Admin Panel','naturalife').'"></a>'. esc_html_x('A color set that can be aplied to any content rows or columns.','Admin Panel','naturalife'),
			"colors" => array(

				"primary_color"         => array("color"=> "#84BE38", "label" => esc_html_x("Primary Color",'Admin Panel','naturalife')),
				"bg_color"              => array("color"=> "#ffffff", "label" => esc_html_x("Row Background Color",'Admin Panel','naturalife')),				
				"font_color"            => array("color"=> "#808891", "label" => esc_html_x("Text Color",'Admin Panel','naturalife')),
				"secondary_font_color"  => array("color"=> "#b9b9b9", "label" => esc_html_x("Secondary Text Color",'Admin Panel','naturalife')),
				"light_text_color"      => array("color"=> "#ffffff", "label" => esc_html_x("Opposite Text Color",'Admin Panel','naturalife')),
				"link_color"            => array("color"=> "#84BE38", "label" => esc_html_x("Link Color",'Admin Panel','naturalife')),
				"heading_color"         => array("color"=> "#585e61", "label" => esc_html_x("Heading Color",'Admin Panel','naturalife')),
				"border_color"          => array("color"=> "#E1E8EE", "label" => esc_html_x("Border Color",'Admin Panel','naturalife')),
				"form_bg_color"         => array("color"=> "#f7f8f9", "label" => esc_html_x("Form Input Background Color",'Admin Panel','naturalife')),
				"form_button_bg_color"  => array("color"=> "#84BE38", "label" => esc_html_x("Form Button Background Color",'Admin Panel','naturalife')),
				"form_button_hover_color"  => array("color"=> "#383D41", "label" => esc_html_x("Form Button Background Color",'Admin Panel','naturalife') . ":" . esc_html_x("Hover",'Admin Panel','naturalife')),
				"social_media_bg_color" => array("color"=> "", "label" => esc_html_x("Social Media Icons Background Color",'Admin Panel','naturalife')),
				"item_bg_color"         => array("color"=> "#ffffff", "label" => esc_html_x("Frames/Boxes Background Color",'Admin Panel','naturalife')),
			));

		$color_list[".alt-style-1"] = array( 
			"id" => "alt_style_1",
			"label" => esc_html_x("Color Set 2",'Admin Panel','naturalife'),
			"description" => '<a class="highlight-section rt-panel-icon-flash" data-section-selector=".alt-style-1" href="#" title="'.esc_html_x('Blink the section (if used) in the current page.','Admin Panel','naturalife').'"></a>'. esc_html_x('A color set that can be aplied to any content rows or columns.','Admin Panel','naturalife'),
			"colors" => array(

				"primary_color"         => array("color"=> "#4f7a17", "label" => esc_html_x("Primary Color",'Admin Panel','naturalife')),
				"bg_color"              => array("color"=> "#84BE38", "label" => esc_html_x("Row Background Color",'Admin Panel','naturalife')),				
				"font_color"            => array("color"=> "#ffffff", "label" => esc_html_x("Text Color",'Admin Panel','naturalife')),
				"secondary_font_color"  => array("color"=> "rgba(255, 255, 255, 0.45)", "label" => esc_html_x("Secondary Text Color",'Admin Panel','naturalife')),
				"light_text_color"      => array("color"=> "#ffffff", "label" => esc_html_x("Opposite Text Color",'Admin Panel','naturalife')),
				"link_color"            => array("color"=> "#ffffff", "label" => esc_html_x("Link Color",'Admin Panel','naturalife')),
				"heading_color"         => array("color"=> "#ffffff", "label" => esc_html_x("Heading Color",'Admin Panel','naturalife')),
				"border_color"          => array("color"=> "rgba(255, 255, 255, 0.38)", "label" => esc_html_x("Border Color",'Admin Panel','naturalife')),
				"form_bg_color"         => array("color"=> "rgba(255, 255, 255, 0.25)", "label" => esc_html_x("Form Input Background Color",'Admin Panel','naturalife')),
				"form_button_bg_color"  => array("color"=> "#528510", "label" => esc_html_x("Form Button Color",'Admin Panel','naturalife')),
				"form_button_hover_color"  => array("color"=> "#2c450b", "label" => esc_html_x("Form Button Color",'Admin Panel','naturalife') . ":" . esc_html_x("Hover",'Admin Panel','naturalife')),
				"social_media_bg_color" => array("color"=> "", "label" => esc_html_x("Social Media Icons Background Color",'Admin Panel','naturalife')),
				"item_bg_color"          => array("color"=> "#528510", "label" => esc_html_x("Frames/Boxes Background Color",'Admin Panel','naturalife')),
			));

		$color_list[".light-style"] = array( 
			"id" => "light_style",
			"label" => esc_html_x("Color Set 3",'Admin Panel','naturalife'),
			"description" => '<a class="highlight-section rt-panel-icon-flash" data-section-selector=".light-style" href="#" title="'.esc_html_x('Blink the section (if used) in the current page.','Admin Panel','naturalife').'"></a>'. esc_html_x('A color set that can be aplied to any content rows or columns.','Admin Panel','naturalife'),
			"colors" => array(

				"primary_color"         => array("color"=> "#84BE38", "label" => esc_html_x("Primary Color",'Admin Panel','naturalife')),
				"bg_color"              => array("color"=> "#383D41", "label" => esc_html_x("Row Background Color",'Admin Panel','naturalife')),				
				"font_color"            => array("color"=> "#e1e1e1", "label" => esc_html_x("Text Color",'Admin Panel','naturalife')),
				"secondary_font_color"  => array("color"=> "#fff", "label" => esc_html_x("Secondary Text Color",'Admin Panel','naturalife')),
				"light_text_color"      => array("color"=> "#fff", "label" => esc_html_x("Opposite Text Color",'Admin Panel','naturalife')),
				"link_color"            => array("color"=> "#84BE38", "label" => esc_html_x("Link Color",'Admin Panel','naturalife')),
				"heading_color"         => array("color"=> "#ffffff", "label" => esc_html_x("Heading Color",'Admin Panel','naturalife')),
				"border_color"          => array("color"=> "rgba(255, 255, 255, 0.25)", "label" => esc_html_x("Border Color",'Admin Panel','naturalife')),
				"form_bg_color"         => array("color"=> "#f7f8f9", "label" => esc_html_x("Form Input Background Color",'Admin Panel','naturalife')),
				"form_button_bg_color"  => array("color"=> "#84BE38", "label" => esc_html_x("Form Button Color",'Admin Panel','naturalife')),
				"form_button_hover_color"  => array("color"=> "#383D41", "label" => esc_html_x("Form Button Color",'Admin Panel','naturalife') . ":" . esc_html_x("Hover",'Admin Panel','naturalife')),
				"social_media_bg_color" => array("color"=> "", "label" => esc_html_x("Social Media Icons Background Color",'Admin Panel','naturalife')),
				"item_bg_color"          => array("color"=> "rgba(255, 255, 255, 0)", "label" => esc_html_x("Frames/Boxes Background Color",'Admin Panel','naturalife')),
			));

		$color_list[".footer-contents"] = array( 
			"id" => "footer",
			"label" => esc_html_x("Footer",'Admin Panel','naturalife'),
			"description" => esc_html_x('Use following settings to customize the footer section of your website.','Admin Panel','naturalife'),
			"colors" => array(

				"primary_color"         => array("color"=> "#84BE38", "label" => esc_html_x("Primary Color",'Admin Panel','naturalife')),
				"bg_color"              => array("color"=> "#f7f8f9", "label" => esc_html_x("Row Background Color",'Admin Panel','naturalife')),				
				"font_color"            => array("color"=> "#808891", "label" => esc_html_x("Text Color",'Admin Panel','naturalife')),
				"secondary_font_color"  => array("color"=> "#b9b9b9", "label" => esc_html_x("Secondary Text Color",'Admin Panel','naturalife')),
				"light_text_color"      => array("color"=> "#ffffff", "label" => esc_html_x("Light Text Color",'Admin Panel','naturalife')),
				"link_color"            => array("color"=> "#84BE38", "label" => esc_html_x("Link Color",'Admin Panel','naturalife')),
				"heading_color"         => array("color"=> "#666d73", "label" => esc_html_x("Heading Color",'Admin Panel','naturalife')),
				"border_color"          => array("color"=> "#E1E8EE", "label" => esc_html_x("Border Color",'Admin Panel','naturalife')),
				"form_bg_color"         => array("color"=> "#ececec", "label" => esc_html_x("Form Input Background Color",'Admin Panel','naturalife')),
				"form_button_bg_color"  => array("color"=> "#84BE38", "label" => esc_html_x("Form Button Color",'Admin Panel','naturalife')),
				"form_button_hover_color"  => array("color"=> "#383D41", "label" => esc_html_x("Form Button Color",'Admin Panel','naturalife') . ":" . esc_html_x("Hover",'Admin Panel','naturalife')),
				"social_media_bg_color" => array("color"=> "", "label" => esc_html_x("Social Media Icons Background Color",'Admin Panel','naturalife')),
				"item_bg_color"          => array("color"=> "#ffffff", "label" => esc_html_x("Frames/Boxes Background Color",'Admin Panel','naturalife')),
			));


		//Create Color Sets
		foreach ($color_list as $seletor => $schema ) {
				
			$controls  =array();

			foreach ($schema["colors"] as $color_id => $color_values  ) {

				$transport = $color_id == "bg_color" ? "refresh" : "postMessage";
				$transport = $color_id == "primary_color" ? "refresh" : "postMessage";

				array_push($controls, array(
						'id'        => 'naturalife_'.$schema["id"]."_".$color_id,
						'label'     => $color_values["label"],    
						"transport" => $transport,
						"default"   => $color_values["color"],															
						"type"      => "rt_color",
						"rt_skin"   => true
					)
				);

			}

			array_push($options["rt_color_schemas"]["sections"], array(
					'id'          => $schema["id"],
					'title'       => $schema["label"], 
					'description' => $schema["description"], 
					'controls'    => apply_filters("rtframework_color_controls_".$schema["id"], $controls )
				)
			);

		}

		return $options;
	}
}
add_filter( 'rtframework_customizer_options', 'rtframework_create_color_set_options', 10 );

if( ! function_exists("rtframework_add_new_footer_options") ){
	/**
	 * Add additional controls to the footer colors
	 * @return array
	 */
	function rtframework_add_new_footer_options( $controls ){

		array_unshift($controls, 

				array(
					"id"          => "naturalife_display_footer", 	
					"label"       => esc_html_x("Footer Visibility",'Admin Panel','naturalife'),
					"description" => esc_html_x("Control the visibility of the footer.",'Admin Panel','naturalife'), 
					"transport"   => "refresh",															
					"default"     => true,
					"type"        => "checkbox",
					"rt_skin"     => true
				),

				array(
					"id"          => "naturalife_underlapped_footer", 	
					"label"       => esc_html_x("Underlapped Footer",'Admin Panel','naturalife'),
					"description" => esc_html_x("Enable/Disable the underlapped footer effect. Note: This option doens't work with the boxed body style.",'Admin Panel','naturalife'), 
					"transport"   => "refresh",															
					"default"     => true,
					"type"        => "checkbox",
					"rt_skin"     => true
				),

				array(
					"id"          => "naturalife_display_footer_widgets", 	
					"label"       => esc_html_x("Footer Widgets Visibility",'Admin Panel','naturalife'),
					"description" => esc_html_x("Control the visibility of the widgets of the footer.",'Admin Panel','naturalife'), 
					"transport"   => "refresh",															
					"default"     => true,
					"type"        => "checkbox", 
					"rt_skin"     => true
				),

				array(
					"id"          => "naturalife_display_social_media", 	
					"label"       => esc_html_x("Footer Social Media Icons Visibility",'Admin Panel','naturalife'),
					"description" => esc_html_x("Control the visibility of the social media icons in the bottom right of the footer.",'Admin Panel','naturalife'), 
					"transport"   => "refresh",															
					"default"     => true,
					"type"        => "checkbox", 
					"rt_skin"     => true
				),


				array(
					"id"          => "naturalife_footer_layout_seperator",	
					"label" 	  => esc_html_x("Footer Layout",'Admin Panel','naturalife'),
					"type"        => "rt_subsection_heading"
				),

				array(
					"id"          => "naturalife_footer_width",	
					"label"       => esc_html_x("Global Footer Width",'Admin Panel', 'naturalife'),
					"description" => "",
					"transport"   => "refresh",															
					"choices"     => array(		
												"default"  => esc_html_x("Content Width",'Admin Panel', 'naturalife'),
												"fullwidth" => esc_html_x("Full Width",'Admin Panel', 'naturalife'),  
										),  
					"type" => "select",
					"default" => "default",
					"rt_skin"   => true
				),

				array(
					"id"          => "naturalife_footer_column_count",															
					"label"       => esc_html_x("Footer Column Count",'Admin Panel','naturalife'),
					"description" => esc_html_x("Select and set the column layout of the footer widget area. Footer widgets can be presented into 1 column up to 4 columns.",'Admin Panel','naturalife'),
					"choices"     =>  array(
												"1" => "1",
												"2" => "2",
												"3" => "3",
												"4" => "4",
												"5" => "5",
												"6" => "6",
							  				),			
					"default"   => "4",
					"transport" => "refresh", 
					"type"      => "rt_select"
				),	

				array(
					"id"          => "naturalife_footer_col_seperator_1",	
					"label" 	  => sprintf(esc_html_x("Footer Column %s",'Admin Panel','naturalife'),"1"),
					"type"        => "rt_seperator",
					"input_attrs" => array("data-depends-id" => "naturalife_footer_column_count", "data-depends-values" => "1,2,3,4,5,6"),
				),	

				array(
					"id"          => "naturalife_footer_col_1",															
					"label"       => esc_html_x("Desktop Layout",'Admin Panel','naturalife') ." (&#8805; 1200px)" ,
					"choices"     =>  array(
												"1/12" => "1/12",
												"2/12" => "2/12",
												"3/12" => "3/12",
												"4/12" => "4/12",
												"5/12" => "5/12",
												"6/12" => "6/12",
												"7/12" => "7/12",
												"8/12" => "8/12",
												"9/12" => "9/12",
												"10/12" => "10/12",		
												"11/12" => "11/12",		
												"12/12" => "12/12",																																																
							  				),			
					"default"   => "6/12",
					"transport" => "refresh", 
					"type"      => "rt_select",
					"input_attrs" => array("data-depends-id" => "naturalife_footer_column_count", "data-depends-values" => "1,2,3,4,5,6"),
				),	

				array(
					"id"          => "naturalife_footer_col_1_m",															
					"label"       => esc_html_x("Tablet Layout",'Admin Panel','naturalife')  ." (1200px <> 768px)" ,
					"choices"     =>  array(
												"1/12" => "1/12",
												"2/12" => "2/12",
												"3/12" => "3/12",
												"4/12" => "4/12",
												"5/12" => "5/12",
												"6/12" => "6/12",
												"7/12" => "7/12",
												"8/12" => "8/12",
												"9/12" => "9/12",
												"10/12" => "10/12",		
												"11/12" => "11/12",		
												"12/12" => "12/12",																																																
							  				),			
					"default"   => "12/12",
					"transport" => "refresh", 
					"type"      => "rt_select",
					"input_attrs" => array("data-depends-id" => "naturalife_footer_column_count", "data-depends-values" => "1,2,3,4,5,6"),
				),	

				array(
					"id"          => "naturalife_footer_featured",		
					"label"       => esc_html_x("Featured First Column?",'Admin Panel','naturalife'),
					"description" => "",
					"transport"   => "refresh",															
					"default"     => true,
					"type"        => "checkbox",
					"rt_skin"     => true
				),

				array(
					"id"          => "naturalife_footer_col_seperator_2",	
					"label" 	  => sprintf(esc_html_x("Footer Column %s",'Admin Panel','naturalife'),"2"),
					"type"        => "rt_seperator",
					"input_attrs" => array("data-depends-id" => "naturalife_footer_column_count", "data-depends-values" => "2,3,4,5,6"),
				),	

				array(
					"id"          => "naturalife_footer_col_2",															
					"label"       => esc_html_x("Desktop Layout",'Admin Panel','naturalife') ." (&#8805; 1200px)" ,
					"choices"     =>  array(
												"1/12" => "1/12",
												"2/12" => "2/12",
												"3/12" => "3/12",
												"4/12" => "4/12",
												"5/12" => "5/12",
												"6/12" => "6/12",
												"7/12" => "7/12",
												"8/12" => "8/12",
												"9/12" => "9/12",
												"10/12" => "10/12",		
												"11/12" => "11/12",		
												"12/12" => "12/12",																																																
							  				),			
					"default"   => "2/12",
					"transport" => "refresh", 
					"type"      => "rt_select",
					"input_attrs" => array("data-depends-id" => "naturalife_footer_column_count", "data-depends-values" => "2,3,4,5,6"),
				),	

				array(
					"id"          => "naturalife_footer_col_2_m",															
					"label"       => esc_html_x("Tablet Layout",'Admin Panel','naturalife')  ." (1200px <> 768px)" ,
					"choices"     =>  array(
												"1/12" => "1/12",
												"2/12" => "2/12",
												"3/12" => "3/12",
												"4/12" => "4/12",
												"5/12" => "5/12",
												"6/12" => "6/12",
												"7/12" => "7/12",
												"8/12" => "8/12",
												"9/12" => "9/12",
												"10/12" => "10/12",		
												"11/12" => "11/12",		
												"12/12" => "12/12",																																																
							  				),			
					"default"   => "4/12",
					"transport" => "refresh", 
					"type"      => "rt_select",
					"input_attrs" => array("data-depends-id" => "naturalife_footer_column_count", "data-depends-values" => "2,3,4,5,6"),
				),	

				array(
					"id"          => "naturalife_footer_col_seperator_3",	
					"label" 	  => sprintf(esc_html_x("Footer Column %s",'Admin Panel','naturalife'),"3"),													
					"type"        => "rt_seperator",
					"input_attrs" => array("data-depends-id" => "naturalife_footer_column_count", "data-depends-values" => "3,4,5,6"),
				),	

				array(
					"id"          => "naturalife_footer_col_3",															
					"label"       => esc_html_x("Desktop Layout",'Admin Panel','naturalife') ." (&#8805; 1200px)" ,
					"choices"     =>  array(
												"1/12" => "1/12",
												"2/12" => "2/12",
												"3/12" => "3/12",
												"4/12" => "4/12",
												"5/12" => "5/12",
												"6/12" => "6/12",
												"7/12" => "7/12",
												"8/12" => "8/12",
												"9/12" => "9/12",
												"10/12" => "10/12",		
												"11/12" => "11/12",		
												"12/12" => "12/12",																																																
							  				),			
					"default"   => "2/12",
					"transport" => "refresh", 
					"type"      => "rt_select",
					"input_attrs" => array("data-depends-id" => "naturalife_footer_column_count", "data-depends-values" => "3,4,5,6"),
				),	

				array(
					"id"          => "naturalife_footer_col_3_m",															
					"label"       => esc_html_x("Tablet Layout",'Admin Panel','naturalife')  ." (1200px <> 768px)" ,
					"choices"     =>  array(
												"1/12" => "1/12",
												"2/12" => "2/12",
												"3/12" => "3/12",
												"4/12" => "4/12",
												"5/12" => "5/12",
												"6/12" => "6/12",
												"7/12" => "7/12",
												"8/12" => "8/12",
												"9/12" => "9/12",
												"10/12" => "10/12",		
												"11/12" => "11/12",		
												"12/12" => "12/12",																																																
							  				),			
					"default"   => "4/12",
					"transport" => "refresh", 
					"type"      => "rt_select",
					"input_attrs" => array("data-depends-id" => "naturalife_footer_column_count", "data-depends-values" => "3,4,5,6"),
				),	

				array(
					"id"          => "naturalife_footer_col_seperator_4",	
					"label" 	  => sprintf(esc_html_x("Footer Column %s",'Admin Panel','naturalife'),"4"),															
					"type"        => "rt_seperator",
					"input_attrs" => array("data-depends-id" => "naturalife_footer_column_count", "data-depends-values" => "4,5,6"),
				),	

				array(
					"id"          => "naturalife_footer_col_4",															
					"label"       => esc_html_x("Desktop Layout",'Admin Panel','naturalife') ." (&#8805; 1200px)" ,
					"choices"     =>  array(
												"1/12" => "1/12",
												"2/12" => "2/12",
												"3/12" => "3/12",
												"4/12" => "4/12",
												"5/12" => "5/12",
												"6/12" => "6/12",
												"7/12" => "7/12",
												"8/12" => "8/12",
												"9/12" => "9/12",
												"10/12" => "10/12",		
												"11/12" => "11/12",		
												"12/12" => "12/12",																																																
							  				),			
					"default"   => "2/12",
					"transport" => "refresh", 
					"type"      => "rt_select",
					"input_attrs" => array("data-depends-id" => "naturalife_footer_column_count", "data-depends-values" => "4,5,6"),
				),	

				array(
					"id"          => "naturalife_footer_col_4_m",															
					"label"       => esc_html_x("Tablet Layout",'Admin Panel','naturalife')  ." (1200px <> 768px)" ,
					"choices"     =>  array(
												"1/12" => "1/12",
												"2/12" => "2/12",
												"3/12" => "3/12",
												"4/12" => "4/12",
												"5/12" => "5/12",
												"6/12" => "6/12",
												"7/12" => "7/12",
												"8/12" => "8/12",
												"9/12" => "9/12",
												"10/12" => "10/12",		
												"11/12" => "11/12",		
												"12/12" => "12/12",																																																
							  				),			
					"default"   => "4/12",
					"transport" => "refresh", 
					"type"      => "rt_select",
					"input_attrs" => array("data-depends-id" => "naturalife_footer_column_count", "data-depends-values" => "4,5,6"),
				),	

				array(
					"id"          => "naturalife_footer_col_seperator_5",	
					"label" 	  => sprintf(esc_html_x("Footer Column %s",'Admin Panel','naturalife'),"5"),															
					"type"        => "rt_seperator",
					"input_attrs" => array("data-depends-id" => "naturalife_footer_column_count", "data-depends-values" => "5,6"),
				),	

				array(
					"id"          => "naturalife_footer_col_5",															
					"label"       => esc_html_x("Desktop Layout",'Admin Panel','naturalife') ." (&#8805; 1200px)" ,
					"choices"     =>  array(
												"1/12" => "1/12",
												"2/12" => "2/12",
												"3/12" => "3/12",
												"4/12" => "4/12",
												"5/12" => "5/12",
												"6/12" => "6/12",
												"7/12" => "7/12",
												"8/12" => "8/12",
												"9/12" => "9/12",
												"10/12" => "10/12",		
												"11/12" => "11/12",		
												"12/12" => "12/12",																																																
							  				),			
					"default"   => "6/12",
					"transport" => "refresh", 
					"type"      => "rt_select",
					"input_attrs" => array("data-depends-id" => "naturalife_footer_column_count", "data-depends-values" => "5,6"),
				),	

				array(
					"id"          => "naturalife_footer_col_5_m",															
					"label"       => esc_html_x("Tablet Layout",'Admin Panel','naturalife')  ." (1200px <> 768px)" ,
					"choices"     =>  array(
												"1/12" => "1/12",
												"2/12" => "2/12",
												"3/12" => "3/12",
												"4/12" => "4/12",
												"5/12" => "5/12",
												"6/12" => "6/12",
												"7/12" => "7/12",
												"8/12" => "8/12",
												"9/12" => "9/12",
												"10/12" => "10/12",		
												"11/12" => "11/12",		
												"12/12" => "12/12",																																																
							  				),			
					"default"   => "6/12",
					"transport" => "refresh", 
					"type"      => "rt_select",
					"input_attrs" => array("data-depends-id" => "naturalife_footer_column_count", "data-depends-values" => "5,6"),
				),	

				array(
					"id"          => "naturalife_footer_col_seperator_6",	
					"label" 	  => sprintf(esc_html_x("Footer Column %s",'Admin Panel','naturalife'),"6"),
					"type"        => "rt_seperator",
					"input_attrs" => array("data-depends-id" => "naturalife_footer_column_count", "data-depends-values" => "6"),
				),	

				array(
					"id"          => "naturalife_footer_col_6",															
					"label"       => esc_html_x("Desktop Layout",'Admin Panel','naturalife') ." (&#8805; 1200px)" ,
					"choices"     =>  array(
												"1/12" => "1/12",
												"2/12" => "2/12",
												"3/12" => "3/12",
												"4/12" => "4/12",
												"5/12" => "5/12",
												"6/12" => "6/12",
												"7/12" => "7/12",
												"8/12" => "8/12",
												"9/12" => "9/12",
												"10/12" => "10/12",		
												"11/12" => "11/12",		
												"12/12" => "12/12",																																																
							  				),			
					"default"   => "6/12",
					"transport" => "refresh", 
					"type"      => "rt_select",
					"input_attrs" => array("data-depends-id" => "naturalife_footer_column_count", "data-depends-values" => "6"),
				),	

				array(
					"id"          => "naturalife_footer_col_6_m",															
					"label"       => esc_html_x("Tablet Layout",'Admin Panel','naturalife')  ." (1200px <> 768px)" ,
					"choices"     =>  array(
												"1/12" => "1/12",
												"2/12" => "2/12",
												"3/12" => "3/12",
												"4/12" => "4/12",
												"5/12" => "5/12",
												"6/12" => "6/12",
												"7/12" => "7/12",
												"8/12" => "8/12",
												"9/12" => "9/12",
												"10/12" => "10/12",		
												"11/12" => "11/12",		
												"12/12" => "12/12",																																																
							  				),			
					"default"   => "6/12",
					"transport" => "refresh", 
					"type"      => "rt_select",
					"input_attrs" => array("data-depends-id" => "naturalife_footer_column_count", "data-depends-values" => "6"),
				),	

				array(
					"id"          => "naturalife_footer_row_seperator",	
					"label" 	  => esc_html_x("Color Set",'Admin Panel','naturalife'),
					"description" => esc_html_x('A color set that used only for footer elements.','Admin Panel','naturalife'),															
					"type"        => "rt_subsection_heading"
				)			 
		);

		return $controls;
	}
}
add_filter( 'rtframework_color_controls_footer', 'rtframework_add_new_footer_options', 20 );


if( ! function_exists("rtframework_add_new_side_panel_options") ){
	/**
	 * Add additional controls to the side panel
	 * @return array
	 */
	function rtframework_add_new_side_panel_options( $controls ){

		array_unshift($controls, 

				array(
					"id"          => "naturalife_header_sidepanel",		
					"label"       => esc_html_x("Desktop Side Panel",'Admin Panel','naturalife'),
					"description" => esc_html_x("Control the visibility of the side panel in desktop screens. (screen size > 1024px)",'Admin Panel','naturalife'),
					"transport"   => "refresh",															
					"default"     => "",
					"type"        => "checkbox",
					"rt_skin"     => true
				),

				array(
					"id"          => "naturalife_header_sidepanel_mobile",		
					"label"       => esc_html_x("Mobile Side Panel",'Admin Panel','naturalife'),
					"description" => esc_html_x("Control the visibility of the side panel in mobile screens. (screen size <= 1024px)",'Admin Panel','naturalife'),
					"transport"   => "refresh",															
					"default"     => true,
					"type"        => "checkbox",
					"rt_skin"     => true
				),

				array(
					"id"          => "naturalife_mobile_menu",		
					"label"       => esc_html_x("Mobile Menu",'Admin Panel','naturalife'),
					"description" => esc_html_x("Control the visibility of the the mobile menu in the mobile side panel.",'Admin Panel','naturalife'),
					"transport"   => "refresh",															
					"default"     => true,
					"type"        => "checkbox",
					"rt_skin"     => true
				),

				array(
					"id"          => "naturalife_sp_seperator2",	
					"label"       => "",
					"description" => "",															
					"type"        => "rt_seperator"
				),

				array(
					"id"          => "naturalife_nav_seperator_side_panel_1",	
					"label"       => esc_html_x('Mobile Menu Colors','Admin Panel','naturalife'),															
					"description" => esc_html_x('Customize the side panel menu colors.','Admin Panel','naturalife'),															
					"type"        => "rt_subsection_heading"
				),

				array(
					"id"          => "naturalife_mobile_nav_item_font_color",	
					"label"       => esc_html_x("Menu Item Font Color",'Admin Panel','naturalife'),
					"description" => "",
					"transport"   => "refresh",
					"default"     => "#383D41",															
					"type"        => "rt_color",
					"rt_skin"   => true
				),

				array(
					"id"          => "naturalife_mobile_nav_item_desc_font_color",	
					"label"       => esc_html_x("Menu Item Description Font Color",'Admin Panel','naturalife'),
					"description" => "",
					"transport"   => "refresh",
					"default"     => "#6b6f73",															
					"type"        => "rt_color",
					"rt_skin"   => true
				),		

				array(
					"id"          => "naturalife_mobile_nav_item_font_color_active",	
					"label"       => esc_html_x("Active Menu Item Font Color",'Admin Panel','naturalife'),
					"description" => "",
					"transport"   => "refresh",
					"default"     => "#84BE38",															
					"type"        => "rt_color",
					"rt_skin"   => true
				),

				array(
					"id"          => "naturalife_mobile_nav_item_border_color",	
					"label"       => esc_html_x("Mobile Menu Border Color",'Admin Panel','naturalife'),
					"description" => "",
					"transport"   => "refresh",
					"default"     => "rgba(255, 255, 255, 0)",															
					"type"        => "rt_color",
					"rt_skin"   => true
				), 

				array(
					"id"          => "naturalife_nav_seperator_side_panel_2",	
					"label"       => esc_html_x('Background','Admin Panel','naturalife'),															
					"type"        => "rt_subsection_heading"
				),

				array(
					"id"          => "naturalife_side_panel_bg_color",	
					"label"       => esc_html_x("Background Color",'Admin Panel','naturalife'),
					"description" => "",
					"transport"   => "refresh",
					"default"     => "#ffffff",
					"type"        => "rt_color",
					"rt_skin"     => true
				),		

				array(
					"id"          => "naturalife_side_panel_bg_overlay_color",	
					"label"       => esc_html_x("Background Overlay Color",'Admin Panel','naturalife'),
					"description" => "",
					"transport"   => "refresh",
					"default"     => "",
					"type"        => "rt_color",
					"rt_skin"     => true
				),	

				array(
					"id"          => "naturalife_side_panel_bg_image", 	
					"label"       => esc_html_x("Background Image",'Admin Panel','naturalife'),
					"description" => "",
					"transport"   => "refresh",															
					"type"        => "media",
					"rt_skin"     => true
				), 
				
				array(
					"id"          => "naturalife_side_panel_bg_position",	
					"label"       => esc_html_x("Position",'Admin Panel','naturalife'),
					"description" => "",
					"transport"   => "refresh",															
					"choices"     => array(		
										"right top"     => esc_html_x("Right Top",'Admin Panel','naturalife'),
										"right center"  => esc_html_x("Right Center",'Admin Panel','naturalife'),
										"right bottom"  => esc_html_x("Right Bottom",'Admin Panel','naturalife'),
										"left top"      => esc_html_x("Left Top",'Admin Panel','naturalife'),
										"left center"   => esc_html_x("Left Center",'Admin Panel','naturalife'),
										"left bottom"   => esc_html_x("Left Bottom",'Admin Panel','naturalife'),
										"center top"    => esc_html_x("Center Top",'Admin Panel','naturalife'),
										"center center" => esc_html_x("Center Center",'Admin Panel','naturalife'),
										"center bottom" => esc_html_x("Center Bottom",'Admin Panel','naturalife'),
									),  
					"type"    => "select",
					"rt_skin" => true
				), 

				array(
					"id"          => "naturalife_side_panel_bg_repeat",	
					"label"       => esc_html_x("Repeat",'Admin Panel','naturalife'),
					"description" => "",
					"transport"   => "refresh",															
					"choices"     => array(		
									"repeat"       => esc_html_x("Tile",'Admin Panel','naturalife'),
									"repeat-x"     => esc_html_x("Tile Horizontally",'Admin Panel','naturalife'),
									"repeat-y"     => esc_html_x("Tile Vertically",'Admin Panel','naturalife'),
									"no-repeat"    => esc_html_x("No Repeat",'Admin Panel','naturalife'),
									),  
					"type"    => "radio",
					"default" => "no-repeat",
					"rt_skin"   => true
				),

				array(
					"id"          => "naturalife_side_panel_bg_size",	
					"label"       => esc_html_x("Background Size",'Admin Panel','naturalife'),
					"description" => "",
					"transport"   => "refresh",															
					"choices"     => array(		
									"auto auto" => esc_html_x("Auto",'Admin Panel','naturalife'),
									"cover" => esc_html_x("Cover",'Admin Panel','naturalife'),
									"contain" => esc_html_x("Contain",'Admin Panel','naturalife'),
									"100% auto" => esc_html_x("100%",'Admin Panel','naturalife'),
									"50% auto" => esc_html_x("50%",'Admin Panel','naturalife'),
									"25% auto" => esc_html_x("25%",'Admin Panel','naturalife'),
									),  
					"default" => "auto auto",
					"type"    => "select",
					"rt_skin"   => true
				),

				array(
					"id"          => "naturalife_nav_seperator_side_panel_3",	
					"label"       => esc_html_x('Colors','Admin Panel','naturalife'),															
					"description" => esc_html_x('A color set that used for the side panel.','Admin Panel','naturalife'),															
					"type"        => "rt_subsection_heading"
				)
		);

		return $controls;
	}
}
add_filter( 'rtframework_color_controls_side_panel', 'rtframework_add_new_side_panel_options', 20 );
