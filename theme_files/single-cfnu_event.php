<?php

global $post;

$smarty = wp_smarty();

$smarty->assign('title', $post->post_title);

$content = apply_filters('the_content', $post->post_content);

$smarty->assign('content', $content);

$pull_quote = get_field('pull_quote');
$smarty->assign('pull_quote', $pull_quote);

$smarty->assign('cta', get_cta());

$date = get_field('date');
$smarty->assign('date', $date);

$header_image = get_field('header_image');
if(!$header_image){
    $header_image = get_field('event_header', 'options');
}
$smarty->assign('header_image', $header_image);

$terms = get_the_terms($post->ID, 'event_tag');
$smarty->assign('tags', $terms);

$index_page = get_page_by_template('page-cfnu_event.php');
if($index_page && isset($index_page->ID)){
    $index_page_url = get_permalink($index_page->ID);
    $smarty->assign('index_page_url', $index_page_url);
}

get_header();

$smarty->display('pages/single.tpl');

get_footer();
