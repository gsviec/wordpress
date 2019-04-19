<style>

	.archive .products-grid li .product_german_market_info .woocommerce-de_price_taxrate span,
	.archive .products-grid li .product_german_market_info .woocommerce_de_versandkosten,
	.archive .products-grid li .product_german_market_info .price-per-unit,
	.archive .products-grid li .product_german_market_info .shipping_de.shipping_de_string,
	.germanized-active,
	.germanized-active p:not(.price),
	.germanized-active span,
	.germanized-active div,
	.german-market-active,
	.german-market-active p:not(.price),
	.german-market-active span,
	.german-market-active div,
	.german-market-info,
	.german-market-info p:not(.price),
	.german-market-info span,
	.german-market-info div,
	.products .wc-gzd-additional-info,
	.woocommerce-variation-price .woocommerce-de_price_taxrate,
	.woocommerce-variation-price .price-per-unit,
	.woocommerce-variation-price .woocommerce_de_versandkosten,
	.woocommerce-variation-price .shipping_de_string,
	.archive .products .delivery-time-info,
	.archive .products .shipping-costs-info,
	.wgm-info.woocommerce-de_price_taxrate
	{
		color: rgba(<?php echo getbowtied_hex2rgb($shopkeeper_theme_options['body_color']); ?>,0.55) !important;
	}

	span.wc-gzd-additional-info.shipping-costs-info,
	.product p.wc-gzd-additional-info
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

	span.wc-gzd-additional-info.shipping-costs-info,
	.product p.wc-gzd-additional-info
	{
		color: <?php echo esc_html($shopkeeper_theme_options['body_color']); ?>;
	}

	.archive .woocommerce-de_price_taxrate,
	.archive .woocommerce_de_versandkosten,
	.archive .price-per-unit,
	.archive .wc-gzd-additional-info a,
	.products .product_after_shop_loop.germanized-active a:not(.button)
	{
		color: <?php echo esc_html($shopkeeper_theme_options['headings_color']); ?>;
	}

</style>