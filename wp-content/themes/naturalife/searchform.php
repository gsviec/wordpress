<form method="get"  action="<?php echo esc_url(home_url('/')); ?>/"  class="wp-search-form rt_form">
	<ul>
		<li><input type="text" class='search showtextback' placeholder="<?php esc_attr_e("search", "naturalife"); ?>" name="s" /><span class="search-icon ui-icon-search-1"></span></li>
	</ul>
	<?php if( defined( "ICL_LANGUAGE_CODE" ) ) : ?><input type="hidden" name="lang" value="<?php echo esc_attr(ICL_LANGUAGE_CODE) ; ?>"/><?php endif;?>
</form>