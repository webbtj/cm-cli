<?php

// Add ACF Options Page
if(function_exists('acf_add_options_page')) {
    acf_add_options_page();
}

function get_page_by_template($template_name, $suppress_filters = false){
    $args = array(
        'post_type' => 'page',
        'meta_key' => '_wp_page_template',
        'meta_value' => $template_name,
        'suppress_filters' => $suppress_filters,
    );
    global $post;
    $old_post = $post;
    $template_query = new WP_Query($args);
    $template_post = null;
    if($template_query->have_posts()){
        while($template_query->have_posts()){
            $template_query->the_post();
            $template_post = $template_query->post;
        }
    }
    wp_reset_query();
    $post = $old_post;
    return $template_post;
}

function get_post_terms($term){
    $terms = get_terms($term);
    foreach($terms as &$t){
        $t->selected = false;
        //--Taxonomy Filter Selected
    }
    return $terms;
}

function get_post_date($post_id = null){
    if($post_id){
        $p = get_post($post_id);
    }else{
        global $post;
        $p = $post;
    }

    $format = 'F j, Y';
    if (function_exists('icl_translate'))
        $format = icl_translate('Formats', $format, $format);

    $time = strtotime($p->post_date);
    return cm_translate_date(date($format, $time));
}

function get_months(){
    return array(
        1 => 'January',
        2 => 'February',
        3 => 'March',
        4 => 'April',
        5 => 'May',
        6 => 'June',
        7 => 'July',
        8 => 'August',
        9 => 'September',
        10 => 'October',
        11 => 'November',
        12 => 'December',
    );
}

function get_years($post_type = 'post'){
    $args = array(
        'post_type' => $post_type,
        'posts_per_page' => 1,
        'order' => 'ASC'
    );
    $current_year = (int) date('Y');
    $posts = load_posts($args);
    if(count($posts) == 1){
        $p = $posts[0];
        $date = strtotime($p->post_date);
        $year = date('Y', $date);
        $years = array();
        for($i = $current_year; $i >= $year; $i--){
            $years[$i] = $i;
        }
        return $years;
    }
    return array(
        $current_year => $current_year
    );
}

function get_cta($cta_key = 'call_to_action_', $fields = null, $post_id = null){
    if(!$post_id){
        global $post;
        $post_id = $post->ID;
    }

    if(!$fields){
        $fields = get_fields($post_id);
    }

    $type = $fields[$cta_key . 'type'];
    $text = $fields[$cta_key . 'text'];
    $internal_page = $fields[$cta_key . 'internal_page'];
    $external_url = $fields[$cta_key . 'external_url'];
    $file = $fields[$cta_key . 'file'];

    switch ($type) {
        case 'internal':
            return array(
                'text' => $text,
                'link' => $internal_page,
                'target' => '_self',
            );
            break;
        case 'external':
            return array(
                'text' => $text,
                'link' => $external_url,
                'target' => '_blank',
            );
            break;
        case 'file':
            return array(
                'text' => $text,
                'link' => $file,
                'target' => '_blank',
            );
            break;
        default:
            return array();
            break;
    }
}

function parse_youtube_url($url){
    preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $url, $matches);
    if(!empty($matches) && $matches){
        return 'https://www.youtube.com/embed/' . $matches[0];
    }
}

function parse_youtube_url_thumbnail($url){
    preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $url, $matches);
    if(!empty($matches) && $matches){
        return 'http://img.youtube.com/vi/' . $matches[0] . '/0.jpg';
    }
}

function parse_youtube_url_href($url){
    preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $url, $matches);
    if(!empty($matches) && $matches){
        return 'https://www.youtube.com/watch?v=' . $matches[0];
    }
}

function parse_youtube_url_embed($url){
    preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $url, $matches);
    if(!empty($matches) && $matches){
        return '//www.youtube.com/embed/' . $matches[0] . '?rel=0';
    }
}

function format_post_for_display(&$p){
    $p->url = get_permalink($p->ID);
    $p->fields = get_acf_fields($p->ID);
    switch ($p->post_type) {
        //--Format Post
    }
}

function get_acf_fields($p = null){
    if(!function_exists('get_fields'))
        return false;
    if(!$p){
        global $post;
        $p = $post;
    }
    $fields = get_fields($p->ID);
    $fields = apply_filters('cm/get_acf_fields', $fields);

    return $fields;
}

function pre($a){
    echo '<pre>';
    print_r($a);
    echo '</pre>';
}
