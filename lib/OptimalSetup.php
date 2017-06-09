<?php
class CM_CLI_OptimalSetup{
	/**
	 * Setup some ideal environment settings, such as gitignore, htaccess, disable xmlrpc, delete default themes.
	 *
	 * ## OPTIONS
	 *
	 * [--skip-gitignore]
	 * : Don't bother with gitignore file
     *
	 * [--skip-htaccess]
	 * : Don't both with htaccess
	 *
	 * [--skip-default-themes]
	 * : Don't delete default WP themes
     *
	 * [--keep-xmlrpc]
	 * : Don't disable XMLRPC (XMLRPC gets disabled because it is rarely used and often the source of security issues)
	 *
	 *
	 * ## EXAMPLES
	 *
	 *     wp cm optimal-setup
	 *
	 * @when before_wp_load
	 */
	public function __invoke($args, $assoc_args){

        $messages = array();
        $source = dirname(dirname(__FILE__));
        $destination = ABSPATH;

		if(chmod("$destination/wp-content/uploads", 0777)){
			$messages[] = 'uploads directory made writable';
		}

        if(!isset($assoc_args['skip-gitignore'])){
            CM_CLI_Helper::copy("$source/optimal-setup/gitignore", "$destination/.gitignore");
			CM_CLI_Helper::copy("$source/optimal-setup/wp-content/uploads/gitignore", "$destination/wp-content/uploads/.gitignore");
            $messages[] = '.gitignore files copied';
        }

        if(!isset($assoc_args['skip-htaccess'])){
            CM_CLI_Helper::copy("$source/optimal-setup/htaccess", "$destination/.htaccess");
            $messages[] = '.htaccess copied';
        }

		if(!isset($assoc_args['skip-default-themes'])){
            $current_theme = CM_CLI_Helper::active_theme_dir();
			$default_themes = array('twentyten', 'twentyeleven', 'twentytwelve',
			'twentythirteen', 'twentyfourteen', 'twentyfifteen', 'twentysixteen',
			'twentyseventeen', 'twentyeighteen', 'twentynineteen', 'twentytwenty');
			$theme_dir = dirname($current_theme);
			$current_theme = basename($current_theme);
			foreach($default_themes as $default_theme){
				if($default_theme != $current_theme){
					if(file_exists("$theme_dir/$default_theme")){
						CM_CLI_Helper::delete_directory("$theme_dir/$default_theme");
						$messages[] = "Default theme '$default_theme' deleted";
					}
				}
			}
        }

        if(!isset($assoc_args['keep-xmlrpc'])){
            // if(chmod("$destination/xmlrpc.php", 0000)){ // changing this to delete instead of chmod because git
			if(unlink("$destination/xmlrpc.php")){
                $messages[] = 'xmlrpc deleted';
            }else{
                WP_CLI::error( "Could not delete xmlrpc.php. You could manually delete it or chmod it to 000." );
            }
        }

        WP_CLI::runcommand("rewrite structure '/%postname%/'");
        $messages[] = "Rewrite structure set to 'Post name'";

        if(!empty($messages)){
            WP_CLI::success( "The following operations were completed: " . implode(', ', $messages) );
        }
	}

}
WP_CLI::add_command( 'cm optimal-setup', 'CM_CLI_OptimalSetup');
