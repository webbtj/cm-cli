<?php

global $post;

$smarty = wp_smarty();

$header_image = get_field('page_header', 'options');
$smarty->assign('header_image', $header_image);

$title_404 = get_field('404_title', 'options');
$smarty->assign('title', $title_404);

$content_404 = get_field('404_content', 'options');
$smarty->assign('content', $content_404);

get_header();

$smarty->display('pages/page.tpl');

get_footer();
