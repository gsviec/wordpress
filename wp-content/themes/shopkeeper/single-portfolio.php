<?php

	switch ( getbowtied_portfolio_layout(get_the_ID()) )
	{        
	    case "boxed":
	        get_template_part( 'single-portfolio-boxed' );
	        break;
	    case "full":
	        get_template_part( 'single-portfolio-full' );
	        break;
	    default:
	        get_template_part( 'single-portfolio-full' );
	        break;
	}