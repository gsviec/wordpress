<?php
/**
 * Portfolio Video
 */
$single_post_values = rtframework_get_global_value("rtframework_single_post_values");


if( ! empty( $single_post_values["external_video"] ) || ! empty( $single_post_values["video_mp4"] )  ){		

	//self hosted videos
	if( ! empty( $single_post_values["video_mp4"] ) ){
		do_action("rtframework_create_media_output",
			array(
				'id' => 'video-'.get_the_ID(),
				'type' => "video",
				'file_mp4' => $single_post_values["video_mp4"],
				'file_webm' => $single_post_values["video_webm"],
				'poster'=> $single_post_values["poster_img_url"]
			)
		);
	}

	//external videos
	if ( ! empty( $single_post_values["external_video"] ) ){
		 
		if( strpos($single_post_values["external_video"], 'youtube')  ) { //youtube
			echo '<div class="video-container embed-responsive embed-responsive-16by9"><iframe class="embed-responsive-item" src="//www.youtube.com/embed/'.rtframework_find_tube_video_id(esc_url($single_post_values["external_video"])).'?rel=0&amp;showinfo=0" allowfullscreen></iframe></div>';
		}
		
		if( strpos($single_post_values["external_video"], 'vimeo')  ) { //vimeo
			echo '<div class="video-container embed-responsive embed-responsive-16by9"><iframe class="embed-responsive-item" src="//player.vimeo.com/video/'.rtframework_find_tube_video_id(esc_url($single_post_values["external_video"])).'?color=d6d6d6&title=0&amp;byline=0&amp;portrait=0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe></div>';
		}			
	}

}