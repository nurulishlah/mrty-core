<?php

/**
 * Retrieve legacy theme mods from wp-masjid
 */
function mrty_get_legacy_opt($key, $default = '')
{
    $mods = get_option('theme_mods_wp-masjid');
    if (isset($mods[$key])) {
        return $mods[$key];
    }
    return $default;
}

/**
 * Output Address
 */
function mrty_address()
{
    $addr = mrty_get_legacy_opt('alamat', 'Jl Raya Lintas Liwa, Wonosari II, Simpang Sari, Sumber Jaya, Lampung Barat');
    echo esc_html($addr);
}

/**
 * Output Phone
 */
function mrty_phone()
{
    $phone = mrty_get_legacy_opt('masjid_telpon', '08123456789');
    echo '<a href="tel:' . esc_attr($phone) . '">' . esc_html($phone) . '</a>';
}

/**
 * Output City Prayer Widget Script (MuslimPro / Manual)
 */
function mrty_prayer_widget()
{
    $mode = mrty_get_legacy_opt('js_mode');

    if ($mode === 'muslimpro') {
        $city_id = mrty_get_legacy_opt('city_id', '1637532');
        echo '<script type="text/javascript" src="https://www.muslimpro.com/muslimprowidget.js?cityid=' . esc_attr($city_id) . '&language=id&timeformat=24" async></script>';
    } else {
        // Fallback for ID Sholat (Manual/API) - simplified for now
        echo '<div class="mrty-prayer-placeholder">Prayer Times Widget (Manual Mode)</div>';
    }
}
