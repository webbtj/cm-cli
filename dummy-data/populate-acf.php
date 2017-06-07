<?php

class ACFPopulator{
    public static function populate($post_id, $key, $details, $return_only = false){
        switch ($details['type']) {
            case 'text':
                $value = ContentHelper::generate_text();
                break;
            case 'textarea':
                $value = strip_tags(ContentHelper::generate_paragraphs(1));
                break;
            case 'number':
                $min = max(1, $details['min']);
                $max = min(100, $details['max']);
                $max = $max ? $max : 100;
                $value = rand($min, $max);
                break;
            case 'email':
                $value = strtolower(ContentHelper::generate_text(1,1)) . '@' .
                    strtolower(ContentHelper::generate_text(1,1)) . '.com';
                break;
            case 'url':
                $value = 'http://' .
                    strtolower(ContentHelper::generate_text(1,1)) . '.com';
                break;
            case 'password':
                $value = ContentHelper::generate_text(1,1);
                break;
            case 'wysiwyg':
                $value = ContentHelper::generate_paragraphs();
                break;
            case 'oembed':
                $value = ContentHelper::oembed();
                break;
            case 'image':
                $value = ContentHelper::get_file($post_id);
                break;
            case 'file':
                $value = ContentHelper::get_file($post_id);
                break;
            case 'gallery': //needs work
                $value = ContentHelper::get_gallery($post_id, $details);
                break;

            case 'select':
                $choices = array_keys($details['choices']);
                if($details['multiple']){
                    $value = array();
                    $num_choices = rand(1, count($choices)-1);
                    for($i = 0; $i < $num_choices; $i++){
                        $k = rand(0, count($choices)-1);
                        $value[] = $choices[$k];
                        unset($choices[$k]);
                        $choices = array_values($choices);
                    }
                    $value = serialize($value);
                }else{
                    $k = rand(0, count($choices)-1);
                    $value = $choices[$k];
                }
                break;

            case 'checkbox':
                $choices = array_keys($details['choices']);
                $value = array();
                $num_choices = rand(1, count($choices)-1);
                for($i = 0; $i < $num_choices; $i++){
                    $k = rand(0, count($choices)-1);
                    $value[] = $choices[$k];
                    unset($choices[$k]);
                    $choices = array_values($choices);
                }
                $value = serialize($value);
                break;

            case 'radio':
                $choices = array_keys($details['choices']);
                $k = rand(0, count($choices)-1);
                $value = $choices[$k];
                break;

            case 'true_false':
                $value = rand(0,1);
                break;
            case 'post_object':
                $value = ContentHelper::get_posts($details);
                break;
            case 'page_link':
                $value = ContentHelper::get_posts($details);
                break;
            case 'relationship':
                $value = ContentHelper::get_posts($details);
                break;
            case 'taxonomy':
                $value = ContentHelper::get_terms($details['taxonomy'], $details['field_type'] == 'checkbox');
                break;
            case 'user':
                $value = ContentHelper::get_users($details['role'], $details['multiple']);
                break;
            case 'google_map':
                $value = ContentHelper::geo_location();
                break;
            case 'date_picker':
                $value =
                    rand( (int) date('Y') -2, (int) date('Y') + 3) .
                    str_pad(rand(1, 12), 2, '0', STR_PAD_LEFT) .
                    str_pad(rand(1, 28), 2, '0', STR_PAD_LEFT);
                break;
            case 'date_time_picker':
                $value =
                    rand( (int) date('Y') -2, (int) date('Y') + 3) . '-' .
                    str_pad(rand(1, 12), 2, '0', STR_PAD_LEFT) . '-' .
                    str_pad(rand(1, 28), 2, '0', STR_PAD_LEFT) . ' ' .
                    str_pad(rand(0, 23), 2, '0', STR_PAD_LEFT) . ':' .
                    str_pad(rand(0, 59), 2, '0', STR_PAD_LEFT) . ':' .
                    str_pad(rand(0, 59), 2, '0', STR_PAD_LEFT);
                break;
            case 'time_picker':
                $value =
                    str_pad(rand(0, 23), 2, '0', STR_PAD_LEFT) . ':' .
                    str_pad(rand(0, 59), 2, '0', STR_PAD_LEFT) . ':' .
                    str_pad(rand(0, 59), 2, '0', STR_PAD_LEFT);
                break;
            case 'color_picker':
                $value = '#' . dechex(rand(0, 16777215));
                break;
            case 'repeater':
                $value = ContentHelper::fill_repeater($details, $post_id);
                break;
        }
        if($value && !$return_only){
            acf_update_value($value, $post_id, $details);
        }elseif($value && $return_only){
            return $value;
        }
    }
}
