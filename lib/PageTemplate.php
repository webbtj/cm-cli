<?php

class CM_CLI_PageTemplate{
	/**
	 * Add a custom page template to your theme
	 *
	 * ## OPTIONS
	 *
     * <slug>
	 * : The machine name of the page template
	 *
	 * [--label=<label>]
	 * : The label of the page template
	 * ---
	 * default: "Custom Page Template"
	 *
	 *
	 * ## EXAMPLES
	 *
	 *     wp cm create-template about --label="About Template"
	 *
	 * @when before_wp_load
	 */
	public function __invoke($args, $assoc_args){

		global $chunker;

		$name = $args[0];
		$label = $assoc_args['label'];

        global $custom_page_template_name;
        global $custom_page_template_label;

        $custom_page_template_name = $name;
        $custom_page_template_label = $label;

		$command_response = WP_CLI::runcommand(
			'theme list --format=json',
			array('return' => 'all')
		);

        if(CM_CLI_Helper::active_theme_dir()){
            $destination = CM_CLI_Helper::active_theme_dir();
            $source = dirname(dirname(__FILE__)) . '/custom-page-template';
            print_r([$name, $label, $source, $destination]);
            CM_CLI_Helper::copy("$source/page--custom.php", "$destination/page-$name.php");
            CM_CLI_Helper::copy("$source/page--custom.tpl", "$destination/templates/pages/page-$name.tpl");

        }
	}

}
WP_CLI::add_command( 'cm create-template', 'CM_CLI_PageTemplate');
