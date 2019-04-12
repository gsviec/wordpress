( function( $ ) {




	/* *******************************************************************************

		ELEMENTOR MASONRY FIX

	********************************************************************************** */ 

	$( window ).on( 'elementor/frontend/init', function() {	 	
		elementorFrontend.hooks.addAction( 'frontend/element_ready/global', function( $scope, $){
			var isotope_elements = $(".masonry, .masonry-gallery, .metro-gallery");
				if ( isotope_elements.length ) {
					isotope_elements.imagesLoaded(function() {
						isotope_elements.rt_run_masonry_isotope();
						$('.filter-holder').rt_filter_nav();

						$scope.find(".has-overlay, .imgeffect").rt_image_overlays(); //fix
					}); 
				}
		});
	});


	/* *******************************************************************************

		RUN FUNCTIONS WHEN ELEMENT READY

	********************************************************************************** */ 
	var rt_elementor_init = function( $scope, $ ) {
		$scope.find('.rt_tabs').rt_tabs();
		$scope.find(".rt-category-tree").rt_category_tree();  
		$scope.rt_lightbox("init");
		$scope.find(".rt-countdown:not(.started)").rt_countdown();
		$scope.find('.rt-anim').rt_anim(); 
		$scope.find('.naturalife-progress-bar-holder').rt_progress_bar();
		$scope.find('.rt-pie-chart').rt_pie_carts();
		$scope.find('.validate_form').rt_contact_form();
		$scope.find(".rt-toggle").rt_accordion();
		$scope.find('.pricing_table.compare').rt_tables();
		$scope.find('.rt_counter').rt_counter();
		$scope.find(".imgeffect").rt_image_hover(); 
		$scope.find(".has-overlay, .imgeffect").rt_image_overlays(); 
		$scope.find('.button_').rt_button_hovers();

		$scope.rt_start_carousels();			 
	};
	
	$( window ).on( 'elementor/frontend/init', function() {	 
		elementorFrontend.hooks.addAction( 'frontend/element_ready/global', rt_elementor_init );
	} );

	/* 	ELEMENTOR EDITOR MODE CHANGE Z-INDEX OF THE HEADER */
	$( window ).on( 'elementor/frontend/init', function() {	 	
		$("body").on("mouseenter",function(){
			$(".top-header").css({"z-index":0}); 
		}).on("mouseleave",function(){
			$(".top-header").css({"z-index":""}); 
		}); 
	} );

} )( jQuery );