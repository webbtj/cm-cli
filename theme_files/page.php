<?php
/*
 * Template Name: Standard Subpage
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

$smarty->assign('cta_top', false);
$smarty->assign('cta', get_cta());

get_header();

$smarty->display('pages/page.tpl');

get_footer();
