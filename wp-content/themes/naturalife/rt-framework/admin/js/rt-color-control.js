/*!
 * naturalife WordPress Theme Admin - Color Control
 * Copyright (C) 2014 RT-Themes
 * http://rtthemes.com
 *
 */
jQuery(document).ready(function($) {
 
		function update_spectrum(color, el, holder, color_input){
 
			var result_box = holder.find(".wp-color-result");

			result_box.css({ "background-color" : color }); 
		
			wp.customize(color_input.data("customize-setting-link"), function(obj) {
				obj.set(color);
			});

			color_input.trigger("change");
		}

		function rt_picker_new_color( color ){
			
			var new_color;

			if( color ){
				if(color.getAlpha() < 1 ){
					new_color = color.toRgbString();
				}else{
					new_color = color.toHexString();
				}	
			}else{
				new_color = "";	
			}

			return new_color;
		}

		function rt_close_pickers(){
			$(".sp-container, .wp-color-picker, .rt-color-control-default").hide();
			$(".wp-picker-open").removeClass("wp-picker-open");
		}
		
		$(".rt-color-control-default").on("click",function(){			  
			var holder= $(this).parents(".wp-picker-container:eq(0)"),
				color_input = holder.find(".wp-color-picker"), 
				picker = holder.find(".rt-color-control"),
				default_color = color_input.data("default-color"); 
				update_spectrum(default_color, picker, holder, color_input);
		});

		$('.accordion-section-content').on('click', function(e) { 
			if( e.target !== this ) 
			return;
			rt_close_pickers();
		});

		$(".customize-control-title").on("click",function(){
			rt_close_pickers();
		});


		$(document.body).on('keyup change', '.wp-color-picker', function(event) { 
			var holder= $(this).parents(".wp-picker-container:eq(0)"),
				color_input = $(this),
				picker = holder.find(".rt-color-control"),
				result_box = holder.find(".wp-color-result");
				result_box.css({ "background-color" : color_input.val() }); 
			 	picker.spectrum("set", color_input.val() );
		});
		
		$(".rt-color-control-result").on("click",function(){

			var holder= $(this).parent(".wp-picker-container:eq(0)"),
				color_input = holder.find(".wp-color-picker"),
				picker = holder.find(".rt-color-control"),
				picker_holder = holder.find(".sp-container");

			rt_close_pickers();

			if( ! $(this).hasClass("wp-picker-open") ){

				if( picker_holder.length > 0 ){
					picker_holder.show();
				}else{
					picker.spectrum({ 
						flat: true,
						showInput: false,
						showAlpha: true, 
						showButtons:false,
						showPalette: false,
						allowEmpty:true,
						palette: [[$(this).data("default-color")]],
						color: color_input.val(),
						move: function(color) {
							update_spectrum( rt_picker_new_color(color), $(this), holder, color_input );
						},
						change: function(color) { 
							update_spectrum( rt_picker_new_color(color), $(this), holder, color_input );
						} 
					}); 		

				}
	
				$(this).addClass("wp-picker-open");
				color_input.show();
				holder.find(".rt-color-control-default").show();

			}else{
				rt_close_pickers();
			} 

		});		

}); 