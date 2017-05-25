<?php
/*
 * Template Name: Research Index
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
    'post_type' => 'cfnu_research',
    'paged' => 1
);

if($_GET['tag']){
    $args['tax_query'] = array(
        array(
            'taxonomy' => 'research_tag',
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

$featured_research_title = get_field('featured_research_title');
$smarty->assign('featured_research_title', $featured_research_title);

$featured_research = get_field('featured_research');
foreach($featured_research as &$featured_research_item){
    format_post_for_display($featured_research_item);
}
$smarty->assign('featured_research', $featured_research);

$all_research_title = get_field('all_research_title');
$smarty->assign('all_research_title', $all_research_title);

$smarty->assign('months', get_months());
$smarty->assign('years', get_years('cfnu_research'));
$smarty->assign('filter_tags', get_post_terms('research_tag'));
$smarty->assign('post_type', 'cfnu_research');

get_header();

$smarty->display('pages/page-cfnu_research.tpl');

get_footer();
