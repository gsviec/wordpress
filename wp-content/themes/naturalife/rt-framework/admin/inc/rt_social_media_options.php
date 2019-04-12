<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * RT-Theme Social Media Options
 */

$this->options["rt_social_media_options"] = array(

		'title' => esc_html_x("Social Media Options", 'Admin Panel','naturalife'), 
		'description' => "", 
		'priority' => 8,
		'sections' => array(									

								/*
								array(
									'id'       => 'visibility',
									'title'    => esc_html_x("Visibility", 'Admin Panel','naturalife'), 
									'controls' => array( 
														array(
															"id"        => "naturalife_social_media",															
															"label"     => esc_html_x("Display the icons in the website",'Admin Panel','naturalife'),
															"default"   => "on",
															"transport" => "refresh", 
															"type"      => "checkbox"
														),												
												),
								),	

								*/
					)

		);


//add all icons within a seperate section
$rt_social_media_icons = $this->rtframework_social_media_icons;
ksort( $rt_social_media_icons );
foreach ( $rt_social_media_icons as $key => $value) {

	switch ($key) {
		case 'Email':
			$msgdesc = esc_html_x("Enter a URL to your contact page or your email address.",'Admin Panel','naturalife');
			break;
		
		case 'Skype':
			$msgdesc = wp_kses( _x("Enter a skype address. <strong>Syntax</strong> : 'skype:skypeid?call' or 'skype:phonenumber?call'.",'Admin Panel','naturalife'), array("strong"=>array()) );	
			break;

		case 'RSS':
			$msgdesc = wp_kses( _x("Enter a valid URL (http or https) to the RSS-feed. <strong>For example</strong>  http://yourwebsite.com/feed/ ",'Admin Panel','naturalife'), array("strong"=>array()) );	
			break;

		default:
			$msgdesc = wp_kses( _x("Enter the URL that you want to link the icon <strong>For example</strong>  http://social-media-site.com/your-name/ ",'Admin Panel','naturalife'), array("strong"=>array()) );	
			break;
	}

	array_push($this->options["rt_social_media_options"]["sections"], array(
			'id'       => $value,
			'title'    => $key." ".esc_html_x("Options", 'Admin Panel','naturalife'), 
			'controls' => array( 
								array(
									"id"          => "naturalife_".$value,										
									"label"       => esc_html_x("Link (URL)",'Admin Panel','naturalife'),
									"default"     => "",
									"description" => $msgdesc,
									"type"        => "text"
								),															
								array(
									"id"      => "naturalife_".$value."_text",											
									"label"   => esc_html_x("Hover Text",'Admin Panel','naturalife'),
									"default" => "",
									"type"    => "text"
								),										
								array(
									'id'      => "naturalife_".$value."_target",						
									'label'   => esc_html_x("Link Target",'Admin Panel','naturalife'),
									'type'    => 'select',
									"default" => "",
									'choices' =>  array('_blank'=>'New Window','_self'=>'Same Window'),
								),													
						),
		)
	);

}