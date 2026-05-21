<?php
add_action( 'wp_footer', function() {
    if ( is_singular( 'post' ) && ! is_user_logged_in() ) {
        echo do_shortcode( '[scroll_popup_trigger scroll="10" delay="500" template="cambridgeblog"]' );
    }
} );