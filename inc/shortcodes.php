<?php

// Original Shortcodes from Parent Theme
add_filter('widget_text', 'do_shortcode');
// tambahkan do_shortcode pada customizer , example do_shortcode(get_theme_mod()); 

function wpm_space_shortcode()
{
    $message = '<span class="spasi"></span>';
    return $message;
}
add_shortcode('spasi', 'wpm_space_shortcode');

function wpm_span_shortcode($atts = [], $message = null, $tag = '')
{
    $atts = array_change_key_case((array) $atts, CASE_LOWER);
    $span = '<span>';
    if (!is_null($message)) {
        $span .= apply_filters('widget_text', $message);
    }
    $span .= '</span>';
    return $span;
}
function wpm_span_shortcodes_init()
{
    add_shortcode('span', 'wpm_span_shortcode');
}
add_action('init', 'wpm_span_shortcodes_init');

function wpm_strong_shortcode($atts = [], $message = null, $tag = '')
{
    $atts = array_change_key_case((array) $atts, CASE_LOWER);
    $strong = '<strong>';
    if (!is_null($message)) {
        $strong .= apply_filters('widget_text', $message);
    }
    $strong .= '</strong>';
    return $strong;
}
function wpm_strong_shortcodes_init()
{
    add_shortcode('strong', 'wpm_strong_shortcode');
}
add_action('init', 'wpm_strong_shortcodes_init');

function wp_masjid_link_att($atts, $message = null)
{
    $default = array(
        'link' => '#',
    );
    $a = shortcode_atts($default, $atts);
    $message = do_shortcode($message);

    return '<a href="' . ($a['link']) . '">' . $message . '</a>';

}
add_shortcode('a', 'wp_masjid_link_att');

// NEW SHORTCODES for Block Theme
add_shortcode('mrty_prayer_widget', function () {
    ob_start();
    mrty_prayer_widget();
    return ob_get_clean();
});

add_shortcode('mrty_address', function () {
    ob_start();
    mrty_address();
    return ob_get_clean();
});

add_shortcode('mrty_phone', function () {
    ob_start();
    mrty_phone();
    return ob_get_clean();
});

add_shortcode('mrty_meta', function ($atts) {
    if (empty($atts['key']))
        return '';
    global $post;
    if (!$post)
        return '';
    return esc_html(get_post_meta($post->ID, $atts['key'], true));
});
