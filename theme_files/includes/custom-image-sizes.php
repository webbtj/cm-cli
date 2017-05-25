<?php
// Custom Image Sizes
add_action( 'after_setup_theme', 'cfnu_custom_image_sizes' );
function cfnu_custom_image_sizes() {
    //--Image Sizes
    add_image_size('1920x1080',     1920,   1080,   true );
    add_image_size('1920x1282',     1920,   1282,   true );
    add_image_size('960w',          960,    0,      false);
    add_image_size('500x330',       500,    330,    true );
    add_image_size('500x500',       500,    500,    true );
    add_image_size('600w',          960,    0,      false);
}
