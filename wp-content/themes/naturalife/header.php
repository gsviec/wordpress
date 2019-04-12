<!doctype html>
<html <?php language_attributes(); ?> class="no-js">
<head> 
<meta charset="<?php bloginfo( 'charset' ); ?>" />  
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php endif; ?>
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>> 
<?php do_action("rtframework_after_body"); ?>
<!-- background wrapper -->
<div id="container">
<?php do_action("rtframework_start_container"); ?> 
<?php get_template_part("top-bar") ?> 
<?php do_action("rtframework_before_header"); ?> 
<?php get_template_part("header-layout".rtframework_get_setting("header_style") ); ?>
<?php get_template_part("mobile-header-layout");?>
<?php do_action("rtframework_after_header"); ?> 

<!-- main contents -->
<div id="main-content">
<?php 
/**
 * rtframework_start_main_content hook			
 * 
 * @hooked rtframework_sub_page_header_function 10
 * @hooked rtframework_before_shop_loop_wrapper 15
 * @hooked rtframework_start_content_container 20  
 * 
 */
do_action("rtframework_start_main_content"); 
?>