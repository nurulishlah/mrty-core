<?php
/**
 * MRTY Settings Page
 * Using native WordPress Settings API
 */

if (!defined('ABSPATH'))
    exit;

/**
 * Register Menu Page
 */
function mrty_add_admin_menu()
{
    add_menu_page(
        __('MRTY Settings', 'mrty-core'),
        __('MRTY Settings', 'mrty-core'),
        'manage_options',
        'mrty-settings',
        'mrty_options_page_html',
        'dashicons-admin-generic',
        60
    );
}
add_action('admin_menu', 'mrty_add_admin_menu');

/**
 * Register Settings
 */
function mrty_settings_init()
{
    register_setting('mrty_options', 'mrty_options');

    // Section 1: Profil Masjid
    add_settings_section(
        'mrty_section_profile',
        __('Mosque Profile', 'mrty-core'),
        'mrty_section_profile_cb',
        'mrty-settings'
    );

    add_settings_field('nama_masjid', __('Mosque Name', 'mrty-core'), 'mrty_field_text_cb', 'mrty-settings', 'mrty_section_profile', ['label_for' => 'nama_masjid']);
    add_settings_field('luas_tanah', __('Land Area (m2)', 'mrty-core'), 'mrty_field_text_cb', 'mrty-settings', 'mrty_section_profile', ['label_for' => 'luas_tanah']);
    add_settings_field('luas_bang', __('Building Area (m2)', 'mrty-core'), 'mrty_field_text_cb', 'mrty-settings', 'mrty_section_profile', ['label_for' => 'luas_bang']);
    add_settings_field('tahun_masjid', __('Year Established', 'mrty-core'), 'mrty_field_text_cb', 'mrty-settings', 'mrty_section_profile', ['label_for' => 'tahun_masjid']);

    // Section 2: Contact & Address
    add_settings_section(
        'mrty_section_contact',
        __('Contact & Address', 'mrty-core'),
        'mrty_section_contact_cb',
        'mrty-settings'
    );

    add_settings_field('alamat', __('Address', 'mrty-core'), 'mrty_field_textarea_cb', 'mrty-settings', 'mrty_section_contact', ['label_for' => 'alamat']);
    add_settings_field('masjid_telpon', __('Phone', 'mrty-core'), 'mrty_field_text_cb', 'mrty-settings', 'mrty_section_contact', ['label_for' => 'masjid_telpon']);
    add_settings_field('masjid_whatsapp', __('WhatsApp', 'mrty-core'), 'mrty_field_text_cb', 'mrty-settings', 'mrty_section_contact', ['label_for' => 'masjid_whatsapp']);
    add_settings_field('masjid_email', __('Email', 'mrty-core'), 'mrty_field_text_cb', 'mrty-settings', 'mrty_section_contact', ['label_for' => 'masjid_email']);
    add_settings_field('masjid_maps', __('Maps Embed Code', 'mrty-core'), 'mrty_field_textarea_cb', 'mrty-settings', 'mrty_section_contact', ['label_for' => 'masjid_maps']);

    // Section 3: Social Media
    add_settings_section(
        'mrty_section_social',
        __('Social Media', 'mrty-core'),
        'mrty_section_social_cb',
        'mrty-settings'
    );

    add_settings_field('masjid_facebook', __('Facebook', 'mrty-core'), 'mrty_field_text_cb', 'mrty-settings', 'mrty_section_social', ['label_for' => 'masjid_facebook']);
    add_settings_field('masjid_instagram', __('Instagram', 'mrty-core'), 'mrty_field_text_cb', 'mrty-settings', 'mrty_section_social', ['label_for' => 'masjid_instagram']);
    add_settings_field('masjid_youtube', __('YouTube', 'mrty-core'), 'mrty_field_text_cb', 'mrty-settings', 'mrty_section_social', ['label_for' => 'masjid_youtube']);
    add_settings_field('masjid_twitter', __('Twitter', 'mrty-core'), 'mrty_field_text_cb', 'mrty-settings', 'mrty_section_social', ['label_for' => 'masjid_twitter']);

    // Section 4: Prayer Times
    add_settings_section(
        'mrty_section_prayer',
        __('Prayer Times', 'mrty-core'),
        'mrty_section_prayer_cb',
        'mrty-settings'
    );

    add_settings_field('js_mode', __('Calculation Mode', 'mrty-core'), 'mrty_field_select_mode_cb', 'mrty-settings', 'mrty_section_prayer', ['label_for' => 'js_mode']);
    add_settings_field('city_id', __('City ID (MuslimPro)', 'mrty-core'), 'mrty_field_text_cb', 'mrty-settings', 'mrty_section_prayer', ['label_for' => 'city_id']);
    add_settings_field('idsholat_id', __('City ID (IDSholat)', 'mrty-core'), 'mrty_field_text_cb', 'mrty-settings', 'mrty_section_prayer', ['label_for' => 'idsholat_id']);
}
add_action('admin_init', 'mrty_settings_init');

/**
 * Section Callbacks
 */
function mrty_section_profile_cb($args)
{
    echo '<p>' . __('Basic information about the mosque.', 'mrty-core') . '</p>';
}
function mrty_section_contact_cb($args)
{
    echo '<p>' . __('Contact details and location.', 'mrty-core') . '</p>';
}
function mrty_section_social_cb($args)
{
    echo '<p>' . __('Social media links.', 'mrty-core') . '</p>';
}
function mrty_section_prayer_cb($args)
{
    echo '<p>' . __('Settings for the prayer times widget.', 'mrty-core') . '</p>';
}

/**
 * Field Callbacks
 */
function mrty_field_text_cb($args)
{
    $options = get_option('mrty_options');
    $key = $args['label_for'];

    // Get value from new option, fallback to legacy if empty and new option doesn't exist yet
    $val = isset($options[$key]) ? $options[$key] : '';

    // If empty and not saved in new options yet, try legacy
    if ($val === '' && !isset($options[$key])) {
        $legacy_mods = get_option('theme_mods_wp-masjid');
        if (isset($legacy_mods[$key])) {
            $val = $legacy_mods[$key];
        }
    }

    echo '<input type="text" id="' . esc_attr($key) . '" name="mrty_options[' . esc_attr($key) . ']" value="' . esc_attr($val) . '" class="regular-text">';
}

function mrty_field_textarea_cb($args)
{
    $options = get_option('mrty_options');
    $key = $args['label_for'];
    $val = isset($options[$key]) ? $options[$key] : '';

    if ($val === '' && !isset($options[$key])) {
        $legacy_mods = get_option('theme_mods_wp-masjid');
        if (isset($legacy_mods[$key])) {
            $val = $legacy_mods[$key];
        }
    }

    echo '<textarea id="' . esc_attr($key) . '" name="mrty_options[' . esc_attr($key) . ']" rows="5" cols="50" class="large-text code">' . esc_textarea($val) . '</textarea>';
}

function mrty_field_select_mode_cb($args)
{
    $options = get_option('mrty_options');
    $key = $args['label_for']; // js_mode
    $val = isset($options[$key]) ? $options[$key] : '';

    if ($val === '' && !isset($options[$key])) {
        $legacy_mods = get_option('theme_mods_wp-masjid');
        if (isset($legacy_mods[$key])) {
            $val = $legacy_mods[$key];
        }
    }

    ?>
    <select id="<?php echo esc_attr($key); ?>" name="mrty_options[<?php echo esc_attr($key); ?>]">
        <option value="idsholat" <?php selected($val, 'idsholat'); ?>>ID Sholat (Manual/API)</option>
        <option value="muslimpro" <?php selected($val, 'muslimpro'); ?>>MuslimPro Widget</option>
    </select>
    <?php
}

/**
 * Top Level Page Callback
 */
function mrty_options_page_html()
{
    if (!current_user_can('manage_options')) {
        return;
    }
    ?>
    <div class="wrap">
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
        <form action="options.php" method="post">
            <?php
            settings_fields('mrty_options');
            do_settings_sections('mrty-settings');
            submit_button('Save Settings');
            ?>
        </form>
    </div>
    <?php
}
