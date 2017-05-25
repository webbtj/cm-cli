<?php

if ( ! class_exists( 'WP_CLI' ) ) {
	return;
}
require_once('lib/helpers.php');

require_once('lib/Theme.php');

WP_CLI::add_command( 'cm theme', 'CM_CLI_Theme' );
