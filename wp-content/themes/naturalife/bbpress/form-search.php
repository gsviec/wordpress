<?php

/**
 * Search 
 *
 * @package bbPress
 * @subpackage Theme
 */

?>
<form role="search" method="get" action="<?php bbp_search_url(); ?>" class="wp-search-form rt_form"> 
	<label class="screen-reader-text hidden" for="bbp_search"><?php esc_html_e( 'Search for:', 'naturalife' ); ?></label>
	<input type="hidden" name="action" value="bbp-search-request" />
	<ul>
		<li><input tabindex="<?php bbp_tab_index(); ?>" type="text" placeholder="<?php esc_attr_e("Search for:", "naturalife"); ?>"  value="<?php echo esc_attr( bbp_get_search_terms() ); ?>" name="bbp_search" id="bbp_search" class="search showtextback" /><span tabindex="<?php bbp_tab_index(); ?>" class="search-icon ui-icon-search-1" id="bbp_search_submit"></span></li>
	</ul>
</form>