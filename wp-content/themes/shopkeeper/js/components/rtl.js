function i(){e(".main-navigation > ul > .menu-item").mouseenter(function() {
    if (e(this).children(".sub-menu").length > 0) {
        var t = e(this).children(".sub-menu");

             i = parseInt(e(window).outerWidth());

            s = parseInt(e(this).offset().left);
            var ri = i - s;

            a = parseInt(t.outerWidth()/2);

             

			//alert("n = " + i);
            
            n = ri-a;
            
            t.css('left' , a-(t.outerWidth()));

        // 0 > n && t.css("left", n - 30 + "px")
    }
})}

jQuery(window).load( function() {

    if( jQuery('html').attr('dir') == 'rtl' ){
            jQuery('[data-vc-full-width="true"]').each( function(i,v){
                jQuery(this).css('right' , jQuery(this).css('left') ).css( 'left' , 'auto');
            });
        }
});