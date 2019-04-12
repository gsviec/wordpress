<?php 
/**
 * rtframework_end_main_content hook			
 * 
 * @hooked rtframework_end_content_container 20  
 * 
 */
do_action("rtframework_end_main_content"); 
?> 
</div><!-- / end #main-content -->
<?php do_action("rtframework_before_footer"); ?> 
<?php get_template_part("footer-layout1" ); ?>
<?php do_action("rtframework_end_container"); ?> 
</div><!-- / end #container --> 

<?php wp_footer();?>
</body>
</html>