<?php

function cm_assign_social(&$wp_smarty){
    $social = array(
        'title' => wp_title('|', false, 'right') . get_bloginfo('name', 'display'),
        'url' => get_permalink(),
    );

    switch($post->post_type){
        case 'page':
            $social['description'] = get_the_excerpt($post->ID);
            break;
        //--Assign Social
    }

    $wp_smarty->assign('social', $social);
}
