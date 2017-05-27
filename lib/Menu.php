<?php

class CM_CLI_Menu{
	/**
	 * Register a Menu in your C+M Smarty theme
	 *
	 * ## OPTIONS
	 *
     * <slug>
	 * : The menu slug
	 *
	 * <name>
	 * : The menu name
	 *
	 * ## EXAMPLES
	 *
	 *     wp cm create-menu main "Main Menu"
	 *
	 * @when before_wp_load
	 */
	public function __invoke($args, $assoc_args){

		global $chunker;

		global $menu_slug;
		global $menu_name;

		$menu_slug = $args[0];
		$menu_name = $args[1];

        $this->register_chunkables();

        if(CM_CLI_Helper::active_theme_dir()){
            $destination = CM_CLI_Helper::active_theme_dir();
            $file = "$destination/includes/menus.php";
            $content = $chunker->chunk($file, file_get_contents($file));
            file_put_contents($file, $content);

            WP_CLI::success( "Menu $menu_name was created..." );
            WP_CLI::success( CM_CLI_Helper::reward() );
        }

		// $command_response = WP_CLI::runcommand(
		// 	'theme list --format=json',
		// 	array('return' => 'all')
		// );
        //
		// $themes = json_decode($command_response->stdout);
        //
		// if(!empty($themes)){
        //     foreach($themes as $theme){
        //         if($theme->status === 'active'){
        //             // do stuff here
        //             $command_response = WP_CLI::runcommand(
        // 				'theme get ' . $theme->name . ' --fields=template_dir,title --format=json',
        // 				array('return' => 'all')
        // 			);
        //             $theme_fields = json_decode($command_response->stdout);
        //             if($theme_fields->template_dir){
        //
        //                 $destination = $theme_fields->template_dir;
        //                 $file = "$destination/includes/menus.php";
        //                 $content = $chunker->chunk($file, file_get_contents($file));
        //                 file_put_contents($file, $content);
        //             }
        //
        //
        //             WP_CLI::success( "Menu $menu_name was created..." );
    	// 			WP_CLI::success( CM_CLI_Helper::reward() );
        //         }
        //     }
        //
		// }
	}

	public function register_chunkables(){
		global $chunker;

		$chunker->register_chunkable('menus.php', '//--Assign Menus', 'chunks/includes/menus/_assign_menus');
		$chunker->register_chunkable('menus.php', '//--Load Menus', 'chunks/includes/menus/_load_menus');
		$chunker->register_chunkable('menus.php', '//--Register Menus', 'chunks/includes/menus/_register_menus');

	}

}
WP_CLI::add_command( 'cm create-menu', 'CM_CLI_Menu');
