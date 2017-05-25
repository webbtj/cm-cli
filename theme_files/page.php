<?php
/*
 * Template Name: Standard Subpage
 */

global $post;

$smarty = wp_smarty();

$smarty->assign('title', $post->post_title);

$content = apply_filters('the_content', $post->post_content);

$smarty->assign('content', $content);

get_header();

$smarty->display('pages/page.tpl');

get_footer();
