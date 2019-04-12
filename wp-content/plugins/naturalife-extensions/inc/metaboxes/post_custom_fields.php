<?php
#-----------------------------------------
#	RT-Theme post_custom_fields.php
#	version: 1.0
#-----------------------------------------

#
# 	Post Custom Fields
#

/**
* @var  array  $customFields  Defines the custom fields available
*/
 
$customFields = array(
				array(
					"title" 		=> _x("Post Format",'Admin Panel','naturalife'),  
					"description"	=> _x('The Post Format Option : The Post item can be set to 6 different types : <br /></br />1) <strong>Standard</strong> : The attached featured image is shown,<br />2) <strong>Gallery</strong> : Display Image(s) as gallery or slider,<br /> 3) <strong>Link</strong> : Tell something about a subject of choice and add a (outside) link to that article or post,<br /> 4) <strong>Video</strong> : Show and Play a Video,<br />5) <strong>Audio</strong> : Show and Play a Audio file,<br />6) <strong>Aside</strong> : The Post item is listed in the blog list but cannot be opened in a single post.<br /><br /><strong>Note : </strong>A image can be attached for replacing the video and audio item in the Blog / Category Listing Pages.','Admin Panel','naturalife'),									
					"name"			=> "_post_format",
					"clean_name"	=> "post_format",
					"options" 		=>  array(
											""        => "Standard",
											"gallery" => "Gallery",
											"link"    => "Link",
											"video"   => "Video", 
											"audio"   => "Audio",
											"aside"   => "Aside"  
									 ),

					"ids" 		=>  array(
										"post-format-0",
										"post-format-gallery",										
										"post-format-link",
										"post-format-video", 
										"post-format-audio", 
										"post-format-aside"
									 ),
					
					"type" 			=> "radio",
					"default"		=> ""
				), 
);

$settings  = array( 
	"name"		=> "Post Formats",
	"scope"		=> array('post'),
	"slug"		=> "post-formats-select",
	"capability"	=> "edit_page",
	"context"		=> "normal",
	"priority"	=> "high" 
);

$rt_post_custom_fields = new rt_meta_boxes($settings,$customFields);

 


$customFields = array(

	array(
		"description"	=> _x("Note: Upload a Featured Image to use it as a placeholder/poster image for the video.",'Admin Panel','naturalife'),					
		"type"			=> "info_text_only",
		"hr"			=> "true",
	),

	array(
		"name"			=> "_post_video_m4v",
		"title"			=> _x("MP4 File URL",'Admin Panel','naturalife'), 	
		"description"	=> _x("Upload a mp4 video-file. For example: http://sample_url/sample_folder/sample.mp4",'Admin Panel','naturalife'),							
		"type"			=> "upload", 
	),

	array(
		"name"			=> "_post_video_webm",
		"title"			=> _x("WEBM File URL",'Admin Panel','naturalife'),
		"description"	=> _x("Upload a WEBM video-file as a fallback video when the mp4 video is not supported (some browsers can not display mp4). Notes: 1) The WEBM video file must be in the same folder as the MP4 video file <br /> 2) The two video files MUST have the same name each with its own correct file extension. <br /> The WEBM file is optional but the MP4 is always needed.",'Admin Panel','naturalife'),					
		"type"			=> "upload", 
	),

	array(
		"title"			 => _x("OR USE A YOUTUBE OR VIMEO VIDEO",'Admin Panel','naturalife'), 
		"type"			 => "heading"
	),

	array(
		"title" 		=> _x("Video URL | YouTube or Vimeo",'Admin Panel','naturalife'), 
		"name"			=> "video_url",
		"description" 	=> _x("Provide and paste a correct url to the video at vimeo or youtube. <strong>Do not include the embed code as the theme will generate the embed code automatically.</strong>",'Admin Panel','naturalife'),
		"type" 			=> "text"
	),

	array(
		"title"			 => _x("BEHAVIOUR OF THE VIDEO IN LISTING PAGES",'Admin Panel','naturalife'), 
		"type"			 => "heading"
	),

	array(
		"title"       => _x("Usage of the Video in Listing Pages",'Admin Panel','naturalife'), 
		"name"        => "_video_usage_listing",
		"description" => _x('With the "Usage of the Video in Listing Pages" option one can set and alter the usage of the Video-file in the Blog Listing Page only.','Admin Panel','naturalife'),						
		"options"     => array(							
							"same"                => _x("Display the Video (grid view only)",'Admin Panel','naturalife'),
							"only_featured_image" => _x("Display the Featured Image",'Admin Panel','naturalife'),
							"no_video"            => _x("Don't display anything",'Admin Panel','naturalife'),
						 ),
		"type" 		 => "select"	
	),
 
);

$settings  = array( 
	"name"		=> _x("Video Post Format Options",'Admin Panel','naturalife'),
	"scope"		=> array('post'),
	"slug"		=> "rt_video_post_custom_fields",
	"capability"	=> "edit_page",
	"context"		=> "normal",
	"priority"	=> "high" 
);

$rt_post_custom_fields = new rt_meta_boxes($settings,$customFields);



$customFields = array(

	array(
		"name"			=> "_post_audio_mp3",
		"title"			=> _x("MP3 File URL",'Admin Panel','naturalife'), 	
		"description"	=> _x("Upload a mp3 audio file. For example: http://sample_url/sample_folder/sample.mp3",'Admin Panel','naturalife'),									
		"type"			=> "upload", 
	),

	array(
		"name"			=> "_post_audio_oga",
		"title"			=> _x("OGG File URL ",'Admin Panel','naturalife'),
		"description"	=> _x("Upload a OGG audio file. For example: http://sample_url/sample_folder/sample.ogg",'Admin Panel','naturalife'),											
		"type"			=> "upload", 
	),


	array(
		"title"			 => _x("BEHAVIOUR OF THE AUDIO FILE IN LISTING PAGES",'Admin Panel','naturalife'), 
		"type"			 => "heading"
	),

	array(
		"title"       => _x("Usage of the Audio in Listing Pages",'Admin Panel','naturalife'), 
		"name"        => "_audio_usage_listing",
		"description" => _x('With the "Usage of the Audio in Listing Pages" option one can set and alter the usage of the Audio-file in the Blog Listing Page only. <strong>Available choices are :</strong><br /><br />1) <strong>Display the Audio</strong> (the Blog Listing Page will show the Audio-file),<br />2) <strong>Display the Featured Image</strong> (the Blog Listing Page will show the to the post attached Featured Image)<br />3) <strong>Do not display anything</strong> (the Blog Listing Page will not show any image or audio-file).','Admin Panel','naturalife'),				
		"options"     => array(							
							"same"                => _x("Display the Audio Player",'Admin Panel','naturalife'),
							"only_featured_image" => _x("Display the Featured Image",'Admin Panel','naturalife'),
							"no_video"            => _x("Don't display Media",'Admin Panel','naturalife'),
						 ),
		"type" 		 => "select"	
	),

 
);

$settings  = array( 
	"name"		=> _x("Audio Post Format Options",'Admin Panel','naturalife'),
	"scope"		=> array('post'),
	"slug"		=> "rt_audio_post_custom_fields",
	"capability"	=> "edit_page",
	"context"		=> "normal",
	"priority"	=> "high" 
);

$rt_post_custom_fields = new rt_meta_boxes($settings,$customFields);



$customFields = array(
	array(
		"description"	=> _x("The gallery function is used to upload and attach multiple images to a post by the use of the <strong>Image Gallery</strong> box. ",'Admin Panel','naturalife'),					
		"type"			=> "info_text_only",
		"hr"			=> "true",
	), 
  
	array(
		"title"       => _x("Usage of Gallery Images",'Admin Panel','naturalife'), 
		"description" => _x('The "Usage of Gallery Images" option can be set to alter the behaviour of the Gallery in the Single Post or Listing Page. <strong>There are two choices:</strong><br /><br />1) <strong>Display Gallery as Slideshow</strong> <br />2) <strong>Display Gallery as Photo-Gallery</strong><br /><br /><strong>Note</strong> : In order to have the slider or gallery function to work there needs to be more then one (1) image attached to the "Image Gallery Box".','Admin Panel','naturalife'),
		"name"        => "_gallery_usage",
		"options"     => array(
							"slider"  => _x("Display Gallery as Slideshow",'Admin Panel','naturalife'),
							"gallery" => _x("Display Gallery as Photo-Gallery",'Admin Panel','naturalife'),
						 ),
		"type"        => "select",	 
	), 

	array(
		"title"   => _x("Displaying Gallery Images in Listing Pages",'Admin Panel','naturalife'), 
		"name"    => "_gallery_usage_listing",
		"description" => _x('With the "Displaying Gallery Images in Listing Pages" option one can set and alter the usage of the gallery in the Blog Listing Page only. <strong>Available choices are :</strong><br /><br />1) <strong>Display the Gallery</strong> (the Blog Listing Page will show the gallery)<br />2) <strong>Display the Featured Image</strong> (the Blog Listing Page will show the to the post attached Featured Image)<br />3) <strong>Do not display anything</strong> (the Blog Listing Page will not show any image).','Admin Panel','naturalife'),		
		"options" => array(							
							"same"                => _x("Display the Gallery/Slideshow",'Admin Panel','naturalife'),
							"only_featured_image" => _x("Display the Featured Image",'Admin Panel','naturalife'),
							"no_image"            => _x("Do not display anything",'Admin Panel','naturalife'),
						 ),
		"type"    => "select"	
	),

	array(
		"title" => _x("SLIDESHOW IMAGE OPTIONS",'Admin Panel','naturalife'),
		"type"  => "heading"
	),

	array(
		"title"   => _x("Crop Images in the Slideshow",'Admin Panel','naturalife'),
		"name"    => "gallery_images_crop",
		"description" 	=> _x('By turning <strong>"ON"</strong> the "Crop Images in the Slideshow" option the images in the gallery will be cropped to the theme defaults width and the height values. The maximum height can be set and controlled below in the next option setting called "Maximum Image Height".','Admin Panel','naturalife'),		
		"default" => "on",
		"hr"      => true,
		"type"    => "checkbox"
	),
			
	array(
		"title"       => _x("Maximum Image Height",'Admin Panel','naturalife'),
		"name"        => "gallery_images_height",
		"description" => _x('Set a maximum height for the gallery image between 300 and 1500px.','Admin Panel','naturalife'),
		"min"         => "0",
		"max"         => "1500",
		"default"     => "600",
		"type"        => "rangeinput"
	),  
 
);

$settings  = array( 
	"name"       => "Gallery Post Format Options",
	"scope"      => array('post'),
	"slug"       => "rt_gallery_post_custom_fields",
	"capability" => "edit_page",
	"context"    => "normal",
	"priority"   => "high" 
);

$rt_post_custom_fields = new rt_meta_boxes($settings,$customFields);
 


$customFields = array(

	array(
		"description"	=> _x("Link the Post to any valid (external) URL.",'Admin Panel','naturalife'),					
		"type"			=> "info_text_only",
		"hr"			=> "true",
	),
   
	
	array(
		"name"        => "post_format_link",
		"title"       => _x("URL",'Admin Panel','naturalife'),
		"description" => _x(" Use a full and correct URL f.e.: (http://yourwebsite.com/yourlink) to where the post should link to. The link will be shown and added to the title of the post.",'Admin Panel','naturalife'),
		"type"        => "text" 
	),	 

	 
);

$settings  = array( 
	"name"       => "Link Post Format Options",
	"scope"      => array('post'),
	"slug"       => "rt_link_post_custom_fields",
	"capability" => "edit_page",
	"context"    => "normal",
	"priority"   => "high" 
);

$rt_post_custom_fields = new rt_meta_boxes($settings,$customFields);

 

$customFields = array(

	array(
		"description"	=> _x("Featured Image Options for the Blog Listing Page or Single Post Page.",'Admin Panel','naturalife'),					
		"type"			=> "info_text_only"
	),


	array(
		"title" 		=> _x("POST LISTING PAGES RELATED OPTIONS",'Admin Panel','naturalife'),
		"type" 			=> "heading"
	),

	array(	 
		"type"        => "div_start",
		"div_class"   => "options_set_holder featured_image_custom_settings",
	),	  	

	array(
		"title"         => _x("Customize Featured Image Settings",'Admin Panel','naturalife'),
		"desc"          => _x('Select and set to use the global settings or customize the cropping and maximum height setting for this post.','Admin Panel','naturalife'),
		"name"          =>  "_featured_image_settings", 
		"options"       =>  array(
			"default"      => _x("Use the global settings",'Admin Panel','naturalife'), 
			"new"          => _x("Customize for this post",'Admin Panel','naturalife'),
			), 
		"type"          => "select", 
		"class"         => "div_controller",
	),	 

		array( 
			"div_class" => "hidden_options_set",
			"type"      => "div_start",
		),

			array(
				"title"         => _x("Customize Featured Resize",'Admin Panel','naturalife'),
				"desc"          => _x('Select and set to use the global settings or customize the cropping and maximum height setting for this post.','Admin Panel','naturalife'),
				"name"          =>  "_blog_image_resize", 
				"options"       =>  array(
					"true"      => _x("Enabled",'Admin Panel','naturalife'), 
					"false"     => _x("Disabled",'Admin Panel','naturalife'),
					), 
				"type"          => "select"
			),	  

			array(
				"title"       => _x("Featured Image Max Width",'Admin Panel','naturalife'),
				"name"        => "_blog_image_width",
				"description" => _x("The featured image will resize to fit the post content area automatically. If you do not want to use the default settings then in here you can set a maximum width for the featured image and alter the look/size of the image in the Blog Listing Page or Single Post Page. <strong>Leave it set to \"0\" to use the theme default scaling of the image which will keep the aspect ratio.</strong> ",'Admin Panel','naturalife'),
				"min"         => "0",
				"max"         => "2000",
				"default"     => "0",
				"type"        => "rangeinput",
				"dependency"  => array( "element" => "rttheme_blog_image_resize", "value" => array("true") ),
			),

			array(
				"title"       => _x("Featured Image Max Height",'Admin Panel','naturalife'),
				"name"        => "_blog_image_height",
				"description" => _x("The featured image will resize to fit the post content area automatically. If you do not want to use the default settings then in here you can set a maximum height for the featured image and alter the look/size of the image in the Blog Listing Page or Single Post Page. <strong>Leave it set to \"0\" to use the theme default scaling of the image which will keep the aspect ratio.</strong> ",'Admin Panel','naturalife'),
				"min"         => "0",
				"max"         => "2000",
				"default"     => "0",
				"type"        => "rangeinput",
				"dependency"  => array( "element" => "rttheme_blog_image_resize", "value" => array("true") ),
			),
			 
			array(
				"title"       => _x("Crop Featured Image.",'Admin Panel','naturalife'),
				"name"        => "_blog_image_crop",
				"description" => _x('By turning "ON" the cropping option the featured image will be cropped according to the previous "Featured Image Max Height" value option on this page.','Admin Panel','naturalife'),
				"default"     => "",
				"type"        => "checkbox",
				"dependency"  => array( "element" => "rttheme_blog_image_resize", "value" => array("true") ),
			),

		array(	 
			"type"    => "div_end"
		),		

	array(	 
		"type"    => "div_end"
	),		


	array(
		"title" 		=> _x("SINGLE POST PAGE RELATED OPTIONS",'Admin Panel','naturalife'),
		"type" 			=> "heading"
	),

	array(	 
		"type"        => "div_start",
		"div_class"   => "options_set_holder featured_image_custom_settings",
	),	  	

	array(
		"title"         => _x("Customize Featured Image Settings",'Admin Panel','naturalife'),
		"desc"          => _x('Select and set to use the global settings or customize the cropping and maximum height setting for this post.','Admin Panel','naturalife'),
		"name"          =>  "_single_featured_image_settings", 
		"options"       =>  array(
			"default"      => _x("Use the global settings",'Admin Panel','naturalife'), 
			"new"          => _x("Customize for this post",'Admin Panel','naturalife'),
			), 
		"type"          => "select", 
		"class"         => "div_controller",
		"hr"            => "true"
	),	 

		array( 
			"div_class" => "hidden_options_set",
			"type"      => "div_start",
		),

			array(
				"title"         => _x("Customize Featured Resize",'Admin Panel','naturalife'),
				"desc"          => _x('Select and set to use the global settings or customize the cropping and maximum height setting for this post.','Admin Panel','naturalife'),
				"name"          =>  "_single_blog_image_resize", 
				"options"       =>  array(
					"true"      => _x("Enabled",'Admin Panel','naturalife'), 
					"false"     => _x("Disabled",'Admin Panel','naturalife'),
					), 
				"type"          => "select"
			),	  

			array(
				"title"       => _x("Featured Image Max Width",'Admin Panel','naturalife'),
				"name"        => "_single_blog_image_width",
				"description" => _x("The featured image will resize to fit the post content area automatically. If you do not want to use the default settings then in here you can set a maximum width for the featured image and alter the look/size of the image in the Blog Listing Page or Single Post Page. <strong>Leave it set to \"0\" to use the theme default scaling of the image which will keep the aspect ratio.</strong> ",'Admin Panel','naturalife'),
				"min"         => "0",
				"max"         => "2000",
				"default"     => "0",
				"type"        => "rangeinput",
				"dependency"  => array( "element" => "rttheme_single_blog_image_resize", "value" => array("true") ),
			),

			array(
				"title"       => _x("Featured Image Max Height",'Admin Panel','naturalife'),
				"name"        => "_single_blog_image_height",
				"description" => _x("The featured image will resize to fit the post content area automatically. If you do not want to use the default settings then in here you can set a maximum height for the featured image and alter the look/size of the image in the Blog Listing Page or Single Post Page. <strong>Leave it set to \"0\" to use the theme default scaling of the image which will keep the aspect ratio.</strong> ",'Admin Panel','naturalife'),
				"min"         => "0",
				"max"         => "2000",
				"default"     => "0",
				"type"        => "rangeinput",
				"dependency"  => array( "element" => "rttheme_single_blog_image_resize", "value" => array("true") ),
			),
			 
			array(
				"title"       => _x("Crop Featured Image.",'Admin Panel','naturalife'),
				"name"        => "_single_blog_image_crop",
				"description" => _x('By turning "ON" the cropping option the featured image will be cropped according to the previous "Featured Image Max Height" value option on this page.','Admin Panel','naturalife'),
				"default"     => "",
				"type"        => "checkbox",
				"dependency"  => array( "element" => "rttheme_single_blog_image_resize", "value" => array("true") ),
			),

		array(	 
			"type"    => "div_end"
		),		

	array(	 
		"type"    => "div_end"
	),		


	array(
		"title" 		=> _x("Hide the Featured Image in the Single Post Page",'Admin Panel','naturalife'),
		"name"			=> "featured_image_single_page",
		"description" 	=> _x('By default the featured image will not show in a single post page. To show the featured image in the single post turn <strong>"ON"</strong> this option.','Admin Panel','naturalife'),
		"default" 		=> "", 
		"type" 			=> "checkbox"
	),	
	 
);

$settings  = array( 
	"name"		 => "Featured Image Options",
	"scope"		 => array('post'),
	"slug"		 => "rt_featured_image_custom_fields",
	"capability" => "edit_page",
	"context"	 => "normal",
	"priority"	 => "high" 
);

$rt_post_custom_fields = new rt_meta_boxes($settings,$customFields);


?>