jQuery(document).ready(function($){

	"use strict";

	//comming from wp_localize_script

	//shopkeeper_catalogMode
    
    function shopkeeper_catalog_mode() {
        if (getbowtied_scripts_vars.catalog_mode == 1) {
            $("form.cart div.quantity").empty();
            $("form.cart button.single_add_to_cart_button").remove();
        }
    }

    shopkeeper_catalog_mode();

})
    
