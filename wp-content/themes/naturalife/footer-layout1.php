<?php
if( ! rtframework_get_setting("display_footer") ){
	return;
}
?>
<!-- footer -->
<footer id="footer" class="footer">
	<?php 
		#
		# footer output
		# get templates footer content outputs
		# @hooked in /rt-framework/functions/theme_functions.php
		#				
		do_action( 'rtframework_footer_output' );					
	?>
</footer><!-- / end #footer --> 