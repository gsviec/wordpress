<?php
#-----------------------------------------
#	RT-Theme staff_custom_fields.php
#-----------------------------------------

#
# 	Staff Custom Fields
#

/**
* @var  array  $customFields  Defines the custom fields available
*/ 
 


$customFields = array(
		array(
			"description"	=> _x("Team / Staff member items can be used to show your complete team or individual or selected member(s) and their complete details, including all their contact and social information, on any location within a page in your website. Attach a featured image to show a image of the member with his details. Team / Staff members can be listed and called :  1) In the Visual Composer by adding a Team/Staff element or Staff Shortcode into the page content. 2) Directly in a page by the use of the Team/Staff shortcode.",'Admin Panel','naturalife'),	
			"type"			=> "info_text_only",
		),
		array(
			"title" => _x("Short Info",'Admin Panel','naturalife'), 
			"type"  => "heading"
		),

		array(
			"title" 		=> _x("Position",'Admin Panel','naturalife'), 
			"name"			=> "_position",
			"type" 			=> "text"
		),

		array(
			"title"       => _x("Short Info",'Admin Panel','naturalife'),
			"description" => _x("Short info : Add a short information about this member. This information will show when the member is listed by the use of the template builder Team/Staff box or Team/Staff shortcode. The short info will not show when the Single Member Page is opened. In the Single Member Page the value entered above, in the default post body content textarea, is presented.",'Admin Panel','naturalife'),
			"name"        => "_short_data",
			"type"        => "textarea",		
			"label_position"  => "block",		
		), 
);


if ( class_exists( 'RTFramework' ) ) {

	global $rtframework_social_media_icons;

	foreach($rtframework_social_media_icons as $key => $value){   
		 
		$msgdesc=sprintf( _x("Link field : Enter a valid URL to the %s page of the member",'Admin Panel','naturalife'),$key);

		if ($key=="Email") {
			$msgdesc=_x(" Link field : Enter a valid URL to the members own contact-page or emailaddress. Note : Do not add 'mailto:' as the theme will add that automatically in case a valid emailaddress is used.",'Admin Panel','naturalife');
		}
		
		if ($key=="Skype"){
			$msgdesc=_x(" Link field : Enter a valid skype address. Syntax : 'skype:skypeid?call' or 'skype:phonenumber?call'",'Admin Panel','naturalife');
		} 

		if( $value != "rss" ){
			array_push($customFields, 

				array(
				"title" => $key,  
				"type" 	=> "heading"
				),

				array( "type" => "table_start" ),

				array(
				"title" => $key. _x(" link",'Admin Panel','naturalife'), 
				"description" => $key. $msgdesc,
				"name" 	=> "_".$value."",
				"type" 	=> "inline_text",
				),

				array( "type" => "td_col" ),

				array(
				"title" => $key. _x(" Text",'Admin Panel','naturalife'), 
				"description" => $key. _x(" Text field : Enter a short text/title which will show on hovering the (social) icon.",'Admin Panel','naturalife'),
				"name" 	=> "_".$value."_text",
				"type" 	=> "inline_text",
				),

				array( "type" => "table_end" )

					
			);  
		}
	}
}

$settings  = array( 
	"name"       => _x("Staff Options",'Admin Panel','naturalife'), 
	"scope"      => "staff",
	"slug"       => "rt_staff_custom_fields",
	"capability" => "edit_post",
	"context"    => "normal",
	"priority"   => "high" 
);

$rt_staff_custom_fields = new rt_meta_boxes($settings,$customFields);