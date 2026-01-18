<?php
/**
 * Plugin Name: MRTY Core
 * Description: Core functionality for MRTY website (CPTs, Taxonomies, Shortcodes).
 * Version: 1.0.0
 * Author: Muhamad Ishlah
 * Text Domain: mrty-core
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Define Plugin Path
define('MRTY_CORE_PATH', plugin_dir_path(__FILE__));

// Load Post Types
require_once MRTY_CORE_PATH . 'inc/post-types/load.php';

// Load Template Tags
require_once MRTY_CORE_PATH . 'inc/template-tags.php';

// Load Shortcodes
require_once MRTY_CORE_PATH . 'inc/shortcodes.php';
