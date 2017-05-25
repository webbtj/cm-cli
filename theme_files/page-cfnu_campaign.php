<?php
/*
 * Template Name: Advocacy (Campaign Index)
 */

global $post;
global $campaign_page_ID;
$campaign_page_ID = $post->ID;

$smarty = wp_smarty();

$smarty->assign('title', $post->post_title);

$content = apply_filters('the_content', $post->post_content);

$header_image = get_field('header_image');
if(!$header_image){
    $header_image = get_field('page_header', 'options');
}
$smarty->assign('header_image', $header_image);

$smarty->assign('content', $content);

$args = array(
    'post_type' => 'cfnu_campaign',
    'paged' => 1
);

$posts = load_posts($args);
$smarty->assign('posts', $posts);
// pre($posts);

$campaign_index_title = get_field('campaign_index_title');
$smarty->assign('campaign_index_title', $campaign_index_title);

// pre($posts);

$args['paged']++;
$has_more = (int) (bool) load_posts($args);
$smarty->assign('has_more', $has_more);

$smarty->assign('post_type', 'cfnu_campaign');

get_header();

$smarty->display('pages/page-cfnu_campaign.tpl');

get_footer();
