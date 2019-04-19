jQuery(function($) {
	
	"use strict";

	$(window).load(function() {

	});

	
	$(window).resize(function() {
	
	});	

	
    $(window).scroll(function() {

    });	 


    $('a.has-hover-img').mousemove(function(e){
    	var parentOffset = $(this).parent().offset();
    	var relX = e.pageX - parentOffset.left + 20;
  		var relY = e.pageY - parentOffset.top + 10;
	    $(this).find('span.menu-hover-img').stop().css({left:relX, top:relY});
	});


});


