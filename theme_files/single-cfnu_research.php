<?php

global $post;

$smarty = wp_smarty();

$smarty->assign('title', $post->post_title);

$content = apply_filters('the_content', $post->post_content);

$smarty->assign('content', $content);

$date = get_post_date();
$smarty->assign('date', $date);

$terms = get_the_terms($post->ID, 'research_tag');
$smarty->assign('tags', $terms);

$index_page = get_page_by_template('page-cfnu_research.php');
if($index_page && isset($index_page->ID)){
    $index_page_url = get_permalink($index_page->ID);
    $smarty->assign('index_page_url', $index_page_url);
}

$smarty->assign('cta', get_cta());
$smarty->assign('cta_top', true);

$header_image = get_field('header_image');
if(!$header_image){
    $header_image = get_field('research_header', 'options');
}
$smarty->assign('header_image', $header_image);

//featured image
$featured_image_type = get_field('featured_image_type');
if($featured_image_type == 'image'){
    $featured_image = get_field('featured_image');
    $smarty->assign('featured_image', $featured_image);
}elseif($featured_image_type == 'video'){
    $featured_video = get_field('featured_video');
    $featured_video = parse_youtube_url_embed($featured_video);
    $smarty->assign('featured_video', $featured_video);
}

get_header();

$smarty->display('pages/single-cfnu_research.tpl');

get_footer();
