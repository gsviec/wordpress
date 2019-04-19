jQuery(function($) {

	"use strict";


    function gbt_ajaxCall( data ) {
    	var thisBtn		= $(".wizard-demo-import .install:not(.done-ajax)");

		$.ajax({
			method:      'POST',
			url:         gbtStrings.ajaxurl,
			data:        data,
			contentType: false,
			processData: false,
			beforeSend:  function() {
				$( '.js-ocdi-ajax-loader' ).show();
			}
		})
		.done( function( response ) {
			if ( 'undefined' !== typeof response.status && 'newAJAX' === response.status ) {
				gbt_ajaxCall( data );
			}
			else if ( 'undefined' !== typeof response.status && 'customizerAJAX' === response.status ) {
				// Fix for data.set and data.delete, which they are not supported in some browsers.
				var newData = new FormData();
				newData.append( 'action', 'ocdi_import_customizer_data' );
				newData.append( 'security', gbtStrings.ajax_nonce );

				gbt_ajaxCall( newData );
			}
			else if ( 'undefined' !== typeof response.status && 'afterAllImportAJAX' === response.status ) {
				// Fix for data.set and data.delete, which they are not supported in some browsers.
				var newData = new FormData();
				newData.append( 'action', 'ocdi_after_import_data' );
				newData.append( 'security', gbtStrings.ajax_nonce );
				gbt_ajaxCall( newData );
			}
			else if ( 'undefined' !== typeof response.message ) {
				// $( '.js-ocdi-ajax-response' ).append( '<p>' + response.message + '</p>' );
				$( '.js-ocdi-ajax-loader' ).hide();

				thisBtn.removeClass("doing-ajax").addClass("done-ajax").html("Done!");
				var next =thisBtn.attr("href");
				window.location.href=next;

				// Trigger custom event, when OCDI import is complete.
				$( document ).trigger( 'ocdiImportComplete' );
			}
			else {
				$( '.js-ocdi-ajax-response' ).append( '<div class="notice  notice-error  is-dismissible"><p>' + response + '</p></div>' );
				$( '.js-ocdi-ajax-loader' ).hide();
				thisBtn.removeClass("doing-ajax").addClass("failed-ajax").html("Try again?");
			}
		})
		.fail( function( error ) {
			$( '.js-ocdi-ajax-response' ).append( '<div class="notice  notice-error  is-dismissible"><p>Error: ' + error.statusText + ' (' + error.status + ')' + '</p></div>' );
			$( '.js-ocdi-ajax-loader' ).hide();
			thisBtn.removeClass("doing-ajax").addClass("failed-ajax").html("Try again?");
		});
    }

	/**
	 * Demo import
	 *
	 *
	 */
	$(".wizard-demo-import").on("click", " .install:not(.done-ajax)", function(e) {

		var thisBtn = $(this);
		thisBtn.removeClass("failed-ajax").addClass("doing-ajax").html("Installing...");

		// Prepare data for the AJAX call
		var data = new FormData();
		data.append( 'action', 'ocdi_import_demo_data' );
		data.append( 'security', gbtStrings.ajax_nonce );
		data.append( 'selected', $( '#ocdi__demo-import-files' ).val() );

		// AJAX call to import everything (content, widgets, before/after setup)
		gbt_ajaxCall( data );

		e.preventDefault();
	});

	var status = true;

	function parse_plugins() {

		var pluginContainer = $(".plugins .plugin:not(.parsed):first");

		if (pluginContainer.length > 0) {

			// console.log("found container");

			var pluginBtn = $(pluginContainer).find(".button.ajax-request");

			if (pluginBtn.length > 0) {
				// console.log("found button");

				var url = pluginBtn.attr("href");
				var pluginSlug = pluginBtn.attr("data-plugin");
				var ajaxUrl = pluginBtn.attr("data-verify");
				var action = pluginBtn.attr("data-action");

				var self = pluginBtn;

				var doAction = jQuery.ajax({
					url: url,
			        type: "get"
				});

				doAction.complete(function(e, xhr){ 

					$.post(ajaxUrl,
					{
						action	  : "gbt_get_wizard_plugins",
						gbt_plugin: pluginSlug
					},
					function ( rsp ) { 

						// console.log(rsp);
						if ( rsp === true ) {
							// The action was done correctly
							status = status && true;
							pluginContainer.addClass("parsed").find(".plugin-status").empty().html("<span class=\"dashicons dashicons-yes\"></span>");

						} else {
							// The action failed for whatever reason
							status = status && false;
							pluginContainer.addClass("parsed").find(".plugin-status").empty().html("<span class=\"dashicons dashicons-no\"></span>");

						}
						parse_plugins(); // recursivity
					});
				});
			} else {
				pluginContainer.addClass("parsed");
				pluginContainer.find(".plugin-status").empty().html("<span class=\"dashicons dashicons-yes\"></span>");
				parse_plugins(); // recursivity
			}

		} else {
			if ( status === true ) {
				$(".wizard-plugins .install").removeClass("doing-ajax").removeClass("failed-ajax").addClass("done-ajax").html("Done!");
				var next = $(".wizard-plugins .install").attr("href");
				window.location.href=next;
			} else {
				$(".plugins .plugin").removeClass("parsed");
				$(".wizard-plugins .install").removeClass("doing-ajax").addClass("failed-ajax").html("Try again?");
			}
			return false;
		}
	}

	$(".wizard-plugins").on("click", " .install:not(.done-ajax)", function(e) {
			e.preventDefault();
			$(this).removeClass("failed-ajax").addClass("doing-ajax").html("Installing...");
			parse_plugins();
	});

});
