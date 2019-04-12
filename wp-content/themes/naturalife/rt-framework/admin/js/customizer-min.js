/*!
 * naturalife WordPress Theme - Customizer
 * Copyright (C) 2014 RT-Themes
 * http://rtthemes.com
 *
 */
!function(a){for(a.fn.rt_css_replace=function(b){var c=new RegExp("{(.*?)}","g"),d=a(this).text().replace(c,"{"+b+"}");a(this).text(d)},a.fn.runs=function(b){wp.customize(rtframework_params.theme_slug+"_"+b+"_link_color",function(c){c.bind(function(c){a('[data-id="'+rtframework_params.theme_slug+"_"+b+'_link_color"]').each(function(){a(this).rt_css_replace(a(this).attr("data-color-for")+":"+c)})})}),wp.customize(rtframework_params.theme_slug+"_"+b+"_bg_color",function(c){c.bind(function(c){a('[data-id="'+rtframework_params.theme_slug+"_"+b+'_bg_color"]').each(function(){a(this).rt_css_replace(a(this).attr("data-color-for")+":"+c)})})}),wp.customize(rtframework_params.theme_slug+"_"+b+"_item_bg_color",function(c){c.bind(function(c){a('[data-id="'+rtframework_params.theme_slug+"_"+b+'_item_bg_color"]').each(function(){a(this).rt_css_replace(a(this).attr("data-color-for")+":"+c)})})}),wp.customize(rtframework_params.theme_slug+"_"+b+"_font_color",function(c){c.bind(function(c){a('[data-id="'+rtframework_params.theme_slug+"_"+b+'_font_color"]').each(function(){a(this).rt_css_replace(a(this).attr("data-color-for")+":"+c)})})}),wp.customize(rtframework_params.theme_slug+"_"+b+"_border_color",function(c){c.bind(function(c){a('[data-id="'+rtframework_params.theme_slug+"_"+b+'_border_color"]').each(function(){a(this).rt_css_replace(a(this).attr("data-color-for")+":"+c)})})}),wp.customize(rtframework_params.theme_slug+"_"+b+"_secondary_font_color",function(c){c.bind(function(c){a('[data-id="'+rtframework_params.theme_slug+"_"+b+'_secondary_font_color"]').each(function(){a(this).rt_css_replace(a(this).attr("data-color-for")+":"+c)})})}),wp.customize(rtframework_params.theme_slug+"_"+b+"_light_text_color",function(c){c.bind(function(c){a('[data-id="'+rtframework_params.theme_slug+"_"+b+'_light_text_color"]').each(function(){a(this).rt_css_replace(a(this).attr("data-color-for")+":"+c)})})}),wp.customize(rtframework_params.theme_slug+"_"+b+"_heading_color",function(c){c.bind(function(c){a('[data-id="'+rtframework_params.theme_slug+"_"+b+'_heading_color"]').each(function(){a(this).rt_css_replace(a(this).attr("data-color-for")+":"+c)})})}),wp.customize(rtframework_params.theme_slug+"_"+b+"_form_button_bg_color",function(c){c.bind(function(c){a('[data-id="'+rtframework_params.theme_slug+"_"+b+'_form_button_bg_color"]').each(function(){a(this).rt_css_replace(a(this).attr("data-color-for")+":"+c)})})}),wp.customize(rtframework_params.theme_slug+"_"+b+"_form_button_hover_color",function(c){c.bind(function(c){a('[data-id="'+rtframework_params.theme_slug+"_"+b+'_form_button_hover_color"]').each(function(){a(this).rt_css_replace(a(this).attr("data-color-for")+":"+c)})})}),wp.customize(rtframework_params.theme_slug+"_"+b+"_form_bg_color",function(c){c.bind(function(c){a('[data-id="'+rtframework_params.theme_slug+"_"+b+'_form_bg_color"]').each(function(){a(this).rt_css_replace(a(this).attr("data-color-for")+":"+c)})})}),wp.customize(rtframework_params.theme_slug+"_"+b+"_social_media_bg_color",function(c){c.bind(function(c){a('[data-id="'+rtframework_params.theme_slug+"_"+b+'_social_media_bg_color"]').each(function(){a(this).rt_css_replace(a(this).attr("data-color-for")+":"+c)})})})},containers=["default","alt_style_1","light_style","footer","side_panel"],i=0;i<containers.length;i++)a.fn.runs(containers[i]);wp.customize(rtframework_params.theme_slug+"_breadcrumb_font_color",function(b){b.bind(function(b){a('[data-id="'+rtframework_params.theme_slug+'_breadcrumb_font_color"]').each(function(){a(this).rt_css_replace(a(this).attr("data-color-for")+":"+b)})})}),wp.customize(rtframework_params.theme_slug+"_breadcrumb_link_color",function(b){b.bind(function(b){a('[data-id="'+rtframework_params.theme_slug+'_breadcrumb_link_color"]').each(function(){a(this).rt_css_replace(a(this).attr("data-color-for")+":"+b)})})}),wp.customize(rtframework_params.theme_slug+"_breadcrumb_bg_color",function(b){b.bind(function(b){b||(b="transparent"),a(".breadcrumb").css({"background-color":b})})}),wp.customize(rtframework_params.theme_slug+"_header_row_font_color",function(b){b.bind(function(b){b||(b="transparent"),a(".sub-page-header h1").css({color:b})})}),wp.customize(rtframework_params.theme_slug+"_header_row_bg_color",function(b){b.bind(function(b){b||(b="transparent"),a(".sub-page-header").css({"background-color":b})})}),wp.customize(rtframework_params.theme_slug+"_body_background_color",function(b){b.bind(function(b){b||(b="transparent"),a("body").css({"background-color":b})})}),wp.customize(rtframework_params.theme_slug+"_holder_background_color",function(b){b.bind(function(b){b||(b="transparent"),a("#container").css({"background-color":b})})}),wp.customize(rtframework_params.theme_slug+"_nav_item_background_color_dark",function(b){b.bind(function(b){b||(b="transparent"),a(".naturalife-dark-header .main-menu > li > a > span").css({"background-color":b})})}),wp.customize(rtframework_params.theme_slug+"_nav_item_font_color_dark",function(b){b.bind(function(b){b||(b="transparent"),a(".naturalife-dark-header .main-menu > li > a > span").css({color:b})})}),wp.customize(rtframework_params.theme_slug+"_nav_item_border_color_dark",function(b){b.bind(function(b){b||(b="transparent"),a(".naturalife-dark-header .main-menu > li > a > span, .naturalife-dark-header .naturalife-search-butto.naturalife-dark-header .mobile-menu-button").css({"border-color":b})})}),wp.customize(rtframework_params.theme_slug+"_sub_nav_item_background_color_dark",function(b){b.bind(function(b){b||(b="transparent"),a(".naturalife-dark-header .main-menu > li li,.naturalife-dark-header .naturalife-language-switcher > ul > li > ul > li").css({"background-color":b})})}),wp.customize(rtframework_params.theme_slug+"_sub_nav_item_font_color_dark",function(b){b.bind(function(b){b||(b="transparent"),a(".naturalife-dark-header .main-menu > li li > a,.naturalife-dark-header .main-menu .multicolumn-holder li > ul > li.menu-item-has-children > span,.naturalife-dark-header .main-menu li li:before,.naturalife-dark-header .main-menu li li:after,.naturalife-dark-header .naturalife-language-switcher > ul > li li span").css({color:b})})}),wp.customize(rtframework_params.theme_slug+"_sub_nav_item_desc_color_dark",function(b){b.bind(function(b){b||(b="transparent"),a(".naturalife-dark-header .main-menu ul li > a > sub,.naturalife-dark-header .main-menu .multicolumn-holder li > .sub-menu ul ul a").css({"border-color":b})})}),wp.customize(rtframework_params.theme_slug+"_sub_nav_item_border_color_dark",function(b){b.bind(function(b){b||(b="transparent"),a(".naturalife-dark-header .main-menu > li li > a,.naturalife-dark-header .main-menu .multicolumn-holder *,.naturalife-dark-header .main-menu > li ul,.naturalife-dark-header .main-menu > li li.menu-item-has-children > a:after,.naturalife-dark-header .naturalife-language-switcher > ul > li li").css({"border-color":b})})}),wp.customize(rtframework_params.theme_slug+"_nav_item_background_color_light",function(b){b.bind(function(b){b||(b="transparent"),a(".naturalife-light-header .main-menu > li > a > span").css({"background-color":b})})}),wp.customize(rtframework_params.theme_slug+"_nav_item_font_color_light",function(b){b.bind(function(b){b||(b="transparent"),a(".naturalife-light-header .main-menu > li > a > span").css({color:b})})}),wp.customize(rtframework_params.theme_slug+"_nav_item_border_color_light",function(b){b.bind(function(b){b||(b="transparent"),a(".naturalife-light-header .main-menu > li > a > span, .naturalife-light-header .naturalife-search-butto.naturalife-light-header .mobile-menu-button").css({"border-color":b})})}),wp.customize(rtframework_params.theme_slug+"_sub_nav_item_background_color_light",function(b){b.bind(function(b){b||(b="transparent"),a(".naturalife-light-header .main-menu > li li,.naturalife-light-header .naturalife-language-switcher > ul > li > ul > li").css({"background-color":b})})}),wp.customize(rtframework_params.theme_slug+"_sub_nav_item_font_color_light",function(b){b.bind(function(b){b||(b="transparent"),a(".naturalife-light-header .main-menu > li li > a,.naturalife-light-header .main-menu .multicolumn-holder li > ul > li.menu-item-has-children > span,.naturalife-light-header .main-menu li li:before,.naturalife-light-header .main-menu li li:after,.naturalife-light-header .naturalife-language-switcher > ul > li li span").css({color:b})})}),wp.customize(rtframework_params.theme_slug+"_sub_nav_item_desc_color_light",function(b){b.bind(function(b){b||(b="transparent"),a(".naturalife-light-header .main-menu ul li > a > sub,.naturalife-light-header .main-menu .multicolumn-holder li > .sub-menu ul ul a").css({"border-color":b})})}),wp.customize(rtframework_params.theme_slug+"_sub_nav_item_border_color_light",function(b){b.bind(function(b){b||(b="transparent"),a(".naturalife-light-header .main-menu > li li > a,.naturalife-light-header .main-menu .multicolumn-holder *,.naturalife-light-header .main-menu > li ul,.naturalife-light-header .main-menu > li li.menu-item-has-children > a:after,.naturalife-light-header .naturalife-language-switcher > ul > li li").css({"border-color":b})})})}(jQuery);