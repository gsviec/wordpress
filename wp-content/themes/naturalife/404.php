<?php
/**
 * 
 * 404 template
 *
 */
get_header(); ?>

<div class="row page-404">	
	
	<div class="col col-sm-4">
		<span class="icon-address"></span>
	</div>

	<div class="col col-sm-8">
		<h1><?php esc_html_e( '404', 'naturalife'); ?></h1>

		<p><?php esc_html_e( 'Apologies, but the page you requested could not be found. Perhaps searching will help.', 'naturalife'); ?></p>

		<?php get_template_part("searchform"); ?>
	</div>

</div>

<?php get_footer(); ?>