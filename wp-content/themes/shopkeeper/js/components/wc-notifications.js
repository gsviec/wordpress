jQuery(document).ready(function ($) {

	if( $('body.gbt_classic_notif').find('.product_layout_3').length > 0 ) {
		$('.woocommerce-message').detach().prependTo('.product_layout_3');
		$('.woocommerce-info').detach().prependTo('.product_layout_3');
		$('.woocommerce-notice').detach().prependTo('.product_layout_3');
		$('.woocommerce-error').detach().prependTo('.product_layout_3');	
	}

	// close notifications
	if( $('body').hasClass('gbt_custom_notif') ) {
		$('body').on('click touchend', '.woocommerce-error, .woocommerce-info, .woocommerce-message, .woocommerce-notice', function(e) {
			//$(this).hide();
			$(this).addClass('fade-out');
			var that = $(this);
			setTimeout(function(){
				that.css('display', 'none');
			}, 500, that);
		});
	}

	$(window).load(function(e) {
		display_custom_notifications();
	});

	$( document.body ).on( 'updated_cart_totals', function(){
		display_custom_notifications();
	});

	$(document).on('added_to_cart', function(event, data) {
		display_custom_notifications();
	});

	$('.page-notifications').on('change', function() {
		display_custom_notifications();
	});

	$('form.woocommerce-checkout, .checkout_coupon').on('submit', function() {
		display_custom_notifications();
	});

	function display_custom_notifications() {

		if( $('body').hasClass('gbt_custom_notif')) {

			$('.page-notifications').removeClass('animate').empty();
		
			setTimeout(function(){

				$(".gbt_custom_notif:not(.woocommerce-account) .woocommerce-notice:not(.woocommerce-info)").each(function(){
					if($(this).hasClass('woocommerce-thankyou-order-received')) return;
					wrap_notification($(this));
				});

				$(".gbt_custom_notif:not(.woocommerce-account) .woocommerce-info").each(function(){
					wrap_notification($(this));
				});

				$(".gbt_custom_notif:not(.woocommerce-account) .woocommerce-error").each(function(){
					wrap_notification($(this));
				});

				$(".gbt_custom_notif:not(.woocommerce-account) .woocommerce-message").each(function(){
					wrap_notification($(this));
				});

				function wrap_notification(notification) {

					if( notification.html().length > 0 ) {

						if( notification.find('.woocommerce-message-wrapper').length == 0 &&
							notification.find('.product_notification_wrapper').length == 0 ) {
							
							notification.wrapInner( "<div class='notice-text'></div>" );
						}

						notification.detach().appendTo('.page-notifications').addClass('notification');						
					}
				}
				
				if( $('.page-notifications').html().length > 0 ) {
					$('.page-notifications').addClass('animate');
				}
			}, 1000);
		}
	}

	//=====================================================================
	//	Build dynamic add to cart message
	//=====================================================================
	var notificationContent = false;

	$('body').on('click touchend', '.ajax_add_to_cart', function(){
		$('.woocommerce-message').remove();
		if ($('body').hasClass('woocommerce-wishlist'))
		{
			var imgSrc = $(this).parents('tr').find('img.attachment-shop_thumbnail').attr('src');
			var prodTitle = $(this).parents('tr').find('.product-name a').html();
		}
		else 
		{
			var imgSrc = $(this).parents('li').find('img.attachment-shop_catalog').attr('src');
			var prodTitle = $(this).parents('li').find('.product-title-link').html();
		}

		if ( typeof imgSrc != 'undefined' && typeof prodTitle != 'undefined' && $('body').hasClass('gbt_custom_notif') )
		{
			notificationContent = '<div class="woocommerce-message"><div class="product_notification_wrapper"><div class="product_notification_background" style="background-image:url(' + imgSrc + ')"></div><div class="product_notification_text">&quot;' + prodTitle + '&quot;' + addedToCartMessage +'</div></div></div>';
		}
		else 
		{
			notificationContent = false;
		}
	});

	//======================================================
	//  Display notification on ajax add to cart
	//======================================================
	$(document).on('added_to_cart', function(event, data) {
		if (notificationContent != false)
		{
			$('#content').prepend(notificationContent);
			notificationContent = false;
		}
	});

	// ajax add to cart notification

	var productNotificationContent = false;

	$('body.single-product').on('click touchend', '.product_content_wrapper .product_infos .ajax_add_to_cart', function(){

		$(".product_infos a.added_to_cart_button").remove();

		$('.woocommerce-message').remove();
		$('.woocommerce-error').remove();

		if( $('body').hasClass('gbt_custom_notif') ) {

			var imgSrc = $('body.single-product .product-images-wrapper').find('.woocommerce-product-gallery__image:first-child img.wp-post-image').attr('src');
			var prodTitle = $('body.single-product .product_content_wrapper').find('.product_title').html();

			if ( typeof imgSrc != 'undefined' && typeof prodTitle != 'undefined' ) {
				productNotificationContent = '<div class="woocommerce-message notification"><div class="product_notification_wrapper"><div class="product_notification_background" style="background-image:url(' + imgSrc + ')"></div><div class="product_notification_text">&quot;' + prodTitle + '&quot;' + addedToCartMessage +'</div></div></div>';
			}

		} else {

			var prodTitle = $('body.single-product .product_content_wrapper').find('.product_title').html();

			if ( typeof prodTitle != 'undefined' ) {

				productNotificationContent = '<div class="woocommerce-message" role="alert"><div class="woocommerce-message-wrapper"><span class="success-icon"><i class="spk-icon spk-icon-cart-shopkeeper"></i></span><span class="notice_text">&quot;' + prodTitle +  '&quot;' + addedToCartMessage + '</span></div></div>';
			}
		}

		$(document).on('added_to_cart', function(event, data) {
			if (productNotificationContent != false)
			{
				setTimeout(function(){

					if( $('body').find('.product_layout_3').length > 0 ) {

						$('.product_layout_3').prepend(productNotificationContent);

					} else {
						$('.product_content_wrapper').prepend(productNotificationContent);
					}

					$('.page-notifications').trigger('change');
					productNotificationContent = false;
				}, 3500);
			}
		});
	});
});