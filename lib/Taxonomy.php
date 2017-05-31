<?php

class CM_CLI_Taxonomy{
	/**
	 * Register a Taxonomy in your C+M Smarty theme
	 *
	 * ## OPTIONS
	 *
     * <slug>
	 * : The taxonomy slug
	 *
	 * [--label=<label>]
	 * : The taxonomy label
	 * ---
	 * default: "Tag"
	 *
	 * [--textdomain=<textdomain>]
	 * : The textdomain of the post type
	 * ---
	 * default: null
	 *
	 * [--post-types=<post-types>]
	 * : The taxnomy post type(s)
	 * ---
	 * default: "post"
     *
	 * [--hierarchical]
	 * : Whether or not the taxonomy is hierarchical
	 * ---
     *
	 * [--hierarchy]
	 * : Alias of hierarchical
	 * ---
     *
	 * [--hierarch]
	 * : Alias of hierarchical
	 * ---
     *
	 * [--hier]
	 * : Alias of hierarchical
	 * ---
	 *
	 * ## EXAMPLES
	 *
	 *     wp cm create-taxonomy event_tag --label="Tag" --post_types="event"
	 *
	 * @when before_wp_load
	 */
	public function __invoke($args, $assoc_args){

		global $chunker;

        //register_global_chunk_keys
		global $taxonomy_slug;
        global $taxonomy_label;
        global $theme_title;
        global $post_types;
		$taxonomy_slug = $args[0];

        $post_types = $assoc_args['post-types'];
        $post_types_array = explode(',', $post_types);
        $taxonomy_label = $assoc_args['label'];

        $this->register_chunkables();

		$command_response = WP_CLI::runcommand(
			'theme list --format=json',
			array('return' => 'all')
		);

		$themes = json_decode($command_response->stdout);

		if(!empty($themes)){
            foreach($themes as $theme){
                if($theme->status === 'active'){
                    // do stuff here
                    $command_response = WP_CLI::runcommand(
        				'theme get ' . $theme->name . ' --fields=template_dir,title --format=json',
        				array('return' => 'all')
        			);
                    $theme_fields = json_decode($command_response->stdout);
                    if($theme_fields->template_dir){
                        $theme_title = $theme_fields->title;

                        $scaffold_command = "scaffold taxonomy $taxonomy_slug --label=\"$taxonomy_label\" --post_types=\"$post_types\" --theme --force";
                        if(isset($assoc_args['textdomain'])){
                            $scaffold_command .= " --textdomain=" . $assoc_args['textdomain'];
                        }

                        WP_CLI::runcommand($scaffold_command);

                        $destination = $theme_fields->template_dir;
                        //chunk existing files
                        $chunk_files = array(
							'assets/js/app.js',
                            'functions.php',
							'includes/ajax-requests.php',
                            'includes/helpers.php',
                            'includes/translations.php',
                            'templates/partials/sections/post-index.tpl',
                            'templates/partials/post-index.tpl',
                        );
                        foreach($post_types_array as $post_type){
                            $chunk_files[] = "page-$post_type.php";
                        }
                        foreach($chunk_files as $chunk_file){
                            $file = "$destination/$chunk_file";
                            $content = $chunker->chunk($file, file_get_contents($file));
                            file_put_contents($file, $content);
                        }
                    }

                    if(
                        isset($assoc_args['hierarchical']) ||
                        isset($assoc_args['hierarchy']) ||
                        isset($assoc_args['hierarch']) ||
                        isset($assoc_args['hier'])
                    ){
                        $content = file_get_contents("$destination/taxonomies/$taxonomy_slug.php");
                        $content = str_replace(
                            "'hierarchical'      => false,",
                            "'hierarchical'      => true,",
                            $content
                        );
                        file_put_contents("$destination/taxonomies/$taxonomy_slug.php", $content);
                    }


                    WP_CLI::success( "Taxonomy $taxonomy_label was created for post types $post_types..." );
    				WP_CLI::success( CM_CLI_Helper::reward() );
                }
            }

		}
	}

	public function register_chunkables(){
		global $chunker;
        global $post_types;
        $post_types_array = explode(',', $post_types);

		$chunker->register_chunkable('ajax-requests.php', '//--Taxonomy Load Posts Query', 'chunks/includes/ajax-requests/_taxonomy_load_posts_query');

		$chunker->register_chunkable('app.js', '//--Taxonomy Ajax Property', 'chunks/assets/js/app/_taxonomy_ajax_property');
		$chunker->register_chunkable('app.js', '//--Taxonomy Filter Trigger', 'chunks/assets/js/app/_taxonomy_filter_trigger');

        $chunker->register_chunkable('functions.php', '//--Register Taxonomies', 'chunks/functions/_register_taxonomies');

        foreach($post_types_array as $post_type){
            $chunker->register_chunkable('helpers.php', '//--Post Assign ' . $post_type . ' Taxonomy', 'chunks/includes/helpers/_post_assign_taxonomy');
			$chunker->register_chunkable('helpers.php', '//--Taxonomy Filter Selected', 'chunks/includes/helpers/_taxonomy_filter_selected');

            $chunker->register_chunkable('page-' . $post_type . '.php', '//--Assign Taxonomy Filters', 'chunks/page-post/_assign_taxonomy_filters');
    		$chunker->register_chunkable('page-' . $post_type . '.php', '//--Taxonomy Query', 'chunks/page-post/_taxonomy_query');
        }

		$chunker->register_chunkable('post-index.tpl', '{* //Filter Taxonomies *}', 'chunks/templates/partials/sections/post-index/_filter_taxonomies');
		$chunker->register_chunkable('post-index.tpl', '{* //Show Taxonomies *}', 'chunks/templates/partials/post-index/_show_taxonomies');

        $chunker->register_chunkable('translations.php', '//--Taxonomy Filter Translations', 'chunks/includes/translations/_taxonomy_filter_translations');

	}

}
WP_CLI::add_command( 'cm create-taxonomy', 'CM_CLI_Taxonomy');
