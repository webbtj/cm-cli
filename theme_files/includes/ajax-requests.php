<?php

add_action('wp_ajax_load_posts', 'load_posts_output');
add_action('wp_ajax_nopriv_load_posts', 'load_posts_output');

function load_posts_output(){

    $smarty = wp_smarty();

    $type = $_GET['type'];
    $page = $_GET['page'];
    $args = array(
        'post_type' => $type,
        'paged' => $page
    );

    $args['tax_query'] = array();

    //--Taxonomy Load Posts Query

    if(empty($args['tax_query'])){
        unset($args['tax_query']);
    }

    if($_GET['year']){
        if($type == 'cfnu_event'){
            $date_query = $_GET['year'];
            if($_GET['month']){
                $date_query .= '-' . str_pad($_GET['month'], 2, '0', STR_PAD_LEFT);
            }
            $args['meta_query'] = array(
                array(
                    'key' => 'date',
                    'value' => $date_query,
                    'compare' => 'LIKE'
                )
            );
        }else{
            $args['date_query'] = array(
                'year' => $_GET['year']
            );
            if($_GET['month']){
                $args['date_query']['month'] = $_GET['month'];
            }
        }
    }

    $posts = load_posts($args);
    $smarty->assign('posts', $posts);

    $args['paged']++;
    $has_more = (int) (bool) load_posts($args);
    $smarty->assign('has_more', $has_more);

    $template_file = 'partials/posts.tpl';
    $index_file = 'page-post.php';

    switch($type){
        case 'post':
            $template_file = 'partials/post-index.tpl';
            $index_file = 'page-post.php';
            break;
        //--Post Type Load Posts Output
    }

    $index_page = get_page_by_template($index_file);
    if($index_page && isset($index_page->ID)){
        $index_page_url = get_permalink($index_page->ID);
        $smarty->assign('index_page_url', $index_page_url);
    }
    $smarty->display($template_file);

    exit;
}

function load_posts($additional_args = array()){
    $post_type = 'post';

    $args = array(
        'post_type' => $post_type
    );

    $args = array_merge($args, $additional_args);

    $posts = new WP_Query($args);
    $output = array();

    while($posts->have_posts()){
        $posts->the_post();
        $p = $posts->post;
        format_post_for_display($p);
        $output[] = $p;
    }

    wp_reset_query();

    return $output;
}
