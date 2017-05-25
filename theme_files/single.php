<?php

global $post;

//[[post-type]]

$smarty = wp_smarty();

$smarty->assign('title', $post->post_title);

$content = apply_filters('the_content', $post->post_content);

$smarty->assign('content', $content);

$smarty->assign('cta', get_cta());

$date = get_post_date();
$smarty->assign('date', $date);

//--Get Taxonomies

//--Post Index Page

get_header();

$smarty->display('pages/single-[[post-type]].tpl');

get_footer();
