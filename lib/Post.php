<?php

class CM_CLI_Post{
	/**
	 * Register a Post in your C+M Smarty theme
	 *
	 * ## OPTIONS
	 *
     * <slug>
	 * : The post type slug
	 *
	 * [--label=<label>]
	 * : The post type label
	 * ---
	 * default: "Custom Post"
	 *
	 * [--textdomain=<textdomain>]
	 * : The textdomain of the post type
	 * ---
	 * default: null
	 *
	 * [--dashicon=<dashicon>]
	 * : The dashicon of the post type
	 * ---
	 * default: "admin-post"
	 *
	 * ## EXAMPLES
	 *
	 *     wp cm post event --label="Event"
	 *
	 * @when before_wp_load
	 */
	public function __invoke($args, $assoc_args){

		global $chunker;

        //register_global_chunk_keys
        global $post_type;
		global $post_name;
        global $index_page;

		$post_type = $args[0];
		$post_name = $assoc_args['label'];
		$index_page = 'page-' . $args[0];

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
                    $scaffold_command = "scaffold post-type $post_type --label=\"$post_name\" --theme --force --dashicon=" . $assoc_args['dashicon'];
                    if(isset($assoc_args['textdomain'])){
                        $scaffold_command .= " --textdomain=" . $assoc_args['textdomain'];
                    }

                    $command_response = WP_CLI::runcommand(
        				'theme get ' . $theme->name . ' --fields=template_dir --format=json',
        				array('return' => 'all')
        			);
                    $theme_fields = json_decode($command_response->stdout);
                    if($theme_fields->template_dir){
                        WP_CLI::runcommand($scaffold_command);

                        //copy new files (single-{post-type}.php, page-{post-type}.php, single-{post-type}.tpl, page-{post-type}.tpl)
                        $source = dirname(dirname(__FILE__)) . '/theme_files';
                        $destination = $theme_fields->template_dir;
                        CM_CLI_Helper::copy("$source/single.php", "$destination/single-$post_type.php");
                        CM_CLI_Helper::copy("$source/page-post.php", "$destination/page-$post_type.php");
                        CM_CLI_Helper::copy("$source/templates/pages/single-post.tpl", "$destination/templates/pages/single-$post_type.tpl");
                        CM_CLI_Helper::copy("$source/templates/pages/page-post.tpl", "$destination/templates/pages/page-$post_type.tpl");
                        //chunk existing files
                        $chunk_files = array('functions.php', 'includes/helpers.php', 'includes/social.php');
                        foreach($chunk_files as $chunk_file){
                            $file = "$destination/$chunk_file";
                            $content = $chunker->chunk($file, file_get_contents($file));
                            file_put_contents($file, $content);
                        }
                    }

                    WP_CLI::success( "Post type $post_type was created..." );
    				WP_CLI::success( CM_CLI_Helper::reward() );
                }
            }

		}
	}

	public function register_chunkables(){
		global $chunker;

		$chunker->register_chunkable('functions.php', '//--Register Post Types', 'chunks/functions/_register_post_type');

		$chunker->register_chunkable('helpers.php', '//--Format Post', 'chunks/includes/helpers/_format_post');

		$chunker->register_chunkable('page-post.php', '//--Assign Post Type', 'chunks/page-post/_assign_post_type');
		$chunker->register_chunkable('page-post.php', '//--Get Post Args', 'chunks/page-post/_get_post_args');
		$chunker->register_chunkable('page-post.php', '//--Get Post Years', 'chunks/page-post/_get_post_years');

		$chunker->register_chunkable('single.php', '//--Get Taxonomies', 'chunks/single/_get_taxonomies');
		$chunker->register_chunkable('single.php', '//--Post Index Page', 'chunks/single/_post_index_page');

		$chunker->register_chunkable('social.php', '//--Assign Social', 'chunks/includes/social/_assign_social');

	}

}
WP_CLI::add_command( 'cm create-post', 'CM_CLI_Post');
