<?php

/******************************************************************************/
/* Social Media ***************************************************************/
/******************************************************************************/	

function getbowtied_social_media() {

	global $shopkeeper_theme_options, $social_media_profiles;
		
	foreach($social_media_profiles as $social) :

		if ( isset($shopkeeper_theme_options[$social['link']]) && !empty($shopkeeper_theme_options[$social['link']]) ) :
		?>

			<li><a href="<?php echo $shopkeeper_theme_options[$social['link']]; ?>" target="_blank" class="social_media"><span class="<?php echo $social['icon']; ?>"></span></a></li>

		<?php
		endif;

	endforeach;

}
add_action( 'getbowtied_social_media', 'getbowtied_social_media' );