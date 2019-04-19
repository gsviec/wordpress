jQuery(document).ready(function($){

	//==============================================================================
	//	Minicart events
	//==============================================================================

	/* open minicart on click */
	if (getbowtied_scripts_vars.option_minicart == 1 && getbowtied_scripts_vars.option_minicart_open == 1) {

		$('body').on('click', '.shopping-bag-button .tools_button, .product_notification_wrapper', function(e) {

			close_notifications();
			
			if ( $(window).width() >= 1024 ) {

				calculate_minicart_margin();

				e.preventDefault();
				$('.shopkeeper-mini-cart').toggleClass('open');
				e.stopPropagation();	
				
			} else {
				e.stopPropagation();	
			}
		});

		/* close minicart */
		$('body').on('click', function(event){
			if( $('.shopkeeper-mini-cart').hasClass('open') ) 
			{
				if (!$(event.target).is('.shopkeeper-mini-cart') && !$(event.target).is('.shopping-bags-button .tools-button') && !$(event.target).is('.woocommerce-message')
					&& ( $('.shopkeeper-mini-cart').has(event.target).length === 0) )
				{
					$('.shopkeeper-mini-cart').removeClass('open');
				}
			}
		});
	}

	/* open minicart on hover */
	var hoverIn = null;
	var hoverOut = null;
	if (getbowtied_scripts_vars.option_minicart == 1 && getbowtied_scripts_vars.option_minicart_open == 2) {

		$('.shopping-bag-button').hover( function(e) {

			if( !($('.shopkeeper-mini-cart').hasClass('open')) && !hoverIn ) {

				hoverIn = window.setTimeout(function() {
	                hoverIn = null;

					close_notifications();
					
					if ( $(window).width() >= 1024 ) {

						calculate_minicart_margin();

						e.preventDefault();
						$('.shopkeeper-mini-cart').addClass('open');
						e.stopPropagation();	
						
					} else {
						e.stopPropagation();	
					}
				}, 350);
			}
		});

		$('.shopping-bag-button, .shopkeeper-mini-cart').hover( function(e) {
			if (hoverOut) {
	            window.clearTimeout(hoverOut);
	            hoverOut = null;
	        }
		}, function (e) {

	        if( !hoverOut ) {

	        	hoverOut = window.setTimeout(function() {
	                hoverOut = null;

	                if ( ($(window).width() >= 1024) && ($('.shopkeeper-mini-cart').hasClass('open')) ) {

						$('.shopkeeper-mini-cart').removeClass('open');
						
					}
               }, 500);
	        }

	        if (hoverIn) {
	            window.clearTimeout(hoverIn);
	            hoverIn = null;
	        }
	    });
	}

	function calculate_minicart_margin() {

		var top = 0;

		if( $('#wpadminbar').length ) {
			top += $('#wpadminbar').height();
		}

		if( $('.top-headers-wrapper').length ) {
			top += $('.top-headers-wrapper').height();
		}

		if( $('header').length && $('header').hasClass('menu-under') && $('.menu-under .main-navigation').length ) {
			top -= $('.main-navigation').height();
		}

		if( top > 0 ) {
			$('.shopkeeper-mini-cart').css('top', top);
		}
	}

	function close_notifications() {
		if( $('body').hasClass('gbt_custom_notif') ) {
			$('.page-notifications .notification').each(function(e) {
				$(this).addClass('fade-out');
				var that = $(this);
				setTimeout(function(){
					that.css('display', 'none');
				}, 500, that);
			});
		}
	}

	calculate_minicart_margin();

});