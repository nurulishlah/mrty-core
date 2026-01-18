<?php
/**
 * Blocks Loader
 * Registers custom blocks for MRTY Core
 */

if (!defined('ABSPATH'))
    exit;

/**
 * Register MRTY Block Category
 */
function mrty_block_category($categories)
{
    return array_merge(
        $categories,
        [
            [
                'slug' => 'mrty',
                'title' => __('MRTY', 'mrty-core'),
                'icon' => 'admin-site-alt3',
            ],
        ]
    );
}
add_filter('block_categories_all', 'mrty_block_category', 10, 2);

/**
 * Load Individual Block Files
 */
require_once MRTY_CORE_PATH . 'inc/blocks/social-links.php';
require_once MRTY_CORE_PATH . 'inc/blocks/mosque-info.php';
require_once MRTY_CORE_PATH . 'inc/blocks/prayer-times.php';
