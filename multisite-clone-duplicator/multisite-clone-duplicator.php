<?php
/**
 * Plugin Name:         MultiSite Clone Duplicator
 * Plugin URI:          http://wordpress.org/plugins/multisite-clone-duplicator/
 * Description:         Clones an existing site into a new one in a multisite installation : copies all the posts, settings and files
 * Author:              Julien OGER, Pierre DARGHAM, GLOBALIS media systems
 * Author URI:          https://github.com/pierre-dargham/multisite-clone-duplicator
 *
 * Version:             1.4.0
 * Requires at least:   3.5.0
 * Tested up to:        4.1.2
 */

// Plugin options
require_once realpath( dirname( __FILE__ ) ) . '/include/option.php';

// Load language
require_once realpath( dirname( __FILE__ ) ) . '/include/lang.php';

// Load Functions
require_once realpath( dirname( __FILE__ ) ) . '/lib/functions.php';

// Load Plugin Core
require_once realpath( dirname( __FILE__ ) ) . '/lib/duplicate.php';
