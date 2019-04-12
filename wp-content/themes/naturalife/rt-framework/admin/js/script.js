/*!
 * naturalife WordPress Theme Admin Scripts
 * Copyright (C) RT-Themes
 * http://rtthemes.com
 *
 * Various scripts for admin UI Only 
 */


/*
*
*	CLOSE MODAL WINDOW
* 
*/	
jQuery(function($){
	$(document.body).on("click",'.rt_modal_close',function(){
		$(this).parents(".rt_modal:eq(0)").css({"display":"none"});
	});
});

/*
*
* 	RT-THEME RESET SETTINGS
* 	
*/	
jQuery(function($){

	$("#rt_theme_reset_settings input").on("click",function(e){ 
			save_control_confirm = confirm( rtframework_variables.reset_theme );

			if( ! save_control_confirm ){ 
		  		return false; 
			}

	});
});

/*
*
*	FORCE WP-CUSTOMIZER SAVE BUTTON REFRESH THE FRAME 
*	after save & publish
*
*/	
jQuery(function($){

	$("#customize-controls #save").on("click",function(){ 
		wp.customize.previewer.refresh() 
	}); 
});

/*
*
*	DEPENDENCIES
*
*/	
jQuery(function($){

	$("[data-depends-id]").each(function() {

		var customizer = false;
		var holder = $(this);
		var theSelectBox = $("#"+holder.attr("data-depends-id"));
		var array = $.makeArray(holder.attr("data-depends-values").split(","));		

		//customizer
		if ( theSelectBox.length == 0 ) {
			theSelectBox =  $("[data-customize-setting-link='"+holder.attr("data-depends-id")+"']");
			holder = $(this).parents(".customize-control:eq(0)");
			var customizer = true;
		}

		theSelectBox.on("change",function(e,load){
			
			var selectedValue = $('option:selected', this).val();
			
 			if( $.inArray( selectedValue, array ) >= 0 ){

				if( load ){
					holder.show();
				}else{
					holder.show().effect("highlight", 700);
				}

			}else{
				holder.hide(); 
			}

		});

		theSelectBox.trigger("change","load");
	});
});

/*
*
*	SHOW HIDE HELP TEXTS
*
*/	

jQuery(function($){
	$(document.body).on('click', '.tooltip_icon', function(event) { 
		var help_text= $(this).parents('.table-row:eq(0)').find(".desc:eq(0)"); 
		help_text.slideToggle('fast').toggleClass("active");
 		
 		$(this).toggleClass("clicked");
	});
});

/*
*
*    FOCUS WIDGETS SECTION
*
*/	
jQuery(function($){ 
	$(".rt-focus-widgets").on("click",function( e ){
		e.preventDefault();
  		wp.customize.panel( 'widgets' ).focus();
		return false;
	});  	
});

/*
*
*	SHORTCODE HELPER
*
*/	

jQuery(function($){  

	function rt_shortcode_helper( event ) { 

 			if ( $("#rttheme_shortcode_helper").length == 0 ){

				$('<div class="rt_loading_bar"></div>').appendTo("body");//create loading bar
				data = 'action=my_action&shortcode_helper=true';
				$.post(ajaxurl, data, function(response) {			   
						$('.rt_loading_bar').remove();  
						$(response).appendTo("body").fadeIn(500);   
						start_helper();
				});	

			}else{
				$( "#rttheme_shortcode_helper").show('fade', { duration: 300, easing: 'swing' });
			}

			function start_helper(){


					//start tabs
					$( "#rttheme_shortcode_helper .rt_tabs" ).rt_tabs();

					//scroll top on tab clik
					$( "#rttheme_shortcode_helper .tab_nav > li" ).on('click', function() { 
						console.log("asdas");
						$( ".modal_content").stop().animate({ scrollTop: 0 }, 300);
					});

					//open the modal	 
					$( "#rttheme_shortcode_helper").show('fade', { duration: 300, easing: 'swing' });
					
					//scroll fix
					$('.tab_contents, .tab_nav').scrollTop(0);

					//make insert buttons visible if there is an active editor
					if( "undefined" != typeof tinyMCE ){ 


						if( null != window.tinyMCE.activeEditor ){  


							if( "" != window.tinyMCE.activeEditor.editorId && "rt_hidden_rich_editor" != window.tinyMCE.activeEditor.editorId ){  			
								$( "#rttheme_shortcode_helper .insert_to_editor").css({display:"block"});
							}else{
								$( "#rttheme_shortcode_helper .insert_to_editor").css({display:"none"});
							}
						}

					}else{
						$( "#rttheme_shortcode_helper .insert_to_editor").css({display:"none"});
					} 


					//insert to editor
					$( ".insert_to_editor" ).on('click', function() { 
						
				 		//the shortcode
				 		var shortcode = $(this).prev("textarea").val();
				 		var new_shortcode = "";

				 		console.log($(this));
				 		console.log( $(this).prev("textarea"));
				 		console.log(shortcode);


				 		if( $( "#" + tinymce.activeEditor.id ).parents("#wp-content-wrap").hasClass("html-active") === false ){//check if html tab is not active
							// replace new lines with <br /> if the line ends with a bracket ]
							
							var shortcode_lines = shortcode.split(/\n/);
							for (i = 0, l = shortcode_lines.length; i < l; i++ ) {
								
								new_shortcode = new_shortcode + shortcode_lines[i];
								this_line = $.trim(	shortcode_lines[i] );
								this_last_char = this_line.substr(this_line.length - 1);

								if ( this_last_char != ">" ){
									new_shortcode = new_shortcode + "<br />"
								}
							}

						}else{
							new_shortcode = shortcode;
						}
				 
						wp.media.editor.insert(new_shortcode); 
						
						$( "#rttheme_shortcode_helper .rt_modal_close" ).trigger("click");

					});

					//add editor shortcut button
					if( "undefined" !=typeof tinymce ){  
					
						if( "undefined" !=typeof tinymce.create ){ 
							tinymce.create('tinymce.plugins.rt_theme_shortcodes', {
								init : function(ed, url) {

									ed.addButton('rt_themeshortcode', {
										title : 'Theme Shortcodes',
										image : url+'/../images/theme-shorcodes.png', 
										onclick : function() {
												jQuery( "#wp-admin-bar-rt_shortcode_helper_button" ).trigger("click");
										}
									});				
								},
								createControl : function(n, cm) {
									return null;
								},
								getInfo : function() {
									return {
										longname : "Shortcodes",
										author : 'RT-Theme',
										version : "1.0"
									};
								}
							});
							tinymce.PluginManager.add('rt_themeshortcode', tinymce.plugins.rt_theme_shortcodes);
						}
					}	

					//add editor shortcut button
					//scroll top on tab clik
					$( ".rt_clean_copy" ).on('click', function() { 

						if( $(this).hasClass("clicked") ){
							return ;
						}

						var the_text = $(this).html();
						var text_field = $('<input type="text" value="'+the_text+'" style="width:100px;">');

						$(this).html("");
						$(this).addClass( "clicked" );
						text_field.appendTo( $(this) );

						text_field.select();

				 
					});
			}

	} 
 
	$("#wp-admin-bar-rt_shortcode_helper_button").on('click', { purpose: "admin_bar" }, rt_shortcode_helper ) ;


	$(window).on("rt_theme_shortcodes",function(){
		rt_shortcode_helper();
	});
});

/*
*
*	ADMIN TOOL-TIPS
*
*/	

jQuery(function($){

	$(".style_parts > div").on('mouseenter mouseleave', function(event) { 
		var tooltip_text= $(this).attr('data-desc'); 
		var tooltip_div  = $('<div class="rt_tooltip_message">'+ tooltip_text +'</div>');
		$(".rt_tooltip_message").remove();

		if(event.type == "mouseenter"){
			$("body").append(tooltip_div);
			tooltip_div.css({"top":$(this).offset().top - ( tooltip_div.height() / 2 ) ,"left":$(this).offset().left-240});
		}
		 		
	});
});

/*
*
*	START PLUGINS FOR AJAX LOADED ELEMENTS
*
*/	
(function($){
	$.fn.start_scripts = function(container,randomClass,purpose) {
 
		//multi selection script
		if(randomClass) randomClass = "."+randomClass;

		$(container).find(".multiple"+randomClass).asmSelect({
			addItemTarget	: 'bottom',
			animate			: true,
			highlight		: true,
			sortable       : true,
			removeLabel		:'x'
		});	  

		//range inputs
		$(container).find(".range"+randomClass).rangeinput();  
		
		//hidden options
	 	$(container).find(".div_controller").trigger("change");
 
		$(container).find(".color_field input").each(function(){

			if( $(this).hasClass("hidden_slide_item") == false ){
				$(this).spectrum({ 
					flat: false,
					showInput: true,
					showButtons: false,
					showAlpha: true, 
					move: function(color) {
 						 
 						var value; 
						if( color.getAlpha() < 1 ){
							value = color.toRgbString();
						}else{
							value = color.toHexString();
						}
 						
 						$(this).val( value );
 						$(this).attr("value", value );
 

					},

					change: function(color) { 
						
 						var value; 
						if( color.getAlpha() < 1 ){
							value = color.toRgbString();
						}else{
							value = color.toHexString();
						}
 						
 						$(this).val( value );
 						$(this).attr("value", value );

					},

					hide: function(color) {

						if ( $(this).val() == "" &&  color.toHexString() == "#ffffff" ){

	 						var value; 
							if( color.getAlpha() < 1 ){
								value = color.toRgbString();
							}else{
								value = color.toHexString();
							}
	 						
	 						$(this).val( value );
	 						$(this).attr("value", value );

						}
					}					
				}); 


				$(this).show(function(){
					if( $(this).val() == "" ){
						$(this).spectrum("set", "#ffffff" );
						$(this).attr("value", "" );
					}
				});				
			}
	    }); 
	}; 

	$.fn.start_scripts(".rt-metaboxes, .widgets-holder-wrap","","page_load");
})(jQuery);

/*
*
*	UPLOAD MEDIA
*
*/	
(function($){
	

	$(document).on('click', '.rttheme_upload_button', function(e) { 

		var url_field = $(this).prev(); 
			this_image_holder = $('[data-holderid="'+ $(this).data("inputid") +'"]');   	

			e.preventDefault();

			//If the uploader object has already been created, reopen the dialog
			if (custom_uploader) {
				custom_uploader.open();
				return;
			}

			//Extend the wp.media object
			var custom_uploader = wp.media.frames.file_frame = wp.media({
				title: wp.media.view.l10n.addMedia, 
				multiple: false
			});

			//When a file is selected, grab the URL and set it as the text field's value
			custom_uploader.on('select', function() {
				var attachment = custom_uploader.state().get('selection').first().toJSON(); 

					url_field.val(attachment.url).trigger("change");  

					if( attachment.type != "image" ){
						this_image_holder.find("img").attr("src","");  
						this_image_holder.removeClass("visible"); 											
					}	

			});

			//Open the uploader dialog
			custom_uploader.open(); 

	}); 		


	$(document).on('keyup change', '.upload_field', function() {

		var url_field = $(this),  
			this_image_holder = $('[data-holderid="'+ $(this).prop("id") +'"]');  

			if( url_field.val() ){
				this_image_holder.find("img").attr("src",url_field.val() );  
				this_image_holder.addClass("visible"); 						
			}else{
				this_image_holder.find("img").attr("src","");  
				this_image_holder.removeClass("visible"); 											
			}			 	

		return ;
		
	});


	//delete
	$(document).on('click', '.uploaded_file .delete_single', function() {  
		var url_field = $('#'+ $(this).data("inputid") +'');
		url_field.val("").trigger("keyup");   
	});         

	//auto select
	$('.upload_field').focus(function() {
		$(this).select();
	});	 
})(jQuery);

/*
*
*	UPLOAD MULTIPLE IMAGES
*
*/	
(function($){
	$(document).on('click', '.rt_gallery_add_button', function(e) { 

		var custom_uploader;
		var $this = $(this);

			e.preventDefault();

			//If the uploader object has already been created, reopen the dialog
			if (custom_uploader) {
				custom_uploader.open();
				return;
			}

			//Extend the wp.media object
			custom_uploader = wp.media.frames.file_frame = wp.media({
				title: wp.media.view.l10n.addMedia, 
				multiple: true
			});


			//When a file is selected, grab the URL and set it as the text field's value
			custom_uploader.on('select', function() {
				
				var selection = custom_uploader.state().get('selection');
				var list = $("#rt-gallery-images");
				var list_value = list.val();
				var list_array = list_value == "" ? new Array() : list_value.split(",");									 				  

				selection.map( function( attachment ) {
					 
					attachment = attachment.toJSON(); 
									
					if( list_array.length == 0 || $.inArray( attachment.id.toString(), list_array ) === -1  ){
						$(".rt-gallery-uploaded-photos").append('<li><img src="'+attachment.sizes.thumbnail.url+'" data-rel="'+attachment.id+'"></li>');
						list_array.push(attachment.id);
						list.val( list_array.join(",") );
					}

				});

			}); 


			//open - update
			custom_uploader.on('open',function() {
			  var selection = custom_uploader.state().get('selection');

				if( jQuery('#rt-gallery-images').val() == "" ){
					return false;
				}

				ids = jQuery('#rt-gallery-images').val().split(',');

				ids.forEach(function(id) {
					attachment = wp.media.attachment(id);
					attachment.fetch();
					selection.add( attachment ? [ attachment ] : [] );
				});

			});

			//Open the uploader dialog
			custom_uploader.open(); 
	}); 		 
})(jQuery);

/*
*
*	UPLOAD MEDIA FOR ID 
*
*/	
(function($){
	
	$(document).on('click', '.rttheme_image_upload_button', function(e) { 

		var url_field = $(this).prev(),
			this_image_holder = $('[data-holderid="'+ $(this).data("inputid") +'"]'),
			file_name_layer = $(this).next(".display_file_name");

			e.preventDefault();

			//If the uploader object has already been created, reopen the dialog
			if (custom_uploader) {
				custom_uploader.open();
				return;
			}

			//Extend the wp.media object
			var custom_uploader = wp.media.frames.downloadable_file = wp.media({
				title: wp.media.view.l10n.addMedia, 
				multiple: false
			});

			//When a file is selected, grab the URL and set it as the text field's value
			custom_uploader.on('select', function() {
				var attachment = custom_uploader.state().get('selection').first().toJSON(); 

				url_field.val(attachment.id);

				if( attachment.type == "image" ){
					this_image_holder.find("img").attr("src",attachment.sizes.thumbnail.url);  
					this_image_holder.addClass("visible"); 						
				}else{
					this_image_holder.find("img").attr("src","");  
					this_image_holder.removeClass("visible"); 		
					file_name_layer.html(attachment.filename);									
				}

			});

			//Open the uploader dialog
			custom_uploader.open(); 

	}); 		
})(jQuery);

/*
*
*	FEATTURED IMAGE GALLERY
*
*/	
(function($){ 
 
		//start sortables
		$("ul.rt-gallery-uploaded-photos").sortable({handle:'img',forceHelperSize: true,  opacity: 0.5,scroll: true, scrollSpeed: 20, cursor: "move", distance: 10, placeholder : 'ui-sortable-placeholder', tolerance: 'pointer',

			start: function(e, ui){ 
				var item = ui.item;  

				ui.placeholder.width(ui.item.width()); 						 
				ui.placeholder.height(ui.item.height()); 						 
 
			},

			update: function(e, ui){ //save new order
  
				var list = $("#rt-gallery-images");
				var new_list = "";

				$(this).find("li").each(function(){

					var img_url = $(this).find("img").attr("data-rel") ;

					if ( new_list == "" ){
						new_list = img_url;	
					}else{
						new_list = new_list + "," + img_url;
					}
					
				});	

				list.val(new_list); 				
			},			

		}); 		 
 
 		//delete button
	 	$(document.body).on('mouseenter', '.rt-gallery-uploaded-photos li', function() { 
	 		var delete_image = '<div class="gallery_delete"></div>';
	 		var old_delete_image = $(this).find(".gallery_delete");
			
 
	 		if( old_delete_image.length ){
				old_delete_image.show();
	 			return false;	 			
	 		}else{
	 			$(this).append(delete_image);
	 		}			

		});


	 	$(document.body).on('mouseleave', '.rt-gallery-uploaded-photos li', function() { 
 			$(this).find(".gallery_delete").hide();
		});
 

		//delete an image
	 	$(document.body).on('click', '.rt-gallery-uploaded-photos li .gallery_delete', function() { 

			var confirm_message = confirm(rtframework_variables.delete_image);		
			var $this = $(this) ;

	 			var list = $("#rt-gallery-images");
	 			var list_array = list.val().split(",");
	 			var this_image_holder = $this.parent("li");
	 			var item_to_delete = this_image_holder.find("img:eq(0)").attr("data-rel");
	 			 
 					if(confirm_message){

						//delete the url from the input
						list_array = jQuery.grep(list_array, function(value) {
						  return value != item_to_delete;
						});

						//update the list
						var new_list = list_array.join();
						list.val(new_list);

						//remove the holder		 			  
						$this.parent("li").remove();
						return true;
					}					   

			return false;    

		});
})(jQuery);
 		 

/*
*
*	SHOW / HIDE HIDDEN OPTIONS
*
*/	
(function($){

	$(document).on('change', '.div_controller' ,function() { 

		var selected_option = $('option:selected', this).val();
		var options_set = $(this).parents(".options_set_holder:eq(0)").find(".hidden_options_set:eq(0)");

		if( selected_option === "new" || selected_option === "boxed-body" || selected_option === "half-boxed" || selected_option === "disabled_parallax" ){
			options_set.slideDown("fast");
		}else{
			options_set.slideUp("fast");
		}
	});
 
	$(".div_controller").trigger("change");
})(jQuery);

/*
*
*	ICON SELECTION FOR THEME OPTIONS
*
*/	
jQuery(function($){  

	$(document.body).on('keyup', '#rt_icon_search', function() {  
		// Retrieve the input field text and reset the count to zero
		var filter = $(this).val(), count = 0;

		// Loop through the comment list
		$(".list-icons li").each(function(){

			// If the list item does not contain the text phrase fade it out
			if ($(this).find("span").text().search(new RegExp(filter, "i")) < 0) {
				$(this).fadeOut();

			// Show the list item if the phrase matches and increase the count by 1
			} else {
				$(this).show();
				count++;
			}
		});

		// Update the count
		var numberItems = count;
		$("#rt_icon_search_result").text(count + " icons found");
	});

	function rt_icon_selection( event ) { 
 
	  	purpose = event.data.purpose;
	  	thisField = $(event.target); 
		iconSelector = $(".icon-selection");

		if( purpose == "item" ){ 
			$(".icon-selection").removeClass("admin_bar"); 
		}else{ 
			$(".icon-selection").addClass("admin_bar"); 
		}

		if (iconSelector.length == 0){ 
 
			$('<div class="rt_loading_bar"></div>').appendTo("body");//create loading bar

			data = 'action=my_action&iconSelector=true';
			$.post(ajaxurl, data, function(response) {			   
				$('.rt_loading_bar').remove();  

					if( purpose == "item" ){
						$(response).appendTo("body").fadeIn(500);  
						$(".icon-selection .blank").show();
					}else{
						$(response).addClass("admin_bar").appendTo("body").fadeIn(500); 
						$(".icon-selection .blank").hide();
					} ;

			});		
		} else{
			$(iconSelector).fadeIn(500);  

			if( purpose == "item" ){ 
				$(".icon-selection .blank").show();
			}else{ 
				$(".icon-selection .blank").hide();
			}			
		}	


		$(document.body).on('click', '.icon_selection_close', function() {  	
			$(".icon-selection").hide();
			thisField.focus();
		}); 


		$(document.body).on('click', '.list-icons li', function() {  

			if( purpose == "item" ){
				var selectted_icon_name = $.trim($(this).attr('class')); 
				var thisField 	= $(event.target); 
				var thisFieldVal  = $(thisField).val();

				var classNames = thisFieldVal.split(" ");
				var newclassNames = "";
				var jump = 1;

 
				for (i = 0; i < classNames.length; i++ ) { 

						if( classNames[i].search(/icon-/i) == 0 && selectted_icon_name == "blank" ) { //found & deleted
							newclassNames += "";  
						}else if( classNames[i].search(/icon-/i) == 0 && selectted_icon_name != "blank" && jump == 1) { //found & replaced
							newclassNames += selectted_icon_name;	 
							jump = jump+1; 

						}else if( classNames[i].search(/icon-/i) < 0 && selectted_icon_name != "blank" && jump == 1) { // not found & added
							newclassNames += " " + classNames[i] + " " + selectted_icon_name;	 

							jump = jump+1;		
						}else{
							newclassNames += " " + classNames[i]; 	
						}

				}
				$(thisField).focus(); 
				$(thisField).val( $.trim(newclassNames) );  
			 	$(thisField).change();   

				$(".icon-selection").hide(); 

				$(document.body).off('click', '.list-icons li');
			}

		});


	} 
 
	$(document.body).on('click', '.button_icon,.button2_icon,.icon_name,.icon_selection,.edit-menu-item-classes,[data-setting="rt-icon-name"]', { purpose: "item" }, rt_icon_selection ) ;
	$("#wp-admin-bar-rt_icons .ab-item div").on('click', { purpose: "admin_bar" }, rt_icon_selection ) ;
});

/*
*
*	START MULTIPLE SELECTION FOR WIDGETS
*
*/	
jQuery(document).ajaxSuccess(function(e, xhr, settings) {
	var widget_id_base 		= 'latest_posts';   // latest posts plugin
	var widget_id_base_2 	= 'popular_posts';   // popular posts plugin
	var widget_id_base_3 	= 'recent_posts_gallery';   // recent posts gallery plugin
	var widget_id_base_4 	= 'rt_products';   // products plugin

	if(settings.data) {    			
		if(typeof settings.data.search == 'function') {    
			if (settings.data){
				if(settings.data.search('action=save-widget') != -1 && ( settings.data.search('id_base=' + widget_id_base) != -1 || settings.data.search('id_base=' + widget_id_base_2) != -1  || settings.data.search('id_base=' + widget_id_base_3) != -1  || settings.data.search('id_base=' + widget_id_base_4) != -1 ) ) {
					var str 			= settings.data;
					var substr   		= str.split('widget-id=');
					var substr_2 		= substr[1].split('&id_base');
					var thisWidtedID 	= substr_2[0];
					
					jQuery("select[multiple]#widget-"+thisWidtedID+"-categories").asmSelect({
						addItemTarget	: 'bottom',
						animate		: true,
						highlight		: true,
						removeLabel	:'x'
					});
				}
			}
		}
	}
});

/*
*
*	GET URL PARAMATERS BY NAME
*
*/	
function getParameterByName(name) {
	name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
	var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
		results = regex.exec(location.search);
	return results == null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}

/*
*
*	CUSTOM FONTS 
*
*/	
(function($){

	//delete a font
	$(document).on('click', '#rt_theme_custom_fonts .delete-font' ,function() { 

  		var form = $("#rt_theme_custom_fonts form");

			 delete_font_confirm = confirm( rtframework_variables.delete_font );

		if( ! delete_font_confirm ){ 
			return false; 
		}else{
			$(this).parents(".font-holder:eq(0)").remove();
		}

	});
 
 	//show hide form options
	$.fn.custom_font_forms = function()
	{ 	

		$(this).each(function(){

			var $this = $(this);

			$(this).on("change",function(){

				var this_font_table = $this.parents(".form-table:eq(0)"); 

				if( $('option:selected', this).val() == "typekit" ){
					this_font_table.find(".kitid").show();
					this_font_table.find(".self_hosted_font").hide();

				}else{
					this_font_table.find(".kitid").hide();
					this_font_table.find(".self_hosted_font").show();
				}


				if( $('option:selected', this).val() == "self-hosted" ){ 
					this_font_table.find(".self_hosted_font").show();

				}else{ 
					this_font_table.find(".self_hosted_font").hide();
				}				


			});

			$(window).load(function() { 
				$this.trigger("change");
			});


		});
	};


	$("#rt_theme_custom_fonts form .rt-font-type").custom_font_forms();	
})(jQuery);

/*
*
*	POST FORMATS
*
*/	
jQuery(document).ready(function() {  

	jQuery.fn.extend({
		ShowPostFormats: function () {
			  
			$this = jQuery(this);
			var theSelectedFormat  = $this.attr("id");

			//post formats / option pairs
			var post_formats = {};
			post_formats['post-format-0'] = "#rt_standart_post_custom_fields";
			post_formats['post-format-gallery'] = "#rt_gallery_post_custom_fields";
			post_formats['post-format-link'] = "#rt_link_post_custom_fields";
			post_formats['post-format-video'] = "#rt_video_post_custom_fields";
			post_formats['post-format-audio'] = "#rt_audio_post_custom_fields";
	
				for (var key in post_formats) {
					if( key !== "post-format-0" ){
						jQuery(post_formats[key]).css({"display":"none"});
					}
				}
	
			jQuery(post_formats[theSelectedFormat]).show().effect("highlight", 700);
	 
		}
	});

	jQuery("#post-formats-select input:checked").ShowPostFormats();
	
		jQuery("#post-formats-select").on("change", function(event){
			jQuery("#post-formats-select input:checked").ShowPostFormats();
		});
});

/*
*
*	PORFOLIO POST FORMATS
*
*/	
(function($){
	$.fn.rt_portfolio_formats= function() { 
		var groups = {
					"rttheme_portfolio_post_format-1": "rttheme_image_format_options",
					"rttheme_portfolio_post_format-2": "rttheme_video_format_options",
					"rttheme_portfolio_post_format-3": "rttheme_audio_format_options"
				};

		//hide all options
		for (var key in groups) {
			var value = groups[key]; 
			$("#"+value).hide();
		}

		//show selected one
		var selectedContainerID = $("#"+groups[$(this).attr("id")]);
		selectedContainerID.slideDown(400).effect("highlight", 700);

	}; 	
})(jQuery);

jQuery(window).load(function() {  

	if (jQuery("#rttheme_portfolio_post_format input:checked").length>0){
		jQuery("#rttheme_portfolio_post_format input:checked").rt_portfolio_formats();
	}else{
		jQuery("#rttheme_portfolio_post_format-1").attr('checked',true).rt_portfolio_formats();
	}

	jQuery("#rttheme_portfolio_post_format").on("change", function(event){
		jQuery("#rttheme_portfolio_post_format input:checked").rt_portfolio_formats();
	});
});


/*
*
*	MULTI COLUMNS CHECKBOX FOR WP-MENUS
*
*/	
(function($){
	
 	if( $("body").hasClass("nav-menus-php") ){

		var form = (' \
			<p class="rt-mega-menu description-wide"> \
			<label>Multi-Column Menu \
			<input class="rt-multi-column-menu widefat code" type="checkbox"></label></p> \
		');

		var form_checked = (' \
			<p class="rt-mega-menu description-wide"> \
			<label>Multi-Column Menu \
			<input class="rt-multi-column-menu widefat code" checked type="checkbox"></label></p> \
		');

		var column_count = (' \
			<p class="rt-mega-menu description-wide hidden-field column-item-size"> \
			<label>Column Item Size \
			<input class="rt-multi-column-item-size widefat code" value="column-item-size-value" type="text" /></label></p> \
		');


		$(".menu-item-settings").each(function(){
			
			classNames = $(this).find(".edit-menu-item-classes").val();

			if( classNames.search(/multicolumn-/i) > -1 ){
				$(this).find(".field-move").before(form_checked);

				//find the stored column size 
				classNames_split = classNames.split(" ");
				stored_column_count = ""; 

				for (i = 0; i < classNames_split.length; i++ ) { 
					if( classNames_split[i].search(/multicolumn-/i) > -1 ){ 
						stored_column_count_array = classNames_split[i].split("-");
						stored_column_count = stored_column_count_array[stored_column_count_array.length-1];
					} 				
				}

				$(this).find(".field-move").before(column_count.replace(/column-item-size-value/i, stored_column_count).replace(/hidden-field/i, ""));  

			}else{
				$(this).find(".field-move").before(form);
				$(this).find(".field-move").before(column_count.replace(/column-item-size-value/i, "3")); 
			}

		}); 


		$('.submit-add-to-menu').on('click', function() {  
			$(document).ajaxStop(function() {

				$(".menu-item.pending").each(function(){
					if( $(this).find(".rt-multi-column-menu").length < 1 ){
						$(this).find(".field-move").before(form);
						$(this).find(".field-move").before(column_count.replace(/column-item-size-value/i, "3")); 
					} 
				});				

			});
		});

		$(document.body).on('click', '.rt-multi-column-menu', function() {   

			var css_field = $(this).parents(".menu-item-settings").find(".edit-menu-item-classes");
			var css_class_value = css_field.val();

			var column_count_holder = $(this).parents(".rt-mega-menu:eq(0)").next(".rt-mega-menu"); 
			var column_count = column_count_holder.find(".rt-multi-column-item-size");


			if( $(this).attr("checked") ){

				css_field.val( $.trim(css_class_value) + " multicolumn-" + column_count.val() ); 
				column_count_holder.removeClass("hidden-field");

			}else{
				var classNames = css_class_value.split(" ");
				var newclassNames = "";

				for (i = 0; i < classNames.length; i++ ) { 

					if( classNames[i].search(/multicolumn-/i) > -1 ) { //found & deleted
						newclassNames += "";
					}else{
						newclassNames += classNames[i];
					}

				}		
				column_count_holder.addClass("hidden-field");
				css_field.val( $.trim(newclassNames) );  
			} 

		});


		$(document.body).on('keyup mouseleave', '.rt-multi-column-item-size', function() {   
 
			var css_field = $(this).parents(".menu-item-settings").find(".edit-menu-item-classes");
			var css_class_value = css_field.val();
			var new_classNames = "";

			//find the stored column size from string  
			classNames_split = css_class_value.split(" "); 

			for (i = 0; i < classNames_split.length; i++ ) { 
				if( classNames_split[i].search(/multicolumn-/i) > -1 ){ 

					new_classNames += " " + "multicolumn-" + $(this).val();
				}else{

					new_classNames += " " + classNames_split[i];
				}
			}

			css_field.val($.trim(new_classNames));
		});		


 	}
})(jQuery);


/* ******************************************************************************* 

	DEMO IMPORT

********************************************************************************** */    
(function($){


	$("#rt-demo-parts").on("change",function(){
		 
		if( $('option:selected', $(this) ).val() == "all" || $('option:selected', $(this) ).val() == "contents" ){
			$("#rt_demo_import_settings td.builder").show().effect("highlight", 500);
		}else{
			$("#rt_demo_import_settings td.builder").hide();
		}

	});

	$("#rt-demo-import-button").on("click",function(e){

		e.preventDefault();	

		var button = $(this),
			 form = $(this).parents("form:eq(0)"),
			 selected_demo = $('option:selected', $("#rt-demo") ).val(),
			 selected_parts = $('option:selected', $("#rt-demo-parts") ).val(),
			 contents_result = $("#contents-result"),
			 widgets_result = $("#widgets-result"),
			 options_result = $("#options-result"), 
			 is_revslider_installed = $('#rt-demo-parts option[value="revslider"]').data("active"),
			 revslider_result = $("#revslider-result"),
			 steps = contents_result.find("strong");

			//select parts
			if( selected_parts == "" ){	
				alert( rtframework_params["select_parts"] );
				$("#rt-demo-parts").effect("highlight", 3000);
				return;		 
			}

			//select a dmeo
			if( $("#rt-demo").length > 0 && selected_demo == "" ){	
				alert( rtframework_params["select_demo"] );
				$("#rt-demo").effect("highlight", 3000);
				return;
			}

			//install revslider
			if( selected_parts == "revslider" && ! is_revslider_installed  ){
				alert( rtframework_params["install_revslider"] );
				return;	
			}

			//content import function
			function rt_content_import(ajaxurl,step,selected_demo,contents_result){

				steps.text(step +"/10");
				
				$.ajax({
					type: 'GET',
					url: ajaxurl,
					data : {
						'action': 'demo_import',
						'demo': selected_demo,
						'part': "contents",	 
						'step': step		
					},		
					success: function(response, textStatus, XMLHttpRequest){
						//error
						if (response.indexOf("{{importer_error}}") >= 0){
							alert("Import process cancelled, click to the logs link to see the errors.");
							contents_result.find(".logs").append( response.replace('{{importer_error}}', '') );
							contents_result.removeClass("importing").addClass("import-failed");
							$(window).trigger("rt_contents_imported").off('rt_contents_imported');
							return false;
						}

						//log
						contents_result.find(".logs").append( response );

						//no error next step
		 				if( step < 10 ){
		 					rt_content_import(ajaxurl,step+1,selected_demo,contents_result);
		 				}

		 				//last step
		 				if( step == 10 ){
		 					contents_result.removeClass("importing").addClass("imported");

		 					$(window).trigger("rt_contents_imported").off('rt_contents_imported');
		 				}
					},
					error: function( MLHttpRequest, textStatus, errorThrown ){
						console.log(errorThrown);
					}		
				});
			}

			//import contents 
			if( selected_parts == "all" || selected_parts == "contents" ){

				if( contents_result.hasClass("importing") ) {
					alert( rtframework_params["wait_previous_install"] );
					return;
				}

				contents_result.show();
				contents_result.removeClass("imported import-failed").addClass("importing");
				contents_result.find(".logs").text("");

				rt_content_import(ajaxurl,1,selected_demo,contents_result);																	
			}

			//import widgets 
			if( selected_parts == "all" || selected_parts == "widgets" ){

 				if( widgets_result.hasClass("importing") ) {
					alert( rtframework_params["wait_previous_install"] );
					return;
				}
	
				widgets_result.show();
				widgets_result.removeClass("imported import-failed").addClass("importing");
				widgets_result.find(".logs").text("");

				$(window).on('rt_contents_imported', function() {

					$.ajax({
						type: 'GET',
						url: ajaxurl,
						data : {
							'action': 'demo_import',
							'demo': selected_demo,
							'part': "widgets",			
						},		
						success: function(response, textStatus, XMLHttpRequest){

			 				//error
							if (response.indexOf("{{importer_error}}") >= 0){
								alert("Import process cancelled, click to the logs link to see the errors. ");
								widgets_result.find(".logs").append( response.replace('{{importer_error}}', '') );
								widgets_result.removeClass("importing").addClass("import-failed");
								return false;
							}

			 				widgets_result.removeClass("importing").addClass("imported");
			 				widgets_result.find(".logs").append( response );

						},
						error: function( MLHttpRequest, textStatus, errorThrown ){
							console.log(errorThrown);
						}		
					});

				});	

				if( selected_parts == "widgets" ) {
					$(window).trigger("rt_contents_imported").off('rt_contents_imported');
				}				
			}

			//import theme settings 
			if( selected_parts == "all" || selected_parts == "options" ){
 
 				if( options_result.hasClass("importing") ) {
					alert( rtframework_params["wait_previous_install"] );
					return;
				}

				options_result.show();
				options_result.removeClass("imported import-failed").addClass("importing");
				options_result.find(".logs").text("");

				$(window).on('rt_contents_imported', function() {

					$.ajax({
						type: 'GET',
						url: ajaxurl,
						data : {
							'action': 'demo_import',
							'demo': selected_demo,
							'part': "options",			
						},		
						success: function(response, textStatus, XMLHttpRequest){

			 				//error
							if (response.indexOf("{{importer_error}}") >= 0){
								alert("Import process cancelled, click to the logs link to see the errors. ");
								options_result.find(".logs").append( response.replace('{{importer_error}}', '') );
								options_result.removeClass("importing").addClass("import-failed");
								return false;
							}
																	
			 				options_result.removeClass("importing").addClass("imported");
			 				options_result.find(".logs").append( response );

						},
						error: function( MLHttpRequest, textStatus, errorThrown ){
							console.log(errorThrown);
						}		
					});
				});

				if( selected_parts == "options" ) {
					$(window).trigger("rt_contents_imported").off('rt_contents_imported');
				}

			}

			//import revslider samples 
			if( is_revslider_installed && ( selected_parts == "all" || selected_parts == "revslider" ) ){

 				if( revslider_result.hasClass("importing") ) {
					alert( rtframework_params["wait_previous_install"] );
					return;
				}

				revslider_result.show();
				revslider_result.removeClass("imported import-failed").addClass("importing");
				revslider_result.find(".logs").text("");

				$(window).on('rt_contents_imported', function() {

					$.ajax({
						type: 'GET',
						url: ajaxurl,
						data : {
							'action': 'demo_import',
							'demo': selected_demo,
							'part': "revslider",			
						},		
						success: function(response, textStatus, XMLHttpRequest){

			 				//error
							if (response.indexOf("{{importer_error}}") >= 0){
								alert("Import process cancelled, click to the logs link to see the errors. ");
								revslider_result.find(".logs").append( response.replace('{{importer_error}}', '') );
								revslider_result.removeClass("importing").addClass("import-failed");
								return false;
							}
																	
			 				revslider_result.removeClass("importing").addClass("imported");
			 				revslider_result.find(".logs").append( response );

						},
						error: function( MLHttpRequest, textStatus, errorThrown ){
							console.log(errorThrown);
						}		
					});
				});

				if( selected_parts == "revslider" ) {
					$(window).trigger("rt_contents_imported").off('rt_contents_imported');
				}

			}
	});


	$("#rt_demo_import_settings .see_logs").on("click",function(e){
			e.preventDefault();
			$(this).parents("div:eq(0)").find(".logs").show();
	});


	$("#rt-demo").on("change",function(e){

		var demo_image = $(".demo-image"),
			 demo_image_base_url = demo_image.data("base_url"),
			 demo = $('option:selected', $(this) ).val();

			if( demo == "" ){
				demo_image.hide();
			}else{
				demo_image.attr("src", demo_image_base_url + "/images/skins/"+ demo + ".png" ).show();
			}

	});


	/* *******************************************************************************

		TABS

	********************************************************************************** */

	if( ! $.fn.rt_tabs ){

		$.fn.rt_tabs = function()
		{

			$(this).each(function () {

				var tabs = $(this),
					tab_nav = $(this).find("> .tab_nav"),
					desktop_nav_element = $(this).find("> .tab_nav > li"),
					mobile_nav_element = $(this).find("> .tab_contents > .tab_content_wrapper > .tab_title"),
					tab_wrappers =  $(this).find("> .tab_contents > .tab_content_wrapper"),
					tab_style = $(this).attr("data-tab-position");

				//desktop nav clicks
				desktop_nav_element.click(function() {
					close_all();
					open_tab( $(this).attr("data-tab-number") );
				})

				//close all tabs
				function close_all(){
					tab_wrappers.each(function() {
						$(this).removeClass("active");
					});

					desktop_nav_element.each(function() {
						$(this).removeClass("active");
					});

				}

				//open a tab
				function open_tab( tab_number ){

					var nav_item = tabs.find('[data-tab-number="'+tab_number+'"]'),
						tab_content_wrapper = $('#'+tab_number);

						nav_item.addClass("active");
						tab_content_wrapper.addClass("active"); 
				}
			});

			$(this).find(".tab_nav > li:eq(0)").trigger("click");
		};
	}

	if ( $.fn.rt_tabs ) {
		$('.rt_tabs').rt_tabs();
	}


	/* *******************************************************************************

		RESET DESIGN OPTIONS

	********************************************************************************** */
	$('#reset-design-options').on("click", function(e){

		e.preventDefault();

		var confirm_message = confirm(rtframework_variables.reset_design_options);		
		if( ! confirm_message ){		
			return;
		}

		var design_options = $("#rttheme_design_tabs");
			design_options.find('input:text, input:password, input:file, textarea').val('');
			design_options.find('input:radio, input:checkbox').removeAttr('checked').removeAttr('selected');
	 
		var select = design_options.find("select");
		  	select.val([]);
		
		var select_single =  design_options.find("select:not(.multiple)");  

			select_single.find('option:first').attr("selected","selected");		
			select.trigger("change");

	});

	/* *******************************************************************************

		DESIGN OPTIONS ICONS

	********************************************************************************** */


 	//topbar visibility
	$("#rttheme_design_options_display_topbar").on("change select",function(){
		var tab = $('#rttheme_design_tabs [data-tab-number="rttheme-topbar"]');

		if( $('option:selected', this).val() == "false" ){
			tab.addClass("dashicons-before dashicons-hidden");
			return;
		}

		tab.removeClass("dashicons-before dashicons-hidden");
	});
	$("#rttheme_design_options_display_topbar").trigger("change");

 	//header visibility
	$("#rttheme_design_options_display_header").on("change select",function(){
		var tab = $('#rttheme_design_tabs [data-tab-number="rttheme-header"]');

		if( $('option:selected', this).val() == "false" ){
			tab.addClass("dashicons-before dashicons-hidden");
			return;
		}

		tab.removeClass("dashicons-before dashicons-hidden");
	});
	$("#rttheme_design_options_display_header").trigger("change");


	//sub header visibility
	$("#rttheme_design_options_hide_sub_header").on("change select",function(){

		var tab = $('#rttheme_design_tabs [data-tab-number="rttheme-subheader"]');

		if( $(this).is(":checked") ){
			tab.addClass("dashicons-before dashicons-hidden");
			return;
		}

		tab.removeClass("dashicons-before dashicons-hidden");
	});
	$("#rttheme_design_options_hide_sub_header").trigger("change");

 	//footer visibility
	$("#rttheme_design_options_display_footer").on("change select",function(){
		var tab = $('#rttheme_design_tabs [data-tab-number="rttheme-footer"]');

		if( $('option:selected', this).val() == "false" ){
			tab.addClass("dashicons-before dashicons-hidden");
			return;
		}

		tab.removeClass("dashicons-before dashicons-hidden");
	});
	$("#rttheme_design_options_display_footer").trigger("change");
 
  	//sidebar visibility
	$("#rttheme_design_options_sidebar_position").on("change select",function(){
		var tab = $('#rttheme_design_tabs [data-tab-number="rttheme-sidebar"]');

		if( $('option:selected', this).val() == "fullwidth" ){
			tab.addClass("dashicons-before dashicons-hidden");
			return;
		}

		tab.removeClass("dashicons-before dashicons-hidden");
	});
	$("#rttheme_design_options_sidebar_position").trigger("change");


})(jQuery); 