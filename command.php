<?php

if ( ! class_exists( 'WP_CLI' ) ) {
	return;
}
require_once('lib/helpers.php');
require_once('lib/chunker.php');

global $chunker;
$chunker = new CM_CLI_Chunker;

require_once('lib/Post.php');
require_once('lib/Theme.php');
