jQuery(document).ready(function ($) {
	
	var window_width = $(window).innerWidth();
	
	//submenu adjustments
	function submenu_adjustments() {
		$(".main-navigation > ul > .menu-item").mouseenter(function() {
			if ( $(this).children(".sub-menu").length > 0 ) {
				var submenu = $(this).children(".sub-menu");
				var window_width = parseInt($(window).outerWidth());
				var submenu_width = parseInt(submenu.outerWidth());
				var submenu_offset_left = parseInt(submenu.offset().left);
				var submenu_adjust = window_width - submenu_width - submenu_offset_left;
						
				if (submenu_adjust < 0) {
					submenu.css("left", submenu_adjust-30 + "px");
				}
			}
		});
	}
	
	submenu_adjustments();
	
	//woocommerce tabs
	$('.woocommerce-tabs .panel:first-child').addClass('current');
	$('.woocommerce-tabs ul.tabs li a').off('click').on('click', function(){
		var that = $(this);
		var currentPanel = that.attr('href');
		
		that.parent().siblings().removeClass('active')
					.end()
					.addClass('active');
		
		$('.woocommerce-tabs').find(currentPanel).siblings('.panel').filter(':visible').fadeOut(500,function(){
			$('.woocommerce-tabs').find(currentPanel).siblings('.panel').removeClass('current');
			$('.woocommerce-tabs').find(currentPanel).addClass('current').fadeIn(500);
		})
		
		return false;
	})
	
	// close search offcanvas
	$(document).on('click', '.site-search .close-button', function(){
		$(document).find('#offCanvasTop1').removeAttr("style");
	});
	
	//add to cart button
	
	$('.add_to_cart_button').one('click',function(){
		
		var	add_to_cart_classes,
			add_to_cart_styles,
			that = $(this);
		
		add_to_cart_classes = that.attr('class');
		add_to_cart_classes=add_to_cart_classes.replace('add_to_cart_button','');
		
		add_to_cart_styles = that.attr('style');
		
		that.parent().on('DOMNodeInserted', function(e) {
			e.stopPropagation();
			
			if ($(e.target).is('.added_to_cart')) {
				$(e.target).addClass(add_to_cart_classes).removeClass('added_to_cart').addClass('added_to_cart_button');
			    $(e.target).attr('style',add_to_cart_styles);
			}
		});
	})
		
    //product animation (thanks Sam Sehnert)
    
    $.fn.visible = function(partial) {

      var $t            = $(this),
          $w            = $(window),
          viewTop       = $w.scrollTop(),
          viewBottom    = viewTop + $w.height(),
          _top          = $t.offset().top,
          _bottom       = _top + $t.height(),
          compareTop    = partial === true ? _bottom : _top,
          compareBottom = partial === true ? _top : _bottom;

    return ((compareBottom <= viewBottom) && (compareTop >= viewTop));

    };

    
    //if is visible on screen add a class
    $("section.related").each(function(i, el) {
        if ($(el).visible(true)) {
            $(el).addClass("on_screen");
        } 
    });

	$(".nano").nanoScroller();
	
	//mobile menu	
	$(".mobile-navigation .menu-item-has-children .sub-menu").before('<div class="more"><span class="spk-icon-down-small"></span></div>');
	
	$(".mobile-navigation").on("click", ".more", function(e) {
		e.stopPropagation();

		var submenus = $(this).parent().find(".sub-menu");
		$.each(submenus, function(x,y){
			$(y).find(".sub-menu").addClass("open");
			$(y).find(".more").remove();
		});

		$(this).parent().toggleClass("current")
						.children(".sub-menu").toggleClass("open");
						
		$(this).parent().find('.more').html($(this).parent().find('.more').html() == '<span class="spk-icon-down-small"></span>' ? '<span class="spk-icon-up-small"></span>' : '<span class="spk-icon-down-small"></span>');
		$(".nano").nanoScroller();
	});

	$(".mobile-navigation").on("click", "a", function(e) {
		if($(this).attr('href') == '#' && $(this).parent('.menu-item').hasClass('menu-item-has-children')) {
			$(this).parent().find('.more').trigger('click');
		} else if($(this).attr('href').indexOf('#') > -1) {
			$('#offCanvasRight1').foundation('close');
		}
	});
	
	function replace_img_source(selector) {
		var data_src = $(selector).attr('data-src');
		$(selector).one('load', function() {
		}).each(function() {
			//if(this.complete) {
				//$(this).load();
				$(selector).attr('src', data_src);
				$(selector).css("opacity", "1");
			//}
		});
	}
	
	$('#products-grid li img').each(function(){
		replace_img_source(this);
	});
	
	$('.related.products li img').each(function(){
		replace_img_source(this);
	});
	
	$('.upsells.products li img').each(function(){
		replace_img_source(this);
	});

	$('.add_to_cart_button').on('click',function(){
		$(this).parents('li.animate').addClass('product_added_to_cart')	
	})
	
	
	//scroll on reviews tab
	$('.woocommerce-review-link').off('click').on('click',function(){
		
		$('.tabs li a').each(function(){
			if ($(this).attr('href')=='#tab-reviews') {
				$(this).trigger('click');
			}
		});
		
		var elem_on_screen_height = 0;
		
		/*if ( $('.site-header-sticky').length > 0 ) {
			elem_on_screen_height += $('.site-header-sticky').outerHeight();
		}*/
		
		if ( $('#wpadminbar').length > 0 ) {
			elem_on_screen_height += $('#wpadminbar').outerHeight();
		}
		
		if ( $('.getbowtied_theme_explorer_wrapper').length > 0 && $('.getbowtied_theme_explorer_wrapper').is('visible') ) {
			elem_on_screen_height += $('.getbowtied_theme_explorer_wrapper').outerHeight();
		}
		
		var tab_reviews_topPos = $('.woocommerce-tabs').offset().top - elem_on_screen_height;
		
		$('html, body').animate({
            scrollTop: tab_reviews_topPos
        }, 1000);
		
		return false;
	})

		
	$('.add_to_wishlist').on('click',function(){
		$(this).parents('.yith-wcwl-add-button').addClass('show_overlay');
	})

	// Login/register
	var account_tab_list = $('.account-tab-list');
	
	account_tab_list.on('click','.account-tab-link',function(){
		
		if ( $('.account-tab-link').hasClass('registration_disabled') ) {
			return false;
		} else {
		
			var that = $(this),
				target = that.attr('href');
			
			that.parent().siblings().find('.account-tab-link').removeClass('current');
			that.addClass('current');
			
			$('.account-forms').find($(target)).siblings().stop().fadeOut(function(){
				$('.account-forms').find($(target)).fadeIn();
			});
			
			//$(target).siblings().stop().fadeOut(function(){
			//	$(target).fadeIn();	
			//});
			
			return false;
		}
	});
	
	// Login/register mobile
	$('.account-tab-link-register').on('click',function(){
		$('.login-form').stop().fadeOut(function(){
			$('.register-form').fadeIn();
		})
		return false;
	})
	
	$('.account-tab-link-login').on('click',function(){
		$('.register-form').stop().fadeOut(function(){
			$('.login-form').fadeIn();
		})
		return false;
	})


	var windowWidth = $(window).width();

	// If both product gallery zoom & product gallery lightbox are disabled, make cursor default
	if ( getbowtied_scripts_vars.product_lightbox != 1 && getbowtied_scripts_vars.product_gallery_zoom != 1 ) {
		$('.product_layout_classic .woocommerce-product-gallery__wrapper .woocommerce-product-gallery__image a').css({'cursor' :'default'});
		$('.product_layout_2 .product-images-wrapper .product-image a img').css({'cursor' :'default'});
		$('.product_layout_3 .product-images-wrapper .product-image a img').css({'cursor' :'default'});
		$('.product_layout_4 .product-images-wrapper .product-image a img').css({'cursor' :'default'});
	}

	if ( getbowtied_scripts_vars.product_lightbox == 1 && getbowtied_scripts_vars.product_gallery_zoom != 1 ) {
		$('.product_layout_4 .product-images-wrapper .product-image a img').css({'cursor' :'pointer'});
	}

    // Disable fresco
    function disable_fresco() {

		if ( getbowtied_scripts_vars.product_lightbox != 1 ) {

			$(".product-images-layout .fresco, .product-images-layout-mobile .fresco, .woocommerce-product-gallery__wrapper .fresco").on('click',function() {
				return false;
			});
		}
	}

    disable_fresco();
	
	
	//add fresco groups to images galleries
	$(".gallery").each(function() {
		
		var that = $(this);
		
		that.find('.gallery-item').each(function(){
			
			var this_gallery_item = $(this);
			
			this_gallery_item.find('.fresco').attr('data-fresco-group', that.attr('id'));
			
			if ( this_gallery_item.find('.gallery-caption').length > 0 ) {
				this_gallery_item.find('.fresco').attr('data-fresco-caption', this_gallery_item.find('.gallery-caption').text());
			}
			
		});
		
	});

	
	// // share product text desktop animation
	// $('.product_socials_wrapper').on('mouseenter',function(){
	// 	$(this).addClass('hovered');
	// })

	// $('.product_socials_wrapper').on('mouseleave',function(){
	// 	$(this).removeClass('hovered');
	// })

	
	function handleSelect() {	
		if ($(window).innerWidth() > 1023 ) {
			
			var select2 = $(".orderby, .big-select").select2({
				//placeholder: "Select a State",
				allowClear: true,
				minimumResultsForSearch: Infinity
			});

		}
	}
	
	handleSelect();


	//gallery caption

	$('.gallery-item').each(function(){
		
		var that = $(this);
		
		if ( that.find('.gallery-caption').length > 0 ) {
			that.append('<span class="gallery-caption-trigger">i</span>')
		}
		
	})
	
	$('.gallery-caption-trigger').on('mouseenter',function(){
		$(this).siblings('.gallery-caption').addClass('show'); 
	});
	
	$('.gallery-caption-trigger').on('mouseleave',function(){
		$(this).siblings('.gallery-caption').removeClass('show');
	});
	
		

	
	/*function refreshBackgrounds(selector) {
		// Chrome shim to fix http://groups.google.com/a/chromium.org/group/chromium-bugs/browse_thread/thread/1b6a86d6d4cb8b04/739e937fa945a921
		// Remove this once Chrome fixes its bug.
		$.browser.chrome = /chrom(e|ium)/.test(navigator.userAgent.toLowerCase());
		if ($.browser.chrome) {
			if ($(selector).css("background-image") != "none") {
				var oldBackgroundImage = $(selector).css("background-image");
				$(selector).css("background-image", oldBackgroundImage);
			}
		}
	}*/

	//refreshBackgrounds(".st-content");
	
	$('.trigger-footer-widget').on('click', function(){
		
		var trigger = $(this).parent();
		
		trigger.fadeOut('1000',function(){
			trigger.remove();
			$('.site-footer-widget-area').fadeIn();
		});
	});
		
	
	//blog isotope - adjust wrapper width, return blog_grid
    function blogIsotopeWrapper () {
           
		if ( $(window).innerWidth() > 1024 ) {
			$blog_grid = 3;
			$('.blog-isotop-container').css({'margin':'0 -1.5%'})
		} else if ( $(window).innerWidth() <= 640 ) {
			$blog_grid = 1;
			$('.blog-isotop-container').css({'margin':'0 -30px'})
		} else {
			$blog_grid = 2;
			$('.blog-isotop-container').css({'margin':'0 -1.5%'})
		}
       
        $blog_wrapper_width = $('.blog-isotop-container').width();
   
        if ( $blog_wrapper_width % $blog_grid > 0 ) {
            $blog_wrapper_width = $blog_wrapper_width + ( $blog_grid - $blog_wrapper_width%$blog_grid);
        };
   
        $('.blog-isotope').css('width',$blog_wrapper_width);

        return $blog_grid;
    } // end blogIsotopeWrapper
   
    
	
	//blog isotope
    if ( $('.blog-isotop-container').length ) {
           
		var $blog_wrapper_inner,   
            $blog_wrapper_width,
            $blog_grid,
            $filterValue;
       
        $filterValue = $('.filters-group .is-checked').attr('data-filter');
                      
        $blog_grid =  blogIsotopeWrapper();
        blogIsotopeWrapper();
       
        var afterBlogIsotope = function(){
            setTimeout(function(){
                //$('.preloader_isotope').remove();
                $(".blog-post").removeClass('hidden');
            },200);
        }
       
        var blogIsotope=function(){
            var imgLoad = imagesLoaded($('.blog-isotope'));
		   
            imgLoad.on('done',function(){

                $blog_wrapper_inner = $('.blog-isotope').isotope({
                    "itemSelector": ".blog-post",
					 //layoutMode: 'fitRows',
                    "masonry": { "columnWidth": ".grid-sizer" }
                });
               
			   afterBlogIsotope()
               
            })
           
           imgLoad.on('fail',function(){

                $blog_wrapper_inner = $('.blog-isotope').isotope({
                    "itemSelector": ".blog-post",
                    "masonry": { "columnWidth": ".grid-sizer" }
                });
               
                afterBlogIsotope()
           })  
           
        }
                   
        blogIsotope();
   
        // filter items on button click
        $('.filters-group').on( 'click', 'filter-item', function() {
           
            $filterValue = $(this).attr('data-filter');
            $blog_wrapper_inner.isotope({ filter: $filterValue });
        
		});
    }//endif blog isotope
	
	
	//portfolio isotope - hover effect
	$('.hover-effect-text').each(function(){
		
		var that = $(this);
		
		that.css('bottom',-that.outerHeight())
			.attr('data-height',that.outerHeight());
	})
	
	$('.hover-effect-link').mouseenter(function(){
		
		var that = $(this);
		
		if ( !that.find('.hover-effect-text').is(':empty') ) {
			
			var portfolio_cat_height = that.find('.hover-effect-text').outerHeight();
			
			that.find('.hover-effect-title').css('bottom',portfolio_cat_height);
			that.find('.hover-effect-text').css('bottom',0);
			
		}
		
	});
	
	
	$('.hover-effect-link').mouseleave(function(){
	
		var that = $(this);
		
		if ( !that.find('.hover-effect-text').is(':empty') ) {
		
			var portfolio_cat_height = that.find('.hover-effect-text').attr('data-height');
	
			that.find('.hover-effect-title').css('bottom',28);
			that.find('.hover-effect-text').css('bottom',-portfolio_cat_height);
		}
		
	});
	
	
	//portfolio isotope - adjust wrapper width, return portfolio_grid
    function portfolioIsotopeWrapper () {
           
		if ( $(window).innerWidth() > 1584 ) {
			$portfolio_grid = 5;
		} else if ( $(window).innerWidth() <= 480 ) {
			$portfolio_grid = 1;
		} else if ( $(window).innerWidth() <= 901 ) {
			$portfolio_grid = 2;
		} else if ( $(window).innerWidth() <= 1248 ) {
			$portfolio_grid = 3;
		} else {
			$portfolio_grid = 4;
		}
		
		if ( $('.items_per_row_3').length > 0 && $(window).innerWidth() > 1248 )
		{
			$portfolio_grid = 3;
		}
		
		if ( $('.items_per_row_4').length > 0 && $(window).innerWidth() > 1584 )
		{
			$portfolio_grid = 4;
		}
       
        $portfolio_wrapper_width = $('.portfolio-isotope-container').width();
   
        if ( $portfolio_wrapper_width % $portfolio_grid > 0 ) {
            $portfolio_wrapper_width = $portfolio_wrapper_width + ( $portfolio_grid - $portfolio_wrapper_width%$portfolio_grid);
        };
   
        $('.portfolio-isotope').css('width',$portfolio_wrapper_width);

        return $portfolio_grid;
    } // end portfolioIsotopeWrapper
   
    //portfolio isotope
    if ( $('.portfolio-isotope-container').length ) {
           
		var $portfolio_wrapper_inner,   
            $portfolio_wrapper_width,
            $portfolio_grid,
            $filterValue;
       
        $filterValue = $('.filters-group .is-checked').attr('data-filter');
                      
        $portfolio_grid =  portfolioIsotopeWrapper();
        portfolioIsotopeWrapper();
       
        var afterIsotope = function(){
            setTimeout(function(){
                //$('.preloader_isotope').remove();
                $(".portfolio-box").removeClass('hidden');
            },200); 
        }
       
        var portfolioIsotope=function(){
            var imgLoad = imagesLoaded($('.portfolio-isotope'));
           
            imgLoad.on('done',function(){

                $portfolio_wrapper_inner = $('.portfolio-isotope').isotope({
                    "itemSelector": ".portfolio-box",
					 //layoutMode: 'fitRows',
                    "masonry": { "columnWidth": ".portfolio-grid-sizer" }
                });
               
                afterIsotope()
            })
           
            imgLoad.on('fail',function(){

                portfolio_wrapper_inner = $('.portfolio-isotope').isotope({
                    "itemSelector": ".portfolio-box",
					 //layoutMode: 'fitRows',
                    "masonry": { "columnWidth": ".portfolio-grid-sizer" }
                });
               
                afterIsotope()
            })
           
        }
                   
        portfolioIsotope();
   
        // filter items on button click
        $('.filters-group').on( 'click', '.filter-item', function() {
		   
            $filterValue = $(this).attr('data-filter'); 
            $(this).parents('.portfolio-filters').siblings('.portfolio-isotope').isotope({ filter: $filterValue });
        
		});
    }//endif portfolio isotope

	
	
	//Language Switcher
	$('.topbar-language-switcher').change(function(){
		window.location = $(this).val();
	});
	
	
	
	
	
	$(window).load(function() {		

        setTimeout(function() {	
            $(".product_thumbnail.with_second_image").css("background-size", "cover");
			$(".product_thumbnail.with_second_image").addClass("second_image_loaded");
        }, 300);
		
        if ($(window).outerWidth() > 1024) {
			$.stellar({
				horizontalScrolling: false,
                responsive: true
			});
		}
		
		setTimeout(function(){
			$('.parallax, .single-post-header-bkg').addClass('loaded');
		},150)
	
	});



	
	$(window).resize(function(){
        
        $('.site-search-form-wrapper-inner, .site-search .widget_search .search-form').css('margin-left',-$(window).width()/4);
		
		$(".main-navigation > ul > .menu-item > .sub-menu").css("left", "-15px");
		       
        //disable_fresco();		
		
		//blog isotope
        if ( $('.blog-isotop-container').length ) {
           
            var $blog_grid_on_resize;
           
            blogIsotopeWrapper()
            $blog_grid_on_resize =  blogIsotopeWrapper(); 
           
            if ( $blog_grid != $blog_grid_on_resize ) {

                $('.filters-group .filter-item').each(function(){
                    if ( $(this).attr('data-filter') == $filterValue ){ 
                            $(this).trigger('click');
                    }
                })
               
                $blog_grid = $blog_grid_on_resize;
           
				resizeIsotopeEnd();
           
            } 
		}
		
		//portfolio isotope
        if ( $('.portfolio-isotope-container').length ) {
           
            var $portfolio_grid_on_resize;
           
            portfolioIsotopeWrapper()
            $portfolio_grid_on_resize =  portfolioIsotopeWrapper(); 
           
            if ( $portfolio_grid != $portfolio_grid_on_resize ) {

                $('.filters-group .filter-item').each(function(){
                    if ( $(this).attr('data-filter') == $filterValue ){
                            $(this).trigger('click');
                    }
                })
               
                $portfolio_grid = $portfolio_grid_on_resize;
        
				resizeIsotopeEnd();
           
            }
			
        }
		
		
		//do something on end resize
        var window_resizeTo = this.resizeTO;
        function resizeIsotopeEnd() {
            if(window_resizeTo) clearTimeout(window_resizeTo);
                 window_resizeTo = setTimeout(function() {
                    $(this).trigger('onEndResizingIsotope');
            }, 100);
        }

	
	});
	
	//do something, window hasn't changed size in 100ms
    $(window).bind('onEndResizingIsotope', function() {
        $('.filters-group .filter-item').each(function(){
            if ( $(this).attr('data-filter') == $filterValue ){ 
                $(this).trigger('click');
            }
        })
    });

    $(window).scroll(function() {
			
		if ( $(this).scrollTop() > 0 ) {
			$('#page_wrapper.sticky_header .top-headers-wrapper').addClass('on_page_scroll');
		} else {
			$('#page_wrapper.sticky_header .top-headers-wrapper').removeClass('on_page_scroll');
		}	
			
    	//$('#page_wrapper.sticky_header .top-headers-wrapper').css('top', $(window).scrollTop());
		
		//animate products
        if ($(window).innerWidth() > 640 ) {
			$(".products li").each(function(i, el) {
				if ($(el).visible(true)) {
					$(el).addClass("animate"); 
				} 
			});
		}
        
        //mark this selector as visible
        $("section.related, #site-footer").each(function(i, el) {
            if ($(el).visible(true)) {
                $(el).addClass("on_screen");
				
            } else {
                $(el).removeClass("on_screen");
				
            }
        });
        
		//single post overlay -  only for large-up
		if ( $(window).width() > 1024 ) {
			$('.single-post-header-overlay').css('opacity', 0.3 + ($(window).scrollTop()) / (($(window).height())*1.4) );
		}
		
		//chrome bg fix
		//refreshBackgrounds(".st-content");
        
    });

	// WISHLIST

	if ($('body').hasClass('woocommerce-wishlist'))
	{
		if ($('td.wishlist-empty').length)
		{
			$('h1.page-title').hide();
		}
	}

	$('.widget_layered_nav span.count, .widget_product_categories span.count').each(function(){
		var count = $(this).html();
		count = count.substring(1, count.length-1);
		$(this).html(count);
	})

	/******************** average rating widget ****************************/
	$('.widget_rating_filter ul li a').each(function(){
		var count = $(this).contents().filter(function(){ 
		  return this.nodeType == 3; 
		})[0].nodeValue;

		$(this).contents().filter(function(){ 
		  return this.nodeType == 3; 
		})[0].nodeValue = '';

		count = count.slice(2,-1);
		
		$(this).append('<span class="count">' + count + '</span>');
	})

	/********************** my account tabs by url **************************/
	if ( ('form#register').length > 0 )
	{
		var hash = window.location.hash;
		if (hash)
		{
			$('.account-tab-link').removeClass('current');
			$('a[href="'+hash+'"]').addClass('current');

			hash = hash.substring(1);
			$('.account-forms > form').hide();
			$('form#'+hash).show();
		}
	}


	/************************************************************************/
	/****************************** BACK TO TOP *****************************/
	/************************************************************************/

	var offset = 300,
	//browser window scroll (in pixels) after which the "back to top" link opacity is reduced
	offset_opacity = 1200,
	//duration of the top scrolling animation (in ms)
	scroll_top_duration = 700,
	//grab the "back to top" link
	$back_to_top = $('.cd-top');

	//hide or show the "back to top" link
	$(window).scroll(function(){
		( $(this).scrollTop() > offset ) ? $back_to_top.addClass('cd-is-visible') : $back_to_top.removeClass('cd-is-visible cd-fade-out');
		if( $(this).scrollTop() > offset_opacity ) { 
			$back_to_top.addClass('cd-fade-out');
		}
	});

	//smooth scroll to top
	$back_to_top.on('click', function(event){
		event.preventDefault();
		$('body,html').animate({
			scrollTop: 0 ,
		 	}, scroll_top_duration
		);
	});
	 

});

jQuery(function($) {
	
	"use strict";
	
	// browser window scroll (in pixels) after which the "back to top" link is shown
	var offset = 300,
		//browser window scroll (in pixels) after which the "back to top" link opacity is reduced
		offset_opacity = 1200,
		//duration of the top scrolling animation (in ms)
		scroll_top_duration = 700,
		//grab the "back to top" link
		$back_to_top = $('.cd-top');

	//hide or show the "back to top" link
	$(window).scroll(function(){
		( $(this).scrollTop() > offset ) ? $back_to_top.addClass('cd-is-visible') : $back_to_top.removeClass('cd-is-visible cd-fade-out');
		if( $(this).scrollTop() > offset_opacity ) { 
			$back_to_top.addClass('cd-fade-out');
		}
	});

	//smooth scroll to top
	$back_to_top.on('click', function(event){
		event.preventDefault();
		$('body,html').animate({
			scrollTop: 0 ,
		 	}, scroll_top_duration
		);
	});

});

jQuery(document).ready(function ($) {

	function bs_fix_vc_full_width_row() {

        var elements = $('[data-vc-full-width="true"]');
        $.each(elements, function () {
            var el = jQuery(this);
            el.css('right', el.css('left')).css('left', '');
        });

    }

	// Fixes rows in RTL
    if( $('body').hasClass("rtl") ) {
        $(document).on('vc-full-width-row', function () {
            bs_fix_vc_full_width_row();
        });
    }

    // Run one time because it was not firing in Mac/Firefox and Windows/Edge some times
    if ($('body').hasClass("rtl")) {
        bs_fix_vc_full_width_row();
    }

	// blog sidebar fix

	if ($('.blog-sidebar').length > 0)
	{
		if ($('.blog-sidebar').height() > $('.blog-isotop-container').height())
		{
			$('.blog-isotop-container').height($('.blog-sidebar').height() + 100);
		}
	}

	$(window).resize(function(){
		if ($('.blog-sidebar').length > 0)
		{
			if ($('.blog-sidebar').height() > $('.blog-isotop-container').height())
			{
				$('.blog-isotop-container').height($('.blog-sidebar').height() + 100);
			}
		}
	})

	// Checkout Form Submit Arrow at Focus

	$(document).on('focus', '.woocommerce-cart #content table.cart td.actions .coupon #coupon_code', function() {
		$('.woocommerce-cart #content table.cart td.actions .coupon').addClass('focus');
	});

	$(document).on('focusout', '.woocommerce-cart #content table.cart td.actions .coupon #coupon_code', function() {
		$('.woocommerce-cart #content table.cart td.actions .coupon').removeClass('focus');
	});

	$(document).on('focus', 'form.checkout_coupon #coupon_code', function() {
		$('form.checkout_coupon .checkout_coupon_inner').addClass('focus');
	});

	$(document).on('focusout', 'form.checkout_coupon #coupon_code', function() {
		$('form.checkout_coupon .checkout_coupon_inner').removeClass('focus');
	});


	// IF admin bar exists, keep same paddings for offcanvas
	if ( $('#wpadminbar').length > 0 && $(window).width() <= 1024 ) {
		$('.st-menu').css('top', '32px')
	}
	
});

jQuery(document).ready(function ($) {

	$(window).load(function() {
		$(".vc_images_carousel").each(function() {
			var height = $(this).find(".vc_item.vc_active").height();
			$(this).css("height", height);
		});
	});

	$(".vc_images_carousel").on('click', '.vc_right, .vc_left, .vc_carousel-indicators li', function(){

		var that = $(this);

		setTimeout(function(){
			var height = that.parents(".vc_images_carousel").find(".vc_item.vc_active").height();
			that.parents(".vc_images_carousel").css("height", height);
		}, 600);
			

	});

});

jQuery(function($) {

	// set focus on search input field in off-canvas
	$(document).on('click touchend', 'header .site-tools .search-button .spk-icon-search', function(){
		setTimeout( function(){
			$(".off-canvas .woocommerce-product-search .search-field").focus();
		}, 800);
	});

	// close off-canvas when 'ESC' is pressed
	$(document).keyup(function(event){
		//check if user has pressed 'Esc'
    	if( ( event.which=='27' ) && ( $('.off-canvas').length ) && ( $('.off-canvas').hasClass('is-open') ) ) {
    		$('.off-canvas').foundation('close');
		}
	});

});

// When Viewport Height is equal with 768, make the minicart image smaller
jQuery(function($) {

	var windowHeight 		 = $(window).height();
	var minicart_product_img = $('.shopkeeper-mini-cart .widget.woocommerce.widget_shopping_cart .widget_shopping_cart_content .cart_list.product_list_widget li.mini_cart_item .product-item-bg');

	if ( windowHeight == 768) {
		minicart_product_img.addClass('smaller-vh');
	} else {
		minicart_product_img.removeClass('smaller-vh');
	}

	// If both facebook messenger and get this theme plugins exists, make them look nice
	if ( $('#fbmsg').length ) {

		if ( $('.getbowtied_get_this_theme').length ) {
			$('#fbmsg').addClass('gbt_plugin_installed');
		} else {
			$('#fbmsg').removeClass('gbt_plugin_installed');
		}
	}

});

jQuery(function($) {
	
	"use strict";

	$("body.single-product form.cart").on("change", "input.qty, input.custom-qty", function() {
        $('button.single_add_to_cart_button.ajax_add_to_cart').data("quantity", this.value);
    });

	$('.cd-quick-view form.cart input[name="quantity"]').trigger('change');

});

jQuery(function($) {

	//progress add to cart button
	$("button.single_add_to_cart_button.ajax_add_to_cart.progress-btn").on("click", function(e) {
		var progressBtn = $(this);

		if (!progressBtn.hasClass("active")) {
		  progressBtn.addClass("active");
		  setTimeout(function() {
		  	progressBtn.addClass("check");
		  }, 3000);
		  setTimeout(function() {
		  	progressBtn.removeClass("active");
		  	progressBtn.removeClass("check");
		  }, 5000);
		}
	});
});

jQuery(document).foundation();