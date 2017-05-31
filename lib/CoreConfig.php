<?php
class CM_CLI_CoreConfig{
	/**
	 * Setup a WordPress site, create DB and user, create a local config file
	 *
	 * ## OPTIONS
     *
     * <master_user>
	 * : The master username, this is used to create the user and database
     *
     * <master_password>
	 * : The master password, this is used to create the user and database
	 *
	 * [--db-name=<db-name>]
	 * : The database name
	 * ---
	 * default: "wordpress"
     *
	 * [--db-user=<db-user>]
	 * : The database user name
	 * ---
	 * default: "root"
     *
	 * [--db-password=<db-password>]
	 * : The database user password, if left blank, a random one will be generated
	 * ---
	 * default: ""
	 *
	 * [--db-host=<db-host>]
	 * : The database host
	 * ---
	 * default: "localhost"
     *
	 * [--db-charset=<db-charset>]
	 * : The database charset
	 * ---
	 * default: "utf8"
     *
	 * [--db-collate=<db-collate>]
	 * : The database collate type
	 * ---
	 * default: ""
     *
	 * [--db-prefix=<db-prefix>]
	 * : The database prefix, if left blank a random one will be generated
	 * ---
	 * default: ""
	 *
	 * ## EXAMPLES
	 *
	 *     wp cm create-local-config --db-name="wordpress" --db-user="wordpress_user" --db-password="wordpress_pass"
	 *
	 * @when before_wp_load
	 */
	public function __invoke($args, $assoc_args){

        define('DB_HOST', $assoc_args['db-host']);
        define('DB_USER', $args[0]);
        define('DB_PASSWORD', $args[1]);

        if(!$assoc_args['db-password']){
            $assoc_args['db-password'] = $this->random_string(16);
        }
        if(!$assoc_args['db-prefix']){
            $assoc_args['db-prefix'] = $this->random_string(6, true, false, false, false) . '_';
        }

		//create db and user if necessary
        CM_CLI_Helper::create_db_user($assoc_args);

        $core_config_command = "core config --dbname=" . $assoc_args['db-name']
            . " --dbuser='" . $assoc_args['db-user'] . "'"
            . " --dbpass='" . $assoc_args['db-password'] . "'"
            . " --dbhost='" . $assoc_args['db-host'] . "'"
            . " --dbprefix='" . $assoc_args['db-prefix'] . "'"
            . " --dbcharset='" . $assoc_args['db-charset'] . "'"
            . " --dbcollate='" . $assoc_args['db-collate'] . "'";
        $cm_create_local_config_command = "cm create-local-config "
            . " --db-name='" . $assoc_args['db-name'] . "'"
            . " --db-user='" . $assoc_args['db-user'] . "'"
            . " --db-password='" . $assoc_args['db-password'] . "'"
            . " --db-host='" . $assoc_args['db-host'] . "'"
            . " --db-charset='" . $assoc_args['db-charset'] . "'"
            . " --db-collate='" . $assoc_args['db-collate'] . "'";

        WP_CLI::runcommand($core_config_command);
        WP_CLI::runcommand($cm_create_local_config_command);

        WP_CLI::success( "Everything setup and ready to install WordPress." );
	}

    public function random_string($length = 10, $lower = true, $upper = true, $num = true, $sym = true) {
        $characters = '';
        if($lower)
            $characters .= 'abcdefghijklmnopqrstuvwxyz';
        if($upper)
            $characters .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        if($num)
            $characters .= '0123456789';
        if($sym)
            $characters .= '!@#$%^&*_+-=[]{}';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

}
WP_CLI::add_command( 'cm core config', 'CM_CLI_CoreConfig');
