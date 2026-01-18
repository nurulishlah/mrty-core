<?php
/**
 * MRTY Mosque Info Block
 * Server-side rendered block for mosque name and address
 */

if (!defined('ABSPATH'))
    exit;

/**
 * Register Block
 */
function mrty_register_mosque_info_block()
{
    register_block_type('mrty/mosque-info', [
        'render_callback' => 'mrty_render_mosque_info_block',
        'attributes' => [
            'layout' => [
                'type' => 'string',
                'default' => 'both'
            ],
            'textColor' => [
                'type' => 'string',
                'default' => ''
            ]
        ]
    ]);
}
add_action('init', 'mrty_register_mosque_info_block');

/**
 * Render Callback
 */
function mrty_render_mosque_info_block($attributes)
{
    $layout = isset($attributes['layout']) ? $attributes['layout'] : 'both';
    $name = mrty_get_opt('nama_masjid', 'Masjid At-Taqwa');
    $address = mrty_get_opt('alamat', '');

    $output = '<div class="wp-block-mrty-mosque-info">';

    if ($layout === 'name-only' || $layout === 'both') {
        $output .= '<p class="mosque-name"><strong>' . esc_html($name) . '</strong></p>';
    }

    if ($layout === 'address-only' || $layout === 'both') {
        if ($address) {
            $output .= '<p class="mosque-address">' . esc_html($address) . '</p>';
        } else {
            $output .= '<p class="mosque-address" style="color: #999; font-style: italic;">Configure address in<a href="' . admin_url('admin.php?page=mrty-settings') . '"> MRTY Settings</a></p>';
        }
    }

    $output .= '</div>';
    return $output;
}
