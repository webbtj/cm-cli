<?php
/*
 * Template Name: Search Results
 */

global $post, $wp_query;

$smarty = wp_smarty();

$title = wp_title('', false);
$title = str_replace('Search Results', _x('Search Results', 'Theme', '[[theme-title]]') . ':', $title);

$smarty->assign('title', $title);

$output = array();

while(have_posts()){
    the_post();
    format_post_for_display($post);
    $output[] = $post;
}

$smarty->assign('posts', $output);

$fields = get_acf_fields();
$smarty->assign('fields', $fields);

get_header();

$smarty->display('pages/search.tpl');

get_footer();
