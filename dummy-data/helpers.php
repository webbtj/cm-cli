<?php

class ContentHelper{
    public static function generate_text($min_words = 2, $max_words = 6, $type = 'lorem'){
		$text = array();
		$num_words = rand($min_words, $max_words);
		$i = 0;
		$dummy_text = dummy_text();
		while($i < $num_words){
			$text[] = $dummy_text[$type][rand(0, count($dummy_text[$type])-1 )];
			$i++;
		}
		$text = ucwords(implode(' ', $text));
		return $text;
	}

    public static function generate_paragraphs($max_paragraphs = 7, $min_sentences = 4, $max_sentences = 12, $type = 'lorem'){
		$content = '';
		$num_paragraphs = rand(1,$max_paragraphs);
		$i = 0;
		$dummy_paragraph = dummy_paragraph();
		while($i < $num_paragraphs){
			$paragraph = array();
			$num_sentences = rand($min_sentences, $max_sentences);
			$j = 0;
			while($j < $num_sentences){
				$content_sentences = $dummy_paragraph[$type];
				$paragraph[] = $content_sentences[rand(0, count($content_sentences)-1)];
				$j++;
			}
			$paragraph = implode(' ', $paragraph);
			$content .= "<p>$paragraph</p>\n";
			$i++;
		}
		return $content;
	}

    public static function oembed(){
        $links = array(
            'http://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'http://www.youtube.com/watch?v=epIT4-gF__M',
            'https://twitter.com/webbtj/status/870578941937016832',
            'https://twitter.com/webbtj/status/868029673019777024',
            'https://www.instagram.com/p/BOcyVsbgKas',
            'https://www.instagram.com/p/BT6Fxs5DOE7'
        );
        return $links[rand(0, count($links)-1)];
    }

    public static function get_posts($field){
        $post_types = $field['post_type'];
        $taxonomy = $field['taxonomy'];
        $multiple = $field['multiple'];

        $number_of_posts = 1;
        if($multiple){
            $min = $field['min'];
            $min = $min ? $min : 1;
            $max = $field['max'];
            $max = $max ? $max : 5;
            $number_of_posts = rand($min, $max);
        }

        if(empty($post_types))
            $post_types = get_post_types();

        $blocked_post_types = array('attachment', 'revision', 'nav_menu_item', 'custom_css', 'customize_changeset', 'acf-field-group', 'acf-field');

        foreach($post_types as $k => $v){
            if(in_array($v, $blocked_post_types)){
                unset($post_types[$k]);
            }
        }

        $args = array(
            'posts_per_page' => $number_of_posts,
            'post_status' => 'publish',
            'orderby' => 'rand',
            'post_type' => $post_types,
        );

        if(!empty($taxonomies)){
            $args['tax_query'] = array();
            foreach($taxonomies as $taxonomy_term_set){
                $parts = explode(':', $taxonomy_term_set);
                $taxonomy = $parts[0];
                $term = $parts[1];
                $args['tax_query'][] = array(
                    array(
                        'taxonomy' => $taxonomy,
                        'field'    => 'slug',
                        'terms'    => $term,
                    )
                );
            }
        }

        $posts = get_posts($args);
        if(count($posts) == 1){
            return $posts[0]->ID;
        }elseif(!empty($posts)){
            $ids = array();
            foreach($posts as $p){
                $ids[] = $p->ID;
            }
            return serialize($ids);
        }
    }

    public static function get_terms($taxonomy, $multiple){
        $term_ids = array();
        $terms = get_terms(array('taxonomy' => $taxonomy, 'hide_empty' => false));
        if($multiple && count($terms) > 1){
            $num_terms = rand(1, count($terms)-1);
            for($i = 0; $i < $num_terms; $i++){
                $k = rand(0, count($terms)-1);
                $term_ids[] = $terms[$k]->term_id;
                unset($terms[$k]);
                $terms = array_values($terms);
            }
            return $term_ids;
        }elseif(!empty($terms)){
            return $terms[0]->term_id;
        }
    }

    public static function get_users($role, $multiple){
        $user_ids = array();
        if(!empty($role))
            $users = get_users(array('role__in' => $role));
        else
            $users = get_users();

        if($multiple && count($users) > 1){
            $num_users = rand(2, count($users)-1);
            for($i = 0; $i < $num_users; $i++){
                $k = rand(0, count($users)-1);
                $user_ids[] = $users[$k]->ID;
                unset($users[$k]);
                $users = array_values($users);
            }
            return serialize($user_ids);
        }elseif(!empty($users)){
            return $users[0]->ID;
        }
    }

    public static function geo_location(){
        $locations = array(
            array(
                'address' => '2050 Gottingen St, Halifax, NS B3K 3A9, Canada',
                'lat' => '44.6512401',
                'lng' => '-63.58242899999999'
            ),
            array(
                'address' => '141 Kennedy Ave, Toronto, ON M6R 2L2, Canada',
                'lat' => '43.653226',
                'lng' => '-79.38318429999998'
            ),
            array(
                'address' => '57 Trafalgar Square, London WC2N 5DU, UK',
                'lat' => '51.5073509',
                'lng' => '-0.12775829999998223'
            ),
            array(
                'address' => 'Saint-Merri, 75004 Paris, France',
                'lat' => '48.856614',
                'lng' => '2.3522219000000177'
            ),
            array(
                'address' => '230 Broadway, New York, NY 10007, USA',
                'lat' => '40.7127837',
                'lng' => '-74.00594130000002'
            ),
            array(
                'address' => '1 Scott Cir NW, Washington, DC 20036, USA',
                'lat' => '38.9071923',
                'lng' => '-77.03687070000001'
            ),
            array(
                'address' => '6th Ave N & Church St SB, Nashville, TN 37243, USA',
                'lat' => '36.1626638',
                'lng' => '-86.78160159999999'
            ),
            array(
                'address' => '101 S Main St, Los Angeles, CA 90012, USA',
                'lat' => '34.0522342',
                'lng' => '-118.2436849'
            ),
            array(
                'address' => 'Downtown, Calgary, AB, Canada',
                'lat' => '51.0486151',
                'lng' => '-114.0708459'
            ),
            array(
                'address' => '100 Street & 102A Avenue, Edmonton, AB T5J 2Z2, Canada',
                'lat' => '53.544389',
                'lng' => '-113.49092669999999'
            ),
            array(
                'address' => '1100 Boulevard Robert-Bourassa, Montréal, QC H3B, Canada',
                'lat' => '45.5016889',
                'lng' => '-73.56725599999999'
            ),
            array(
                'address' => '100 Albert St, Ottawa, ON K1P 1A5, Canada',
                'lat' => '45.4215296',
                'lng' => '-75.69719309999999'
            ),
            array(
                'address' => '909 5th Ave, Seattle, WA 98164, USA',
                'lat' => '47.6062095',
                'lng' => '-122.3320708'
            ),
            array(
                'address' => '2118 Albert St, Regina, SK S4P, Canada',
                'lat' => '50.4452112',
                'lng' => '-104.61889429999997'
            ),
            array(
                'address' => '397 Queen St, Fredericton, NB E3B 1B5, Canada',
                'lat' => '45.9635895',
                'lng' => '-66.64311509999999'
            ),
            array(
                'address' => 'Portage & Main, Winnipeg, MB, Canada',
                'lat' => '49.895136',
                'lng' => '-97.13837439999998'
            ),
            array(
                'address' => '102 Livingstone St, St. John\'s, NL A1C 1V9, Canada',
                'lat' => '47.5615096',
                'lng' => '-52.712576799999965'
            ),
            array(
                'address' => '1502 Marilla St, Dallas, TX 75201, USA',
                'lat' => '32.7766642',
                'lng' => '-96.79698789999998'
            ),
            array(
                'address' => '1170 SE 12th Terrace, Miami, FL 33131, USA',
                'lat' => '25.7616798',
                'lng' => '-80.19179020000001'
            ),
            array(
                'address' => 'Parrsboro, NS, Canada',
                'lat' => '45.4056589',
                'lng' => '-64.3258874'
            )
        );
        $index = rand(0, count($locations)-1);
        return $locations[$index];
    }

    public static function fill_repeater($field, $post_id){
        $key = $field['key'];
        $min = $details['min'];
        $min = $min ? $min : 1;
        $max = $details['max'];
        $max = $max ? $max : 5;
        $num_entries = rand($min, $max);
        $rows = array();

        if(!empty($field['sub_fields'])){
            for($i = 0; $i < $num_entries; $i++){
                $values = array();
                foreach($field['sub_fields'] as $sub_field){
                    $value = ACFPopulator::populate($post_id, $sub_field['name'], $sub_field, true);
                    $values[$sub_field['name']] = $value;
                }
                $rows[] = $values;
            }
        }

        return $rows;
    }

    public static function download_file($post_id, $url, $randomize_name = false, $extension = null){
        if ( defined( 'DOING_AJAX' ) && DOING_AJAX ){
            return false;
        }else{
            $tmp = download_url($url, 0 );
            $file_array = array(
                'name' => urldecode(basename($url)),
                'tmp_name' => $tmp
            );
            if($randomize_name && $extension){
                $file_array['name'] = sanitize_title(ContentHelper::generate_text(2, 4)) . '.' . $extension;
            }
            if(is_wp_error($tmp)){
                @unlink($file_array['tmp_name']);
                return false;
            }
            $id = media_handle_sideload($file_array, $post_id, $desc);
            @unlink($file_array['tmp_name']);
            if(is_wp_error($id)){
                return false;
            }
            if($return_url)
                return wp_get_attachment_url($id);
            return $id;
        }
    }

    public static function get_file($post_id, $new_file_likelihood = 10){
        if(rand(1, 100) <= 100 - $new_file_likelihood){
            $args = array('post_type' => 'attachment', 'posts_per_page' => 1, 'orderby' => 'rand',);
            $posts = get_posts($args);
            if($posts){
                return $posts[0]->ID;
            }else{
                return ContentHelper::download_file($post_id, 'https://source.unsplash.com/random', true, 'png');
            }
        }else{
            return ContentHelper::download_file($post_id, 'https://source.unsplash.com/random', true, 'png');
        }
    }

    public static function get_gallery($post_id, $field){
        $min = $field['min'];
        $min = $min ? $min : 1;
        $max = $field['max'];
        $max = $max ? $max : 5;
        $num_items = rand($min, $max);
        $ids = array();
        for($i = 0; $i < $num_items; $i++){
            $ids[] = ContentHelper::get_file($post_id, 5);
        }
        return $ids;
    }
}
