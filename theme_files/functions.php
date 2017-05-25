<?php
define('ASSET_VERSION', '0.0.1');
define('WP_USE_THEMES', true);

add_action('wp_enqueue_scripts', 'cfnu_add_stylesheets');

function cfnu_add_stylesheets() {

    wp_enqueue_style('font-awesome.min', '/mockup/assets/vendor/font-awesome.min.css', array(), ASSET_VERSION , 'all');
    wp_enqueue_style('ionicons.min', '/mockup/assets/vendor/ionicons.min.css', array(), ASSET_VERSION , 'all');
    wp_enqueue_style('normalize', '/mockup/assets/vendor/normalize.css', array(), ASSET_VERSION , 'all');
    wp_enqueue_style('slick', '/mockup/assets/vendor/slick.css', array(), ASSET_VERSION , 'all');
    wp_enqueue_style('style', '/mockup/assets/css/style.css', array(), ASSET_VERSION , 'all');

    wp_enqueue_style('dev', get_template_directory_uri() . '/assets/css/dev.css', array(), ASSET_VERSION , 'all');

}
add_action('wp_enqueue_scripts', 'cfnu_add_javascripts');

function cfnu_add_javascripts(){
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

    //Load Menus
    cm_load_menus();

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
