<?php

// remove elements
vc_remove_element("vc_wp_search");
vc_remove_element("vc_wp_meta");
vc_remove_element("vc_wp_recentcomments");
vc_remove_element("vc_wp_calendar");
vc_remove_element("vc_wp_pages");
vc_remove_element("vc_wp_tagcloud");
vc_remove_element("vc_wp_custommenu");
vc_remove_element("vc_wp_text");
vc_remove_element("vc_wp_posts");
vc_remove_element("vc_wp_links");
vc_remove_element("vc_wp_categories");
vc_remove_element("vc_wp_archives");
vc_remove_element("vc_wp_rss");
vc_remove_element("product");
// vc_remove_element("add_to_cart");
vc_remove_element("add_to_cart_url");
vc_remove_element("product_page");

vc_add_param("vc_row", array(
	"type" => "textfield",
	"class" => "hide_in_vc_editor",
	"admin_label" => true,
	"heading" => "Height",
	"param_name" => "height",
	"value" => "",
	"description" => ""
));

vc_add_param("vc_row", array(
	"type" => "dropdown",
	"class" => "hide_in_vc_editor",
	"admin_label" => true,
	"heading" => "Row Type",
	"param_name" => "type",
	"description" => "[Deprecated Option] Use 'Row Stretch' instead (scroll above).",
	"value" => array(
		"Full Width" => "full_width",
		"Boxed" => "boxed"
	)
));

vc_add_param("vc_row", array(
	"type" => "dropdown",
	"class" => "hide_in_vc_editor",
	"admin_label" => true,
	"heading" => "Columns Height",
	"param_name" => "columns_height",
	"description" => "[Deprecated Option] Use 'Equal Height' instead (scroll above).",
	"value" => array(
		"Normal" => "normal_height",
		"Fit Columns Height" => "adjust_cols_height"
	)
));

// [vc_row_inner]
vc_add_param("vc_row_inner", array(
	"type" => "dropdown",
	"class" => "hide_in_vc_editor",
	"admin_label" => true,
	"heading" => "Row Type",
	"param_name" => "type",
	"description" => "[Deprecated Option]",
	"value" => array(
		"Full Width" => "full_width",
		"Boxed" => "boxed"
	)
));