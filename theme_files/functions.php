<?php
define('ASSET_VERSION', '0.0.1');
define('WP_USE_THEMES', true);
define('ASSETS_DIR', get_template_directory_uri() . '/assets/');

add_action('wp_enqueue_scripts', 'cm_add_stylesheets');

function cm_add_stylesheets() {

    wp_enqueue_style('font-awesome.min', '/mockup/assets/vendor/font-awesome.min.css', array(), ASSET_VERSION , 'all');
    wp_enqueue_style('ionicons.min', '/mockup/assets/vendor/ionicons.min.css', array(), ASSET_VERSION , 'all');
    wp_enqueue_style('normalize', '/mockup/assets/vendor/normalize.css', array(), ASSET_VERSION , 'all');
    wp_enqueue_style('slick', '/mockup/assets/vendor/slick.css', array(), ASSET_VERSION , 'all');
    wp_enqueue_style('style', '/mockup/assets/css/style.css', array(), ASSET_VERSION , 'all');

    wp_enqueue_style('dev', get_template_directory_uri() . '/assets/css/dev.css', array(), ASSET_VERSION , 'all');

}
add_action('wp_enqueue_scripts', 'cm_add_javascripts');

function cm_add_javascripts(){
	wp_enqueue_script('app', get_template_directory_uri() . '/assets/js/app.js', array('jquery'), ASSET_VERSION, true);

}

function wp_smarty(){
    global $wp_smarty, $post;

    if($wp_smarty)
        return $wp_smarty;

    $wp_smarty = smarty_get_instance();

    $wp_smarty  ->setTemplateDir(dirname(__FILE__) . '/templates')
                ->setCompileDir(dirname(__FILE__) . '/templates_c')
                ->setCacheDir(dirname(__FILE__) . '/cache');

    $stylesheet_directory = get_bloginfo('stylesheet_directory');
    $wp_smarty->assign('stylesheet_directory', $stylesheet_directory);
    $wp_smarty->assign('assets_dir', ASSETS_DIR);

    //Load Menus
    cm_load_menus($wp_smarty);

    $wp_smarty->assign('Y', date('Y'));

    if(function_exists('bcn_display')){
        $wp_smarty->assign('breadcrumbs', do_shortcode(bcn_display(true)));
    }

    cm_assign_translations($wp_smarty);
    cm_assign_languages($wp_smarty);
    cm_assign_menus($wp_smarty);
    cm_assign_social($wp_smarty);

    return $wp_smarty;
}



require_once('includes/ajax-requests.php');
require_once('includes/translations.php');
require_once('includes/menus.php');
require_once('includes/social.php');
require_once('includes/custom-image-sizes.php');
require_once('includes/helpers.php');
require_once('includes/cleanup.php');

//--Register Post Types

//--Register Taxonomies


add_action( 'pre_get_posts',  'set_posts_per_search_page'  );
function set_posts_per_search_page( $query ) {

    if(is_search())
        $query->set( 'posts_per_page', -1 );

    return $query;
}

add_action('wp_enqueue_scripts', 'clean_wordpress_header');
function clean_wordpress_header(){
    wp_deregister_script('comment-reply');

    remove_action('admin_print_styles',     'print_emoji_styles');
    remove_action('wp_head',                'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts',    'print_emoji_detection_script');
    remove_action('wp_print_styles',        'print_emoji_styles');
    remove_filter('wp_mail',                'wp_staticize_emoji_for_email');
    remove_filter('the_content_feed',       'wp_staticize_emoji');
    remove_filter('comment_text_rss',       'wp_staticize_emoji');
    remove_action('wp_head',                'rest_output_link_wp_head');
    remove_action('wp_head',                'wp_oembed_add_discovery_links');
    remove_action('template_redirect',      'rest_output_link_header', 11, 0);
    remove_action('wp_head',                'rsd_link');
    remove_action('wp_head',                'wlwmanifest_link');
    remove_action('wp_head',                'wp_shortlink_wp_head');
    remove_action('wp_head',                'wp_generator');

    add_filter('emoji_svg_url', '__return_false');
    if(!is_front_page()){
        wp_dequeue_style('sb_instagram_styles');
        wp_dequeue_style('sb_instagram_icons');
    }
}
