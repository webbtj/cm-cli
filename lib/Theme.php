<?php


class CM_CLI_Theme{
	/**
	 * Sets up your theme for Smarty for WordPress
	 *
	 * ## OPTIONS
	 *
	 * <directory-name>
	 * : The theme to set up.
	 *
	 * [--theme-title=<theme-title>]
	 * : The title of the theme
	 * ---
	 * default: C+M Smarty Scaffold
	 *
	 * [--theme-uri=<theme-uri>]
	 * : The uri of the theme
	 * ---
	 * default: http://sitebynorex.com
	 *
	 * [--author-name=<author-name>]
	 * : The name of the Author
	 * ---
	 * default: C+M
	 *
	 * [--author-uri=<author-uri>]
	 * : The author URI
	 * ---
	 * default: http://sitebynorex.com
	 *
	 * [--theme-description=<theme-description>]
	 * : The theme description
	 * ---
	 * default: Smarty Scaffolded Theme by C+M
	 *
	 * [--theme-version=<theme-version>]
	 * : The version of the theme
	 * ---
	 * default: 1.0
	 *
	 * [--activate]
	 * : Whether or not to activate the theme
	 * ---
	 * default: false
	 *
	 * ## EXAMPLES
	 *
	 *     wp cm theme twentyseventeen
	 *
	 * @when before_wp_load
	 */
	public function __invoke($args, $assoc_args){

		global $template_vars;
		$template_vars = $assoc_args;

		$theme_name = $args[0];

		$this->register_global_chunk_keys();
		$this->register_chunkables();

		$command_response = WP_CLI::runcommand(
			'theme list --format=json',
			array('return' => 'all')
		);

		$themes = json_decode($command_response->stdout);
		if(!empty($themes)){
			$theme = $themes[0];
			$command_response = WP_CLI::runcommand(
				'theme get ' . $theme->name . ' --fields=template_dir --format=json',
				array('return' => 'all')
			);
			$theme_fields = json_decode($command_response->stdout);
			if($theme_fields->template_dir){
				$destination = dirname($theme_fields->template_dir) . '/' . $theme_name;
				if(!file_exists($destination)){
					mkdir($destination);
				}
				CM_CLI_Helper::directory_builder(dirname(dirname(__FILE__)) . '/theme_files', $destination);
				WP_CLI::success( "Smarty theme $template_name was created..." );
				WP_CLI::success( CM_CLI_Helper::reward() );
			}
		}

		if(isset($assoc_args['activate']) && $assoc_args['activate']){
			WP_CLI::runcommand('theme activate ' . $theme_name);
		}
	}

	public function register_global_chunk_keys(){
		global $taxonomy_slug;
        global $post_type;
		global $post_name;
        global $index_page;
		global $menu_slug;
		global $menu_name;

		$taxonomy_slug = 'post_tag';
		$post_type = 'post';
		$post_name = 'Post';
		$index_page = 'page-post';
		$menu_slug = 'main_menu';
		$menu_name = 'Main Menu';
	}

	public function register_chunkables(){
		global $chunker;
		global $post_type;
		$post_type = 'post';

		//FROM POST
		$chunker->register_chunkable('functions.php', '//--Register Post Types', 'chunks/functions/_register_post_type');

		$chunker->register_chunkable('helpers.php', '//--Format Post', 'chunks/includes/helpers/_format_post');

		$chunker->register_chunkable('page-post.php', '//--Assign Post Type', 'chunks/page-post/_assign_post_type');
		$chunker->register_chunkable('page-post.php', '//--Get Post Args', 'chunks/page-post/_get_post_args');
		$chunker->register_chunkable('page-post.php', '//--Get Post Years', 'chunks/page-post/_get_post_years');

		$chunker->register_chunkable('single.php', '//--Get Taxonomies', 'chunks/single/_get_taxonomies');
		$chunker->register_chunkable('single.php', '//--Post Index Page', 'chunks/single/_post_index_page');

		$chunker->register_chunkable('social.php', '//--Assign Social', 'chunks/includes/social/_assign_social');

		//FROM TAXONOMY
		$chunker->register_chunkable('functions.php', '//--Register Taxonomies', 'chunks/functions/_register_taxonomies');

		$chunker->register_chunkable('helpers.php', '//--Post Assign ' . $post_type . ' Taxonomy', 'chunks/includes/helpers/_post_assign_taxonomy');

		$chunker->register_chunkable('page-post.php', '//--Assign Taxonomy Filters', 'chunks/page-post/_assign_taxonomy_filters');
		$chunker->register_chunkable('page-post.php', '//--Taxonomy Query', 'chunks/page-post/_taxonomy_query');

		$chunker->register_chunkable('post-index.tpl', '{* //Filter Taxonomies *}', 'chunks/templates/partials/sections/post-index/_filter_taxonomies');
		$chunker->register_chunkable('post-index.tpl', '{* //Show Taxonomies *}', 'chunks/templates/partials/post-index/_show_taxonomies');

		//FROM MENU
		$chunker->register_chunkable('menus.php', '//--Assign Menus', 'chunks/includes/menus/_assign_menus');
		$chunker->register_chunkable('menus.php', '//--Load Menus', 'chunks/includes/menus/_load_menus');
		$chunker->register_chunkable('menus.php', '//--Register Menus', 'chunks/includes/menus/_register_menus');

	}

	public static function doc(){
		return array(
		    'shortdesc' => 'Scaffolds a Smarty Based theme',
		    'synopsis' => array(
		        array(
		            'type'     => 'positional',
		            'name'     => 'directory-name',
		            'optional' => false,
		            'multiple' => false,
		        ),
		        array(
		            'type'     => 'assoc',
		            'name'     => 'theme-title',
		            'optional' => true,
		            'default'  => 'C+M Smarty Scaffold',
		        ),
				array(
		            'type'     => 'assoc',
		            'name'     => 'theme-uri',
		            'optional' => true,
		            'default'  => 'http://sitebynorex.com',
		        ),
				array(
		            'type'     => 'assoc',
		            'name'     => 'author-name',
		            'optional' => true,
		            'default'  => 'C+M',
		        ),
				array(
		            'type'     => 'assoc',
		            'name'     => 'author-uri',
		            'optional' => true,
		            'default'  => 'http://sitebynorex.com',
		        ),
				array(
		            'type'     => 'assoc',
		            'name'     => 'theme-description',
		            'optional' => true,
		            'default'  => 'Smarty Scaffolded Theme by C+M',
		        ),
				array(
		            'type'     => 'assoc',
		            'name'     => 'theme-version',
		            'optional' => true,
		            'default'  => '1.0',
		        ),
				array(
		            'type'     => 'assoc',
		            'name'     => 'activate',
		            'optional' => true,
		            'default'  => false,
					// 'options'  => array(true, false)
		        ),
		    ),
		    'when' => 'after_wp_load',
		);
	}
}
WP_CLI::add_command( 'cm theme', 'CM_CLI_Theme');//, CM_CLI_Theme::doc() );
