<?php
class CM_CLI_LocalConfig{
	/**
	 * Add a custom page template to your theme
	 *
	 * ## OPTIONS
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
	 * : The database user password
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
	 * ## EXAMPLES
	 *
	 *     wp cm create-local-config --db-name="wordpress" --db-user="wordpress_user" --db-password="wordpress_pass"
	 *
	 * @when before_wp_load
	 */
	public function __invoke($args, $assoc_args){

		global $chunker;

        $vars = array();
        foreach($assoc_args as $k => $v){
            $vars["[[$k]]"] = $v;
        }

		$eval_lines = array();

        //read the current wp-config.php file
        $file = fopen(ABSPATH . '/wp-config.php', 'r');
        $lines = array();
        $tab = 0;
        if($file){
            while(!feof($file)){
                $line = fgets($file);
                $lines[] = str_repeat("\t", $tab) . $line;
                if(strpos($line, '// ** MySQL settings ** //') !== false){
                    $lines[] = "if(file_exists('wp-config-local.php')){\n";
                    $lines[] = "\trequire_once('wp-config-local.php');\n";
                    $lines[] = "}else{\n";
                    $tab = 1;
                }
				if($tab === 1){
					$eval_lines[] = $line;
				}
                if(strpos($line, "define( 'DB_COLLATE'") !== false){
                    $lines[] = "}\n";
                    $tab = 0;
                }
            }
        }
        fclose($file);
        $lines = implode("", $lines);

		//get the original db config vars from wp-config
		$eval_lines = implode("", $eval_lines);
		eval($eval_lines);

		//create db and user if necessary
		$this->sql_commands($assoc_args);

		//write the wp-config file.
        file_put_contents(ABSPATH . '/wp-config.php', $lines);

		//create the wp-config-local.php file
        $source = dirname(dirname(__FILE__)) . '/wp-config-local/wp-config-local.php';
        $destination = ABSPATH . '/wp-config-local.php';
        CM_CLI_Helper::copy($source, $destination, $vars);
	}

	public function sql_commands($assoc_args){
		$database = null; $username = null; $password = ''; $connection_from = null;
		if($assoc_args['db-name'] !== DB_NAME)
			$database = $assoc_args['db-name'];
		if($assoc_args['db-user'] !== DB_USER)
			$username = $assoc_args['db-user'];
		if($assoc_args['db-password'] !== DB_PASSWORD)
			$password = $assoc_args['db-password'];
		if($assoc_args['db-host'] !== 'localhost')
			$connection_from = $assoc_args['db-host'];

		if($database){
			$connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD);
	        if($connection->connect_error){
	            throw new Exception("Error connecting to the DB as admin user: " . $connection->connect_error, 1);
			}
	        $connection->query("CREATE DATABASE IF NOT EXISTS $database");
	        if($connection->error)
	            throw new Exception("MySQL Error: " . $connection->error, 1);

			if($username){
		        if($connection_from){
		            $connection->query("GRANT ALL PRIVILEGES ON $database.* TO '$username'@'$connection_from' IDENTIFIED BY '$password' ");
		            if($connection->error)
		                throw new Exception("MySQL Error: " . $connection->error, 1);
		        }else{
		            $connection->query("GRANT ALL PRIVILEGES ON $database.* TO '$username'@'%' IDENTIFIED BY '$password' ");
		            if($connection->error)
		                throw new Exception("MySQL Error: " . $connection->error, 1);
		            $connection->query("GRANT ALL PRIVILEGES ON $database.* TO '$username'@'localhost' IDENTIFIED BY '$password' ");
		            if($connection->error)
		                throw new Exception("MySQL Error: " . $connection->error, 1);
		        }
			}

			$connection->close();
		}
	}

}
WP_CLI::add_command( 'cm create-local-config', 'CM_CLI_LocalConfig');
