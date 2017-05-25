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

    if($_GET['tag']){
        switch ($type) {
            case 'cfnu_international':
                $taxonomy = 'international_tag';
                break;
            case 'cfnu_event':
                $taxonomy = 'event_tag';
                break;
            case 'cfnu_research':
                $taxonomy = 'research_tag';
                break;
            default:
                $taxonomy = 'post_tag';
                break;
        }
        $args['tax_query'] = array(
    		array(
    			'taxonomy' => $taxonomy,
    			'field'    => 'slug',
    			'terms'    => $_GET['tag'],
    		),
    	);
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

    if($type == 'cfnu_campaign'){
        global $campaign_page_ID;
        $template_page = get_page_by_template('page-cfnu_campaign.php');
        $campaign_page_ID = $template_page->ID;
    }

    $posts = load_posts($args);
    $smarty->assign('posts', $posts);

    $args['paged']++;
    $has_more = (int) (bool) load_posts($args);
    $smarty->assign('has_more', $has_more);

    $template_file = 'partials/posts.tpl';
    $index_file = 'page-post.php';

    switch($type){
        case 'cfnu_campaign':
            $template_file = 'partials/cfnu_campaigns.tpl';
            $index_file = 'page-cfnu_campaign.php';
            break;
        case 'cfnu_research':
            $template_file = 'partials/cfnu_research.tpl';
            $index_file = 'page-cfnu_research.php';
            break;
        case 'post':
            $template_file = 'partials/posts.tpl';
            $index_file = 'page-post.php';
            break;
        case 'cfnu_international':
            $template_file = 'partials/posts.tpl';
            $index_file = 'page-cfnu_international.php';
            break;
        case 'cfnu_event':
            $template_file = 'partials/posts.tpl';
            $index_file = 'page-cfnu_event.php';
            break;
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
