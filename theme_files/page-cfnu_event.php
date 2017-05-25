<?php
/*
 * Template Name: Event Index
 */

global $post;

$smarty = wp_smarty();

$smarty->assign('title', $post->post_title);

$content = apply_filters('the_content', $post->post_content);

$smarty->assign('content', $content);

$header_image = get_field('header_image');
if(!$header_image){
    $header_image = get_field('page_header', 'options');
}
$smarty->assign('header_image', $header_image);

$args = array(
    'post_type' => 'cfnu_event',
    'paged' => 1
);

if($_GET['tag']){
    $args['tax_query'] = array(
        array(
            'taxonomy' => 'event_tag',
            'field'    => 'slug',
            'terms'    => $_GET['tag'],
        ),
    );
}

$posts = load_posts($args);
$smarty->assign('posts', $posts);

$args['paged']++;
$has_more = (int) (bool) load_posts($args);
$smarty->assign('has_more', $has_more);

$smarty->assign('index_page_url', get_permalink());

$smarty->assign('months', get_months());
$smarty->assign('years', get_years('cfnu_event'));
$smarty->assign('filter_tags', get_post_terms('event_tag'));
$smarty->assign('post_type', 'cfnu_event');

get_header();

$smarty->display('pages/page-cfnu_event.tpl');

get_footer();
