<?php

/**
 * Sets up your theme for Smarty for WordPress
 *
 * ## OPTIONS
 *
 * <theme-name>
 * : The theme to set up.
 *
 * ## EXAMPLES
 *
 *     wp cm theme twentyseventeen
 *
 * @when before_wp_load
 */

class CM_CLI_Theme{
	public function __invoke($args){
		$theme_name = $args[0];

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
	}
}
