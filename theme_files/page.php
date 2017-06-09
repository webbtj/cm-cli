<?php
/*
 * Template Name: Standard Subpage
 */

global $post;

$smarty = wp_smarty();

$smarty->assign('title', $post->post_title);

$content = apply_filters('the_content', $post->post_content);

$smarty->assign('content', $content);

$fields = get_acf_fields();
$smarty->assign('fields', $fields);

get_header();

$smarty->display('pages/page.tpl');

get_footer();
