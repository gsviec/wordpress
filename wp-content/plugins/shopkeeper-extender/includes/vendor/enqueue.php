<?php

$theme = wp_get_theme();
if ( $theme->template != 'shopkeeper') {

	add_action( 'wp_enqueue_scripts', 'getbowtied_vendor_scripts', 99 );
	function getbowtied_vendor_scripts() {

		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
		wp_register_style(
			'gbt_18_sk_swiper_style',
			plugins_url( 'swiper/css/swiper'.$suffix.'.css', __FILE__ ),
			array(),
			filemtime(plugin_dir_path(__FILE__) . 'swiper/css/swiper'.$suffix.'.css')
		);
		wp_register_script(
			'gbt_18_sk_swiper_script',
			plugins_url( 'swiper/js/swiper'.$suffix.'.js', __FILE__ ),
			array()
		);
	}
}