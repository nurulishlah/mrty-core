<?php
/**
 * MRTY Prayer Times Block
 * Server-side rendered block for prayer times widget
 */

if (!defined('ABSPATH'))
    exit;

/**
 * Register Block
 */
function mrty_register_prayer_times_block()
{
    register_block_type('mrty/prayer-times', [
        'render_callback' => 'mrty_render_prayer_times_block',
        'attributes' => []
    ]);
}
add_action('init', 'mrty_register_prayer_times_block');

/**
 * Render Callback
 */
function mrty_render_prayer_times_block($attributes)
{
    ob_start();
    mrty_prayer_widget();
    return ob_get_clean();
}
