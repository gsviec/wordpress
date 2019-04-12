<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * RT-Theme Blog Options
 */
		$this->options["typography"] = array(

				'title' => esc_html_x("Typography Options", 'Admin Panel','naturalife'), 
				'description' => "", 
				'priority' => 3,
				'sections' => array(

									array(
										'id'       => 'body',
										'title'    => esc_html_x("Body", 'Admin Panel','naturalife'), 
										'controls' => array( 
															array(
																"id"          => 'naturalife_body_font',															
																"label"       => esc_html_x("Font",'Admin Panel','naturalife'),
																"choices"     =>  $this->fonts,
																"input_attrs" => array("class"=>"rt_fonts", "data-variant-id"=> 'naturalife_body_font_variant', "data-subset-id"=> 'naturalife_body_font_subset'),
																"default"   => "google||Roboto",
																"transport" => "refresh", 
																"type"      => "rt_select",
																"rt_skin"   => true
															),

															array(
																"id"          => 'naturalife_body_font_subset',															
																"label"       => esc_html_x("Subsets",'Admin Panel','naturalife'),
																"choices"     => array(),			
																"default"     => array("latin"),
																"input_attrs" => array("multiple"=>"multiple"),
																"transport"   => "refresh", 
																"type"        => "rt_select",
																"rt_skin"   => true
															),

															array(
																"id"          => 'naturalife_body_font_variant',															
																"label"       => esc_html_x("Font Weight",'Admin Panel','naturalife'),
																"choices"     => array(),			
																"default"     => "regular",
																"transport"   => "refresh", 
																"type"        => "rt_select",
																"rt_skin"   => true
															),

															array(
																"label"       => esc_html_x("Body Font Size",'Admin Panel','naturalife'),																
																"id"          => "naturalife_body_font_size",
																"default"     => "16", 
																"type"        => "number",
																"transport"   => "refresh",
																"input_attrs" => array("min"=>10,"max"=>100),
																"rt_skin"   => true
															),

													),
									),		


							array(
										'id'       => 'secondary',
										'title'    => esc_html_x("Secondary Font",'Admin Panel','naturalife'),
										'controls' => array( 

															array(
																"id"          => 'naturalife_secondary_font',															
																"label"       => esc_html_x("Font",'Admin Panel','naturalife'),
																"choices"     => $this->fonts,
																"input_attrs" => array("class"=>"rt_fonts", "data-variant-id"=> 'naturalife_secondary_font_variant', "data-subset-id"=> 'naturalife_secondary_font_subset'),
																"default"   => "google||Caveat",
																"transport" => "refresh", 
																"type"      => "rt_select",
																"rt_skin"   => true
															),

															array(
																"id"          => 'naturalife_secondary_font_subset',															
																"label"       => esc_html_x("Subsets",'Admin Panel','naturalife'),
																"choices"     => array(),			
																"default"     => array("latin"),
																"input_attrs" => array("multiple"=>"multiple"),
																"transport"   => "refresh", 
																"type"        => "rt_select",
																"rt_skin"   => true
															),

															array(
																"id"          => 'naturalife_secondary_font_variant',															
																"label"       => esc_html_x("Font Weight",'Admin Panel','naturalife'),
																"choices"     =>  array(),			
																"default"     => "700",
																"transport"   => "refresh", 
																"type"        => "rt_select",
																"rt_skin"   => true
															),

													),
									),				 


									array(
										'id'       => 'headings',
										'title'    => esc_html_x("Headings", 'Admin Panel','naturalife'), 
										'controls' => array( 
															array(
																"id"          => 'naturalife_heading_font',															
																"label"       => esc_html_x("Font",'Admin Panel','naturalife'),
																"choices"     =>  $this->fonts,
																"input_attrs" => array("class"=>"rt_fonts", "data-variant-id"=> 'naturalife_heading_font_variant', "data-subset-id"=> 'naturalife_heading_font_subset'),
																"default"   => "google||Roboto Slab",
																"transport" => "refresh", 
																"type"      => "rt_select",
																"rt_skin"   => true
															),

															array(
																"id"          => 'naturalife_heading_font_subset',															
																"label"       => esc_html_x("Subsets",'Admin Panel','naturalife'),
																"choices"     => array(),			
																"default"     => array("latin"),
																"input_attrs" => array("multiple"=>"multiple"),
																"transport"   => "refresh", 
																"type"        => "rt_select",
																"rt_skin"   => true
															),

															array(
																"id"          => 'naturalife_heading_font_variant',															
																"label"       => esc_html_x("Font Weight",'Admin Panel','naturalife'),
																"choices"     => array(),			
																"default"     => "700",
																"transport"   => "refresh", 
																"type"        => "rt_select",
																"rt_skin"   => true
															),

															array(
																"id"          => "naturalife_tp_seperator_1",	
																"label" 	  => esc_html_x("Desktop Font Sizes",'Admin Panel','naturalife')." (> 1024px)" ,													
																"type"        => "rt_seperator"
															),	

															array(
																"label"       => esc_html_x("H1 Font Size",'Admin Panel','naturalife'),																
																"id"          => "naturalife_h1_font_size",
																"default"     => "40", 
																"type"        => "number",
																"transport"   => "refresh",
																"input_attrs" => array("min"=>10,"max"=>100),
																"rt_skin"   => true
															),

															array(
																"label"       => esc_html_x("H2 Font Size",'Admin Panel','naturalife'),																
																"id"          => "naturalife_h2_font_size",
																"default"     => "34", 
																"type"        => "number",
																"transport"   => "refresh",
																"input_attrs" => array("min"=>10,"max"=>100),
																"rt_skin"   => true
															),

															array(
																"label"       => esc_html_x("H3 Font Size",'Admin Panel','naturalife'),																
																"id"          => "naturalife_h3_font_size",
																"default"     => "30", 
																"type"        => "number",
																"transport"   => "refresh",
																"input_attrs" => array("min"=>10,"max"=>100),
																"rt_skin"   => true
															),

															array(
																"label"       => esc_html_x("H4 Font Size",'Admin Panel','naturalife'),																
																"id"          => "naturalife_h4_font_size",
																"default"     => "24", 
																"type"        => "number",
																"transport"   => "refresh",
																"input_attrs" => array("min"=>10,"max"=>100),
																"rt_skin"   => true
															),

															array(
																"label"       => esc_html_x("H5 Font Size",'Admin Panel','naturalife'),																
																"id"          => "naturalife_h5_font_size",
																"default"     => "20", 
																"type"        => "number",
																"transport"   => "refresh",
																"input_attrs" => array("min"=>10,"max"=>100),
																"rt_skin"   => true
															),


															array(
																"label"       => esc_html_x("H6 Font Size",'Admin Panel','naturalife'),																
																"id"          => "naturalife_h6_font_size",
																"default"     => "16", 
																"type"        => "number",
																"transport"   => "refresh",
																"input_attrs" => array("min"=>10,"max"=>100),
																"rt_skin"   => true
															),

															array(
																"id"          => "naturalife_tp_seperator_2",	
																"label" 	  => esc_html_x("Mobile Font Sizes",'Admin Panel','naturalife')." (&#8804; 1024px)" ,													
																"type"        => "rt_seperator"
															),


															array(
																"label"       => esc_html_x("H1 Font Size",'Admin Panel','naturalife'),																
																"id"          => "naturalife_h1_m_font_size",
																"default"     => "26", 
																"type"        => "number",
																"transport"   => "refresh",
																"input_attrs" => array("min"=>10,"max"=>100),
																"rt_skin"   => true
															),

															array(
																"label"       => esc_html_x("H2 Font Size",'Admin Panel','naturalife'),																
																"id"          => "naturalife_h2_m_font_size",
																"default"     => "24", 
																"type"        => "number",
																"transport"   => "refresh",
																"input_attrs" => array("min"=>10,"max"=>100),
																"rt_skin"   => true
															),

															array(
																"label"       => esc_html_x("H3 Font Size",'Admin Panel','naturalife'),																
																"id"          => "naturalife_h3_m_font_size",
																"default"     => "22", 
																"type"        => "number",
																"transport"   => "refresh",
																"input_attrs" => array("min"=>10,"max"=>100),
																"rt_skin"   => true
															),


															array(
																"label"       => esc_html_x("H4 Font Size",'Admin Panel','naturalife'),																
																"id"          => "naturalife_h4_m_font_size",
																"default"     => "20", 
																"type"        => "number",
																"transport"   => "refresh",
																"input_attrs" => array("min"=>10,"max"=>100),
																"rt_skin"   => true
															),


															array(
																"label"       => esc_html_x("H5 Font Size",'Admin Panel','naturalife'),																
																"id"          => "naturalife_h5_m_font_size",
																"default"     => "18", 
																"type"        => "number",
																"transport"   => "refresh",
																"input_attrs" => array("min"=>10,"max"=>100),
																"rt_skin"   => true
															),

															array(
																"label"       => esc_html_x("H6 Font Size",'Admin Panel','naturalife'),																
																"id"          => "naturalife_h6_m_font_size",
																"default"     => "16", 
																"type"        => "number",
																"transport"   => "refresh",
																"input_attrs" => array("min"=>10,"max"=>100),
																"rt_skin"   => true
															),

													),
									),				 

									array(
										'id'       => 'menu',
										'title'    => esc_html_x("Main Menu", 'Admin Panel','naturalife'), 
										'controls' => array( 


															array(
																"id"          => "naturalife_main_menu_seperator_1",	
																"label"       => esc_html_x('Top Level Items','Admin Panel','naturalife'),															
																"type"        => "rt_subsection_heading"
															),			

															array(
																"id"          => 'naturalife_menu_font',															
																"label"       => esc_html_x("Font",'Admin Panel','naturalife'),
																"choices"     =>  $this->fonts,
																"input_attrs" => array("class"=>"rt_fonts", "data-variant-id"=> 'naturalife_menu_font_variant', "data-subset-id"=> 'naturalife_menu_font_subset'),
																"default"   => "google||Roboto",
																"transport" => "refresh", 
																"type"      => "rt_select",
																"rt_skin"   => true
															),

															array(
																"id"          => 'naturalife_menu_font_subset',															
																"label"       => esc_html_x("Subsets",'Admin Panel','naturalife'),
																"choices"     => array(),			
																"default"     => array("latin"),
																"input_attrs" => array("multiple"=>"multiple"),
																"transport"   => "refresh", 
																"type"        => "rt_select",
																"rt_skin"   => true
															),

															array(
																"id"          => 'naturalife_menu_font_variant',															
																"label"       => esc_html_x("Font Weight",'Admin Panel','naturalife'),
																"choices"     => array(),			
																"default"     => "700",
																"transport"   => "refresh", 
																"type"        => "rt_select",
																"rt_skin"   => true
															),

															array(
																"label"       => esc_html_x("Top Level Item Font Size",'Admin Panel','naturalife'),																
																"id"          => "naturalife_menu_font_size",
																"default"     => "14", 
																"type"        => "number",
																"transport"   => "refresh",
																"input_attrs" => array("min"=>10,"max"=>100),
																"rt_skin"   => true
															),
 
 															array(
																"id"          => "naturalife_main_menu_seperator_2",	
																"label"       => esc_html_x('Sub Level Items','Admin Panel','naturalife'),															
																"type"        => "rt_subsection_heading"
															),			

															array(
																"id"          => 'naturalife_sub_menu_font',															
																"label"       => esc_html_x("Font",'Admin Panel','naturalife'),
																"choices"     =>  $this->fonts,
																"input_attrs" => array("class"=>"rt_fonts", "data-variant-id"=> 'naturalife_sub_menu_font_variant', "data-subset-id"=> 'naturalife_sub_menu_font_subset'),
																"default"   => "google||Roboto",
																"transport" => "refresh", 
																"type"      => "rt_select",
																"rt_skin"   => true
															),

															array(
																"id"          => 'naturalife_sub_menu_font_subset',															
																"label"       => esc_html_x("Subsets",'Admin Panel','naturalife'),
																"choices"     => array(),			
																"default"     => array("latin"),
																"input_attrs" => array("multiple"=>"multiple"),
																"transport"   => "refresh", 
																"type"        => "rt_select",
																"rt_skin"   => true
															),

															array(
																"id"          => 'naturalife_sub_menu_font_variant',															
																"label"       => esc_html_x("Font Weight",'Admin Panel','naturalife'),
																"choices"     => array(),			
																"default"     => "regular",
																"transport"   => "refresh", 
																"type"        => "rt_select",
																"rt_skin"   => true
															),

															array(
																"label"       => esc_html_x("Sub Level Item Font Size",'Admin Panel','naturalife'),																
																"id"          => "naturalife_menu_sub_font_size",
																"default"     => "14", 
																"type"        => "number",
																"transport"   => "refresh",
																"input_attrs" => array("min"=>10,"max"=>100),
																"rt_skin"   => true
															),

													),
									),	


									array(
										'id'       => 'side_panel',
										'title'    => esc_html_x("Side Panel", 'Admin Panel','naturalife'), 
										'controls' => array( 

															array(
																"id"          => "naturalife_sidepanel_s1",	
																"label"       => esc_html_x('Desktop','Admin Panel','naturalife'),									 														
																"type"        => "rt_subsection_heading"
															),

																array(
																	"label"       => esc_html_x("Text Font Size",'Admin Panel','naturalife'),																
																	"id"          => "naturalife_sidepanel_font_size",
																	"default"     => "16", 
																	"type"        => "number",
																	"transport"   => "refresh",
																	"input_attrs" => array("min"=>10,"max"=>100),
																	"rt_skin"   => true
																),

																array(
																	"label"       => esc_html_x("Widget Heading Font Size",'Admin Panel','naturalife'),																
																	"id"          => "naturalife_sidepanel_widget_heading_font_size",
																	"default"     => "16", 
																	"type"        => "number",
																	"transport"   => "refresh",
																	"input_attrs" => array("min"=>10,"max"=>100),
																	"rt_skin"   => true
																),

																array(
																	"label"       => esc_html_x("Menu Item Font Size",'Admin Panel','naturalife'),																
																	"id"          => "naturalife_sidepanel_menu_font_size",
																	"default"     => "16", 
																	"type"        => "number",
																	"transport"   => "refresh",
																	"input_attrs" => array("min"=>10,"max"=>100),
																	"rt_skin"   => true
																),

																array(
																	"label"       => esc_html_x("Sub-menu Item Font Size",'Admin Panel','naturalife'),																
																	"id"          => "naturalife_sidepanel_menu_sub_font_size",
																	"default"     => "14", 
																	"type"        => "number",
																	"transport"   => "refresh",
																	"input_attrs" => array("min"=>10,"max"=>100),
																	"rt_skin"   => true
																),

															array(
																"id"          => "naturalife_sidepanel_s2",	
																"label"       => esc_html_x('Mobile','Admin Panel','naturalife'),									 														
																"type"        => "rt_subsection_heading"
															),


																array(
																	"label"       => esc_html_x("Text Font Size",'Admin Panel','naturalife'),																
																	"id"          => "naturalife_sidepanel_font_size_mobile",
																	"default"     => "16", 
																	"type"        => "number",
																	"transport"   => "refresh",
																	"input_attrs" => array("min"=>10,"max"=>100),
																	"rt_skin"   => true
																),

																array(
																	"label"       => esc_html_x("Widget Heading Font Size",'Admin Panel','naturalife'),																
																	"id"          => "naturalife_sidepanel_widget_heading_font_size_mobile",
																	"default"     => "16", 
																	"type"        => "number",
																	"transport"   => "refresh",
																	"input_attrs" => array("min"=>10,"max"=>100),
																	"rt_skin"   => true
																),

																array(
																	"label"       => esc_html_x("Menu Item Font Size",'Admin Panel','naturalife'),																
																	"id"          => "naturalife_sidepanel_menu_font_size_mobile",
																	"default"     => "16", 
																	"type"        => "number",
																	"transport"   => "refresh",
																	"input_attrs" => array("min"=>10,"max"=>100),
																	"rt_skin"   => true
																),

																array(
																	"label"       => esc_html_x("Sub-menu Item Font Size",'Admin Panel','naturalife'),																
																	"id"          => "naturalife_sidepanel_menu_sub_font_size_mobile",
																	"default"     => "14", 
																	"type"        => "number",
																	"transport"   => "refresh",
																	"input_attrs" => array("min"=>10,"max"=>100),
																	"rt_skin"   => true
																),

													),
									),	

									array(
										'id'       => 'miscellaneous',
										'title'    => esc_html_x("Miscellaneous", 'Admin Panel','naturalife'), 
										'controls' => array( 



															array(
																"label"       => esc_html_x("Top Bar Font Size",'Admin Panel','naturalife'),																
																"id"          => "naturalife_top_bar_font_size",
																"default"     => "12", 
																"type"        => "number",
																"transport"   => "refresh",
																"input_attrs" => array("min"=>10,"max"=>100),
																"rt_skin"   => true
															),			

															array(
																"id"          => "naturalife_top_bar_font",
																"label"       => esc_html_x("Top Bar Font",'Admin Panel','naturalife'),			
																"description" => "",
																"transport"   => "refresh",
																"choices"     => array(																					
																					"body" => esc_html_x("Use the body font family",'Admin Panel','naturalife'), 
																					"heading" => esc_html_x("Use the heading font family",'Admin Panel','naturalife'),
																					"secondary" => esc_html_x("Use the secondary font family",'Admin Panel','naturalife'),
																					"menu" => esc_html_x("Use the menu font family",'Admin Panel','naturalife'), 
																					"sub_menu" => esc_html_x("Use the sub menu font family",'Admin Panel','naturalife'), 
																				),
																"type"    => "select",
																"default" => "menu",
																"rt_skin" => true
															),


     														array(
																"label"       => esc_html_x("Header Widgets Font Size",'Admin Panel','naturalife'),													
																"id"          => "naturalife_header_widgets_font_size",
																"default"     => "14", 
																"type"        => "number",
																"transport"   => "refresh",
																"input_attrs" => array("min"=>10,"max"=>100),
																"rt_skin"   => true
															),			


															array(
																"id"          => "naturalife_header_widgets_font",
																"label"       => esc_html_x("Header Widgets Font",'Admin Panel','naturalife'),			
																"description" => "",
																"transport"   => "refresh",
																"choices"     => array(																					
																					"body" => esc_html_x("Use the body font family",'Admin Panel','naturalife'), 
																					"heading" => esc_html_x("Use the heading font family",'Admin Panel','naturalife'),
																					"secondary" => esc_html_x("Use the secondary font family",'Admin Panel','naturalife'),
																					"menu" => esc_html_x("Use the menu font family",'Admin Panel','naturalife'), 
																					"sub_menu" => esc_html_x("Use the sub menu font family",'Admin Panel','naturalife'), 
																				),
																"type"    => "select",
																"default" => "menu",
																"rt_skin" => true
															),


															array(
																"label"       => esc_html_x("Page Heading Font Size",'Admin Panel','naturalife'),
																"id"          => "naturalife_page_heading_font_size",
																"default"     => "", 
																"type"        => "number",
																"transport"   => "refresh",
																"input_attrs" => array("min"=>10,"max"=>100),
																"rt_skin"   => true
															),

															array(
																"label"       => esc_html_x("Breadcrumb Menu Font Size",'Admin Panel','naturalife'),																
																"id"          => "naturalife_breadcrumb_font_size",
																"default"     => "12", 
																"type"        => "number",
																"transport"   => "refresh",
																"input_attrs" => array("min"=>10,"max"=>100),
																"rt_skin"   => true
															),

															array(
																"label"       => esc_html_x("Blog List Heading Font Size",'Admin Panel','naturalife'),																
																"id"          => "naturalife_blog_title_font_size",
																'description' => esc_html_x("Only for H1 and H2 headings in blog lists.",'Admin Panel','naturalife'),
																"default"     => "24", 
																"type"        => "number",
																"transport"   => "refresh",
																"input_attrs" => array("min"=>10,"max"=>100),
																"rt_skin"   => true
															),

															array(
																"label"       => esc_html_x("Blog List Heading Font Size",'Admin Panel','naturalife') . " - " . esc_html_x("Mobile",'Admin Panel','naturalife'),																
																"id"          => "naturalife_blog_title_font_size_m",
																"default"     => "20", 
																"type"        => "number",
																"transport"   => "refresh",
																"input_attrs" => array("min"=>10,"max"=>100),
																"rt_skin"   => true
															),

															array(
																"label"       => esc_html_x("Sidebar Widget Heading Font Size",'Admin Panel','naturalife'),																
																"id"          => "naturalife_sidebar_widget_heading_font_size",
																"default"     => "12", 
																"type"        => "number",
																"transport"   => "refresh",
																"input_attrs" => array("min"=>10,"max"=>100),
																"rt_skin"   => true
															),

															array(
																"label"       => esc_html_x("Sidebar Widget Body Font Size",'Admin Panel','naturalife'),																
																"id"          => "naturalife_sidebar_widget_body_font_size",
																"default"     => "14", 
																"type"        => "number",
																"transport"   => "refresh",
																"input_attrs" => array("min"=>10,"max"=>100),
																"rt_skin"   => true
															),															

															array(
																"label"       => esc_html_x("Footer Widget Heading Font Size",'Admin Panel','naturalife'),																
																"id"          => "naturalife_footer_heading_font_size",
																"default"     => "14", 
																"type"        => "number",
																"transport"   => "refresh",
																"input_attrs" => array("min"=>10,"max"=>100),
																"rt_skin"   => true
															),
															
															array(
																"label"       => esc_html_x("Footer Widget Body Font Size",'Admin Panel','naturalife'),																
																"id"          => "naturalife_footer_body_font_size",
																"default"     => "14", 
																"type"        => "number",
																"transport"   => "refresh",
																"input_attrs" => array("min"=>10,"max"=>100),
																"rt_skin"   => true
															),
													),
									),		

							)
			);