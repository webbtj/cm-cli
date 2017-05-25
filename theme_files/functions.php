<?php
define('ASSET_VERSION', '0.0.1.8');
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

    // wp_deregister_script('jquery');
    // wp_enqueue_script('jquery', get_template_directory_uri() . '/assets/js/jquery.js', array(), ASSET_VERSION, true);
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

    /* ALWAYS REMEMEBER TO RESET QUERY!!! */

    //Load Menus
    $primary = wp_nav_menu(array(
        'theme_location' => 'primary',
        'echo' => false,
        'menu_class' => 'primary-menu-class',
        'menu_id' => 'primary',
        'container' => 0
    ));
    $wp_smarty->assign('menu_primary', $primary);

    //Load Options

    $wp_smarty->assign('Y', date('Y'));

    if(function_exists('bcn_display')){
        $wp_smarty->assign('breadcrumbs', do_shortcode(bcn_display(true)));
    }

    $contact_form_id = get_field('contact_form', 'options');
    $shortcode = '[gravityform id="' . $contact_form_id . '" title="false" description="false" ajax="true"]';
    $contact_form = do_shortcode($shortcode);
    $wp_smarty->assign('contact_form', $contact_form);

    do_translations($wp_smarty);

    $main_menu = array_values(get_nav_tree('main_menu'));
    $wp_smarty->assign('main_menu', $main_menu);

    $languages = icl_get_languages('skip_missing=0');
    $wp_smarty->assign('languages', $languages);

    $no_filter_results = get_field('no_filter_results', 'options');
    $wp_smarty->assign('no_filter_results', $no_filter_results);

    $social = array(
        'title' => wp_title('|', false, 'right') . get_bloginfo('name', 'display'),
        'url' => get_permalink(),
    );

    switch($post->post_type){
        case 'post':
            $social['description'] = get_the_excerpt($post->ID);
            $header_image = get_field('header_image');
            if(!$header_image){
                $header_image = get_field('news_header', 'options');
            }
            break;
        case 'cfnu_campaign':
            $social['description'] = get_the_excerpt($post->ID);
            $header_image = get_field('header_image');
            if(!$header_image){
                $header_image = get_field('campaign_header', 'options');
            }
            break;
        case 'cfnu_event':
            $social['description'] = get_the_excerpt($post->ID);
            $header_image = get_field('header_image');
            if(!$header_image){
                $header_image = get_field('event_header', 'options');
            }
            break;
        case 'cfnu_international':
            $social['description'] = get_the_excerpt($post->ID);
            $header_image = get_field('header_image');
            if(!$header_image){
                $header_image = get_field('international_header', 'options');
            }
            break;
        case 'cfnu_research':
            $social['description'] = get_the_excerpt($post->ID);
            $header_image = get_field('header_image');
            if(!$header_image){
                $header_image = get_field('research_header', 'options');
            }
            break;
        case 'page':
            if(basename(get_page_template()) == 'page-home.php'){
                $social['description'] = strip_tags(get_field('brand_statement_title'));
                $header_image = get_field('banner_image');
            }else{
                $social['description'] = get_the_excerpt($post->ID);
                $header_image = get_field('header_image');
            }
            if(!$header_image){
                $header_image = get_field('page_header', 'options');
            }
            break;
    }
    $social['image'] = $header_image;

    $wp_smarty->assign('social', $social);

    return $wp_smarty;
}

add_shortcode('news-home-title', 'get_news_index_title');
function get_news_index_title(){
    $index_page = get_page_by_template('page-post.php');
    if($index_page && isset($index_page->ID)){
        return $index_page->post_title;
    }
}

add_shortcode('news-home-url', 'get_news_index_url');
function get_news_index_url(){
    $index_page = get_page_by_template('page-post.php');
    if($index_page && isset($index_page->ID)){
        return get_permalink($index_page->ID);
    }
}

add_shortcode('search-title', 'get_search_title');
function get_search_title(){
    return _x('Search', 'Theme', 'CFNU');
}

function format_post_for_display(&$p){
    $p->url = get_permalink($p->ID);
    switch ($p->post_type) {
        case 'cfnu_campaign':
            $index_image = get_field('index_image', $p->ID);
            if(!$index_image){
                global $campaign_page_ID;
                $index_image = get_field('default_index_image', $campaign_page_ID);
            }
            $p->index_image = $index_image;
            $p->excerpt = get_the_excerpt($p->ID);
            break;
        case 'cfnu_research':
            $p->date = get_post_date($p->ID);
            $p->excerpt = get_the_excerpt($p->ID);
            $terms = get_the_terms($p->ID, 'research_tag');
            $p->tags = $terms;
            $p->cta = get_cta('call_to_action_', null, $p->ID);
            break;
        case 'cfnu_international':
            $p->date = get_post_date($p->ID);
            $p->excerpt = get_the_excerpt($p->ID);
            $terms = get_the_terms($p->ID, 'international_tag');
            $p->tags = $terms;
            break;
        case 'cfnu_event':
            $p->date = get_field('date', $p->ID);
            $p->excerpt = get_the_excerpt($p->ID);
            $terms = get_the_terms($p->ID, 'event_tag');
            $p->tags = $terms;
            break;
        case 'post':
            $p->date = get_post_date($p->ID);
            $p->excerpt = get_the_excerpt($p->ID);
            $terms = get_the_terms($p->ID, 'post_tag');
            $p->tags = $terms;
            break;
    }
    // switch ($post->post_type) {
    //     case 'page':
    //         $post->excerpt = substr(pseudo_excerpt($post, 'post_excerpt', 'post_content', 'history_expertise'), 0, 500);
    //         break;
    //     case 'mdw_lawyer':
    //         $post->first_name = get_field('first_name', $post->ID);
    //         $post->last_name = get_field('last_name', $post->ID);
    //         $post->position = get_field('position', $post->ID);
    //         $post->excerpt = substr(pseudo_excerpt($post, 'about'), 0, 500);
    //         break;
    //     case 'post':
    //         $post->excerpt = substr(pseudo_excerpt($post, 'post_excerpt', 'post_content'), 0, 500);
    //         $post->author = get_post_objects(get_field('author', $post->ID), array('first_name', 'last_name', 'position'));
    //         $post->services = get_related_posts('mdw_service_to_post', $post->ID);
    //         $post->date = get_the_date('', $post->ID);
    //         break;
    //     case 'mdw_life_event':
    //         $post->excerpt = substr(pseudo_excerpt($post, 'post_excerpt', 'post_content'), 0, 500);
    //         break;
    //     case 'mdw_service':
    //         $post->excerpt = get_field('excerpt', $post->ID);
    //         if(!$post->excerpt)
    //           $post->excerpt = substr(pseudo_excerpt($post, 'description', 'expertise'), 0, 500);
    //         break;
    // }
}

function get_months(){
    return array(
        1 => 'January',
        2 => 'February',
        3 => 'March',
        4 => 'April',
        5 => 'May',
        6 => 'June',
        7 => 'July',
        8 => 'August',
        9 => 'September',
        10 => 'October',
        11 => 'November',
        12 => 'December',
    );
}

function get_years($post_type = 'post'){
    $args = array(
        'post_type' => $post_type,
        'posts_per_page' => 1,
        'order' => 'ASC'
    );
    $current_year = (int) date('Y');
    $posts = load_posts($args);
    if(count($posts) == 1){
        $p = $posts[0];
        $date = strtotime($p->post_date);
        $year = date('Y', $date);
        $years = array();
        for($i = $current_year; $i >= $year; $i--){
            $years[$i] = $i;
        }
        return $years;
    }
    return array(
        $current_year => $current_year
    );
}

function get_cta($cta_key = 'call_to_action_', $array = null, $post_id = null){
    if(!$post_id){
        global $post;
        $post_id = $post->ID;
    }

    if(!$array){
        $array = get_fields($post_id);
    }

    $type = $array[$cta_key . 'type'];
    $text = $array[$cta_key . 'text'];
    $internal_page = $array[$cta_key . 'internal_page'];
    $external_url = $array[$cta_key . 'external_url'];
    $file = $array[$cta_key . 'file'];

    switch ($type) {
        case 'internal':
            return array(
                'text' => $text,
                'link' => $internal_page,
                'target' => '_self',
            );
            break;
        case 'external':
            return array(
                'text' => $text,
                'link' => $external_url,
                'target' => '_blank',
            );
            break;
        case 'file':
            return array(
                'text' => $text,
                'link' => $file,
                'target' => '_blank',
            );
            break;
        default:
            return array();
            break;
    }

}

function get_post_terms($term){
    $terms = get_terms($term);
    if(isset($_GET['tag'])){
        foreach($terms as &$t){
            $t->selected = false;
            if($t->slug === $_GET['tag']){
                $t->selected = true;
            }
        }
    }
    return $terms;
}

function get_post_date($post_id = null){
    if($post_id){
        $p = get_post($post_id);
    }else{
        global $post;
        $p = $post;
    }

    $format = 'F j, Y';
    if (function_exists('icl_translate'))
        $format = icl_translate('Formats', $format, $format);

    $time = strtotime($p->post_date);
    return translate_date(date($format, $time));
}

function get_page_by_template($template_name, $suppress_filters = false){
    $args = array(
        'post_type' => 'page',
        'meta_key' => '_wp_page_template',
        'meta_value' => $template_name,
        'suppress_filters' => $suppress_filters,
    );
    global $post;
    $old_post = $post;
    $template_query = new WP_Query($args);
    $template_post = null;
    if($template_query->have_posts()){
        while($template_query->have_posts()){
            $template_query->the_post();
            $template_post = $template_query->post;
        }
    }
    wp_reset_query();
    $post = $old_post;
    return $template_post;
}

function parse_youtube_url($url){
    preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $url, $matches);
    if(!empty($matches) && $matches){
        return 'https://www.youtube.com/embed/' . $matches[0];
    }
}

function parse_youtube_url_thumbnail($url){
    preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $url, $matches);
    if(!empty($matches) && $matches){
        return 'http://img.youtube.com/vi/' . $matches[0] . '/0.jpg';
    }
}

function parse_youtube_url_href($url){
    preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $url, $matches);
    if(!empty($matches) && $matches){
        return 'https://www.youtube.com/watch?v=' . $matches[0];
    }
}

function parse_youtube_url_embed($url){
    preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $url, $matches);
    if(!empty($matches) && $matches){
        return '//www.youtube.com/embed/' . $matches[0] . '?rel=0';
    }
}

// Custom Image Sizes
add_action( 'after_setup_theme', 'cfnu_custom_image_sizes' );
function cfnu_custom_image_sizes() {
    add_image_size('1280w',     1280,   0,      false);
    add_image_size('1280x740',  1280,   740,    true);
    add_image_size('600h',      0,      600,    false);
    add_image_size('640x480',   640,    480,    false);
    //real sizes
    add_image_size('1920x1080',     1920,   1080,   true );
    add_image_size('1920x1282',     1920,   1282,   true );
    add_image_size('960w',          960,    0,      false);
    add_image_size('500x330',       500,    330,    true );
    add_image_size('500x500',       500,    500,    true );
    add_image_size('600w',          960,    0,      false);
}

// Add ACF Options Page
if(function_exists('acf_add_options_page')) {
    acf_add_options_page();
}

require_once('post_types/cfnu_event.php');
require_once('post_types/cfnu_international.php');
require_once('post_types/cfnu_campaign.php');
require_once('post_types/cfnu_research.php');
require_once('post_types/post.php');
require_once('includes/ajax-requests.php');
require_once('includes/translations.php');
require_once('includes/cleanup.php');

function pre($a){
    echo '<pre>';
    print_r($a);
    echo '</pre>';
}

register_nav_menu('main_menu', 'Main Menu');

//http://wordpress.stackexchange.com/questions/170033/convert-output-of-nav-menu-items-into-a-tree-like-multidimensional-array
function get_nav_tree($location){
    $theme_locations = get_nav_menu_locations();
    $menu_id = $theme_locations[$location];
    $items = wp_get_nav_menu_items( $menu_id );
    return  $items ? buildTree( $items, 0 ) : null;
}

function buildTree( array &$elements, $parent = 0 ){
    $branch = array();
    foreach ( $elements as &$element )
    {
        if ( $element->menu_item_parent == $parent )
        {
            $children = buildTree( $elements, $element->ID );
            if ( $children )
                $element->children = $children;

            $branch[$element->ID] = $element;
            unset( $element );
        }
    }
    return $branch;
}

add_action( 'pre_get_posts',  'set_posts_per_search_page'  );
function set_posts_per_search_page( $query ) {

    if(is_search())
        $query->set( 'posts_per_page', -1 );

    return $query;
}
