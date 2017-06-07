<?php
class CM_CLI_DummyContent{
	/**
	 * Setup some ideal environment settings, such as gitignore, htaccess, disable xmlrpc, delete default themes.
	 *
	 * ## OPTIONS
	 *
     * [--post-types=<post-types>]
	 * : Which post-types to create content for, if none, use all
	 * ---
	 * default: ""
     *
     * [--quantity=<quantity>]
	 * : How many (of each post type) to create
	 * ---
	 * default: 10
     *
     * [--hour-change=<hour-change>]
	 * : How many hours apart to set each post (on a per-post-type basis). First post is created now, each subsequent post is created X hours earlier
	 * ---
	 * default: 6
     *
     * [--day-change=<day-change>]
	 * : How many days apart to set each post (on a per-post-type basis). First post is created now, each subsequent post is created X days earlier
	 * ---
	 * default: ""
     *
     * [--month-change=<month-change>]
	 * : How many months apart to set each post (on a per-post-type basis). First post is created now, each subsequent post is created X months earlier
	 * ---
	 * default: ""
     *
     * [--year-change=<year-change>]
	 * : How many years apart to set each post (on a per-post-type basis). First post is created now, each subsequent post is created X years earlier
	 * ---
	 * default: ""
     *
	 * [--taxonomies]
	 * : Whether or not to create any new taxonomies, use --no-taxonomies to prevent from creating new taxonomies
	 *
	 *
	 * ## EXAMPLES
	 *
	 *     wp cm dummy
	 *
	 * @when after_wp_load
	 */
	public function __invoke($args, $assoc_args){
        $create_terms = $this->get_create_terms($assoc_args);
        $post_types = $this->get_post_types($assoc_args);
        $quantity = $assoc_args['quantity'];
		$this->get_taxonomies();
		$this->new_post_ids = array();
        foreach($post_types as $post_type){
			$post_date = new DateTime;
			$date_diff_string = $this->get_date_diff_string($assoc_args);
            for($i = 0; $i < $quantity; $i++){
				if($i > 0)
					$post_date->modify($date_diff_string);
                $this->new_post_ids[] = $this->create_post($post_type, $create_terms, $post_date->format('Y-m-d H:i:s'));
            }
        }

		if(!empty($this->new_post_ids)){
			foreach($this->new_post_ids as $post_id){
				$this->populate_acf_fields($post_id);
			}
		}

		WP_CLI::success( "Dummy content created" );
	}

    public function create_post($post_type, $create_terms, $post_date){
		$body = ContentHelper::generate_paragraphs();
		$title = ContentHelper::generate_text();
		$post_id = wp_insert_post(array(
			'post_title' => $title,
			'post_type' => $post_type,
			'post_content' => $body,
			'post_status' => 'publish',
			'post_date' => $post_date
		));
		$taxonomy_terms = $this->get_terms($post_type, $create_terms);
		$term_ids = array();
		foreach($taxonomy_terms as $taxonomy => $terms){
			foreach($terms as $term){
				$term_ids[] = (int) $term->term_id;
			}
			wp_set_object_terms($post_id, $term_ids, $taxonomy);
			$term_ids = array();
		}
		return $post_id;

    }

    public function get_create_terms($assoc_args){
        $create_terms = true;
        if(isset($assoc_args['taxonomies']) && !$assoc_args['taxonomies'])
            $create_terms = false;
        return $create_terms;
    }

    public function get_post_types($assoc_args){
        $blocked_post_types = array('attachment', 'revision', 'nav_menu_item', 'custom_css', 'customize_changeset', 'acf-field-group', 'acf-field');
        if($assoc_args['post-types']){
            $post_types = explode(",", $assoc_args['post-types']);
        }else{
            $post_types = get_post_types();
        }
        foreach($post_types as $k => $v){
            if(in_array($v, $blocked_post_types)){
                unset($post_types[$k]);
            }
        }
        return $post_types;
    }

	public function get_taxonomies(){
		$taxonomies = get_taxonomies(array(), 'object');
		$this->taxonomies = array();
		$blocked_taxonomies = array('post_format', 'nav_menu', 'link_category');
		foreach($taxonomies as $taxonomy){
			if(!in_array($taxonomy->name, $blocked_taxonomies)){
				if(!empty($taxonomy->object_type)){
					foreach($taxonomy->object_type as $object_type){
						if(!isset($this->taxonomies[$object_type])){
							$this->taxonomies[$object_type] = array();
						}
						if(!isset($this->taxonomies[$object_type][$taxonomy->name])){
							$this->taxonomies[$object_type][$taxonomy->name] =
								get_terms(array('taxonomy' => $taxonomy->name, 'hide_empty' => false));
						}
					}
				}
			}
		}
	}

	public function get_terms($post_type, $create_terms){
		$output = array();
		if(!empty($this->taxonomies[$post_type])){
			foreach($this->taxonomies[$post_type] as $taxonomy => $terms){
				$num_terms = rand(1,3);
				$i = 0;
				while($i < $num_terms){

					if(!isset($output[$taxonomy])){
						$output[$taxonomy] = array();
					}

					$create_new = false;
					if($create_terms && (range(1,10) <= 4 || empty($terms)) ){
						$create_new = true;
					}

					if($create_new){
						$term_name = ContentHelper::generate_text(1,3);
						while(term_exists($term_name, $taxonomy)){
							$term_name = ContentHelper::generate_text(1,3);
						}
						$insert_term = wp_insert_term($term_name, $taxonomy);
						$term_object = get_term($insert_term['term_id'], $taxonomy);
						$output[$taxonomy][] = $term_object;
						$this->taxonomies[$post_type][$taxonomy][] = $term_object;
					}else{
						$index = rand(0, count($terms) - 1);
						$output[$taxonomy][] = $terms[$index];
						unset($terms[$index]);
						$terms = array_values($terms);
					}
					$i++;
				}
			}
		}
		return $output;
	}

	public function get_date_diff_string($assoc_args){
		$units = array('year', 'month', 'day', 'hour');
		foreach($units as $unit){
			if($assoc_args[$unit . '-change']){
				return '-' . $assoc_args[$unit . '-change'] . ' ' . $unit . 's';
			}
		}
	}

	public function populate_acf_fields($post_id){

		$field_groups = $this->get_post_field_groups($post_id);
		if($field_groups){
			foreach($field_groups as $field_group){
				if(!empty($field_group['fields'])){
					foreach($field_group['fields'] as $field){
						$a = ACFPopulator::populate($post_id, $field['name'], $field);
					}
				}
			}
		}
	}

	function load_acf_field_groups(){
		if(!function_exists('acf_get_field_groups')){
			return false;
		}
		if(!isset($this->field_groups)){
			$this->field_groups = acf_get_field_groups();
			if(!empty($this->field_groups)){
				foreach($this->field_groups as &$field_group){
					$field_group['fields'] = acf_get_fields_by_id($field_group['ID']);
				}
			}
		}
		return true;
	}

	function get_post_field_groups($post_id){
		if($this->load_acf_field_groups() && !empty($this->field_groups)){
			$field_groups = array();
			foreach($this->field_groups as $field_group){
				$visible = acf_get_field_group_visibility(
					$field_group, array('post_id' => $post_id)
				);
				if($visible){
					$field_groups[] = $field_group;
				}
			}
			if(empty($field_groups))
				return false;
			return $field_groups;
		}
	}

}
require_once(dirname(dirname(__FILE__)) . '/dummy-data/helpers.php');
require_once(dirname(dirname(__FILE__)) . '/dummy-data/paragraph.php');
require_once(dirname(dirname(__FILE__)) . '/dummy-data/text.php');
require_once(dirname(dirname(__FILE__)) . '/dummy-data/populate-acf.php');
WP_CLI::add_command( 'cm dummy', 'CM_CLI_DummyContent');
