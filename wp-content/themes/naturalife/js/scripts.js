/*!
 * jQuery RT Parallax Backgrounds
 * Author: RT-Themes
 * Copyright (C) RT-Themes
 */


;(function ( $, window, document, undefined ) {
	"use strict"; 

	/**	
	 * Creates a parallax
	 * @class The RT Parallax
	 * @public
	 * @param {Object} [options] - The options
	 */
	function rtprlx(element, options) {

		/**
		 * Current settings
		 * @public
		 */
		this.settings = null;

		/**
		 * Current options set by the caller including defaults.
		 * @public
		 */
		this.options = $.extend({}, rtprlx.Defaults, options);

		/**
		 * Plugin element.
		 * @public
		 */
		this.$element = $(element);

		/**
		 * Check if it is a mobile browser with touch events
		 */
		if( this.istouchDevice() && this.ismobileDevice() ){
			this.$element.show();
			return;
		}

		/**
		 * initialize
		 */
		this.refresh();
		this.initialize();
	}

	/**
	 * Default options for rtprlx
	 * @public
	 */
	rtprlx.Defaults = {
		speed_min : 1.35 // min value for the speed
	};


	/**
	 * Check if touch enabled
	 * @protected
	 */
	rtprlx.prototype.istouchDevice = function() {
		try{ document.createEvent("TouchEvent"); return true; }
		catch(e){ return false; }
	};


	/**
	 * Check if it is a mobile OS
	 * @protected
	 */
 	rtprlx.prototype.ismobileDevice = function() {
		if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
			return true;
		}
 	};


	/**
	 * Initializes rtprlx
	 * @protected
	 */
	rtprlx.prototype.initialize = function() {

		var $this = this;

		$this.win.on("resize refresh-rtprlx",function(){
			$this.refresh();
			$this.parallax();
		});

		$this.parallax();

		$this.win.on("scroll.rtprlx",function(){
			$this.parallax();
		});

		$this.$element.show();
	};

	/**
	 * Initializes rtprlx
	 * @protected
	 */
	rtprlx.prototype.parallax = function() {


		var maxscroll 	= ( this.winH + this.win.scrollTop() ) -  this.itemTop;
		var rate      	= this.invisible_part / ( this.winH + this.row_height );
		var isvisible 	= maxscroll > 0 && this.itemBottom > this.win.scrollTop();

		if( ! isvisible ) {
			return;
		}

		var move_rate =  maxscroll * rate;

		if( this.effect == "vertical" ){
			var yPos =  this.direction == 1 ? -1 * move_rate : -1 * this.invisible_part + move_rate;
			this.apply_css(0, yPos);
		}else{
			var xPos =  this.direction == 1 ? -1 * move_rate : -1 * this.invisible_part + move_rate;
			this.apply_css(xPos, 0);
		}

	};


	/**
	 * Refresh rtprlx vars
	 * @protected
	 */
	rtprlx.prototype.refresh = function() {

		this.row            = this.options.parent_row ? this.options.parent_row : this.$element.parents("div:eq(0)");
		this.effect         = this.$element.attr("data-rt-parallax-effect");// vertical, horizontal
		this.direction      = this.$element.attr("data-rt-parallax-direction"); // -1 down/right , 1 up/left
		this.speed          = Math.max( parseInt(this.$element.attr("data-rt-parallax-speed")), this.options.speed_min );  //relative value with the css row height
		this.row_height     = this.row.outerHeight();
		this.row_width      = this.row.outerWidth();
		this.holder_height  = this.effect == "vertical" ? this.row_height * this.speed : this.row_height ;
		this.holder_width   = this.effect == "horizontal" ? this.row_width * this.speed : this.row_width + 4 ;

		this.invisible_part = this.effect == "vertical" ? this.holder_height - this.row_height : this.holder_width - this.row_width,
		this.posTop         = this.row.offset().top,
		this.itemBottom     = this.posTop + this.row_height;
		this.itemTop        = this.posTop;
		this.win            = $(window);
		this.winH           = $(window).height();
		this.winW           = $(window).width();


		this.start_position = this.direction == -1 ? -1 * this.invisible_part : 0;


		this.$element.css({ "height":this.holder_height, "width":this.holder_width+"px" });

		if( this.effect == "vertical" ){
			this.apply_css(0, this.start_position);
		}else{
			this.apply_css(this.start_position, 0);
		}

	};


	/**
	 * Apply css
	 * @protected
	 */
	rtprlx.prototype.apply_css = function( x, y ) {

			var is_rtl = $("body").hasClass("rtl");

			//if it is rtl language make it reverse
			x = is_rtl ? -1 * x : x;

			this.$element.css({
				"-webkit-transform": "translate3d("+x+"px, "+y+"px,0)",
				"-moz-transform": "translate3d("+x+"px, "+y+"px,0)",
				"-ms-transform": "translate3d("+x+"px, "+y+"px,0)",
				"-o-transform": "translate3d("+x+"px, "+y+"px,0)",
				"transform": "translate3d("+x+"px, "+y+"px,0)"
			});

	};


	/**
	 * The jQuery Plugin
	 * @public
	 */
	$.fn.rtprlx = function(options) {
		return this.each(function() {
			if (!$.data(this, 'rtprlx')) {
				$.data(this, 'rtprlx', new rtprlx( this, options ));
			}
		});
	};
})( jQuery, window, document );



/*!
 * naturalife WordPress Theme Scripts
 * Copyright (C) 2017 RT-Themes
 * http://rtthemes.com
 *
 * various scripts file
 */
(function($){
"use strict";

	/* *******************************************************************************

		GLOBAL VARS

	***********************************************************************************/
	var is_rtl = $("body").hasClass("rtl");
	var window_width = $(window).width();
	var window_height = $(window).height();


	/* *******************************************************************************

		LOADERS

	***********************************************************************************/

	$('html').imagesLoaded( { background: ".has-bg-image, body, .slide-background" }, function() {	//all images loaded
		$(window).trigger("rt_images_loaded");
	});

	$(window).on('rt_images_loaded', function() { //window and all images loaded
		if( document.readyState === "complete" ){
			$(window).trigger("rt_loaded");
		}else{
			$(window).on('load', function() {
				$(window).trigger("rt_loaded");
			});
		}
	});

	$(document).ajaxComplete(function() {//check completed ajax requests
		$(window).trigger("rt_ajax_complete"); 
	});

	/* *******************************************************************************

		ON PAGE LOAD

	***********************************************************************************/

	var loading_lgoo_img = $('.loading-logo');

	loading_lgoo_img.waitForImages(function() {
		loading_lgoo_img.css({"opacity":1});
	});

	$(window).on("rt_loaded",function(){

		if( $("body").hasClass("rt-loading") ){
			$("body").addClass("rt-loaded");
			$(window).scrollTop(0);
			
			setTimeout(function() {	 
				$("#loader-wrapper").remove();		  
			}, 650 );	
		}

		setTimeout(function(){
			$("body").removeClass("rt-loading");
		},200);

	});


	/* *******************************************************************************

		ON LEAVE

	***********************************************************************************/

	if( ! $.fn.rt_on_leave ){

		$.fn.rt_on_leave = function()
		{

		$('a[href^="'+rtframework_params["home_url"]+'"]').on("click", function(e){

			if( $.fn.is_mobile_menu() ){
				return;
			}

			if( $(this).attr("target") && $(this).attr("target") != "" ){
				if( $(this).attr("target") !== "_self" ){
					return;
				}
			}

			if ( window.parent.location !== window.location ) {//check if customizer active
				return;
			}

			var cur_url = window.location.host + window.location.pathname + window.location.search;
			var target_url = this.host + this.pathname + this.search;
			var target_extension = this.pathname.split('.');
			var search = this.search;

			if( cur_url == target_url || search.indexOf("replytocom") == 1 ){
				return;
			}

			if( typeof target_extension[1] != "undefined" && typeof target_extension[1] != "php" && typeof target_extension[1] != "html"  ){
				return;
			}

			if ( e.ctrlKey || e.shiftKey || e.metaKey || (e.button && e.button == 1) ){
				return;
			}

			$("body").addClass("rt-leaving");


			var href = this.href;
			window.location = href;

			return false;

		});

		};
	}

	$(window).on("rt_loaded",function(){
		if($("body").hasClass("rt-transition")){
			$.fn.rt_on_leave();	
		}
	});


	/* *******************************************************************************

		WINDOW WIDTH RESIZE ONLY

	***********************************************************************************/

	$(window).resize(function(){
		if($(this).width() != window_width){
			window_width = $(this).width();
			$(window).trigger("window_width_resize");
		}
	});

	/* *******************************************************************************

		WINDOW HEIGHT RESIZE ONLY

	***********************************************************************************/

	$(window).resize(function(){
		if($(this).height() != window_height){
			window_height = $(this).height();
			$(window).trigger("window_height_resize");
		}
	});

	/* *******************************************************************************

		CHECK IF THE HIDDEN MOBILE MENU ACTIVE

	***********************************************************************************/
	if( ! $.fn.is_mobile_menu ){

		$.fn.is_mobile_menu = function()
		{
			return Modernizr.mq('(max-width: 1024px)');
		};
	}


	/* *******************************************************************************

		STICKY HEADER

	********************************************************************************** */


	if( ! $.fn.rt_sticky_header ){

		$.fn.rt_sticky_header = function()
		{
				if( $(this).length == 0 ){
					return;
				}

				var header = $(this),
					body = $("body"), 
					header_normal_height = $(".top-header").outerHeight(),
					header_offset = $(".top-header").offset().top,
					release_point = $("#main-content > div:not(.sub-page-header):eq(0)").offset().top,
					release_point =  release_point < header_normal_height ? header_normal_height + header_offset : release_point,
					top_bar_height = $(".naturalife-top-bar").outerHeight(),
					wp_admin_bar_height = 0 + $("#wpadminbar").outerHeight(),
					lastScrollTop = 0,
					direction = body.hasClass("sticky-header-style-1") ? "down" : "always",
					scroll_direction = "";


				if( header.length > 0 ){

					//scroll function
					$(window).scroll(function(event) {


						if( $.fn.is_mobile_menu() ){
							return;
						}

						var y = $(window).scrollTop();
						var header_stuck = body.hasClass("stuck");

						if( y < 0 ){
							return;
						}

						//detect direction
						if (y > lastScrollTop){
							scroll_direction = "down";
						} else {
							scroll_direction = "up";
						}
						lastScrollTop = y;
 
						if( y < release_point + 50 ){ 
							body.removeClass( "header-stuck  header-long-distance" );
							return;
						}

						if( y < release_point + 150 ){ 
							body.removeClass( "header-stuck" );
							return;
						}

						if( direction == "always" && y > 500 ){
							body.addClass( "header-stuck header-long-distance" );
							return;
						}

						if( scroll_direction == "up" && y > 500 ){
							body.addClass( "header-stuck header-long-distance" );
							return;
						}

						if( scroll_direction == "down" ){
							body.removeClass( "header-stuck" );
							return;
						} 
					});
				}
		};

	}

	// Add space for Elementor Menu Anchor link
	$( window ).on( 'elementor/frontend/init', function() {	 
		elementorFrontend.hooks.addFilter( 'frontend/handlers/menu_anchor/scroll_top_distance', function( scrollTop ) {
			if( !$.fn.is_mobile_menu()  && $("body").hasClass("sticky-header-style-2") ){
				return scrollTop - 60;	//60px sticky header height
			}
			return scrollTop;
		} );
	} );

	$(window).on('rt_loaded resize', function() {
		$(".sticky-header-holder").rt_sticky_header();
	});



	/* *******************************************************************************

		STICKY MOBILE HEADER
		admin bar fix

	********************************************************************************** */
	if( ! $.fn.rt_sticky_mobile_header ){

		$.fn.rt_sticky_mobile_header = function()
		{
 				if( $(window).width() > 600 ){
 					if($(window).width() < 1024){
 						$(".mobile-header-stuck").removeClass("mobile-header-stuck");
 						$(window).off("scroll.mobile-header");
 					} 
 					return;
 				}

				var header = $(this); 
				if( header.length > 0 ){

					//scroll function
					$(window).on("scroll.mobile-header", function( event ){
						var y = $(window).scrollTop(); 

						if( y < 0 || y > 200){
							return;
						}
 
						if(  y > 46 ){ 
							header.addClass("mobile-header-stuck")
							$("body").removeClass("admin-bar");
							return;
						}
 
 						if(  y < 100 ){ 
							header.removeClass("mobile-header-stuck")
							$("body").addClass("admin-bar");
							return;
						}
					});
				}
		};
	}
 
	$(window).on('rt_loaded resize', function() {
		$(".admin-bar.sticky-mobile-header .mobile-header").rt_sticky_mobile_header();
	});

	/* ******************************************************************************* 

		FIXED FOOOTERS

	********************************************************************************** */  

	if( ! $.fn.rt_fixed_footers ){

		$.fn.rt_fixed_footers = function()
		{ 
			if( $("body.elementor-editor-active").length > 0 ){
				return;
			}

			if( $(this).length < 1 ){
				return;
			}

			var main_content = $("#main-content"), 
				footer = $("#footer"),
				footer_height = footer.outerHeight(true); 

			if( footer.length == 0 ){
				return;
			}

			if ( Modernizr.touch ) {
				$("body").removeClass( "naturalife-fixed-footer-acitve" );
				return;
			}			

			function deactive(){
				$("body").removeClass( "naturalife-fixed-footer-acitve" );
				main_content.css( { "margin-bottom" : "" });
			}

			if( $("body").outerHeight() - $(window).height() < footer_height ){
				deactive();
				return;
			} 

			if( $(window).height() - 100 < footer_height   ){
				deactive();
				return;
			}			

			$("body").addClass( "naturalife-fixed-footer-acitve" );		
			main_content.css( { "margin-bottom" : footer_height +"px" });	

			$(window).off("scroll.footer");
		};
	}

	if ( $.fn.rt_fixed_footers ) {  
		$(window).on('rt_loaded', function() {  	

			if( $.fn.is_mobile_menu() ){
				return;
			}	

			$(window).on("scroll.footer", function( event ){

				var footer = $("#footer");

				if( footer.length == 0 ){
					return;
				}				
				if( footer.offset().top - 300 < $(window).scrollTop() + $(window).outerHeight() ){					
					$('.naturalife-fixed-footer').rt_fixed_footers(); 
				}
			});

			$(window).on('rt_ajax_complete resize', function() {  	
				setTimeout(function() {	 
					$('.naturalife-fixed-footer').rt_fixed_footers();
				}, 200 );	
			}); 				
		}); 		
	}

	/* *******************************************************************************

		IMG effects

	********************************************************************************** */

	if( ! $.fn.rt_image_hover ){

		$.fn.rt_image_hover = function()
		{
			$(this).each(function(){
				var button = $(this).find(".action-button");

				if( button.length > 0 ){
					return;
				}
				$(this).append('<span class="action-button"></span>'); 
			});
		};
	}

	$(window).on('resize load', function() {
		$(".imgeffect").rt_image_hover();
	});

	if( ! $.fn.rt_image_overlays ){

		$.fn.rt_image_overlays = function()
		{
			$(this).each(function(){
				 
				var img = $(this).find("img"), 
					img_w = img.width();

				if( img_w == 0 ){
					img_w = img.attr("width");	
				}

				if( img_w == 0 ){
					img_w = "auto";	
				}				
				$(this).css({"max-width":parseInt(img_w)});	

			});
		};
	}

	$(window).on('resize load', function(e) {
		if( e.type == "resize" ){
			$(".has-overlay, .imgeffect").css({"max-width":"100%"});	
		}
		setTimeout(function() {		
			$(".has-overlay, .imgeffect").rt_image_overlays();
		},300);
	});


	/* *******************************************************************************

		CALCULATE DISTANCE

	***********************************************************************************/
	if( ! $.fn.rt_calc_distance ){

		$.fn.rt_calc_distance = function( target ){

			//vars
			var wp_admin_bar_height = $("#wpadminbar").outerHeight();
			var sticky_header = $(".sticky-header .top-header");
			var target_ofset = target.offset().top;
			var sticky_header_height = 85;

			//reduce position
			var distance = wp_admin_bar_height;

			if( target.offset().top > 30 ) {
				if( sticky_header.length > 0 ){
					distance += sticky_header_height;

				}
			}

			return target_ofset - distance;
		}
	}

	/* *******************************************************************************

		RT ONE PAGE

	***********************************************************************************/

	if( ! $.fn.rt_one_page ){

		$.fn.rt_one_page = function()
		{

			if( window.location.hash ){

				var target = $(window.location.hash);

				if( target.length > 0 && $('.main-menu a[href*="'+window.location.hash+'"]').length > 0 && ! target.hasClass("vc_tta-panel vc_active") ){
					rt_scroll_to( $.fn.rt_calc_distance( target ) , window.location.hash );
				}
			}

			$(this).on("click",function(e){

					var cur_url = window.location.host + window.location.pathname + window.location.search;
					var this_url = this.host + this.pathname + this.search;

					if( cur_url == this_url ){

						e.preventDefault();

						if( this.hash == "#top" ){ 
							rt_scroll_to( 0, "");
							return ;
						}

						//elementor pages doesn't need the rest of the function
						if( $("body").hasClass("elementor-page") ){
							return;
						}

						var target = $(this.hash);

						//if target is hidden
						if( target.hasClass("hidden-element") ){
							target = target.parents("*:eq(0)");
						}

						//if target doesn't exists
						if( target.length == 0 ){
							window.location = this.href;
							return ;
						}

						rt_scroll_to( $.fn.rt_calc_distance(target), this.hash);
					}
			});

			$(this).each(function(){

				var menu_item = $(this),
					hash = this.hash,
					section = $(hash);

				if( ! section.is(":visible") ){
					section = section.parents("*:eq(0)");
				}

				menu_item.parent("li").removeClass("current-menu-item current_page_item");

				section.appear(function(){
						rt_remove_active_menu_class();
						menu_item.parent("li").addClass("current-menu-item current_page_item");
				},{accX: 0, accY: -1 * section.height() / 2 , one:false});

			});


			function rt_remove_active_menu_class(){
				$(".main-menu > li.current-menu-item, .main-menu > li.current_page_item, .section-nav > li.current_page_item").removeClass("current-menu-item current_page_item");
			}

		};
	}

	if ( $.fn.rt_one_page ) {
		$(window).one("rt_loaded", function(){
			$($('.main-menu a[href*="#"]:not([href="#"]),.section-nav a[href*="#"]:not([href="#"]), .rt-scroll a[href*="#"]:not([href="#"]), a.rt-scroll[href*="#"]:not([href="#"])')).rt_one_page();
		});
	}

	/* *******************************************************************************

		SCROLLTO LINKS

	***********************************************************************************/
	$(".scroll").on("click",function(){

		if( this.hash == "#top" ){
			rt_scroll_to( 0, "");
			return ;
		}

		if( $(this.hash).length < 1 ){
			return ;
		}

		rt_scroll_to( $.fn.rt_calc_distance( $(this.hash) ), this.hash);
	});


	/* *******************************************************************************

		GO TO TOP LINK

	***********************************************************************************/

	if( ! $.fn.rtframework_go_to_top ){

		$.fn.rtframework_go_to_top = function()
		{
			var $this = $(this);
			$(window).trigger("scroll");

			$(window).on("scroll", function( event ){		

				var s_top = $(this).scrollTop();
				
				if( s_top > 400 || s_top < 600 ){
					if( s_top > 400 ){
						$this.addClass("visible");
					}else{
						$this.removeClass("visible");
					}
				}
			});

			$(this).on("click",function(e){
				rt_scroll_to( 0, "");
			});

		};
	}

	if ( $.fn.rtframework_go_to_top ) {
		$('.go-to-top').rtframework_go_to_top();
	}

	/* *******************************************************************************

		RT COUNTER

	***********************************************************************************/

	if( ! $.fn.rt_counter ){

		$.fn.rt_counter = function()
		{
			$(this).each(function(){
				var number_holder = $(this).find("> .number > span"),
					 number = number_holder.text();
						
						$(this).appear(function(){

							$({
								Counter: 0
							}).animate({
								Counter: number_holder.text()
							}, {
								duration: 1200,
								step: function () {
									number_holder.text(Math.ceil(this.Counter));
								},
								complete: function () {
									number_holder.text(number);
								}
							});

						},{accX: 0, accY: -30});
			});
		};
	}

	if ( $.fn.rt_counter ) {
		$(window).one("rt_loaded", function(){
			$('.rt_counter').rt_counter();
		});
	}

	/* *******************************************************************************

		RT SCROLL TO

	***********************************************************************************/

	function rt_scroll_to( to, hash ){

		$('html, body').stop().animate({
			'scrollTop': to
		}, 900, 'swing', function() {
			window.location.hash = hash;
			$('html,body').scrollTop(to);
		});
	}

	/* *******************************************************************************

		FIX FEATURES COLUMN POSITION OF COMPARE TABLES

	********************************************************************************** */

	if( ! $.fn.rt_tables ){

		$.fn.rt_tables = function()
		{

			//brings the features column position same with other columns
			function fix_compare_features( table ){

				$(table).each(function(i){

					var start_position_element = $(this).find(".start_position"),
					features_list = $(this).find(".table_wrap.features ul"),
					new_offset =  start_position_element.offset().top - $(this).offset().top;

					features_list.css("top",new_offset);
				});
			}


			//copy features to each column for mobile
			function copy_features( table ){

				var features;

				$(table).each(function(){

					features=[];
					//createa features array from the first row
					$(this).find(".table_wrap.features li").each(function(){
						features.push( $(this).html() );
					});

				});

				$(table).find(".table_wrap").each(function(i){

					if( $(this).hasClass("features") == "" ){
						var i = 0;
						$(this).find("li").each(function(){
							if( typeof features[i] != "undefined" ){
								$(this).prepend('<div class="d-lg-none">'+features[i]+'</div>');
							}
						i++;
						});
					}
				});
			}


			$(this).each(function(){

				var table = $(this);

				//bind to window resize
				$(window).bind("resize",table, function( ){
					fix_compare_features( table );
				});

				//start functions
				fix_compare_features( table );
				copy_features( table );

			});

		};
	}

	if ( $.fn.rt_tables ) {
		$('.pricing_table.compare').rt_tables();
	}


	/* *******************************************************************************

		TOGGLE - ACCORDION

	********************************************************************************** */
	if( ! $.fn.rt_accordion ){

		$.fn.rt_accordion = function()
		{	
			$(this).each(function () {

					$(this).find(".toggle-content").hide();
					$(this).find(".open .toggle-content").show();

					$(this).find("ol li .toggle-head").on("click",function(){

						clearTimeout("accordion_timeout");

						var element = $(this).parent("li"),
							content = element.find(".toggle-content");

						if( element.hasClass("open")){
							element.removeClass("open");
							content.stop().slideUp(300);

						}else{

							$(this).parents("ol").find("li.open").removeClass("open").find(".toggle-content").stop().slideUp(300);

							element.addClass("open");
							content.stop().slideDown(300,function(){
								fix_accordion_pos();
							});

						}

						function fix_accordion_pos(){
							if( $(window).scrollTop() > element.offset().top ){
								var accordion_timeout = setTimeout(function() {
									var add = $("#wpadminbar").outerHeight() + $(".top-header.stuck").outerHeight();
									rt_scroll_to( element.offset().top - add, "");
								}, 100 );
							}
						}
					});

			});					
		};
	}

	if ( $.fn.rt_accordion ) {
		$(".rt-toggle").rt_accordion();
	}

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

				//nav height fix
				height_fix(1);

				//mobile nav clicks
				mobile_nav_element.on("click",function(){
					close_all();
					open_tab( $(this).attr("data-tab-number") );
				})

				//desktop nav clicks
				desktop_nav_element.on("click",function(){
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
						tab_content_wrapper = tabs.find('[data-tab-content="'+tab_number+'"]');

						nav_item.addClass("active");
						tab_content_wrapper.addClass("active");
						height_fix( tab_number );

						//fix custom select forms
						$.fn.rt_customized_selects( tab_content_wrapper );
						tab_content_wrapper.find('span.customselect').remove();
						tab_content_wrapper.find('select.hasCustomSelect').removeAttr("style");
						$.fn.rt_customized_selects( tab_content_wrapper );

						if( window_width < 767 ){
							rt_scroll_to( tab_content_wrapper.offset().top, "" );
						}
				}

				//height fix -  vertical style
				function height_fix( tab_number ) {
					if( tab_style == "tab-position-2" ){
						var current_tab_height = tabs.find('[data-tab-content="'+tab_number+'"]').outerHeight();
						tab_nav.css({"min-height":current_tab_height+"px"});
					}
				}

			});

		};
	}

	if ( $.fn.rt_tabs ) {
		$('.rt_tabs').rt_tabs();
	}

	/* *******************************************************************************

		START CAROUSELS

	********************************************************************************** */

	$.fn.rt_start_carousels = function( callbacks ) {

		//mobile (responsive) heading sizes for the main content carousel
		//createa a css and append to body for screens only below 768px
		$(".main-carousel").each(function(){

			var create_css = "",
				 unique_class_name = "",
				 mobile_height = $(this).data("mobile-height"),
			     tablet_height = $(this).data("tablet-height");

			create_css += "#"+$(this).attr("id")+" .item{min-height:"+mobile_height+"px !important;}";
			create_css += "#"+$(this).attr("id")+" .slide-background{height:"+mobile_height+"px !important;}";
			create_css += "#"+$(this).attr("id")+" .owl-nav div{top:"+mobile_height/2+"px !important;}";
			create_css += "#"+$(this).attr("id")+" .slide-content{margin-top:"+mobile_height+"px !important;}";


			$("<style>@media screen and (max-width: 475px) {"+create_css+"}</style>").prependTo($("body"));

			create_css = "";

			$(this).find(".slide_heading").each(function(){
				unique_class_name = "heading-" + Math.floor((Math.random() * 100000) + 1);
				$(this).addClass(unique_class_name);
				create_css += "."+unique_class_name+"{font-size:"+$(this).data("mobile-value")+"px !important;}";
			});

			$(this).find(".slide-text").each(function(){
				unique_class_name = "text-" + Math.floor((Math.random() * 100000) + 1);
				$(this).addClass(unique_class_name);
				create_css += "."+unique_class_name+"{font-size:"+$(this).data("mobile-value")+"px !important;}";
			});

			$(this).find(".slide-background").each(function(){
				unique_class_name = "bg-" + Math.floor((Math.random() * 100000) + 1);
				$(this).addClass(unique_class_name);
				create_css += "."+unique_class_name+"{background-position:"+$(this).data("bgpos")+" !important;}";
			});

			create_css += "#"+$(this).attr("id")+" .item{min-height:"+tablet_height+"px !important;}";
			create_css += "#"+$(this).attr("id")+" .slide-background{height:"+tablet_height+"px !important;}";
			create_css += "#"+$(this).attr("id")+" .owl-nav div{top:"+tablet_height/2+"px !important;}";
			create_css += "#"+$(this).attr("id")+" .slide-content{margin-top:"+tablet_height+"px !important;}";

			$("<style>@media screen and (max-width: 1024px) {"+create_css+"}</style>").prependTo($("body"));

		});

		//craete carousels
		$(this).find(".rt-carousel:not(.manual-start)").each(function(){

			var autoHeight_,
				margin = $(this).data("margin") !== ""  && typeof $(this).data("margin") != "undefined" ? $(this).data("margin") : 15,
				padding = $(this).data("padding") !== "" && typeof $(this).data("padding") != "undefined" ? $(this).data("padding") : 0,
				carousel_holder = $(this),
				min_height = carousel_holder.data("min-height"),
				items = parseInt($(this).attr("data-item-width")),//number of items of each slides
				tablet_items = typeof $(this).data("tablet-item-width") != "undefined" && $(this).data("tablet-item-width") != "" ? parseInt($(this).attr("data-tablet-item-width")) : ( items == 1 ) ? 1 : 2 ,//number of items of each slides
				mobile_items = typeof $(this).data("mobile-item-width") != "undefined" ? parseInt($(this).attr("data-mobile-item-width")) : 1,//number of items of each slides
				nav = $(this).attr("data-nav") == "true" ? true : false,
				dots = $(this).attr("data-dots") == "true" ? true : false,
				thumbnails = $(this).attr("data-thumbnails") == "true" ? true : false,
				boxed = $(this).attr("data-boxed") == "true" ? true : false,
				fullheight = $(this).attr("data-fullheight") == "true" ? true : false,
				timeout = typeof $(this).attr("data-timeout") != "undefined" ? $(this).data("timeout") : 5000,
				autoplay = $(this).data("autoplay") != "undefined" ? $(this).data("autoplay") : false,
				loop = typeof $(this).data("loop") != "undefined" && $(this).data("loop") != "" ? true : false,
				carousel_id = $(this).attr("id"),
				is_main_carousel = carousel_holder.hasClass("main-carousel");

			//auto height & margin
			if( items == 1 && padding == 0 ){
				autoHeight_ = true;
				margin = 0;
			}else{
				autoHeight_ = false;
				margin = margin;
			}

			//tablet mobile layout defaults
			tablet_items = tablet_items || 1;
			mobile_items = mobile_items || 1; 
			
			//start carousel
			var carousel = carousel_holder.find(".owl-carousel");

			//loaded
			carousel_holder.addClass("rt-carousel-loaded");

			carousel.imagesLoaded( { background: ".has-bg-image" }, function( instance ) {

				if( instance.images.length == 1 ){
					nav = dots = false;
				}

				//color tones for main slider
				$(window).on("header_normal_pos",function(){
					carousel.trigger("carousel_header_style");
				});
				carousel.on('initialized.owl.carousel changed.owl.carousel carousel_header_style', function(e) {

					if( e.item ){
						var current_slide = $(this).find('.owl-item:eq('+e.item["index"]+')');
					}else{
						var current_slide = $(this).find('.owl-item.active');
					}

					if( ! is_main_carousel || current_slide.length === 0 ){
						return;
					}

					var skin = current_slide.find("> .item").data("color-tone");

					if( undefined === skin || "" == skin ) {
						return;
					}

					carousel_holder.removeClass("dark-bg-tone light-bg-tone");
					carousel_holder.addClass(skin+"-bg-tone");

					if( window_width < 1024 || $(".top-header").hasClass("stuck") ){
						return ;
					}

					//check if the carousel is in the first row of an overlapped-header page
					if( ! carousel.parents(".elementor-top-section").last().is($(".overlapped-header .elementor-section-wrap > .elementor-top-section:first-child") ) ){
						return;
					}

					$("body.overlapped-header .dynamic-skin").removeClass("naturalife-dark-header naturalife-light-header");
					$("body.overlapped-header .dynamic-skin").addClass("naturalife-"+skin+"-header");
				});

				//thumb navigation
				carousel.on('changed.owl.carousel initialized.owl.carousel', function(e) {

					if( ! thumbnails ){
						return;
					}

					$('#'+carousel_id +"-thumbnails > a.active").removeClass("active");
					$('#'+carousel_id +"-thumbnails > a:eq("+e.item.index+")").addClass("active");
				});

				//text navigation
				$('#'+carousel_id +"-thumbnails > a").on('click dblclick', function(event) {

					if( "dblclick" == event.type){
						event.preventDefault();
						return;
					}

					var id = $(this).data("href"); 
					carousel.trigger('to.owl.carousel',  [id, 300, true]);
				});

				//make full height
				if( fullheight ){
					carousel.on('initialized.owl.carousel', function(e) {
						make_full_height(carousel,min_height ); });

					$(window).on('window_height_resize', function() {
						make_full_height(carousel,min_height );
						carousel.trigger('refresh.owl.carousel');
					});
				}

				//select arrow set
				if( is_main_carousel ){
					var arrowset = ! is_rtl ? ["<span class=\"ui-icon-left-arrow-1\"></span>","<span class=\"ui-icon-right-arrow-1\"></span>"] : ["<span class=\"ui-icon-right-arrow-1\"></span>","<span class=\"ui-icon-left-arrow-1\"></span>"] ;
				}else{
					var arrowset = ! is_rtl ? ["<span class=\"ui-icon-angle-left\"></span>","<span class=\" ui-icon-angle-right\"></span>"] : ["<span class=\"ui-icon-angle-right\"></span>","<span class=\"ui-icon-angle-left\"></span>"] ;
				}

				//carousel object
				carousel.owlCarousel({
					rtl: is_rtl ? true : false,
					loop:loop,
					autoplayTimeout : timeout,
					autoplay:autoplay,
					autoplayHoverPause:true,
					margin:margin,
					responsiveClass:true,
					URLhashListener:thumbnails,
					startPosition: 'URLHash',
					autoplaySpeed:700,
					navSpeed: items == 1 ? 700 : 300,
					dotsSpeed: 300,
					autoHeightClass: 'owl-height',
					navText: nav ? arrowset : '',
					animateOut: is_main_carousel ? 'fadeOut' : false,
					animateIn: is_main_carousel ? 'fadeIn' : false,
					rewind: is_main_carousel ? true : false, 					 

					responsive:{
						0:{
							items:mobile_items,
							nav:nav,
							dots:dots,
							autoHeight: 1,
							dotsContainer: "#"+carousel_id+"-dots",
							stagePadding: 0
						},
						768:{
							items:tablet_items,
							nav:nav,
							dots:dots,
							autoHeight: 1,
							dotsContainer: "#"+carousel_id+"-dots",
							stagePadding: padding / 2
						},
						1025:{
							items:items,
							nav:nav,
							dots:dots,
							autoHeight: 1,
							dotsContainer: "#"+carousel_id+"-dots",
							stagePadding: padding,
							mouseDrag: is_main_carousel ?  false  : true,
							autoplayHoverPause: false
						}
					},
					onInitialized: callbacks ? callbacks._onInitialized : isotope_layout,
					onChanged: callbacks ? callbacks._onChanged : "",
					onRefreshed: callbacks ? callbacks._onRefreshed : "",
					onTranslated: isotope_layout,
				});

				//lightboxes
				carousel.on('changed.owl.carousel', function(e) {

					if( ! loop ){
						return;
					}

					carousel.rt_lightbox("init");
				});

			});
		});

		//reset isotopes after carousel
		function isotope_layout(){

			var isotope_gallery = $(".masonry-gallery");

			if( isotope_gallery.length > 0 ){
				setTimeout(function() {
					isotope_gallery.isotope('layout');
				}, 1000);
			}
		}

		//get highest item of the carousel
		function get_highest_item( carousel ){
			var heights = [];
			carousel.find(".owl-item").each(function(){
				heights.push($(this).outerHeight());
			});

			return Math.max.apply(null, heights);
		}

		//reset carousel item heights
		function reset_carousel_heights( carousel, items, mobile_items, tablet_items, carousel_holder ){

			var is_image_carousel = carousel_holder.hasClass("rt-image-carousel");

			carousel.find(".owl-item > div").each(function(){
				$(this).css({"height": ""});
			});
		}

		//make all carousel items in same height
		function make_same_height( carousel, items, mobile_items, tablet_items, carousel_holder ){

			if( mobile_items == 1 && window_width < 768 ){
				return false;
			}

			if( tablet_items == 1 && window_width >= 768  &&  window_width <= 1025){
				return false;
			}

			if( items == 1 && window_width > 1025 ){
				return false;
			}

			var height = get_highest_item( carousel );

			carousel.find(".owl-item > div").each(function(){
				$(this).css({"min-height": height +"px"});
			});

		 	carousel.trigger('refresh.owl.carousel');
		}

		//make all carousel items which has .has-bg-image classname in full height
		function make_full_height( carousel, min_height ){

			var window_height = $(window).height(),
				 wp_admin_bar_height = $("#wpadminbar").outerHeight(),
				 offset = carousel.offset().top,
				 new_height = window_height - offset ;

			if( parseInt( min_height ) > new_height ){
				return;
			}

			carousel.find(".has-bg-image,.slide-content-wrapper").each(function(){
				$(this).css({"min-height": new_height +"px"});
			});
		}

	};
 
	//$(window).on('rt_loaded', function(){
		$("body").rt_start_carousels();
	//});


	/* *******************************************************************************

		SEARCH WIDGET

	********************************************************************************** */
	$(".rt_form .search-icon").on('click', function() { 
		$(this).parents("form:eq(0)").submit();
	});

	/* *******************************************************************************

		SOCIAL SHARE

	********************************************************************************** */

	$(document.body).on("click",".naturalife-share-content a", function( event ) {

		//if email button clicked do nothing
		if( $(this).hasClass("icon-mail") ){
			return ;
		}

		//for other buttons open a popup window
		var newwindow=window.open($(this).attr("data-url"),'name','height=400,width=400');

		if (newwindow == null || typeof(newwindow)=='undefined') {
			alert( rtframework_params["popup_blocker_message"] );
		}else{
			newwindow.focus();
		}

		event.preventDefault();
	});

	$(document.body).on("click",".social_share > span", function( event ) { 
		var icons = $(this).next("ul");
		$.fn.rt_popup_on(".rt-popup-share");
		var share_content_wrapper = $(".naturalife-share-content ul");
		share_content_wrapper.replaceWith(icons.clone());
	});


	/* *******************************************************************************

		DROP DOWN MENU

	********************************************************************************** */

	if( ! $.fn.rt_drop_down ){

		$.fn.rt_drop_down = function()
		{

			if( $.fn.is_mobile_menu() ){
				return ;
			}

			var $this = $(this);

			$this.each(function(){

				var menu_items_with_sub = $(this).find(".menu-item-has-children"),
					max_depth = 0;

				menu_items_with_sub.each(function(){
					max_depth = Math.max( max_depth, $(this).data("depth") );
				});

				if( ! is_rtl ){

					var right_space = window_width - $(this).offset().left,
					left_space = $(this).offset().left,
					menu_total_width = left_space + ( ( max_depth + 1 ) * 240 );

					 if( right_space < left_space && window_width < menu_total_width ){
						$(this).addClass("o-direction");
					 }

				}else{

					var right_space = window_width - $(this).offset().left,
					left_space = $(this).offset().left,
					menu_total_width = right_space + ( ( max_depth + 1 ) * 240 );

					if( left_space < right_space && window_width < menu_total_width ){
						$(this).addClass("o-direction");
					}
				}

				$(this).addClass("submenu-loaded");					
			});

		};
	}

	$(".main-menu > li:not(.multicolumn).menu-item-has-children").rt_drop_down();

	/* *******************************************************************************

		TOP BAR DROP DOWN MENU

	********************************************************************************** */

	if( ! $.fn.rt_topbar_drop_down ){

		$.fn.rt_topbar_drop_down = function()
		{

			if( $.fn.is_mobile_menu() ){
				return ;
			}

			var $this = $(this);


			$this.each(function(){


					var menu_items_with_sub = $(this).find(".menu-item-has-children"),
						max_depth = 0;

					menu_items_with_sub.each(function(){
						max_depth = Math.max( max_depth, $(this).parents("ul").length  );
					});

					if( ! is_rtl ){

						if( window_width < $(this).offset().left + ( max_depth  * 160 ) ){
							$(this).addClass("o-direction");
						}

					}else{

						if( 0 > ( $(this).offset().left - ( max_depth * 160 ) ) ){
							$(this).addClass("o-direction");
						}
					}
			});

		};
	}

	$(".top-bar-right .topbar-widget .menu > li.menu-item-has-children").rt_topbar_drop_down();



	/* *******************************************************************************

		MEGA MENU

	********************************************************************************** */

	$('.main-menu .multicolumn > ul > li.menu-item-has-children > a').each(function(){

		if( $(this).attr("href") == "#" || $(this).attr("href") == "" ){
			var $this = $(this);
			$('<span>'+$(this).html()+'</span>').insertAfter($this);
			$this.remove();
		}

	});


	if( ! $.fn.rt_mega_menu ){

		$.fn.rt_mega_menu = function(action)
		{

			if( $(this).length === 0 ){
				return;
			}

			var $this = $(this),
				header = $(".header-elements"),
				header = $(".header-elements").length > 0 ? header : $(".main-menu-wrapper").parents(".elementor-row:eq(0)"),
				header_width = header[0].getBoundingClientRect().width - 40,
				new_col = "",
				ew_line;

			$this.each(function(){

				var $this = $(this),
					  menu = $this.find("> ul"),
					  col_size = $this.data("col-size"),
					  menu_width = Math.min( col_size * 310 , header_width );

				if( ! menu.hasClass("multicolumn-holder") ){
					$("<ul class='sub-menu multicolumn-holder' />").appendTo($(this));

					var  group;
					var lists_length = Math.ceil( menu.find('> li').length / col_size );

					while( ( group = menu.find('> li:lt('+ lists_length  +')').remove() ).length){
						$('<li/>').append($("<ul class='sub-menu'/>").append(group)).appendTo($(this).find("> .multicolumn-holder"));
					}
					menu.remove();
					menu = $this.find("> ul");//menu updated
				}

				$(this).addClass("submenu-loaded");
				
				if( ! is_rtl ){

					var leftPos  = $this.offset().left,
						 leftMargin = Math.ceil( header_width + header.offset().left ) - ( leftPos + menu_width) + 20;

					//set width
					menu.css({
						"width" : menu_width
					});

					if( leftMargin > 0 ){
						return;
					}

					menu.css({
						"margin-left" : parseFloat(leftMargin)
					});

				}else{


					var item_width = $this.outerWidth(),
						leftPos  = $this.offset().left + item_width,
						leftMargin  = Math.min(0, - 1 * (  header.offset().left - (leftPos - menu_width)) - 20 );

					//set width
					menu.css({
						"width" : menu_width
					});

					if( leftMargin == 0 ){
						return;
					}

					menu.css({
						"margin-right" : leftMargin
					});



				}
				
			});


		};
	}

	var rt_mega_menu = $(".main-menu > li.multicolumn.menu-item-has-children");

	$('#logo').waitForImages(function() {
		rt_mega_menu.rt_mega_menu();
	});

	$(window).on('window_width_resize', function() {
		rt_mega_menu.rt_mega_menu();
	});


	/* *******************************************************************************

		PARALLAX BACKGROUNDS

	********************************************************************************** */
	$(window).on('rt_loaded', function(){
		$('.rt-parallax-background:not(.rt-el-parallax)').rtprlx({});
	});


	/* *******************************************************************************

		PARALLAX BACKGROUNDS FOR ELEMENTOR

	********************************************************************************** */
	$(window).on('rt_loaded', function(){

		$('.rt-el-parallax-background').each(function(){
		
			var el = $(this).hasClass("elementor-column") ? $(this).find(".elementor-column-wrap") : $(this);
			var css = getComputedStyle(el[0]);

			var parallax_settings_list = {
					"1" : [{ "effect" : "horizontal", "direction" : "-1" }],
					"2" : [{ "effect" : "horizontal", "direction" :"1" }],
					"3" : [{ "effect" : "vertical", "direction" : "-1" }],
					"4" : [{ "effect" : "vertical", "direction" :"1" }],
				};		

			if( ! $(this).data("settings") ){
				return;
			}

			var parallax_setting = parallax_settings_list[ $(this).data("settings")["rt_bg_parallax_effect"] ];

			var paralax_layer = $('<div class="rt-parallax-background rt-el-parallax has-bg-image" data-rt-parallax-direction="'+parallax_setting[0]["direction"]+'" data-rt-parallax-effect="'+parallax_setting[0]["effect"]+'" data-rt-parallax-speed="'+$(this).data("settings")["rt_bg_parallax_speed"]+'"/>');
			paralax_layer.css({
				"background-attachment" : css["background-attachment"],
				"background-blend" : css["background-blend"],
				"background-clip" : css["background-clip"],
				"background-color" : css["background-color"],
				"background-image" : css["background-image"],
				"background-origin" : css["background-origin"],
				"background-position" : css["background-position"],
				"background-repeat" : css["background-repeat"],
				"background-size" : css["background-size"],
				"bottom": "0",
				"height": "100%",
				"position": "absolute",
				"top": "0"
			});

			el.find(">div:eq(0)").before(paralax_layer);
			el.css({"background":"none","overflow":"hidden"});
			$(this).find(".rt-parallax-background").rtprlx({
				"parent_row" : $(this)
			});
		});

		
	});

 


	/* *******************************************************************************

		LOAD MORE

	********************************************************************************** */

	$(".load_more").on("click",function(e){

		e.preventDefault();

		var button = $(this),
			listid = button.attr("data-listid"),
			page_count = parseInt(button.attr("data-page_count")) ,
			current_page = parseInt(button.attr("data-current_page")) ;

		//prevent multiple clicks before loading elements
		button.attr("disabled", "disabled");

		//check if there is more posts to display
		if( page_count == 1 ){
			return ;
		}

		//load more button classes
		button.find("span.ui-icon-angle-down:first-child").removeClass("ui-icon-angle-down").addClass("ui-icon-spin1 animate-spin");

		//start ajax
		$.ajax({
			type: 'POST',
			url: rtframework_params.ajax_url,
			data : {
				'action': 'rtframework_ajax_loader',
				'atts': $(this).attr("data-atts"),
				'wpml_lang': rtframework_params.wpml_lang,
				'page': current_page + 1
			},
			success: function(response, textStatus, XMLHttpRequest){

				var response = $(response), elems, wrapper, masonry;

					wrapper = $("#"+listid);

					if( wrapper.hasClass("masonry-gallery") || wrapper.hasClass("metro-gallery") ){
						masonry = true;
					}

					if( masonry ){
						elems = response.find(".rt-dynamic");
					}else{
						elems = response.find("> div, > article");
					}

			
				
				// wait the images
				imagesLoaded( response ).on('done', function( instance ) {

					//append the elements and rebuild the masonry layout
					if( masonry ){
						wrapper.isotope().append( elems ).isotope( 'appended', elems );
						$(window).trigger("window_width_resize");
					}else{
						wrapper.append( elems );
					}

					//img effects for new loaded elements
					elems.find(".imgeffect").rt_image_hover();

					//lightboxes
					$(elems).rt_lightbox("init");

					//start carousels
					elems.rt_start_carousels( { '_onRefreshed' : function _onRefreshed(){
						if( masonry ){
							wrapper.isotope('layout');
						}
					}});

					//the load more button
					button.find(".animate-spin").removeClass("ui-icon-spin1 animate-spin").addClass("ui-icon-angle-down");

					//decrease the page count
					button.attr("data-page_count",page_count-1);

					//increase the current page count
					button.attr("data-current_page", current_page+1 );

					//remove the button if there is no page left
					if( page_count -1 <= 1 ){
						button.attr("disabled", "disabled").hide();
					}else{
						button.removeAttr("disabled");
					} 

				});

			},
			error: function( MLHttpRequest, textStatus, errorThrown ){
				console.log(errorThrown);
			}
		});

	});


	/* *******************************************************************************

		CUSTOM DESIGNED SELECT FORMS

	********************************************************************************** */
	if( ! $.fn.rt_customized_selects ){
		$.fn.rt_customized_selects = function( wrapper ) {
			if ( $.isFunction($.fn.customSelect) ) {

				var selectors = '.orderby, .widget .menu.dropdown-menu, .naturalife-custom-select';
				if( wrapper ){
					wrapper.find(selectors).customSelect( { customClass: "customselect" } );
				}else{
					$(selectors).customSelect( { customClass: "customselect" } );
				}

			}
		};
	};

	$(window).load(function(){
		$.fn.rt_customized_selects();

		//bind to gravity ajax load
		$(document).bind('gform_post_render', function(){
			$.fn.rt_customized_selects();
		});

	});


	/* *******************************************************************************

		FORM VALIDATION

	********************************************************************************** */
	$.fn.rt_contact_form = function() {

		$(this).each(function(){

			var the_form = $(this);

			the_form.find(".submit").on("click",function(event){

				//vars
				var loading = the_form.find(".loading"),
					error = false;
				
				//check required fields
				the_form.find(".required").each(function(){

					var type = $(this).prop("type") || $(this).prop("tagName").toLowerCase();
					var val = $(this).val();
					
					if( ! val ){
						$(this).addClass("error");
						error = true;		
					}else if( type == "checkbox" && ! $(this).attr("checked") ){ 					
						$(this).addClass("error");
						error = true;		
					}else{
						$(this).removeClass("error");
					}
				});

				//there is an error
				if(error){
					return ;
				}

				//show loading icon
				loading.show();

				//searialize the form
				var serialize_form = $(the_form).serialize();

				//ajax form data
				var data = serialize_form +'&action=rt_ajax_contact_form';

				//post
				$.post(rtframework_params.ajax_url, data, function(response) {
					var response = $(response);
					response.prependTo(the_form);
					loading.hide();
				});

				//close warnings
				the_form.find(".info_box").remove();

			});
		});
	};

	$('.validate_form').rt_contact_form();


	/* *******************************************************************************

		INFO BOX CLOSE

	********************************************************************************** */
	$(document.body).on("click",".info_box .icon-cancel",function() {
		$(this).parent(".info_box").fadeOut();
	});


	/* *******************************************************************************

		LIGHTBOX PLUGIN

	********************************************************************************** */

	$.fn.rt_lightbox = function(event) {
		if ($.fn.lightGallery){

				var carousel_atts= {
					selector: 'a[data-rel^="rt_lightbox"]',
					hash: false,
					downloadUrl: false,
					loop: false,
					thumbnail: false,
					index: 0					
				};

				$(this).find(".rt_lightbox_gallery, .rt-gallery").lightGallery(carousel_atts);

				var carousel_atts= {
					selector: 'this',
					hash: false,
					downloadUrl: false,
					loop: false,
					thumbnail: false,
					index: 0					
				};

				$(this).find(".rt_lightbox").lightGallery(carousel_atts);

				//prevent 3rd party lightboxes and elementor lightbox
				$(this).find(".rt_lightbox").on('click',function( event ){
					event.preventDefault();
					return false;
				});
 			
		}

	};

	$(document).rt_lightbox("init");


	/* *******************************************************************************

		RT GOOGLE MAPS

	********************************************************************************** */
	$.rt_maps = function(el, locations, zoom){

		var base = this;
		base.init = function(){
			// initialize google map
			if(locations.length>0) google.maps.event.addDomListener(window, 'load', $.fn.rt_maps());
		};

		if(locations.length>0) base.init();
	};

	$.fn.rt_maps = function(locations, zoom){

		var map_id = $(this).attr("id");

		//holder height
		var height = $('[data-scope="#'+map_id+'"]').attr("data-height");

		if ( height > 0 ){
			$(this).css({'height':height+"px"});
		}

		//api options
		var myOptions = {
			zoom: zoom,
			panControl: true,
			zoomControl: true,
			scaleControl: true,
			streetViewControl: false,
			overviewMapControl: false,
			scrollwheel : false,
			navigationControl: true,
			center: new google.maps.LatLng(0, 0),
			mapTypeId: google.maps.MapTypeId.ROADMAP
		}

		var map = new google.maps.Map( document.getElementById(map_id), myOptions);

		//B&W Map
		var bwmap = $('[data-scope="#'+map_id+'"]').attr("data-bw");

		if ( typeof bwmap !== "undefined" && bwmap != "" ){
			// Create an array of styles.
			var styles = [
				{
					stylers: [
						{ hue: "#fff" },
						{ saturation: -100 },
						{ lightness: 0 },
						{ gamma: 1 }
					]
				}
			];
			// Create a new StyledMapType object, passing it the array of styles,
			// as well as the name to be displayed on the map type control.
			var styledMap = new google.maps.StyledMapType(styles, {name: "Styled Map"});

			//Associate the styled map with the MapTypeId and set it to display.
			map.mapTypes.set('map_style', styledMap);
			map.setMapTypeId('map_style');
		}

		$.fn.setMarkers(map, locations);

		$.fn.fixTabs(map,map_id,zoom);
		$.fn.fixAccordions(map,map_id,zoom);
	};

	$.fn.setMarkers = function (map, locations) {


		if(locations.length>1){
			var bounds = new google.maps.LatLngBounds();
		}else{
			var center = new google.maps.LatLng(locations[0][1], locations[0][2]);
			map.panTo(center);
		}


		for (var i = 0; i < locations.length; i++) {
			if (locations[i] instanceof Array) {
				var location = locations[i];
				var myLatLng = new google.maps.LatLng(location[1], location[2]);
				var marker = new google.maps.Marker({
					position: myLatLng,
					map: map,
					animation: google.maps.Animation.DROP,
					draggable: false,
					title: location[0]
				});

				$.fn.add_new_event(map,marker,location[4]);
				if(locations.length>1) bounds.extend(myLatLng);
			}
		}

		if(locations.length>1)  map.fitBounds(bounds);
	};

	$.fn.add_new_event = function (map,marker,content) {

	  if(content){
			var infowindow = new google.maps.InfoWindow({
				content: content,
				maxWidth: 300
			});
			google.maps.event.addListener(marker, 'click', function() {;
			infowindow.open(map,marker);
		});
	  }
	};

	$.fn.fixTabs = function (map,map_id,zoom) {
		var tabs = $("#"+map_id).parents(".rt_tabs:eq(0)"),
			desktop_nav_element = tabs.find("> .tab_nav > li"),
			mobile_nav_element = tabs.find("> .tab_contents > .tab_content_wrapper > .tab_title");

		desktop_nav_element.on("click",  { map: map } , function() {
			var c = map.getCenter();
			google.maps.event.trigger(map, 'resize');
			map.setZoom(zoom);
			map.setCenter(c);
		});

		mobile_nav_element.on("click",  { map: map } , function() {
			var c = map.getCenter();
			google.maps.event.trigger(map, 'resize');
			map.setZoom(zoom);
			map.setCenter(c);
		});
	};

	$.fn.fixAccordions = function (map,map_id,zoom) {
		var panes = $("#"+map_id).parents(".rt-toggle:eq(0) > ol > li");

		panes.on("click",  { map: map } , function() {
			var c = map.getCenter();
			google.maps.event.trigger(map, 'resize');
			map.setZoom(zoom);
			map.setCenter(c);
		});
	};

	/* *******************************************************************************

		SLIDER PARALLAX EFFECT

	********************************************************************************** */

	$.fn.rt_slider_position = function()
	{
		var slider =  $('#main-content > .content-row:first-child .main-carousel[data-parallax="true"], .elementor-row .main-carousel[data-parallax="true"]');

		if( slider.length == 0 || Modernizr.touchevents ){
			return ;
		}

		var parallax_effect = ! Modernizr.touchevents ? true : false,
			wp_admin_bar_height = $("#wpadminbar").outerHeight(),
			offsetTop = slider.offset().top,
			sliderHeight = slider.outerHeight(),
			gap = offsetTop - wp_admin_bar_height,
			carousel = slider.find(".owl-stage-outer"),
			slidebackground = carousel.find(".slide-background"),
			$window = $(window);


			//parallax effect
			$(window).on("scroll", function( event ){

				if( window_width < 1024 ){
					return ;
				}

				var scrollTop = $window.scrollTop() - gap ;

				if( sliderHeight < scrollTop ){
					return ;
				}

				var y = Math.max( 0, scrollTop ),
					cy = parseInt(0.2*y);

					if( y < 420 ){
						slidebackground.css({
							"-webkit-transform": "translate3d(0, "+cy+"px, 0)",
							"-moz-transform": "translate3d(0, "+cy+"px, 0)",
							"-ms-transform": "translate3d(0, "+cy+"px, 0)",
							"-o-transform": "translate3d(0, "+cy+"px, 0)",
							"transform": "translate3d(0, "+cy+"px, 0)"
						});
					}

					if(  y > 220 && y < 260 ){
						carousel.addClass("scrolled");
					}

					if(  y < 220 ){
						carousel.removeClass("scrolled");
					}
			});
	}

	$(window).on('rt_loaded resize', function() {
		$.fn.rt_slider_position();
	});


	/* *******************************************************************************

		MASONRY LAYOUTS

	********************************************************************************** */

	$.fn.rt_run_masonry_isotope = function(options) {
		$(this).each(function(){

			var $container = $(this),
				$filter_navigation = $('[data-list-id="'+$(this).attr("id")+'"]');

				$container.rt_fix_metro_layout();

				var isotope = function () {
					$container.isotope({
						resizable: false,
						itemSelector: '.rt-dynamic',
						percentPosition: true,
						layoutMode:'packery'
					});
				}; 
				isotope();

		});

	};

	//start isotopes
	$(window).on('rt_loaded window_width_resize', function() {
		$('.masonry, .masonry-gallery, .metro-gallery').rt_run_masonry_isotope();
	});

	//fix metro layouts
	$.fn.rt_fix_metro_layout = function() {

		var $container = $(this);


		if( $container.hasClass("metro-gallery")){
			var width = $container.width()/4;
			var padding = $container.hasClass("nogaps") ? 0 : 15;

			$container.find(".col").each(function(){

				if( window_width > 1024 ){
					var w = $(this).hasClass("double-width") ? "50%" : "25%";
					var h = $(this).hasClass("double-height") ? ( width - padding ) * 2 : width - (padding*2);					
				}else if( window_width <= 1024 && window_width >= 768 ){
					var w = $(this).hasClass("double-width") ? "100%" : "50%";
					var h = $(this).hasClass("double-height") ?  width * 4 + padding * 2 : width * 2;	
				}else{
					var w = "100%";
					var h = $(this).hasClass("double-width") && ! $(this).hasClass("double-height") ?  width * 2 : width * 4;					
				}

				$(this).css({
					"flex" : "0 0" +w,
				 	"width" : w,
					"height" : h
				});

				var img_height= $(this).innerHeight();
				
				$(this).find("img").css({
					"height" : img_height,
					"width":  "auto",
					"max-width" : "inherit",
					"max-height" : "inherit"
				});


			});
		}
	};

	//a function for filter navigation classes on click
	$.fn.rt_filter_nav = function() {

		var filter_holder = $(this);

		$(this).each(function(){
			
				var $optionLinks = $(this).find('a');

				$optionLinks.on("click",function(){
					var $this = $(this),
						selector = $(this).attr('data-filter');

					//filter items
					$("#"+filter_holder.data("list-id")).isotope({ filter: selector });

					// add active class to the navigation item
					if ( $this.hasClass('active') ) {
						return false;
					}

					var $optionSet = $this.parents('.filter_navigation ul');
					$optionSet.find('.active').removeClass('active');
					$this.addClass('active');

					return false;
				});
		});
	};

	//start filters
	$('.filter-holder').rt_filter_nav();


	/* *******************************************************************************

		RESPONSIVE HEADINGS

	********************************************************************************** */
	$.fn.rt_font_resize = function() {

		$(this).each(function(){
			var $this = $(this),
				max_font_size = $this.data("maxfont-size"),
				min_font_size = $this.data("minfont-size");

				var resize_font_size = function(){

					var compress = 1;
					compress = window_width < 1260 ? 0.85 : compress;
					compress = window_width < 1160 ? 0.75 : compress;
					compress = window_width < 960 ? 0.65 : compress;
					compress = window_width < 768 ? 0.6 : compress;
					compress = window_width < 560 ? 0.5 : compress;
					compress = window_width < 480 ? 0.4 : compress;
					compress = window_width < 300 ? 0.35 : compress;

					if(compress == 1){
						$this.css('font-size', max_font_size +'px');
						return false;
					}

					 $this.css('font-size', Math.max( min_font_size, parseFloat( compress * max_font_size ) ) +'px');
				};

				resize_font_size();
				$(window).on('resize.rt_font_resize orientationchange.rt_font_resize', resize_font_size);
		});

	};

	$('[data-maxfont-size]').rt_font_resize();




	/* *******************************************************************************

		PIE CARTS

	********************************************************************************** */
	$.fn.rt_pie_carts = function() {

		$(this).appear(function(){

			var is_icon = $(this).find("span.icon").length > 0,
				size = Math.min( window_width - 60, $(this).data("wsize"));

				//dynamic span size
				$(this).find("span").css({
					"line-height": size+"px",
					"width": size+"px"
				});

			//create
			$(this).easyPieChart({
				barColor: $(this).data("barcolor"),
				trackColor: $(this).data("basecolor"),
				scaleColor: false,
				lineCap: 'butt',
				lineWidth: $(this).data("linewidth"),
				animate: 1500,
				size: Math.min( window_width - 60, $(this).data("wsize")),
				onStep: function(from, to, percent) {
					if( ! is_icon ){
						$(this.el).find('.percent').text(Math.round(percent));
					}
				}
			});
		},{accX: 0, accY: -100});

	};

	$(window).one("rt_loaded", function(){
		$('.rt-pie-chart').rt_pie_carts();
	});



	/* *******************************************************************************

		PROGRESS BARS

	********************************************************************************** */
	$.fn.rt_progress_bar = function() {

		$(this).each(function(){

			var $this = $(this),
			bar = $this.find(".naturalife-progress-bar"),
			title = $this.find(".naturalife-progress-title"),
			percent = $this.data("percent"),
			percent_output = $this.find(".naturalife-progress-desc span");

			if( title.width() + 30 > ($this.width() * percent) / 100 ){
				$this.addClass("short-bar");
			}

			$this.appear(function(){

				bar.width(percent+"%");

				if( ! is_rtl ){
					percent_output.css({left:percent+"%"});
				}else{ 
					percent_output.css({right:percent+"%"});
				}


				$({
					Counter: 0
				}).animate({
					Counter: percent
				}, {
					duration: 1200,
					step: function () {
						percent_output.text(Math.ceil(this.Counter));
					},
					complete: function () {
						percent_output.text(percent);
					}
				});

			},{accX: 0, accY: -30});

		});

	};

	$(window).one("rt_loaded", function(){
		$('.naturalife-progress-bar-holder').rt_progress_bar();
	});



	/* *******************************************************************************

		TEXT ANIMATION

	********************************************************************************** */
	$.fn.rt_anim = function() {

		$(this).each(function(){

			var $this = $(this),
			texts = $this.find("span"),
			first = $this.find("span:first-child"),
			timeout = $this.data("timeout");

			first.addClass("active");

			var text_anim = setInterval(function(){

				var active = $this.find(".active"),
					next = active.next() ;

				if(next.length == 0) {
					next = first;
				}

				active.removeClass("active");
				next.addClass("active");

			},timeout);

		});

	};

	$(window).one("rt_loaded", function(){
		$('.rt-anim').rt_anim();
	});

	/* *******************************************************************************

		BACKGROUND SLIDER

	********************************************************************************** */
	$.fn.rt_bg_anim = function() {

		$(this).each(function(){

			var $this = $(this),
			images = $this.data("imgs"),
			timeout = $this.data("timeout"),//seconds
			i=1,
			img_array = images.split(","),
			img_count = img_array.length;

			var anim_layer = $this.clone();
				anim_layer.appendTo($this);

			//pre load images
			var img_objects = [];
			for (var y = 0; y < img_array.length; y++) {
				var img = new Image();
				img.src = img_array[i];
				img_objects[y] = img;
			}

			$(img_objects).imagesLoaded().done( function( instance ) {

				$this.appear(function(){

					if( img_count <= 1 ){
						animate(false);
						return;
					}else{
						animate(true);
					}

					var bg_anim = setInterval(function(){

						anim_layer.css({
							"background-image" : 'url('+img_array[i-1]+')',
							"transform": "scale(1)",
							"transition": "opacity 0s, transform 0s",
							"opacity":1
						});

						animate(true);

					},timeout * 1000);
				});

			});

			function animate(loop){
				setTimeout(function(){

					if( loop ){
						anim_layer.css({
							"opacity":0,
							"transform": "scale(1.5)",
							"transition": "opacity 1s ease "+(timeout-1)+"s, transform "+timeout*2+"s",
						});
					}else{
						anim_layer.css({
							"transform": "scale(1.5)",
							"transition": "transform "+timeout*2+"s",
						});
					}

					i = ( i == img_count ) ? 1 : i+1;

					//next image
					$this.css({
						"background-image" : 'url('+img_array[i-1]+')'
					});

				},50);
			};

		});
	};

	$(window).one("rt_loaded", function(){
		$('.rt-background-slider').rt_bg_anim();
	});


	/* *******************************************************************************

		SIDE PANEL

	********************************************************************************** */

	var side_animation = {};

	$.fn.rt_toggle_side_panel = function()
	{
		//toggle body class
		$("body").toggleClass("naturalife-panel-on");

		if( $("body").hasClass("naturalife-panel-on") ){//open

			var showitems = setTimeout(function(){
				$(".naturalife-panel-contents > .animate").show().animate({opacity: 1,top: 0},400);
				$('naturalife-panel-holder').perfectScrollbar('update');
			},700);

			$(document).on("keyup.rt_side_panel",function(e){
				if (e.keyCode === 27){
					$(window).trigger("rt_side_panel");
					return;
				}
			});

		}else{//close
			$(".naturalife-panel-contents > .animate").animate({opacity: 0, top: "20px",},400,function(){
				$(this).hide();
			});

			$(".naturalife-sidepanel-button").removeClass("active");

			$(document).off("keyup.rt_side_panel");
		}
	}

	$(window).on("rt_side_panel", function(){
		//toggle side panal
		$.fn.rt_toggle_side_panel();
	});

	$(window).on('rt_side_panel resize', function() {
		if($("body").hasClass("naturalife-panel-on")){
			if( $(window).height() < 1024 ){
				$(".naturalife-panel-holder,.naturalife-panel-background").height("100vh" );
			}else{
				$(".naturalife-panel-holder,.naturalife-panel-background").height( $(window).height() );	
			}
		}
	});

	//scrollbar 
	$.fn.rt_side_panel_scrollbar = function()
	{
		if( ! $.fn.is_mobile_menu() ){
			$('.naturalife-panel-holder:not(".ps-container")').perfectScrollbar({
				suppressScrollX: true
			});
		}
	}

	$(window).on('rt_loaded resize', function() {
		$.fn.rt_side_panel_scrollbar();
	});


	/* *******************************************************************************

		SIDE PANEL OPEN / CLOSE BUTTON

	********************************************************************************** */
	$.fn.rtframework_side_menu_button = function()
	{

		$(this).on("click",function(e){
			e.preventDefault();

			$(this).addClass("active");
			$(".naturalife-panel-contents > .widget.woocommerce, .naturalife-panel-contents > .widget.rt_woocommerce_login").removeClass("animate");
			$(".naturalife-panel-contents > *:not(.widget.woocommerce):not(.widget.rt_woocommerce_login)").addClass("animate");


			if( ! $("body").hasClass("naturalife-panel-on") ){
				$(window).trigger("rt_side_panel");
			}
		});

	} 

	$(".naturalife-sidepanel-button").rtframework_side_menu_button();

	$(".naturalife-panel-close").on("click",function(e){
		if( $("body").hasClass("naturalife-panel-on") ){
			$(window).trigger("rt_side_panel");
		}
	});

	/* *******************************************************************************

		CART BUTTON MENU

	********************************************************************************** */
	$.fn.rtframework_cart_menu_button = function()
	{

		$(this).on("click",function(e){
			e.preventDefault();

			$(".naturalife-panel-contents > *:not(.widget.woocommerce)").removeClass("animate");
			$(".naturalife-panel-contents > .widget.woocommerce").addClass("animate");

			if( ! $("body").hasClass("naturalife-panel-on") ){
				$(window).trigger("rt_side_panel");
			}
		});

	}

	$(".naturalife-cart-menu-button").rtframework_cart_menu_button();


	/* *******************************************************************************

		USER BUTTON MENU

	********************************************************************************** */
	$.fn.rtframework_user_menu_button = function()
	{

		$(this).on("click",function(e){
			e.preventDefault();

			$(".naturalife-panel-contents > *:not(.widget.rt_woocommerce_login)").removeClass("animate");
			$(".naturalife-panel-contents > .widget.rt_woocommerce_login").addClass("animate");

			if( ! $("body").hasClass("naturalife-panel-on") ){
				$(window).trigger("rt_side_panel");
			}
		});

	}

	$(".naturalife-user-menu-button").rtframework_user_menu_button();



	/* *******************************************************************************

		SIDE PANEL MENU

	********************************************************************************** */

	if( ! $.fn.rt_panel_menu ){

		$.fn.rt_panel_menu = function()
		{

			$(this).on("click",function(e){

				var $this = $(this).parent("li");
				
				//if the link is only # then toggle the sub menu
				if( $(this).attr("href") == "#" ){
					e.preventDefault();
					$this.find(">ul").slideToggle();
					$this.toggleClass("current-menu-item");
					return;
				}

				//toggle the sub menu when clicked to +/- icons
				if( ! is_rtl ){
					if( ! $this.hasClass("menu-item-has-children") || window_width - ( ( window_width - $(".naturalife-panel-contents .menu").width() ) / 2 + e.pageX ) > 55 ){
						$(".naturalife-sidepanel-button").trigger("click");
						return ;
					}
				}else{
					if( ! $this.hasClass("menu-item-has-children") || e.pageX > 65 ){
						$(".naturalife-sidepanel-button").trigger("click");
						return ;
					}
				}


				e.preventDefault();

				$this.find(">ul").slideToggle();
				$this.toggleClass("current-menu-item");
				
				return false;

			});

		};
	}

	$(window).on('load', function() {
		$('.naturalife-panel-contents .menu li').each(function(){
				if( $(this).hasClass("current-menu-ancestor") ){
					$(this).removeClass("current-menu-item current-menu-ancestor");	
					$(this).addClass("current-menu-item");	
				}
		}).promise().done( function(){ 
			$('.naturalife-panel-contents .menu li a, .naturalife-panel-contents .menu li > span').rt_panel_menu();
		});
	});


	/* *******************************************************************************

		CONTENT OVERLAY

	********************************************************************************** */

	$(".naturalife-panel-holder").after('<div id="content-overlay"></div>');

	//passive close
	$("#content-overlay").on('touchstart click', function(e) {
		e.preventDefault();
		if( $("body").hasClass("naturalife-panel-on") ){
			$(window).trigger("rt_side_panel");
		}
	});

	/* *******************************************************************************

		CURSOR CSS
		IE doesn't work with relative urls

	********************************************************************************** */
	$('<style>.naturalife-panel-on  #content-overlay{ cursor: url("'+rtframework_params["rttheme_template_dir"]+'/images/close.cur"), pointer;}</style>').appendTo($("head"));



	/* *******************************************************************************

		SEARCH BUTTON MENU

	********************************************************************************** */

	$.fn.rt_header_search_button = function()
	{
		$(this).on("click",function(e){			
			e.preventDefault();

			setTimeout(function() {
				$('.rt-popup-search .search').focus();
			}, 500 );
		
			$.fn.rt_popup_on(".rt-popup-search");				
		});
	}

	$(".naturalife-search-button").rt_header_search_button();


	/* *******************************************************************************

		LANGUAGE BUTTON MENU

	********************************************************************************** */
	$.fn.rtframework_language_menu_button = function()
	{
		$(this).on("click",function(e){
			e.preventDefault();
			$.fn.rt_popup_on(".rt-popup-languages");
		});
	}

	$(".naturalife-wpml-menu-button").rtframework_language_menu_button();


	/* *******************************************************************************

		OPEN / CLOSE POPUP

	********************************************************************************** */
	$.fn.rt_popup_on = function(target)
	{	
		$(target).toggleClass("active"); 

		$('.rt-popup-content-wrapper').perfectScrollbar({
			suppressScrollX: true
		});
			
		$(document).on("keyup.rt_popup_esc",function(e){
			if (e.keyCode === 27){
				$.fn.rt_popup_off(target);
				return;
			}
		});

		$(target).find(".rt-popup-close").on("click",function(){
			$.fn.rt_popup_off(target);
			return;
		});
	};

	$.fn.rt_popup_off = function(target)
	{
		$(target).toggleClass("active"); 
		$(document).off("keyup.rt_popup_esc");
		$(target).find(".rt-popup-close").off("click");	
	};



	/* *******************************************************************************

		WOOCOMMERCE ADDED TO CART ITEM TO SIDE PANEL

	********************************************************************************** */

	if ( ! $.fn.rt_add_to_cart ) {

		$.fn.rt_add_to_cart = function()
		{

			if( typeof wc_cart_fragments_params == 'undefined' ){
				return ;
			}

			$( '.add_to_cart_button' ).on( 'click', function() {
				//add classname to the parent holder
				$(this).parent().addClass("clicked");

				//bind to added_to_cart
				$( 'body' ).one( 'added_to_cart',  function() {
					$(".naturalife-panel-contents > .widget_shopping_cart").css({"opacity":0});
					$(".naturalife-cart-menu-button").trigger("click");
					setTimeout(function(){
						$(window).trigger("rt_fix_sticky_sidebar");
					},50);
				});

			});


		}
	}
	$.fn.rt_add_to_cart();


	/* *******************************************************************************

		Quantity

	********************************************************************************** */
	$(document.body).on("click",".quantity .rt-minus,.quantity .rt-plus", function( e ) { 
			e.preventDefault();

			var $this = $(this),
				plus = $this.hasClass("rt-plus"),
				input = $this.parent().find(".qty"),
				step = parseInt(input.attr("step")),
				min = parseInt(input.attr("min")),
				max = parseInt(input.attr("max")),
				val = parseInt(input.attr("value")),
				new_val = 0;

			if( plus ){
				new_val = val + step;
			}else{
				new_val = val - step;
			}
			new_val = min ? Math.max(min,new_val) : new_val;
			new_val = max ? Math.min(max,new_val) : new_val;
			new_val = Math.max(0,new_val);

			input.val( new_val );
			input.trigger("change");
	});


	/* *******************************************************************************

		Count Down

	********************************************************************************** */

	if ( ! $.fn.rt_countdown ) {

		$.fn.rt_countdown = function()
		{
			$(this).each(function(){

				var date = $(this).attr("data-date");
				var format = $(this).html();

				if( date === undefined ){
					return true;//skip
				}

				$(this).countdown(date, function(event) {
					$(this).html(event.strftime(format));
				});

				$(this).addClass("started");
			});
		}
	}

	$(".rt-countdown").rt_countdown();


	/* *******************************************************************************

		My account

	********************************************************************************** */
	$(".woocommerce-MyAccount-navigation .is-active a").on("click touchstart", function(e){
		$(".woocommerce-MyAccount-navigation li").show("slow");
		e.preventDefault();
		return;
	});


	/* *******************************************************************************

		CF7 - Form Icon submit

	********************************************************************************** */

	$("form .icon-submit").on("click", function(e){
		$(this).parents("form:eq(0)").submit();
		e.preventDefault();
		return;
	});


	/* *******************************************************************************

		Revslider control

	********************************************************************************** */

	if( ! $.fn.rt_rev_control ){

		$.fn.rt_rev_control = function(action)
		{

			if( ! $("body").hasClass("overlapped-header") ){
					return ;
			}

			$(".rev_slider_wrapper").each(function(){
				var $this = $(this);

				if( ! $this.parents(".elementor-top-section").last().is($(".overlapped-header .elementor-section-wrap > .elementor-top-section:first-child") ) ){
					return;
				}

				var id_array = $this.attr("id").split("_");
				var id = id_array[2];
				var revapi = eval('revapi'+id);
 
				revapi.bind("revolution.slide.onchange",function (e,data) {

						var left_arrow = $this.find(".tp-leftarrow.custom");
						var right_arrow = $this.find(".tp-rightarrow.custom");
						var skin = data.currentslide.data("param1");
						
						if( "" == skin ){
							return;
						}

						$("body.overlapped-header .dynamic-skin").removeClass("naturalife-dark-header naturalife-light-header");
						$("body.overlapped-header .dynamic-skin").addClass("naturalife-"+skin+"-header"); 
						$(".top-header").attr("data-color",skin);

						left_arrow.removeClass("light dark").addClass(skin);
						right_arrow.removeClass("light dark").addClass(skin);
				});

				revapi.bind("revolution.slide.onbeforeswap",function (e,data) {

						var skin = data.nextslide.data("param1");

						if( "" == skin ){
							return;
						}

						if( $.fn.is_mobile_menu() || $(".top-header").hasClass("stuck") ){
							return ;
						}

					$("body.overlapped-header .dynamic-skin").css({"opacity":0.5});
				});

				revapi.bind("revolution.slide.onafterswap",function (e,data) {

						var skin = data.currentslide.data("param1");

						if( "" == skin ){
							return;
						}

						if( $.fn.is_mobile_menu() || $(".top-header").hasClass("stuck") ){
							return ;
						}
					$("body.overlapped-header .dynamic-skin").css({"opacity":1});
				});

			});
		};
	}

	$(window).on("load",function(){
		$.fn.rt_rev_control();
	});


	/* ******************************************************************************* 

		CATEGORY TREE

	***********************************************************************************/ 
 	if( ! $.fn.rt_category_tree ){

		$.fn.rt_category_tree = function()
		{ 
			var category = $(this);
			category.find('.cat-item:has(.children)').addClass('has-children');
			$('<span></span>').prependTo(category.find('.cat-item:has(.children)')); 

			category.find('.cat-item:has(.children) > span').on("click", function(){
			
				var parent = $(this).parent();

				if( parent.hasClass("current-cat") || parent.hasClass("current-cat-ancestor") ){
					parent.removeClass("current-cat current-cat-ancestor");	
					parent.addClass("active");	
				}
				
				parent.toggleClass("active");
			});

		};
	}

	$(".rt-category-tree").rt_category_tree();  

	/* *******************************************************************************

		IE FIX FOR RESPONSIVE SVG BACKGROUND SHAPES

	********************************************************************************** */

	$(window).on('load resize', function() {
		setTimeout(function() {
			$('.rt-svg-background.bottom').each(function() {
				var ua = window.navigator.userAgent;


				var svg = $(this);
				var width = svg.attr("width");
				var height = svg.attr("height");
				var parent_width = svg.parent().width();
				var parent_height = svg.parent().height();
				var new_height = height * parent_width / width;

				svg.css({"padding-top":parent_height - new_height + 1 + "px"});
			});
		},150);
	});

	/* *******************************************************************************

		TABLET DROP-DOWN TOUCH FIX

	********************************************************************************** */

	$.fn.rt_menu_touch_fix = function()
	{

		$(this).on("touchstart",function(e){

			e.preventDefault();		

			var this_li = $(this).parent("li"); 
			var this_link = $(this).attr("href"); 
			
			if( this_li.hasClass("hover") ){
				$(this).trigger("click");
				return true;
			}	

			var hovered = $(this).parents("ul:eq(0)").find("> li.hover");

			if( ! hovered.is( $( this ) ) ){
				hovered.removeClass("hover");
			}

			this_li.addClass("hover");
 			
			return false;
 			
		})

	};
	
	if(  Modernizr.touchevents ){//check touch support	 
		$( '.main-menu li:has(ul) > a').rt_menu_touch_fix(); 
	}


	/* *******************************************************************************

		TABLET NAVIGATION FIX FOR DEACTIVE STATE

	********************************************************************************** */

	$("#container").on("click",function() {
		$( '.main-menu .hover').removeClass("hover"); 
		return true;
	});
 

	/* *******************************************************************************

		STICKY SIDEBARS

	********************************************************************************** */

	if( ! $.fn.rt_sticky_sidebar ){

		$.fn.rt_sticky_sidebar = function()
		{	
				var $window = $(window);

				$window.off("scroll.sidebar"); 

				if( $(this).length == 0 ){
					return;
				}

				if( Modernizr.touchevents || $.fn.is_mobile_menu() ){

					$(this).each(function(){
						$(this).find("> .column-inner").removeAttr("style");
					});

					return;
				}

				var $stickyHeaderFields = "#wpadminbar, .header-stuck .sticky-header-holder";
				
				$(this).each(function(){



					var $content_block = $(this).parent(),
						$sidebar = $(this),
						$sidebarInner = $(this).find("> .column-inner"),
						$contentInner = $content_block.find(".content:eq(0) > .column-inner");

						$sidebarInner.removeAttr("style");						
					
					var	padding = 0,
						sidebar_left_position = $sidebar.offset().left,
						sidebar_first_left_position = $sidebar.position().left,
						sidebarInnerHeight = $sidebarInner.outerHeight(),
						sidebarHeight = $sidebar.outerHeight(),
						sidebarWidth = $sidebar.width(),
						sidebar_position = $sidebarInner.position().top,						
						content_block_top = $sidebar.offset().top,
						sidebar_bottom = (sidebar_position + sidebarInnerHeight + content_block_top) - window_height;						

						if( $contentInner.height() < sidebarInnerHeight ){
							return;
						}

						if( sidebarHeight > sidebarInnerHeight ){

							$window.on("scroll.sidebar",function(event) {

								var scrollTop = $window.scrollTop();
								sidebarInnerHeight = $sidebarInner.outerHeight();

								if( $.fn.is_mobile_menu() ){
									return;
								}
							
								var $addHeigth = 25;

								//sticky fields on top
								$($stickyHeaderFields).each(function(){
									$addHeigth = $addHeigth + $(this).height();
								});

								if( sidebarInnerHeight > window_height ){//stick to the bottom

									var tmax = (sidebarHeight - sidebarInnerHeight);
									var ttop = scrollTop - sidebar_bottom - padding;
									    ttop = Math.min( ttop, tmax );
									 	ttop = Math.max( ttop , padding );

										if( ttop <= padding ){
											$sidebarInner.removeAttr("style"); 
											$sidebar.removeClass("stuck");
											return;
										}

									 	if( ttop == tmax ){
											$sidebarInner.css({
												"position": "absolute",  
												'bottom':  padding  + "px", 
											}); 
											$sidebar.addClass("stuck");
											return;
										}

									 	if( tmax > padding ){
											$sidebarInner.css({
												"position": "fixed", 
												'top':  "auto",
												'bottom':  padding  + "px", 
												'width': sidebarWidth +"px"	
											}); 
											$sidebar.addClass("stuck");
											return;
										}

								}else{//stick to the top							
										var top_position = scrollTop + $addHeigth ,
										maxposition = sidebarHeight - ( sidebar_position + sidebarInnerHeight ) - padding,
										topPosition = -1 * Math.min( 0 , content_block_top - top_position );
										topPosition = Math.min(  maxposition, topPosition );


										if( content_block_top - top_position > 0 ){
											$sidebarInner.removeAttr("style");
											$sidebar.removeClass("stuck");
											return;
										}

										if( maxposition == topPosition ){
											$sidebarInner.css({
												"position": "absolute",
												'bottom' : "auto",
												'top': ( sidebarHeight - sidebarInnerHeight ) - padding + "px", 
												'width': sidebarWidth +"px"
											});
											$sidebar.addClass("stuck");
											return;
										}

										if( content_block_top - top_position < 0 ){
											$sidebarInner.css({
												"position": "fixed",
												'top': $addHeigth + padding + "px",
												'bottom' : "auto", 
												'width': sidebarWidth +"px"												
											}); 
											$sidebar.addClass("stuck");
											return;
										}
								}

							});
						}
				});

		};

	}

	//run the script
	$(window).on("rt_loaded resize rt_fix_sticky_sidebar",function(e){		 
		$(".sticky-sidebar").rt_sticky_sidebar();
		$(window).trigger("scroll"); 
	});

	//check dynamic ajax contents
	$(window).on('rt_ajax_complete', function() {  	
		setTimeout(function() {	 
			$(window).trigger("rt_fix_sticky_sidebar");
		}, 150 );	
	}); 

	//fix sticky sidebar when content height changed - woocommerce tabs
	$(".wc-tabs > li").on("click load",function(){
		setTimeout(function(){
			$(window).trigger("rt_fix_sticky_sidebar");
		},50);
	});

	/* ******************************************************************************* 

		Fix Select 2 styling

	********************************************************************************** */  
	$('select').on('select2:open', function (e) { 
    	$(".select2-container").removeClass("default-style").addClass("default-style");
	});

	/* ******************************************************************************* 

		CUSTOM BUTTON HOVERS

	********************************************************************************** */  
	$.fn.rt_button_hovers = function() {
		var styles = "";
		$(this).each(function(){
			var $this = $(this); 
				$this.find("> span:only-child").clone().appendTo($this); 

				if($this[0].hasAttribute("data-hover-style")){
					var unique_class_name = "button-" + Math.floor((Math.random() * 10000) + 1);
					$this.addClass(unique_class_name);
					styles += "."+unique_class_name+":hover{"+$this.data("hover-style")+"}";
					$this.removeAttr("data-hover-style");
				}
		}); 
		if( styles !== "" ){
			$("<style>"+styles+"</style>").appendTo($("head"));
		}
	};

	$('.button_').rt_button_hovers();

	//button widget selective refresh in the Customizer.
	$( function() {
		if ( 'undefined' !== typeof wp && wp.customize && wp.customize.selectiveRefresh ) {
			wp.customize.selectiveRefresh.bind( 'sidebar-updated', function( sidebarPartial ) { 
				$('.widget .button_').rt_button_hovers();
			} );
		}
	} );


	/* ******************************************************************************* 

		TOOLTIPS

	********************************************************************************** */  
	$.fn.rt_tooltips = function() {
		$(this).each(function(){
			
			var $this = $(this); 
			var tooltip = $this.find("mark"); 
			var tooltip_h = tooltip.height(); 

				$this.on("touchstart mouseenter",function(){ 
					tooltip.css({
						"display" : "block",
						"top" : $this.offset().top - $(window).scrollTop() - tooltip_h - 20 +"px",
						"left" :  $this.offset().left +  ( ($this.outerWidth() - tooltip.outerWidth()) / 2  )
					}); 

					$(window).on("scroll.tooltip",function(){
						tooltip.removeAttr("style"); 
						$(window).off("scroll.tooltip");
					});
				});

				$this.on("mouseleave touchmove",function(){ 
					tooltip.removeAttr("style");
				});

		}); 
	};

	$('.rt-tooltip-text').rt_tooltips(); 

})(jQuery);