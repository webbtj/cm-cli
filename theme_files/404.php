<?php

global $post;

$smarty = wp_smarty();

$title_404 = get_field('404_title', 'options');
$smarty->assign('title', $title_404);

$content_404 = get_field('404_content', 'options');
$smarty->assign('content', $content_404);

get_header();

$smarty->display('pages/page.tpl');

get_footer();
