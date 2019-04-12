/*!
 * naturalife WordPress Theme - Customizer
 * Copyright (C) 2014 RT-Themes
 * http://rtthemes.com
 *
 */

( function( $ ) {

	
	$.fn.rt_css_replace = function( css )
	{ 

		var search = new RegExp('\{(.*?)\}', 'g'),
			new_css = $(this).text().replace(search, "{"+css+"}");

			$(this).text( new_css );
	};



	/**
	 * content rows css replacer
	 */
	$.fn.runs = function( container )
	{  

		wp.customize(rtframework_params["theme_slug"]+'_'+ container +'_link_color', function( value ) {
			value.bind( function( to ) {   
				$('[data-id="'+rtframework_params["theme_slug"]+'_'+ container +'_link_color"]').each(function(){
					$(this).rt_css_replace($(this).attr("data-color-for")+":"+to);
				});
			} );
		} );

		wp.customize(rtframework_params["theme_slug"]+'_'+ container +'_bg_color', function( value ) {
			value.bind( function( to ) {   
				$('[data-id="'+rtframework_params["theme_slug"]+'_'+ container +'_bg_color"]').each(function(){
					$(this).rt_css_replace($(this).attr("data-color-for")+":"+to);
				});
			} );
		} );

		wp.customize(rtframework_params["theme_slug"]+'_'+ container +'_item_bg_color', function( value ) {
			value.bind( function( to ) {   
				$('[data-id="'+rtframework_params["theme_slug"]+'_'+ container +'_item_bg_color"]').each(function(){
					$(this).rt_css_replace($(this).attr("data-color-for")+":"+to);
				});
			} );
		} );

		wp.customize(rtframework_params["theme_slug"]+'_'+ container +'_font_color', function( value ) {
			value.bind( function( to ) {   
				$('[data-id="'+rtframework_params["theme_slug"]+'_'+ container +'_font_color"]').each(function(){
					$(this).rt_css_replace($(this).attr("data-color-for")+":"+to);
				});
			} );
		} );


		// wp.customize(rtframework_params["theme_slug"]+'_'+ container +'_primary_color', function( value ) {
		// 	value.bind( function( to ) {   
		// 		$('[data-id="'+rtframework_params["theme_slug"]+'_'+ container +'_primary_color"]').each(function(){
		// 			$(this).rt_css_replace($(this).attr("data-color-for")+":"+to);
		// 		});
		// 	} );
		// } );

		wp.customize(rtframework_params["theme_slug"]+'_'+ container +'_border_color', function( value ) {
			value.bind( function( to ) {   
				$('[data-id="'+rtframework_params["theme_slug"]+'_'+ container +'_border_color"]').each(function(){
					$(this).rt_css_replace($(this).attr("data-color-for")+":"+to);
				});
			} );
		} );


		wp.customize(rtframework_params["theme_slug"]+'_'+ container +'_secondary_font_color', function( value ) {
			value.bind( function( to ) {   
				$('[data-id="'+rtframework_params["theme_slug"]+'_'+ container +'_secondary_font_color"]').each(function(){
					$(this).rt_css_replace($(this).attr("data-color-for")+":"+to);
				});
			} );
		} );


		wp.customize(rtframework_params["theme_slug"]+'_'+ container +'_light_text_color', function( value ) {
			value.bind( function( to ) {   
				$('[data-id="'+rtframework_params["theme_slug"]+'_'+ container +'_light_text_color"]').each(function(){
					$(this).rt_css_replace($(this).attr("data-color-for")+":"+to);
				});
			} );
		} );


		wp.customize(rtframework_params["theme_slug"]+'_'+ container +'_heading_color', function( value ) {
			value.bind( function( to ) {   
				$('[data-id="'+rtframework_params["theme_slug"]+'_'+ container +'_heading_color"]').each(function(){
					$(this).rt_css_replace($(this).attr("data-color-for")+":"+to);
				});
			} );
		} );

		wp.customize(rtframework_params["theme_slug"]+'_'+ container +'_form_button_bg_color', function( value ) {
			value.bind( function( to ) {   
				$('[data-id="'+rtframework_params["theme_slug"]+'_'+ container +'_form_button_bg_color"]').each(function(){
					$(this).rt_css_replace($(this).attr("data-color-for")+":"+to);
				});
			} );
		} ); 

		wp.customize(rtframework_params["theme_slug"]+'_'+ container +'_form_button_hover_color', function( value ) {
			value.bind( function( to ) {   
				$('[data-id="'+rtframework_params["theme_slug"]+'_'+ container +'_form_button_hover_color"]').each(function(){
					$(this).rt_css_replace($(this).attr("data-color-for")+":"+to);
				});
			} );
		} ); 

		wp.customize(rtframework_params["theme_slug"]+'_'+ container +'_form_bg_color', function( value ) {
			value.bind( function( to ) {   
				$('[data-id="'+rtframework_params["theme_slug"]+'_'+ container +'_form_bg_color"]').each(function(){
					$(this).rt_css_replace($(this).attr("data-color-for")+":"+to);
				});
			} );
		} ); 


		wp.customize(rtframework_params["theme_slug"]+'_'+ container +'_social_media_bg_color', function( value ) {
			value.bind( function( to ) {   
				$('[data-id="'+rtframework_params["theme_slug"]+'_'+ container +'_social_media_bg_color"]').each(function(){
					$(this).rt_css_replace($(this).attr("data-color-for")+":"+to);
				});
			} );
		} );						 

	};
	
	containers = ["default","alt_style_1","light_style","footer","side_panel"]; 

	for (i = 0; i < containers.length; i++) { 
		$.fn.runs( containers[i] );
	};




	wp.customize(rtframework_params["theme_slug"]+'_breadcrumb_font_color', function( value ) {
		value.bind( function( to ) {   
			$('[data-id="'+rtframework_params["theme_slug"]+'_breadcrumb_font_color"]').each(function(){
				$(this).rt_css_replace( $(this).attr("data-color-for")+":"+to ) ;
			});
		} );
	} );	

	wp.customize(rtframework_params["theme_slug"]+'_breadcrumb_link_color', function( value ) {
		value.bind( function( to ) {   
			$('[data-id="'+rtframework_params["theme_slug"]+'_breadcrumb_link_color"]').each(function(){
				$(this).rt_css_replace( $(this).attr("data-color-for")+":"+to ) ;
			});
		} );
	} );	

	wp.customize(rtframework_params["theme_slug"]+'_breadcrumb_bg_color', function( value ) {
		value.bind( function( to ) {   

			if( ! to ) {
				to = "transparent";
			}

			$('.breadcrumb').css({
				"background-color": to
			});	
		} );
	} );

	wp.customize(rtframework_params["theme_slug"]+'_header_row_font_color', function( value ) {
		value.bind( function( to ) {   

			if( ! to ) {
				to = "transparent";
			}

			$('.sub-page-header h1').css({
				"color": to
			});	
		} );
	} );

	wp.customize(rtframework_params["theme_slug"]+'_header_row_bg_color', function( value ) {
		value.bind( function( to ) {   

			if( ! to ) {
				to = "transparent";
			}

			$('.sub-page-header').css({
				"background-color": to
			});	
		} );
	} );	



	/**
	 * native selectors
	 */
	wp.customize(rtframework_params["theme_slug"]+'_body_background_color', function( value ) {
		value.bind( function( to ) {   

			if( ! to ) {
				to = "transparent";
			}

			$('body').css({
				"background-color": to
			});	
		} );
	} );

	wp.customize(rtframework_params["theme_slug"]+'_holder_background_color', function( value ) {
		value.bind( function( to ) {   

			if( ! to ) {
				to = "transparent";
			}

			$('#container').css({
				"background-color": to
			});	
		} );
	} );



  	/**
  	 * Dark Navigation
  	 */


  	wp.customize(rtframework_params["theme_slug"]+'_nav_item_background_color_dark', function( value ) {
		value.bind( function( to ) {   

			if( ! to ) {
				to = "transparent";
			}

			$('.naturalife-dark-header .main-menu > li > a > span').css({
				"background-color": to
			});	
		} );
	} );


  	wp.customize(rtframework_params["theme_slug"]+'_nav_item_font_color_dark', function( value ) {
		value.bind( function( to ) {   

			if( ! to ) {
				to = "transparent";
			}

			$('.naturalife-dark-header .main-menu > li > a > span').css({
				"color": to
			});	
		} );
	} );

  	wp.customize(rtframework_params["theme_slug"]+'_nav_item_border_color_dark', function( value ) {
		value.bind( function( to ) {   

			if( ! to ) {
				to = "transparent";
			}

			$('.naturalife-dark-header .main-menu > li > a > span, .naturalife-dark-header .naturalife-search-butto.naturalife-dark-header .mobile-menu-button').css({
				"border-color": to
			});	
		} );
	} );


  	wp.customize(rtframework_params["theme_slug"]+'_sub_nav_item_background_color_dark', function( value ) {
		value.bind( function( to ) {   

			if( ! to ) {
				to = "transparent";
			}

			$('.naturalife-dark-header .main-menu > li li,.naturalife-dark-header .naturalife-language-switcher > ul > li > ul > li').css({
				"background-color": to
			});	
		} );
	} );


  	wp.customize(rtframework_params["theme_slug"]+'_sub_nav_item_font_color_dark', function( value ) {
		value.bind( function( to ) {   

			if( ! to ) {
				to = "transparent";
			}

			$('.naturalife-dark-header .main-menu > li li > a,.naturalife-dark-header .main-menu .multicolumn-holder li > ul > li.menu-item-has-children > span,.naturalife-dark-header .main-menu li li:before,.naturalife-dark-header .main-menu li li:after,.naturalife-dark-header .naturalife-language-switcher > ul > li li span').css({
				"color": to
			});	
		} );
	} );

  	wp.customize(rtframework_params["theme_slug"]+'_sub_nav_item_desc_color_dark', function( value ) {
		value.bind( function( to ) {   

			if( ! to ) {
				to = "transparent";
			}

			$('.naturalife-dark-header .main-menu ul li > a > sub,.naturalife-dark-header .main-menu .multicolumn-holder li > .sub-menu ul ul a').css({
				"border-color": to
			});	
		} );
	} );


  	wp.customize(rtframework_params["theme_slug"]+'_sub_nav_item_border_color_dark', function( value ) {
		value.bind( function( to ) {   

			if( ! to ) {
				to = "transparent";
			}

			$('.naturalife-dark-header .main-menu > li li > a,.naturalife-dark-header .main-menu .multicolumn-holder *,.naturalife-dark-header .main-menu > li ul,.naturalife-dark-header .main-menu > li li.menu-item-has-children > a:after,.naturalife-dark-header .naturalife-language-switcher > ul > li li').css({
				"border-color": to
			});	
		} );
	} );


  	/**
  	 * Light Navigation
  	 */

  	wp.customize(rtframework_params["theme_slug"]+'_nav_item_background_color_light', function( value ) {
		value.bind( function( to ) {   

			if( ! to ) {
				to = "transparent";
			}

			$('.naturalife-light-header .main-menu > li > a > span').css({
				"background-color": to
			});	
		} );
	} );


  	wp.customize(rtframework_params["theme_slug"]+'_nav_item_font_color_light', function( value ) {
		value.bind( function( to ) {   

			if( ! to ) {
				to = "transparent";
			}

			$('.naturalife-light-header .main-menu > li > a > span').css({
				"color": to
			});	
		} );
	} );

  	wp.customize(rtframework_params["theme_slug"]+'_nav_item_border_color_light', function( value ) {
		value.bind( function( to ) {   

			if( ! to ) {
				to = "transparent";
			}

			$('.naturalife-light-header .main-menu > li > a > span, .naturalife-light-header .naturalife-search-butto.naturalife-light-header .mobile-menu-button').css({
				"border-color": to
			});	
		} );
	} );


  	wp.customize(rtframework_params["theme_slug"]+'_sub_nav_item_background_color_light', function( value ) {
		value.bind( function( to ) {   

			if( ! to ) {
				to = "transparent";
			}

			$('.naturalife-light-header .main-menu > li li,.naturalife-light-header .naturalife-language-switcher > ul > li > ul > li').css({
				"background-color": to
			});	
		} );
	} );


  	wp.customize(rtframework_params["theme_slug"]+'_sub_nav_item_font_color_light', function( value ) {
		value.bind( function( to ) {   

			if( ! to ) {
				to = "transparent";
			}

			$('.naturalife-light-header .main-menu > li li > a,.naturalife-light-header .main-menu .multicolumn-holder li > ul > li.menu-item-has-children > span,.naturalife-light-header .main-menu li li:before,.naturalife-light-header .main-menu li li:after,.naturalife-light-header .naturalife-language-switcher > ul > li li span').css({
				"color": to
			});	
		} );
	} );

  	wp.customize(rtframework_params["theme_slug"]+'_sub_nav_item_desc_color_light', function( value ) {
		value.bind( function( to ) {   

			if( ! to ) {
				to = "transparent";
			}

			$('.naturalife-light-header .main-menu ul li > a > sub,.naturalife-light-header .main-menu .multicolumn-holder li > .sub-menu ul ul a').css({
				"border-color": to
			});	
		} );
	} );


  	wp.customize(rtframework_params["theme_slug"]+'_sub_nav_item_border_color_light', function( value ) {
		value.bind( function( to ) {   

			if( ! to ) {
				to = "transparent";
			}

			$('.naturalife-light-header .main-menu > li li > a,.naturalife-light-header .main-menu .multicolumn-holder *,.naturalife-light-header .main-menu > li ul,.naturalife-light-header .main-menu > li li.menu-item-has-children > a:after,.naturalife-light-header .naturalife-language-switcher > ul > li li').css({
				"border-color": to
			});	
		} );
	} );

	  	
} )( jQuery );