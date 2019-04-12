<?php
#-----------------------------------------
#	RT-Theme testimonial_custom_fields.php
#-----------------------------------------

#
# 	Staff Custom Fields
#

/**
* @var  array  $customFields  Defines the custom fields available
*/ 

 

$customFields = array(

		array(
			"description"	=> _x("Testimonials can be used to show your client's remarks about anything they commented on. You can have them shown in any part of your website. Attach a featured image to show a (rounded) thumbnail image of the person or company-logo beside the testimonial text. Testimonial items can be listed and called : <br /><br />1) In the Visual Composer by adding a testimonial element or in the page content by adding a testimonials shortcode.,<br />2) Directly in a page by the use of the testimonial shortcode.",'Admin Panel','naturalife'),	
			"type"			=> "info_text_only",
		),
		array(
			"title" => _x("The Testimonial Text",'Admin Panel','naturalife'), 
			"type"  => "heading"
		),
		array(
			"title" => _x("Testimonial Text",'Admin Panel','naturalife'),
			"description"	=> _x("Testimonial Text : Enter the text which needs to appear as the testimonial text. Valid HTML code (h-tags, a-tags, divs) is allowed, but we suggest to keep the formatting as simple as possible.",'Admin Panel','naturalife'),	
			"name"  => "_testimonial",
			"type"  => "textarea",	
			"label_position"  => "block",				
		),

		array(
			"title" => _x("Testimonial Info",'Admin Panel','naturalife'), 
			"type"  => "heading"
		),

		array(
			"type"  => "table_start"
		),

		array(
			"title" => _x("Client's Name",'Admin Panel','naturalife'), 
			"description"	=> _x("Client's Name : The supplied name will appear at the bottom of the Testimonial.",'Admin Panel','naturalife'),
			"name"  => "_name",
			"type"  => "inline_text",
			"label_position"  => "block",	
		),		

		array(
			"type" => "td_col"
		),

		array(
			"title" => _x("Client's Job Title",'Admin Panel','naturalife'), 
			"description"	=> _x("Client's Job Title : The supplied Job Title will appear at the bottom of the Testimonial.",'Admin Panel','naturalife'),			
			"name"  => "_title",
			"type"  => "inline_text",
			"label_position"  => "block",	
		),

		array(
			"type" => "table_end"
		),		
		
		array(
			"type"  => "table_start"
		),

		array(
			"title" => _x("Company / Organization",'Admin Panel','naturalife'), 
			"name"  => "_link_text",
			"type"  => "inline_text",
			"label_position"  => "block",	
		),

		array(
			"type" => "td_col"
		),

		array(
			"title" => _x("Client's Link",'Admin Panel','naturalife'), 
			"name"  => "_link",
			"type"  => "inline_text",
			"label_position"  => "block",	
		),

		array(
			"type" => "table_end"
		),						
);

$settings  = array( 
	"name"       => _x("Testimonial Options",'Admin Panel','naturalife'), 
	"scope"      => "testimonial",
	"slug"       => "rt_testimonial_custom_fields",
	"capability" => "edit_post",
	"context"    => "normal",
	"priority"   => "high" 
);

$rt_testimonial_custom_fields = new rt_meta_boxes($settings,$customFields);