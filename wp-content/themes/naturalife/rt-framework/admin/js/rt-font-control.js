/*!
 * 
 * naturalife WordPress Theme Admin - Font Control
 * Copyright (C) 2014 RT-Themes
 * http://rtthemes.com
 *
 */

jQuery(document).ready(function($) {

 
 	function rt_create_option_inputs( list, selected_values ){

		var i,options,selected,anyselected = false ;

		selected_values_array = selected_values.toString().split(",");
		list = list.toString().split(",");

		for (i = 0; i < list.length; ++i) {	 
			
			if( $.inArray( list[i], selected_values_array ) > -1 ){
				anyselected = true;
			} 
		}


		for (i = 0; i < list.length; ++i) {	 
			selected = $.inArray( list[i], selected_values_array ) > -1 ? "selected" : "";		
 			selected = ! anyselected && i == 0 ? "selected" : selected;	
			options += '<option value="'+list[i]+'" '+selected+'>'+list[i]+'</option>';    
		}

		return options;
 		
 	}

	$(".rt_fonts").on("change",function(){

			var selectedOption = $('option:selected', this),
				selectedValue = selectedOption.val(),
				el;


			if ( ! selectedValue ){
				return false;
			}

			var	variants = selectedOption.data("variants"),
				subsets = selectedOption.data("subsets"),
				parse_value = selectedValue.split("||"),
				kind = parse_value[0],
				family = parse_value[1];


				//subset
				el = $("[data-customize-setting-link='"+$(this).data("subset-id")+"']");
				if( kind == "google" && subsets ){

					el.html( rt_create_option_inputs( subsets, $(this).data("selected-subsets") ) ).trigger("change");
					el.parents("li:eq(0)").show().effect("highlight", 700);

				}else{
					el.parents("li:eq(0)").hide();
				}

				//variant
				el = $("[data-customize-setting-link='"+$(this).data("variant-id")+"']");
				if( kind == "google" && variants ){

					el.html( rt_create_option_inputs( variants, $(this).data("selected-variant") ) ).trigger("change");
					el.parents("li:eq(0)").show().effect("highlight", 700);

				}else{
					el.parents("li:eq(0)").hide();
				}

	});	

	$(window).on("load",function(){
		$(".rt_fonts").each(function(){
			$(this).trigger("change");
		});
	});	
 
}); 

