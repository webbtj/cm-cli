<?php
/*
 * Template Name: Media Page
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

$photo_gallery_title = get_field('photo_gallery_title');
$smarty->assign('photo_gallery_title', $photo_gallery_title);
$press_kit_title = get_field('press_kit_title');
$smarty->assign('press_kit_title', $press_kit_title);

$photo_gallery = get_field('photo_gallery');
$smarty->assign('photo_gallery', $photo_gallery);

$press_kit_items = get_field('press_kit_items');
foreach($press_kit_items as &$press_kit_item){
    $press_kit_item = get_cta('call_to_action_', $press_kit_item);
}
$smarty->assign('press_kit_items', $press_kit_items);

get_header();

$smarty->display('pages/page-media.tpl');

get_footer();
