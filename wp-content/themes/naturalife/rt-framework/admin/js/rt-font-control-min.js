/*!
 * 
 * naturalife WordPress Theme Admin - Font Control
 * Copyright (C) 2014 RT-Themes
 * http://rtthemes.com
 *
 */
jQuery(document).ready(function(a){function b(b,c){var d,e,f,g=!1;for(selected_values_array=c.toString().split(","),b=b.toString().split(","),d=0;d<b.length;++d)a.inArray(b[d],selected_values_array)>-1&&(g=!0);for(d=0;d<b.length;++d)f=a.inArray(b[d],selected_values_array)>-1?"selected":"",f=g||0!=d?f:"selected",e+='<option value="'+b[d]+'" '+f+">"+b[d]+"</option>";return e}a(".rt_fonts").on("change",function(){var c,d=a("option:selected",this),e=d.val();if(!e)return!1;{var f=d.data("variants"),g=d.data("subsets"),h=e.split("||"),i=h[0];h[1]}c=a("[data-customize-setting-link='"+a(this).data("subset-id")+"']"),"google"==i&&g?(c.html(b(g,a(this).data("selected-subsets"))).trigger("change"),c.parents("li:eq(0)").show().effect("highlight",700)):c.parents("li:eq(0)").hide(),c=a("[data-customize-setting-link='"+a(this).data("variant-id")+"']"),"google"==i&&f?(c.html(b(f,a(this).data("selected-variant"))).trigger("change"),c.parents("li:eq(0)").show().effect("highlight",700)):c.parents("li:eq(0)").hide()}),a(window).on("load",function(){a(".rt_fonts").each(function(){a(this).trigger("change")})})});