<?php

if ( !function_exists ('shopkeeper_custom_gutenberg_styles') ) {
	function shopkeeper_custom_gutenberg_styles() {

		global $shopkeeper_theme_options, $default_fonts;

		ob_start();	

		?>

		<style>

			.edit-post-visual-editor h1,
			.edit-post-visual-editor h2,
			.edit-post-visual-editor h3,
			.edit-post-visual-editor h4,
			.edit-post-visual-editor h5,
			.edit-post-visual-editor h6,
			.edit-post-visual-editor .button,
			.edit-post-visual-editor button,
			.edit-post-visual-editor label,
			.edit-post-visual-editor table thead tr th,
			.edit-post-visual-editor input[type="button"],
			.edit-post-visual-editor input[type="reset"],
			.edit-post-visual-editor input[type="submit"],
			.edit-post-visual-editor button[type="submit"],
			.wp-block-button,
			.wp-block-cover .wp-block-cover-text,
			.wp-block-subhead,
			.wp-block-image	figcaption,
			.edit-post-visual-editor .wp-block-quote p,
			.edit-post-visual-editor .wp-block-quote cite,
			.wp-block-quote p,
			.wp-block-quote cite,
			.wp-block-quote .editor-rich-text,
			.edit-post-visual-editor .wp-block-pullquote p,
			.edit-post-visual-editor .wp-block-pullquote cite,
			.wp-block-pullquote p,
			.wp-block-pullquote cite,
			.wp-block-pullquote .editor-rich-text,
			.gbt_18_sk_latest_posts_title,
			.gbt_18_sk_editor_banner_title,
			.gbt_18_sk_editor_slide_title_input,
			.gbt_18_sk_editor_slide_button_input,
			.gbt_18_sk_categories_grid .gbt_18_sk_category_name,
			.gbt_18_sk_categories_grid .gbt_18_sk_category_count,
			.gbt_18_sk_slider_wrapper .gbt_18_sk_slide_button,
			.gbt_18_sk_posts_grid .gbt_18_sk_posts_grid_title,
			.gbt_18_sk_editor_portfolio_item_title,
			.editor-post-title .editor-post-title__input,
			.wc-products-block-preview .product-title,
			.wc-products-block-preview .product-add-to-cart,
			.wc-block-products-category .wc-product-preview__title,
			.wc-block-products-category .wc-product-preview__add-to-cart
			{ 
				font-family: 
				<?php 
					if (isset($shopkeeper_theme_options['new_main_font']['font-family'])):
						if (!in_array($shopkeeper_theme_options['new_main_font']['font-family'], $default_fonts)): ?>
							<?php echo '\'' . $shopkeeper_theme_options['new_main_font']['font-family'] . '\','; ?> 
							sans-serif;
						<?php else: ?>
							<?php echo $shopkeeper_theme_options['new_main_font']['font-family']; ?>;
						<?php endif; ?>
					<?php else: ?>
						NeueEinstellung;
					<?php endif; ?>
			}

			.edit-post-visual-editor p,
			.edit-post-visual-editor textarea,
			.gbt_18_sk_editor_banner_subtitle,
			.gbt_18_sk_editor_slide_description_input
			{
				font-family: 
				<?php if (isset($shopkeeper_theme_options['new_secondary_font']['font-family'])): ?>
					<?php if (!in_array($shopkeeper_theme_options['new_secondary_font']['font-family'], $default_fonts)): ?>
						<?php echo '\'' . $shopkeeper_theme_options['new_secondary_font']['font-family'] . '\','; ?> 
						sans-serif;
					<?php else: ?>
						<?php echo $shopkeeper_theme_options['new_secondary_font']['font-family'] .', sans-serif'; ?>;
					<?php endif; ?>
				<?php else: ?>
					'Radnika';
				<?php endif; ?>
			}

			.editor-styles-wrapper
			{
				font-family: 
				<?php if (isset($shopkeeper_theme_options['new_secondary_font']['font-family'])): ?>
					<?php if (!in_array($shopkeeper_theme_options['new_secondary_font']['font-family'], $default_fonts)): ?>
						<?php echo '\'' . $shopkeeper_theme_options['new_secondary_font']['font-family'] . '\','; ?> 
						sans-serif !important;
					<?php else: ?>
						<?php echo $shopkeeper_theme_options['new_secondary_font']['font-family'] .', sans-serif'; ?> !important;
					<?php endif; ?>
				<?php else: ?>
					'Radnika' !important;
				<?php endif; ?>
			}

			.gbt_18_sk_latest_posts_title,
			.wp-block-quote p,
			.wp-block-pullquote p
			{
				color: <?php echo esc_html($shopkeeper_theme_options['headings_color']); ?>;
			}

			.gbt_18_sk_latest_posts_title:hover,
			.edit-post-visual-editor .wp-block-latest-posts a,
			.edit-post-visual-editor .wp-block-archives a,
			.edit-post-visual-editor .wp-block-categories a,
			.gbt_18_sk_posts_grid_title
			{
				color: <?php echo esc_html($shopkeeper_theme_options['main_color']); ?>;
			}

			.wp-block-quote cite,
			.wp-block-pullquote cite
			{
				color: <?php echo esc_html($shopkeeper_theme_options['body_color']); ?>;
			}

			.wp-block-quote:not(.is-large):not(.is-style-large),
			.wp-block-quote
			{
				border-left-color: <?php echo esc_html($shopkeeper_theme_options['headings_color']); ?>;
			}

			.wp-block-pullquote
			{
				border-top-color: <?php echo esc_html($shopkeeper_theme_options['headings_color']); ?>;
				border-bottom-color: <?php echo esc_html($shopkeeper_theme_options['headings_color']); ?>;
			}

			.gbt_18_sk_latest_posts_item_link:hover .gbt_18_sk_latest_posts_img_overlay
			{
				background: <?php echo esc_html($shopkeeper_theme_options['main_color']) ?>;
			}

		</style>

		<?php

		$content = ob_get_clean();
		$content = str_replace(array("\r\n", "\r"), "\n", $content);
		$lines = explode("\n", $content);
		$new_lines = array();
		foreach ($lines as $i => $line) { if(!empty($line)) $new_lines[] = trim($line); }

		return implode($new_lines);
	}
}

if ( !function_exists ('shopkeeper_custom_gbt_styles') ) {
	function shopkeeper_custom_gbt_styles() {
		$styles = shopkeeper_custom_gutenberg_styles();
		echo $styles;
	}
}

if ( !function_exists ('shopkeeper_custom_gbt_editor_styles') ) {
	function shopkeeper_custom_gbt_editor_styles() {
		global $current_screen;

		$current_screen = get_current_screen();
		if ( method_exists($current_screen, 'is_block_editor') && $current_screen->is_block_editor() ) {
		    $styles = shopkeeper_custom_gutenberg_styles();
			echo $styles;
		}
	}
}

add_action( 'wp_head', 'shopkeeper_custom_gbt_styles', 100 );
add_action( 'admin_head', 'shopkeeper_custom_gbt_editor_styles' );

?>