<style>

	.dokan-btn, .dokan-btn-theme,
	.dokan-feat-image-btn,
	body.dokan-store .woocommerce-breadcrumb,
	.dokan-single-store .dokan-store-tabs ul li a,
	body.dokan-dashboard .dokan-dash-sidebar .dokan-dashboard-menu a
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

	body.dokan-dashboard .select2-search__field
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

	body.dokan-dashboard .dokan-table .row-actions .edit a,
	body.dokan-dashboard .dokan-table .row-actions .view a,
	body.dokan-dashboard .dokan-table td p a,
	body.dokan-dashboard .dokan-product-listing .dokan-product-listing-area del .amount,
	body.dokan-dashboard .pagination li span.current,
	body.dokan-dashboard .pagination li span:hover,
	body.dokan-dashboard .pagination li a:hover,
	body.dokan-store .dokan-pagination li.active a,
	body.dokan-store .dokan-pagination li span:hover,
	body.dokan-store .dokan-pagination li a:hover,
	body.dokan-dashboard .btn.btn-default:hover,
	body.dokan-store .dokan-widget-area ul li a
	{
		color: <?php echo esc_html($shopkeeper_theme_options['body_color']); ?>;
	}

	body.dokan-store .woocommerce-breadcrumb,
	body.dokan-store .woocommerce-breadcrumb a,
	body.dokan-store .woocommerce-breadcrumb span
	{
		color: rgba(<?php echo getbowtied_hex2rgb($shopkeeper_theme_options['body_color']); ?>,0.55);
	}

	.dokan-dashboard .dokan-dash-sidebar		
	{
		background-color: <?php echo esc_html($shopkeeper_theme_options['headings_color']); ?>;
	}

	.dokan-dashboard .dokan-dash-sidebar ul.dokan-dashboard-menu li a,
	.dokan-dashboard .dokan-dash-sidebar ul.dokan-dashboard-menu li a i
	{
		<?php if ( (isset($shopkeeper_theme_options['main_background']['background-color'])) ) : ?>
		color:<?php echo esc_html($shopkeeper_theme_options['main_background']['background-color']); ?> !important;
		<?php endif; ?>
	}

	body.dokan-store .woocommerce-breadcrumb a:hover
	{
		color: <?php echo esc_html($shopkeeper_theme_options['main_color']); ?>;
	}

	.dokan-btn.dokan-btn-theme:not(.dokan-add-new-product):not([name="dokan_update_payment_settings"]):not([name="dokan_update_product"]):not([name="dokan_update_store_settings"]):not([name="dokan_save_account_details"]):not(.vendor-dashboard),
	.dokan-dashboard .btn-theme.add_note,
	.dokan-dashboard .gravatar-button-area a,
	.dokan-btn.dokan-btn-sm.delete,
	.dokan-product-edit .upload_file_button
	{
		color: <?php echo esc_html($shopkeeper_theme_options['main_color']) ?> !important;
	}

	.dokan-dashboard .dokan-dash-sidebar ul.dokan-dashboard-menu li.active,
	.dokan-dashboard .dokan-dash-sidebar ul.dokan-dashboard-menu li:hover,
	.dokan-dashboard .dokan-dash-sidebar ul.dokan-dashboard-menu li.dokan-common-links a:hover,
	.dokan-dashboard .dokan-dash-sidebar ul.dokan-dashboard-menu li .tooltip .tooltip-inner
	{
		background: <?php echo esc_html($shopkeeper_theme_options['main_color']) ?> !important;
	}

	.dokan-dashboard .dokan-dash-sidebar ul.dokan-dashboard-menu li .tooltip .tooltip-arrow
	{
		border-top-color: <?php echo esc_html($shopkeeper_theme_options['main_color']) ?>;
	}

	body.dokan-dashboard .dokan-table ins
	{
		background-color: <?php echo esc_html($shopkeeper_theme_options['main_color']) ?> !important;
	}

	.dokan-btn.vendor-dashboard,
	.dokan-feat-image-btn,
	.dokan-btn.dokan-add-new-product,
	.dokan-btn.dokan-btn-info,
	.dokan-form-horizontal .dokan-form-group .dokan-w4 .dokan-btn-theme,
	.dokan-new-product-area .dokan-btn[name="add_product"],
	.dokan-product-edit .dokan-btn[name="dokan_update_product"],
	.dokan-btn.insert-file-row
	{
		background-color: <?php echo esc_html($shopkeeper_theme_options['main_color']) ?> !important;
	}

	.dokan-btn.dokan-btn-theme,
	.dokan-dashboard .gravatar-button-area a,
	.dokan-form-horizontal .dokan-form-group .dokan-w4 .dokan-btn-theme,
	.dokan-feat-image-btn
	{
		border-color: <?php echo esc_html($shopkeeper_theme_options['main_color']) ?>;
	}

	.dokan-single-store .dokan-store-tabs ul li a
	{
		color:<?php echo esc_html($shopkeeper_theme_options['sticky_header_color']) ?>;
	}

</style>