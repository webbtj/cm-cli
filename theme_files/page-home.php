<?php
/*
 * Template Name: Homepage
 */

 global $post;

$smarty = wp_smarty();

$banners = get_field('banners');
foreach($banners as &$banner){
    $banner['banner_cta'] = get_cta('banner_', $banner);
}
$smarty->assign('banners', $banners);

$brand_statement_title = get_field('brand_statement_title');
$smarty->assign('brand_statement_title', $brand_statement_title);

$brand_statement_cta = get_field('brand_statement_cta');
$brand_statement_cta = get_cta('call_to_action_', $brand_statement_cta);
$smarty->assign('brand_statement_cta', $brand_statement_cta);

$featured_content_title = get_field('featured_content_title');
$smarty->assign('featured_content_title', $featured_content_title);

$featured_content_items = get_field('featured_content_items');
foreach($featured_content_items as &$featured_content_item){
    $featured_content_item['cta'] = get_cta('content_', $featured_content_item);
}
$smarty->assign('featured_content_items', $featured_content_items);

$speak_up_title = get_field('speak_up_title');
$smarty->assign('speak_up_title', $speak_up_title);

$speak_up_subtitle = get_field('speak_up_subtitle');
$smarty->assign('speak_up_subtitle', $speak_up_subtitle);

$speak_up_cta = get_cta('speak_up_call_to_action_');
$smarty->assign('speak_up_cta', $speak_up_cta);

$recent_news_title = get_field('recent_news_title');
$smarty->assign('recent_news_title', $recent_news_title);

$args = array(
    'post_type' => 'post',
    'paged' => 1,
    'posts_per_page' => 3
);

$posts = load_posts($args);
$smarty->assign('posts', $posts);

$news_page = get_page_by_template('page-post.php');
if($news_page && isset($news_page->ID)){
    $news_page_url = get_permalink($news_page->ID);
    $smarty->assign('news_page_url', $news_page_url);
}

$twitter_user = get_field('twitter_user');
$smarty->assign('twitter_user', $twitter_user);

$newsletter_title = get_field('newsletter_title');
$smarty->assign('newsletter_title', $newsletter_title);

$newsletter_description = get_field('newsletter_description');
$smarty->assign('newsletter_description', $newsletter_description);

$newsletter_form_id = get_field('newsletter_form');
$shortcode = '[gravityform id="' . $newsletter_form_id . '" title="false" description="false" ajax="true"]';
$newsletter_form = do_shortcode($shortcode);
$smarty->assign('newsletter_form', $newsletter_form);

get_header();

$smarty->display('pages/page-home.tpl');

get_footer();
