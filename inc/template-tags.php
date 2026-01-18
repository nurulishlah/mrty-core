<?php

/**
 * Retrieve theme option (New Settings API -> Legacy Theme Mod fallback)
 */
function mrty_get_opt($key, $default = '')
{
    // 1. Check New Settings API (mrty_options)
    $options = get_option('mrty_options');
    if (isset($options[$key]) && $options[$key] !== '') {
        return $options[$key];
    }

    // 2. Check Legacy Theme Mods (wp-masjid)
    $legacy_mods = get_option('theme_mods_wp-masjid');
    if (isset($legacy_mods[$key])) {
        return $legacy_mods[$key];
    }

    return $default;
}

/**
 * Output Address
 */
function mrty_address()
{
    $addr = mrty_get_opt('alamat', 'Jl Raya Lintas Liwa, Wonosari II, Simpang Sari, Sumber Jaya, Lampung Barat');
    echo esc_html($addr);
}

/**
 * Output Phone
 */
function mrty_phone()
{
    $phone = mrty_get_opt('masjid_telpon', '08123456789');
    echo '<a href="tel:' . esc_attr($phone) . '">' . esc_html($phone) . '</a>';
}

/**
 * Output Social Media Links
 */
function mrty_socials()
{
    $fb = mrty_get_opt('masjid_facebook');
    $ig = mrty_get_opt('masjid_instagram');
    $yt = mrty_get_opt('masjid_youtube');
    $tw = mrty_get_opt('masjid_twitter');

    if ($fb)
        echo '<li><a href="' . esc_url($fb) . '"><i class="wp-block-social-link-facebook">FB</i></a></li>'; // Simple placeholder icons for now if not using block
    // Note: The Footer template uses the core Social Links block, which we can't easily inject PHP into without a block filter.
    // However, for parts using shortcodes or PHP templates:

    // For now, let's just provide the data helper. The Block Theme uses manual links in the footer currently.
    // We can creating a shortcode [mrty_social_links] to render the list dynamically.
}

/**
 * Output City Prayer Widget Script (MuslimPro / Manual)
 */
function mrty_prayer_widget()
{
    $mode = mrty_get_opt('js_mode');

    if ($mode === 'muslimpro') {
        $city_id = mrty_get_opt('city_id', '1637532');
        echo '<script type="text/javascript" src="https://www.muslimpro.com/muslimprowidget.js?cityid=' . esc_attr($city_id) . '&language=id&timeformat=24" async></script>';
    } else {
        // Fallback for ID Sholat (Manual/API)
        echo '<div class="mrty-prayer-placeholder" style="text-align:center; padding: 20px; background: #f0f0f0;">';
        echo '<strong>jadwal Sholat (Manual Mode)</strong><br>';
        echo 'City ID: ' . esc_html(mrty_get_opt('idsholat_id', '8'));
        echo '</div>';
    }
}
