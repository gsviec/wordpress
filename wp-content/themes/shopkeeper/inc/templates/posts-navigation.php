<?php

/******************************************************************************/
/* Post Navigation Archive *****************************************************/
/******************************************************************************/

if ( ! function_exists( 'getbowtied_the_posts_navigation' ) ) :
function getbowtied_the_posts_navigation() {
    // Don't print empty markup if there's only one page.
    if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
        return;
    }
    ?>
        <nav class="posts-navigation">
            <ul class="nav-links">

                        <?php  
                            $args = array(
                               'base'  => esc_url_raw( str_replace( 999999999, '%#%', remove_query_arg( 'add-to-cart', get_pagenum_link( 999999999, false ) ) ) ),
                            'format'       => '',
                            'add_args'     => '',
                            'current'      => max( 1, get_query_var( 'paged' ) ),
                            'total'        => $wp_query->max_num_pages,
                            'prev_text'    => '<i class="fa fa-angle-left"></i>',
                            'next_text'    => '<i class="fa fa-angle-right"></i>',
                            'type'         => 'list',
                            'end_size'     => 3,
                            'mid_size'     => 3
                            ); 

                            echo paginate_links($args); 
                        ?>
            </ul><!-- .nav-links -->
        </nav><!-- .navigation -->
    <?php
}
endif;