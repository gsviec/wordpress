/*!
 * 
 * RT-Theme 19 WordPress Theme Admin - Skin Selector
 * Copyright (C) 2014 RT-Themes
 * http://rtthemes.com
 *
 */

jQuery(document).ready(function($) {


	$(".highlight-section").each(function(){
		$(this).on("click",function(e) { 
			e.preventDefault();

			var iframe = $('#customize-preview iframe');
			var elementselector = $(this).data("section-selector");
			var elements = iframe.contents().find(elementselector);

			elements.each(function(){

				var highlight = $('<div class="highlight-element" style="position:absolute;background:#ffc200;opacity:0.5;z-index:999999999"></div>');

				highlight.appendTo(iframe.contents().find("body"));

				highlight.css({
					"width":$(this).outerWidth(),
					"height":$(this).outerHeight(),
					"top":$(this).offset().top,
					"left":$(this).offset().left,
				}).animate({
							"opacity":0
						}, {
							duration: 1200,
							complete: function () {
								highlight.remove();
							}							
						});
				});
		}); 
	}); 
 


	$( "body" ).on( "rt_skin_selector", function( e ) {
		var body = $( this );

		if ( body.hasClass( "selecting-skins" ) ) {
			body.removeClass( "selecting-skins" );
			$(".rt-skin-selector").removeClass("selected");
		} else {
			body.addClass( "selecting-skins" );
			
			if( ! body.hasClass("skins-loaded") ){
				$.fn.rt_load_skins();
			}
		}
	});

	$(".rt-skin-selector").on("click",function( e ){
		e.preventDefault();

		if ( ! $("body").hasClass( "selecting-skins" ) || $(this).hasClass("selected") ) {
			$("body").trigger( "rt_skin_selector" );
		}

		$(".rt-skin-selector").removeClass("selected");

		if ( $("body").hasClass( "selecting-skins" ) ) {
			$(this).addClass("selected");
		}

		$("#available-rt-skins").attr("data-selecting-skins", $(this).data("value") );


		return false;
	});


	$('body').on('click', function(e) { 

		if( ! $(this).hasClass("selecting-skins") ) {
			return ;	
		}
		
		if( e.target.id == "available-rt-skins" || e.target.id == "rt-skin-selector"  ) {
			return ;	
		}

		if( $(e.target).hasClass("skin-image") ) {
			return ;	
		}

		$(this).trigger( "rt_skin_selector" );
	});
 
	$(document.body).on('click', '#available-rt-skins .skin', function() {
		
		var apply_skin_confirm = confirm(rtframework_params["apply_skin"]);

		if( ! apply_skin_confirm ){ 
			return false; 
		}

		var $skin_data,
			item,
			type, 
			skin_id = $(this).data("skin-id");

		$("body").trigger( "rt_skin_selector" );
		$(".rt-skin-selector").removeClass("selected");
		rt_showloader();

 		$.ajax({
			type: 'POST',
			url: ajaxurl,
			data : {
				'action': 'rt_ajax_get_skin_data',
				'skin-id': skin_id
			},		
			success: function(response, textStatus, XMLHttpRequest){

				if( response ){

				 	$skin_data = $.parseJSON(response);
			
						$.each( $skin_data, function( setting_id, value ) {
							
							
							field = $('[data-customize-setting-link="'+setting_id+'"]');
							

							if( field.length == 0 ){
								field = $('#customize-control-'+setting_id+' .wp-color-picker');
							}

							if( field.length == 0 ){
								return;
							}

							type = field.prop("type") || field.prop("tagName").toLowerCase();


	 
							if( type == "select-one" || type == "select-multiple" ){
								
								
								if( $.isArray(value) ){
									field.find("option").each(function(){
	 
										if( $.inArray( $(this).val(), value ) > -1 ){
											$(this).attr("selected","selected");
										}else{
											$(this).attr("selected",null);
										}

									});
								}else{
									field.find("option:selected").attr("selected",null);
									field.find('[value="'+value+'"]').attr("selected","selected");
								}
								
								field.trigger("change");

							}else if( type == "checkbox" ){
								if( value ){
									field.prop("checked",true);
								}else{
									field.prop("checked",false)
								}

								field.trigger("change");
							}else if( type == "radio" ){

								if( value ){
									$('[data-customize-setting-link="'+setting_id+'"][value="'+value+'"]').prop("checked",true);
								}								
							
								field.trigger("change");
							}else{
								field.val(value);

								field.trigger("change");
							}
						});
					wp.customize.requestChangesetUpdate();
					rt_hideloader();

				}

			},
			error: function( MLHttpRequest, textStatus, errorThrown ){
				console.log(errorThrown);
				rt_hideloader();
			}		
		});
	});


	function rt_showloader(){
		if( $("#customize-preview rt_loading_bar").length == 0 ){
			$("#customize-preview").prepend('<div class="rt_loading_bar"></div>');	
		}else{
			$("#customize-preview rt_loading_bar").show();
		} 
	}

	function rt_hideloader(){
		setTimeout( function() {
			$(".rt_loading_bar").hide();
		},2000);
	}

	$.fn.rt_load_skins = function( callbacks ) {
		$.ajax({
			type: 'POST',
			url: ajaxurl,
			data : {
				'action': 'rt_ajax_skin_loader'
			},		
			success: function(response, textStatus, XMLHttpRequest){
 				$("#available-rt-skins").append( response );
 				$("body").addClass( "skins-loaded" );
 				$(".skins-loading-spinner").hide();
			},
			error: function( MLHttpRequest, textStatus, errorThrown ){
				console.log(errorThrown);
			}		
		});

	};
 
}); 