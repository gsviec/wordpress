<?php

/******************************************************************************/
/* Portfolio Layout ***********************************************************/
/******************************************************************************/	

function getbowtied_portfolio_layout($page_id) {

	$page_portfolio_layout = get_post_meta( $page_id, 'portfolio_layout', true );

	$layout = "full";

	switch ($page_portfolio_layout)
	{        
	    case "boxed":
	        $layout = "boxed";
	        break;
	    case "full":
	        $layout = "full";
	        break;
	    default:
	        $layout = "full";
	        break;
	}

	return $layout;

}