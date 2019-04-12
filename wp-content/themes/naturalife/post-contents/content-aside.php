<?php
# 
# rt-theme
# post content for standart post types in listing pages
# 
extract(rtframework_get_global_value("rtframework_post_values"));
extract(rtframework_get_global_value("rtframework_blog_list_atts"));
?> 

<!-- blog box-->		
<div class="entry-content light-style text">

	<!-- blog headline--> 
	<?php 
		the_content();
	?>

</div><!-- / blog box-->