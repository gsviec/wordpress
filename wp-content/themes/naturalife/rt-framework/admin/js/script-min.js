/*!
 * naturalife WordPress Theme Admin Scripts
 * Copyright (C) RT-Themes
 * http://rtthemes.com
 *
 * Various scripts for admin UI Only 
 */
function getParameterByName(a){a=a.replace(/[\[]/,"\\[").replace(/[\]]/,"\\]");var b=new RegExp("[\\?&]"+a+"=([^&#]*)"),c=b.exec(location.search);return null==c?"":decodeURIComponent(c[1].replace(/\+/g," "))}jQuery(function(a){a(document.body).on("click",".rt_modal_close",function(){a(this).parents(".rt_modal:eq(0)").css({display:"none"})})}),jQuery(function(a){a("#rt_theme_reset_settings input").on("click",function(){return save_control_confirm=confirm(rtframework_variables.reset_theme),save_control_confirm?void 0:!1})}),jQuery(function(a){a("#customize-controls #save").on("click",function(){wp.customize.previewer.refresh()})}),jQuery(function(a){a("[data-depends-id]").each(function(){var b=a(this),c=a("#"+b.attr("data-depends-id")),d=a.makeArray(b.attr("data-depends-values").split(","));if(0==c.length){c=a("[data-customize-setting-link='"+b.attr("data-depends-id")+"']"),b=a(this).parents(".customize-control:eq(0)")}c.on("change",function(c,e){var f=a("option:selected",this).val();a.inArray(f,d)>=0?e?b.show():b.show().effect("highlight",700):b.hide()}),c.trigger("change","load")})}),jQuery(function(a){a(document.body).on("click",".tooltip_icon",function(){var b=a(this).parents(".table-row:eq(0)").find(".desc:eq(0)");b.slideToggle("fast").toggleClass("active"),a(this).toggleClass("clicked")})}),jQuery(function(a){a(".rt-focus-widgets").on("click",function(a){return a.preventDefault(),wp.customize.panel("widgets").focus(),!1})}),jQuery(function(a){function b(){function b(){a("#rttheme_shortcode_helper .rt_tabs").rt_tabs(),a("#rttheme_shortcode_helper .tab_nav > li").on("click",function(){console.log("asdas"),a(".modal_content").stop().animate({scrollTop:0},300)}),a("#rttheme_shortcode_helper").show("fade",{duration:300,easing:"swing"}),a(".tab_contents, .tab_nav").scrollTop(0),"undefined"!=typeof tinyMCE?null!=window.tinyMCE.activeEditor&&a("#rttheme_shortcode_helper .insert_to_editor").css(""!=window.tinyMCE.activeEditor.editorId&&"rt_hidden_rich_editor"!=window.tinyMCE.activeEditor.editorId?{display:"block"}:{display:"none"}):a("#rttheme_shortcode_helper .insert_to_editor").css({display:"none"}),a(".insert_to_editor").on("click",function(){var b=a(this).prev("textarea").val(),c="";if(console.log(a(this)),console.log(a(this).prev("textarea")),console.log(b),a("#"+tinymce.activeEditor.id).parents("#wp-content-wrap").hasClass("html-active")===!1){var d=b.split(/\n/);for(i=0,l=d.length;i<l;i++)c+=d[i],this_line=a.trim(d[i]),this_last_char=this_line.substr(this_line.length-1),">"!=this_last_char&&(c+="<br />")}else c=b;wp.media.editor.insert(c),a("#rttheme_shortcode_helper .rt_modal_close").trigger("click")}),"undefined"!=typeof tinymce&&"undefined"!=typeof tinymce.create&&(tinymce.create("tinymce.plugins.rt_theme_shortcodes",{init:function(a,b){a.addButton("rt_themeshortcode",{title:"Theme Shortcodes",image:b+"/../images/theme-shorcodes.png",onclick:function(){jQuery("#wp-admin-bar-rt_shortcode_helper_button").trigger("click")}})},createControl:function(){return null},getInfo:function(){return{longname:"Shortcodes",author:"RT-Theme",version:"1.0"}}}),tinymce.PluginManager.add("rt_themeshortcode",tinymce.plugins.rt_theme_shortcodes)),a(".rt_clean_copy").on("click",function(){if(!a(this).hasClass("clicked")){var b=a(this).html(),c=a('<input type="text" value="'+b+'" style="width:100px;">');a(this).html(""),a(this).addClass("clicked"),c.appendTo(a(this)),c.select()}})}0==a("#rttheme_shortcode_helper").length?(a('<div class="rt_loading_bar"></div>').appendTo("body"),data="action=my_action&shortcode_helper=true",a.post(ajaxurl,data,function(c){a(".rt_loading_bar").remove(),a(c).appendTo("body").fadeIn(500),b()})):a("#rttheme_shortcode_helper").show("fade",{duration:300,easing:"swing"})}a("#wp-admin-bar-rt_shortcode_helper_button").on("click",{purpose:"admin_bar"},b),a(window).on("rt_theme_shortcodes",function(){b()})}),jQuery(function(a){a(".style_parts > div").on("mouseenter mouseleave",function(b){var c=a(this).attr("data-desc"),d=a('<div class="rt_tooltip_message">'+c+"</div>");a(".rt_tooltip_message").remove(),"mouseenter"==b.type&&(a("body").append(d),d.css({top:a(this).offset().top-d.height()/2,left:a(this).offset().left-240}))})}),function(a){a.fn.start_scripts=function(b,c){c&&(c="."+c),a(b).find(".multiple"+c).asmSelect({addItemTarget:"bottom",animate:!0,highlight:!0,sortable:!0,removeLabel:"x"}),a(b).find(".range"+c).rangeinput(),a(b).find(".div_controller").trigger("change"),a(b).find(".color_field input").each(function(){0==a(this).hasClass("hidden_slide_item")&&(a(this).spectrum({flat:!1,showInput:!0,showButtons:!1,showAlpha:!0,move:function(b){var c;c=b.getAlpha()<1?b.toRgbString():b.toHexString(),a(this).val(c),a(this).attr("value",c)},change:function(b){var c;c=b.getAlpha()<1?b.toRgbString():b.toHexString(),a(this).val(c),a(this).attr("value",c)},hide:function(b){if(""==a(this).val()&&"#ffffff"==b.toHexString()){var c;c=b.getAlpha()<1?b.toRgbString():b.toHexString(),a(this).val(c),a(this).attr("value",c)}}}),a(this).show(function(){""==a(this).val()&&(a(this).spectrum("set","#ffffff"),a(this).attr("value",""))}))})},a.fn.start_scripts(".rt-metaboxes, .widgets-holder-wrap","","page_load")}(jQuery),function(a){a(document).on("click",".rttheme_upload_button",function(b){var c=a(this).prev();if(this_image_holder=a('[data-holderid="'+a(this).data("inputid")+'"]'),b.preventDefault(),d)return void d.open();var d=wp.media.frames.file_frame=wp.media({title:wp.media.view.l10n.addMedia,multiple:!1});d.on("select",function(){var a=d.state().get("selection").first().toJSON();c.val(a.url).trigger("change"),"image"!=a.type&&(this_image_holder.find("img").attr("src",""),this_image_holder.removeClass("visible"))}),d.open()}),a(document).on("keyup change",".upload_field",function(){var b=a(this),c=a('[data-holderid="'+a(this).prop("id")+'"]');b.val()?(c.find("img").attr("src",b.val()),c.addClass("visible")):(c.find("img").attr("src",""),c.removeClass("visible"))}),a(document).on("click",".uploaded_file .delete_single",function(){var b=a("#"+a(this).data("inputid"));b.val("").trigger("keyup")}),a(".upload_field").focus(function(){a(this).select()})}(jQuery),function(a){a(document).on("click",".rt_gallery_add_button",function(b){{var c;a(this)}return b.preventDefault(),c?void c.open():(c=wp.media.frames.file_frame=wp.media({title:wp.media.view.l10n.addMedia,multiple:!0}),c.on("select",function(){var b=c.state().get("selection"),d=a("#rt-gallery-images"),e=d.val(),f=""==e?new Array:e.split(",");b.map(function(b){b=b.toJSON(),(0==f.length||-1===a.inArray(b.id.toString(),f))&&(a(".rt-gallery-uploaded-photos").append('<li><img src="'+b.sizes.thumbnail.url+'" data-rel="'+b.id+'"></li>'),f.push(b.id),d.val(f.join(",")))})}),c.on("open",function(){var a=c.state().get("selection");return""==jQuery("#rt-gallery-images").val()?!1:(ids=jQuery("#rt-gallery-images").val().split(","),void ids.forEach(function(b){attachment=wp.media.attachment(b),attachment.fetch(),a.add(attachment?[attachment]:[])}))}),void c.open())})}(jQuery),function(a){a(document).on("click",".rttheme_image_upload_button",function(b){var c=a(this).prev(),d=a('[data-holderid="'+a(this).data("inputid")+'"]'),e=a(this).next(".display_file_name");if(b.preventDefault(),f)return void f.open();var f=wp.media.frames.downloadable_file=wp.media({title:wp.media.view.l10n.addMedia,multiple:!1});f.on("select",function(){var a=f.state().get("selection").first().toJSON();c.val(a.id),"image"==a.type?(d.find("img").attr("src",a.sizes.thumbnail.url),d.addClass("visible")):(d.find("img").attr("src",""),d.removeClass("visible"),e.html(a.filename))}),f.open()})}(jQuery),function(a){a("ul.rt-gallery-uploaded-photos").sortable({handle:"img",forceHelperSize:!0,opacity:.5,scroll:!0,scrollSpeed:20,cursor:"move",distance:10,placeholder:"ui-sortable-placeholder",tolerance:"pointer",start:function(a,b){b.item;b.placeholder.width(b.item.width()),b.placeholder.height(b.item.height())},update:function(){var b=a("#rt-gallery-images"),c="";a(this).find("li").each(function(){var b=a(this).find("img").attr("data-rel");c=""==c?b:c+","+b}),b.val(c)}}),a(document.body).on("mouseenter",".rt-gallery-uploaded-photos li",function(){var b='<div class="gallery_delete"></div>',c=a(this).find(".gallery_delete");return c.length?(c.show(),!1):void a(this).append(b)}),a(document.body).on("mouseleave",".rt-gallery-uploaded-photos li",function(){a(this).find(".gallery_delete").hide()}),a(document.body).on("click",".rt-gallery-uploaded-photos li .gallery_delete",function(){var b=confirm(rtframework_variables.delete_image),c=a(this),d=a("#rt-gallery-images"),e=d.val().split(","),f=c.parent("li"),g=f.find("img:eq(0)").attr("data-rel");if(b){e=jQuery.grep(e,function(a){return a!=g});var h=e.join();return d.val(h),c.parent("li").remove(),!0}return!1})}(jQuery),function(a){a(document).on("change",".div_controller",function(){var b=a("option:selected",this).val(),c=a(this).parents(".options_set_holder:eq(0)").find(".hidden_options_set:eq(0)");"new"===b||"boxed-body"===b||"half-boxed"===b||"disabled_parallax"===b?c.slideDown("fast"):c.slideUp("fast")}),a(".div_controller").trigger("change")}(jQuery),jQuery(function(a){function b(b){purpose=b.data.purpose,thisField=a(b.target),iconSelector=a(".icon-selection"),"item"==purpose?a(".icon-selection").removeClass("admin_bar"):a(".icon-selection").addClass("admin_bar"),0==iconSelector.length?(a('<div class="rt_loading_bar"></div>').appendTo("body"),data="action=my_action&iconSelector=true",a.post(ajaxurl,data,function(b){a(".rt_loading_bar").remove(),"item"==purpose?(a(b).appendTo("body").fadeIn(500),a(".icon-selection .blank").show()):(a(b).addClass("admin_bar").appendTo("body").fadeIn(500),a(".icon-selection .blank").hide())})):(a(iconSelector).fadeIn(500),"item"==purpose?a(".icon-selection .blank").show():a(".icon-selection .blank").hide()),a(document.body).on("click",".icon_selection_close",function(){a(".icon-selection").hide(),thisField.focus()}),a(document.body).on("click",".list-icons li",function(){if("item"==purpose){var c=a.trim(a(this).attr("class")),d=a(b.target),e=a(d).val(),f=e.split(" "),g="",h=1;for(i=0;i<f.length;i++)0==f[i].search(/icon-/i)&&"blank"==c?g+="":0==f[i].search(/icon-/i)&&"blank"!=c&&1==h?(g+=c,h+=1):f[i].search(/icon-/i)<0&&"blank"!=c&&1==h?(g+=" "+f[i]+" "+c,h+=1):g+=" "+f[i];a(d).focus(),a(d).val(a.trim(g)),a(d).change(),a(".icon-selection").hide(),a(document.body).off("click",".list-icons li")}})}a(document.body).on("keyup","#rt_icon_search",function(){var b=a(this).val(),c=0;a(".list-icons li").each(function(){a(this).find("span").text().search(new RegExp(b,"i"))<0?a(this).fadeOut():(a(this).show(),c++)});a("#rt_icon_search_result").text(c+" icons found")}),a(document.body).on("click",'.button_icon,.button2_icon,.icon_name,.icon_selection,.edit-menu-item-classes,[data-setting="rt-icon-name"]',{purpose:"item"},b),a("#wp-admin-bar-rt_icons .ab-item div").on("click",{purpose:"admin_bar"},b)}),jQuery(document).ajaxSuccess(function(a,b,c){var d="latest_posts",e="popular_posts",f="recent_posts_gallery",g="rt_products";if(c.data&&"function"==typeof c.data.search&&c.data&&-1!=c.data.search("action=save-widget")&&(-1!=c.data.search("id_base="+d)||-1!=c.data.search("id_base="+e)||-1!=c.data.search("id_base="+f)||-1!=c.data.search("id_base="+g))){var h=c.data,i=h.split("widget-id="),j=i[1].split("&id_base"),k=j[0];jQuery("select[multiple]#widget-"+k+"-categories").asmSelect({addItemTarget:"bottom",animate:!0,highlight:!0,removeLabel:"x"})}}),function(a){a(document).on("click","#rt_theme_custom_fonts .delete-font",function(){a("#rt_theme_custom_fonts form");return delete_font_confirm=confirm(rtframework_variables.delete_font),delete_font_confirm?void a(this).parents(".font-holder:eq(0)").remove():!1}),a.fn.custom_font_forms=function(){a(this).each(function(){var b=a(this);a(this).on("change",function(){var c=b.parents(".form-table:eq(0)");"typekit"==a("option:selected",this).val()?(c.find(".kitid").show(),c.find(".self_hosted_font").hide()):(c.find(".kitid").hide(),c.find(".self_hosted_font").show()),"self-hosted"==a("option:selected",this).val()?c.find(".self_hosted_font").show():c.find(".self_hosted_font").hide()}),a(window).load(function(){b.trigger("change")})})},a("#rt_theme_custom_fonts form .rt-font-type").custom_font_forms()}(jQuery),jQuery(document).ready(function(){jQuery.fn.extend({ShowPostFormats:function(){$this=jQuery(this);var a=$this.attr("id"),b={};b["post-format-0"]="#rt_standart_post_custom_fields",b["post-format-gallery"]="#rt_gallery_post_custom_fields",b["post-format-link"]="#rt_link_post_custom_fields",b["post-format-video"]="#rt_video_post_custom_fields",b["post-format-audio"]="#rt_audio_post_custom_fields";for(var c in b)"post-format-0"!==c&&jQuery(b[c]).css({display:"none"});jQuery(b[a]).show().effect("highlight",700)}}),jQuery("#post-formats-select input:checked").ShowPostFormats(),jQuery("#post-formats-select").on("change",function(){jQuery("#post-formats-select input:checked").ShowPostFormats()})}),function(a){a.fn.rt_portfolio_formats=function(){var b={"rttheme_portfolio_post_format-1":"rttheme_image_format_options","rttheme_portfolio_post_format-2":"rttheme_video_format_options","rttheme_portfolio_post_format-3":"rttheme_audio_format_options"};for(var c in b){var d=b[c];a("#"+d).hide()}var e=a("#"+b[a(this).attr("id")]);e.slideDown(400).effect("highlight",700)}}(jQuery),jQuery(window).load(function(){jQuery("#rttheme_portfolio_post_format input:checked").length>0?jQuery("#rttheme_portfolio_post_format input:checked").rt_portfolio_formats():jQuery("#rttheme_portfolio_post_format-1").attr("checked",!0).rt_portfolio_formats(),jQuery("#rttheme_portfolio_post_format").on("change",function(){jQuery("#rttheme_portfolio_post_format input:checked").rt_portfolio_formats()})}),function(a){if(a("body").hasClass("nav-menus-php")){var b=' 			<p class="rt-mega-menu description-wide"> 			<label>Multi-Column Menu 			<input class="rt-multi-column-menu widefat code" type="checkbox"></label></p> 		',c=' 			<p class="rt-mega-menu description-wide"> 			<label>Multi-Column Menu 			<input class="rt-multi-column-menu widefat code" checked type="checkbox"></label></p> 		',d=' 			<p class="rt-mega-menu description-wide hidden-field column-item-size"> 			<label>Column Item Size 			<input class="rt-multi-column-item-size widefat code" value="column-item-size-value" type="text" /></label></p> 		';a(".menu-item-settings").each(function(){if(classNames=a(this).find(".edit-menu-item-classes").val(),classNames.search(/multicolumn-/i)>-1){for(a(this).find(".field-move").before(c),classNames_split=classNames.split(" "),stored_column_count="",i=0;i<classNames_split.length;i++)classNames_split[i].search(/multicolumn-/i)>-1&&(stored_column_count_array=classNames_split[i].split("-"),stored_column_count=stored_column_count_array[stored_column_count_array.length-1]);a(this).find(".field-move").before(d.replace(/column-item-size-value/i,stored_column_count).replace(/hidden-field/i,""))}else a(this).find(".field-move").before(b),a(this).find(".field-move").before(d.replace(/column-item-size-value/i,"3"))}),a(".submit-add-to-menu").on("click",function(){a(document).ajaxStop(function(){a(".menu-item.pending").each(function(){a(this).find(".rt-multi-column-menu").length<1&&(a(this).find(".field-move").before(b),a(this).find(".field-move").before(d.replace(/column-item-size-value/i,"3")))})})}),a(document.body).on("click",".rt-multi-column-menu",function(){var b=a(this).parents(".menu-item-settings").find(".edit-menu-item-classes"),c=b.val(),d=a(this).parents(".rt-mega-menu:eq(0)").next(".rt-mega-menu"),e=d.find(".rt-multi-column-item-size");if(a(this).attr("checked"))b.val(a.trim(c)+" multicolumn-"+e.val()),d.removeClass("hidden-field");else{var f=c.split(" "),g="";for(i=0;i<f.length;i++)g+=f[i].search(/multicolumn-/i)>-1?"":f[i];d.addClass("hidden-field"),b.val(a.trim(g))}}),a(document.body).on("keyup mouseleave",".rt-multi-column-item-size",function(){var b=a(this).parents(".menu-item-settings").find(".edit-menu-item-classes"),c=b.val(),d="";for(classNames_split=c.split(" "),i=0;i<classNames_split.length;i++)d+=classNames_split[i].search(/multicolumn-/i)>-1?" multicolumn-"+a(this).val():" "+classNames_split[i];b.val(a.trim(d))})}}(jQuery),function(a){a("#rt-demo-parts").on("change",function(){"all"==a("option:selected",a(this)).val()||"contents"==a("option:selected",a(this)).val()?a("#rt_demo_import_settings td.builder").show().effect("highlight",500):a("#rt_demo_import_settings td.builder").hide()}),a("#rt-demo-import-button").on("click",function(b){function c(b,d,e,f){k.text(d+"/10"),a.ajax({type:"GET",url:b,data:{action:"demo_import",demo:e,part:"contents",step:d},success:function(g){return g.indexOf("{{importer_error}}")>=0?(alert("Import process cancelled, click to the logs link to see the errors."),f.find(".logs").append(g.replace("{{importer_error}}","")),f.removeClass("importing").addClass("import-failed"),a(window).trigger("rt_contents_imported").off("rt_contents_imported"),!1):(f.find(".logs").append(g),10>d&&c(b,d+1,e,f),void(10==d&&(f.removeClass("importing").addClass("imported"),a(window).trigger("rt_contents_imported").off("rt_contents_imported"))))},error:function(a,b,c){console.log(c)}})}b.preventDefault();var d=(a(this),a(this).parents("form:eq(0)"),a("option:selected",a("#rt-demo")).val()),e=a("option:selected",a("#rt-demo-parts")).val(),f=a("#contents-result"),g=a("#widgets-result"),h=a("#options-result"),i=a('#rt-demo-parts option[value="revslider"]').data("active"),j=a("#revslider-result"),k=f.find("strong");if(""==e)return alert(rtframework_params.select_parts),void a("#rt-demo-parts").effect("highlight",3e3);if(a("#rt-demo").length>0&&""==d)return alert(rtframework_params.select_demo),void a("#rt-demo").effect("highlight",3e3);if("revslider"==e&&!i)return void alert(rtframework_params.install_revslider);if("all"==e||"contents"==e){if(f.hasClass("importing"))return void alert(rtframework_params.wait_previous_install);f.show(),f.removeClass("imported import-failed").addClass("importing"),f.find(".logs").text(""),c(ajaxurl,1,d,f)}if("all"==e||"widgets"==e){if(g.hasClass("importing"))return void alert(rtframework_params.wait_previous_install);g.show(),g.removeClass("imported import-failed").addClass("importing"),g.find(".logs").text(""),a(window).on("rt_contents_imported",function(){a.ajax({type:"GET",url:ajaxurl,data:{action:"demo_import",demo:d,part:"widgets"},success:function(a){return a.indexOf("{{importer_error}}")>=0?(alert("Import process cancelled, click to the logs link to see the errors. "),g.find(".logs").append(a.replace("{{importer_error}}","")),g.removeClass("importing").addClass("import-failed"),!1):(g.removeClass("importing").addClass("imported"),void g.find(".logs").append(a))},error:function(a,b,c){console.log(c)}})}),"widgets"==e&&a(window).trigger("rt_contents_imported").off("rt_contents_imported")}if("all"==e||"options"==e){if(h.hasClass("importing"))return void alert(rtframework_params.wait_previous_install);h.show(),h.removeClass("imported import-failed").addClass("importing"),h.find(".logs").text(""),a(window).on("rt_contents_imported",function(){a.ajax({type:"GET",url:ajaxurl,data:{action:"demo_import",demo:d,part:"options"},success:function(a){return a.indexOf("{{importer_error}}")>=0?(alert("Import process cancelled, click to the logs link to see the errors. "),h.find(".logs").append(a.replace("{{importer_error}}","")),h.removeClass("importing").addClass("import-failed"),!1):(h.removeClass("importing").addClass("imported"),void h.find(".logs").append(a))},error:function(a,b,c){console.log(c)}})}),"options"==e&&a(window).trigger("rt_contents_imported").off("rt_contents_imported")}if(i&&("all"==e||"revslider"==e)){if(j.hasClass("importing"))return void alert(rtframework_params.wait_previous_install);j.show(),j.removeClass("imported import-failed").addClass("importing"),j.find(".logs").text(""),a(window).on("rt_contents_imported",function(){a.ajax({type:"GET",url:ajaxurl,data:{action:"demo_import",demo:d,part:"revslider"},success:function(a){return a.indexOf("{{importer_error}}")>=0?(alert("Import process cancelled, click to the logs link to see the errors. "),j.find(".logs").append(a.replace("{{importer_error}}","")),j.removeClass("importing").addClass("import-failed"),!1):(j.removeClass("importing").addClass("imported"),void j.find(".logs").append(a))},error:function(a,b,c){console.log(c)}})}),"revslider"==e&&a(window).trigger("rt_contents_imported").off("rt_contents_imported")}}),a("#rt_demo_import_settings .see_logs").on("click",function(b){b.preventDefault(),a(this).parents("div:eq(0)").find(".logs").show()}),a("#rt-demo").on("change",function(){var b=a(".demo-image"),c=b.data("base_url"),d=a("option:selected",a(this)).val();""==d?b.hide():b.attr("src",c+"/images/skins/"+d+".png").show()}),a.fn.rt_tabs||(a.fn.rt_tabs=function(){a(this).each(function(){function b(){f.each(function(){a(this).removeClass("active")}),e.each(function(){a(this).removeClass("active")})}function c(b){var c=d.find('[data-tab-number="'+b+'"]'),e=a("#"+b);c.addClass("active"),e.addClass("active")}{var d=a(this),e=(a(this).find("> .tab_nav"),a(this).find("> .tab_nav > li")),f=(a(this).find("> .tab_contents > .tab_content_wrapper > .tab_title"),a(this).find("> .tab_contents > .tab_content_wrapper"));a(this).attr("data-tab-position")}e.click(function(){b(),c(a(this).attr("data-tab-number"))})}),a(this).find(".tab_nav > li:eq(0)").trigger("click")}),a.fn.rt_tabs&&a(".rt_tabs").rt_tabs(),a("#reset-design-options").on("click",function(b){b.preventDefault();var c=confirm(rtframework_variables.reset_design_options);if(c){var d=a("#rttheme_design_tabs");d.find("input:text, input:password, input:file, textarea").val(""),d.find("input:radio, input:checkbox").removeAttr("checked").removeAttr("selected");var e=d.find("select");e.val([]);var f=d.find("select:not(.multiple)");f.find("option:first").attr("selected","selected"),e.trigger("change")}}),a("#rttheme_design_options_display_topbar").on("change select",function(){var b=a('#rttheme_design_tabs [data-tab-number="rttheme-topbar"]');return"false"==a("option:selected",this).val()?void b.addClass("dashicons-before dashicons-hidden"):void b.removeClass("dashicons-before dashicons-hidden")}),a("#rttheme_design_options_display_topbar").trigger("change"),a("#rttheme_design_options_display_header").on("change select",function(){var b=a('#rttheme_design_tabs [data-tab-number="rttheme-header"]');return"false"==a("option:selected",this).val()?void b.addClass("dashicons-before dashicons-hidden"):void b.removeClass("dashicons-before dashicons-hidden")}),a("#rttheme_design_options_display_header").trigger("change"),a("#rttheme_design_options_hide_sub_header").on("change select",function(){var b=a('#rttheme_design_tabs [data-tab-number="rttheme-subheader"]');return a(this).is(":checked")?void b.addClass("dashicons-before dashicons-hidden"):void b.removeClass("dashicons-before dashicons-hidden")}),a("#rttheme_design_options_hide_sub_header").trigger("change"),a("#rttheme_design_options_display_footer").on("change select",function(){var b=a('#rttheme_design_tabs [data-tab-number="rttheme-footer"]');return"false"==a("option:selected",this).val()?void b.addClass("dashicons-before dashicons-hidden"):void b.removeClass("dashicons-before dashicons-hidden")}),a("#rttheme_design_options_display_footer").trigger("change"),a("#rttheme_design_options_sidebar_position").on("change select",function(){var b=a('#rttheme_design_tabs [data-tab-number="rttheme-sidebar"]');return"fullwidth"==a("option:selected",this).val()?void b.addClass("dashicons-before dashicons-hidden"):void b.removeClass("dashicons-before dashicons-hidden")}),a("#rttheme_design_options_sidebar_position").trigger("change")}(jQuery);